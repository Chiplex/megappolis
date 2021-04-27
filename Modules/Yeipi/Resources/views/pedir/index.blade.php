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
                    <div class="btn-group btn-group-lg">
                        <button type="button" class="btn btn-default">
                            <i class="fas fa-cart-plus mr-1"></i>
                            <span class="badge badge-warning navbar-badge" id="spnCartCount"></span>
                        </button>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> 4 new messages
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-users mr-2"></i> 8 friend requests
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> 3 new reports
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="row gy2">
                    @foreach ($stocks as $stock)
                    <div class="col-sm-3">
                        {!! Form::open() !!}
                        {!! Form::hidden('id', $stock->product->id) !!}
                        {!! Form::submit($stock->product->descripcion, ['class' => 'btn btn-app bg-white btn-block']) !!}
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
    var modal, view, templateModal, dataTemplate = {};

    $("form").on('submit', function (e) {
        e.preventDefault();
        var product = FormToJSON($(this));
        PrepararModal(product);
    });

    function PrepararModal(product) {
        view = View("pedir.modal.shops");
        templateModal = Handlebars.compile(view);
        $.when(FillDataHtml(product)).done(() => AbrirModal(product));
    }

    function FillDataHtml(product) {
        var options = {
            type: "get",
            url: "{{ url('yeipi/pedir/shop') }}" + "/" + product.id,
        };
        return Service(options)
            .then(data => dataTemplate.shops = data.shops)
            .catch(error => console.log(error));
    }

    function AbrirModal(product) {
        dataTemplate.product_id = product.id;
        console.log(dataTemplate);
        modal =  $(templateModal(dataTemplate));
        modal.modal('show');
    }

    $("#frmPedir", modal).on('submit', function (e) {
        e.preventDefault();
        var pedir = FormToJSON($(this));
        console.log(pedir);
    });
</script>
@endpush