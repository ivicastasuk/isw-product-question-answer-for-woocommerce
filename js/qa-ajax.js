jQuery(function($){
    let offset = 0;
    const container = $('#isw-qa-container');
    const productID = container.data('product');
    const questionsPerPage = parseInt(isw_pqa_ajax.questions_per_page) || 5;
    const loadMoreText = isw_pqa_ajax.btn_text_load_more || 'Učitaj još...';

    function loadQuestions() {
        // Prikaži loading text
        $('#isw-qa-load-more').text('Učitava...');
        
        $.get(isw_pqa_ajax.ajax_url, {
            action: 'isw_pqa_load',
            product_id: productID,
            offset: offset
        }, function(data){
            if(data.trim()) {
                $('#isw-qa-list').append(data);
                $('#isw-qa-load-more').show().text(loadMoreText);
                offset += questionsPerPage;
            } else {
                $('#isw-qa-load-more').hide();
            }
        });
    }

    loadQuestions();

    $('#isw-qa-load-more').on('click', loadQuestions);

    $('#isw-qa-toggle-form').on('click', function(){
        $(this).hide();
        $('#isw-qa-form').slideDown();
    });

    $('#isw-qa-cancel').on('click', function(){
        $('#isw-qa-form').slideUp(function(){
            $('#isw-qa-toggle-form').show();
        });
    });

    $('#isw-qa-form').on('submit', function(e){
        e.preventDefault();
        $.post(isw_pqa_ajax.ajax_url, {
            action: 'isw_pqa_submit',
            nonce: $(this).find('[name="nonce"]').val(),
            question: $(this).find('[name="question"]').val(),
            product_id: productID
        }, function(response){
            alert(response.data);
            $('#isw-qa-form')[0].reset();
            $('#isw-qa-form').slideUp(function(){
                $('#isw-qa-toggle-form').show();
            });
            $('#isw-qa-list').empty();
            offset = 0;
            loadQuestions();
        });
    });

});
