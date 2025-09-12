<?php
/**
 * Testimonial Block Template.
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
$id = 'testimonial-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'testimonial-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$quote = get_field('quote') ?: 'Your testimonial here...';
$author = get_field('author') ?: 'Author name';
$role = get_field('role') ?: 'Author role';
$image = get_field('image');
$background_color = get_field('background_color') ?: 'bg-gray-100';
$text_color = get_field('text_color') ?: 'text-gray-800';
?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($class_name); ?> <?php echo esc_attr($background_color); ?> rounded-lg shadow-md p-6 md:p-8">
    <div class="flex flex-col md:flex-row items-center">
        <?php if ($image) : ?>
            <div class="mb-4 md:mb-0 md:mr-6 flex-shrink-0">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="w-20 h-20 rounded-full object-cover">
            </div>
        <?php endif; ?>
        <div>
            <blockquote class="<?php echo esc_attr($text_color); ?> text-lg italic mb-4">
                <?php echo wp_kses_post($quote); ?>
            </blockquote>
            <div class="font-bold <?php echo esc_attr($text_color); ?>">
                <?php echo esc_html($author); ?>
            </div>
            <?php if ($role) : ?>
                <div class="text-sm <?php echo esc_attr($text_color); ?> opacity-75">
                    <?php echo esc_html($role); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
