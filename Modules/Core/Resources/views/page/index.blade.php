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
                <th>App</th>
                <th>Controller</th>
                <th>Action</th>
                <th>Type</th>
                <th>Page</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                <tr>
                    <td>{{$page->id}}</td>
                    <td>{{$page->app->name}}</td>
                    <td>{{$page->controller}}</td>
                    <td>{{$page->action}}</td>
                    <td>{{$page->type}}</td>
                    <td>{{$page->page_id}}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ url('/core/role/register/'.$page->id) }}" class="btn btn-info btn-flat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ url('/core/role/user/'.$page->id) }}" class="btn btn-info btn-flat">
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
