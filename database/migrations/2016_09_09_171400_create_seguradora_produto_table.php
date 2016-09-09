<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguradoraProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seuradora_produto', function (Blueprint $table) {
            $table->integer('idproduto');
            $table->integer('idseguradora');
            $table->string('prdotudo_susep');
            $table->integer('idade_aceitacao_min')->nullable();
            $table->integer('idade_aceitacao_max')->nullable();
            $table->float('valor_aceitacao_min')->nullable();
            $table->float('valor_aceitacao_max')->nullable();
            $table->boolean('ind_exige_vistoria')->nullable();
            $table->boolean('ind_exige_rastreador')->nullable();
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('seuradora_produto');
    }
}
