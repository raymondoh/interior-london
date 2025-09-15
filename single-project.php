<?php
get_header();

$pid        = get_the_ID();
$title      = get_the_title();
$subtitle   = function_exists('get_field') ? get_field('project_subtitle', $pid) : '';
$client     = function_exists('get_field') ? get_field('project_client', $pid) : '';
$year       = function_exists('get_field') ? get_field('project_year', $pid) : '';
$location   = function_exists('get_field') ? get_field('project_location', $pid) : '';

// Build gallery: featured + attached images (unique)
$images = [];

// Prefer chosen images from the metabox
$chosen_csv = get_post_meta($pid, '_project_gallery_ids', true);
if (is_string($chosen_csv) && $chosen_csv !== '') {
  $images = array_filter(array_map('intval', explode(',', $chosen_csv)));
}

// Fallback: featured + attached images
if (empty($images)) {
  if (has_post_thumbnail($pid)) {
    $images[] = get_post_thumbnail_id($pid);
  }
  $attached = get_posts([
    'post_type'      => 'attachment',
    'posts_per_page' => -1,
    'post_status'    => 'inherit',
    'post_parent'    => $pid,
    'post_mime_type' => 'image',
    'orderby'        => 'menu_order ID',
    'order'          => 'ASC',
    'fields'         => 'ids',
  ]);
  foreach ($attached as $aid) {
    if (!in_array($aid, $images, true)) $images[] = $aid;
  }
}

?>
<main id="primary" class="site-main" role="main" aria-label="<?php esc_attr_e('Project', 'interior'); ?>">

    <!-- Breadcrumb -->
    <section class="py-6 bg-gray-50">
        <div class="container">
            <nav class="text-sm font-light text-gray-600">
                <a href="<?php echo esc_url(home_url('/')); ?>"
                    class="hover:text-gray-900"><?php esc_html_e('Home','interior'); ?></a>
                <span class="mx-2 text-gray-300">/</span>
                <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>"
                    class="hover:text-gray-900"><?php esc_html_e('Portfolio','interior'); ?></a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-900"><?php echo esc_html($title); ?></span>
            </nav>
        </div>
    </section>

    <!-- Hero -->
    <section class="py-16 bg-white">
        <div class="container">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <?php if ( function_exists('get_field') && (int) get_post_meta($pid, 'project_is_featured', true) === 1 ): ?>
                    <span
                        class="button-text inline-block bg-gray-100 text-gray-800 border border-gray-200 rounded-full px-3 py-1.5 mb-6">
                        <?php esc_html_e('Featured Project','interior'); ?>
                    </span>
                    <?php endif; ?>

                    <h1 class="heading-xl text-gray-900 tracking-tight">
                        <?php echo esc_html($title); ?>
                    </h1>

                    <?php if ($subtitle): ?>
                    <p class="body-lg text-gray-600 mt-6 max-w-2xl"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>

                    <!-- Meta grid -->
                    <div class="grid grid-cols-2 gap-6 mt-10">
                        <?php if ($location): ?>
                        <div>
                            <p class="text-sm font-light text-gray-500"><?php esc_html_e('Location','interior'); ?></p>
                            <p class="font-light text-gray-900"><?php echo esc_html($location); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if ($year): ?>
                        <div>
                            <p class="text-sm font-light text-gray-500"><?php esc_html_e('Completed','interior'); ?></p>
                            <p class="font-light text-gray-900"><?php echo esc_html($year); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if ($client): ?>
                        <div>
                            <p class="text-sm font-light text-gray-500"><?php esc_html_e('Client','interior'); ?></p>
                            <p class="font-light text-gray-900"><?php echo esc_html($client); ?></p>
                        </div>
                        <?php endif; ?>
                        <div>
                            <p class="text-sm font-light text-gray-500"><?php esc_html_e('Category','interior'); ?></p>
                            <p class="font-light text-gray-900">
                                <?php
                $cats = get_the_terms($pid, 'project_category');
                if ($cats && !is_wp_error($cats)) {
                  echo esc_html(implode(', ', wp_list_pluck($cats, 'name')));
                } else {
                  esc_html_e('—','interior');
                }
                ?>
                            </p>
                        </div>
                    </div>
                    <div class="mt-10">
                        <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>"
                            class="btn-primary btn-compact btn-anim inline-flex items-center gap-2">
                            ← <?php esc_html_e('Back to Portfolio','interior'); ?>
                        </a>
                    </div>

                </div>

                <!-- Gallery -->
                <!-- Gallery -->
                <div class="relative">
                    <?php if (!empty($images)): ?>
                    <div id="pjx-gallery" class="relative overflow-hidden ratio-project-main bg-neutral-100 rounded-md">
                        <?php foreach ($images as $index => $img_id): ?>
                        <?php
          $src = wp_get_attachment_image_url($img_id, 'x-large') ?: wp_get_attachment_image_url($img_id, 'large');
          $alt = get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $title;
        ?>
                        <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>"
                            data-index="<?php echo esc_attr($index); ?>"
                            class="pjx-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-300 <?php echo $index === 0 ? 'opacity-100' : 'opacity-0'; ?>"
                            loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>" decoding="async">
                        <?php endforeach; ?>

                        <!-- Controls -->
                        <button type="button"
                            class="pjx-prev absolute left-3 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white rounded p-2 shadow">
                            <span class="sr-only"><?php esc_html_e('Previous','interior'); ?></span> ←
                        </button>
                        <button type="button"
                            class="pjx-next absolute right-3 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white rounded p-2 shadow">
                            <span class="sr-only"><?php esc_html_e('Next','interior'); ?></span> →
                        </button>

                        <div
                            class="pjx-counter absolute bottom-3 right-3 bg-black/80 text-white px-2 py-1 text-sm font-light rounded">
                            1 / <?php echo count($images); ?>
                        </div>
                    </div>

                    <!-- Thumbs -->
                    <div class="grid grid-cols-4 gap-2 mt-3">
                        <?php foreach ($images as $index => $img_id): ?>
                        <?php $thumb = wp_get_attachment_image_url($img_id, 'thumbnail'); ?>
                        <button type="button"
                            class="pjx-thumb aspect-square overflow-hidden rounded <?php echo $index === 0 ? 'ring-2 ring-gray-900' : 'opacity-70 hover:opacity-100'; ?>"
                            data-index="<?php echo esc_attr($index); ?>">
                            <img src="<?php echo esc_url($thumb); ?>" alt="" class="w-full h-full object-cover">
                        </button>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="ratio-project-main bg-neutral-100 rounded-xl grid place-items-center text-neutral-500">
                        <?php esc_html_e('No images uploaded yet.','interior'); ?>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

    <!-- Overview (uses post content) -->
    <section class="py-24 bg-gray-50">
        <div class="container">
            <div class="text-center mb-12">
                <h2 class="heading-lg text-gray-900"><?php esc_html_e('Project Overview','interior'); ?></h2>
            </div>

            <?php
