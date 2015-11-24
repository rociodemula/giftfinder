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
        $result = \DB::table('users')
            ->select(['name', 'email'])
            ->where('name','rociodemula')
            ->orderBy('name','ASC')
            ->get();
        dd($result);
        // return $result;
    }

}