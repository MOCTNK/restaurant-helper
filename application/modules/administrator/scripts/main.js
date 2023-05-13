function getWindowForm(action, vars = []) {
    let dataClient = {
        'action': action,
        'vars': vars
    };
    console.log(dataClient);
    return $.ajax({
        type: 'post',
        url: URL_ACTION,
        dataType: 'json',
        data: dataClient,
        success: function(result) {
        },
        error: function(result) {
            message("Ошибка запроса! Результат в консоле!");
            console.log(result);
        },
    });
}