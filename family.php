<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Family"; 
if(isset($_SESSION['city_name'])){

	include('header-newfile.php');	// not login
}else{
	header('location:https://mysittivacations.com/');
}
session_start();
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");

$dropCity = $_SESSION['city_name'];

if($dropCity == 'Washington D.C.'){
	$dropCity = 'Washington';
}elseif($dropCity == 'Washington DC'){
	$dropCity = 'Washington';
}
$dropdown_value = 'family attractions';

$date1 = date("Y-m-d");
$start_date = date("Y-m-d", strtotime($date1)).'T12:00:00Z';
$date2 = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y')));
$end_date = date("Y-m-d", strtotime($date2)).'T12:00:00Z';


$city_name_query = @mysql_query("SELECT dma_id, country_name FROM us_country_dma WHERE country_name ='".$dropCity."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$city_dma_id = $get_city_name['dma_id'];



$url = "https://app.ticketmaster.com/discovery/v2/classifications?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".rawurlencode($dropdown_value)."&preferredCountry=us";

$response_content = file_get_contents($url);
$response = json_decode($response_content, true);

$classifications = $response['_embedded']['classifications'];

$data = [];

foreach ($classifications as $key => $classification) {

	$generes = $classification['segment']['_embedded']['genres'];
	$ids = implode(',', array_map(function($genere){
		return $genere['id'];
	}, $generes));

	$data[$key] = $ids;
}

$ids = implode(',', $data);

if($date1){
	$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&startDateTime=".$start_date."&endDateTime=".$end_date."&countryCode=US&classificationId=".$ids."&dmaId=".$city_dma_id."&page=0"; 
}else{
	$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&countryCode=US&classificationId=".$ids."&dmaId=".$city_dma_id."&page=0";
}
    //https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&countryCode=US&classificationId=&dmaId=381&page=0

$result_get = file_get_contents($urlgo);
$get_all_data1 = json_decode($result_get, true);

$page_size = $get_all_data1['page']['size'];
$totalPages = $get_all_data1['page']['totalPages'];
$number = $get_all_data1['page']['number'];

$get_ticket_data = $get_all_data1['_embedded']['events']; ?>

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<style>
#where_say_section #city_deals_home .blissey-widget .blissey-gallery-images{
      min-height: 257px !important;
}  
#city_deals_home .blissey-widget--l .blissey-widget-body-hotels-full-list-item-gallery {
    min-height: 257px !important;
}
#city_deals_home .blissey-widget .blissey-info-details-specification__hotel_name:hover {
    color: #000 !important
}
#where_say_section #city_deals_home .blissey-widget .blissey-info-price-wrapper-button a {
    padding-right: 46px !important;
    width: 122.42px;
    font-size: 14px !important;
    padding: 6px 12px !important;
    height: 42px !important;
    text-align: center;
    line-height: 36px !important;
    margin-left: 5px!important;
}
#where_say_section .blissey-widget .blissey-info-price-wrapper-button a:before {
    width: 25px;
    height: 25px;
}
#where_say_section .blissey-widget .blissey-info-price-wrapper-button a:after {
    right: 18px !important;
    top: 13px !important;
}
#where_say_section .blissey-widget .blissey-info-price-wrapper-button {
    padding-right: 5px !important;
}
#where_say_section .blissey-widget .blissey-info-price-wrapper {
    padding: 15px 5px !important;
}
</style>
<div class="v2_content_inner2">
	<div id="loader"></div>
</div>
<input type="hidden" id="inputCity" value="<?php if(isset($_SESSION['city_name'])){ echo $_SESSION['city_name']; } ?>">
<div class='modal fade' id='popularcitiesModal' role='dialog'>

	<div class='modal-dialog modal-dialog-centered modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h5>Popular Cities</h5>
				<button type='button' class='close' data-dismiss='modal'>&times;</button>
				
			</div>
			<div class="modal-body">
				<div class="cities_modal">
					<p></p>

					<div id="modal_loader"></div> 
				</div>
			</div>
			
			<!-- <div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			</div> -->
		</div>
	</div>
</div>
<!--<section class="inner_page_hero sec_pad familyhead">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="hero_section_content">
					<h2 class="mb-5">Family Fun in <?php echo $_SESSION['city_name']; ?>
				</h2>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="content-bannersss">
				<input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

				<input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['full_city_name'];?>" required="">

				<a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><img src="/css/optimize/images/search.png" alt=""></a>
			</div>
		</div>
	</div>
</div>
</section>-->
<div data-aos="zoom-in-right" class="banner-section hotel-hero city-hero" style="background-image:url(images/family-hero.png)"> 
	<div class="container">
		<div class="mobile-hero">
			<img src="images/family-hero.png">
		</div>
		<div class="carousel-caption-top">
		   <h1>Family Fun in <?php echo $_SESSION['city_name']; ?></h1>
		</div>
		<div class="view-all-sec">
			<div class="view-tag" data-aos="zoom-in-down">
				<a href="#">Search</a>
			</div>
		</div>
		<div class="free-trail-form">
		   <div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<div class="search-content hotels">
							<ul>
								<li>
									<div class="form-group">
										<input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

										<input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['full_city_name'];?>" required="">
										<a id="hitAjaxwithCity" class="search-btn hitbutton" href="#">Search</a>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
	   </div>
	</div>
