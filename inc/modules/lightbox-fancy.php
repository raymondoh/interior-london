<?php
if ( ! defined('ABSPATH') ) { exit; }

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('fancybox-css','https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css', [], '5.0');
  wp_enqueue_script('fancybox-js','https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', [], '5.0', true);

  $init = get_stylesheet_directory().'/assets/modules/lightbox-fancybox.js';
  if ( file_exists($init) ) {
    wp_enqueue_script('bp-fancybox-init', get_stylesheet_directory_uri().'/assets/modules/lightbox-fancybox.js', ['fancybox-js'], filemtime($init), true);
  }
});