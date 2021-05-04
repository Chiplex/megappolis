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
        $form = ['route' => 'passport.store', 'method' => 'post', 'files' => true];
        return view('passport', \compact('form'));
    }

    public function store()
    {
        return view('dashboard', $this->GetInfo([]));
    }
}
