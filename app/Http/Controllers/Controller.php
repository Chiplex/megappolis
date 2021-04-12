<?php

namespace App\Http\Controllers;

use Auth;
use Modules\Core\Entities\Page;
use Modules\Core\Entities\Permission;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $role = "CORE-MEGAPPOLIS";

    public function GetPages()
    {
        $user = request()->user();
        $app = $user->apps()->where('name', request()->segment(1))->first();
        $page = $app->pages()->where(['controller' => request()->segment(2) ?? 'home', 'action' => request()->segment(3) ?? 'index'])->first();

        return $page;
    }

    public function GetPermissions(Page $page)
    {
        $user = Auth::user();
        $roles = $user->roles();
        
        return $permissions = $roles->where('name', $this->role)->exists() 
            ? Permission::where('page_id', $page->id)->select('name')->orderBy('name')->groupBy('name')->get()
            : $roles->permissions()->select('name')->orderBy('name')->groupBy('name')->get();
    }

    public function GetInfo($data)
    {
        $page = $this->GetPages();
        $permission = $this->GetPermissions($page);
        return ['view' => $page, 'permissions' => $permission, 'data'=> $data];
    }
}
