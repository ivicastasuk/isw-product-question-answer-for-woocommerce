<?php
/**
 * Uninstall script for ISW Product Question and Answer for WooCommerce plugin
 * 
 * This file is executed when the plugin is deleted through WordPress admin
 */

// If not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Security check
if (!current_user_can('activate_plugins')) {
    return;
}

// Delete all plugin options
delete_option('isw_pqa_options');

// Delete all custom post type data
$posts = get_posts(array(
    'numberposts' => -1,
    'post_type' => 'isw_product_question',
    'post_status' => 'any'
));

foreach ($posts as $post) {
    wp_delete_post($post->ID, true);
}

// Remove custom post type from database
global $wpdb;

// Delete meta data
$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE post_id IN (SELECT ID FROM {$wpdb->posts} WHERE post_type = 'isw_product_question')");

// Delete posts
$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'isw_product_question'");

// Clear cache
wp_cache_flush();
