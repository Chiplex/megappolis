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
</div>
@push('js')
<script>
    var modal = $("#modal");

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
</script>

@endpush