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
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Stock</th>
                    <th>Medida</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($shop->stocks as $stock)
                    <tr>
                        <td>{{ $stock->id }}</td>
                        <td>{{ $stock->producto->descripcion }}</td>
                        <td>{{ $stock->producto->marca }}</td>
                        <td>{{ $stock->stock }}</td>
                        <td>{{ $stock->medida }}</td>
                        <td>{{ $stock->precio }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('yeipi.product.edit', ['stock' => $stock->id]) }}" class="btn btn-info btn-flat">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

