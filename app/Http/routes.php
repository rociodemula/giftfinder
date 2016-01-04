<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', 'WelcomeController@index')->name('inicio');
//Route::get('/welcome', 'WelcomeController@index');
//Route::get('/home', 'HomeController@index');
Route::get('/perfil', 'ProfileController@edit')->name('perfil')->middleware('auth');
Route::post('/perfil', 'ProfileController@index')->middleware('auth');
Route::get('/busqueda', 'SearchController@edit')->name('busqueda')->middleware('auth');
Route::post('/busqueda', 'SearchController@show')->middleware('auth');
Route::get('/contacto', 'ContactController@edit')->name('contacto')->middleware('auth');
Route::post('/contacto', 'ContactController@index')->middleware('auth');
Route::get('/condiciones', 'RulesController@index');
Route::get('/ayuda', 'HelpController@index');
Route::get('/derechos', 'CopyController@index');

// Authentication routes...
/*
 *  Están en vendor/bestmomo/scafold
 *
*/
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin')->name('login');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister')->name('registro');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');


// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');




Route::controllers([
    'users' => 'UsersController',
    'password' => 'Auth\PasswordController',
]);


Route::group(['prefix' => 'dummy', 'namespace' => 'Dummy'], function() {
    // Los controladores de tipo "resource" siguen la interfaz REST
    Route::resource('/{n?}', 'DummyController@index',['n']);

});

