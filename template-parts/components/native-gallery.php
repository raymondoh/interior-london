<?php
/**
 * Native WordPress Gallery with Lightbox (Robust Version)
 *
 * This version directly gets the post object to ensure it finds the content.
 *
 * @package WordPress
 * @subpackage your-theme-name
 */

// Get the full post object for the current page.
global $post;

// Check if the post object exists and has content.
if ( isset($post->post_content) && has_block('core/gallery', $post->post_content) ) {

    // Parse the blocks directly from the post's content.
    $blocks = parse_blocks( $post->post_content );
    $gallery_images = [];

    // Find the first gallery block and extract its image IDs.
    foreach ($blocks as $block) {
        if ('core/gallery' === $block['blockName'] && !empty($block['innerBlocks'])) {
            foreach ($block['innerBlocks'] as $image_block) {
                if (isset($image_block['attrs']['id'])) {
                    $gallery_images[] = $image_block['attrs']['id'];
                }
            }
            break; // Stop after finding the first gallery.
        }
    }

    if (!empty($gallery_images)) : ?>

<div x-data="{
        isOpen: false,
        images: [],
        currentIndex: 0
    }" x-init="() => {
        // First, get the image URLs for the lightbox.
        let imageElements = $el.querySelectorAll('.swiper-slide img');
        imageElements.forEach(img => images.push(img.dataset.largeUrl));

        // Then, wait for the next moment for Swiper to be ready.
        // This setTimeout solves the 'Swiper is not defined' error.
        setTimeout(() => {
            new Swiper($el.querySelector('.swiper'), {
                loop: true,
                slidesPerView: 3,
                spaceBetween: 30,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        }, 10); // A tiny 10ms delay is all we need.
    }" class="relative w-full max-w-5xl mx-auto my-12">

    <div class="swiper">
        <div class="swiper-wrapper">
            <?php
                // Loop through the image IDs we found.
                foreach ($gallery_images as $index => $image_id) :
                    $full_image_url = wp_get_attachment_image_url($image_id, 'full');
                    $thumbnail_url = wp_get_attachment_image_url($image_id, 'large');
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                ?>
            <div class="swiper-slide">
                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($image_alt); ?>"
                    data-large-url="<?php echo esc_url($full_image_url); ?>"
                    class="cursor-pointer w-full h-full object-cover"
                    @click="isOpen = true; currentIndex = <?php echo $index; ?>">
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div x-show="isOpen" @keydown.escape.window="isOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-95" style="display: none;">
        <button @click="isOpen = false" class="absolute top-4 right-4 text-white text-3xl z-50">&times;</button>
        <div class="relative w-full h-full p-8 flex items-center justify-center">
            <button @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1"
                class="absolute left-4 text-white text-4xl p-4">&#8249;</button>
            <img :src="images[currentIndex]" class="max-w-full max-h-full object-contain">
            <button @click="currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0"
                class="absolute right-4 text-white text-4xl p-4">&#8250;</button>
        </div>
    </div>
</div>
<?php
    endif;
}
?>