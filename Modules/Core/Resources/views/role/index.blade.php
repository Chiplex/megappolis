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
            <a class="btn btn-tool btn-primary" href="{{ url('/core/role/register/') }}" role="button"><i class="fa fa-plus" aria-hidden="true"></i></a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table class="table table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>App</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->type}}</td>
                    <td>{{$role->app->name ?? ''}}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ url('/core/role/register/'.$role->id) }}" class="btn btn-info btn-flat">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ url('/core/role/user-page-permissions/'.$role->id) }}" class="btn btn-info btn-flat">
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
