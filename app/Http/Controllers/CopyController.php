<?php

namespace Giftfinder\Http\Controllers;

use Illuminate\Http\Request;

use Giftfinder\Http\Requests;
use Giftfinder\Http\Controllers\Controller;

class CopyController extends Controller
{
    /*
     * Esta vista no está restringida a un grupo de usuarios concreto, con lo que no
     * necesitamos declarar un contructor con un filtro.
     */

    /**
     * Visualiza pa vista de Derechos de autor
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Devolemos el nombre de la vista correspondiente.
        return view('copy');
    }

}
