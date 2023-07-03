<?php
/*
 * Adds related posts to single_*.php. Needs at least  bootScore 5.3.1
 *
 * This template can be overriden by copying this file to your-theme/bs-swiper-main/related-posts.php
 *
 * @author 		bootScore
 * @package 	bS Swiper
 * @version   5.3.0
*/

function bootscore_related_posts()
{

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
    'post__not_in'    => array($post_id),
    'posts_per_page'  => '12',
  );

  $related_cats_post = new WP_Query($query_args);
?>

  <div class="related-posts mb-3">
    <hr>
    <h2 class="h4 text-center my-4"><?php _e('You might also like', 'bootscore'); ?></h2>
    <div class="px-lg-5 position-relative">
      <div class="cards swiper-container swiper position-static">
        <div class="swiper-wrapper">

          <?php
          if ($related_cats_post->have_posts()) :
            while ($related_cats_post->have_posts()) : $related_cats_post->the_post();
          ?>

              <div class="swiper-slide card h-auto mb-5">
                <!-- Featured Image-->
                <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                <div class="card-body d-flex flex-column">
                  <!-- Title -->
                  <a class="stretched-link text-body text-decoration-none" href="<?php the_permalink(); ?>">
                    <h3 class="h6 blog-post-title mb-0">
                      <?php the_title(); ?>
                    </h3>
                  </a>
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
