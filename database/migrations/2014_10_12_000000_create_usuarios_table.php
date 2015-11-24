<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Migra la base de datos.
     * Crea las tablas para la bbdd giftfinder
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('cod_usuario');
            $table->string('nombre_usuario', 30);
            $table->string('clave', 60);
            $table->string('localizacion', 60)->nullable();
            $table->decimal('latitud', 9, 6);
            $table->decimal('longitud', 9, 6);
            $table->string('email', 80)->unique()->nullable();
            $table->string('telefono', 12)->nullable();
            $table->string('movil', 12)->nullable();
            $table->boolean('whatsapp')->default(false);
            $table->boolean('geolocalizacion')->default(false);
            $table->boolean('acepto')->default(true);
            $table->enum('tipo', ['user',
                                  'admin'])
                ->default('user');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('usuarios');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
