
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
            message("Ошибка запроса! Результат в консоле!");
            console.log(result);
        },
    });
}

function createTable() {
    $('.space-container').html("");
    let result = getUsersList();
    result.done(function () {
        let data = result.responseJSON.data;
        let view = result.responseJSON.view;
        $('#user_info').html(data.length);
        $('.space-container').html(view);
        for(let i = 0; i < data.length; i++) {
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
            message("Ошибка запроса! Результат в консоле!");
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
            message("Ошибка запроса! Результат в консоле!");
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
            message("Ошибка запроса! Результат в консоле!");
            console.log(result);
        },
    });
}

function deleteUser(dataClient) {
    $.ajax({
        type: 'post',
        url: URL_ACTION,
        dataType: 'json',
        data: dataClient,
        success: function(result) {
            if(result.success) {
                closeCustomWindow();
                createTable();
                message("Пользователь удален!", false);
            } else {
                message(result.message);
            }
        },
        error: function(result) {
            message("Ошибка запроса! Результат в консоле!");
            console.log(result);
        },
    });
}

function windowAddUser() {
    let result = getWindowForm("getWindowFormAddUser");
    result.done(function () {
        let data = result.responseJSON.view;
        customWindow(data, 500, 800);
        $('#input_avatar').change(function (event) {
            let url = URL.createObjectURL(event.target.files[0]);
            $('.avatar').attr('src',url);
        });
        $('#form_add').submit(function (event) {
            event.preventDefault();
            let dataClient = {
                'action': "createUser",
                'form': getDataForm($('#form_add'))
            };
            dataClient.form.is_admin = $(".custom-checkbox").prop('checked');
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
        customWindow(data, 500, 800);
        $('#input_avatar').change(function (event) {
            let url = URL.createObjectURL(event.target.files[0]);
            $('.avatar').attr('src',url);
        });
        $('#form_edit').submit(function (event) {
            event.preventDefault();
            let dataClient = {
                'action': "editUser",
                'form': getDataForm($('#form_edit'))
            };
            dataClient.form.id = user.id;
            dataClient.form.is_admin = $(".custom-checkbox").prop('checked');
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
        customWindow(data, 400, 250);
        $('#form_delete').submit(function (event) {
            event.preventDefault();
            let dataClient = {
                'action': "deleteUser",
                'id': user.id
            };
            deleteUser(dataClient);
        });
    });
}

$(document).ready(function() {
    $('#add_user').click(function () {
        windowAddUser();
    });
    createTable();
});