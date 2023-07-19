<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
function groupon_api_call($limit,$city){
	if(!empty($city)):
		$prepAddr = str_replace(' ','+',$city);
	    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
	    $output= json_decode($geocode);
	    $latitude = $output->results[0]->geometry->location->lat;
	    $longitude = $output->results[0]->geometry->location->lng;
		$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=tours&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."";
		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
	else:
		$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&limit=".$limit."&locale=en_US";
	endif;
	// return $urlgo;
	$result_get = file_get_contents($urlgo);
	$get_all_data = json_decode($result_get, true);
	$get_deals = $get_all_data['deals'];
	return $get_deals;
}
if($_POST['modal_info'] == 'landing_page_modal'){
	$html .= "<h2>".$_POST['modal_title']."</h2>
				<ul class='groupon_deals_modal'>";
	$get_deals = groupon_api_call($_POST['modal_limit'],base64_decode($_POST['modal_city']));
	// echo $get_deals;
	foreach ($get_deals as $homeData){
	    $price = $homeData['options'][0]['price']['formattedAmount'];
	    $value = $homeData['options'][0]['value']['formattedAmount'];
	    $discountPercent = $homeData['options'][0]['discountPercent'];
	    $endAt = 	$homeData['options'][0]['endAt'];
	    $endDate = date('m/d/Y', strtotime($endAt));
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

						<h1 class='pricelanding'>".$price.' /<h2 class="night">night</h2>'."</h1><h2 class='valuelanding'>".$value."</h2>
						<h1 class='saleend'>".'Sales Ends: ' .$endDate."</h1>
					</div>
				</li>";
	}
	$html .= "</ul>";
}
else{
	$html .= "<div class='headingActivity-new1 container'>";
				if(!empty($_POST['formatted'])):
					$html .= "<h2> Groupon deals </h2>
								<a  data-toggle='modal' data-target='#popularcitiesModal' data-info='landing_page_modal' data-limit='50' data-title=' Groupon deals' data-city =".base64_encode($_POST['formatted'])." class='open-GrouponDialog'>
									See all
								</a>";
				else:
					$html .= "<h2> Groupon all-inclusive deals </h2>
								<a  data-toggle='modal' data-target='#popularcitiesModal' data-info='landing_page_modal' data-limit='50' data-title='Groupon all-inclusive deals' data-city ='".base64_encode($_POST['formatted'])."' class='open-GrouponDialog'>
									See all
								</a>";
				endif;
	$html .= "</div>";
	$get_deals = groupon_api_call('5',$_POST['formatted']);
	foreach ($get_deals as $homeData){
	    $price = $homeData['options'][0]['price']['formattedAmount'];
	    $value = $homeData['options'][0]['value']['formattedAmount'];
	    $discountPercent = $homeData['options'][0]['discountPercent'];
	    $endAt = 	$homeData['options'][0]['endAt'];
	    $endDate = date('m/d/Y', strtotime($endAt));
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

						<h1 class='pricelanding'>".$price.' /<h2 class="night">night</h2>'."</h1><h2 class='valuelanding'>".$value."</h2>
						<h1 class='saleend'>".'Sales Ends: ' .$endDate."</h1>
					</div>
				</li>";
	}
}		
echo $html;
?>
