<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('min_bid');
            $table->unsignedInteger('max_bid');
            $table->boolean('single_bid');
            $table->unsignedInteger('win_1');
            $table->unsignedInteger('win_2');
            $table->unsignedInteger('win_3');
            $table->unsignedInteger('max_players');
            $table->timestamp('game_end')->nullable();
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
        Schema::dropIfExists('games');
    }
}
