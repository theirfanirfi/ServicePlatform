<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectFeedCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_feed_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feed_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('reply_id')->unsigned()->nullable();
            $table->text('comment');
            $table->timestamps();

            $table->foreign('feed_id')->references('id')->on('project_feeds')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('reply_id')->references('id')->on('project_feed_comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_feed_comments');
    }
}
