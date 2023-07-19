<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$limit = $_POST['limit'];
$dropCity = $_POST['formatted'];
$key = str_replace(' ','+',$_POST['key']);

$prepAddr = str_replace(' ','',$dropCity);

$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
$output= json_decode($geocode);
$latitude = $output->results[0]->geometry->location->lat;
$longitude = $output->results[0]->geometry->location->lng;


$ch = curl_init();   
$urlgo = "https://api.yelp.com/v3/businesses/search?term=".$key."&latitude=".$latitude."&longitude=".$longitude."&limit=".$limit."";
curl_setopt($ch, CURLOPT_URL, $urlgo);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

$headers = array();
$headers[] = "Authorization: Bearer BjJKM-1ZSbav4VMbtIUvC4isdLkwrihG9XDUanCcbbknBWIXs1XHBbJnuzH5vgD0ETyCpxAg3FAvMvxB_z6QCnusskWwYEofgpkNvOY7ytK_HKGrGv-98bo44V-AWnYx";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
	echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

$get_deals = json_decode($result);

$getyelpTourData = $get_deals->businesses;
if(!empty($getyelpTourData)){

	/* $html .='<div class="live-concerts yelp-tour-logo"><input type="text" name="search-yelp-horizontal" class="horizontal_yelp_content new_yelp_Content_cust" value="" id="search-yelp-horizontal" placeholder="What are you looking for?" style="border: 1px solid grey !important;padding: 12px !important;margin-left: 0;margin-bottom: 20px !important; color :grey" autocomplete="off">
			<div id="suggesstion-box"></div>
		    <input type="submit" id="hitTeam" class="filtering_button" name="enter_buton"> 
		    <input type="submit" id="yelp-hitAjaxCity" class="filtering_button new_cust_filt_button" name="enter_buton" style="top: 0px;"><img src="https://mysittivacations.com/images/yelp-logo.png" class="yelp_images_logo" style="display: inline-block;"></div>';*/
		    $html .= ' <div class="row">';
		    foreach ($getyelpTourData as $homeData)
		    {

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

		    	$tour_category1 = @$homeData->categories[0]->title;
		    	$tour_category2 = @$homeData->categories[1]->title;
		    	$tour_category3 = @$homeData->categories[2]->title;


		    	$html .= "<div class='col-lg-4 custom_column_one'>
		    	<div class='grid mb-4'>
		    	<div class='image_htfix_mid'><a href='".$tour_url."' target='_blank'>";
		    	if(!empty($tour_image)) {
		    		$html .= "<img src='".$tour_image."'>";
		    	} else {
		    		$html .= "<img src='https://mysitti.com/images/noimage-found.jpeg'>";
		    	}
		    	$html .= "</a></div>

		    	<div class='item_content yelp_content'>
		    	<h3><a href='".$tour_url."' target='_blank'>".$tour_name."</a></h3>
		    	<p class='location'><i class='fas fa-map pe-2'></i>".$tour_city. "</p>
		    	<div class='stars_tag pb-4'> <span class='hotel_tag'>".$tour_category1."</span><div class='star_rate'>";

		    	for($x=1;$x<=$tour_rating;$x++) {

		    		$html .= " <span class='fa fa-star checked'></span>";
		    	}
		    	if (strpos($tour_rating,'.')) {

		    		$html .= "<span class='fa fa-star checked'></span>";

		    		$x++;
		    	}
		    	$html .= "<span  class='reviews yelpuser-review'  style='cursor:pointer;'' data-toggle='modal' data-target='#myModal-review' data-id='".$tour_id."'>(".$tour_review_count." Ratings)</span></div>

		    	</div>




		    	</div>
		    	</div>
		    	</div>

		    	<div class='modal fade' id='myModal-review' role='dialog'>

		    	<div class='modal-dialog'>

		    	<div class='modal-content'>
		    	<div class='modal-header'>

		    	<span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>

		    	<button type='button' class='close' data-dismiss='modal'>&times;</button>
		    	<h4 class='modal-title'></h4>
		    	</div>
		    	<div class='tuorfun'>
		    	<ul class='modal-tour-review'>

		    	</ul> 	 
		    	</div>
		    	<div class='modal-footer'>
		    	<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		    	</div>
		    	</div>

		    	</div>
		    	</div>
		    	";
		    }

		    $html .= '</div>';
		    echo $html;


		    ?>
		    <div class="text-center">
		    	<div class="browse_load_more " style="text-align: center;color: black;" data-key="<?php echo $key; ?>" data-limit ="<?php echo $limit; ?>">Load more</div>
		    </div>
		<?php } else { ?>
			<div class="text-center">
				<h3> No Results Found </h3>
			</div>
			<?php } ?>