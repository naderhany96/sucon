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
        Schema::create('slot_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_slot_id')->constrained('doctor_slots')->cascadeOnDelete();
            $table->time('time_from')->nullable();
            $table->time('time_to')->nullable();
            $table->string('day')->nullable();
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
        Schema::dropIfExists('slot_ranges');
    }
};
