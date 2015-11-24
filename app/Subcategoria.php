<?php
/**
 * Created by PhpStorm.
 * User: rocio
 * Date: 24/11/15
 * Time: 15:27
 */

namespace Giftfinder;


use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    protected $table = 'subcategorias';

    public function properties()

    {
        $this->hasMany('Giftfinder\Producto');
    }
}