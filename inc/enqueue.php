<?php

/**
 * Enqueue styles & scripts
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  5.8.12
 */


// Exit if accessed directly
defined('ABSPATH') || exit;


/**
 * Register styles and scripts
 */
function bs_swiper_scripts() {

  // Plugin root
  $plugin_dir = plugin_dir_path( dirname( __FILE__ ) );
  $plugin_url = plugin_dir_url( dirname( __FILE__ ) );

  // File paths
  $swiper_js      = $plugin_dir . 'assets/js/swiper-bundle.min.js';
  $swiper_init_js = $plugin_dir . 'assets/js/swiper-init.min.js';
  $swiper_css     = $plugin_dir . 'assets/css/swiper-bundle.min.css';
  $swiper_style   = $plugin_dir . 'assets/css/swiper-style.min.css';

  // Versions based on file modification time
  $swiper_js_ver      = file_exists( $swiper_js ) ? date( 'YmdHi', filemtime( $swiper_js ) ) : false;
  $swiper_init_js_ver = file_exists( $swiper_init_js ) ? date( 'YmdHi', filemtime( $swiper_init_js ) ) : false;
  $swiper_css_ver     = file_exists( $swiper_css ) ? date( 'YmdHi', filemtime( $swiper_css ) ) : false;
  $swiper_style_ver   = file_exists( $swiper_style ) ? date( 'YmdHi', filemtime( $swiper_style ) ) : false;

  // Scripts
  wp_enqueue_script(
    'swiper-min-js',
    $plugin_url . 'assets/js/swiper-bundle.min.js',
    [],
    $swiper_js_ver,
    true
  );

  wp_enqueue_script(
    'swiper-init-js',
    $plugin_url . 'assets/js/swiper-init.min.js',
    [ 'swiper-min-js' ],
    $swiper_init_js_ver,
    true
  );

  // Styles
  wp_enqueue_style(
    'swiper-min-css',
    $plugin_url . 'assets/css/swiper-bundle.min.css',
    [],
    $swiper_css_ver
  );

  wp_enqueue_style(
    'swiper-style-css',
    $plugin_url . 'assets/css/swiper-style.min.css',
    [ 'swiper-min-css' ],
    $swiper_style_ver
  );
}

add_action( 'wp_enqueue_scripts', 'bs_swiper_scripts' );
