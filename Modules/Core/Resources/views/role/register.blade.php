<div class="card card-info">
    {{ Form::open($form) }}
    <div class="card-header">
        <div class="card-tools">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    <div class="card-body">
        @include('form.text', ['name' => 'name', 'title' => 'Nombre', 'value' => $role->name ?? ''])
        @include('form.text', ['name' => 'description', 'title' => 'Descripcion', 'value' => $role->description ?? ''])
    </div>
    {!! Form::close() !!}
</div>
