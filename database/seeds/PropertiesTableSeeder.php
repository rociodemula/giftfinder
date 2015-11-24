<?php

use Illuminate\Database\Seeder;
use \Giftfinder\User;
use Faker\Factory as Faker;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        $users = User::all();
        foreach ($users as $user) {

            $id = $user->id;
            if(rand(0,1) == 1) {
                // No en todos los casos voy a insertar productos
                $numProperties = rand(1,4);
                for($p = 1; $p <= $numProperties; $p++) {
                    $property_id = \DB::table('properties')->insertGetId(array(
                        'user_id' => $id,
                        'name' => $faker->word,
                        'address' => $faker->address,
                        'description' => $faker->paragraph($nbSentences = rand(2,10))
                    ));
                    $numImages = rand(0,3);
                    for($i = 1; $i <= $numImages; $i++) {
                        //DB::table('images')->insert([
                        //                     'data' => $binaryFile
                        // ]);

                        \DB::table('properties_images')->insert([
                            'property_id' => $property_id,
                            'image' => file_get_contents($faker->imageUrl(120, 120))
                        ]);
                    }
                }
            }



        }

    }
}
