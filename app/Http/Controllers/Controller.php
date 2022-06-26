<?php

namespace App\Http\Controllers;

use Auth;
use Modules\Core\Entities\App;
use Modules\Core\Entities\Module;
use Modules\Core\Entities\Permission;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $role = "CORE-MEGAPPOLIS";

    public function GetInfo($data)
    {
        $module = $this->GetModules();
        $permission = $this->GetPermissions($module);
        return ['page' => $module, 'permissions' => $permission, 'data'=> $data];
    }

    public function GetModules()
    {
        $user = Auth::user();
        $app = $user->apps()->firstOrNew(['name'=> request()->segment(1) ?? 'core']);
        if($app->isDirty())
        {
            $app->description = 'Core';
            $app->type = 'CORE';
            $app->url = '/core';
            $app->user_id = $user->id;
            $app->save();
        }

        $module = $app->modules()->firstOrNew([
            'controller' => request()->segment(2) ?? 'home',
            'action' => request()->segment(3) ?? 'index'
        ]);

        if($module->isDirty()){
            $module->name = implode('/', request()->segments());
            $module->description = 'Core';
            $module->type = 'CORE';
            $module->module_id = $app->id;
            $module->save();
        }

        return $module;
    }

    public function GetPermissions(Module $page)
    {
        if(Auth::user()->roles()->where('name', $this->role)->exists()){
            return Permission::where('page_id', $page->id)
                ->select('name')
                ->orderBy('name')
                ->groupBy('name')
                ->get();
        }
        else {
            return auth()
                ->user()
                ->roles()
                ->firstWhere('app_id', $page->app->id)
                ->permissions()
                ->select('name')
                ->orderBy('name')
                ->groupBy('name')
                ->get();
        }
    }
}
