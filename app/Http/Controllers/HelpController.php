<?php

namespace Giftfinder\Http\Controllers;

use Illuminate\Http\Request;

use Giftfinder\Http\Requests;
use Giftfinder\Http\Controllers\Controller;

class HelpController extends Controller
{
    /**
     * Visualiza la vista correspondiente a la ayuda del programa.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Retornamos la vista correspondiente:
        return view('help');
    }

}
