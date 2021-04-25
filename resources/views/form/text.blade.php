
<div class="form-group row">
    {!! Form::label($name, $title, $optionsLabel ?? ['class' => isset($modal) ? 'col-sm-4' :'col-sm-2' . ' col-form-label']) !!}
    <div class="{{ isset($modal) ? 'col-sm-8' : 'col-sm-4' }}">
        {!! Form::text($name, $value ?? null, $optionsControl ?? ['class' => 'form-control', 'placeholder' => $title, 'disabled' => $disabled ?? false]) !!}
    </div>
</div>