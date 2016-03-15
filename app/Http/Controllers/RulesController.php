<?php

namespace Giftfinder\Http\Controllers;

use Illuminate\Http\Request;

use Giftfinder\Http\Requests;
use Giftfinder\Http\Controllers\Controller;

class RulesController extends Controller
{
    /*
     * Esta vista no está restringida a un grupo de usuarios concreto, con lo que no
     * necesitamos declarar un contructor con un filtro.
     */

    /**
     * Visualiza la página prevista para informar de las normas del sitio.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('rules');
    }


}
