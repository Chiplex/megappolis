/**
 * Convierte Json a Formulario HTML
 * Con la capacidad de explorar un objeto 
 * 
 * @param {*} form 
 * @param {*} data 
 */
function JSONToForm(form, data) {
    $.each(data, function (key, value) {
        var element = $('[name=' + key + ']', form);
        var data = $(element).attr('data');

        switch (element.prop("type")) {
            case "radio":
            case "checkbox":
                element.each(function () {
                    if ($(this).attr('value') == value) $(this).attr("checked", value);
                });
                break;
            case "date":
                element.val(moment(value).format('YYYY-MM-DD'));
                break;
            case "time":
                element.val(moment(value).format('HH:mm:ss'));
                break;
            default:
                if(typeof value === 'object' && value !== null) {
                    element.val(eval('value.' + data));
                }else{
                    element.val(value);
                }
                break;
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

/**
 * 
 * Concentra todos los solicitudes API en una sola funcion con sweetalert
 * 
 * @param {var} options 
 * @returns Promise
 */
function Service(options) {

    return new Promise((resolve, reject) => {
        $.ajax(options)
            .done((result) => resolve(result))
            .fail((error) => {
                // Mostrar error como alerta
                Swal.fire({
                    title: 'Error',
                    text: error.responseJSON.error,
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                });
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

function OpenWindow(uri) {
    var win = window.open(uri, "_blank");
    var interval = window.setInterval(function () {
        try {
            if (win == null || win.closed) {
                window.clearInterval(interval);
                //closeCallback(win);
                tblFichaMedica.search("").draw();
            }
        } catch (e) {
            console.log(e);
        }
    }, 1000);
    return win;
}