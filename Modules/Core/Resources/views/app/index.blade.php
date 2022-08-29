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
    var app = new CrudService('{{ $crud }}');
    var form = new FormService(modal.find("form"));
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
                callback: async function (key, options) {
                    var tr = $(options.$trigger[0]).closest('tr');
                    var row = t.row(tr);
                    var model = row.data();
                    switch (key) {
                        case "edit":
                            form.clear();
                            form.fill(model);
                            modal.modal('show');
                            break;
                        case "delete":
                            await app.delete(model.id);
                            t.ajax.reload();
                            break;
                    }
                },
                items: {
                    "edit": { name: "Editar", icon: "edit", },
                    "delete": { name: "Eliminar", icon: "delete", },
                }
            };
        },
    });

    $('#btnAddApp').on('click', () => {
        form.reset();
        modal.modal('show');
    });

    form.onSubmit(async () => {
        var data = form.asModel();
        await app.save(data);
        modal.modal('hide');
        t.ajax.reload();
    })
</script>
@endpush
