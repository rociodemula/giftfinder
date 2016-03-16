<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsuariosProductosTable, encargada de migrar la tabla Usuarios_productos.
 */
class CreateUsuariosProductosTable extends Migration
{
    /**
     * Migra la base de datos.
     * Crea la tabla Usuarios_productos para la bbdd giftfinder
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_productos', function (Blueprint $table) {
            $table->increments('codigo');
            $table->integer('usuario')->unsigned();
            $table->integer('producto')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at');
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
     * Deshace la migración realizada con up().
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
