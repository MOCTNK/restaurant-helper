function message(text) {
    $('.messages-box').append('<div class="message">'+text+'</div>');
    $('body').click(function(){
        $('.message').remove();
    });
}

export default message;