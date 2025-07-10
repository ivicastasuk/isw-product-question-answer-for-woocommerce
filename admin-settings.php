<?php
// Settings stranica za ISW Product Q&A plugin

// Registruj settings opcije
add_action('admin_init', 'isw_pqa_register_settings');
function isw_pqa_register_settings() {
    // Registruj settings group
    register_setting('isw_pqa_settings', 'isw_pqa_options', array(
        'sanitize_callback' => 'isw_pqa_sanitize_options'
    ));
    
    // Osnovne postavke sekcija
    add_settings_section(
        'isw_pqa_general_section',
        'Osnovne postavke',
        'isw_pqa_general_section_callback',
        'isw_pqa_settings'
    );
    
    // Frontend postavke sekcija
    add_settings_section(
        'isw_pqa_frontend_section',
        'Frontend postavke',
        'isw_pqa_frontend_section_callback',
        'isw_pqa_settings'
    );
    
    // Tipografija sekcija
    add_settings_section(
        'isw_pqa_typography_section',
        'Tipografija',
        'isw_pqa_typography_section_callback',
        'isw_pqa_settings'
    );
    
    // Izgled pozadine sekcija
    add_settings_section(
        'isw_pqa_background_section',
        'Pozadina i kontejneri',
        'isw_pqa_background_section_callback',
        'isw_pqa_settings'
    );
    
    // Dugmićи sekcija
    add_settings_section(
        'isw_pqa_buttons_section',
        'Dugmići',
        'isw_pqa_buttons_section_callback',
        'isw_pqa_settings'
    );
    
    // Polje za omogućavanje/onemogućavanje Q&A tab-a
    add_settings_field(
        'enable_qa_tab',
        'Omogući Q&A tab',
        'isw_pqa_enable_qa_tab_callback',
        'isw_pqa_settings',
        'isw_pqa_general_section'
    );
    
    // Polje za naslov tab-a
    add_settings_field(
        'qa_tab_title',
        'Naslov Q&A tab-a',
        'isw_pqa_qa_tab_title_callback',
        'isw_pqa_settings',
        'isw_pqa_general_section'
    );
    
    // Polje za prioritet tab-a
    add_settings_field(
        'qa_tab_priority',
        'Prioritet tab-a',
        'isw_pqa_qa_tab_priority_callback',
        'isw_pqa_settings',
        'isw_pqa_general_section'
    );
    
    // Polje za broj pitanja po stranici
    add_settings_field(
        'questions_per_page',
        'Broj pitanja po stranici',
        'isw_pqa_questions_per_page_callback',
        'isw_pqa_settings',
        'isw_pqa_frontend_section'
    );
    
    // Polje za automatsko odobravanje pitanja
    add_settings_field(
        'auto_approve_questions',
        'Automatski odobri pitanja',
        'isw_pqa_auto_approve_questions_callback',
        'isw_pqa_settings',
        'isw_pqa_frontend_section'
    );
    
    // Polje za email notifikacije
    add_settings_field(
        'email_notifications',
        'Email notifikacije za nova pitanja',
        'isw_pqa_email_notifications_callback',
        'isw_pqa_settings',
        'isw_pqa_frontend_section'
    );
    
    // === TIPOGRAFIJA POLJA ===
    
    // Font family
    add_settings_field(
        'font_family',
        'Font Family',
        'isw_pqa_font_family_callback',
        'isw_pqa_settings',
        'isw_pqa_typography_section'
    );
    
    // Font size
    add_settings_field(
        'font_size',
        'Veličina fonta',
        'isw_pqa_font_size_callback',
        'isw_pqa_settings',
        'isw_pqa_typography_section'
    );
    
    // Font weight
    add_settings_field(
        'font_weight',
        'Debljina fonta',
        'isw_pqa_font_weight_callback',
        'isw_pqa_settings',
        'isw_pqa_typography_section'
    );
    
    // Text color
    add_settings_field(
        'text_color',
        'Boja teksta',
        'isw_pqa_text_color_callback',
        'isw_pqa_settings',
        'isw_pqa_typography_section'
    );
    
    // Text transform
    add_settings_field(
        'text_transform',
        'Transformacija teksta',
        'isw_pqa_text_transform_callback',
        'isw_pqa_settings',
        'isw_pqa_typography_section'
    );
    
    // Line height
    add_settings_field(
        'line_height',
        'Visina reda',
        'isw_pqa_line_height_callback',
        'isw_pqa_settings',
        'isw_pqa_typography_section'
    );
    
    // === POZADINA I KONTEJNERI ===
    
    // Question container background
    add_settings_field(
        'question_bg_color',
        'Pozadina pitanja',
        'isw_pqa_question_bg_color_callback',
        'isw_pqa_settings',
        'isw_pqa_background_section'
    );
    
    // Answer container background
    add_settings_field(
        'answer_bg_color',
        'Pozadina odgovora',
        'isw_pqa_answer_bg_color_callback',
        'isw_pqa_settings',
        'isw_pqa_background_section'
    );
    
    // Container border
    add_settings_field(
        'container_border',
        'Border kontejnera',
        'isw_pqa_container_border_callback',
        'isw_pqa_settings',
        'isw_pqa_background_section'
    );
    
    // Container border radius
    add_settings_field(
        'container_border_radius',
        'Zaobljenje uglova',
        'isw_pqa_container_border_radius_callback',
        'isw_pqa_settings',
        'isw_pqa_background_section'
    );
    
    // Container padding
    add_settings_field(
        'container_padding',
        'Unutrašnji razmak',
        'isw_pqa_container_padding_callback',
        'isw_pqa_settings',
        'isw_pqa_background_section'
    );
    
    // Container margin
    add_settings_field(
        'container_margin',
        'Spoljašnji razmak',
        'isw_pqa_container_margin_callback',
        'isw_pqa_settings',
        'isw_pqa_background_section'
    );
    
    // === DUGMIĆI ===
    
    // Button text color
    add_settings_field(
        'btn_text_color',
        'Boja teksta dugmića',
        'isw_pqa_btn_text_color_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button background color
    add_settings_field(
        'btn_bg_color',
        'Pozadina dugmića',
        'isw_pqa_btn_bg_color_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button hover background
    add_settings_field(
        'btn_hover_bg_color',
        'Pozadina na hover',
        'isw_pqa_btn_hover_bg_color_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button hover text color
    add_settings_field(
        'btn_hover_text_color',
        'Boja teksta na hover',
        'isw_pqa_btn_hover_text_color_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button border
    add_settings_field(
        'btn_border',
        'Border dugmića',
        'isw_pqa_btn_border_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button border radius
    add_settings_field(
        'btn_border_radius',
        'Zaobljenje dugmića',
        'isw_pqa_btn_border_radius_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button padding
    add_settings_field(
        'btn_padding',
        'Unutrašnji razmak dugmića',
        'isw_pqa_btn_padding_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button width
    add_settings_field(
        'btn_width',
        'Širina dugmića',
        'isw_pqa_btn_width_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button alignment
    add_settings_field(
        'btn_alignment',
        'Poravnanje dugmića',
        'isw_pqa_btn_alignment_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button font size
    add_settings_field(
        'btn_font_size',
        'Veličina fonta dugmića',
        'isw_pqa_btn_font_size_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button font weight
    add_settings_field(
        'btn_font_weight',
        'Debljina fonta dugmića',
        'isw_pqa_btn_font_weight_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button text transform
    add_settings_field(
        'btn_text_transform',
        'Transformacija teksta dugmića',
        'isw_pqa_btn_text_transform_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button text - Ask Question
    add_settings_field(
        'btn_text_ask_question',
        'Tekst dugmeta "Postavi pitanje"',
        'isw_pqa_btn_text_ask_question_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button text - Submit Question
    add_settings_field(
        'btn_text_submit_question',
        'Tekst dugmeta "Pošalji"',
        'isw_pqa_btn_text_submit_question_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button text - Cancel
    add_settings_field(
        'btn_text_cancel',
        'Tekst dugmeta "Otkaži"',
        'isw_pqa_btn_text_cancel_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
    
    // Button text - Load More
    add_settings_field(
        'btn_text_load_more',
        'Tekst dugmeta "Učitaj još"',
        'isw_pqa_btn_text_load_more_callback',
        'isw_pqa_settings',
        'isw_pqa_buttons_section'
    );
}

// Sanitization funkcija za opcije
function isw_pqa_sanitize_options($input) {
    $sanitized = array();
    
    if (!is_array($input)) {
        return $sanitized;
    }
    
    // Boolean opcije
    $boolean_fields = array(
        'enable_qa_tab', 
        'auto_approve_questions', 
        'email_notifications'
    );
    
    foreach ($boolean_fields as $field) {
        $sanitized[$field] = isset($input[$field]) ? 1 : 0;
    }
    
    // Text opcije
    $text_fields = array(
        'qa_tab_title',
        'btn_text_ask_question',
        'btn_text_submit_question', 
        'btn_text_cancel',
        'btn_text_load_more'
    );
    
    foreach ($text_fields as $field) {
        if (isset($input[$field])) {
            $sanitized[$field] = sanitize_text_field($input[$field]);
        }
    }
    
    // Numeričke opcije
    $numeric_fields = array(
        'qa_tab_priority' => array('min' => 1, 'max' => 100),
        'questions_per_page' => array('min' => 1, 'max' => 50),
        'font_size' => array('min' => 10, 'max' => 30),
        'line_height' => array('min' => 1, 'max' => 3),
        'container_border_width' => array('min' => 0, 'max' => 10),
        'container_border_radius' => array('min' => 0, 'max' => 50),
        'container_padding' => array('min' => 0, 'max' => 50),
        'container_margin' => array('min' => 0, 'max' => 50),
        'btn_border_width' => array('min' => 0, 'max' => 10),
        'btn_border_radius' => array('min' => 0, 'max' => 50),
        'btn_padding_tb' => array('min' => 0, 'max' => 30),
        'btn_padding_lr' => array('min' => 0, 'max' => 50),
        'btn_font_size' => array('min' => 10, 'max' => 24),
        'btn_width_value' => array('min' => 50, 'max' => 500)
    );
    
    foreach ($numeric_fields as $field => $limits) {
        if (isset($input[$field])) {
            $value = floatval($input[$field]);
            $sanitized[$field] = max($limits['min'], min($limits['max'], $value));
        }
    }
    
    // Color opcije
    $color_fields = array(
        'text_color',
        'question_bg_color',
        'answer_bg_color', 
        'container_border_color',
        'btn_text_color',
        'btn_bg_color',
        'btn_hover_bg_color',
        'btn_hover_text_color',
        'btn_border_color'
    );
    
    foreach ($color_fields as $field) {
        if (isset($input[$field])) {
            $sanitized[$field] = sanitize_hex_color($input[$field]);
        }
    }
    
    // Select opcije
    $select_fields = array(
        'font_family' => array(
            'inherit', 'Arial, sans-serif', 'Georgia, serif', 'Helvetica, sans-serif',
            'Times New Roman, serif', 'Verdana, sans-serif', 'Open Sans, sans-serif',
            'Roboto, sans-serif', 'Lato, sans-serif', 'Montserrat, sans-serif',
            'Source Sans Pro, sans-serif'
        ),
        'font_weight' => array('normal', 'bold', '300', '400', '500', '600', '700', '800'),
        'text_transform' => array('none', 'uppercase', 'lowercase', 'capitalize'),
        'container_border_style' => array('none', 'solid', 'dashed', 'dotted'),
        'btn_border_style' => array('none', 'solid', 'dashed', 'dotted'),
        'btn_font_weight' => array('normal', 'bold', '300', '400', '500', '600', '700', '800'),
        'btn_text_transform' => array('none', 'uppercase', 'lowercase', 'capitalize'),
        'btn_width_type' => array('auto', 'fixed', 'full'),
        'btn_alignment' => array('left', 'center', 'right')
    );
    
    foreach ($select_fields as $field => $allowed_values) {
        if (isset($input[$field]) && in_array($input[$field], $allowed_values)) {
            $sanitized[$field] = $input[$field];
        }
    }
    
    return $sanitized;
}

// Callback funkcije za sekcije
function isw_pqa_general_section_callback() {
    echo '<p>Osnovne postavke za rad Q&A sistema.</p>';
}

function isw_pqa_frontend_section_callback() {
    echo '<p>Osnovne postavke za prikaz na frontend-u.</p>';
}

function isw_pqa_typography_section_callback() {
    echo '<p>Postavke tipografije za tekst pitanja i odgovora.</p>';
}

function isw_pqa_background_section_callback() {
    echo '<p>Postavke pozadine i kontejnera za pitanja i odgovore.</p>';
}

function isw_pqa_buttons_section_callback() {
    echo '<p>Detaljne postavke izgleda dugmića.</p>';
}

// Callback funkcije za polja
function isw_pqa_enable_qa_tab_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['enable_qa_tab']) ? $options['enable_qa_tab'] : 1;
    echo '<input type="checkbox" name="isw_pqa_options[enable_qa_tab]" value="1" ' . checked(1, $value, false) . ' />';
    echo '<label> Prikaži Q&A tab na stranicama proizvoda</label>';
}

function isw_pqa_qa_tab_title_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['qa_tab_title']) ? $options['qa_tab_title'] : 'Pitanja i odgovori';
    echo '<input type="text" name="isw_pqa_options[qa_tab_title]" value="' . esc_attr($value) . '" class="regular-text" />';
    echo '<p class="description">Naslov koji će se prikazati na tab-u.</p>';
}

function isw_pqa_qa_tab_priority_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['qa_tab_priority']) ? $options['qa_tab_priority'] : 60;
    echo '<input type="number" name="isw_pqa_options[qa_tab_priority]" value="' . esc_attr($value) . '" min="1" max="100" />';
    echo '<p class="description">Redosled prikaza tab-a (veći broj = kasnije se prikazuje).</p>';
}

function isw_pqa_questions_per_page_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['questions_per_page']) ? $options['questions_per_page'] : 5;
    echo '<input type="number" name="isw_pqa_options[questions_per_page]" value="' . esc_attr($value) . '" min="1" max="50" />';
    echo '<p class="description">Broj pitanja koji se učitava odjednom.</p>';
}

function isw_pqa_auto_approve_questions_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['auto_approve_questions']) ? $options['auto_approve_questions'] : 1;
    echo '<input type="checkbox" name="isw_pqa_options[auto_approve_questions]" value="1" ' . checked(1, $value, false) . ' />';
    echo '<label> Automatski odobri nova pitanja (inače čekaju odobravanje)</label>';
}

function isw_pqa_email_notifications_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['email_notifications']) ? $options['email_notifications'] : 0;
    echo '<input type="checkbox" name="isw_pqa_options[email_notifications]" value="1" ' . checked(1, $value, false) . ' />';
    echo '<label> Pošalji email administratoru kada se postavi novo pitanje</label>';
}

// Funkcija za dobijanje opcija sa default vrednostima
function isw_pqa_get_option($option_name, $default = '') {
    $options = get_option('isw_pqa_options', array());
    return isset($options[$option_name]) ? $options[$option_name] : $default;
}

// Settings stranica
function isw_pqa_settings_page() {
    ?>
    <div class="wrap">
        <h1>ISW Product Q&A - Postavke</h1>
        
        <!-- Tab navigacija -->
        <h2 class="nav-tab-wrapper">
            <a href="#general" class="nav-tab nav-tab-active" onclick="switchTab(event, 'general')">Osnovno</a>
            <a href="#typography" class="nav-tab" onclick="switchTab(event, 'typography')">Tipografija</a>
            <a href="#containers" class="nav-tab" onclick="switchTab(event, 'containers')">Kontejneri</a>
            <a href="#buttons" class="nav-tab" onclick="switchTab(event, 'buttons')">Dugmići</a>
            <a href="#info" class="nav-tab" onclick="switchTab(event, 'info')">Info</a>
        </h2>
        
        <form method="post" action="options.php">
            <?php settings_fields('isw_pqa_settings'); ?>
            
            <!-- General tab -->
            <div id="general" class="tab-content" style="display: block;">
                <h3>Osnovne postavke</h3>
                <table class="form-table">
                    <?php do_settings_fields('isw_pqa_settings', 'isw_pqa_general_section'); ?>
                </table>
                
                <h3>Frontend postavke</h3>
                <div class="frontend-settings-block">
                    <?php
                    // Prikaži frontend postavke jedna ispod druge
                    $frontend_fields = array(
                        'questions_per_page' => 'Broj pitanja po stranici',
                        'auto_approve_questions' => 'Automatski odobri pitanja', 
                        'email_notifications' => 'Email notifikacije za nova pitanja'
                    );
                    
                    foreach ($frontend_fields as $field_name => $field_label) {
                        echo '<div class="frontend-setting-item">';
                        echo '<h4>' . esc_html($field_label) . '</h4>';
                        
                        if ($field_name == 'questions_per_page') {
                            isw_pqa_questions_per_page_callback();
                        } elseif ($field_name == 'auto_approve_questions') {
                            isw_pqa_auto_approve_questions_callback();
                        } elseif ($field_name == 'email_notifications') {
                            isw_pqa_email_notifications_callback();
                        }
                        
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            
            <!-- Typography tab -->
            <div id="typography" class="tab-content" style="display: none;">
                <h3>Tipografija</h3>
                <?php do_settings_fields('isw_pqa_settings', 'isw_pqa_typography_section'); ?>
            </div>
            
            <!-- Containers tab -->
            <div id="containers" class="tab-content" style="display: none;">
                <h3>Pozadina i kontejneri</h3>
                <?php do_settings_fields('isw_pqa_settings', 'isw_pqa_background_section'); ?>
            </div>
            
            <!-- Buttons tab -->
            <div id="buttons" class="tab-content" style="display: none;">
                <h3>Dugmići</h3>
                <?php do_settings_fields('isw_pqa_settings', 'isw_pqa_buttons_section'); ?>
                
                <!-- Preview dugmića -->
                <div class="btn-preview">
                    <div class="btn-preview-title">Preview dugmića:</div>
                    <div style="padding: 15px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;">
                        <?php 
                        $options = get_option('isw_pqa_options');
                        $preview_text = isset($options['btn_text_ask_question']) ? $options['btn_text_ask_question'] : 'Postavi pitanje';
                        ?>
                        <button type="button" id="btn-preview" style="
                            display: inline-block;
                            margin: 0;
                            text-decoration: none;
                            cursor: pointer;
                            border: 2px solid #4abb6b;
                            outline: none;
                            background-color: #4abb6b;
                            color: #ffffff;
                            padding: 8px 20px;
                            font-size: 14px;
                            font-weight: normal;
                            border-radius: 25px;
                            transition: all 0.3s ease;
                        "><?php echo esc_html($preview_text); ?></button>
                        <p style="margin-top: 10px; color: #666; font-size: 12px;">
                            <em>Preview se ažurira automatski kada menjate postavke.</em>
                            <br>
                            <button type="button" onclick="forceUpdatePreview()" style="margin-top: 5px; font-size: 11px; padding: 2px 8px;">
                                🔄 Ručno ažuriranje preview-a
                            </button>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Info tab -->
            <div id="info" class="tab-content" style="display: none;">
                <div style="padding: 15px; background: #f1f1f1; border-radius: 5px;">
                    <h3>Informacije o plugin-u</h3>
                    <p><strong>Verzija:</strong> 1.2</p>
                    <p><strong>Autor:</strong> ISW</p>
                    <p><strong>Opis:</strong> Plugin za dodavanje Q&A funkcionalnosti na WooCommerce proizvode.</p>
                    
                    <h4>Statistike</h4>
                    <?php
                    $total_questions = wp_count_posts('isw_product_question');
                    $answered_questions = get_posts(array(
                        'post_type' => 'isw_product_question',
                        'post_parent' => 0,
                        'meta_query' => array(
                            array(
                                'key' => 'product_id',
                                'compare' => 'EXISTS'
                            )
                        ),
                        'fields' => 'ids'
                    ));
                    
                    $answered_count = 0;
                    foreach($answered_questions as $question_id) {
                        $answers = get_children(array(
                            'post_parent' => $question_id,
                            'post_type' => 'isw_product_question'
                        ));
                        if (!empty($answers)) {
                            $answered_count++;
                        }
                    }
                    
                    $unanswered_count = count($answered_questions) - $answered_count;
                    ?>
                    <p><strong>Ukupno pitanja:</strong> <?php echo esc_html(count($answered_questions)); ?></p>
                    <p><strong>Odgovorena pitanja:</strong> <?php echo esc_html($answered_count); ?></p>
                    <p><strong>Neodgovorena pitanja:</strong> <?php echo esc_html($unanswered_count); ?></p>
                </div>
            </div>
            
            <?php submit_button('Sačuvaj postavke'); ?>
        </form>
        
        <style>
        .tab-content { 
            display: none; 
            padding: 20px 0;
        }
        .tab-content table {
            margin-top: 20px;
        }
        .form-table th {
            width: 200px;
        }
        .form-table td input[type="color"] {
            width: 50px;
            height: 30px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .form-table td select {
            min-width: 150px;
        }
        .form-table td input[type="number"] {
            width: 80px;
        }
        .description {
            font-style: italic;
            color: #666;
            margin-top: 5px;
        }
        
        /* Frontend postavke custom layout */
        .frontend-settings-block {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-top: 15px;
        }
        
        .frontend-setting-item {
            margin-bottom: 25px;
            padding: 15px;
            background: white;
            border-radius: 4px;
            border-left: 4px solid #0073aa;
        }
        
        .frontend-setting-item:last-child {
            margin-bottom: 0;
        }
        
        .frontend-setting-item h4 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 15px;
            font-weight: 600;
        }
        
        .frontend-setting-item input[type="checkbox"] {
            margin-right: 8px;
        }
        
        .frontend-setting-item input[type="number"] {
            width: 80px;
            height: 30px;
            padding: 4px 8px;
        }
        
        .frontend-setting-item label {
            font-weight: normal;
            color: #555;
        }
        </style>
        
        <script>
        function switchTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("nav-tab");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("nav-tab-active");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.classList.add("nav-tab-active");
            evt.preventDefault();
            
            // Ako se prebacujemo na buttons tab, reinicijalizuj preview
            if (tabName === 'buttons') {
                setTimeout(function() {
                    initButtonPreview();
                }, 100);
            }
        }
        
        function initButtonPreview() {
            // Prvo ažuriraj preview sa trenutnim vrednostima
            setTimeout(function() {
                updateButtonPreview();
            }, 100);
            
            // Pronađi sve inpute i selecte
            var buttonInputs = document.querySelectorAll('input[name^="isw_pqa_options[btn_"], select[name^="isw_pqa_options[btn_"]');
            
            buttonInputs.forEach(function(input, index) {
                // Ukloni stare listenere
                input.removeEventListener('input', updateButtonPreview);
                input.removeEventListener('change', updateButtonPreview);
                
                // Dodaj nove listenere
                input.addEventListener('input', function() {
                    setTimeout(updateButtonPreview, 50);
                });
                
                input.addEventListener('change', function() {
                    setTimeout(updateButtonPreview, 50);
                });
            });
        }
        
        // Live preview za dugmiće
        function updateButtonPreview() {
            var preview = document.getElementById('btn-preview');
            if (!preview) {
                return;
            }
            
            // Helper funkcije za dobijanje vrednosti
            var textColor = getInputValue('isw_pqa_options[btn_text_color]', '#ffffff');
            var bgColor = getInputValue('isw_pqa_options[btn_bg_color]', '#4abb6b');
            var hoverBgColor = getInputValue('isw_pqa_options[btn_hover_bg_color]', '#ffffff');
            var hoverTextColor = getInputValue('isw_pqa_options[btn_hover_text_color]', '#4abb6b');
            var borderWidth = getInputValue('isw_pqa_options[btn_border_width]', '2');
            var borderStyle = getSelectValue('isw_pqa_options[btn_border_style]', 'solid');
            var borderColor = getInputValue('isw_pqa_options[btn_border_color]', '#4abb6b');
            var borderRadius = getInputValue('isw_pqa_options[btn_border_radius]', '25');
            var paddingTB = getInputValue('isw_pqa_options[btn_padding_tb]', '8');
            var paddingLR = getInputValue('isw_pqa_options[btn_padding_lr]', '20');
            var fontSize = getInputValue('isw_pqa_options[btn_font_size]', '14');
            var fontWeight = getSelectValue('isw_pqa_options[btn_font_weight]', 'normal');
            var textTransform = getSelectValue('isw_pqa_options[btn_text_transform]', 'none');
            var widthType = getSelectValue('isw_pqa_options[btn_width_type]', 'auto');
            var widthValue = getInputValue('isw_pqa_options[btn_width_value]', '150');
            
            // Primeni stilove (bez !important)
            preview.style.color = textColor;
            preview.style.backgroundColor = bgColor;
            preview.style.border = borderWidth + 'px ' + borderStyle + ' ' + borderColor;
            preview.style.borderRadius = borderRadius + 'px';
            preview.style.padding = paddingTB + 'px ' + paddingLR + 'px';
            preview.style.fontSize = fontSize + 'px';
            preview.style.fontWeight = fontWeight;
            preview.style.textTransform = textTransform;
            preview.style.textDecoration = 'none';
            preview.style.cursor = 'pointer';
            preview.style.transition = 'all 0.3s ease';
            preview.style.display = 'inline-block';
            preview.style.margin = '0';
            preview.style.outline = 'none';
            
            // Width handling
            if (widthType === 'fixed') {
                preview.style.width = widthValue + 'px';
            } else if (widthType === 'full') {
                preview.style.width = '100%';
            } else {
                preview.style.width = 'auto';
            }
            
            // Store colors for hover (remove old event listeners first)
            var newPreview = preview.cloneNode(true);
            preview.parentNode.replaceChild(newPreview, preview);
            preview = newPreview;
            
            // Update button text if changed
            var askQuestionText = getInputValue('isw_pqa_options[btn_text_ask_question]', 'Postavi pitanje');
            if (askQuestionText && askQuestionText.trim() !== '') {
                preview.textContent = askQuestionText;
            }
            
            // Add hover effects
            preview.addEventListener('mouseenter', function() {
                this.style.backgroundColor = hoverBgColor;
                this.style.color = hoverTextColor;
            });
            
            preview.addEventListener('mouseleave', function() {
                this.style.backgroundColor = bgColor;
                this.style.color = textColor;
            });
        }
        
        function forceUpdatePreview() {
            updateButtonPreview();
        }
        
        // Helper funkcije za dobijanje vrednosti
        function getInputValue(name, defaultValue) {
            var element = document.querySelector('input[name="' + name + '"]');
            return element ? element.value : defaultValue;
        }
        
        function getSelectValue(name, defaultValue) {
            var element = document.querySelector('select[name="' + name + '"]');
            return element ? element.value : defaultValue;
        }
        
        // Dodaj event listenere za live preview
        document.addEventListener('DOMContentLoaded', function() {
            // Sačekaj da se svi elementi učitaju
            setTimeout(function() {
                initButtonPreview();
            }, 200);
            
            // Takođe pozovi kad se klikne na bilo koji tab
            var tabLinks = document.querySelectorAll('.nav-tab');
            tabLinks.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    setTimeout(function() {
                        if (document.getElementById('btn-preview')) {
                            initButtonPreview();
                        }
                    }, 300);
                });
            });
        });
        </script>
    </div>
    <?php
}

