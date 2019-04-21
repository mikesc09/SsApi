<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaplantillaPersonal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantillas_personal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 80);
            $table->string('apellido_paterno', 80);
            $table->string('apellido_materno', 80);
            $table->string('categiria', 50);
            $table->string('rfc', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantillas_personal');
    }
}
