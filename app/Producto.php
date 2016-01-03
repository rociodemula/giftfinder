<?php
/**
 * Created by PhpStorm.
 * User: rocio
 * Date: 24/11/15
 * Time: 15:28
 */

namespace Giftfinder;


use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $table = 'productos';

    public function usuarios()

    {
        $this->hasMany('Giftfinder\Usuario_producto');
    }
}