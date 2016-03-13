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
    public function __construct()
    {
        // Aplica un filtro a través de un middleware.
        // No permite entrar en la página si no estamos logados como un usuario tipo admin.
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tabla = \Request::get('tabla');

        $resultados = [];
        $campos = [];
        $editar = false;


        if ($tabla != 'Tabla'){
            $resultados =  DB::table($tabla)->get();
            $campos = DB::getSchemaBuilder()->getColumnListing($tabla);
            $editar = true;
        }

        return view('cpanel', [
            'editar' => $editar,
            'nuevo' => false,
            'tabla' => $tabla,
            'id' => '',
            'campos' => $campos,
            'resultados' => $resultados,
            'tablas' => DB::select('SHOW TABLES'),
            'ddbb' => 'Tables_in_'.env('DB_DATABASE'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tabla)
    {
        $resultados = [];
        $campos = [];

        if ($tabla != 'Tabla'){
            $resultados =  DB::table($tabla)->get();
            $campos = DB::getSchemaBuilder()->getColumnListing($tabla);
        }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $tabla
     * @return \Illuminate\Http\Response
     */
    public function store($tabla)
    {
        $request = \Request::instance();
        $grabado = null;
        $validacion = null;
        $exito = false;
        switch($tabla){
            case 'categorias':
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
                    $grabado = Usuario_producto::modificarAdmin($request, $id);
                }
        }

        $resultados =  DB::table($tabla)->get();
        $campos = DB::getSchemaBuilder()->getColumnListing($tabla);

        if ($grabado){
            $id = '';
            $editar = false;
            $exito= true;
        }else if($validacion->fails()){
            return redirect()->back()->withInput()->withErrors($validacion->errors());
        }

        return view('cpanel', [
            'exito' => $exito,
            'editar' => false,
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  string  $tabla
     * @return \Illuminate\Http\Response
     */
    public function edit($tabla, $id = '')
    {
        $resultados =  DB::table($tabla)->get();
        $campos = DB::getSchemaBuilder()->getColumnListing($tabla);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $request = \Request::instance();
        $id = $request->get('id');
        $tabla = $request->get('tabla');
        $grabado = null;
        $validacion = null;
        $editar = true;
        $exito = false;
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

        $resultados =  DB::table($tabla)->get();
        $campos = DB::getSchemaBuilder()->getColumnListing($tabla);

        if ($grabado){
            $id = '';
            $editar = false;
            $exito= true;
        }else if($validacion->fails()){
            return redirect()->back()->withInput()->withErrors($validacion->errors());
        }

        return view('cpanel', [
            'exito' => $exito,
            'editar' => $editar,
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  string  $tabla
     * @return \Illuminate\Http\Response
     */
    public function destroy($tabla, $id)
    {
        $borrado = null;
        switch($tabla){
            case 'categorias':
                Categoria::destroy($id);
                break;
            case 'peticiones':
                Peticion::destroy($id);
                break;
            case 'productos':
                Producto::destroy($id);
                break;
            case 'subcategorias':
                Subcategoria::destroy($id);
                break;
            case 'usuarios':
                Usuario::destroy($id);
                break;
            case 'usuarios_productos':
                Usuario_producto::destroy($id);
        }

        $resultados =  DB::table($tabla)->get();
        $campos = DB::getSchemaBuilder()->getColumnListing($tabla);

        return view('cpanel', [
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
