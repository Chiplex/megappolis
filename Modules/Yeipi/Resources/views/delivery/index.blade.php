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
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveries as $delivery)
                        <tr>
                            <td>{{$delivery->id}}</td>
                            <td>{{$delivery->people->getNameComplete()}}</td>
                            <td>{{$delivery->people->phone}}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('yeipi.contract.store') }}" method="post" >
                                        @csrf
                                        <input type="hidden" name="delivery_id" value="{{ auth()->user()->people->id }}">
                                        <input type="hidden" name="shop_id" value="{{ auth()->user()->people->id }}">
                                        <button type="submit" class="btn btn-black btn-block">
                                            <i class="fas fa-arrow-circle-right"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('yeipi.contract.create', ['delivery' => $delivery->id, 'shop' => ].) }}"
                                        class="btn btn-info btn-flat">
                                        <i class="fa fa-user"></i> Contratar
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