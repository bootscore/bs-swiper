<?php

/**
 * Enqueue styles & scripts
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  6.0.0
 */


// Exit if accessed directly
defined('ABSPATH') || exit;


/**
 * Register styles and scripts
 */
function swiper_scripts() {

  // Base plugin directory (go up one level from /inc/)
  $plugin_dir = plugin_dir_path(__DIR__);
  $plugin_url = plugin_dir_url(__DIR__);

  // File paths
  $swiper_js      = $plugin_dir . 'assets/js/swiper-bundle.min.js';
  $swiper_init_js = $plugin_dir . 'assets/js/swiper-init.min.js';
  $swiper_css     = $plugin_dir . 'assets/css/swiper-bundle.min.css';
  $swiper_style   = $plugin_dir . 'assets/css/swiper-style.min.css';

  // Versions based on file modification time
  $swiper_js_ver      = file_exists($swiper_js) ? date('YmdHi', filemtime($swiper_js)) : false;
  $swiper_init_js_ver = file_exists($swiper_init_js) ? date('YmdHi', filemtime($swiper_init_js)) : false;
  $swiper_css_ver     = file_exists($swiper_css) ? date('YmdHi', filemtime($swiper_css)) : false;
  $swiper_style_ver   = file_exists($swiper_style) ? date('YmdHi', filemtime($swiper_style)) : false;

  // Enqueue scripts with versioning
  wp_enqueue_script('swiper-min-js', $plugin_url . 'assets/js/swiper-bundle.min.js', [], $swiper_js_ver, true);
  wp_enqueue_script('swiper-init-js', $plugin_url . 'assets/js/swiper-init.min.js', [], $swiper_init_js_ver, true);

  // Enqueue styles with versioning
  wp_enqueue_style('swiper-min-css', $plugin_url . 'assets/css/swiper-bundle.min.css', [], $swiper_css_ver);
  wp_enqueue_style('swiper-style-css', $plugin_url . 'assets/css/swiper-style.min.css', [], $swiper_style_ver);
}

add_action('wp_enqueue_scripts', 'swiper_scripts');
