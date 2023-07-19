
                <section class="category">
                    <div class="container">
                        <h4>Choose your category</h4>
                        <?php if( empty($_SESSION['city_name'])) { ?>
                            <ul>
                                <li>   <a class="nav-link" href="javascript:void(0);" data-src="hotels/index.php?city=" data-toggle="modal" data-target="#exampleModal"><img src="<?php echo $SiteURL; ?>img/hotel_icon.png" class="ml-3"> hotels</a></li>
                                <li>  <a class="nav-link" href="javascript:void(0);" data-src="flight/index.php?city=" data-toggle="modal" data-target="#exampleModal"><img src="<?php echo $SiteURL; ?>img/flights_icon.png" class="ml-3"> flights</a></li>
                                <li>  <a class="nav-link" href="<?php echo $SiteURL; ?>car-rentals.php" ><img src="<?php echo $SiteURL; ?>img/rentals_icon.png" class="ml-3"> car rentals</a></li>
                                <li><a class="nav-link" href="javascript:void(0);" data-src="restaurant-deals.php?city=" data-toggle="modal" data-target="#exampleModal"><img src="<?php echo $SiteURL; ?>img/restaurants_icon.png" class="ml-3"> restaurants</a></li>
                                <li>  <a class="nav-link" href="javascript:void(0);" data-src="yelp-tour.php?city=" data-toggle="modal" data-target="#exampleModal"><img src="<?php echo $SiteURL; ?>img/things_icon.png" class="ml-3"> things to do</a></li>
                                <li>  <a class="nav-link" href="javascript:void(0);" data-src="city-guide.php?city=" data-toggle="modal" data-target="#exampleModal"><img src="<?php echo $SiteURL; ?>img/audio_icon.png" class="ml-3"> audio tours</a></li>
                                <li> <a class="nav-link" href="<?php echo $SiteURL; ?>random_deals.php"><img src="<?php echo $SiteURL; ?>img/deals_icon.png" class="ml-3"> deals</a></li>
                                <li>  <a class="nav-link" href="<?php echo $SiteURL; ?>/blog"><img src="<?php echo $SiteURL; ?>img/blogs_icon.png" class="ml-3"> blogs</a></li>
                            </ul>
                            <input type="hidden" value="" class="general_popup_vel "> 
                        <?php } else {?>
                            <ul>
                                <li> <a href="<?php echo $SiteURL; ?>hotels/index.php"><img src="<?php echo $SiteURL; ?>img/hotel_icon.png" class="ml-3"> hotels</a></li>
                                <li> <a href="<?php echo $SiteURL; ?>flight/index.php"><img src="<?php echo $SiteURL; ?>img/flights_icon.png" class="ml-3"> flights</a></li>
                                <li> <a href="<?php echo $SiteURL; ?>car-rentals.php"><img src="<?php echo $SiteURL; ?>img/rentals_icon.png" class="ml-3"> car rentals</a></li>
                                <li> <a href="<?php echo $SiteURL; ?>restaurant-deals.php"><img src="<?php echo $SiteURL; ?>img/restaurants_icon.png" class="ml-3"> restaurants</a></li>
                                <li> <a href="<?php echo $SiteURL; ?>yelp-tour.php"><img src="<?php echo $SiteURL; ?>img/things_icon.png" class="ml-3"> things to do</a></li>
                                <li> <a href="<?php echo $SiteURL; ?>city-guide.php"><img src="<?php echo $SiteURL; ?>img/audio_icon.png" class="ml-3"> audio tours</a></li>
                                <li> <a href="<?php echo $SiteURL; ?>random_deals.php"><img src="<?php echo $SiteURL; ?>img/deals_icon.png" class="ml-3"> deals</a></li>
                                <li> <a href="<?php echo $SiteURL; ?>/blog?city_name=true"><img src="<?php echo $SiteURL; ?>img/blogs_icon.png" class="ml-3"> blogs</a></li>
                            </ul>
                        <?php }?>
                    </div>
                </section>