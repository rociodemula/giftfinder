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

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $primaryKey = 'cod_categoria';

    protected $fillable = ['nombre_categoria'];

    public function subcategorias()

    {
        $this->hasMany('Giftfinder\Subcategoria');
    }

    public static function crear($data){
        return Categoria::create([
            'nombre_categoria' => $data['nombre_categoria'],
        ]);
    }

    public static function modificar($request, $id){
        return DB::table('categorias')
            ->where('cod_categoria', '=', $id)
            ->update(['nombre_categoria' => $request->nombre_categoria]);
    }

    public static function borrar($id){
        return Categoria::destroy($id);
    }

    public static function validar($request){
        return \Validator::make($request->all(), [
            'nombre_categoria' => 'required|max:30',
        ]);
    }
}