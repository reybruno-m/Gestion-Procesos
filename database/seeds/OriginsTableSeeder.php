<?php

use Illuminate\Database\Seeder;

class OriginsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$sectores = array(
			"Compras",
			"Contabilidad",
			"Estadisticas",
			"Informatica",
			"Mantenimiento",
			"Patrimonio",
			"Ventas",
    	);

    	$personas = array(
			"Aversa Agustin",
			"Lizzi Jose Luis", 
			"Olmos Washington",
			"Rey Bruno Martin",
			"Sosa Sergio",
		);

		# Listado Inicial de Sectores.

        for ($i = 0; $i < count($sectores) ; $i++) 
        { 
        	DB::table('origins')->insert([
	            'misc_id' => 2,				# Indica el tipo de origen, tomado de misc, Inicialmente (1) Persona (2) Sector
	            'name' => $sectores[$i],	# Nombre.
	        ]);
        }

		# Listado Inicial de Personas.

        for ($j = 0; $j < count($personas) ; $j++) 
        { 
        	DB::table('origins')->insert([
	            'misc_id' => 1,				# Indica el tipo de origen, tomado de misc, Inicialmente (1) Persona (2) Sector
	            'name' => $personas[$j],	# Nombre.
	        ]);
        }
	}
}






