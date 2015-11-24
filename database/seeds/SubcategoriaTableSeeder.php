<?php

use Illuminate\Database\Seeder;

class SubcategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('subcategorias')->insert(array(
            'nombre_subcategoria'   =>  'Kéfir',
            'categoria'             =>  1,
        ));
    }
}
