<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


/**
 * Class CreatePeticionesTable, encargada de migrar la tabla Peticiones.
 */
class CreatePeticionesTable extends Migration
{
    /**
     * Migra la base de datos.
     * Crea la tabla peticiones para la bbdd giftfinder
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
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at');
            //
            $table->integer('usuario')->unsigned();
            $table->foreign('usuario')
                ->references('cod_usuario')
                ->on('usuarios')
                ->onDelete('cascade');
        });
    }

    /**
     * Deshace la migración realizada con up().
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