</div>
<!--end of hero section-->
<?php include('category-newfile.php'); ?>
<!--end of category -->
<!--<section class="travels sec_pad what_do pt-0">
	<div class="container">
		<div class="heading">
			<h4>Popular things to do</h4>
			<p>Find fun places to see and things to do experience the art, museums, music, zoos</p>
		</div>
		<div class="travels_inner slider_nav mb-0">
			<div class="what_do_slider owl-carousel owl-theme">
				<div class="grid">
					<a id="top_links" name="Museum" >
						<div class="image_sq_htfix"> 
							<img src="img/ss/ttd_img1.png" alt="Museum" class="img-fluid w-100">
						</div>
						<h3>Museum</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="Sightseeingguide" name="Sightseeing" >
						<div class="image_sq_htfix"> 
							<img src="img/ss/ttd_img2.png" alt="Sightseeing" class="img-fluid w-100">
						</div>
						<h3>SIGHTSEEING/TOURS</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="tourforfun" name="Tours" >
						<div class="image_sq_htfix"> 
							<img src="img/ss/ttd_img3.png" alt="DAY TRIP" class="img-fluid w-100">
						</div>
						<h3>DAY TRIP</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="nightlife_yelp" name="top attractions">
						<div class="image_sq_htfix"> 
							<img src="img/ss/ttd_img4.png"  alt="top attractions" class="img-fluid w-100">
						</div>
						<h3>TOP ATTRACTIONS</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="nightlife_yelp" name="nightlife" >
						<div class="image_sq_htfix"> 
							<img src="images/nightlife.jpg" alt="nightlife" class="img-fluid w-100">
						</div>
						<h3>Nightlife</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="top_links" name="Fine Dinning" >
						<div class="image_sq_htfix"> 
							<img src="images/fine-dining.jpg" class="img-fluid w-100" alt="Fine Dinning">
						</div>
						<h3>Fine Dinning</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="top_links" name="Shopping">
						<div class="image_sq_htfix"> 
							<img src="images/shopping-new.jpg" alt="Shopping"  class="img-fluid w-100">
						</div>
						<h3>Shopping</h3>

					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>-->

<div class="slider-section flight-sec"> 
			<div class="container">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2>Popular things to do</h2>
				   <p>Find fun places to see and things to do experience the art, museums, music, zoos</p>
				</div>
				<div class="testimonial-section products">
				   <div class="owl-carousel owl-theme" id="ProductSlide">
					   
					   <div data-aos="zoom-in-left" class="testimonial-block product">
						  <div class="cities">
							    <img src="images/thing-to-do/things1.png">
								<a id="top_links" name="Museum"><p>Museum</p></a>
								<a href="#" class="starer"><i class="fa fa-star" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="testimonial-block product">
							<div class="cities">
							    <img src="images/thing-to-do/seeingtours.png">
								<a id="Sightseeingguide" name="Sightseeing"><p>Sightseeing/tours</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
							</div>
					   </div>
					   <div data-aos="zoom-in-right" class="testimonial-block product">
							<div class="cities">
							    <img src="img/ss/ttd_img3.png">
								<a id="tourforfun" name="Tours"><p>DAY TRIP</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
							</div>
					   </div>
					   
					    <div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="img/ss/ttd_img4.png">
							    <a id="nightlife_yelp" name="top attractions"><p>TOP ATTRACTIONS</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="images/thing-to-do/Nightlife.png">
							    <a id="nightlife_yelp" name="nightlife"><p>Nightlife</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-left" class="testimonial-block product">
						  <div class="cities">
								<img src="images/thing-to-do/Shopping.png">
								<a id="top_links" name="shopping"><p>Shopping</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="images/fine-dining.jpg">
								<a id="top_links" name="Fine Dinning"><p>Fine Dinning</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
				   </div>
				</div>
			</div>
		</div>
		
<?php $get_deals = groupon_api_call('3','','ga-family-getaways');?>
<div class="slider-section discount-section groupon_discount_sec"> 
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2>Groupon Tour Discounts</h2>
				   <p>Stories, tips, and guides</p>
				</div>
			</div>
			<?php  $i= 0;
			foreach ($get_deals as $homeData):
			if($i%2==0){
				$dataaos="zoom-in-right";
			}else{
				$dataaos="zoom-in-left";
			}
			?>
			<div data-aos="<?php echo $dataaos;?>" class="col-12 col-sm-6 all-inclusive col-md-4 col-lg-4 section_<?php echo $i; ?>">
				<?php   $i++; 
				echo $homeData['cardHtml']; ?>
			</div>		
			<script>
			$(document).ready( function (){
				var pics_str = $('.section_<?php echo $i; ?> .cui-image').data('srcset');
                  if(pics_str != undefined){
						var pics_arr = pics_str.split(',');
						pics_str = '';
						$.each(pics_arr, function(index, el) {
						imgPath = this.trim();
						imgPath = imgPath.substring(0, imgPath.indexOf('.jpg')+4);
					   $('.section_<?php echo $i; ?> .cui-svg-placeholder').css({"background-image":"url("+imgPath+")"});
					});
                  }
              });
          </script> 
			<?php 
			endforeach;?>
			<div class="view-tag" data-aos="zoom-in-down">
				<a href="#" data-toggle="modal" data-target="#groupon_discount" target="_blank" class="groupon_discount btn btn-outline-dark px-4">View all</a>
			</div>
		</div>
	</div>
