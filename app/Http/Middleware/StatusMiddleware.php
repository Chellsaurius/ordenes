<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->user_status == 1) {
                return $next($request);
            }
            else {
                Auth::logout();
                return redirect()->back()->with('error', 'Error con la cuenta.');
            }
        }
        else {
            return redirect('/welcome')->with('message', 'Acceso denegado, ingrese al sistema');
        }
        // return $next($request);
    }

}
