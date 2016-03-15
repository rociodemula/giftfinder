<?php

namespace Giftfinder\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

class EncryptCookies extends BaseEncrypter
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    /*
     * No se modifica la gestión de cookies de Laravel
     * TODO revisar política de cookies.
     */
    protected $except = [
        //
    ];
}
