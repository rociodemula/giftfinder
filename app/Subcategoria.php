<?php
/**
 * Created by PhpStorm.
 * User: rocio
 * Date: 24/11/15
 * Time: 15:27
 */

namespace Giftfinder;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subcategoria extends Model
{
    protected $table = 'subcategorias';

    protected $primaryKey = 'cod_subcategoria';

    protected $fillable = ['nombre_subcategoria', 'categoria'];

    public function productos()

    {
        $this->hasMany('Giftfinder\Producto');
    }

    public static function crear($data){
        return Subcategoria::create([
            'nombre_subcategoria' => $data['nombre_subcategoria'],
            'categoria' => $data['categoria'],
        ]);
    }

    public static function modificar($request, $id){
        return DB::table('subcategorias')
            ->where('cod_subcategoria', '=', $id)
            ->update([
                'nombre_subcategoria' => $request->nombre_subcategoria,
                'categoria' => $request->categoria,
            ]);
    }

    public static function borrar($id){
        return Subcategoria::destroy($id);
    }

    public static function validar($request){
        return \Validator::make($request->all(), [
            'nombre_subcategoria' => 'required|max:30',
            'categoria' => 'required|numeric|exists:categorias,cod_categoria'
        ]);

    }
}