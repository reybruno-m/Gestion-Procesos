<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiscTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('misc', function (Blueprint $table) {
            $table->bigIncrements('id');           # Indice Incrementable.
            $table->integer('group');              # Agrupa los valores por categorias.
            $table->string('name');              # Establece un nombre para la opcion.
            $table->integer('value');              # Asigna un valor a la opcion especifica.
            # $table->timestamps();                # Creado / Modificado.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('misc');
    }
}
