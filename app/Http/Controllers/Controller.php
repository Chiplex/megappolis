<?php

namespace App\Http\Controllers;

use Auth;
use Modules\Core\Entities\App;
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

    public function GetInfo($data)
    {
        $page = $this->GetPages();
        $permission = $this->GetPermissions($page);
        return ['page' => $page, 'permissions' => $permission, 'data'=> $data];
    }

    public function GetPages()
    {
        $user = Auth::user();
        $app = $user->apps()->where('name', request()->segment(1) ?? 'core')->first() ?? App::where('name', request()->segment(1) ?? 'core')->first();
        $page = $app->pages()->firstOrNew(['controller' => request()->segment(2) ?? 'home', 'action' => request()->segment(3) ?? 'index']);

        if($page->isDirty()){
            $page->name = implode('/', request()->segments());
            $page->type = 'new';
            $page->save();
        }

        return $page;
    }

    public function GetPermissions(Page $page)
    {
        if(Auth::user()->roles()->where('name', $this->role)->exists()){
            return Permission::where('page_id', $page->id)
                ->select('name')
                ->orderBy('name')
                ->groupBy('name')
                ->get();
        }
        else {
            return Auth::user()
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
