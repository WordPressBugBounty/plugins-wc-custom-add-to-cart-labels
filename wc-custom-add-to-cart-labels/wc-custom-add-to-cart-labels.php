<?php
/*
 Plugin Name: Custom Add to Cart labels for WooCommerce
 Plugin URI: https://profiles.wordpress.org/wpexpertsio
 Description: This plugin lets you change the "add to cart" labels on single product pages (per product type) and archive/shop pages (per product type).
 Author: WPExperts.io
 Author URI: https://github.com/rynaldos
 Version: 1.5.4
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

    if( ! defined( 'SMTP_EL_VERSION' ) ) {
        add_filter( 'woocommerce_settings_tabs_array', 'catcl_smtp_email_logs_tab', 99 );
        add_action( 'woocommerce_settings_tabs_smtp_email_logs', 'catcl_smtp_email_logs_settings' );
        add_action( 'admin_enqueue_scripts', 'catcl_enqueue_admin_scripts' );
    }

    function catcl_smtp_email_logs_tab( $tabs ) {
        $tabs['smtp_email_logs'] = __( 'SMTP', 'wc-hide-shipping-methods' );

        return $tabs;
    }

    function catcl_smtp_email_logs_settings() {
        ?>
        <style>
        .smtp-providers-list {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            margin-bottom: 32px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .smtp-providers-list h2 {
            font-size: 1.5em;
            margin-bottom: 8px;
            color: #1a1a1a;
        }
        .smtp-provider-row {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 10px;
            margin-bottom: 14px;
            padding: 20px 26px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .smtp-provider-logo {
            width: 38px;
            height: 38px;
            margin-right: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
        .smtp-provider-title {
            font-size: 1.15em;
            font-weight: 700;
            margin-right: 14px;
            color: #1a1a1a;
        }
        .smtp-provider-desc {
            color: #6c757d;
            font-size: 1em;
            flex: 1;
            line-height: 1.4;
        }
        .smtp-provider-status {
            background: linear-gradient(135deg, #ffeaea 0%, #ffe0e0 100%);
            color: #d32f2f;
            font-size: 0.9em;
            padding: 4px 12px;
            border-radius: 8px;
            margin-right: 18px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .smtp-provider-switch {
            margin-right: 14px;
            display: flex;
            align-items: center;
        }
        .smtp-toggle {
            position: relative;
            width: 52px;
            height: 26px;
            background: #e0e0e0;
            border-radius: 13px;
            margin-right: 10px;
            transition: background 0.3s;
            cursor: pointer;
            border: none;
        }
        .smtp-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .smtp-toggle-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: left 0.3s;
        }
        .smtp-toggle input:checked + .smtp-toggle-slider {
            left: 29px;
            background: #4caf50;
        }
        .smtp-toggle-label {
            font-size: 0.9em;
            color: #9e9e9e;
            font-weight: 700;
            margin-left: 2px;
        }
        .smtp-provider-edit {
            color: #4f46e5;
            font-size: 1.3em;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .smtp-provider-edit:hover {
            transform: scale(1.1);
        }
        .smtp-provider-row:hover {
            box-shadow: 0 4px 16px rgba(79, 70, 229, 0.15);
            border-color: #4f46e5;
            transform: translateY(-2px);
        }
        .smtp-blur {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            backdrop-filter: blur(4px);
            display: none;
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .smtp-popup {
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(175deg, #DAD7FF 0%, #FFFFFF 100%);
            border-radius: 16px;
            box-shadow: 0 12px 48px rgba(90, 80, 180, 0.10);
            z-index: 9999;
            padding: 48px 40px 40px 40px;
            min-width: 480px;
            max-width: 92vw;
            display: none;
            animation: popupSlideIn 0.3s ease-out;
        }
        @keyframes popupSlideIn {
            from { 
                opacity: 0;
                transform: translate(-50%, -45%);
            }
            to { 
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }
        .smtp-popup h2 {
            margin-top: 0;
            font-size: 1.9em;
            color: #101517;
        }
        .smtp-popup p {
            font-size: 1.1em;
            color: #101517;
        }
        .smtp-popup .smtp-popup-close {
            position: absolute;
            top: 16px;
            right: 20px;
            font-size: 2.2em;
            color: #7c6fc7;
            cursor: pointer;
            transition: transform 0.2s, color 0.2s;
        }
        .smtp-popup .smtp-popup-close:hover {
            transform: scale(1.1);
            color: #3a2e7a;
        }
        .smtp-popup .smtp-popup-btn {
            background: #873eff;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 18px 42px;
            font-size: 1.2em;
            font-weight: 500;
            margin-top: 24px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(90, 80, 180, 0.10);
            letter-spacing: 0.5px;
        }
        .smtp-popup .smtp-popup-btn:hover {
            background: #5007aa;
            color: #fff;
            box-shadow: 0 6px 20px rgba(90, 80, 180, 0.18);
        }
        .smtp-popup-gradient {
            background: #FFFFFF;
            color: #3a2e7a;
            text-align: center;
        }
        .smtp-popup-logo-container {
            background: linear-gradient(135deg, #edeaff 0%, #f8f9fa 100%);
            width: 96px;
            height: 96px;
            border-radius: 50%;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(90, 80, 180, 0.10), 0 0 0 6px rgba(218,215,255,0.18);
        }
        .smtp-popup-logo-container img {
            width: 60px;
            height: 60px;
        }
        .smtp-popup-heading {
            margin-top: 0;
            font-size: 2.2em;
            font-weight: 600;
            letter-spacing: -1.5px;
            color: #3a2e7a;
            text-shadow: 0 2px 12px rgba(218,215,255,0.18);
        }
        .smtp-popup-tagline {
            font-size: 1.15em;
            opacity: 0.95;
            margin: 16px auto 36px;
            max-width: 460px;
            line-height: 1.5;
            color: #4b3e8a;
        }
        .smtp-popup-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin: 36px 0 50px 0;
            justify-items: stretch;
        }
        .smtp-popup-card {
            background: #ffffff;
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0px 2px 8px rgba(0,0,0,.16);
            transition: all 0.3s;
            border: 1px solid rgba(218,215,255,0.3);
        }
        .smtp-popup-card-icon {
            background: linear-gradient(135deg, #edeaff 0%, #f8f9fa 100%);
            padding: 10px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(90, 80, 180, 0.10);
            flex-shrink: 0;
        }
        .smtp-popup-card-icon img {
            width: 25px;
            display: block;
        }
        .smtp-popup-card-text {
            font-size: 1.12em;
            font-weight: 700;
            text-align: left;
            color: #720EEC;
            text-shadow: 0 1px 4px rgba(218, 215, 255, 0.18);
        }
        .smtp-popup-link {
            text-decoration: none;
        }
        </style>
        <div class="smtp-providers-list">
            <h2>SMTP Providers</h2>
            <p style="color:#666; font-size:1.08em; margin-bottom:18px;">⚠️ Don’t risk losing sales! WooCommerce emails often fail to deliver or go to spam by default. Make sure your order emails reach the inbox — activate reliable email delivery today.</p>
            <div class="smtp-provider-row smtp-provider-office365" onclick="showSmtpProPopup()">
                <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/office365.png" class="smtp-provider-logo" alt="Microsoft 365">
                <span class="smtp-provider-title">Microsoft 365</span>
                <span class="smtp-provider-desc">Send emails using Microsoft 365 with licensed accounts for trusted and secure delivery.</span>
                <span class="smtp-provider-status">INACTIVE</span>
                <span class="smtp-provider-switch">
                    <label class="smtp-toggle">
                        <input type="checkbox" disabled>
                        <span class="smtp-toggle-slider"></span>
                    </label>
                    <span class="smtp-toggle-label">OFF</span>
                </span>
                <span class="smtp-provider-edit">&#9998;</span>
            </div>
            <div class="smtp-provider-row smtp-provider-gmail" onclick="showSmtpProPopup()">
                <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/gmail.png" class="smtp-provider-logo" alt="Gmail">
                <span class="smtp-provider-title">Gmail</span>
                <span class="smtp-provider-desc">Secure Gmail API email delivery with a fast setup and high reliability.</span>
                <span class="smtp-provider-status">INACTIVE</span>
                <span class="smtp-provider-switch">
                    <label class="smtp-toggle">
                        <input type="checkbox" disabled>
                        <span class="smtp-toggle-slider"></span>
                    </label>
                    <span class="smtp-toggle-label">OFF</span>
                </span>
                <span class="smtp-provider-edit">&#9998;</span>
            </div>
            <div class="smtp-provider-row smtp-provider-brevo" onclick="showSmtpProPopup()">
                <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/brevo.png" class="smtp-provider-logo" alt="Brevo">
                <span class="smtp-provider-title">Brevo</span>
                <span class="smtp-provider-desc">Send emails daily via Brevo SMTP, ideal for lower-volume email delivery.</span>
                <span class="smtp-provider-status">INACTIVE</span>
                <span class="smtp-provider-switch">
                    <label class="smtp-toggle">
                        <input type="checkbox" disabled>
                        <span class="smtp-toggle-slider"></span>
                    </label>
                    <span class="smtp-toggle-label">OFF</span>
                </span>
                <span class="smtp-provider-edit">&#9998;</span>
            </div>
            <div class="smtp-provider-row smtp-provider-smtp" onclick="showSmtpProPopup()">
                <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/smtp.png" class="smtp-provider-logo" alt="SMTP">
                <span class="smtp-provider-title">Other SMTP</span>
                <span class="smtp-provider-desc">Connect any SMTP service for a flexible setup and reliable email sending.</span>
                <span class="smtp-provider-status">INACTIVE</span>
                <span class="smtp-provider-switch">
                    <label class="smtp-toggle">
                        <input type="checkbox" disabled>
                        <span class="smtp-toggle-slider"></span>
                    </label>
                    <span class="smtp-toggle-label">OFF</span>
                </span>
                <span class="smtp-provider-edit">&#9998;</span>
            </div>
        </div>
        <div class="smtp-blur" id="smtpBlur"></div>
        <div class="smtp-popup smtp-popup-gradient" id="smtpPopup">
            <span class="smtp-popup-close" onclick="closeSmtpProPopup()">&times;</span>
            <div class="smtp-popup-logo-container">
                <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/logo.webp" alt="SMTP Pro">
            </div>
            <h2 class="smtp-popup-heading">SMTP & Email Logs for WooCommerce</h2>
            <p class="smtp-popup-tagline">Unlock professional email delivery and never miss a customer order again!</p>
            <div class="smtp-popup-grid">
                <div class="smtp-popup-card">
                    <div class="smtp-popup-card-icon">
                        <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/office365.png">
                    </div>
                    <span class="smtp-popup-card-text">Microsoft SMTP</span>
                </div>
                <div class="smtp-popup-card">
                    <div class="smtp-popup-card-icon">
                        <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/gmail.png">
                    </div>
                    <span class="smtp-popup-card-text">Gmail SMTP</span>
                </div>
                <div class="smtp-popup-card">
                    <div class="smtp-popup-card-icon">
                        <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/brevo.png">
                    </div>
                    <span class="smtp-popup-card-text">Brevo SMTP</span>
                </div>
                <div class="smtp-popup-card">
                    <div class="smtp-popup-card-icon">
                        <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/images/smtp.png">
                    </div>
                    <span class="smtp-popup-card-text">Other SMTP</span>
                </div>
            </div>
            <a href="https://woocommerce.com/products/smtp-and-email-logs/?utm_source=plugin&utm_medium=wc_custom_add_to_cart_labels&utm_campaign=settings_tab" target="_blank" class="smtp-popup-link smtp-popup-btn">Get Started Now</a>
        </div>
        <script>
        function showSmtpProPopup() {
            document.getElementById('smtpBlur').style.display = 'block';
            document.getElementById('smtpPopup').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        function closeSmtpProPopup() {
            document.getElementById('smtpBlur').style.display = 'none';
            document.getElementById('smtpPopup').style.display = 'none';
            document.body.style.overflow = '';
        }
        document.getElementById('smtpBlur').addEventListener('click', closeSmtpProPopup);
        </script>
        <?php
    }

    /**
     * Enqueue admin scripts and add JavaScript alert
     */
    function catcl_enqueue_admin_scripts( $hook ) {
        // Only load on WooCommerce settings pages
        if ( 'woocommerce_page_wc-settings' === $hook ) {
            ?>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function() {
                    // Find the SMTP tab by its text content
                    var tabs = document.querySelectorAll('.woo-nav-tab-wrapper .nav-tab');
                    tabs.forEach(function(tab) {
                        if (tab.textContent.trim() === 'SMTP') {
                        // Create the badge element
                        var badge = document.createElement('span');
                        badge.textContent = 'Premium';
                        badge.style.background = '#873eff';
                        badge.style.color = '#fff';
                        badge.style.fontSize = '11px';
                        badge.style.padding = '2px 6px';
                        badge.style.marginLeft = '6px';
                        badge.style.borderRadius = '8px';
                        badge.style.verticalAlign = 'middle';
                        badge.style.fontWeight = 'bold';
                        // Add the badge after the tab
                        tab.appendChild(badge);
                        }
                    });
                });
            </script>
            <?php
        }
    }

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
