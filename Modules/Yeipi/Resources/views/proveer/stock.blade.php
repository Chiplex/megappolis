<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">Stock</div>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" id="btnAbrirModal">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table" id="tblStock" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Marca</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Costo</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right">
                                <strong >Total:</strong>
                            </td>
                            <td class="text-right">
                                <strong>Total:</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

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
                @include('form.select', [
                'name' => 'product_id',
                'title' => 'Producto',
                'modal' => true ,
                'id' => 'drpProducts',
                'list' => collect([])
                ])

                @include('form.text', [
                'name' => 'stock',
                'title' => 'Stock',
                'modal' => true
                ])

                @include('form.text', [
                'name' => 'medida',
                'title' => 'Medida',
                'modal' => true
                ])

                @include('form.text', [
                'name' => 'precio',
                'title' => 'Precio',
                'modal' => true
                ])
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
    var total = 0;
    var modal = $("#modal");
    var formStock =  $("#{{ $form['id'] }}", modal);

    var tStock = $("#tblStock").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('yeipi.proveer.data.stock') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', "orderable": false, searchable: false },
            { data: 'product.descripcion', name: 'product.descripcion' },
            { data: 'product.marca', name: 'product.marca' },
            { data: 'stock', name: 'stock' },
            { data: 'precio', name: 'precio' },
            { data: 'subtotal', name: 'subtotal', "orderable": false, searchable: false },
        ],
        "createdRow": (row, data, index) => {
            total = data.subtotal + total;
            $('td', row).eq(3).addClass("text-right");
            $('td', row).eq(4).addClass("text-right");
            $('td', row).eq(5).addClass("text-right");
            $('tfoot td:eq(5)').addClass("text-right").html(number_format(total, 2));
        },
        "drawCallback": function (settings) {
            total = 0;
        }
    });

    $.contextMenu({
        selector: ".context-menu-stock",
        build: function ($trigger, e) {
            return {
                callback: function (key, options) {
                    var tr = $(options.$trigger[0]).closest('tr');
                    var row = tStock.row(tr);
                    var model = row.data();
                    switch (key) {
                        case "edit":
                            AbrirModalStock(model);
                            break;
                        case "delete":
                            EliminarStock(model);
                            break;
                    }
                },
                items: {
                    "edit": { name: "Editar", icon: "edit", },
                    "delete": { name: "Eliminar", icon: "delete", disabled:true },
                }
            };
        },
    });

    $("#btnAbrirModal").on('click', () => AbrirModalStock());

    formStock.on('submit', function (e) {
        e.preventDefault();
        GuardarStock();
    });

    function AbrirModalStock(model) {
        let nuevo = typeof model === "undefined";
        formStock[0].reset();

        Service({
            type: "get",
            url: "{{ url('yeipi/proveer/product') }}",
        })
        .then(data => {
            FillDrop(data.products)
            if(!nuevo) 
                JSONToForm(formStock, model);
        });
        
        modal.modal("show");
    }

    function FillDrop(data) {
        $("#drpProducts", modal).empty();
        $("#drpProducts", modal).append(`<option value="">Seleccione una opción</option>`);
        $.each(data, function (index, value) {
            $("#drpProducts", modal).append(`<option value="${value.id}">${value.descripcion} (${value.marca ? value.marca : 'Sin Marca'})</option>`);
        });
    }

    function GuardarStock(){
        var stock = FormToJSON(formStock);
        stock.shop_id = "{{ $shop->id }}";
        
        var route = "{{ url('yeipi/proveer/stock') }}";
        var url = route + "/" + (stock.id ? stock.id : '');
        $.ajax({
            type: stock.id ? "PUT" :"POST",
            url: url,
            data: stock,
        })
        .done((r) => tStock.ajax.reload())
        .fail((e) => console.log(e))
        .always(() => modal.modal("hide"))
    }

    function EliminarStock(model) {
        var route = "{{ url('yeipi/proveer/stock') }}";
        var url = route + "/" + model.id;
        $.ajax({
            type: "DELETE",
            url: url,
        })
        .done((r) => tStock.ajax.reload())
        .fail((e) => console.log(e))
    }
</script>

@endpush