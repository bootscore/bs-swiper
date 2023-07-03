<?php

function bootscore_related_posts() {

    $post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category( $post_id );

    if(!empty($categories) && !is_wp_error($categories)):
        foreach ($categories as $category):
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

    $related_cats_post = new WP_Query( $query_args );
  ?>


<div class="related-posts">
<hr>
<h2 class="h4 text-center mb-4"><?php _e('You might also be interested in this', 'bootscore'); ?></h2>
    <div class="px-5 mb-4 position-relative">

      <div class="cards swiper-container swiper position-static">

        <div class="swiper-wrapper">


<?php

    if($related_cats_post->have_posts()):
         while($related_cats_post->have_posts()): $related_cats_post->the_post(); ?>
     
<div class="swiper-slide card h-auto mb-5">

              <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                </a>
              <?php endif; ?>

              <div class="card-body d-flex flex-column">

                <?php bootscore_category_badge(); ?>

                <a class="text-body text-decoration-none" href="<?php the_permalink(); ?>">
                  <?php the_title('<h3 class="blog-post-title h5">', '</h3>'); ?>
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
            
        <?php endwhile; ?>
         
         </div>
                <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next end-0"></div>
        <div class="swiper-button-prev start-0"></div>
        
      </div>
</div>
</div>
<?php

        // Restore original Post Data
        wp_reset_postdata();
     endif;

}