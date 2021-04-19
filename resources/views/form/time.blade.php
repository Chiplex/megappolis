<div class="form-group row">
    {!! Form::label($name, $title, $attributeLabel ?? ['class' => 'col-sm-2 col-form-label'] ) !!}
    <div class="col-sm-4">
        {!! Form::time($name, $value, $attributeControl ?? ['class' => 'form-control']) !!}
    </div>
</div>