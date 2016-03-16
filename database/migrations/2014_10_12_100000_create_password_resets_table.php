<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePasswordResetsTable encargada de migrar la tabla Password_resets
 */
class CreatePasswordResetsTable extends Migration
{

    /**
     * Migra la base de datos.
     * Crea la tabla password-resets para la bbdd giftfinder
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('password_resets');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
