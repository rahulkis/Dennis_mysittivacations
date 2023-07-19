<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
  $titleofpage="Online Restaurant Coupons & Deals in United States| MySittiVacations"; 
  $meta_description = "It's no secret that restaurants can be a headache. Whether you're in a hurry or just looking for the perfect place for you and your family, the restaurant reservation process can be frustrating. That's why we created this website with all of the restaurant reservation information you need. Whether you're trying to find a date, a time, or a place to eat, our restaurant reservation system will save you time and money. There are a wide range of restaurants in D.C. For a more upscale experience, we recommend the Capital Grille, Maestro, and The Palm. If you're looking for more of a family-friendly experience, El Pollo Loco, Five Guys, and Outback Steakhouse will give you what you're looking for!  
  Dine in the best restaurants in Washington D.C.
  The best restaurants in Washington, D.C. are those that are in the heart of the city. They are places where you would take your significant other and share a meal with them. It's also great to dine at a restaurant that you have never been to before. Every year, millions of people travel to Washington, D.C. to see the monuments and museums. However, visitors also stay in the city to explore food culture and the hottest restaurants in Washington, D.C. If you're coming to Washington, D.C. any time this year, be sure to check out these restaurants. You won't regret it!

  A better way to make reservations.
  It's often difficult to make a reservation at a restaurant. First, you have to call the place and hope they have a spot available. Then you have to hope they still have room available when you get there. If you make a reservation online, you can answer those questions before you go. When you arrive, you can skip the line and go straight to your table! With so many websites, apps, and mobile booking platforms, there are now more ways than ever to book a hotel. If you're looking for a great place to stay, it's important to use the most up-to-date booking method, which is usually the easiest and quickest.

  Click here to book your next reservation!
  MySitti Vacations offers personalized vacation packages for those who want to relax and unwind. We offer packages for one week, two weeks, or longer. All our destinations have been carefully selected to give you the most relaxing, rejuvenating experience possible. You will find that you enjoy our private island destination as much as we enjoy hosting you! You've come to the right place to make a reservation! We have a wide range of rooms that are both comfortable and clean. Our friendly staff is always there to make sure you have an enjoyable stay, so don't hesitate to ask them if you need anything! We also have activities for everyone, from families with children to couples and even individuals. Here you'll find information on all of our activities, from arts and crafts to outdoor games. So, if you're looking for a fun-filled vacation, you've come to the right place!";
  // ob_start("ob_gzhandler");
  session_start();

  $mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
  if(isset($_REQUEST['city'])){
    $_SESSION['city_name'] = $_REQUEST['city'];
  }
  $_SESSION['city_name'] = 'chicago';
  // if(!isset($_SESSION['city_name'])){
  //   header('location:https://mysittivacations.com/');
  // }
  if(isset($_SESSION['city_name'])){
    $getAds = "SELECT * FROM specific_city_sidebar WHERE city like '%".$_SESSION['city_name']."%' limit 1";
    $result = $mysqli->query($getAds);
    $count = $result->num_rows;
    if($count > 0){
      foreach ($result as $key => $value) {
        $city_data =  $value['city_id_code'];
      }
    }
  } 
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
  ?>
  <script  src="js/jquery-1.11.0.min.js"></script>
  <?php include("header-newfile.php"); ?>
  <style>
  .blissey-widget .blissey-info {
    order: 2;
    padding: 0px !important; 
    background: none !important;
  }
  .restFoood img{
    height:170px;
    object-fit: cover;
  }
  span.count{
    text-transform: capitalize; }
    .load_more, .load_more_search{
      margin-bottom: 20px;
    }
    .hotel_listitem .hotel_details.resturant_sprecification .hotel_name {
    padding: 0;
    height: auto;
}
.hotel_listitem .hotel_details.resturant_sprecification .restro_btns 
 .hotel_rating {
    padding: 0;
}
.hotel_listitem .hotel_details.resturant_sprecification .restro_btns .restro_deals {
    padding: 0;
    justify-content: start;
}
.hotel_listitem .hotel_details.resturant_sprecification > * {
    height: auto;
}
.hotel_listitem .hotel_details.resturant_sprecification .restro_btns .restro_deals a.restro_btn {
    letter-spacing: 0;
    padding: 10px 15px;
    border-radius: 100px;
    color: #fff;
    font-size: 13px;
    margin: 0 0px;
    background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa);
}
.hotel_listitem .hotel_img .image_htfix {
    max-height: 160px;
}
.hotel_details.resturant_sprecification {
    padding: 0 20px 0;
}
  </style>
  <body>
    <div class="v2_content_inner2">
      <div id="loader"></div>
      <span class='update-zero' style="display: none;">0</span> 
    </div>
    <?php //include("includes/menu.php"); ?>
    <!--end of navbar section-->
	
	
	
	<div data-aos="zoom-in-right" class="banner-section hotel-hero comedy-sec" style="background-image:url(images/Restaurant.jpg)"> 
			<div class="container">
				<div class="mobile-hero">
					<img src="images/Restaurant.jpg">
				</div>
				<div class="carousel-caption-top">
				   <h1>Restaurants in <?php echo $_SESSION['city_name']; ?></h1>
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

											<input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>" required="">

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
		
		
   <!-- <section class="inner_page_hero sec_pad resturent-sec">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="hero_section_content">
              <h2 class="mb-5">Restaurants in <?php //echo $_SESSION['city_name']; ?></h2>
            </div>
          </div>
          <div class="col-lg-12">
           <div class="content-bannersss">
            <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

            <input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php //echo $_SESSION['city_name'];?>" required="">

            <a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><img src="/css/optimize/images/search.png" alt=""></a>
          </div>
        </div>
      </div>
    </div>
  </section>-->
  <!--end of hero section-->
  
  <?php include('category-newfile.php'); ?>
  <!--end of category section-->
  <!-- product listing section -->
  <div class="rind-the-right-section comedy-sec">
		<div class="container n-contain ">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
					<div class="filter_box_main_mobile">
					<div class="filter_box">
            <h5 class="filter-heading">
              Search By Name
            </h5>
            <div class="filter_data">
              <div class="yelp_searcch_box search">
               <i class="fa fa-search"></i>  <input type="text" name="search-yelp-horizontal" class="form-control horizontal_yelp_content new_yelp_Content_cust" value="<?php echo $_SESSION['city_name']; ?>"  id="search-yelp-horizontal" placeholder="Search by restaurant’s name" autocomplete="off" >
               <div id="suggesstion-box"></div>
                <!-- <input type="submit" id="hitTeam" class="filtering_button" name="enter_buton"> 
                  <input type="submit" id="yelp-hitAjaxCity" class="filtering_button new_cust_filt_button" name="enter_buton"> -->
                </div>
              </div>
            </div>
            <div class="mobile-filter">
              <ul>
                <li>
                  <div class="sorf-filter">
                    <span>Sort By</span><select class="form-select" aria-label="Default select example">
                      <option selected="">Best Value</option>
                      <option value="1">Value</option>
                    </select>
                  </div>
                </li>
                <li><a href="#" data-toggle="modal" data-target="#filter-popup"><i class="fa fa-filter" aria-hidden="true"></i>Filter</a></li>
              </ul>
            </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="filter-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="filter-sec">
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          Establishment Type
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered" id="restaurantList"> 
                            <li>
                              <input class="styled-checkbox activity restaurantName" name="restaurantList" id="styled-checkbox-1 activity-01" type="checkbox"
                              value="Restaurants">
                              <label for="styled-checkbox-1 activity-01" >Restaurants</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" name="restaurantList" id="styled-checkbox-2 activity-02" type="checkbox" value="quick-bites"
                              >
                              <label for="styled-checkbox-2 activity-02">Quick Bites</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" name="restaurantList" id="styled-checkbox-02 activity-03" type="checkbox" value="dessert"
                              value="value02">
                              <label for="styled-checkbox-02 activity-03">Dessert</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" name="restaurantList" id="styled-checkbox-012 activity-04" type="checkbox" value="cafes"
                              value="value012">
                              <label for="styled-checkbox-012 activity-04">Coffee & Tea</label>
                            </li>
                          </ul>
                         <!--  <a href="#" class="show_more">
                            Show All
                          </a> -->
                        </div>
                      </div>
                      <hr>
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          Restaurant features
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered" id="restaurantList">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-4 activity-05" name="restaurantList" type="checkbox" value="delivery restaurants"
                              >
                              <label for="styled-checkbox-4 activity-05">Delivery</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-5 activity-06" name="restaurantList" type="checkbox" value="takeout restaurants"
                              >
                              <label for="styled-checkbox-5 activity-06">Takeout</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-05 activity-07" name="restaurantList" type="checkbox" value="giftcard restaurants"
                              >
                              <label for="styled-checkbox-05 activity-07">Gift Cards Available</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-005 activity-08" name="restaurantList" type="checkbox" value="table restaurants"
                              >
                              <label for="styled-checkbox-005 activity-08">Table Service</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-105 activity-09" name="restaurantList" type="checkbox" value="Creditcards restaurants"
                              >
                              <label for="styled-checkbox-105 activity-09">Accepts Credit Cards</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-205 activity-10" name="restaurantList"  type="checkbox" value="family restaurants"
                              >
                              <label for="styled-checkbox-205 activity-10">Family style</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-305 activity-11" name="restaurantList" type="checkbox" value="wifi restaurants"
                              >
                              <label for="styled-checkbox-305 activity-11">Free Wifi</label>
                            </li>
                          </ul>
                          <!-- <a href="#" class="show_more">
                            Show All
                          </a> -->
                        </div>
                      </div>

                      <hr>
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          Meals
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered" id="restaurantList">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-7 activity-12" name="restaurantList" type="checkbox" value="breakfast"
                              >
                              <label for="styled-checkbox-7 activity-12">Breakfast</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-8 activity-13"  name="restaurantList" type="checkbox" value="brunch"
                              >
                              <label for="styled-checkbox-8 activity-13">Brunch</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-07 activity-14" name="restaurantList" type="checkbox" value="lunch"
                              >
                              <label for="styled-checkbox-07 activity-14">Lunch</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-08 activity-15" type="checkbox" value="dinner"
                              >
                              <label for="styled-checkbox-08 activity-15">Dinner</label>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <hr>
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          Cuisine
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered" id="restaurantList">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-71 activity-16" name="restaurantList" type="checkbox" value="american"
                              >
                              <label for="styled-checkbox-71 activity-16">American </label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-81 activity-17" name="restaurantList" type="checkbox" value="asian"
                              >
                              <label for="styled-checkbox-81 activity-17">Asian</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-071 activity-18" name="restaurantList"  type="checkbox" value="chinese"
                              >
                              <label for="styled-checkbox-071 activity-18">Chinese</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0811 activity-19" name="restaurantList" type="checkbox" value="australian"
                              >
                              <label for="styled-checkbox-0811 activity-19">Australian</label>
                            </li>
                          </ul>
                          <ul class="unstyled centered new_cuisine" id="restaurantList" style="display:none;">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-711 activity-20" name="restaurantList" type="checkbox" value="italian"
                              >
                              <label for="styled-checkbox-711 activity-20">Italian </label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-812 activity-21" name="restaurantList" type="checkbox" value="indian"
                              >
                              <label for="styled-checkbox-812 activity-21">Indian</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0712 activity-22" name="restaurantList"  type="checkbox" value="french"
                              >
                              <label for="styled-checkbox-0712 activity-22">French</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0813 activity-23" name="restaurantList" type="checkbox" value="japanese"
                              >
                              <label for="styled-checkbox-0813 activity-23">Japanese</label>
                            </li>
                          </ul>
                          <a href="javascript:void(0);" class="show_more show_text">
                            Show more
                          </a> 
                        </div>
                      </div>
                      <hr>
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          Price
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered" id="restaurantList">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-72 activity-24" name="restaurantList" type="checkbox" value="cheap eats">
                              <label for="styled-checkbox-72 activity-24">Cheap Eats </label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-82 activity-25" name="restaurantList" type="checkbox" value="mid range"
                              >
                              <label for="styled-checkbox-82 activity-25"> Mid-range</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-072 activity-26"  name="restaurantList" type="checkbox" value="fine dining"
                              >
                              <label for="styled-checkbox-072 activity-26"> Fine Dining</label>
                            </li>

                          </ul>

                        </div>
                      </div>
                      <hr>
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          Dishes
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered" id="restaurantList">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-73 activity-27" name="restaurantList" type="checkbox" value="salad">
                              <label for="styled-checkbox-73 activity-27">Salad</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-83 activity-28" name="restaurantList" type="checkbox" value="fish"
                              >
                              <label for="styled-checkbox-83 activity-28">Fish</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-073 activity-29" name="restaurantList" type="checkbox" value="beef"
                              >
                              <label for="styled-checkbox-073 activity-29">Beef</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-083 activity-30" name="restaurantList" type="checkbox" value="pork"
                              >
                              <label for="styled-checkbox-083 activity-30">Pork</label>
                            </li>
                          </ul>
                         <!--  <a href="#" class="show_more">
                            Show All
                          </a> -->
                        </div>
                      </div>
                      <hr>
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          Good for
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered" id="restaurantList">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-74 activity-31" name="restaurantList" type="checkbox" value="child friendly">
                              <label for="styled-checkbox-74 activity-31">Child-friendly</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-84 activity-32" name="restaurantList" type="checkbox" value="kids"
                              >
                              <label for="styled-checkbox-84 activity-32">Kids</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-074 activity-33" name="restaurantList" type="checkbox" value="bar scene"
                              >
                              <label for="styled-checkbox-074 activity-33"> Bar Scene</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-084 activity-34"  name="restaurantList" type="checkbox" value="groups"
                              >
                              <label for="styled-checkbox-084 activity-34">Groups</label>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <hr>
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          Dietary Restrictions
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered"  id="restaurantList">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-75 activity-35"  name="restaurantList" type="checkbox" value="vegetarian">
                              <label for="styled-checkbox-75 activity-35">Vegetarian Friendly</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-85 activity-36" name="restaurantList" type="checkbox" value="vegan"
                              >
                              <label for="styled-checkbox-85 activity-36">Vegan Options</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-075 activity-37" name="restaurantList"  type="checkbox" value="halal"
                              >
                              <label for="styled-checkbox-075 activity-37">Halal</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-085 activity-38" name="restaurantList" type="checkbox" value="kosher"
                              >
                              <label for="styled-checkbox-085 activity-38">Kosher</label>
                            </li>
                          </ul>
                          <!-- <a href="#" class="show_more">
                            Show All
                          </a> -->
                        </div>
                      </div>
                      <hr>
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          Neighbourhoods: 
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered"  id="restaurantList">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-753 activity-39" name="restaurantList" type="checkbox" value="downtown">
                              <label for="styled-checkbox-753 activity-39">Downtown <?php echo $_SESSION['city_name']; ?></label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-853 activity-40" name="restaurantList" type="checkbox" value="soma"
                              >
                              <label for="styled-checkbox-853 activity-40">SoMa</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0753 activity-41" name="restaurantList" type="checkbox" value="mission district"
                              >
                              <label for="styled-checkbox-0753 activity-41">Mission District</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0853 activity-42" name="restaurantList" type="checkbox" value="theater district"
                              >
                              <label for="styled-checkbox-0853 activity-42">Theater District</label>
                            </li>
                          </ul>
                       <!--    <a href="#" class="show_more">
                            Show All
                          </a> -->
                        </div>
                      </div>
                      <hr>
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          MICHELIN Guide
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered" id="restaurantList">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-754 activity-43" name="restaurantList" type="checkbox" value="MICHELIN guide">
                              <label for="styled-checkbox-754 activity-43">MICHELIN Guide </label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-854 activity-44" name="restaurantList" type="checkbox" value="MICHELIN 1 Star"
                              >
                              <label for="styled-checkbox-854 activity-44">MICHELIN 1 Star</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0754 activity-45" name="restaurantList" type="checkbox" value="MICHELIN 2 Stars"
                              >
                              <label for="styled-checkbox-0754 activity-45">MICHELIN 2 Stars</label>
                            </li>
                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0854 activity-46" name="restaurantList" type="checkbox" value="MICHELIN 3 Stars"
                              >
                              <label for="styled-checkbox-0854 activity-46">MICHELIN 3 Stars</label>
                            </li>
                          </ul>
                          <!-- <a href="#" class="show_more">
                            Show All
                          </a> -->
                        </div>
                      </div>
                      <hr>
                      <div class="filter_box">
                        <h5 class="filter-heading">
                          Airports
                        </h5>
                        <div class="filter_data">
                          <ul class="unstyled centered">

                            <li>
                              <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-755 activity-47" type="checkbox" name="restaurantList" value="<?php echo $_SESSION['city_name']; ?> Intl Airport">
                              <label for="styled-checkbox-755 activity-47"><?php echo $_SESSION['city_name']; ?> Intl Airport</label>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
					<div class="sidebar-listing">
						<div class="specialities-checkbox">
							<div class="searcher-sec">
								<label class="custom-control-label">Search By Name</label>
								<div class="form-group">
									<input type="Name" class="form-control horizontal_yelp_content new_yelp_Content_cust" id="search-yelp-horizontal" placeholder="New York NY, USA" value="<?php echo $_SESSION['city_name']; ?>">
                  <div id="suggesstion-box"></div>
                </div>
							</div>
						</div>
						<div class="specialities-checkbox" id="restaurantList">
							<div class="listing-check">
								<h4>ESTABLISHMENT TYPE</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity  restaurantName" name="restaurantList" id="customCheck01" value="Restaurants">
								  <label class="custom-control-label" for="customCheck01">Restaurant</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity  restaurantName" name="restaurantList" id="customCheck02" value="quick-bites">
								  <label class="custom-control-label" for="customCheck02">Quick Bites</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity  restaurantName" name="restaurantList" id="customCheck03" value="dessert">
								  <label class="custom-control-label" for="customCheck03">Dessert</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity  restaurantName" name="restaurantList" id="customCheck04" value="cafes">
								  <label class="custom-control-label" for="customCheck04">Coffee & Tea</label>
								</div>
							</div>
							<div class="listing-check">
								<h4>RESTAURANT FEATURES</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck05" name="restaurantList" value="delivery restaurants" >
								  <label class="custom-control-label" for="customCheck05">Delivery</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck06" name="restaurantList" value="takeout restaurants">
								  <label class="custom-control-label" for="customCheck06">Takeout</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck07" name="restaurantList" value="giftcard restaurants">
								  <label class="custom-control-label" for="customCheck07">Gift Cards Available</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck08" name="restaurantList" value="table restaurants">
								  <label class="custom-control-label" for="customCheck08">Table Service</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck09" name="restaurantList" value="Creditcards restaurants">
								  <label class="custom-control-label" for="customCheck09">Accepts Credit Cards</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck10" name="restaurantList" value="family restaurants">
								  <label class="custom-control-label" for="customCheck10">Family style</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck11" name="restaurantList" value="wifi restaurants">
								  <label class="custom-control-label" for="customCheck11">Free Wifi</label>
								</div>
							</div>
							<div class="listing-check">
								<h4>Meals</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck12" name="restaurantList" value="breakfast">
								  <label class="custom-control-label" for="customCheck12">Breakfast</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck013" name="restaurantList" value="brunch">
								  <label class="custom-control-label" for="customCheck013">Brunch</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck14" name="restaurantList" value="lunch">
								  <label class="custom-control-label" for="customCheck14">Lunch</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck15" name="restaurantList" value="dinner">
								  <label class="custom-control-label" for="customCheck15">Dinner</label>
								</div>

							</div>
							<div class="listing-check">
								<h4>CUISINE</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck16" name="restaurantList" value="american">
								  <label class="custom-control-label" for="customCheck16">American</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck17" name="restaurantList" value="asian">
								  <label class="custom-control-label" for="customCheck17">Asian</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck18" name="restaurantList" value="chinese">
								  <label class="custom-control-label" for="customCheck18">Chinese</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck19" name="restaurantList" value="australian">
								  <label class="custom-control-label" for="customCheck19">Australian</label>
								</div><div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck19" name="restaurantList" value="maxican">
								  <label class="custom-control-label" for="customCheck19">Maxican</label>
								</div><div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck19" name="restaurantList" value="japanese">
								  <label class="custom-control-label" for="customCheck19">Japanese</label>
								</div><div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck19" name="restaurantList" value="thai">
								  <label class="custom-control-label" for="customCheck19">Thai</label>
								</div><div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck19" name="restaurantList" value="italian">
								  <label class="custom-control-label" for="customCheck19">Italian</label>
								</div>
								<a href="javascript:void(0)" class=""  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-cuisine">View all
							</div>
							<div class="listing-check">
								<h4>Price</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck20" name="restaurantList" value="cheap eats">
								  <label class="custom-control-label" for="customCheck20">Cheap Eats</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck21" name="restaurantList" value="mid range">
								  <label class="custom-control-label" for="customCheck21">Mid-range</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck22" name="restaurantList" value="fine dining">
								  <label class="custom-control-label" for="customCheck22">Fine Dining</label>
								</div>
							</div>
							<div class="listing-check">
								<h4>DISHES</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck23" name="restaurantList" value="salad">
								  <label class="custom-control-label" for="customCheck23">Salad</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck24" name="restaurantList" value="fish">
								  <label class="custom-control-label" for="customCheck24">Fish</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck25" name="restaurantList" value="beef">
								  <label class="custom-control-label" for="customCheck25">Beef</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck26" name="restaurantList" value="pork">
								  <label class="custom-control-label" for="customCheck26">Pork</label>
								</div>
							</div>
							<div class="listing-check">
								<h4>GOOD FOR</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck23" name="restaurantList" value="child friendly">
								  <label class="custom-control-label" for="customCheck23">Child-friendly</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck24" name="restaurantList" value="kids">
								  <label class="custom-control-label" for="customCheck24">Kids</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck25" name="restaurantList" value="bar scene">
								  <label class="custom-control-label" for="customCheck25">Bar Scene</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck26" name="restaurantList" value="groups">
								  <label class="custom-control-label" for="customCheck26">Groups</label>
								</div>
							</div>
							<div class="listing-check">
								<h4>DIETARY RESTRICTIONS</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck23" name="restaurantList" value="vegetarian">
								  <label class="custom-control-label" for="customCheck23">Vegetarian Friendly</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck24" name="restaurantList" value="vegan">
								  <label class="custom-control-label" for="customCheck24">Vegan Options</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck25" name="restaurantList" value="halal">
								  <label class="custom-control-label" for="customCheck25">Halal</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck26" name="restaurantList" value="kosher">
								  <label class="custom-control-label" for="customCheck26">Kosher</label>
								</div>
							</div>
							<div class="listing-check">
								<h4>NEIGHBOURHOODS</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck27" name="restaurantList" value="downtown">
								  <label class="custom-control-label" for="customCheck27">Downtown New York</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck28" name="restaurantList" value="soma">
								  <label class="custom-control-label" for="customCheck28">Soma</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck29" name="restaurantList" value="mission district"> 
								  <label class="custom-control-label" for="customCheck29">Mission District</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck30" name="restaurantList" value="theater district">
								  <label class="custom-control-label" for="customCheck30">Theater District</label>
								</div>
							</div>
							<div class="listing-check">
								<h4>MICHELIN GUIDE</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck31" name="restaurantList" value="MICHELIN guide">
								  <label class="custom-control-label" for="customCheck31">MICHELIN Guide</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck32" name="restaurantList" value="MICHELIN 1 Star">
								  <label class="custom-control-label" for="customCheck32">MICHELIN 1 Star</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck33" name="restaurantList" value="MICHELIN 2 Stars">
								  <label class="custom-control-label" for="customCheck33">MICHELIN 2 Stars</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck34" name="restaurantList" value="MICHELIN 3 Stars">
								  <label class="custom-control-label" for="customCheck34">MICHELIN 3 Stars</label>
								</div>
							</div>
							<div class="listing-check">
								<h4>AIRPORTS</h4>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input restaurantName" id="customCheck35" name="restaurantList" value="<?php echo $_SESSION['city_name']; ?> Intl Airport">
								  <label class="custom-control-label" for="customCheck35"><?php echo $_SESSION['city_name']; ?> Intl Airport</label>
								</div>
							</div>
						</div>
						
						<div class="adver-comedy rest-adv">
            <a href="https://www.dpbolvw.net/click-8265264-15090738" target="_top">
                <img src="/images/restaurant-ad.png" width="300" height="600" alt="">
              </a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
					<div class="white-box-area inner rest-deals">
						<div class="row">
							<div class="col-md-12 col-12">
								<div class="heading-content">
									<div class="content-sec">
									<h4>Delivery Available</h4>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-12">
								<section class="client-sec comedy">
									<div class="testimonial-section products">
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio">
											
                     <?php   
                      $delievery = yelp_api_call('10',$_SESSION['city_name'],'delivery restaurants');
                      $count=0;
                      foreach ($delievery as $homeData){
                        $tour_image = $homeData->image_url;
                        $tour_rating = $homeData->rating;
                        $tour_id = $homeData->id;
                        $tour_review_count = $homeData->review_count;
                        if($count%2==0){
                            $dataaos="zoom-in-left";
                        }else{
                            $dataaos="zoom-in-right";
                        }
                        ?>
                        <div data-aos="<?php echo $dataaos;?>" class="testimonial-block product">
                          <a href="<?php echo $homeData->url; ?>" target="_blank">
                            <div class="discount-block">
                              
                                <img src="<?php echo $tour_image; ?>">
                              <div class="discount-content">
                                <h3><?php echo substr($homeData->name, 0, 20); ?></h3>
                                <div class="stars">
                                <ul>
                                  <?php for($x=1;$x<=$tour_rating;$x++): ?>
                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                  <?php endfor; ?>
                                  </ul>
                                  <p  class="reviews yelpuser-review"  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
                                    (<?php echo $tour_review_count; ?> Reviews)
                                  </p>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>
                      <?php 
                    $count++;} ?>
									   </div>
									</div>
									
									<div class="testimonial-section products">
										<div class="head-yelp">
											<h3> <?php echo $_SESSION['city_name']; ?> by Food </h3>
										</div>
									  <div class="owl-carousel owl-theme" id="ProductSlide-audio2">
                      <div data-aos="zoom-in-left" class="testimonial-block product restFoood" id="Mexican">
												<div class="discount-block">
													<img src="images/mexican-cuisine.jpg">
													<div class="discount-content">
														<h3>MEXICAN</h3>
													</div>
												</div>
											</div>
                      <div data-aos="zoom-in-right" class="testimonial-block product  restFoood" id="Lunch">
												<div class="discount-block">
													<img src="images/lunchnew.jpg">
													<div class="discount-content">
														<h3>Lunch</h3>
													</div>
												</div>
											</div>
                      <div data-aos="zoom-in-left" class="testimonial-block product  restFoood" id="Cheap Eats">
												<div class="discount-block">
													<img src="images/cheapeat.jpg">
													<div class="discount-content">
														<h3>Cheap Eats</h3>
													</div>
												</div>
											</div>
                      <div data-aos="zoom-in-right" class="testimonial-block product restFoood" id="Coffee & Tea">
												<div class="discount-block">
													<img src="images/coffytea.jpg">
													<div class="discount-content">
														<h3>Coffee & Tea</h3>
													</div>
												</div>
											</div>
                      <div data-aos="zoom-in-left" class="testimonial-block product restFoood" id="Seafood">
												<div class="discount-block">
													<img src="images/seafoodnew.jpg">
													<div class="discount-content">
														<h3>Seafood</h3>
													</div>
												</div>
											</div>
                      <div data-aos="zoom-in-right" class="testimonial-block product restFoood" id="Breakfast">
												<div class="discount-block">
													<img src="images/brkfirstImg.jpg">
													<div class="discount-content">
														<h3>Breakfast</h3>
													</div>
												</div>
											</div>
											<div data-aos="zoom-in-left" class="testimonial-block product restFoood" id="Chinese">
												<div class="discount-block">
													<img src="images/chinese-cuisine.jpg">
													<div class="discount-content">
														<h3>Chinese</h3>
													</div>
												</div>
											</div>
											<div data-aos="zoom-in-right" class="testimonial-block product restFoood" id="Italian">
												<div class="discount-block">
													<img src="images/italian-cuisine.jpg">
													<div class="discount-content">
														<h3>Italian</h3>
													</div>
												</div>
											</div>
											<div data-aos="zoom-in-left" class="testimonial-block product restFoood" id="Pizza">
												<div class="discount-block city">
													<img src="images/pizza-cuisine.jpg">
													<div class="discount-content">
														<h3>Pizza</h3>
													</div>
												</div>					  
											</div>
                      <div data-aos="zoom-in-right" class="testimonial-block product restFoood" id="Barbeque">
												<div class="discount-block city">
													<img src="images/barbecue-beef.jpg">
													<div class="discount-content">
														<h3>Barbeque</h3>
													</div>
												</div>					  
											</div>
									   </div>
									  </div>
									
									<div class="testimonial-section products restFoood" id="Fine Dining">
										<div class="head-yelp">
											<h3>Fine Dining</h3>
										</div>
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio3">
                      <?php   
                          $fineDining = yelp_api_call('10',$_SESSION['city_name'],'fine dining');
                          $count=0;
                          foreach ($fineDining as $homeData){
                            $fineDining_image = $homeData->image_url;
                            $tour_rating = $homeData->rating;
                            $tour_id = $homeData->id;
                            $fineDining_count = $homeData->review_count;
                            if($count%2==0){
                              $dataaos="zoom-in-left";
                              }else{
                                  $dataaos="zoom-in-right";
                              }
                            ?>
                            <div data-aos="<?php echo $dataaos;?>" class="testimonial-block product">
                            <a href="<?php echo $homeData->url; ?>" target="_blank">
                              <div class="discount-block">
                                <img src="<?php echo $fineDining_image; ?>">
                                <div class="discount-content">
                                  <h3><?php echo substr($homeData->name, 0, 20); ?></h3>
                                    <div class="stars">
                                      <ul>
                                        <?php for($x=1;$x<=$tour_rating;$x++): ?>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <?php endfor; ?>
                                      </ul>
                                      <p  class=""  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
                                      (<?php echo $fineDining_count; ?> Reviews)
                                      </p>
                                    </div>
                                </div>
                              </div>
                            </a>
                          </div>
                    <?php 
                  $count++;} ?>
									   </div>
									</div>
									
									<div class="testimonial-section products">
										<div class="head-yelp">
											<h3>Moderately Priced</h3>
										</div>
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio4">
											
											
                     <?php
                        $moderately = yelp_api_call('10',$_SESSION['city_name'],'moderately priced restaurants');
                        $count=0;
                        foreach ($moderately as $moderValue){
                          $moderately_image = $moderValue->image_url;
                          $tour_rating = $moderValue->rating;
                          $tour_id = $moderValue->id;
                          $moderately_count = $moderValue->review_count;
                          if($count%2==0){
                            $dataaos="zoom-in-left";
                            }else{
                                $dataaos="zoom-in-right";
                            }
                          ?>
                          <div data-aos="<?php echo $dataaos;?>" class="testimonial-block product">
                            <a href="<?php echo $moderValue->url; ?>" target="_blank">
                              <div class="discount-block">
                                <img src="<?php echo $moderately_image; ?>">
                              <div class="discount-content">
                                <h3><?php echo substr($moderValue->name, 0, 20); ?></h3>
                                <div class="stars">
                                  <ul>
                                  <?php for($x=1;$x<=$tour_rating;$x++): ?>
                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                  <?php endfor; ?>
                                  </ul>
                                  <p  class=""  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
                                    (<?php echo $moderately_count; ?> Reviews)
                                  </p>

                                </div>

                              </div>
                            </a>
                            </div>
                          </div>

                        <?php 
                      $count++;} ?>
											
									   </div>
									</div>
									
									<div class="testimonial-section products">
										<div class="head-yelp">
											<h3>Cheap Eats</h3>
										</div>
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio5">
											
											
                     <?php
                     $count=0;
                    $cheap = yelp_api_call('10',$_SESSION['city_name'],'cheap eats');
                    foreach ($cheap as $cheapValue){
                      $cheap_image = $cheapValue->image_url;
                      $tour_rating = $cheapValue->rating;
                      $tour_id = $cheapValue->id;
                      $cheap_count = $cheapValue->review_count;
                      if($count%2==0){
                        $dataaos="zoom-in-left";
                        }else{
                        $dataaos="zoom-in-right";
                      }
                      ?>
                      <div data-aos="<?php echo $dataaos;?>" class="testimonial-block product">
                        <a href="<?php echo $cheapValue->url; ?>" target="_blank">
                        <div class="discount-block">
                          <img src="<?php echo $cheap_image; ?>" class="img-fluid w-100">
                        <div class="discount-content">
                          <h3><?php echo substr($cheapValue->name, 0, 20); ?></h3>
                          <div class="stars">
                            <ul>
                            <?php for($x=1;$x<=$tour_rating;$x++): ?>
                              <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            <?php endfor; ?>
                            </ul>
                            <p  class=""  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
                              (<?php echo $cheap_count; ?> Reviews)
                            </p>
                            
                          </div>
                        </div>
                      </a>
                      </div>
                    </div>
                  <?php 
                $count++;} ?>
											
									   </div>
									</div>
									
									<div class="testimonial-section products">
										<div class="head-yelp">
											<h3>Breakfast</h3>
										</div>
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio6">
                     <?php
                     $count=0;
                            $breakfast = yelp_api_call('10',$_SESSION['city_name'],'breakfast');
                            foreach ($breakfast as $breakfastValue){
                              $breakfast_image = $breakfastValue->image_url;
                              $tour_rating = $breakfastValue->rating;
                              $tour_id = $breakfastValue->id;
                              $breakfast_count = $breakfastValue->review_count;
                              if($count%2==0){
                                $dataaos="zoom-in-left";
                                }else{
                                $dataaos="zoom-in-right";
                              }
                              ?>
                              <div data-aos="<?php echo $dataaos;?>" class="testimonial-block product">
                                <a href="<?php echo $breakfastValue->url; ?>" target="_blank">
                                <div class="discount-block">
                                  <img src="<?php echo $breakfast_image; ?>">
                                <div class="discount-content">
                                <h3><?php echo substr($breakfastValue->name, 0, 20); ?></h3>
                                <div class="stars">
                                  <ul>
                                  <?php for($x=1;$x<=$tour_rating;$x++): ?>
                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                  <?php endfor; ?>
                                  </ul>
                                  <p  class="reviews yelpuser-review"  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
                                  (<?php echo $breakfast_count; ?> Reviews)
                                  </p>
                                
                              </div>
                            </div>
                          </a>
                          </div>
                        </div>
                        <?php 
                      $count++;} ?>

									   </div>
									</div>
									
									<div class="filter_head sort-display-sec">
                    <div class="heading mb-0">
                      <h4><span class="count"></span> Restaurants in <?php echo $_SESSION['city_name'] ?>. Displaying 1–10</h4>
                    </div>
                    <div class="custom-select-box">
                     <!-- <a href="#"><i class="fas fa-bars"></i></a>
                      <a href="#"><i class="fas fa-th-large"></i></a>-->
                      <span>Sort
                      </span>
                      <select class="form-select" aria-label="Default select example">
                        <option selected="">Best Value</option>
                        <option value="1">Value</option>
                      </select>
                    </div>
                  </div>
								</section>
							</div>
							
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4">
                <input type="hidden" id="fullCityName" value="<?php echo $_SESSION['city_name'] ?>">
                <article id="atrl" class="oneArticle categoty-article inner_rest restaurant" v-html="members"> </article>
                  <div class="accordian_info">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            What are the hotels close to the center of <?php echo $_SESSION['city_name'];?>?
                          </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body"><script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=center&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=hotels.mysittivacations.com%2Fhotels&locale=en&limit=5" charset="utf-8"></script></div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            What are the best pet-friendly hotels in <?php echo $_SESSION['city_name'];?>? 
                          </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body"><script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=pets&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=hotels.mysittivacations.com%2Fhotels&locale=en&limit=5&nobooking=" charset="utf-8"></script></div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            What are the best luxury hotels in <?php echo $_SESSION['city_name'];?>?
                          </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body"><script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=luxury&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=hotels.mysittivacations.com%2Fhotels&locale=en&limit=5&nobooking=" charset="utf-8"></script></div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree1">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree1" aria-expanded="false" aria-controls="flush-collapseThree1">
                            What are the top hotels in <?php echo $_SESSION['city_name'];?>? 
                          </button>
                        </h2>
                        <div id="flush-collapseThree1" class="accordion-collapse collapse" aria-labelledby="flush-headingThree1" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body"><script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=tophotels&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=hotels.mysittivacations.com%2Fhotels&locale=en&limit=5&nobooking=" charset="utf-8"></script></div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree2">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree2" aria-expanded="false" aria-controls="flush-collapseThree2">
                            Which hotels have the best ratings in <?php echo $_SESSION['city_name'];?>?
                          </button>
                        </h2>
                        <div id="flush-collapseThree2" class="accordion-collapse collapse" aria-labelledby="flush-headingThree2" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body"><script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=5stars&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=hotels.mysittivacations.com%2Fhotels&locale=en&limit=5&nobooking=" charset="utf-8"></script></div>
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

 	<div class='modal fade bd-example-modal-lg' id='myModal-cuisine'  tabindex="-1" data-focus-on="input:first"  role='dialog' style="top: 18px;">
				<div class='modal-dialog modal-lg'>
					<div class='modal-content guide_modal'>
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalScrollableTitle" style="font-size: 28px;">Adrenaline Rush</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" style="font-size: 36px;padding: 16px;">&times;</span>
							</button>
						</div>
						<div class="audio_tour_modal">
							<ul class="us-city-popupd row">
							<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Restaurants" data-dismiss='modal'>Restaurants</li>
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Delis" data-dismiss='modal'>Delis</li>
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Caribbean" data-dismiss='modal'>Caribbean</li>
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Food Stands" data-dismiss='modal'>Food Stands</li>
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Food" data-dismiss='modal'>Food</li>
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Barbeque" data-dismiss='modal'>Barbeque</li>
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Pubs" data-dismiss='modal'>Pubs</li>
							</li>
							<li class="col-sm-3 col-md-3 col-xs-6">
							<input type="checkbox" name="" class="cuisine" value="Beer, Wine & Spirits" data-dismiss='modal'>Beer, Wine & Spirits</li>
							<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Mexican" data-dismiss='modal'>Mexican
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Tacos" data-dismiss='modal'>Tacos
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Diners" data-dismiss='modal'>Diners
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Polish" data-dismiss='modal'>Polish
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Ramen" data-dismiss='modal'>Ramen
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Hot Dogs" data-dismiss='modal'>Hot Dogs
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Sandwiches" data-dismiss='modal'>Sandwiches
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Nightlife" data-dismiss='modal'>Nightlife
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Thai" data-dismiss='modal'>Thai
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Beer Bar" data-dismiss='modal'>Beer Bar
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Bubble Tea" data-dismiss='modal'>Bubble Tea
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Asian Fusion" data-dismiss='modal'>Asian Fusion
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Food Trucks" data-dismiss='modal'>Food Trucks
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="African" data-dismiss='modal'>African
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Buffets" data-dismiss='modal'>Buffets
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Fast Food" data-dismiss='modal'>Fast Food
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Event Planning & Services" data-dismiss='modal'>Event Planning & Services
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Specialty Food" data-dismiss='modal'>Specialty Food
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Buffets" data-dismiss='modal'>Buffets
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Gastropubs" data-dismiss='modal'>Gastropubs
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Greek" data-dismiss='modal'>Greek
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Pizza" data-dismiss='modal'>Pizza
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Breakfast & Brunch" data-dismiss='modal'>Breakfast & Brunch
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Burgers" data-dismiss='modal'>Burgers
							</li>	<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Indian" data-dismiss='modal'>Indian
							</li>	
							<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Soul Food" data-dismiss='modal'>Soul Food
							</li>
								<li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Halal" data-dismiss='modal'>Halal
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Sports Bars" data-dismiss='modal'>Sports Bars
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Italian" data-dismiss='modal'>Italian
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Vegetarian" data-dismiss='modal'>Vegetarian
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Southern" data-dismiss='modal'>Southern
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Pop-Up Restaurants" data-dismiss='modal'>Pop-Up Restaurants
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Chicken Wings" data-dismiss='modal'>Chicken Wings
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Chicken Shop" data-dismiss='modal'>Chicken Shop
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Tapas/Small Plates" data-dismiss='modal'>Tapas/Small Plates
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Waffles" data-dismiss='modal'>Waffles
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Chinese" data-dismiss='modal'>Chinese
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Wine Bars" data-dismiss='modal'>Wine Bars
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Tapas/Small Plates" data-dismiss='modal'>Tapas/Small Plates
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Waffles" data-dismiss='modal'>Waffles
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Coffee & Tea" data-dismiss='modal'>Coffee & Tea
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Steakhouses" data-dismiss='modal'>Steakhouses
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Pakistani" data-dismiss='modal'>Pakistani
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Donuts" data-dismiss='modal'>Donuts
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Seafood" data-dismiss='modal'>Seafood
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="French" data-dismiss='modal'>French
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Cantonese" data-dismiss='modal'>Cantonese
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Food Delivery Services" data-dismiss='modal'>Food Delivery Services
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Middle Eastern" data-dismiss='modal'>Middle Eastern
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Caterers" data-dismiss='modal'>Caterers
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Empanadas" data-dismiss='modal'>Empanadas
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Cafes" data-dismiss='modal'>Cafes
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Soup" data-dismiss='modal'>Soup
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Gluten-Free" data-dismiss='modal'>Gluten-Free
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Caterers" data-dismiss='modal'>Caterers
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Food Court" data-dismiss='modal'>Food Court
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Cafes" data-dismiss='modal'>Cafes
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Cocktail Bars" data-dismiss='modal'>Cocktail Bars
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Vegan" data-dismiss='modal'>Vegan
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Korean" data-dismiss='modal'>Korean
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Noodles" data-dismiss='modal'>Noodles
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Japanese" data-dismiss='modal'>Japanese
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Mediterranean" data-dismiss='modal'>Mediterranean
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Vietnamese" data-dismiss='modal'>Vietnamese
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Cajun/Creole" data-dismiss='modal'>Cajun/Creole
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="New Mexican Cuisine" data-dismiss='modal'>New Mexican Cuisine
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Cuban" data-dismiss='modal'>Cuban
							</li><li class="col-sm-3 col-md-3 col-xs-6">
								<input type="checkbox" name="" class="cuisine" value="Falafel" data-dismiss='modal'>Falafel
							</li>
							</ul>
						</div>
						<div class='modal-footer'>
							<button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
						</div>
					</div>
				</div>
			</div>

