<?php

use Illuminate\Database\Seeder;

/**
 * Class PeticionTableSeeder
 */
class PeticionTableSeeder extends Seeder
{
    /**
     * Incorpora los inserts a la tabla.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('peticiones')->insert(array(
            'usuario'           =>  3,
            'email_respuesta'   =>  'pymkysafe@gmail.com',
            'mensaje'           =>  'Tengo gatos para regalar y querría que se diese de alta la opción.',
        ));
    }
}
