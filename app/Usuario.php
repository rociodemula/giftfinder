<?php

namespace Giftfinder;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Giftfinder\Usuario_producto;

class Usuario extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * @var string
     */
    protected $primaryKey = 'cod_usuario';

    /**
     * @return mixed
     */
    public function getAuthPassword() {
        return $this->clave;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre_usuario', 'localizacion', 'latitud', 'longitud', 'email', 'clave', 'telefono', 'movil', 'whatsapp', 'geolocalizacion', 'acepto'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['clave', 'remember_token'];

    public function peticiones()
    {
        $this->hasMany('Giftfinder\Peticion');
    }

    public function productos()
    {
        $this->hasMany('Giftfinder\Usuario_producto');
    }

    /**
     * @param $data
     * @return static
     */
    public static function crear($data){

        $data['acepto'] = (isset($data['acepto']) && $data['acepto'] == 'on') ? 1 : 0;
        $data['whatsapp'] = (isset($data['whatsapp']) && $data['whatsapp'] == 'on') ? 1 : 0;
        $data['geolocalizacion'] = (isset($data['geolocalizacion']) && $data['geolocalizacion'] == 'on') ? 1 : 0;

        $usuario = Usuario::create([
            'nombre_usuario' => $data['nombre_usuario'],
            'clave' => bcrypt($data['clave']),
            'localizacion' => $data['localizacion'],
            'latitud' => $data['latitud'],
            'longitud' => $data['longitud'],
            'email' => $data['email'],
            'telefono' => $data['telefono'],
            'movil' => $data['movil'],
            'whatsapp' => $data['whatsapp'],
            'geolocalizacion' => $data['geolocalizacion'],
            'acepto' => $data['acepto']
        ]);

        if ($data['producto'] != 'Producto'){
            Usuario_producto::crear($usuario->cod_usuario, $data['producto']);
        }
        return $usuario;
    }

    public static function modificar($request, $id){
        $ok = false;
        $usuario = Usuario::find($id);
        if (Usuario::validarModificacion($request)){
            $usuario->nombre_usuario = $request->nombre_usuario;
            //Necesario para que no grabe el campo clave en caso de estar vacío.
            //Para las modificaciones no se ve oportuno ponerlo obligatorio, así que, en caso de
            //que el usuario no teclee nada, no se actualiza este campo en el save.
            if (isset($request->clave) && $request->clave != ''){
                $usuario->clave = bcrypt($request->clave);
            }
            $usuario->localizacion = $request->localizacion;
            $usuario->latitud = $request->latitud;
            $usuario->longitud = $request->longitud;
            $usuario->email = $request->email;
            $usuario->telefono = $request->telefono;
            $usuario->movil = $request->movil;
            $usuario->whatsapp = ($request->whatsapp) ? 1 : 0;
            $usuario->geolocalizacion = ($request->geolocalizacion) ? 1 : 0;

            $usuario->save();

            if(isset($request->productoCompartido)){
                foreach ($request->productoCompartido as $clave => $producto){
                    if ($producto != 'Producto'){
                        Usuario_producto::modificar($usuario->cod_usuario, Usuario_producto::getCodProducto($producto), $clave);
                    }else{
                        Usuario_producto::borrarPorId($clave);
                    }
                }
            }

            if(isset($request->producto)){
                foreach($request->producto as $producto){
                    if(($producto != 'Producto') && !Usuario_producto::buscar($usuario->cod_usuario, $producto)){
                        Usuario_producto::crear($usuario->cod_usuario, $producto);
                    }
                }

            }


            $ok = true;
        }
        //TODO resolver tema de rollback en caso de que no se pueda crear el producto.
        return $ok;
    }

    public static function modificarAdmin($request, $id){
        $update = array();
        if($request->clave != $request->clave_old){
            //Si la clave ha cambiado, la volvemos a encriptar antes de grabarla
            $update = ['clave' => bcrypt($request->clave)];
        }
        //Si la clave no se ha alterado, no la actualizamos, así preservamos la clave encriptada original del usuario
        $update = array_merge($update, [
            'nombre_usuario' => $request->nombre_usuario,
            'localizacion' => $request->localizacion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'movil' => $request->movil,
            'whatsapp' => ($request->whatsapp) ? 1 : 0,
            'geolocalizacion' => ($request->geolocalizacion) ? 1 : 0,
        ]);
        return DB::table('usuarios')
            ->where('cod_usuario', '=', $id)
            ->update($update);
    }


    public static function validarAlta($data){
        return Validator::make($data, [
            'nombre_usuario' => 'required|max:30|unique:usuarios',
            'clave' => 'required|min:6',
            'password_confirmation' => 'required|same:clave',
            'localizacion' => 'max:60',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'email' => 'required|email|max:80',
            'telefono' => 'numeric|digits:9',
            'movil' => 'numeric|digits:9',
            'acepto' => 'required'
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    public static function validarModificacion($request) {

        $data = array();
        $rules = array();
        if(auth()->user()->nombre_usuario != $request->nombre_usuario){
            $data = ['nombre_usuario' => $request->nombre_usuario];
            $rules = ['nombre_usuario' => 'required|max:30|unique:usuarios'];
        }
        $rest = array(
            'clave' => $request->clave,
            'password_confirmation' => $request->password_confirmation,
            'localizacion' => $request->localizacion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'movil' => $request->movil,
            'whatsapp' => $request->whatsapp,
            'geolocalizacion' => $request->geolocalizacion
        );
        //Para las modificaciones no ponemos obligatoria la password, y si no se modifica, se dejará la existente.
        $restRules = array(
            'clave' => 'min:6',
            'password_confirmation' => 'same:clave',
            'localizacion' => 'max:60',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'email' => 'required|email|max:80',
            'telefono' => 'numeric|digits:9',
            'movil' => 'numeric|digits:9'
        );
        $data = array_merge($data, $rest);
        $rules = array_merge($rules, $restRules);

        return \Validator::make($data, $rules);
    }

    public static function validarAdmin($request){

        $data = array();
        $rules = array();
        if($request->nombre_usuario != $request->nombre_usuario_old){
            $data = ['nombre_usuario' => $request->nombre_usuario];
            $rules = ['nombre_usuario' => 'required|max:30|unique:usuarios'];
        }
        $rest = array(
            'clave' => $request->clave,
            'localizacion' => $request->localizacion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'movil' => $request->movil,
            'whatsapp' => $request->whatsapp,
            'geolocalizacion' => $request->geolocalizacion
        );
        $restRules = array(
            'clave' => 'required|min:6',
            'localizacion' => 'max:60',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'email' => 'required|email|max:80',
            'telefono' => 'numeric|digits:9',
            'movil' => 'numeric|digits:9'
        );
        $data = array_merge($data, $rest);
        $rules = array_merge($rules, $restRules);

        return \Validator::make($data, $rules);
    }

}
