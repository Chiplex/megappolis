<div class="row justify-content-md-center">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>Pedir</h3>
            </div>
            <div class="icon">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
            </div>
            <a class="btn btn-black btn-lg btn-block" href="{{ route('yeipi.home.create', ['yeipi' => 'pedir']) }}" role="button">
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Entregar</h3>
            </div>
            <div class="icon">
                <i class="fa fa-truck"></i>
            </div>
            <a class="btn btn-black btn-lg btn-block" href="{{ route('yeipi.home.create', ['yeipi' => 'entregar']) }}" role="button">
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Proveer</h3>
            </div>
            <div class="icon">
                <i class="fa fa-store"></i>
            </div>
            <a class="btn btn-black btn-lg btn-block" href="{{ route('yeipi.home.create', ['yeipi' => 'proveer']) }}" role="button">
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
</div>
