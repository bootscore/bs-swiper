<?php
/*Plugin Name: bs Swiper
Plugin URI: https://bootscore.me/documentation/bs-swiper/
Description: Plugin to show posts, pages, custom post types or WooCommerce products in a swiper.js carousel in Bootscore theme.
Version: 6-dev
Tested up to: 6.8
Requires at least: 5.0
Requires PHP: 7.4
Author: Bootscore
Author URI: https://bootscore.me
License: MIT License
*/


// Exit if accessed directly
defined( 'ABSPATH' ) || exit;


/**
 * Load required files
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/enqueue.php';             // Enqueue scripts and styles
require_once plugin_dir_path( __FILE__ ) . 'inc/locate-template.php';     // Allow template overrides in child-theme
require_once plugin_dir_path( __FILE__ ) . 'inc/shortcode.php';           // Shortcode for columns and heroes


// Temporary, add this file to locate_template
require_once plugin_dir_path( __FILE__ ) . 'templates/related-posts.php'; // Related posts