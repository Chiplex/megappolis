<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" id="btnAbrirModal">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-condensed context-menu" id="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descripcion</th>
                            <th>Marca</th>
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
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            {!! Form::open($form) !!}
                <div class="modal-body">
                    {!! Form::hidden('id', $product->id ?? '', ) !!}
                    @include('form.text', ['name' => 'descripcion', 'title' => 'Descripcion', 'value' => $product->descripcion ?? '', 'modal' => true])
                    @include('form.text', ['name' => 'marca', 'title' => 'Marca', 'value' => $product->descripcion ?? '', 'modal' => true])
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
        ajax: '{{ route('yeipi.product.data') }}',
        columns: [
            { data: 'id', name: 'id', "orderable": false },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'marca', name: 'marca' }
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
 
    $("#frmProducto").on('submit', function (e) {
        e.preventDefault();
        var model = FormToJSON($(this));
        var url = model.id ? "{{ url('yeipi/product/register') }}" + "/" +  model.id : "{{ route('yeipi.product.store') }}" 
        $.ajax({
            type: "POST",
            url: url,
            data: model,
        })
        .done((r) => t.search("").draw())
        .fail((e) => console.log(e))
        .always(() => modal.modal("hide"))
    });

    $("#btnAbrirModal").on('click', function () {
       AbrirModal();
    });

    function AbrirModal(model) {
        let nuevo = typeof model === "undefined";
        $("#iptMethod").remove();
        if (nuevo) {
            $("#frmProducto")[0].reset();
        }
        else {
            JSONToForm($("#frmProducto")[0], model);
        }
        modal.modal("show");
    }
</script>
@endpush