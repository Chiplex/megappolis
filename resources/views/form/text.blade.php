<div class="form-group row">
    {!! Form::label($name, $title, $optionsLabel ?? ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-4">
        {!! Form::text($name, $value, $optionsControl ?? ['class' => 'form-control', 'placeholder' => $title, 'disabled' => $disabled ?? false]) !!}
    </div>
</div>