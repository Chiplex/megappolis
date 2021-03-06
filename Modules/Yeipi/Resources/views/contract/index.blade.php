<div class="row">
    <div class="col-12">
        <div class="card">
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
                    <a class="btn btn-primary" href="{{ route('yeipi.contract.create')}}" role="button">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Shop</th>
                            <th>Delivery</th>
                            <th>Empieza</th>
                            <th>Acaba</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contracts as $contract)
                        <tr>
                            <td>{{$contract->id}}</td>
                            <td>{{$contract->shop->nombre}}</td>
                            <td>{{$contract->delivery->people->getNameComplete()}}</td>
                            <td>{{$contract->empieza}}</td>
                            <td>{{$contract->acaba}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>