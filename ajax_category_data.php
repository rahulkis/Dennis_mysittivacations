<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$location = rawurlencode($_POST['changeValue']);


$prepAddr = str_replace(' ','+',$location);
$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
$output= json_decode($geocode);
$latitude = $output->results[0]->geometry->location->lat;
$longitude = $output->results[0]->geometry->location->lng;

if (empty($latitude) && empty($longitude) && empty($location)) {
	$location = rawurlencode($_POST['changeValue']);
	$prepAddr = str_replace(' ','+',$location);
	$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
}


$collection_id = $_POST['collection_data'];


	if($location != "") {
		$urls = "https://developers.zomato.com/api/v2.1/search?q=".$location."&count=30&order=desc&lat=".$latitude."&lon=".$longitude."&collection_id=".$collection_id;
	}

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
	    	$urls = "https://developers.zomato.com/api/v2.1/search?q=".$location."&count=30&order=desc&lat=".$latitude."&lon=".$longitude;
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

        $html = "";

		foreach($get_deals as $homeData){
        
        $image = "https://mysitti.com/images/noimage-found.jpeg"; 
        if(!empty($homeData->restaurant->thumb)){
        	$image = $homeData->restaurant->thumb;
        }
       
		 $html .= "

		 <div class='home_list'>
			<div class='home_image'>
			<a href=".$homeData->restaurant->url." target='_blank'>

		      <img src= ".$image." width='250' height='200'>
		      
              </a>
			 

	        </div>

	        <div class='home_data'>
             <h2>".$homeData->restaurant->name."</h2>
               <div class='home_city'>
					<span>".$homeData->restaurant->location->locality."</span><br>
					<h3>".$homeData->restaurant->location->city."</h3><br>
					<h4>".$homeData->restaurant->location->address."</h4><br>

					<h4>CUISINES:".$homeData->restaurant->cuisines."</h4><br>
					<h4>COST FOR TWO: ".$homeData->restaurant->currency." ".$homeData->restaurant->average_cost_for_two."</h4><br>

					<div class='container'>
					  <button type='button' class='vewmenu' data-toggle='modal' data-target='#myModal'  data-id=".$homeData->restaurant->id.">Reviews</button>

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
					          <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
					        </div>
					      </div>
					      
					    </div>
					  </div>
					</div>
				</div>
	        </div>
	        <div class='jk'>
		<h2>".$homeData->restaurant->user_rating->aggregate_rating."</h2>
			 <h3 style='color: black;'>".$homeData->restaurant->user_rating->votes." votes</h3>
			 </div>

			 <div class='callmenu'>
              
              <button type='button' class='call' data-toggle='modal'>Call
			</button>

			  <button type='button' class='menu' data-toggle='modal'>Menu
			  </button>
			 </div>
		</div>
		
		
		";

		}

		echo $html;

         
    	
?>