<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_productos', function (Blueprint $table) {
            $table->increments('codigo');
            $table->integer('usuario')->unsigned();
            $table->integer('producto')->unsigned();
            $table->timestamps();
            $table->foreign('usuario')
                ->references('cod_usuario')
                ->on('usuarios')
                ->onDelete('cascade');
            $table->foreign('producto')
                ->references('cod_producto')
                ->on('productos')
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
        Schema::dropIfExists('usuarios_productos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
