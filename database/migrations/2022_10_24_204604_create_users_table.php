<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_type')->default('patient')->comment('patient | doctor');
            $table->string('email');
            $table->boolean('is_active')->default(1);
            $table->string('surname')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone');
            $table->string('dob')->nullable();
            $table->string('device_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->json('pyment_methods')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('password');
            $table->index(['id', 'email', 'phone', 'user_type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