// === TIPOGRAFIJA CALLBACK FUNKCIJE ===

function isw_pqa_font_family_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['font_family']) ? $options['font_family'] : 'inherit';
    
    $fonts = array(
        'inherit' => 'Nasleđen od teme',
        'Arial, sans-serif' => 'Arial',
        'Georgia, serif' => 'Georgia',
        'Helvetica, sans-serif' => 'Helvetica',
        'Times New Roman, serif' => 'Times New Roman',
        'Verdana, sans-serif' => 'Verdana',
        'Open Sans, sans-serif' => 'Open Sans',
        'Roboto, sans-serif' => 'Roboto',
        'Lato, sans-serif' => 'Lato',
        'Montserrat, sans-serif' => 'Montserrat',
        'Source Sans Pro, sans-serif' => 'Source Sans Pro'
    );
    
    echo '<select name="isw_pqa_options[font_family]">';
    foreach ($fonts as $font_value => $font_name) {
        echo '<option value="' . esc_attr($font_value) . '" ' . selected($value, $font_value, false) . '>' . esc_html($font_name) . '</option>';
    }
    echo '</select>';
}

function isw_pqa_font_size_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['font_size']) ? $options['font_size'] : '14';
    echo '<input type="number" name="isw_pqa_options[font_size]" value="' . esc_attr($value) . '" min="10" max="30" /> px';
    echo '<p class="description">Veličina fonta u pikselima.</p>';
}

