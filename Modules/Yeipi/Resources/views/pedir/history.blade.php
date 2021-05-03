<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="input-group">
                        <input type="text" name="table_search" class="form-control" placeholder="Search" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-tools">
                    <form action="{{ route('yeipi.pedir.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                    </form>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" id="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Delivery</th>
                            <th>Fecha de Solicitud</th>
                            <th>Fecha de Recepción</th>
                            <th>Fecha de Salida</th>
                            <th>Fecha de Entrega</th>
                            <th>Productos</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@push('js')
<script>
    var total = 0;
    var t = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('yeipi.pedir.data.history') }}",
        columns: [
            { data: 'id', name: 'id', "orderable": false },
            { data: 'delivery', name: 'delivery', orderable: false, searchable: false, defaultContent: "", },
            { data: 'fechaSolicitud', name: 'fechaSolicitud' },
            { data: 'fechaRecepcion', name: 'fechaRecepcion' },
            { data: 'fechaSalida', name: 'fechaSalida' },
            { data: 'fechaEntrega', name: 'fechaEntrega' },
            { data: 'products', name: 'products', orderable: false, searchable: false, defaultContent: "", },
        ],
    });
    
    $.contextMenu({
        selector: ".context-menu",
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