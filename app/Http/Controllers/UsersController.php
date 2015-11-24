<?php

/**
 * Created by PhpStorm.
 * User: rociodemula
 * Date: 2/11/15
 * Time: 13:52
 */

namespace Giftfinder\Http\Controllers;


class UsersController extends Controller
{
    public function getIndex() {
        $result = \DB::table('usuarios')
            ->select(['nombre_usuario', 'email'])
            ->where('nombre_usuario','rociodemula')
            ->orderBy('nombre_usuario','ASC')
            ->get();
        dd($result);
        // return $result;
    }

}