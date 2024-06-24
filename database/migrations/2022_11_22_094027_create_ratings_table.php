<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->morphs('rateable');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->timestamps();
            $table->index('rateable_type');
            $table->index('rateable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('ratings');
    }
}
