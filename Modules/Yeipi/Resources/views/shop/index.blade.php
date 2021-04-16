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
                    <a class="btn btn-primary" href="{{ route('yeipi.shop.create')}}" role="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Direccion</th>
                            <th>Abre</th>
                            <th>Cierra</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shops as $shop)
                        <tr>
                            <td>{{$shop->id}}</td>
                            <td>{{$shop->nombre}}</td>
                            <td>{{$shop->direccion}}</td>
                            <td>{{$shop->abre}}</td>
                            <td>{{$shop->cierra}}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ url('/yeipi/shop/register/'.$shop->id) }}"
                                        class="btn btn-info btn-flat">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ url('/yeipi/pedir/delete/'.$shop->id) }}"
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
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>