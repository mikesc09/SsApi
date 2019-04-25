<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaComisiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comisiones', function (Blueprint $table) {

            $table->increments('id');
            $table->string('motivo_comision');
            $table->string('no_comision');
            $table->string('no_memorandum');
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('es_vehiculo_oficial')->default(false);
            $table->decimal('total', 8,2);
            $table->string('tipo_comision', 5)->comment('para identificacion del tipo de comision y su flujo');
            $table->string('placas')->nullable();
            $table->string('modelo')->nullable();
            $table->boolean('status_comision')->default(false);
            $table->date('fecha');
            $table->decimal('total_peaje', 18,2)->nullable();
            $table->decimal('total_combustible', 18,2)->nullable();
            $table->decimal('total_fletes_mudanza', 18,2)->nullable();
            $table->decimal('total_pasajes_nacionales', 18,2)->nullable();
            $table->decimal('total_viaticos_nacionales', 18,2);
            $table->decimal('total_viaticos_extranjeros', 18,2)->nullable();
            $table->decimal('total_pasajes_internacionales', 18,2)->nullable();       
            $table->string('nombre_subdepartamento');
            $table->integer('organo_responsable_id')->unsigned();
            $table->integer('plantilla_personal_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

        });

       

        Schema::table('comisiones', function($table)
        {
            $table->foreign('organo_responsable_id')->references('id')->on('organos_responsables')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('plantilla_personal_id')->references('id')->on('plantillas_personal')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
           
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comisiones');
    }
}
