<?php

namespace Giftfinder\Http\Controllers;

use Illuminate\Http\Request;

use Giftfinder\Http\Requests;
use Giftfinder\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Giftfinder\Categoria;
use Giftfinder\Subcategoria;
use Giftfinder\Producto;

class SearchController extends Controller
{
    public function __construct()
    {
        // Aplica un filtro a través de un middleware.
        // No permite entrar en la página si no estamos logados.
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $nombre_producto = \Request::get('producto');

        if ($nombre_producto != 'Producto'){
            $cod_producto = DB::table('productos')
                ->where('nombre_producto', '=', $nombre_producto )
                ->value('cod_producto');

            $resultados = DB::table('usuarios_productos')
                ->join('usuarios', 'usuarios.cod_usuario', '=', 'usuarios_productos.usuario')
                ->select('usuarios.cod_usuario', 'usuarios.nombre_usuario', 'usuarios.email', 'usuarios.telefono', 'usuarios.movil', 'usuarios.whatsapp', 'usuarios.localizacion', 'usuarios.longitud', 'usuarios.latitud')
                ->where('usuarios_productos.producto', '=', $cod_producto)
                ->get();
            //TODO ordenar por ubicación según posición del usuario logado
        }
        else{
            $resultados = [];
        }
        //TODO la vista search no visualiza correctamente el Producto seleccionado
        return view('search', [
            'resultado' => $resultados,
            'categoria' => Categoria::all(),
            'subcategoria' => Subcategoria::all(),
            'producto' => Producto::all() ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //TODO relacionar lso combos de Categoria-Subcat-Producto para que sean selectivos
        return view('search', [
            'resultado' => [],
            'categoria' => Categoria::all(),
            'subcategoria' => Subcategoria::all(),
            'producto' => Producto::all() ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
