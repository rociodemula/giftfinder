<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //$this->call(CategoriaTableSeeder::class);
        //$this->call(SubcategoriaTableSeeder::class);
        $this->call(ProductoTableSeeder::class);
        $this->call(UsuarioTableSeeder::class);
        $this->call(UsuarioProductoTableSeeder::class);
        $this->call(PeticionTableSeeder::class);

        Model::reguard();
    }
}
