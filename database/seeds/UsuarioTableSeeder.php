<?php
use Illuminate\Database\Seeder;
use Faker\Provider\es_ES\Address;
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
            'localizacion' => 'Dos Hermanas, Sevilla, Spain',
            'latitud' => 37.2865803,
            'longitud' => -5.924239099999999,
            'email' => 'pruebas@example.com',
            'tipo' => 'admin',
        ));

        \DB::table('usuarios')->insert(array(
            'nombre_usuario' => 'tutorproy',
            'password' => \Hash::make('secure'),
            'localizacion' => 'Aguadulce, Almería, Spain',
            'latitud' => 36.816162,
            'longitud' => -2.5718122,
            'email' => 'pruebas1@example.com',
            'tipo' => 'admin',
        ));
        for ($i = 0; $i < 10; $i++) {
            \DB::table('usuarios')->insert(array(
                'nombre_usuario' => $faker->unique()->word,
                'password' => \Hash::make('123456'),
                'localizacion' => Address::state().',Spain',
                'latitud' => $faker->latitude,
                'longitud' => $faker->longitude,
                'email' => $faker->unique()->email,
                'tipo' => 'user',
            ));

        }

    }

}