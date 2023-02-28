<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherTables extends Migration
{
    public function up()
    {
        // Create the locations table
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->string('ip_address');
            $table->timestamps();
        });

        // Create the forecasts table
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations');
            $table->date('date');
            $table->string('icon');
            $table->string('description');
            $table->float('max_temp');
            $table->float('min_temp');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop the forecasts table
        Schema::dropIfExists('forecasts');

        // Drop the locations table
        Schema::dropIfExists('locations');
    }
}
