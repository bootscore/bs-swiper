<?php
/*Plugin Name: bS Swiper
Plugin URI: https://bootscore.me/plugins/bs-swiper/
Description: Plugin to show posts, pages, custom post types or WooCommerce products in a swiper.js carousel for bootScore theme. <a href="https://bootscore.me/documentation/bs-swiper/">Documentation</a> | <a href="https://bootscore.me/documentation/bs-swiper/#Changelog">Changelog</a>
Version: 5.4.0
Tested up to: 6.3.1
Requires at least: 5.0
Requires PHP: 7.4
Author: bootScore
Author URI: https://bootscore.me
License: MIT License
*/


// Exit if accessed directly
defined( 'ABSPATH' ) || exit;


/**
 * Update checker
 */
require 'update/update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
  'https://bootscore.me/wp-content/plugins/bs-swiper-main/update/plugin.json',
  __FILE__, //Full path to the main plugin file or functions.php.
  'bs-swiper-main'
);


/**
 * Register styles and scripts
 */
function swiper_scripts() {

  wp_enqueue_script('swiper-min-js', plugins_url('/js/swiper-bundle.min.js', __FILE__), array(), false, true);

  wp_enqueue_script('swiper-init-js', plugins_url('/js/swiper-init.js', __FILE__), array(), false, true);

  wp_register_style('swiper-min-css', plugins_url('css/swiper-bundle.min.css', __FILE__));
  wp_enqueue_style('swiper-min-css');

  wp_register_style('swiper-style-css', plugins_url('css/swiper-style.css', __FILE__));
  wp_enqueue_style('swiper-style-css');
}

add_action('wp_enqueue_scripts', 'swiper_scripts');


/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/bs-swiper-main/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/bs-swiper-main/templates/$template_name.
 *
 * @since 1.0.0
 *
 * @param 	string 	$template_name			Template to load.
 * @param 	string 	$string $template_path	Path to templates.
 * @param 	string	$default_path			Default path to template files.
 * @return 	string 							Path to the template file.
 */
function bs_swiper_locate_template($template_name, $template_path = '', $default_path = '') {

  // Set variable to search in bs-swiper-main folder of theme.
  if (!$template_path) :
    $template_path = 'bs-swiper-main/';
  endif;

  // Set default plugin templates path.
  if (!$default_path) :
    $default_path = plugin_dir_path(__FILE__) . 'templates/'; // Path to the template folder
  endif;

  // Search template file in theme folder.
  $template = locate_template(array(
    $template_path . $template_name,
    $template_name
  ));

  // Get plugins template file.
  if (!$template) :
    $template = $default_path . $template_name;
  endif;

  return apply_filters('bs_swiper_locate_template', $template, $template_name, $template_path, $default_path);
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
