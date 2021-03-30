<div class="card card-info">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST">
      @csrf
      <div class="card-body">
        <div class="form-group row">
          <label for="App" class="col-sm-2 col-form-label">App</label>
          <div class="col-sm-4">
            <select class="custom-select form-control-border" id="App" name="app">
                @foreach ($apps as $app)
                    <option value="{{$app->id}}">{{$app->name}}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="controller" class="col-sm-2 col-form-label">Controller</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="controller" placeholder="Controller" name="controller" value="{{ old('controller') }}">
          </div>
        </div>
        <div class="form-group row">
            <label for="action" class="col-sm-2 col-form-label">Action</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="action" placeholder="Action"  name="action" value="{{ old('action') }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name') }}" name="name">
            </div>
        </div>
        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Type</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="type" placeholder="Type" value="{{ old('type') }}" name="type">
            </div>
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="submit" class="btn btn-info">Save</button>
      </div>
      <!-- /.card-footer -->
    </form>
  </div>