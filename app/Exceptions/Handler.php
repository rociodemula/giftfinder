<?php

namespace Giftfinder\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     * (Modificada la original de Laravel para redirigir al usuario tras la
     * pérdida de sesión (token) directamente a la página de login).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
        //Necesitamos redirigir al usuario a la página de login en caso de que
        //su sesión haya caducado (el token se pierde)
        //Esta solución procede del hilo:
        //http://stackoverflow.com/questions/31449434/handling-expired-token-in-laravel
        //Se podría hacer un redirect()->guest('auth/login') o incluso a redirect('/')
        //pero en principio, se ve más oportuna esta solución, que no limita a si eres o no un guest
        //y te invita directamente a que te logues para continuar estando en la misma página
        if ($e instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect('auth/login');
        }

        return parent::render($request, $e);
    }
}
