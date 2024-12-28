<?php
if (!defined('ABSPATH')) {
    exit;
}

class SAP_WooCommerce {
    public function __construct() {
        // WooCommerce specific hooks
    }

    public static function create_article_access_product($post_id) {
        $product = new WC_Product_Simple();
        $product->set_name('24h Access to Article: ' . get_the_title($post_id));
        $product->set_regular_price('0.50');
        $product->set_virtual(true);
        $product->save();
        
        update_post_meta($post_id, '_article_product_id', $product->get_id());
        
        return $product->get_id();
    }

    public static function has_user_article_access($post_id) {
        if (!is_user_logged_in()) {
            return false;
        }

        $user_id = get_current_user_id();
        $product_id = get_post_meta($post_id, '_article_product_id', true);
        
        if (!$product_id) {
            return false;
        }

        $orders = wc_get_orders(array(
            'customer_id' => $user_id,
            'status' => 'completed',
            'date_created' => '>' . (time() - 24 * 60 * 60)
        ));

        foreach ($orders as $order) {
            foreach ($order->get_items() as $item) {
                if ($item->get_product_id() == $product_id) {
                    return true;
                }
            }
        }

        return false;
    }
}