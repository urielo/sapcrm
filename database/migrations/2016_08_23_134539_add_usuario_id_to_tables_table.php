<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsuarioIdToTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cobranca', function (Blueprint $table) {
            $table->integer('usuario_id')->nullable();
        });

        Schema::table('proposta', function (Blueprint $table) {
            $table->integer('usuario_id')->nullable();
        });
        Schema::table('cotacao', function (Blueprint $table) {
            $table->integer('usuario_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cobranca', function (Blueprint $table) {
            $table->dropColumn('usuario_id');
        });

        Schema::table('proposta', function (Blueprint $table) {
            $table->dropColumn('usuario_id');
        });
        Schema::table('cotacao', function (Blueprint $table) {
            $table->dropColumn('usuario_id');
        });
    }
}
