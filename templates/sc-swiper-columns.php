<?php

/*
 *
 * Post/Page/CPT Card slider template.
 *
 * This template can be overriden by copying this file to your-theme/bs-swiper/sc-swiper-card.php
 *
 * @author   Bootscore
 * @package  bs Swiper
 * @version  6.0.0
*/


// Exit if accessed directly
defined( 'ABSPATH' ) || exit;


// Column Slider Shortcode
add_shortcode('bs-swiper-columns', 'bootscore_swiper');
function bootscore_swiper($atts) {
  ob_start();

  $atts = shortcode_atts(array(
    'type'          => 'post',
    'post_status'   => 'publish',
    'order'         => 'date',
    'orderby'       => 'date',
    'posts'         => -1,
    'category'      => '',
    'post_parent'   => '',
    'tax'           => '',
    'terms'         => '',
    'id'            => '',
    'categories'    => 'true',
    'meta'          => 'true',
    'excerpt'       => 'true',
    'readmore'      => 'true',
    'tags'          => 'true',
    'navigation'    => 'true',  // new shows/hides prev/next arrows
    'pagination'    => 'true',  // new shows/hides bullet pagination
    'slidesperview' => '',      // new attribute: e.g., "2,3,4,6"
    'loop'          => 'false', // new parameter: default false
    'autoplay'      => 'false', // new parameter: default false
    'delay'         => '4000',  // new parameter: default 4000ms
    'spacebetween'  => '20',    // new parameter: default 20px
    'effect'        => 'slide', // new parameter: default slide
    'speed'         => '300',   // new parameter: default 300ms
    'context'       => '',      // new contextual filters
  ), $atts);

  // Store context globally for filters, if needed
  $GLOBALS['bs_swiper_context'] = $atts['context'];

  $context = $atts['context'];

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
    $terms = array_map('trim', explode(',', $terms));
    $terms = array_filter($terms);
    $terms = array_unique($terms);
    unset($options['category_name']);
    $options['tax_query'] = array(array(
      'taxonomy' => $tax,
      'field'    => 'slug',
      'terms'    => $terms,
    ));
  }

  if (!empty($atts['id'])) {
    $ids = array_map('intval', explode(',', $atts['id']));
    $ids = array_filter($ids);
    $ids = array_unique($ids);
    $options['post__in'] = $ids;
  }

  // Handle slidesperview attribute and map to breakpoints
  $breakpoints = [];
  $bps = [0, 576, 768, 992, 1200, 1400]; // xs, sm, md, lg, xl, 2xl

  if (!empty($atts['slidesperview'])) {
    $slidesperview = array_map('intval', explode(',', $atts['slidesperview']));

    foreach ($slidesperview as $i => $val) {
      if (isset($bps[$i])) {
        $breakpoints[$bps[$i]] = ['slidesPerView' => $val];
      }
    }
  } else {
    // Default: 1 slide on xs/sm, 2 on md, 3 on lg, 4 on xl+, etc.
    $breakpoints = [
      0    => ['slidesPerView' => 1],
      576  => ['slidesPerView' => 1],
      768  => ['slidesPerView' => 2],
      992  => ['slidesPerView' => 3],
      1200 => ['slidesPerView' => 4],
      1400 => ['slidesPerView' => 4],
    ];
  }

  // Handle loop parameter
  $loop = ($atts['loop'] === 'true');
  
  // Handle autoplay parameters
  $autoplay = ($atts['autoplay'] === 'true');
  $delay = is_numeric($atts['delay']) ? (int) $atts['delay'] : 4000;

  // Handle spacebetween parameter
  $spaceBetween = is_numeric($atts['spacebetween']) ? (int) $atts['spacebetween'] : 20;

  // Handle effect parameter - validate against allowed effects
  $allowed_effects = array('slide', 'fade', 'cube', 'coverflow', 'flip', 'cards', 'creative');
  $effect = in_array(strtolower($atts['effect']), $allowed_effects) ? strtolower($atts['effect']) : 'slide';

  // Handle speed parameter
  $speed = is_numeric($atts['speed']) ? (int) $atts['speed'] : 300;

  $data_breakpoints = htmlspecialchars(json_encode($breakpoints), ENT_QUOTES, 'UTF-8');
  $data_loop = $loop ? 'true' : 'false';
  $data_autoplay = $autoplay ? 'true' : 'false';
  $data_delay = $delay;
  $data_spacebetween = $spaceBetween;
  $data_effect = $effect;
  $data_speed = $speed;

  $query = new WP_Query($options);
  if ($query->have_posts()) : ?>

    <!-- Swiper -->
    <div class="position-relative <?php 
    if ($atts['navigation'] === 'true') {
        echo apply_filters('bootscore/bs-swiper/class/wrapper/spacer', 'px-5', 'bs-swiper-columns');
    } ?>">  
      
      <div class="bs-swiper-columns swiper-container swiper position-static" 
           data-swiper-breakpoints="<?= $data_breakpoints; ?>"
           data-swiper-loop="<?= $data_loop; ?>"
           data-swiper-autoplay="<?= $data_autoplay; ?>"
           data-swiper-delay="<?= $data_delay; ?>"
           data-swiper-spacebetween="<?= $data_spacebetween; ?>"
           data-swiper-effect="<?= $data_effect; ?>"
           data-swiper-speed="<?= $data_speed; ?>">
        <div class="swiper-wrapper">

          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <article class="swiper-slide <?= apply_filters('bootscore/class/loop/card', 'card h-auto mb-5', 'bs-swiper-columns'); ?>">

              <?php do_action('bootscore_before_loop_thumbnail', 'bs-swiper-columns'); ?>
              
              <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium', array('class' => apply_filters('bootscore/class/loop/card/image', 'card-img-top', 'bs-swiper-columns'))); ?>
                </a>
              <?php endif; ?>
              
              <?php do_action('bootscore_after_loop_thumbnail', 'bs-swiper-columns'); ?>

              <div class="<?= apply_filters('bootscore/class/loop/card/body', 'card-body d-flex flex-column', 'bs-swiper-columns'); ?>">
                <?php if ($atts['categories'] === 'true') : bootscore_category_badge(); endif; ?>
                
                <?php do_action('bootscore_before_loop_title', 'bs-swiper-columns'); ?>
                
                <a class="<?= apply_filters('bootscore/class/loop/card/title/link', 'text-body text-decoration-none', 'bs-swiper-columns'); ?>" href="<?php the_permalink(); ?>">
                  <?php the_title('<h2 class="' . apply_filters('bootscore/class/loop/card/title', 'blog-post-title h5', 'bs-swiper-columns') . '">', '</h2>'); ?>
                </a>
                
                <?php do_action('bootscore_after_loop_title', 'bs-swiper-columns'); ?>

                <?php if ($atts['meta'] === 'true') : ?>
                  <?php if (get_post_type() === 'post') : ?>
                    <p class="meta small mb-2 text-body-secondary">
                      <?php
                        bootscore_date();
                        bootscore_author();
                        bootscore_comments();
                        bootscore_edit();
                      ?>
                    </p>
                  <?php endif; ?>
                <?php endif; ?>

                <?php if ($atts['excerpt'] === 'true') : ?>
                  <p class="<?= apply_filters('bootscore/class/loop/card-text/excerpt', 'card-text', 'bs-swiper-columns'); ?>">
                    <a class="text-body text-decoration-none" href="<?php the_permalink(); ?>">
                      <?= strip_tags(get_the_excerpt()); ?>
                    </a>
                  </p>
                <?php endif; ?>
                
                <?php if ($atts['readmore'] === 'true') : ?>
                  <p class="<?= apply_filters('bootscore/class/loop/card-text/read-more', 'card-text mt-auto', 'bs-swiper-columns'); ?>">
                    <a class="<?= apply_filters('bootscore/class/loop/read-more', 'read-more', 'bs-swiper-columns'); ?>" href="<?php the_permalink(); ?>">
                      <?= apply_filters('bootscore/loop/read-more/text', __('Read more »', 'bootscore', 'bs-swiper-columns')); ?>
                    </a>
                  </p>
                <?php endif; ?>

                <?php if ($atts['tags'] === 'true') : bootscore_tags(); endif; ?>
              </div>
              
              <?php do_action('bootscore_loop_item_after_card_body', 'bs-swiper-columns'); ?>
              
            </article>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- Add Pagination -->
        <?php if ($atts['pagination'] === 'true') : ?>
          <div class="swiper-pagination"></div>
        <?php endif; ?>
        
        <!-- Add Navigation Arrows -->
        <?php if ($atts['navigation'] === 'true') : ?>
          <div class="<?= apply_filters('bootscore/bs-swiper/class/navigation', '', 'bs-swiper-columns'); ?>">
            <div class="swiper-button-next end-0"></div>
            <div class="swiper-button-prev start-0"></div>
          </div>
        <?php endif; ?>
        
      </div>
    </div>
    <!-- Swiper End -->

<?php
    return ob_get_clean();
  endif;
}