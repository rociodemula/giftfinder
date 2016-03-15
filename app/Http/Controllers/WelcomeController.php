<?php

namespace Giftfinder\Http\Controllers;


use Giftfinder\Producto;

class WelcomeController extends Controller
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

    /*
     * Esta vista no está restringida a un grupo de usuarios concreto, con lo que no
     * necesitamos declarar un contructor con un filtro.
     */

    /**
     * Visualiza la página de bienvenida, con los productos de la base de datos para la
     * sección de 'Productos destacados'.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //Alimentamos la vista con los productos a mostrar en la página de bienvenida:
        return view('welcome', ['producto' => Producto::all()]);
    }

    /**
     * Visualiza la página de bienvenida y la alimenta adecuadamente tras una baja
     * de usuario, evitando que el usuario sepa qué acaba de ocurrir mediante un
     * mensaje informativo de que ya no tiene perfil disponible en la plataforma.
     *
     * @param $baja -  Resultado de la baja del usuario trasladado a la vista.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($baja){
        //Pasando el resultado guardado en $baja que hemos obtenido del borrado del
        //registro en la basede datos, sabremos en la vista si el mensaje que hemos
        //de transmitir es de éxito, o no.
        //También tendremos que alimentar la vista de forma mínima, como en el index,
        //con los productos que queremos mistrar en la página de bienvenida.
        return view('welcome', [
            'baja' => $baja,
            'producto' => Producto::all()
        ]);
    }

}
