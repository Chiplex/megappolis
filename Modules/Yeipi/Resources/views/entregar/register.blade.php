<div class="card card-info">
    <form class="form-horizontal"
        action="@if (isset($order)) {{ route('yeipi.entregar.update' , ['order' => $order->id]) }} @else {{ route('yeipi.pedir.store') }} @endif"
        method="POST">
        @csrf
        @if (isset($order))
        @method('PUT')
        @endif
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-primary" href="{{ route('yeipi.entregar.index') }}" role="button">
                    <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                </a>
                @empty($order->fechaRecepcion)
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sun"></i> Entregar
                </button>    
                @endempty
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Pedido de:</dt>
                <dd class="col-sm-9">{{ $order->customer->people->getNameComplete() }}</dd>
                <dt class="col-sm-3">Fecha de solicitud:</dd>
                <dd class="col-sm-9">{{ $order->fechaSolicitud }}</dt>
                <dt class="col-sm-3">Fecha de salida:</dt>
                <dd class="col-sm-9">{{ $order->fechaSalida }}</dd>
                <dt class="col-sm-3">Fecha de entrega:</dt>
                <dd class="col-sm-9">{{ $order->fechaEntrga }}</dd>
            </dl>
        </div>
    </form>
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
                                <a href="{{ url('/yeipi/pedir/detail/'.$detail->id) }}"
                                    class="btn btn-info btn-flat">
                                    <i class="fa fa-check"></i> Conseguido
                                </a>
                                <a href="{{ url('/yeipi/pedir/detail/'.$detail->id) }}"
                                    class="btn btn-info btn-flat">
                                    <i class="fa fa-times"></i> No conseguido
                                </a>
                            </div>
                            @endisset
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>