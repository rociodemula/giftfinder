<?php

namespace Giftfinder\Http\Controllers\Auth;

use Giftfinder\Producto;
use Giftfinder\Subcategoria;
use Giftfinder\Categoria;
use Giftfinder\Usuario;
use Validator;
use Giftfinder\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    private $redirectTo = '/';

    // Se cambia por consejo en http://stackoverflow.com/questions/28584531/laravel-5-modify-existing-auth-module-email-to-username
    // pero no parece ser la solución definitiva. Sigue dando problemas y continua buscando el email como loginUsername
    // es necesario sobreescribir varias lineas de código en AuthenticateUser.php postLogin algunas lineas
    // (buscar en clase AuthenticatesAndRegistersUsers  y luego en AuthenticatesUsers)
    protected $loginUsername = 'nombre_usuario';
    protected $username = 'nombre_usuario';
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
        return Usuario::validarAlta($data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Usuario
     */
    protected function create(array $data)
    {
        return Usuario::crear($data);
    }

    public function postLogin(Request $request)
    {
        //Anterior:
        /*$this->validate($request, [
        $this->loginUsername() => 'required', 'clave' => 'required',
        ]);*/
        //Se modifica segun:
        //http://stackoverflow.com/questions/28584531/laravel-5-modify-existing-auth-module-email-to-username

        $this->validate($request, [
            'nombre_usuario' => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        //Anterior:
        //$credentials = $this->getCredentials($request);
        //se sustituye por consejo en:
        //http://stackoverflow.com/questions/28584531/laravel-5-modify-existing-auth-module-email-to-username

        $credentials = $request->only('nombre_usuario', 'password');

        //Para solucionar las limitaciones de Laravel para cambiar el nombre del campo password, y
        //poder acceder a nuestro campo clave en la base de datos, no hay más remedio que renombrar
        //el nombre de la clave del array generado con getCredentials, ya que contendrá el nombre
        //de clave 'clave' en lugar de 'password', que es lo que espera el sistema
        //Se siguen los consejos del siguiente enlace
        // http://stackoverflow.com/questions/26073309/how-to-change-custom-password-field-name-for-laravel-4-and-laravel-5-user-auth
        $my_credentials = ['nombre_usuario' => $credentials['nombre_usuario'], 'password' => $credentials['password']];
        if (Auth::attempt($my_credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }
        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }
    public function getRegister(){
        return view('auth.register', [
            'categoria' => Categoria::all(),
            'subcategoria' => Subcategoria::all(),
            'producto' => Producto::all() ]);
    }

}
