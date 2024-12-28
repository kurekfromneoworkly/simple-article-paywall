<?php
/*
Plugin Name: Simple Article Paywall
Description: Paywall system for blog posts with WooCommerce integration
Version: 1.0
Author: Juraj Augustín Kurek
*/

if (!defined('ABSPATH')) {
    exit;
}

define('SAP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SAP_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once SAP_PLUGIN_PATH . 'includes/class-sap-admin.php';
require_once SAP_PLUGIN_PATH . 'includes/class-sap-public.php';
require_once SAP_PLUGIN_PATH . 'includes/class-sap-woocommerce.php';

function sap_init() {
    new SAP_Admin();
    new SAP_Public();
    new SAP_WooCommerce();
}
add_action('plugins_loaded', 'sap_init');

register_activation_hook(__FILE__, 'sap_activate');
function sap_activate() {
    // Create necessary database tables if needed
}

register_deactivation_hook(__FILE__, 'sap_deactivate');
function sap_deactivate() {
    // Clean up if needed
}