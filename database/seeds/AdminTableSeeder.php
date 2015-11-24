<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: rociodemula
 * Date: 2/11/15
 * Time: 10:55
 */
class AdminTableSeeder extends Seeder {
    public function run() {
        \DB::table('users')->insert(array(
            'name' => 'rociodemula',
            'first_name' => 'Rocío',
            'last_name' => 'de Mula',
            'email' => 'rociodemula@demosdata.com',
            'type' => 'admin',
            'password' => \Hash::make('secret'),

        ));
    }

}