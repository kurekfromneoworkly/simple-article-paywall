<?php
if (!defined('ABSPATH')) {
    exit;
}

class SAP_Public {
    public function __construct() {
        add_filter('the_content', array($this, 'filter_post_content'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
    }

    public function filter_post_content($content) {
        if (!is_single() || !in_the_loop()) {
            return $content;
        }

        $post_id = get_the_ID();
        $enabled = get_post_meta($post_id, '_paywall_enabled', true);
        
        if ($enabled !== 'on') {
            return $content;
        }

        if (SAP_WooCommerce::has_user_article_access($post_id)) {
            return $content;
        }

        $preview_length = get_post_meta($post_id, '_paywall_preview_length', true) ?: 200;
        
        // Rozdelenie obsahu na slová
        $words = str_word_count(strip_tags($content), 2);
        $preview_words = array_slice($words, 0, $preview_length);
        
        // Získanie pozície posledného slova v pôvodnom texte
        end($preview_words);
        $last_position = key($preview_words) + strlen(current($preview_words));
        
        // Rozdelenie obsahu na preview a skrytú časť
        $preview_content = substr($content, 0, $last_position);
        $hidden_content = substr($content, $last_position);
        
        ob_start();
        include SAP_PLUGIN_PATH . 'public/views/paywall-message.php';
        $paywall_html = ob_get_clean();

        return $preview_content . $paywall_html;
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            'sap-public',
            SAP_PLUGIN_URL . 'public/css/style.css',
            array(),
            '1.0.0'
        );
    }
}
