<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('invited_user_id')->unsigned();
            $table->boolean('main')->default(0);
            $table->boolean('view_files')->default(0);
            $table->boolean('upload_files')->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->foreign('invited_user_id')->references('id')->on('users')->onDelete('RESTRICT');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_invitations');
    }
}
