# bS Swiper

WordPress plugin to show posts, pages, custom-post-types or WooCommerce products in a swiper.js carousel in bootScore theme.

- Demo and documentation: https://bootscore.me/documentation/bs-swiper/

<img src="https://lh3.googleusercontent.com/pw/AM-JKLWiXYRnKEw159nO7pwFb4ntUSLVFvmlb8jvSaz__ucMtM26cCHhEXAwHSc58oh1FKGg99sY6sxyw1ycm5fuGUimM-lYZ2Z2yrh-imU4EE_vQhu8pwFaP4fK8yeXQdSyZowyGgwSNBR83WvRajr4M8e-Kw=w1200-h941-no" alt="bs-swiper">

## Installation
1. Download latest release [bs-swiper-main.zip](https://github.com/bootscore/bs-swiper/releases). 
2. In your admin panel, go to Plugins > and click the Add New button.
3. Click Upload Plugin and Choose File, then select the Plugin's .zip file. Click Install Now.
4. Click Activate to use your new Plugin right away.

## Usage
Select template you want to use by replacing `bs-swiper-*` placeholder in shortcode examples.

- `bs-swiper-card` shows items in 4 (xxl), 3 (lg), 2 (md) and 1 (sm) column cards.
- `bs-swiper-hero` shows items in a hero slider with auto-slide effect. Items must have a featured-image.
- `bs-swiper-hero-fade` shows items in a hero slider with auto-fade effect. Items must have a featured-image.
- `bs-swiper-card-product` shows only WooCommerce products in 4 (xxl), 3 (lg), 2 (md) and 1 (sm) column cards.

## Posts

### Shortcode to show posts by category
`[bs-swiper-* type="post" category="cars, boats" order="ASC" orderby="date" posts="6"]`   

#### Options
- category: category-slug, multiple categories separated by comma
- order: ASC or DESC
- orderby: date, title, or rand
- posts: amount of posts to show

### Shortcode to show posts by tags
`[bs-swiper-* type="post" tax="post_tag" terms="bikes, motorbikes" order="DESC" orderby="date" posts="5"]`

#### Options
- tax: taxonomy (post_tag)
- terms: tags-slug, multiple terms separated by comma
- order: ASC or DESC
- orderby: date, title, or rand
- posts: amount of posts to show

### Shortcode to show single posts by id
`[bs-swiper-* type="post" id="1, 15"]`

#### Options
- id: id of post, multiple ids separated by comma 

## Pages

### Shortcode to show child-pages by parent-page id
`[bs-swiper-* type="page" post_parent="21" order="ASC" orderby="title" posts="6"]`

Showing child-pages in parent-page is very useful to avoid empty parent-pages.

#### Options
- post_parent: id of parent page
- order: ASC or DESC
- orderby: date, title, or rand
- posts: amount of pages to show

### Shortcode to show single pages by id
`[bs-* type="page" id="2, 25"]`

#### Options
- id: id of page, multiple ids separated by comma 

## Custom Post Types

### Shortcode to show custom-post-types by terms
`[bs-swiper-* type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]`

#### Options:
- type: type of custom-post-type
- tax: taxonomy
- terms: terms-slug, multiple terms separated by comma
- order: ASC or DESC
- orderby: date, title, or rand
- posts: amount of custom post types to show 

### Shortcode to show single custom-post-types by id
`[bs-* type="isotope" id="33, 31"]`

#### Options
- id: id of custom-post-type, multiple ids separated by comma 

## WooCommerce Products

### Shortcode to show products
`[bs-swiper-card-product category="shoes, trousers" order="DESC" orderby="date" posts="12"]`

#### Options:
- category: category slug, multiple categories separated by comma
- order: ASC or DESC
- orderby: date, title, or rand
- posts: amount of products to show 

## Overriding templates via theme
Template files can be found within the **/bs-swiper-main/templates/** plugin directory.

Edit files in an upgrade-safe way using overrides. Copy the template into a directory within your theme named **/bs-swiper-main/** keeping the same file structure but removing the **/templates/** subdirectory. Path must be **/your-theme/bs-swiper-main/[file].php**.

The copied file will now override the bS Swiper template file. Change cards, classes or HTML as you want.

### Templates that can be overridden
- sc-swiper-card.php
- sc-swiper-card-product.php
- sc-swiper-hero.php
- sc-swiper-hero-fade.php

## License & Credits
- bS Swiper, MIT License https://github.com/bootscore/bs-swiper/blob/main/LICENSE
- swiper.js, nolimits4web, MIT License https://github.com/nolimits4web/swiper/blob/master/LICENSE
- Plugin Update Checker, YahnisElsts, MIT License https://github.com/YahnisElsts/plugin-update-checker/blob/master/license.txt

