=== Custom Add to Cart labels for WooCommerce ===
Contributors: saadiqbal, wpexpertsio
Tags: add to cart, add to cart label, woocommerce, woocommerce add to cart, add to cart text, change add to cart, per product type, single product page, shop page, archive page, change button, change label, button text, buy now, custom button label, woocommerce button, simple product, variable product, grouped product, external product, bookable, subscription
Requires at least: 6.2
Tested up to: 7.0
Stable tag: 1.5.4
WC requires at least: 3.0
WC tested up to: 10.8.1
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Easily customize "Add to Cart" button labels for every WooCommerce product type — on single product pages AND archive/shop pages. No coding required.

== Description ==

Tired of the boring default "Add to Cart" button? Want to say "Buy Now", "Book Today", "Subscribe", or "Get Started" instead?

**Custom Add to Cart labels for WooCommerce** lets you change button text for every product type on single product pages and archive/shop pages. One simple settings page, zero coding, full control.

= What you can customize =

**Single product pages:**
* Simple products → "Buy Now", "Order Now"
* Variable products → "Select Options", "Choose Your Size"
* Grouped products → "View Products", "Choose Items"
* External/Affiliate products → "Shop Now", "Visit Store"
* Bookable products (WooCommerce Bookings) → "Book Now", "Reserve"
* Subscription products → "Subscribe Now", "Join"
* Variable Subscription products → "Choose Plan"

**Archive / Shop pages:**
* Simple products
* Variable products
* Grouped products
* External/Affiliate products
* Bookable products
* Subscription products
* Variable Subscription products

= Features =

* ✅ **Separate labels for single product & archive pages** — different text for each context
* ✅ **Works with WooCommerce 3.0+ through 10.x** — fully backward compatible
* ✅ **HPOS compatible** — works with WooCommerce High-Performance Order Storage
* ✅ **Tested up to WordPress 7.0**
* ✅ **Tested up to WooCommerce 10.8.1**
* ✅ **All product types supported** — Simple, Variable, Grouped, External, Bookable, Subscription, Variable Subscription
* ✅ **Unicode, emoji & special characters** — 🚀 🔥 💥
* ✅ **Graceful fallback** — unsupported product types use WooCommerce defaults
* ✅ **Lightweight** — minimal footprint, no page bloat
* ✅ **No coding required** — configure from WooCommerce settings
* ✅ **Conflict-free** — prefixed filter callbacks avoid plugin clashes

= Perfect for =

* 🏪 eCommerce stores wanting unique CTAs per product type
* 📅 Booking sites that need "Book Now" instead of "Add to Cart"
* 📦 Subscription businesses wanting "Subscribe" buttons
* 🌍 Multilingual stores — easily adapt button text per language
* 🎯 Conversion-focused shops optimizing their call-to-action
* 🔧 Agencies managing multiple client stores with different brand needs

= What makes this plugin different? =

Unlike complex alternatives, this plugin does **one thing well** — change add-to-cart button text. No bloat, no page builders, no confusing UI. Just clean settings, instant results, and lightweight code that won't slow your store.

== Screenshots ==

1. Settings page — WooCommerce > Settings > Products > Change "add to cart" labels
2. Shop page — custom button labels visible on product archive/loop pages
3. Single product page — custom labels on individual product view

== Installation ==

= Automatic Installation =

Go to **Plugins > Add New**, search for "Custom Add to Cart labels for WooCommerce", then install and activate.

= Manual Installation =

1. Download the plugin and upload to your `/wp-content/plugins/` directory
2. Activate the plugin from the WordPress Plugins screen
3. Go to **WooCommerce > Settings > Products > Change "add to cart" labels**
4. Enter your custom labels for each product type
5. Click Save and you're done

= Requirements =

* WordPress 6.2 or higher
* WooCommerce 3.0 or higher
* PHP 7.4 or higher

== Frequently Asked Questions ==

