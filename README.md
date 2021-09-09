# bS Swiper

Plugin to show posts, pages, custom post types or WooCommerce products in a swiper.js carousel for bootScore WordPress theme.

Demo: https://bootscore.me/plugins/bs-swiper/

Documentation: https://bootscore.me/documentation/bs-swiper/

## Installation

1. Download the zip file right here by pressing the green `code` button above or get plugin through the official [store](https://bootscore.me/shop/products/theme/bs5-swiper/) (free). 
2. In your admin panel, go to Plugins > and click the Add New button.
3. Click Upload Plugin and Choose File, then select the Plugin's .zip file. Click Install Now.
4. Click Activate to use your new Plugin right away.

## Usage

### Posts

Use shortcode to show posts:

#### Cards: 

`[bs-swiper-card type="post" category="water, classic, markup" order="DESC" orderby="date" posts="12"]`

#### Heroes:

##### Slide

`[bs-swiper-hero type="post" category="water, classic, markup" order="DESC" orderby="date" posts="12"]`

##### Fade

`[bs-swiper-hero-fade type="post" category="water, classic, markup" order="DESC" orderby="date" posts="12"]`

#### Options:

- category: category slug, separated by comma for multiple categories
- order: ASC or DESC
- orderby: date or title
- posts: number of posts to display

### Pages

Use shortcode to show child pages:

#### Cards:
`[bs-swiper-card type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]`

#### Heroes:

##### Slide

`[bs-swiper-hero type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]`

##### Fade

`[bs-swiper-hero-fade type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]`

#### Options:

- post_parent: ID of parent page
- order: ASC or DESC
- orderby: date or title
- posts: number of pages to display

### Custom Post Types

Use shortcode to show custom post types:

#### Cards:

`[bs-swiper-card type="isotope" tax="isotope_category" cat_parent="224" order="DESC" orderby="date" posts="10"]`

#### Heroes:

##### Slide

`[bs-swiper-hero type="isotope" tax="isotope_category" cat_parent="224" order="DESC" orderby="date" posts="10"]`

##### Fade

`[bs-swiper-hero-fade type="isotope" tax="isotope_category" cat_parent="224" order="DESC" orderby="date" posts="10"]`

#### Options:

- type: type of custom post type
- tax: taxonomy
- cat_parent: ID of parent taxonomy
- order: ASC or DESC
- orderby: date or title
- posts: number of posts to display 

### Products

Use shortcode to display your products in a page:

`[bs-swiper-card-product order="DESC" orderby="date" posts="12" category="sample-category, test-category"]`

#### Options:

- category: category slug, separated by comma for multiple categories
- order: ASC or DESC
- orderby: date or title
- posts: number of posts to display

## Overriding templates via theme

Template files can be found within the /bs-swiper-main/templates/ plugin directory.

Edit files in an upgrade-safe way using overrides. Copy the template into a directory within your theme named /bs-swiper-main keeping the same file structure but removing the /templates/ subdirectory. Path must be `/your-theme/bs-swiper-main/[file].php`.

The copied file will now override the bS Swiper template file. Change cards, classes or HTML as you want.

### Templates that can be overwritten:

- sc-swiper-card.php
- sc-swiper-card-product.php
- sc-swiper-hero.php
- sc-swiper-hero-fade.php

## License & Credits

- bS Swiper, MIT License https://github.com/bootscore/bs-swiper/blob/main/LICENSE
- swiper.js, nolimits4web, MIT License https://github.com/nolimits4web/swiper/blob/master/LICENSE
- Plugin Update Checker, YahnisElsts, https://github.com/YahnisElsts/plugin-update-checker/blob/master/license.txt
