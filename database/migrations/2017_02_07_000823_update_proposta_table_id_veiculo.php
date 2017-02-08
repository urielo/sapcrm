<?php
use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class UpdatePropostaTableIdVeiculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('UPDATE proposta SET veiculo_id = cotacao.veicid from cotacao where cotacao.idcotacao = proposta.idcotacao;');
        DB::unprepared('UPDATE proposta SET created_at = dtcreate ;');
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