function isw_pqa_font_weight_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['font_weight']) ? $options['font_weight'] : 'normal';
    
    $weights = array(
        'normal' => 'Normal',
        'bold' => 'Bold',
        '300' => 'Light (300)',
        '400' => 'Regular (400)',
        '500' => 'Medium (500)',
        '600' => 'Semi Bold (600)',
        '700' => 'Bold (700)',
        '800' => 'Extra Bold (800)'
    );
    
    echo '<select name="isw_pqa_options[font_weight]">';
    foreach ($weights as $weight_value => $weight_name) {
        echo '<option value="' . esc_attr($weight_value) . '" ' . selected($value, $weight_value, false) . '>' . esc_html($weight_name) . '</option>';
    }
    echo '</select>';
}

function isw_pqa_text_color_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['text_color']) ? $options['text_color'] : '#333333';
    echo '<input type="color" name="isw_pqa_options[text_color]" value="' . esc_attr($value) . '" />';
    echo '<p class="description">Osnovna boja teksta.</p>';
}

function isw_pqa_text_transform_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['text_transform']) ? $options['text_transform'] : 'none';
    
    $transforms = array(
        'none' => 'Bez transformacije',
        'uppercase' => 'VELIKA SLOVA',
        'lowercase' => 'mala slova',
        'capitalize' => 'Prvo Veliko Slovo'
    );
    
    echo '<select name="isw_pqa_options[text_transform]">';
    foreach ($transforms as $transform_value => $transform_name) {
        echo '<option value="' . esc_attr($transform_value) . '" ' . selected($value, $transform_value, false) . '>' . esc_html($transform_name) . '</option>';
    }
    echo '</select>';
}