</div>
<?php function groupon_api_call($limit,$city,$key){
		$url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&address=".urlencode($_SESSION['city_name']);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
		$responseJson = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($responseJson);

		if ($response->status == 'OK') {
			$latitude = $response->results[0]->geometry->location->lat;
			$longitude = $response->results[0]->geometry->location->lng;
		} 
		if(!empty($city)):
			$prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
			$key = str_replace(' ','+',$key);
			$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
			$output= json_decode($geocode);
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;

			$urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)%20AND%20context=web_getaways&showBestOption=true&divisionLoc=41.184,-96.15&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
		// endif;
		else:

			if(!empty($key)):
				if($key == 'restaurants'){
					$urlgo = "https://www.groupon.com/occasion/deals-json?filterQuery=(subcategory:".$key.")&context=web_holiday&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=3";
				} else {
					$urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)&context=web_getaways&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
				}
			else:
				$urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)%20AND%20context=web_getaways&showBestOption=true&divisionLoc=41.184,-96.15&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
			endif;
		endif;
		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
		$get_deals = $get_all_data['deals'];
		return $get_deals;
	}
	?>
	<!--end of Grupon discount -->
	<?php function yelp_api_data($limit,$city,$keyword){
		$prepAddr =empty($city)?'Chicago': str_replace(' ','+',$city);
		$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
		$ch = curl_init();   
		$key = str_replace(' ','+',$keyword);
		$urlgo = empty($limit) ? 'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'':'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'&limit='.$limit.'';
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
		$get_deals = json_decode($result);

		$getyelpTourData = $get_deals->businesses;
		return $getyelpTourData;
	}?>

	<div class="slider-section discount-section stay-sec blog-feat" > 
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12">
					<div data-aos="zoom-in-left" class="myheader-sec">
					   <h2>Top Attractions in <?php echo $_SESSION['city_name']; ?></h2>
					</div>
				</div>
			</div>
			<?php 
			$ciountt = 0;
			$getyelpTourData = yelp_api_data('6',$_SESSION['city_name'],'family attractions'); 
			if(!empty($getyelpTourData)) { ?>
			<div class="row">
					<?php foreach ($getyelpTourData as $homeData):
						
						if($ciountt%2==0){
							$dataaos='zoom-in-right';
						}else{
							$dataaos='zoom-in-left';
						}
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
						$tour_phone = $homeData->display_phone;					?>
							<div data-aos="<?php echo $dataaos;?>" class="col-12 col-sm-6 col-md-4 col-lg-4">
							<a href="<?php echo $tour_url ; ?>" target="_blank">
							<div class="discount-block city">
								<?php if(!empty($tour_image)) : ?>
									<img src="<?php echo $tour_image; ?>" class="img-fluid w-100" alt="<?php echo $tour_name ; ?> ">
								<?php else : ?>
									<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg" class="img-fluid w-100" alt="<?php echo $tour_name ; ?> ">
								<?php endif; ?>
								<div class="blog-time">
									<p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $tour_location_address1.''.$tour_location_address2 ; ?></p>
									<!--<p><i class="fa fa-calendar" aria-hidden="true"></i> September 6, 2022</p>-->
								</div>
								<div class="discount-content">
									<h3><?php echo $tour_name ; ?></h3>
								</div>
								<p class="trav-sec desti"><span><?php echo $tour_city ; ?></span></p>
							</div>
							</a>
						</div>
						<?php 
						$ciountt++;
						endforeach; ?>
					</div>
				<?php } else { ?>
					<div class="row">
						<div class="yelp-serach-null-result col-md-5 col-sm-5 col-xs-6">
							<p> No record Found</p>
						</div>
					</div>
				<?php } ?>
				
		</div>
	</div>
		
		
		
		
	<!--end of top attraction-->
	
	
	<div class="slider-section tour-sec"> 
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12">
					<div data-aos="zoom-in-left" class="myheader-sec">
					   <h2>Tours & Travel</h2>
					   <p>Enjoy the scenic views of National Parks</p>
					</div>
				</div>
			</div>
			<div class="row">
			 <div class="testimonial-section ">
				 <div class="owl-carousel owl-theme" id="ProductSlide-audio2">
						<?php 
						if($_SESSION['city_name'] == 'Washington D.C.'){
								$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' LIMIT 10";
							}else{
								$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun' LIMIT 10";
							}
							$result = $mysqli->query($randon_deals);
							$random=0;
							foreach ($result as $keys => $values) {
								if($random%2==0){
									$dataaos='zoom-in-right';
								}else{
									$dataaos='zoom-in-left';
								}
								if(!empty($values['tag'])){
									$new = substr($values['link'], strrpos($values['link'], '=' )+1);
									$buy_urls = str_replace('%3A%2F%2F', '://', $new);
									$buy_urlss = str_replace('%2F', '/', $buy_urls);
									$buy_urlsss = str_replace('%3F', '/', $buy_urlss);
									$buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
									$buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
									$buy_url = $buy_urlsssss; 
									?>
									<div data-aos="<?php echo $dataaos;?>" class="col-12 ">
										<a href="<?php echo $buy_url; ?>"  target="_blank">
											<div class="discount-block">
												<img src="<?php echo $values['image_link']; ?>" alt="<?php echo $values['title']; ?>" >
												<div class="discount-content">
													<h3><?php echo substr($values['title'],0,20). '...';; ?></h3>
												</div>
											</div>
										</a>
									</div>
								<?php } 
								$random++;
							}?>
						</div>
					</div>
				<div class="view-tag" data-aos="zoom-in-down">
					<a href="#" data-toggle="modal" data-target="#national_parks" target="_blank" class="national_pas btn btn-outline-dark px-4">View all</a>
				</div>
			</div>
		</div>
	</div>
	<!--end of see_beautiful -->
	
	
	
	<div class="slider-section discount-section where_say_sec" id="where_say_section"> 
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>Places to stay in  <?php echo $_SESSION['city_name']; ?></h2>
						   <p> <?php echo $_SESSION['city_name']; ?> Hotels and Places to Stay</p>
						</div>
					</div>
				</div>
				<div class="travels_inner">
				<div class="row what_do_slider22" id="city_deals_home">
					
						<?php $getAds = "SELECT content FROM specific_city_sidebar WHERE city like '%".$_SESSION['city_name']."%' limit 1";
						$result = $mysqli->query($getAds);
						$count = $result->num_rows;
						if($count > 0){
							foreach ($result as $key => $value) {
								$fiveStar = str_replace('popularity', 'Pet Friendly&popularity', $value['content']);?>

								<?php   echo "<div data-aos='zoom-in-right' class='grid'>".str_replace('limit=50', 'limit=4', $fiveStar)."</div>"; ?>
							<?php }
						}?>
					
					
					<div class="view-tag">
						<a href="https://mysittivacations.com/hotels/index.php" class="btn btn-outline-dark px-4">View all</a>
					</div>
				</div>
				</div>
			</div>
		</div>
