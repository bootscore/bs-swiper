=== bs Swiper ===

Contributors: Bastian Kreiter, torricelli, Sean Emerson, Dog Byte Marketing

Stable tag: 5.8.7
Tested up to: 6.7
Requires at least: 5.0
Requires PHP: 7.4
License: MIT License
License URI: https://github.com/bootscore/bs-swiper/blob/main/LICENSE

Plugin to show posts, pages, custom post types or WooCommerce products in a swiper.js carousel in Bootscore theme. Copyright 2021 - 2024 Bootscore.


== Credits ==

    - Swiper: https://swiperjs.com/, MIT License, https://github.com/nolimits4web/swiper/blob/master/LICENSE, Copyright 2015, Vladimir Kharlampidi
    - Update Checker https://github.com/YahnisElsts/plugin-update-checker/blob/master/license.txt, Copyright 2017, Jānis Elsts

== Installation ==

1. In your admin panel, go to Plugins > and click the Add New button.
2. Click Upload Plugin and Choose File, then select the Plugin's .zip file. Click Install Now.
3. Click Activate to use your new Plugin right away.


== Usage ==


= Posts =

Use shortcode to show posts somewhere:

Cards:
[bs-swiper-card type="post" category="cars, boats" order="DESC" orderby="date" posts="4"]

Cards Autoplay:
[bs-swiper-card-autoplay type="post" category="cars, boats" order="DESC" orderby="date" posts="4"]

Heroes:
[bs-swiper-hero type="post" category="cars, boats" order="DESC" orderby="date" posts="4"]

Heroes Fade:
[bs-swiper-hero-fade type="post" category="cars, boats" order="DESC" orderby="date" posts="4"]

Options:

category="" category-slug
order="" ASC or DESC
orderby="" date, title or rand
posts="" amount of posts to show
categories="false" hide categories badges
excerpt="false" hide excerpt
tags="false" hide tags badges


= Pages =

Use shortcode to show child pages somewhere:

Cards:
[bs-swiper-card type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]

Cards Autoplay:
[bs-swiper-card-autoplay type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]

Heroes:
[bs-swiper-hero type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]

Heroes Fade:
[bs-swiper-hero-fade type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]

Options:

post_parent="" ID of parent page
order="" ASC or DESC
orderby="" date, title or rand
posts="" amount of pages to show
excerpt="false" hide excerpt


= Custom Post Types =

Use shortcode to show custom post types somewhere:

Cards:
[bs-swiper-card type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]

Cards Autoplay:
[bs-swiper-card-autoplay type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]

Heroes:
[bs-swiper-hero type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]

Heroes Fade:
[bs-swiper-hero-fade type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]

Options:

type="" type of custom post type
tax="" taxonomy
terms="" terms-slug - multiple terms separated by comma
order="" ASC or DESC
orderby="" date, title or rand
posts="" amount of posts to show 
excerpt="false" hide excerpt


= Products =

Use shortcode to show products somewhere:

[bs-swiper-card-product category="shoes, trousers" order="DESC" orderby="date" posts="12"]

Options:

category="" category-slug, multiple categories separated by comma
order="" ASC or DESC
orderby="" date, title or rand
posts="" number of posts to display
featured="true" - Will pull featured products (Default: false)
outofstock="false" - Will hide out of stock products (Default: true)
onsale="true" - Will show only onsale products (Default: '')
showhidden="true" Shows products hidden from catalog (Default: false)
        

== Changelog ==

= 5.8.7 - November 19 2024 =

#### Improvements

- Changed `<hr>` to `border-top` in `related-posts.php`
- Tested up to WP 6.7

#### Updates

- Swiper v11.1.15
- Plugin Update Checker v5.5

= 5.8.6 - September 13 2024 =

#### Improvement

* Added `icon.png`

#### Update

* Swiper 11.1.14

= 5.8.5 - September 04 2024 =

#### Improvement

* Added `pauseOnMouseEnter: true,` to autoplay init

#### Update

* Swiper 11.1.12

= 5.8.4 - August 27 2024 =

#### Update

* Swiper 11.1.10

= 5.8.3 - August 15 2024 =

#### Update

* Swiper 11.1.8

= 5.8.2 - July 24 2024 =

#### Update

* Swiper 11.1.7

