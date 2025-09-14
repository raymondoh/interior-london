<?php
/**
 * Heritage & Tradition section (modular + filterable)
 *
 * Customize via filters:
 * - interior/heritage_badge_text (string)
 * - interior/heritage_heading (string, allows simple <span> tags)
 * - interior/heritage_intro (string)
 * - interior/heritage_items (array of [title, desc, numeral])
 */

// Defaults (mirroring your Next.js content)
$badge_text = apply_filters('interior/heritage_badge_text', 'Heritage & Tradition');

$heading = apply_filters(
  'interior/heritage_heading',
  'Rooted in <span class="font-normal">Classical Tradition</span>'
);

$intro = apply_filters(
  'interior/heritage_intro',
  'Our craft traces back to the master plasterers of ancient Rome and Renaissance Italy. We honor these time-tested techniques while bringing modern precision and innovation to every project.'
);

$items = apply_filters('interior/heritage_items', [
  [
    'numeral' => 'I',
    'title'   => 'Traditional Methods',
    'desc'    => 'Hand-mixed lime mortars and time-honored application techniques',
  ],
  [
    'numeral' => 'II',
    'title'   => 'Master Craftsmen',
    'desc'    => 'Artisans trained in European workshops and heritage restoration',
  ],
  [
    'numeral' => 'III',
    'title'   => 'Timeless Beauty',
    'desc'    => 'Finishes that age gracefully and stand the test of centuries',
  ],
]);
?>

<section class="py-24 sm:py-32 bg-gray-50 relative overflow-hidden">
    <div class="container relative z-10 text-center">
        <span
            class="button-text inline-block bg-gray-800 text-white border border-gray-700 rounded-full px-3 py-1.5 mb-8">
            <?php echo esc_html($badge_text); ?>
        </span>

        <h2 class="heading-xl text-gray-900 tracking-tight">
            <?php // Allow a safe <span> for the emphasized word
      echo wp_kses($heading, ['span' => ['class' => []]]); ?>
        </h2>

        <p class="body-lg text-gray-600 mt-6 max-w-3xl mx-auto">
            <?php echo esc_html($intro); ?>
        </p>

        <div class="grid md:grid-cols-3 gap-12 sm:gap-16 mt-16">
            <?php foreach ($items as $item): ?>
            <div class="text-center">
                <div
                    class="bg-gray-100 w-20 h-20 mx-auto mb-6 flex items-center justify-center transition-all duration-300 hover:bg-gray-200 rounded-lg">
                    <span class="text-2xl font-light text-gray-800">
                        <?php echo esc_html($item['numeral']); ?>
                    </span>
                </div>
                <h3 class="text-xl font-light text-gray-900 mb-3">
                    <?php echo esc_html($item['title']); ?>
                </h3>
                <p class="body-base text-gray-600 leading-relaxed">
                    <?php echo esc_html($item['desc']); ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- subtle backdrop “grain” block for depth (optional, purely decorative) -->
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
        <div class="absolute -top-1/3 right-0 h-[40rem] w-[40rem] bg-white/40 blur-3xl rounded-full"></div>
    </div>
</section>