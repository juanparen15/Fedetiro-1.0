<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        // Excluir todas las rutas de Voyager usando un patrón
        // if ($request->route() && str_starts_with($request->route()->getName(), 'voyager.')) {
        //     return $next($request);
        // }

        // if (Auth::check() && Auth::user()->isActive == 0) {
        //     Auth::logout();
        //     return redirect()->route('login')->with('error', 'Tu cuenta ha sido desactivada. Contacta al administrador.');
        // }

        return $next($request);
    }
}
