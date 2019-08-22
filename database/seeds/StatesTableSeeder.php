<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$states = array(
    		'Pendiente',
    		'Tomado',
    		'Pausado',
    		'Finalizado',
    		'Rechazado',
    	);

    	foreach ($states as $st) {
	    	DB::table('states')->insert([
	            'name' => $st,
	        ]);
    	}
    }
}
