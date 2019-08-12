<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');                                        # Indice Incrementable.
            $table->string('description')->nullable()->default(null);           # Descripcion de la Peticion. 
            $table->integer('id_priority');                                    # Nivel de Prioridad 'table_various'
            $table->integer('id_user');                                      # Indice de Usuario 'table_users'
            $table->integer('id_origin');                                       # Indice del origen 'table_origins'
            $table->timestamps();                                               # Creado / Modificado.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