$overview = function_exists('get_field') ? get_field('project_overview', $pid) : '';
if ($overview) {
  echo '<div class="prose max-w-none body-lg text-gray-700">';
  echo wp_kses_post( wpautop($overview) );
  echo '</div>';
} else {
  // Fallback to main content if you want
  echo '<div class="prose max-w-none body-lg text-gray-700">';
  while ( have_posts() ) { the_post(); the_content(); }
  echo '</div>';
}
?>

        </div>
    </section>

    <!-- Testimonial (optional placeholder - easy to swap later) -->
    <section class="py-24 bg-white">
        <div class="container text-center">
            <div class="flex justify-center mb-6">
                <?php for ($i=0; $i<5; $i++) echo '<span class="mx-0.5 text-gray-800">★</span>'; ?>
            </div>
            <blockquote class="heading-md text-gray-900 max-w-3xl mx-auto">
                <?php
        // You can later replace this with an ACF text field (e.g., project_testimonial)
        echo esc_html__( '“The craftsmanship is extraordinary. Every wall is a work of art.”', 'interior' );
        ?>
            </blockquote>
            <p class="caption mt-4"><?php echo esc_html($client ?: __('Private Client','interior')); ?></p>
        </div>
    </section>

    <!-- Related Projects -->
    <?php
  $related_ids = [];
  $terms = wp_get_post_terms($pid, 'project_category', ['fields' => 'ids']);
  if (!is_wp_error($terms) && !empty($terms)) {
    $rel_q = new WP_Query([
      'post_type'           => 'project',
      'post_status'         => 'publish',
      'posts_per_page'      => 3,
      'ignore_sticky_posts' => true,
      'no_found_rows'       => true,
      'post__not_in'        => [$pid],
      'tax_query'           => [[
        'taxonomy' => 'project_category',
        'field'    => 'term_id',
        'terms'    => $terms,
      ]],
    ]);
  }
  ?>
    <?php if ( isset($rel_q) && $rel_q->have_posts() ): ?>
    <section class="py-24 bg-gray-50">
        <div class="container">
            <div class="text-center mb-12">
                <h2 class="heading-lg text-gray-900"><?php esc_html_e('Similar Projects','interior'); ?></h2>
                <p class="body-base text-gray-600 max-w-2xl mx-auto">
                    <?php esc_html_e('Explore more work featuring similar techniques or styles.','interior'); ?>
                </p>
            </div>

            <?php if ( $rel_q->have_posts() ): ?>
            <div class="relative">
                <!-- Slider -->
                <div class="swiper overflow-visible pb-14 swiper-stretch" id="similar-projects-swiper">
                    <div class="swiper-wrapper">
                        <?php while ($rel_q->have_posts()): $rel_q->the_post(); ?>
                        <div class="swiper-slide">
                            <article
                                class="card-equal bg-white overflow-hidden rounded-md border border-black/5 shadow-sm hover:shadow-md transition">
                                <a href="<?php the_permalink(); ?>" class="flex flex-col h-full">
                                    <div class="aspect-[4/3] overflow-hidden bg-neutral-100">
                                        <?php
              if ( has_post_thumbnail() ) {
                the_post_thumbnail('project-card', [
                  'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110'
                ]);
              } else {
                echo '<div class="h-full w-full grid place-items-center body-sm text-neutral-500">No image</div>';
              }
              ?>
                                    </div>

                                    <div class="card-equal-body">
                                        <h3 class="heading-md text-gray-900 mb-2 card-title-clamp"><?php the_title(); ?>
                                        </h3>
                                        <?php
                $sub = function_exists('get_field') ? get_field('project_subtitle') : '';
                if ($sub) {
                  echo '<p class="body-base text-neutral-700 mb-4 card-subtitle-clamp card-subtitle-minh">'. esc_html($sub) .'</p>';
                } else {
                  // keep heights consistent when no subtitle
                  echo '<p class="body-base text-neutral-700 mb-4 card-subtitle-clamp card-subtitle-minh">&nbsp;</p>';
                }
              ?>
                                        <span
                                            class="button-text mt-auto inline-flex items-center gap-2 text-neutral-900">
                                            <?php esc_html_e('View project','interior'); ?> →
                                        </span>
                                    </div>
                                </a>
                            </article>
                        </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>

                    <div class="swiper-pagination"></div>
                </div>



                <!-- No-JS fallback (hidden when JS is available) -->
                <noscript>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                        <?php
            // Re-run a tiny loop (or reuse $rel_q before resetting if you prefer)
            $fallback = new WP_Query($rel_q->query_vars);
            while ($fallback->have_posts()): $fallback->the_post(); ?>
                        <article
                            class="group bg-white overflow-hidden rounded-md border border-black/5 shadow-sm hover:shadow-md transition">
                            <a href="<?php the_permalink(); ?>" class="block">
                                <div class="aspect-[4/3] overflow-hidden bg-neutral-100">
                                    <?php if ( has_post_thumbnail() ) {
                      the_post_thumbnail('project-card', ['class'=>'w-full h-full object-cover']);
                    } else {
                      echo '<div class="h-full w-full grid place-items-center body-sm text-neutral-500">No image</div>';
                    } ?>
                                </div>
                                <div class="p-6">
                                    <h3 class="heading-md text-gray-900 mb-2"><?php the_title(); ?></h3>
                                </div>
                            </a>
                        </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </noscript>
            </div>
            <?php else: ?>
            <div class="rounded-2xl border border-black/5 bg-white/70 backdrop-blur p-10 text-center">
                <p class="body-base text-neutral-700"><?php esc_html_e('No similar projects found.','interior'); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php endif; ?>

    <?php get_template_part('template-parts/cta'); ?>
</main>

<?php get_footer(); ?>