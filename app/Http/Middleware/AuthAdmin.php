<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
      public function handle($request, Closure $next)
      {
         if (Auth::user()->tipo_usuario!=='ADMINISTRADOR') {
            abort(401, 'No está autorizado.');
         }
         
         return $next($request);
      }
}
