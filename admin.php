<?php
// Admin meni i stranice
add_action('admin_menu', 'isw_pqa_admin_menu');
function isw_pqa_admin_menu() {
    // Parent menu item
    add_submenu_page(
        'edit.php?post_type=product',
        'ISW Product Q&A',
        'ISW Product Q&A',
        'manage_woocommerce',
        'isw-pqa-main',
        'isw_pqa_redirect_to_qa' // Redirect funkcija
    );
    
    // Q&A submenu (glavni admin panel)
    add_submenu_page(
        'edit.php?post_type=product',
        'Q&A - Pitanja i Odgovori',
        '→ Q&A',
        'manage_woocommerce',
        'isw-pqa-qa',
        'isw_pqa_admin_page'
    );
    
    // Settings submenu
    add_submenu_page(
        'edit.php?post_type=product',
        'Q&A - Postavke',
        '→ Postavke',
        'manage_woocommerce',
        'isw-pqa-settings',
        'isw_pqa_settings_page'
    );
}

// Redirect funkcija za parent menu
function isw_pqa_redirect_to_qa() {
    wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa'));
    exit;
}

add_action('admin_enqueue_scripts', function($hook) {
    // Prikaži stil na svim ISW Q&A stranicama
    if (isset($_GET['page']) && (
        $_GET['page'] === 'isw-pqa-qa' || 
        $_GET['page'] === 'isw-pqa-settings' || 
        $_GET['page'] === 'isw-pqa-main'
    )) {
        wp_enqueue_style(
            'isw-pqa-admin-style',
            plugins_url('css/style.css', __FILE__)
        );
    }
});

