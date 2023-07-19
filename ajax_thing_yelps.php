<?php 
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
function yelp_api_call($limit,$city,$keyword){
	//$key = empty($keyword) ? 'things%20%to%20%do' : str_replace(' ', '%20%', $keyword);
	$prepAddr =empty($city)?'Chicago': str_replace(' ','+',$city);
	$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
  // echo "geocode";
  // echo $geocode;
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	$ch = curl_init();   
	$key = str_replace(' ','+',$keyword);
	// $urlgo = empty($limit) ? 'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'':'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'&limit='.$limit.'';
	$urlgo = empty($limit) ? 'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'':'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'&limit='.$limit.'';
	
	// return $urlgo;
	curl_setopt($ch, CURLOPT_URL, $urlgo);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

	$headers = array();
	$headers[] = "Authorization: Bearer BjJKM-1ZSbav4VMbtIUvC4isdLkwrihG9XDUanCcbbknBWIXs1XHBbJnuzH5vgD0ETyCpxAg3FAvMvxB_z6QCnusskWwYEofgpkNvOY7ytK_HKGrGv-98bo44V-AWnYx";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)):
		echo 'Error:' . curl_error($ch);
	endif;
	curl_close ($ch);
 // echo "result";
 // echo $result;
	$get_deals = json_decode($result);

	$getyelpTourData = $get_deals->businesses;
	return $getyelpTourData;
}
?>
		<!-- <div class="horizontal-yelp-topbanner text-muted">
					<div class="yelp_searcch_box">
						<input type="text" name="search-yelp-horizontal" class="horizontal_yelp_content new_yelp_Content_cust" value="" id="search-yelp-horizontal" placeholder="What are you looking for?" autocomplete="off" >
						<div id="suggesstion-box"></div>
						<input type="submit" id="hitTeam" class="filtering_button" name="enter_buton"> 
						<input type="submit" id="yelp-hitAjaxCity" class="filtering_button new_cust_filt_button" name="enter_buton">
					</div>
						<img class="horizontal_yelp_content" src="<?php echo $SiteURL; ?>images/yelp-logo.png">
					</div> -->
					<div class="row">
						<?php 
						if(isset($_POST['limit'])){
							$limit = $_POST['limit'];
						}else{
							$limit = '';
						}
						$getyelpTourData = yelp_api_call($limit,$_POST['formatted'],$_POST['key']);      
						if(!empty($getyelpTourData)):
							foreach ($getyelpTourData as $homeData):
								$ciountt++;
								$tour_id = $homeData->id;
								$tour_name= $homeData->name;
								$tour_image = $homeData->image_url;
								$tour_url = $homeData->url;
								$tour_review_count = $homeData->review_count;
								$tour_rating = $homeData->rating;
								$tour_location_address1 = $homeData->location->address1;
								$tour_location_address2 = $homeData->location->address2;
								$tour_city = $homeData->location->city;
								$tour_zipCode = $homeData->location->zip_code;
								$tour_country = $homeData->location->country;
								$tour_state = $homeData->location->state; 
								$tour_phone = $homeData->display_phone;
								
								?>
								<div class='col-lg-4 custom_column'>
									<div class='grid mb-4'>
										<div class='image_htfix_mid'>
											<a href="<?php echo $tour_url ; ?>" target="_blank">
												<?php if(!empty($tour_image)) : ?>
													<img src="<?php echo $tour_image; ?>">
													<?php else : ?>
														<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg">
													<?php endif; ?>
												</a>
											</div>

											<div class='item_content yelp_content'>
												<h3>
													<a href="<?php echo $tour_url; ?>" target="_blank"><?php echo $tour_name; ?></a>
												</h3>

												<p class="location"><i class="fas fa-map pe-2"></i><?php echo $tour_city ; ?> </p>
												<div class='stars_tag pb-4'>
													<span class="hotel_tag">
														<?php $for_counter = 0 ;
														$total = count((array)$homeData->categories)-1; 
														foreach ($homeData->categories as $category){
															echo $category->title;
															if($for_counter != $total){
																echo ", ";
															}

															$for_counter++; 
														} ?>
													</span>
													<span  class="reviews yelpuser-review"  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
															(<?php echo $tour_review_count ; ?> Ratings)
															</span>
													<div class='star_rate'>
														<?php for($x=1;$x<=$tour_rating;$x++): ?>
															<span class='fa fa-star checked'></span>
														<?php endfor; ?>
														<?php if (strpos($tour_rating,".")) : ?>
															<span class='fa fa-star checked'></span>
															<?php 
															$x++;
														endif; ?>
														
													</div>  
													
													
												</div>
												
												
											</div>
										</div>
									</div>
									<?php
								endforeach;?>
							</div>

							<div class="text-center"> <div class="load_more load_more_yelps" style="text-align: center;color: black;" data-key="<?php echo $_POST['key']; ?>" data-id="<?php echo $limit; ?>">Load more<div></div>
								<?php
							
							endif;