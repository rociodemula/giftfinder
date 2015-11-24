<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategorias', function (Blueprint $table) {
            $table->increments('cod_subcategoria');
            $table->string('nombre_subcategoria',30);
            $table->integer('categoria')->unsigned();
            $table->timestamps();
            $table->foreign('categoria')
                ->references('cod_categoria')
                ->on('categorias')
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
        Schema::dropIfExists('subcategorias');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        // Schema::drop('transaction_types');
    }
}
