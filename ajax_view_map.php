<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$uuid = $_POST['formatted'];

    
   $ch = curl_init();

   $url = "https://api.izi.travel/mtgobjects/".$uuid."?languages=en,nl,ru";

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


	$headers = array();
	$headers[] = "X-Izi-Api-Key: 3cabfbf6-f811-4249-b95e-d53a298672ac";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);

	$get_deals = json_decode($result);

    $location = $get_deals[0]->location;
    $latitude =  $location->latitude;
    $longitude = $location->longitude;

 
    $html .= "

		 <div class='home_list'>
		 <div id='map'></div>
		    <script>
		      function initMap() {
		        var uluru = {lat: ".$latitude.", lng: ".$longitude."};
		        var map = new google.maps.Map(document.getElementById('map'), {
		          zoom: 4,
		          center: uluru
		        });
		        var marker = new google.maps.Marker({
		          position: uluru,
		          map: map
		        });
		      }
		    </script>
		    <script async defer
		    src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCJ8bxQApwVyI3IpuLbavOPYvHnuHbnsKc&callback=initMap'>
		    </script>
				   
				</div>
				
				";

	echo $html;


?>
     
