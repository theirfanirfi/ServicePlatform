<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('ship_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->string('port');
            $table->date('date');
            $table->dateTime('eta');
            $table->dateTime('etb');
            $table->dateTime('etd');
            $table->boolean('closed')->default(0);
            $table->timestamps();

            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
