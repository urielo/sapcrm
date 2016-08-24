<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApoliceSeguradoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apolice_seguradora', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_proposta_sap")->nullable();
            $table->integer("id_config_seguradora")->nullable();
            $table->integer("id_apolice_seguradora")->nullable();
            $table->integer("cd_apolice_seguradora")->nullable();
            $table->integer("id_cotacao_seguradora")->nullable();
            $table->integer("id_proposta_seguradora")->nullable();
            $table->integer("id_endosso_seguradora")->nullable();
            $table->string("dt_instalacao_rastreador",10)->nullable();
            $table->string("dt_ativa_rastreador",10)->nullable();
            $table->string("dt_inicio_comodato",10)->nullable();
            $table->string("dt_fim_comodato",10)->nullable();
            $table->integer("cd_retorno_seguradora")->nullable();
            $table->text("nm_retorno_seguradora")->nullable();
            $table->timestamp("dt_criacao")->nullable();
            $table->timestamp("dt_update")->nullable();
            $table->text("xml_saida")->nullable();
            $table->text("xml_retorno")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('apolice_seguradora');
    }
}
