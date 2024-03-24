<?php

/*
 *
 * Post/Page/CPT Hero fade slider template.
 *
 * This template can be overriden by copying this file to your-theme/bs-swiper/sc-swiper-hero.php
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  5.7.2
 *
 * Posts: 
 * [bs-swiper-hero-fade type="post" category="cars, boats" order="ASC" orderby="date" posts="6"]
 *
 * Child-pages: 
 * [bs-swiper-hero-fade type="page" post_parent="21" order="ASC" orderby="title" posts="6"]
 *
 * Custom post types:
 * [bs-swiper-hero-fade type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]
 *
 * Single items:
 * [bs-swiper-hero-fade type="post" id="1, 15"]
 * [bs-swiper-hero-fade type="page" id="2, 25"]
 * [bs-swiper-hero-fade type="isotope" id="33, 31"]
 * 
 * Optional:
 * Add the following attributes to disable excerpt, tags, or categories
 * excerpt="false"
 * tags="false"
 * categories="false"
 *
*/


// Exit if accessed directly
defined( 'ABSPATH' ) || exit;


// Hero Slider Shortcode
add_shortcode('bs-swiper-hero-fade', 'bootscore_swiper_hero_fade');
function bootscore_swiper_hero_fade($atts) {

  ob_start();
  $atts = shortcode_atts(array(
    'type'        => 'post',
    'post_status' => 'publish',
    'order'       => 'date',
    'orderby'     => 'date',
    'posts'       => -1,
    'category'    => '',
    'post_parent' => '',
    'tax'         => '',
    'terms'       => '',
    'id'          => '',
    'excerpt'     => 'true',
    'tags'        => 'true',
    'categories'  => 'true',
  ), $atts);

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
  if ($tax != '' && $terms != '') {
    $terms = explode(',', $terms);
    $terms = array_map('trim', $terms);
    $terms = array_filter($terms);
    $terms = array_unique($terms);
    unset($options['category_name']);
    $options['tax_query'] = array(array(
      'taxonomy' => $tax,
      'field'    => 'slug',
      'terms'    => $terms,
    ));
  }

  if ($atts['id'] != '') {
    $ids = explode(',', sanitize_text_field($atts['id']));
    $ids = array_map('intval', $ids);
    $ids = array_filter($ids);
    $ids = array_unique($ids);
    $options['post__in'] = $ids;
  }

  $query = new WP_Query($options);
  if ($query->have_posts()) { ?>


    <!-- Swiper -->
    <div class="heroes-fade swiper-container swiper mb-4">

      <div class="swiper-wrapper">

        <?php while ($query->have_posts()) : $query->the_post(); ?>

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

        <?php endwhile;
        wp_reset_postdata(); ?>

      </div> <!-- .swiper-wrapper -->

      <!-- Add Pagination -->
      <div class="swiper-pagination"></div>
      <!-- Add Arrows -->
      <div class="swiper-button-next d-none d-lg-block"></div>
      <div class="swiper-button-prev d-none d-lg-block"></div>


    </div><!-- swiper-container -->
    <!-- Swiper End -->

<?php $myvariable = ob_get_clean();
    return $myvariable;
  }
}
