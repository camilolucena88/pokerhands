<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('round_id');
            $table->integer('user_id');
            $table->integer('score_player_1');
            $table->integer('score_player_2');
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
        Schema::dropIfExists('wins');
    }
}
