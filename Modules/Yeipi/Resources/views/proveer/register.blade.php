<div class="card bg-info">
    {!! Form::open($form) !!}
    <div class="card-header">
        <div class="card-tools">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    <div class="card-body">
        @include('form.text', ['name' => 'nombre', 'title' => 'Nombre', 'value' => $shop->nombre ?? ''])
        @include('form.text', ['name' => 'direccion', 'title' => 'Direccion', 'value' => $shop->direccion ?? ''])
        @include('form.text', ['name' => 'latitud', 'title' => 'Latitud', 'value' => $shop->latitud ?? ''])
        @include('form.text', ['name' => 'longitud', 'title' => 'Longitud', 'value' => $shop->longitud ?? ''])
        @include('form.time', ['name' => 'abre', 'title' => 'Abre', 'value' => $shop->abre ?? ''])
        @include('form.time', ['name' => 'cierra', 'title' => 'Cierra', 'value' => $shop->cierra ?? ''])
    </div>
    {!! Form::close() !!}
</div>
@isset ($shop)
<div class="card card-info">
    <div class="card-header">
        <div class="card-title">
            Productos
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-primary" id="btnAbrirModal">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-condensed" id="table" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Stock</th>
                    <th>Medida</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endif

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            {!! Form::open($form) !!}
                <div class="modal-body">
                    {!! Form::hidden('id') !!}
                    @include('form.select', ['name' => 'product_id', 'title' => 'Producto', 'list' => $products, 'modal' => true , 'id' => 'txtProduct'])
                    @include('form.text', ['name' => 'stock', 'title' => 'Stock', 'modal' => true])
                    @include('form.text', ['name' => 'medida', 'title' => 'Medida', 'modal' => true])
                    @include('form.text', ['name' => 'precio', 'title' => 'Precio', 'modal' => true])
                </div>
                <div class="modal-footer">
                    {!! Form::button('<i class="fa fa-save"></i>', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('js')
<script>
    var modal = $("#modal");
    var t = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('yeipi.proveer.data', ['shop' => $shop->id]) }}',
        columns: [
            { data: 'id', name: 'id', "orderable": false },
            { data: 'descripcion', name: 'producto' },
            { data: 'marca', name: 'marca' },
            { data: 'stock', name: 'stock' },
            { data: 'medida', name: 'medida' },
            { data: 'precio', name: 'precio' },
        ],
    });

    $.contextMenu({
        selector: ".context-menu",
        build: function ($trigger, e) {
            return {
                callback: function (key, options) {
                    var model = t.row($(options.$trigger[0]).closest('tr')).data();
                    console.log(model);
                    switch (key) {
                        case "edit":
                            AbrirModal(model);
                            break;
                    }
                },
                items: {
                    "edit": { name: "Editar", icon: "edit", },
                }
            };
        },
    });
 
    $("#frmProducto", modal).on('submit', function (e) {
        e.preventDefault();
        var stock = FormToJSON($(this));
        stock.shop_id = "{{ $shop->id }}";
        var route = "{{ route('yeipi.proveer.store') }}";
        var url = stock.id ? route + "/" +  stock.id : route
        $.ajax({
            type: stock.id ? "PUT" :"POST",
            url: url,
            data: stock,
        })
        .done((r) => t.search("").draw())
        .fail((e) => console.log(e))
        .always(() => modal.modal("hide"))
    });
    $("#btnAbrirModal").on('click', function () {
       AbrirModal();
    });
    //$('#txtProduct', modal).select2();

    function AbrirModal(model) {
        let nuevo = typeof model === "undefined";
        $("#frmProducto", modal)[0].reset();
        if (!nuevo) {
            JSONToForm($("#frmProducto", modal)[0], model);
        }
        modal.modal("show");
    }
</script>
@endpush