= How do I use special characters or emojis in my label? =

Simply copy and paste them into the input field. The plugin fully supports Unicode, HTML entities, and emoji characters.

= Where can I find emojis to use? =

Check out [Getemoji](https://getemoji.com/) and [Copypastecharacter](https://www.copypastecharacter.com/).

= Will this work with my theme? =

Yes, this plugin works with any WordPress theme that uses standard WooCommerce templates for the add-to-cart button.

= Does it work with WooCommerce Blocks / FSE themes? =

The plugin hooks into WooCommerce's native PHP filter system, which works with classic themes. For block themes using WooCommerce Blocks, the label changes apply on page load but may not reflect inside the block editor preview.

= Does this work on archive/shop pages? =

Yes! You can set separate labels for single product pages AND archive/shop pages (including category, tag, and search pages).

= What product types are supported? =

Simple, Variable, Grouped, External/Affiliate, Bookable (WooCommerce Bookings), Subscription, and Variable Subscription (WooCommerce Subscriptions).

= Does it support HPOS (High-Performance Order Storage)? =

Yes, the plugin is fully compatible with WooCommerce HPOS.

= Can I set different labels for individual products? =

Currently the plugin works per product type. Per-product label customization is under consideration for a future update.

= Will this work with WooCommerce Bookings? =

Yes. Bookable products are fully supported on both single and archive pages.

= How do I reset to default labels? =

Simply clear the custom text fields in **WooCommerce > Settings > Products > Change "add to cart" labels** and save. The plugin will fall back to WooCommerce's default button text.

= Where can I submit issues or request features? =

Submit bug reports and feature requests on our [GitHub Repository](https://github.com/wpexperts/wc-custom-add-to-cart-labels).

= Can I contribute translations? =

Yes! The plugin is translation-ready. Contribute via the [WordPress translation portal](https://translate.wordpress.org/projects/wp-plugins/wc-custom-add-to-cart-labels).

== Developer Hooks ==

The plugin works with WooCommerce's standard add-to-cart text filters:

`woocommerce_product_single_add_to_cart_text` — For single product pages
`woocommerce_product_add_to_cart_text` — For archive/shop pages

Our callbacks use unique prefixed names (`wccatcl_product_single_add_to_cart_text` and `wccatcl_product_loop_add_to_cart_text`) to avoid conflicts with other plugins.

To override programmatically, use a higher priority (lower number):

`add_filter( 'woocommerce_product_single_add_to_cart_text', 'my_custom_function', 5, 2 );`

== Changelog ==

= 1.5.4 =
* Tested up to WordPress 7.0 and WooCommerce 10.8.1
* Confirmed HPOS (High-Performance Order Storage) compatibility
* Performance improvement — added static caching for settings lookups
* Security hardening — added output escaping on button labels
* Fixed i18n — replaced variable-based __() calls with escaped output
* Fixed plugin header to match readme compatibility claims

= 1.5.3 =
* Tested up to WordPress 6.8 and WooCommerce 10.0

= 1.5.2 =
* Changed plugin ownership to WPExperts.io

= 1.5.1 =
* Updated plugin display name

= 1.4.1 =
* Renamed to "Custom Add to Cart labels for WooCommerce" (removed trademark implications)
* Updated all i18n calls to use correct text domain `wc-custom-add-to-cart-labels`
* Prefixed callback functions to avoid plugin conflicts

= 1.4.0 =
* Unsupported product types now fall back to WooCommerce defaults
* Distinct filters for single product and archive pages

= 1.3 =
* Added subscription and variable subscription product support
* Fixed Gutenberg compatibility issue

= 1.1 =
* Added bookable products support

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.5.4 =
This update adds WordPress 7.0 and WooCommerce 10.8.1 compatibility, HPOS compatibility confirmation, and important security hardening for output escaping. We recommend all users update.

= 1.5.3 =
Compatibility update for WordPress 6.8 and WooCommerce 10.0.