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

