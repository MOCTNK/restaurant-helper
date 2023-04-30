

var step = 0;
var maxStep = 3;

function clearWindow() {
    $('.installer_space').html('');
}

function getViewStep() {
    if(step === maxStep) {
        window.location.replace("/account/login");
    } else {
        let dataClient = {
            'action': "getView",
            'step': step + 1
        };
        $.ajax({
            type: 'post',
            url: '/installer/setup',
            dataType: 'json',
            data: dataClient,
            success: function (result) {
                console.log(result);
                step++;
                if (result.success) {
                    if(result.next) {
                        getViewStep();
                    } else {
                        clearWindow();
                        $('.installer_space').html(result.view);
                        nextStep();
                    }
                } else {
                    message(result.message);
                }
            },
            error: function (result) {
                console.log(result);
            },
        });
    }
}

function checkStep(dataClient) {
    $.ajax({
        type: 'post',
        url: '/installer/setup',
        dataType: 'json',
        data: dataClient,
        success: function(result) {
            console.log(result);
            if(result.success) {
                getViewStep();
            } else {
                message(result.message);
            }
        },
        error: function(result) {
            console.log(result);
        },
    });
}


function nextStep() {
    $('#step_'+step).css('color', 'white');
    switch (step) {
        case 1:
            $('#form_data-base').submit(function(event) {
                event.preventDefault();
                let dataClient = {
                    'action': "formBD",
                    'step': step,
                    'form': getDataForm($(this))
                };
                checkStep(dataClient);
            });
            break;
        case 2:
            let dataClient = {
                'action': "createBD",
                'step': step
            };
            checkStep(dataClient);
            break;
        case 3:
            $('#form_admin').submit(function(event) {
                event.preventDefault();
                let dataClient = {
                    'action': "formAdmin",
                    'step': step,
                    'form': getDataForm($(this))
                };
                checkStep(dataClient);
            });
            break;
    }
}


$(document).ready(function() {
    getViewStep();
});