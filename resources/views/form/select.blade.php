<div class="form-group row">
    {!! Form::label($name, $title, $attributeLabel ?? ['class' => isset($modal) ? 'col-sm-4' :'col-sm-2' . ' col-form-label']) !!}
    <div class="{{ isset($modal) ? 'col-sm-8' : 'col-sm-4' . ' col-form-label' }}">
        {!! Form::select($name, $list, $selected ?? null, $optionsControl ?? ['class' => 'custom-select form-control-border', 'placeholder' => 'Seleccione una opción', 'id' => $id ?? '']) !!}
    </div>
  </div>