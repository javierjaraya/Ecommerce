<?php

namespace App\Http\Middleware;

use Closure;
//use Illuminate\Support\Facades\Auth;//Para acceder al auth


class AdminMiddleware
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
        if (auth()->check() && auth()->user()->id_perfil == 2)
            return $next($request);

        return redirect('/');
    }
}
