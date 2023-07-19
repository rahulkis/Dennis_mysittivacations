<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$value = $_POST['formatted'];

$pageNumber = $_POST['page'];


$exp = explode(",", $value);
$cy = $exp[0];
if($cy == "Washington") {
	$cyhy = "washington-dc";
	$cysp = "washington%20dc";
} else {
	$cyhy = str_replace(' ', '-', strtolower($exp[0]));
	$cysp = str_replace(' ', '%20', strtolower($exp[0]));
	$tn = str_replace(' ', '', $exp[1]);
}

if (empty($cyhy)) {
	$cyhy = $_POST['city'];
	$cysp = $_POST['city'];
}


$start=0;
$limit = 15;
	if(isset($_GET['page']))
	{
	$page = $_GET['page'];
	$start = ($page-1)*$limit;
	}

	if (!empty($_POST['restaurantData'])) {
	 	$search_slug = $_POST['restaurantData'];
	}else{
	 	$search_slug = 'restaurants';
	}

		$prepAddr = str_replace(' ','+',$cyhy);
		
		$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;

		//&division_id=".rawurlencode($cyhy)."
		$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".rawurlencode($cyhy)."+".rawurlencode($search_slug)."&lat=".$latitude."&lng=".$longitude."&division=".rawurlencode($cyhy)."&filters=category:food-and-drink&locale=en_US";


		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
		
		$get_deals = $get_all_data['deals'];
	  	?>
	  	
		<div class="marGin"></div>
						
		<?php
		$html = "";

		function paganation($get_deals, $page) {
	        global $show_per_page;

	        $page = $page < 1 ? 1 : $page;

	        $start = ($page - 1) * ($show_per_page + 1);
	        $offset = $show_per_page + 1;

	        $outArray = array_slice($get_deals, $start, $offset);
	        return $outArray;

	    }

         $show_per_page = 14;
         $page = $pageNumber;
		 $DataArray = paganation($get_deals, $page);
		 

		if(count($get_all_data) > 0) {
	    foreach ($DataArray as $homeData)
	    {

		if($homeData['options'][0]['price']['formattedAmount'] == $homeData['options'][0]['value']['formattedAmount']){
		
    	}else{
		$price = $homeData['options'][0]['price']['formattedAmount'];
	    $value1 = $homeData['options'][0]['value']['formattedAmount'];
		$discount = $homeData['options'][0]['discount']['formattedAmount'];
		$save = 'Save ';
		$off = '% Off';
	    $discountPercent = $homeData['options'][0]['discountPercent'];
    	}

    	if(!$homeData['highlightsHtml']){
    		$read_more = '';
    	}else{
           $read_more = 'Read More';
    	}
           

		    $endAt = 	$homeData['options'][0]['endAt'];
	        $endDate = date('m/d/Y', strtotime($endAt));
	        $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
	        $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
	        $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
	        $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
            
           
	    	$html .= "<div class='home_list newhotels-deals'>
					<div class='home_image newhotels-deals'>
					  <a href='".$homeData['dealUrl']."' target='_blank' class='homeLink1'>
					   	<img src='".$homeData['grid4ImageUrl']."' width='250' height='200'>
					   	</a>

					 <h2 class='deals-name-new'><a href='".$homeData['dealUrl']."' target='_blank'>".$homeData['merchant']['name']."</a></h2>

					<h1 class='addres1 p8'>".$streetAddress1."</h1>
					<h1 class='addres2 p9'>".$streetAddress2."</h1>
					<h1 class='cityNamelanding p10'>".$cityName.', '.$postalCode."</h1>

			        </div>

					<div class='home_data newHotelsdeals'>
						<h2 class='discountPercent p1'>".$discountPercent. $off."</h2><span class='announcementTitledeasl p2' style='color: black;'>".$homeData['announcementTitle']."</span><br>
                       <div class='alldealset p3'>
						<h1 class='pricelanding-hotel p4'>".$price." <span class='valuelanding-hotel p5'>".$value1."</span></h1>
						<h1 class='saleend-hotel p6'>".'Sales Ends: ' .$endDate."</h1>
                       </div>

						<div class='home_city'>
						<span class='discountNight p7'>".$save.$discount."</span>
							
							".$homeData['highlightsHtml']."
							<a href='".$homeData['dealUrl']."' target='_blank' class='read_more'>
					   	      ".$read_more."
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