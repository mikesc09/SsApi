<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaLugaresComisiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('lugares_comisiones', function(Blueprint $table)
		{

			$table->increments('id');
			$table->integer('comision_id')->unsigned();
            $table->string('sede'); //a que lugar del instituto o lugar que asistira
            $table->date('fecha_inicio');
            $table->date('fecha_termino');
            $table->decimal('cuota_diaria')->unsigned();
            $table->integer('total_dias')->unsigned();
            $table->boolean('es_nacional')->default(false);
            $table->integer('periodo')->unsigned(); // creo que esto es igual al campo total_dias
            $table->date('termino'); // se agrega pero presuntamente también hace referencia a la fecha_termino
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('lugares_comisiones', function($table)
        {
            $table->foreign('comision_id')->references('id')->on('comisiones')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lugares_comisiones');
    }
}
