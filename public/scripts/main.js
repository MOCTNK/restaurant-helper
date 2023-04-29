function customWindow(html, width = 660, height = 460) {
    let left = (width + 40) / 2;
    let top = (height + 40) / 2;
    $('body').prepend('<div class="darkness"></div>');
    $('body').prepend('<div class="custom-window" style="width: '+width+'px; height: '+height+'px; margin-left: -'+left+'px; margin-top: -'+top+'px;"></div>');
    $('.custom-window').append('<div class="custom-window_panel"></div>');
    $('.custom-window').append('<div class="custom-window_container"></div>');
    $('.custom-window_panel').append('<div class="custom-window_close"></div>');
    $('.custom-window_container').append(html);
    $('.custom-window_close').click(function () {
        $('.custom-window').remove();
        $('.darkness').remove();
    });
}

function closeCustomWindow() {
    $('.custom-window').remove();
    $('.darkness').remove();
}

function getDataForm(form) {
    let strData = form.serializeArray();
    let result = {};
    let i = 0;
    while(true) {
        if(strData[i]) {
            result[strData[i].name] = strData[i].value;
        } else {
            break;
        }
        i++;
    }
    return result;
}

function message(text, error = true) {
    $('.messages-box').append('<div class="message" style="'+(!error ? "background-color: #28da6e;" : "")+'">'+text+'</div>');
    $('.messages-box').css('visibility','visible');
    $('body').click(function(){
        $('.message').remove();
        $('.messages-box').css('visibility','hidden');
    });
}
