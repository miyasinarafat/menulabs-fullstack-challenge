<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weather', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->string('description');
            $table->decimal('temperature', 10, 8);
            $table->decimal('temperature_min', 10, 8);
            $table->decimal('temperature_max', 10, 8);
            $table->integer('humidity');
            $table->integer('visibility');
            $table->decimal('wind_speed', 10, 8);
            $table->string('city');
            $table->string('country');
            $table->string('icon');
            $table->dateTime('datetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather');
    }
};
