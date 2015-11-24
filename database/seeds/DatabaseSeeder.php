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

        $this->call(TransactionTypesSeeder::class);
        $this->call(AdminTableSeeder::class);
        // Inicia la carga de la clase UserTableSeeder que acabamos de crear
        // con los datos de los usuarios
        $this->call(UserTableSeeder::class);
        $this->call(PropertiesTableSeeder::class);
        $this->call(TransactionsSeeder::class);

        Model::reguard();
    }
}
