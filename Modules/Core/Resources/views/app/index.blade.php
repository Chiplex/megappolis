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
            <a class="btn btn-tool btn-primary" href="{{ url('/core/app/register/') }}" role="button"><i class="fa fa-plus" aria-hidden="true"></i></a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table class="table table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Icon</th>
                <th>Type</th>
                <th>Aproved</th>
                <th>Blocked</th>
                <th>Owner</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($apps as $app)
              <tr>
                <td>{{$app->id}}</td>
                <td>{{$app->name}}</td>
                <td>{{$app->icon_id}}</td>
                <td>{{$app->type}}</td>
                <td>{{$app->approved_at}}</td>
                <td>{{$app->blocked_at}}</td>
                <td>{{$app->user->email}}</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ url('/core/app/register/'.$app->id) }}" class="btn btn-info btn-flat">
                      <i class="fas fa-edit"></i>
                    </a>
                    @if (isset($app->approved_at))
                    <a href="{{ url('/core/app/block/'.$app->id) }}" class="btn btn-info btn-flat">
                      <i class="fa fa-ban" aria-hidden="true"></i>
                    </a>
                    @else
                    <a href="{{ url('/core/app/approve/'.$app->id) }}" class="btn btn-info btn-flat">
                      <i class="fas fa-check    "></i>
                    </a>
                    @endif
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
