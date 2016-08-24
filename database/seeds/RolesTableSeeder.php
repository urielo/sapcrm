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
            [  'id'=>'1',
                'name' => 'admin',
                'display_name' => 'Administrador',
                'description' => 'Usuariso administradores do sitema',

            ],
            [   'id'=>'2',
                'name' => 'corretor-master',
                'display_name' => 'Corretor Master',
                'description' => 'Conta master do login corretor',

            ],
            [   'id'=>'3',
                'name' => 'corretor-sub',
                'display_name' => 'Corretor Subconta',
                'description' => 'Subconta dos corretores',

            ],
            
            [   'id'=>'4',
                'name' => 'telemarketing',
                'display_name' => 'Telemarketing',
                'description' => 'Usuarios vendedores',

            ],
            [   'id'=>'5',
                'name' => 'cobranca',
                'display_name' => 'Cobrança',
                'description' => '',

            ],
            [   'id'=>'6',
                'name' => 'diretor',
                'display_name' => 'Diretor',
                'description' => '',
            ],
            

        ]);
    }
}
