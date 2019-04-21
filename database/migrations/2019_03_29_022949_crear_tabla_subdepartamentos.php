<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaSubdepartamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subdepartamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_departamento', 200);
            $table->integer('organo_responsable_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('subdepartamentos', function($table)
        {
            $table->foreign('organo_responsable_id')->references('id')->on('organos_responsables')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subdepartamentos');
    }
}
