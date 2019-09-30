<?php

use Illuminate\Database\Seeder;

class MiscsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	/*Tipos de Origenes Iniciales*/

    	DB::table('misc')->insert([
            'group' => 1,
            'name' => 'Persona',
        ]);
    	DB::table('misc')->insert([
            'group' => 1,
            'name' => 'Sector Seccion',
        ]);

        /*Tipos de Prioridades*/

    	DB::table('misc')->insert([
            'group' => 2,
            'name' => 'Baja',
        ]);
    	DB::table('misc')->insert([
            'group' => 2,
            'name' => 'Intermedia',
        ]);
    	DB::table('misc')->insert([
            'group' => 2,
            'name' => 'Alta',
        ]);
    }
}
