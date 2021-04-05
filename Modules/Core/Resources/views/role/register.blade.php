<div class="card card-info">
  <form class="form-horizontal" action="@if (isset($role)) {{ route('core.role.update' , ['role' => $role->id]) }} @else {{ route('core.role.store') }} @endif" method="POST">
    @csrf
    @if (isset($role))
      @method('PUT')
    @endif
    <div class="card-header">
      <div class="card-tools">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save   fa-fw"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="name" placeholder="name" name="name" value="{{ old('name') ?? isset($role) ? $role->name : '' }}">
        </div>
      </div>
    </div>
  </form>
</div>