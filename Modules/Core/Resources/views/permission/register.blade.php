<div class="card card-info">
  <form class="form-horizontal" action="@if (isset($permission)) {{ route('core.permission.update' , ['permission' => $permission->id]) }} @else {{ route('core.permission.store') }} @endif" method="POST">
    @csrf
    @if (isset($permission))
      @method('PUT')
    @endif
    <div class="card-header">
      <div class="card-tools">
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </div>
    <div class="card-body">
      <div class="form-group row">
        <label for="role" class="col-sm-2 col-form-label">Roles</label>
        <div class="col-sm-4">
          <select class="custom-select form-control-border" id="role" name="role_id">
              @foreach ($roles as $role)
                  <option value="{{$role->id}}" 
                    @isset($permission) 
                      @if (old('role_id') ?? $permission->role_id == $role->id) 
                        selected 
                      @endif 
                    @endisset
                    @empty($permission)
                      @if (old('role_id') == $role->id) 
                        selected 
                      @endif 
                    @endempty
                    >
                    {{$role->name}}
                  </option> 
              @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="page" class="col-sm-2 col-form-label">Page</label>
        <div class="col-sm-4">
          <select class="custom-select form-control-border" id="page" name="page_id">
              @foreach ($pages as $page)
                  <option value="{{$page->id}}" 
                    @isset($permission) 
                      @if (old('page_id') ?? $permission->page_id == $page->id) 
                        selected 
                      @endif 
                    @endisset
                    @empty($permission)
                      @if (old('page_id') == $page->id) 
                        selected 
                      @endif 
                    @endempty
                    >
                    {{$page->name}}
                  </option> 
              @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="name" placeholder="name" name="name" value="{{ old('name') ?? isset($permission) ? $permission->name : '' }}">
        </div>
      </div>
    </div>
  </form>
</div>