<?php

namespace Giftfinder\Http\Controllers\Auth;

use Giftfinder\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    //Para cambiar el texto del asunto del mensaje de recuperación de claves:
    protected $subject = 'Link de recuperación de clave';

    /**
     * Create a new password controller instance.
     *
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

/* Se comienza a trabajar en una línea en la que se cambie el nombre de campo password
   por clave, pero genera conflictos con múltiples librerías.
   Esta solución no resulta válida y se abandona por el momento.
   Si no existe necesidad de renombrar el campo, la sobrescritura de este método
   no es necesaria. Se conserva el código del intento por documentar una solución
   no apta.
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'clave' => 'required|min:6',
            'password_confirmation' => 'required|same:clave'
        ]);

        $credentials = $request->only(
            'email', 'clave', 'password_confirmation', 'token'
        );/*
        $my_credentials = ['email' => $credentials['email'],
            'password' => $credentials['clave'],
            'password_confirmation' => $credentials['password_confirmation'],
            'token' => $credentials['token']];*//*

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect($this->redirectPath())->with('status', trans($response));

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }*/

}
