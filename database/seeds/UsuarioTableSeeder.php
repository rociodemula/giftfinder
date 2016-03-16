<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


/**
 * Class UsuarioTableSeeder
 */
class UsuarioTableSeeder extends Seeder {

    /**
     * Incorpora los inserts a la tabla.
     *
     * @return void
     */
    public function run() {

        //Con el método create de Faker podemos alimentar la tabla usuarios con
        //los reigstros que queramos.
        $faker = Faker::create();

        \DB::table('usuarios')->insert(array(
            'nombre_usuario' => 'adminproy',
            'password' => \Hash::make('secure'),
            'latitud' => 57.4879289,
            'longitud' => -4.1406816,
            'email' => 'pruebas@example.com',
            'tipo' => 'admin',
        ));

        \DB::table('usuarios')->insert(array(
            'nombre_usuario' => 'tutorproy',
            'password' => \Hash::make('secure'),
            'latitud' => 57.4879289,
            'longitud' => -4.1406816,
            'email' => 'pruebas1@example.com',
            'tipo' => 'admin',
        ));
        for ($i = 0; $i < 10; $i++) {
            \DB::table('usuarios')->insert(array(
                'nombre_usuario' => $faker->unique()->word,
                'password' => \Hash::make('123456'),
                'latitud' => $faker->latitude,
                'longitud' => $faker->longitude,
                'email' => $faker->unique()->email,
                'tipo' => 'user',
            ));

        }

    }

}