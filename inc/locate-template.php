<?php

/**
 * Locate template
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  6.0.0
 */


// Exit if accessed directly
defined('ABSPATH') || exit;


/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/bs-swiper/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/bs-swiper/templates/$template_name.
 *
 * @since 6.0.0
 *
 * @param  string  $template_name      Template to load.
 * @param  string  $template_path      Path to templates.
 * @param  string  $default_path       Default path to template files.
 * @return string                      Path to the template file.
 */
function bs_swiper_locate_template($template_name, $template_path = '', $default_path = '') {

  // Set variable to search in bs-swiper folder of theme.
  if (!$template_path) :
    $template_path = 'bs-swiper/';
  endif;

  // Set default plugin templates path.
  if (!$default_path) :
    // Go one directory up from /inc/
    $default_path = plugin_dir_path(__DIR__) . 'templates/'; // Correct default path
  endif;

  // Search template file in theme folder.
  $template = locate_template(array(
    trailingslashit($template_path) . $template_name,
    $template_name
  ));

  // Get plugin's template file if not found in theme.
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
 * @param string    $template_name     Template to load.
 * @param array     $args              Args passed for the template file.
 * @param string    $template_path     Path to templates.
 * @param string    $default_path      Default path to template files.
 */
function bs_swiper_get_template($template_name, $args = array(), $template_path = '', $default_path = '') {

  if (is_array($args) && isset($args)) :
    extract($args);
  endif;

  $template_file = bs_swiper_locate_template($template_name, $template_path, $default_path);

  if (!file_exists($template_file)) :
    _doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', esc_html($template_file)), '1.0.0');
    return;
  endif;

  include $template_file;
}
