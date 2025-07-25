<?php
/**
 * Plugin Name: ISW Product Question and Answer for WooCommerce
 * Plugin URI: https://isw-team.com/plugins/product-qa
 * Description: Dodaje Q&A tab sa pitanjima i odgovorima po proizvodima, koristeći Custom Post Type. Potpuno prilagodljiv dizajn sa naprednim opcijama stilizovanja.
 * Version: 1.2.0
 * Author: ISW Team
 * Author URI: https://isw-team.com
 * Text Domain: isw-product-question-answer-for-woocommerce
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * WC requires at least: 3.0
 * WC tested up to: 8.0
 * Woo: 12345:abcdef1234567890abcdef1234567890
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network: false
 */

// Sprečava direktan pristup
if (!defined('ABSPATH')) {
    exit;
}

// Definisanje konstanti
define('ISW_PQA_VERSION', '1.2.0');
define('ISW_PQA_PLUGIN_FILE', __FILE__);
define('ISW_PQA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ISW_PQA_PLUGIN_URL', plugin_dir_url(__FILE__));

// Učitaj admin fajlove samo u admin delu
if (is_admin()) {
    require_once ISW_PQA_PLUGIN_DIR . 'admin.php';
    require_once ISW_PQA_PLUGIN_DIR . 'admin-settings.php';
}

// Internationalization
add_action('plugins_loaded', 'isw_pqa_load_textdomain');
function isw_pqa_load_textdomain() {
    load_plugin_textdomain('isw-product-question-answer-for-woocommerce', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

// WooCommerce HPOS compatibility
add_action('before_woocommerce_init', function() {
    if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

// WooCommerce aktivacija i dependency check
register_activation_hook(__FILE__, 'isw_pqa_activation_check');
function isw_pqa_activation_check() {
    // Proveri WordPress verziju
    if (version_compare(get_bloginfo('version'), '5.0', '<')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            esc_html__('ISW Product Q&A zahteva WordPress verziju 5.0 ili noviju.', 'isw-product-question-answer-for-woocommerce'),
            esc_html__('Plugin greška', 'isw-product-question-answer-for-woocommerce'),
            array('back_link' => true)
        );
    }
    
    // Proveri PHP verziju
    if (version_compare(PHP_VERSION, '7.4', '<')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            esc_html__('ISW Product Q&A zahteva PHP verziju 7.4 ili noviju.', 'isw-product-question-answer-for-woocommerce'),
            esc_html__('Plugin greška', 'isw-product-question-answer-for-woocommerce'),
            array('back_link' => true)
        );
    }
    
    // Proveri da li je WooCommerce aktivan
    if (!is_plugin_active('woocommerce/woocommerce.php') && !function_exists('WC')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            esc_html__('ISW Product Q&A zahteva instaliran i aktiviran WooCommerce plugin.', 'isw-product-question-answer-for-woocommerce'),
            esc_html__('Plugin greška', 'isw-product-question-answer-for-woocommerce'),
            array('back_link' => true)
        );
    }
    
    // Flush rewrite rules
    flush_rewrite_rules();
}

// Dodatna provera pri učitavanju plugina
add_action('plugins_loaded', 'isw_pqa_check_woocommerce', 11);
function isw_pqa_check_woocommerce() {
    if (!function_exists('WC')) {
        add_action('admin_notices', 'isw_pqa_woocommerce_missing_notice');
        return;
    }
}

// Admin notice ako WooCommerce nije aktivan
function isw_pqa_woocommerce_missing_notice() {
    echo '<div class="notice notice-error"><p>';
    // translators: %s is the string "WooCommerce" formatted in bold
    echo wp_kses(sprintf(__('ISW Product Q&A zahteva %s da bi radio ispravno. Molimo instalirajte i aktivirajte WooCommerce.', 'isw-product-question-answer-for-woocommerce'), '<strong>WooCommerce</strong>'), array('strong' => array()));
    echo '</p></div>';
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
    // Proveri da li je tab omogućen u postavkama
    $enable_tab = isw_pqa_get_option('enable_qa_tab', 1);
    if (!$enable_tab) {
        return $tabs;
    }
    
    $tab_title = isw_pqa_get_option('qa_tab_title', 'Pitanja i odgovori');
    $tab_priority = isw_pqa_get_option('qa_tab_priority', 60);
    
    $tabs['isw_qa_tab'] = array(
        'title'    => $tab_title,
        'priority' => intval($tab_priority),
        'callback' => 'isw_pqa_tab_content'
    );
    return $tabs;
}

// Prikaz taba
function isw_pqa_tab_content() {
    global $product;
    $product_id = $product->get_id();
    $current_user = wp_get_current_user();

    // Podesivi tekstovi dugmića
    $btn_text_ask_question = isw_pqa_get_option('btn_text_ask_question', 'Postavi pitanje');
    $btn_text_submit_question = isw_pqa_get_option('btn_text_submit_question', 'Pošalji');
    $btn_text_cancel = isw_pqa_get_option('btn_text_cancel', 'Otkaži');
    $btn_text_load_more = isw_pqa_get_option('btn_text_load_more', 'Učitaj još...');

    echo '<div id="isw-qa-container" data-product="' . esc_attr( $product_id ) . '" data-can-answer="' . (current_user_can('edit_others_posts') ? '1' : '0') . '">';
    echo '<div id="isw-qa-list"></div>';
    echo '<button id="isw-qa-load-more" class="isw-qa-btn" style="display:none">' . esc_html($btn_text_load_more) . '</button>';

    if ( is_user_logged_in() ) {
        echo '<button id="isw-qa-toggle-form" class="isw-qa-btn">' . esc_html($btn_text_ask_question) . '</button>';
        echo '<form id="isw-qa-form" method="post" style="display:none">';
        echo '<textarea name="question" required placeholder="' . esc_attr__('Vaše pitanje...', 'isw-product-question-answer-for-woocommerce') . '"></textarea>';
        echo '<input type="hidden" name="product_id" value="' . esc_attr( $product_id ) . '">';
        echo '<input type="hidden" name="nonce" value="' . esc_attr( wp_create_nonce( 'isw_pqa_nonce' ) ) . '">';
        echo '<button type="submit" class="isw-qa-btn">' . esc_html($btn_text_submit_question) . '</button>';
        echo '<button type="button" id="isw-qa-cancel" class="isw-qa-btn" style="margin-left:10px;">' . esc_html($btn_text_cancel) . '</button>';
        echo '</form>';
    } else {
        echo '<p>' . esc_html__('Morate biti prijavljeni da biste postavili pitanje.', 'isw-product-question-answer-for-woocommerce') . '</p>';
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
        'post_title' => __('Odgovor', 'isw-product-question-answer-for-woocommerce') . ' - ' . current_time('mysql'),
        'post_content' => $answer,
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
        'post_parent' => $question_id,
        'meta_input' => array('product_id' => $product_id)
    ));

    wp_send_json_success( __('Odgovor je sačuvan.', 'isw-product-question-answer-for-woocommerce') );
}

