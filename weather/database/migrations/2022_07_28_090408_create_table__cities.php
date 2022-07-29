<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cities', function (Blueprint $table) {
            $table->id();
            $table->string('city_name');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('zipcode')->nullable();
            $table->string('state')->nullable();   
            //$table->string('state_id');    // we also make tbl for state and pass the id 
            $table->string('country')->nullable();  
            //$table->string('country_id');  // we also make tbl for state and pass the id 
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
        Schema::dropIfExists('tbl_cities');
    }
}
