<?php
/*

 * Post/Page/CPT Hero slider template.
 *
 * This template can be overriden by copying this file to your-theme/bs-swiper-main/sc-swiper-hero.php
 *
 * @author 		Bastian Kreiter
 * @package 	bS Swiper
 * @version     1.0.0


Post Slider Shortcode 
[bs-swiper-hero type="post" category="blog, equal-height" order="DESC" orderby="date" posts="12"]

Page Slider Shortcode
[bs-swiper-hero type="page" post_parent="PARENT-PAGE-ID" order="ASC" orderby="title" posts="6"]

CPT Slider Shortcode
[bs-swiper-hero type="isotope" tax="isotope_category" cat_parent="PARENT-TAX-ID" order="DESC" orderby="date" posts="10"]

*/


// Hero Slider Shortcode
add_shortcode( 'bs-swiper-hero', 'bootscore_swiper_hero' );
function bootscore_swiper_hero( $atts ) {
	ob_start();
	extract( shortcode_atts( array (
		'type' => 'post',
		'order' => 'date',
		'orderby' => 'date',
		'posts' => -1,
		'category' => '',
        'post_parent'    => '', // parent-id child-pages
        'cat_parent'    => '', // parent-taxonomy-id CPT
		'tax' => '' // CPT taxonomy
        
	), $atts ) );
	$options = array(
		'post_type' => $type,
		'order' => $order,
		'orderby' => $orderby,
		'posts_per_page' => $posts,
		'category_name' => $category,
        'post_parent' => $post_parent,
        
	);
    
    // CPT - Check if taxonomy and terms were defined
	if ( $tax != '' && $cat_parent != '' ) {
		$terms = explode( ',', trim( $cat_parent ) );
		$terms = array_map( 'trim', $terms );
		$terms = array_unique( $terms );
		$terms = array_filter( $terms );
		$options['tax_query'] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => $tax,
				'field'    => 'term_id',
				'terms'    => $terms,
				'operator' => 'IN'
			)
		);
	}    
    
	$query = new WP_Query( $options );
	if ( $query->have_posts() ) { ?>


<!-- Swiper -->
<div class="heroes swiper-container swiper mb-4">

    <div class="swiper-wrapper">

        <?php while ( $query->have_posts() ) : $query->the_post(); ?>

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

        <?php endwhile; wp_reset_postdata(); ?>

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