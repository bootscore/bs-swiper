<?php if (!empty($related_posts)) { ?>

<hr>
<h2 class="h4 text-center mb-4">Das könnte Sie auch interessieren</h2>
<div class="px-lg-5 mb-4 position-relative related-posts">
  <div class="cards swiper-container swiper position-static">
    <div class="swiper-wrapper">
      <?php
        $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 12, 'post__not_in' => array($post->ID) ) );
        if( $related ) foreach( $related as $post ) {
        setup_postdata($post); 
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
      <?php }
        wp_reset_postdata(); ?>
    </div> <!-- .swiper-wrapper -->
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next end-0 d-none d-lg-block"></div>
    <div class="swiper-button-prev start-0 d-none d-lg-block"></div>
  </div><!-- swiper-container -->
</div>

<?php
}
