<?php	
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Str;
	use it\User;
	use it\Role;
	use it\Origin;

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

	    	$di = Origin::where('name', '=', 'Informatica')->first();
	    	$dp = Origin::where('name', '=', 'Patrimonio')->first();
	    	$dm = Origin::where('name', '=', 'Mantenimiento')->first();
	    	$de = Origin::where('name', '=', 'Estadisticas')->first();

	    	# Creo Usuario Normal.
	    	$user = new User();
			$user->last_name = 'Rey';
			$user->first_name = 'Bruno Martin';
			$user->email = 'informatica@gmail.com';
			$user->password = bcrypt('123456');
			$user->origin_id = $di->id;
			$user->save();
	    	# Relacion Rol/Usuario.
			$user->roles()->attach($role_user);

			# Creo Usuario Normal.
	    	$user = new User();
			$user->last_name = 'Lizzi';
			$user->first_name = 'Jose Luis';
			$user->email = 'mantenimiento@gmail.com';
			$user->password = bcrypt('123456');
			$user->origin_id = $dm->id;
			$user->save();
	    	# Relacion Rol/Usuario.
			$user->roles()->attach($role_user);

			# Creo Usuario Normal.
	    	$user = new User();
			$user->last_name = 'Alberto';
			$user->first_name = 'Lea Edith';
			$user->email = 'patrimonio@gmail.com';
			$user->password = bcrypt('123456');
			$user->origin_id = $dp->id;
			$user->save();
	    	# Relacion Rol/Usuario.
			$user->roles()->attach($role_user);

			# Creo Usuario Estadisticas.
	    	$user = new User();
			$user->last_name = 'Perez';
			$user->first_name = 'Ricardo';
			$user->email = 'estadisticas@gmail.com';
			$user->password = bcrypt('123456');
			$user->origin_id = $de->id;
			$user->save();
			# Relacion Rol/Usuario.			
			$user->roles()->attach($role_statistics);

			# Creo Usuario Administrador.
	    	$user = new User();
			$user->last_name = 'Rey';
			$user->first_name = 'Alejandro';
			$user->email = 'admin@gmail.com';
			$user->password = bcrypt('123456');
			$user->origin_id = null;
			$user->save();
			# Relacion Rol/Usuario.			
			$user->roles()->attach($role_admin);

	    }
	}
