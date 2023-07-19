<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$dropCity = $_POST['formatted'];

 
		$prepAddr = str_replace(' ','+',$dropCity);
		$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
       
		$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".rawurlencode($dropCity)."&lat=".$latitude."&lng=".$longitude."&query=restaurant+deals&division=".rawurlencode($dropCity)."&offset=0&limit=5&locale=en_US";
		
		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
		$get_deals = $get_all_data['deals'];


		$address = $dropCity; 
		$prepAddr = str_replace(' ','+',$address);
		$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
		$output= json_decode($geocode);
		 $latitude = $output->results[0]->geometry->location->lat;
		 $longitude = $output->results[0]->geometry->location->lng;
        
        
		$collection_id = $_GET['collection_id'];
		$title = $_GET['title'];
		$description = $_GET['description'];

		$urls = "https://developers.zomato.com/api/v2.1/search?q=".$prepAddr."&count=5&lat=".$latitude."&lon=".$longitude;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $urls);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


		$headers = array();
		$headers[] = "Accept: application/json";
		$headers[] = "User-Key: 99868269a38bfabc5532b10a32fa75c7";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
        
       $data = json_decode($result); 

  
        $get_deals = $data->restaurants;

        if (!count($get_deals)) {
	    	$urls = "https://developers.zomato.com/api/v2.1/search?q=".$location."&count=5&order=desc&lat=".$latitude."&lon=".$longitude;
	    	$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $urls);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			$headers = array();
			$headers[] = "Accept: application/json";
			$headers[] = "User-Key: 99868269a38bfabc5532b10a32fa75c7";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
			    echo 'Error:' . curl_error($ch);
			}
			curl_close ($ch);
		  	$data = json_decode($result); 
		    $get_deals = $data->restaurants;
	    }


	  	?>
     
	
	 <?php 
     foreach ($get_deals as $homeData)
	    {

    	$image = "https://mysitti.com/images/noimage-found.jpeg"; 
    		if(!empty($homeData->restaurant->thumb)){
    		$image = $homeData->restaurant->thumb;
    	}
    	
	$price = $homeData['options'][0]['price']['formattedAmount'];
	    $value = $homeData['options'][0]['value']['formattedAmount'];
	    $discountPercent = $homeData['options'][0]['discountPercent'];
	    $endAt = 	$homeData['options'][0]['endAt'];
        $endDate = date('d/m/Y', strtotime($endAt));
        $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
        $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
        $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
        $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
    	
	$html .= "<li class='col-sm-3 city-recom' style='float: left; list-style: none; position: relative; width: 290px;'>
				<div class='borderIsan hotelandingDeal'>
					<a href='".$homeData['dealUrl']."' target='_blank'>
						<img src='".$homeData['grid4ImageUrl']."'>
					</a>

					<a href='".$homeData['dealUrl']."' target='_blank'>";
					$tourname = $homeData['merchant']['name']; 
					$out = strlen($tourname) > 24 ? substr($tourname,0,24)."..." : $tourname;
					$html .= "<h2 class='discountPercent'>".$discountPercent. '% Off'."</h2><h1 class='nameIsan hotelandingnameIsan' style= 'text-align: center;'>".$out."</h1></a>
					<h1 class='addres1'>".$streetAddress1."</h1>
					<h1 class='addres2'>".$streetAddress2."</h1>
					<h1 class='cityNamelanding'>".$cityName.', '.$postalCode."</h1>
					<h1 class='pricelanding'>".$price. "</h1><h2 class='valuelanding'>".$value."</h2>
					<h1 class='saleend'>".'Sales Ends: ' .$endDate."</h1>


					
				</div>
			</li>";
    	}
    	
    	
    	echo $html;


	  ?>


	  
