<?php

use Illuminate\Database\Seeder;

class TipoVeiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            ['dados'=>['idtipoveiculo' => '1', 'desc' => 'Carro', 'status_id' => 1], 'update'=>['codigo' => 3620,]],
            ['dados'=>['idtipoveiculo' => '2', 'desc' => 'Caminhão', 'status_id' => 2], 'update'=>['codigo' => 0,]],
            ['dados'=>['idtipoveiculo' => '4', 'desc' => 'Moto', 'status_id' => 1], 'update'=>['codigo' => 4068,]],
            ['dados'=>['idtipoveiculo' => '8', 'desc' => 'Taxi', 'status_id' => 2], 'update'=>['codigo' => 0,]],
        ];

        foreach ($dados as $dado){
            \App\Model\TipoVeiculos::firstOrCreate($dado['dados'])->update($dado['update']);
        }
    }
}
