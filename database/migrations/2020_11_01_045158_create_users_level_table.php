<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_level', function (Blueprint $table) {
            $table->string('level',50);
            $table->string('value');

            $table->softDeletes();
            $table->primary('level');
        });
        Schema::table('users', function(Blueprint $table)
        {
            $table->string('user_level_id',50);
            $table->foreign('user_level_id')->references('level')->on('users_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_level');
    }
}
