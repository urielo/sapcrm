<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIdTipoveiculoTablePrecoprodutofipe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('precoprodutofipe', function (Blueprint $table) {
            $table->integer('idtipoveiculo')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('precoprodutofipe', function (Blueprint $table) {
            $table->dropColumn('idtipoveiculo');
        });
    }
}
