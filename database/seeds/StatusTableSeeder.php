<?php

use Illuminate\Database\Seeder;
use App\Model\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["id" => 1, "descricao" => "Ativo"],
            ["id" => 2, "descricao" => "Inativo"],
            ["id" => 3, "descricao" => "Aguardando Aprovacao"],
            ["id" => 9, "descricao" => "Cotação Ativa"],
            ["id" => 10, "descricao" => "Proposta Ativa"],
            ["id" => 11, "descricao" => "Vencida"],
            ["id" => 12, "descricao" => "Cancelada"],
            ["id" => 13, "descricao" => "Recusada ou Renegociar"],
            ["id" => 14, "descricao" => "Aguardando  Pagamento"],
            ["id" => 15, "descricao" => "Pago"],
            ["id" => 16, "descricao" => "Agendado"],
            ["id" => 17, "descricao" => "Instalado"],
            ["id" => 18, "descricao" => "Virgente"],
            ["id" => 19, "descricao" => "Aberto"],
            ["id" => 20, "descricao" => "Recusado Pagamento"],
            ["id" => 21, "descricao" => "FIPE Aceita"],
            ["id" => 22, "descricao" => "FIPE Sem aceitação"],
            ["id" => 23, "descricao" => "FIPE exige Contingencia (segundo rastreador)"],
            ["id" => 24, "descricao" => "Falha na geração da apólice"],
            ["id" => 25, "descricao" => "Fim de virgência"],
            ["id" => 26, "descricao" => "Movimento - Enviado"],
            ["id" => 27, "descricao" => "Movimento - Retorno"],
            ["id" => 30, "descricao" => "Enviado - Aguardando Retorno"],
            ["id" => 31, "descricao" => "Enviado - Aceito"],
            ["id" => 32, "descricao" => "Enviado - Recusado"],
            ["id" => 33, "descricao" => "Enviado - Sem retorno"],
            ["id" => 40, "descricao" => "Cancelado - Não Enviado"],
            ["id" => 41, "descricao" => "Cancelado - Aguardando Retorno"],
            ["id" => 42, "descricao" => "Cancelado - Aceito"],
            ["id" => 43, "descricao" => "Cancelado - Recusado"],
            ["id" => 44, "descricao" => "Cancelado - Sem retorno"],
        ];
        
        foreach ($datas as $data){
            $status = Status::firstOrCreate(['id'=>$data['id']]);
            $status->update($data);
        }
    }
}
