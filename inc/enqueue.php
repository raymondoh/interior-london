<?php
/**
 * Enqueue theme styles and scripts
 *
 * @package Interior_Theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Core assets: Tailwind CSS + esbuild JS bundle
 */
function interior_enqueue_assets() {
    $dir = get_template_directory();
    $uri = get_template_directory_uri();

    // CSS (Tailwind build)
    $css_rel = '/assets/css/main.css';
    if ( file_exists( $dir . $css_rel ) ) {
        wp_enqueue_style(
            'interior-main-style',
            $uri . $css_rel,
            array(),
            filemtime( $dir . $css_rel )
        );
    }

    // JS (esbuild bundle)
    $js_rel = '/assets/js/main.js';
    if ( file_exists( $dir . $js_rel ) ) {
        wp_enqueue_script(
            'interior-main',                 // single canonical handle
            $uri . $js_rel,
            array(),
            filemtime( $dir . $js_rel ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'interior_enqueue_assets', 20 );

/**
 * Optional modules (toggle via $BP_MODULES in functions.php)
 * Example:
 *   $BP_MODULES = ['alpine' => false, 'fancybox' => true, 'swiper' => false];
 *   $GLOBALS['BP_MODULES'] = $BP_MODULES;
 */
function interior_enqueue_modules() {
    global $BP_MODULES;
    if ( empty( $BP_MODULES ) || ! is_array( $BP_MODULES ) ) return;

    // Alpine.js
    if ( ! empty( $BP_MODULES['alpine'] ) ) {
        wp_enqueue_script(
            'alpine-js',
            'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js',
            array(),
            null,
            true
        );
    }

    // Fancybox
    if ( ! empty( $BP_MODULES['fancybox'] ) ) {
        wp_enqueue_style(
            'fancybox-css',
            'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css',
            array(),
            '5.0'
        );
        wp_enqueue_script(
            'fancybox-js',
            'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js',
            array(),
            '5.0',
            true
        );
    }

    // Swiper
    if ( ! empty( $BP_MODULES['swiper'] ) ) {
        wp_enqueue_style(
            'swiper-css',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            array(),
            '11'
        );
        wp_enqueue_script(
            'swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            array(),
            '11',
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'interior_enqueue_modules', 30 );

/**
 * Inject archive config for Load More (before main.js)
 */
add_action( 'wp_enqueue_scripts', function () {
    if ( ! ( is_post_type_archive( 'project' ) || is_tax( 'project_category' ) ) ) {
        return;
    }

    // Build context for the script
    $term         = is_tax( 'project_category' ) ? get_queried_object() : null;
    $term_id      = $term ? (int) $term->term_id : 0;
    $year         = isset( $_GET['year'] ) ? sanitize_text_field( $_GET['year'] ) : 'all';
    $view         = ( isset( $_GET['view'] ) && $_GET['view'] === 'list' ) ? 'list' : 'grid';
    $featured_ids = $GLOBALS['interior_featured_ids'] ?? [];

    $config = array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'interior_load_more' ),
        'ppp'      => 9,
        'year'     => $year,
        'term_id'  => $term_id,
        'view'     => $view,
        'exclude'  => array_map( 'intval', (array) $featured_ids ),
    );

    // Ensure main script is registered/enqueued first (by our earlier hook)
    if ( wp_script_is( 'interior-main', 'enqueued' ) ) {
        wp_add_inline_script(
            'interior-main',
            'window.INTERIOR_LOAD_MORE = ' . wp_json_encode( $config ) . ';',
            'before'
        );
    }
}, 25 );