<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <div class="input-group" >
              <input type="text" name="table_search" class="form-control" placeholder="Search" />
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-tools">
            <form action="{{ route('yeipi.pedir.store')}}" method="post">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
            </form>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table class="table table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Delivery</th>
                <th>Fecha de Solicitud</th>
                <th>Fecha de Salida</th>
                <th>Fecha de Entrega</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->contract->delivery->people->name}}</td>
                    <td>{{$order->fechaSolicitud}}</td>
                    <td>{{$order->fechaSalida}}</td>
                    <td>{{$order->fechaEntrega}}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            {!! Form::file() !!}
                            <a href="{{ url('/yeipi/pedir/register/'.$order->id) }}" class="btn btn-info btn-flat">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ url('/yeipi/pedir/register/'.$order->id) }}" class="btn btn-info btn-flat">
                                <i class="fas fa-user"></i>
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