// Snimi pitanje
add_action( 'wp_ajax_isw_pqa_submit', 'isw_pqa_submit_question' );
function isw_pqa_submit_question() {
    check_ajax_referer( 'isw_pqa_nonce', 'nonce' );
    if ( ! is_user_logged_in() || ! current_user_can( 'read' ) ) wp_send_json_error();

    $question = sanitize_text_field( $_POST['question'] );
    $product_id = absint( $_POST['product_id'] );
    
    $auto_approve = isw_pqa_get_option('auto_approve_questions', 1);
    $post_status = $auto_approve ? 'publish' : 'pending';

    $question_id = wp_insert_post(array(
        'post_type' => 'isw_product_question',
        'post_title' => __('Pitanje', 'isw-product-question-answer-for-woocommerce') . ' - ' . current_time('mysql'),
        'post_content' => $question,
        'post_status' => $post_status,
        'post_author' => get_current_user_id(),
        'meta_input' => array('product_id' => $product_id)
    ));
    
    // Pošalji email notifikaciju ako je omogućena
    $email_notifications = isw_pqa_get_option('email_notifications', 0);
    if ($email_notifications && $question_id) {
        $admin_email = get_option('admin_email');
        $product = wc_get_product($product_id);
        $product_name = $product ? $product->get_name() : __('Nepoznat proizvod', 'isw-product-question-answer-for-woocommerce');
        $user = wp_get_current_user();
        
        // translators: %s is the product name
        $subject = sprintf(__('Novo pitanje na proizvodu: %s', 'isw-product-question-answer-for-woocommerce'), $product_name);
        // translators: %s is the user's display name
        $message = sprintf(__('Korisnik %s je postavio novo pitanje:', 'isw-product-question-answer-for-woocommerce'), $user->display_name) . "\n\n";
        // translators: %s is the product name
        $message .= sprintf(__('Proizvod: %s', 'isw-product-question-answer-for-woocommerce'), $product_name) . "\n";
        // translators: %s is the question text
        $message .= sprintf(__('Pitanje: %s', 'isw-product-question-answer-for-woocommerce'), $question) . "\n\n";
        $message .= __('Odgovorite na:', 'isw-product-question-answer-for-woocommerce') . ' ' . admin_url('edit.php?post_type=product&page=isw-pqa-qa');
        
        wp_mail($admin_email, $subject, $message);
    }

    $message = $auto_approve ? __('Pitanje je sačuvano.', 'isw-product-question-answer-for-woocommerce') : __('Pitanje je poslato na odobravanje.', 'isw-product-question-answer-for-woocommerce');
    wp_send_json_success( $message );
}

