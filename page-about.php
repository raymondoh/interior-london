<?php
/**
 * Template Name: About
 * Template Post Type: page
 * @package Interior_Theme
 */


get_header();

$pid = get_queried_object_id();
$gfi = function_exists('get_field') ? 'get_field' : null;

$badge = $gfi ? $gfi('about_badge', $pid) : '';
$title = $gfi ? $gfi('about_title', $pid) : '';
$intro = $gfi ? $gfi('about_intro', $pid) : '';

$story_heading = $gfi ? $gfi('about_story_heading', $pid) : '';
$story_text    = $gfi ? $gfi('about_story_text', $pid) : '';
$story_img_id  = $gfi ? (int) $gfi('about_story_image', $pid) : 0;

$team_heading  = $gfi ? $gfi('about_team_heading', $pid) : '';
$team = [
  [
    'name' => $gfi ? $gfi('about_team_1_name', $pid) : '',
    'role' => $gfi ? $gfi('about_team_1_role', $pid) : '',
    'bio'  => $gfi ? $gfi('about_team_1_bio',  $pid) : '',
    'img'  => $gfi ? (int)$gfi('about_team_1_img', $pid) : 0,
  ],
  [
    'name' => $gfi ? $gfi('about_team_2_name', $pid) : '',
    'role' => $gfi ? $gfi('about_team_2_role', $pid) : '',
    'bio'  => $gfi ? $gfi('about_team_2_bio',  $pid) : '',
    'img'  => $gfi ? (int)$gfi('about_team_2_img', $pid) : 0,
  ],
  [
    'name' => $gfi ? $gfi('about_team_3_name', $pid) : '',
    'role' => $gfi ? $gfi('about_team_3_role', $pid) : '',
    'bio'  => $gfi ? $gfi('about_team_3_bio',  $pid) : '',
    'img'  => $gfi ? (int)$gfi('about_team_3_img', $pid) : 0,
  ],
];

$exp_heading   = $gfi ? $gfi('about_expertise_heading', $pid) : '';
$certs_heading = $gfi ? $gfi('about_certifications_heading', $pid) : '';
$certs_list    = $gfi ? $gfi('about_certifications_list', $pid) : '';
$awds_heading  = $gfi ? $gfi('about_awards_heading', $pid) : '';
$awds_list     = $gfi ? $gfi('about_awards_list', $pid) : '';

$values_heading = $gfi ? $gfi('about_values_heading', $pid) : '';
$val1_t = $gfi ? $gfi('about_value_1_title', $pid) : '';
$val1_p = $gfi ? $gfi('about_value_1_text',  $pid) : '';
$val2_t = $gfi ? $gfi('about_value_2_title', $pid) : '';
$val2_p = $gfi ? $gfi('about_value_2_text',  $pid) : '';
$val3_t = $gfi ? $gfi('about_value_3_title', $pid) : '';
$val3_p = $gfi ? $gfi('about_value_3_text',  $pid) : '';

