<?php
/**
 * Reusable Testimonial Slider Component
 *
 * Displays posts from the 'testimonial' CPT in a Swiper.js slider.
 *
 * @package WP_Boilerplate
 */

$args = array(
    'post_type'      => 'testimonial',
    'posts_per_page' => -1,
);

$testimonials_query = new WP_Query($args);

if ( $testimonials_query->have_posts() ) : ?>

<section class="bg-base-100 py-20">
    <div class="container mx-auto px-4" x-data x-init="() => {
            // A separate, new Swiper instance just for this slider
            setTimeout(() => {
                new Swiper($el.querySelector('.testimonial-swiper'), {
                    loop: true,
                    slidesPerView: 1, // Show 1 slide at a time
                    spaceBetween: 30,
                    autoplay: {
                        delay: 5000, // Auto-play every 5 seconds
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            }, 10);
        }">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold">What Our Clients Say</h2>
            <p class="text-lg text-base-content/70 mt-2">Trusted by the best in the industry.</p>
        </div>

        <div class="testimonial-swiper swiper">
            <div class="swiper-wrapper">
                <?php
                while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post();
                    $author_role = get_field('author_role_company');
                ?>
                <div class="swiper-slide text-center max-w-3xl mx-auto">
                    <div class="text-2xl italic mb-4">
                        "<?php echo get_the_content(); ?>"
                    </div>
                    <div class="font-bold text-lg"><?php the_title(); ?></div>
                    <?php if ($author_role): ?>
                    <div class="text-base-content/70"><?php echo esc_html($author_role); ?></div>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="swiper-pagination mt-8"></div>
        </div>
    </div>
</section>

<?php 
endif; 
wp_reset_postdata(); // Reset the global post object
?>