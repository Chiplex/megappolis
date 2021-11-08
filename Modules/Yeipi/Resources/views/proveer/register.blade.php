<div class="card bg-info">
    {!! Form::open($form) !!}
    <div class="card-header">
        <div class="card-tools">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    <div class="card-body">
        @include('form.text', ['name' => 'nombre', 'title' => 'Nombre', 'value' => $shop->nombre ?? ''])
        @include('form.text', ['name' => 'direccion', 'title' => 'Direccion', 'value' => $shop->direccion ?? ''])
        @include('form.text', ['name' => 'latitud', 'title' => 'Latitud', 'value' => $shop->latitud ?? ''])
        @include('form.text', ['name' => 'longitud', 'title' => 'Longitud', 'value' => $shop->longitud ?? ''])
        @include('form.time', ['name' => 'abre', 'title' => 'Abre', 'value' => $shop->abre ?? ''])
        @include('form.time', ['name' => 'cierra', 'title' => 'Cierra', 'value' => $shop->cierra ?? ''])
    </div>
    {!! Form::close() !!}
</div>
@isset ($shop)
<div class="card card-info">
    <div class="card-header">
        <div class="card-title">
            Productos
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-primary" id="btnAbrirModal">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-condensed" id="table" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Stock</th>
                    <th>Medida</th>
                    <th>Precio</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endif



@push('js')
<script>
    var modal = $("#modal");
    var t = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('yeipi.proveer.data', ['shop' => $shop->id]) }}',
        columns: [
            { data: 'id', name: 'id', "orderable": false },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'marca', name: 'marca' },
            { data: 'stock', name: 'stock' },
            { data: 'medida', name: 'medida' },
            { data: 'precio', name: 'precio' },
        ],
    });

</script>
@endpush

