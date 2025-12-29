<?php

/**
 * Locate templates
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  5.8.12
 */


// Exit if accessed directly
defined('ABSPATH') || exit;


/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/bs-swiper/$template_name
 * 2. /themes/theme/bs-swiper-main/$template_name
 * 3. /themes/theme/$template_name
 * 4. /plugins/bs-swiper-main/templates/$template_name
 *
 * @since 5.7.0
 *
 * @param string $template_name Template to load.
 * @param string $template_path Path to templates.
 * @param string $default_path  Default path to template files.
 * @return string               Path to the template file.
 */
function bs_swiper_locate_template( $template_name, $template_path = '', $default_path = '' ) {

  // Set default plugin templates path (plugin root!)
  if ( ! $default_path ) {
    $default_path = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/';
  }

  // 1. /theme/bs-swiper/
  $bs_swiper_path = get_theme_file_path( 'bs-swiper/' . $template_name );
  if ( file_exists( $bs_swiper_path ) ) {
    return $bs_swiper_path;
  }

  // 2. /theme/bs-swiper-main/ (legacy fallback)
  $bs_swiper_main_path = get_theme_file_path( 'bs-swiper-main/' . $template_name );
  if ( file_exists( $bs_swiper_main_path ) ) {
    return $bs_swiper_main_path;
  }

  // 3. Plugin templates
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
 * @param string $template_name Template to load.
 * @param array  $args          Args passed to the template.
 * @param string $template_path Path to templates.
 * @param string $default_path  Default path to template files.
 */
function bs_swiper_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

  if ( is_array( $args ) && ! empty( $args ) ) {
    extract( $args, EXTR_SKIP );
  }

  $template_file = bs_swiper_locate_template( $template_name, $template_path, $default_path );

  if ( ! file_exists( $template_file ) ) {
    _doing_it_wrong(
      __FUNCTION__,
      sprintf( '<code>%s</code> does not exist.', esc_html( $template_file ) ),
      '1.0.0'
    );
    return;
  }

  include $template_file;
}


/**
 * Templates output.
 *
 * These functions include template files from /templates.
 *
 * @since 1.0.0
 */

// Cards
function bs_swiper_card() {
  bs_swiper_get_template( 'sc-swiper-card.php' );
}
add_action( 'wp_head', 'bs_swiper_card' );

// Cards Autoplay
function bs_swiper_card_autoplay() {
  bs_swiper_get_template( 'sc-swiper-card-autoplay.php' );
}
add_action( 'wp_head', 'bs_swiper_card_autoplay' );

// Products
function bs_swiper_card_product() {
  bs_swiper_get_template( 'sc-swiper-card-product.php' );
}
add_action( 'wp_head', 'bs_swiper_card_product' );

// Heroes
function bs_swiper_hero() {
  bs_swiper_get_template( 'sc-swiper-hero.php' );
}
add_action( 'wp_head', 'bs_swiper_hero' );

// Heroes Fade
function bs_swiper_hero_fade() {
  bs_swiper_get_template( 'sc-swiper-hero-fade.php' );
}
add_action( 'wp_head', 'bs_swiper_hero_fade' );

// Related Posts
function bs_swiper_related_posts() {
  bs_swiper_get_template( 'related-posts.php' );
}
add_action( 'wp_head', 'bs_swiper_related_posts' );
