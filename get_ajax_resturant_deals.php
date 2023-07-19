<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$restaurantsData = $_POST['restaurantData'];
$citysearch = rawurlencode($_POST['city']);

$prepAddr = str_replace(' ','+',$_POST['city']);
	$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;


	$ch = curl_init();   

	$urlgo = "https://api.yelp.com/v3/businesses/search?term=".rawurlencode($restaurantsData)."&latitude=".$latitude."&longitude=".$longitude."";

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

    $getyelpresCateData = $get_deals->businesses;

  
?>
	  	
		<div class="marGin"></div>
						
		<?php 

	
     foreach ($getyelpresCateData as $homeData)
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
        
        
        
	     $html .= "<div class='row tab-two'>
				    <div class='col-md-5 col-sm-5 col-xs-12'>
					 <div class='m_2 tour_images'><a href='".$tour_url."' target='_blank'>";
					 if(!empty($tour_image)) {
					$html .= "<img src='".$tour_image."'>";
					 } else {
					$html .= "<img src='https://mysitti.com/images/noimage-found.jpeg'>";
					 }
					$html .= "</a></div>
					</div>
						  <div class='col-md-7 col-sm-7 col-xs-12'>
					    <h2 class='hu tour_names'><a href='".$tour_url."' target='_blank'>".$tour_name."</a></h2>
						
				 	<ul class='rating2 tour_ratingd'>";

						 for($x=1;$x<=$tour_rating;$x++) {

						 	$html .= "<li><img src='imagesNew/star.png'></li>";
						 }
						 if (strpos($tour_rating,'.')) {

						  $html .= "<li><img src='images/halfstar.png'></li>";

							$x++;
						}
						 $html .= "</ul>
                             
                        <p class='reviews yelpuser-review' style='color:#0355a9; cursor:pointer;' data-toggle='modal' data-target='#myModal-review' data-id=".$tour_id." >".$tour_review_count. ' Reviews'."</p>
                        
						<ul class='tour_cate_type' style='color:black';>
						 <li>".$tour_category1.', '.$tour_category2.' '.$tour_category3."</li>
						</ul>

						<div class='col-md-8'>
						<ul class='list_f tour_address'>
						  <li>".$tour_location_address1."</li>
						  <li>".$tour_location_address2."</li>
						  <li>".$tour_city. '&nbsp'. $tour_state . '&nbsp'. $tour_zipCode."</li>
						  <li>".$tour_phone."</li>

						</ul>
						</div>
						<div class='review_button'><button type='button' class='vewmenu yelpuser-review' data-toggle='modal' data-target='#myModal-review'  data-id=".$tour_id.">Reviews</button></div>
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
					     <ul class='modal-rest-review'>
							
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
    	
    	
    	echo $html;


	  ?>