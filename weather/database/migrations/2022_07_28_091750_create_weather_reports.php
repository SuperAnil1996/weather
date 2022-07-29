<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('city_id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->float('temp');
            $table->float('temp_min');
            $table->float('temp_max');
            $table->float('feels_like');
            $table->float('pressure');
            $table->float('humidity');
            $table->float('sea_level');
            $table->float('grnd_level');
            $table->float('visibility');
            $table->text('wind');
            $table->text('clouds');
            $table->string('dt');
            $table->string('sunrise');
            $table->string('sunset');
            $table->string('timezone');
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
        Schema::dropIfExists('weather_reports');
    }
}
