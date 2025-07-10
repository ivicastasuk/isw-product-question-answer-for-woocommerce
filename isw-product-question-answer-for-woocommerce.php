<?php
/**
 * Plugin Name: ISW Product Question and Answer for WooCommerce
 * Description: Dodaje Q&A tab sa pitanjima i odgovorima po proizvodima, koristeći Custom Post Type.
 * Version: 1.2
 * Author: ISW
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( is_admin() ) {
    require_once plugin_dir_path(__FILE__) . 'admin.php';
}

// WooCommerce aktivacija
register_activation_hook(__FILE__, 'isw_pqa_activation_check');
function isw_pqa_activation_check() {
    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('ISW Product Q&A zahteva instaliran i aktiviran WooCommerce plugin.');
    }
}

// Registruj CPT
add_action('init', 'isw_pqa_register_post_type');
function isw_pqa_register_post_type() {
    register_post_type('isw_product_question', array(
        'labels' => array(
            'name' => 'ISW Product Q&A',
            'singular_name' => 'ISW Product Q&A'
        ),
        'public' => false,
        'has_archive' => false,
        'show_ui' => false,
        // 'show_in_menu' => 'edit.php?post_type=product',
        'supports' => array('title', 'editor', 'author'),
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-editor-help'
    ));
}

// Dodaj tab
add_filter( 'woocommerce_product_tabs', 'isw_pqa_add_tab' );
function isw_pqa_add_tab( $tabs ) {
    $tabs['isw_qa_tab'] = array(
        'title'    => 'Pitanja i odgovori',
        'priority' => 60,
        'callback' => 'isw_pqa_tab_content'
    );
    return $tabs;
}

// Prikaz taba
function isw_pqa_tab_content() {
    global $product;
    $product_id = $product->get_id();
    $current_user = wp_get_current_user();

    echo '<div id="isw-qa-container" data-product="' . esc_attr( $product_id ) . '" data-can-answer="' . (current_user_can('edit_others_posts') ? '1' : '0') . '">';
    echo '<div id="isw-qa-list"></div>';
    echo '<button id="isw-qa-load-more" class="isw-qa-btn" style="display:none">Učitaj još...</button>';

    if ( is_user_logged_in() ) {
        echo '<button id="isw-qa-toggle-form" class="isw-qa-btn">Postavi pitanje</button>';
        echo '<form id="isw-qa-form" method="post" style="display:none">';
        echo '<textarea name="question" required placeholder="Vaše pitanje..."></textarea>';
        echo '<input type="hidden" name="product_id" value="' . esc_attr( $product_id ) . '">';
        echo '<input type="hidden" name="nonce" value="' . wp_create_nonce( 'isw_pqa_nonce' ) . '">';
        echo '<button type="submit" class="isw-qa-btn">Pošalji</button>';
        echo '<button type="button" id="isw-qa-cancel" class="isw-qa-btn" style="margin-left:10px;">Otkaži</button>';
        echo '</form>';
    } else {
        echo '<p>Morate biti prijavljeni da biste postavili pitanje.</p>';
    }

    echo '</div>';
}

// Snimi odgovor
add_action( 'wp_ajax_isw_pqa_submit_answer', 'isw_pqa_submit_answer' );
function isw_pqa_submit_answer() {
    check_ajax_referer( 'isw_pqa_nonce', 'nonce' );
    if ( ! is_user_logged_in() || ! current_user_can( 'edit_others_posts' ) ) wp_send_json_error();

    $answer = sanitize_text_field( $_POST['answer'] );
    $question_id = absint( $_POST['question_id'] );
    $product_id = absint( $_POST['product_id'] );

    if (!$answer || !$question_id || !$product_id) wp_send_json_error();

    wp_insert_post(array(
        'post_type' => 'isw_product_question',
        'post_title' => 'Odgovor - ' . current_time('mysql'),
        'post_content' => $answer,
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
        'post_parent' => $question_id,
        'meta_input' => array('product_id' => $product_id)
    ));

    wp_send_json_success( 'Odgovor je sačuvan.' );
}

// Snimi pitanje
add_action( 'wp_ajax_isw_pqa_submit', 'isw_pqa_submit_question' );
function isw_pqa_submit_question() {
    check_ajax_referer( 'isw_pqa_nonce', 'nonce' );
    if ( ! is_user_logged_in() || ! current_user_can( 'read' ) ) wp_send_json_error();

    $question = sanitize_text_field( $_POST['question'] );
    $product_id = absint( $_POST['product_id'] );

    wp_insert_post(array(
        'post_type' => 'isw_product_question',
        'post_title' => 'Pitanje - ' . current_time('mysql'),
        'post_content' => $question,
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
        'meta_input' => array('product_id' => $product_id)
    ));

    wp_send_json_success( 'Pitanje je sačuvano.' );
}

// Učitaj pitanja i odgovore (dodata forma za odgovor)
function isw_pqa_load_questions() {
    $product_id = absint( $_GET['product_id'] );
    $offset = absint( $_GET['offset'] );
    $can_answer = current_user_can('edit_others_posts');

    $args = array(
        'post_type' => 'isw_product_question',
        'posts_per_page' => 5,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_parent' => 0,
        'meta_query' => array(
            array(
                'key' => 'product_id',
                'value' => $product_id,
                'compare' => '='
            )
        )
    );

    $posts = get_posts( $args );
    $output = '';

    foreach ( $posts as $post ) {
        $author = get_userdata($post->post_author);
        $author_name = $author ? $author->display_name : 'Korisnik';

        $output .= '<div class="qa-thread">';
        $output .= '<div class="qa-item">';
        $output .= '<div class="question"><strong>' . esc_html($author_name) . ' postavio pitanje:</strong> ' . esc_html( $post->post_content ) . '<br><small>' . esc_html( get_the_date('d.m.Y. H:i', $post) ) . '</small></div>';

        $replies = get_children(array(
            'post_parent' => $post->ID,
            'post_type' => 'isw_product_question',
            'orderby' => 'date',
            'order' => 'ASC'
        ));

        foreach ( $replies as $reply ) {
            $reply_author = get_userdata($reply->post_author);
            $reply_author_name = $reply_author ? $reply_author->display_name : 'Admin';
            $output .= '<div class="answer"><em>' . esc_html($reply_author_name) . ' odgovorio:</em> ' . esc_html( $reply->post_content ) . '<br><small>' . esc_html( get_the_date('d.m.Y. H:i', $reply) ) . '</small></div>';
        }

        $output .= '</div></div>';
    }

    echo $output;
    wp_die();
}
add_action('wp_ajax_isw_pqa_load', 'isw_pqa_load_questions');
add_action('wp_ajax_nopriv_isw_pqa_load', 'isw_pqa_load_questions');

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', function() {
    if (is_product()) {
        wp_enqueue_script(
            'isw-pqa-ajax',
            plugins_url('js/qa-ajax.js', __FILE__),
            array('jquery'),
            null,
            true
        );
        wp_localize_script('isw-pqa-ajax', 'isw_pqa_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
        wp_enqueue_style(
            'isw-pqa-style',
            plugins_url('css/style.css', __FILE__)
        );
    }
});
