@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('auth_header', 'Registro de Miembro')

@section('auth_body')
{!! Form::open($form) !!}
    @include('form.input-group.text', ['name' => 'name', 'placeholder' => 'Nombre'])
    @include('form.input-group.text', ['name' => 'otherName', 'placeholder' => 'Otros Nombres'])
    @include('form.input-group.text', ['name' => 'lastName', 'placeholder' => 'Apellidos'])
    @include('form.input-group.text', ['name' => 'dateBirth', 'placeholder' => 'Otros Apellidos'])
    @include('form.input-group.text', ['name' => 'country', 'placeholder' => 'Pais'])
    @include('form.input-group.text', ['name' => 'city', 'placeholder' => 'Ciudad'])
    @include('form.input-group.text', ['name' => 'phone', 'placeholder' => 'Celular - Incluir código de país'])
    @include('form.input-group.text', ['name' => 'sex', 'placeholder' => 'Sexo'])
    @include('form.input-group.text', ['name' => 'documentoNumero', 'placeholder' => 'Numero de Documento CI / DNI'])
    <div class="mb-3">
        <label for="formFile" class="form-label">Foto de Perfil</label>
        {!! Form::file('nroCarnet', ['class' => 'form-control', 'id' => 'formFile']) !!}
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Foto de CI / DNI Anverso</label>
        {!! Form::file('anverso', ['class' => 'form-control', 'id' => 'formFile']) !!}
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Foto de CI / DNI Reverso</label>
        {!! Form::file('reverso', ['class' => 'form-control', 'id' => 'formFile']) !!}
    </div>
    <button type="submit" class="btn btn-block btn-flat btn-primary">
        <span class="fas fa-save"></span> Guardar
    </button>
{!! Form::close() !!}
@stop