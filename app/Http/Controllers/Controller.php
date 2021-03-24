<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Modules\Core\Entiites\Page;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetPermisos(Page $page)
    {
        $role = "CORE-MEGAPPOLIS";
        $user = Auth::user();
        $roles = $user->roles();
        
        if($roles->where('name', $role)->exists())
        {
            $permissions = Permission::where('page_id', $page->id)->select('name')->orderBy('name')->groupBy('name')->get();
        }
        else
        {
            $permissions = $role->permissions()->select('name')->where('page_id', $page->id)->orderBy('name')->groupBy('name')->get();
        }
        return $permissions;
    }
}
