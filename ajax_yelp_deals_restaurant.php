<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
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

function yelp_api_autosearch($city,$keyword){
	$key = empty($keyword) ? 'things%20%to%20%do' : str_replace(' ', '%20%', $keyword);
	$prepAddr =empty($city)?'Chicago': str_replace(' ','+',$city);
	$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	$ch = curl_init();   
	
	$urlgo ='https://api.yelp.com/v3/autocomplete?text=bars&latitude='.$latitude.'&longitude='.$longitude.'';
	
	// echo $urlgo;
	// $urlgo = "https://api.yelp.com/v3/businesses/search?term=".$key."&latitude=".$latitude."&longitude=".$longitude."&limit=".$limit."";
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

	$results = json_decode($result);

	$terms = array();

	if(count($results) > 0)
	{
		if($results->categories)
		{
			foreach ($results->categories as  $value) {
				$terms[] = $value->title;
			}
		}  
		if($results->businesses)
		{
			foreach ($results->businesses as  $value) {
				$terms[] = $value->name;
			}
		}
		if($results->terms)
		{
			foreach ($results->terms as  $value) {
				$terms[] = $value->text;
			}
		}      
	}
	$terms = json_encode($terms);
	return $terms;
}


///////////////////////////////////////////////////////////////////////////////
// see all button open a modal for that modal data this code is responsible  //
///////////////////////////////////////////////////////////////////////////////
if($_POST['modal_info'] == 'landing_page_modal'):
	?>
	<div class="input-group stylish-input-group search-box-area-top">

		<input type="text" name="yelp-modal-search" value="<?php if(!empty($_POST['modal_key'])){echo $_POST['modal_key']; } ?>" placeholder="What are you looking for?" class="modal-search-box text-muted form-control" id="yelp-modal-search" >

		<span class="input-group-addon iconss" id="yelp-modal-search-button">
			<button type="submit">
				<span class="glyphicon glyphicon-search"></span>
			</button>  
		</span>

	</div>
	<!--end new-search-->
	<p id="no_data_found"></p>
	<ul class="groupon_deals_modal">
		<?php 
		$getyelpTourData = yelp_api_call($_POST['modal_limit'],base64_decode($_POST['modal_city']),$_POST['modal_key']);

		foreach ($getyelpTourData as $homeData):
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
			<li class="col-sm-3 city-recom deals" style="float: left; list-style: none; position: relative; width: 290px;">
				<a href="<?php echo $tour_url; ?>" target="_blank">
					<?php if(!empty($tour_image)) : ?>
						<img src="<?php echo $tour_image; ?>" alt="<?php echo $tour_name; ?>">
					<?php else : ?>
						<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg">
					<?php endif; ?>
				</a>
				<div class="">
					<h2 class="hu deal_name ">
						<a href="<?php echo $tour_url; ?>" target="_blank"><?php echo $tour_name; ?>
					</a>
				</h2>
				<ul class="rating2 tour_ratingd">
					<?php for($x=1;$x<=$tour_rating;$x++): ?>
						<li><img class="star_images"  src="imagesNew/star.png"></li>
					<?php endfor; ?>
					<?php if (strpos($tour_rating,'.')) : ?>
						<li><img class="star_images" src="images/halfstarnew.png"></li>
						<?php 
						$x++;
					endif; ?>
				</ul>
				<p class="reviews yelpuser-review" style="color:#0355a9; cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>" >
					<?php echo $tour_review_count; ?> Reviews 
				</p> 
				<ul class="tour_cate_type" style="color:black;">
					<li>
						<?php 
						$for_counter = 0 ;
						$total = count((array)$homeData->categories)-1; 
						foreach ($homeData->categories as $category):
							echo $category->title;
							if($for_counter != $total):
								echo ", ";
							endif; 
							$for_counter++; 
						endforeach; 
						?>
					</li>
				</ul>

			</div>		
		</li>
		<?php
	endforeach;
	?> 
</ul>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////
// If you want horizontal design of yelp tour in any page paste { design : 'Horizontal' }  //
// in ajax all for "ajax_yelp_deals.php" page                                              //
/////////////////////////////////////////////////////////////////////////////////////////////
elseif($_POST['design'] === 'Horizontal'): 
	if(isset($_POST['new_val']) && !empty($_POST['new_val']))
	{
		$new_val = $_POST['new_val'];
		$limit = $_POST['limit'];
	}
	else{
		$limit = $_POST['limit'];

	}
	?>
