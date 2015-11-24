<?php

namespace Giftfinder\Http\Controllers;


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
        return view('welcome');
    }

}
