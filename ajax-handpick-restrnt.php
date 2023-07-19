<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$dropCity = rawurlencode($_POST['formatted']);

 
		$prepAddr = str_replace(' ','+',$dropCity);
		$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;

		//Curl to get Zomato City id

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://developers.zomato.com/api/v2.1/cities?q=".$dropCity."&lat=".$latitude."&lon=".$longitude."&count=1");

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

		$finalreult = json_decode($result);
        
        $city_id = $finalreult->location_suggestions[0]->id;

        if(count($city_id)>0){
        //Get Zomato collections
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://developers.zomato.com/api/v2.1/collections?city_id=".$city_id."&lat=".$latitude."&lon=".$longitude."&count=5");
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

		$collectionsArray = json_decode($result);

		$get_deals = $collectionsArray->collections;

        }else{

        	echo $html.= 'No Result Found';
        }


	  ?>
     
	
	 <?php 
     foreach ($get_deals as $homeData)
	    {

	    	

	$html .= "<li class='col-sm-3 city-recom' style='float: left; list-style: none; position: relative; width: 290px;'>
				<div class='borderIsan'>
					<a href='category-data.php?collection_id=".$homeData->collection->collection_id."&title=".$homeData->collection->title."&description=".$homeData->collection->description."' >
						<img src='".$homeData->collection->image_url."'>
					</a>

					<a href='".$homeData->collection->url."' >";
					$tourname = $homeData->collection->description; 
					$out = strlen($tourname) > 24 ? substr($tourname,0,24)."..." : $tourname;
					$html .= "<h2 class='nameIsan' style= 'text-align: center;'>".$out."</h2></a>
					<span class='hnd-pick-title'>".$homeData->collection->title."</span>
				</div>
			</li>";
    	}

    	
    	echo $html;


	  ?>
