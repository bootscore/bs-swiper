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
    $default_path = plugin_dir_path(__FILE__) . 'templates/'; // Path to the template folder
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
 * @since 1.0.0
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

/**
 * Column Slider Shortcode
 *
 * Usage:
 * [bs-swiper-columns type="post" posts="6"]
 * [bs-swiper-columns type="product" posts="8"]
 */
add_shortcode('bs-swiper-columns', 'bootscore_swiper');
function bootscore_swiper($atts) {
  ob_start();

  $atts = shortcode_atts(array(
    'type'          => 'post',
    'post_status'   => 'publish',
    'order'         => 'date',
    'orderby'       => 'date',
    'posts'         => -1,
    'category'      => '',
    'post_parent'   => '',
    'tax'           => '',
    'terms'         => '',
    'id'            => '',
    'categories'    => 'true',
    'meta'          => 'true',
    'excerpt'       => 'true',
    'readmore'      => 'true',
    'tags'          => 'true',
    'navigation'    => 'true',  // new shows/hides prev/next arrows
    'pagination'    => 'true',  // new shows/hides bullet pagination
    'slidesperview' => '',      // new attribute: e.g., "2,3,4,6"
    'loop'          => 'false', // new parameter: default false
    'autoplay'      => 'false', // new parameter: default false
    'delay'         => '4000',  // new parameter: default 4000ms
    'spacebetween'  => '24',    // 24px equal to default Bootstrap 1.5rem grid gutter
    'effect'        => 'slide', // new parameter: default slide
    'speed'         => '300',   // new parameter: default 300ms
    'context'       => '',      // new contextual filters
  ), $atts);

  // Store context globally for filters, if needed
  $GLOBALS['bs_swiper_context'] = $atts['context'];

  $context = $atts['context'];

  $options = array(
    'post_type'      => sanitize_text_field($atts['type']),
    'order'          => sanitize_text_field($atts['order']),
    'orderby'        => sanitize_text_field($atts['orderby']),
    'posts_per_page' => is_numeric($atts['posts']) ? (int) $atts['posts'] : -1,
    'category_name'  => sanitize_text_field($atts['category']),
    'post_parent'    => is_numeric($atts['post_parent']) ? (int) $atts['post_parent'] : '',
  );

  $tax = trim(sanitize_text_field($atts['tax']));
  $terms = trim(sanitize_text_field($atts['terms']));
  if ($tax && $terms) {
    $terms = array_map('trim', explode(',', $terms));
    $terms = array_filter($terms);
    $terms = array_unique($terms);
    unset($options['category_name']);
    $options['tax_query'] = array(array(
      'taxonomy' => $tax,
      'field'    => 'slug',
      'terms'    => $terms,
    ));
  }

  if (!empty($atts['id'])) {
    $ids = array_map('intval', explode(',', $atts['id']));
    $ids = array_filter($ids);
    $ids = array_unique($ids);
    $options['post__in'] = $ids;
  }

  // Handle slidesperview attribute and map to breakpoints
  $breakpoints = [];
  $bps = [0, 576, 768, 992, 1200, 1400]; // xs, sm, md, lg, xl, 2xl

  if (!empty($atts['slidesperview'])) {
    $slidesperview = array_map('intval', explode(',', $atts['slidesperview']));

    foreach ($slidesperview as $i => $val) {
      if (isset($bps[$i])) {
        $breakpoints[$bps[$i]] = ['slidesPerView' => $val];
      }
    }
  } else {
    // Default: 1 slide on xs/sm, 2 on md, 3 on lg, 4 on xl+, etc.
    $breakpoints = [
      0    => ['slidesPerView' => 1],
      576  => ['slidesPerView' => 1],
      768  => ['slidesPerView' => 2],
      992  => ['slidesPerView' => 3],
      1200 => ['slidesPerView' => 4],
      1400 => ['slidesPerView' => 4],
    ];
  }

  // Handle loop parameter
  $loop = ($atts['loop'] === 'true');
  
  // Handle autoplay parameters
  $autoplay = ($atts['autoplay'] === 'true');
  $delay = is_numeric($atts['delay']) ? (int) $atts['delay'] : 4000;

  // Handle spacebetween parameter
  $spaceBetween = is_numeric($atts['spacebetween']) ? (int) $atts['spacebetween'] : 20;

  // Handle effect parameter - validate against allowed effects
  $allowed_effects = array('slide', 'fade', 'cube', 'coverflow', 'flip', 'cards', 'creative');
  $effect = in_array(strtolower($atts['effect']), $allowed_effects) ? strtolower($atts['effect']) : 'slide';

  // Handle speed parameter
  $speed = is_numeric($atts['speed']) ? (int) $atts['speed'] : 300;

  $data_breakpoints = htmlspecialchars(json_encode($breakpoints), ENT_QUOTES, 'UTF-8');
  $data_loop = $loop ? 'true' : 'false';
  $data_autoplay = $autoplay ? 'true' : 'false';
  $data_delay = $delay;
  $data_spacebetween = $spaceBetween;
  $data_effect = $effect;
  $data_speed = $speed;

  $query = new WP_Query($options);
  if ($query->have_posts()) : ?>

    <!-- Swiper -->
    <?php
    // The wrapper is used to place navigation arrows outside the slides
    // @link https://stackoverflow.com/questions/41855877/css-how-to-have-swiper-slider-arrows-outside-of-slider-that-takes-up-12-column
    $wrapper_classes = 'bs-swiper-wrapper';
    $wrapper_classes .= ' ' . apply_filters('bootscore/bs-swiper/class/wrapper', 'position-relative mb-3', 'bs-swiper-columns');

    // Add woocommerce class if type is product
    if ($atts['type'] === 'product') {
        $wrapper_classes .= ' woocommerce';
    }

    if ($atts['navigation'] === 'true') {
      $wrapper_classes .= ' ' . apply_filters('bootscore/bs-swiper/class/wrapper/padding-x', 'px-5', 'bs-swiper-columns');
    }

    if ($atts['pagination'] === 'true') {
      $wrapper_classes .= ' ' . apply_filters('bootscore/bs-swiper/class/wrapper/padding-bottom', 'pb-5', 'bs-swiper-columns');
    }

    // Add context as data attribute if provided
    $wrapper_attributes = '';
    if (!empty($atts['context'])) {
      $wrapper_attributes = ' data-context="' . esc_attr($atts['context']) . '"';
    }
    ?>

    <div class="<?= $wrapper_classes ?>"<?= $wrapper_attributes ?>>
      
      <!-- Main Swiper Container - CLEANED UP -->
      <div class="bs-swiper-columns swiper" 
           data-swiper-breakpoints="<?= $data_breakpoints; ?>"
           data-swiper-loop="<?= $data_loop; ?>"
           data-swiper-autoplay="<?= $data_autoplay; ?>"
           data-swiper-delay="<?= $data_delay; ?>"
           data-swiper-spacebetween="<?= $data_spacebetween; ?>"
           data-swiper-effect="<?= $data_effect; ?>"
           data-swiper-speed="<?= $data_speed; ?>">
        <div class="swiper-wrapper">

          <?php while ($query->have_posts()) : $query->the_post(); ?>
              <?php if ($atts['type'] === 'product') : ?>
                  
                <!-- WooCommerce Product Template -->
                <?php
                  // Load product template (allow child/theme override in /bs-swiper/)
                  // Pass $atts as $atts_local to the template
                  bs_swiper_get_template('columns-wc-products.php', array('atts_local' => $atts));
                ?>
              <?php else : ?>
                  <!-- Default Post Template -->
                  <?php
                    // Load post template (allow child/theme override in /bs-swiper/)
                    // Pass $atts as $atts_local to the template
                    bs_swiper_get_template('columns.php', array('atts_local' => $atts));
                  ?>
              <?php endif; ?>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
      <!-- End Main Swiper Container -->

      <!-- Navigation and Pagination OUTSIDE the swiper container -->
      <?php if ($atts['pagination'] === 'true') : ?>
        <div class="swiper-pagination"></div>
      <?php endif; ?>
      
      <?php if ($atts['navigation'] === 'true') : ?>
        <div class="<?= apply_filters('bootscore/bs-swiper/class/navigation', '', 'bs-swiper-columns'); ?>">
          <div class="swiper-button-next end-0"></div>
          <div class="swiper-button-prev start-0"></div>
        </div>
      <?php endif; ?>
      
    </div>
    <!-- Swiper End -->

<?php
    return ob_get_clean();
  endif;
}