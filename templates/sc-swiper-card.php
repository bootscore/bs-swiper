<?php

/*
 *
 * Post/Page/CPT Card slider template.
 *
 * This template can be overriden by copying this file to your-theme/bs-swiper/sc-swiper-card.php
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  5.7.2
 *
 * Posts: 
 * [bs-swiper-card type="post" category="cars, boats" order="ASC" orderby="date" posts="6"]
 *
 * Child-pages: 
 * [bs-swiper-card type="page" post_parent="21" order="ASC" orderby="title" posts="6"]
 *
 * Custom post types:
 * [bs-swiper-card type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]
 *
 * Single items:
 * [bs-swiper-card type="post" id="1, 15"]
 * [bs-swiper-card type="page" id="2, 25"]
 * [bs-swiper-card type="isotope" id="33, 31"]
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


// Card Slider Shortcode
add_shortcode('bs-swiper-card', 'bootscore_swiper');
function bootscore_swiper($atts) {

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
    <div class="px-5 position-relative">

      <div class="cards swiper-container swiper position-static">

        <div class="swiper-wrapper">

          <?php while ($query->have_posts()) : $query->the_post(); ?>

            <div class="swiper-slide card h-auto mb-5">

              <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                </a>
              <?php endif; ?>

              <div class="card-body d-flex flex-column">

                <?php if ($atts['categories'] == 'true') : ?>
                  <?php bootscore_category_badge(); ?>
                <?php endif; ?>

                <a class="text-body text-decoration-none" href="<?php the_permalink(); ?>">
                  <?php the_title('<h2 class="blog-post-title h5">', '</h2>'); ?>
                </a>

                <?php if ('post' === get_post_type()) : ?>
                  <p class="meta small mb-2 text-body-secondary">
                    <?php
                      bootscore_date();
                      bootscore_author();
                      bootscore_comments();
                      bootscore_edit();
                    ?>
                  </p>
                <?php endif; ?>

                <?php if ($atts['excerpt'] == 'true') : ?>
                  <p class="card-text">
                    <a class="text-body text-decoration-none" href="<?php the_permalink(); ?>">
                      <?= strip_tags(get_the_excerpt()); ?>
                    </a>
                  </p>
                <?php endif; ?>

                <p class="card-text mt-auto">
                  <a class="read-more" href="<?php the_permalink(); ?>">
                    <?php _e('Read more »', 'bootscore'); ?>
                  </a>
                </p>

                <?php if ($atts['tags'] == 'true') : ?>
                  <?php bootscore_tags(); ?>
                <?php endif; ?>

              </div>

            </div><!-- .card -->

          <?php endwhile;
          wp_reset_postdata(); ?>

        </div> <!-- .swiper-wrapper -->

        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next end-0"></div>
        <div class="swiper-button-prev start-0"></div>

      </div><!-- swiper-container -->

    </div>
    <!-- Swiper End -->

<?php $myvariable = ob_get_clean();
    return $myvariable;
  }
}
