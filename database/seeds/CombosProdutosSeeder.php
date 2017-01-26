<?php
use \App\Model\Combos;
use Illuminate\Database\Seeder;

class CombosProdutosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            ['idprodutomaster' => 1, 'idprodutoopcional' => 19, 'tipo_veiculo_id' => 1,],
            ['idprodutomaster' => 1, 'idprodutoopcional' => 22, 'tipo_veiculo_id' => 1,],
            ['idprodutomaster' => 15, 'idprodutoopcional' => 4, 'tipo_veiculo_id' => 1,],
            ['idprodutomaster' => 1, 'idprodutoopcional' => 4, 'tipo_veiculo_id' => 4,],
            ['idprodutomaster' => 1, 'idprodutoopcional' => 22, 'tipo_veiculo_id' => 4,],
            ['idprodutomaster' => 15, 'idprodutoopcional' => 4, 'tipo_veiculo_id' => 4,],
        ];
        foreach ($dados as $dado) {
            Combos::firstOrCreate($dado);
        }
    }
}
