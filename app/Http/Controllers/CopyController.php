<?php

namespace Giftfinder\Http\Controllers;

use Illuminate\Http\Request;

use Giftfinder\Http\Requests;
use Giftfinder\Http\Controllers\Controller;

class CopyController extends Controller
{
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
