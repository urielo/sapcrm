<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Model\Role;

class RolesUsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);

        $role = Role::find(1);

        $user->attachRole($role);
    }
}
