<?php
/**
 * Template Name: Services
 * Template: Services (Index)
 * Slug your page as /services/ to use this file automatically.
 * Dynamic via ACF (optional) with graceful fallbacks.
 *
 * Recommended ACF fields on this Page:
 * - services_hero_badge (Text)
 * - services_hero_title (Text)
 * - services_hero_intro (Textarea)
 *
 * - services_list (Repeater)
 *    - image (Image)
 *    - title (Text)
 *    - intro (Textarea)
 *    - bullets (Repeater) -> item (Text)
 *    - link_url (URL)
 *    - link_label (Text)
 *
 * - process_badge (Text)
 * - process_title (Text)
 * - process_intro (Textarea)
 * - process_steps (Repeater)
 *    - step_no (Text) e.g. "01"
 *    - title (Text)
 *    - text (Textarea)
 *
 * - pricing_badge (Text)
 * - pricing_title (Text)
 * - pricing_intro (Textarea)
 * - pricing_tiers (Repeater)
 *    - title (Text)
 *    - blurb (Textarea)
 *    - price (Text) e.g. "£85"
 *    - unit (Text) e.g. "/sq meter"
 *    - bullets (Repeater) -> item (Text)
 *    - style (Select: "dark"|"light") // optional
 *    - cta_label (Text)
 *    - cta_url (URL)
 */

get_header();
the_post();

// ---------- Hero fields ----------
$hero_badge = get_field('services_hero_badge') ?: __('Our Services', 'interior');
$hero_title = get_field('services_hero_title') ?: __('Masterful<br><span class="font-normal">Craftsmanship</span>', 'interior');
$hero_intro = get_field('services_hero_intro') ?: __('From heritage restoration to contemporary finishes, our master craftsmen deliver exceptional results that transform spaces and stand the test of time.', 'interior');

// ---------- Services list ----------
$services = get_field('services_list');

// ---------- Process fields ----------
$process_badge = get_field('process_badge') ?: __('Our Process', 'interior');
$process_title = get_field('process_title') ?: __('Precision in Every <span class="font-normal">Step</span>', 'interior');
$process_intro = get_field('process_intro') ?: __('Our meticulous approach ensures exceptional results from initial consultation to final inspection.', 'interior');
$process_steps = get_field('process_steps');

// ---------- Pricing fields ----------
$pricing_badge = get_field('pricing_badge') ?: __('Investment', 'interior');
$pricing_title = get_field('pricing_title') ?: __('Transparent <span class="font-normal">Pricing</span>', 'interior');
$pricing_intro = get_field('pricing_intro') ?: __('Quality craftsmanship is an investment in your property\'s value and your daily enjoyment of the space.', 'interior');
$pricing_tiers = get_field('pricing_tiers');
?>

