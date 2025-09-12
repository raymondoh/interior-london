<?php
/**
 * Reusable Service Cards Component
 *
 * This component displays a grid of posts from the 'service' Custom Post Type.
 *
 * @package WP_Boilerplate
 */

$args = array(
    'post_type'      => 'service',
    'posts_per_page' => -1, // Get all service posts
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
);

$services_query = new WP_Query($args);

if ( $services_query->have_posts() ) : ?>

<section class="bg-base-100/10 py-20">
    <div class="container mx-auto px-4">

        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold">Our Services</h2>
            <p class="text-lg text-base-content/70 mt-2">Expertise in every detail.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            while ( $services_query->have_posts() ) : $services_query->the_post();
            ?>
            <div class="card bg-base-100 shadow-xl text-center p-8">
                <?php if ( has_post_thumbnail() ) : ?>
                <figure class="w-24 h-24 mx-auto mb-4">
                    <?php the_post_thumbnail('thumbnail', ['class' => 'rounded-full']); ?>
                </figure>
                <?php endif; ?>
                <h3 class="text-2xl font-bold mb-2"><?php the_title(); ?></h3>
                <div class="text-base-content/70">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php 
endif; 
wp_reset_postdata(); // Reset the global post object
?>