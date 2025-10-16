<?php
/**
 * Template: Swiper Columns (WooCommerce Products)
 * Context: Used by [bs-swiper-columns type="product"]
 *
 * @var array $atts_local
 */

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
