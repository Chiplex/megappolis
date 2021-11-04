var modalTypes = {
    Success: "success",
    Warning: "warning",
    Error: "error",
};

var modalTemplate = {
    title: "",
    body: "",
    footer: ""
};

var modalFuntions = {
    success: function (title, body, footer) {
        modalTemplate.title = title;
        modalTemplate.body = body;
        modalTemplate.footer = footer;
        $("#modal-title").html(modalTemplate.title);
        $("#modal-body").html(modalTemplate.body);
        $("#modal-footer").html(modalTemplate.footer);
        $("#modal-container").modal("show");
    },
    warning: function (title, body, footer) {
        modalTemplate.title = title;
        modalTemplate.body = body;
        modalTemplate.footer = footer;
        $("#modal-title").html(modalTemplate.title);
        $("#modal-body").html(modalTemplate.body);
        $("#modal-footer").html(modalTemplate.footer);
        $("#modal-container").modal("show");
    },
    error: function (title, body, footer) {
        modalTemplate.title = title;
        modalTemplate.body = body;
        modalTemplate.footer = footer;
        $("#modal-title").html(modalTemplate.title);
        $("#modal-body").html(modalTemplate.body);
        $("#modal-footer").html(modalTemplate.footer);
        $("#modal-container").modal("show");
    },
    close: function () {
        $("#modal-container").modal("hide");
    }
};

var modalHtml = {
    success: function (title, body, footer) {
        return '<div class="modal fade" id="modal-container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
            '<div class="modal-dialog">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>' +
            '<h4 class="modal-title" id="modal-title">' + title + '</h4>' +
            '</div>' +
            '<div class="modal-body" id="modal-body">' + body + '</div>' +
            '<div class="modal-footer" id="modal-footer">' + footer + '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
    },
    warning: function (title, body, footer) {
        return '<div class="modal fade" id="modal-container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
            '<div class="modal-dialog">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>' +
            '<h4 class="modal-title" id="modal-title">' + title + '</h4>' +
            '</div>' +
            '<div class="modal-body" id="modal-body">' + body + '</div>' +
            '<div class="modal-footer" id="modal-footer">' + footer + '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
    },
    error: function (title, body, footer) {
        return '<div class="modal fade" id="modal-container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
            '<div class="modal-dialog">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>' +
            '<h4 class="modal-title" id="modal-title">' + title + '</h4>' +
            '</div>' +
            '<div class="modal-body" id="modal-body">' + body + '</div>' +
            '<div class="modal-footer" id="modal-footer">' + footer + '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
    }
};


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

/**
 * 
 * Concentra todos los solicitudes API en una sola funcion
 * 
 * @param {var} options 
 * @returns Promise
 */
function Service(options) {
    return new Promise((resolve, reject) => {
        $.ajax(options)
        .done((result) => resolve(result) )
        .fail((error) => {
            modal.error("Error", error.responseText, "Cerrar");
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
        }
        catch (e) {
            console.log(e);
        }
    }, 1000);
    return win;
}