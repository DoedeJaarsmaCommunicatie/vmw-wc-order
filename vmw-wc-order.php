<?php

/*
Plugin Name: Vmw Wc Order
Description: This plugin adds an after order hook to send orders to the VMW Portal
Version: 1.0
Author: Mitch Hijlkema
License: GPL2
*/

defined('ABSPATH') || exit;

define('VMWCO_FILE', __FILE__);
define('VMWCO_VERSION', '1.0.0');

add_action('woocommerce_thankyou', function ($order_id) {
    include_once plugin_dir_path(VMWCO_FILE) . 'vendor/autoload.php';

    $client = Symfony\Component\HttpClient\HttpClient::create();
    $client->request('GET', 'https://verkoper.vindmijnwijn.nl/webhooks/add-order/' . $order_id);
}, 10, 1);
