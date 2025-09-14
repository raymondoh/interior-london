<?php
/**
 * Stats section (modular + filterable)
 *
 * Override the items via:
 * add_filter('interior/stats_items', function ($items) {
 *   return [
 *     ['value' => '40+', 'label' => 'Years Experience'],
 *     ['value' => '650+', 'label' => 'Projects Completed'],
 *     ['value' => '100%', 'label' => 'Satisfaction Rate'],
 *     ['value' => '24/7', 'label' => 'Support Available'],
 *   ];
 * });
 */

// Default items (mirrors your Next.js example)
$stats_items = [
  ['value' => '35+',  'label' => 'Years Experience'],
  ['value' => '500+', 'label' => 'Projects Completed'],
  ['value' => '100%', 'label' => 'Satisfaction Rate'],
  ['value' => '24/7', 'label' => 'Support Available'],
];

// Allow overrides via filter
$stats_items = apply_filters('interior/stats_items', $stats_items);
?>

<section class="py-24 sm:py-32 bg-white">
    <div class="container">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 sm:gap-16 text-center">
            <?php foreach ($stats_items as $item): ?>
            <div class="flex flex-col items-center">
                <!-- Icon tile (neutral box, subtle hover) -->
                <div class="bg-gray-50 p-6 mb-6 transition-all duration-300 hover:bg-gray-100 rounded-lg">
                    <!-- Simple inline SVG placeholder icon; swap per item if desired -->
                    <svg class="w-8 h-8 text-gray-800" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 7h16M4 12h16M4 17h10" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" />
                    </svg>
                </div>

                <h3 class="text-3xl font-light text-gray-900 mb-2">
                    <?= esc_html($item['value']); ?>
                </h3>
                <p class="text-gray-600 font-light tracking-wide">
                    <?= esc_html($item['label']); ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>