// Učitaj pitanja i odgovore (dodata forma za odgovor)
function isw_pqa_load_questions() {
    $product_id = absint( $_GET['product_id'] );
    $offset = absint( $_GET['offset'] );
    $can_answer = current_user_can('edit_others_posts');
    $questions_per_page = isw_pqa_get_option('questions_per_page', 5);

    $args = array(
        'post_type' => 'isw_product_question',
        'posts_per_page' => intval($questions_per_page),
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_parent' => 0,
        'post_status' => 'publish', // Samo odobrena pitanja
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
        $author_name = $author ? $author->display_name : esc_html__('Korisnik', 'isw-product-question-answer-for-woocommerce');

        $output .= '<div class="qa-thread">';
        $output .= '<div class="qa-item">';
        $output .= '<div class="question"><strong>' . esc_html($author_name) . ' ' . esc_html__('postavio pitanje:', 'isw-product-question-answer-for-woocommerce') . '</strong> ' . esc_html( $post->post_content ) . '<br><small>' . esc_html( get_the_date('d.m.Y. H:i', $post) ) . '</small></div>';

        $replies = get_children(array(
            'post_parent' => $post->ID,
            'post_type' => 'isw_product_question',
            'orderby' => 'date',
            'order' => 'ASC'
        ));

        foreach ( $replies as $reply ) {
            $reply_author = get_userdata($reply->post_author);
            $reply_author_name = $reply_author ? $reply_author->display_name : esc_html__('Admin', 'isw-product-question-answer-for-woocommerce');
            $output .= '<div class="answer"><em>' . esc_html($reply_author_name) . ' ' . esc_html__('odgovorio:', 'isw-product-question-answer-for-woocommerce') . '</em> ' . esc_html( $reply->post_content ) . '<br><small>' . esc_html( get_the_date('d.m.Y. H:i', $reply) ) . '</small></div>';
        }

        $output .= '</div></div>';
    }

    $allowed_html = array(
        'div' => array(
            'class' => array()
        ),
        'strong' => array(),
        'em' => array(),
        'br' => array(),
        'small' => array()
    );
    
    echo wp_kses($output, $allowed_html);
    wp_die();
}
add_action('wp_ajax_isw_pqa_load', 'isw_pqa_load_questions');
add_action('wp_ajax_nopriv_isw_pqa_load', 'isw_pqa_load_questions');

// Funkcija za dobijanje opcija (za frontend i backend)
if (!function_exists('isw_pqa_get_option')) {
    function isw_pqa_get_option($option_name, $default = '') {
        $options = get_option('isw_pqa_options', array());
        return isset($options[$option_name]) ? $options[$option_name] : $default;
    }
}

