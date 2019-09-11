<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
	    $misc_id = array(3, 4, 5); 
	    $user_id = array(1, 2);
	    $origin_id = array(14,15,31,32,34,35,36,40,41,42);

       	$faker = Faker::create();

    	for ($i = 0; $i < 50 ; $i++) 
    	{ 
	    	DB::table('requests')->insert([
	            'description' => $faker->text($maxNbChars = 200),
	            'misc_id' => $misc_id[rand(0,2)],
	            'user_id' => $user_id[rand(0,1)],
	            'origin_id' => $origin_id[rand(0,9)],
	            'created_at' => $faker->dateTime,
	            'updated_at' => $faker->dateTime,

	        ]);
    	}

    }
}

