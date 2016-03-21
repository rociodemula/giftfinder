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

/**
 * Clase Usuario que gestiona los registros de los usuarios de la aplicación.
 * Contiene los métodos de la clase para altas, modificaciones y validación de datos,
 * personalizados a partir de los estándares de la clase Model.
 *
 * Practicamente toda la funcionalidad respecto a autenticación de usuarios y recuperación
 * de contraseñas, proviene de la implementación de las 3 inerfaces para autenticar (gestión
 * de login), autorizar (gestión de permisos) y resetear claves de usuarios.
 *
 * @package Giftfinder
 */
class Usuario extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;


    //SOBREESCRITURA DE VARIABLES DE CLASE:

    protected $table = 'usuarios'; //Nombre de tabla.

    protected $primaryKey = 'cod_usuario'; // Clave primaria de la tabla.

    //Cada campo que vaya a ser grabado debe estar en este array.
    protected $fillable = ['nombre_usuario', 'localizacion', 'latitud', 'longitud', 'email', 'password', 'telefono', 'movil', 'whatsapp', 'geolocalizacion', 'acepto'];

    //Estos campos no se incluirán en los archivos json correspondientes:
    protected $hidden = ['password', 'remember_token'];

    /**
     * Método que retorna la clave de autorización de la clase.
     *
     * @return mixed
     */
    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * Método que establece la relación uno a muchos con el modelo Peticion.
     */
    public function peticiones()
    {
        $this->hasMany('Giftfinder\Peticion');
    }

    /**
     * Método que establece la relación uno a muchos con el modelo Usuario_producto.
     */
    public function productos()
    {
        $this->hasMany('Giftfinder\Usuario_producto');
    }

    /**
     * Método que crea un registro nuevo en la tabla Usuarios. En caso de que el usuario haya
     * definido algun producto a compartir, se graba también en la tqabla Usuarios_productos.
     *
     * @param $data
     * @return static
     */

    public static function crear($data){

        //Los 3 campos del formulario que consisten en un check, tenemos que adaptarlo para
        //grabarlos en la base de datos con tipo de dato binario, 1 para los que tengan valor
        //'on' en el formulario, 0 para los que no.
        $data['acepto'] = (isset($data['acepto']) && $data['acepto'] == 'on') ? 1 : 0;
        $data['whatsapp'] = (isset($data['whatsapp']) && $data['whatsapp'] == 'on') ? 1 : 0;
        $data['geolocalizacion'] = (isset($data['geolocalizacion']) && $data['geolocalizacion'] == 'on') ? 1 : 0;

        //Creamos el usuario con ayuda del método create de Model, pasando como parámetros
        //todos los datos contenidos en el array recibido como parámetro:
        $usuario = Usuario::create([
            'nombre_usuario' => $data['nombre_usuario'],
            'password' => bcrypt($data['password']),
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
        //En caso de que exista algún producto entre los datos recogidos, tenemos que grabar
        //un registro en Usuarios_registros por cada producto compartido:
        if(isset($data['producto'])){
            foreach($data['producto'] as $producto){
                //Usamos la variable almacenada en $usuario para relacionar el producto con
                //el usuario que lo comparte:
                if(($producto != 'Producto') && !Usuario_producto::buscar($usuario->cod_usuario, $producto)){
                    //Solo grabamos el producto compartido en caso de que no exista ya, son eso
                    //evitamos repetir productos compartidos en caso de que el usuario los
                    //duplique en el formulario.
                    Usuario_producto::crear($usuario->cod_usuario, $producto);
                }
            }
        }
        //Nota: Podría contemplarse un rollback para el caso de que nos e pudiera completar el
        //grabado de productos, pero al estar el formulario abierto para grabar 1, varios o ningún
        //producto compartido, es comlpicado determinar en qué cirsunscancias sería necesario
        //establecer la necesidad de un rollback.

        //Retornamos la instancia de Usuario creada, como es normal en el método create.
        return $usuario;
    }

    /**
     * Método que modifica un registro ya existente a partir de los datos del request pasados
     * por post desde el formulario y el id del usuario que modifica su perfil.
     *
     * @param $request
     * @param $id
     * @return bool
     */
    public static function modificar($request, $id){

        //Buscamos y volcamos los datos del usuario logado para modificarlos:
        $usuario = Usuario::find($id);
        //Vamos sobreescribiendo en esta instancia todos los campos con los procedentes
        // del request:
        $usuario->nombre_usuario = $request->nombre_usuario;
        //La password puede modificarse o no. En caso de que el usuario ay tecleado una
        //password nueva, la encriptamos y la guardamos en la instancia, en caso de
        //que el usuario no teclee nada, no se actualiza este campo en el save.
        if (isset($request->password) && $request->password != ''){
            $usuario->password = bcrypt($request->password);
        }
        //Grabamos en la instancia el resto de los datos:
        $usuario->localizacion = $request->localizacion;
        $usuario->latitud = $request->latitud;
        $usuario->longitud = $request->longitud;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->movil = $request->movil;
        $usuario->whatsapp = ($request->whatsapp) ? 1 : 0;
        $usuario->geolocalizacion = ($request->geolocalizacion) ? 1 : 0;

        //Trasladamos el contenido de la instancia usuario a su registro en la base de datos
        //con ayuda del método save() heredado de Model.
        $ok = $usuario->save();

        //En caso de existir productos compartidos previos, comprobamos si se han borrado o no, y
        //los mantenemos, modificamos o borramos, según el valos del campo $producto.
        //La clave a buscar en la tabla, nos hemos encargado de alimentarla desde la vista
        //con el campo $clave
        if(isset($request->productoCompartido)){
            foreach ($request->productoCompartido as $clave => $producto){
                if ($producto != 'Producto'){
                    //Si el valor del campo es diferente a Producto, cogemos el índice correspondiente y
                    //modificamos ese mismo registro a lo que haya puesto de nuevo el usuario.
                    Usuario_producto::modificar($usuario->cod_usuario, Usuario_producto::getCodProducto($producto), $clave);
                }else{
                    //Si se ha eliminado el producto compartido de la vista, debe contener 'Producto' en el
                    //valor del campo, con lo que borramos el registro correspondiente a ese id:
                    Usuario_producto::borrarPorId($clave);
                }
            }
        }

        //Los productos nuevos que se quieran compartir, se habrán recibido en el campo producto,
        //en un array con tantas posiciones como artículos nuevos se hayan añadido:
        if(isset($request->producto)){
            foreach($request->producto as $producto){
                //Siguiendo el mismo algoritmo de altas, por cada producto nuevo a compartir, creamos
                //un registro en la tabla Usuario_producto:
                if(($producto != 'Producto') && !Usuario_producto::buscar($usuario->cod_usuario, $producto)){
                    Usuario_producto::crear($usuario->cod_usuario, $producto);
                }
            }

        }

        //Nota: Podría contemplarse un rollback para el caso de que nos e pudiera completar el
        //grabado de productos, pero al estar el formulario abierto para grabar 1, varios o ningún
        //producto compartido, es comlpicado determinar en qué cirsunscancias sería necesario
        //establecer la necesidad de un rollback.

        return $ok; //Devolvemos el resultado de la modificación.
    }

    /**
     * Método específico que modifica un usuario desde el panel de administración del sitio.
     * Es radicalmente diferente del usado para modificación del propio perfil del usuario logado,
     * ya que en este caso, no se puede usar la información de sesión para averiguar qué registro
     * modificar, sino que tenemos que inyectar esa información desde la vista, y gestionarla
     * adecuadamente en el modelo.
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public static function modificarAdmin($request, $id){
        $update = array(); //Array para incluir los datos modificados

        //La contraseña puede modificarse, o no. En caso de que no sea la misma que
        //la inyectada desde los datos iniciales, la deberemos encriptar antes de
        //grabarla en la tabla:
        if($request->password != $request->password_old){
            //Si la clave ha cambiado, la volvemos a encriptar antes de grabarla
            $update = ['password' => bcrypt($request->password)];
        }
        //Si la clave no se ha alterado, no la actualizamos, así preservamos la clave encriptada
        //original del usuario. De cualquier modo, hacemos un merge entre ambos arrays. En caso de
        //no haber modificación de password, el primero estará vacío:
        $update = array_merge($update, [
            'nombre_usuario' => $request->nombre_usuario,
            'localizacion' => $request->localizacion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'movil' => $request->movil,
            'whatsapp' => ($request->whatsapp) ? 1 : 0, //Importante recordar que los checks hay que 'traducirlos' a 0 y 1
            'geolocalizacion' => ($request->geolocalizacion) ? 1 : 0,
            'acepto' => 1, //En el caso de acepto, consideramos que al ser una modificación, ya se ha aceptado la política previamente.
        ]);
        //Hacemos un update en el id del usuario alimentado desde la vista y devolvemos el resultado:
        return DB::table('usuarios')
            ->where('cod_usuario', '=', $id)
            ->update($update);
    }


    /**
     * Método que valida un alta de usuario a partir de un array con todos los datos contenidos en el
     * formulario. Se apoya en el método make de Validator, que devuelve el estado de la validación.
     *
     * @param $data
     * @return mixed
     */
    public static function validarAlta($data){
        return Validator::make($data, [
            'nombre_usuario' => 'required|max:30|unique:usuarios',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'localizacion' => 'max:100',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'email' => 'required|email|max:80|unique:usuarios',
            'telefono' => 'numeric|digits:9',
            'movil' => 'numeric|digits:9'
        ]);
    }

    /**
     * Método que valida una modificación a partir del request. En caso de haber modificado
     * el nombre del usuario, valida que no exista otro igual, en caso de que no se
     * modifique el nombre, no valida este campo, puesto que obviamente existirá.
     * @param $request
     * @return mixed
     */
    public static function validarModificacion($request) {

        //Preparamos un array para las reglas y otro para los datos:
        $data = array();
        $rules = array();

        //Tenemos que considerar aparte los campos con la constraint unique de la base
        //de datos, porque al validar la modificación, darán problamas, al existir ya.
        //Si se ha cambiado el nombre de usuario/email, debemos añadir la regla para que
        //verifique que el nombre/emailnuevo no existe ya en la tabla.
        if(auth()->user()->nombre_usuario != $request->nombre_usuario){
            $data = ['nombre_usuario' => $request->nombre_usuario];
            $rules = ['nombre_usuario' => 'required|max:30|unique:usuarios'];
        }
        if(auth()->user()->email != $request->email){
            $data = array_merge($data, ['email' => $request->email]);
            $rules = array_merge($rules, ['email' => 'required|max:80|unique:usuarios']);
        }
        //Volvamos el resto de datos en su array:
        $rest = array(
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'localizacion' => $request->localizacion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'telefono' => $request->telefono,
            'movil' => $request->movil,
            'whatsapp' => $request->whatsapp,
            'geolocalizacion' => $request->geolocalizacion
        );
        //Volcamos el resto de reglas en su array.
        //Para las modificaciones no ponemos obligatoria la password, y si no se modifica, se dejará la existente.
        $restRules = array(
            'password' => 'min:6',
            'password_confirmation' => 'same:password',
            'localizacion' => 'max:100',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'telefono' => 'numeric|digits:9',
            'movil' => 'numeric|digits:9'
        );
        //Unimos lod arrays provenientes de las diferentes comparativas:
        $data = array_merge($data, $rest);
        $rules = array_merge($rules, $restRules);

        //Validamos y retornamos el resutado.
        return \Validator::make($data, $rules);
    }

    /**
     * Método muy similar a validarModificacion(), pero sin usar los datos de sesión,
     * ya que en el panel de administración hay más de un usuario con posibilidad de
     * ser modificado.
     *
     * @param $request
     * @return \Illuminate\Validation\Validator
     */
    public static function validarAdmin($request){

        //El algoritmo es idéntico al método vaidarModificacion()
        $data = array();
        $rules = array();
        //Salvo por esta comparativa, en la que no se usa la info de sesión:
        if($request->nombre_usuario != $request->nombre_usuario_old){
            $data = ['nombre_usuario' => $request->nombre_usuario];
            $rules = ['nombre_usuario' => 'required|max:30|unique:usuarios'];
        }
        if($request->email != $request->email_old){
            $data = array_merge($data, ['email' => $request->email]);
            $rules = array_merge($rules, ['email' => 'required|max:80|unique:usuarios']);
        }
        $rest = array(
            'password' => $request->password,
            'localizacion' => $request->localizacion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'telefono' => $request->telefono,
            'movil' => $request->movil,
            'whatsapp' => $request->whatsapp,
            'geolocalizacion' => $request->geolocalizacion,
            'acepto' => $request->acepto
        );
        $restRules = array(
            'password' => 'required|min:6',
            'localizacion' => 'max:100',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'telefono' => 'numeric|digits:9',
            'movil' => 'numeric|digits:9',
            'acepto' => 'required|boolean:true',
            'whatsapp' => 'boolean',
            'geolocalizacion' => 'boolean'
        );
        $data = array_merge($data, $rest);
        $rules = array_merge($rules, $restRules);

        return \Validator::make($data, $rules);
    }

}
