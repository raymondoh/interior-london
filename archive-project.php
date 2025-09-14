<?php
/**
 * Archive: Projects (/portfolio)
 * Reflects the Next.js Archive UI: hero, filters (category + year), view toggle, featured, grid/list.
 */

get_header();

/** -------------------------------------------------------------
 *  Inputs (GET): year=YYYY|all, view=grid|list
 *  Tax context: project_category term archives supported
 * --------------------------------------------------------------*/
$selected_year = isset($_GET['year']) ? sanitize_text_field($_GET['year']) : 'all';
$view_mode     = isset($_GET['view']) ? sanitize_text_field($_GET['view']) : 'grid';
$view_mode     = in_array($view_mode, ['grid','list'], true) ? $view_mode : 'grid';

$is_term       = is_tax('project_category');
$current_term  = $is_term ? get_queried_object() : null;

/** -------------------------------------------------------------
 *  Build filter links helpers (preserve query params)
 * --------------------------------------------------------------*/
function interior_build_url($base, $params = []) {
  $merged = array_merge($_GET, $params);
  $qs = array_filter($merged, function ($v) {
    return $v !== null && $v !== '';
  });
  $sep = (strpos($base, '?') === false) ? '?' : '&';
  return esc_url($base . ($qs ? $sep . http_build_query($qs) : ''));
}


/** -------------------------------------------------------------
 *  Collect category terms for chips
 * --------------------------------------------------------------*/
$terms = get_terms([
  'taxonomy'   => 'project_category',
  'hide_empty' => true,
]);

/** -------------------------------------------------------------
 *  Determine years (from ACF project_year across matching posts)
 *  NOTE: fine for small/medium catalogs. For large, replace with a cached query.
 * --------------------------------------------------------------*/
$year_query_args = [
  'post_type'      => 'project',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'fields'         => 'ids',
  'no_found_rows'  => true,
];

if ($is_term && $current_term) {
  $year_query_args['tax_query'] = [[
    'taxonomy' => 'project_category',
    'field'    => 'term_id',
    'terms'    => (int) $current_term->term_id,
  ]];
}
$all_ids = get_posts($year_query_args);
$years   = [];
if ($all_ids) {
  foreach ($all_ids as $pid) {
    $y = function_exists('get_field') ? (string) get_field('project_year', $pid) : '';
    if ($y !== '') { $years[$y] = true; }
  }
}
$years = array_keys($years);
rsort($years);

/** -------------------------------------------------------------
 *  Featured projects query (up to 2), respecting term + year filter
 * --------------------------------------------------------------*/
$featured_meta = [
  'key'     => 'project_is_featured',
  'value'   => '1',
  'compare' => '=',
];
$year_meta = null;
if ($selected_year !== 'all') {
  $year_meta = [
    'key'     => 'project_year',
    'value'   => $selected_year,
    'compare' => '=',
  ];
}

$meta_query = ['relation' => 'AND', $featured_meta];
if ($year_meta) $meta_query[] = $year_meta;

$featured_args = [
  'post_type'           => 'project',
  'post_status'         => 'publish',
  'posts_per_page'      => 2,
  'ignore_sticky_posts' => true,
  'no_found_rows'       => true,
  'meta_query'          => $meta_query,
];

if ($is_term && $current_term) {
  $featured_args['tax_query'] = [[
    'taxonomy' => 'project_category',
    'field'    => 'term_id',
    'terms'    => (int) $current_term->term_id,
  ]];
}

$featured_q   = new WP_Query($featured_args);
$featured_ids = $featured_q->have_posts() ? wp_list_pluck($featured_q->posts, 'ID') : [];
$GLOBALS['interior_featured_ids'] = $featured_ids;


/** -------------------------------------------------------------
 *  Main results query (exclude featured), paginated
 * --------------------------------------------------------------*/
$paged = max(1, (int) get_query_var('paged'));

$main_meta = [];
if ($selected_year !== 'all') {
  $main_meta[] = [
    'key'     => 'project_year',
    'value'   => $selected_year,
    'compare' => '=',
  ];
}
$main_args = [
  'post_type'           => 'project',
  'post_status'         => 'publish',
  'posts_per_page'      => 9,
  'paged'               => $paged,
  'ignore_sticky_posts' => true,
  'meta_query'          => $main_meta ?: null,
  'post__not_in'        => $featured_ids,
  'orderby'             => 'date',
  'order'               => 'DESC',
];

if ($is_term && $current_term) {
  $main_args['tax_query'] = [[
    'taxonomy' => 'project_category',
    'field'    => 'term_id',
    'terms'    => (int) $current_term->term_id,
  ]];
}

$main_q = new WP_Query($main_args);

// Count for “Showing X of Y”
$total_found = $main_q->found_posts + count($featured_ids);
$current_shown = count($featured_ids) + $main_q->post_count;

/** -------------------------------------------------------------
 *  Archive header content
 * --------------------------------------------------------------*/
$badge   = $is_term ? ($current_term->name) : 'Project Archive';
$heading = $is_term
  ? sprintf('Projects in <span class="font-normal">%s</span>', esc_html($current_term->name))
  : 'Project <span class="font-normal">Archive</span>';

$intro   = $is_term && ! empty($current_term->description)
  ? $current_term->description
  : 'A comprehensive collection of our finest plastering work spanning years of craftsmanship and innovation.';

