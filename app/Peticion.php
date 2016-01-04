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

class Peticion extends Model
{
    protected $table = 'peticiones';

    protected $fillable = ['email_respuesta', 'asunto', 'mensaje', 'usuario'];

    public static function alta($request, $id){
        if (Peticion::validar($request)){
            return Peticion::create([
                'email_respuesta' => $request->email_respuesta,
                'asunto' => $request->asunto,
                'mensaje' => $request->mensaje,
                'usuario' => $id
            ]);
        }
    }
    public static function validar($request){
        $data = array(
            'email_respuesta' => $request->email_respuesta,
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje
        );
        return Validator::make($data, [
            'email_respuesta' => 'email|max:80',
            'asunto'=> 'max:50',
            'mensaje' => 'required|max:255'
        ]);
    }
}