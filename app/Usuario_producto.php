<?php

namespace Giftfinder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuario_producto extends Model
{
    protected $table = 'usuarios_productos';

    protected $fillable = ['usuario', 'producto'];

    public static function alta($cod_usuario, $nombre_producto){
        $codProducto = DB::table('productos')
            ->where('nombre_producto', '=', $nombre_producto )
            ->value('cod_producto');

        return Usuario_producto::create([
            'usuario' => $cod_usuario,
            'producto' => $codProducto
        ]);
    }
}
