

function login(dataClient) {
    $.ajax({
        type: 'post',
        url: '/account/login',
        dataType: 'json',
        data: dataClient,
        success: function(result) {
            console.log(result);
            if(result.success) {
                window.location.replace("/panel/employee");
            } else {
                message(result.message);
            }
        },
        error: function(result) {
            console.log(result);
        },
    });
}
$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault();
        let dataClient = {
            'action': "login",
            'form': getDataForm($(this))
        };
        login(dataClient);
    });
});