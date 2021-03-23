<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Entities\App;

class ViewController extends Controller
{
    public function getView($view){
        $app = \request()->segment(1);
        $controller = \request()->segment(2);
        $action = \request()->segment(3);
        
        $app = App::find(['name' => $app]);
        $matchesPage = ['app_id'=> $app->id, 'controller' => $controller, 'action' => $action];
        $page = Page::where($matchesPage)->first();

        $permissions;

        $matchesRole = ['user_id' => auth()->user()->id , 'role_id' => 1];
        if(Role::where($matchesRole)->count() > 0){
            $matchPage = ['controller' => $controller, 'action' => $action];
            $permissions = Permission::whereHas('pages', function (Builder $query) use($matchPage){
                $query->where($matchPage);
            })->orderBy('name')->groupBy('name')->get();
        }
        else{
            $permissions = Permission::whereHas('roles.user', function (Builder $query)
            {
                $query->where('id', auth()->user()->id);
            })->orderBy('name')->groupBy('name')->get();
        }
        
        return view('core::'.$app."\'".$view,compact($permissions));
    }
}
