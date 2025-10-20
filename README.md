# bs Swiper - WordPress Swiper Slider Plugin

[![Packagist Prerelease](https://img.shields.io/packagist/vpre/bootscore/bs-swiper?logo=packagist&logoColor=fff)](https://packagist.org/packages/bootscore/bs-swiper)
[![Github All Releases](https://img.shields.io/github/downloads/bootscore/bs-swiper/total.svg)](https://github.com/bootscore/bs-swiper/releases)


A powerful and flexible WordPress plugin that integrates Swiper.js to create beautiful, responsive sliders for posts, pages, products, and any custom post type.

## Features

- 🎨 **Two Layout Types**: `columns` (multi-column cards) and `heroes` (full-width slides)
- 🛒 **WooCommerce Support**: Built-in product slider with advanced filtering options
- 🎯 **Custom Post Types**: Works with any post type, not just posts and pages
- 🏷️ **Advanced Filtering**: Filter by taxonomies, terms, categories, IDs, parent pages
- ⚡ **Visual Effects**: Multiple Swiper effects including fade, cube, coverflow, flip, cards, creative
- 📱 **Fully Responsive**: Custom breakpoints for different screen sizes
- 🎨 **Highly Customizable**: Extensive filter and action hooks for developers
- 🔄 **Child Theme Support**: All templates can be overridden in child themes
- 🎯 **Context-Aware**: Use context parameter to target specific sliders with filters

## Installation

1. Upload the plugin files to `/wp-content/plugins/bs-swiper/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the shortcode in your posts, pages, or widgets

## Basic Usage

### Simple Post Slider
```
[bs-swiper layout="columns" type="post" posts="6"]
```

### Product Slider
```
[bs-swiper layout="columns" type="product" posts="8"]
```

### Hero Slider with Fade Effect
```
[bs-swiper layout="heroes" type="post" effect="fade" autoplay="true"]
```

## Shortcode Parameters

### Layout & Type

| Parameter | Default | Description | Values |
|-----------|---------|-------------|--------|
| `layout` | `columns` | Slider layout type | `columns`, `heroes` |
| `type` | `post` | Post type to display | `post`, `page`, `product`, or any custom post type |

### Content Filtering

| Parameter | Default | Description | Example |
|-----------|---------|-------------|---------|
| `posts` | `-1` | Number of posts to display | `posts="6"` |
| `order` | `DESC` | Sort order | `order="ASC"` |
| `orderby` | `date` | Order by field | `orderby="title"` |
| `category` | - | Filter by category slug | `category="news"` |
| `tax` | - | Custom taxonomy | `tax="product_cat"` |
| `terms` | - | Taxonomy terms (comma-separated) | `terms="electronics,gadgets"` |
| `id` | - | Specific post IDs (comma-separated) | `id="1,5,12"` |
| `post_parent` | - | Filter by parent page ID | `post_parent="10"` |

### WooCommerce-Specific Parameters

| Parameter | Default | Description | Example |
|-----------|---------|-------------|---------|
| `featured` | - | Show only featured products | `featured="true"` |
| `onsale` | - | Show only products on sale | `onsale="true"` |
| `outofstock` | - | Include out of stock products | `outofstock="true"` (default hides them) |
| `showhidden` | `false` | Show products hidden from catalog | `showhidden="true"` |

### Display Options

| Parameter | Default | Description | Values |
|-----------|---------|-------------|--------|
| `categories` | `true` | Show category badges | `true`, `false` |
| `meta` | `true` | Show post meta (date, author, etc.) | `true`, `false` |
| `excerpt` | `true` | Show post excerpt | `true`, `false` |
| `readmore` | `true` | Show read more link | `true`, `false` |
| `tags` | `true` | Show post tags | `true`, `false` |

### Slider Behavior

| Parameter | Default | Description | Values |
|-----------|---------|-------------|--------|
| `slidesperview` | Auto | Slides per view at breakpoints | `1,1,2,3,4,4` or `auto` |
| `effect` | `slide` | Transition effect | `slide`, `fade`, `cube`, `coverflow`, `flip`, `cards`, `creative`, `auto` |
| `loop` | `false` | Enable continuous loop | `true`, `false` |
| `autoplay` | `false` | Enable autoplay | `true`, `false` |
| `delay` | `4000` | Autoplay delay in milliseconds | `delay="3000"` |
| `spacebetween` | `24` (columns)<br>`0` (heroes) | Space between slides in pixels | `spacebetween="30"` |
| `speed` | `300` | Transition speed in milliseconds | `speed="500"` |
| `navigation` | `true` | Show navigation arrows | `true`, `false` |
| `pagination` | `true` | Show pagination dots | `true`, `false` |

### Advanced Options

| Parameter | Default | Description | Example |
|-----------|---------|-------------|---------|
| `context` | - | Context identifier for filtering | `context="homepage-slider"` |

## Responsive Breakpoints

The `slidesperview` parameter accepts 6 comma-separated values corresponding to Bootstrap breakpoints:

1. **0px** (xs)
2. **576px** (sm)
3. **768px** (md)
4. **992px** (lg)
5. **1200px** (xl)
6. **1400px** (xxl)

### Example
```
[bs-swiper slidesperview="1,1,2,3,4,4"]
```

This displays:
- 1 slide on mobile (xs, sm)
- 2 slides on tablets (md)
- 3 slides on small desktops (lg)
- 4 slides on large desktops (xl, xxl)

## Effect Notes

Some effects only support single slide view:
- `fade` - Cross-fade transition
- `cube` - 3D cube rotation
- `flip` - 3D flip effect
- `cards` - Cards stack effect

These effects will automatically force `slidesperview="1"` regardless of your setting.

Effects that support multiple slides:
- `slide` - Default sliding transition
- `coverflow` - 3D coverflow effect
- `creative` - Custom creative transitions
- `auto` - Automatic width

## Usage Examples

### Blog Posts Slider
```
[bs-swiper layout="columns" type="post" category="tutorials" posts="8" slidesperview="1,1,2,3,4,4"]
```

### Featured Products
```
[bs-swiper layout="columns" type="product" featured="true" posts="12" slidesperview="1,2,3,4,5,5"]
```

### On-Sale Products with Brand Filter
```
[bs-swiper layout="columns" type="product" tax="product_brand" terms="nike,adidas" onsale="true" outofstock="false"]
```

### Hero Slider with Fade Effect
```
[bs-swiper layout="heroes" type="post" category="featured" effect="fade" autoplay="true" delay="5000" posts="5"]
```

### Custom Post Type Slider
```
[bs-swiper layout="columns" type="portfolio" tax="portfolio_category" terms="web-design" slidesperview="1,1,2,2,3,3"]
```

### Coverflow Effect Product Slider
```
[bs-swiper layout="columns" type="product" effect="coverflow" slidesperview="1,1,2,3,3,3" spacebetween="50"]
```

### Minimal Slider with Context
```
[bs-swiper layout="columns" type="post" context="tailwind-cards" meta="false" tags="false" readmore="false" slidesperview="1,1,2,3,3,3"]
```

## Developer Customization

### Available Filters

The plugin provides extensive filter hooks for customization. All filters pass a context parameter (second argument) for targeted modifications.

#### Wrapper Classes
```php
// Modify wrapper classes
add_filter('bootscore/bs-swiper/class/wrapper', 'custom_wrapper_class', 10, 2);
function custom_wrapper_class($class, $context) {
    return $class . ' my-custom-class';
}

// Modify navigation padding (columns layout only)
add_filter('bootscore/bs-swiper/class/wrapper/padding-x', 'custom_nav_padding', 10, 2);
function custom_nav_padding($class, $context) {
    if ($context === 'bs-swiper-columns') {
        return 'px-xl-5'; // Only add padding on xl screens
    }
    return $class;
}

// Modify pagination padding (columns layout only)
add_filter('bootscore/bs-swiper/class/wrapper/padding-bottom', 'custom_pagination_padding', 10, 2);
```

#### Card Classes (Columns Template)
```php
// Modify card wrapper class
add_filter('bootscore/class/loop/card', 'custom_card_class', 10, 2);
function custom_card_class($class, $context) {
    if ($context === 'bs-swiper-columns') {
        return 'card shadow-sm h-100';
    }
    return $class;
}

// Modify card image class
add_filter('bootscore/class/loop/card/image', 'custom_card_image', 10, 2);

// Modify card body class
add_filter('bootscore/class/loop/card/body', 'custom_card_body', 10, 2);

// Modify card title class
add_filter('bootscore/class/loop/card/title', 'custom_card_title', 10, 2);

// Modify card title link class
add_filter('bootscore/class/loop/card/title/link', 'custom_title_link', 10, 2);

// Modify excerpt class
add_filter('bootscore/class/loop/card-text/excerpt', 'custom_excerpt', 10, 2);

// Modify excerpt link class
add_filter('bootscore/class/loop/card-text/excerpt/link', 'custom_excerpt_link', 10, 2);

// Modify read more wrapper class
add_filter('bootscore/class/loop/card-text/read-more', 'custom_read_more_wrapper', 10, 2);

// Modify read more link class
add_filter('bootscore/class/loop/read-more', 'custom_read_more_link', 10, 2);

// Modify read more text
add_filter('bootscore/loop/read-more/text', 'custom_read_more_text');
function custom_read_more_text($text) {
    return __('Continue Reading →', 'textdomain');
}
```

#### Navigation Classes
```php
// Modify navigation wrapper classes
add_filter('bootscore/bs-swiper/class/navigation', 'custom_navigation_class', 10, 2);
```

### Using Context for Targeted Customization

The `context` parameter allows you to target specific sliders:
```
[bs-swiper type="post" context="homepage-slider" ...]
[bs-swiper type="post" context="sidebar-slider" ...]
```

Then in your functions.php:
```php
// Only affect homepage slider
add_filter('bootscore/class/loop/card', 'homepage_card_style', 10, 2);
function homepage_card_style($class, $context) {
    // Check global context variable
    if (!empty($GLOBALS['bs_swiper_context']) && $GLOBALS['bs_swiper_context'] === 'homepage-slider') {
        return 'card border-0 shadow-lg';
    }
    return $class;
}
```

### Available Actions
```php
// Before thumbnail
do_action('bootscore_before_loop_thumbnail', 'bs-swiper-columns');

// After thumbnail
do_action('bootscore_after_loop_thumbnail', 'bs-swiper-columns');

// Before title
do_action('bootscore_before_loop_title', 'bs-swiper-columns');

// After title
do_action('bootscore_after_loop_title', 'bs-swiper-columns');

// After tags
do_action('bootscore_after_loop_tags', 'bs-swiper-columns');

// After card body
do_action('bootscore_loop_item_after_card_body', 'bs-swiper-columns');
```

### Example: Add Custom Content
```php
// Add custom badge after thumbnail
add_action('bootscore_after_loop_thumbnail', 'add_custom_badge', 10, 1);
function add_custom_badge($context) {
    if ($context === 'bs-swiper-columns') {
        echo '<div class="position-absolute top-0 end-0 m-2">';
        echo '<span class="badge bg-danger">New</span>';
        echo '</div>';
    }
}
```

## Template Override

You can override templates by copying them to your child theme:

**Plugin Location:**
```
/wp-content/plugins/bs-swiper/templates/columns.php
/wp-content/plugins/bs-swiper/templates/columns-wc-products.php
/wp-content/plugins/bs-swiper/templates/heroes.php
/wp-content/plugins/bs-swiper/templates/heroes-wc-products.php
```

**Child Theme Location:**
```
/wp-content/themes/your-child-theme/bs-swiper/columns.php
/wp-content/themes/your-child-theme/bs-swiper/columns-wc-products.php
/wp-content/themes/your-child-theme/bs-swiper/heroes.php
/wp-content/themes/your-child-theme/bs-swiper/heroes-wc-products.php
```

## Template Variables

Inside template files, you have access to:

- `$atts_local` - Array of all shortcode attributes
- Standard WordPress template tags (`the_title()`, `the_permalink()`, etc.)

### Example Template Usage
```php
<?php if ($atts_local['categories'] === 'true') : ?>
    <!-- Show categories -->
<?php endif; ?>

<?php if ($atts_local['meta'] === 'true' && get_post_type() === 'post') : ?>
    <!-- Show post meta -->
<?php endif; ?>
```


## Credits

- Built with [Swiper.js](https://swiperjs.com/)
- Designed for [Bootscore WordPress Theme](https://bootscore.me/)

## License

This plugin is licensed under MIT.
