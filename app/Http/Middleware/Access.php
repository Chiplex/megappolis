<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Access
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Solo ingresan aquellos usuarios que tiene el rol asignado por la ruta
        $user = $request->user();
        if (!$request->user()->roles()->where('name', $role)->exists())  
            return back()->with('message', 'Acceso no autorizado');
        
        return $next($request);
    }
}
