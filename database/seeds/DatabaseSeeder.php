<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Indica el orden en que se deben ejecutar los seeders que alimentan
     * la base de datos.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(ProductoTableSeeder::class);
        $this->call(UsuarioTableSeeder::class);
        $this->call(UsuarioProductoTableSeeder::class);
        $this->call(PeticionTableSeeder::class);

        Model::reguard();
    }
}
