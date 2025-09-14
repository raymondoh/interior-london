<?php
/**
 * Theme Setup
 *
 * Handles theme supports, menus, image sizes, and text domain.
 *
 * @package WordPress_Boilerplate
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Theme setup callback.
 */
function boilerplate_setup() {
    // Make theme available for translation.
    load_theme_textdomain( 'boilerplate', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable featured images.
    add_theme_support( 'post-thumbnails' );
    add_image_size('project-card', 960, 720, true);

    // Register navigation menus.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'boilerplate' ),
    ) );

    // Switch default core markup to valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Support custom logo.
    add_theme_support( 'custom-logo', array(
        'height'      => 64,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ) );
    // Menus
  register_nav_menus([
    'primary' => __('Primary Menu', 'interior'),
  ]);

    // Add responsive embeds.
    add_theme_support( 'responsive-embeds' );

    // Example image sizes (adjust or remove if not needed).
    add_image_size( 'card-thumb', 600, 400, true );
    add_image_size( 'hero', 1600, 900, true );
}
add_action( 'after_setup_theme', 'boilerplate_setup' );