<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMotivosCancelamentoCertificado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motivos_cancelamento_certificado', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->integer('cod_motivo');
            $table->integer('tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('motivosCancelamentoCertificado');
    }
}
