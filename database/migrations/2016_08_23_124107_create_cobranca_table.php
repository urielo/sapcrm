<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCobrancaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobranca', function (Blueprint $table) {
            $table->integer("id");
            $table->integer("idproposta");
            $table->string("numpagamento",100);
            $table->string("operadora",120);
            $table->string("dtvencimento",8);
            $table->string("dtpagamento",8);
            $table->integer("idstatus");
            $table->integer("diasdemais");
            $table->float("vlcartao");
            $table->integer("idcartao");
            $table->integer("parcelas");
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
        Schema::drop('cobranca');
    }
}