<!-- end of hotel section -->
<?php  $get_deals = groupon_api_call('','','restaurants'); ?>
<div class="slider-section restuarent groupon_discount_sec"> 
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>Restraurant Deals</h2>
						   <p>Save Yourself Or Family Money With Meal Deals</p>
						</div>
					</div>
					<?php 
					$i= 0;

					foreach ($get_deals as $homeData){
						$price = $homeData['options'][0]['price']['formattedAmount'];
						$value = $homeData['options'][0]['value']['formattedAmount'];
						$discountPercent = $homeData['options'][0]['discountPercent'];
						$endAt =  $homeData['options'][0]['endAt'];
						$endDate = date('m/d/Y', strtotime($endAt));
						$tour_review_count =$homeData['merchant']['recommendations'][0]['total'];
						$tour_rating = $homeData['merchant']['recommendations'][0]['rating'];
						$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
						$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
						$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
						$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
						$tourname = $homeData['merchant']['name']; 
						$out =  substr($tourname,0,60);?>
						<div class="col-lg-4 all-inclusive sections_<?php echo $i; ?>">
							<?php   $i++; 
							echo $homeData['cardHtml']; ?>
							
						</div>
						<script>
							$(document).ready( function (){
								var pics_str = $('.sections_<?php echo $i; ?> .cui-image').data('srcset');
							  if(pics_str != undefined){
								var pics_arr = pics_str.split(',');
								console.log('.section_<?php echo $i; ?>');
								pics_str = '';
								$.each(pics_arr, function(index, el) {
									imgPath = this.trim();
									imgPath = imgPath.substring(0, imgPath.indexOf('.jpg')+4);
									$('.sections_<?php echo $i; ?> .cui-svg-placeholder').css({"background-image":"url("+imgPath+")"});
								});
							  }
						  });
						</script> 
						<?php 
					} ?>
					
				</div>
			</div>
		</div>
