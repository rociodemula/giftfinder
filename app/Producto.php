<?php
/**
 * Created by PhpStorm.
 * User: rocio
 * Date: 24/11/15
 * Time: 15:28
 */

namespace Giftfinder;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Clase Producto que gestiona los productos de la aplicación. Se ncluyen métodos
 * para dar altas de registro, modificaciones y validar los datos antes de su grabación.
 * @package Giftfinder
 */
class Producto extends Model
{

    //SOBREESCRITURA DE VARIABLES DE CLASE:

    protected $table = 'productos'; //Nombre de tabla.

    protected $primaryKey = 'cod_producto'; //Nombre de clave primaria.

    //Cada campo que vaya a ser grabado debe estar en este array.
    protected $fillable = ['subcategoria', 'nombre_producto', 'descripcion', 'foto_producto', 'link_articulo'];

    /**
     * Método que establece la relación de uno a muchos entre Producto y el modelo
     * Usuario_producto.
     */
    public function usuarios()

    {
        $this->hasMany('Giftfinder\Usuario_producto');
    }

    /**
     * Método que crea un registro nuevo en la tabla, con los datos contenidos en un array
     * pasado como parámetro. Se aprovecha el método create de la clase Model, que devuelve
     * el elemento creado.
     *
     * @param $data
     * @return static
     */
    public static function crear($data){
        return Producto::create([
            'subcategoria' => $data['subcategoria'],
            'nombre_producto' => $data['nombre_producto'],
            'descripcion' => $data['descripcion'],
            'foto_producto' => $data['foto_producto'],
            'link_articulo' => $data['link_articulo'],
        ]);
    }

    /**
     * Método que modifica un registo existente a partir de una instancia de la clase Request
     * procedente de un formulario de entrada y el id (clave primaria) del registro a modificar.
     * Usa el método table de la clase DB.
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public static function modificar($request, $id){
        return DB::table('productos')
            ->where('cod_producto', '=', $id)
            ->update([
                'subcategoria' => $request->subcategoria,
                'nombre_producto' => $request->nombre_producto,
                'descripcion' => $request->descripcion,
                'foto_producto' => $request->foto_producto,
                'link_articulo' => $request->link_articulo,
            ]);
    }


    /**
     * Método que valida un conjunto de datos contenidos en un objeto Request procedente de un
     * formulario y que se pasan como parámetro. Se aprovecha el método make de Validator y
     * retorna el resultado del mismo.
     *
     * @param $request
     * @return \Illuminate\Validation\Validator
     */
    public static function validar($request){
        return \Validator::make($request->all(), [
            'nombre_producto' => 'required|max:30',
            'subcategoria' => 'required|numeric|exists:subcategorias,cod_subcategoria',
            'descripcion' => 'max:255',
            'foto_producto' => 'max:255',
            'link_articulo' => 'max:255',
        ]);

    }
}