<!DOCTYPE html>
<html>
<body onload="getLocation()">

<p>Click the button to get your coordinates.</p>


<p id="demo"></p>

<script>
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude;
}
</script>

<?php 
$curl = curl_init();

	curl_setopt_array($curl, array(
		
		CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?latlng='30.720654099999997','76.8432551'&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: b38c85f9-9968-4e9f-83ed-4512d47b02ec",
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$response = json_decode($response, true);
		// print_r($response['results'][0]['formatted_address']);

		////////////////////////////////////////////////////////////////////////////////////////////
		// Important Note :=> Please do not change the sequence of $address_arr. It contains      //
		// locality as city, administrative_area_level_1 as state, country as country and         //
		// postal_code as zip code. If you add new type put is at end and remember it's indexing  //
		////////////////////////////////////////////////////////////////////////////////////////////
		$address_arr = ['locality', 'administrative_area_level_1', 'country', 'postal_code'];
		$formatted_address = [];
		foreach ($address_arr as $type) {
			foreach ($response['results'][0]['address_components'] as $key => $address_component) {
				// print_r($address_component);
				if (array_search($type, $address_component['types']) !== false) {
					$postal_code = $response['results'][0]['address_components'][$key]['long_name'];
					array_push($formatted_address, $postal_code);
				}
			}
		}
		array_push($formatted_address, str_replace(', ', ',', $response['results'][0]['formatted_address']));
		// print_r($formatted_address);

	}
echo $formatted_address['0'];
echo $formatted_address['2'];
?>

</body>
</html>
