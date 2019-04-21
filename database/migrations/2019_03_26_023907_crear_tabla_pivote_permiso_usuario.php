<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPivotePermisoUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permiso_usuario', function (Blueprint $table) {
            		
            $table->string('permiso_id', 32);
            $table->integer('usuario_id')->unsigned();
            $table->tinyInteger('denegar')->default(0);  

			$table->foreign('permiso_id')
                  ->references('id')->on('permisos')
                  ->onDelete('cascade');

            $table->foreign('usuario_id')
                  ->references('id')->on('usuarios')
                  ->onUpdate('cascade')
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
        Schema::drop('permiso_usuario');
    }
}
