<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Entities\App;
use Modules\Core\Entities\Page;
use Modules\Core\Entities\Permission;

class Access
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = "guest")
    {
        // se redirecciona cuando el usuario no tiene el rol asignado por la ruta
        $user = $request->user();
        if (!$user->roles()->where('name', $role)->exists()) {
            return redirect('home');
        }
        $roles = $user->roles();
        // se redirecciona cuando el usuario no tiene el app que viene del url
        if (!$user->apps()->where('name', $request->segment(1))->exists()) {
            return redirect('home');
        }
        
        // se redirecciona cuando el usuario no tiene el pagina y la accion que viene del url
        $app = $user->apps()->where('name', $request->segment(1))->first();
        if (!$app->pages()->where(['controller' => $request->segment(2), 'action' => $request->segment(3)])->exists()) {
            return redirect('home');
        }

        if ($role != "guest") {
            $page = $app->pages()->where(['controller' => $request->segment(2), 'action' => $request->segment(3)])->first();
        } 
        else {
            $page = Page::where(['controller' => $request->segment(2), 'action' => $request->segment(3)])->first();
        }
        
        // Se redirecciona cuando no tiene el permiso de ver en esta pagina
        $role = $roles->where('name', $role)->first();
        if (!$role->permissions()->where(['page_id' => $page->id, 'name' => 'view'])->exists()) {
            return redirect('home');
        }
        
        // Si es el creador pasar todos los permisos
        if ($roles->where('name', 'CORE-MEGAPPOLIS')->exists()) {
            $permissions = Permission::where('page_id', $page->id)->select('name')->orderBy('name')->groupBy('name')->get();
        }
        $permissions = $role->permissions()->where(['page_id' => $page->id, 'name' => 'view'])->select('name')->orderBy('name')->groupBy('name')->get();

        $request->attributes->add(['page' => $page, 'permissions' => $permissions]);
        
        return $next($request);
    }
}
