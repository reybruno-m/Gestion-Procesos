<?php

use Illuminate\Database\Seeder;

class DepartamentsTableSeeder extends Seeder
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
			"Consultorios Externos",
			"Contabilidad",
			"Direccion",
			"Enfermeria",
			"Informatica",
			"Mantenimiento",
			"Odontologia",
			"Patrimonio",
			"Sala 1",
			"Sala 2",
			"Sala 3",
			"Sala 4",
			"Salud Mental",
			"Servicio Social",
			"Traumatologia",
			"Tumores.",
			"Turnos",
			"Vacunatorio",
			"Estadisticas"
	 	);

		# Listado Inicial de Sectores.

        for ($i = 0; $i < count($sectores) ; $i++) 
        { 
        	DB::table('departaments')->insert([
	            'name' => $sectores[$i],	# Nombre.
	        ]);
        }
    }
}
