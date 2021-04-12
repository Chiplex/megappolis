<div class="card card-info">
  <form class="form-horizontal" action="@if (isset($page)) {{ route('core.page.update' , ['page' => $page->id]) }} @else {{ route('core.page.store') }} @endif" method="POST">
    @csrf
    @if (isset($page))
      @method('PUT')
    @endif
    <div class="card-header">
      <div class="card-tools">
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </div>
    <div class="card-body">
      <div class="form-group row">
        <label for="App" class="col-sm-2 col-form-label">App</label>
        <div class="col-sm-4">
          <select class="custom-select form-control-border" id="App" name="app_id">
              @foreach ($apps as $app)
                  <option value="{{$app->id}}" 
                    @isset($page) 
                      @if (old('app_id') ?? $page->app_id == $app->id) 
                        selected 
                      @endif 
                    @endisset
                    @empty($page)
                      @if (old('app_id') == $app->id) 
                        selected 
                      @endif 
                    @endempty
                    >
                    {{$app->name}}
                  </option> 
              @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="controller" class="col-sm-2 col-form-label">Controller</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="controller" placeholder="Controller" name="controller" value="{{ old('controller') ?? isset($page) ? $page->controller : '' }}">
        </div>
      </div>
      <div class="form-group row">
          <label for="action" class="col-sm-2 col-form-label">Action</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="action" placeholder="Action"  name="action" value="{{ old('action') ?? isset($page) ? $page->action : '' }}">
          </div>
      </div>
      <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{ old('name') ?? isset($page) ? $page->name : '' }}">
          </div>
      </div>
      <div class="form-group row">
        <label for="icon" class="col-sm-2 col-form-label">Icon</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="icon" placeholder="icon" name="icon" value="{{ old('icon') ?? isset($page) ? $page->icon : '' }}">
        </div>
      </div>
      <div class="form-group row">
          <label for="type" class="col-sm-2 col-form-label">Type</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="type" placeholder="Type" name="type" value="{{ old('type') ?? isset($page) ? $page->type : '' }}">
          </div>
      </div>
      <div class="form-group row">
        <div class="offset-sm-2 col-sm-4">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="header"
              @isset($page) 
                @if (old('header') == 1 || $page->header == 1) 
                  checked 
                @endif 
              @endisset
              @empty($page)
                @if (old('header') == 1) 
                  checked 
                @endif 
              @endempty
              >
            <label for="header" class="custom-control-label">Header</label>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>