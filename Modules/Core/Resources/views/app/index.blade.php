<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-primary" id="btnAddApp">
                        <i class="fa fa-plus"></i>
                    </button>
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
                            <th>Status</th>
                            <th>Status Date</th>
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

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register App</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open($form) !!}
            <div class="modal-body">
                {!! Form::hidden('id') !!}

                @include('form.text', [
                    'name' => 'name',
                    'title' => 'Name',
                    'modal' => true
                ])

                @include('form.text', [
                    'name' => 'type',
                    'title' => 'Type',
                    'modal' => true
                ])

                @include('form.text', [
                    'name' => 'description',
                    'title' => 'Description',
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
    var t = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('core.app.data') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', "orderable": false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'type', name: 'type' },
            { data: 'status', name: 'status' },
            { data: 'status_date', name: 'status_date' },
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
                        case "info":
                            OpenWindow('{{ url('/core/app/info/') }}/' + model.id);
                            break;
                        case "edit":
                            modal.find('form').attr('action', '{{ url('/core/app/update') }}');
                            modal.find('form').attr('method', 'post');
                            modal.find('form').find('input[name=id]').val(model.id);
                            modal.find('form').find('input[name=name]').val(model.name);
                            modal.find('form').find('input[name=type]').val(model.type);
                            modal.find('form').find('input[name=description]').val(model.description);
                            modal.modal('show');
                            break;
                        case "delete":
                            http({
                                url: '{{ url('/core/app/delete/') }}/' + model.id,
                                method: 'DELETE',
                                success: function (response) {
                                    row.remove().draw();
                                }
                            });
                            break;
                    }
                },
                items: {
                    "info": { name: "Info", icon: "info", },
                    "edit": { name: "Editar", icon: "edit", },
                    "delete": { name: "Eliminar", icon: "delete", },
                }
            };
        },
    });

    $('#btnAddApp').on('click', function () {
        modal.find('input[name="id"]').val('');
        modal.find('input[name="name"]').val('');
        modal.find('input[name="type"]').val('');
        modal.find('input[name="description"]').val('');
        modal.modal('show');
    });

</script>
@endpush
