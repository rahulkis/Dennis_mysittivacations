<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Cork And Barrel"; 
session_start();
$_SESSION['city_name'] = "Chicago";
if(isset($_SESSION['city_name'])){

	include('header-newfile.php');	// not login
}else{
	header('location:https://mysittivacations.com/');
}
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
<?php
if (isset($_SESSION['city_name']) || isset($_SESSION['formatteds'])) {
	$session_city_name = empty($_SESSION['city_name']) ? $_SESSION['formatteds'] : $_SESSION['city_name'];
	$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$session_city_name."'");
	$get_city_name = mysql_fetch_assoc($city_name_query);
	$dropdown_city = $get_city_name['city_name'];
	$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
	$get_state_name = mysql_fetch_assoc($state_name_query);
	$_SESSION['country'] = $get_state_name['country_id'];
	$state_name = $get_state_name['name'];
	$state_code = $get_state_name['code'];

	$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
	$get_co_name = mysql_fetch_assoc($co_name_query);
	$conry_nm = $get_co_name['name'];
}elseif(!empty($_GET['city'])){
	$dropdown_city = $_GET['city'];
	$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$_GET['city']."'");
	$get_city_name = mysql_fetch_assoc($city_name_query);
	$dropdown_city = $get_city_name['city_name'];
	$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
	$get_state_name = mysql_fetch_assoc($state_name_query);
	$_SESSION['country'] = $get_state_name['country_id'];
	$state_name = $get_state_name['name'];
	$state_code = $get_state_name['code'];

	$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
	$get_co_name = mysql_fetch_assoc($co_name_query);
	$conry_nm = $get_co_name['name'];
}else{
	$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
	$get_city_name = mysql_fetch_assoc($city_name_query);
	$dropdown_city = $get_city_name['city_name'];
	$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
	$get_state_name = mysql_fetch_assoc($state_name_query);
	$_SESSION['country'] = $get_state_name['country_id'];
	$state_name = $get_state_name['name'];
	$state_code = $get_state_name['code'];

	$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
	$get_co_name = mysql_fetch_assoc($co_name_query);
	$conry_nm = $get_co_name['name'];

}
if(isset($_SESSION['city_name'])){
	$getAds = "SELECT * FROM specific_city_sidebar WHERE city like '%".$_SESSION['city_name']."%' limit 1";
	$result = $mysqli->query($getAds);
	$count = $result->num_rows;
	if($count > 0){
		foreach ($result as $key => $value) {
			$city_data =  $value['city_id_code'];
		}
	}
} ?>
<style>
	.blissey-widget .blissey-info {
		order: 2;
		padding: 0px !important; 
		background: #fff !important;
	}
    .mobileView{
       display:none; 
    }
    
     .accordion-item {
    background-color: #fff;
    border: 0px solid rgba(0,0,0,.125)! important;
}
.accordian_info button.accordion-button {
    background: #fff! important;
}
.accordian_info {
    background: #fff! important;
    padding: 30px;
    border-radius: 6px;
}
.hotel_name a {
    text-decoration: none;
    color: #000;
}
.resturant_specl {
    display: none;
}

.restro_btns,.restro_deals,.loc_details,.hotel_name {
    border: 0px solid #ccc! important;
}

