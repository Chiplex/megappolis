<div class="form-group row">
    {!! Form::label($name, $title, $attributeLabel ?? ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-4">
        {!! Form::select($name, $list, $selected, $optionsControl ?? ['class' => 'custom-select form-control-border', 'placeholder' => 'Seleccione una opcion']) !!}
    </div>
  </div>