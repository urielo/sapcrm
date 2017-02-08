<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnClicpfcnpjToSeguradoIdOnCotacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotacao', function (Blueprint $table) {
            $table->renameColumn('clicpfcnpj','segurado_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotacao', function (Blueprint $table) {
            //
        });
    }
}
