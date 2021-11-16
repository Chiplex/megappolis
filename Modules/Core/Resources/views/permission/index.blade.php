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
            <a class="btn btn-tool btn-primary" href="{{ url('/core/permission/register/') }}" role="button"><i class="fa fa-plus" aria-hidden="true"></i></a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Role</th>
                <th>App</th>
                <th>Controller</th>
                <th>Action</th>
                <th>Page</th>
                <th>Name</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($permissions as $permission)
              <tr>
                <td>{{$permission->id}}</td>
                <td>{{$permission->role->name}}</td>
                <td>{{$permission?->page?->app?->name ?? ""}}</td>
                <td>{{$permission?->page?->controller ?? ""}}</td>
                <td>{{$permission?->page?->action ?? ""}}</td>
                <td>{{$permission?->page?->name ?? ""}}</td>
                <td>{{$permission->name}}</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ url('/core/permission/register/'.$permission->id) }}" class="btn btn-info btn-flat">
                      <i class="fas fa-edit"></i>
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
