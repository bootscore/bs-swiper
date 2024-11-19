<?php

/*
 *
 * Adds related posts to single-*.php. Needs at least  Bootscore 5.3.1
 *
 * This template can be overridden by copying this file to your-theme/bs-swiper/related-posts.php
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  5.8.7
 *
*/


// Exit if accessed directly
defined( 'ABSPATH' ) || exit;


// Related posts
function bootscore_related_posts() {
  
  // Check if the user wants to disable related posts
  $disable_related_posts = apply_filters('bootscore_disable_related_posts', false);

  // If the filter is set to true, exit the function
  if ($disable_related_posts) {
    return;
  }

  $post_id = get_the_ID();
  $cat_ids = array();
  $categories = get_the_category($post_id);

  if (!empty($categories) && !is_wp_error($categories)) :
    foreach ($categories as $category) :
      array_push($cat_ids, $category->term_id);
    endforeach;
  endif;

  $current_post_type = get_post_type($post_id);

  $query_args = array(
    'category__in'   => $cat_ids,
    'post_type'      => $current_post_type,
    'post_status'    => 'publish',
    'post__not_in'   => array($post_id),
    'posts_per_page' => '12',
  );

  $related_cats_post = new WP_Query($query_args);

  // Check if there are related posts
  if ($related_cats_post->have_posts()) :
    ?>
    <div class="related-posts border-top mb-3">
      <h2 class="h4 text-center my-4"><?= apply_filters('bootscore/bs-swiper/related-posts/heading', __('You might also like', 'bootscore')); ?></h2>
      <div class="px-lg-5 position-relative">
        <div class="cards swiper-container swiper position-static">
          <div class="swiper-wrapper">

            <?php
            while ($related_cats_post->have_posts()) : $related_cats_post->the_post();
            ?>

              <div class="swiper-slide card h-auto mb-5">

                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                <?php endif; ?>

                <div class="card-body d-flex flex-column">

                  <?php the_title('<h3 class="card-title h6 text-truncate">', '</h3>'); ?>

                  <p class="card-text small text-truncate">
                    <?= strip_tags(get_the_excerpt()); ?>
                  </p>

                  <p class="card-text small mt-auto">
                    <a class="read-more stretched-link" href="<?php the_permalink(); ?>">
                      <?php _e('Read more »', 'bootscore'); ?>
                    </a>
                  </p>

                </div>

              </div><!-- .card -->

            <?php endwhile; ?>

          </div><!-- .swiper-wrapper -->

          <!-- Add Pagination -->
          <div class="swiper-pagination"></div>
          <!-- Add Arrows -->
          <div class="swiper-button-next end-0 d-none d-lg-block"></div>
          <div class="swiper-button-prev start-0 d-none d-lg-block"></div>

        </div><!-- .swiper-container -->
      </div><!-- .px-lg-5.position-relative -->
    </div><!-- .related-posts -->
    <?php
    // Restore original Post Data
    wp_reset_postdata();
  endif;
}
