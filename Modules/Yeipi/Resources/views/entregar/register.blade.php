<div class="card  bg-olive">
    <div class="card-header">
        <div class="card-tools">
            @if ($form['show'])
                {!! Form::open($form) !!}
                    <a class="btn btn-primary" href="{{ route('yeipi.entregar.index') }}" role="button">
                        <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                    </a>
                    {!! Form::button('<i class="fa fa-sun"></i>'.$form['name'], ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            @endif
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Pedido de:</dt>
            <dd class="col-sm-9">{{ $order->customer->people->getNameComplete() }}</dd>
            <dt class="col-sm-3">Fecha de solicitud:</dd>
            <dd class="col-sm-9">{{ $order->fechaSolicitud }}</dt>
            <dt class="col-sm-3">Fecha de recepcion:</dd>
            <dd class="col-sm-9">{{ $order->fechaRecepcion }}</dt>
            <dt class="col-sm-3">Fecha de salida:</dt>
            <dd class="col-sm-9">{{ $order->fechaSalida }}</dd>
            <dt class="col-sm-3">Fecha de entrega:</dt>
            <dd class="col-sm-9">{{ $order->fechaEntrga }}</dd>
        </dl>
    </div>
</div>
<div class="card">
    <div class="card-header">
        Detalles
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->details as $detail)
                    <tr>
                        <td>{{ $detail->id }}</td>
                        <td>{{ $detail->descripcion }}</td>
                        <td>{{ $detail->cantidad }}</td>
                        <td>{{ $detail->precio }}</td>
                        <td>
                            @isset($order->fechaRecepcion)
                            <div class="btn-group btn-group-sm">
                                @if (empty($detail->fechaConseguido) && empty($detail->fechaNoConseguido))
                                {!! Form::open(['route' => ['yeipi.entregar.conseguido', $detail->id ], 'method' => 'put']) !!}
                                {!! Form::button('<i class="fa fa-check"></i> Conseguido', ['type' => 'submit', 'class' => 'btn btn-info btn-flat']) !!}
                                {!! Form::close() !!} 
                                {!! Form::open(['route' => ['yeipi.entregar.no-conseguido', $detail->id ], 'method' => 'put']) !!}
                                {!! Form::button('<i class="fa fa-times"></i> No conseguido', ['type' => 'submit', 'class' => 'btn btn-info btn-flat']) !!}
                                {!! Form::close() !!}
                                @else
                                    @isset($detail->fechaConseguido)
                                        <span class="badge badge-primary">Conseguido</span>
                                    @endisset
                                    @isset($detail->fechaNoConseguido)
                                        <span class="badge badge-warning">No conseguido</span>
                                    @endisset
                                @endif
                            </div>
                            @endisset
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>