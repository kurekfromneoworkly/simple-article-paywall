<?php 
if (!defined('ABSPATH')) exit;
$product_id = get_post_meta($post_id, '_article_product_id', true);
if (!$product_id) {
    $product_id = SAP_WooCommerce::create_article_access_product($post_id);
}
?>
<div class="article-paywall">
    <div class="paywall-message">
        <h3>Pokračovať v čítaní</h3>
        <p>Získajte 24-hodinový prístup k tomuto článku za 0,50€</p>
        <a href="<?php echo esc_url(add_query_arg('add-to-cart', $product_id, wc_get_cart_url())); ?>" 
           class="add-to-cart-button">
            Kúpiť prístup
        </a>
    </div>
</div>
