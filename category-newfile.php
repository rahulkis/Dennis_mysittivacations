
                <div class="body-content">
					<div class="feature-section car-feature pt-0">
                        <div class="container">
							<div data-aos="zoom-in-right" class="top-heading-section text-center">
							   <h1>CHOOSE YOUR CATEGORY</h1>
							</div>
							<div class="row">
							<?php if( empty($_SESSION['city_name'])) { ?>
								
								 <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
									   <div class="business-block text-center">
										  <a href="javascript:void(0);" data-src="hotels/index.php?city=" class="nav-linkk" data-bs-toggle="modal" data-bs-target="#exampleModal">
											  <img src="<?php echo $SiteURL; ?>images/hotel-flight.png" loading="lazy">
											  <p>Hotels Flights</p>
										  </a>
									   </div>
								  </div>
								 <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center yellow-bg">
									  <a href="javascript:void(0);" data-src="flight/index.php?city=" class="nav-linkk" data-bs-toggle="modal" data-bs-target="#exampleModal">
										  <img src="<?php echo $SiteURL; ?>images/flightnew.png" loading="lazy">
										  <p>Flights</p>
									  </a>
								   </div>
								</div>
								<div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center blue-bg">
									  <a href="<?php echo $SiteURL; ?>car-rental.php">
										  <img src="<?php echo $SiteURL; ?>images/car-rentalnew.png" loading="lazy">
										  <p>Car Rentals</p>
									  </a>
								   </div>
							   </div>	
								<div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center red-bg">
									  <a href="javascript:void(0);" data-src="restaurant-deal.php?city=" class="nav-linkk" data-bs-toggle="modal" data-bs-target="#exampleModal">
										  <img src="<?php echo $SiteURL; ?>images/restaurant-new.png" loading="lazy">
										  <p>Restaurants</p>
									  </a>
								   </div>
							   </div>
							    <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center purple-bg">
									  <a href="javascript:void(0);" data-src="yelp-tour.php?city=" class="nav-linkk" data-bs-toggle="modal" data-bs-target="#exampleModal">
										  <img src="<?php echo $SiteURL; ?>images/things-to-do-new.png" loading="lazy">
										  <p>Things To Do</p>
									  </a>
								   </div>
							   </div>
							   <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center green-bg">
									  <a href="javascript:void(0);" data-src="city-guide.php?city=" class="nav-linkk" data-bs-toggle="modal" data-bs-target="#exampleModal">
										  <img src="<?php echo $SiteURL; ?>images/audio-tour-new.png" loading="lazy">
										  <p>Audio Tour</p>
									  </a>
								   </div>
							   </div>
							   <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center grey-bg">
									  <a href="<?php echo $SiteURL; ?>random_deals.php?flag=All-Inclusive">
										  <img src="<?php echo $SiteURL; ?>images/dollar.png" loading="lazy">
										  <p>Deals</p>
									  </a>
								   </div>
							   </div>
							   <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center saff-bg">
									  <a href="<?php echo $SiteURL; ?>/blog">
										  <img src="<?php echo $SiteURL; ?>images/blogsnew.png" loading="lazy">
										  <p>Blogs</p>
									  </a>
								   </div>
							   </div>	
								<input type="hidden" value="" class="general_popup_vel "> 
							<?php } else {?>
								 <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center">
									  <a href="<?php echo $SiteURL; ?>hotels/index.php">
										  <img src="<?php echo $SiteURL; ?>images/hotel-flight.png" loading="lazy">
										  <p>Hotels Flights</p>
									  </a>
								   </div>
							    </div>
								<div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center yellow-bg">
									  <a href="<?php echo $SiteURL; ?>flight/index.php">
										  <img src="<?php echo $SiteURL; ?>images/flightnew.png" loading="lazy">
										  <p>Flights</p>
									  </a>
								   </div> 
							   </div>
							   <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center blue-bg">
									  <a href="<?php echo $SiteURL; ?>car-rental.php">
										  <img src="<?php echo $SiteURL; ?>images/car-rentalnew.png" loading="lazy">
										  <p>Car Rentals</p>
									  </a>
								   </div>
							   </div>
							   <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center red-bg">
									  <a href="<?php echo $SiteURL; ?>restaurant-deal.php">
										  <img src="<?php echo $SiteURL; ?>images/restaurant-new.png" loading="lazy">
										  <p>Restaurants</p>
									  </a>
								   </div>
							   </div>
							    <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center purple-bg">
									  <a href="<?php echo $SiteURL; ?>yelp-tour.php">
										  <img src="<?php echo $SiteURL; ?>images/things-to-do-new.png" loading="lazy">
										  <p>Things To Do</p>
									  </a>
								   </div>
							   </div>
							  <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center green-bg">
									  <a href="<?php echo $SiteURL; ?>city-guide.php">
										  <img src="<?php echo $SiteURL; ?>images/audio-tour-new.png" loading="lazy">
										  <p>Audio Tour</p>
									  </a>
								   </div>
							   </div>
							<div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
							   <div class="business-block text-center grey-bg">
								  <a href="<?php echo $SiteURL; ?>random_deals.php?flag=All-Inclusive">
									  <img src="<?php echo $SiteURL; ?>images/dollar.png" loading="lazy">
									  <p>Deals</p>
								  </a>
							   </div>
						   </div>
							   <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
								   <div class="business-block text-center saff-bg">
									  <a href="<?php echo $SiteURL; ?>blog?city_name=<?php echo $_SESSION['city_name']; ?>">
										  <img src="<?php echo $SiteURL; ?>images/blogsnew.png" loading="lazy">
										  <p>Blogs</p>
									  </a>
								   </div>
							   </div>
									
							<?php }?>
							</div>
						</div>
                    </div>
                </div>