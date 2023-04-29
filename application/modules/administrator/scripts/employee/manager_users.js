
function getUsersList() {
    let dataClient = {
        'action': "getUsersList"
    };
    return $.ajax({
        type: 'post',
        url: URL_ACTION,
        dataType: 'json',
        data: dataClient,
        success: function(result) {
        },
        error: function(result) {
            console.log(result);
        },
    });
}

function createTable() {
    $('.space-container').html("");
    let result = getUsersList();
    result.done(function () {
        let data = result.responseJSON.data;
        $('#user_info').html(data.length);
        $('.space-container').append('<table id="custom_table"></table>');
        $('#custom_table').append(
            '<tr><th class="empty"></th><th>id</th><th>Фото</th><th>ФИО</th><th>Дата рождения</th><th>Дата создания</th></tr>'
        );
        for(let i = 0; i < data.length; i++) {
            $('#custom_table').append(
                '<tr class="'+(i % 2 !== 0 ? "tr-grey" : "tr-blue")+'"><td class="empty">'
                + '<div id="edit_'+i+'" class="button_table" style="background-image: url(/public/resources/table/icon_edit.png);"></div>'
                + '<div id="delete_'+i+'" class="button_table" style="background-image: url(/public/resources/table/icon_delete.png); margin-left: 15px;"></div></td>'
                + '<td>'+data[i].id+'</td>'
                + '<td><div class="table_image" style="background-image: url(/public/resources/account/'+data[i].avatar+');"></div></td>'
                + '<td>'+data[i].surname+' '+data[i].name+' '+data[i].patronymic+'</td>'
                + '<td>'+data[i].date_of_birth+'</td>'
                + '<td>'+data[i].date+'</td></tr>'
            );
            $('#edit_'+i).click(function () {
                windowEditUser(data[i].id);
            });
            $('#delete_'+i).click(function () {
                windowDeleteUser(data[i].id);
            });
        }
    });
}

function getWindowForm() {
    let dataClient = {
        'action': "getWindowFormAddUser"
    };
    return $.ajax({
        type: 'post',
        url: URL_ACTION,
        dataType: 'json',
        data: dataClient,
        success: function(result) {
        },
        error: function(result) {
            console.log(result);
        },
    });
}

function createUser(dataClient) {
    $.ajax({
        type: 'post',
        url: URL_ACTION,
        dataType: 'json',
        data: dataClient,
        success: function(result) {
            console.log(result);
            if(result.success) {
                closeCustomWindow();
                createTable();
                message("Пользователь добавлен!", false);
            } else {
                message(result.message);
            }
        },
        error: function(result) {
            console.log(result);
        },
    });
}

function windowEditUser(idUser) {
    customWindow(idUser, 500, 550);
}

function windowDeleteUser(idUser) {
    customWindow(idUser, 500, 250);
}

$(document).ready(function() {
    $('#add_user').click(function () {
        let result = getWindowForm();
        result.done(function () {
            let data = result.responseJSON.view;
            customWindow(data, 500, 550);
            $('#form_add').submit(function (event) {
                event.preventDefault();
                let dataClient = {
                    'action': "createUser",
                    'form': getDataForm($('#form_add'))
                };
                createUser(dataClient);
            });
        });
    });
    createTable();
});