function interior_lines_to_array($text) {
  $lines = array_map('trim', preg_split('/\r\n|\r|\n/', (string)$text));
  return array_values(array_filter($lines, fn($l) => $l !== ''));
}
?>
<main id="primary" class="site-main">

    <!-- Hero -->
    <section class="section-hero bg-white">
        <div class="container text-center">
            <?php if ($badge): ?>
            <span
                class="button-text inline-block rounded-full bg-gray-100 text-gray-800 border border-gray-200 px-3 py-1.5 mb-6">
                <?php echo esc_html($badge); ?>
            </span>
            <?php endif; ?>

            <h1 class="heading-xl text-gray-900 tracking-tight">
                <?php echo esc_html($title ?: 'Masters of the '); ?>
                <?php if (!$title): ?><span
                    class="font-normal"><?php esc_html_e('Ancient Craft','interior'); ?></span><?php endif; ?>
            </h1>

            <?php if ($intro): ?>
            <div class="body-lg text-gray-600 max-w-3xl mx-auto mt-6"><?php echo wp_kses_post( wpautop($intro) ); ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Story -->
    <section class="section bg-gray-50">
        <div class="container">
            <div class="grid lg:grid-cols-2 items-center gap-12 lg:gap-20">
                <div>
                    <h2 class="heading-lg text-gray-900 tracking-tight mb-6 sm:mb-8">
                        <?php echo esc_html($story_heading ?: 'Our Story'); ?>
                    </h2>
                    <?php if ($story_text): ?>
                    <div class="body-base text-gray-600 space-y-6">
                        <?php echo wp_kses_post( wpautop($story_text) ); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="relative overflow-hidden">
                    <?php
            if ($story_img_id) {
              echo wp_get_attachment_image($story_img_id, 'large', false, ['class'=>'w-full h-96 object-cover rounded-sm']);
            }
          ?>
                </div>
            </div>
        </div>
    </section>


    <!-- Team -->
    <section class="section bg-white">
        <div class="container">
            <div class="section-header">
                <span
                    class="button-text inline-block rounded-full bg-gray-100 text-gray-800 border border-gray-200 px-3 py-1.5 mb-6">
                    <?php esc_html_e('Leadership Team','interior'); ?>
                </span>
                <h2 class="heading-lg text-gray-900 tracking-tight">
                    <?php echo esc_html($team_heading ?: 'Meet Our '); ?>
                    <?php if (!$team_heading): ?>
                    <span class="font-normal"><?php esc_html_e('Master Craftsmen','interior'); ?></span>
                    <?php endif; ?>
                </h2>
            </div>

            <?php
    // Build $team array if not already done upstream:
    // $team = [
    //   ['name'=> get_field('about_team_1_name'), 'role'=>..., 'bio'=>..., 'img'=>...],
    //   ...
    // ];
    $team_items = array_values(array_filter($team ?? [], function($m){
      return !empty($m['name']) || !empty($m['img']);
    }));
    ?>

            <?php if (!empty($team_items)): ?>

            <!-- Mobile slider (visible < md) -->
            <div class="block md:hidden">
                <div class="swiper" id="about-team-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($team_items as $member): ?>
                        <div class="swiper-slide">
                            <div class="text-center group">
                                <div class="mb-6 overflow-hidden">
                                    <?php
                      if (!empty($member['img'])) {
                        echo wp_get_attachment_image(
                          $member['img'],
                          'large',
                          false,
                          ['class' => 'w-full h-80 object-cover transition-transform duration-300 group-hover:scale-105 rounded-md']
                        );
                      } else {
                        echo '<div class="w-full h-80 bg-gray-100 rounded-md"></div>';
                      }
                    ?>
                                </div>
                                <?php if (!empty($member['name'])): ?>
                                <h3 class="heading-md text-gray-900 mb-2"><?php echo esc_html($member['name']); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($member['role'])): ?>
                                <p class="body-base text-gray-600 mb-4"><?php echo esc_html($member['role']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($member['bio'])): ?>
                                <p class="body-sm text-gray-500"><?php echo esc_html($member['bio']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Slider UI -->
                    <div class="swiper-pagination swiper-pagination-static mt-6"></div>
                </div>
            </div>

            <!-- Desktop grid (hidden < md) -->
            <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-16">
                <?php foreach ($team_items as $member): ?>
                <div class="text-center group">
                    <div class="mb-8 overflow-hidden">
                        <?php
                if (!empty($member['img'])) {
                  echo wp_get_attachment_image(
                    $member['img'],
                    'large',
                    false,
                    ['class' => 'w-full h-80 object-cover transition-transform duration-300 group-hover:scale-105 rounded-md']
                  );
                } else {
                  echo '<div class="w-full h-80 bg-gray-100 rounded-md"></div>';
                }
              ?>
                    </div>
                    <?php if (!empty($member['name'])): ?>
                    <h3 class="heading-md text-gray-900 mb-2"><?php echo esc_html($member['name']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($member['role'])): ?>
                    <p class="body-base text-gray-600 mb-4"><?php echo esc_html($member['role']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($member['bio'])): ?>
                    <p class="body-sm text-gray-500"><?php echo esc_html($member['bio']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <?php else: ?>
            <div class="rounded-2xl border border-black/5 bg-white/70 backdrop-blur p-10 text-center">
                <p class="body-base text-neutral-700"><?php esc_html_e('Team coming soon.','interior'); ?></p>
            </div>
            <?php endif; ?>

        </div>
    </section>


    <!-- Expertise & Certifications -->
    <section class="section bg-gray-50">
        <div class="container">
            <div class="section-header">
                <span
                    class="button-text inline-block rounded-full bg-gray-900 text-white border border-gray-800 px-3 py-1.5 mb-6">
                    <?php esc_html_e('Expertise & Credentials','interior'); ?>
                </span>
                <h2 class="heading-lg text-gray-900 tracking-tight">
                    <?php echo esc_html($exp_heading ?: 'Certified Excellence'); ?>
                </h2>
            </div>

            <div class="grid md:grid-cols-2 gap-12 lg:gap-20">
                <div>
                    <h3 class="heading-md text-gray-900 mb-6 sm:mb-8">
                        <?php echo esc_html($certs_heading ?: 'Professional Certifications'); ?>
                    </h3>
                    <?php $certs = interior_lines_to_array($certs_list); ?>
                    <?php if ($certs): ?>
                    <ul class="space-y-6 body-base text-gray-600">
                        <?php foreach ($certs as $c): ?><li><?php echo esc_html($c); ?></li><?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>

                <div>
                    <h3 class="heading-md text-gray-900 mb-6 sm:mb-8">
                        <?php echo esc_html($awds_heading ?: 'Awards & Recognition'); ?>
                    </h3>
                    <?php $awds = interior_lines_to_array($awds_list); ?>
                    <?php if ($awds): ?>
                    <ul class="space-y-6 body-base text-gray-600">
                        <?php foreach ($awds as $a): ?><li><?php echo esc_html($a); ?></li><?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="section bg-white">
        <div class="container">
            <div class="section-header">
                <h2 class="heading-lg text-gray-900 tracking-tight">
                    <?php echo esc_html($values_heading ?: 'Our Values'); ?>
                </h2>
                <p class="body-lg text-gray-600 max-w-3xl mx-auto mt-4">
                    <?php esc_html_e('Every project is guided by principles that have shaped our craft for generations.', 'interior'); ?>
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-12 lg:gap-16">
                <?php
          $values = [
            ['title'=>$val1_t, 'text'=>$val1_p, 'icon'=>'✦'],
            ['title'=>$val2_t, 'text'=>$val2_p, 'icon'=>'✓'],
            ['title'=>$val3_t, 'text'=>$val3_p, 'icon'=>'∞'],
          ];
          foreach ($values as $v):
            if (!($v['title'] || $v['text'])) continue;
        ?>
                <div class="text-center">
                    <div class="bg-gray-50 p-8 mb-8 transition-all duration-300 hover:bg-gray-100">
                        <span class="text-2xl font-light text-gray-800"><?php echo esc_html($v['icon']); ?></span>
                    </div>
                    <?php if ($v['title']): ?><h3 class="heading-md text-gray-900 mb-4">
                        <?php echo esc_html($v['title']); ?></h3><?php endif; ?>
                    <?php if ($v['text']):  ?><p class="body-base text-gray-600"><?php echo esc_html($v['text']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <?php get_template_part('template-parts/components/cta'); ?>

</main>

<?php get_footer(); ?>