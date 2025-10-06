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
 * Register styles and scripts
 */
function swiper_scripts() {
  // File paths
  $swiper_js      = plugin_dir_path(__FILE__) . 'assets/js/swiper-bundle.min.js';
  $swiper_init_js = plugin_dir_path(__FILE__) . 'assets/js/swiper-init.min.js';
  $swiper_css     = plugin_dir_path(__FILE__) . 'assets/css/swiper-bundle.min.css';
  $swiper_style   = plugin_dir_path(__FILE__) . 'assets/css/swiper-style.min.css';

  // Versions based on file modification time
  $swiper_js_ver      = file_exists($swiper_js) ? date('YmdHi', filemtime($swiper_js)) : false;
  $swiper_init_js_ver = file_exists($swiper_init_js) ? date('YmdHi', filemtime($swiper_init_js)) : false;
  $swiper_css_ver     = file_exists($swiper_css) ? date('YmdHi', filemtime($swiper_css)) : false;
  $swiper_style_ver   = file_exists($swiper_style) ? date('YmdHi', filemtime($swiper_style)) : false;

  // Enqueue scripts with versioning
  wp_enqueue_script('swiper-min-js', plugins_url('/assets/js/swiper-bundle.min.js', __FILE__), [], $swiper_js_ver, true);
  wp_enqueue_script('swiper-init-js', plugins_url('/assets/js/swiper-init.min.js', __FILE__), [], $swiper_init_js_ver, true);

  // Enqueue styles with versioning
  wp_enqueue_style('swiper-min-css', plugins_url('/assets/css/swiper-bundle.min.css', __FILE__), [], $swiper_css_ver);
  wp_enqueue_style('swiper-style-css', plugins_url('/assets/css/swiper-style.min.css', __FILE__), [], $swiper_style_ver);
}

add_action('wp_enqueue_scripts', 'swiper_scripts');


/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/bs-swiper/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/bs-swiper/templates/$template_name.
 *
 * @since 1.0.0
 *
 * @param 	string 	$template_name			Template to load.
 * @param 	string 	$string $template_path	Path to templates.
 * @param 	string	$default_path			Default path to template files.
 * @return 	string 							Path to the template file.
 */
function bs_swiper_locate_template($template_name, $template_path = '', $default_path = '') {

  // Set variable to search in bs-swiper folder of theme.
  if (!$template_path) :
    $template_path = 'bs-swiper/';
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
 * @since 6.0.0
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

