<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function show($view){
        
        if (count(request()->segments()) > 2) {
            $appName = 'main';
            $controller = \request()->segment(1);
            $action = \request()->segment(2);
        } else {
            $appName = \request()->segment(1);
            $controller = \request()->segment(2);
            $action = \request()->segment(3);
        }

        $app = App::find(['name' => $appName, 'user_id' => 1 ])->first();
        $page = Page::where(['app_id'=> $appName->id, 'controller' => 'page', 'action' => 'index'])->first();

        $permissions = GetPermisos($page);
        
        $result = ['result' => true, 'data' => $permissions];
        //return view('core::'.$app."\'".$view, compact($permissions->toArray()));
        return view('core::app\shared\viewIndex', compact('result'))->render();
    }
}
