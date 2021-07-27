<?php
/*Plugin Name: bS5 Swiper
Plugin URI: https://bootscore.me/plugins/bs-swiper/
Description: Post / Child Page / Product slider for bootScore 5 theme https://bootscore.me. Use Shortcode [bs-post-slider type="post" category="sample-category" order="ASC" orderby="title" posts="12"] to display posts, [bs-post-slider type="page" post_parent="1891" order="ASC" orderby="title" posts="6"] to display child pages or [bs-product-slider order="DESC" orderby="date" posts="12" category="theme, child-themes, free, plugins"] to show WooCommerce products. Check readme.txt in PlugIn folder for options.
Version: 5.0.0.0
Author: Bastian Kreiter
Author URI: https://crftwrk.de
License: GPLv2
*/


// Register Styles and Scripts
function swiper_scripts() {
    
    wp_enqueue_script( 'swiper-min-js', plugins_url( '/js/swiper-bundle.min.js' , __FILE__ ), array( 'jquery' ), '1.0', true );
    
    wp_enqueue_script( 'swiper-init-js', plugins_url( '/js/swiper-init.js' , __FILE__ ), array( 'jquery' ), '1.0', true );
    
    wp_register_style( 'swiper-min-css', plugins_url('css/swiper-bundle.min.css', __FILE__) );
    wp_enqueue_style( 'swiper-min-css' );
    
    wp_register_style( 'swiper-style-css', plugins_url('css/swiper-style.css', __FILE__) );
    wp_enqueue_style( 'swiper-style-css' );
    
    }

add_action('wp_enqueue_scripts','swiper_scripts');



/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/bs5-swiper/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/bs5-swiper/templates/$template_name.
 *
 * @since 1.0.0
 *
 * @param 	string 	$template_name			Template to load.
 * @param 	string 	$string $template_path	Path to templates.
 * @param 	string	$default_path			Default path to template files.
 * @return 	string 							Path to the template file.
 */
function bs_swiper_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	// Set variable to search in bs5-swiper folder of theme.
	if ( ! $template_path ) :
		$template_path = 'bs5-swiper/';
	endif;

	// Set default plugin templates path.
	if ( ! $default_path ) :
		$default_path = plugin_dir_path( __FILE__ ) . 'templates/'; // Path to the template folder
	endif;

	// Search template file in theme folder.
	$template = locate_template( array(
		$template_path . $template_name,
		$template_name
	) );

	// Get plugins template file.
	if ( ! $template ) :
		$template = $default_path . $template_name;
	endif;

	return apply_filters( 'bs_swiper_locate_template', $template, $template_name, $template_path, $default_path );

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
function bs_swiper_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {

	if ( is_array( $args ) && isset( $args ) ) :
		extract( $args );
	endif;

	$template_file = bs_swiper_locate_template( $template_name, $tempate_path, $default_path );

	if ( ! file_exists( $template_file ) ) :
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
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

function bs_swiper_card() {

	return bs_swiper_get_template( 'sc-swiper-card.php' );

}
add_action('wp_head', 'bs_swiper_card');


function bs_swiper_card_product() {

    return bs_swiper_get_template( 'sc-swiper-card-product.php' );

}
add_action('wp_head', 'bs_swiper_card_product');


function bs_swiper_hero() {

    return bs_swiper_get_template( 'sc-swiper-hero.php' );

}
add_action('wp_head', 'bs_swiper_hero');