?>
<main id="primary" class="site-main" role="main" aria-label="<?php esc_attr_e('Portfolio', 'interior'); ?>">

    <!-- Hero -->
    <section class="py-16 sm:py-24 bg-white">
        <div class="container text-center">
            <span
                class="button-text inline-block bg-gray-100 text-gray-800 border border-gray-200 rounded-full px-3 py-1.5 mb-6">
                <?php echo esc_html($badge); ?>
            </span>
            <h1 class="heading-xl text-gray-900 tracking-tight">
                <?php echo wp_kses($heading, ['span' => ['class' => []]]); ?>
            </h1>
            <p class="body-lg text-gray-600 mt-4 max-w-3xl mx-auto">
                <?php echo esc_html($intro); ?>
            </p>
        </div>
    </section>

    <!-- Filters + view toggle -->
    <section class="py-8 bg-gray-50">
        <div class="container">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <!-- Category chips -->
                <div class="flex flex-wrap gap-2">
                    <?php
            $all_url = interior_build_url( get_post_type_archive_link('project'), ['paged'=>null] );
            $all_active = !$is_term;
          ?>
                    <a href="<?php echo $all_url; ?>"
                        class="button-text inline-flex items-center rounded-full border px-4 py-2 transition <?php echo $all_active ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-900 border-black/10 hover:bg-gray-100'; ?>">
                        <?php esc_html_e('All Projects','interior'); ?>
                    </a>
                    <?php if ( ! is_wp_error($terms) && $terms ) :
            foreach ($terms as $term):
              $active = $is_term && (int)$current_term->term_id === (int)$term->term_id;
              $url = interior_build_url( get_term_link($term), ['paged'=>null] );
          ?>
                    <a href="<?php echo $url; ?>"
                        class="button-text inline-flex items-center rounded-full border px-4 py-2 transition <?php echo $active ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-900 border-black/10 hover:bg-gray-100'; ?>">
                        <?php echo esc_html($term->name); ?>
                    </a>
                    <?php endforeach; endif; ?>
                </div>

                <!-- Year select + View toggle -->
                <div class="flex items-center gap-4">
                    <form method="get" class="flex items-center gap-2">
                        <?php
              // Preserve existing non-year params (e.g., view), but not paged
              foreach ($_GET as $k => $v) {
                if ($k === 'year' || $k === 'paged') continue;
                echo '<input type="hidden" name="' . esc_attr($k) . '" value="' . esc_attr($v) . '">';
              }
            ?>
                        <select name="year" class="button-text border border-black/10 rounded-md px-3 py-2">
                            <option value="all"><?php esc_html_e('All Years','interior'); ?></option>
                            <?php foreach ($years as $y): ?>
                            <option value="<?php echo esc_attr($y); ?>" <?php selected($selected_year, $y); ?>>
                                <?php echo esc_html($y); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <button class="button-text rounded-full border border-black/10 px-4 py-2">
                            <?php esc_html_e('Apply','interior'); ?>
                        </button>
                    </form>

                    <div class="flex border border-black/10 rounded-md overflow-hidden">
                        <a href="<?php echo interior_build_url(get_post_type_archive_link('project'), ['view'=>'grid','paged'=>null]); ?>"
                            class="px-3 py-2 text-sm button-text <?php echo $view_mode==='grid' ? 'bg-gray-900 text-white' : 'bg-white text-gray-900 hover:bg-gray-50'; ?>">
                            Grid
                        </a>
                        <a href="<?php echo interior_build_url(get_post_type_archive_link('project'), ['view'=>'list','paged'=>null]); ?>"
                            class="px-3 py-2 text-sm button-text <?php echo $view_mode==='list' ? 'bg-gray-900 text-white' : 'bg-white text-gray-900 hover:bg-gray-50'; ?>">
                            List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Results count -->
            <div class="mt-6">
                <p class="caption">
                    <?php
            printf(
              /* translators: 1: current shown, 2: total found */
              esc_html__('Showing %1$d of %2$d projects', 'interior'),
              (int) $current_shown,
              (int) $total_found
            );
          ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Featured cards -->
    <?php if ( $featured_q->have_posts() ): ?>
    <section class="py-10 bg-white">
        <div class="container grid gap-8 md:grid-cols-2">
            <?php while ($featured_q->have_posts()): $featured_q->the_post();
    get_template_part('template-parts/project/card', null, [
      'id'       => get_the_ID(),
      'variant'  => 'grid',   // matches your Next.js featured look (still uses grid card)
      'featured' => true,
    ]);
  endwhile; wp_reset_postdata(); ?>
        </div>

    </section>
    <?php endif; ?>

    <!-- Main results: grid or list -->
    <section class="py-16 bg-white">
        <div class="container">
            <?php if ( $main_q->have_posts() ): ?>

            <?php if ( $view_mode === 'grid' ): ?>
            <div id="project-results" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($main_q->have_posts()): $main_q->the_post();
              get_template_part('template-parts/project/card', null, [
                'id'       => get_the_ID(),
                'variant'  => 'grid',
                'featured' => false,
              ]);
            endwhile; ?>
            </div>
            <?php else: ?>
            <div id="project-results" class="space-y-6">
                <?php while ($main_q->have_posts()): $main_q->the_post();
              get_template_part('template-parts/project/card', null, [
                'id'       => get_the_ID(),
                'variant'  => 'list',
                'featured' => false,
              ]);
            endwhile; ?>
            </div>
            <?php endif; ?>

            <!-- Load more button (AJAX appends into #project-results) -->
            <div class="mt-12 text-center">
                <?php if ( $main_q->max_num_pages > 1 ): ?>
                <button id="load-more-projects" class="button-text rounded-full border border-black/10 px-6 py-3">
                    <?php esc_html_e('Load More Projects','interior'); ?>
                </button>
                <?php endif; ?>
            </div>

            <?php else: ?>

            <!-- Empty state -->
            <div class="rounded-2xl border border-black/5 bg-white/70 backdrop-blur p-10 text-center">
                <p class="body-base text-neutral-700">
                    <?php esc_html_e('No projects found for this filter.', 'interior'); ?>
                </p>
            </div>

            <?php endif; wp_reset_postdata(); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>