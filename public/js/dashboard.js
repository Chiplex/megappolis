$(document).on('click', function (event) {
    $(".modal").remove();
    $(".modal-backdrop").remove();
    var a = $(event.target).closest('a');

    var route = a.attr("href").replace(/https?:\/\//i, "");
    var segment = route.split("/");


    console.log((segment));
    event.preventDefault();

    /////Actualizacion para solo recargar el menu izquierdo y no la pagina entera
    if (a.length > 0 && a.hasClass('LoadMod')) {
        try {
            //console.log("recarga fragment");
            event.preventDefault();
            $("#idArea").val(a.attr("id"));
            $("a").removeClass("mod-selected");
            a.addClass("mod-selected");
            CargarMenuIzq();
            ajaxLoad(getAbsoluteUrl(a.attr("href")));
            $('body').removeClass('sidebar-open');

        }
        catch (err) {
            alert(err.message);
        }
        return false;
    }
    //////////////////////////////////////////////

    if (a.length > 0 && a.hasClass('aload')) {
        try {
            
            $(".modal").remove();
            $(".modal-backdrop").remove();
            ajaxLoad(getAbsoluteUrl(a.attr("href")));
            $('body').removeClass('sidebar-open');
        }
        catch (err) {
            alert(err.message);
        }
        return false;
    }
});

function GetAbsoluteURL(url) {
    a = document.createElement("a");
    a.href = url;
    return a.href;
}
var getAbsoluteUrl = (function () {
    var a;

    return function (url) {
        if (!a) a = document.createElement('a');
        a.href = url;

        return a.href;
    };
})();

function LoadContent(url) {
    $.ajax({
        type: 'get',
        url: url,
        async: false,
        beforeSend: function () {
            $('.CargarPagina').show();
            $('#mainContent').addClass("pantallaCarga");
        },
        complete: function () {
            $('.CargarPagina').hide();
            $('#mainContent').removeClass("pantallaCarga");
        },
        cache: false,
        success: function (result) {
            if ($(result).attr('id') != "txtContent") {
                location.href = url;
                return;
            }
            var s = $(result).html().trim();
            if (s == null)
                return;

            var j = JSON.parse(s);
            if (j.result) {
                window.history.pushState({ "html": s, "pageTitle": j.titulo + '-' + j.subtitulo, "areaID": $("#idArea").val()}, "", url);
                //prevstate = jsonHtml;
                $('#mainContent').html(s);
                jsonHtml = j;
                CargarContenido();
            }
            //Bancos.load();
        },
        error: function (error) {
            modales.show(modalTypes.danger, error);
            $('#mainContent').html('');
        },
    })
}