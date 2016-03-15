<?php

namespace Giftfinder\Http\Controllers;

use Giftfinder\Usuario_producto;
use Illuminate\Http\Request;
use Giftfinder\Categoria;
use Giftfinder\Subcategoria;
use Giftfinder\Producto;
use Giftfinder\Usuario;
use Giftfinder\Http\Requests;
use Giftfinder\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Contructor de la clase, que se encarga de filtrar a través del middleware
     * que garantiza que ningún usuario no logado pueda visualiar la página, o
     * recibir un mensaje de error inapropiado.
     *
     * En lugar de eso, se redirigirá directamente a la pantalla de login, llevandole
     * a la página de perfil una vez identificado.
     */
    public function __construct()
    {
        // Aplica un filtro a través de un middleware.
        // No permite entrar en la página si no estamos logados.
        $this->middleware('auth');
    }
    /**
     * Gestiona la visualización de la vista correspondiente a la petición post
     * tras haber modificado el perfil de usuario.
     *
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        $ok = null;
        //COMPROBAR SI SE HA SOLICITADO LA BAJA ANTES DE HACER NADA MÁS:
        //==============================================================
        //En caso de que el usuario haya marcado el check de eliminar perfil
        //redirigiremos a la url que gestionará la baja de este usuario.
        if (\Input::has('eliminar')){

            //Lo primero es destruir el usuario logado.
            $baja = Usuario::destroy(auth()->user()->cod_usuario);

            //Redirigimos el flujo del programa a la url prevista para llevar al usuario
            //directamente a la página de bienvenida, con un pequeño mensaje indicando que su
            //perfil ha sido eliminado, ya que a partir de este instante solo podrá
            //acceder a las url permitidas para invitados:
            $ok = redirect('/baja/' . $baja);

        }else{

            //Volcamos los datos del request en una variable:
            $request = \Request::instance();

            //Validamos el formulario en servidor, con el validador previsto en el modelo:
            $validacion = Usuario::validarModificacion($request);
            if($validacion->fails()){
                //Si la validación falla, comunicamos devolveremos la ristra de errores para que la vista los
                //interprete y vizualice en su lugar.
                $ok = redirect()->back()->withInput()->withErrors($validacion->errors());
            }elseif(Usuario::modificar($request, auth()->user()->cod_usuario)){
                //Se añade el registro de la tabla usuarios, para poder refrescarlo de forma correcta en la vista. Si no lo
                //hacemos así, los campos del perfil de usuarios, no se actualizan en la sesión tras el update en todos los casos, solo
                //si no modificamos los productos ofrecidos. Este bug se ha resuelto completamente con esta técnica, ya que no
                // se recupera ningún dato del usuario de sesión, salvo el código, el esto procede de la base de datos recién
                //actualizada.
                $ok = view('profile', [
                    'exito' => true,
                    'categoria' => Categoria::all(),
                    'subcategoria' => Subcategoria::all(),
                    'producto' => Producto::all(),
                    'usuario' => Usuario::where('cod_usuario', auth()->user()->cod_usuario)->first(),
                    'compartido' => Usuario_producto::where('usuario', auth()->user()->cod_usuario)->get() ]);
            }else{
                //Si ha habido algún otro error (por ejemplo, de acceso a base de datos), alimentamos la vista de forma
                //que se muestre un mensaje genérico de que la operación no se ha completado de forma exitosa:
                $ok = view('profile', [
                    'exito' => false,
                    'categoria' => Categoria::all(),
                    'subcategoria' => Subcategoria::all(),
                    'producto' => Producto::all(),
                    'usuario' => Usuario::where('cod_usuario', auth()->user()->cod_usuario)->first(),
                    'compartido' => Usuario_producto::where('usuario', auth()->user()->cod_usuario)->get() ]);
            }
        }
        //Retornamos la variable $ok, que guarda la alimentación para la vista, independientemente del resultado.
        return $ok;
    }


    /**
     * Gestiona la visualización del formulario en caso de que se acceda a él por una llamada get
     * correspondiente al usuario entrando en el perfil por primera vez.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        //Alimentamos la vista de forma básica, con todos los datos que necesitamos para volcar los
        //campos del perfil de usuario.
        return view('profile', [
            'categoria' => Categoria::all(),
            'subcategoria' => Subcategoria::all(),
            'producto' => Producto::all(),
            'usuario' => Usuario::where('cod_usuario', auth()->user()->cod_usuario)->first(),
            'compartido' => Usuario_producto::where('usuario', auth()->user()->cod_usuario)->get()
        ]);
    }
}