<main id="primary" class="min-h-screen bg-white">

    <!-- Hero Section -->
    <section class="section-hero bg-white">
        <div class="container">
            <div class="max-w-4xl mx-auto text-center">
                <span
                    class="badge badge-muted mb-8 font-light tracking-wide"><?php echo wp_kses_post($hero_badge); ?></span>
                <h1 class="heading-hero mb-8 leading-tight tracking-tight text-gray-900">
                    <?php echo wp_kses_post($hero_title); ?>
                </h1>
                <p class="body-lg text-gray-600 mb-16 max-w-3xl mx-auto">
                    <?php echo esc_html($hero_intro); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="section bg-white">
        <div class="container">
            <?php if ($services && is_array($services)) : ?>
            <div class="grid lg:grid-cols-3 gap-12">
                <?php foreach ($services as $svc) :
            $img_id   = $svc['image'] ?? 0;
            $title    = $svc['title'] ?? '';
            $intro    = $svc['intro'] ?? '';
            $bullets  = $svc['bullets'] ?? [];
            $link_url = $svc['link_url'] ?? '';
            $link_lbl = $svc['link_label'] ?? __('Learn More', 'interior');
          ?>
                <article class="group">
                    <div class="relative overflow-hidden mb-8">
                        <div class="w-full h-80 bg-neutral-100 overflow-hidden">
                            <?php
                    if ($img_id) {
                      echo wp_get_attachment_image($img_id, 'x-large', false, ['class' => 'w-full  h-80 object-cover transition-transform duration-700 group-hover:scale-105']);
                    } else {
                      // fallback blank
                      echo '<div class="w-full h-80 bg-gray-100"></div>';
                    }
                  ?>
                        </div>
                        <div
                            class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors duration-300">
                        </div>
                        <!-- Optional icon chip (can replace with custom SVG if desired) -->
                        <div class="absolute top-6 left-6">
                            <div class="bg-white/10 backdrop-blur-sm p-3 border border-white/20">
                                <span class="text-white">★</span>
                            </div>
                        </div>
                    </div>

                    <?php if ($title): ?>
                    <h3 class="heading-md text-gray-900 mb-4 tracking-wide"><?php echo esc_html($title); ?></h3>
                    <?php endif; ?>

                    <?php if ($intro): ?>
                    <p class="body-base text-gray-600 leading-relaxed mb-6"><?php echo esc_html($intro); ?></p>
                    <?php endif; ?>

                    <?php if ($bullets && is_array($bullets)): ?>
                    <ul class="space-y-3 mb-8">
                        <?php foreach ($bullets as $b): if (!empty($b['item'])): ?>
                        <li class="flex items-start text-gray-600">
                            <span class="mt-1 mr-3 inline-block h-2 w-2 rounded-full bg-gray-300"></span>
                            <span class="font-light"><?php echo esc_html($b['item']); ?></span>
                        </li>
                        <?php endif; endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <?php if ($link_url): ?>
                    <a href="<?php echo esc_url($link_url); ?>"
                        class="btn-secondary btn-compact btn-anim inline-flex items-center">
                        <?php echo esc_html($link_lbl); ?>
                        <span
                            class="ml-2 inline-block transition-transform duration-300 group-hover:translate-x-1">→</span>
                    </a>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <!-- Fallback static examples if no ACF content yet -->
            <div class="grid lg:grid-cols-3 gap-12">
                <?php
          $fallbacks = [
            [
              'img' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1600&auto=format&fit=crop',
              'title' => 'Venetian Plaster',
              'intro' => 'Hand-troweled marble plaster creating lustrous, depth-rich surfaces with timeless elegance.',
              'bullets' => ['Authentic lime-based materials', 'Multiple finish options', 'Naturally antimicrobial'],
            ],
            [
              'img' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=1600&auto=format&fit=crop',
              'title' => 'Heritage Restoration',
              'intro' => 'Specialized restoration using traditional lime mortars and time-honored techniques.',
              'bullets' => ['Listed building expertise', 'Conservation-grade materials', 'Period-accurate methods'],
            ],
            [
              'img' => 'https://images.unsplash.com/photo-1600573472550-8090b5e0744e?q=80&w=1600&auto=format&fit=crop',
              'title' => 'Decorative Finishes',
              'intro' => 'Bespoke decorative plasterwork: moldings, ceiling roses, and architectural details.',
              'bullets' => ['Custom design', 'Hand-run profiles', 'Specialty finishes'],
            ],
          ];
          foreach ($fallbacks as $f):
          ?>
                <article class="group">
                    <div class="relative overflow-hidden mb-8">
                        <img src="<?php echo esc_url($f['img']); ?>" alt=""
                            class="w-full h-80 object-cover transition-transform duration-700 group-hover:scale-105" />
                        <div
                            class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors duration-300">
                        </div>
                        <div class="absolute top-6 left-6">
                            <div class="bg-white/10 backdrop-blur-sm p-3 border border-white/20"><span
                                    class="text-white">★</span></div>
                        </div>
                    </div>
                    <h3 class="heading-md text-gray-900 mb-4 tracking-wide"><?php echo esc_html($f['title']); ?></h3>
                    <p class="body-base text-gray-600 leading-relaxed mb-6"><?php echo esc_html($f['intro']); ?></p>
                    <ul class="space-y-3 mb-8">
                        <?php foreach ($f['bullets'] as $b): ?>
                        <li class="flex items-start text-gray-600">
                            <span class="mt-1 mr-3 inline-block h-2 w-2 rounded-full bg-gray-300"></span>
                            <span class="font-light"><?php echo esc_html($b); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo esc_url( home_url('/contact') ); ?>"
                        class="btn-secondary btn-compact btn-anim inline-flex items-center">
                        <?php esc_html_e('Learn More','interior'); ?>
                        <span
                            class="ml-2 inline-block transition-transform duration-300 group-hover:translate-x-1">→</span>
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Process Section -->
    <section class="section bg-gray-50">
        <div class="container">
            <div class="section-header">
                <span
                    class="badge badge-dark mb-8 font-light tracking-wide"><?php echo wp_kses_post($process_badge); ?></span>
                <h2 class="heading-xl mb-6 text-gray-900"><?php echo wp_kses_post($process_title); ?></h2>
                <p class="body-lg text-gray-600 max-w-3xl mx-auto"><?php echo esc_html($process_intro); ?></p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">
                <?php if ($process_steps && is_array($process_steps)) :
          foreach ($process_steps as $step):
            $no    = $step['step_no'] ?? '';
            $t     = $step['title'] ?? '';
            $txt   = $step['text'] ?? '';
        ?>
                <div class="text-center">
                    <div class="bg-white p-8 mb-6 transition-all duration-300 hover:shadow-lg">
                        <div
                            class="w-16 h-16 bg-gray-100 mx-auto mb-6 flex items-center justify-center transition-all duration-300 hover:bg-gray-200">
                            <span class="text-2xl font-light text-gray-800"><?php echo esc_html($no ?: '—'); ?></span>
                        </div>
                        <h3 class="text-xl font-light text-gray-900 mb-4 tracking-wide"><?php echo esc_html($t); ?></h3>
                        <p class="text-gray-600 font-light leading-relaxed"><?php echo esc_html($txt); ?></p>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <?php
          $defaults = [
            ['01','Consultation','Detailed site assessment and design discussion to understand your vision.'],
            ['02','Preparation','Careful surface preparation and protection of surrounding areas.'],
            ['03','Application','Traditional techniques and premium materials for lasting beauty.'],
            ['04','Finishing','Final inspection and touch-ups to ensure perfection.'],
          ];
          foreach ($defaults as $d):
          ?>
                <div class="text-center">
                    <div class="bg-white p-8 mb-6 transition-all duration-300 hover:shadow-lg">
                        <div
                            class="w-16 h-16 bg-gray-100 mx-auto mb-6 flex items-center justify-center transition-all duration-300 hover:bg-gray-200">
                            <span class="text-2xl font-light text-gray-800"><?php echo esc_html($d[0]); ?></span>
                        </div>
                        <h3 class="text-xl font-light text-gray-900 mb-4 tracking-wide"><?php echo esc_html($d[1]); ?>
                        </h3>
                        <p class="text-gray-600 font-light leading-relaxed"><?php echo esc_html($d[2]); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="section bg-white">
        <div class="container">
            <div class="section-header">
                <span
                    class="badge badge-muted mb-8 font-light tracking-wide"><?php echo wp_kses_post($pricing_badge); ?></span>
                <h2 class="heading-xl mb-6 text-gray-900"><?php echo wp_kses_post($pricing_title); ?></h2>
                <p class="body-lg text-gray-600 max-w-3xl mx-auto"><?php echo esc_html($pricing_intro); ?></p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <?php if ($pricing_tiers && is_array($pricing_tiers)) :
          foreach ($pricing_tiers as $tier):
            $t_title = $tier['title'] ?? '';
            $t_blurb = $tier['blurb'] ?? '';
            $t_price = $tier['price'] ?? '';
            $t_unit  = $tier['unit'] ?? '';
            $t_bul   = $tier['bullets'] ?? [];
            $t_style = $tier['style'] ?? 'light';
            $t_cta_l = $tier['cta_label'] ?? __('Get Quote','interior');
            $t_cta_u = $tier['cta_url'] ?? home_url('/contact');

            $is_dark = ($t_style === 'dark');
        ?>
                <div
                    class="<?php echo $is_dark ? 'bg-gray-900 text-white' : 'bg-gray-50'; ?> p-8 relative transition-all duration-300 hover:shadow-lg">
                    <?php if ($is_dark): ?>
                    <div class="absolute top-4 right-4">
                        <span
                            class="badge badge-glass font-light tracking-wide"><?php esc_html_e('Most Popular','interior'); ?></span>
                    </div>
                    <?php endif; ?>

                    <h3
                        class="text-2xl font-light <?php echo $is_dark ? 'text-white' : 'text-gray-900'; ?> mb-4 tracking-wide">
                        <?php echo esc_html($t_title); ?>
                    </h3>
                    <p class="<?php echo $is_dark ? 'text-white/90' : 'text-gray-600'; ?> font-light mb-6">
                        <?php echo esc_html($t_blurb); ?>
                    </p>

                    <div class="mb-8">
                        <?php if ($t_price): ?>
                        <span
                            class="text-4xl font-light <?php echo $is_dark ? 'text-white' : 'text-gray-900'; ?>"><?php echo esc_html($t_price); ?></span>
                        <?php endif; ?>
                        <?php if ($t_unit): ?>
                        <span
                            class="<?php echo $is_dark ? 'text-white/90' : 'text-gray-600'; ?> font-light"><?php echo esc_html($t_unit); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if ($t_bul && is_array($t_bul)): ?>
                    <ul class="space-y-3 mb-8">
                        <?php foreach ($t_bul as $b) : if (!empty($b['item'])): ?>
                        <li class="flex items-start <?php echo $is_dark ? 'text-white/90' : 'text-gray-600'; ?>">
                            <span
                                class="mt-1 mr-3 inline-block h-2 w-2 rounded-full <?php echo $is_dark ? 'bg-white/50' : 'bg-gray-300'; ?>"></span>
                            <span class="font-light"><?php echo esc_html($b['item']); ?></span>
                        </li>
                        <?php endif; endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <a href="<?php echo esc_url($t_cta_u); ?>"
                        class="<?php echo $is_dark ? 'btn-light' : 'btn-secondary'; ?> btn-anim w-full text-center inline-flex items-center justify-center">
                        <?php echo esc_html($t_cta_l); ?>
                    </a>
                </div>
                <?php endforeach; else: ?>
                <!-- Fallback three tiers -->
                <?php
          $tiers = [
            ['Essential','Perfect for smaller residential projects and touch-ups.','£45','/sq meter',['Standard lime plaster finish','Basic surface preparation','1-year warranty'], false, __('Get Quote','interior')],
            ['Premium','Ideal for luxury residential and commercial spaces.','£85','/sq meter',['Venetian plaster finish','Premium surface preparation','Multiple finish options','5-year warranty'], true, __('Get Quote','interior')],
            ['Bespoke','Custom solutions for heritage and specialty projects.','£150+','/sq meter',['Heritage restoration techniques','Custom decorative elements','Specialist materials','Lifetime warranty'], false, __('Consultation','interior')],
          ];
          foreach ($tiers as $t):
            [$tt,$tb,$tp,$tu,$bul,$dark,$cta] = $t;
          ?>
                <div
                    class="<?php echo $dark ? 'bg-gray-900 text-white' : 'bg-gray-50'; ?> p-8 relative transition-all duration-300 hover:shadow-lg">
                    <?php if ($dark): ?>
                    <div class="absolute top-4 right-4"><span class="badge badge-glass">Most Popular</span></div>
                    <?php endif; ?>
                    <h3
                        class="text-2xl font-light <?php echo $dark ? 'text-white' : 'text-gray-900'; ?> mb-4 tracking-wide">
                        <?php echo esc_html($tt); ?></h3>
                    <p class="<?php echo $dark ? 'text-white/90' : 'text-gray-600'; ?> font-light mb-6">
                        <?php echo esc_html($tb); ?></p>
                    <div class="mb-8">
                        <span
                            class="text-4xl font-light <?php echo $dark ? 'text-white' : 'text-gray-900'; ?>"><?php echo esc_html($tp); ?></span>
                        <span
                            class="<?php echo $dark ? 'text-white/90' : 'text-gray-600'; ?> font-light"><?php echo esc_html($tu); ?></span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <?php foreach ($bul as $b): ?>
                        <li class="flex items-start <?php echo $dark ? 'text-white/90' : 'text-gray-600'; ?>">
                            <span
                                class="mt-1 mr-3 inline-block h-2 w-2 rounded-full <?php echo $dark ? 'bg-white/50' : 'bg-gray-300'; ?>"></span>
                            <span class="font-light"><?php echo esc_html($b); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo esc_url( home_url('/contact') ); ?>"
                        class="<?php echo $dark ? 'btn-light' : 'btn-secondary'; ?> btn-anim w-full inline-flex items-center justify-center">
                        <?php echo esc_html($cta); ?>
                    </a>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section  -->
    <?php get_template_part('template-parts/components/cta'); ?>



</main>

<?php get_footer(); ?>