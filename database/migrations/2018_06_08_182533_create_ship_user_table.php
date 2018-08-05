<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer( 'ship_id');
            $table->integer( 'user_id');

           /* 1 = accepted, 2 = rejected, else = pending */
            $table->integer( 'status')->default(3);
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
        Schema::dropIfExists('ship_users');
    }
}
