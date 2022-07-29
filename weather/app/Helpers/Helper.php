<?php
		
 if(!function_exists('getLiveWeatherByCity')){
 	function getLiveWeatherByCity($city){
 		$key=env('OPENWEATHER');
		$url="https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$key";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
 	}
 }