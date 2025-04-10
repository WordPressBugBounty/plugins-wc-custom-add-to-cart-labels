=== Custom Add to Cart labels for WooCommerce ===

Contributors: rynald0s
Tags: add to cart, add to cart label, woocommerce, woocommerce add to cart, add to cart text, change add to cart, per product type, single product, single product page, archives, shop page, change button, change label, button label, simple, variable, grouped, external
Requires at least: 6.2
Tested up to: 6.7
Stable tag: 1.5.1
WC requires at least: 3.0
WC tested up to: 9.7
License: GPLv3 or later License
URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin lets you change the “add to cart” labels on all single product pages (per product type) and also on archive/shop page (per product type)


== Description ==

This plugin lets you customize the “add to cart” button labels on single product pages (per product type) and also on archive/shop page (per product type)

= Single products = 

* Simple products
* Variable products
* Grouped products
* External products
* Bookable products
* Subscription products

= Archive pages = 

* Simple products
* Variable products
* Grouped products
* External products
* Bookable products
* Subscription products

= Features = 

* Compatible with latest WooCommerce (3.0.0 and up) 
* Supports ASCII special characters in labels
* Supports Unicode characters in labels
* Supports HTML5 characters in labels
* Supports Emojis in labels (http://getemoji.com/ and http://www.copypastecharacter.com/emojis)


== Installation ==

1. Download the plugin & install it to your `wp-content/plugins` folder (or use the Plugins menu through the WordPress Administration section)
2. Activate the plugin
3. Navigate to ** WooCommerce > Settings > Products > Change “add to cart” labels **.
4. Customise your labels.
5. Save and enjoy!


== Frequently Asked Questions ==

= Q: How do I use special characters / emojis in my label?  =
A: Copy / paste them into the label field

= Q: Where can I find emojis to use in my label?  =
A: See: [Getemoji](http://getemoji.com/) and [Copypastecharacter](http://www.copypastecharacter.com/emojis)

= Q: Where can I go if I find an issue or want to recommend a feature? =
A: You can submit a issues / feature requests on the [Public GitHub Repository](). 

== Screenshots ==

1. Settings
2. Shop page
3. Single product page


== Changelog ==

= 1.0  =  
* first release

= 1.1 = 
* added support for bookable products

= 1.3 =
* Added support for subscription and subscription variable products
* Fixed Call to a member function get_type() on null issue with Gutenberg

= 1.4.0 =
* Reverted back to prior working release.
* For product types that aren’t explicitly supported or don’t have custom settings defined, the plugin now falls back to the default WooCommerce add-to-cart text.
* Implemented distinct filters and callback functions for single product pages and archive/shop (loop) pages, ensuring that each context can have its own custom label configuration.

= 1.4.1 =

* Updated display name from WC Custom Add to Cart labels to Custom Add to Cart labels for WooCommerce to remove trademark implications.
* Bumped plugin version from 1.4.0 to 1.4.1 and added new header fields:
* Updated all internationalization calls to use the correct text domain wc-custom-add-to-cart-labels.
* Renamed callback functions for add-to-cart text from generic names (e.g., custom_woocommerce_product_single_add_to_cart_text) to unique prefixed names (wccatcl_product_single_add_to_cart_text and wccatcl_product_loop_add_to_cart_text) to avoid conflicts.

= 1.5.1 =

* Updated plugin name