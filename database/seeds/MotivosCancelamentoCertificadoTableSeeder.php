<?php

use Illuminate\Database\Seeder;
use App\Model\MotivosCancelamentoCertificado;


class MotivosCancelamentoCertificadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        MotivosCancelamentoCertificado::create(['tipo' => 1, 'cod_motivo' => 1, 'descricao' => "CANCELADO POR SOLICITAÇÃO"]);
        MotivosCancelamentoCertificado::create(['tipo' => 1, 'cod_motivo' => 2, 'descricao' => "CANCELAMENTO SOLICITADO PELO CLIENTE NO REPRESENTANTE"]);
        MotivosCancelamentoCertificado::create(['tipo' => 1, 'cod_motivo' => 3, 'descricao' => "CANCELADO POR SOLICITAÇÃO - DIFICULDADES FINANCEIRAS"]);
        MotivosCancelamentoCertificado::create(['tipo' => 2, 'cod_motivo' => 1, 'descricao' => "CANCELADO POR EXPIRAÇÃO DO CONTRATO"]);
        MotivosCancelamentoCertificado::create(['tipo' => 3, 'cod_motivo' => 1, 'descricao' => "CANCELADO POR INADIMPLÊNCIA"]);
        MotivosCancelamentoCertificado::create(['tipo' => 3, 'cod_motivo' => 2, 'descricao' => "CANCELADO POR INADIMPLÊNCIA PELA ROTINA DE FATURAMENTO"]);
        MotivosCancelamentoCertificado::create(['tipo' => 4, 'cod_motivo' => 1, 'descricao' => "CANCELADO POR OCORRENCIA DE SINISTRO"]);
        MotivosCancelamentoCertificado::create(['tipo' => 5, 'cod_motivo' => 1, 'descricao' => "CANCELADO POR PRODUTO NÃO ACEITO CANCELADO POR VALOR DO PREMIO NÃO CORRESPONDENTE AO"]);
        MotivosCancelamentoCertificado::create(['tipo' => 5, 'cod_motivo' => 2, 'descricao' => "PRODUTO"]);
    }
}
