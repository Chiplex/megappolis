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
                <h3>{{ $ordersNoDelivered->count() }}</h3>
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
            </div>
            <div class="card-body">
                <table class="table" id="tblStock" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
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

@push('js')
<script>
var t = $("#tblStock").DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('yeipi.proveer.data.stock') }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', "orderable": false, searchable: false },
        { data: 'product.descripcion', name: 'product.descripcion' },
        { data: 'precio', name: 'precio' },
        { data: 'stock', name: 'stock' },
    ],
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
    selector: ".context-menu-stock",
    build: function ($trigger, e) {
        return {
            callback: function (key, options) {
                var tr = $(options.$trigger[0]).closest('tr');
                var row = t.row(tr);
                var model = row.data();
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
</script>

@endpush