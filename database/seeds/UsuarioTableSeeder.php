<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: rociodemula
 * Date: 2/11/15
 * Time: 10:55
 */
class UsuarioTableSeeder extends Seeder {
    public function run() {

        $faker = Faker::create();

        \DB::table('usuarios')->insert(array(
            'nombre_usuario' => 'adminproy',
            'clave' => \Hash::make('secure'),
            'latitud' => 57.4879289,
            'longitud' => -4.1406816,
            'email' => 'pruebas@example.com',
            'tipo' => 'admin',
        ));

        \DB::table('usuarios')->insert(array(
            'nombre_usuario' => 'tutorproy',
            'clave' => \Hash::make('secure'),
            'latitud' => 57.4879289,
            'longitud' => -4.1406816,
            'email' => 'pruebas1@example.com',
            'tipo' => 'admin',
        ));
        for ($i = 0; $i < 10; $i++) {
            \DB::table('usuarios')->insert(array(
                'nombre_usuario' => $faker->unique()->word,
                'clave' => \Hash::make('123456'),
                'latitud' => $faker->latitude,
                'longitud' => $faker->longitude,
                'email' => $faker->unique()->email,
                'tipo' => 'user',
            ));

        }

    }

}