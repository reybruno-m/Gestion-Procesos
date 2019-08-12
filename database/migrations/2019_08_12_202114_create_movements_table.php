<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->bigIncrements('id');                                                # Indice Incrementable.
            $table->integer('id_request');                                              # Indice Solicitud 'table_requests'.
            $table->integer('id_user')->nullable()->default(null);                      # Indice Usuario 'table_users'.
            $table->integer('id_state')->nullable()->default(null);                    # Indice Estado 'table_various'.
            $table->longtext('description')->nullable()->default(null);                 # Descripcion de lo realizado.
            $table->timestamp('taken')->useCurrent();                                  # Fecha de Tomado/Creacion.
            $table->timestamp('finalized')->nullable()->default(null);                 # Fecha de Finalizacion.
            # $table->timestamps();                                                     # Creado / Modificado.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
}
