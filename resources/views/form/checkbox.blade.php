<div class="form-group row">
    <div class="offset-sm-2 col-sm-4">
        <div class="custom-control custom-checkbox">
            {!! Form::checkbox($name, $value, $checked, $optionsControl ?? ['class' => 'custom-control-input']) !!}
            {!! Form::label($name, $title, $optionsLabel ?? ['class' => 'custom-control-label']) !!}
        </div>
    </div>
  </div>