function isw_pqa_line_height_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['line_height']) ? $options['line_height'] : '1.5';
    echo '<input type="number" name="isw_pqa_options[line_height]" value="' . esc_attr($value) . '" min="1" max="3" step="0.1" />';
    echo '<p class="description">Visina reda (1.0 = normalno, 1.5 = uvećano).</p>';
}

// === POZADINA I KONTEJNERI CALLBACK FUNKCIJE ===

function isw_pqa_question_bg_color_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['question_bg_color']) ? $options['question_bg_color'] : '#f5f5f5';
    echo '<input type="color" name="isw_pqa_options[question_bg_color]" value="' . esc_attr($value) . '" />';
    echo '<p class="description">Boja pozadine kontejnera pitanja.</p>';
}

function isw_pqa_answer_bg_color_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['answer_bg_color']) ? $options['answer_bg_color'] : '#e0f7fa';
    echo '<input type="color" name="isw_pqa_options[answer_bg_color]" value="' . esc_attr($value) . '" />';
    echo '<p class="description">Boja pozadine kontejnera odgovora.</p>';
}

function isw_pqa_container_border_callback() {
    $options = get_option('isw_pqa_options');
    $border_width = isset($options['container_border_width']) ? $options['container_border_width'] : '0';
    $border_style = isset($options['container_border_style']) ? $options['container_border_style'] : 'solid';
    $border_color = isset($options['container_border_color']) ? $options['container_border_color'] : '#cccccc';
    
    echo '<input type="number" name="isw_pqa_options[container_border_width]" value="' . esc_attr($border_width) . '" min="0" max="10" style="width: 60px;" /> px ';
    
    echo '<select name="isw_pqa_options[container_border_style]" style="width: 100px;">';
    $border_styles = array('none' => 'Bez', 'solid' => 'Puna', 'dashed' => 'Isprekidana', 'dotted' => 'Tačkasta');
    foreach ($border_styles as $style_value => $style_name) {
        echo '<option value="' . esc_attr($style_value) . '" ' . selected($border_style, $style_value, false) . '>' . esc_html($style_name) . '</option>';
    }
    echo '</select> ';
    
    echo '<input type="color" name="isw_pqa_options[container_border_color]" value="' . esc_attr($border_color) . '" />';
    echo '<p class="description">Širina, stil i boja border-a kontejnera.</p>';
}

