<?php

namespace Giftfinder;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    //
    protected $table = 'properties';

    public function images()
    {
        $this->hasMany('Giftfinder\PropertyImage');
    }

}
