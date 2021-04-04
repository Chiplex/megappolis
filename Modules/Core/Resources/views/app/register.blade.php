<div class="card card-info">
  <form class="form-horizontal" action="@if (isset($app_)) {{ route('core.app.update' , ['app' => $app_->id]) }} @else {{ route('core.app.store') }} @endif" method="POST">
    @csrf
    @if (isset($app_))
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
          <input type="text" class="form-control" id="name" placeholder="name" name="name" value="{{ old('name') ?? isset($app_) ? $app_->name : '' }}">
        </div>
      </div>
      <div class="form-group row">
        <label for="icon" class="col-sm-2 col-form-label">Icon</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="icon" placeholder="icon" name="icon_id" value="{{ old('icon') ?? isset($app_) ? $app_->icon : '' }}">
        </div>
      </div>
      <div class="form-group row">
        <label for="type" class="col-sm-2 col-form-label">type</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="type" placeholder="type" name="type" value="{{ old('type') ?? isset($app_) ? $app_->type : '' }}">
        </div>
      </div>
    </div>
  </form>
</div>