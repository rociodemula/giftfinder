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

class Producto extends Model
{

    protected $table = 'productos';

    protected $primaryKey = 'cod_producto';

    protected $fillable = ['subcategoria', 'nombre_producto', 'descripcion', 'foto_producto', 'link_articulo'];

    public function usuarios()

    {
        $this->hasMany('Giftfinder\Usuario_producto');
    }

    public static function crear($data){
        return Producto::create([
            'subcategoria' => $data['subcategoria'],
            'nombre_producto' => $data['nombre_producto'],
            'descripcion' => $data['descripcion'],
            'foto_producto' => $data['foto_producto'],
            'link_articulo' => $data['link_articulo'],
        ]);
    }

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

    public static function borrar($id){
        return Producto::destroy($id);
    }

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