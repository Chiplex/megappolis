@php
    if(!$options->has('class')){
        $options->put('class', 'form-control');
    }
    if (!$options->has('placeholder')) {
        $options->put('placeholder','Seleccione una opción');
    }
@endphp
<div class="form-group row">
    @if($options->has('title'))
        {!! Form::label(
            $options->get('name'), 
            $options->get('title'), 
            ['class' => 'col-form-label col-sm-4']
            ) 
        !!}
    @endif
    <div class="col-sm-8">
        {!! Form::select(
            $options->get('name'), 
            $options->get('list'), 
            $options->get('value', old($options->get('name'))), 
            $options->except(['name', 'value', 'list', 'title'])->all())
        !!}
    </div>
</div>
@error($options->get('name'))
<p class="text-danger">
    <strong>{{ $errors->first($options->get('name')) }}</strong>
</p>
@enderror
