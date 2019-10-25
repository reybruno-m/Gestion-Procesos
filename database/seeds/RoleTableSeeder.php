<?php

use Illuminate\Database\Seeder;
use it\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = "user";
        $role->description = "usuario normal.";
        $role->save();

        $role = new Role();
        $role->name = "administrator";
        $role->description = "usuario administrador.";
        $role->save();


        $role = new Role();
        $role->name = "statistics";
        $role->description = "usuario impresiones, estadisticas.";
        $role->save();


    }
}
