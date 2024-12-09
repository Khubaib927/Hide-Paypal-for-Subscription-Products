<?php
/**
 * Plugin Name: Hide PayPal for WooCommerce Subscriptions
 * Plugin URI: https://github.com/codesfix/hide-paypal-subscriptions
 * Description: Automatically hides PayPal payment gateway for subscription products in WooCommerce
 * Version: 1.0.0
 * Author: CodesFix
 * Author URI: https://codesfix.net
 * Text Domain: hide-paypal-subscriptions
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * WC requires at least: 3.0
 * WC tested up to: 8.5
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('HPS_VERSION', '1.0.0');
define('HPS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('HPS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Main plugin class
class Hide_PayPal_Subscriptions {
    
    // Constructor
    public function __construct() {
        // Check if WooCommerce is active
        if ($this->check_woocommerce()) {
            add_filter('woocommerce_available_payment_gateways', array($this, 'hide_paypal_for_subscriptions'), 100, 1);
            add_action('admin_notices', array($this, 'admin_notices'));
        }
    }

    // Check if WooCommerce is active
    private function check_woocommerce() {
        return in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));
    }

    // Main function to hide PayPal
    public function hide_paypal_for_subscriptions($available_gateways) {
        // Early exit if no gateways
        if (!is_array($available_gateways)) {
            return $available_gateways;
        }

        // Check if WooCommerce is active
        if (!function_exists('WC') || !WC()->cart) {
            return $available_gateways;
        }

        // PayPal gateway IDs specific to Payment Plugins for PayPal
        $paypal_gateway_ids = [
            'ppcp_payments',  // Main PayPal gateway
            'ppcp',          // Standard PayPal
            'ppcp_cc',       // Credit Card
            'ppcp_pay_later' // Pay Later
        ];

        $has_subscription = false;

        // Check cart for subscription products
        foreach (WC()->cart->get_cart() as $cart_item) {
            $product = $cart_item['data'];
            
            // Specific check for simple subscription
            if ($product->get_type() === 'subscription' || 
                $product->get_type() === 'simple_subscription' ||
                (function_exists('wcs_is_subscription_product') && wcs_is_subscription_product($product))) {
                $has_subscription = true;
                break;
            }
        }

        // If subscription found, remove PayPal gateways
        if ($has_subscription) {
            foreach ($paypal_gateway_ids as $gateway_id) {
                if (isset($available_gateways[$gateway_id])) {
                    unset($available_gateways[$gateway_id]);
                }
            }

            // Ensure Stripe remains if it's available
            if (isset($available_gateways['stripe']) && empty($available_gateways)) {
                return ['stripe' => $available_gateways['stripe']];
            }
        }

        return $available_gateways;
    }

    // Admin notices
    public function admin_notices() {
        if (!class_exists('WooCommerce')) {
            ?>
            <div class="notice notice-error">
                <p><?php _e('Hide PayPal for Subscriptions requires WooCommerce to be installed and activated.', 'hide-paypal-subscriptions'); ?></p>
            </div>
            <?php
        }
    }
}

// Initialize the plugin
function hide_paypal_subscriptions_init() {
    new Hide_PayPal_Subscriptions();
}
add_action('plugins_loaded', 'hide_paypal_subscriptions_init');
