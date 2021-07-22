<?php
/*

 * Post/Page slider template.
 *
 * This template can be overriden by copying this file to your-theme/bs5-swiper/sc-post-slider.php
 *
 * @author 		Bastian Kreiter
 * @package 	bS5 Swiper
 * @version     1.0.0


Post Slider Shortcode 
[bs-swiper-hero type="post" category="blog, equal-height" order="DESC" orderby="date" posts="12"]

Page Slider Shortcode
[bs-swiper-hero type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]

*/


// Post Slider Shortcode
add_shortcode( 'bs-swiper-hero', 'bootscore_swiper_hero' );
function bootscore_swiper_hero( $atts ) {
	ob_start();
	extract( shortcode_atts( array (
		'type' => 'post',
		'order' => 'date',
		'orderby' => 'date',
		'posts' => -1,
		'category' => '',
        'post_parent'    => '',
        
	), $atts ) );
	$options = array(
		'post_type' => $type,
		'order' => $order,
		'orderby' => $orderby,
		'posts_per_page' => $posts,
		'category_name' => $category,
        'post_parent' => $post_parent,
        
	);
	$query = new WP_Query( $options );
	if ( $query->have_posts() ) { ?>


<!-- Swiper -->



    <div class="swiper-container swiper-container-hero swiper mb-4">

        <div class="swiper-wrapper">

            <?php while ( $query->have_posts() ) : $query->the_post(); ?>

            <div class="swiper-slide h-100">
                <!-- Featured Image-->
                <?php the_post_thumbnail('full', array('class' => 'swiper-hero-img')); ?>

                <div class="card card-body border-0 bg-primary text-white p-xl-5">

                    <?php bootscore_category_badge(); ?>

                    <!-- Title -->
                    <h2 class="blog-post-title">
                        <a class="h1 text-white" href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <!-- Excerpt & Read more -->
                    <div class="card-text lead">
                        <?php the_excerpt(); ?>
                    </div>

                    <div class="mt-auto">
                        <a class="read-more btn btn-lg btn-outline-light w-100 mb-4 mb-lg-0" href="<?php the_permalink(); ?>"><?php _e('Read more »', 'bootscore'); ?></a>
                    </div>
                    <!-- Tags -->
                    <?php bootscore_tags(); ?>

                </div><!-- .card -->

            </div><!-- .swiper-slide -->

            <?php endwhile; wp_reset_postdata(); ?>

        </div> <!-- .swiper-wrapper -->

        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next end-0"></div>
        <div class="swiper-button-prev start-0"></div>
        

    </div><!-- swiper-container -->



<!-- Swiper End -->

<?php $myvariable = ob_get_clean();
	return $myvariable;
	}	
}

// Post Slider Shortcode End
