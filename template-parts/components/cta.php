<?php
/**
 * Global CTA with per-page override.
 */
$cta = interior_get_cta(get_queried_object_id());
?>

<section class="py-24 sm:py-32 bg-white">
    <div class="container text-center">
        <h2 class="heading-xl text-gray-900 tracking-tight">
            <?php echo esc_html($cta['heading']); ?>
        </h2>

        <?php if (!empty($cta['body'])): ?>
        <p class="body-lg text-gray-600 mt-6 max-w-3xl mx-auto">
            <?php echo esc_html($cta['body']); ?>
        </p>
        <?php endif; ?>

        <div class="mt-12 flex flex-col sm:flex-row gap-6 justify-center">
            <?php if (!empty($cta['primary_text']) && !empty($cta['primary_url'])): ?>
            <a href="<?php echo esc_url($cta['primary_url']); ?>"
                class="button-text inline-flex items-center justify-center rounded-full bg-gray-900 text-white px-8 py-3 hover:bg-gray-800 transition">
                <?php echo esc_html($cta['primary_text']); ?>
            </a>
            <?php endif; ?>

            <?php if (!empty($cta['secondary_text']) && !empty($cta['secondary_url'])): ?>
            <a href="<?php echo esc_url($cta['secondary_url']); ?>"
                class="button-text inline-flex items-center justify-center rounded-full border border-gray-900 text-gray-900 px-8 py-3 hover:bg-gray-900 hover:text-white transition">
                <?php echo esc_html($cta['secondary_text']); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>