<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Entities\Permission;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = 'guest')
    {
        // Solo ingresan aquellos que tiene el permiso de ver en la pagina
        $user = $request->user();
        $app = $user->app()->where('name', $request->segment(1))->first();
        $page = $app->pages()->where(['controller' => $request->segment(2), 'action' => $request->segment(3)])->first();
        $role = $user->roles()->where('name', $role)->first();
        $permissions = $role->permissions()->where(['page_id' => $page->id, 'name' => 'view'])->first();
        if (!$permissions) return back()->with('message', 'No tiene permisos para ver esta pagina');

        return $next($request);
    }
}
