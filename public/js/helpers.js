function JSONToForm(form, data) {
    $.each(data, function (key, value) {
        var control = $('[name=' + key + ']', form);
        switch (control.prop("type")) {
            case "radio": case "checkbox":
                control.each(function () {
                    if ($(this).attr('value') == value) $(this).attr("checked", value);
                });
                break;
            case "date":
                control.val(JsonDateControl(value));
                break;
            case "time":
                control.val(JsonTimeControl(value));
                break;
            default:
                control.val(value);
        }
    });
}

function FormToJSON($form) {
    var formData = $form.serializeArray();
    var data = {};
    $(formData).each(function () {
        if (data[this.name] !== undefined) {
            if (!Array.isArray(data[this.name])) {
                data[this.name] = [data[this.name]];
            }
            data[this.name].push(this.value);
        } else {
            data[this.name] = this.value;
        }
    });
    return data;
}