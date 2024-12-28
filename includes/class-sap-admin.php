<?php
if (!defined('ABSPATH')) {
    exit;
}

class SAP_Admin {
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_paywall_metabox'));
        add_action('save_post', array($this, 'save_paywall_settings'));
    }

    public function add_paywall_metabox() {
        add_meta_box(
            'paywall_settings',
            'Paywall Settings',
            array($this, 'render_paywall_metabox'),
            'post',
            'side'
        );
    }

    public function render_paywall_metabox($post) {
        $enabled = get_post_meta($post->ID, '_paywall_enabled', true);
        $preview_length = get_post_meta($post->ID, '_paywall_preview_length', true) ?: 200;
        wp_nonce_field('paywall_settings', 'paywall_nonce');
        include SAP_PLUGIN_PATH . 'admin/views/metabox.php';
    }

    public function save_paywall_settings($post_id) {
        if (!isset($_POST['paywall_nonce']) || !wp_verify_nonce($_POST['paywall_nonce'], 'paywall_settings')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $enabled = isset($_POST['paywall_enabled']) ? 'on' : 'off';
        update_post_meta($post_id, '_paywall_enabled', $enabled);
        
        if (isset($_POST['preview_length'])) {
            update_post_meta($post_id, '_paywall_preview_length', sanitize_text_field($_POST['preview_length']));
        }
    }
}
