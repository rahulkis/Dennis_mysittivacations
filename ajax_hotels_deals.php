<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$value = $_POST['changeValue'];


$prepAddr = str_replace(' ','+',$value);
		$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;


		// $urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".rawurlencode($value)."&lat=".$latitude."&lng=".$longitude."&query=hotels+deals&filters=category:hotels-and-accommodations&division=".rawurlencode($value)."&offset=0&limit=100&locale=en_US";

		$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".rawurlencode($value)."&lat=".$latitude."&lng=".$longitude."&query=hotels&filters=category:hotels-and-accommodations&offset=0&limit=250&locale=en_US";

				$result_get = file_get_contents($urlgo);
				$get_all_data = json_decode($result_get, true);
				$get_deals = $get_all_data['deals'];
	  	?>
	  	
		<div class="marGin"></div>
						
		<?php
      
        function paganation($get_deals, $page) {
	        global $show_per_page;

	        $page = $page < 1 ? 1 : $page;

	        $start = ($page - 1) * ($show_per_page + 1);
	        $offset = $show_per_page + 1;

	        $outArray = array_slice($get_deals, $start, $offset);
	        return $outArray;

	    }

         $show_per_page = 14;
         $page = 1;
		 $DataArray = paganation($get_deals, $page);


		$html = "";

		if(count($get_all_data) > 0) {
	    foreach ($DataArray as $homeData)
	    {

		    $price = $homeData['options'][0]['price']['formattedAmount'];
		    $value = $homeData['options'][0]['value']['formattedAmount'];
		    $discountPercent = $homeData['options'][0]['discountPercent'];
		    $discount = $homeData['options'][0]['discount']['formattedAmount'];
		    $endAt = 	$homeData['options'][0]['endAt'];
	        $endDate = date('m/d/Y', strtotime($endAt));
	        $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
	        $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
	        $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
	        $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
            
           
	    	$html .= "<div class='home_list'>
					<div class='home_image newhotels-deals'>
					   <a href='".$homeData['dealUrl']."' target='_blank'>
					   	<img src='".$homeData['grid4ImageUrl']."' width='250' height='200'>
					   	</a>

						 <h2 class='deals-name-new'><a href='".$homeData['dealUrl']."' target='_blank'>".$homeData['merchant']['name']."</a> </h2>
	                       
	                    <h1 class='addres1'>".$streetAddress1."</h1>
						<h1 class='addres2'>".$streetAddress2."</h1>
						<h1 class='cityNamelanding'>".$cityName.', '.$postalCode."</h1>

			        </div>

					<div class='home_data newHotelsdeals'>
						<h2 class='discountPercent'>".$discountPercent. '% Off'."</h2><span class='announcementTitledeasl' style='color: black;'>".$homeData['announcementTitle']."</span><br>
                       <div class='alldealset'>
						<h1 class='pricelanding-hotel'>".$price.' /<span class="night-dis">night</span>'." <sapn class='valuelanding-hotel'>".$value."</span></h1>
						
						<h1 class='saleend-hotel'>".'Sales Ends: ' .$endDate."</h1>
                       </div>

						<div class='home_city'>
						<h1 class='discountNight'>".'Save '.$discount.'/<span class="night-dis">night</span>'."</h1>
							
							".$homeData['highlightsHtml']."

							<a href='".$homeData['dealUrl']."' target='_blank' class='read_more'>
					   	      Read More
					   		</a>
							</p>
							
						</div>
					</div>
				</div>";
    	}
    	} else {
    		echo "<h1 class='record_not_found'>Record not found.</h1>";
    	}
    	echo $html;

    	echo $html1 = "<div class='next-prev'><button class='prev' field='quantity'>Prev</button>
				
						<button class='next' field='quantity'>Next</button></div>";

    	
 
    	
?>