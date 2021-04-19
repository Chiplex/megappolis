<div class="row justify-content-md-center">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Pedir</h3>
            </div>
            <div class="icon">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
            </div>
            {!! Form::open(['route' => 'yeipi.customer.store', 'method' => 'post']) !!}
                {!! Form::hidden('people_id', auth()->user()->people->id) !!}
                <button type="submit" class="btn btn-black btn-lg btn-block">
                    <i class="fas fa-arrow-circle-right"></i>
                </button>
            {!! Form::close() !!}
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
            <form action="{{ route('yeipi.delivery.store') }}" method="post" >
                @csrf
                <input type="hidden" name="people_id" value="{{ auth()->user()->people->id }}">
                <button type="submit" class="btn btn-black btn-lg btn-block">
                    <i class="fas fa-arrow-circle-right"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-default">
            <div class="inner">
                <h3>Proveer</h3>
            </div>
            <div class="icon">
                <i class="fa fa-store"></i>
            </div>
            <button type="button" class="btn btn-black btn-lg btn-block">
                Pronto
            </button>
            {{-- <form action="{{ route('yeipi.shop.store') }}" method="post" >
                @csrf
                <input type="hidden" name="people_id" value="{{ auth()->user()->people->id }}">
                <button type="submit" class="btn btn-black btn-lg btn-block">
                    <i class="fas fa-arrow-circle-right"></i>
                </button>
            </form> --}}
        </div>
    </div>
    <!-- ./col -->
</div>
