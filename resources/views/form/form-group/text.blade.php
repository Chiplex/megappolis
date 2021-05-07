@php
    if ($options->get('modal')) {
        $classLabel = ['col-form-label', 'col-sm-4'];
        $classControl = ['col-form-label', 'col-sm-8'];
    }
    else {
        $classLabel = ['col-form-label', 'col-sm-2'];
        $classControl = ['col-form-label', 'col-sm-4'];
    }
    if (!$options->has('class')) $options->put('class','form-control');
@endphp
<div class="form-group row">
    @if($options->has('title'))
        {!! Form::label($options->get('name'), $options->get('title'), ['class' => implode(' ', $classLabel)]) !!}
    @endif
    {!! Form::text($options->get('name'), $options->get('value', old($options->get('name'))), $options->except(['name', 'value'])->all()) !!}
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fa fa-{{ $options->get('icon', 'circle') }}"></span>
        </div>
    </div>
</div>
@error($options->get('name'))
<p class="text-danger">
    <strong>{{ $errors->first($options->get('name')) }}</strong>
</p>
@enderror

    {!! Form::label($name, $title, $optionsLabel ?? ['class' => isset($modal) ? 'col-sm-4' : 'col-sm-2' . ' ']) !!}
    <div class="{{ isset($modal) ? 'col-sm-8' : 'col-sm-4' }}">
        {!! Form::text($name, $value ?? null, $optionsControl ?? ['class' => 'form-control', 'placeholder' => $title, 'disabled' => $disabled ?? false]) !!}
    </div>