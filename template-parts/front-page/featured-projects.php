<?php
/**
 * Featured Projects (dynamic, hardened)
 */

function interior_get_featured_project_id(): ?int {
  // Query explicit featured
  $q = new WP_Query([
    'post_type'           => 'project',
    'post_status'         => 'publish',
    'posts_per_page'      => 1,
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
    'meta_query'          => [[
      'key'     => 'project_is_featured',
      'value'   => '1',      // ACF true_false saves '1'
      'compare' => '=',
    ]],
  ]);

  if ($q->have_posts()) {
    $q->the_post();
    $id = get_the_ID();
    wp_reset_postdata();
    return $id;
  }

  // Fallback to the latest published project
  $q = new WP_Query([
    'post_type'           => 'project',
    'post_status'         => 'publish',
    'posts_per_page'      => 1,
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
    'orderby'             => 'date',
    'order'               => 'DESC',
  ]);

  if ($q->have_posts()) {
    $q->the_post();
    $id = get_the_ID();
    wp_reset_postdata();
    return $id;
  }

  return null;
}

$featured_id = interior_get_featured_project_id();
?>

<section id="portfolio" class="py-24 sm:py-32 bg-white">
    <div class="container">

        <div class="text-center mb-16 sm:mb-20">
            <span class="badge badge-muted mb-6">Our Finest Work</span>
            <h2 class="heading-xl text-gray-900 tracking-tight">
                Masterpieces in <span class="font-normal">Plaster</span>
            </h2>
            <p class="body-lg text-gray-600 max-w-3xl mx-auto mt-4">
                Explore a selection of recent projects across luxury residential and heritage restoration.
            </p>
        </div>

        <?php if ($featured_id): ?>
        <?php
        $subtitle  = function_exists('get_field') ? get_field('project_subtitle', $featured_id) : null;
        $permalink = get_permalink($featured_id);
      ?>

        <!-- Featured block -->
        <article class="mb-16 sm:mb-20 relative overflow-hidden rounded-xl">
            <a href="<?php echo esc_url($permalink); ?>" class="group block"
                aria-label="<?php echo esc_attr(get_the_title($featured_id)); ?>">

                <!-- The ratio box is the positioning context -->
                <div class="relative ratio-project-main w-full overflow-hidden bg-neutral-200 rounded-xl">
                    <?php
        if (has_post_thumbnail($featured_id)) {
          echo wp_get_attachment_image(
            get_post_thumbnail_id($featured_id),
            'full',
            false,
            [
              'class'   => 'absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
              'loading' => 'eager',
              'decoding'=> 'async',
              'sizes'   => '(min-width:1024px) 1200px, 100vw',
              'alt'     => esc_attr(get_the_title($featured_id)),
            ]
          );
        } else {
          echo '<div class="absolute inset-0 grid place-items-center body-sm text-neutral-500">No image</div>';
        }
      ?>
                    <!-- Overlay sits in the same box -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent pointer-events-none">
                    </div>
                </div>

                <!-- Text layer -->
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="badge badge-glass mb-3">Featured Project</span>
                    <h3 class="heading-lg text-white mb-1"><?php echo esc_html(get_the_title($featured_id)); ?></h3>
                    <?php if (!empty($subtitle)): ?>
                    <p class="body-base text-white/90"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                </div>
            </a>
        </article>

        <?php
        // Grid of next 3 (exclude featured)
        $grid_q = new WP_Query([
          'post_type'           => 'project',
          'post_status'         => 'publish',
          'posts_per_page'      => 3,
          'ignore_sticky_posts' => true,
          'no_found_rows'       => true,
          'orderby'             => 'date',
          'order'               => 'DESC',
          'post__not_in'        => [$featured_id],
        ]);
      ?>

        <?php if ($grid_q->have_posts()): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <?php while ($grid_q->have_posts()): $grid_q->the_post(); ?>
            <article
                class="group relative overflow-hidden rounded-md border border-black/5 bg-white shadow-sm transition hover:shadow-md">
                <a href="<?php the_permalink(); ?>" class="block">
                    <div class="aspect-[4/3] overflow-hidden bg-neutral-100">
                        <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('project-card', ['class' => 'w-full h-full object-cover transition-transform duration-300 group-hover:scale-110']);
                  } else {
                    echo '<div class="h-full w-full grid place-items-center body-sm text-neutral-500">No image</div>';
                  } ?>
                    </div>
                    <div class="p-5">
                        <h3 class="heading-md line-clamp-2 text-gray-900"><?php the_title(); ?></h3>
                        <?php if (has_excerpt()): ?>
                        <p class="body-base text-neutral-700 mt-2 line-clamp-3">
                            <?php echo esc_html(wp_strip_all_tags(get_the_excerpt())); ?></p>
                        <?php endif; ?>
                        <span class="button-text mt-4 inline-flex items-center gap-2 text-neutral-900">
                            View project <span aria-hidden="true">→</span>
                        </span>
                    </div>
                </a>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php else: ?>
        <p class="body-base text-neutral-600">More projects coming soon.</p>
        <?php endif; ?>

        <?php else: ?>
        <div class="rounded-xl border border-black/5 bg-white/70 backdrop-blur p-8 text-center">
            <p class="body-base text-neutral-700">
                No projects found yet. Add a project in <strong>Projects → Add New</strong>, set a Featured Image,
                and (optionally) toggle <em>Featured Project?</em>.
            </p>
        </div>
        <?php endif; ?>

        <div class="text-center mt-14">
            <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>"
                class="btn-primary btn-compact btn-anim inline-flex items-center gap-2">
                View Full Portfolio <span aria-hidden="true">→</span>
            </a>
        </div>

    </div>
</section>