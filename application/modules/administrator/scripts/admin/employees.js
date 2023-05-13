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
        let view = result.responseJSON.view;
        $('#employees_info').html(data.length);
        $('.space-container').html(view);
        for(let i = 0; i < data.length; i++) {
            $('#edit_'+i).click(function () {
                windowEditEmployee(data[i]);
            });
            $('#delete_'+i).click(function () {
                windowDeleteEmployee(data[i].user);
            });
        }
    });
}

function windowEmployeeUser() {
    let result = getWindowForm("getWindowFormAddEmployee");
    result.done(function () {
        let view = result.responseJSON.view;
        let data = result.responseJSON.data;
        customWindow(view, 500, 350);
        $('#form_add').submit(function (event) {
            event.preventDefault();
            if($('#employee_list').val() == null || $('#position_list').val() == null) {
                if($('#employee_list').val() == null) {
                    message("Не выбран пользователь!");
                }
                if($('#position_list').val() == null) {
                    message("Не выбрана должность!");
                }
            } else {
                let idEmployee = data.employees[$('#employee_list').val()].id;
                let idPosition = data.positionsList[$('#position_list').val()].id;
                createEmployee(idEmployee, idPosition);
            }
        });
    });
}

function windowDeleteEmployee(user) {
    let result = getWindowForm("getWindowFormDeleteEmployee", user);
    result.done(function () {
        let data = result.responseJSON.view;
        customWindow(data, 400, 250);
        $('#form_delete').submit(function (event) {
            event.preventDefault();
            let dataClient = {
                'action': "deleteEmployee",
                'id': user.id
            };
            deleteEmployee(dataClient);
        });
    });
}

function windowEditEmployee(userData) {
    let result = getWindowForm("getWindowFormEditEmployee", userData);
    result.done(function () {
        let view = result.responseJSON.view;
        let data = result.responseJSON.data;
        customWindow(view, 500, 350);
        $('#form_edit').submit(function (event) {
            event.preventDefault();
            console.log(data);
            let dataClient = {
                'action': "editEmployee",
                'idUser': userData.user.id,
                'idPosition': data.positionsList[$('#position_list').val()].id
            };
            editEmployee(dataClient);
        });
    });
}

function createEmployee(idEmployee, idPosition) {
    let dataClient = {
        'action': "createEmployee",
        'idEmployee': idEmployee,
        'idPosition': idPosition
    };
    $.ajax({
        type: 'post',
        url: URL_ACTION,
        dataType: 'json',
        data: dataClient,
        success: function(result) {
            if(result.success) {
                closeCustomWindow();
                createTable();
                message("Сотрудник добавлен!", false);
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
function deleteEmployee(dataClient) {
    $.ajax({
        type: 'post',
        url: URL_ACTION,
        dataType: 'json',
        data: dataClient,
        success: function(result) {
            if(result.success) {
                closeCustomWindow();
                createTable();
                message("Сотрудник удален!", false);
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

function editEmployee(dataClient) {
    $.ajax({
        type: 'post',
        url: URL_ACTION,
        dataType: 'json',
        data: dataClient,
        success: function(result) {
            if(result.success) {
                closeCustomWindow();
                createTable();
                message("Сотрудник изменен!", false);
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

$(document).ready(function() {
    $('#add_employee').click(function () {
        windowEmployeeUser();
    });
    createTable();
});