function isw_pqa_admin_page() {
    echo '<div class="wrap">';
    echo '<h1>ISW Product Q&A - Question Management</h1>';
    
    // Prikaži poruke o statusu
    if (isset($_GET['success'])) {
        switch ($_GET['success']) {
            case 'answer_added':
                echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Answer has been successfully added!', 'isw-product-question-answer-for-woocommerce') . '</p></div>';
                break;
            case 'question_approved':
                echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Question has been successfully approved!', 'isw-product-question-answer-for-woocommerce') . '</p></div>';
                break;
            case 'question_deleted':
                echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Question has been successfully deleted!', 'isw-product-question-answer-for-woocommerce') . '</p></div>';
                break;
        }
    }
    
    if (isset($_GET['error'])) {
        switch ($_GET['error']) {
            case 'empty_answer':
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('Error: Answer cannot be empty.', 'isw-product-question-answer-for-woocommerce') . '</p></div>';
                break;
            case 'missing_data':
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('Error: Required data is missing.', 'isw-product-question-answer-for-woocommerce') . '</p></div>';
                break;
            case 'invalid_question':
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('Error: Question does not exist or is invalid.', 'isw-product-question-answer-for-woocommerce') . '</p></div>';
                break;
            case 'creation_failed':
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('Error: Answer creation failed.', 'isw-product-question-answer-for-woocommerce') . '</p></div>';
                break;
            case 'update_failed':
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('Error: Question update failed.', 'isw-product-question-answer-for-woocommerce') . '</p></div>';
                break;
            case 'delete_failed':
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('Error: Question deletion failed.', 'isw-product-question-answer-for-woocommerce') . '</p></div>';
                break;
            default:
                // translators: %s is the error message returned by the system
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html(sprintf(__('An unexpected error occurred: %s', 'isw-product-question-answer-for-woocommerce'), $_GET['error'])) . '</p></div>';
                break;
        }
    }
    
    // Navigacija između stranica
    echo '<nav class="nav-tab-wrapper">';
    echo '<a href="' . esc_url(admin_url('edit.php?post_type=product&page=isw-pqa-qa')) . '" class="nav-tab nav-tab-active">Q&A</a>';
    echo '<a href="' . esc_url(admin_url('edit.php?post_type=product&page=isw-pqa-settings')) . '" class="nav-tab">Settings</a>';
    echo '</nav>';
    echo '<br>';
    
    // Filter za status pitanja
    $current_filter = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : 'all';
    echo '<div class="subsubsub">';
    echo '<a href="' . esc_url(admin_url('edit.php?post_type=product&page=isw-pqa-qa&filter=all')) . '" class="' . (esc_attr($current_filter) == 'all' ? 'current' : '') . '">All Questions</a> | ';
    echo '<a href="' . esc_url(admin_url('edit.php?post_type=product&page=isw-pqa-qa&filter=answered')) . '" class="' . (esc_attr($current_filter) == 'answered' ? 'current' : '') . '">Answered</a> | ';
    echo '<a href="' . esc_url(admin_url('edit.php?post_type=product&page=isw-pqa-qa&filter=unanswered')) . '" class="' . (esc_attr($current_filter) == 'unanswered' ? 'current' : '') . '">Unanswered</a>';
    echo '</div>';
    echo '<br>';
    ?>
    <script>
    jQuery(function($){
        $('.isw-pqa-q-title').on('click', function(){
            var $card = $(this).closest('.isw-pqa-q-wrap').find('.isw-pqa-q-card');
            $('.isw-pqa-q-card').not($card).slideUp();
            $card.slideToggle();
        });
        
        // Validacija forme za odgovor
        $('.isw-pqa-answer-form').on('submit', function(e) {
            var answer = $(this).find('textarea[name="answer"]').val().trim();
            if (!answer) {
                e.preventDefault();
                alert('Morate uneti odgovor pre slanja.');
                return false;
            }
            
            // Prikaži loading indikator
            var $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true).text('Šalje se...');
            
            // Ako se forma šalje duže od 10 sekundi, vratni dugme
            setTimeout(function() {
                $btn.prop('disabled', false).text('ODGOVORI');
            }, 10000);
        });
        
        // Remove success/error parameters from URL after 3 seconds
        if (window.location.search.indexOf('success=') !== -1 || window.location.search.indexOf('error=') !== -1) {
            setTimeout(function() {
                var url = window.location.pathname + '?post_type=product&page=isw-pqa-qa';
                if (window.location.search.indexOf('filter=') !== -1) {
                    var filter = new URLSearchParams(window.location.search).get('filter');
                    if (filter) url += '&filter=' + filter;
                }
                window.history.replaceState({}, document.title, url);
            }, 3000);
        }
    });
    </script>
    <?php

    // Pronađi sva pitanja po proizvodima na osnovu filtera
    $query_args = array(
        'post_type' => 'isw_product_question',
        'posts_per_page' => 999,
        'post_parent' => 0,
        'post_status' => array('publish', 'pending'), // Uključi i pitanja koja čekaju odobravanje
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    // Filtriraj pitanja na osnovu statusa
    if ($current_filter == 'unanswered') {
        // Pitanja bez odgovora
        $query_args['meta_query'] = array(
            array(
                'key' => 'has_answer',
                'compare' => 'NOT EXISTS'
            )
        );
    }
    
    $questions = get_posts($query_args);
    
    // Ako je filter "answered" ili "unanswered", dodatno filtriraj
    if ($current_filter == 'answered' || $current_filter == 'unanswered') {
        $filtered_questions = array();
        foreach ($questions as $question) {
            $answers = get_posts(array(
                'post_type' => 'isw_product_question',
                'post_parent' => $question->ID,
                'posts_per_page' => 1
            ));
            $has_answer = !empty($answers);
            
            if (($current_filter == 'answered' && $has_answer) || 
                ($current_filter == 'unanswered' && !$has_answer)) {
                $filtered_questions[] = $question;
            }
        }
        $questions = $filtered_questions;
    }

    if (empty($questions)) {
        echo '<p>Nijedan proizvod nema postavljeno pitanje.</p></div>';
        return;
    }

    foreach ($questions as $question) {
        $product_id = get_post_meta($question->ID, 'product_id', true);
        $product = wc_get_product($product_id);
        if (!$product) continue;
        $title = $product->get_name();

        // Da li ima odgovor?
        $answers = get_posts(array(
            'post_type' => 'isw_product_question',
            'post_parent' => $question->ID,
            'posts_per_page' => 1
        ));
        $has_answer = !empty($answers);

        echo '<div class="isw-pqa-q-wrap '.($has_answer ? 'has-answer' : 'no-answer').'">';
        echo '<div class="isw-pqa-q-title">'.esc_html($title);
        
        // Prikaži status pitanja
        if ($question->post_status == 'pending') {
            echo ' <span style="color: orange;">(Čeka odobravanje)</span>';
        }
        
        echo '</div>';

        echo '<div class="isw-pqa-q-card">';
        echo '<div><b>Question:</b> '.esc_html($question->post_content).'</div>';
        echo '<div style="font-size:11px;color:#666;">'.esc_html(get_the_date('d.m.Y. H:i', $question)).'</div>';
        
        // Dugmad za odobravanje/brisanje ako pitanje čeka odobravanje
        if ($question->post_status == 'pending') {
            echo '<div style="margin: 10px 0;">';
            echo '<form method="post" action="'.esc_url(admin_url('admin-post.php')).'" style="display: inline-block; margin-right: 10px;">';
            echo '<input type="hidden" name="action" value="isw_pqa_approve_question">';
            echo '<input type="hidden" name="question_id" value="'.esc_attr($question->ID).'">';
            wp_nonce_field('isw_pqa_approve_question', 'isw_pqa_approve_nonce');
            echo '<button type="submit" class="button button-primary">Approve Question</button>';
            echo '</form>';
            
            echo '<form method="post" action="'.esc_url(admin_url('admin-post.php')).'" style="display: inline-block;">';
            echo '<input type="hidden" name="action" value="isw_pqa_delete_question">';
            echo '<input type="hidden" name="question_id" value="'.esc_attr($question->ID).'">';
            wp_nonce_field('isw_pqa_delete_question', 'isw_pqa_delete_nonce');
            echo '<button type="submit" class="button button-secondary" onclick="return confirm(\'Are you sure you want to delete this question?\')">Delete Question</button>';
            echo '</form>';
            echo '</div>';
        }

        if ($has_answer) {
            $answer = $answers[0];
            echo '<div class="isw-pqa-answer" style="margin-top:10px;"><b>Answer:</b> '.esc_html($answer->post_content).'</div>';
            echo '<div style="font-size:11px;color:#666;">'.esc_html(get_the_date('d.m.Y. H:i', $answer)).'</div>';
        } else {
            // Forma za odgovor
            echo '<form class="isw-pqa-answer-form" method="post" action="'.esc_url(admin_url('admin-post.php')).'">';
            echo '<input type="hidden" name="action" value="isw_pqa_add_answer">';
            echo '<input type="hidden" name="question_id" value="'.esc_attr($question->ID).'">';
            echo '<input type="hidden" name="product_id" value="'.esc_attr($product_id).'">';
            wp_nonce_field('isw_pqa_add_answer', 'isw_pqa_answer_nonce');
            echo '<textarea name="answer" placeholder="Upišite odgovor..." required style="width: 100%; min-height: 80px; margin: 10px 0;"></textarea>';
            echo '<br><button type="submit" class="button button-primary">REPLY</button>';
            echo '</form>';
        }

        echo '</div></div>';
    }

    echo '</div>';
}

