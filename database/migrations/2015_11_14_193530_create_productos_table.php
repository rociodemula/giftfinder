<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProductosTable, encargada de la migración de la tabla Productos.
 */
class CreateProductosTable extends Migration
{
    /**
     * Migra la base de datos.
     * Crea la tabla Productos para la bbdd giftfinder
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('cod_producto');
            $table->integer('subcategoria')->unsigned();
            $table->string('nombre_producto', 30);
            $table->string('descripcion')->nullable();
            $table->string('foto_producto')->nullable();
            $table->string('link_articulo')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at');
            $table->foreign('subcategoria')
                ->references('cod_subcategoria')
                ->on('subcategorias')
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
        Schema::dropIfExists('productos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
