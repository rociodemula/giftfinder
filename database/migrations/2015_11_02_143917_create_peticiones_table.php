<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeticionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peticiones', function (Blueprint $table) {
            $table->increments('cod_peticion');
            $table->string('email_respuesta', 80);
            $table->string('asunto', 50)->nullable();
            $table->string('mensaje');
            $table->timestamps();
            //
            $table->integer('usuario')->unsigned();
            $table->foreign('usuario')
                ->references('cod_usuario')
                ->on('usuarios')
                ->onDelete('cascade');
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
        Schema::dropIfExists('peticiones');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
