<div class="row">
    <div class="col-12">
        <div class="card">
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