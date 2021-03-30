<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control" placeholder="Search">
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
                <th>Name</th>
                <th>Icon</th>
                <th>Type</th>
                <th>Aproved</th>
                <th>Blocked</th>
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
                    <td>{{$app->approved}}</td>
                    <td>{{$app->blocked}}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ url('/core/role/register/'.$app->id) }}" class="btn btn-info btn-flat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ url('/core/role/user/'.$app->id) }}" class="btn btn-info btn-flat">
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
