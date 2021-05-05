@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('auth_header', 'Registro de Miembro')

@section('auth_body')
{!! Form::open($form) !!}
    @include('form.input-group.text', ['options' => collect(['name' => 'name', 'placeholder' => 'Nombre', 'required' => true])])
    @include('form.input-group.text', ['options' => collect(['name' => 'otherName', 'placeholder' => 'Otros Nombres', 'required' => true])])
    @include('form.input-group.text', ['options' => collect(['name' => 'lastName', 'placeholder' => 'Apellidos', 'required' => true])])
    @include('form.input-group.text', ['options' => collect(['name' => 'otherLastName', 'placeholder' => 'Otros Apellidos', 'required' => true])])
    @include('form.input-group.date', ['options' => collect(['name' => 'dateBirth', 'placeholder' => 'Fecha de Nacimiento', 'required' => true, 'title' => 'Fecha de Nacimiento'])])
    @include('form.input-group.text', ['options' => collect(['name' => 'country', 'placeholder' => 'Pais', 'required' => true])])
    @include('form.input-group.text', ['options' => collect(['name' => 'city', 'placeholder' => 'Ciudad', 'required' => true])])
    @include('form.input-group.text', ['options' => collect(['name' => 'phone', 'placeholder' => 'Celular - Incluir código de país', 'required' => true])])
    @include('form.input-group.select', ['options' => collect(['name' => 'sex', 'placeholder' => 'Sexo', 'required' => true, 'list' => ['M' => 'Masculino', 'F' => 'Femenino']])])
    @include('form.input-group.text', ['options' => collect(['name' => 'documentoNumero', 'placeholder' => 'Numero de Documento CI / DNI', 'required' => true])])
    
    {!! Form::button('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-block btn-flat btn-primary', 'type' => 'submit']) !!}
{!! Form::close() !!}
@stop