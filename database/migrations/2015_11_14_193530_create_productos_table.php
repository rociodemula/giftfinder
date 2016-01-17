<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
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
            $table->timestamps();
            $table->foreign('subcategoria')
                ->references('cod_subcategoria')
                ->on('subcategorias')
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
        Schema::dropIfExists('productos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
