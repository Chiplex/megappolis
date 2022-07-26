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
        return ['module' => $module, 'permissions' => $permission, 'data'=> $data];
    }

    public function GetModules()
    {
        $user = Auth::user();
        $app = $user->apps()->where(['name'=> request()->segment(1) ?? 'core'])->first();

        $module = $app->modules()->where([
            'controller' => request()->segment(2) ?? 'home',
            'action' => request()->segment(3) ?? 'index'
        ])->first();

        return $module;
    }

    public function GetPermissions(Module $module)
    {
        if(Auth::user()->roles()->where('name', $this->role)->exists()){
            return Permission::where('module_id', $module->id)
                ->select('name')
                ->orderBy('name')
                ->groupBy('name')
                ->get();
        }
        return auth()->user()->roles()
            ->firstWhere('app_id', $module->app->id)
                ->permissions()
                ->select('name')
                ->orderBy('name')
                ->groupBy('name')
                ->get();
    }

    public function layout($data)
    {
        return view('layout', $this->GetInfo($data));
    }
}
