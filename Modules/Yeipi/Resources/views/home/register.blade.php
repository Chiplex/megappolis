<div class="card card-info">
    {!! Form::open($form) !!}
    <div class="card-header">
        <div class="card-title">Confirma tu infomación para la comunicación entre quienes pidan, entreguen o provean</div>
        <div class="card-tools">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label for="tipo" class="col-sm-2 col-form-label">Que Vamos a hacer</label>
            <div class="col-sm-4">
                <div class="btn-group btn-group-toggle btn-block" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="action" value="pedir" @if($action == 'pedir') checked="checked" @endif><i class="fa fa-cart-plus" aria-hidden="true"></i> Pedir
                    </label>
                    <label class="btn btn-outline-danger">
                        <input type="radio" name="action" value="entregar" @if($action == 'entregar') checked="checked" @endif><i class="fa fa-truck"></i> Entregar
                    </label>
                    <label class="btn btn-outline-info">
                        <input type="radio" name="action" value="proveer" @if($action == 'proveer') checked="checked" @endif><i class="fa fa-store"></i> Proveer
                    </label>
                </div>
            </div>
        </div>
        @include('form.text', ['name' => 'name', 'title' => 'Nombre', 'value' => $people->name ?? '', 'disabled' => true])
        @include('form.text', ['name' => 'otheName', 'title' => 'Otros Nombres', 'value' => $people->otherName ?? '', 'disabled' => true])
        @include('form.text', ['name' => 'lastName', 'title' => 'Apellidos', 'value' => $people->lastName ?? '', 'disabled' => true])
        @include('form.text', ['name' => 'otherLastName', 'title' => 'Otros Apellidos', 'value' => $people->otherLastName ?? '', 'disabled' => true])
        @include('form.text', ['name' => 'phone', 'title' => 'Celular', 'value' => $people->phone ?? ''])
    </div>
    {!! Form::close() !!}
</div>
