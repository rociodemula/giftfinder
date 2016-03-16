<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsuariosTable, encargada de migrar la tabla Usuarios.
 */
class CreateUsuariosTable extends Migration
{
    /**
     * Migra la base de datos.
     * Crea la tabla Usuarion para la bbdd giftfinder
     *
     * @return void
     */
    public function up()
    {
        //Definimos la tabla Usuarios, según las especificaciones:
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('cod_usuario');
            $table->string('nombre_usuario', 30);
            $table->string('password', 60);
            $table->string('localizacion', 100)->nullable();
            $table->decimal('latitud', 9, 6);
            $table->decimal('longitud', 9, 6);
            $table->string('email', 80)->unique();
            $table->string('telefono', 12)->nullable();
            $table->string('movil', 12)->nullable();
            $table->boolean('whatsapp')->default(false);
            $table->boolean('geolocalizacion')->default(false);
            $table->boolean('acepto')->default(true);
            $table->enum('tipo', ['user',
                                  'admin'])
                ->default('user');
            $table->rememberToken();
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
        Schema::dropIfExists('usuarios');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
