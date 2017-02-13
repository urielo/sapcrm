<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCotacaoVeiculosDados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::unprepared('UPDATE cotacao SET code_fipe = veiculosegurado.veiccodfipe,
//                        ano_veiculo = veiculosegurado.veicano,
//                        combustivel_id = veiculosegurado.veictipocombus, 
//                        tipo_veiculo_id = veiculosegurado.veiccdveitipo,
//                        ind_veiculo_zero = veiculosegurado.veicautozero,
//                        validade = dtvalidade,
//                        created_at = cotacao.dtcreate
//                        from veiculosegurado where cotacao.veicid = veiculosegurado.veicid;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
