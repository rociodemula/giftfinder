<?php

namespace Giftfinder\Http\Controllers\Auth;

use Giftfinder\User;
use Validator;
use Giftfinder\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    private $redirectTo = '/home';
    /**
     * Incluido como medida de seguridad.
     * Por defecto, el sistema utiliza el valor 5
     */
    private $maxLoginAttempts = 10;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Aplica un filtro a través de un middleware. El filtro lo que hará es
        // aplicarse siempre que no se use la llamada a 'getLogout'.
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre_usuario' => 'required|max:255|unique:users',
            'latitud' => 'required|max:255',
            'longitud' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'clave' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'nombre_usuario' => $data['nombre_usuario'],
            'latitud' => $data['latitud'],
            'longitud' => $data['longitud'],
            'email' => $data['email'],
            'clave' => bcrypt($data['clave']),
        ]);
    }
}
