<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCancelamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancelamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cancelado_id');
            $table->string('cancelado_desc');
            $table->integer('motivo_id');
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
        Schema::drop('cancelamentos');
    }
}
