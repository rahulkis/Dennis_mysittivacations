<?php
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
if($_POST['modal_info'] == 'landing_page_modal'):
	?>
	<!-- new-search
	//////////////////////////////////////////////////////////////////////
	// For ajax of this search please refer LandingPageFooter.php page  //
	////////////////////////////////////////////////////////////////////// 
-->
<!-- <div class="input-group stylish-input-group search-box-area-top" >

	<input type="text" name="groupon-modal-search" placeholder="What you are looking for?" class="modal-search-box text-muted form-control" id="groupon-modal-search" >

	<span class="input-group-addon iconss" id="groupon-modal-search-button">
		<button type="submit" >
			<i class="fas fa-search"></i>
		</button>  
	</span>

</div> -->

<p id="no_data_found"></p>
<div class="see_beautiful_inner p-3">
	<div class="row">
		<?php
		if(isset($_POST['modal_search_city'])):
			$modal_city = $_POST['modal_search_city'];
		else:
			$modal_city = base64_decode($_POST['modal_city']);
		endif;
		$get_deals = groupon_api_call($_POST['modal_limit'],$modal_city,$_POST['modal_key']);
		// echo $get_deals;
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
			$out = strlen($tourname) > 20 ? substr($tourname,0,15)."..." : $tourname;
			if($discountPercent != 0){
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
											<?php } endforeach; ?>
										</div></div>
										<?php 
									else: 
										$get_deals = groupon_api_call('80',$_POST['formatted'],$_POST['key']);
										$get_deals_mobile = groupon_api_call('50',$_POST['formatted'],$_POST['key']);

										if(!empty($get_deals)):
											?>
											<section class="see_beautiful sec_pad bg_grey">
												<div class="container">
													<div class="heading">
														<div class="row">
															<div class="col-lg-9">
																<?php 
																if(!empty($_POST['formatted'])):
																	if($_POST['key'] == 'sports'){ ?>
																		<h4> Groupon Sports Deals  </h4>
																	<?php		}elseif($_POST['key'] == 'concert'){

																		?>
																		<h2>Groupon Concert Deals</h2>
																		<?php
																	}elseif($_POST['key'] == 'performing arts'){
																		?>
																		<h2>Groupon Performing Deals</h2>
																		<?php
																	}else{
																		?>
																		<h4> Groupon Sports Deals  </h4>

																		<!-- <h2>Groupon meal deals</h2> -->
																	<?php } 
																endif;?>

															</div>
															<div class="col-lg-3 text-lg-end">
																<?php 
																if(!empty($_POST['formatted'])):
																	if($_POST['key'] == 'sports'){ ?>


																		<a  data-toggle="modal" data-target="#popularcitiesModal" class=" btn btn-outline-dark px-4" data-url="ajax_groupon_deals.php" data-info="landing_page_modal" data-limit="80" data-title="<?php echo $_POST['title'] ;?>" data-city ="<?php echo base64_encode($_POST['formatted']); ?>" data-key="<?php echo $_POST['key']; ?>" class="open-GrouponDialog">
																			See all
																		</a>

																	<?php } else { ?>
																		<a  data-toggle="modal" data-target="#popularcitiesModal" data-url="ajax_groupon_deals.php" data-info="landing_page_modal" data-limit="80" data-title=" Groupon deals" data-city ="<?php echo base64_encode($_POST['formatted']); ?>" data-key="<?php echo $_POST['key']; ?>" class="open-GrouponDialog btn btn-outline-dark px-4 sports_viewall">
																			View all
																		</a>
																	<?php }
																endif; ?>
															</div>
														</div>
													</div>


													<?php if(!$detect->isMobile()) { ?>
														<div class="see_beautiful_inner">
															<div class="row">
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
																	$tourname = $homeData['title']; 
																	$out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
																	if($discountPercent != 0){
																		$i++;
																		if($i < 4){
																			?>	
																			<div class="col-lg-4">
																				<div class="grid sports_grid">
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
											<?php } }  endforeach; ?>
										</div></div>
									<?php } else{ ?>
										<div class="discounts_inner ">
											<div class="row owl-carousel owl-theme">
											<!-- <div class="carousels" >
												<div class="carousel-inners"> -->
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
														$tourname = $homeData['title']; 
														$out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
														if($discountPercent != 0){
															?>
															<div class="col-lg-4">
																<div class="grid sports_grid">
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
																	<button class="arrow_sports"><i class="fas fa-chevron-right"></i></button>
														<!-- <h1 class="pricelanding"><?php echo $value ; ?></h1>
														<h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>


														<h2 class="valuelanding"><?php echo $price ;?></h2>
														<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1> -->
													</div>
												</div>
															<!-- <div class="carousel_mobile">
																<div class=''>
																	<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
																		<img src="<?php echo $homeData['grid4ImageUrl']; ?>">
																	</a>
																	<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
																		<!-- <h2 class="discountPercent"><?php echo $discountPercent; ?>% Off</h2> -->
																		<!-- <h1 class="nameIsan hotelandingnameIsan" style= "text-align: center;"><?php echo $out ; ?></h1>
																	</a>
																	<h1 class="pricelanding"><?php echo $value ; ?></h1>
																	<h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>

																	<h2 class="valuelanding mod"><?php echo $price ;?></h2>
																	<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
																</div>
															</div> --> 
															<?php
														}
													endforeach;

													?>

												</div>
											</div>

											<?php
										}
									endif;
								endif;
								?>
							</div>
						</section>
