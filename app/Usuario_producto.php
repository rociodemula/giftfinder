<?php

namespace Giftfinder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Clase Usuario_producto que contiene los productos compartidos por los usuarios.
 * Contiene métodos para las diferentes acciones necesarias para la gestión de la
 * clase, que sustituyen a los métodos estándar de la clase Model para crear, modificar
 * y validar los datos.
 *
 * @package Giftfinder
 */
class Usuario_producto extends Model
{

    //SOBREESCRITURA DE VARIABLES DE CLASE:
    protected $table = 'usuarios_productos'; //Nombre de la tabla en la base de datos.

    //Cada campo que vaya a ser grabado debe estar en este array.
    protected $fillable = ['usuario', 'producto'];

    protected $primaryKey = 'codigo'; //Nombre de la clave primaria (id de la tabla).

    /**
     * Método que crea un registro nuevo en la tabla, a a partir del nombre de producto y el código de
     * usuario pasados como parámetros. Se aprovecha el método create de la clase Model, que devuelve
     * el elemento creado.
     *
     * @param $cod_usuario
     * @param $nombre_producto
     * @return static
     */
    public static function crear($cod_usuario, $nombre_producto){

        //Obtenemos primero el código del producto, con un método específico de la clase:
        $codProducto = Usuario_producto::getCodProducto($nombre_producto);

        return Usuario_producto::create([
            'usuario' => $cod_usuario,
            'producto' => $codProducto
        ]);
    }

    /**
     * Método que busca si existe ya un registro previo con esa combinación de usuario/producto, para
     * evitar grabar registros repetidos con la misma información.
     *
     * @param $cod_usuario
     * @param $nombre_producto
     * @return mixed
     */
    public static function buscar($cod_usuario, $nombre_producto){

        //Obtenemos primero el código del producto, con un método específico de la clase:
        $codProducto = Usuario_producto::getCodProducto($nombre_producto);

        //Retornamos los posibles registros encontrados con esa combinación producto_usuario.
        return DB::table('usuarios_productos')
            ->where('usuario', '=', $cod_usuario)
            ->where('producto', '=', $codProducto)
            ->get();
    }

    /**
     * Método que modifica un registo existente a partir del id de usuario, el de producto y el id
     * del registro concreto, pudiendo modificar un producto compartido concreto  la base de datos, y
     * sobreescribirlo con otra información. Usa el método table de la clase DB.
     *
     * @param $usuario
     * @param $producto
     * @param $id
     * @return mixed
     */
    public static function modificar($usuario, $producto, $id){
        return DB::table('usuarios_productos')
            ->where('codigo', '=', $id)
            ->update([
                'usuario' => $usuario,
                'producto' => $producto,
            ]);
    }

    /**
     * Método que gestiona la modificación de un registro de Usuarios_productos desde el panel
     * de administración del sitio. Se recibe directamente un objeto de clase Request en lugar de
     * campos sueltos. Por lo demás el similar a modificar().
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public static function modificarAdmin($request, $id){
        return DB::table('usuarios_productos')
            ->where('codigo', '=', $id)
            ->update([
                'usuario' => $request->usuario,
                'producto' => $request->producto,
            ]);
    }

    /**
     * Método para borrar todos los registro de la tabla Usuarios_productos que
     * tengan un usuario y producto cncreto. en caso de existir más de uno, se
     * borrarían todos.
     *
     * @param $cod_usuario
     * @param $nombre_producto
     * @return mixed
     */
    public static function borrar($cod_usuario, $nombre_producto){
        $codProducto = Usuario_producto::getCodProducto($nombre_producto);
        return DB::table('usuarios_productos')
            ->where('usuario', '=', $cod_usuario)
            ->where('producto', '=', $codProducto)
            ->delete();
    }

    /**
     * Método que borra un registro concreto de la tabla Usuario_productos a partir
     * del id del registro, no del contenido de usuario/producto.
     *
     * @param $id
     * @return mixed
     */
    public static function borrarPorId($id){
        return DB::table('usuarios_productos')
            ->where('codigo', '=', $id)
            ->delete();;
    }

    /**
     * Método que obtiene el código de producto correspondiente a un registro de la tabla
     * Productos, a partir del nombre del mismo que se le pasa como parámetro.
     *
     * @param $nombre_producto
     * @return mixed
     */
    public static function getCodProducto($nombre_producto){
        return DB::table('productos')
            ->where('nombre_producto', '=', $nombre_producto )
            ->value('cod_producto');
    }

    /**
     * Método para validar el contenido del objeto Request procedente de un formulario,
     * con arreglo a las normas específicas para la tabla usuario_producto.
     *
     * @param $request
     * @return \Illuminate\Validation\Validator
     */
    public static function validar($request){
        return \Validator::make($request->all(), [
            'usuario' => 'required|numeric|exists:usuarios,cod_usuario',
            'producto' => 'required|numeric|exists:productos,cod_producto',
        ]);
    }
}
