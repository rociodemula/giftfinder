<?php

namespace Giftfinder\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

    /*
     * No se modifica la gestión de tokens de Laravel.
     */
    protected $except = [
        //
    ];
}
