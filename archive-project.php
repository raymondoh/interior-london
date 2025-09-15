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
 *  Featured projects query (up to 2), respecting term + year filter
 * --------------------------------------------------------------*/
$featured_meta = [
  'key'     => 'project_is_featured',
  'value'   => '1',
  'compare' => '=',
];


$meta_query = ['relation' => 'AND', $featured_meta];


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

// $main_meta = [];
// if ($selected_year !== 'all') {
//   $main_meta[] = [
//     'key'     => 'project_year',
//     'value'   => $selected_year,
//     'compare' => '=',
//   ];
// }
$main_args = [
  'post_type'           => 'project',
  'post_status'         => 'publish',
  'posts_per_page'      => 9,
  'paged'               => $paged,
  'ignore_sticky_posts' => true,
  'meta_query'          =>  null,
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
if ( $is_term && $current_term ) {
  // Term archive
  $badge   = $current_term->name; // e.g., "Residential"
  $heading = sprintf(
    'Projects in <span class="font-normal">%s</span>',
    esc_html( $current_term->name )
  );
  $intro   = ! empty( $current_term->description )
    ? $current_term->description
    : 'Explore curated projects from this category.';
} else {
  // Main portfolio archive
  $badge   = 'Our Portfolio';
  $heading = 'Projects';
  $intro   = 'A comprehensive collection of our finest plastering work spanning years of craftsmanship and innovation.';
}
?>

<main id="primary" class="site-main" role="main" aria-label="<?php esc_attr_e('Portfolio', 'interior'); ?>">

    <!-- Archive Hero -->
    <section class="section py-12 md:py-16 bg-white">
        <div class="container text-center">
            <span class="badge badge-muted mb-6">
                <?php echo esc_html( $badge ); ?>
            </span>

            <h1 class="heading-xl text-gray-900 tracking-tight">
                <?php echo wp_kses( $heading, ['span' => ['class' => []]] ); ?>
            </h1>

            <?php if ( ! empty( $intro ) ) : ?>
            <p class="body-lg text-gray-600 mt-4 max-w-3xl mx-auto">
                <?php echo esc_html( $intro ); ?>
            </p>
            <?php endif; ?>
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
                        class="btn-secondary btn-compact <?php echo $all_active ? 'bg-gray-900 text-white' : ''; ?>">
                        <?php esc_html_e('All Projects','interior'); ?>
                    </a>

                    <?php if ( ! is_wp_error($terms) && $terms ) :
    foreach ($terms as $term):
      $active = $is_term && (int)$current_term->term_id === (int)$term->term_id;
      $url = interior_build_url( get_term_link($term), ['paged'=>null] );
  ?>
                    <a href="<?php echo $url; ?>"
                        class="btn-secondary btn-compact <?php echo $active ? 'bg-gray-900 text-white' : ''; ?>">
                        <?php echo esc_html($term->name); ?>
                    </a>
                    <?php endforeach; endif; ?>
                </div>


                <!-- View toggle -->
                <div class="flex items-center gap-4">
                    <!-- View toggle -->
                    <div class="flex border border-black/10 rounded-md overflow-hidden">
                        <a href="<?php echo interior_build_url(get_post_type_archive_link('project'), ['view'=>'grid','paged'=>null]); ?>"
                            class="button-text px-3 py-2 text-sm <?php echo $view_mode==='grid' ? 'bg-gray-900 text-white' : 'bg-white text-gray-900 hover:bg-gray-50'; ?>">
                            Grid
                        </a>
                        <a href="<?php echo interior_build_url(get_post_type_archive_link('project'), ['view'=>'list','paged'=>null]); ?>"
                            class="button-text px-3 py-2 text-sm <?php echo $view_mode==='list' ? 'bg-gray-900 text-white' : 'bg-white text-gray-900 hover:bg-gray-50'; ?>">
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
    <section class="py-10 bg-gray-50">
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
    <section class="py-16 bg-gray-50">
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
                <button id="load-more-projects"
                    class="btn-anim rounded-md border border-black/10 font-light px-6 py-3 hover:bg-gray-100 transition">
                    <?php esc_html_e('Load More Projects','interior'); ?>
                </button>

                <?php endif; ?>
            </div>

            <?php else: ?>

            <?php
  // Build a smart "back" target
  if ( $is_term && $current_term ) {
    // On a category page: go back to the term base (clears year), preserving view
    $back_url   = interior_build_url( get_term_link( $current_term ), [
      
      'view' => $view_mode,
    ]);
    $back_label = sprintf(
      /* translators: %s is the term name */
      esc_html__( 'Back to %s Projects', 'interior' ),
      esc_html( $current_term->name )
    );
  } else {
    // On the main archive: go back to all projects (clears year), preserving view
    $back_url   = interior_build_url( get_post_type_archive_link('project'), [
      
      'view' => $view_mode,
    ]);
    $back_label = esc_html__( 'Back to All Projects', 'interior' );
  }
?>

            <!-- Empty state -->
            <div class="rounded-2xl border border-black/5 bg-white/70 backdrop-blur p-10 text-center">
                <p class="body-base text-neutral-700 mb-6">
                    <?php esc_html_e('No projects found for this filter.', 'interior'); ?>
                </p>
                <a href="<?php echo esc_url( $back_url ); ?>" class="btn btn-primary btn-anim">
                    <?php echo $back_label; ?>
                </a>
            </div>

            <?php endif; wp_reset_postdata(); ?>

        </div>
    </section>
    <?php get_template_part( 'template-parts/components/cta' ); ?>

</main>

<?php get_footer(); ?>