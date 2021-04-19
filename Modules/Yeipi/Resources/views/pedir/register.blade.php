<div class="card card-danger">
    <div class="card-header">
        <div class="card-tools">
            @isset($order->fechaSolicitud)
            <a class="btn btn-primary" href="{{ route('yeipi.pedir.index') }}" role="button">
                <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
            </a>
            @endisset
            @empty($order->fechaSolicitud)
            {!! Form::open($form) !!}
                {!! Form::button('<i class="fas fa-save"></i> Solicitar', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
            {!! Form::close() !!}
            @endempty
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Pedido de:</dt>
            <dd class="col-sm-9">{{ $order->customer->people->getNameComplete() }}</dd>
            <dt class="col-sm-3">Llevado por:</dt>
            <dd class="col-sm-9"></dd>
            {{-- <dd class="col-sm-9">{{ $order->contract->delivery->people->getNameComplete() ?? '' }}</dd> --}}
            <dt class="col-sm-3">Fecha de solicitud:</dd>
            <dd class="col-sm-9">{{ $order->fechaSolicitud }}</dt>
            <dt class="col-sm-3">Fecha de recepción:</dd>
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
        <div class="card-tools">
            @empty($order->fechaSolicitud)
                <a href="{{ route('yeipi.detail.create') }}" class="btn btn-primary" href="#" role="button"><i class="fa fa-plus"></i></a>
            @endempty
        </div>
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
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/yeipi/pedir/detail/'.$detail->id) }}"
                                    class="btn btn-info btn-flat">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ url('/yeipi/pedir/detail/'.$detail->id) }}"
                                    class="btn btn-info btn-flat">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>