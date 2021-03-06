<div class="row">
    <div class="col-12">
        <div class="card bg-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="input-group input-group-lg">
                        <input type="text" name="table_search" class="form-control" placeholder="Search" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-tools">
                    <a href="{{route('yeipi.pedir.history')}}" class="btn btn-lg btn-default">
                        <i class="fa fa-history" aria-hidden="true"></i> Ver pedidos anteriores
                    </a>
                    <div class="btn-group btn-group-lg">
                        <a type="button" class="btn btn-default" href="{{route('yeipi.pedir.edit', ['order' => $order->id ])}}">
                            <i class="fas fa-cart-plus mr-1"></i>
                            <span class="badge badge-warning navbar-badge" id="spnCartCount"></span>
                        </a>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            @foreach ($details as $detail)
                                <p class="dropdown-item">{{ $detail->cantidad }} {{ $detail->stock->product->descripcion }}</p>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach ($stocks as $stock)
                    <div class="col">
                        {!! Form::open() !!}
                            {!! Form::hidden('product_id', $stock->product->id) !!}
                            {!! Form::hidden('order_id', $order->id) !!}
                            <div class="card bg-white text-center">
                                <img src="#" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $stock->product->descripcion }} <small>Bs. {{ $stock->precio }}</small></h5>
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

@push('js')
<script>
    var mPedido, vPedido;
    vPedido = View("pedir.modal.shops");
    mPedido = $(vPedido);

    DetailsCount();

    $("form").on('submit', function (e) {
        e.preventDefault();
        var dataForm = FormToJSON($(this));
        AbrirModal(dataForm);
    });

    $("#frmPedir", mPedido).on('submit', function (e) {
        e.preventDefault();
        var pedido = FormToJSON($(this));
        GuardarPedido(pedido);
    });

    function AbrirModal(dataForm) {
        JSONToForm(mPedido, dataForm);
        Service({
            type: "get",
            url: "{{ url('yeipi/pedir/shop') }}" + "/" + dataForm.product_id,
        })
        .then(data => FillDrop(data.shops))

        mPedido.modal('show');
    }

    function FillDrop(shops) {
        select = $("#drpShops", mPedido).empty();
        option = $("<option>");
        for (const key in shops) {
            let shop = shops[key];
            option.clone().val(shop.id).text(shop.nombre).appendTo(select);
        }
    }

    function GuardarPedido(pedido) {
        Service({
            type: "post",
            url: "{{ route('yeipi.pedir.store') }}",
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
            url: "{{ route('yeipi.pedir.count') }}"
        })
        .then(data => {
            $("#spnCartCount").text(data.details_count);
        })
    }
</script>
@endpush