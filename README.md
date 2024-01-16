# bs Swiper

[![Packagist Prerelease](https://img.shields.io/packagist/vpre/bootscore/bs-swiper?logo=packagist&logoColor=fff)](https://packagist.org/packages/bootscore/bs-swiper)
[![Github All Releases](https://img.shields.io/github/downloads/bootscore/bs-swiper/total.svg)](https://github.com/bootscore/bs-swiper/releases)


WordPress plugin to show posts, pages, custom post types or WooCommerce products in a [swiper.js](https://swiperjs.com) carousel in Bootscore theme.

- Demo and documentation: https://bootscore.me/documentation/bs-swiper/

<img src="https://lh3.googleusercontent.com/pw/AM-JKLWiXYRnKEw159nO7pwFb4ntUSLVFvmlb8jvSaz__ucMtM26cCHhEXAwHSc58oh1FKGg99sY6sxyw1ycm5fuGUimM-lYZ2Z2yrh-imU4EE_vQhu8pwFaP4fK8yeXQdSyZowyGgwSNBR83WvRajr4M8e-Kw=w1200-h941-no" alt="bs-swiper">

## Installation
1. Download latest release [bs-swiper.zip](https://github.com/bootscore/bs-swiper/releases/latest/download/bs-swiper.zip). 
2. In your admin panel, go to Plugins > and click the Add New button.
3. Click Upload Plugin and Choose File, then select the Plugin's .zip file. Click Install Now.
4. Click Activate to use your new Plugin right away.

## Usage
Select template you want to use by replacing `bs-swiper-*` placeholder in shortcode examples.

- `bs-swiper-card` shows items in 4 (xxl), 3 (lg), 2 (md) and 1 (sm) column cards.
- `bs-swiper-card-autoplay` shows items in 4 (xxl), 3 (lg), 2 (md) and 1 (sm) column cards with autoplay.
- `bs-swiper-hero` shows items in a hero slider with auto-slide effect. Items must have a featured-image.
- `bs-swiper-hero-fade` shows items in a hero slider with auto-fade effect. Items must have a featured-image.
- `bs-swiper-card-product` shows only WooCommerce products in 4 (xxl), 3 (lg), 2 (md) and 1 (sm) column cards.

## Posts

### Shortcode to show posts by category
```
[bs-swiper-* type="post" category="cars, boats" order="ASC" orderby="date" posts="6"]
```   

#### Options
- `category=""` - category-slug, multiple categories separated by comma
- `order=""` - ASC or DESC
- `orderby=""` - date, title, or rand
- `posts=""` - amount of posts to show
- `excerpt="false"` - hide excerpt
- `tags="false"` - hide tags
- `categories="false"` - hide categories

### Shortcode to show posts by tags
```
[bs-swiper-* type="post" tax="post_tag" terms="bikes, motorbikes" order="DESC" orderby="date" posts="5"]
```

#### Options
- `tax=""` - taxonomy (post_tag)
- `terms=""` - tags-slug, multiple terms separated by comma
- `order=""` - ASC or DESC
- `orderby=""` - date, title, or rand
- `posts=""` - amount of posts to show
- `excerpt="false"` - hide excerpt
- `tags="false"` - hide tags
- `categories="false"` - hide categories

### Shortcode to show single posts by id
```
[bs-swiper-* type="post" id="1, 15"]
```

#### Options
- `id=""` - id of post, multiple ids separated by comma 
- `excerpt="false"` - hide excerpt
- `tags="false"` - hide tags
- `categories="false"` - hide categories

## Pages

### Shortcode to show child-pages by parent-page id
```
[bs-swiper-* type="page" post_parent="21" order="ASC" orderby="title" posts="6"]
```

Showing child-pages in parent-page is very useful to avoid empty parent-pages.

#### Options
- `post_parent=""` - id of parent page
- `order=""` - ASC or DESC
- `orderby=""` - date, title, or rand
- `posts=""` - amount of pages to show
- `excerpt="false"` - hide excerpt

### Shortcode to show single pages by id
```
[bs-* type="page" id="2, 25"]
```

#### Options
- `id=""` - id of page, multiple ids separated by comma 
- `excerpt="false"` - hide excerpt

## Custom Post Types

### Shortcode to show custom-post-types by terms
```
[bs-swiper-* type="isotope" tax="isotope_category" terms="dogs, cats" order="DESC" orderby="date" posts="5"]
```

#### Options:
- `type=""` - type of custom-post-type
- `tax=""` - taxonomy
- `terms=""` - terms-slug, multiple terms separated by comma
- `order=""` - ASC or DESC
- `orderby=""` - date, title, or rand
- `posts=""` - amount of custom post types to show 
- `excerpt="false"` - hide excerpt

### Shortcode to show single custom-post-types by id
```
[bs-* type="isotope" id="33, 31"]
```

#### Options
- `id=""` - id of custom-post-type, multiple ids separated by comma 
- `excerpt="false"` - hide excerpt

## WooCommerce Products

### Shortcode to show products
```
[bs-swiper-card-product]
```

#### Options:
- `category="cars, boats"` - Category slug, multiple categories separated by comma. Will pull products matching these categories (Default: `''`)
- `id="1, 2, 3"` - id of product(s), multiple ids separated by comma. Will show products matching these ids (Default: `''`)
- `brand="brand1, brand2"` - Will pull products matching these brands (Default: `''`)
- `posts="12"` - Specify how many products will be shown (Default: `-1`)
- `orderby="date"` - `date`, `title` or `rand`. Specify how products will be ordered by (Default: `date`)
- `order="DESC"` - Specify if products will be ordered `ASC` or `DESC` (Default: `DESC`)
- `featured="true"` - Will pull featured products (Default: `false`)
- `outofstock="false"` - Will hide out of stock products (Default: `true`)
- `onsale="true"` - Will show only onsale products (Default: `''`)
- `showhidden="true"` Shows products hidden from catalog (Default: `false`)


## Related posts
Bootscore v5.3.1 added a hook to all `single-*.php`'s:

```php
<?php if (function_exists('bootscore_related_posts')) bootscore_related_posts(); ?>
```

bs Swiper hooks related posts there showing the latest 12 posts from the same category. This means that the category should have at least 4 posts to show the related posts correctly.

Related posts can be removed by adding a filter to child's `functions.php`:

```php
// Remove related posts
add_filter('bootscore_disable_related_posts', '__return_true');
```

Or by a single line of CSS:

```css
.related-posts {
  display: none;
}
```

## Overriding templates via theme
Template files can be found within the `/bs-swiper/templates/` plugin directory.

Edit files in an upgrade-safe way using overrides. Copy the template into a directory within your theme named `/bs-swiper/` keeping the same file structure but removing the `/templates/` subdirectory. Path must be `/your-theme/bs-swiper/[file].php`.

The copied file will now override the bs Swiper template file. Change cards, classes or HTML as you want.

### Templates that can be overridden
- `related-posts.php`
- `sc-swiper-card.php`
- `sc-swiper-card-autoplay.php`
- `sc-swiper-card-product.php`
- `sc-swiper-hero.php`
- `sc-swiper-hero-fade.php`

## License & Credits
- bs Swiper, MIT License https://github.com/bootscore/bs-swiper/blob/main/LICENSE
- swiper.js, nolimits4web, MIT License https://github.com/nolimits4web/swiper/blob/master/LICENSE
- Plugin Update Checker, YahnisElsts, MIT License https://github.com/YahnisElsts/plugin-update-checker/blob/master/license.txt
