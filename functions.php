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