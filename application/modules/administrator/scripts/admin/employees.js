function getEmployeesList() {
    let dataClient = {
        'action': "getEmployeesList"
    };
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

function createTable() {
    $('.space-container').html("");
    let result = getEmployeesList();
    result.done(function () {
        let data = result.responseJSON.data;
        console.log(data);
        let view = result.responseJSON.view;
        $('#employees_info').html(data.length);
        $('.space-container').html(view);
        for(let i = 0; i < data.length; i++) {
            $('#edit_'+i).click(function () {
                alert("good");
                //windowEditUser(data[i]);
            });
            $('#delete_'+i).click(function () {
                alert("good");
                //windowDeleteUser(data[i]);
            });
        }
    });
}

function windowEmployeeUser() {
    let result = getWindowForm("getWindowFormAddEmployee");
    result.done(function () {
        let data = result.responseJSON.view;
        customWindow(data, 500, 800);
        $('#form_add').submit(function (event) {
            event.preventDefault();
            alert("Gun");
        });
    });
}

$(document).ready(function() {
    $('#add_employee').click(function () {
        windowEmployeeUser();
    });
    createTable();
});