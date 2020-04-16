<?php

/*
Plugin Name: Vmw Wc Order
Description: This plugin adds an after order hook to send orders to the VMW Portal
Version: 2.0
Author: Mitch Hijlkema
License: GPL2
*/

defined('ABSPATH') || exit;

define('VMWCO_FILE', __FILE__);
define('VMWCO_VERSION', '1.0.0');

/**
 * Hooks into WooCommerce action to send a request to a Webhook.
 *
 * This function hooks in to `woocommerce_order_status_processing` action to
 * send a request to the vendor portal web hook to start the order cycle
 * Used to be on `woocommerce_thankyou` but that only fires when the
 * order thank you page is called. Which is not 100% guaranteed.
 *
 * @see woocommerce_order_status_processing
 * @param int $order_id The woocommerce order id
 *
 * @returns void
 */
add_action('woocommerce_order_status_processing', static function ($order_id) {
	include_once plugin_dir_path(VMWCO_FILE) . 'vendor/autoload.php';

	try {
		$client = Symfony\Component\HttpClient\HttpClient::create();
		$client->request('GET', 'https://verkoper.vindmijnwijn.nl/webhooks/add-order/' . $order_id);
	} catch (\Exception $e) {
		// Do nothing to interrupt order.
	}
}, 10, 1);
