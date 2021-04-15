<div class="card card-info">
{!! Form::open($form) !!}
    {!! Form::hidden('order_id', $order->id) !!}
    <div class="card-header">
        <div class="card-tools">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            {!! Form::label('descripcion', 'Descripcion', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-4">
                {!! Form::text('descripcion', $detail->description ?? '', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('cantidad', 'Cantidad', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-4">
                {!! Form::number('cantidad', $detail->cantidad ?? '', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('precio', 'Precio', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-4">
                {!! Form::number('precio', $detail->precio ?? '', ['class' => 'form-control', 'step' => '0.01']) !!}
            </div>
        </div>
    </div>
{!! Form::close() !!}
  </div>