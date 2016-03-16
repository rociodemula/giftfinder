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
            if ($request->ajax()) {
                $ok = view('errors/401');
                //Original:
                //$ok = response('Unauthorized.', 401);
            } else {
                //En principio no se ve oportuno lanzar un mensaje de falta de permisos, debido a la
                //seguridad. Simplemente se redirige al usuario a la página de bienvenida.
                $ok = view('errors/401');
                //Original
                //$ok =  redirect('/');
            }
        }else{
            //En caso de estar autorizado, se usa la clousure para mostrar el resultado.
            $ok = $next($request);
        }

        return $ok;
    }
}
