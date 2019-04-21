<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('activo')->default(0);          
            $table->string('salud_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('categoria')->nullable();
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->string('clave_elector')->nullable();            
            $table->boolean('su')->default(false);
            $table->timestamps();
            $table->softDeletes();

        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usuarios');
    }
}
