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
    'swiper'   => true,
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

   
  }
});


// AJAX: load more projects for /portfolio (and term archives)
add_action('wp_ajax_interior_load_more', 'interior_load_more_projects');
add_action('wp_ajax_nopriv_interior_load_more', 'interior_load_more_projects');

function interior_load_more_projects() {
  check_ajax_referer('interior_load_more', 'nonce');

  $paged          = max(2, (int) ($_POST['paged'] ?? 2));
  $posts_per_page = max(1, (int) ($_POST['ppp'] ?? 9));
  $term_id        = isset($_POST['term_id']) ? (int) $_POST['term_id'] : 0;
  $view           = (isset($_POST['view']) && $_POST['view'] === 'list') ? 'list' : 'grid';
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
    'no_found_rows'       => false, // needed to compute max_num_pages for have_more
  ];

  if ($term_id) {
    $args['tax_query'] = [[
      'taxonomy' => 'project_category',
      'field'    => 'term_id',
      'terms'    => $term_id,
    ]];
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

  // Derive have_more robustly
  $max_pages = (int) $q->max_num_pages;
  $have_more = ($max_pages > 0) && ($paged < $max_pages);
  $next_paged = $have_more ? ($paged + 1) : 0;

  wp_send_json_success([
    'html'       => $html,       // rendered cards (may be '')
    'have_more'  => $have_more,  // explicit boolean
    'next_paged' => $next_paged, // 0 when there are no more pages
  ]);
}

// Mark the "Portfolio" menu item current on project archive, single, and taxonomy pages
add_filter('nav_menu_css_class', function($classes, $item){
  // The URL of your portfolio archive
  $archive_url = untrailingslashit( get_post_type_archive_link('project') );
  $item_url    = untrailingslashit( $item->url );

  if (
    ( is_post_type_archive('project') || is_singular('project') || is_tax('project_category') )
    && $archive_url && $item_url && $item_url === $archive_url
  ) {
    $classes[] = 'current-menu-item';
  }

  return $classes;
}, 10, 2);
// Contact form handler
add_action('admin_post_nopriv_interior_contact', 'interior_handle_contact_form');
add_action('admin_post_interior_contact',        'interior_handle_contact_form');

function interior_handle_contact_form() {
  // Basic nonce check
  if ( ! isset($_POST['interior_contact_nonce_field']) ||
       ! wp_verify_nonce($_POST['interior_contact_nonce_field'], 'interior_contact_nonce') ) {
    interior_contact_redirect_with_error('Security check failed.');
  }

  $name        = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
  $email       = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
  $phone       = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
  $projectType = isset($_POST['projectType']) ? sanitize_text_field($_POST['projectType']) : '';
  $message     = isset($_POST['message']) ? wp_strip_all_tags($_POST['message']) : '';

  // Basic required fields
  if ( $name === '' || $email === '' || $message === '' ) {
    interior_contact_redirect_with_error('Please complete all required fields.', compact('name','email','phone','projectType','message'));
  }

  // Prepare email
  $to      = get_option('admin_email');
  $subject = sprintf('[Contact] %s', $name);
  $body    = "Name: $name\nEmail: $email\nPhone: $phone\nProject Type: $projectType\n\nMessage:\n$message\n";
  $headers = array('Reply-To: ' . $name . ' <' . $email . '>');

  $sent = wp_mail($to, $subject, $body, $headers);

  $redirect = wp_get_referer() ?: home_url('/');
  if ($sent) {
    wp_safe_redirect( add_query_arg('sent', 1, $redirect) );
  } else {
    interior_contact_redirect_with_error('Could not send email. Please try again later.', compact('name','email','phone','projectType','message'));
  }
  exit;
}

function interior_contact_redirect_with_error($msg, $data = array()) {
  $redirect = wp_get_referer() ?: home_url('/');
  $args = array('sent' => -1, 'error' => $msg);
  // repopulate fields on error
  foreach ($data as $k => $v) { $args[$k] = $v; }
  wp_safe_redirect( add_query_arg($args, $redirect) );
  exit;
}