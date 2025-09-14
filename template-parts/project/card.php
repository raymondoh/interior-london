<?php
/**
 * Project Card
 *
 * Args:
 * - id        (int)   Post ID (required)
 * - variant   (string) 'grid' | 'list' (default grid)
 * - featured  (bool)  highlight badge + styling (default false)
 */

$pid      = $args['id'] ?? get_the_ID();
$variant  = $args['variant'] ?? 'grid';
$featured = !empty($args['featured']);

$title    = get_the_title($pid);
$link     = get_permalink($pid);

$year     = function_exists('get_field') ? get_field('project_year', $pid) : '';
$loc      = function_exists('get_field') ? get_field('project_location', $pid) : '';
$sub      = function_exists('get_field') ? ( get_field('project_subtitle', $pid) ?: '' ) : '';
$desc     = has_excerpt($pid) ? wp_strip_all_tags(get_the_excerpt($pid)) : $sub;

// Category label (lowercase like your Next.js chips)
$cats = get_the_terms($pid, 'project_category');
$cat_label = '';
if ($cats && !is_wp_error($cats)) {
  $cat_label = strtolower($cats[0]->name);
}

$meta_line = trim( ($cat_label ? $cat_label : '') . ( ($cat_label && $year) ? ' • ' : '' ) . ($year ?: '') );

$thumb_size = ($variant === 'list') ? 'project-card' : 'project-card';
$has_thumb  = has_post_thumbnail($pid);

if ($variant === 'list'): ?>
<!-- LIST VARIANT -->
<article
    class="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-black/5">
    <a href="<?php echo esc_url($link); ?>" class="flex flex-col md:flex-row">
        <div class="relative w-full md:w-80 aspect-[4/3] md:aspect-square overflow-hidden">
            <?php
$img_id = interior_get_project_card_image_id($pid);
if ($img_id) {
  echo wp_get_attachment_image($img_id, 'project-card', false, [
    'class'   => 'object-cover w-full h-full group-hover:scale-110 transition-transform duration-500',
    'loading' => 'lazy',
  ]);
} else {
  echo '<div class="w-full h-full grid place-items-center body-sm text-neutral-500 bg-neutral-100">No image</div>';
}
?>

            <?php if ($featured): ?>
            <span
                class="absolute top-4 left-4 bg-gray-900 text-white px-2 py-1 text-xs font-light rounded">Featured</span>
            <?php endif; ?>
        </div>
        <div class="flex-1 p-6">
            <?php if ($meta_line): ?>
            <div class="text-xs text-neutral-500 font-light uppercase tracking-wide mb-2">
                <?php echo esc_html($meta_line); ?>
            </div>
            <?php endif; ?>
            <h3 class="text-2xl font-light text-gray-900 mb-2 group-hover:text-gray-700 transition-colors">
                <?php echo esc_html($title); ?></h3>
            <?php if ($loc): ?>
            <p class="text-sm text-neutral-500 mb-3 font-light"><?php echo esc_html($loc); ?></p>
            <?php endif; ?>
            <?php if ($desc): ?>
            <p class="text-sm text-gray-800 font-light leading-relaxed"><?php echo esc_html($desc); ?></p>
            <?php endif; ?>
        </div>
    </a>
</article>

<?php else: ?>
<!-- GRID VARIANT -->
<article
    class="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-black/5">
    <a href="<?php echo esc_url($link); ?>" class="block">
        <div class="relative aspect-[4/3] overflow-hidden">
            <?php
$img_id = interior_get_project_card_image_id($pid);
if ($img_id) {
  echo wp_get_attachment_image($img_id, 'project-card', false, [
    'class'   => 'object-cover w-full h-full group-hover:scale-110 transition-transform duration-500',
    'loading' => 'lazy',
  ]);
} else {
  echo '<div class="w-full h-full grid place-items-center body-sm text-neutral-500 bg-neutral-100">No image</div>';
}
?>

            <?php if ($featured): ?>
            <span
                class="absolute top-4 left-4 bg-gray-900 text-white px-2 py-1 text-xs font-light rounded">Featured</span>
            <?php endif; ?>
        </div>
        <div class="p-6">
            <?php if ($meta_line): ?>
            <div class="text-xs text-neutral-500 font-light uppercase tracking-wide mb-2">
                <?php echo esc_html($meta_line); ?>
            </div>
            <?php endif; ?>
            <h3 class="text-xl font-light text-gray-900 mb-2 group-hover:text-gray-700 transition-colors">
                <?php echo esc_html($title); ?></h3>
            <?php if ($loc): ?>
            <p class="text-sm text-neutral-500 mb-2 font-light"><?php echo esc_html($loc); ?></p>
            <?php endif; ?>
            <?php if ($desc): ?>
            <p class="text-sm text-gray-800 font-light line-clamp-2"><?php echo esc_html($desc); ?></p>
            <?php endif; ?>
        </div>
    </a>
</article>
<?php endif; ?>