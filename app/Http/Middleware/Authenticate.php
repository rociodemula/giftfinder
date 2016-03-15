<?php

namespace Giftfinder\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * Variable de clase del middleware.
     *
     * @var Guard
     */

    protected $auth;

    /**
     * Contructor de la clase. Crea un filtro de forma que ningún usuario no logado
     * pueda accedera las páginas con este middleware.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Manejador del middleware. Redirige los usuarios no logados a la página de login
     * o a la 401 en caso de peticiones ajax.
     *
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next)
    {
        $ok = null;
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                //Se prevee que la petición pueda ser ajax.
                $ok = response('Unauthorized.', 401);
            } else {
                $ok = redirect()->guest('auth/login');
                //En principio no se ve oportuno lanzar un mensaje de falta de permisos.
                //Simplemente se redirige al usuario a la página de login.
            }
        }else{
            //En caso de estar logado, se usa la clousure para mostrar el resultado.
            $ok = $next($request);
        }

        return $ok;
    }
}
