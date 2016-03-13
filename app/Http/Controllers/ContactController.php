<?php

namespace Giftfinder\Http\Controllers;

use Giftfinder\Peticion;
use Illuminate\Http\Request;

use Giftfinder\Http\Requests;
use Giftfinder\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Constructor de la clase
     */
    public function __construct()
    {
        // Aplica un filtro a través de un middleware.
        // No permite entrar en la página Contactos si no estamos logados.
        $this->middleware('auth');
    }
    /**
     * Visualiza la página tras la grabación de la petición y vuelca los
     * mansajes de error en caso de que existan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Variable para retornar los datos resultantes de la gestión del formulario
        $resultado = null;

        //Volcamos los datos del formulario en una variable y usamos el validador de la
        //clase para validar los datos.
        $request = \Request::instance();
        $validacion = Peticion::validar($request);

        if($validacion->fails()){

            //Comunicación de errores en caso de que no esté correcto el formulario
            $resultado = redirect()->back()->withInput()->withErrors($validacion->errors());

        }elseif($this->store($request, auth()->user()->cod_usuario)){

            //Si la validación es buena, y la grabación se realiza bien, enviamos un correo al
            //administrador del sitio como aviso de que tiene unapetición nueva.
            $asunto = 'Nuevo mensaje de usuario Giftfinder';
            $mensaje = '<br/>Email usuario: '.$request->email_respuesta
                .'<br/>Asunto: '.$request->asunto
                .'<br/>Mensaje: '.$request->mensaje;

            //Si no indicamos esta cabecera, no inerpretará el código html y no saldrán
            //los acentos ni las ñ correctamente:
            $cabecera= 'Content-type: text/html; charset=utf-8';

            //En vez de rociodemula@demosdata.com, se podría enviar a un buzón especifico del
            //sitio, o al correo de todos los administradores de la tabla Usuarios.
            $correo = mail('rociodemula@demosdata.com', $asunto, $mensaje, $cabecera);

            //Devolvemos el resultado de éxito y el resultado del envío de correo a la vista.
            $resultado = view('contact', [
                'exito' => true,
                'correo' => $correo
            ]);

        }else{

            //Si ha fallado la grabación en la tabla Peticiones, preparamos el resultado para
            //que la vista lance el mensaje de error.
            $resultado = view('contact', [
                'exito' => false,
                'correo' => false
            ]);
        }
        return $resultado; //El resultado se devuelve de igual forma.
    }


    /**
     * Almacena la petición en la tabla Peticiones usando el método del modelo Peticion.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param array $data
     */
    public function store(Request $request, $id)
    {
        return Peticion::alta($request, $id);
    }


    /**
     * Función que nos edita elf formulario de contacto
     * al entrar en la página por primera vez.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //No enviamos ningún dato adicional, para evitar mensajes de error en la vista.
        //Con esta combinación, la vista no volcará nada en el contenedor de errores.
        return view('contact');
    }

}
