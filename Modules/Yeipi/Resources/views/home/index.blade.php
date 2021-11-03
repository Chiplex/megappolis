@extends('adminlte::page')

@section('title', 'Home')

@section('content_top_nav_right')
    @if (Route::has('login'))
        @guest
            <li>
                <a href="{{ route('login') }}" class="nav-link">Log in</a>
            </li>
            <li>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                @endif
            </li>
        @endauth
    @endif
@endsection

@section('content_header')
    @if (\Session::has('message'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            {!! \Session::get('message') !!}
        </div>
    @endif
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@stop

@section('content')
<div class="row justify-content-md-center mt-5">
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
@stop


@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop

@section('js')
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/helpers.js') }}" ></script>
    {{-- <script src="{{ asset('js/dashboard.js') }}" defer></script> --}}
@stop

@section('footer')
© 2021 MegaAppolis.
@endsection


