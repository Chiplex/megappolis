<div class="card {{ $action }}">
    {!! Form::open($form) !!}
    <div class="card-header">
        <div class="card-title">Confirma tu infomación para la comunicación entre quienes pidan, entreguen o provean</div>
        <div class="card-tools">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    <div class="card-body">
        {!! Form::hidden('action', $yeipi) !!}
        @include('form.form-group.text', ['options' => collect(['name' => 'name', 'value' => $people->name ?? '', 'placeholder' => 'Nombre', 'required' => true,  'title' => 'Nombre'])])
        @include('form.form-group.text', ['options' => collect(['name' => 'otherName', 'value' => $people->otherName ?? '', 'placeholder' => 'Otros Nombres', 'required' => true, 'title' => 'Otros Nombres'])])
        @include('form.form-group.text', ['options' => collect(['name' => 'lastName', 'value' => $people->lastName ?? '', 'placeholder' => 'Apellidos', 'required' => true, 'title' => 'Apellidos'])])
        @include('form.form-group.text', ['options' => collect(['name' => 'otherLastName', 'value' => $people->otherLastName ?? '', 'placeholder' => 'Otros Apellidos', 'required' => true, 'title' => 'Otros Apellidos'])])
        @include('form.form-group.date', ['options' => collect(['name' => 'dateBirth', 'value' => $people->dateBirth ?? '', 'placeholder' => 'Fecha de Nacimiento', 'required' => true, 'title' => 'Fecha de Nacimiento'])])
        @include('form.form-group.text', ['options' => collect(['name' => 'country', 'value' => $people->country ?? '', 'placeholder' => 'Pais', 'required' => true, 'title' => 'País'])])
        @include('form.form-group.text', ['options' => collect(['name' => 'city', 'value' => $people->city ?? '', 'placeholder' => 'Ciudad', 'required' => true, 'title' => 'Ciudad'])])
        @include('form.form-group.text', ['options' => collect(['name' => 'phone', 'value' => $people->phone ?? '', 'placeholder' => 'Incluir código de país', 'required' => true, 'title' => 'Celular'])])
        @include('form.form-group.select', ['options' => collect(['name' => 'sex', 'value' => $people->sex ?? '', 'required' => true, 'list' => ['M' => 'Masculino', 'F' => 'Femenino'], 'title' => 'Sexo'])])
        @include('form.form-group.text', ['options' => collect(['name' => 'documentNumber', 'value' => $people->documentNumber ?? '', 'placeholder' => 'Numero de Documento CI / DNI', 'required' => true, 'title' => 'Nro. de CI | DNI'])])
        @include('form.form-group.file', ['options' => collect(['name' => 'profile', 'title' => 'Foto de Perfil', 'required' => true])])
        @include('form.form-group.file', ['options' => collect(['name' => 'anverso', 'title' => 'Foto de CI / DNI Anverso', 'required' => true])])
        @include('form.form-group.file', ['options' => collect(['name' => 'reverso', 'title' => 'Foto de CI / DNI Reverso', 'required' => true])])
    </div>
    {!! Form::close() !!}
</div>
