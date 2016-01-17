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
            'tabla' => $tabla,
            'id' => '',
            'campos' => $campos,
            'resultados' => $resultados,
            'tablas' => DB::select('SHOW TABLES'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            'tabla' => '',
            'id' => '',
            'resultados' => [],
            'campos' => [],
            'tablas' => DB::select('SHOW TABLES'),
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
            'tabla' => $tabla,
            'id' => $id,
            'campos' => $campos,
            'resultados' => $resultados,
            'tablas' => DB::select('SHOW TABLES'),
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
        $editar = true;
        switch($tabla){
            case 'categorias':
                $grabado = Categoria::modificar($request, $id);
                break;
            case 'peticiones':
                $grabado = Peticion::modificar($request, $id);
                break;
            case 'productos':
                $grabado = Producto::modificar($request, $id);
                break;
            case 'subcategorias':
                $grabado = Subcategoria::modificar($request, $id);
                break;
            case 'usuarios':
                $grabado = Usuario::modificar($request, $id);
                break;
            case 'usuarios_productos':
                $grabado = Usuario_producto::modificar($request, $id);
        }

        $resultados =  DB::table($tabla)->get();
        $campos = DB::getSchemaBuilder()->getColumnListing($tabla);

        if ($grabado){
            $id = '';
            $editar = false;
        }

        return view('cpanel', [
            'editar' => $editar,
            'tabla' => $tabla,
            'id' => $id,
            'campos' => $campos,
            'resultados' => $resultados,
            'tablas' => DB::select('SHOW TABLES'),
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
            'tabla' => $tabla,
            'id' => '',
            'campos' => $campos,
            'resultados' => $resultados,
            'tablas' => DB::select('SHOW TABLES'),
        ]);
    }
}
