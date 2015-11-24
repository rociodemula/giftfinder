<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \Giftfinder\User as User;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $minUserId = \DB::table('users')->min('id');
        $maxUserId = \DB::table('users')->max('id');
        //

        // echo($minUserId. ' -> '. $maxUserId);


        for($t = 1; $t <= 30; $t++) {
            $userIdToFind = rand($minUserId, $maxUserId);
            $user_id = \Giftfinder\User::where('id','>=', $userIdToFind)->first()->id;
            \DB::table('transactions')->insert([
                'user_id' => $user_id,
                'transaction_date' => $faker->dateTime,
                'transaction_type_id' => $faker->randomElement([1,2,3,4,5]),
                'transaction_description' => $faker->text()
                ]);
        }




    }
}
