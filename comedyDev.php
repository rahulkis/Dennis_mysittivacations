<?php session_start(); ?>
<?php include('customerHeader.php'); 
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>

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
<div data-aos="zoom-in-right" class="banner-section hotel-hero comedy-sec" style="background-image:url(/mysitti-html/images/comedy-hero.png)"> 
			<div class="container">
				<div class="mobile-hero">
					<img src="images/comedy-hero.png">
				</div>
				<div class="carousel-caption-top">
				   <h1>Laugh With US!</h1>
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
												<input type="Name" class="form-control" id="exampleFormControlInput1" placeholder="New York">
												<a href="#">Search </a>
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

		<div class="body-content">
			<div class="feature-section">
		       <div class="container">
					<div data-aos="zoom-in-right" class="top-heading-section text-center">
				       <h1>CHOOSE YOUR CATEGORY</h1>
					</div>
					<div class="row">
				       <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
					       <div class="business-block text-center">
						      <a href="">
							      <img src="images/2.png">
							      <p>Hotels Flights</p>
							  </a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
					       <div class="business-block text-center yellow-bg">
						      <a href="">
							      <img src="images/5.png">
							      <p>Flights</p>
							  </a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
					       <div class="business-block text-center blue-bg">
						      <a href="">
							      <img src="images/4.png">
							      <p>Car Rentals</p>
							  </a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
					       <div class="business-block text-center red-bg">
						      <a href="">
							      <img src="images/3.png">
							      <p>Restaurants</p>
							  </a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
					       <div class="business-block text-center purple-bg">
						      <a href="">
							      <img src="images/1.png">
							      <p>Things To Do</p>
							  </a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
					       <div class="business-block text-center green-bg">
						      <a href="">
							      <img src="images/6.png">
							      <p>Audio Tour</p>
							  </a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
					       <div class="business-block text-center grey-bg">
						      <a href="">
							      <img src="images/7.png">
							      <p>Deals</p>
							  </a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
					       <div class="business-block text-center saff-bg">
						      <a href="">
							      <img src="images/8.png">
							      <p>Blogs</p>
							  </a>
						   </div>
					   </div>
					</div>
				</div>
			</div>
		</div>
		

		
		<div class="rind-the-right-section comedy-sec">
		<div class="container n-contain ">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
					<div class="sidebar-listing">
						
						<div class="specialities-checkbox">
							<div class="searcher-sec">
								<label class="custom-control-label">Search By Name</label>
								<div class="form-group">
									<input type="Name" class="form-control" id="exampleFormControlInput1" placeholder="New York NY, USA">
								</div>
							</div>
						</div>
						<div class="specialities-checkbox">
							<div class="listing-check">
								<h4>CATEGORY</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck01">
								  <label class="custom-control-label" for="customCheck01">Arts and Theater</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck02">
								  <label class="custom-control-label" for="customCheck02">Broadway</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck03">
								  <label class="custom-control-label" for="customCheck03">Off-Broadway</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck04">
								  <label class="custom-control-label" for="customCheck04">Ballet and Dance</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck05">
								  <label class="custom-control-label" for="customCheck05">Classical</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck06">
								  <label class="custom-control-label" for="customCheck06">Comedy</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck07">
								  <label class="custom-control-label" for="customCheck07">Film Festivals</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck08">
								  <label class="custom-control-label" for="customCheck08">Museums and Exhibits</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck09">
								  <label class="custom-control-label" for="customCheck09">Musicals</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck10">
								  <label class="custom-control-label" for="customCheck10">Opera</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck11">
								  <label class="custom-control-label" for="customCheck11">Plays</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="customCheck12">
								  <label class="custom-control-label" for="customCheck12">More Arts and Theater</label>
								</div>
							</div>
						</div>
						
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
									<h4>Groupon Performing Comedy</h4>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-12">
								<section class="client-sec comedy">
									<div class="testimonial-section products">
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio">
											<div data-aos="zoom-in-right" class="testimonial-block product">
												<div class="discount-block">
													<img src="images/comedy2.png">
													<div class="discount-content">
														<h3>The Chonga Girls</h3>
														<p>The Chonga Girls - Wednesday, Oct 12, 2022 / 9:30pm</p>
													</div>
													<div class="comedy-detail">
														<ul>
															<li><i class="fa fa-map-marker" aria-hidden="true"></i> Lehman Center for the Performing Arts, Bronx</li>
															<li><i class="fa fa-shopping-cart" aria-hidden="true"></i> 270+ bought</li>
															<li><i class="fa fa-usd" aria-hidden="true"></i> $586  <span>$31</span> 38% OFF</li>
														</ul>
													</div>
												</div>
											</div>
											<div data-aos="zoom-in-left" class="testimonial-block product">
												<div class="discount-block">
													<img src="images/comedy2.png">
													<div class="discount-content">
														<h3>Roast Battle NYC</h3>
														<p>Two General Admission Tickets with Four 6-Month VIP Passes to Any...</p>
													</div>
													<div class="comedy-detail">
														<ul>
															<li><i class="fa fa-map-marker" aria-hidden="true"></i> Lehman Center for the Performing Arts, Bronx</li>
															<li><i class="fa fa-shopping-cart" aria-hidden="true"></i> 270+ bought</li>
															<li><i class="fa fa-usd" aria-hidden="true"></i> $586  <span>$31</span> 38% OFF</li>
														</ul>
													</div>
												</div>
											</div>
											<div data-aos="zoom-in-right" class="testimonial-block product">
												<div class="discount-block city">
													<img src="images/comedy2.png">
													<div class="discount-content">
														<h3>The Mavericks</h3>
														<p>Grupo Niche - Saturday, Feb 11, 2023 / 8:00pm</p>
													</div>
													<div class="comedy-detail">
														<ul>
															<li><i class="fa fa-map-marker" aria-hidden="true"></i> Lehman Center for the Performing Arts, Bronx</li>
															<li><i class="fa fa-shopping-cart" aria-hidden="true"></i> 270+ bought</li>
															<li><i class="fa fa-usd" aria-hidden="true"></i> $586  <span>$31</span> 38% OFF</li>
														</ul>
													</div>
												</div>					  
											</div>
											<div data-aos="zoom-in-left" class="testimonial-block product">
												<div class="discount-block">
													<img src="images/comedy1.png">
													<div class="discount-content">
														<h3>The Chonga Girls</h3>
														<p>The Chonga Girls - Wednesday, Oct 12, 2022 / 9:30pm</p>
													</div>
													<div class="comedy-detail">
														<ul>
															<li><i class="fa fa-map-marker" aria-hidden="true"></i> Lehman Center for the Performing Arts, Bronx</li>
															<li><i class="fa fa-shopping-cart" aria-hidden="true"></i> 270+ bought</li>
															<li><i class="fa fa-usd" aria-hidden="true"></i> $586  <span>$31</span> 38% OFF</li>
														</ul>
													</div>
												</div>
											</div>
									   </div>
									</div>
									
									<div class="testimonial-section products">
										<div class="head-yelp">
											<h3> Deals on <img src="./img/ss/musictag.png"></h3>
										</div>
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio2">
									   	<?php $getyelpTourData = yelp_api_call(20,$_SESSION['city_name'],'Comedy'); 
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
											<div data-aos="zoom-in-right" class="testimonial-block product">
												<div class="discount-block">
													<?php if(!empty($tour_image)) : ?>
														<img src="<?php echo $tour_image; ?>" class="img-fluid w-100" alt="<?php echo $tour_name; ?>">
													<?php else : ?>
														<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg" alt="no-image">
													<?php endif; ?>
													<div class="discount-content">
														<h3><?php echo $tour_name; ?></h3>
														<div class="stars">
															<!-- <ul>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
															</ul> -->
															<?php for($x=1;$x<=$tour_rating;$x++): ?>
																<span class='fa fa-star checked'></span>
															<?php endfor; ?>
															<?php if (strpos($tour_rating,".")) : ?>
																<span class='fa fa-star checked'></span>
																<?php 
																$x++;
															endif; ?>
															<p>(<?php echo $tour_review_count ; ?> Reviews)</p>
														</div>
														<p>
															<?php $for_counter = 0 ;
									$total = count((array)$homeData->categories)-1; 
									foreach ($homeData->categories as $category){
										echo $category->title;
										if($for_counter != $total){
											echo ", ";
										}
										$for_counter++; 
									} ?>
													</div>
													<div class="comedy-detail">
														<ul>
															<li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $tour_location_address1 ; ?> <?php echo $tour_location_address2 ; ?><?php echo $tour_city ; ?>  <?php echo $tour_state ; ?>  <?php echo $tour_zipCode ; ?> </li>
															<?php if ( $tour_phone != ''){?>
															<p class="contacts"><i class="fas fa-phone "></i> <?php echo $tour_phone ; ?></p>
														<?php } ?>
														</ul>
													</div>
												</div>
												<?php endforeach; ?>
											</div>
											<!-- <div data-aos="zoom-in-left" class="testimonial-block product">
												<div class="discount-block">
													<img src="images/comedy5.png">
													<div class="discount-content">
														<h3>Roast Battle NYC</h3>
														<div class="stars">
															<ul>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
															</ul>
															<p>(339 Reviews)</p>
														</div>
														<p>Cocktail Bars, Dive Bars, Comedy Clubs</p>
													</div>
													<div class="comedy-detail">
														<ul>
															<li><i class="fa fa-map-marker" aria-hidden="true"></i> 130 W 3rd St New York NY 10012</li>
															<li><i class="fa fa-phone" aria-hidden="true"></i> (212) 725-3860</li>
														</ul>
													</div>
												</div>
											</div>
											<div data-aos="zoom-in-right" class="testimonial-block product">
												<div class="discount-block city">
													<img src="images/comedy6.png">
													<div class="discount-content">
														<h3>The Mavericks</h3>
														<div class="stars">
															<ul>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
															</ul>
															<p>(339 Reviews)</p>
														</div>
														<p>Cocktail Bars, Dive Bars, Comedy Clubs</p>
													</div>
													<div class="comedy-detail">
														<ul>
															<li><i class="fa fa-map-marker" aria-hidden="true"></i> 130 W 3rd St New York NY 10012</li>
															<li><i class="fa fa-phone" aria-hidden="true"></i> (212) 725-3860</li>
														</ul>
													</div>
												</div>					  
											</div>
											<div data-aos="zoom-in-left" class="testimonial-block product">
												<div class="discount-block">
													<img src="images/comedy1.png">
													<div class="discount-content">
														<h3>The Chonga Girls</h3>
														<div class="stars">
															<ul>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<li><i class="fa fa-star" aria-hidden="true"></i></li>
															</ul>
															<p>(339 Reviews)</p>
														</div>
														<p>Cocktail Bars, Dive Bars, Comedy Clubs</p>
													</div>
													<div class="comedy-detail">
														<ul>
															<li><i class="fa fa-map-marker" aria-hidden="true"></i> 130 W 3rd St New York NY 10012</li>
															<li><i class="fa fa-phone" aria-hidden="true"></i> (212) 725-3860</li>
														</ul>
													</div>
												</div>
											</div> -->
									   </div>
									</div>
									<!--<div class="comedy-bottom-sec">
										<div class="slide">
											<div class="discount-block">
												<div class="cities">
													<img src="images/hotel4.png">
												</div>
												<div class="rating">
													<div class="stars">
														<p>Hotels</p>
														<ul>
															<li><i class="fa fa-star" aria-hidden="true"></i></li>
															<li><i class="fa fa-star" aria-hidden="true"></i></li>
															<li><i class="fa fa-star" aria-hidden="true"></i></li>
															<li><i class="fa fa-star" aria-hidden="true"></i></li>
														</ul>
													</div>
													<div class="reviews-no">
														<p>8.0</p>
													</div>
												</div>
												<div class="discount-content">
													<h3>Smyth Tribeca <span><i class="fa fa-map-marker" aria-hidden="true"></i> Times Square</span></h3>
													<div class="hotel-price">
														<p>Agoda <span></span>$472</p>
														<a href="#">View Details</a>
													</div>
												</div>
												<div class="discount-action hotels green-bg">
													<div class="action-content">
														<p><b>$586</b> <span>Price for 1 night at <a href="#">Trip.com</a></span></p>
													</div>
													<a class="hotel-book" href="#">Book Now <i class="fa fa-angle-right" aria-hidden="true"></i></a>
												</div>
											</div>
										</div>
										<div class="slide">
											<div class="discount-block">
												<div class="cities">
													<img src="images/hotel4.png">
												</div>
												<div class="rating">
													<div class="stars">
														<p>Hotels</p>
														<ul>
															<li><i class="fa fa-star" aria-hidden="true"></i></li>
															<li><i class="fa fa-star" aria-hidden="true"></i></li>
															<li><i class="fa fa-star" aria-hidden="true"></i></li>
															<li><i class="fa fa-star" aria-hidden="true"></i></li>
														</ul>
													</div>
													<div class="reviews-no">
														<p>8.0</p>
													</div>
												</div>
												<div class="discount-content">
													<h3>Smyth Tribeca <span><i class="fa fa-map-marker" aria-hidden="true"></i> Times Square</span></h3>
													<div class="hotel-price">
														<p>Agoda <span></span>$472</p>
														<a href="#">View Details</a>
													</div>
												</div>
												<div class="discount-action hotels green-bg">
													<div class="action-content">
														<p><b>$586</b> <span>Price for 1 night at <a href="#">Trip.com</a></span></p>
													</div>
													<a class="hotel-book" href="#">Book Now <i class="fa fa-angle-right" aria-hidden="true"></i></a>
												</div>
											</div>
										</div>
									</div>-->
								</section>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		
		<footer class="footer-section">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4">
						<div class="footer-logo">
							<img src="images/logo-footer.png">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<p>We can help you plan the perfect vacation. Our travel website makes it easy to find the ideal trip and book one today! Check out our deals on flights, hotels, cruises, adventure tours, car rentals, tours, and more. We have partnered with more than 700+ airlines, over 500,000+ hotel locations, and thousands of travel sites worldwide. With so much to see and do, you want to ensure you've got the best travel plans. That's why we created our site: to help you find a great vacation package you can't find anywhere else.</p>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<ul>
							<li><a href="#">About Us</a></li>
							<li><a href="#">DMCA Policy</a></li>
							<li><a href="#">Terms & Conditions</a></li>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Other Terms & Conditions</a></li>
							<li><a href="#">Contact Us</a></li>
						</ul>
						<div class="mailer-sec">
							<img src="images/mail.png">
							<a href="#">vacations@mysittivacations.com</a>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<div class="copyright-section">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-4">
						<a href="#">© 2022 mysittivacations.com</a>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-8">
						<ul>
							<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	   
	
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
	
	$('#ProductSlide-audio').owlCarousel({
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
	
  </body>
</html>