const ResolveJsonResponseSuccess = {
    List: (response) => {
        if (response.success)
            return response.data;

        Swal.fire({
            title: 'Error',
            text: response.message,
            type: 'warning',
            confirmButtonText: 'Aceptar'
        });
    },
    Model: (response) => {
        if (response.success)
            return response.data;

        Swal.fire({
            title: 'Error',
            text: response.message,
            type: 'warning',
            confirmButtonText: 'Aceptar'
        });
    },
    Value: (response) => {
        if (response.success)
            return response.data;

        Swal.fire({
            title: 'Error',
            text: response.message,
            type: 'warning',
            confirmButtonText: 'Aceptar'
        });
    },
    Datatable: (response) => {
        if (response.success)
            return response.data;

        Swal.fire({
            title: 'Error',
            text: response.message,
            type: 'warning',
            confirmButtonText: 'Aceptar'
        });
    },
    Report: (response) => {
        if (response.success)
            window.open(response.data, '_blank');
        else
            Swal.fire({
                title: 'Error',
                text: response.message,
                type: 'warning',
                confirmButtonText: 'Aceptar'
            });
    },
    Select2: (response) => {
        if (response.success)
            return response.data;
        else
            Swal.fire({
                title: 'Error',
                text: response.message,
                type: 'warning',
                confirmButtonText: 'Aceptar'
            });
    },
    Event: (response) => {
        if (response.success)
            return response.data;
        else
            Swal.fire({
                title: 'Error',
                text: response.message,
                type: 'warning',
                confirmButtonText: 'Aceptar'
            });
    },
    File: (response) => {
        if (response.success)
            return response.data;
        else
            Swal.fire({
                title: 'Error',
                text: response.message,
                type: 'warning',
                confirmButtonText: 'Aceptar'
            });
    },
    Chart: (response) => {
        if (response.success) {
            var Labels = response.Labels;
            var DataSets = response.DataSets;
            return { Labels, DataSets };
        }
        else
            Swal.fire({
                title: 'Error',
                text: response.message,
                type: 'warning',
                confirmButtonText: 'Aceptar'
            });
    },
    default: (response) => {
        if (response.success)
            return response.data;
        else
            Swal.fire({
                title: 'Error',
                text: response.message,
                type: 'warning',
                confirmButtonText: 'Aceptar'
            });
    }
};

const ResolveJsonResponseError = {
    "400": (response) => {
        Swal.fire({
            title: 'Error',
            text: response.responseJSON.message || 'Error al procesar la solicitud',
            type: 'warning',
            confirmButtonText: 'Aceptar'
        });
    },
    "401": (response) => {
        Swal.fire({
            title: 'Error',
            text: response.responseJSON.message || 'No tiene permisos para realizar esta acción',
            type: 'warning',
            confirmButtonText: 'Aceptar'
        });
    },
    "403": (response) => {
        Swal.fire({
            title: 'Error',
            text: response.responseJSON.message || 'No tiene permisos para realizar esta acción',
            type: 'warning',
            confirmButtonText: 'Aceptar'
        });
    },
    "404": (response) => {
        Swal.fire({
            title: 'Error',
            text: response.responseJSON.message || 'Recurso no encontrado',
            type: 'warning',
            confirmButtonText: 'Aceptar'
        });
    },
    "419": (response) => {
        Swal.fire({
            title: 'Error',
            text: response.responseJSON.message || 'Sesión expirada',
            type: 'warning',
            confirmButtonText: 'Aceptar'
        });
    },
    "500": (response) => {
        Swal.fire({
            title: 'Error',
            text: response.responseJSON.message || 'Error al procesar la solicitud',
            type: 'warning',
            confirmButtonText: 'Aceptar'
        });
    }
};

const ShowLoadingFrameByType = {
    "banner": {
        show: () => $("#BannerLoading").show(),
        hide: () => $("#BannerLoading").hide(),
    },
    "spinner": {
        show: () => $("#SpinnerLoading").show(),
        hide: () => $("#SpinnerLoading").hide(),
    },
    "quick": {
        show: () => $("#QuickLoading").show(),
        hide: () => $("#QuickLoading").hide(),
    },
    "full": {
        show: () => $("#FullLoading").show(),
        hide: () => $("#FullLoading").hide(),
    },
    "linear": {
        show: () => $("#LinearLoading").show(),
        hide: () => $("#LinearLoading").hide(),
    },
    "default": (type) => {
        Swal.fire({
            title: 'Cargando',
            text: 'Espere un momento por favor',
            onOpen: () => {
                Swal.showLoading();
            }
        });
    }
};

function http(url, data, method, resolveTypeResponse, hasLoading) {
    if (hasLoading)
        ShowLoadingFrameByType[hasLoading].show();

    if (typeof data !== "object") {
        data = { id: data };
    }
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            data: data,
            type: method ? method : "GET",
        })
            .done(function (data) {
                resolve(ResolveJsonResponseSuccess[resolveTypeResponse] ? ResolveJsonResponseSuccess[resolveTypeResponse](data) : ResolveJsonResponseSuccess.default(data));
            })
            .fail(function (error) {
                reject(ResolveJsonResponseError[error.status](error));
            })
            .always(function () {
                if (hasLoading)
                    ShowLoadingFrameByType[hasLoading].hide();
            });
    });
}

