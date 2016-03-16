<?php
/**
 * Created by PhpStorm.
 * User: rocio
 * Date: 24/11/15
 * Time: 15:21
 */

namespace Giftfinder;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * Clase Peticion que gestiona las peticiones hechas por los usuarios al administrador
 * del sitio.
 * Contiene los métodos de la clase para altas, modificaciones y validación de datos,
 * personalizados a partir de los estándares de la clase Model.
 *
 * @package Giftfinder
 */
class Peticion extends Model
{
    //SOBREESCRITURA DE VARIABLES DE CLASE:

    protected $table = 'peticiones'; // Nombre de la tabla en la base de datos.

    protected $primary_key = 'cod_peticion'; //Nombre de la clave primaria (id de la tabla).

    //Cada campo que vaya a ser grabado debe estar en este array.
    protected $fillable = ['email_respuesta', 'asunto', 'mensaje', 'usuario'];

    /**
     * Método para dar un registro de alta en la tabla. Se aprovecha el método create de la
     * clase Model. Se usa el objeto Request y el id del usuario relacionado con la
     * petición coo parámetros para la creación del registro.
     *
     * @param $request
     * @param $id
     * @return static
     */
    public static function alta($request, $id){
        return Peticion::create([
            'email_respuesta' => $request->email_respuesta,
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'usuario' => $id
        ]);
    }

    /**
     * Método para modificar un registro ya existente en la tabla Peticiones. Se usa como
     * entrada un objeto Request y el id de la petición modificada.
     * Se usa el método table de la clase DB.
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public static function modificar($request, $id){
        return DB::table('peticiones')
            ->where('cod_peticion', '=', $id)
            ->update([
                'email_respuesta' => $request->email_respuesta,
                'asunto' => $request->asunto,
                'mensaje' => $request->mensaje,
                'usuario' => $request->usuario,
            ]);
    }

    /**
     * Método para validar un objeto request acorde a las exigencias de la clase.
     * Se usa el método make de la clase Validator, para poder comparar los datos del
     * request, con las reglas de validación pertinentes.
     *
     * @param $request
     * @return \Illuminate\Validation\Validator
     */
    public static function validar($request){
        //Retornamos el resultado de la validación:
        return \Validator::make($request->all(), [
            'email_respuesta' => 'required|email|max:80',
            'asunto'=> 'max:50',
            'mensaje' => 'required|max:255'
        ]);
    }
}