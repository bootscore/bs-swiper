<?php
/**
 * Template: Swiper Heroes (Default Post)
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

<div class="swiper-slide h-100 bg-dark">

<!-- Featured Image-->
<?php the_post_thumbnail('full', array('class' => 'swiper-hero-img')); ?>

<div class="position-absolute top-0 end-0 bottom-0 start-0">

  <div class="container h-100 d-flex justify-content-center align-items-end">

    <div class="text-white mb-5 text-center">

      <?php if ($atts['categories'] == 'true') : ?>
        <?php bootscore_category_badge(); ?>
      <?php endif; ?>

      <!-- Title -->
      <h2 class="blog-post-title h5">
        <a class="text-white text-decoration-none" href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
        </a>
      </h2>

      <!-- Excerpt & Read more -->
      <?php if ($atts['excerpt'] == 'true') : ?>
        <p class="card-text">
          <a class="text-white text-decoration-none" href="<?php the_permalink(); ?>">
            <?= strip_tags(get_the_excerpt()); ?>
          </a>
        </p>
      <?php endif; ?>

      <p class="card-text">
        <a class="read-more btn btn-sm btn-light" href="<?php the_permalink(); ?>"><?php _e('Read more »', 'bootscore'); ?></a>
      </p>

      <!-- Tags -->
      <?php if ($atts['tags'] == 'true') : ?>
        <?php bootscore_tags(); ?>
      <?php endif; ?>

    </div>
  </div>

</div>

</div><!-- .swiper-slide -->