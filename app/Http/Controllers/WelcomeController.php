<?php

namespace Giftfinder\Http\Controllers;


use Giftfinder\Producto;

class WelcomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    /**
     *
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    public function index()
    {
        return view('welcome', ['producto' => Producto::all()]);
    }

    public function destroy($baja){
        return view('welcome', [
            'baja' => $baja,
            'producto' => Producto::all()
        ]);
    }

}
