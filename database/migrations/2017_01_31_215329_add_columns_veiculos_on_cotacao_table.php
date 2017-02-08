<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsVeiculosOnCotacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotacao',function (Blueprint $table){
            $table->string('code_fipe',20)->nullable();
            $table->integer('ano_veiculo')->nullable();
            $table->integer('combustivel_id')->nullable();
            $table->integer('tipo_veiculo_id')->nullable();
            $table->integer('ind_veiculo_zero')->nullable();
            $table->timestamp('validade')->nullable();
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
        //
    }
}
