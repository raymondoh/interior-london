<?php
if ( ! defined('ABSPATH') ) { exit; }

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11');
  wp_enqueue_script('swiper-js','https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11', true);

  $init = get_stylesheet_directory().'/assets/modules/carousel-swiper.js';
  if ( file_exists($init) ) {
    wp_enqueue_script('bp-swiper-init', get_stylesheet_directory_uri().'/assets/modules/carousel-swiper.js', ['swiper-js'], filemtime($init), true);
  }
});