class CrudService {
    constructor(url) {
        this.url = url;
    }

    index() {
        return http(this.url + "/index", null, "GET", "default");
    }

    store(data) {
        return http(this.url + "/register", data, "POST", "default");
    }

    show(id) {
        return http(this.url + "/register/" + id, null, "GET", "default");
    }

    update(data) {
        return http(this.url + "/register/" + data.id, data, "PUT", "default");
    }

    destroy(id) {
        return http(this.url + "/register/" + id, null, "DELETE", "default");
    }

    save(data) {
        if (data.id)
            return this.update(data);
        else
            return this.store(data);
    }
}

class AjaxForSelect2 {
    constructor(options) {
        this.url = options.url || "";
        this.dataType = options.dataType || "json";
        this.delay = options.delay || 250;
        this.data = options.data || this.data;
        this.processResults = options.processResults || this.processResults;
    }

    processResults(data, params) {
        return {
            results: data
        };
    }

    data(params) {
        return {
            q: params.term,
            page: params.page
        };
    }
}

class OptionForSelect2 {
    constructor(options) {
        this.width = options.width || '100%';
        this.language = options.language || 'es';
        this.placeholder = options.placeholder || 'Seleccione una opción';
        this.multiple = options.multiple || false;
        this.selectOnClose = options.selectOnClose || true;
        this.dropdownParent = options.dropdownParent || 'body';
        this.dropdownAutoWidth = options.dropdownAutoWidth || true;
        this.allowClear = options.allowClear || true;
        this.ajax = new AjaxForSelect2(options.ajax);
        this.minimumInputLength = options.minimumInputLength || 0;
        this.templateResult = options.templateResult || this.templateResult;
        this.templateSelection = options.templateSelection || this.templateSelection;
    }

    templateResult(state) {
        if (!state.id) { return state.text; }
        return $('<span>' + state.text + '</span>');
    }

    templateSelection(state) {
        return state.text;
    }
}

class Select2Service {
    constructor(control, option) {
        this.url = "";
        this.method = "GET";
        this.control = control;
        if (option) {
            this.options = new OptionForSelect2(option);
        }
    }

    setUrl(url) {
        this.url = url;
    }

    setMethod(method) {
        this.method = "POST";
    }

    setValue(value) {
        this.control.val(value).trigger("change");
    }

    getValue() {
        return this.control.val();
    }

    setText(text) {
        this.control.text(text);
    }

    getText() {
        return this.control.text();
    }

    create() {
        this.control.select2(this.options);
    }

    destroy() {
        this.control.select2('destroy');
    }

    build(callbackAppend) {
        this.callbackBuildAppend = callbackAppend;
        var _this = this;
        var data = http(this.url, null, this.method, "Select2")
            .then(function (data) {
                if (_this.callbackBuildAppend) {
                    _this.callbackBuildAppend(data);
                    return;
                }
                _this.control.append($("<option></option>").attr("value", "").text("Seleccione una opción"));
                data.forEach(function (item) {
                    _this.control.append($("<option></option>").attr("value", item.Value).text(item.Text));
                });
            });
    }

    parameters(param, term) {
        var method = term == "CODIGO" ? "GetParametrosByTipoToSelectAsCodigo" : "GetParametroByTipoToSelectAsId";
        this.url = getAbsoluteUrl("/AdministracionSis/Usuarios/" + method + "/" + param);
        return this;
    }
}

class FormService {
    constructor(form) {
        this.form = form;
    }

    submit() {
        var data = this.form.serializeArray();
        var formData = new FormData();
        data.forEach(function (item) {
            formData.append(item.name, item.value);
        });
        return http(this.form.attr("action"), formData, "POST", "default");
    }

    submitWithFile() {
        var data = this.form.serializeArray();
        var formData = new FormData();
        data.forEach(function (item) {
            formData.append(item.name, item.value);
        });
        var files = this.form.find("input[type=file]");
        files.each(function (index, item) {
            formData.append(item.name, item.files[0]);
        });
        return http(this.form.attr("action"), formData, "POST", "default");

    }

    toggle(mode) {
        var elements = this.form[0].elements;
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].type != "button") {
                elements[i].disabled = !mode;
            }
        }
    }

    fill(data) {
        this.form.attr('method', 'PUT');
        for (var key in data) {
            if (key !== "_token") {
                var control = this.form.find("[name='" + key + "']");
                if (control.length > 0) {
                    if (control.is("input[type='checkbox']")) {
                        control.prop("checked", data[key]);
                    }
                    else if (control.is("input[type='radio']")) {
                        control.filter("[value='" + data[key] + "']").prop("checked", true);
                    }
                    else {
                        control.val(data[key]);
                    }
                }
            }
        }
    }

    asModel() {
        var data = this.form.serializeArray();
        var model = {};
        data.forEach(function (item) {
            model[item.name] = item.value;
        });
        return model;
    }

    clear() {
        this.form.find("input, select, textarea").val("");
    }

    reset() {
        this.form.attr('method', 'POST');
        this.form[0].reset();
    }

    getControl(name) {
        return this.form.find("[name='" + name + "']");
    }

    getValue(name) {
        return this.form.find("[name='" + name + "']").val();
    }

    onSubmit(callback) {
        this.form.submit(function (e) {
            e.preventDefault();
            callback();
        });
    }
}
