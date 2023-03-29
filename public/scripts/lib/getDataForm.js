function getDataForm(form) {
    let strData = form.serializeArray();
    let result = {};
    let i = 0;
    while(true) {
        if(strData[i]) {
            result[strData[i].name] = strData[i].value;
        } else {
            break;
        }
        i++;
    }
    return result;
}

export default getDataForm;