// Funkcija za generiranje dinamičkog CSS-a
function isw_pqa_generate_dynamic_css() {
    // Tipografija
    $font_family = isw_pqa_get_option('font_family', 'inherit');
    $font_size = isw_pqa_get_option('font_size', '14');
    $font_weight = isw_pqa_get_option('font_weight', 'normal');
    $text_color = isw_pqa_get_option('text_color', '#333333');
    $text_transform = isw_pqa_get_option('text_transform', 'none');
    $line_height = isw_pqa_get_option('line_height', '1.5');
    
    // Pozadina i kontejneri
    $question_bg_color = isw_pqa_get_option('question_bg_color', '#f5f5f5');
    $answer_bg_color = isw_pqa_get_option('answer_bg_color', '#e0f7fa');
    $container_border_width = isw_pqa_get_option('container_border_width', '0');
    $container_border_style = isw_pqa_get_option('container_border_style', 'solid');
    $container_border_color = isw_pqa_get_option('container_border_color', '#cccccc');
    $container_border_radius = isw_pqa_get_option('container_border_radius', '10');
    $container_padding = isw_pqa_get_option('container_padding', '15');
    $container_margin = isw_pqa_get_option('container_margin', '20');
    
    // Dugmići
    $btn_text_color = isw_pqa_get_option('btn_text_color', '#ffffff');
    $btn_bg_color = isw_pqa_get_option('btn_bg_color', '#4abb6b');
    $btn_hover_bg_color = isw_pqa_get_option('btn_hover_bg_color', '#ffffff');
    $btn_hover_text_color = isw_pqa_get_option('btn_hover_text_color', '#4abb6b');
    $btn_border_width = isw_pqa_get_option('btn_border_width', '2');
    $btn_border_style = isw_pqa_get_option('btn_border_style', 'solid');
    $btn_border_color = isw_pqa_get_option('btn_border_color', '#4abb6b');
    $btn_border_radius = isw_pqa_get_option('btn_border_radius', '25');
    $btn_padding_tb = isw_pqa_get_option('btn_padding_tb', '8');
    $btn_padding_lr = isw_pqa_get_option('btn_padding_lr', '20');
    $btn_width_type = isw_pqa_get_option('btn_width_type', 'auto');
    $btn_width_value = isw_pqa_get_option('btn_width_value', '150');
    $btn_alignment = isw_pqa_get_option('btn_alignment', 'left');
    $btn_font_size = isw_pqa_get_option('btn_font_size', '14');
    $btn_font_weight = isw_pqa_get_option('btn_font_weight', 'normal');
    $btn_text_transform = isw_pqa_get_option('btn_text_transform', 'none');
    
    // Generiraj width CSS za dugmiće
    $btn_width_css = '';
    if ($btn_width_type === 'fixed') {
        $btn_width_css = "width: {$btn_width_value}px !important;";
    } elseif ($btn_width_type === 'full') {
        $btn_width_css = "width: 100% !important;";
    }
    
    // Generiraj alignment CSS
    $btn_alignment_css = '';
    if ($btn_alignment === 'center') {
        $btn_alignment_css = "text-align: center;";
    } elseif ($btn_alignment === 'right') {
        $btn_alignment_css = "text-align: right;";
    }
    
    $css = "
        /* Opšta tipografija */
        #isw-qa-container,
        .qa-thread,
        .qa-item {
            font-family: {$font_family} !important;
            font-size: {$font_size}px !important;
            font-weight: {$font_weight} !important;
            color: {$text_color} !important;
            text-transform: {$text_transform} !important;
            line-height: {$line_height} !important;
        }
        
        /* Kontejneri pitanja */
        .qa-thread {
            background: {$question_bg_color} !important;
            border: {$container_border_width}px {$container_border_style} {$container_border_color} !important;
            border-radius: {$container_border_radius}px !important;
            padding: {$container_padding}px !important;
            margin-bottom: {$container_margin}px !important;
        }
        
        /* Kontejneri odgovora */
        .qa-item .answer {
            background: {$answer_bg_color} !important;
            border-radius: {$container_border_radius}px !important;
            padding: {$container_padding}px !important;
        }
        
        /* Dugmići */
        .isw-qa-btn {
            color: {$btn_text_color} !important;
            background-color: {$btn_bg_color} !important;
            border: {$btn_border_width}px {$btn_border_style} {$btn_border_color} !important;
            border-radius: {$btn_border_radius}px !important;
            padding: {$btn_padding_tb}px {$btn_padding_lr}px !important;
            font-size: {$btn_font_size}px !important;
            font-weight: {$btn_font_weight} !important;
            text-transform: {$btn_text_transform} !important;
            {$btn_width_css}
            margin: 0.5em 1em 0.5em 0 !important;
            display: inline-block !important;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }
        
        .isw-qa-btn:hover {
            color: {$btn_hover_text_color} !important;
            background-color: {$btn_hover_bg_color} !important;
            border-color: {$btn_border_color} !important;
        }
        
        /* Poravnanje dugmića */
        #isw-qa-container {
            {$btn_alignment_css}
        }
        
        /* Form elementi */
        #isw-qa-form textarea {
            font-family: {$font_family} !important;
            font-size: {$font_size}px !important;
            color: {$text_color} !important;
            border-radius: {$container_border_radius}px !important;
            padding: {$container_padding}px !important;
            width: 100% !important;
            min-height: 80px !important;
            border: 1px solid {$container_border_color} !important;
            margin-bottom: 10px !important;
        }
        
        /* Admin kontejneri */
        .isw-pqa-answer {
            background: {$answer_bg_color} !important;
            border-radius: {$container_border_radius}px !important;
            padding: {$container_padding}px !important;
        }
        
        .isw-pqa-answer-form textarea {
            font-family: {$font_family} !important;
            font-size: {$font_size}px !important;
            color: {$text_color} !important;
            border-radius: {$container_border_radius}px !important;
            padding: {$container_padding}px !important;
        }
    ";
    
    return $css;
}

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
            'ajax_url' => admin_url('admin-ajax.php'),
            'questions_per_page' => isw_pqa_get_option('questions_per_page', 5),
            'btn_text_load_more' => isw_pqa_get_option('btn_text_load_more', 'Učitaj još...')
        ));
        wp_enqueue_style(
            'isw-pqa-style',
            plugins_url('css/style.css', __FILE__)
        );
        
        // Dinamički CSS za sve stilove
        $custom_css = isw_pqa_generate_dynamic_css();
        wp_add_inline_style('isw-pqa-style', $custom_css);
    }
});
