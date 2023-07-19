<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$page = $_POST['page'];
$dropdown_value = 'Winery';
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
	if(isset($_POST['limit'])){
		$limit = $_POST['limit'];
	}else{
		$limit = '';
	}
	$getyelpTourData = yelp_api_call($limit,$_SESSION['city_name'],'Winery'); 
	if(!empty($getyelpTourData)):
	foreach ($getyelpTourData as $homeData){
		$tour_id = $homeData->id;
		$eventsName= $homeData->name;
		$image_url = $homeData->image_url;
		$eventUrl = $homeData->url;
		$tour_review_count = $homeData->review_count;
		$tour_rating = $homeData->rating;
		$venue_name = $homeData->location->address1;
		$address1 = $homeData->location->address1;
		$address2 = $homeData->location->address2;
		$city = $homeData->location->city;
		$zipCode = $homeData->location->zip_code;
		$country = $homeData->location->country;
		$state = $homeData->location->state; 
		$tour_phone = $homeData->display_phone;

		$image = "https://mysitti.com/images/noimage-found.jpeg"; 
		if(!empty($image_url)){
		$image =  $image_url ;
		}
		$html .= "<div class='slide' data-aos='zoom-in-right'>
			<a href=".$eventUrl." target='_blank'>
				<div class='discount-block'>
					<div class='cities'>
					<img src= ".$image.">
					</div>
					<div class='discount-content'>
						<h3> ".$eventsName."</h3><span><i class='fa fa-map-marker' aria-hidden='true'></i>".$venue_name."</span>
					</div>
					<div class='comedy-add-details'>
						<p><i class='fa fa-map-marker' aria-hidden='true'></i> ".$address1."  ".$address2.", ".$city.", ".$country."</p>
					</div>
					<div class='discount-action hotels'>
						<a href=".$eventUrl." target='_blank' class='hotel-book'>SEE MORE</a>
					</div>
				</div>
			</a>
		</div>";
	}
	$html.='<div class="view-tag" data-aos="zoom-in-down">
		<a href="javascript:;"  class="load_more_search" data-key="'.$_POST['key'].'" data-id="'.$limit.'">View All</a>
	</div>';
	//$html .= '<div class="text-center"><div class="load_more_search" style="text-align: center;color: black; margin-bottom:20px;" data-key="'.$_POST['key'].'" data-id="'.$limit.'">Load more</div></div> ';
echo $html;
	endif;
?>
