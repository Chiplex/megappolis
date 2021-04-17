<div class="form-group row">
    {!! Form::label($name, $title, $optionsLabel ?? ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-4">
        {!! Form::date($name, $value, $optionsControl ?? ['class' => 'form-control']) !!}
    </div>
</div>