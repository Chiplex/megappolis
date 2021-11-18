<div class="card bg-gradient-primary">
    <div class="card-header">
        <div class="card-tools">
            {!! Form::open($formPedido) !!}
            @if ($order->fechaEntrega != null)
            <input type="number" name="Calificacion" class="form-control" placeholder="Calificacion" min="0" max="5"
                value="{{ $order->calificacion }}">
            @endif
            {!! Form::button('<i class="fas fa-save"></i> '.$text, ['class' => 'btn btn-primary', 'type' => 'submit'])
            !!}
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
                    <td class="text-right">
                        <strong>Total:</strong>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registro de Detalle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open($formDetalle) !!}
            <div class="modal-body">
                <input type="hidden" name="order_id">
                <input type="hidden" name="stock_id">
                <div class="form-group row">
                    <label for="shop" class="col-sm-4">Descripcion</label>
                    <div class="col-sm-8">
                        <input type="text" name="descripcion" data="descripcion" data="stock.product.descripcion"
                            class="form-control" placeholder="Descripcion" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cantidad" class="col-sm-4 col-form-label">Cantidad</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="Cantidad" name="cantidad" type="text" id="cantidad">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="descripcion" class="col-sm-4 col-form-label">Precio</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="Precio" name="precio" type="text" id="precio" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::button('<i class="fa fa-save" aria-hidden="true"></i>', ['class' => 'btn btn-primary', 'type'
                => 'submit']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('js')
<script>
    var mPedido = $("#modal");
    var total = 0;
    var t = $('#table').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 500,
        ajax: "{{ $routes['dataCurrent'] }}",
        columns: [
            { data: 'id', name: 'id', "orderable": false },
            { data: 'stock.product.descripcion', name: 'stock.product.descripcion' },
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
                            AbrirModalDetalle(model);
                            break;
                        case "delete":
                            EliminarDetalle(model);
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

    $("#form-product").submit(function (e) {
        e.preventDefault();
        GuardarDetalle();
    });

    function AbrirModalDetalle(model) {
        console.log(model);
        JSONToForm(mPedido, model);
        mPedido.modal('show');
    }

    function GuardarDetalle() {
        var form = $("#form-product");
        var data = FormToJSON(form);
        var url = form.attr('action');
        var method = "PUT";
        if (data.id) {
            method = "POST";
        }
        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function (response) {
                if (response.success) {
                    mPedido.modal('hide');
                    t.ajax.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function (response) {
                alert(response.message);
            }
        });
    }

    function EliminarDetalle(model) {
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