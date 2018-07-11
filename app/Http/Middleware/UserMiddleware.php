<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        //1 = Cliente
        //2 = Administrador
        if (auth()->check() && (auth()->user()->id_perfil == 1 || auth()->user()->id_perfil == 2))
            return $next($request);

        return redirect('/');
    }
}
