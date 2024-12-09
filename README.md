=== Hide PayPal for WooCommerce Subscriptions ===
Contributors: codesfix
Tags: woocommerce, paypal, subscriptions, payments
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.0.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically hides PayPal payment gateway for subscription products in WooCommerce.

== Description ==
This plugin automatically removes PayPal payment options when customers have subscription products in their cart, while keeping other payment methods (like Stripe) available. This is useful when you want to restrict subscription payments to specific payment gateways.

= Features =
* Automatically hides all PayPal payment options for subscription products
* Keeps other payment gateways available
* Compatible with simple subscription products
* Works with Payment Plugins for PayPal WooCommerce
* Lightweight and easy to install

= Requirements =
* WordPress 5.0 or higher
* WooCommerce 3.0 or higher
* Payment Plugins for PayPal WooCommerce
* WooCommerce Subscriptions

== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/hide-paypal-subscriptions` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. No additional configuration needed - it works automatically

== Frequently Asked Questions ==
= Does this plugin work with other PayPal plugins? =
This plugin is specifically designed to work with "Payment Plugins for PayPal WooCommerce". It may work with other PayPal plugins but is not guaranteed.

= Will this affect regular products? =
No, PayPal will remain available for all non-subscription products.

= Where can I get support? =
For support, please visit https://codesfix.net or create an issue on our GitHub repository.

== Changelog ==
= 1.0.0 =
* Initial release

== Upgrade Notice ==
= 1.0.0 =
Initial release
