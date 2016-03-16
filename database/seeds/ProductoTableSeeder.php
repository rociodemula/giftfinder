<?php

use Illuminate\Database\Seeder;

/**
 * Class ProductoTableSeeder
 */
class ProductoTableSeeder extends Seeder
{
    /**
     * Incorpora los inserts a la tabla.
     *
     * @return void
     */
    public function run()
    {
        //Necesitamos alimentar previamente Categoría y Subcategoría, en el mismo
        //archivo seeder, para así poder disponer de los id para insertarlos en la
        //tabla Productos.
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
            'descripcion'  =>  'Hongo a partir del cual podemos generar un rico refresco, con ayuda de panela, cítricos y agua mineral.',
            'link_articulo' =>  'https://es.wikipedia.org/wiki/K%C3%A9fir#K.C3.A9fir_de_agua',
            'foto_producto' => 'https://upload.wikimedia.org/wikipedia/commons/e/e0/K%C3%A9fir-mr.lex-grains_eau.jpg',
        ));

        \DB::table('productos')->insert(array(
            'nombre_producto'  =>  'Kéfir de Leche',
            'subcategoria'  =>  $subcategoria,
            'descripcion'  =>  'Hongo que se alimenta de la lactosa y con el que podemos elaborar un lácteo fermentado también conocido como yogur búlgaro.',
            'link_articulo' =>  'https://es.wikipedia.org/wiki/K%C3%A9fir#K.C3.A9fir_de_leche',
            'foto_producto' => 'https://upload.wikimedia.org/wikipedia/commons/0/05/Kefir-grains-90grams.jpg',
        ));

        \DB::table('productos')->insert(array(
            'nombre_producto'  =>  'Kombucha',
            'subcategoria'  =>  $subcategoria,
            'descripcion'  =>  'Hongo también conocido como kefir de té, hongo chino u hongo de té.',
            'link_articulo' =>  'https://es.wikipedia.org/wiki/Kombucha',
            'foto_producto' => 'https://upload.wikimedia.org/wikipedia/commons/6/67/Kombucha.jpg',
        ));
    }
}