<style>
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
.discount-block {
    box-shadow: 0px 0px 10px #0000002b;
    margin: 10px 5px;
}
.discount-block img {
    height: 190px;
    object-fit: cover;
    border-radius: 12px;
}
.testimonial-section.products a {
    text-decoration: none;
}
.discount-block .stars ul{
   padding: 0;     
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
    font-size: 16px;
    font-weight: normal;
    font-family: 'Poppins', sans-serif;
}
.filter_head.sort-display-sec {
    border: 1px solid #fd846b;
}
.rest-deals .accordian_info .accordion-body {
    margin: 30px 0 20px;
    background: #ffe6e1;
    padding: 20px;
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
    min-width: 124px;
    font-family: 'Poppins', sans-serif;
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
    
.testimonial-section .owl-nav button {
    background: #186fbb!important;
}
.client-sec.comedy .testimonial-section .owl-nav {
    margin-left: 10px;
    margin-right: 10px;
    width: calc(100% - 20px);
}
.sort-display-sec .custom-select-box span {
    font-family: 'Poppins', sans-serif;
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-tabs-list__item--checked span.blissey-widget-tabs-list-icon {
    background-color: #5955B3 !important;
    width: 30px !important;
    height: 30px !important;
    background-size: 18px !important;
    border-radius: 50%;
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-tabs-list__item--checked {
    color: #000 !important;
    font-weight: 600 !important;
    background: #5955B333 !important;
    padding: 12px 20px 12px 15px !important;
    border: 1px solid #5955B3 !important;
    line-height: 30px !important;
    font-size: 16px !important;
}
.rest-deals .blissey-widget .blissey-widget-tabs {
    margin-bottom: 15px !important;
}
    
.accordian_info .blissey-widget .blissey-widget-body-hotels-compact-list-item-info .blissey-info-details-specification__hotel_name:hover{
    position: relative !important;
    left:0;
    font-weight: 600!important;
}
.accordian_info .blissey-widget .blissey-widget-body-hotels-compact-list-item-info .blissey-info-details-specification__hotel_name {
    font-family: 'Ubuntu', sans-serif !important;
    font-size: 18px !important;
}
    
    @media (max-width: 480px){
        .blissey-widget {
            display: block;
        }
    }
</style>
<?php if(isset($_REQUEST['food'])){?>
	<script type="text/javascript">
   $( document ).ready(function() {
   var category_name = "<?php echo $_REQUEST['food'] ?>";
   restaurantApi(category_name);
   refreshGrouponApi(category_name);
   var count =$('.total_count').val();
   $('.count').text(category_name);
   $('html, body').animate({
    scrollTop: $("#atrl").offset().top
  }, 2000);
 }); 
</script>
<?php 
}
 ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php if(isset($_SESSION['city_name'])){ ?>
  <script type="text/javascript">
    $( document ).ready(function() {
      $(".show_text").click(function(){
        $(".new_cuisine").toggle();
        var txt = $(".new_cuisine").is(':visible') ? 'Show Less' : 'Show More';
        $(".show_text").text(txt);
      });
      $('body').on('keyup', '#search-yelp-horizontal', function () { 
        var key = $(this).val();
        var city = $('#fullCityName').val();

        $.ajax({
          url: "ajax_yelp_auto1.php",
          type: "POST",
          data: {
            formatteds: key, city: city,
          },
          success: function (res) 
          {  
            console.log(res); 
            $("#suggesstion-box").html('');
            $("#suggesstion-box").show();  
            $("#suggesstion-box").html(res);

          },
        });
      });

      $('body').on('click','#suggesstion-box li' ,function()
      {
        var val = $(this).text();
        $("#search-yelp-horizontal").val(val);
        var new_val = $("#search-yelp-horizontal").val();
        yelpHorizontalSearch(new_val);
        $("#suggesstion-box").hide();   


        $('html, body').animate({
          scrollTop: $("#suggesstion-box").offset().top
        }, 1000);
      })


      function yelpHorizontalSearch(new_val){
        var keyword = $('#search-yelp-horizontal').val();
        var geodemo = $('#target').val();
        var limit = '10';
        if(keyword != '' && keyword != null){
          console.log(keyword);
          $.ajax({
            url: "ajax_yelp_deals_restaurant.php",
            type: "POST",
            data: {
              limit             : limit,
              new_val           : new_val,
              formatted     : geodemo,
              design        : 'Horizontal',
              key           : keyword
            },
            beforeSend: function()
            {
              $("#loader").addClass("loading");
            },
            success: function (response) 
            {
              $('html, body').animate({
                scrollTop: $(".oneArticle").offset().top
              }, 1000);
              $('.oneArticle').html(response);
              $("#loader").removeClass("loading");
            }
          });
        }
        else{
          alert('Please Enter Keyword.')
        }
      }
    });
  </script>

  <script type="text/javascript" charset="utf-8">
    function restaurantApi(key){
   // if ($('#target').val().length === 0) {
    var geodemo = $('#geo-demo').val();
    var fullCityName = $('#fullCityName').val();
    /*}else{
      var geodemo = $('#target').val();
      var fullCityName = $('#fullCityName').val();
    }*/
   // alert(fullCityName);
   $.ajax({
    url: "ajax_yelp_deals_restaurant.php",
    type: "POST",
    data: {
      formatted: fullCityName, 
      key      : key,
      limit    : '10',
      design   : 'Horizontal'
    },
    beforeSend: function()
    {
      $("#loader").addClass("loading");
    },
    success: function (response) 
    {
      $('article#atrl').html(response);
      $(".close").trigger('click');
      $("#loader").removeClass("loading");  
    }
  });
 }

 function refreshGrouponApi(key){
 // if ($('#target').val().length === 0) {
  var geodemo = $('#geo-demo').val();
  var fullCityName = $('#fullCityName').val();
  /*}else{
    var geodemo = $('#target').val();
    var fullCityName = $('#fullCityName').val();
  }*/
  $.ajax({
    url: "ajax_groupon_refresh.php",
    type: "POST",
    data: {
      formatted: fullCityName, 
      key      : key
    },
    beforeSend: function()
    {
      $("#loader").addClass("loading");
    },
    success: function (response) 
    {
      $('.Deals_food').html(response);
      var owl = $(".owl-carousel");
      owl.owlCarousel({
        items: 4,
        navigation: true
      });
      $("#loader").removeClass("loading");
      $('.owl-nav').removeClass('disabled'); 
    }
  });
}

$(document).on('click','.cuisine',function(){
  var category_name = $(this).val();
  // alert(category_name);
  $('#myModal-cuisine').modal({ show: false})
  restaurantApi(category_name);
  var count =$('.total_count').val();
  $('.count').text(category_name);
  $('html, body').animate({
    scrollTop: $("#atrl").offset().top
  }, 2000);
});

$(document).on('click','#restaurantList .restaurantName',function(){
  var category_name = $("input[name='restaurantList']:checked").val();
   $("#filter-popup").modal('hide');
  restaurantApi(category_name);
  var count =$('.total_count').val();
  $('.count').text(category_name);
  $('html, body').animate({
    scrollTop: $("#atrl").offset().top
  }, 2000);
});
$(document).on('click','#zomato-cat-id li',function(){
    // var el =$(this);
    var category_name = this.id;
    // alert(category_name);
    restaurantApi(category_name);
    $('html, body').animate({
      scrollTop: $("#atrl").offset().top
    }, 2000);
  }); 
$( document ).ready(function() {
  $(document).on('click','.restFoood',function(){
   var category_name = $(this).attr('id');
   // alert(category_name);
   restaurantApi(category_name);
   refreshGrouponApi(category_name);
   var count =$('.total_count').val();
   $('.count').text(category_name);
   $('html, body').animate({
    scrollTop: $("#atrl").offset().top
  }, 2000);
 });  });
$(document).on('click','.foood',function(){
    // var el =$(this);
    var category_name = $(this).attr('id');
    restaurantApi(category_name);
    refreshGrouponApi(category_name);
    $('html, body').animate({
      scrollTop: $("#atrl").offset().top
    }, 2000);
  });
$(document).on('click','#zomato-cat-id-pop li',function(){
    // var el =$(this);
    var category_name = this.id;
    $("#cross_food").trigger('click');
    // alert(category_name);
    restaurantApi(category_name);
    $('html, body').animate({
      scrollTop: $("#atrl").offset().top
    }, 2000);
  });
$(document).on("click", ".open-CitiesDialog", function () {
  var el = $(this);
  var modal_link = el.data('info');
  var modal_title = el.data('title');
  var modal_table =el.data('table');
  var modal_trigger =el.data('trigger');
  var modal_api =el.data('api');
  var modal_whereCity =el.data('wherecity');
  var modal_city =el.data('city');
  var modal_affiliationName =el.data('affiliationname');
  var modal_table2 =el.data('table2');
  $.ajax({
    url: "ajax_specific_landingpage.php",
    type: "POST",
    data: {
      modal_link : modal_link,
      modal_title : modal_title,
      modal_trigger : modal_trigger,
      modal_api : modal_api,
      modal_whereCity : modal_whereCity,
      modal_city : modal_city,
      modal_affiliationName : modal_affiliationName,
      modal_table : modal_table,
      modal_table2 : modal_table2
    },
    beforeSend: function()
    {
      $("#modal_loader").addClass("loading");
    },
    success: function (response) 
    {
      $('.modal-content .cities_modal').html("");
      $('.modal-content .cities_modal').html(response);
      $("#modal_loader").removeClass("loading");
    }
  });
});
$(document).on('keydown','#search-yelp-horizontal',function(e){
  var key = e.which;
    if(key == 13)  // the enter key code
    {
      var new_val = $("#search-yelp-horizontal").val();
      yelpHorizontalSearch(new_val);
    } 
  });
$(document).on('click', '#yelp-hitAjaxCity', function(){
  var search_data = $("#search-yelp-horizontal").val();
  var limit = '10';
  if(search_data.length>0){
    var geodemo1 = $('#target').val(); 
    if(geodemo1.length > 0){
     var geodemo = $('#target').val(); 
     var fullCityName = $('#fullCityName').val();
   }else{
     var geodemo = $('#geo-demo').val();
     var fullCityName = $('#fullCityName').val(); 
   }       

   $.ajax({
    url: "ajax_yelp_deals_restaurant.php",
    type: "POST",
    data: {
      new_val  : search_data,
      limit    : limit,
      formatted: fullCityName, 
      key      : search_data,
      design   : 'Horizontal'
    },
    beforeSend: function()
    {
      $("#loader").addClass("loading");
    },
    success: function (response) 
    {
      $('article#atrl').html(response);
      $("#loader").removeClass("loading");    
    }
  });
   return false;

 }else{
  alert('Please enter search Keyword');
}

});

$(document).on("click", ".open-GrouponDialog", function () {
  var el = $(this);
  var modal_info = el.data('info');
  var modal_title = el.data('title');
  var modal_limit =el.data('limit');
  var modal_city =el.data('city');
  var modal_key =el.data('key');
  var modal_url =el.data('url');
  $.ajax({
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
      $("#modal_loader").addClass("loading");
    },
    success: function (response) 
    {
      $('.modal-content .cities_modal').html(response);
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
$(document).ready(function(){
 if( $(window).width() < 640 ) {
  $("#plus").show();
  $(".hotel-side").hide();

  $("#plus").click(function(){
    $(".hotel-side").slideDown("show");
    $("#plus").hide();
    $("#minus").show();
  });

  $("#minus").click(function(){
    $(".hotel-side").slideUp("hide");
    $("#plus").show();
    $("#minus").hide();
  });

  $(".mobile-res").show(); 
      // $(".desktop-res").hide();
      $("#local-rest").show();
    }  
  }); 
$(function(){
  $(document.body).on('click', '.vewmenu', function(){  
    var res_id = $(this).attr('data-id');

    $.ajax({
      type: 'POST',
      url: 'ajax_review_data.php',
      data: {rest_id: res_id},
      beforeSend: function()
      {
        $("#loader").addClass("loading");
      },
      success: function(data) {
        $('.modal-body').html(data);
        $("#loader").removeClass("loading");
      }
    });
  });
}); 
$(document).on('click','.load_more_yelps',function(){
  var limits = $(this).attr('data-id');
  var limit = +limits+10;
  var keyss = $(this).attr('data-key');
  if(keyss != ''){
    var key = $(this).attr('data-key');
  }else{
    var key = "Cheap Eats";
  }
  var formatted = "<?php echo $_SESSION['city_name'] ?>";
  $.ajax({
    type: 'POST',
    url: 'ajax_thing_yelps_restaurant.php',
    data: {limit: limit, key:key, formatted:formatted},
    beforeSend: function()
    {
      $("#loader").addClass("loading");
    },
    success: function(data) {
      $('.oneArticle').html(data);
      $("#loader").removeClass("loading");
    }
  });
});
$(document).on('click','.load_more_search',function(){
  var limits = $(this).attr('data-id');
  var limit = +limits+10;
  var key = $('#search-yelp-horizontal').val();
  if(key == '' || key == undefined){
    var key = $(this).attr('data-key');
  }
  var formatted = "<?php echo $_SESSION['city_name'] ?>";
  $.ajax({
    type: 'POST',
    url: 'ajax_thing_yelps_restaurant.php',
    data: {limit: limit, key:key, formatted:formatted},
    beforeSend: function()
    {
      $("#loader").addClass("loading");
    },
    success: function(data) {
      $('.oneArticle').html(data);
      $("#loader").removeClass("loading");
    }
  });
});
$(document).ready(function() {
  $('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
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
<?php } ?>
<?php  include('blog-resources-new.php');?>
<?php include('footer-newfile.php'); ?>
</body>
</html>

<style>

.desktop-filter {display: block;}
.mobile-filter {display: none;}
.image_htfix_mid img {object-fit: cover !important;}
.rind-the-right-section.comedy-sec .sidebar-listing {display: block;}
.filter_box_main_mobile {display: none;}
@media screen and (max-width:767px){
  .desktop-filter {display: none;}
  .mobile-filter {display: block;}
  .content-bannersss { width: 100%;}
  section.category li {width: 47%;margin: 0 8px 0 0;}
  section.category li a {font-size: 14px;}
  section.inner_page_hero.sec_pad {min-height: 15rem;display: flex;align-items: center;padding: 0;}
  section.category h4 {margin-bottom: 30px;}
  section.category {margin: 40px 0 40px;}
  .resturant_listhead .sorf-filter a {display: none;}
  .sorf-filter span {margin: 0 10px 0 0px;}
  .add_img {display: none;}
  .image_htfix_mid {height: 200px !important;}
  .image_htfix_mid img {object-fit: cover !important;}
  .heading h4 {font-size: 28px;}
  .restFoood img{height:200px;}
  #cool_flight .owl-dots, .resturantclient .owl-dots, .foodtype .owl-dots {margin: 10px 0 0!important;}
  .owl-dots {margin: 10px 0 0px!important;}
  .image_sq_htfix {height: 200px;}
  .slider_nav .owl-nav.disabled {display: flex;margin: 0;}
  .heading p {padding-left: 0px;}
  .heading {margin-bottom: 30px;}
  #our_blogs {padding: 50px 0;}
  .hero_section_content h2 {font-size: 24px;line-height: 42px;margin: 0 0 0px !important;}
  .general_nav#myHeader .check_class, .geo.geocontrast {font-size: 16px;border-radius: 4px;}
  #hitAjaxwithCity {right: 3px;top: 13px;width: 42px!important;background: #276ab5;padding: 13px;border-radius: 4px 4px;}
  .mobile-filter ul {display: flex;align-items: center;justify-content: space-around;flex-wrap: wrap;margin: 0;padding: 0;}
  .mobile-filter ul li a {font-size: 16px;margin: 0;width: 100%;    border-radius: 8px;}
  .mobile-filter ul li a i {margin: 0 10px 0 0px;}
  .mobile-filter {border-top: 1px solid #ccc;padding: 10px 0 0px;border-bottom: 0; margin: 0;}
  .mobile-filter ul li {width: 50%;text-align: center;border-right: 1px solid #ccc;padding: 5px;}
  .mobile-filter ul li:last-child {border: 0;}
  .filter_box {padding-right: 0px;}
  h5.filter-heading {margin-bottom: 20px;}
  /*.testimonial-section .owl-nav button {background: transparent !important;}*/
  .filter_head div:nth-child(1) {width: 100%;    margin: 0 !important;}
  .sort-display-sec .custom-select-box {margin: 10px auto 0;}
  .blissey-widget--s .blissey-widget-body-hotels-compact-list-item-info {margin: 0 0 0 0px!important;}
  .blissey-widget--s .blissey-widget-body-hotels-compact-list-item-info .blissey-info-price {margin: 10px 0 10px 0px!important;display: flex !important;flex-wrap: wrap;}
  .blissey-widget .blissey-info-price-wrapper {width: 100% !important;}
  .blissey-widget--m .blissey-widget-body-hotels-compact-list-item-gallery, .blissey-widget--s .blissey-widget-body-hotels-compact-list-item-gallery {margin-right: 0px!important;
    width: 100%!important;}
    .blissey-widget--s .blissey-widget-body-hotels-compact-list-item-info .blissey-info-price-wrapper__total {margin-bottom: 0px!important;text-align: left !important;}
    .blissey-widget .blissey-info-price-wrapper-discount {text-align: left !important;}
    .blissey-widget .blissey-info-price-wrapper__text {text-align: left !important;}
    .blissey-widget--s .blissey-widget-body-hotels-compact-list-item-info .blissey-info-price-wrapper-button {position: relative !important;width: 100% !important;margin: 10px 0 0 !important;}
    .rest-deals .accordian_info .blissey-widget .blissey-info-price-wrapper-button a {width: 100%; text-align: center !important;line-height: 40px !important;height: 40px !important;}
    .filter_box_main_mobile {padding: 15px;border: 1px solid #f3f3f3;border-radius: 20px;background: #fbfbfb;display: block;}
    .filter_box_main_mobile .search input {box-shadow: none;border-radius: 30px;font-size: 14px;height: 50px;padding: 0 0px;border: 1px solid #ced4da;margin: 0 0 15px;}
		.filter_box_main_mobile .yelp_searcch_box.search {box-shadow: none;}
		.rind-the-right-section.comedy-sec .sidebar-listing {display: none;}
		.filter_data li { margin: 5px 0;}
		.styled-checkbox+label {position: relative;cursor: pointer;display: flex;align-items: center;font-size: 14px;color: #848484;font-weight: 300;padding: 0;width: 90%;}
		.styled-checkbox+label:before {content: "";margin-right: 10px;display: inline-block;vertical-align: text-top; width: 13px;height: 13px;background: #fff;box-shadow: none;    border: 1px solid #ccc !important;border-radius: 3px !important;}
		.filter-sec {background: transparent;}
}
</style>
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
	
	$('#ProductSlide-audio3').owlCarousel({
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
	$('#ProductSlide-audio4').owlCarousel({
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
	$('#ProductSlide-audio5').owlCarousel({
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
	$('#ProductSlide-audio6').owlCarousel({
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