<?php if(isset($_GET['yelp']) && $_GET['yelp'] != 'peek'){ ?>
	
<script type="text/javascript">
		jQuery(document).ready(function(){
			var limit = "9";
			var geodemo = jQuery('#target').val();
			var quick_link = "<?php echo $_GET['yelp'] ?>";
			jQuery.ajax({
				url: "ajax_yelp_dev.php",
				type: "POST",
				data: {
					limit : limit,
					formatted: geodemo,
					key: quick_link
				},
				beforeSend: function()
				{
					jQuery("#loader").addClass("loading");
				},
				success: function (response) 
				{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
		})
	</script>
<?php } ?>
<?php if(isset($_GET['yelp']) && $_GET['yelp'] = 'peek'){ ?>
	<script>
		jQuery(document).ready(function(){
			var offset = '9';
			var geodemo = jQuery('#target').val();
			jQuery.ajax({
				url: "ajax_peek.php",
				type: "POST",
				data: {
					city_name: geodemo,
					offset:offset
				},
				beforeSend: function()
				{
					jQuery("#loader").addClass("loading");
				},
				success: function (response) 
				{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
		});
	</script>
<?php } ?>
<script type="text/javascript">
	var app = new Vue({
		el: '#thingsToDo',
		data:{
			members:'',
			tours:'',
			groupon:'',
			debug: true,
			title: 'Tour Discounts',
			key: 'Museum',
			grouponkey: 'tours',
			formatted: '<?php echo $_SESSION['city_name']; ?>',
			checkSessionServer: '',
			limit :'9',
			ajaxRequest: false
		},

		mounted: function(){
			<?php if(!isset($_GET['yelp'])){ ?>
				this.getSpecificData();
			<?php } ?>
			this.getSpecificTours();
			this.getGrouponDeals();
		},

		methods:{
			getSpecificData: function(){
				var vm = this;
				vm.ajaxRequest = true;
				vm.checkSessionServer =  axios.post('ajax_yelpRestDeals.php', {formatted: vm.formatted,key: vm.key,limit: vm.limit });
				vm.checkSessionServer.then(function(response){
					app.members = response.data;
					vm.ajaxRequest = false;
				});
			},
			getSpecificTours: function(){
				var vm = this;
				vm.ajaxRequest = true;
				vm.checkSessionServer =  axios.post('ajax_things_tours.php', {formatted: vm.formatted});
				vm.checkSessionServer.then(function(response){
					app.tours = response.data;
					vm.ajaxRequest = false;
				});
			},	
			getGrouponDeals: function(){
				var vm = this;
				vm.ajaxRequest = true;
				vm.checkSessionServer =  axios.post('ajax_groupon_things.php', {formatted: vm.formatted,key: vm.grouponkey,title:vm.title});
				vm.checkSessionServer.then(function(response){
					app.groupon = response.data;
					Vue.nextTick(function(){
						jQuery('.owl-carousel').owlCarousel({
							items: 4,
							loop: true,
							margin: 10,
							autoplay: false,
							responsiveClass: true,
							responsive: {
								0: {
									items: 1,
									nav: true
								},
								600: {
									items: 3,
									nav: false
								},
								1000: {
									items: 4,
									nav: true,
									loop: false,
									margin: 20
								}
							}
						});
					}.bind(vm));
					vm.ajaxRequest = false;
				});
			}
		}
	});
	jQuery(document).ready(function(){
		jQuery('#localShopping').click(function(){
			jQuery('#popularcitiesModalShopping').show();
		});
		jQuery('.yelpShopping').click(function(){
			jQuery('#popularcitiesModalShopping').hide();
		})
		if( jQuery(window).width() < 640 ) {
			jQuery(".tourmobile").show();
		}	
	});	
	jQuery(document).on("click", ".general_page_link", function () {

		var el = jQuery(this);
		var modal_title = el.data('title');
		var tableName = el.data('table');
		var typeofmodal = el.data('trigger');
		var modal_link =  el.data('link');
		jQuery.ajax({
			url: "ajax_general_page.php",
			type: "POST",
			data: {
				tableName : tableName,
				trigger : typeofmodal,
				title : modal_title,
				modal_link : modal_link
			},
			beforeSend: function()
			{
				jQuery("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				jQuery('.cities_modal').html(response);
				jQuery("#modal_loader").removeClass("loading");
			}
		});
	});
	//////////////////////////////////////////////////////////
  	// Function for yelp horizontal design top search box  //
	/////////////////////////////////////////////////////////
	function yelpHorizontalSearchs(new_val){
		var keyword = new_val;
		var geodemo = jQuery('#fullCityName').val();
		var limit = "9";
		if(keyword != '' && keyword != null){
			console.log(keyword);
			jQuery.ajax({
				url: "ajax_yelp_deals.php",
				type: "POST",
				data: {
					limit           : limit,
					new_val         :new_val,
					formatted 	   	: geodemo,
					design    		: 'Horizontal',
					key      			: keyword
				},
				beforeSend: function()
				{
					jQuery("#loader").addClass("loading");
				},
				success: function (response) 
				{
					jQuery('.top_title').html(keyword);
					jQuery('.oneArticle').html(response);
					jQuery('html, body').animate({
						scrollTop: jQuery(".oneArticle").offset().top
					}, 2000);
					jQuery("#loader").removeClass("loading");
				}
			});
		}
		else{
			alert('Please Enter Keyword.')
		}
	}
	function yelpHorizontalSearch(new_val){
		var keyword = jQuery('#search-yelp-horizontal').val();
		var geodemo = jQuery('#fullCityName').val();
		var limit = "9";
		if(keyword != '' && keyword != null){
			console.log(keyword);
			jQuery.ajax({
				url: "ajax_yelp_deals.php",
				type: "POST",
				data: {
					limit           : limit,
					new_val         :new_val,
					formatted 	   	: geodemo,
					design    		: 'Horizontal',
					key      			: keyword
				},
				beforeSend: function()
				{
					jQuery("#loader").addClass("loading");
				},
				success: function (response) 
				{
					jQuery('.oneArticle').html(response);
					jQuery("#loader").removeClass("loading");
				}
			});
		}
		else{
			alert('Please Enter Keyword.')
		}
	}
	
	jQuery('body').on('keyup', '#search-yelp-horizontal', function () { 
		var key = jQuery(this).val();
		var city = jQuery('#fullCityName').val();

		jQuery.ajax({
			url: "ajax_yelp_auto1.php",
			type: "POST",
			data: {
				formatteds: key, city: city,
			},
			success: function (res) 
			{  
				console.log(res); 
				jQuery("#suggesstion-box").html('');
				jQuery("#suggesstion-box").show();  
				jQuery("#suggesstion-box").html(res);

			},
		});
	});

	jQuery('body').on('click','#suggesstion-box li' ,function()
	{
		var val = jQuery(this).text();
		jQuery("#search-yelp-horizontal").val(val);
		var new_val = jQuery("#search-yelp-horizontal").val();
		yelpHorizontalSearch(new_val);
		jQuery("#suggesstion-box").hide(); 
		jQuery('html, body').animate({
			scrollTop: jQuery("#suggesstion-box").offset().top
		}, 1000);  
	});
	jQuery(document).on('keydown','#search-yelp-horizontal',function(e){
		var keyword= jQuery(this).val();
		var city = jQuery('#fullCityName').val();

		jQuery.ajax({
			url: "ajax_yelp_auto1.php",
			type: "POST",
			async:false,
			data: {
				formatteds: keyword, city: city,
			},
			success: function (res) 
			{  
				console.log(res); 
				jQuery("#suggesstion-box").html('');
				jQuery("#suggesstion-box").show();  
				jQuery("#suggesstion-box").html(res);

			},
		});
	});

	jQuery(document).on('click', '#yelp-hitAjaxCity', function(){
		var new_val = jQuery("#search-yelp-horizontal").val();
		yelpHorizontalSearch(new_val);
	});
	
	jQuery(document).on('keydown','#search-yelp-horizontal',function(e){
		var key = e.which;
		if(key == 13)  // the enter key code
		{
			var new_val = jQuery("#search-yelp-horizontal").val();
			yelpHorizontalSearch(new_val);
		}	
	});
	/////////////////////
  	// End serach box  //
	/////////////////////
	jQuery(document).on("click", ".open-CitiesDialog", function () {

		var el = jQuery(this);
		var modal_link = el.data('info');
		var modal_title = el.data('title');
		var modal_table =el.data('table');
		jQuery.ajax({
			url: "ajax_general_page.php",
			type: "POST",
			data: {
				modal_link : modal_link,
				modal_title : modal_title,
				modal_table : modal_table
			},
			beforeSend: function()
			{
				jQuery("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				jQuery('.cities_modal').html(response);
				jQuery("#modal_loader").removeClass("loading");
			}
		});    
	});
	jQuery(document).on("click", ".open-SportsDialogs", function () {
		var el = jQuery(this);
		var modal_title = el.data('title');
		var modal_trigger =el.data('trigger');
		var modal_city =el.data('city');
		var modal_table2 =el.data('table2');
		jQuery.ajax({
			url: "ajax_specific_landingpage.php",
			type: "POST",
			data: {
				modal_title : modal_title,
				modal_trigger : modal_trigger,
				modal_city : modal_city,
				modal_table2 : modal_table2
			},
			beforeSend: function()
			{
				jQuery("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				jQuery('.cities_modal').html("");
				jQuery('.cities_modal').html(response);
				jQuery("#modal_loader").removeClass("loading");
			}
		});    
	});

	jQuery(document).on("click", ".open-GrouponDialog", function () {
		var el = jQuery(this);
		var modal_info = el.data('info');
		var modal_title = el.data('title');
		var modal_limit =el.data('limit');
		var modal_city =el.data('city');
		var modal_key =el.data('key');
		var modal_url =el.data('url');
		jQuery.ajax({
			url: modal_url,
			type: "POST",
			data: {
				modal_info : modal_info,
				modal_title : modal_title,
				modal_limit : modal_limit,
				modal_city : modal_city,
				modal_key : modal_key
			},
			beforeSend: function()
			{
				jQuery("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				jQuery('.cities_modal').html(response);
				jQuery("#modal_loader").removeClass("loading");
			}
		});    
	});
</script>
<?php if(empty($_SESSION['city_name']) ):?>
	<script type="text/javascript">
		jQuery(window).load(function(){
			var source="yelp-tour";
			var title="Things To Do";
			var info = [
			{"source":"yelp-tour","name":"Best Comedy Cities","pageName":"comedy.php","tableName":"comedy_scence"},
					// {"source":"yelp-tour","name":"Popular Cities","pageName":"yelp-tour.php","tableName":"popular_cities"},
					{"source":"yelp-tour","name":"Family Friendly Cities","pageName":"family.php","tableName":"Cities_for_Families"},
					{"source":"yelp-tour","name":"Cities For Music Lovers","pageName":"concert.php","tableName":"cities_for_musiclovers"},
					// {"source":"yelp-tour","name":"Concert","pageName":"concert.php","tableName":"concert_cities"},
					{"source":"yelp-tour","name":"Exotic Vacations","pageName":"hotels/index.php","tableName":"Exotic_vacations"},
					// {"source":"yelp-tour","name":"America Music Lover","pageName":"concert.php","tableName":"america_music_lover"},
					{"source":"yelp-tour","name":"Asia,Europe,Australia","pageName":"hotels/index.php","tableName":"asia"},
					// {"source":"yelp-tour","name":"Australia","pageName":"hotels/index.php","tableName":"australia"},
					{"source":"yelp-tour","name":"Beaches","pageName":"hotels/index.php","tableName":"beach"},
					// {"source":"yelp-tour","name":"Canada","pageName":"hotels/index.php","tableName":"canada"},
					// {"source":"yelp-tour","name":"Europe","pageName":"hotels/index.php","tableName":"europe"}
					];
					jQuery.ajax({
						url: "ajax_general_page.php",
						type: "POST",
						data: {
							info 	: info,
							source  : source,
							title 	: title

						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
							jQuery('.things-to-do-cities').html(response);
							jQuery('.carousel-control-prev').trigger('click');
							jQuery("#loader").removeClass("loading");
						}
					});
				});
			</script>
		<?php endif; ?>
		<?php if(!empty($_SESSION['city_name']) ):?>
			<script type="text/javascript">
				jQuery(document.body).on('click','#hitAjaxCity',function(e){
					e.preventDefault();
					var geodemo = jQuery('#target').val();
					jQuery.ajax({
						url: "city_search_ajax.php",
						type: "POST",
						data: {
							formatteds: geodemo
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{   
							window.location.reload();
							jQuery("#loader").removeClass("loading");
						}
					});
				});
				jQuery(document).on("click", "#top_links", function (e) {
					e.preventDefault();
					var el = jQuery(this);
					jQuery('.oneArticle').css('display','block');
					jQuery('.side_side_bar').css('display','block');
					jQuery('.discounts_inner').css('display','none');
					var limit = "9";
					var geodemo = jQuery('#inputCity').val();
					var quick_link = el.attr('name');
					var quick_link = quick_link.replace(/[_\W]+/g, "-")
					jQuery.ajax({
						url: "ajax_yelp_dev.php",
						type: "POST",
						data: {
							limit : limit,
							formatted: geodemo,
							key: quick_link
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
							jQuery('.top_title').html(quick_link);
							jQuery('.oneArticle').html(response);
							jQuery('html, body').animate({
								scrollTop: jQuery(".oneArticle").offset().top
							}, 2000);
							jQuery("#loader").removeClass("loading");
						}
					});
				});

				jQuery(document).on("click", "#Sightseeingguide", function (e) {
				//jQuery('#sightseeingguide').click(function(){
					e.preventDefault();
					jQuery("#loader").addClass("loading");
					jQuery('.oneArticle').css('display','none');
					jQuery('.side_side_bar').css('display','none');
					jQuery('.discounts_inner').css('display','block');
					jQuery('.top_title').html('Sightseeing');
					jQuery('html, body').animate({
						scrollTop: jQuery(".discounts_inner").offset().top
					}, 2000);
					jQuery("#loader").removeClass("loading");
				});
				jQuery(document).on('click', '#nightlife_yelp', function(){
					jQuery('.oneArticle').css('display','block');
					jQuery('.side_side_bar').css('display','block');
					jQuery('.discounts_inner').css('display','none');
					var new_val = jQuery(this).attr('name');
					yelpHorizontalSearchs(new_val);
				});
				jQuery(document).on("click", ".browse_load_more", function (e) {
					e.preventDefault();
					var el = jQuery(this);
					var limit = jQuery(this).attr('data-limit');
					var limit = +limit+9;
					var geodemo = jQuery('#inputCity').val();
					var quick_link = jQuery(this).attr('data-key');
					jQuery.ajax({
						url: "ajax_yelp_dev.php",
						type: "POST",
						data: {
							limit : limit,
							formatted: geodemo,
							key: quick_link
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
				});
				jQuery(document).on("click", ".tour_load_more", function (e) {
					e.preventDefault();
					var limit = jQuery(this).attr('data-limit');
					var offset = +limit+9;
					var geodemo = jQuery('#inputCity').val();
					jQuery.ajax({
						url: "ajax_peek.php",
						type: "POST",
						data: {
							city_name: geodemo,
							offset:offset
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);
			   	// jQuery('html, body').animate({
			    //     scrollTop: jQuery(".oneArticle").offset().top
			    // }, 2000);
			    jQuery("#loader").removeClass("loading");
			}
		});
				});
				jQuery(document).on("click", ".peek_load_more", function (e) {
					e.preventDefault();
					var limit = jQuery(this).attr('data-limit');
					var offset = +limit+9;
					var geodemo = jQuery('#inputCity').val();
					jQuery.ajax({
						url: "ajax_tourforfun.php",
						type: "POST",
						data: {
							city_name: geodemo,
							offset:offset
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);

			   	// jQuery('html, body').animate({
			    //     scrollTop: jQuery(".oneArticle").offset().top
			    // }, 2000);
			    jQuery("#loader").removeClass("loading");
			}
		});
				});
				jQuery(document).on("click", "#tourforfun", function (e) {
					e.preventDefault();
					jQuery('.oneArticle').css('display','block');
					jQuery('.side_side_bar').css('display','block');
					jQuery('.discounts_inner').css('display','none');
					var offset = '9';
					var geodemo = jQuery('#inputCity').val();
					jQuery.ajax({
						url: "ajax_tourforfun.php",
						type: "POST",
						data: {
							city_name: geodemo,
							offset:offset
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);
		    	jQuery('.top_title').html('Day Trip');
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
				});
				jQuery(document).on("click", "#toursSight", function (e) {
					e.preventDefault();
					var offset = '9';
					var geodemo = jQuery('#inputCity').val();
					jQuery.ajax({
						url: "ajax_peek.php",
						type: "POST",
						data: {
							city_name: geodemo,
							offset:offset
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
				});
			</script>
		<?php endif;; ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#tourfunData").click(function(){

					var geodemo1 = jQuery('#inputCity').val(); 
					if(geodemo1.length > 0){
						var geodemo = jQuery('#target').val(); 
						var fullCityName = jQuery('#fullCityName').val();
					}else{
						var geodemo = jQuery('#geo-demo').val();
						var fullCityName = jQuery('#fullCityName').val();

					}

					jQuery.ajax({
						url: "ajax_tourfun_seeall_data.php",
						type: "POST",
						data: {
							formatted: geodemo
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{   
							jQuery('#tourdata').html(response); 
							jQuery("#loader").removeClass("loading");
						}
					});                  
				}) 	

			});

			jQuery(document).on('click','.load_more_yelps',function(){
				var limits = jQuery(this).attr('data-id');
				var limit = +limits+9;
				var key = "Museum";
				var formatted = "<?php echo $_SESSION['city_name'] ?>";
				jQuery.ajax({
					type: 'POST',
					url: 'ajax_thing_yelps.php',
					data: {limit: limit, key:key, formatted:formatted},
					beforeSend: function()
					{
						jQuery("#loader").addClass("loading");
					},
					success: function(data) {
						jQuery('.oneArticle').html(data);
						jQuery("#loader").removeClass("loading");
					}
				});
			});     
			jQuery(document).on('click','.load_more_search',function(){
				var limits = jQuery(this).attr('data-id');
				var limit = +limits+9;
				var key = jQuery('#search-yelp-horizontal').val();
				var formatted = "<?php echo $_SESSION['city_name'] ?>";
				jQuery.ajax({
					type: 'POST',
					url: 'ajax_thing_yelps.php',
					data: {limit: limit, key:key, formatted:formatted},
					beforeSend: function()
					{
						jQuery("#loader").addClass("loading");
					},
					success: function(data) {
						jQuery('.oneArticle').html(data);
						jQuery("#loader").removeClass("loading");
					}
				});
			}); 
			jQuery(function(){
				jQuery(document.body).on('click', '.yelpuser-review', function(){	
					var tour_id = jQuery(this).attr('data-id');

					jQuery.ajax({
						type: 'POST',
						url: 'ajax_tour_review_data.php',
						data: {tourid: tour_id},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function(data) {
							jQuery('.modal-tour-review').html(data);
							jQuery("#loader").removeClass("loading");
						}
					});
				});
			});	
			jQuery(document).ready(function(){
				jQuery(".dropdown-toggle").dropdown();
			});
			jQuery(document).ready(function() {
				jQuery('.owl-carousel').owlCarousel({
					loop: true,
					margin: 10,
					autoplay:false,
					responsiveClass: true,
					responsive: {
						0: {
							items: 1,
							nav: true
						},
						600: {
							items: 2,
							nav: false
						},
						1000: {
							items: 4,
							nav: true,
							loop: false,
							margin: 20
						}
					}
				})

			}) ;

		</script>
		<?php if(isset($_GET['tours']) && $_GET['tours'] == 'sightseeing'){?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#loader").addClass("loading");
					jQuery('.oneArticle').css('display','none');
					jQuery('.side_side_bar').css('display','none');
					jQuery('.discounts_inner').css('display','block');
					jQuery('.top_title').html('Sightseeing');
					jQuery('html, body').animate({
						scrollTop: jQuery(".discounts_inner").offset().top
					}, 2000);
					jQuery("#loader").removeClass("loading");
				})
			</script>

		<?php } ?>
		<script>

			$(document).on('click','.national_pas',function(){
				$.ajax({
					url: "ajax_national_parks.php",
					type: "POST",
					data: {
						key :'National parks'
					},
					beforeSend: function()
					{
						$("#modal_loader").addClass("loading");
					},
					success: function (response) 
					{
						$('.national_parsd').html(response);
						$("#modal_loader").removeClass("loading");
					}
				}); 
			});
			$(document).on('click','.groupon_discount',function(){
				$.ajax({
					url: "ajax_groupon_discount.php",
					type: "POST",
					data: {
						key :'fun-and-leisure-activities'
					},
					beforeSend: function()
					{
						$("#modal_loader").addClass("loading");
					},
					success: function (response) 
					{
						$('.groupon_discount_parsd').html(response);
						$("#modal_loader").removeClass("loading");

						setTimeout(function(){
							for (var i = 1; i <= 80; i++) {
					//alert(i);
					 // console.log('.section_'+i+' .cui-image');
					 var pics_str = jQuery('.section1_'+i+' .cui-image').attr('data-srcset');
                  // var pics_arr = '';
                  console.log(pics_str);
                  if( pics_str != undefined){
                  	
                  	var pics_arr = pics_str.split(',');
                  	pics_str = '';
                  	jQuery.each(pics_arr, function(index, el) {
                  		imgPath = this.trim();
                  		imgPath = imgPath.substring(0, imgPath.indexOf('.jpg')+4);
                   // alert(imgPath);
                   jQuery('.section1_'+i+' .cui-svg-placeholder').css({"background-image":"url("+imgPath+")"});
               });
                  }
              }
          },1000);


					}
				}); 
			})
		</script>
		<div class='modal fade' id='myModal-review' role='dialog'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>

						<h4 class='modal-title'></h4>
					</div>
					<div class='tuorfun'>
						<ul class='modal-tour-review'>

						</ul>    
					</div>
					<div class='modal-footer'>
						<button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
					</div>
				</div>

			</div>
		</div>
		<section class="Hotel-sanf sec_pad new-for">
	<div class="container">
		<div class="heading-content">
			<div class="row">
				<div class="col-lg-12">
					<h2><span class="top_title">Top Attractions</span> in <?php echo $_SESSION['city_name']; ?> </h4>
				</div>
				<!-- <div class="col-lg-12 text-lg-center">
					<a data-toggle="modal" data-target="#more_audio_tourss" target="_blank" class="btn btn-outline-dark px-4">View all</a>
				</div> -->
			</div>
		</div>
		<div class="oneArticle"></div>
		<div class="discounts_inner">
			<div class="row">
				<?php
				$guide_city = "SELECT * FROM  get_guide_tours WHERE city_name LIKE '%".$_SESSION['city_name']."%' LIMIT 1";
				$guide_city_result = $mysqli->query($guide_city);
				$guide_city_count = $guide_city_result->num_rows;
				if($guide_city_count > 0){
					foreach ($guide_city_result as $key => $value) {
						echo $value['content'];
					}
				}else{
					$string =  substr($_SESSION['city_name'], 0, 3);
					$string =  strtoupper(  $string ); 
					if( $_SESSION['city_name'] == "San Sebastián"){
						$string = "EAS";
					}
					if( $_SESSION['city_name'] == "İstanbul"){
						$string = "IST";
					}
					echo  $fiveStar = '<script src="//c108.travelpayouts.com/content?promo_id=4039&shmarker=iddqd&trs=26480&place=&items=25&locale=en-US&powered_by=true&iata='.$string.'" charset="utf-8"></script>';
				}?>
			</div>
		</div>
	</div>
</section>
		<?php include('blog-resources-new.php');?>
		<?php include('footer-newfile.php'); ?>
		
		
		<script>
	
	$('#ProductSlide').owlCarousel({
		loop:true,
		margin:20,
		nav:true,
		responsiveClass:true,
		dots:false,
		responsive:{
			0:{
				items:1,
			},
			768:{
				items:2,
			},
			1100:{
				items:4,
				loop:false
			}
		}
	})
	$('#ProductSlide-audio2').owlCarousel({
		loop:true,
		margin:20,
		nav:true,
		responsiveClass:true,
		dots:false,
		responsive:{
			0:{
				items:1,
			},
			768:{
				items:2,
			},
			1100:{
				items:3,
				loop:true
			}
		}
	})
	</script>
	<script>
	  AOS.init();
	  
	  AOS.init({disable: 'mobile'});
	</script>
	<style>
		@media(max-width:767px){
		.new-for .heading-content h2:before {height: 4px;top: 12px;}
		.new-for .heading-content h2 {padding: 0 0 0 30px;font-size: 21px;}
		.testimonial-section .owl-nav { top: 35%;}
	}
	</style>