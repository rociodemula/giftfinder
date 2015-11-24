<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: rociodemula
 * Date: 2/11/15
 * Time: 10:55
 */
class UserTableSeeder extends Seeder {
    public function run() {

        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $id = \DB::table('users')->insertGetId(array(
                'name' => $faker->unique()->word,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->email,
                'password' => \Hash::make('123456'),
                'type' => $faker->randomElement(['admin',
                    'guest',
                    'owner',
                    'lessor',
                    'lessee',
                    'state-agent',
                    'professional'])
            ));

        }

    }

}