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
        @include('form.input-group.file', ['options' => collect(['name' => 'profile', 'title' => 'Foto de Perfil', 'required' => true])])
        @include('form.input-group.file', ['options' => collect(['name' => 'anverso', 'title' => 'Foto de CI / DNI Anverso', 'required' => true])])
        @include('form.input-group.file', ['options' => collect(['name' => 'reverso', 'title' => 'Foto de CI / DNI Reverso', 'required' => true])])
    </div>
    {!! Form::close() !!}
</div>

