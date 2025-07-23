<?php
/**
 * Uninstall script za ISW Product Question and Answer for WooCommerce plugin
 * 
 * Ovaj fajl se izvršava kada se plugin briše kroz WordPress admin
 */

// Ako nije pozvan od WordPress-a, izađi
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Sigurnosna provera
if (!current_user_can('activate_plugins')) {
    return;
}

// Obriši sve opcije plugina
delete_option('isw_pqa_options');

// Obriši sve custom post type podatke
$posts = get_posts(array(
    'numberposts' => -1,
    'post_type' => 'isw_product_question',
    'post_status' => 'any'
));

foreach ($posts as $post) {
    wp_delete_post($post->ID, true);
}

// Ukloni custom post type iz baze
global $wpdb;

// Obriši meta podatke
$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE post_id IN (SELECT ID FROM {$wpdb->posts} WHERE post_type = 'isw_product_question')");

// Obriši postove
$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'isw_product_question'");

// Očisti cache
wp_cache_flush();
