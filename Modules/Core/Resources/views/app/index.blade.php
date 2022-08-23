<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a class="btn btn-tool btn-primary" href="{{ url('/core/app/register/') }}" role="button"><i
                            class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-head-fixed text-nowrap" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Aproved</th>
                            <th>Blocked</th>
                            <th>Owner</th>
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
    var t = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('core.app.data') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', "orderable": false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'type', name: 'type' },
            { data: 'approved_at', name: 'approved_at' },
            { data: 'blocked_at', name: 'blocked_at' },
            { data: 'user.email', name: 'user.email' },
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
                            OpenWindow('{{ url('/core/app/register/') }}/' + model.id);
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