<!-- 		<div class="horizontal-yelp-topbanner text-muted">
						<?php if($_POST['horizontal_title'] == 'Generic' || empty($_POST['horizontal_title'])): ?>
						<?php else: ?>
						<h3 class="horizontal_yelp_content"><?php echo $_POST['horizontal_title'] ; ?></h3>
						<?php endif;?>
					<div class="yelp_searcch_box">
						<input type="text" name="search-yelp-horizontal" class="horizontal_yelp_content new_yelp_Content_cust" value="<?php if(isset($new_val)){ echo $new_val; } ?>" id="search-yelp-horizontal" placeholder="What are you looking for?" autocomplete="off" >
						<div id="suggesstion-box"></div>
						<input type="submit" id="hitTeam" class="filtering_button" name="enter_buton"> 
						<input type="submit" id="yelp-hitAjaxCity" class="filtering_button new_cust_filt_button" name="enter_buton">
					</div>
						<img class="horizontal_yelp_content" src="<?php echo $SiteURL; ?>images/yelp-logo.png">
					</div> -->
					<?php 

					$getyelpTourData = yelp_api_call($limit,$_POST['formatted'],$_POST['key']);

					if(!empty($getyelpTourData)):
						$count = count($getyelpTourData);
							
							foreach ($getyelpTourData as $homeData):
								$ciountt++;
								$tour_id = $homeData->id;
								$tour_name= $homeData->name;
								$tour_slug= $homeData->alias;
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
								<div class='hotel_listitem'>
									<div class="hotel_img">
										<div class='image_htfix'>
											<a href="<?php echo $tour_url ; ?>" target="_blank">
												<?php if(!empty($tour_image)) : ?>
													<img src="<?php echo $tour_image; ?>">
												<?php else : ?>
													<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg">
												<?php endif; ?>
											</a>
										</div>
									</div>
									<div class="hotel_details resturant_sprecification">
										<div class="loc_details">
											<div class="hotel_name">
												<h5><a href="<?php echo $tour_url; ?>" target="_blank"><?php echo $tour_name; ?></a></h5>
											</div>
											<div class="resturant_specl">
												<div class="resto_type">
													<p><i class="fas fa-hamburger"></i> <?php echo $tour_city ; ?></p>
												</div>
												<div class="resto_menu">
													<p><a href="https://www.yelp.com/menu/<?php echo $tour_slug; ?>" target="_blank"><i class="fas fa-utensils"></i> MENU </a></p>
												</div>
												<div class="open-info">
													<p class="text-success"><i class="fas fa-check"></i> Open Now</p>
												</div>
											</div>
										</div>
											<!-- <div class="restro_tesimonial">
												<ul>
													<li>
														<p><i class="fas fa-quote-left"></i> <i>“Great Peking Duck”</i></p>
													</li>
													<li>
														<p><i class="fas fa-quote-left"></i> <i>“There are some special foods that you can't find where else.”</i></p>
													</li>
												</ul>
											</div> -->
											<div class="restro_btns">
												<div class="restro_deals">
													<a href="<?php echo $tour_url; ?>" target="_blank" class="restro_btn">
														VIEW DEAL
													</a>
												</div>
												<div class="restro_deals">
													<a href="<?php echo $tour_url; ?>" target="_blank" class="restro_btn">
														ORDER ONLINE
													</a>
												</div>
												<div class="hotel_rating">
													<!-- <h6 class="mb-2"><?php echo $tour_name; ?></h6> -->
													<div class="star_rate">
														<div class='star_rate'>
															<?php for($x=1;$x<=$tour_rating;$x++): ?>
																<span class='fa fa-star checked'></span>
															<?php endfor; ?>
															<?php if (strpos($tour_rating,".")) : ?>
																<span class='fa fa-star checked'></span>
																<?php 
																$x++;
															endif; ?>
															<span  class="reviews yelpuser-review"  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
																(<?php echo $tour_review_count ; ?> Ratings)
															</span>
															
															
														</div> 
													</div>
												</div>
											</div>
										</div>
									</div>

												<!-- <p class='location'>
													<ul class="list_f tour_address">
														<li><?php echo $tour_location_address1 ; ?></li>
														<li><?php echo $tour_location_address2 ; ?></li>
														<li><?php echo $tour_city ; ?>  <?php echo $tour_state ; ?>  <?php echo $tour_zipCode ; ?></li>
														<li><?php echo $tour_phone ; ?></li>
													</ul>
												</p>	 -->
											<!-- 	<div class='stars_tag pb-4'>
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
													
												</div> -->
												<?php
											endforeach;?>
											<input type="hidden" name="count" value="<?php echo $count; ?>" class="total_count">
											<div class="text-center"><div class="load_more_search" style="text-align: center;color: black;" data-key="<?php echo $_POST['key']; ?>" data-id="<?php echo $limit; ?>">Load more</div></div>
											<?php
										else:
											?>
											<div class="row tab-two text-muted">
												<div class="yelp-serach-null-result col-md-5 col-sm-5 col-xs-6">
													<p> No record Found</p>
												</div>
											</div>
											<?php
										endif;
									else : 
										if($_POST['formatted'] == 'Washington'){
											$formattedA = 'Washington D.C.';
										}else{
											$formattedA = $_POST['formatted'];
										}
										$getyelpTourData = yelp_api_call('4',$formattedA,$_POST['key']);
										$getyelpTourDatamob = yelp_api_call('20',$_POST['formatted'],$_POST['key']);
		// echo $getyelpTourData;
										?>
										<div class="headingActivity-new container">
											<?php if($_POST['key'] === 'brewery' ): ?>
												<h2 class="brewery_h2">Breweries</h2>
											<?php endif; ?>
											<?php if($_POST['key'] === 'comedy' ): ?>
												<h2 class="brewery_h2"><?php echo $_POST['formatted']; ?> Comedy Clubs</h2>
											<?php endif; ?>
											<p><img class="landingYelpImg" src="<?php echo $SiteURL; ?>images/yelp-logo.png"></p>
											<a  data-toggle="modal" data-target="#popularcitiesModal" data-info="landing_page_modal" data-url="ajax_yelp_things.php" data-limit="" data-title="Yelp Deals" data-city ="<?php echo base64_encode($_POST['formatted']); ?>" data-key="<?php echo $_POST['key']; ?>" class="open-GrouponDialog">
												See all
											</a>
										</div>
										<div class="bs-example popular_city_in_mobile groupon_respoo groupon_deals_mobile">
											<div class="carousels" >
												<div class="carousel-inners">
													<?php
													foreach ($getyelpTourDatamob as $homeData):
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
														<div class="carousel_mobile">
															<a href="<?php echo $tour_url; ?>" target="_blank">
																<?php if(!empty($tour_image)) : ?>
																	<img src="<?php echo $tour_image; ?>">
																<?php else : ?>
																	<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg">
																<?php endif; ?>
															</a>
															<div class="col-md-12 col-sm-12 col-xs-12 deal_data">
																<h2 class="hu deal_name ">
																	<a href="<?php echo $tour_url; ?>" target="_blank"><?php echo $tour_name; ?>
																</a>
															</h2>
															<ul class="rating2 tour_ratingd list-inline">
																<?php for($x=1;$x<=$tour_rating;$x++): ?>
																	<li><img class="star_images"  src="imagesNew/star.png"></li>
																<?php endfor; ?>
																<?php if (strpos($tour_rating,".")) : ?>
																	<li><img class="star_images" src="images/halfstarnew.png"></li>
																	<?php 
																	$x++;
																endif; ?>
															</ul>
															<p class="reviews yelpuser-review" style="color:#0355a9; cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id=<?php echo $tour_id; ?> ><?php echo $tour_review_count; ?> Reviews </p> 
															<ul class="tour_cate_type" style="color:black;">
																<li>
																	<?php 
																	$for_counter = 0 ;
																	$total = count((array)$homeData->categories)-1; 
																	foreach ($homeData->categories as $category):
																		echo $category->title;
																		if($for_counter != $total):
																			echo ", ";
																		endif; 
																		$for_counter++; 
																	endforeach; 
																	?>
																</li>
															</ul>
															<div class="col-md-12">
																<ul class="list_f tour_address">
																	<li><?php echo $tour_location_address1; ?></li>
																	<li><?php echo $tour_location_address2; ?></li>
																	<li><?php echo $tour_city; ?>  <?php echo $tour_state; ?>  <?php echo $tour_zipCode; ?></li>
																	<li><?php echo $tour_phone; ?></li>

																</ul>
															</div>
														</div>		
													</div>
												<?php endforeach; ?>
											</div>
										</div>
									</div>
									<?php
								endif;
								?>
