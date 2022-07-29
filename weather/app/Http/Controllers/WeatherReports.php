<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use App\Services\WeatherService;
use App\Models\City;
use App\Models\WeatherReport;
use App\Transformers\WeatherTransformer;

class WeatherReports extends Controller
{
    // public function __construct(WeatherService $WeatherService){
    //     $this->weatherService=$WeatherService;
    // }    
    /**
    * Responsible for city weather 
    * @param this function take one parma city sting type 
    * @return reponse  accornding to data in json default 
    **/
    public function cityReport(Request $request){
        try{
            $validator=Validator::make($request->all(),[
                "city"=>"required",
            ]);
            if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'message'=>$validator->errors()->first(),
               ],400);
            }
            $result=City::where('city_name',$request->city)->first();
            if($result){
                $respoData=$this->getWeatherResponseData($result->id);
                if($respoData){
                    $return=(new WeatherTransformer ())->singleReport($respoData);
                    return response()->json([
                        'status'=>200,
                        'data'=>$return,
                    ],200);
                }else{
                    $response=json_decode(getLiveWeatherByCity($request->city));
                    if($response->cod==200){
                        $this->storeWeatherReport($result->id,$response);
                        $respoData=$this->getWeatherResponseData($result->id);
                        $return=(new WeatherTransformer ())->singleReport($respoData);
                        return response()->json([
                            'status'=>200,
                            'data'=>$return,
                        ],200);
                    }else{
                        return response()->json([
                            'status'=>404,
                            'message'=>"Oops! The city you entered could not be found, please try again."
                        ],404); 
                    }
                }   
            }else{
                $response=json_decode(getLiveWeatherByCity($request->city));
                if($response->cod==200){
                    $city= new City();
                    $city->city_name=$response->name;
                    $city->longitude=$response->coord->lon;
                    $city->latitude=$response->coord->lat;
                    $city->country=$response->sys->country;
                    $city->save();
                    $this->storeWeatherReport($city->id,$response);
                    $respoData=$this->getWeatherResponseData($city->id);
                    $return=(new WeatherTransformer ())->singleReport($respoData);
                    return response()->json([
                        'status'=>200,
                        'data'=>$return,
                    ],200);

                }else{
                    return response()->json([
                        'status'=>404,
                        'message'=>"Oops! The city you entered could not be found, please try again."
                    ],404); 
                }
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>404,
                'message'=>$e->getMessage(), 
            ],404);
        }
    }

    /**
     *  
     * 
    **/
    public function getWeatherResponseData($cityId){
        return City::join('weather_reports','weather_reports.city_id','=','tbl_cities.id')
        ->select('tbl_cities.*','weather_reports.*')
        ->where('tbl_cities.id',$cityId)->where(\DB::raw('CAST(weather_reports.created_at as date)'),date('Y-m-d'))
        ->orderBy('weather_reports.id',"DESC")->first();
    }

    public function storeWeatherReport($city_id,$response){
        //print_r($response->main->grnd_level??0);  die();
        $weatherReport= new WeatherReport();
        $weatherReport->city_id=$city_id;
        $weatherReport->title=$response->weather[0]->main;
        $weatherReport->description=$response->weather[0]->description;
        $weatherReport->icon=$response->weather[0]->icon;
        $weatherReport->temp=$response->main->temp;
        $weatherReport->temp_min=$response->main->temp_min;
        $weatherReport->temp_max=$response->main->temp_max;
        $weatherReport->feels_like=$response->main->feels_like;
        $weatherReport->pressure=$response->main->pressure;
        $weatherReport->humidity=$response->main->humidity;
        $weatherReport->grnd_level=$response->main->grnd_level??0;
        $weatherReport->sea_level=$response->main->sea_level??0;
        $weatherReport->visibility=$response->visibility;
        $weatherReport->wind=json_encode($response->wind);
        $weatherReport->clouds=json_encode($response->clouds);
        $weatherReport->dt=$response->dt;
        $weatherReport->sunrise=$response->sys->sunrise;
        $weatherReport->sunset=$response->sys->sunset;
        $weatherReport->timezone=$response->timezone;
        return $weatherReport->save();
    }

}
