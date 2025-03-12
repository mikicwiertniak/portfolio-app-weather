<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weather_forecast', function (Blueprint $table) {
            $table->id();
            $table->integer('city_id');
            $table->dateTime('weather_date');
            $table->string('icon');
            $table->string('condition');
            $table->string('description');
            $table->integer('temperature');
            $table->integer('temperature_feel');
            $table->integer('pressure');
            $table->integer('humidity');
            $table->integer('wind_speed');
            $table->string('rain')
                  ->nullable();
            $table->string('snow')
                  ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_forecast');
    }
};
