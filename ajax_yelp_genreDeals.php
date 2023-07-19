<?php
$json = file_get_contents('php://input');
$someArray = json_decode($json, true);
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
if($someArray['design'] === 'Horizontal'): 
		if(isset($someArray['new_val']) && !empty($someArray['new_val']))
		{
			$new_val = $someArray['new_val'];
		}
		else{
		}
?>
		<div class="horizontal-yelp-topbanner text-muted">
						<?php if($someArray['horizontal_title'] == 'Generic' || empty($someArray['horizontal_title'])): ?>
						<?php else: ?>
						<h3 class="horizontal_yelp_content"><?php echo $someArray['horizontal_title'] ; ?></h3>
						<?php endif;?>
					<div class="yelp_searcch_box">
						<input type="text" name="search-yelp-horizontal" class="horizontal_yelp_content new_yelp_Content_cust" value="<?php if(isset($new_val)){ echo $new_val; } ?>" id="search-yelp-horizontal" placeholder="What are you looking for?" autocomplete="off" >
						<div id="suggesstion-box"></div>
						<input type="submit" id="hitTeam" class="filtering_button" name="enter_buton"> 
						<input type="submit" id="yelp-hitAjaxCity" class="filtering_button new_cust_filt_button" name="enter_buton">
					</div>
						<img class="horizontal_yelp_content" src="<?php echo $SiteURL; ?>images/yelp-logo.png">
					</div>
			<?php 
			if(isset($someArray['limit'])){
				$limit = $someArray['limit'];
			}else{
				$limit = '';
			}
			$getyelpTourData = yelp_api_call($limit,$someArray['formatted'],$someArray['key']);      
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
			 	<div class="row tab-two">
				    <div class="col-md-5 col-sm-12 col-xs-12 col-5">
						<div class="m_2 tour_images">
						 	<a href="<?php echo $tour_url ; ?>" target="_blank">
								 <?php if(!empty($tour_image)) : ?>
									<img src="<?php echo $tour_image; ?>">
								<?php else : ?>
									<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg">
								<?php endif; ?>
							</a>
						</div>
					</div>
				  	<div class="col-md-6 col-sm-12 col-xs-12 col-6">
					    <h2 class="hu tour_names">
					    	<a href="<?php echo $tour_url; ?>" target="_blank"><?php echo $tour_name; ?></a>
					    </h2>	
					 	<ul class="rating2 tour_ratingd">
						 	<?php for($x=1;$x<=$tour_rating;$x++): ?>
							 	<li><img class="star_images"  src="imagesNew/star.png"></li>
							<?php endfor; ?>
							<?php if (strpos($tour_rating,".")) : ?>
								<li><img class="star_images" src="images/halfstarnew.png"></li>
							<?php 
								$x++;
								endif; ?>
						</ul>           
		                <p class="reviews yelpuser-review" style="color:#0355a9; cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id ; ?>" ><?php echo $tour_review_count ; ?> Reviews</p>
						<ul class="tour_cate_type" style="color:black";>
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
						<div class="col-md-8">
							<ul class="list_f tour_address">
								<li><?php echo $tour_location_address1 ; ?></li>
								<li><?php echo $tour_location_address2 ; ?></li>
								<li><?php echo $tour_city ; ?>  <?php echo $tour_state ; ?>  <?php echo $tour_zipCode ; ?></li>
								<li><?php echo $tour_phone ; ?></li>
							</ul>
						</div>
						<div class="review_button">
							<button type="button" class="vewmenu yelpuser-review" data-toggle="modal" data-target="#myModal-review"  data-id=<?php echo $tour_id ; ?>>Reviews</button>
						</div>
				  	</div>
				</div>
	<?php
			endforeach;
			?>
			<div class="load_more_yelps" style="text-align: center;color: black;" data-id="<?php echo $limit; ?>">Load more<div>
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
	endif;
?>
