<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email', 255);
            $table->string('name', 255);
            $table->string('mobile_phone', 255);
            $table->string('password', 255);
            $table->boolean('isActive');
            $table->boolean('isSuperAdmin')->default(0);
            $table->timestamps();

            $table->index(['id', 'email', 'mobile_phone', 'isActive', 'isSuperAdmin']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
