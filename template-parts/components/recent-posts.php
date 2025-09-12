<?php
/**
 * Reusable Recent Posts Component
 *
 * Displays the latest 3 blog posts in a card grid.
 *
 * @package WP_Boilerplate
 */

// Arguments for our query to get the latest 3 posts.
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'ignore_sticky_posts' => 1, // This ensures "sticky posts" don't get stuck at the top.
);

$recent_posts_query = new WP_Query($args);

// Check if the query returned any posts.
if ( $recent_posts_query->have_posts() ) : ?>

<section class="bg-base-100 py-20">
    <div class="container mx-auto px-4">

        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold">From Our Blog</h2>
            <p class="text-lg text-base-content/70 mt-2">News, articles, and insights from our team.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            // Start the loop to display each post.
            while ( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post();
            ?>

            <div class="card bg-base-100 shadow-xl overflow-hidden group">
                <?php if ( has_post_thumbnail() ) : ?>
                <figure class="aspect-video">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </a>
                </figure>
                <?php endif; ?>
                <div class="card-body">
                    <h3 class="card-title text-xl font-bold">
                        <a href="<?php the_permalink(); ?>" class="link link-hover"><?php the_title(); ?></a>
                    </h3>
                    <p class="text-base-content/70 mt-2">
                        <?php echo get_the_excerpt(); // Display a short excerpt. ?>
                    </p>
                    <div class="card-actions justify-end mt-4">
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>

            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php 
endif; 

// Reset the post data to avoid conflicts with other queries on the page.
wp_reset_postdata(); 
?>