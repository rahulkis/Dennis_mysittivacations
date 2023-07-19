<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$location = rawurlencode($_POST['changeValue']);


$prepAddr = str_replace(' ','+',$location);
$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
$output= json_decode($geocode);
$latitude = $output->results[0]->geometry->location->lat;
$longitude = $output->results[0]->geometry->location->lng;



	if($location != "") // this for side search bar
	{
		$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".$location."&lat=".$latitude."&lng=".$longitude."&query=restaurant+deals&division=".$location."&locale=en_US&limit=12&campaign.currency=USD";

	} 

		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
		$get_deals = $get_all_data['deals'];

        $html = "";

		foreach($get_deals as $homeData){

			if($homeData['options'][0]['price']['formattedAmount'] == $homeData['options'][0]['value']['formattedAmount']){
		
    	}else{
		$price = $homeData['options'][0]['price']['formattedAmount'];
	    $value1 = $homeData['options'][0]['value']['formattedAmount'];
		$discount = $homeData['options'][0]['discount']['formattedAmount'];
		$save = 'Save ';
		$off = '% Off';
	    $discountPercent = $homeData['options'][0]['discountPercent'];
    	}

    	$endAt = 	$homeData['options'][0]['endAt'];
	    $endDate = date('m/d/Y', strtotime($endAt));

		 $html .= "
		 <div class='home_list'>
			<div class='home_image'>
		      <img src= '".$homeData['grid4ImageUrl']."' width='250' height='200'>   	   	
	        </div>
	        <div class='home_data'>
             <h2><a href= '".$homeData['dealUrl']."' target='_blank'>
               ".$homeData['merchant']['name']."</a></h2>
               <div class='alldealset p3'>
				<h1 class='pricelanding-hotel p4'>".$price." <span class='valuelanding-hotel p5'>".$value1."</span></h1>
				<h1 class='saleend-hotel p6'>".'Sales Ends: ' .$endDate."</h1>
               </div>

               <div class='home_city'>
					<span>".$homeData['announcementTitle']."</span><br>
					<h3>".$homeData['division']['name']."</h3><br>
					
					 ".$homeData['highlightsHtml']."
					</p>
					<p>".$homeData['title']."</p>
				</div>
	        </div>
	        <div class='home_price'>
			<li>
				<a href=".$homeData['dealUrl']." class='homeLink' target='_blank'>View Deal</a>
			</li>
		  </div>
		</div>
		
		
		";

		echo $html;

								  

		}
	
         
    	
?>