function isw_pqa_container_border_radius_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['container_border_radius']) ? $options['container_border_radius'] : '10';
    echo '<input type="number" name="isw_pqa_options[container_border_radius]" value="' . esc_attr($value) . '" min="0" max="50" /> px';
    echo '<p class="description">Zaobljenje uglova kontejnera.</p>';
}

function isw_pqa_container_padding_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['container_padding']) ? $options['container_padding'] : '15';
    echo '<input type="number" name="isw_pqa_options[container_padding]" value="' . esc_attr($value) . '" min="0" max="50" /> px';
    echo '<p class="description">Unutrašnji razmak kontejnera.</p>';
}

function isw_pqa_container_margin_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['container_margin']) ? $options['container_margin'] : '20';
    echo '<input type="number" name="isw_pqa_options[container_margin]" value="' . esc_attr($value) . '" min="0" max="50" /> px';
    echo '<p class="description">Spoljašnji razmak između kontejnera.</p>';
}

// === DUGMIĆI CALLBACK FUNKCIJE ===

function isw_pqa_btn_text_color_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_text_color']) ? $options['btn_text_color'] : '#ffffff';
    echo '<input type="color" name="isw_pqa_options[btn_text_color]" value="' . esc_attr($value) . '" />';
    echo '<p class="description">Boja teksta na dugmićima.</p>';
}

