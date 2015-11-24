<?php

use Illuminate\Database\Seeder;

class UsuarioProductoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
    }
}
