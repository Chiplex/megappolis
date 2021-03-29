@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_top_nav_right')
    @if (Route::has('login'))
        <li class="nav-item">
            @auth
                <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-link">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 nav-link">Register</a>
                @endif
            @endauth
        </li>
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
{{$view->name}}
@stop

@section('content')

@include($view->buildView(), $data)
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/app.js') }}" defer></script>
@stop

@section('footer')
© 2021 MegaAppolis.
@endsection