function isw_pqa_btn_bg_color_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_bg_color']) ? $options['btn_bg_color'] : '#4abb6b';
    echo '<input type="color" name="isw_pqa_options[btn_bg_color]" value="' . esc_attr($value) . '" />';
    echo '<p class="description">Boja pozadine dugmića.</p>';
}

function isw_pqa_btn_hover_bg_color_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_hover_bg_color']) ? $options['btn_hover_bg_color'] : '#ffffff';
    echo '<input type="color" name="isw_pqa_options[btn_hover_bg_color]" value="' . esc_attr($value) . '" />';
    echo '<p class="description">Boja pozadine na hover.</p>';
}

function isw_pqa_btn_hover_text_color_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_hover_text_color']) ? $options['btn_hover_text_color'] : '#4abb6b';
    echo '<input type="color" name="isw_pqa_options[btn_hover_text_color]" value="' . esc_attr($value) . '" />';
    echo '<p class="description">Boja teksta na hover.</p>';
}

function isw_pqa_btn_border_callback() {
    $options = get_option('isw_pqa_options');
    $border_width = isset($options['btn_border_width']) ? $options['btn_border_width'] : '2';
    $border_style = isset($options['btn_border_style']) ? $options['btn_border_style'] : 'solid';
    $border_color = isset($options['btn_border_color']) ? $options['btn_border_color'] : '#4abb6b';
    
    echo '<input type="number" name="isw_pqa_options[btn_border_width]" value="' . esc_attr($border_width) . '" min="0" max="10" style="width: 60px;" /> px ';
    
    echo '<select name="isw_pqa_options[btn_border_style]" style="width: 100px;">';
    $border_styles = array('none' => 'Bez', 'solid' => 'Puna', 'dashed' => 'Isprekidana', 'dotted' => 'Tačkasta');
    foreach ($border_styles as $style_value => $style_name) {
        echo '<option value="' . esc_attr($style_value) . '" ' . selected($border_style, $style_value, false) . '>' . esc_html($style_name) . '</option>';
    }
    echo '</select> ';
    
    echo '<input type="color" name="isw_pqa_options[btn_border_color]" value="' . esc_attr($border_color) . '" />';
    echo '<p class="description">Širina, stil i boja border-a dugmića.</p>';
}

