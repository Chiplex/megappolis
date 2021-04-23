<div class="row">
    <div class="col-sm-12">
        <div class="card card-info">
            {!! Form::open($form) !!}
            <div class="card-header">
                <div class="card-tools">
                    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            <div class="card-body">
                @include('form.text', ['name' => 'descripcion', 'title' => 'Descripcion', 'value' => $product->descripcion ?? ''])
                @include('form.text', ['name' => 'marca', 'title' => 'Marca', 'value' => $product->descripcion ?? ''])
            </div>
            {!! Form::close() !!}
        </div>
    </div>
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
                    <a class="btn btn-primary" href="{{ route('yeipi.product.create')}}" role="button">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
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

@push('js')
<script>
    var t;
    $(function() {
        t = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('yeipi.product.data') }}',
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'descripcion', name: 'descripcion' },
                    { data: 'marca', name: 'marca' }
                ],
            "createdRow": (row, data, index) => {
                $('td', row).addClass("context-menu");
            }
        });

        
    });

    $.contextMenu({
        selector: '.context-menu', 
        build: function($trigger, e) {
            // this callback is executed every time the menu is to be shown
            // its results are destroyed every time the menu is hidden
            // e is the original contextmenu event, containing e.pageX and e.pageY (amongst other data)
            return {
                callback: function(key, options) {
                    var m = "clicked: " + key;
                    window.console && console.log(m) || alert(m); 
                },
                items: {
                    "edit": {name: "Edit", icon: "angle-down"},
                    "cut": {name: "Cut", icon: "cut"},
                    "copy": {name: "Copy", icon: "copy"},
                    "paste": {name: "Paste", icon: "paste"},
                    "delete": {name: "Delete", icon: "delete"},
                    "sep1": "---------",
                    "quit": {name: "Quit", icon: function($element, key, item){ return 'context-menu-icon context-menu-icon-quit'; }}
                }
            };
        }
    });
</script>
@endpush
