<div class="row justify-content-md-center">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Pedir</h3>
            </div>
            <form action="{{ route('yeipi.customer.store') }}" method="post" >
                @csrf
                <input type="hidden" name="people_id" value="{{auth()->user()->people->id}}">
                <button type="submit" class="clear-fix">
                    <div class="icon">
                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                    </div>
                </button>
            </form>
            <a href="#" class="small-box-footer">
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Entregar</h3>
            </div>
            <div class="icon">
                <i class="fa fa-truck"></i>
            </div>
            <a href="#" class="small-box-footer">
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
</div>
