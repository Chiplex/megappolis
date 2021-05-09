<div class="card bg-gradient-primary">
    <div class="card-header">
        <div class="card-tools">
            @isset($order->fechaSolicitud)
            <a class="btn btn-primary" href="{{ route('yeipi.pedir.index') }}" role="button">
                <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
            </a>
            @endisset
            @empty($order->fechaSolicitud)
            {!! Form::open($form) !!}
                {!! Form::hidden('order_id', $order->id) !!}
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
        <div class="card-title">
            Detalles
        </div>
    </div>
    <div class="card-body">
        <table class="table" id="table" style="width: 100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tienda</th>
                    <th>Direccion</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">
                        <strong>Total:</strong>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


@push('js')
<script>
var total = 0;
var t = $('#table').DataTable({
    processing: true,
    serverSide: true,
    "pageLength": 500,
    ajax: "{{ route('yeipi.pedir.data.detail', ['order' => $order->id]) }}",
    columns: [
        { data: 'id', name: 'id', "orderable": false },
        { data: 'stock.shop.nombre', name: 'stock.shop.nombre' },
        { data: 'stock.shop.direccion', name: 'stock.shop.direccion' },
        { data: 'stock.product.descripcion', name: 'stock.product.descripcion' },
        { data: 'descripcion', name: 'descripcion' },
        { data: 'cantidad', name: 'cantidad' },
        { data: 'precio', name: 'precio' },
        { data: 'subtotal', name: 'subtotal', orderable: false, searchable: false },
    ],
    "createdRow": (row, data, index) => {
        total = data.subtotal + total;
        $('td', row).eq(7).addClass("text-right");
        $('td', row).eq(6).addClass("text-right");
        $('td', row).eq(5).addClass("text-right");
        $('tfoot td:eq(7)').addClass("text-right").html(number_format(total, 2));
    },
    "drawCallback": function (settings) {
        total = 0;
    }
});

$.contextMenu({
    selector: ".context-menu",
    build: function ($trigger, e) {
        return {
            callback: function (key, options) {
                var tr = $(options.$trigger[0]).closest('tr');
                var row = t.row(tr);
                var model = row.data();
                switch (key) {
                    case "edit":
                        AbrirModal(model);
                        break;
                }
            },
            items: {
                "edit": { name: "Editar", icon: "edit", disabled: {{ isset($order->fechaSolicitud) ? 'true': 'false'}} },
            }
        };
    },
});
</script>
@endpush