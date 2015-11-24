<?php
/**
 * Created by PhpStorm.
 * User: rocio
 * Date: 24/11/15
 * Time: 15:24
 */

namespace Giftfinder;


use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    public function properties()

    {
        $this->hasMany('Giftfinder\Subcategoria');
    }
}