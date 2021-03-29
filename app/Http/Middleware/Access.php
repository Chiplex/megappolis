<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Entities\App;
use Modules\Core\Entities\Page;

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
        $user = $request->user();
        if (!$user->roles()->where('name', $role)->exists()) {
            // se redirecciona cuando el usuario no tiene el rol relativo
            return redirect('home');
        }

        if (!$user->apps()->where('name', $request->segment(1))->exists()) {
            // se redirecciona cuando el usuario no tiene el app que viene del url
            return redirect('home');
        }
        
        $app = $user->apps()->where('name', $request->segment(1))->first();
        if (!$app->pages()->where(['controller' => $request->segment(2), 'action' => $request->segment(3)])->exists()) {
            // se redirecciona cuando el usuario no tiene el pagina y la accion que viene del url
            return redirect('home');
        }
        
        return $next($request);
    }
}
