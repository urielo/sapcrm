<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPrimaryProdutosCombosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos_combos', function (Blueprint $table) {
            $table->primary(['idprodutomaster','idprodutoopcional','tipo_veiculo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos_combos', function (Blueprint $table) {
            //
        });
    }
}
