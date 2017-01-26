<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsRolesTableSeeder::class);
        $this->call(RolesUsuariosTableSeeder::class);
        $this->call(ConfigTablesConfigs::class);
        $this->call(MotivosCancelamentoCertificadoTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(PrecoProdutoTableSeeder::class);
        $this->call(CreateTriggersFuntionsSeeder::class);
        $this->call(CombosProdutosSeeder::class);
        $this->call(TipoVeiculosSeeder::class);
    }
}
