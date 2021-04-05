<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AppCreator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $app = $user->apps()->where('name', $request->segment(1))->first();

        // Solo entran aquellos usuarios que tiene acceso su aplicacion o son creadores de esa App
        if (!$app)
            return back()->with('message', 'App no instalada: '.$request->segment(1));
        
        // Solo puede si la app no esta bloqueada
        if($app->blocked_at != null)
            return back()->with('message', 'App bloqueada: '.$request->segment(1));

        // Solo ingresan aquellos usuarios cuyo tienen el controlador que solicitan
        $page = $app->pages()->where(['controller' => $request->segment(2), 'action' => $request->segment(3)])->first();
            
        if (!$page)
            return back()->with('message', 'Módulo no instalado: '.$request->segment(2).' -> '.$request->segment(3));
        
        return $next($request);
    }
}
