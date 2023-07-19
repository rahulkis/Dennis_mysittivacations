<?php
ob_start("ob_gzhandler");
session_start();

$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$titleofpage="MySittiVacations: Best Deals For Flight & Hotel Vacation Packages";
$meta_description = "Youre ready to book your trip.Planning a vacation is a tough job, but our website is here to help you. You can create an account and easily manage your travel dates, see if you can find the right price, or even customize your own travel package. We also have other helpful features, such as the ability to search for flights, hotels, and packages. You can even book an RV, a cruise ship, or a vacation home.
Finally, there's an advanced booking feature that will allow you to request a specific travel date. So get started today. You've spent months planning this trip, and the time has finally come. You're ready to book your flight, but you just can't seem to find the right price online! Luckily, you have plenty of resources at your fingertips and it won't take you more than a few hours to find the best flight there is. With a bit of dedication, you'll be on your way to your dream destination in no time.We know what you're looking for, and we're happy to help you plan your next trip.With our website, you can find out all the details you need to know about your upcoming trip. We have all the important information you need, and we want to help make planning as easy as possible. We know what you're looking for, and we're happy to help you plan your next trip. If you think you're ready to book your next trip, you've come to the right place.
We've got the deals you need to make your vacation more affordable and fun. From plane tickets to hotel deals, we have everything you need to make your travel arrangements. We know that traveling is more than just putting in the time and the miles; it's about savoring the memories. Whether you're traveling for work or for pleasure, all of your travel needs are our priority!";
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
if(isset($_GET['status'])){
   session_unset(); 
   session_destroy();
   unset($_COOKIE['city_name']);
   unset($_COOKIE['search_city']);
   setcookie('search_city', '', time() - 3600, '/'); // Empty value and old timestamp
  setcookie('city_name', '', time() - 3600, '/'); // Empty value and old timestamp
}
if(!empty($_COOKIE['city_name'])){
   $_SESSION['city_name']  = strtok($_COOKIE['city_name'], ',');
   $_SESSION['formatteds'] = strtok($_COOKIE['city_name'], ',');
}
?>
<link href="https://www.mysittivacations.com/css/homePage.css" rel="stylesheet">
<?php

   include("header-newfile.php");
if(isset($_SESSION['city_name'])){?>
    <script src="js/vue.js"></script>
    <script src="js/axios.min.js"></script>
<?php }
if(!$detect->isMobile()) {
    if(!isset($_COOKIE['mailchimp_form'])){?>
       <!-- <script defer src="js/convertflow.js"></script>  -->
   <?php } } 
   //include("landing-home.php"); 

   $resultpix =json_decode($response, true);?>
   <style>section.mewtwo-best_offers.mewtwo-best_offers--hidden.mewtwo-best_offers--transparent {
    display: none !important;
}
.mewtwo-widget--c98aeb1f90b513aff212c115d707c6ac .mewtwo-best_offers{display: none !important;}
.videocontrol{width: 100%}
.cities_modal h2{
    text-align:left !important;
    padding-left: 20px;
}
.discounts_inner img {
    max-width: 101%;
    height: auto;
}
section.inner_page_hero.sec_pad.city_bg {
    background-image: url(../../img/ss/city_bg_top_banner.png) !important;
    background-repeat: repeat-X !important;
    background-size: auto 100% !important;
    background-position: center bottom !important;
}
</style>
<div class='modal fade homepageModell' id='popularcitiesModal' tabindex="-1" data-focus-on="input:first"  role='dialog'>

    <div class='modal-dialog modal-lg modal-dialog-scrollable'>
        <div class='modal-content' style="overflow-y: scroll !important;">
            <div class='modal-header'>

              <div id="modal_loader"></div>
          </div>
          <div class="cities_modal adrenaline">

          </div>
          <div class='modal-footer'>
              <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
          </div>
      </div>
  </div>
</div>

