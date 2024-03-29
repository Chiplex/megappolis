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
            { data: 'DT_RowIndex', name: 'DT_RowIndex', "orderable": false, searchable: false },
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
            var id = $($trigger[0]).attr('data-id');
            console.log(id);
            return {
                callback: function (key, options) {
                    var tr = $(options.$trigger[0]).closest('tr');
                    var row = t.row(tr);
                    var model = row.data();
                    switch (key) {
                        case "edit":
                            var win = OpenWindow("{{ url('/yeipi/pedir/register') }}/" + model.id);
                            break;
                        case "delete":
                            AbrirModal(model);
                            break;
                    }
                },
                items: {
                    "edit": { name: "Editar", icon: "edit", disabled: {{ $permissions->contains('name', 'edit') ? 'false' : 'true' }} },
                    "delete": { name: "Borrar", icon: "delete", disabled: {{ $permissions->contains('name', 'delete') ? 'false' : 'true' }} },
                }
            };
        },
    });
</script>
@endpush