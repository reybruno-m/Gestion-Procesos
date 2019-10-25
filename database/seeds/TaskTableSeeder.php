<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TaskTableSeeder extends Seeder
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

    	for ($i = 1; $i <= 50 ; $i++) 
    	{ 

            $user = $user_id[rand(0,1)];
            $dateTime = $faker->dateTime;

	    	DB::table('tasks')->insert([
	            'description' => $faker->text($maxNbChars = 100),
	            'misc_id' => $misc_id[rand(0,2)],
	            'user_id' => $user,
	            'origin_id' => $origin_id[rand(0,9)],
	            'created_at' => $dateTime,
	            'updated_at' => $dateTime,

	        ]);

            DB::table('movements')->insert([
                'task_id' => $i,
                'user_id' => $misc_id[rand(0,2)],
                'state_id' => $userId,
                'taken' => $dateTime,
            ]); 

    	}

    }
}