// Handler za unos odgovora
add_action('admin_post_isw_pqa_add_answer', function() {
    // Provera bezbednosti
    if (!is_user_logged_in()) {
        wp_die(esc_html__('You must be logged in.', 'isw-product-question-answer-for-woocommerce'), esc_html__('Unauthorized Access', 'isw-product-question-answer-for-woocommerce'), array('response' => 403));
    }
    
    if (!current_user_can('manage_woocommerce') && 
        !current_user_can('edit_posts') && 
        !current_user_can('edit_others_posts') &&
        !current_user_can('manage_options')) {
        wp_die(esc_html__('You do not have permission for this action.', 'isw-product-question-answer-for-woocommerce'), esc_html__('Unauthorized Access', 'isw-product-question-answer-for-woocommerce'), array('response' => 403));
    }
    
    if (!isset($_POST['isw_pqa_answer_nonce']) || !wp_verify_nonce($_POST['isw_pqa_answer_nonce'], 'isw_pqa_add_answer')) {
        wp_die(esc_html__('Security check failed.', 'isw-product-question-answer-for-woocommerce'), esc_html__('Invalid Security Check', 'isw-product-question-answer-for-woocommerce'), array('response' => 403));
    }
    
    // Sanitizacija ulaznih podataka
    $question_id = absint($_POST['question_id']);
    $product_id = absint($_POST['product_id']);
    $answer = sanitize_textarea_field($_POST['answer']);
    
    // Validacija podataka
    if (empty($answer)) {
        wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&error=empty_answer'));
        exit;
    }
    
    if (!$question_id || !$product_id) {
        wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&error=missing_data'));
        exit;
    }
    
    // Proverava da li pitanje postoji i da li je validno
    $question = get_post($question_id);
    if (!$question || $question->post_type !== 'isw_product_question') {
        wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&error=invalid_question'));
        exit;
    }
    
    // Kreiranje odgovora
    $post_id = wp_insert_post(array(
        'post_type' => 'isw_product_question',
        'post_title' => sanitize_text_field('Odgovor - ' . current_time('mysql')),
        'post_content' => $answer,
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
        'post_parent' => $question_id,
    ));
    
    if ($post_id && !is_wp_error($post_id)) {
        // Dodeli meta podatke
        add_post_meta($post_id, 'product_id', $product_id);
        wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&success=answer_added'));
    } else {
        wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&error=creation_failed'));
    }
    exit;
});

