

function getModuleList() {
    let dataClient = {
        'action': "getModuleList"
    };
    return $.ajax({
        type: 'post',
        url: '/panel/admin/modules',
        dataType: 'json',
        data: dataClient,
        success: function(result) {

        },
        error: function(result) {

        },
    });
}

function initModule(module) {
    let dataClient = {
        'action': "initModule",
        'module': module
    };
    $.ajax({
        type: 'post',
        url: '/panel/admin/modules',
        dataType: 'json',
        data: dataClient,
        success: function(result) {
            if(result.success) {
                $('.module-list').html("");
                createModuleList();
            } else {
                message(result.message);
            }
        },
        error: function(result) {
            console.log(result);
        },
    });
}

function createModuleList() {
    let result = getModuleList();

    result.done(function () {
        $('.module-list').append(result.responseJSON.view);
        for(let i = 0; i < result.responseJSON.list.length; i++) {
            let id = result.responseJSON.list[i].init ? '#delete_'+i : '#init_'+i;
            $(id).click(function() {
                if(!result.responseJSON.list[i].init) {
                    initModule(result.responseJSON.list[i].name);
                } else {
                    alert(result.responseJSON.list[i].name);
                }
            });
        }
    });
}
$(document).ready(function() {
    $('#update').click(function() {
        $('.module-list').html("");
        createModuleList();
    });
    createModuleList();
});