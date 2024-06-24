<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mediable_id');
            $table->string('mediable_type', 250);
            $table->string('name', 250)->nullable();
            $table->string('type', 250)->nullable();
            $table->text('path')->nullable();
            $table->string('size', 250)->nullable();
            $table->string('attribute', 250)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id', 'mediable_id', 'mediable_type', 'attribute']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
};
