<?php

namespace Giftfinder\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfAuthenticated
{
    /**
     * Variable de clase del middleware.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    /**
     * Constructor de la clase. Gestiona la redirección de usuarios ya autenticados
     * durante la recuperación de contraseñas.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Manejador del middleware. Redirige a un usuario a su gestion de perfil
     * en caso de estar autenticado.
     * Forma parte de la gestión de recuperación de contraseñas de Laravel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ok = null;
        if ($this->auth->check()) {
            $ok = redirect('/perfil');
        }else{
            $ok = $next($request);
        }

        return $ok;
    }
}
