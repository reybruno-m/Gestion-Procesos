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
            $table->bigIncrements('id');                                               # Indice Incrementable.
            
            $table->bigInteger('request_id')->nullable()->unsigned();                  # Indice Solicitud 'table_requests'.
            $table->foreign('request_id')->references('id')->on('requests');

            $table->bigInteger('user_id')->nullable()->unsigned();                     # Indice Usuario 'table_users'.
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->bigInteger('state_id')->nullable()->unsigned();                    # Indice Estado 'table_states'.
            $table->foreign('state_id')->references('id')->on('states');
            
            $table->longtext('description')->nullable()->default(null);                # Descripcion de lo realizado.
            $table->timestamp('taken')->useCurrent();                                  # Fecha de Tomado/Creacion.
            $table->timestamp('finalized')->nullable()->default(null);                 # Fecha de Finalizacion.
            # $table->timestamps();                                                    # Creado / Modificado.
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

/*
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');                                        # Indice Incrementable.
            $table->string('description')->nullable()->default(null);           # Descripcion de la Peticion. 
            $table->bigInteger('id_priority')->nullable()->unsigned();          # Nivel de Prioridad 'table_various'
            $table->foreign('id_priority')->references('id')->on('misc');       
            $table->bigInteger('id_user')->nullable()->unsigned();              # Indice de Usuario 'table_users'
            $table->foreign('id_user')->references('id')->on('users');
            $table->bigInteger('id_origin')->nullable()->unsigned();            # Indice del origen 'table_origins'
            $table->foreign('id_origin')->references('id')->on('origins');      
            $table->timestamps();                                               # Creado / Modificado.
        });
    }
*/