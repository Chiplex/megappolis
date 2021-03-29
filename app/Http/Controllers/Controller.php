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
        
        return $permissions = $roles->where('name', $role)->exists() 
            ? Permission::where('page_id', $page->id)->GetByRole()
            : $roles->permissions()->GetByRole();
    }
}