function isw_pqa_btn_border_radius_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_border_radius']) ? $options['btn_border_radius'] : '25';
    echo '<input type="number" name="isw_pqa_options[btn_border_radius]" value="' . esc_attr($value) . '" min="0" max="50" /> px';
    echo '<p class="description">Zaobljenje uglova dugmića (25px = okrugao).</p>';
}

function isw_pqa_btn_padding_callback() {
    $options = get_option('isw_pqa_options');
    $padding_tb = isset($options['btn_padding_tb']) ? $options['btn_padding_tb'] : '8';
    $padding_lr = isset($options['btn_padding_lr']) ? $options['btn_padding_lr'] : '20';
    
    echo 'Gore/Dole: <input type="number" name="isw_pqa_options[btn_padding_tb]" value="' . esc_attr($padding_tb) . '" min="0" max="30" style="width: 60px;" /> px ';
    echo 'Levo/Desno: <input type="number" name="isw_pqa_options[btn_padding_lr]" value="' . esc_attr($padding_lr) . '" min="0" max="50" style="width: 60px;" /> px';
    echo '<p class="description">Unutrašnji razmak dugmića.</p>';
}

function isw_pqa_btn_width_callback() {
    $options = get_option('isw_pqa_options');
    $width_type = isset($options['btn_width_type']) ? $options['btn_width_type'] : 'auto';
    $width_value = isset($options['btn_width_value']) ? $options['btn_width_value'] : '150';
    
    echo '<select name="isw_pqa_options[btn_width_type]" id="btn_width_type">';
    $width_types = array('auto' => 'Automatska', 'fixed' => 'Fiksna širina', 'full' => 'Puna širina');
    foreach ($width_types as $type_value => $type_name) {
        echo '<option value="' . esc_attr($type_value) . '" ' . selected($width_type, $type_value, false) . '>' . esc_html($type_name) . '</option>';
    }
    echo '</select> ';
    
    echo '<input type="number" name="isw_pqa_options[btn_width_value]" value="' . esc_attr($width_value) . '" min="50" max="500" id="btn_width_value" style="width: 80px;" /> px';
    echo '<p class="description">Širina dugmića.</p>';
    
    echo '<script>
    document.getElementById("btn_width_type").addEventListener("change", function() {
        var widthInput = document.getElementById("btn_width_value");
        if (this.value === "fixed") {
            widthInput.style.display = "inline";
        } else {
            widthInput.style.display = "none";
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        var event = new Event("change");
        document.getElementById("btn_width_type").dispatchEvent(event);
    });
    </script>';
}

function isw_pqa_btn_alignment_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_alignment']) ? $options['btn_alignment'] : 'left';
    
    $alignments = array(
        'left' => 'Levo',
        'center' => 'Centar',
        'right' => 'Desno'
    );
    
    echo '<select name="isw_pqa_options[btn_alignment]">';
    foreach ($alignments as $align_value => $align_name) {
        echo '<option value="' . esc_attr($align_value) . '" ' . selected($value, $align_value, false) . '>' . esc_html($align_name) . '</option>';
    }
    echo '</select>';
    echo '<p class="description">Poravnanje dugmića u kontejneru.</p>';
}

