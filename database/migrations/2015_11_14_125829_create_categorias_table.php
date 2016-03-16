<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCategoriasTable, encargada de migrar la tabla Categorías
 */
class CreateCategoriasTable extends Migration
{
    /**
     * Migra la base de datos.
     * Crea la tabla Categorías para la bbdd giftfinder
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('cod_categoria');
            $table->string('nombre_categoria', 30);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at');
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
        Schema::dropIfExists('categorias');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
