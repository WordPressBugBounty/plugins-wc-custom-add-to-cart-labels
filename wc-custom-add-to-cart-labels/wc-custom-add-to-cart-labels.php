<?php

/*
 Plugin Name: WC Custom Add to Cart labels
 Plugin URI: https://profiles.wordpress.org/rynald0s
 Description: Customize add-to-cart labels and styles for each WooCommerce product type. Easily adjust button text, colors, font size, borders, and border radius on single product and shop/archive pages via a dedicated WooCommerce settings tab. 
 Author: Rynaldo Stoltz
 Author URI: https://orcawp.com
 Version: 1.5
 License: GPLv3 or later License
 URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check if WooCommerce is active.
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    return;
}

// Define plugin constants.
define( 'WC_CUSTOM_ATC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WC_CUSTOM_ATC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include our required classes.
if ( ! class_exists( 'WC_Custom_ATC_Admin' ) ) {
    require_once WC_CUSTOM_ATC_PLUGIN_DIR . 'includes/class-wc-custom-atc-admin.php';
}
if ( ! class_exists( 'WC_Custom_ATC_Frontend' ) ) {
    require_once WC_CUSTOM_ATC_PLUGIN_DIR . 'includes/class-wc-custom-atc-frontend.php';
}

// Initialize the plugin.
add_action( 'plugins_loaded', 'wc_custom_atc_init' );
function wc_custom_atc_init() {
    WC_Custom_ATC_Admin::init();
    WC_Custom_ATC_Frontend::init();
}
