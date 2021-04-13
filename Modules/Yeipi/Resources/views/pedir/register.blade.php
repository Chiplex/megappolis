<div class="card card-info">
    <form class="form-horizontal"
        action="@if (isset($order)) {{ route('yeipi.pedir.update' , ['order' => $order->id]) }} @else {{ route('yeipi.pedir.store') }} @endif"
        method="POST">
        @csrf
        @if (isset($order))
        @method('PUT')
        @endif
        <div class="card-header">
            <div class="card-tools">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save   fa-fw"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Pedido de:</dt>
                <dd class="col-sm-9">{{ $order->customer->people->getNameComplete() }}</dd>
                <dt class="col-sm-3">Llevado por:</dt>
                <dd class="col-sm-9"></dd>
                <dt class="col-sm-3">Fecha de solicitud</dd>
                <dd class="col-sm-9">{{ $order->fechaSolicitud }}</dt>
                <dt class="col-sm-3">Fecha de salida</dt>
                <dd class="col-sm-9">{{ $order->fechaSalida }}</dd>
                <dt class="col-sm-3">Fecha de Entrega</dt>
                <dd class="col-sm-9">{{ $order->fechaEntrga }}</dd>
            </dl>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name" placeholder="name" name="name"
                        value="{{ old('name') ?? isset($order) ? $order->name : '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name" placeholder="name" name="type"
                        value="{{ old('type') ?? isset($order) ? $order->type : '' }}">
                </div>
            </div>
        </div>
    </form>
</div>