<?php
/**
 * Enqueue theme styles and scripts
 *
 * @package WordPress_Boilerplate
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue styles and scripts.
 */
function boilerplate_enqueue_assets() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // CSS (compiled Tailwind build).
    $css_rel = '/assets/css/main.css';
    if ( file_exists( $theme_dir . $css_rel ) ) {
        wp_enqueue_style(
            'boilerplate-main-style',
            $theme_uri . $css_rel,
            array(),
            filemtime( $theme_dir . $css_rel )
        );
    }

    // JS (compiled bundle).
    $js_rel = '/assets/js/main.js';
    if ( file_exists( $theme_dir . $js_rel ) ) {
        wp_enqueue_script(
            'boilerplate-main-js',
            $theme_uri . $js_rel,
            array(),
            filemtime( $theme_dir . $js_rel ),
            true // load in footer
        );
    }
}
add_action( 'wp_enqueue_scripts', 'boilerplate_enqueue_assets' );

/**
 * Optional: enqueue module scripts if toggled in functions.php
 * Example: $BP_MODULES['alpine'] = true;
 */
function boilerplate_enqueue_modules() {
    global $BP_MODULES;

    if ( ! is_array( $BP_MODULES ) ) {
        return;
    }

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
            'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css',
            array(),
            '10.0.0'
        );
        wp_enqueue_script(
            'swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js',
            array(),
            '10.0.0',
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'boilerplate_enqueue_modules', 20 );