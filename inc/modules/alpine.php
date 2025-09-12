<?php
if ( ! defined('ABSPATH') ) { exit; }

/** Alpine.js + early AJAX payload (so x-init can read it) */
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_script('alpine-intersect', 'https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js', [], null, true);
  wp_enqueue_script('alpine-js',        'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', ['alpine-intersect'], null, true);

  $data = [
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce'    => wp_create_nonce('load_more_posts'),
  ];
  $payload = 'window.hinton_portfolio_ajax_obj = '.wp_json_encode($data).';'
           . 'var hinton_portfolio_ajax_obj = window.hinton_portfolio_ajax_obj;';
  wp_add_inline_script('alpine-js', $payload, 'before');

  // Optional: your Alpine init script
  $init = get_stylesheet_directory().'/assets/modules/alpine-init.js';
  if ( file_exists($init) ) {
    wp_enqueue_script('bp-alpine-init', get_stylesheet_directory_uri().'/assets/modules/alpine-init.js', ['alpine-js'], filemtime($init), true);
  }
});