.feature-section.car-feature{
    padding-top: 0;
}  
.top-heading-section h1 {
    font-weight: 600;
}
.testimonial-section.products a {
    text-decoration: none;
}
.testimonial-section.products button {
    border-radius: 50% !important;
    margin: 10px !important;
}
.blog-block ul li:last-child {
    width: 65%;
}
.blog-block li.discount-block.first {
    width: 35%;
    margin: 0;
}
.filter_head.sort-display-sec .heading h4:after {
    content: none;
}
.filter_head.sort-display-sec .heading h4{ 
    padding-left: 0;
}
.filter_head.sort-display-sec {
    border: 1px solid #fd846b;
}
.rest-deals .accordian_info .accordion-body {
    margin: 30px 0 20px;
    background: #ffe6e1;
    padding: 20px !important;
    border-radius: 15px;
    text-align: center;
}
.rest-deals .blissey-widget .blissey-widget-tabs ul.blissey-widget-tabs-list {
    margin-top: 0 !important;
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-tabs-list__item--checked {
    background: #5955b333 !important;
    padding: 15px 20px 15px 15px !important;
    display: inline-block !important;
    border: 1px solid #5955b3 !important;
    border-radius: 6px;
    color: #000 !important;
    font-weight: 600 !important;
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-tabs-list__item--checked {
    background: #276ab5 !important;
    padding: 12px 20px 12px 15px !important;
    border: 1px solid #276ab5;
    border-radius: 5px;
    color: #fff !important;
    font-weight: 600 !important;
}
.filter_head.sort-display-sec .custom-select-box select {
    min-width: 140px;
}
.testimonial-section.products .head-yelp h3 {
    font-weight: 600;
}
.rest-deals .blissey-widget .blissey-widget-tabs {
    background: transparent !important;
}
.rest-deals .blissey-widget{
     border: none !important;   
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-body-hotels-compact-list__item {
    border-radius: 10px;
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-footer {
    background-color: #ffe6e1!important;
    border-top: none !important;
}
.rest-deals .accordian_info .blissey-widget .blissey-info-price-wrapper-button a {
    background: #fe6e00 !important;
    color: #fff !important;
    border-radius: 50px !important;
}
.blog-section .discount-block .blog-details h3 {
    display: block;
    display: -webkit-box;
    margin: 0 auto;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 50px;
}
.blog-block li.discount-block.first img {
    height: 780px;
    object-fit: cover;
}
.rest-deals .heading-content h4 {
    font-weight: 600;
}  
  @media (max-width: 767px){
.owl-dots {
    display: none;
}
.container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
    padding-right: unset;
    padding-left: unset;
    }
}

</style>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<div class="v2_content_inner2">
	<div id="loader"></div>
	<span class='update-zero' style="display: none;">10</span>	
</div>
<!--<section class="inner_page_hero sec_pad beverages_sec_bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="hero_section_content">
					<h2 class="mb-5">Cork And Barrel in  <?php //echo $_SESSION['city_name']; ?></h2>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="content-bannersss">
					<input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

					<input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php //echo $_SESSION['full_city_name'];?>" required="">

					<a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><img src="/css/optimize/images/search.png" alt=""></a>
				</div>
			</div>
		</div>
	</div>
</section>-->
<div data-aos="zoom-in-right" class="banner-section hotel-hero comedy-sec" style="background-image:url(images/brewery-hero.png)"> 
			<div class="container">
				<div class="mobile-hero">
					<img src="images/brewery-hero.png">
				</div>
				<div class="carousel-caption-top">
				   <h1>Cork And Barrel in  <?php echo $_SESSION['city_name']; ?></h1>
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
<!-- product listing section -->
<?php function yelp_api_call($limit,$city,$keyword){
	$prepAddr =empty($city)?'Chicago': str_replace(' ','+',$city);
	$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	$ch = curl_init();   
	$key = str_replace(' ','+',$keyword);
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
	$get_deals = json_decode($result);

	$getyelpTourData = $get_deals->businesses;
	return $getyelpTourData;
}?>
<section class="sec_pad filter-sec">
	<div class="container">
		<div class="row">
			
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
						$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."&locale=en_US";
					else:

						if(!empty($key)):
							$urlgo = "https://www.groupon.com/occasion/deals-json?filterQuery=(subcategory2:".$key.")&divisionLoc=".$latitude.",".$longitude."&pageType=holiday&includeHtml=true";
						else:

							$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&limit=".$limit."&locale=en_US";
						endif;
					endif;
					$result_get = file_get_contents($urlgo);
					$get_all_data = json_decode($result_get, true);
					$get_deals = $get_all_data['deals'];
					return $get_deals;
				}?>
			
	<div class="rind-the-right-section comedy-sec">
		<div class="container n-contain ">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
					<div class="sidebar-listing">
						<div class="adver-comedy">
							<img src="images/ad1.png">
							<img src="images/ad3.png">
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
					<div class="white-box-area inner rest-deals">
						<div class="row">
							<div class="col-md-12 col-12">
								<div class="heading-content">
									<div class="content-sec">
										<h4>Groupon Performing Brewery</h4>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-12">
								<section class="client-sec comedy">
									<div class="testimonial-section products">
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio">
									   
									   <?php $get_deals = groupon_api_call('20','','v-bars');
							if(!empty($get_deals)){ ?>
							<?php  
								$i= 0;
								foreach ($get_deals as $homeData):
								if($i%2==0){
									$dataaos="zoom-in-right";
								}else{
									$dataaos="zoom-in-left";
								}
							?>
							<div data-aos="<?php echo $dataaos;?>" class="testimonial-block product section_<?php echo $i; ?>">
								<?php   $i++; 
								echo $homeData['cardHtml']; ?>
							</div>
							<?php 
								endforeach;
							} ?>
											
									   </div>
									</div>
									
									<div class="testimonial-section products">
										<div class="head-yelp">
											<h3> Deals on <img src="images/yelpnew.png"></h3>
										</div>
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio2">
									   
									   
									   <?php $getyelpTourData = yelp_api_call(20,$_SESSION['city_name'],'Brewery'); 
									   $loop=0;
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
											if($loop%2==0){
												$dataaos='zoom-in-right';
											}else{
												$dataaos='zoom-in-left';
											}
											?>
											<div data-aos="<?php echo  $dataaos;?>" class="testimonial-block product">
											<a href="<?php echo $tour_url; ?>" target="_blank">
											<div class="discount-block">
											
												<?php if(!empty($tour_image)) : ?>
													<img src="<?php echo $tour_image; ?>" class="img-fluid w-100" alt="<?php echo $tour_name; ?>">
												<?php else : ?>
													<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg" alt="no-image">
												<?php endif; ?>
													<div class="discount-content">
														<h3><?php echo $tour_name; ?></h3>
														<div class="stars">
															<ul>
															<?php for($x=1;$x<=$tour_rating;$x++): ?>
															<li><i class="fa fa-star" aria-hidden="true"></i></li>
															<?php endfor; ?>
															<?php if (strpos($tour_rating,".")) : ?>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<?php 
																$x++;
															endif; ?>
																
															</ul>
															<p style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
															(<?php echo $tour_review_count ; ?> Ratings)
															</p>
														</div>
														<p><?php $for_counter = 0 ;
														$total = count((array)$homeData->categories)-1; 
														foreach ($homeData->categories as $category){
															echo $category->title;
															if($for_counter != $total){
																echo ", ";
															}
															$for_counter++; 
														} ?></p>
													</div>
													<div class="comedy-detail">
														<ul>
															<li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $tour_location_address1.' '.$tour_location_address2.' '.$tour_city.' '.$tour_state.' '.$tour_zipCode ; ?></li>
															<?php if ( $tour_phone != ''){?>
															<li><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $tour_phone ; ?></li>
															<?php } ?>
														</ul>
													</div>
													
												</div>
												</a>
											</div>
										<?php 
										$loop++;
										endforeach; ?>
									   </div>
									</div>
									
									<div class="sort-display-sec">
										<div class="sort-content">
											<p>Popular shows in <?php echo $_SESSION['city_name'];?>. Displaying 1–20</p>
										</div>
										
									</div>
									
									<div class="comedy-bottom-sec oneArticle ticketMaster_sec">
									<?php if(isset($_POST['limit'])){
										$limit = $_POST['limit'];
									}else{
										$limit = 20;
									}
									$getyelpTourData = yelp_api_call($limit,$_SESSION['city_name'],'Winery'); 
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
														<img src= ".$image." class='img-fluid'>
													</div>
													<div class='discount-content'>
														<h3> ".$eventsName."</h3> <span><i class='fa fa-map-marker' aria-hidden='true'></i> ".$venue_name."</span>
													</div>
													<div class='comedy-add-details'>
														<p><i class='fa fa-map-marker' aria-hidden='true'></i> ".$address1."  ".$address2.", ".$city.", ".$country."</p>
													</div>
													<div class='discount-action hotels'>
														<a class='hotel-book' href=".$eventUrl." target='_blank'>See More </a>
													</div>
												</div>
											</a>
										</div>";
										}

									echo $html;?>
									
										
									<div class="view-tag" data-aos="zoom-in-down">
										<a href="javascript:;"  class="load_more_search" data-key="Winery" data-id="20">View All</a>
									</div>
									
									
									
									
									 
									
									
									
									
									</div>
								</section>
							</div>
							<div class="powerdby aos-init aos-animate" data-aos="zoom-in-down">
								<a href="#">Hotel rating provided by TrustYou™ <img src="images/pwrd.png"></a>
								<p>Powered by <b>Travelpayouts</b></p>
							</div>
							<div class="col-lg-3 mobileView" style="display: none;">
								<div class="add_img">
									<img src="./img/ss/addimg.png" class="img-fluid w-100">
								</div>
								<div class="add_img">
									<img src="./img/ss/addimg2.png" class="img-fluid w-100">
								</div>
							</div>
						
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4 rest-deals">
                                <div class="accordian_info">
                                <div class="accordion comedy" id="accordionFlushExample">
									  <div class="accordion-item">
										<h2 class="accordion-header" id="headingOne">
										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
											What are the hotels close to the center of <?php echo $_SESSION['city_name'];?>
										  </button>
										</h2>
										
										<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionFlushExample">
										  <div class="accordion-body">
											<script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=center&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=search.hotellook.com&locale=en&limit=5&nobooking=" charset="utf-8"></script>
										  </div>
										</div>
										
									  </div>
									  <div class="accordion-item">
										<h2 class="accordion-header" id="headingTwo">
										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											What are the best pet-friendly hotels in <?php echo $_SESSION['city_name'];?>
										  </button>
										</h2>
										<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
										  <div class="accordion-body">
											<script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=pets&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=search.hotellook.com&locale=en&limit=5&nobooking=" charset="utf-8"></script>
										  </div>
										</div>
									  </div>
									  <div class="accordion-item">
										<h2 class="accordion-header" id="headingThree">
										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
											What are the best luxury hotels in <?php echo $_SESSION['city_name'];?>
										  </button>
										</h2>
										<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
										  <div class="accordion-body">
											<script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=luxury&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=search.hotellook.com&locale=en&limit=5&nobooking=" charset="utf-8"></script>
										  </div>
										</div>
									  </div>
									  <div class="accordion-item">
										<h2 class="accordion-header" id="headingfour">
										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
											What are the top hotels in <?php echo $_SESSION['city_name'];?>
										  </button>
										</h2>
										<div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
										  <div class="accordion-body">
											<script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=luxury&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=search.hotellook.com&locale=en&limit=5&nobooking=" charset="utf-8"></script>
										  </div>
										</div>
									  </div>
									  <div class="accordion-item">
										<h2 class="accordion-header" id="headingfive">
										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
											Which hotels have the best ratings in <?php echo $_SESSION['city_name'];?>
										  </button>
										</h2>
										<div id="collapsefive" class="accordion-collapse collapse" aria-labelledby="headingfive" data-bs-parent="#accordionExample">
										  <div class="accordion-body">
											<script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=5stars&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=search.hotellook.com&locale=en&limit=5&nobooking=" charset="utf-8"></script>
										  </div>
										</div>
									  </div>
									   
								</div>
                                </div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
			
			</div>
		</div>
	</section>
	<!-- product listing section -->
	<!-- Us popular city -->
	<div class='modal fade' id='popularcitiesModal' role='dialog'>

		<div class='modal-dialog '>
			<div class='modal-content'>
				<div class='modal-header'>
					<span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>
					<button type='button' class='close' data-dismiss='modal'>&times;</button>
					<div id="modal_loader"></div>
				</div>
				<div class="cities_modal">

				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				</div>
			</div>
		</div>
	</div>
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
	<!-- Us popular city End -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="js/autocomplete.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			$(document).on('click','.next-refine',function(e){

				var geodemo = $('#geo-demo').val();	
				e.preventDefault();

				fieldName = $(this).attr('field');

				var currentVal = parseInt($('.update-zero').html());

				if (currentVal == 30) {
					$('.update-zero').html(currentVal);
				}
				else if (!isNaN(currentVal) ) {

					$('.update-zero').html(currentVal + 10);

				} 
				else {

					$('.update-zero').html(0);
				}

			});

			$(document).on('click','.prev-refine',function(e){

				var geodemo = $('#geo-demo').val();	

				e.preventDefault();

				fieldName = $(this).attr('field');

				var currentVal = parseInt($('.update-zero').html());


				if (!isNaN(currentVal) && currentVal > 0) {

					$('.update-zero').html(currentVal - 10);

				} else {

					$('.update-zero').html(0);
				}

			});
		});


	</script>
	<script type="text/javascript">

		$(document).ready(function(){

			$(document.body).on('click','.next-refine',function(e){

				var geodemo = $('#geo-demo').val();
				var key = $(".update-zero").text();
				var value = 'Winery';

				$.ajax({
					url: "ajax_refine_ticketmaster_next_data_winery.php",
					type: "POST",
					data: {
						formatted: geodemo, page : key, dropValue : value
					},
					beforeSend: function()
					{
						$("#loader").addClass("loading");
					},
					success: function (response) 
					{
						$('.family-ticketMaster').html(response);
						jQuery('html, body').animate({
							scrollTop: jQuery(".family-ticketMaster").offset().top
						}, 1000);
						$("#loader").removeClass("loading");

					}
				});	

			});

			$(document.body).on('click','.prev-refine',function(e){

				var geodemo = $('#geo-demo').val();
				var key = $(".update-zero").text();
				var value = 'Winery';

				$.ajax({
					url: "ajax_refine_ticketmaster_next_data_winery.php",
					type: "POST",
					data: {
						formatted: geodemo, page : key, dropValue : value
					},
					beforeSend: function()
					{
						$("#loader").addClass("loading");
					},
					success: function (response) 
					{
						$('.family-ticketMaster').html(response);
						jQuery('html, body').animate({
							scrollTop: jQuery(".family-ticketMaster").offset().top
						}, 1000);
						$("#loader").removeClass("loading");

					}
				});	

			});
		});

	</script>
	<script>
		(function($){
			var jQuery_2_1_1 = $.noConflict(true);
			jQuery_2_1_1('#suggestion_search').autocomplete({
				serviceUrl: 'concert-search-data.php',
				groupBy: 'category',
				minChars:'2',
				formatResult: function(suggestion) {
					var html = '<a href="'+suggestion.data.url+'" target="_blank"><img src="'+suggestion.data.img+'">';
					html += '<div class="text-format"><h3>'+suggestion.value+'</h3><span>'+suggestion.data.class+'</span><span>'+suggestion.data.date+'</span></div></a>';
					return html;
				},
				onSelect: function (suggestion) {
			// alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
		}
	});
		})(jQuery);
	</script>
	<script type="text/javascript">
		$(document).on("click", ".open-GrouponDialog", function () {
			var el = $(this);
			var modal_info  = el.data('info');
			var modal_title = el.data('title');
			var modal_limit = el.data('limit');
			var modal_city  = el.data('city');
			var modal_key   = el.data('key');
			var modal_url   = el.data('url');
			$.ajax({
				url: modal_url,
				type: "POST",
				data: {
					modal_info  : modal_info,
					modal_title : modal_title,
					modal_limit : modal_limit,
					modal_city  : modal_city,
					modal_key   : modal_key
				},
				beforeSend: function()
				{
					$("#modal_loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.cities_modal').html(response);
					$("#modal_loader").removeClass("loading");
				}
			});    
		});
		$(document.body).on('click', '.yelpuser-review', function(){  
			var tour_id = $(this).attr('data-id');
			$.ajax({
				type: 'POST',
				url: 'ajax_tour_review_data.php',
				data: {tourid: tour_id},
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function(data) {
					$('.modal-tour-review').html(data);
					$("#loader").removeClass("loading");
				}
			});
		});
	</script>
	<script type="text/javascript">
		var app = new Vue({
			el: '#specificGenre',
			data:{
				genreData:'',
				checkSessionServer: '',
				formatted: '<?php echo $_SESSION['city_name']; ?>',
				tittle: 'Wineries',
				key: 'wineries',
				ajaxRequest: false
			},

			mounted: function(){
				this.getGenreData();
			},

			methods:{
				getGenreData: function(){
					var vm = this;
					vm.ajaxRequest = true;
					vm.checkSessionServer =  axios.post('ajax_specific_genre.php', {formatted: vm.formatted,title: vm.tittle,key:vm.key});
					vm.checkSessionServer.then(function(response){
						app.genreData = response.data;
						vm.ajaxRequest = false;
					});
				}
			}
		})

		var pageCounter = 0;
		if ($('#target').val().length === 0) {
			var geodemo = $('#geo-demo').val();
		}else{
			var geodemo = $('#target').val();
		}
		$(window).load(function(){
			$.ajax({
				url: "ajax_yelp_deals.php",
				type: "POST",
				data: {
					formatted: geodemo,
					key: 'wineries'
				},
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.comedy-events-deals').html(response);
					$("#loader").removeClass("loading");
				}
			});

			$.ajax({
				url: "ajax_ticketmaster_deals.php",
				type: "POST",
				data: {
					formatted: geodemo,
					key      : 'Wineries'
				},
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.family-ticketMaster').html(response);
					$("#loader").removeClass("loading");
				}
			});
		});
		$(document.body).on('click','.next',function(e){
			e.preventDefault();
			pageCounter++;
			$.ajax({
				url: "ajax_ticketmaster_pagination.php",
				type: "POST",
				data: {
					formatted: geodemo,
					page     : pageCounter,
					key      : 'Wineries'
				},
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.family-ticketMaster').html(response);
					$("#loader").removeClass("loading");
				}
			});

		});
		$(document.body).on('click','.prev',function(e){
			e.preventDefault();
			pageCounter--;
			$.ajax({
				url: "ajax_ticketmaster_pagination.php",
				type: "POST",
				data: {
					formatted: geodemo,
					page     : pageCounter,
					key      : 'Wineries'
				},
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.family-ticketMaster').html(response);
					$("#loader").removeClass("loading");
				}
			});

		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {

			$("#dpd_team").datepicker({
				minDate: 0,
				dateFormat: "mm/dd/yy",
				onSelect: function (date) {
					var date2 = $('#dpd_team').datepicker('getDate');
					date2.setDate(date2.getDate() +1);
					$('#dpdtm').datepicker('setDate', date2);
            //sets minDate to dateofbirth date + 1
            $('#dpdtm').datepicker('option', 'minDate', date2);
        }
    });
			$('#dpdtm').datepicker({
				dateFormat: "mm/dd/yy",
				onClose: function () {
					var dt1 = $('#dpd_team').datepicker('getDate');
					var dt2 = $('#dpdtm').datepicker('getDate');
					if (dt2 <= dt1) {
						var minDate = $('#dpdtm').datepicker('option', 'minDate');
						$('#dpdtm').datepicker('setDate', minDate);
					}
				}
			});


		});
	</script>	

	<script type="text/javascript">
		$(document).ready(function(){
			$("#target").on('blur',function(){
				setTimeout(function(){ var geodemo = $('#target').val(); 
					if(geodemo.length > 0){
						$.ajax({
							url: "city_search_ajax.php",
							type: "POST",
							data: {
								formatteds: geodemo
							},
							beforeSend: function()
							{
								$("#loader").addClass("loading");
							},
							success: function (response) 
							{   

								$("#loader").removeClass("loading");
							}
						});
					} 
				},1000);                   
			})

		});	
	</script>
	<script src="js/new/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript">
		$(".form-select").change(function(){
			var value = $(this).val();
			if(value == 1){

				$('.music_shows').sort(function(a, b) {
					if (a.textContent < b.textContent) {
						return -1;
					} else {
						return 1;
					}
				}).appendTo('.alpha_filter');

			}else{
				$('.music_shows').sort(function(a, b) {
					if (a.textContent < b.textContent) {
						return 1;
					} else {
						return -1;
					}
				}).appendTo('.alpha_filter');
			}

		}); 
		$(".selectRangeteam").click(function(){

			var textBox_city = $('#refine-result').val();
			var date1 = $('#dpd_team').val();
			var date2 = $('#dpdtm').val();
			var drop_down_keyword = $("input[name='dropDownId']:checked").val();
			//alert(drop_down_keyword);

			if(textBox_city == ''){
				alert('Please Enter City Name');
				return false;
			}
			if(drop_down_keyword == '' || drop_down_keyword == undefined){
				alert('Please Select Category');
				return false;
			}else{

				$.ajax({
					url: "ajax_refine_ticketmaster_data.php",
					type: "POST",
					data: {
						formatted: textBox_city, srartdate: date1, enddate : date2, doropdown : drop_down_keyword
					},
					beforeSend: function()
					{
						$("#loader").addClass("loading");
					},
					success: function (response) 
					{
						$('.family-ticketMaster').html(response);
						jQuery('html, body').animate({
							scrollTop: jQuery(".family-ticketMaster").offset().top
						}, 1000);
						$("#loader").removeClass("loading");
					}
				});	
			}

		});  	
		$(document).on('click','.load_more_search',function(){
			var limits = $(this).attr('data-id');
			var limit = +limits+20;
			var key = $('#search-yelp-horizontal').val();
			if(key == '' || key == undefined){
				var key = $(this).attr('data-key');
			}
			var formatted = "<?php echo $_SESSION['city_name'] ?>";
			$.ajax({
				type: 'POST',
				url: 'ajax_refine_ticketmaster_next_data_winery.php',
				data: {limit: limit, key:key, formatted:formatted},
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function(data) {
					if(data !=''){
						$('.oneArticle').html(data);
					}else{
						$('.load_more_search').css('display','none');
					}
					$("#loader").removeClass("loading");
					

				}
			});
		});
		$(document).on('click','.activity',function(){
			var textBox_city = $('#refine-result').val();
			var date1 = $('#dpd_team').val();
			var date2 = $('#dpdtm').val();
			var drop_down_keyword = $("input[name='dropDownId']:checked").val();
			$.ajax({
				url: "ajax_refine_ticketmaster_data.php",
				type: "POST",
				data: {
					formatted: textBox_city, srartdate: date1, enddate : date2, doropdown : drop_down_keyword
				},
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.family-ticketMaster').html(response);
					jQuery('html, body').animate({
						scrollTop: jQuery(".family-ticketMaster").offset().top
					}, 1000);
					$("#loader").removeClass("loading");
				}
			});
		});
		var nowTemp = new Date();
		var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

		var checkin = $('#dpd_team').datepicker({

			beforeShowDay: function(date) {
				return date.valueOf() >= now.valueOf();
			},
			autoclose: true

		}).on('changeDate', function(ev) {
			if (ev.date.valueOf() > checkout.datepicker("getDate").valueOf() || !checkout.datepicker("getDate").valueOf()) {

				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate() + 1);
				checkout.datepicker("update", newDate);

			}
			$('#dpdtm')[0].focus();
		});


		var checkout = $('#dpdtm').datepicker({
			beforeShowDay: function(date) {
				if (!checkin.datepicker("getDate").valueOf()) {
					return date.valueOf() >= new Date().valueOf();
				} else {
					return date.valueOf() > checkin.datepicker("getDate").valueOf();
				}
			},
			autoclose: true

		}).on('changeDate', function(ev) {});
		$(document.body).on('click','.next',function(e){
			e.preventDefault();
			pageCounter++;
			$.ajax({
				url: "ajax_ticketmaster_pagination.php",
				type: "POST",
				data: {
					formatted: geodemo,
					page     : pageCounter,
					key      : 'Arts+and+Theater'
				},
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.family-ticketMaster').html(response);
					jQuery('html, body').animate({
						scrollTop: jQuery(".family-ticketMaster").offset().top
					}, 1000);
					$("#loader").removeClass("loading");
				}
			});

		});
		$(document.body).on('click','.prev',function(e){
			e.preventDefault();
			pageCounter--;
			$.ajax({
				url: "ajax_ticketmaster_pagination.php",
				type: "POST",
				data: {
					formatted: geodemo,
					page     : pageCounter,
					key      : 'Arts+and+Theater'
				},
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.family-ticketMaster').html(response);
					$("#loader").removeClass("loading");
				}
			});

		});
		$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
} else {
	$box.prop("checked", false);
}
});
</script>
<script>
	AOS.init();
</script>
<script>
	jQuery(document).ready( function (){
		setTimeout(function(){
			for (var i = 1; i <= 20; i++) {
					//alert(i);
					 // console.log('.section_'+i+' .cui-image');
					 var pics_str = jQuery('.section_'+i+' .cui-image').attr('data-srcset');
                  // var pics_arr = '';
                  console.log(pics_str);
                  if( pics_str != undefined){
                  	
                  	var pics_arr = pics_str.split(',');
                  	pics_str = '';
                  	jQuery.each(pics_arr, function(index, el) {
                  		imgPath = this.trim();
                  		imgPath = imgPath.substring(0, imgPath.indexOf('.jpg')+4);
                   // alert(imgPath);
                   console.log('section_'+i+'qa');
                   jQuery('.section_'+i+' .cui-svg-placeholder').css({"background-image":"url("+imgPath+")"});
               });
                  }
              }
          },3000);
	});
</script>
<?php include('blog-resources-new.php');?>
<?php include('footer-newfile.php'); ?>