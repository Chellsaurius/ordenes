<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6) {
                return $next($request);
            }
            else {
                return redirect('/home')->with('message', 'Acceso denegado por permisos');
            }
        }
        else {
            return redirect('/welcome')->with('message', 'Acceso denegado, ingrese al sistema');
        }
        // return $next($request);
    }
}
