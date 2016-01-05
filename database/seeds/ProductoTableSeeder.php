<?php

use Illuminate\Database\Seeder;

class ProductoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = \DB::table('categorias')->insertGetId(array(
            'nombre_categoria'  =>  'Alimentación',
        ));

        $subcategoria = \DB::table('subcategorias')->insertGetId(array(
        'nombre_subcategoria'   =>  'Kéfir',
        'categoria'             =>  $categoria,
        ));

        \DB::table('productos')->insert(array(
            'nombre_producto'  =>  'Kéfir de Agua',
            'subcategoria'  =>  $subcategoria,
            'descripcion'  =>  'Gránulos de hongo a partir del cual podemos generar un rico refresco, con ayuda de panela, cítricos y agua mineral.',
            'link_articulo' =>  'https://es.wikipedia.org/wiki/K%C3%A9fir#K.C3.A9fir_de_agua',
        ));

        \DB::table('productos')->insert(array(
            'nombre_producto'  =>  'Kéfir de Leche',
            'subcategoria'  =>  $subcategoria,
            'descripcion'  =>  'Gránulos de hongo que se alimenta de la leche y con el que podemos elaborar un producto fermentado también conocido como yogur búlgaro.',
            'link_articulo' =>  'https://es.wikipedia.org/wiki/K%C3%A9fir#K.C3.A9fir_de_leche',
        ));

        \DB::table('productos')->insert(array(
            'nombre_producto'  =>  'Kombucha',
            'subcategoria'  =>  $subcategoria,
            'descripcion'  =>  'También conocido como kefir de té, hongo chino u hongo de té.',
            'link_articulo' =>  'https://es.wikipedia.org/wiki/Kombucha',
        ));
    }
}
