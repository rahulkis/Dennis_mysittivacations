<?php 
function groupon_api_call($limit,$city,$key){
	$url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&address=".urlencode($_SESSION['city_name']);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
	$responseJson = curl_exec($ch);
	curl_close($ch);

	$response = json_decode($responseJson);

	if ($response->status == 'OK') {
		$latitude = $response->results[0]->geometry->location->lat;
		$longitude = $response->results[0]->geometry->location->lng;
	} 
	if(!empty($city)):
		$prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
		// echo $prepAddr;
		$key = str_replace(' ','+',$key);
		$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
		//$urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-4269)%20AND%20(subcategory:".$key.")&context=web_holiday&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=80";
		if($key == 'restaurants'){
					$urlgo = "https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-4269)%20AND%20(subcategory:".$key.")&context=web_holiday&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=80";
				} else {
				$urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)&context=web_getaways&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=80";
				}
		// endif;
	else:

		if(!empty($key)):
				if($key == 'restaurants'){
					$urlgo = "https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-4269)%20AND%20(subcategory:".$key.")&context=web_holiday&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=80";
				} else {
				echo "hh".	$urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)&context=web_getaways&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=80";
				}
		 endif;

	endif;
	// return $urlgo;
	$result_get = file_get_contents($urlgo);
	$get_all_data = json_decode($result_get, true);
	$get_deals = $get_all_data['deals'];
	return $get_deals;
}
session_start(); if(!empty($_SESSION['city_name'])){
	$city = $_SESSION['city_name'];
	$key = 'fun-and-leisure-activities';
}else{
	$city = 'Chicago';
	$key = 'all%20inclusive%20resort';
}

$data = groupon_api_call('80',$city,'fun-and-leisure-activities');
if(count($data) > 0)
	{     ?>
		<div class="discounts_inner owl-theme">
			<div class="row">
				<?php
				$i= 0; 
				foreach($data as $homeData)
				{
			/*$price = $homeData['options'][0]['price']['formattedAmount'];
			$value = $homeData['options'][0]['value']['formattedAmount'];
			$discountPercent = $homeData['options'][0]['discountPercent'];
			$endAt =  $homeData['options'][0]['endAt'];
			$endDate = date('m/d/Y', strtotime($endAt));
			$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
			$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
			$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
			$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
			$tourname = $homeData['merchant']['name']; 
			$out =  substr($tourname,0,60);*/
			//if($discountPercent != 0){
			//	$i++;
			?>
			<div class="col-lg-4 all-inclusive section1_<?php echo $i; ?>">
			<!-- <ul class="us-city-popup">
				<li class="col-sm-4 col-md-4 col-xs-4"> -->
					<?php   $i++; 
					echo $homeData['cardHtml']; ?>
						<!-- <a href="<?php echo  $homeData['dealUrl']; ?>"  target="_blank">
							<span class="dealscity_name cityes_cityes_name"><?php echo $out ?></span>
							<img src="<?php echo $homeData['grid4ImageUrl']; ?>" alt="" class="img-fluid w-100">
							
						</a> -->
						
				<!-- 	</li>
				</ul> -->
			</div>
				
			<?php // }
		} 
	}
