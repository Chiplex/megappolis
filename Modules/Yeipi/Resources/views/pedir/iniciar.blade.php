<div class="card card-info">
    {!! Form::open($form) !!}
    <div class="card-header">
        <div class="card-tools">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    <div class="card-body">
        @include('form.text', ['name' => 'direccion', 'title' => 'Direccion', 'value' => $customer->direccion ?? '', 'modal' => false])
        @include('form.text', ['name' => 'latitud', 'title' => 'Latitud', 'value' => $customer->latitud ?? '', 'modal' => false])
        @include('form.text', ['name' => 'longitud', 'title' => 'Longitud', 'value' => $customer->longitud ?? '', 'modal' => false])
    </div>
    {!! Form::close() !!}
</div>

