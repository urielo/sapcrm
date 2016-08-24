<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartoes', function (Blueprint $table) {
            $table->increments("id");
            $table->string("bandeira")->nullable();
            $table->string("numero")->nullable();
            $table->string("validade",6)->nullable();
            $table->string("cvv",3)->nullable();
            $table->string("clicpfcnpj")->nullable();
            $table->string("nome")->nullable();
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
        Schema::drop('cartoes');
    }
}
