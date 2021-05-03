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

function Service(options) {
    return new Promise((resolve, reject) => {
        $.ajax(options)
        .done(function (result) {
            resolve(result);
        }).fail(function (error) {
            console.log(error);
            reject(error);
        });
    });
}

function View(view) {
    var html = null;
    $.ajax({
        async: false,
        url: "/view/" + view,
        type: "get"
    }).done(function (data) {
        html = data;
    }).fail(function (error) {
        console.log(error);;
    });
    return html;
}

function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0)
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}