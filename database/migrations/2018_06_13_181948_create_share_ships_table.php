<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareShipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_ships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('to_user_id');
            $table->integer('ship_id');
            $table->boolean('status')->default(0)->comment('0=pending,1=approve,2=reject');

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
        Schema::dropIfExists('share_ships');
    }
}
