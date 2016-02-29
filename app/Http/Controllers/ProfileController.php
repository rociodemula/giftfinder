<?php

namespace Giftfinder\Http\Controllers;

use Giftfinder\Usuario_producto;
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
            $baja = $this->destroy(auth()->user()->cod_usuario);
            return redirect('/baja/' . $baja);
        }else{

            $exito = false;
            $request = \Request::instance();
            $validacion = Usuario::validarModificacion($request);
            if($validacion->fails()){
                //Comunicación de errores en caso de que no esté correcto el formulario
                return redirect()->back()->withInput()->withErrors($validacion->errors());
            }
            if($this->update($request, auth()->user()->cod_usuario)){
                $exito = true;
            }

            //Se añade el registro de la tabla usuarios, para poder refrescarlo de forma correcta en la vista. Si no lo
            //hacemos así, los campos del perfil de usuarios, no se actualizan en la sesión tras el update en todos los casos, solo
            //si no modificamos los productos ofrecidos. Este bug se ha resuelto completamente con esta técnica, ya que no
            // se recupera ningún dato del usuario de sesión, salvo el código, el esto procede de la base de datos recién
            //actualizada.
            return view('profile', [
                'exito' => $exito,
                'categoria' => Categoria::all(),
                'subcategoria' => Subcategoria::all(),
                'producto' => Producto::all(),
                'usuario' => Usuario::where('cod_usuario', auth()->user()->cod_usuario)->first(),
                'compartido' => Usuario_producto::where('usuario', auth()->user()->cod_usuario)->get() ]);

            /*
            if($this->update(\Request::instance(), auth()->user()->cod_usuario)){
                return redirect('/perfil');
            }
            return view('profile', [
                $this->update(\Request::instance(), auth()->user()->cod_usuario),

                    'categoria' => Categoria::all(),
                    'subcategoria' => Subcategoria::all(),
                    'producto' => Producto::all()

            ]);*/
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
            'producto' => Producto::all(),
            'usuario' => Usuario::where('cod_usuario', auth()->user()->cod_usuario)->first(),
            'compartido' => Usuario_producto::where('usuario', auth()->user()->cod_usuario)->get()
        ]);
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
