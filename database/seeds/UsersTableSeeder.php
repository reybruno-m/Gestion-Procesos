<?php	
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Str;
	use it\User;
	use it\Role;

	class UsersTableSeeder extends Seeder
	{
	    /**
	     * Run the database seeds.
	     *
	     * @return void
	     */
	    public function run()
	    {
	    	# Obtengo los Roles.
	    	$role_user = Role::where('name', '=', 'user')->first();
	    	$role_admin = Role::where('name', '=', 'administrator')->first();
	    	$role_statistics = Role::where('name', '=', 'statistics')->first();

	    	# Creo Usuario Normal.
	    	$user = new User();
			$user->last_name = 'Rey';
			$user->first_name = 'Bruno Martin';
			$user->email = 'user@gmail.com';
			$user->password = bcrypt('123456');
			$user->api_token = Str::random(60);
			$user->save();
	    	# Relacion Rol/Usuario.
			$user->roles()->attach($role_user);

			# Creo Usuario Administrador.
	    	$user = new User();
			$user->last_name = 'Sosa';
			$user->first_name = 'Sergio Andres';
			$user->email = 'administrator@gmail.com';
			$user->password = bcrypt('123456');
			$user->api_token = Str::random(60);
			$user->save();
	    	# Relacion Rol/Usuario.
			$user->roles()->attach($role_admin);

			# Creo Usuario Estadisticas.
	    	$user = new User();
			$user->last_name = 'Perez';
			$user->first_name = 'Ricardo';
			$user->email = 'statistics@gmail.com';
			$user->password = bcrypt('123456');
			$user->api_token = Str::random(60);
			$user->save();
			# Relacion Rol/Usuario.			
			$user->roles()->attach($role_statistics);

	    }
	}
