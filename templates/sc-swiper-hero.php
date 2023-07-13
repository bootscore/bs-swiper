<?php
/*

 * Post/Page/CPT Hero slider template.
 *
 * This template can be overriden by copying this file to your-theme/bs-swiper-main/sc-swiper-hero.php
 *
 * @author 		bootScore
 * @package 	bS Swiper
 * @version     5.2.0

Posts: 
[bs-swiper-hero type="post" category="cars, boats" order="ASC" orderby="date" posts="6"]

Child-pages: 
[bs-swiper-hero type="page" post_parent="21" order="ASC" orderby="title" posts="6"]

Custom post types:
[bs-swiper-hero type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]

Single items:
[bs-swiper-hero type="post" id="1, 15"]
[bs-swiper-hero type="page" id="2, 25"]
[bs-swiper-hero type="isotope" id="33, 31"]
*/


// Hero Slider Shortcode
add_shortcode('bs-swiper-hero', 'bootscore_swiper_hero');
function bootscore_swiper_hero($atts) {

  ob_start();
  extract(shortcode_atts(array(
    'type' => 'post',
    'order' => 'date',
    'orderby' => 'date',
    'posts' => -1,
    'category' => '',
    'post_parent'    => '',
    'tax' => '',
    'terms' => '',
    'id' => ''
  ), $atts));

  $options = array(
    'post_type' => $type,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
    'category_name' => $category,
    'post_parent' => $post_parent,
  );

  $tax = trim($tax);
  $terms = trim($terms);
  if ($tax != '' && $terms != '') {
    $terms = explode(',', $terms);
    $terms = array_map('trim', $terms);
    $terms = array_filter($terms);
    $terms = array_unique($terms);
    unset($options['category_name']);
    $options['tax_query'] = array(array(
      'taxonomy' => $tax,
      'field'    => 'name',
      'terms'    => $terms,
    ));
  }

  if ($id != '') {
    $ids = explode(',', $id);
    $ids = array_map('intval', $ids);
    $ids = array_filter($ids);
    $ids = array_unique($ids);
    $options['post__in'] = $ids;
  }

  $query = new WP_Query($options);
  if ($query->have_posts()) { ?>


    <!-- Swiper -->
    <div class="heroes swiper-container swiper mb-4">

      <div class="swiper-wrapper">

        <?php while ($query->have_posts()) : $query->the_post(); ?>

          <div class="swiper-slide h-100 bg-dark">

            <!-- Featured Image-->
            <?php the_post_thumbnail('full', array('class' => 'swiper-hero-img')); ?>

            <div class="position-absolute top-0 end-0 bottom-0 start-0">

              <div class="container h-100 d-flex flex-column">

                <div class="mt-auto text-white mb-5 text-center">

                  <?php bootscore_category_badge(); ?>

                  <!-- Title -->
                  <h2 class="blog-post-title">
                    <a class="text-white" href="<?php the_permalink(); ?>">
                      <?php the_title(); ?>
                    </a>
                  </h2>

                  <!-- Excerpt & Read more -->
                  <div class="card-text">
                    <?php the_excerpt(); ?>
                  </div>

                  <a class="read-more btn btn-light" href="<?php the_permalink(); ?>"><?php _e('Read more »', 'bootscore'); ?></a>

                  <!-- Tags -->
                  <?php bootscore_tags(); ?>

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

// Hero Slider Shortcode End