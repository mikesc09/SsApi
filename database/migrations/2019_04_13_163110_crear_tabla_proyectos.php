<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProyectos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_proyecto', 100);
            $table->string('responsable', 150);
            $table->integer('plantilla_personal_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('proyectos', function($table)
        {
            $table->foreign('plantilla_personal_id')->references('id')->on('plantillas_personal')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
}