<!--
<script charset="utf-8" type="text/javascript">
    if ($('#target').val().length === 0) {
        var geodem = $('#currentLocation').val();
        var geodemo = geodem;
    }else{
        var geodemo = $('#target').val();
    }
    var today = new Date();
    var dd = today.getDate();
                            var mm = today.getMonth()+1; //January is 0!
                            var yyyy = today.getFullYear();
                            if(dd<10) {
                                dd = '0'+dd
                            } 
                            if(mm<10) {
                                mm = '0'+mm
                            } 
                            today = yyyy + '-' + mm + '-' + dd;
                            console.log(today);
                            var tomorrow = new Date();
                            var t_dd   = tomorrow.getDate()+1;
                            var t_mm   = tomorrow.getMonth()+1; //January is 0!
                            var t_yyyy = tomorrow.getFullYear();
                            if(t_dd<10) {
                                t_dd = '0'+t_dd
                            } 
                            if(t_mm<10) {
                                t_mm = '0'+t_mm
                            } 
                            tomorrow = t_yyyy + '-' + t_mm + '-' + t_dd;
                            console.log(tomorrow);
                           // window.TP_FORM_SETTINGS = window.TP_FORM_SETTINGS || {};
                           window.TP_FORM_SETTINGS["c98aeb1f90b513aff212c115d707c6ac"] = {
                            "handle": "c98aeb1f90b513aff212c115d707c6ac",
                            "widget_name": "Hotels Search Form",
                            "border_radius": "2",
                            "additional_marker": null,
                            "width": null,
                            "show_logo": false,
                            "show_hotels": true,
                            "form_type": "hotel",
                            "locale": "us",
                            "currency": "usd",
                            "sizes": "default",
                            "search_target": "_self",
                            "active_tab": "avia",
                            "search_host": "jetradar.com/searches/new",
                                // "hotels_host": "hotels.mysitti.com/hotels",
                                "hotels_host": "https://MysittiVacations.com/hotels/redirection.php",
                                "hotel": {
                                    "name": ""
                                },
                                "hotel_alt": "",
                                "avia_alt": "",
                                "retargeting": true,
                                "depart_date": null,
                                "return_date": null,
                                "check_in_date": today,
                                "check_out_date": tomorrow,
                                "no_track": false,
                                "powered_by": false,
                                "id": 119878,
                                "marker": 130544,
                                "origin": {
                                    "name": ""
                                },
                                "destination": {
                                    "name": ""
                                },
                                "color_scheme": {
                                    "name": "custom",
                                    "icons": "icons_orange",
                                    "background": "#feba31",
                                    "color": "#000",
                                    "border_color": "#feba31",
                                    "button": "#65c109",
                                    "button_text_color": "#fff",
                                    "input_border": "#feba31"
                                },
                                "hotels_type": "hotellook_host",
                                "best_offer": {
                                    "locale": "us",
                                    "currency": "usd",
                                    "marker": 130544,
                                    "search_host": "jetradar.com/searches/new",
                                    "offers_switch": false,
                                    "api_url": "//minprices-jetradar.aviasales.ru/minimal_prices/offers.json",
                                    "routes": []
                                },
                                "hotel_logo_host": null,
                                "search_logo_host": "jetradar.com",
                                "hotel_marker_format": null,
                                "hotelscombined_marker": null,
                                "responsive": true,
                                "height": 424
                            };
                        </script>
                    -->
                    <?php if(isset($_SESSION['city_name'])){ 
                        if($_SESSION['city_name']=="Mýkonos"){
                            $_SESSION['city_name'] = 'Mykonos';
                        }if($_SESSION['city_name']=="Gdańsk"){
                            $_SESSION['city_name'] = 'Gdansk';
                        }if($_SESSION['city_name']=="Düsseldorf"){
                            $_SESSION['city_name'] = 'Dusseldorf';
                        }
                        $mysqli->query("set character_set_results='utf8'");
                        $wikiData = "SELECT * FROM  wikipedia_content WHERE city LIKE '%".strtok($_SESSION['city_name'], ',')."%' LIMIT 1";
                        $result = $mysqli->query($wikiData);
                        $count = $result->num_rows;
                            //if($count > 0){ ?>
							<div data-aos="zoom-in-right" class="banner-section hotel-hero city-hero" style="background-image:url(images/specific-back.png)"> 
								<div class="container">
									<div class="mobile-hero">
										<img src="images/specific-back.png">
									</div>
									<div class="carousel-caption-top">
									   <h1>Explore <?php echo $_SESSION['city_name']; ?></h1>
										<p><?php
                                                foreach ($result as $key => $value) {
                                                  echo substr($value['text'],0,150)."...";

                                              }?></p>
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
	   
                              
                      <?php 
               //}
                  } else{
                    ?>
					<div data-aos="zoom-in-right" class="banner-section" style="background-image:url(images/my-banner.png)"> 
					   <div class="container">
							<div class="mobile-hero">
								<img src="images/mobile-hero.png">
							</div>
						   <div class="carousel-caption-top">
							   <h1>Get ready for your next vacation by checking out our website first.</h1>
								<p>Your life is busy, and there isn't enough time to organize your travel dates. That's why we're here: we have all the information you need to plan your next vacation. Check out our website; it's packed full of helpful information to help you find the best hotels, flights, tours, and more, making your planning easy.</p>
						   </div>
						   <div class="view-all-sec">
								<div class="view-tag" data-aos="zoom-in-down">
									<a href="#">Search</a>
								</div>
						   </div>
						  
                    <!--<section class="hero_section">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-7" data-aos="fade-right" data-aos-duration="1000">
                                    <div class="hero_section_content home_page">
                                        <h5>Get ready for your next vacation by checking out our website first.</h5>
                                        <p> Your life is busy, and there isn't enough time to organize your travel dates. That's why we're here: we have all the information you need to plan your next vacation. Check out our website; it's packed full of helpful information to help you find the best hotels, flights, tours, and more, making your planning easy. </p>
                                    </div>
                                </div>
                                <div class="col-lg-5" data-aos="fade-left" data-aos-duration="1000">
                                    <div class="hero_section_img">
                                        <img src="img/hero_img.png" class="img-fluid" loading="lazy">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>-->
                <?php } ?>
                <!--end of hero section-->

               
				 <div class="free-trail-form home_dev_searchform">
							   <div class="container">
									<div class="row">
										<div class="col-md-12 col-12">
											<div class="search-content">
											 <?php if( empty($_SESSION['city_name'])) { ?>
											<section class="" id="">
												<input id="target" type="hidden" class="geo geocontrast" placeholder="Where would you like to go?" value="" required>
												<script charset="utf-8" src="//www.travelpayouts.com/widgets/c98aeb1f90b513aff212c115d707c6ac.js?v=2251" async></script>

											</section>
										<?php } ?>
											</div>
										</div>
									</div>
								</div>
						   </div>
					   </div>
					</div>
                <!--end of Filter -->
                <?php include('category-newfile.php'); ?>
                <!--end of category -->
                <?php if( empty($_SESSION['city_name'])) { ?>
                    <!--<section id="cool_flight" data-aos="fade-up" data-aos-duration="1000">
                        <div class="container">
                            <div class="heading">
                                <h4>Cool Flight Deals</h4>
                                <p>Checkout what we found for you from </p>
                            </div>
                            <div class="client owl-carousel owl-theme">
                               <?php
                               $sql = "SELECT name,image_url FROM popular_cities limit 10";
                               $result = $mysqli->query($sql);

                               foreach ($result as $key => $value) {
                                   ?>
                                   <div class="item">
                                    <a onclick="reloadLandingPage('<?php echo $value['name']; ?>',this)" href="random_deals.php?flag=Flights&from_name=<?php echo $value['name']; ?>&from_to=United state">
                                        <div class="image_htfix_mid"> 
                                            <img src="<?php echo $value['image_url']; ?>" alt="<?php echo $value['name']; ?>" loading="lazy"  class="img-fluid">
                                        </div>  
                                        <div class="item_content">
                                            <h3><?php echo $value['name']; ?></h3>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </section>-->
			<div class="slider-section flight-sec" id=""> 
			<div class="container">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2>Cool Flight Deals</h2>
				   <p>Checkout what we found for you from</p>
				</div>
				<div class="testimonial-section products">
				   <div class="owl-carousel owl-theme ProductSlide" id="ProductSlide">
					  
					   <?php
                               $sql = "SELECT name,image_url FROM popular_cities limit 10";
                               $result = $mysqli->query($sql);

                               foreach ($result as $key => $value) {
                                   ?>
								    <!--<div data-aos="zoom-in-right" class="testimonial-block product">
									   <div class="cities">
											<img src="images/slid4.png">
											<a href=""><p>New York</p></a>
									   </div>
								     </div>-->
                                   <div class="item testimonial-block product">
                                   
                                        <div class="cities"> 
                                            <img src="<?php echo $value['image_url']; ?>" alt="<?php echo $value['name']; ?>" loading="lazy">
                                         <a onclick="reloadLandingPage('<?php echo $value['name']; ?>',this)" href="random_deals.php?flag=Flights&from_name=<?php echo $value['name']; ?>&from_to=United state">
                                            <h3><?php echo $value['name']; ?></h3>
										</a>
                                        </div>
                                </div>
                            <?php } ?>
				   </div>
				</div>
			</div>
		</div>

                <!--end of main-slider-->
                <div class="generalPageHeadingActivity inspiratinSection">
                </div>
                <div class="clear"></div> 
                <section class="adds sec_pad">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-2">
                            </div>
                            <div class="col-lg-8" >
                              <a href="https://www.tkqlhce.com/click-8265264-13820699" target="_top">
                                 <img src="images/home-ad.gif" width="728" height="90" alt="Vrbo" border="0"/></a>
                             </div>
                             <div class="col-lg-2">
                             </div>
                         </div>
                     </div>
                 </section>
              <!--   <section class="adds sec_pad">
                    <div class="container">
                        <div class="row">
                            <a href="https://www.tkqlhce.com/click-8265264-13820699" target="_top">
                                <img src="images/home-ad.gif" width="1300" height="90" alt="Vrbo" border="0"/></a>
                            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                                <img src="img/img24.png" class="img-fluid" loading="lazy" >
                            </div>
                            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                                <img src="img/img24.png" class="img-fluid" loading="lazy" >
                            </div>
                        </div>
                    </div>
                </section> -->
                <!--end of adds -->
            <?php } else {
				?>
				<div class="about-mysiti-sec">
					<div class="container">
						<div class="row">
							<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-6 col-lg-6">
								<div class="about-img">
									 <?php foreach ($result as $key => $value) { 
                                       $images[] = $value['images'];
                                       $video_url = $value['video'];
                                   } 
                                   $image_url = explode(",",$images[0] );?>
                                   <?php if($video_url!=''){ ?>
                                    <video width="" height="" class="videocontrol" playsinline autoplay muted loop>
                                        <source src="https://www.mysittivacations.com/video/<?php echo $video_url; ?>" type="video/mp4">
                                            <source src="movie.ogg" type="video/ogg">
                               
                                    <?php  } elseif(empty($images[0]) && $video_url=='') { ?>
                                        <div class="col-lg-7 image_left">
                                            <img src="img/img29.png" class="img-fluid w-100" loading="lazy" >
                                        </div>
                                        <div class="col-lg-5 image_right">
                                            <img src="img/img30.png" class="img-fluid  w-100 mb-4" loading="lazy" >
                                            <img src="img/img31.png" class="img-fluid  w-100" loading="lazy" >
                                        </div>
                                    <?php  } else { ?>
                                       <div class="col-lg-7 image_left">
                                          <img src="/images/<?php echo $image_url[0]; ?>" class="img-fluid w-100" loading="lazy" >
                                      </div>
                                      <div class="col-lg-5 image_right">
                                        <?php if ($image_url[1] != ''){ ?>
                                            <img src="/images/<?php echo $image_url[1]; ?>" class="img-fluid  w-100 mb-4" loading="lazy" >
                                        <?php } ?>
                                        <?php if ($image_url[2] != ''){ ?>
                                            <img src="/images/<?php echo $image_url[2]; ?>" class="img-fluid  w-100" loading="lazy" >
                                        <?php } ?>
                                    </div>
                                <?php } ?>
									<a href="#"><i class="fa fa-play" aria-hidden="true"></i></a>
								</div>
							</div>
							<div data-aos="zoom-in-left" class="col-12 col-sm-6 col-md-6 col-lg-6">
								<div class="about-content">
									<div data-aos="zoom-in-left" class="myheader-sec">
									   <h2>About <?php echo $_SESSION['city_name']; ?></h2>
									   
                                <?php foreach ($result as $key => $value) { 
                                    if($value['text'] != ''){ ?>
										 <p> <?php  echo substr($value['text'],0,1000); ?><span class="content"><?php  echo "- ".substr($value['text'],1000,10000); ?></span>
                                        <a href="javascript:void();" class="show_hide" data-content="toggle-text" style="color:green;">Read More</a></p>
                                <?php } } ?>
									  
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="slider-section discount-section travels what_do pb-0 hotel_style where_say_sec"> 
					<div class="container">
						<div class="row">
							<div class="col-12 col-sm-12 col-md-12 col-lg-12">
								<div data-aos="zoom-in-left" class="myheader-sec">
								   <h2>Where to stay</h2>
								   <p>Low hotel rates for luxury, comfort, pet-friendly rooms</p>
								</div>
							</div>
						</div>
						<div class="row" id="city_deals_home">
							
								 <?php
							   $getAds = "SELECT content FROM specific_city_sidebar WHERE city like '%".$_SESSION['city_name']."%' limit 1";
							   $result = $mysqli->query($getAds);
							   $count = $result->num_rows;
							   if($count > 0){
								foreach ($result as $key => $value) {
								  $fiveStar = str_replace('popularity', '5star', $value['content']);
								  echo "<div class='grid'>".str_replace('limit=50', 'limit=3', $fiveStar)."</div>";
								}
							  }
							  else{
								
								 $string =  substr($_SESSION['city_name'], 0, 3);
								 $string =  strtoupper(  $string ); 
								 if( $_SESSION['city_name'] == "San Sebastián"){
									$string = "EAS";
								}
								if( $_SESSION['city_name'] == "İstanbul"){
									$string = "IST";
								}
								 $fiveStar = '<script async src="//www.travelpayouts.com/blissey/scripts_en_us.js?categories=popularity&iata='.$string.'&type=full&currency=usd&host=hotels.mysittivacations.com%2Fhotels&marker=130544.&limit=3&powered_by=true" charset="UTF-8"></script>';
								 echo "<div data-aos='zoom-in-right' class=''>".str_replace('limit=50', 'limit=3', $fiveStar)."</div>";
							 }?>
							<div class="view-tag" data-aos="zoom-in-down">
									<a href="/hotels/index.php">View All</a>
								</div>
						</div>
					</div>
				</div>
				
		<?php if(isset($_SESSION['city_name'])){ ?>				
		<input type="hidden" id="inputCity" value="<?php if(isset($_SESSION['city_name'])){ echo $_SESSION['city_name']; } ?>">

		<div class="slider-section discount-section stay-sec new-for"> 
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>What to do</h2>
						   <p>Find fun place to see and  things to do experience the art,museums,music,zoos</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-12">
						<div class="heading-content">
							<div class="content-sec">
								<h2>Escape Room in <?php echo $_SESSION['city_name']; ?></h2>
							</div>
							<div class="view-all-sec-new">
								<a href="/yelp-tour.php?tours=escape%20%room">View All</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row discounts_inner">
				
				</div>
			</div> 
		</div>
		
			<?php function yelp_api_data($limit,$city,$keyword){
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
	}?>
		<div class="slider-section discount-section stay-sec new-for"> 
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<div class="heading-content">
							<div class="content-sec">
								<h2>Family Top Attractions in <?php echo $_SESSION['city_name']; ?></h2>
							</div>
							<div class="view-all-sec-new">
								<a href="/family.php">View All</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
				
				<?php 
			$ciountt = 0;
			$getyelpTourData = yelp_api_data('3',$_SESSION['city_name'],'family attractions'); 
			if(!empty($getyelpTourData)) { ?>
					<?php foreach ($getyelpTourData as $homeData):
						
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
						$tour_phone = $homeData->display_phone; ?>
						
						<div class="col-md-4 col-12">
							<div class="dicount-offer-sec top-attr">
								
								<?php if(!empty($tour_image)) : ?>
									<img src="<?php echo $tour_image; ?>" class="nav-img" alt="<?php echo $tour_name ; ?> ">
								<?php else : ?>
									<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg" class="nav-img" alt="<?php echo $tour_name ; ?> ">
								<?php endif; ?>
								
										
								<div class="dis-content">
									<h3><?php echo $tour_name; ?></h3>
									<ul>
										<li><img class="nav-img" src="images/loc-n.png"><?php echo $tour_city; ?></li>
									</ul>
									<div class="review-sec">
										<a href="<?php echo $tour_url ; ?>" target="_blank" class="">
											<?php $for_counter = 0 ;
												$total = count((array)$homeData->categories)-1; 
												foreach ($homeData->categories as $category){
													echo $category->title;
													if($for_counter != $total){
														echo ", ";
													}
													
													$for_counter++; 
											} ?>
										
										</a>
										<div class="rating">
											<ul>
											
											<?php for($x=1;$x<=$tour_rating;$x++) { ?>
													<li><i class="fa fa-star" aria-hidden="true"></i></li>
												<?php } ?>
												<?php $x++;?>
																			
											
											</ul>
											<p>(<?php echo $tour_review_count ; ?> Ratings)</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<?php endforeach; ?>
					
				<?php } else { ?>
					 
						<div class="yelp-serach-null-result col-md-5 col-sm-5 col-xs-6">
							<p> No record Found</p>
						</div>
					
				<?php } ?>
				
			</div>
			</div>
		</div>
		
		
		<div class="slider-section client-sec comedy winery-sec new-for"> 
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<div class="heading-content">
							<div class="content-sec">
								<h2>Winery</h2>
							</div>
							<div class="view-all-sec-new">
								<a href="/brewery.php">View All</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div class="comedy-bottom-sec">
							<div class="row">
							
							<?php if(isset($_POST['limit'])){
							$limit = $_POST['limit'];
						}else{
							$limit = 3;
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
								
								$html_winesty .= "<div class='col-12 col-sm-12 col-md-3 col-lg-3'>
									<div class='slide' data-aos='zoom-in-right'>
										<div class='discount-block'>
											<div class='cities'>
												<img src=".$image.">
											</div>
											<div class='discount-content'>
												<h3>".$eventsName."</h3> <span><i class='fa fa-map-marker' aria-hidden='true'></i> ".$venue_name."</span>
											</div>
											<div class='comedy-add-details'>
												<p><i class='fa fa-map-marker' aria-hidden='true'></i> ".$address1."  ".$address2.", ".$city.", ".$country."</p>
											</div>
											<div class='discount-action hotels'>
												<a class='hotel-book' href=".$eventUrl." target='_blank'>See More </a>
											</div>
										</div>
									</div>
								</div>";
								
								
								
								
							}

						echo $html_winesty;?>

							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<!--<div class="slider-section client-sec comedy  discount-section new-for "> 
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<div class="heading-content">
							<div class="content-sec">
								<h2>Performing Art</h2>
							</div>
							<div class="view-all-sec-new">
								<a href="/performing-arts.php">View All</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div class="comedy-bottom-sec family-ticketMaster" id="family_ticketMaster">
							
							<?php	
							/*if (isset($_SESSION['city_name']) || isset($_SESSION['formatteds'])) {
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
}$dropCity = $_SESSION['city_name'];

      	if($dropCity == 'Washington D.C.'){
      		$dropCity = 'Washington';
      	}elseif($dropCity == 'Washington DC'){
      		$dropCity = 'Washington';
      	}
		
      	$dropdown_value = 'Arts and Theater';

      	$date1 = date("Y-m-d");
      	$start_date = date("Y-m-d", strtotime($date1)).'T12:00:00Z'; 
      	$date2 = date("Y-m-d", strtotime("tomorrow"));
      	$end_date = date("Y-m-d", strtotime($date2 )).'T12:00:00Z';


      	$city_name_query = @mysql_query("SELECT dma_id, country_name FROM us_country_dma WHERE country_name ='".$dropCity."'");
      	$get_city_name = mysql_fetch_assoc($city_name_query);
      	$city_dma_id = 149;


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
      	$result_get = file_get_contents($urlgo);
      	$get_all_data1 = json_decode($result_get, true);

      	$page_size = $get_all_data1['page']['size'];
      	$totalPages = $get_all_data1['page']['totalPages'];
      	$number = $get_all_data1['page']['number'];

      	$get_deals = $get_all_data1['_embedded']['events']; 
      	if(($city_dma_id) > 0){
      		$html = '';

      		foreach ($get_deals as $homeData)
      		{
      			$eventsName = $homeData['name'];
      			$eventUrl = $homeData['url'];
      			$start_date = $homeData['dates']['start']['localDate'];

      			$timestamp = strtotime($start_date);
      			$date_foemate = date('m/d/Y', $timestamp);

      			$nameOfDay = date('D', strtotime($start_date));
      			$time = $homeData['dates']['start']['localTime'];
      			$strtime = date('h:i A', strtotime($time));
      			$city = $homeData['_embedded']['venues'][0]['city']['name'];
      			$state = $homeData['_embedded']['venues'][0]['state']['name'];
      			$country = $homeData['_embedded']['venues'][0]['country']['countryCode'];
      			$venue_name =$address1 = $homeData['_embedded']['venues'][0]['name'];
      			$address1 = $homeData['_embedded']['venues'][0]['address']['line1'];
      			$address2 = $homeData['_embedded']['venues'][0]['address']['line2'];
      			$image_url = $homeData['images'][1]['url'];

      			$image = "https://mysitti.com/images/noimage-found.jpeg"; 
      			if(!empty($image_url)){
      				$image =  $image_url ;
      			}


      			$html .= "<div class='col-md-6 alpha_filter' >
      			<div class='music_shows alpha_filter_div'>
      			<a href=".$eventUrl." target='_blank'>
      			<div class='image_htfix'>
      			<img src= ".$image." class='img-fluid'>
      			</div>
      			</a>
      			<div class='showname_location'>
      			<h5> ".$eventsName."</h5>
      			<p class='contacts'><i class='fas fa-map-marker-alt'></i> ".$venue_name."</p>
      			</div>
      			<p class='contacts p-3 ''><i class='fas fa-map-marker-alt'></i>".$address1."  ".$address2.", ".$city.", ".$country."</p>
      			<div class='date_coupon'>
      			<p class='contacts'><i class='fas fa-calendar'></i> ". $nameOfDay .','.$date_foemate." </p>
      			<p class='contacts'><i class='fas fa-clock'></i>".$strtime."</p>
      			</div>
      			<div class='detail_btn mx-0'>
      			<a href=".$eventUrl." target='_blank'><button>SEE TICKET</button></a>
      			</div>
      			</div>
      			</div>";
      		}


      	}else{
      		echo '<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h2>';
      	}
      	echo $html;*/
		?>
		
						</div>

						</div>
				</div>
			</div>
		</div>
		
	   <div class="slider-section client-sec comedy winery-sec new-for"> 
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<div class="heading-content">
							<div class="content-sec">
								<h2>Comedy</h2>
							</div>
							<div class="view-all-sec-new">
								<a href="/comedy.php">View All</a>
							</div>
						</div>
					</div>
				</div>
				<div class="testimonial-section products">
				   <div class="owl-carousel owl-theme" id="ProductSlide-audio2">
						<?php $getyelpTourData = yelp_api_call(4,$_SESSION['city_name'],'Comedy'); 
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
						$tour_phone = $homeData->display_phone;?>
						<div data-aos="zoom-in-left" class="testimonial-block product">
							<div class="discount-block">
								<?php if(!empty($tour_image)) : ?>
									<img src="<?php echo $tour_image; ?>" alt="<?php echo $tour_name; ?>">
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
										<p>(<?php echo $tour_review_count ; ?> Ratings)</p>
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
										<li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $tour_location_address1 ; ?> <?php echo $tour_location_address2 ; ?><?php echo $tour_city ; ?>  <?php echo $tour_state ; ?>  <?php echo $tour_zipCode ; ?> </li>
										<li><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $tour_phone; ?></li>
									</ul>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
						
				   </div>
				</div>
			</div>
		</div>
			<?php } ?>

<!--design end-->
			

<div class="landing_specific_page" id="specificData">
  <!--   <div id="loader" :class="loading"></div> -->
  <div class="specific_page_categories" v-html="members">
  </div>
</div>
<section class="adds pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8" >
               <a href="https://www.dpbolvw.net/click-8265264-13217276" target="_top">
                <img src="images/home-ad-specific.jfif" width="728" height="90" alt="Up to 35% off at Moon Palace The Grand-Cancun almost over. Book now!" border="0"/></a>

                 <div class="container recommed-city pcdesktop new_adds" style="text-align: center;  margin: 40px 0px 0px;">
					<a href="https://track.flexlinkspro.com/g.ashx?foid=156074.4221.271012&trid=1215297.159075&foc=16&fot=9999&fos=5" rel="nofollow" target="_blank" alt="Best Hotel Prices 728x90" title="Best Hotel Prices 728x90" ><img border="0" src="http://a.impactradius-go.com/display-ad/4221-271012" style="max-width: 100%;margin-top: 20px;" /></a><img src="https://track.flexlinkspro.com/i.ashx?foid=156074.4221.271012&trid=1215297.159075&foc=16&fot=9999&fos=5" border="0" width="0" height="0" style="opacity: 0;"/>
				</div>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
    </div>
</section>

<?php } ?>
<?php include('blog-resources-new.php');?>
<!--end of our_blog-->
<?php if( empty($_SESSION['city_name'])) { ?>
    <section class="bicycle sec_pad">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1500">
                    <div class="bicycle_content">
                        <div class="heading mb-0">
                            <h4 class="text-white">Rent With Companies You Know and Trust</h4>
                            <!-- <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p> -->
                        </div>
                        <a href="/car-rentals.php" class="btn">View Car Rental Deals</a>

                    </div>
                    <div class="car_banner">
                        <img src="images/car-banner.png" class="img-fluid" loading="lazy" >
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1500">
                    <div class="bicycle_img">
                        <img src="img/img28-new.png" class="img-fluid" loading="lazy" >
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<!--end of adds -->



<!-- design -->


<!--food end-->



<!-- JS -->


<?php function yelp_api_call($limit,$city,$keyword){
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
}?>

<?php include('footer-home-dev.php'); ?>


<!-- Travel Inspiration Popup -->
<div class='modal fade my_modal' id='travel_inspiration'  tabindex="-1" data-focus-on="input:first"  role='dialog'>
    <div class='modal-dialog modal-lg modal-dialog-scrollable'>
        <div class='modal-content guide_modal'>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle" style="font-size: 28px;">Travel Inspirations</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" style="font-size: 36px;padding: 16px;">&times;</span>
          </button>
      </div>
      <div class="travel_inspiration_modalss travel_inspiration_parsd modal-body">

      </div>
      <div class='modal-footer'>
          <button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
  </div>
</div>
</div>

<script type="text/javascript">

		var geodemo = jQuery('#inputCity').val();
		var limit = "3";
		var quick_link = 'escape-20-room';
		jQuery.ajax({
			url: "ajax_yelp_home_dev.php",
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
		    	jQuery('.top_title').html('Escape Room');
		    	jQuery('.discounts_inner').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".discounts_inner").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
</script>

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
    })
	$('.ProductSlide').owlCarousel({
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
	$('.ProductSlide1').owlCarousel({
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
				loop:false
			}
		}
	})
</script>












<!----perfoming--->
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
	var pageCounter = 0;
	if ($('#target').val().length === 0) {
		var geodemo = $('#geo-demo').val();
	}else{
		var geodemo = $('#target').val();
	}
	$(window).load(function(){
		$.ajax({
			url: "ajax_ticketmaster_deals.php",
			type: "POST",
			data: {
				formatted: geodemo,
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
	
	var app = new Vue({
		el: '#specificGenre',
		data:{
			genreData:'',
			checkSessionServer: '',
			formatted: '<?php echo $_SESSION['city_name']; ?>',
			tittle: 'Performing Arts Deals',
			key: 'performing arts',
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

</script>
	
</body>

</html>
<style>
.business-block {
    height: 100%;
}
.business-block  a{
    height: 100%;
}
.where_say_sec #city_deals_home .blissey-widget--l .blissey-widget-body-hotels-full-list-item-gallery, .where_say_sec .blissey-widget--l .blissey-gallery {
    min-height: 257px !important;
}
.groupon_discount_sec .all-inclusive:nth-child(3) .cui-udc-details {
    background: #fe6e003d;
}
.groupon_discount_sec .all-inclusive:nth-child(3) .cui-udc-details:after {
    background-image: url(./images/right-green.png);
}
.groupon_discount_sec .all-inclusive:nth-child(4) .cui-udc-details {
    background: #00ae5d36;
}
.groupon_discount_sec .all-inclusive:nth-child(3) .cui-udc-details:after {
    background-image: url(./images/right-saff.png);
}
    
section.mewtwo-hotels.mewtwo-hotels--virgin.mewtwo-tabs-container {
    background: transparent !important;
    box-shadow: none!important;
}
.mewtwo-widget .mewtwo-hotels-city {
    width: 26%!important;
}
    
@media(max-width:767px){  
img.cui-image {
    max-width: 0 !important;
}
  }
</style>