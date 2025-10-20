<?php

/**
 * Columns Slider Shortcode
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  6.0.0
 */
 
 
// Exit if accessed directly
defined('ABSPATH') || exit;


/**
 * Swiper Shortcode
 *
 * Usage:
 * [bs-swiper layout="columns" type="post" posts="6"]
 * [bs-swiper layout="columns" type="product" posts="8"]
 * [bs-swiper layout="columns" type="product" featured="true" onsale="true" outofstock="false"]
 * [bs-swiper layout="heroes" type="post" effect="fade"]
 * [bs-swiper layout="heroes" type="product" effect="coverflow"]
 * [bs-swiper layout="columns" type="post" effect="auto" slidesperview="auto"]
 */
add_shortcode('bs-swiper', 'bootscore_swiper');
function bootscore_swiper($atts) {
  ob_start();

  $atts = shortcode_atts(array(
    'layout'        => 'columns', // new: columns, heroes
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
    'navigation'    => 'true',
    'pagination'    => 'true',
    'slidesperview' => '',      // Works for both layouts now
    'loop'          => 'false',
    'autoplay'      => 'false',
    'delay'         => '4000',
    'spacebetween'  => '',      // Conditional defaults
    'effect'        => 'slide', // Works for both layouts now
    'speed'         => '300',
    'context'       => '',
    // WooCommerce-specific parameters
    'featured'      => '',      // Show only featured products
    'outofstock'    => '',      // Hide out of stock products (default behavior)
    'onsale'        => '',      // Show only on-sale products
    'showhidden'    => 'false', // Show products hidden from catalog
  ), $atts);

  // Set conditional defaults based on layout
  if ($atts['layout'] === 'heroes') {
    if (empty($atts['spacebetween'])) {
      $atts['spacebetween'] = '0'; // Default for heroes
    }
  } else {
    // columns layout defaults
    if (empty($atts['spacebetween'])) {
      $atts['spacebetween'] = '24'; // Default for columns
    }
  }

  // Store context globally for filters
  $GLOBALS['bs_swiper_context'] = $atts['context'];

  $options = array(
    'post_type'      => sanitize_text_field($atts['type']),
    'order'          => sanitize_text_field($atts['order']),
    'orderby'        => sanitize_text_field($atts['orderby']),
    'posts_per_page' => is_numeric($atts['posts']) ? (int) $atts['posts'] : -1,
    'category_name'  => sanitize_text_field($atts['category']),
    'post_parent'    => is_numeric($atts['post_parent']) ? (int) $atts['post_parent'] : '',
  );

  // WooCommerce-specific handling
  if ($atts['type'] === 'product') {
    
    // Initialize tax_query array if needed
    if (!isset($options['tax_query'])) {
      $options['tax_query'] = array();
    }
    
    // Hide products excluded from catalog (unless showhidden is true)
    if ($atts['showhidden'] !== 'true') {
      $options['tax_query'][] = array(
        'taxonomy' => 'product_visibility',
        'field'    => 'slug',
        'terms'    => 'exclude-from-catalog',
        'operator' => 'NOT IN',
      );
    }
    
    // Featured products filter
    if ($atts['featured'] === 'true') {
      $options['tax_query'][] = array(
        'taxonomy' => 'product_visibility',
        'field'    => 'slug',
        'terms'    => 'featured',
        'operator' => 'IN',
      );
    }
    
    // Out of stock filter (hide by default if outofstock is not 'true')
    if ($atts['outofstock'] !== 'true') {
      if (!isset($options['meta_query'])) {
        $options['meta_query'] = array();
      }
      $options['meta_query'][] = array(
        'key'     => '_stock_status',
        'value'   => 'instock',
        'compare' => '=',
      );
    }
    
    // On-sale filter (use WooCommerce helper instead of meta_query)
    if ($atts['onsale'] === 'true') {
      $onsale_ids = wc_get_product_ids_on_sale();
      
      // If post__in already exists (from id parameter), intersect with on-sale IDs
      if (!empty($options['post__in'])) {
        $options['post__in'] = array_intersect($options['post__in'], $onsale_ids);
      } else {
        $options['post__in'] = $onsale_ids;
      }
    }
    
    // Use product_cat instead of category_name for products
    if (!empty($atts['category'])) {
      unset($options['category_name']);
      $options['tax_query'][] = array(
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => sanitize_text_field($atts['category']),
      );
    }
  }

  // Handle taxonomy query
  $tax = trim(sanitize_text_field($atts['tax']));
  $terms = trim(sanitize_text_field($atts['terms']));
  if ($tax != '' && $terms != '') {
    $terms = array_map('trim', explode(',', $terms));
    $terms = array_filter($terms);
    $terms = array_unique($terms);
    
    if (!isset($options['tax_query'])) {
      $options['tax_query'] = array();
    }
    
    unset($options['category_name']);
    $options['tax_query'][] = array(
      'taxonomy' => $tax,
      'field'    => 'slug',
      'terms'    => $terms,
    );
  }

  // Handle specific post IDs
  if (!empty($atts['id'])) {
    $ids = array_map('intval', explode(',', $atts['id']));
    $ids = array_filter($ids);
    $ids = array_unique($ids);
    
    // If post__in already exists (from onsale), intersect
    if (!empty($options['post__in'])) {
      $options['post__in'] = array_intersect($options['post__in'], $ids);
    } else {
      $options['post__in'] = $ids;
    }
  }

  // Handle slidesperview attribute for both layouts
  $breakpoints = [];
  $bps = [0, 576, 768, 992, 1200, 1400];

  // Handle effect parameter for both layouts
  $allowed_effects = array('slide', 'fade', 'cube', 'coverflow', 'flip', 'cards', 'creative', 'auto');
  $effect = in_array(strtolower($atts['effect']), $allowed_effects) ? strtolower($atts['effect']) : 'slide';

  // Effects that require slidesPerView: 1
  $single_slide_effects = array('fade', 'cube', 'flip', 'cards');

  if (!empty($atts['slidesperview'])) {
    // Check if effect requires single slide
    if (in_array($effect, $single_slide_effects)) {
      // Force slidesPerView to 1 for all breakpoints
      foreach ($bps as $bp) {
        $breakpoints[$bp] = ['slidesPerView' => 1];
      }
    } else {
      // Check if slidesperview is 'auto'
      if ($atts['slidesperview'] === 'auto') {
        // Set all breakpoints to 'auto'
        foreach ($bps as $bp) {
          $breakpoints[$bp] = ['slidesPerView' => 'auto'];
        }
      } else {
        // Handle comma-separated values
        $slidesperview = array_map('trim', explode(',', $atts['slidesperview']));
        foreach ($slidesperview as $i => $val) {
          if (isset($bps[$i])) {
            // Check if individual value is 'auto'
            $breakpoints[$bps[$i]] = ['slidesPerView' => $val === 'auto' ? 'auto' : (int)$val];
          }
        }
      }
    }
  } else {
    // Default breakpoints based on effect first, then layout
    if (in_array($effect, $single_slide_effects)) {
      // Force single slide for these effects
      $breakpoints = [
        0    => ['slidesPerView' => 1],
        576  => ['slidesPerView' => 1],
        768  => ['slidesPerView' => 1],
        992  => ['slidesPerView' => 1],
        1200 => ['slidesPerView' => 1],
        1400 => ['slidesPerView' => 1],
      ];
    } elseif ($atts['layout'] === 'heroes') {
      $breakpoints = [
        0    => ['slidesPerView' => 1],
        576  => ['slidesPerView' => 1],
        768  => ['slidesPerView' => 1],
        992  => ['slidesPerView' => 1],
        1200 => ['slidesPerView' => 1],
        1400 => ['slidesPerView' => 1],
      ];
    } else {
      // columns layout defaults
      $breakpoints = [
        0    => ['slidesPerView' => 1],
        576  => ['slidesPerView' => 1],
        768  => ['slidesPerView' => 2],
        992  => ['slidesPerView' => 3],
        1200 => ['slidesPerView' => 4],
        1400 => ['slidesPerView' => 4],
      ];
    }
  }

  // Handle parameters
  $loop = ($atts['loop'] === 'true');
  $autoplay = ($atts['autoplay'] === 'true');
  $delay = is_numeric($atts['delay']) ? (int) $atts['delay'] : 4000;
  $spaceBetween = is_numeric($atts['spacebetween']) ? (int) $atts['spacebetween'] : ($atts['layout'] === 'heroes' ? 0 : 24);
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
    $wrapper_classes = 'bs-swiper-wrapper bs-swiper-' . $atts['layout'];
    $wrapper_classes .= ' ' . apply_filters('bootscore/bs-swiper/class/wrapper', 'position-relative mb-3', 'bs-swiper-columns');

    // Add woocommerce class if type is product
    if ($atts['type'] === 'product') {
        $wrapper_classes .= ' woocommerce';
    }

    // Add px-5 padding ONLY for columns layout
    if ($atts['layout'] === 'columns' && $atts['navigation'] === 'true') {
      $wrapper_classes .= ' ' . apply_filters('bootscore/bs-swiper/class/wrapper/padding-x', 'px-5', 'bs-swiper-columns');
    }

    //if ($atts['pagination'] === 'true') {
    if ($atts['layout'] === 'columns' && $atts['pagination'] === 'true') {
      $wrapper_classes .= ' ' . apply_filters('bootscore/bs-swiper/class/wrapper/padding-bottom', 'pb-5', 'bs-swiper-columns');
    }

    // Add context as data attribute if provided
    $wrapper_attributes = '';
    if (!empty($atts['context'])) {
      $wrapper_attributes = ' data-context="' . esc_attr($atts['context']) . '"';
    }
    ?>

    <div class="<?= $wrapper_classes ?>"<?= $wrapper_attributes ?>>
      
      <!-- Main Swiper Container -->
      <div class="swiper bs-swiper-container" 
           data-swiper-breakpoints="<?= $data_breakpoints; ?>"
           data-swiper-loop="<?= $data_loop; ?>"
           data-swiper-autoplay="<?= $data_autoplay; ?>"
           data-swiper-delay="<?= $data_delay; ?>"
           data-swiper-spacebetween="<?= $data_spacebetween; ?>"
           data-swiper-effect="<?= $data_effect; ?>"
           data-swiper-speed="<?= $data_speed; ?>">
        <div class="swiper-wrapper">

          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php
            // Determine template based on layout and type
            $template_suffix = '';
            $template_name = $atts['layout']; // columns or heroes
            
            if ($atts['type'] === 'product') {
                $template_suffix = '-wc-products';
            }
            
            $template_file = $template_name . $template_suffix . '.php';
            
            // Load template (allow child/theme override in /bs-swiper/)
            bs_swiper_get_template($template_file, array('atts_local' => $atts));
            ?>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>

      <!-- Navigation and Pagination -->
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
