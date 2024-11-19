<?php
/*Plugin Name: bs Swiper
Plugin URI: https://bootscore.me/documentation/bs-swiper/
Description: Plugin to show posts, pages, custom post types or WooCommerce products in a swiper.js carousel in Bootscore theme.
Version: 5.8.7
Tested up to: 6.7
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
require 'update/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/bootscore/bs-swiper/',
	__FILE__,
	'bs-swiper'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');


/**
 * Register styles and scripts
 */
function swiper_scripts() {

  wp_enqueue_script('swiper-min-js', plugins_url('/assets/js/swiper-bundle.min.js', __FILE__), array(), false, true);

  wp_enqueue_script('swiper-init-js', plugins_url('/assets/js/swiper-init.min.js', __FILE__), array(), false, true);

  wp_register_style('swiper-min-css', plugins_url('/assets/css/swiper-bundle.min.css', __FILE__));
  wp_enqueue_style('swiper-min-css');

  wp_register_style('swiper-style-css', plugins_url('/assets/css/swiper-style.min.css', __FILE__));
  wp_enqueue_style('swiper-style-css');
}

add_action('wp_enqueue_scripts', 'swiper_scripts');


/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/bs-swiper/$template_name
 * 2. /themes/theme/bs-swiper-main/$template_name
 * 3. /themes/theme/$template_name
 * 4. /plugins/bs-swiper-main/templates/$template_name.
 *
 * @since 5.7.0
 *
 * @param 	string 	$template_name			Template to load.
 * @param 	string 	$string $template_path	Path to templates.
 * @param 	string	$default_path			Default path to template files.
 * @return 	string 							Path to the template file.
 */
function bs_swiper_locate_template($template_name, $template_path = '', $default_path = '') {

  // Set default plugin templates path.
  if (!$default_path) :
    $default_path = plugin_dir_path(__FILE__) . 'templates/'; // Path to the template folder
  endif;

  // Check if 'bs-swiper/' exists in the theme.
  $bs_swiper_path = get_theme_file_path('bs-swiper/' . $template_name);
  if (file_exists($bs_swiper_path)) {
    return $bs_swiper_path;
  }

  // Check if 'bs-swiper-main/' exists in the theme.
  // Fallback for existing 'bs-swiper-main/' folders in child theme
  $bs_swiper_main_path = get_theme_file_path('bs-swiper-main/' . $template_name);
  if (file_exists($bs_swiper_main_path)) {
    return $bs_swiper_main_path;
  }

  // If neither 'bs-swiper/' nor 'bs-swiper-main/' exists, return the default path.
  return $default_path . $template_name;
}


/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @since 1.0.0
 *
 * @see bs_swiper_locate_template()
 *
 * @param string 	$template_name			Template to load.
 * @param array 	$args					Args passed for the template file.
 * @param string 	$string $template_path	Path to templates.
 * @param string	$default_path			Default path to template files.
 */
function bs_swiper_get_template($template_name, $args = array(), $tempate_path = '', $default_path = '') {

  if (is_array($args) && isset($args)) :
    extract($args);
  endif;

  $template_file = bs_swiper_locate_template($template_name, $tempate_path, $default_path);

  if (!file_exists($template_file)) :
    _doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $template_file), '1.0.0');
    return;
  endif;

  include $template_file;
}


/**
 * Templates.
 *
 * This func tion will output the templates
 * file from the /templates.
 *
 * @since 1.0.0
 */

// Cards
function bs_swiper_card() {
  return bs_swiper_get_template('sc-swiper-card.php');
}
add_action('wp_head', 'bs_swiper_card');


// Cards Autoplay
function bs_swiper_card_autoplay() {
  return bs_swiper_get_template('sc-swiper-card-autoplay.php');
}
add_action('wp_head', 'bs_swiper_card_autoplay');


// Products
function bs_swiper_card_product() {
  return bs_swiper_get_template('sc-swiper-card-product.php');
}
add_action('wp_head', 'bs_swiper_card_product');


// Heroes
function bs_swiper_hero() {
  return bs_swiper_get_template('sc-swiper-hero.php');
}
add_action('wp_head', 'bs_swiper_hero');


// Heroes Fade
function bs_swiper_hero_fade() {
  return bs_swiper_get_template('sc-swiper-hero-fade.php');
}
add_action('wp_head', 'bs_swiper_hero_fade');


// Related Posts
function bs_swiper_related_posts() {
  return bs_swiper_get_template('related-posts.php');
}
add_action('wp_head', 'bs_swiper_related_posts');
