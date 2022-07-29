<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherService 
{


    /**
    * 
    * @param this function take one parma city sting type 
    * @return reponse  accornding to data in json default 
    **/
    public function getWeatherReportByCity($city){
       return $city;
    }
}
