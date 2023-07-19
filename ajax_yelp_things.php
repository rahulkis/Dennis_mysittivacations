<?php 
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
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

		$getyelpTourData = yelp_api_call('5',$_POST['formatted'],$_POST['modal_key']);
		// echo $getyelpTourData;
?>
			<div class="headingActivity-new container">
				<?php if($_POST['key'] === 'brewery' ): ?>
					<h2 class="brewery_h2">Breweries</h2>
				<?php endif; ?>
				<p><img src="https://mysitti.com/images/yelp-logo.png" class="yelp_imagesses"></p>
				<a  data-toggle="modal" data-target="#popularcitiesModal" data-info="landing_page_modal" data-url="ajax_yelp_deals.php" data-limit="" data-title="Yelp Deals" data-city ="<?php echo base64_encode($_POST['formatted']); ?>" data-key="<?php echo $_POST['key']; ?>" class="open-GrouponDialog">
				</a>
			</div>
			<ul>
				<?php
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
					    <li class="col-sm-3 col-lg-4 city-recom concert_specific" style="float: left; list-style: none; position: relative; width: 290px;">
							<a href="<?php echo $tour_url; ?>" target="_blank">
								<?php if(!empty($tour_image)) : ?>
									<img src="<?php echo $tour_image; ?>">
								<?php else : ?>
									<img src="https://mysitti.com/images/noimage-found.jpeg">
								<?php endif; ?>
							</a>
							<div class="col-md-12 col-sm-12 col-xs-12 deal_data">
							    <h2 class="hu deal_name yelp_ajax_resultss">
								    <a href="<?php echo $tour_url; ?>" target="_blank"> <?php echo substr($tour_name, 0, 8).'...'; ?>
								    </a>
							    </h2>
							 	<ul class="rating2 tour_ratingd list-inline yelp_ajax_rating">
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
						</li>
						<?php 
endforeach;
						?>
			</ul>