<?php

use Illuminate\Database\Seeder;

class TransactionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Las descripciones harían referencia a la clave de la traducción
        // para los distintos idiomas.
        // TODO: Pendiente de crear archivos de traducciones
        \DB::table('transaction_types')->insert(['transaction_name' => 'emit_bill']);
        \DB::table('transaction_types')->insert(['transaction_name' => 'visit']);
        \DB::table('transaction_types')->insert(['transaction_name' => 'call_professional']);
        \DB::table('transaction_types')->insert(['transaction_name' => 'pay_bill']);
        \DB::table('transaction_types')->insert(['transaction_name' => 'send_letter']);

    }
}
