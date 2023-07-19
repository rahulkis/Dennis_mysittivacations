<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

//$dropCity = rawurlencode($_POST['formatted']);

$title = rawurlencode($_POST['formatteds']);

//$uiid = $_POST['uiid'];

//$str = substr($title, 5);


 $ch = curl_init();

 $url = "https://api.izi.travel/mtg/objects/search?languages=en&query=".$title."";


curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

$headers = array();
$headers[] = "X-Izi-Api-Key: 3cabfbf6-f811-4249-b95e-d53a298672ac";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$results = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);


$get_datas = json_decode($results);

$uiid = $get_datas[0]->uuid;


?>



	 <?php 

     $ch = curl_init();

	 $url = "https://api.izi.travel/mtgobjects/".$uiid."?languages=en,nl,ru";


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

	$get_data = json_decode($result);

	$tour_name = $get_data[0]->content[0]->title;
	$audio_uiid = $get_data[0]->content[0]->audio[0]->uuid;
	$children =   $get_data[0]->content[0]->children;
    
    echo $html2.= "<div id='audio-guide'><h1 style='color: blue;'>
			</h1><h2 style='color: black;'>".$str."</h2></div>
			<a id='backbutton_id'><img src='/images/back.png'></a>
			<div class='audio-summary'>";

     foreach ($children as $homeData) 
			{
              
			$main_uiid = $homeData->uuid;
			$circle_latitude = $homeData->trigger_zones[0]->circle_latitude;
			$circle_longitude = $homeData->trigger_zones[0]->circle_longitude;
			$content_provider_uiid = $homeData->content_provider->uuid;
			$images_uiid = $homeData->images[0]->uuid;
			$title = $homeData->title;
			$desc = $homeData->desc;

			$audio_url = "https://media.izi.travel/".$content_provider_uiid."/".$audio_uiid.".m4a";

      		$image_url = 'https://media.izi.travel/'.$content_provider_uiid.'/'.$images_uiid.'_800x600.jpg';


			  	$lat = $circle_latitude; 
				$long = $circle_longitude; 

				$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_ENCODING, "");
				$curlData = curl_exec($curl);
				curl_close($curl);

				$data = json_decode($curlData);

				$address = $data->results[0]->formatted_address;
				if(empty($address)){
					$address = 'Address Not Found';
				}

				$image = "https://mysitti.com/images/noimage-found.jpeg"; 
        		if(!empty($image_url)){
        		$image = $image_url;
        	}

		
	$html .= "
         
		 <div class='home_list'>
			<div class='home_image'>
              <a target='_blank' id=".$main_uiid." class='audio-tour-data' data-toggle='modal' data-target='#myModal'>
		      <img src= ".$image." width='200' height='200'><img src='https://mysitti.com/images/paybutton.png' class='play-1'>
             </a>
	        </div>

	        <div class='home_data'>
               <div class='home_city'>
             	<h2>".$title."</h2><br/>	
				</div>

			   <div class='home_address'>
			   	<h3>".$address."</h3>
			   </div>

			   <div class='home_address_map'>
			   	<a id=".$main_uiid." class='view-map' data-toggle='modal' data-target='#myModal'>View Map
               </a>
			   </div>

	        </div>
	        <!-- model-popup -->
	        <div class='modal fade' id='myModal' role='dialog'>
			    <div class='modal-dialog'>
			      <div class='modal-content'>
			        <div class='modal-header'>

			        <span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>

			          <button type='button' class='close' data-dismiss='modal'>&times;</button>
			          <h4 class='modal-title'></h4>
			        </div>
			        <div class='modal-body'>
			          
			        </div>
			        <div class='modal-footer'>
			          <button type='button' class='btn btn-default cross-icons' data-dismiss='modal'>Close</button>
			        </div>
			      </div>
			      
			    </div>
			  </div>
	        <!-- end model popup -->
		</div>
		
		
		";

		}

		echo $html;

	  ?>
