
<?php

include("Query.Inc.php") ;
$Obj = new Query($DBName) ;

$url = "https://maps.google.com/maps/api/geocode/json?latlng=".$_POST['lat'].",".$_POST['lng']."&key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&sensor=false";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			 // echo "<pre>"; print_r($response_a); die('dddd');
			$lat = $response_a->results[0]->geometry->location->lat;
			$long = $response_a->results[0]->geometry->location->lng;	

			$i = 0;

			foreach($response_a->results[0]->address_components as $abc)
			{
				if($abc->types[0] == "country")
				{
					$country = $response_a->results[0]->address_components[$i]->long_name;
				}
				
				if($abc->types[0] == "administrative_area_level_1")
				{
					$state = $response_a->results[0]->address_components[$i]->long_name;
				}

				if($abc->types[0] == "locality")
				{
					$city = $response_a->results[0]->address_components[$i]->long_name;
				}


				$i++;


			}

$_SESSION['city_name'] = $city;
	 $_SESSION['formatteds'] = $city;
echo $city;
			?>