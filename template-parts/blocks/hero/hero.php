<?php
/**
 * Hero Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'hero-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'hero-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$heading = get_field('heading') ?: 'Your Heading Here';
$subheading = get_field('subheading') ?: 'Your subheading here';
$background_image = get_field('background_image');
$cta_text = get_field('cta_text') ?: 'Learn More';
$cta_url = get_field('cta_url') ?: '#';
$text_color = get_field('text_color') ?: 'text-white';
$overlay_opacity = get_field('overlay_opacity') ?: '50';

// Background image style
$bg_style = '';
if ($background_image) {
    $bg_style = ' style="background-image: url(' . esc_url($background_image['url']) . ');"';
}
?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($class_name); ?> bg-cover bg-center relative"<?php echo $bg_style; ?>>
    <div class="absolute inset-0 bg-black opacity-<?php echo esc_attr($overlay_opacity); ?>"></div>
    <div class="container mx-auto px-4 py-24 md:py-32 lg:py-48 relative z-10">
        <div class="max-w-3xl">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 <?php echo esc_attr($text_color); ?>">
                <?php echo esc_html($heading); ?>
            </h2>
            <div class="text-xl md:text-2xl mb-8 <?php echo esc_attr($text_color); ?>">
                <?php echo wp_kses_post($subheading); ?>
            </div>
            <?php if ($cta_text) : ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-primary">
                    <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
