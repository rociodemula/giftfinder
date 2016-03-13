<?php

namespace Giftfinder\Http\Controllers;

use Giftfinder\Categoria;
use Giftfinder\Peticion;
use Giftfinder\Producto;
use Giftfinder\Subcategoria;
use Giftfinder\Usuario;
use Giftfinder\Usuario_producto;
use Illuminate\Http\Request;

use Giftfinder\Http\Requests;
use Giftfinder\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;

class CPanelController extends Controller
{
    /**
     * Contructor de la clase
     */
    public function __construct()
    {
        // Aplica un filtro a través de un middleware.
        // No permite entrar en la página si no estamos logados como un usuario tipo admin.
        $this->middleware('admin');
    }
    /**
     * Visualiza la vista del panel de control para el usuario que entra con
     * una petición post a /cpanel, tras haber elegido alguna tabla en el combo
     * y pulsae el botón Ver de la vista.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Recuperamos el nombre de la tabla elegida:
        $tabla = \Request::get('tabla');

        //Inicializams las variables que necesitamos para cargar los datos para alimentar la vista.
        $resultados = [];
        $campos = [];
        $editar = false;


        //Cargaremos los datos de la tabla, siempre que se haya elegido alguna.
        if ($tabla != 'Tabla'){
            //Necesitamos cargar todos los registros de la tabla elegida:
            $resultados =  DB::table($tabla)->get();

            //Todos los nombres de los campos para pintar la cabecera de la tabla responsiva de la vista:
            $campos = DB::getSchemaBuilder()->getColumnListing($tabla);

            //Y cambiar el flag editar para indicarle a la vista que vamos a permitir editar los registros.
            $editar = true;
        }

        //Alimentamos la vista con los datos recopilados:
        //Nota: Las dos últimas variables se cargan en base a las respuestas del último post del hilo:
        //http://stackoverflow.com/questions/19444956/getting-all-tables-inside-a-database-using-laravel-4
        return view('cpanel', [
            'editar' => $editar,
            'nuevo' => false,
            'tabla' => $tabla,
            'id' => '',
            'campos' => $campos,
            'resultados' => $resultados,
            'tablas' => DB::select('SHOW TABLES'), //cargamos todas las tablas de la base de datos
            'ddbb' => 'Tables_in_'.env('DB_DATABASE'), //con esto recuperamos el nombre de la base de datos del fichero de configuración de Laravel.
        ]);
    }

    /**
     * Alimenta la vista cpanel de forma que se permita insertar una fila en
     * blanco en la tabla que se pasa como parámetro.
     *
     * @param $tabla
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /**
     */
    public function create($tabla)
    {
        //Inicializamos los arrays que alimentan la vista.
        $resultados = [];
        $campos = [];

        //En caso de que se haya elegido alguna tabla en el combo,
        //cargamos los resultados de los registros y los nombres de campo en
        //los arrays previstos:
        if ($tabla != 'Tabla'){
            $resultados =  DB::table($tabla)->get();
            $campos = DB::getSchemaBuilder()->getColumnListing($tabla);
        }
        //Alimentamos la vista con la combinacion de flags prevista para que
        //se genere una líneaen blanco al inicio de la tabla responsive que
        //muestra el contenido de la tabla:
        //(a la vez que se alimentan el resto de elementos del formulario,
        //como el propio combo con el resto de tablas accesibles)
        return view('cpanel', [
            'editar' => true,
            'nuevo' => true,
            'tabla' => $tabla,
            'id' => '',
            'resultados' => $resultados,
            'campos' => $campos,
            'tablas' => DB::select('SHOW TABLES'),
            'ddbb' => 'Tables_in_'.env('DB_DATABASE'),
        ]);
    }

