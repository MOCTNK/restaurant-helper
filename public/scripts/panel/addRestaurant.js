
function getWindow(action) {
    let dataClient = {
        'action': action,
    };
    return $.ajax({
        type: 'post',
        url: '/panel/admin/restaurants',
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

function getWindowFormAddRestaurant() {
    return getWindow('windowFormAddRestaurant');
}

function addRestaurant(dataClient) {
    console.log(dataClient);
    $.ajax({
        type: 'post',
        url: '/panel/admin/restaurants/add',
        dataType: 'json',
        data: dataClient,
        success: function(result) {
            console.log(result);
            if(result.success) {
                window.location.replace("/panel/admin/restaurants");
            } else {
                message(result.message);
            }
        },
        error: function(result) {
            message("Ошибка запроса! Результат в консоле!");
            message(result);
        },
    });
}
$(document).ready(function() {
    $('#add').click(function (event) {
        event.preventDefault();
        let result = getWindowFormAddRestaurant()
        result.done(function () {
            let view = result.responseJSON.view;
            customWindow(view, 500, 620);
            $('#form_add_restaurant').submit(function(event) {
                event.preventDefault();
                let dataClient = {
                    'action': "addRestaurant",
                    'form': getDataForm($(this))
                };
                dataClient.form.logo = $('.input_file').val();
                addRestaurant(dataClient);
            });
        });
    });
});