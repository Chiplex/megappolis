<div class="modal fade" id="model" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => 'yeipi.pedir.producto', 'method' => 'post', 'id' => 'frmPedir']) !!}
            <div class="modal-body">
                <input type="hidden" name="product_id">
                <div class="form-group row">
                    <label for="shop" class="col-sm-4">Proveedor</label>
                    <div class="col-sm-8">
                        <select class="custom-select form-control-border" id="drpShops" name="shop_id">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cantidad" class="col-sm-4 col-form-label">Cantidad</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="Cantidad" name="cantidad" type="text" id="cantidad">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="descripcion" class="col-sm-4 col-form-label">Descripción</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="Cantidad" name="descripcion" type="text" id="descripcion">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::button('<i class="fa fa-save" aria-hidden="true"></i>', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>