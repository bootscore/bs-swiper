<?php
/**
 * Template: Swiper Columns (WooCommerce Products)
 * Context: Used by [bs-swiper-columns type="product"]
 *
 * @var array $atts_local
 *
 * This template can be overriden by copying this file to your-theme/bs-swiper/columns-wc-productss.php
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  6.0.0
 */

  // Exit if accessed directly
  defined( 'ABSPATH' ) || exit;

?>
<div <?php wc_product_class('swiper-slide card h-auto d-flex text-center product-card'); ?>>

  <?php
  do_action('woocommerce_before_shop_loop_item');
  do_action('woocommerce_before_shop_loop_item_title');
  ?>

  <div class="card-body d-flex flex-column">
    <?php
      do_action('woocommerce_shop_loop_item_title');
      do_action('woocommerce_after_shop_loop_item_title');
      do_action('woocommerce_after_shop_loop_item');
    ?>
  </div>

</div>
