<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCorrcomissaominToCorretorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corretor', function (Blueprint $table) {
            $table->float('corrcomissaomin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corretor', function (Blueprint $table) {
            $table->dropColumn('corrcomissaomin')->nullable();
        });
    }
}
