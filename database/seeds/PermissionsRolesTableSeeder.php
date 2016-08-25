<?php

use Illuminate\Database\Seeder;

use App\Model\Role;
use App\Model\Permission;

class PermissionsRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::find(1);

        $permission = Permission::all();

        $role->attachPermissions($permission);
    }
}
