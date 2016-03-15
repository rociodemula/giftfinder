<?php

namespace Giftfinder\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * (Middlewares globales para sesiones gestionadas por Laravel)
     *
     * @var array
     */
    //Middlewares generados para sesiones gestionadas por Laravel:
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Giftfinder\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Giftfinder\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     * (Middlewares de enrutamiento desarrollados en la aplicación)
     *
     * @var array
     */
    //Para autorización a usuarios autenticados, invitados y administradores.
    //(auth.basic es el enrutador básico de gestión de autenticación de Laravel, lo dejamos conmentado auqnue
    // no se usa en esta aplicación)
    protected $routeMiddleware = [
        'auth' => \Giftfinder\Http\Middleware\Authenticate::class,
        //'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \Giftfinder\Http\Middleware\RedirectIfAuthenticated::class,
        'admin' => \Giftfinder\Http\Middleware\AdminControl::class,
    ];

}
