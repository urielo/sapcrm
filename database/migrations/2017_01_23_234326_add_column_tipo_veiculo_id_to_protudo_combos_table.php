<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTipoVeiculoIdToProtudoCombosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos_combos', function (Blueprint $table) {
          $table->integer('tipo_veiculo_id')->default(1);
          $table->primary('tipo_veiculo_id');
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
