function message(text) {
    $('.messages-box').append('<div class="message">'+text+'</div>');
    $('.messages-box').css('visibility','visible');
    $('body').click(function(){
        $('.message').remove();
        $('.messages-box').css('visibility','hidden');
    });
}

export default message;