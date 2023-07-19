   <div class="body-content">
           <div class="feature-section">
               <div class="container">
                    <div data-aos="zoom-in-right" class="top-heading-section text-center">
                       <h1>CHOOSE YOUR CATEGORY</h1>
                    </div>
                    <div class="row">
                        <?php if( empty($_SESSION['city_name'])) { ?>
                           

                        <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center">
                              <a href="javascript:void(0);" data-src="hotels/index.php?city=" data-toggle="modal" data-target="#exampleModal">
                                  <img src="/mysitti-html/images/2.png">
                                  <p>Hotels Flights</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center yellow-bg">
                              <a href="javascript:void(0);" data-src="flight/index.php?city=" data-toggle="modal" data-target="#exampleModal">
                                  <img src="/mysitti-html/images/5.png">
                                  <p>Flights</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center blue-bg">
                              <a href="<?php echo $SiteURL; ?>car-rentals.php" >
                                  <img src="/mysitti-html/images/4.png">
                                  <p>Car Rentals</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center red-bg">
                              <a href="javascript:void(0);" data-src="restaurant-deals.php?city=" data-toggle="modal" data-target="#exampleModal">
                                  <img src="/mysitti-html/images/3.png">
                                  <p>Restaurants</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center purple-bg">
                              <a href="javascript:void(0);" data-src="yelp-tour.php?city=" data-toggle="modal" data-target="#exampleModal">
                                  <img src="/mysitti-html/images/1.png">
                                  <p>Things To Do</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center green-bg">
                              <a href="javascript:void(0);" data-src="city-guide.php?city=" data-toggle="modal" data-target="#exampleModal">
                                  <img src="/mysitti-html/images/6.png">
                                  <p>Audio Tour</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center grey-bg">
                              <a href="<?php echo $SiteURL; ?>random_deals.php">
                                  <img src="/mysitti-html/images/7.png">
                                  <p>Deals</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center saff-bg">
                              <a href="<?php echo $SiteURL; ?>/blog">
                                  <img src="/mysitti-html/images/8.png">
                                  <p>Blogs</p>
                              </a>
                           </div>
                       </div>
                            <input type="hidden" value="" class="general_popup_vel "> 

                        <?php } else {?>
                            <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center">
                              <a href="<?php echo $SiteURL; ?>hotels/index.php">
                                  <img src="/mysitti-html//mysitti-html/images/2.png">
                                  <p>Hotels Flights</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center yellow-bg">
                              <a href="<?php echo $SiteURL; ?>flight/index.php">
                                  <img src="/mysitti-html/images/5.png">
                                  <p>Flights</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center blue-bg">
                              <a href="<?php echo $SiteURL; ?>car-rentals.php">
                                  <img src="/mysitti-html/images/4.png">
                                  <p>Car Rentals</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center red-bg">
                              <a href="<?php echo $SiteURL; ?>restaurant-deals.php">
                                  <img src="/mysitti-html/images/3.png">
                                  <p>Restaurants</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center purple-bg">
                              <a href="<?php echo $SiteURL; ?>yelp-tour.php">
                                  <img src="/mysitti-html/images/1.png">
                                  <p>Things To Do</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-left" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center green-bg">
                              <a href="<?php echo $SiteURL; ?>city-guide.php">
                                  <img src="/mysitti-html/images/6.png">
                                  <p>Audio Tour</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center grey-bg">
                              <a href="<?php echo $SiteURL; ?>random_deals.php">
                                  <img src="/mysitti-html/images/7.png">
                                  <p>Deals</p>
                              </a>
                           </div>
                       </div>
                       <div data-aos="zoom-in-right" class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                           <div class="business-block text-center saff-bg">
                              <a href="<?php echo $SiteURL; ?>/blog?city_name=true">
                                  <img src="/mysitti-html/images/8.png">
                                  <p>Blogs</p>
                              </a>
                           </div>
                       </div>
                        <?php }?>
                    </div>
                    </div>
                    </div>
                    </div>
               