<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('permissions')->truncate()->cascade();

        DB::table('permissions')->insert([
            [
                'name' => 'vendas-cotacao-gerar',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'vendas-negociacoes',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'vendas-negociacoes-negociar',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'vendas-cotacao',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'vendas-cotacao-pdf',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'gesta-apolice',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'gesta-aprovacao',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'gestao-cobranca',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'gestao-apolice-emitir',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'gestao-apolice-pdf',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'gestao-aprovacao-recusar',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'gestao-cobranca-cancelar',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'gestao-cobranca-salvapagamento',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'gestao-aprovacao-comfirma',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'show-proposta',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'segurado-show',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'menu-vendas',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'menu-gestao',
                'display_name' => '',
                'description' => '',

            ],
            [
                'name' => 'menu-config',
                'display_name' => '',
                'description' => '',

            ],[
                'name' => 'usuarios-gestao',
                'display_name' => '',
                'description' => '',

            ],

        ]);

    }
}
