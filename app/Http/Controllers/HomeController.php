<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard', $this->GetInfo([]));
    }

    public function create()
    {
        return view('passport');
    }

    public function store()
    {
        return view('dashboard', $this->GetInfo([]));
    }
}
