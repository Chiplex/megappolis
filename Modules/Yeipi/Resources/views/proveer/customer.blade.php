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
                <table class="table" id="tblCustomer" style="width: 100%">
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