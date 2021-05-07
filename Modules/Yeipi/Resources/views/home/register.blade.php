<div class="card card-info">
    {!! Form::open($form) !!}
    <div class="card-header">
        <div class="card-title">Confirma tu infomación para la comunicación entre quienes pidan, entreguen o provean</div>
        <div class="card-tools">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label for="tipo" class="col-sm-2 col-form-label">Que Vamos a hacer</label>
            <div class="col-sm-4">
                <div class="btn-group btn-group-toggle btn-block" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="action" value="pedir" @if($action == 'pedir') checked="checked" @endif><i class="fa fa-cart-plus" aria-hidden="true"></i> Pedir
                    </label>
                    <label class="btn btn-outline-danger">
                        <input type="radio" name="action" value="entregar" @if($action == 'entregar') checked="checked" @endif><i class="fa fa-truck"></i> Entregar
                    </label>
                    <label class="btn btn-outline-info">
                        <input type="radio" name="action" value="proveer" @if($action == 'proveer') checked="checked" @endif><i class="fa fa-store"></i> Proveer
                    </label>
                </div>
            </div>
        </div>
        @include('form.input-group.text', ['options' => collect(['name' => 'name', 'value' => $people->name ?? '', 'placeholder' => 'Nombre', 'required' => true])])
        @include('form.input-group.text', ['options' => collect(['name' => 'otherName', 'value' => $people->otherName ?? '', 'placeholder' => 'Otros Nombres', 'required' => true])])
        @include('form.input-group.text', ['options' => collect(['name' => 'lastName', 'value' => $people->lastName ?? '', 'placeholder' => 'Apellidos', 'required' => true])])
        @include('form.input-group.text', ['options' => collect(['name' => 'otherLastName', 'value' => $people->otherLastName ?? '', 'placeholder' => 'Otros Apellidos', 'required' => true])])
        @include('form.input-group.date', ['options' => collect(['name' => 'dateBirth', 'value' => $people->dateBirth ?? '', 'placeholder' => 'Fecha de Nacimiento', 'required' => true, 'title' => 'Fecha de Nacimiento'])])
        @include('form.input-group.text', ['options' => collect(['name' => 'country', 'value' => $people->country ?? '', 'placeholder' => 'Pais', 'required' => true])])
        @include('form.input-group.text', ['options' => collect(['name' => 'city', 'value' => $people->city ?? '', 'placeholder' => 'Ciudad', 'required' => true])])
        @include('form.input-group.text', ['options' => collect(['name' => 'phone', 'value' => $people->phone ?? '', 'placeholder' => 'Celular - Incluir código de país', 'required' => true])])
        @include('form.input-group.select', ['options' => collect(['name' => 'sex', 'value' => $people->sex ?? '', 'placeholder' => 'Sexo', 'required' => true, 'list' => ['M' => 'Masculino', 'F' => 'Femenino']])])
        @include('form.input-group.text', ['options' => collect(['name' => 'documentNumber', 'value' => $people->documentNumber ?? '', 'placeholder' => 'Numero de Documento CI / DNI', 'required' => true])])
        @include('form.input-group.file', ['options' => collect(['name' => 'profile', 'title' => 'Foto de Perfil', 'required' => true])])
        @include('form.input-group.file', ['options' => collect(['name' => 'anverso', 'title' => 'Foto de CI / DNI Anverso', 'required' => true])])
        @include('form.input-group.file', ['options' => collect(['name' => 'reverso', 'title' => 'Foto de CI / DNI Reverso', 'required' => true])])
    </div>
    {!! Form::close() !!}
</div>
