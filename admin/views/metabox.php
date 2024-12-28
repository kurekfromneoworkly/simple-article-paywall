<?php 
if (!defined('ABSPATH')) exit;
?>
<p>
    <input type="checkbox" name="paywall_enabled" id="paywall_enabled" <?php checked($enabled, 'on'); ?>>
    <label for="paywall_enabled">Enable Paywall</label>
</p>
<p>
    <label for="preview_length">Preview Length (characters):</label>
    <input type="number" name="preview_length" id="preview_length" value="<?php echo esc_attr($preview_length); ?>">
</p>
