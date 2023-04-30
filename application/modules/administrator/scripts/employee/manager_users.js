
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
                windowEditUser(data[i]);
            });
            $('#delete_'+i).click(function () {
                windowDeleteUser(data[i]);
            });
        }
    });
}

function getWindowForm(action, vars = []) {
    let dataClient = {
        'action': action,
        'vars': vars
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
                let file = new FormData(document.getElementById('form_avatar'));
                let resultSaveFile = saveFile(file, 'account', dataClient.form.avatar);
                resultSaveFile.done(function () {
                    closeCustomWindow();
                    createTable();
                    message("Пользователь добавлен!", false);
                });
            } else {
                message(result.message);
            }
        },
        error: function(result) {
            console.log(result);
        },
    });
}

function editUser(dataClient) {
    $.ajax({
        type: 'post',
        url: URL_ACTION,
        dataType: 'json',
        data: dataClient,
        success: function(result) {
            console.log(result);
            if(result.success) {
                let file = new FormData(document.getElementById('form_avatar'));
                let resultSaveFile = saveFile(file, 'account', dataClient.form.avatar);
                resultSaveFile.done(function () {
                    closeCustomWindow();
                    createTable();
                    message("Пользователь обновлен!", false);
                });
            } else {
                message(result.message);
            }
        },
        error: function(result) {
            console.log(result);
        },
    });
}

function windowAddUser() {
    let result = getWindowForm("getWindowFormAddUser");
    result.done(function () {
        let data = result.responseJSON.view;
        customWindow(data, 500, 650);
        $('#input_avatar').change(function (event) {
            let url = URL.createObjectURL(event.target.files[0]);
            $('.avatar').css('background-image','url('+url+')');
        });
        $('#form_add').submit(function (event) {
            event.preventDefault();
            let dataClient = {
                'action': "createUser",
                'form': getDataForm($('#form_add'))
            };
            if(document.getElementById('input_avatar').files.length !== 0) {
                dataClient.form.avatar = getHash()+'.png';
            }
            createUser(dataClient);
        });
    });
}

function windowEditUser(user) {
    let result = getWindowForm("getWindowFormEditUser", user);
    result.done(function () {
        let data = result.responseJSON.view;
        customWindow(data, 500, 550);
        $('#input_avatar').change(function (event) {
            let url = URL.createObjectURL(event.target.files[0]);
            $('.avatar').css('background-image','url('+url+')');
        });
        $('#form_edit').submit(function (event) {
            event.preventDefault();
            let dataClient = {
                'action': "editUser",
                'form': getDataForm($('#form_edit'))
            };
            dataClient.form.id = user.id;
            if(document.getElementById('input_avatar').files.length !== 0) {
                dataClient.form.avatar = getHash()+'.png';
            }
            editUser(dataClient);
        });
    });
}

function windowDeleteUser(user) {
    let result = getWindowForm("getWindowFormDeleteUser", user);
    result.done(function () {
        let data = result.responseJSON.view;
        customWindow(data, 500, 250);

    });
}

$(document).ready(function() {
    $('#add_user').click(function () {
        windowAddUser();
    });
    createTable();
});