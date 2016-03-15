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
    /**
     * Contructor de la clase. Contiene un filtro para que solo puedan acceder
     * a esta vista los usuarios logados en el sistema.
     */
    public function __construct()
    {
        // Aplica un filtro a través de un middleware.
        // No permite entrar en la página si no estamos logados.
        $this->middleware('auth');
    }


    /**
     * Visualiza los datos para atender una llamada post realizada desde esta página,
     * después de que el usuario haya seleccionado un producto a buscar.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        //Recuperamos el nombre de producto del request
        $nombre_producto = \Request::get('producto');

        if ($nombre_producto != 'Producto'){

            //En caso de que se haya elegido algún producto, buscamos su código en la base de datos
            $cod_producto = DB::table('productos')
                ->where('nombre_producto', '=', $nombre_producto )
                ->value('cod_producto');

            //Seleccionamos a todos los usuarios que tengan ese producto compartido.
            //Hay que hacer un join, para coger los datos del usuario de la tabla usuarios.
            $resultados = DB::table('usuarios_productos')
                ->join('usuarios', 'usuarios.cod_usuario', '=', 'usuarios_productos.usuario')
                ->select('usuarios.cod_usuario', 'usuarios.nombre_usuario', 'usuarios.email', 'usuarios.telefono', 'usuarios.movil', 'usuarios.whatsapp', 'usuarios.localizacion', 'usuarios.longitud', 'usuarios.latitud')
                ->where('usuarios_productos.producto', '=', $cod_producto)
                ->get();
        }
        else{
            //En caso de que no se haya seleccionado nada en producto, reseteamos los resultados.
            $resultados = [];
            $nombre_producto = '';
        }

        //Devolvemos la vista alimentada adecuadamente con los resultados:
        return view('search', [
            'nombreProducto' => $nombre_producto,
            'resultado' => $resultados,
            'categoria' => Categoria::all(),
            'subcategoria' => Subcategoria::all(),
            'producto' => Producto::all() ]);
    }


    /**
     * Visualiza la página de búsquedas si se accede a ella mediante una llamada get
     * correspondiente al usuario logado que entra por primera vez.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('search', [
            'nombreProducto' => '',
            'resultado' => [],
            'categoria' => Categoria::all(),
            'subcategoria' => Subcategoria::all(),
            'producto' => Producto::all() ] );
    }


}
