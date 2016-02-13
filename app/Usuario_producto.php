<?php

namespace Giftfinder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuario_producto extends Model
{
    protected $table = 'usuarios_productos';

    protected $fillable = ['usuario', 'producto'];

    public static function crear($cod_usuario, $nombre_producto){
        $codProducto = Usuario_producto::getCodProducto($nombre_producto);

        return Usuario_producto::create([
            'usuario' => $cod_usuario,
            'producto' => $codProducto
        ]);
    }

    public static function buscar($cod_usuario, $nombre_producto){
        $codProducto = Usuario_producto::getCodProducto($nombre_producto);
        return DB::table('usuarios_productos')
            ->where('usuario', '=', $cod_usuario)
            ->where('producto', '=', $codProducto)
            ->get();
    }

    public static function modificar($usuario, $producto, $id){
        return DB::table('usuarios_productos')
            ->where('codigo', '=', $id)
            ->update([
                'usuario' => $usuario,
                'producto' => $producto,
            ]);
    }
    public static function modificarAdmin($request, $id){
        return DB::table('usuarios_productos')
            ->where('codigo', '=', $id)
            ->update([
                'usuario' => $request->usuario,
                'producto' => $request->producto,
            ]);
    }
    public static function borrar($cod_usuario, $nombre_producto){
        $codProducto = Usuario_producto::getCodProducto($nombre_producto);
        return DB::table('usuarios_productos')
            ->where('usuario', '=', $cod_usuario)
            ->where('producto', '=', $codProducto)
            ->delete();;
    }

    public static function borrarPorId($id){
        return DB::table('usuarios_productos')
            ->where('codigo', '=', $id)
            ->delete();;
    }
    public static function getCodProducto($nombre_producto){
        return DB::table('productos')
            ->where('nombre_producto', '=', $nombre_producto )
            ->value('cod_producto');
    }

    public static function validar($request){
        return \Validator::make($request->all(), [
            'usuario' => 'required|numeric|exists:usuarios,cod_usuario',
            'producto' => 'required|numeric|exists:productos,cod_producto',
        ]);
    }
}
