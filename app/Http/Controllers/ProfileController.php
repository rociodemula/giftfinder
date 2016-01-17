<?php

namespace Giftfinder\Http\Controllers;

use Illuminate\Http\Request;
use Giftfinder\Categoria;
use Giftfinder\Subcategoria;
use Giftfinder\Producto;
use Giftfinder\Usuario;
use Giftfinder\Http\Requests;
use Giftfinder\Http\Controllers\Controller;

class ProfileController extends Controller
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
        if (\Input::has('eliminar')){
            if ($this->destroy(auth()->user()->cod_usuario)){
                //Para redirigir a inicio es necesario un return redirect():
                return redirect('/');
                //TODO mensaje de confirmación de borrado del perfil
            }
        }else{
            if($this->update(\Request::instance(), auth()->user()->cod_usuario)){
                return redirect('/perfil');
                //TODO mensaje comunicando que el perfil ha sido actualizado
                //TODO control de errores en el formulario y mensajes error
            }
        }
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('profile', [
            'categoria' => Categoria::all(),
            'subcategoria' => Subcategoria::all(),
            'producto' => Producto::all() ]);
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
        return Usuario::modificar($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Usuario::destroy($id);
    }
}
