<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('role_usuario')->truncate();
//        DB::table('roles')->truncate();
        DB::table('roles')->insert([
            [  
                'name' => 'admin',
                'display_name' => 'Administrador',
                'description' => 'Usuariso administradores do sitema',

            ],
            [  
                'name' => 'corretor-master',
                'display_name' => 'Corretor Master',
                'description' => 'Conta master do login corretor',

            ],
            [  
                'name' => 'corretor-sub',
                'display_name' => 'Corretor Subconta',
                'description' => 'Subconta dos corretores',

            ],
            
            [   
                'name' => 'telemarketing',
                'display_name' => 'Telemarketing',
                'description' => 'Usuarios vendedores',

            ],
            [   
                'name' => 'cobranca',
                'display_name' => 'Cobrança',
                'description' => '',

            ],
            [   
                'name' => 'diretor',
                'display_name' => 'Diretor',
                'description' => '',
            ],
            

        ]);
    }
}
