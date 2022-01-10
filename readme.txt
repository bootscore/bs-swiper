=== bS Swiper ===

Contributors: Bastian Kreiter, torricelli

Requires at least: 4.5
Tested up to: 5.8.3
Requires PHP: 5.6
Stable tag: 5.1.0.0
License: MIT License
License URI: https://github.com/bootscore/bs-swiper/blob/main/LICENSE

Plugin to show posts, pages, custom post types or WooCommerce products in a swiper.js carousel for bootScore theme. Copyright 2021 - 2022 bootScore.


== Credits ==

    - Swiper: https://swiperjs.com/, MIT License, http://www.idangero.us/swiper/, Copyright 2015, Vladimir Kharlampidi
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
        
        Heroes:
        [bs-swiper-hero type="post" category="cars, boats" order="DESC" orderby="date" posts="4"]
        
        Heroes Fade:
        [bs-swiper-hero-fade type="post" category="cars, boats" order="DESC" orderby="date" posts="4"]

        Options:

        category: category slug
        order: ASC or DESC
        orderby: date, title or rand
        posts: amount of posts to show
        
        
    = Pages =

        Use shortcode to show child pages somewhere:

        Cards:
        [bs-swiper-card type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]
        
        Heroes:
        [bs-swiper-hero type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]
        
        Heroes Fade:
        [bs-swiper-hero-fade type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]

        Options:

        post_parent: ID of parent page
        order: ASC or DESC
        orderby: date, title or rand
        posts: amount of pages to show
        
        
    = Custom Post Types =

        Use shortcode to show custom post types somewhere:

        Cards:
        [bs-swiper-card type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]
        
        Heroes:
        [bs-swiper-hero type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]
        
        Heroes Fade:
        [bs-swiper-hero-fade type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]

        Options:

        type: type of custom post type
        tax: taxonomy
        terms: terms-slug - multiple terms separated by comma
        order: ASC or DESC
        orderby: date, title or rand
        posts: amount of posts to show 

    = Products =

        Use shortcode to show products somewhere:

        [bs-swiper-card-product category="shoes, trousers" order="DESC" orderby="date" posts="12"]

        Options:

        category: category-slug, multiple categories separated by comma
        order: ASC or DESC
        orderby: date, title or rand
        posts: number of posts to display
        


== Changelog ==

    = 5.1.0.0 - January 10 2022 =
    
        * [NEW] Added shortcode to show single items by id
        * [NEW] Added shortcode for custom post types by terms-slug
        * [REMOVED] Shortcode for CPT by parent terms id
        * [CHANGED] Template sc-swiper-card.php
        * [CHANGED] Template sc-swiper-hero.php
        * [CHANGED] Template sc-swiper-hero-fade.php
        * [UPDATE] Swiper 7.3.4

    = 5.0.0.4 - October 23 2021 =
    
        * Added bg-dark class to heroes
        * Update Swiper 7.0.9

    = 5.0.0.3 - September 09 2021 =
    
        * Update to swiper 7.0.4
        * Changed repository and plugin name

    = 5.0.0.2 - August 12 2021 =
    
        * Added new hero-fade template

    = 5.0.0.1 - August 02 2021 =
    
        * Removed source map in swiper-bundle.min.js

    = 5.0.0.0 - July 29 2021 =
    
        * Initial release
        
        
