<?php
/**
 * Created by PhpStorm.
 * User: rocio
 * Date: 24/11/15
 * Time: 15:24
 */

namespace Giftfinder;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Clase Categoria, que contiene las categorías necesarias para la aplicación.
 * Cada Categoría comprende varias Subcategorías.
 * Contiene métodos para las diferentes acciones necesarias para la gestión de la
 * clase, que sustituyen a los métodos estándar de la clase Model para crear, modificar
 * y validar los datos.
 *
 * @package Giftfinder
 */
class Categoria extends Model
{
    //SOBREESCRITURA DE VARIABLES DE CLASE:

    protected $table = 'categorias'; // Nombre de la tabla en la base de datos.

    protected $primaryKey = 'cod_categoria';//Nombre de la clave primaria (id de la tabla).

    protected $fillable = ['nombre_categoria']; //Cada campo que vaya a ser grabado debe estar en este array.


    /**
     * Método que establece la relación uno a muchos con el modelo Subcategoria.
     */
    public function subcategorias()

    {
        $this->hasMany('Giftfinder\Subcategoria');
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
        return Categoria::create([
            'nombre_categoria' => $data['nombre_categoria'],
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
        return DB::table('categorias')
            ->where('cod_categoria', '=', $id)
            ->update(['nombre_categoria' => $request->nombre_categoria]);
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
            'nombre_categoria' => 'required|max:30',
        ]);
    }
}