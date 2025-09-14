<?php
/**
 * Theme bootstrap
 *
 * @package WordPress_Boilerplate
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Version (used for cache keys elsewhere if needed).
 * Keep in sync with style.css header if you wish.
 */
define( 'BP_THEME_VERSION', '0.1.0' );

/**
 * Core includes
 */
require_once __DIR__ . '/inc/setup.php';
require_once __DIR__ . '/inc/enqueue.php';

/**
 * Optional feature modules
 * Flip to true per project, or override via the 'bp/modules' filter.
 *
 * Available modules (handled in inc/enqueue.php):
 * - alpine    : Loads Alpine.js (CDN)
 * - fancybox  : Loads Fancybox (CSS/JS via CDN)
 * - swiper    : Loads Swiper (CSS/JS via CDN)
 */
$BP_MODULES = array(
    'alpine'   => false,
    'fancybox' => false,
    'swiper'   => false,
);

/**
 * Allow child themes / plugins to override module toggles.
 * Example:
 *   add_filter('bp/modules', fn($m) => array_merge($m, ['alpine' => true]));
 */
$BP_MODULES = apply_filters( 'bp/modules', $BP_MODULES );

/**
 * (Optional) expose toggles globally for enqueue.php
 */
$GLOBALS['BP_MODULES'] = $BP_MODULES;

/**
 * Housekeeping: add a small body class to help target this theme if needed.
 */
add_filter( 'body_class', function( $classes ) {
    $classes[] = 'bp-theme';
    return $classes;
});
add_action('pre_get_posts', function (WP_Query $q) {
  if ( is_admin() || ! $q->is_main_query() ) return;

  // Portfolio archive + category archives
  if ( $q->is_post_type_archive('project') || $q->is_tax('project_category') ) {
    // Page size for grids
    $q->set('posts_per_page', 9);

    // Filter by ACF meta project_year via ?year=YYYY
    if ( isset($_GET['year']) && $_GET['year'] !== 'all' ) {
      $year = sanitize_text_field($_GET['year']);
      $meta_query = (array) $q->get('meta_query');
      $meta_query[] = [
        'key'     => 'project_year',
        'value'   => $year,
        'compare' => '='
      ];
      $q->set('meta_query', $meta_query);
      // optional: sort newest first if many same-year entries
      $q->set('orderby', 'date');
      $q->set('order', 'DESC');
    }
  }
});

// AJAX: load more projects for /portfolio (and term archives)
add_action('wp_ajax_interior_load_more', 'interior_load_more_projects');
add_action('wp_ajax_nopriv_interior_load_more', 'interior_load_more_projects');

function interior_load_more_projects() {
  check_ajax_referer('interior_load_more', 'nonce');

  $paged          = max(2, (int) ($_POST['paged'] ?? 2));
  $posts_per_page = max(1, (int) ($_POST['ppp'] ?? 9));
  $year           = sanitize_text_field($_POST['year'] ?? 'all');
  $term_id        = (int) ($_POST['term_id'] ?? 0);
  $view           = ($_POST['view'] === 'list') ? 'list' : 'grid';
  $exclude_ids    = array_filter(array_map('intval', (array) ($_POST['exclude'] ?? [])));

  $args = [
    'post_type'           => 'project',
    'post_status'         => 'publish',
    'paged'               => $paged,
    'posts_per_page'      => $posts_per_page,
    'ignore_sticky_posts' => true,
    'post__not_in'        => $exclude_ids,
    'orderby'             => 'date',
    'order'               => 'DESC',
  ];

  if ($year !== 'all') {
    $args['meta_query'][] = [
      'key'     => 'project_year',
      'value'   => $year,
      'compare' => '=',
    ];
  }

  if ($term_id) {
    $args['tax_query'][] = [
      'taxonomy' => 'project_category',
      'field'    => 'term_id',
      'terms'    => $term_id,
    ];
  }

  $q = new WP_Query($args);

  ob_start();
  if ($q->have_posts()) {
    while ($q->have_posts()) {
      $q->the_post();
      get_template_part('template-parts/project/card', null, [
        'id'       => get_the_ID(),
        'variant'  => $view,
        'featured' => false,
      ]);
    }
  }
  wp_reset_postdata();

  $html = ob_get_clean();

  wp_send_json_success([
    'html'      => $html,
    'have_more' => ($paged < (int) $q->max_num_pages),
    'next_paged'=> $paged + 1,
  ]);
}