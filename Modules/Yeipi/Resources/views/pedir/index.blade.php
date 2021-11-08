<div class="row">
    <div class="col-12">
        <div class="callout callout-primary">
            <h5>Direccion de entrega</h5>
            <p>{{ $customer->direccion }}</p>
        </div>
        <div class="card bg-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="input-group">
                        <input type="text" name="table_search" class="form-control" placeholder="Search" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-tools">
                    <a href="{{ $routes['localization'] }}" class="btn btn-default">
                        <i class="fas fa-external-link-alt"></i>
                        Actualizar localización
                    </a>
                    <a href="{{ $routes['history'] }}" class="btn btn-default">
                        <i class="fa fa-history" aria-hidden="true"></i> Ver pedidos anteriores
                    </a>
                    <div class="btn-group">
                        {{-- Si tiene un pedido en curso, redirecciona al pedido en curso caso contrario registra el pedido --}}
                        @if($order->fechaRecepcion != null)
                            <a href="{{ $routes['current'] }}" class="btn btn-default">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Ver pedido en curso
                            </a>
                        @else
                            <a type="button" class="btn btn-default" href="{{ $routes['current'] }}">
                                <i class="fas fa-cart-plus mr-1"></i> 
                                <span class="badge badge-warning" id="spnCartCount">3</span>
                                Continuar con el pedido
                            </a>
                            <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach ($details as $detail)
                                    <p class="dropdown-item">{{ $detail->cantidad }} {{ $detail->stock->product->descripcion }}</p>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach ($stocks as $stock)
                    <div class="col">
                        {!! Form::open(['id' => 'form-product']) !!}
                            {!! Form::hidden('product_id', $stock->product->id) !!}
                            {!! Form::hidden('order_id', $order->id) !!}
                            <div class="card bg-white text-center">
                                <img src="#" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $stock->product->descripcion }}</h5>
                                    {!! Form::submit('Agregar al carrito', ['class' => 'btn bg-primary btn-block']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open($form) !!}
            <div class="modal-body">
                <input type="hidden" name="product_id">
                <input type="hidden" name="order_id">
                <div class="form-group row">
                    <label for="shop" class="col-sm-4">Proveedor</label>
                    <div class="col-sm-8">
                        <select class="custom-select form-control-border" id="drpShops" name="shop_id">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cantidad" class="col-sm-4 col-form-label">Cantidad</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="Cantidad" name="cantidad" type="text" id="cantidad" autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="descripcion" class="col-sm-4 col-form-label">Descripción</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="Descripcion" name="descripcion" type="text" id="descripcion">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::button('<i class="fa fa-save" aria-hidden="true"></i>', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('js')
<script>
    var mPedido = $("#modal");

    DetailsCount();

    $("#form-product").on('submit', function (e) {
        e.preventDefault();
        var dataForm = FormToJSON($(this));
        AbrirModal(dataForm);
    });

    $("#form-pedir", mPedido).on('submit', function (e) {
        e.preventDefault();
        var pedido = FormToJSON($(this));
        GuardarPedido(pedido);
    });

    function AbrirModal(dataForm) {
        JSONToForm(mPedido, dataForm);
        Service({
            type: "get",
            url: "{{ $routes['shop'] }}" + "/" + dataForm.product_id,
        })
        .then(data => FillDrop(data.shops))

        mPedido.modal('show');
    }

    function FillDrop(shops) {
        select = $("#drpShops", mPedido).empty();
        option = $("<option>");
        for (const key in shops) {
            let shop = shops[key];
            option.clone().val(shop.id).text(`Bs. ${shop.pivot.precio} en ${shop.nombre}`).appendTo(select);
        }
    }

    function GuardarPedido(pedido) {
        Service({
            type: "post",
            url: $("#form-pedir", mPedido).attr('action'),
            data: pedido
        })
        .then(data => {
            mPedido.modal("hide");
            shortDetail = $("<p>");
            shortDetail.clone().addClass("dropdown-item").text(data.detail.cantidad + " " + data.detail.stock.product.descripcion).prependTo(".dropdown-menu-right");
            DetailsCount();
        })
    }

    function DetailsCount() {
        Service({
            type: "get",
            url: "{{ $routes['count'] }}"
        })
        .then(data => {
            $("#spnCartCount").text(data.details_count);
        })
    }

    
</script>
@endpush