function isw_pqa_btn_font_size_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_font_size']) ? $options['btn_font_size'] : '14';
    echo '<input type="number" name="isw_pqa_options[btn_font_size]" value="' . esc_attr($value) . '" min="10" max="24" /> px';
    echo '<p class="description">Veličina fonta na dugmićima.</p>';
}

function isw_pqa_btn_font_weight_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_font_weight']) ? $options['btn_font_weight'] : 'normal';
    
    $weights = array(
        'normal' => 'Normal',
        'bold' => 'Bold',
        '300' => 'Light (300)',
        '400' => 'Regular (400)',
        '500' => 'Medium (500)',
        '600' => 'Semi Bold (600)',
        '700' => 'Bold (700)',
        '800' => 'Extra Bold (800)'
    );
    
    echo '<select name="isw_pqa_options[btn_font_weight]">';
    foreach ($weights as $weight_value => $weight_name) {
        echo '<option value="' . esc_attr($weight_value) . '" ' . selected($value, $weight_value, false) . '>' . esc_html($weight_name) . '</option>';
    }
    echo '</select>';
}

// Nova polja - dugmići
function isw_pqa_btn_text_transform_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_text_transform']) ? $options['btn_text_transform'] : 'none';
    
    $transforms = array(
        'none' => 'Normalno',
        'uppercase' => 'VELIKA SLOVA',
        'lowercase' => 'mala slova',
        'capitalize' => 'Prvo Slovo Veliko'
    );
    
    echo '<select name="isw_pqa_options[btn_text_transform]">';
    foreach ($transforms as $transform_value => $transform_name) {
        echo '<option value="' . esc_attr($transform_value) . '" ' . selected($value, $transform_value, false) . '>' . esc_html($transform_name) . '</option>';
    }
    echo '</select>';
    echo '<p class="description">Kako će biti prikazan tekst na dugmićima.</p>';
}

function isw_pqa_btn_text_ask_question_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_text_ask_question']) ? $options['btn_text_ask_question'] : 'Postavi pitanje';
    
    echo '<input type="text" name="isw_pqa_options[btn_text_ask_question]" value="' . esc_attr($value) . '" class="regular-text" />';
    echo '<p class="description">Tekst koji se prikazuje na dugmetu za postavljanje pitanja.</p>';
}

function isw_pqa_btn_text_submit_question_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_text_submit_question']) ? $options['btn_text_submit_question'] : 'Pošalji';
    
    echo '<input type="text" name="isw_pqa_options[btn_text_submit_question]" value="' . esc_attr($value) . '" class="regular-text" />';
    echo '<p class="description">Tekst koji se prikazuje na dugmetu za slanje pitanja.</p>';
}

function isw_pqa_btn_text_cancel_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_text_cancel']) ? $options['btn_text_cancel'] : 'Otkaži';
    
    echo '<input type="text" name="isw_pqa_options[btn_text_cancel]" value="' . esc_attr($value) . '" class="regular-text" />';
    echo '<p class="description">Tekst koji se prikazuje na dugmetu za otkazivanje forme.</p>';
}

function isw_pqa_btn_text_load_more_callback() {
    $options = get_option('isw_pqa_options');
    $value = isset($options['btn_text_load_more']) ? $options['btn_text_load_more'] : 'Učitaj još...';
    
    echo '<input type="text" name="isw_pqa_options[btn_text_load_more]" value="' . esc_attr($value) . '" class="regular-text" />';
    echo '<p class="description">Tekst koji se prikazuje na dugmetu za učitavanje dodatnih pitanja.</p>';
}