    /**
     * Graba el registro nuevo alojado en el request en la tabla pasada por parámetro,
     * y alimenta la vista de forma que devuelva los mensajes de error/éxito procedentes.
     *
     * @param $tabla
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store($tabla)
    {
        //Recuperamos el contenido del request del formulario correspondiente
        //al nuevo registro:
        $request = \Request::instance();

        //Reiniciamos los diferentes flags  y variables que necesitamos para valorar la situación
        //final de la operación:
        $ok = null;
        $grabado = null;
        $validacion = null;

        //Dependiendo de la tabla de la que se trate, necesitamos llamar a unas
        //validaciones y métodos de modelos diferentes:
        switch($tabla){
            case 'categorias':
                //Las validaciones de categoría, petición, subcategorías y usuarios_productos
                //son bastante básicas, nos limitamos a validar y grabar con los métodos ya
                //previstos en el modelo:
                $validacion = Categoria::validar($request);
                if(!$validacion-> fails()){
                    $grabado = Categoria::crear(['nombre_categoria' => $request->nombre_categoria]);
                }
                break;
            case 'peticiones':
                $validacion = Peticion::validar($request);
                if(!$validacion->fails()) {
                    $grabado = Peticion::alta($request, $request->usuario);
                }
                break;
            case 'productos':
                //Para productos tenemos más campos, pero la simplicidad es similar:
                $validacion = Producto::validar($request);
                if(!$validacion->fails()) {
                    $grabado = Producto::crear([
                        'subcategoria' => $request->subcategoria,
                        'nombre_producto' => $request->nombre_producto,
                        'descripcion' => $request->descripcion,
                        'foto_producto' => $request->foto_producto,
                        'link_articulo' => $request->link_articulo,
                    ]);
                }
                break;
            case 'subcategorias':
                $validacion = Subcategoria::validar($request);
                if(!$validacion->fails()) {
                    $grabado = Subcategoria::crear([
                        'nombre_subcategoria' => $request->nombre_subcategoria,
                        'categoria' => $request->categoria,
                    ]);
                }
                break;
            case 'usuarios':
                //En el caso de usuarios debemos transformar primero los campos de checkbox en datos binarios
                //que podamos alojar en la tabla prevista:
                $validacion = Usuario::validarAdmin($request);
                if(!$validacion->fails()) {
                    $data['acepto'] = (isset($request->acepto) && $request->acepto) ? 1 : null;
                    $data['whatsapp'] = (isset($request->whatsapp) && $request->whatsapp) ? 1 : 0;
                    $data['geolocalizacion'] = (isset($request->geolocalizacion) && $request->geolocalizacion) ? 1 : 0;

                    $grabado = Usuario::create([
                        'nombre_usuario' => $request->nombre_usuario,
                        'password' => bcrypt($request->password),
                        'localizacion' => $request->localizacion,
                        'latitud' => $request->latitud,
                        'longitud' => $request->longitud,
                        'email' => $request->email,
                        'telefono' => $request->telefono,
                        'movil' => $request->movil,
                        'whatsapp' => $data['whatsapp'],
                        'geolocalizacion' => $data['geolocalizacion'],
                        'acepto' => $data['acepto']
                    ]);
                }
                break;
            case 'usuarios_productos':
                $validacion = Usuario_producto::validar($request);
                if(!$validacion->fails()) {
                    $grabado = Usuario_producto::create([
                        'usuario' => $request->usuario,
                        'producto' => $request->producto
                    ]);
                }
        }

        //Alimentamos el resto de la vista que no tiene que ver con la grabación
        //del resistro:
        $resultados =  DB::table($tabla)->get();
        $campos = DB::getSchemaBuilder()->getColumnListing($tabla);

        //En caso de grabación correcta, inicializamos las variables y flags que
        //alimentan la vista, de forma que se le pueda transmitir un mensaje de
        //Éxito al usuario:
        if ($grabado){
            $ok = view('cpanel', [
                'exito' => true,
                'editar' => false,
                'nuevo' => false,
                'tabla' => $tabla,
                'id' => '',
                'campos' => $campos,
                'resultados' => $resultados,
                'tablas' => DB::select('SHOW TABLES'),
                'ddbb' => 'Tables_in_'.env('DB_DATABASE'),
            ]);
        }else if($validacion->fails()){
            //Si no, hemos de guardar el resultado con los errores en la variable
            //prevista para ello:
            $ok = redirect()->back()->withInput()->withErrors($validacion->errors());
        }else{
            //En caso de que haya fallado la grabación en base de datos, se le pasa
            //a la vista la combinación para que muestr un mensaje de error específico.
            $ok = view('cpanel', [
                'exito' => false,
                'editar' => false,
                'nuevo' => false,
                'tabla' => $tabla,
                'id' => '',
                'campos' => $campos,
                'resultados' => $resultados,
                'tablas' => DB::select('SHOW TABLES'),
                'ddbb' => 'Tables_in_'.env('DB_DATABASE'),
            ]);
        }

        return $ok;
    }

    /**
     * Visualiza el panel de administración en caso de que el usuario esté
     * entrando por primera vez con una llamada get sin parámetros.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        //Alimentamos la vista de forma inicial, con todas las tablas de la
        //base de datos disponibles y sin opción a editar nada ni añadir registros,
        //ya que no habrá ninguna tabla seleccionada.
        return view('cpanel', [
            'editar' => false,
            'nuevo' => false,
            'tabla' => '',
            'id' => '',
            'resultados' => [],
            'campos' => [],
            'tablas' => DB::select('SHOW TABLES'),
            'ddbb' => 'Tables_in_'.env('DB_DATABASE'),
        ]);
    }

    /**
     * Alimenta la vista panel de control en caso de que se haya pulsado
     * editar un registro. Se devolverá la vista con un array en el que se
     * disponga de el id del registro a modificar y la tabla concreta (aparte
     * del resto de parámetros necesarios para competar el resto de elementos
     * de la vista.
     *
     * @param $tabla
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($tabla, $id = '')
    {
        //Cargaremos tabmién los registros de la tabla y los nombres de campos, como en
        //otros métodos de este misma clase:
        $resultados =  DB::table($tabla)->get();
        $campos = DB::getSchemaBuilder()->getColumnListing($tabla);
        //Es importante que editar este con valor true, ya que así reconocerá la
        //vista que debe mostrar el juego de botones e inputs propio de un registro
        //en edición.
        return view('cpanel', [
            'editar' => true,
            'nuevo' => false,
            'tabla' => $tabla,
            'id' => $id,
            'campos' => $campos,
            'resultados' => $resultados,
            'tablas' => DB::select('SHOW TABLES'),
            'ddbb' => 'Tables_in_'.env('DB_DATABASE'),
        ]);
    }

    /**
     * Alimenta la vista tras haber pulsado el botón para grabar un registro ya
     * existente modificándolo.
     *
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update()
    {
        //Recuperamos el contenido del request:
        $request = \Request::instance();

        //Guardamos los datos importantes del request en variables independientes
        //para que sean más manejables:
        $id = $request->get('id');
        $tabla = $request->get('tabla');

        //Inicializamos algunos flag y variables necesarias:
        $grabado = null;
        $validacion = null;
        $ok = null;

        //Al igual que en altas, según la tabla, cambiará el procedimiento, y nos iremos
        //a los métodos específicos de cada modelo, algunos, diseñados para esta opción de
        //panel de administración, ya que es diferente del formulario genérico de usuario:
        switch($tabla){
            case 'categorias':
                $validacion = Categoria::validar($request);
                if(!$validacion-> fails()){
                    $grabado = Categoria::modificar($request, $id);
                }
                break;
            case 'peticiones':
                $validacion = Peticion::validar($request);
                if(!$validacion->fails()) {
                    $grabado = Peticion::modificar($request, $id);
                }
                break;
            case 'productos':
                $validacion = Producto::validar($request);
                if(!$validacion->fails()) {
                    $grabado = Producto::modificar($request, $id);
                }
                break;
            case 'subcategorias':
                $validacion = Subcategoria::validar($request);
                if(!$validacion->fails()) {
                    $grabado = Subcategoria::modificar($request, $id);
                }
                break;
            case 'usuarios':
                $validacion = Usuario::validarAdmin($request);
                if(!$validacion->fails()) {
                    $grabado = Usuario::modificarAdmin($request, $id);
                }
                break;
            case 'usuarios_productos':
                $validacion = Usuario_producto::validar($request);
                if(!$validacion->fails()) {
                    $grabado = Usuario_producto::modificarAdmin($request, $id);
                }
        }

        //Recargamos los datos para alimentar los combos y cabeceras de la vista:
        $resultados =  DB::table($tabla)->get();
        $campos = DB::getSchemaBuilder()->getColumnListing($tabla);

        if ($grabado){
            //Si se ha grabado, devolveremos la vista sin errores:
            $ok = view('cpanel', [
                'exito' => true,
                'editar' => false,
                'nuevo' => false,
                'tabla' => $tabla,
                'id' => '',
                'campos' => $campos,
                'resultados' => $resultados,
                'tablas' => DB::select('SHOW TABLES'),
                'ddbb' => 'Tables_in_'.env('DB_DATABASE'),
            ]);
        }else if($validacion->fails()){
            //Si ha fallado la validación pasaremos los errores de validación:
            $ok = redirect()->back()->withInput()->withErrors($validacion->errors());
        }else{
            //La única opción que nos queda es qeu haya pasado la validación pero nos
            //falle la grabación en base de datos, con lo que preparamos la alimentación
            //de la vista para un error genérico:
            $ok = view('cpanel', [
                'exito' => false,
                'editar' => false,
                'nuevo' => false,
                'tabla' => $tabla,
                'id' => '',
                'campos' => $campos,
                'resultados' => $resultados,
                'tablas' => DB::select('SHOW TABLES'),
                'ddbb' => 'Tables_in_'.env('DB_DATABASE'),
            ]);
        }

        return $ok;
    }

    /**
     * Gestiona la baja del registro del id y tabla pasados por parámetro y realimenta
     * la vista con el mensaje de éxito/error correspondiente.
     *
     * @param $tabla
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($tabla, $id)
    {
        //Mismo algoritmo que en altas y modificaciones:
        //  - Diferentes cases para cada modelo.
        //  - Guardamos el resultado en un flag
        //  - Retornamos la vista con variables que la realimentan
        //  y le dicen a si mostrar el mensaje de éxito
        //  o un error.
        $borrado = null;
        switch($tabla){
            case 'categorias':
                $borrado = Categoria::destroy($id);
                break;
            case 'peticiones':
                $borrado = Peticion::destroy($id);
                break;
            case 'productos':
                $borrado = Producto::destroy($id);
                break;
            case 'subcategorias':
                $borrado = Subcategoria::destroy($id);
                break;
            case 'usuarios':
                $borrado = Usuario::destroy($id);
                break;
            case 'usuarios_productos':
                $borrado = Usuario_producto::destroy($id);
        }

        $resultados =  DB::table($tabla)->get();
        $campos = DB::getSchemaBuilder()->getColumnListing($tabla);

        return view('cpanel', [
            'exito' => $borrado,
            'editar' => false,
            'nuevo' => false,
            'tabla' => $tabla,
            'id' => '',
            'campos' => $campos,
            'resultados' => $resultados,
            'tablas' => DB::select('SHOW TABLES'),
            'ddbb' => 'Tables_in_'.env('DB_DATABASE'),
        ]);
    }
}
