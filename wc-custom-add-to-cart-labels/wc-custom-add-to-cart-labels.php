<?php
/*
 Plugin Name: Custom Add to Cart labels for WooCommerce
 Plugin URI: https://profiles.wordpress.org/wpexpertsio
 Description: This plugin lets you change the "add to cart" labels on single product pages (per product type) and archive/shop pages (per product type).
 Author: WPExperts.io
 Author URI: https://github.com/rynaldos
 Version: 1.5.5
 License: GPLv3 or later License
 Requires at least: 6.2
 Tested up to: 7.0
 License: GPLv3 or later
 License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active.
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    /**
     * Add settings section.
     */
    function catcl_section( $sections ) {
        $sections['catcl_section'] = __( 'Add to cart button labels', 'wc-custom-add-to-cart-labels' );
        return $sections;
    }
    add_filter( 'woocommerce_get_sections_products', 'catcl_section' );

    /**
     * Register settings for the plugin.
     */
    function catcl_settings( $settings, $current_section ) {
        if ( 'catcl_section' === $current_section ) {
            $catcl_settings = array();

            // Settings for single product pages
            $catcl_settings[] = array(
                'title' => __( 'Change the "add to cart" button label on single product pages (per product type)', 'wc-custom-add-to-cart-labels' ),
                'type'  => 'title',
                'id'    => 'wc_atc_change_single'
            );

            $catcl_settings[] = array(
                'title'       => __( 'Simple products', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on the single product page for simple products', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'simple_button_text_single',
                'type'        => 'text',
                'placeholder' => 'Add to cart',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'Grouped products', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on the single product page for grouped products', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'grouped_button_text_single',
                'type'        => 'text',
                'placeholder' => 'Add to cart',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'External products', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on the single product page for external products', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'external_button_text_single',
                'type'        => 'text',
                'placeholder' => 'Add to cart',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'Variable products', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on the single product page for variable products', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'variable_button_text_single',
                'type'        => 'text',
                'placeholder' => 'Add to cart',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'Bookable products', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on the single product page for bookable products', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'booking_button_text_single',
                'type'        => 'text',
                'placeholder' => 'Add to cart',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'Subscription products', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on the single product page for subscription products', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'subs_button_text_single',
                'type'        => 'text',
                'placeholder' => 'Sign up now',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'Variable subscription products', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on the single product page for variable subscription products', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'subs_var_button_text_single',
                'type'        => 'text',
                'placeholder' => 'Sign up now',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array( 'type' => 'sectionend', 'id' => 'wc_atc_change_single' );

            // Settings for archive/shop pages
            $catcl_settings[] = array(
                'title' => __( 'Change the "add to cart" button label on archive/shop pages (per product type)', 'wc-custom-add-to-cart-labels' ),
                'type'  => 'title',
                'id'    => 'wc_atc_change_archive'
            );
            $catcl_settings[] = array(
                'title'       => __( 'Simple products (archive)', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on simple products shown on the archive page', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'simple_button_text',
                'type'        => 'text',
                'placeholder' => 'Add to cart',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'Grouped products (archive)', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on grouped products shown on the archive page', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'grouped_button_text',
                'type'        => 'text',
                'placeholder' => 'Add to cart',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'External products (archive)', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on external products shown on the archive page', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'external_button_text',
                'type'        => 'text',
                'placeholder' => 'Add to cart',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'Variable products (archive)', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on variable products shown on the archive page', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'variable_button_text',
                'type'        => 'text',
                'placeholder' => 'Add to cart',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'Bookable products (archive)', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on bookable products shown on the archive page', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'booking_button_text',
                'type'        => 'text',
                'placeholder' => 'Add to cart',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'Subscription products (archive)', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on subscription products shown on the archive page', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'subs_button_text',
                'type'        => 'text',
                'placeholder' => 'Sign up now',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array(
                'title'       => __( 'Variable subscription products (archive)', 'wc-custom-add-to-cart-labels' ),
                'desc'        => __( 'This will change the "add to cart" label on variable subscription products shown on the archive page', 'wc-custom-add-to-cart-labels' ),
                'id'          => 'subs_var_button_text',
                'type'        => 'text',
                'placeholder' => 'Sign up now',
                'css'         => 'min-width:350px;',
            );
            $catcl_settings[] = array( 'type' => 'sectionend', 'id' => 'wc_atc_change_archive' );
            return $catcl_settings;
        } else {
            return $settings;
        }
    }
    add_filter( 'woocommerce_get_settings_products', 'catcl_settings', 10, 2 );

    /**
     * Retrieve the custom setting value for a given key.
     * If no custom value is set, return an empty string so that the default text is used.
     */
    function catcl_get_settings( $key ) {
        $saved = get_option( $key );
        return ( $saved && '' != $saved ) ? $saved : '';
    }

    /**
     * Callback for single product add-to-cart text.
     */
    function wccatcl_product_single_add_to_cart_text( $text, $product ) {
        if ( ! is_object( $product ) ) {
            return $text;
        }

        $product_type = $product->get_type();
        $custom_text = '';

        switch ( $product_type ) {
            case 'simple':
                $custom_text = catcl_get_settings( 'simple_button_text_single' );
                break;
            case 'grouped':
                $custom_text = catcl_get_settings( 'grouped_button_text_single' );
                break;
            case 'external':
                $custom_text = catcl_get_settings( 'external_button_text_single' );
                break;
            case 'variable':
                $custom_text = catcl_get_settings( 'variable_button_text_single' );
                break;
            case 'booking':
                $custom_text = catcl_get_settings( 'booking_button_text_single' );
                break;
            case 'subscription':
                $custom_text = catcl_get_settings( 'subs_button_text_single' );
                break;
            case 'variable-subscription':
                $custom_text = catcl_get_settings( 'subs_var_button_text_single' );
                break;
            default:
                // For non-explicitly supported types, return default WooCommerce text.
                return $text;
        }
        return ( '' !== $custom_text ) ? __( $custom_text, 'wc-custom-add-to-cart-labels' ) : $text;
    }
    add_filter( 'woocommerce_product_single_add_to_cart_text', 'wccatcl_product_single_add_to_cart_text', 10, 2 );
    add_filter( 'woocommerce_booking_single_add_to_cart_text', 'wccatcl_product_single_add_to_cart_text', 10, 2 );

    /**
     * Callback for loop/archive add-to-cart text.
     */
    function wccatcl_product_loop_add_to_cart_text( $text, $product ) {
        if ( ! is_object( $product ) ) {
            return $text;
        }

        $product_type = $product->get_type();
        $custom_text = '';

        switch ( $product_type ) {
            case 'simple':
                $custom_text = catcl_get_settings( 'simple_button_text' );
                break;
            case 'grouped':
                $custom_text = catcl_get_settings( 'grouped_button_text' );
                break;
            case 'external':
                $custom_text = catcl_get_settings( 'external_button_text' );
                break;
            case 'variable':
                $custom_text = catcl_get_settings( 'variable_button_text' );
                break;
            case 'booking':
                $custom_text = catcl_get_settings( 'booking_button_text' );
                break;
            case 'subscription':
                $custom_text = catcl_get_settings( 'subs_button_text' );
                break;
            case 'variable-subscription':
                $custom_text = catcl_get_settings( 'subs_var_button_text' );
                break;
            default:
                return $text;
        }
        return ( '' !== $custom_text ) ? __( $custom_text, 'wc-custom-add-to-cart-labels' ) : $text;
    }
    add_filter( 'woocommerce_product_add_to_cart_text', 'wccatcl_product_loop_add_to_cart_text', 10, 2 );
}
