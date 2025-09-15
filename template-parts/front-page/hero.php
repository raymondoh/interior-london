<?php
// Your PHP data fetching logic remains the same.
$slides_query = interior_get_slides(5);
$slides_data = [];
if ($slides_query->have_posts()) {
    while ($slides_query->have_posts()) {
        $slides_query->the_post();
        $slides_data[] = [
            'id'             => get_the_ID(),
            'title'          => get_the_title(),
            'subtitle'       => get_field('slide_subtitle'), // Re-enable your ACF field
            'primary_text'   => get_field('slide_cta_primary_text'),
            'primary_url'    => get_field('slide_cta_primary_url'),
            'secondary_text' => get_field('slide_cta_secondary_text'),
            'secondary_url'  => get_field('slide_cta_secondary_url'),
        ];
    }
}
wp_reset_postdata(); ?>

<?php if (!empty($slides_data)) : ?>
<!-- <section class="relative h-[90vh] lg:h-screen overflow-hidden" id="hero-slider-section"> -->
<section class="relative hero-h overflow-hidden" id="hero-slider-section" id="hero-slider-section">
    <!-- Slides (BG images) -->
    <div class="relative w-full h-full">
        <?php foreach ($slides_data as $index => $slide) :
      $image_url = get_the_post_thumbnail_url($slide['id'], 'full');
      $is_active = $index === 0 ? 'opacity-100' : 'opacity-0';
    ?>
        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 <?php echo $is_active; ?>"
            data-index="<?php echo esc_attr($index); ?>" data-title="<?php echo esc_attr($slide['title']); ?>"
            data-subtitle="<?php echo esc_attr($slide['subtitle']); ?>"
            data-primary-text="<?php echo esc_attr($slide['primary_text']); ?>"
            data-primary-url="<?php echo esc_url($slide['primary_url']); ?>"
            data-secondary-text="<?php echo esc_attr($slide['secondary_text']); ?>"
            data-secondary-url="<?php echo esc_url($slide['secondary_url']); ?>">
            <?php if ($image_url): ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($slide['title']); ?>"
                class="w-full h-full object-cover">
            <?php else: ?>
            <div class="w-full h-full bg-gray-200"></div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Prev/Next controls -->
    <?php if (count($slides_data) > 1): ?>
    <button id="hero-prev-slide" aria-label="Previous Slide"
        class="hidden sm:block z-20 absolute left-8 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm p-3 transition-all duration-300 group">
        <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24"
            fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button id="hero-next-slide" aria-label="Next Slide"
        class="hidden sm:block z-20 absolute right-8 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm p-3 transition-all duration-300 group">
        <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24"
            fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
    <?php endif; ?>

    <!-- Dots -->
    <?php if (count($slides_data) > 1): ?>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex space-x-3">
        <?php foreach ($slides_data as $index => $_): ?>
        <button
            class="hero-indicator w-3 h-3 transition-all duration-300 <?php echo ($index === 0) ? 'bg-white scale-125' : 'bg-white/50 hover:bg-white/75'; ?>"
            data-index="<?php echo esc_attr($index); ?>" aria-label="Go to slide <?php echo $index + 1; ?>"></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Static hero copy (center-left) -->
    <div class="absolute inset-0 z-10 flex items-center">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 w-full">
            <div class="max-w-3xl">

                <?php if ($badge_text = get_field('hero_badge_text')) : ?>
                <div
                    class="rounded-lg bg-black/80 text-white border-white/20 mb-8 backdrop-blur-sm font-light tracking-wide inline-block px-3 py-1 text-sm">
                    <?php echo esc_html($badge_text); ?>
                </div>
                <?php endif; ?>


                <?php if ($main_heading = get_field('hero_main_heading')) : ?>
                <h1
                    class="text-4xl sm:text-5xl lg:text-7xl font-light mb-6 text-balance leading-tight text-white tracking-tight">
                    <?php 
                        // nl2br() converts line breaks from the textarea into <br> tags
                        echo nl2br(esc_html($main_heading)); 
                    ?>
                </h1>
                <?php endif; ?>



                <?php if ($paragraph = get_field('hero_paragraph')) : ?>
                <p class="text-lg lg:text-xl text-white/90 mb-10 text-pretty leading-relaxed max-w-2xl font-light">
                    <?php echo esc_html($paragraph); ?>
                </p>
                <?php endif; ?>
                <!-- Bottom-left CTAs -->
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                    <a id="hero-cta-primary" href="<?php echo esc_url($slides_data[0]['primary_url']); ?>"
                        class="btn-light btn-anim inline-flex items-center justify-center">
                        <?php echo esc_html($slides_data[0]['primary_text']); ?>
                        <span class="ml-3 inline-block group-hover:translate-x-1 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                viewBox="0 0 24 24">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                        </span>
                    </a>

                    <a id="hero-cta-secondary" href="<?php echo esc_url($slides_data[0]['secondary_url']); ?>"
                        class="btn-glass btn-anim inline-flex items-center justify-center">
                        <?php echo esc_html($slides_data[0]['secondary_text']); ?>
                    </a>
                </div>


            </div>
        </div>
    </div>

    <!-- Bottom-right dynamic black box (JS updates these IDs) -->
    <div class="hidden lg:block absolute bottom-8 right-8 bg-black/80 backdrop-blur-sm p-6 max-w-sm">
        <h3 id="hero-title" class="text-white font-medium text-base mb-2">
            <?php echo esc_html($slides_data[0]['title']); ?>
        </h3>
        <p id="hero-subtitle" class="text-white/70 text-sm leading-snug">
            <?php echo esc_html($slides_data[0]['subtitle']); ?>
        </p>
    </div>
</section>

<?php endif; ?>