= 5.8.1 - July 15 2024 =

#### Improvement

* Added `icon.svg`

#### Update

* Swiper 11.1.5

= 5.8.0 - June 06 2024 =

#### Feature

* Added a filter to change related posts heading title

#### Update

* Swiper 11.1.4

#### Templates changed

* `related-posts.php`

= 5.7.2 - March 28 2024 =

#### Bugfix

* Term field name to slug

#### Update

* Update checker 5.4
* Swiper 11.0.7

= 5.7.1 - February 13 2024 =

#### Improvement

* Moved `css` and `js` to `assets` folder
* Minified styles and scripts and added source

#### Update

* Swiper 11.0.6

= 5.7.0 - January 16 2024 =

#### Feature

* Rewrite locate template script to skip `-main` suffix in child folder
* Add filter to remove related posts

#### Improvement

* Replaced `text-muted` with `text-body-secondary`
* `-main` branch suffix from plugin's folder. This does not affect existing bs-swiper-main installations.
* Classes in hero templates

#### Bugfix

* Remove related posts if no other posts in the same category are available

#### Update

* Update checker 5.3

= 5.6.0 - November 28 2023 =

#### Feature

* Added brand and onsale attribute
* Product template shortcode options
* Procuct attribute to show the hidden products

#### Improvement

* Revert limit 12 products to posts -1
* Added sanitization and the extract replacement to the other templates 

#### Bugfix

* Products with visibility set to none are currently being displayed
* Possibility to get non published posts

#### Update

* Update checker v5
* Swiper 11.0.5

= 5.5.0 - October 16 2023 =

#### Feature

* Attribute for handling OOS products

= 5.4.0 - September 14 2023 =

#### Feature

* Added featured products attribute
* Added ability to disable excerpt, categories and tags badges

#### Bugfix

* Product shortcode triggering error when category is empty

= 5.3.2 - August 27 2023 =

#### Bugfix

* Downgrade to update checker 4

= 5.3.1 - August 26 2023 =

#### Improvement

* Deny direct access

#### Bugfix

* Tags badges in heroes

#### Update

* Plugin update checker 5.2

= 5.3.0 - August 11 2023 =

#### Feature

* Related posts template

#### Improvement

* Change --bs-primary to --bs-link-color (Dark Mode)

#### Bugfix

* Undefined variable in sc-product.php

= 5.2.1 - April 26 2023 =

#### Improvement

* Replace PHP echo's with shorthand
* Change bullet CSS variable to body color

= 5.2.0 - March 31 2023 =

#### Improvement

* Loop cards

= 5.1.0.7 - December 21 2022 =

#### Feature

* Added composer.json
* Added card autoplay template

#### Update

* Update Swiper 8.4.5

= 5.1.0.6 - September 06 2022 =

#### Improvement

* Fix product star rating

= 5.1.0.5 - July 27 2022 =

#### Update

* Swiper 8.3.2

= 5.1.0.4 - June 28 2022 =

#### Improvement

* Reformat all files

#### Update

* Swiper 8.2.5

= 5.1.0.3 - June 10 2022 =

#### Update

* Swiper 8.2.3

= 5.1.0.2 - April 16 2022 =

#### Update

* Swiper 8.1.1

= 5.1.0.1 - February 03 2022 =

#### Update

* Swiper 8.0.2

= 5.1.0.0 - January 10 2022 =

#### Feature

* Added shortcode to show single items by id
* Added shortcode for custom post types by terms-slug

#### Removed

* Shortcode for CPT by parent terms id

#### Improvement

* Template sc-swiper-card.php
* Template sc-swiper-hero.php
* Template sc-swiper-hero-fade.php

#### Update

* Swiper 7.3.4

= 5.0.0.4 - October 23 2021 =

#### Improvement

* Added bg-dark class to heroes

#### Update

*  Swiper 7.0.9

= 5.0.0.3 - September 09 2021 =

#### Feature

* Changed repository and plugin name

#### Update

* Swiper 7.0.4

= 5.0.0.2 - August 12 2021 =

#### Feature

* Added new hero-fade template

= 5.0.0.1 - August 02 2021 =

#### Removed

* Source map in swiper-bundle.min.js

= 5.0.0.0 - July 29 2021 =

* Initial release