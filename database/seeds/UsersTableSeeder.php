<?php
	
	use Illuminate\Database\Seeder;

	class UsersTableSeeder extends Seeder
	{
	    /**
	     * Run the database seeds.
	     *
	     * @return void
	     */
	    public function run()
	    {
	        DB::table('users')->insert([
	            'last_name' => 'Rey',
	            'first_name' => 'Bruno Martin',
	            'email' => 'brunomartinrey@gmail.com',
	            'password' => bcrypt('39029759'),
	        ]);
	        DB::table('users')->insert([
	            'last_name' => 'Auditor',
	            'first_name' => '',
	            'email' => 'auditor@gmail.com',
	            'password' => bcrypt('laravel'),
	        ]);
	    }
	}
