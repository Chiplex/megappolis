<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $ordersDelivered->count() }}</h3>
                <p>Ordenes Entregadas</p>
            </div>
            <div class="icon">
                <i class="fa fa-list fa-fw" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $ordersUndelivered->count() }}</h3>
                <p>Nuevas Ordenes</p>
            </div>
            <div class="icon">
                <i class="fa fa-star fa-fw" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalSales }}</h3>
                <p>Total Ventas</p>
            </div>
            <div class="icon">
                <i class="fa fa-money-check fa-fw"></i>
                <i class="fa fa-dollar" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
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
                            <th>Precio</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Customers</div>
            </div>
            <div class="card-body">
                <table class="table" id="tblCustomer" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Delivery</th>
                        </tr>
                    </thead>
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
    var modal = $("#modal");

    var tStock = $("#tblStock").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('yeipi.proveer.data.stock') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', "orderable": false, searchable: false },
            { data: 'product.descripcion', name: 'product.descripcion' },
            { data: 'product.marca', name: 'product.marca' },
            { data: 'precio', name: 'precio' },
            { data: 'stock', name: 'stock' },
        ],
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
                    }
                },
                items: {
                    "edit": { name: "Editar", icon: "edit", },
                }
            };
        },
    });

    var t = $("#tblCustomer").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('yeipi.proveer.data.customer') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', "orderable": false, searchable: false },
            { data: 'customer', name: 'customer.people.name' },
            { data: 'delivery', name: 'delivery.people.name' },
        ],
    });

    $.contextMenu({
        selector: ".context-menu-customer",
        build: function ($trigger, e) {
            return {
                callback: function (key, options) {
                    var model = t.row($(options.$trigger[0]).closest('tr')).data();
                    console.log(model);
                    switch (key) {
                        case "ver":
                            //window.location.href = "" + model.id;
                            break;
                    }
                },
                items: {
                    "ver": { name: "Ver", icon: "fa-info", },
                }
            };
        },
    });

    $("#btnAbrirModal").on('click', function () {
        AbrirModalStock();
    });

    $("#frmProducto", modal).on('submit', function (e) {
        e.preventDefault();
        GuardarStock();
    });

    function AbrirModalStock(model) {
        let nuevo = typeof model === "undefined";
        $("#frmProducto", modal)[0].reset();
        
        Service({
            type: "get",
            url: "{{ url('yeipi/proveer/product') }}",
        })
        .then(data => {
            FillDrop(data.products)
            JSONToForm($("#frmProducto", modal), model);
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
        var stock = FormToJSON($("#frmProducto", modal));
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
</script>

@endpush