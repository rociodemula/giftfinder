<?php

namespace Giftfinder\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminControl
{
    /**
     * Constructor de la clase. Se encarga de que con este middleware nadie que no tenga
     * permiso de administrador pueda entrar a una página restringida.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Manejador del middleware de administración. Se encarga de redrigir a un usuario no
     * autorizado a la página de inicio, incluyendo peticiones ajax.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ok = null;
        if ($this->auth->user()->tipo != 'admin'){
            $ok = view('errors/401');
        }else{
            //En caso de estar autorizado, se usa la clousure para mostrar el resultado.
            $ok = $next($request);
        }

        return $ok;
    }
}
