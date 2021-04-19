<div class="card card-info">
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
        Deliveries
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Delivery</th>
                    <th>Empieza</th>
                    <th>Acaba</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shop->contracts as $contract)
                    <tr>
                        <td>{{ $contract->id }}</td>
                        <td>{{ $contract->delivery->people->getNameComplete() ?? '' }}</td>
                        <td>{{ $contract->empieza }}</td>
                        <td>{{ $contract->acaba }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/yeipi/shop/update/'.$contract->delivery_id) }}"
                                    class="btn btn-info btn-flat">
                                    <i class="fa fa-ban"></i>Quitar
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