// Handler za odobravanje pitanja
add_action('admin_post_isw_pqa_approve_question', function() {
    // Provera bezbednosti
    if (!current_user_can('manage_woocommerce') ||
        !isset($_POST['isw_pqa_approve_nonce']) ||
        !wp_verify_nonce($_POST['isw_pqa_approve_nonce'], 'isw_pqa_approve_question')) {
        wp_die(esc_html__('Unauthorized access', 'isw-product-question-answer-for-woocommerce'), esc_html__('Unauthorized Access', 'isw-product-question-answer-for-woocommerce'), array('response' => 403));
    }
    
    $question_id = absint($_POST['question_id']);
    if ($question_id) {
        $result = wp_update_post(array(
            'ID' => $question_id,
            'post_status' => 'publish'
        ));
        
        if (is_wp_error($result)) {
            wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&error=update_failed'));
        } else {
            wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&success=question_approved'));
        }
    } else {
        wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&error=invalid_question'));
    }
    exit;
});

// Handler za brisanje pitanja
add_action('admin_post_isw_pqa_delete_question', function() {
    // Security check
    if (!current_user_can('manage_woocommerce') ||
        !isset($_POST['isw_pqa_delete_nonce']) ||
        !wp_verify_nonce($_POST['isw_pqa_delete_nonce'], 'isw_pqa_delete_question')) {
        wp_die(esc_html__('Unauthorized access', 'isw-product-question-answer-for-woocommerce'), esc_html__('Unauthorized Access', 'isw-product-question-answer-for-woocommerce'), array('response' => 403));
    }
    
    $question_id = absint($_POST['question_id']);
    if ($question_id) {
        // First delete all answers to this question
        $answers = get_posts(array(
            'post_type' => 'isw_product_question',
            'post_parent' => $question_id,
            'posts_per_page' => -1,
            'fields' => 'ids'
        ));
        
        foreach ($answers as $answer_id) {
            wp_delete_post($answer_id, true);
        }
        
        // Then delete the question
        $result = wp_delete_post($question_id, true);
        
        if ($result) {
            wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&success=question_deleted'));
        } else {
            wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&error=delete_failed'));
        }
    } else {
        wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa-qa&error=invalid_question'));
    }
    exit;
});

// Handler for unauthenticated users
add_action('admin_post_nopriv_isw_pqa_add_answer', function() {
    wp_die(esc_html__('You must be logged in as an administrator to reply to questions.', 'isw-product-question-answer-for-woocommerce'), esc_html__('Unauthorized Access', 'isw-product-question-answer-for-woocommerce'), array('response' => 403));
});
