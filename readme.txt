=== bS5 Post / Page / Product Slider ===

Contributors: craftwerk

Requires at least: 4.5
Tested up to: 5.7.2
Requires PHP: 5.6
Stable tag: 5.0.0.0
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Posts, Pages or WooCommerce products Slider for bootScore 5 WordPress theme, made with Swiper, Copyright 2021 Bastian Kreiter.

== Credits ==

Swiper: https://swiperjs.com/, MIT License, http://www.idangero.us/swiper/, Copyright 2015, Vladimir Kharlampidi

== Installation ==

1. In your admin panel, go to Plugins > and click the Add New button.
2. Click Upload Plugin and Choose File, then select the Plugin's .zip file. Click Install Now.
3. Click Activate to use your new Plugin right away.

== Usage ==

    = Posts =

        Use shortcode to display your posts in a page:

        [bs-post-slider type="post" category="sample-category" order="ASC" orderby="title" posts="12"]

        Options:

        category: category slug
        order: ASC or DESC
        orderby: date or title
        posts: number of posts to display
        
    = Pages =

        Use shortcode to display child pages in a page:

        [bs-post-slider type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]

        Options:

        post_parent: ID of your parent page
        order: ASC or DESC
        orderby: date or title
        posts: number of pages to display

    = Products =

        Use shortcode to display your products in a page:

        [bs-product-slider order="DESC" orderby="date" posts="12" category="sample-category, test-category"]

        Options:

        order: ASC or DESC
        orderby: date or title
        posts: number of posts to display
        category: category slug, seperated by comma for multiple categories


== Changelog ==

    = 5.0.0.2 - June 13 2021 =
    
        * [IMPROVEMENT] Folder name changed from bs5-post-product-slider to bs5-post-page-product-slider. Old plugin must be removed before reinstalling. Updating through the plugin-uploader will not work. 
        * [IMPROVEMENT] Removed mb-4 from main-wrapper
        * [IMPROVEMENT] Slider can now show subpages by parent page id.

    = 5.0.0.2 - May 11 2021 =
    
        * [UPDATE] Swiper 6.5.9 security update

    = 5.0.0.1 - February 16 2021 =
    
        * [NEW] Override templates in child-theme 
        * [SEO] Merged swiper.min.css and swiper-style.css into one file to reduce HTTP requests
        * [SEO] Merged swiper.min.js and swiper-init.js into one file to reduce HTTP requests
        * [SEO] Load js in footer

    = 5.0.0 - December 12 2020 =
    
        * Initial release
        
        
