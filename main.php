<?php
/*Plugin Name: bs Swiper
Plugin URI: https://bootscore.me/documentation/bs-swiper/
Description: Plugin to show posts, pages, custom post types or WooCommerce products in a swiper.js carousel in Bootscore theme.
Version: 5.8.12
Tested up to: 6.9
Requires at least: 5.0
Requires PHP: 7.4
Author: Bootscore
Author URI: https://bootscore.me
License: MIT License
*/


// Exit if accessed directly
defined( 'ABSPATH' ) || exit;


/**
 * Update checker
 */
require 'inc/update/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/bootscore/bs-swiper/',
	__FILE__,
	'bs-swiper'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');


/**
 * Load required files
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/locate-template.php'; // Template overrides
require_once plugin_dir_path( __FILE__ ) . 'inc/enqueue.php';         // Scripts & styles
