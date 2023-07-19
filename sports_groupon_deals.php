<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
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
	    // echo  $latitude ." ". $longitude;
	    // if($limit === 'full'):
		    /////////////////////////////////////////////////////////////////////////////////
	    	// tsToken=US_AFF_0_207698_212556_0 contains => Country = United States (US),  //
		    // Affiliate Id = 207698, Media Id = 212556                                    //
		    /////////////////////////////////////////////////////////////////////////////////
			// $urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&locale=en_US";
		// else:
		$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."&locale=en_US";
		// endif;
	else:
		// if($limit === 'full'):
		    /////////////////////////////////////////////////////////////////////////////////
	    	// tsToken=US_AFF_0_207698_212556_0 contains => Country = United States (US),  //
		    // Affiliate Id = 207698, Media Id = 212556                                    //
		    /////////////////////////////////////////////////////////////////////////////////
			// $urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&limit=150&locale=en_US";
			// $urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&locale=en_US";
		// else:
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
?>
<section class="see_beautiful sec_pad bg_grey">
	<div class="container">
		<div class="heading">
			<div class="row">
				<div class="col-lg-9">
					<h4> Groupon Sports Deals  </h4>
				</div>
				<div class="col-lg-3 text-lg-end">
					<a  data-toggle="modal" data-target="#popularcitiesModal" data-url="ajax_groupon_deals.php" data-info="landing_page_modal" data-limit="80" data-title=" Groupon deals" data-city ="<?php echo base64_encode($_POST['formatted']); ?>" data-key="<?php echo $_POST['key']; ?>" class="open-GrouponDialog btn btn-outline-dark px-4">
						See all
					</a>

				</div>
			</div>
		</div>
		<div class="see_beautiful_inner">
			<div class="row">
				<?php
				$i = 0;
				$get_deals = groupon_api_call('50',$_POST['formatted'],$_POST['key']);
				$get_deals_mobile = groupon_api_call('50',$_POST['formatted'],$_POST['key']);
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
					$tourname = $homeData['title']; 
					$out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
					if($discountPercent != 0){
						$i++;
						if($i < 4){
							?>	
							<div class="col-lg-4">
					<div class="grid sports_grid mb-3 shadow">
						<a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
							<img src="<?php echo $homeData['grid4ImageUrl']; ?>">
						</a>
						<a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
							<!-- <h2 class="discountPercent"><?php echo $discountPercent; ?>% Off</h2> -->
							<h1 class="nameIsan hotelandingnameIsan"><?php echo $out ; ?></h1>
						</a>
						<ul>
							<li><i class="fas fa-dollar-sign me-3"></i><del><?php echo $value ; ?></del> (<?php echo $discountPercent; ?>% Off) - <span class="price"><?php echo $price ;?></span></li>
							<li><i class="fas fa-tags me-3"></i>Sales Ends: <?php echo $endDate ; ?></li>
						</ul>
						<a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank"><button class="arrow_sports"><i class="fas fa-chevron-right"></i></button></a>
														<!-- <h1 class="pricelanding"><?php echo $value ; ?></h1>
														<h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>


														<h2 class="valuelanding"><?php echo $price ;?></h2>
														<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1> -->
													</div>
												</div>
											<?php } } endforeach; ?>

										</div>
									</div>
								</div>
							</section>
										<!-- <div class="bs-example popular_city_in_mobile groupon_respoo sports_grupons">
											<div class="carousels">
												<div class="carousel-inners" >
													<?php
													$counter = 0;
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
														$tourname = $homeData['title']; 
														$out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
														if($discountPercent != 0){
															?>
															<div class="carousel_mobile">
																<div class=''>
																	<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
																		<img src="<?php echo $homeData['grid4ImageUrl']; ?>">
																	</a>
																	<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
																		<h1 class="nameIsan hotelandingnameIsan" style= "text-align: center;"><?php echo $out ; ?></h1>
																	</a>
																	<h1 class="pricelanding"><?php echo $value ; ?></h1>
																	<h2 class="discountPercent groupon_per"><?php echo $discountPercent; ?>% Off</h2>
																	<h2 class="valuelanding mod"><?php echo $price ;?></h2>
																	<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
																</div>
															</div>
															<?php
															$counter++; 
														}
													endforeach;			
													?>
												</div>
											</div>
										</div> -->


