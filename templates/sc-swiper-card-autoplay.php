<?php
/*

 * Post/Page/CPT Card Autoplay slider template.
 *
 * This template can be overriden by copying this file to your-theme/bs-swiper-main/sc-swiper-card.php
 *
 * @author 		bootScore
 * @package 	bS Swiper
 * @version     5.2.1


Posts: 
[bs-swiper-card-autoplay type="post" category="cars, boats" order="ASC" orderby="date" posts="6"]

Child-pages: 
[bs-swiper-card-autoplay type="page" post_parent="21" order="ASC" orderby="title" posts="6"]

Custom post types:
[bs-swiper-card-autoplay type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]

Single items:
[bs-swiper-card-autoplay type="post" id="1, 15"]
[bs-swiper-card-autoplay type="page" id="2, 25"]
[bs-swiper-card-autoplay type="isotope" id="33, 31"]
*/


// Card Slider Shortcode
add_shortcode('bs-swiper-card-autoplay', 'bootscore_swiper_autoplay');
function bootscore_swiper_autoplay($atts) {

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

    <div class="px-5 position-relative">

      <div class="cards-autoplay swiper-container swiper position-static">

        <div class="swiper-wrapper">

          <?php while ($query->have_posts()) : $query->the_post(); ?>

            <div class="swiper-slide card h-auto mb-5">

              <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                </a>
              <?php endif; ?>

              <div class="card-body d-flex flex-column">

                <?php bootscore_category_badge(); ?>

                <a class="text-body text-decoration-none" href="<?php the_permalink(); ?>">
                  <?php the_title('<h2 class="blog-post-title h5">', '</h2>'); ?>
                </a>

                <?php if ('post' === get_post_type()) : ?>
                  <p class="meta small mb-2 text-muted">
                    <?php
                      bootscore_date();
                      bootscore_author();
                      bootscore_comments();
                      bootscore_edit();
                    ?>
                  </p>
                <?php endif; ?>

                <p class="card-text">
                  <a class="text-body text-decoration-none" href="<?php the_permalink(); ?>">
                    <?= strip_tags(get_the_excerpt()); ?>
                  </a>
                </p>

                <p class="card-text mt-auto">
                  <a class="read-more" href="<?php the_permalink(); ?>">
                    <?php _e('Read more »', 'bootscore'); ?>
                  </a>
                </p>

                <?php bootscore_tags(); ?>

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

// Card Slider Shortcode End