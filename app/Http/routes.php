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

/*
 * Definimos las rutas para las diferentes situaciones, según post y get, con parámetros según el caso.
 */
/**********************************************************
 *             RUTAS PARA PÁGINA DE INICIO
 **********************************************************/

//Ruta para página de bienvenida estándar:
Route::get('/', 'WelcomeController@index')->name('inicio');
//Ruta para para página de inicio tras la baja de usuario:
Route::get('/baja/{baja}', 'WelcomeController@destroy');

/**********************************************************
 *             RUTAS PARA PÁGINA DE PERFIL
 **********************************************************/

//Editar perfil, el usuario tiene que estar autenticado.
//Por get recoge la acción el método edit del controlador:
Route::get('/perfil', 'ProfileController@edit')->name('perfil')->middleware('auth');
//Por post (tras envío de formulario rectificado) gestiona la acción el método
//index del controlador específico:
Route::post('/perfil', 'ProfileController@index')->middleware('auth');

/**********************************************************
 *             RUTAS PARA PÁGINA DE BÚSQUEDAS
 **********************************************************/

//Requisito -> usuario autenticado.
//La petición get la gestiona el método edit del controlador específico:
Route::get('/busqueda', 'SearchController@edit')->name('busqueda')->middleware('auth');
//La petición post la gestiona l método show:
Route::post('/busqueda', 'SearchController@show')->middleware('auth');

/**********************************************************
 *             RUTAS PARA PÁGINA DE CONTACTO
 **********************************************************/

//Requisito -> estar autenticado.
//La llamada get la atiende el método edit:
Route::get('/contacto', 'ContactController@edit')->name('contacto')->middleware('auth');
//La petición post se atiende desde index:
Route::post('/contacto', 'ContactController@index')->middleware('auth');

/**********************************************************
 *             RUTAS PARA PÁGINA DE PANEL DE CONTROL
 **********************************************************/

//Requisito -> Estar autenticado con usuario con permisos de administración.
//La petición get sin parámetros se atiende desde show()
Route::get('/cpanel',  'CPanelController@show')->name('cpanel')->middleware(['auth', 'admin']);
//La petición post se atiende desde index()
Route::post('/cpanel', 'CPanelController@index')->middleware(['auth', 'admin']);
//La petición get con juego de parámetros para editar registro se atiende desde edit()
Route::get('/cpanel/editar/{tabla}/{id}', 'CPanelController@edit')->middleware(['auth', 'admin']);
//La petición get con juego de parámetros para borrar registro se atiende desde destroy()
Route::get('/cpanel/borrar/{tabla}/{id}', 'CPanelController@destroy')->middleware(['auth', 'admin']);
//La petición post con ruta para grabar registro editado se atiende desde update()
Route::post('/cpanel/grabar', 'CPanelController@update')->middleware(['auth', 'admin']);
//La petición get con juego de parámetros para crear nuevo registro se atiende desde create()
Route::get('/cpanel/nuevo/{tabla}', 'CPanelController@create')->middleware(['auth', 'admin']);
//La petición post con ruta para grabar nuevo registro se atiende desde store()
Route::post('/cpanel/alta/{tabla}', 'CPanelController@store')->middleware(['auth', 'admin']);

/**********************************************************
 *      RUTAS PARA PÁGINA DE PAGINAS DE INFORMACIÓN
 **********************************************************/

//Rut para páginas en el menú del footer, informativas y accesibles para cualqueir usuario:
Route::get('/condiciones', 'RulesController@index'); //A condiciones de uso de la página
Route::get('/ayuda', 'HelpController@index');// a Ayuda genérica de la página
Route::get('/derechos', 'CopyController@index'); //A derechos de autor


/**********************************************************
 *             RUTAS RELATIVAS A AUTENTICACIÓN
 **********************************************************/

//Petición get se atiende desde método getLogin de controlador específico:
Route::get('auth/login', 'Auth\AuthController@getLogin')->name('login');
//Petición post (tras logarse) desde método postLogin:
Route::post('auth/login', 'Auth\AuthController@postLogin');
//Petición get de logout, se atiende desde getLogaout:
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister')->name('registro');
Route::post('auth/register', 'Auth\AuthController@postRegister');


/**********************************************************
 *      RUTAS RELATIVAS A RECUPERACIÓN DE CONTRASEÑAS
 **********************************************************/

// Link de reseteo de password, peticiones get y post:
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');


// Peticiones get (link enviado por correo al usuario), y post, tras
// definir contraseña nueva:
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');



