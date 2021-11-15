<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $ordersDelivered->count() }}</h3>
                <p>Ordenes Entregadas</p>
            </div>
            <div class="icon">
                <i class="fa fa-list fa-fw" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $ordersUndelivered->count() }}</h3>
                <p>Nuevas Ordenes</p>
            </div>
            <div class="icon">
                <i class="fa fa-star fa-fw" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalSales }}</h3>
                <p>Total Ventas</p>
            </div>
            <div class="icon">
                <i class="fa fa-money-check fa-fw"></i>
                <i class="fa fa-dollar" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</div>