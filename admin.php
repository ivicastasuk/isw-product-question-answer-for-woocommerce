<?php
// Admin meni i stranice
add_action('admin_menu', 'isw_pqa_admin_menu');
function isw_pqa_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=product',
        'ISW Pitanja i Odgovori',
        'ISW Product Q&A',
        'manage_woocommerce',
        'isw-pqa',
        'isw_pqa_admin_page'
    );
}

add_action('admin_enqueue_scripts', function($hook) {
    // Prikaži stil samo na tvojoj custom admin stranici
    if (isset($_GET['page']) && $_GET['page'] === 'isw-pqa') {
        wp_enqueue_style(
            'isw-pqa-style',
            plugins_url('css/style.css', __FILE__)
        );
    }
});

function isw_pqa_admin_page() {
    echo '<div class="wrap"><h1>Proizvodi sa pitanjima</h1>';
    ?>
    <script>
    jQuery(function($){
        $('.isw-pqa-q-title').on('click', function(){
            var $card = $(this).closest('.isw-pqa-q-wrap').find('.isw-pqa-q-card');
            $('.isw-pqa-q-card').not($card).slideUp();
            $card.slideToggle();
        });
    });
    </script>
    <?php

    // Pronađi sva pitanja po proizvodima
    $questions = get_posts(array(
        'post_type' => 'isw_product_question',
        'posts_per_page' => 999,
        'post_parent' => 0,
        'orderby' => 'date',
        'order' => 'DESC'
    ));

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
        echo '<div class="isw-pqa-q-title">'.esc_html($title).'</div>';

        echo '<div class="isw-pqa-q-card">';
        echo '<div><b>Pitanje:</b> '.esc_html($question->post_content).'</div>';
        echo '<div style="font-size:11px;color:#666;">'.esc_html(get_the_date('d.m.Y. H:i', $question)).'</div>';

        if ($has_answer) {
            $answer = $answers[0];
            echo '<div class="isw-pqa-answer" style="margin-top:10px;"><b>Odgovor:</b> '.esc_html($answer->post_content).'</div>';
            echo '<div style="font-size:11px;color:#666;">'.esc_html(get_the_date('d.m.Y. H:i', $answer)).'</div>';
        } else {
            // Forma za odgovor
            echo '<form class="isw-pqa-answer-form" method="post" action="'.admin_url('admin-post.php').'">';
            echo '<input type="hidden" name="action" value="isw_pqa_add_answer">';
            echo '<input type="hidden" name="question_id" value="'.esc_attr($question->ID).'">';
            echo '<input type="hidden" name="product_id" value="'.esc_attr($product_id).'">';
            wp_nonce_field('isw_pqa_add_answer', 'isw_pqa_answer_nonce');
            echo '<textarea name="answer" placeholder="Upišite odgovor..."></textarea>';
            echo '<br><button type="submit" class="button button-primary">ODGOVORI</button>';
            echo '</form>';
        }

        echo '</div></div>';
    }

    echo '</div>';
}

// Handler za unos odgovora (ostaje isti kao ranije)
add_action('admin_post_isw_pqa_add_answer', function() {
    if (
        !current_user_can('manage_woocommerce') ||
        !isset($_POST['isw_pqa_answer_nonce']) ||
        !wp_verify_nonce($_POST['isw_pqa_answer_nonce'], 'isw_pqa_add_answer')
    ) {
        wp_die('Nedozvoljen pristup');
    }
    $question_id = absint($_POST['question_id']);
    $product_id = absint($_POST['product_id']);
    $answer = sanitize_textarea_field($_POST['answer']);
    if ($answer && $question_id && $product_id) {
        wp_insert_post(array(
            'post_type' => 'isw_product_question',
            'post_title' => 'Odgovor - ' . current_time('mysql'),
            'post_content' => $answer,
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_parent' => $question_id,
            'meta_input' => array('product_id' => $product_id)
        ));
    }
    wp_redirect(admin_url('edit.php?post_type=product&page=isw-pqa'));
    exit;
});