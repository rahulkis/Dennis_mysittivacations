<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
 /* ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);*/
  // include("Query.Inc.php");
  // $Obj = new Query($DBName);
  // require_once 'Mobile_Detect.php';
  // $detect = new Mobile_Detect;
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
  if(!isset($_SESSION['city_name'])){
    header('location:https://mysittivacations.com/');
  }if(isset($_SESSION['city_name'])){
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
  <?php include("header-new.php"); ?>
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
  </style>
  <body>
    <div class="v2_content_inner2">
      <div id="loader"></div>
      <span class='update-zero' style="display: none;">0</span> 
    </div>
    <?php //include("includes/menu.php"); ?>
    <!--end of navbar section-->
    <section class="inner_page_hero sec_pad resturent-sec">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="hero_section_content">
              <h2 class="mb-5">Restaurants in <?php echo $_SESSION['city_name'];?></h2>
            </div>
          </div>
          <div class="col-lg-12">
           <div class="content-bannersss">
            <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

            <input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>" required="">

            <a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><img src="/css/optimize/images/search.png" alt=""></a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--end of hero section-->
  <?php include('category-navigation.php'); ?>
  <!--end of category section-->
  <!-- product listing section -->
  <section class="sec_pad filter-sec">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
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
            <div class="desktop-filter">
              <hr>
              <div class="filter_box">
                <h5 class="filter-heading">
                  Establishment Type
                </h5>
                <div class="filter_data">
                  <ul class="unstyled centered" id="restaurantList"> 
                    <li>
                      <input class="styled-checkbox activity  restaurantName" name="restaurantList" id="styled-checkbox-1" type="checkbox"
                      value="Restaurants">
                      <label for="styled-checkbox-1" >Restaurants</label>
                    </li>
                    <li>
                      <input class="styled-checkbox activity  restaurantName" name="restaurantList" id="styled-checkbox-2" type="checkbox" value="quick-bites"
                      >
                      <label for="styled-checkbox-2">Quick Bites</label>
                    </li>
                    <li>
                      <input class="styled-checkbox activity  restaurantName" name="restaurantList" id="styled-checkbox-02" type="checkbox" value="dessert"
                      value="value02">
                      <label for="styled-checkbox-02">Dessert</label>
                    </li>
                    <li>
                      <input class="styled-checkbox activity  restaurantName" name="restaurantList" id="styled-checkbox-012" type="checkbox" value="cafes"
                      value="value012">
                      <label for="styled-checkbox-012">Coffee & Tea</label>
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
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-4" name="restaurantList" type="checkbox" value="delivery restaurants"
                  >
                  <label for="styled-checkbox-4">Delivery</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-5" name="restaurantList" type="checkbox" value="takeout restaurants"
                  >
                  <label for="styled-checkbox-5">Takeout</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-05" name="restaurantList" type="checkbox" value="giftcard restaurants"
                  >
                  <label for="styled-checkbox-05">Gift Cards Available</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-005" name="restaurantList" type="checkbox" value="table restaurants"
                  >
                  <label for="styled-checkbox-005">Table Service</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-105" name="restaurantList" type="checkbox" value="Creditcards restaurants"
                  >
                  <label for="styled-checkbox-105">Accepts Credit Cards</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-205" name="restaurantList"  type="checkbox" value="family restaurants"
                  >
                  <label for="styled-checkbox-205">Family style</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-305" name="restaurantList" type="checkbox" value="wifi restaurants"
                  >
                  <label for="styled-checkbox-305">Free Wifi</label>
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
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-7" name="restaurantList" type="checkbox" value="breakfast"
                  >
                  <label for="styled-checkbox-7">Breakfast</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-8"  name="restaurantList" type="checkbox" value="brunch"
                  >
                  <label for="styled-checkbox-8">Brunch</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-07" name="restaurantList" type="checkbox" value="lunch"
                  >
                  <label for="styled-checkbox-07">Lunch</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-08" type="checkbox" value="dinner"
                  >
                  <label for="styled-checkbox-08">Dinner</label>
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
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-71" name="restaurantList" type="checkbox" value="american"
                  >
                  <label for="styled-checkbox-71">American </label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-81" name="restaurantList" type="checkbox" value="asian"
                  >
                  <label for="styled-checkbox-81">Asian</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-071" name="restaurantList"  type="checkbox" value="chinese"
                  >
                  <label for="styled-checkbox-071">Chinese</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0811" name="restaurantList" type="checkbox" value="australian"
                  >
                  <label for="styled-checkbox-0811">Australian</label>
                </li>
              </ul>
              <ul class="unstyled centered new_cuisine" id="restaurantList" style="display:none;">

                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-711" name="restaurantList" type="checkbox" value="italian"
                  >
                  <label for="styled-checkbox-711">Italian </label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-812" name="restaurantList" type="checkbox" value="indian"
                  >
                  <label for="styled-checkbox-812">Indian</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0712" name="restaurantList"  type="checkbox" value="french"
                  >
                  <label for="styled-checkbox-0712">French</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0813" name="restaurantList" type="checkbox" value="japanese"
                  >
                  <label for="styled-checkbox-0813">Japanese</label>
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
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-72" name="restaurantList" type="checkbox" value="cheap eats">
                  <label for="styled-checkbox-72">Cheap Eats </label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-82" name="restaurantList" type="checkbox" value="mid range"
                  >
                  <label for="styled-checkbox-82"> Mid-range</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-072"  name="restaurantList" type="checkbox" value="fine dining"
                  >
                  <label for="styled-checkbox-072"> Fine Dining</label>
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
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-73" name="restaurantList" type="checkbox" value="salad">
                  <label for="styled-checkbox-73">Salad</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-83" name="restaurantList" type="checkbox" value="fish"
                  >
                  <label for="styled-checkbox-83">Fish</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-073" name="restaurantList" type="checkbox" value="beef"
                  >
                  <label for="styled-checkbox-073">Beef</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-083" name="restaurantList" type="checkbox" value="pork"
                  >
                  <label for="styled-checkbox-083">Pork</label>
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
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-74" name="restaurantList" type="checkbox" value="child friendly">
                  <label for="styled-checkbox-74">Child-friendly</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-84" name="restaurantList" type="checkbox" value="kids"
                  >
                  <label for="styled-checkbox-84">Kids</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-074" name="restaurantList" type="checkbox" value="bar scene"
                  >
                  <label for="styled-checkbox-074"> Bar Scene</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-084"  name="restaurantList" type="checkbox" value="groups"
                  >
                  <label for="styled-checkbox-084">Groups</label>
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
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-75"  name="restaurantList" type="checkbox" value="vegetarian">
                  <label for="styled-checkbox-75">Vegetarian Friendly</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-85" name="restaurantList" type="checkbox" value="vegan"
                  >
                  <label for="styled-checkbox-85">Vegan Options</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-075" name="restaurantList"  type="checkbox" value="halal"
                  >
                  <label for="styled-checkbox-075">Halal</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-085" name="restaurantList" type="checkbox" value="kosher"
                  >
                  <label for="styled-checkbox-085">Kosher</label>
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
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-753" name="restaurantList" type="checkbox" value="downtown">
                  <label for="styled-checkbox-753">Downtown <?php echo $_SESSION['city_name']; ?></label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-853" name="restaurantList" type="checkbox" value="soma"
                  >
                  <label for="styled-checkbox-853">SoMa</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0753" name="restaurantList" type="checkbox" value="mission district"
                  >
                  <label for="styled-checkbox-0753">Mission District</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0853" name="restaurantList" type="checkbox" value="theater district"
                  >
                  <label for="styled-checkbox-0853">Theater District</label>
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
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-754" name="restaurantList" type="checkbox" value="MICHELIN guide">
                  <label for="styled-checkbox-754">MICHELIN Guide </label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-854" name="restaurantList" type="checkbox" value="MICHELIN 1 Star"
                  >
                  <label for="styled-checkbox-854">MICHELIN 1 Star</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0754" name="restaurantList" type="checkbox" value="MICHELIN 2 Stars"
                  >
                  <label for="styled-checkbox-0754">MICHELIN 2 Stars</label>
                </li>
                <li>
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-0854" name="restaurantList" type="checkbox" value="MICHELIN 3 Stars"
                  >
                  <label for="styled-checkbox-0854">MICHELIN 3 Stars</label>
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
                  <input class="styled-checkbox activity  restaurantName" id="styled-checkbox-755" type="checkbox" name="restaurantList" value="<?php echo $_SESSION['city_name']; ?> Intl Airport">
                  <label for="styled-checkbox-755"><?php echo $_SESSION['city_name']; ?> Intl Airport</label>
                </li>
              </ul>
            </div>
          </div>
          <hr>
        </div>
        <div class="add_img">
          <a href="https://www.dpbolvw.net/click-8265264-15090738" target="_top">
            <img src="/images/restaurant-ad.png" width="300" height="600" alt="" border="0"/></a>
            <!-- <img src="./img/ss/addimg.png" class="img-fluid w-100"> -->
          </div>
          <!-- <div class="add_img">
            <img src="./img/ss/addimg2.png" class="img-fluid w-100">
          </div> -->
        </div>
        <!--end of search-filter section-->
        <div class="col-lg-9">
          <h5 class="filter-heading mb-3">
            Delivery Available
          </h5>
          <div class="resturantclient owl-carousel owl-theme mb-5">
            <?php   $delievery = yelp_api_call('10',$_SESSION['city_name'],'delivery restaurants');
            foreach ($delievery as $homeData){
              $tour_image = $homeData->image_url;
              $tour_rating = $homeData->rating;
              $tour_id = $homeData->id;
              $tour_review_count = $homeData->review_count;
              ?>
              <div class="grid restaurants_deals ">
                <a href="<?php echo $homeData->url; ?>" target="_blank">
                  <div class="image_htfix_mid">
                    <img src="<?php echo $tour_image; ?>" class="img-fluid w-100">
                  </div>
                  <a href="#" class="like"><i class="far fa-heart"></i></a>
                  <div class="restaurants_deals_content">
                    <h4><?php echo substr($homeData->name, 0, 20); ?></h4>
                    <div class="star_rate">
                      <?php for($x=1;$x<=$tour_rating;$x++): ?>
                        <span class="fa fa-star checked"></span>
                      <?php endfor; ?>
                      
                      <span  class="reviews yelpuser-review"  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
                        (<?php echo $tour_review_count; ?> Reviews)
                      </span>
                    </div>
                  </div>
                </a>
              </div>
            <?php } ?>
          </div>
          <h5 class="filter-heading mb-3">
            <?php echo $_SESSION['city_name']; ?> by Food
          </h5>
          <div class="foodtype owl-carousel owl-theme mb-5">
            <div class="grid restaurants_deals restFoood"  id="Breakfast">
              <img src="images/brkfirstImg.jpg" class="img-fluid w-100">
              <div class="restaurants_deals_content">
                <h4>Breakfast</h4>
              </div>
            </div>
            <div class="grid restaurants_deals restFoood" id="Seafood">
              <img src="images/seafoodnew.jpg" class="img-fluid w-100">
              <div class="restaurants_deals_content">
                <h4>Seafood</h4>
              </div>
            </div>
            <div class="grid restaurants_deals restFoood" id="Coffee Tea">
              <img src="images/coffytea.jpg" class="img-fluid w-100">
              <div class="restaurants_deals_content">
                <h4>Coffee & Tea</h4>
              </div>
            </div>
            <div class="grid restaurants_deals restFoood" id="Cheap Eats">
              <img src="images/cheapeat.jpg" class="img-fluid w-100">
              <div class="restaurants_deals_content">
                <h4>Cheap Eats</h4>
              </div>
            </div>
            <div class="grid restaurants_deals restFoood" id="Lunch">
              <img src="images/lunchnew.jpg" class="img-fluid w-100">
              <div class="restaurants_deals_content">
                <h4>Lunch</h4>
              </div>
            </div>
            <div class="grid restaurants_deals restFoood" id="Mexican">
              <img src="images/mexican-cuisine.jpg" class="img-fluid w-100">
              <div class="restaurants_deals_content">
                <h4>MEXICAN</h4>
              </div>
            </div>
            <div class="grid restaurants_deals restFoood" id="Chinese">
              <img src="images/chinese-cuisine.jpg" class="img-fluid w-100">
              <div class="restaurants_deals_content">
                <h4>Chinese</h4>
              </div>
            </div>
            <div class="grid restaurants_deals restFoood" id="Italian">
              <img src="images/italian-cuisine.jpg" class="img-fluid w-100">
              <div class="restaurants_deals_content">
                <h4>Italian</h4>
              </div>
            </div>
            <div class="grid restaurants_deals restFoood"  id="Pizza">
              <img src="images/pizza-cuisine.jpg" class="img-fluid w-100">
              <div class="restaurants_deals_content">
                <h4>Pizza</h4>
              </div>
            </div>
            <div class="grid restaurants_deals restFoood" id="Barbeque">
              <img src="images/barbecue-beef.jpg" class="img-fluid w-100">
              <div class="restaurants_deals_content">
                <h4>Barbeque</h4>
              </div>
            </div>
          </div>
          <h5 class="filter-heading mb-3">
            Fine Dining
          </h5>
          <div class="resturantclient owl-carousel owl-theme mb-5">
            <?php   $fineDining = yelp_api_call('10',$_SESSION['city_name'],'fine dining');
            foreach ($fineDining as $homeData){
              $fineDining_image = $homeData->image_url;
              $tour_rating = $homeData->rating;
              $tour_id = $homeData->id;
              $fineDining_count = $homeData->review_count;
              ?>
              <div class="grid restaurants_deals">
               <a href="<?php echo $homeData->url; ?>" target="_blank">
                <div class="image_htfix_mid">
                  <img src="<?php echo $fineDining_image; ?>" class="img-fluid w-100">
                </div>
                <a href="#" class="like"><i class="far fa-heart"></i></a>
                <div class="restaurants_deals_content">
                 <h4><?php echo substr($homeData->name, 0, 20); ?></h4>
                 <div class="star_rate">
                  <?php for($x=1;$x<=$tour_rating;$x++): ?>
                   <span class="fa fa-star checked"></span>
                 <?php endfor; ?>
                 <span  class="reviews yelpuser-review"  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
                   (<?php echo $fineDining_count; ?> Reviews)
                 </span>

               </div>
             </div>
           </a>
         </div>
       <?php } ?>
     </div>
     <h5 class="filter-heading mb-3">
      Moderately Priced
    </h5>

    <div class="resturantclient owl-carousel owl-theme mb-5">
      <?php
      $moderately = yelp_api_call('10',$_SESSION['city_name'],'moderately priced restaurants');
      foreach ($moderately as $moderValue){
        $moderately_image = $moderValue->image_url;
        $tour_rating = $moderValue->rating;
        $tour_id = $moderValue->id;
        $moderately_count = $moderValue->review_count;
        ?>
        <div class="grid restaurants_deals">
          <a href="<?php echo $moderValue->url; ?>" target="_blank">
            <div class="image_htfix_mid">
              <img src="<?php echo $moderately_image; ?>" class="img-fluid w-100">
            </div>
            <a href="#" class="like"><i class="far fa-heart"></i></a>
            <div class="restaurants_deals_content">
              <h4><?php echo substr($moderValue->name, 0, 20); ?></h4>
              <div class="star_rate">
                <?php for($x=1;$x<=$tour_rating;$x++): ?>
                  <span class="fa fa-star checked"></span>
                <?php endfor; ?>
                <span  class="reviews yelpuser-review"  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
                  (<?php echo $moderately_count; ?> Reviews)
                </span>

              </div>

            </div>
          </a>
        </div>

      <?php } ?>
    </div>
    <h5 class="filter-heading mb-3">
      Cheap Eats
    </h5>
    <div class="resturantclient owl-carousel owl-theme mb-5">
      <?php
      $cheap = yelp_api_call('10',$_SESSION['city_name'],'cheap eats');
      foreach ($cheap as $cheapValue){
        $cheap_image = $cheapValue->image_url;
        $tour_rating = $cheapValue->rating;
        $tour_id = $cheapValue->id;
        $cheap_count = $cheapValue->review_count;
        ?>
        <div class="grid restaurants_deals">
          <a href="<?php echo $cheapValue->url; ?>" target="_blank">
           <div class="image_htfix_mid">
            <img src="<?php echo $cheap_image; ?>" class="img-fluid w-100">
          </div>
          <a href="#" class="like"><i class="far fa-heart"></i></a>
          <div class="restaurants_deals_content">
            <h4><?php echo substr($cheapValue->name, 0, 20); ?></h4>
            <div class="star_rate">
              <?php for($x=1;$x<=$tour_rating;$x++): ?>
                <span class="fa fa-star checked"></span>
              <?php endfor; ?>
              <span  class="reviews yelpuser-review"  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
                (<?php echo $cheap_count; ?> Reviews)
              </span>
              
            </div>
          </div>
        </a>
      </div>
    <?php } ?>
  </div>

  <h5 class="filter-heading mb-3">
    Breakfast
  </h5>
  <div class="resturantclient owl-carousel owl-theme mb-5">
    <?php
    $breakfast = yelp_api_call('10',$_SESSION['city_name'],'breakfast');
    foreach ($breakfast as $breakfastValue){
      $breakfast_image = $breakfastValue->image_url;
      $tour_rating = $breakfastValue->rating;
      $tour_id = $breakfastValue->id;
      $breakfast_count = $breakfastValue->review_count;
      ?>
      <div class="grid restaurants_deals">
        <a href="<?php echo $breakfastValue->url; ?>" target="_blank">
         <div class="image_htfix_mid">
          <img src="<?php echo $breakfast_image; ?>" class="img-fluid w-100">
        </div>
        <a href="#" class="like"><i class="far fa-heart"></i></a>
        <div class="restaurants_deals_content">
         <h4><?php echo substr($breakfastValue->name, 0, 20); ?></h4>
         <div class="star_rate">
           <?php for($x=1;$x<=$tour_rating;$x++): ?>
            <span class="fa fa-star checked"></span>
          <?php endfor; ?>
          <span  class="reviews yelpuser-review"  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
           (<?php echo $breakfast_count; ?> Reviews)
         </span>
         
       </div>
     </div>
   </a>
 </div>
<?php } ?>
</div>
<div class="filter_head resturant_listhead">
  <div class="heading mb-0">
    <h4><span class="count"></span> Restaurants in <?php echo $_SESSION['city_name'] ?>. Displaying 1–10</h4>
  </div>
  <div class="sorf-filter">
    <a href="#"><i class="fas fa-bars"></i></a>
    <a href="#"><i class="fas fa-th-large"></i></a>
    <span>Sort By
    </span>
    <select class="form-select" aria-label="Default select example">
      <option selected="">Best Value</option>
      <option value="1">Value</option>
    </select>
  </div>
</div>
<input type="hidden" id="fullCityName" value="<?php echo $_SESSION['city_name'] ?>">
<article id="atrl" class="oneArticle categoty-article inner_rest restaurant" v-html="members"> </article>
<!-- <div  class="hotel_listitem">

  <div class="hotel_img">
    <img src="./img/ss/hotel1.png" class="img-fluid w-100">
  </div>
  <div class="hotel_details resturant_sprecification">
   <div class="loc_details">
     <div class="hotel_name">
       <h5>Cow Hollow Inn and Suites</h5>
     </div>
     <div class="resturant_specl">
       <div class="resto_type">
         <p><i class="fas fa-hamburger"></i> Chinese, Asian</p>
       </div>
       <div class="resto_menu">
        <p><i class="fas fa-utensils"></i> MENU</p>
      </div>
      <div class="open-info">
        <p class="text-success"><i class="fas fa-check"></i> Open Now</p>
      </div>
    </div>

  </div>
  <div class="restro_tesimonial">
   <ul>
     <li>
       <p><i class="fas fa-quote-left"></i> <i>“Great Peking Duck”</i></p>
     </li>
     <li>
      <p><i class="fas fa-quote-left"></i> <i>“There are some special foods that you can't find where else.”</i></p>
    </li>
  </ul>
</div>
<div class="restro_btns">
 <div class="restro_deals">
   <a href="#" class="restro_btn">
    VIEW DEAL
  </a>
</div>
<div class="restro_deals">
  <a href="#" class="restro_btn">
    ORDER ONLINE
  </a>
</div>
<div class="hotel_rating">
  <h6 class="mb-2">Cow Hollow Inn and Suites</h6>
  <div class="star_rate">
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span class="fa fa-star checked"></span>
    <span>
      (200 Reviews)
    </span>
  </div>
</div>
</div>
</div>
</div> -->
<!-- <div class="pagination">
  <button class="pagination_btn disable">Previous</button>
  <ul class="pagination-list">
    <li class="active">
      <span>1</span>
    </li>
    <li>
      <span>2</span>
    </li>
    <li>
      <span>3</span>
    </li>
    <li>
      <span>4</span>
    </li>
    <li>
      <span>5</span>
    </li>
  </ul>
  <button class="pagination_btn">Next</button>
</div> -->
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
</section> 

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
$(document).on('click','#restaurantList .restaurantName',function(){
  var category_name = $("input[name='restaurantList']:checked").val();
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
<?php  include('blog-resources.php');?>
<?php include('landingPage-footer.php'); ?>
</body>
</html>

<style>

.desktop-filter {display: block;}
.mobile-filter {display: none;}
.image_htfix_mid img {object-fit: cover !important;}
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
  .mobile-filter ul {display: flex;align-items: center;justify-content: space-around;flex-wrap: wrap;}
  .mobile-filter ul li a {font-size: 16px;}
  .mobile-filter ul li a i {margin: 0 10px 0 0px;}
  .mobile-filter {border-top: 1px solid #ccc;padding: 0px 0 0px;border-bottom: 1px solid #ccc;margin: 0 0 20px;}
  .mobile-filter ul li {width: 50%;text-align: center;border-right: 1px solid #ccc;padding: 5px;}
  .mobile-filter ul li:last-child {border: 0;}
  .filter_box {padding-right: 0px;}
  h5.filter-heading {margin-bottom: 20px;}
}
</style>