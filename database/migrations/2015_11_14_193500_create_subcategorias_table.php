<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSubcategoriasTable, encargada de la migración de la tabla Subcategorías.
 */
class CreateSubcategoriasTable extends Migration
{
    /**
     * Migra la base de datos.
     * Crea la tabla Subcategorías para la bbdd giftfinder
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategorias', function (Blueprint $table) {
            $table->increments('cod_subcategoria');
            $table->string('nombre_subcategoria',30);
            $table->integer('categoria')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at');
            $table->foreign('categoria')
                ->references('cod_categoria')
                ->on('categorias')
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
        Schema::dropIfExists('subcategorias');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        // Schema::drop('transaction_types');
    }
}
