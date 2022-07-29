<?php
	namespace App\Transformers;

	use League\Fractal\Manager;
	use League\Fractal\Resource\Collection;



	class WeatherTransformer {

		public function singleReport($data){
			return [
				'name'=>$data->name,
				'name'=>$data->city_name,
		        "latitude"=>$data->latitude,
		        "longitude"=>$data->longitude,
		        "zipcode"=>$data->zipcode,
		        "state"=>$data->state,
		        "country"=>$data->country,
		        "weather"=>[
		        	'title'=>$data->title,
		        	'description'=>$data->description,
		        	'icon'=>$data->icon,
		        	'temprature'=>[
		        		'temp'=>$data->temp,
		        		'temp_min'=>$data->temp_min,
		        		'temp_max'=>$data->temp_max,
		        		'feels_like'=>$data->feels_like,
		        		'pressure'=>$data->pressure,
		        		'humidity'=>$data->humidity,
		        		'sea_level'=>$data->sea_level,
		        		'sea_level'=>$data->grnd_level,
		        	],
		        	'visibility'=>$data->visibility,
		        	'wind'=>json_decode($data->wind),
		        	'clouds'=>json_decode($data->clouds),
		        	'dt'=>$data->dt,
		        	'sunrise'=>$data->sunrise,
		        	'sunset'=>$data->sunset,
		        	'timezone'=>$data->timezone,
		        ]
			];
		}

	}
