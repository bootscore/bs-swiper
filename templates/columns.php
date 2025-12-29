<?php
/**
 * Template: Swiper Columns (Default Post)
 * Context: Used by [bs-swiper-columns] shortcode for non-product posts.
 *
 * @var array $atts_local
 *
 * This template can be overriden by copying this file to your-theme/bs-swiper/columns.php
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  6.0.0
 */

  // Exit if accessed directly
  defined( 'ABSPATH' ) || exit;

?>
<article class="swiper-slide <?= apply_filters('bootscore/class/loop/card', 'card h-auto', 'bs-swiper-columns'); ?>">

  <?php do_action('bootscore_before_loop_thumbnail', 'bs-swiper-columns'); ?>

  <?php if (has_post_thumbnail()) : ?>
    <a href="<?php the_permalink(); ?>">
      <?php the_post_thumbnail('medium', array('class' => apply_filters('bootscore/class/loop/card/image', 'card-img-top', 'bs-swiper-columns'))); ?>
    </a>
  <?php endif; ?>

  <?php do_action('bootscore_after_loop_thumbnail', 'bs-swiper-columns'); ?>

  <div class="<?= apply_filters('bootscore/class/loop/card/body', 'card-body d-flex flex-column', 'bs-swiper-columns'); ?>">

    <?php if ($atts_local['categories'] === 'true') : bootscore_category_badge(); endif; ?>

    <?php do_action('bootscore_before_loop_title', 'bs-swiper-columns'); ?>

    <a class="<?= apply_filters('bootscore/class/loop/card/title/link', 'text-body text-decoration-none', 'bs-swiper-columns'); ?>" href="<?php the_permalink(); ?>">
      <?php the_title('<h2 class="' . apply_filters('bootscore/class/loop/card/title', 'blog-post-title h5', 'bs-swiper-columns') . '">', '</h2>'); ?>
    </a>

    <?php do_action('bootscore_after_loop_title', 'bs-swiper-columns'); ?>

    <?php if ($atts_local['meta'] === 'true' && get_post_type() === 'post') : ?>
      <p class="meta small mb-2 text-body-secondary">
        <?php
          bootscore_date();
          bootscore_author();
          bootscore_comments();
          bootscore_edit();
        ?>
      </p>
    <?php endif; ?>

    <?php if ($atts_local['excerpt'] === 'true') : ?>
      <p class="<?= apply_filters('bootscore/class/loop/card-text/excerpt', 'card-text', 'bs-swiper-columns'); ?>">
        <a class="<?= apply_filters('bootscore/class/loop/card-text/excerpt/link', 'text-body text-decoration-none', 'bs-swiper-columns'); ?>" href="<?php the_permalink(); ?>">
          <?= strip_tags(get_the_excerpt()); ?>
        </a>
      </p>
    <?php endif; ?>

    <?php if ($atts_local['readmore'] === 'true') : ?>
      <p class="<?= apply_filters('bootscore/class/loop/card-text/read-more', 'card-text mt-auto', 'bs-swiper-columns'); ?>">
        <a class="<?= apply_filters('bootscore/class/loop/read-more', 'read-more', 'bs-swiper-columns'); ?>" href="<?php the_permalink(); ?>">
          <?= apply_filters('bootscore/loop/read-more/text', __('Read more »', 'bootscore')); ?>
        </a>
      </p>
    <?php endif; ?>

    <?php if ($atts_local['tags'] === 'true') : bootscore_tags(); endif; ?>

    <?php do_action('bootscore_after_loop_tags', 'bs-swiper-columns'); ?>

  </div>

  <?php do_action('bootscore_loop_item_after_card_body', 'bs-swiper-columns'); ?>

</article>
