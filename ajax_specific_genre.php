<?php

$json = file_get_contents('php://input');
$someArray = json_decode($json, true);
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
/////////////////////////////////////////////////////////////////////////////////////////////////////////
// Call this function with three parameter                                                             //
// {$limit, $city, $key} {request from api, deals for the city, Keyword (what type of deals you want)} //
/////////////////////////////////////////////////////////////////////////////////////////////////////////
function groupon_api_call($limit,$city,$key){
	if(!empty($city)):
		$prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
		// echo $prepAddr;
		$key = str_replace(' ','+',$key);
	    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
	    $output= json_decode($geocode);
	    $latitude = $output->results[0]->geometry->location->lat;
	    $longitude = $output->results[0]->geometry->location->lng;
			$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."&locale=en_US";
		// endif;
	else:
		
		if(!empty($key)):
			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&offset=0&limit=".$limit."&locale=en_US";
		else:

			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&limit=".$limit."&locale=en_US";
		endif;
		// endif;
		
	endif;
	// return $urlgo;
	$result_get = file_get_contents($urlgo);
	$get_all_data = json_decode($result_get, true);
	$get_deals = $get_all_data['deals'];
	return $get_deals;
}
		$get_deals = groupon_api_call('80',$someArray['formatted'],$someArray['key']);
		$get_deals_mobile = groupon_api_call('50',$someArray['formatted'],$someArray['key']);

		if(!empty($get_deals)):
?>
			<div class="headingActivity-new1 groupon_deals_common_class container">
						<h2> Groupon <?php echo $someArray['title']; ?> </h2>
						<a  data-toggle="modal" data-target="#popularcitiesModal" data-url="ajax_groupon_deals.php" data-info="landing_page_modal" data-limit="80" data-title=" Groupon deals" data-city ="<?php echo base64_encode($someArray['formatted']); ?>" data-key="<?php echo $someArray['key']; ?>" class="open-GrouponDialog">
							See all
						</a>
			</div>
			<?php if(!$detect->isMobile()) { ?>
			<ul class="popular_cityy">
				<?php 
				$i= 0;
					foreach ($get_deals as $homeData):
					    $price = $homeData['options'][0]['price']['formattedAmount'];
					    $value = $homeData['options'][0]['value']['formattedAmount'];
					    $discountPercent = $homeData['options'][0]['discountPercent'];
					    $endAt = 	$homeData['options'][0]['endAt'];
					    $endDate = date('m/d/Y', strtotime($endAt));
					    $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
					    $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
					    $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
					    $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
					    $tourname = $homeData['merchant']['name']; 
                        $out =  substr($tourname,0,20);
						if($discountPercent != 0){
							$i++;
						if($i < 5){
				?>	
						<li class="col-md-3 col-sm-12 col-xs-12 city-recom" style="float: left; list-style: none; position: relative; width: 290px;">
							<div class='borderIsan hotelandingDeal'>
								<a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
									<img src="<?php echo $homeData['grid4ImageUrl']; ?>">
								</a>
								<a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
									<!-- <h2 class="discountPercent"><?php echo $discountPercent; ?>% Off</h2> -->
									<h1 class="nameIsan hotelandingnameIsan" style= "text-align: center;"><?php echo $out ; ?></h1>
								</a>
								<h1 class="pricelanding"><?php echo $value ; ?></h2>
                <h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>
								

								<h2 class="valuelanding"><?php echo $price ;?></h1>
								<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
							</div>
						</li>
				<?php } }  endforeach; ?>
			</ul>
		<?php } else{ ?>
		<div class="bs-example popular_city_in_mobile groupon_respoo groupon_deals_mobile">
				<div class="carousels" >
					<div class="carousel-inners">
					<?php
				
					foreach ($get_deals_mobile as $homeData):
					    $price = $homeData['options'][0]['price']['formattedAmount'];
					    $value = $homeData['options'][0]['value']['formattedAmount'];
					    $discountPercent = $homeData['options'][0]['discountPercent'];
					    $endAt = 	$homeData['options'][0]['endAt'];
					    $endDate = date('m/d/Y', strtotime($endAt));
					    $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
					    $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
					    $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
					    $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
					    $tourname = $homeData['merchant']['name']; 
                        $out =  substr($tourname,0,20);
						if($discountPercent != 0){
						?>
						<div class="carousel_mobile">
							<div class=''>
								<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
									<img src="<?php echo $homeData['grid4ImageUrl']; ?>">
								</a>
								<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
									<!-- <h2 class="discountPercent"><?php echo $discountPercent; ?>% Off</h2> -->
									<h1 class="nameIsan hotelandingnameIsan" style= "text-align: center;"><?php echo $out ; ?>...</h1>
								</a>
								<h1 class="pricelanding"><?php echo $value ; ?></h2>
                <h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>
								
								<h2 class="valuelanding mod"><?php echo $price ;?></h1>
								<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
							</div>
						</div>
						<?php
					}
					endforeach;
							
					?>
					</div>
				</div>
			</div>

		<?php
	}
		endif;
?>
