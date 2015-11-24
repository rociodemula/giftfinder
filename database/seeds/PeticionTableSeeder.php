<?php

use Illuminate\Database\Seeder;

class PeticionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
