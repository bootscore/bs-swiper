=== bS5 Swiper ===

Contributors: craftwerk

Requires at least: 4.5
Tested up to: 5.8
Requires PHP: 5.6
Stable tag: 5.0.0.1
License: MIT License
License URI: https://github.com/craftwerkberlin/bs5-swiper/blob/main/LICENSE

Plugin to show posts, pages, custom post types or WooCommerce products in a swiper.js carousel for bootScore 5 theme. Copyright 2021 Bastian Kreiter.


== Credits ==

    - Swiper: https://swiperjs.com/, MIT License, http://www.idangero.us/swiper/, Copyright 2015, Vladimir Kharlampidi
    - Update Checker https://github.com/YahnisElsts/plugin-update-checker/blob/master/license.txt, Copyright 2017, Jānis Elsts

== Installation ==

1. In your admin panel, go to Plugins > and click the Add New button.
2. Click Upload Plugin and Choose File, then select the Plugin's .zip file. Click Install Now.
3. Click Activate to use your new Plugin right away.


== Usage ==


    = Posts =

        Use shortcode to show posts:

        Cards:
        [bs-swiper-card type="post" category="water, classic, markup" order="DESC" orderby="date" posts="12"]
        
        Heroes:
        [bs-swiper-hero type="post" category="water, classic, markup" order="DESC" orderby="date" posts="12"]

        Options:

        category: category slug
        order: ASC or DESC
        orderby: date or title
        posts: number of posts to display
        
        
    = Pages =

        Use shortcode to show child pages:

        Cards:
        [bs-swiper-card type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]
        
        Heroes:
        [bs-swiper-hero type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]

        Options:

        post_parent: ID of parent page
        order: ASC or DESC
        orderby: date or title
        posts: number of pages to display
        
        
    = Custom Post Types =

        Use shortcode to show custom post types:

        Cards:
        [bs-swiper-card type="isotope" tax="isotope_category" cat_parent="224" order="DESC" orderby="date" posts="10"]
        
        Heroes:
        [bs-swiper-hero type="isotope" tax="isotope_category" cat_parent="224" order="DESC" orderby="date" posts="10"]

        Options:

        type: type of custom post type
        tax: taxonomy
        cat_parent: ID of parent taxonomy
        order: ASC or DESC
        orderby: date or title
        posts: number of posts to display     


    = Products =

        Use shortcode to display your products in a page:

        [bs-swiper-card-product order="DESC" orderby="date" posts="12" category="sample-category, test-category"]

        Options:

        order: ASC or DESC
        orderby: date or title
        posts: number of posts to display
        category: category slug, seperated by comma for multiple categories


== Changelog ==

    = 5.0.0.1 - August 02 2021 =
    
        * Removed source map in swiper-bundle.min.js

    = 5.0.0.0 - July 29 2021 =
    
        * Initial release
        
        
