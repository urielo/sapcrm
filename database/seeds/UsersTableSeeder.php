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
        DB::table('usuarios')->truncate();
        
        DB::table('usuarios')->insert([
            
            [
                'nome'=>'admin',
                'email'=>'suporte@seguroautopratico.com.br',
                'password'=>  bcrypt('adminsap'),
                'idtipousuario'=>1,
                'idstatus'=>1,
                
            ],
            [
                'nome'=>'uriel',
                'email'=>'uriel@seguroautopratico.com.br',
                'password'=>  bcrypt('09266087467'),
                'idtipousuario'=>1,
                'idstatus'=>1,

            ],
            
        ]);
        
        
    }
}
