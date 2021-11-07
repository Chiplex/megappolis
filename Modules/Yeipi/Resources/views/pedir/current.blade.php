<div class="card bg-gradient-primary">
    <div class="card-header">
        <div class="card-tools">
            {!! Form::open($form) !!}
                {!! Form::button('<i class="fas fa-save"></i> '.$text, ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
            {!! Form::close() !!}
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
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Tienda</th>
                    <th>Direccion</th>
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
var mPedido, vPedido;
var vPedido = View("pedir.modal.detail");
var mPedido = $(vPedido);
var total = 0;
var t = $('#table').DataTable({
    processing: true,
    serverSide: true,
    "pageLength": 500,
    ajax: "{{ route('yeipi.pedir.data.current') }}",
    columns: [
        { data: 'id', name: 'id', "orderable": false },
        { data: 'stock.product.descripcion', name: 'stock.product.descripcion' },
        { data: 'descripcion', name: 'descripcion' },
        { data: 'stock.shop.nombre', name: 'stock.shop.nombre' },
        { data: 'stock.shop.direccion', name: 'stock.shop.direccion' },
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
                    case "delete":
                        Eliminar(model);
                        break;
                }
            },
            items: {
                "edit": { name: "Editar", icon: "edit", disabled: {{ isset($order->fechaSolicitud) ? 'true': 'false'}} },
                "delete": { name: "Eliminar", icon: "delete", disabled: {{ isset($order->fechaSolicitud) ? 'true': 'false'}} },
            }
        };
    },
});

function AbrirModal(model) {
    JSONToForm(model, mPedido);
    mPedido.modal('show');
}

function Eliminar(model) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, eliminar!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "{{ route('yeipi.pedir.delete') }}",
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                    detail_id: model.id
                },
                success: function (data) {
                    if (data.success) {
                        Swal.fire(
                            '¡Eliminado!',
                            data.message,
                            'success'
                        );
                        t.ajax.reload();
                    } else {
                        Swal.fire(
                            '¡Error!',
                            data.message,
                            'error'
                        );
                    }
                }
            });
        }
    });
}

</script>
@endpush