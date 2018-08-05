<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipFeedCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_feed_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feed_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('reply_id')->unsigned()->nullable(true);
            $table->text('comment');
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
        Schema::dropIfExists('ship_feed_comments');
    }
}
