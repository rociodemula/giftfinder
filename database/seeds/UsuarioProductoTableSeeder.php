<?php

use Illuminate\Database\Seeder;

/**
 * Class UsuarioProductoTableSeeder
 */
class UsuarioProductoTableSeeder extends Seeder
{
    /**
     * Incorpora los inserts a la tabla.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  1,
            'producto'  =>  1,
        ));

        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  1,
            'producto'  =>  2,
        ));
        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  1,
            'producto'  =>  3,
        ));
        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  2,
            'producto'  =>  3,
        ));
        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  2,
            'producto'  =>  1,
        ));
        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  3,
            'producto'  =>  1,
        ));
        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  5,
            'producto'  =>  2,
        ));
        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  6,
            'producto'  =>  1,
        ));
        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  7,
            'producto'  =>  1,
        ));
        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  8,
            'producto'  =>  3,
        ));
        \DB::table('usuarios_productos')->insert(array(
            'usuario'   =>  9,
            'producto'  =>  1,
        ));
    }
}
