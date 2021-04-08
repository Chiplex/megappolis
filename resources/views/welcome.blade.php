@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_top_nav_right')
    @if (Route::has('login'))
        @auth
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
            </li>
        @else
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
    <h1></h1>
@stop

@section('content')

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