<?php
ob_start("ob_gzhandler");
session_start();

$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}
$titleofpage="MySittiVacations: Best Deals For Flight & Hotel Vacation Packages";
$meta_description = "Get the best deals on flights, hotels, cruises, adventure tours, car rentals with Mysittivacations. We ensure you to get the best travel plans in USA. Visit now!";
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
// if(isset($_GET['status'])){
//    session_unset(); 
//    session_destroy();
//    unset($_COOKIE['city_name']);
//    unset($_COOKIE['search_city']);
//    setcookie('search_city', '', time() - 3600, '/'); // Empty value and old timestamp
//   setcookie('city_name', '', time() - 3600, '/'); // Empty value and old timestamp
// }
// if(!empty($_COOKIE['city_name'])){
//    $_SESSION['city_name']  = strtok($_COOKIE['city_name'], ',');
//    $_SESSION['formatteds'] = strtok($_COOKIE['city_name'], ',');
// }
?>
<?php
include("home_header.php"); ?>
   <script async src="https://js.convertflow.co/production/websites/10476.js"></script>
 <style type="text/css">
     .pac-container {
    z-index: 9999 !important;
}
button#myBtn {
    display: block;
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 99;
    font-size: 18px;
    border: none;
    outline: none;
    color: white;
    cursor: pointer;
    padding: 15px;
    border-radius: 100px px;
    background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa);
}
.us-city-popups img {
    height: 200px;
    border-radius: 10px;
}
.modal-header button.close{
display: inline-flex !important;
}
ul.us-city-popups.row a.cool_link {
    position: relative !important;
    text-align: center !important;
    display: block !important;
}
ul.us-city-popups.row a.cool_link span.dealscity_name.cityes_cityes_name {
    position: relative;
    top: -55px;
    background: #fff;
    width: 90%;
    display: block;
    margin: 0 auto;
    padding: 10px;
    border-radius: 30px;
}
form#ContactFrom {
    padding: 10px 30px;
}
</style>

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
    $count = $result->num_rows; ?>
    <div data-aos="zoom-in-right" class="banner-section n-home hotel-hero city-hero" style="background-image:url(images/specific-back.png)"> 
        <div class="container">
            <div class="mobile-hero">
                <img src="images/specific-back.png" loading="lazy">
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
} else{
                    ?>
<div data-aos="zoom-in-right" class="banner-section n-home" style="background-image:url(images/my-banner.png)"> 
   <div class="container">
        <div class="mobile-hero">
            <img src="images/mobile-hero.png" loading="lazy">
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
<div class="slider-section flight-sec" id=""> 
        <a class="img-poster" href="https://www.kqzyfj.com/click-8265264-15343527" target="_top">
        <img src="https://www.lduhtrp.net/image-8265264-15343527" width="728" height="90" alt="" border="0"/></a>
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
                           
                           <div class="item testimonial-block product">
                           
                                <div class="cities"> 
                                    <a onclick="reloadLandingPage('<?php echo $value['name']; ?>',this)" href="random_deals.php?flag=Flights&from_name=<?php echo $value['name']; ?>&from_to=United state" class="cool_link">
                                    <img src="<?php echo $value['image_url']; ?>" alt="<?php echo $value['name']; ?>" loading="lazy">
                                </a>
                                 <a onclick="reloadLandingPage('<?php echo $value['name']; ?>',this)" href="random_deals.php?flag=Flights&from_name=<?php echo $value['name']; ?>&from_to=United state">
                                    <h3><?php echo $value['name']; ?></h3>
                                </a>
                                </div>
                        </div>
                    <?php } ?>
           </div>
        </div>
        <div class="view-tag" data-aos="zoom-in-down">
            <a class= "viewAll" keyword="Cool Flight Deals">View all</a>
        </div>

    </div>
</div>
<div class="slider-section new-for"> 
    <div class="container">
        <div data-aos="zoom-in-left" class="myheader-sec">
            <h2>Cruise Deals</h2>
        </div>
        <div class="travels_inner">
            <div class="row">
                <div class="testimonial-section products">
                    <div class="owl-carousel owl-theme ProductSlide" id="ProductSlide">
                        <div data-aos="zoom-in-right" class="testimonial-block product">
                            <div class="cities">
                                <a href="https://www.tkqlhce.com/click-8265264-10493749" class="cool_link">
                                    <img src="/cruises_images/last-minute-cruises.jpg" class="img-fluid w-100" loading="lazy">
                                </a>
                                <a href="https://www.tkqlhce.com/click-8265264-10493749">
                                    <p>Last-Minute</p>
                                </a>
                            </div>
                        </div>
                        <div data-aos="zoom-in-left" class="testimonial-block product">
                            <div class="cities">
                                <a href="https://www.kqzyfj.com/click-8265264-10678374" class="cool_link">
                                    <img src="/cruises_images/family-cruises.jpg" class="img-fluid w-100" loading="lazy">
                                </a>
                                <a href="https://www.kqzyfj.com/click-8265264-10678374">
                                    <p>Family</p>
                                </a>
                            </div>
                        </div>
                        <div data-aos="zoom-in-left" class="testimonial-block product">
                            <div class="cities">
                                <a href="https://www.jdoqocy.com/click-8265264-10281267" class="cool_link">
                                    <img src="/cruises_images/honeymoon.png" class="img-fluid w-100" loading="lazy">
                                </a>
                                <a href="https://www.jdoqocy.com/click-8265264-10281267">
                                    <p>Honeymoon</p>
                                </a>
                            </div>
                        </div>
                        <div data-aos="zoom-in-left" class="testimonial-block product">
                            <div class="cities">
                                <a href="https://www.anrdoezrs.net/click-8265264-13312047" class="cool_link">
                                    <img src="/cruises_images/ncl_Bliss_Haven_Observ_Lounge_Dk17_Sofa_View.jpg" class="img-fluid w-100" loading="lazy">
                                </a>
                                <a href="https://www.anrdoezrs.net/click-8265264-13312047">
                                    <p>Couple</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="view-tag" data-aos="zoom-in-down">
                    <a href="/random_deals.php?flag=Cruises" target="_blank" class="national_pas">View all</a>
                </div>
            </div>
        </div> 
    </div>
</div>

<div class="generalPageHeadingActivity inspiratinSection amazing_discounts_sec"></div>
             
            
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
                        <a href="javascript:void(0)" class="show_hide" data-content="toggle-text" style="color:green;">Read More</a></p>
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
                                <a href="/yelp-tour.php?tours=escape%20room">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row discounts_inner escape_room">
                
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
                            $limit = 4;
                        }
                        $getyelpTourData = yelp_api_data($limit,$_SESSION['city_name'],'Winery'); 
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
                                                <img src=".$image." loading='lazy'>
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
                        <?php $getyelpTourData = yelp_api_data(4,$_SESSION['city_name'],'Comedy'); 
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
                        <a href="<?php echo $tour_url ?>">
                        <div data-aos="zoom-in-left" class="testimonial-block product">
                            <div class="discount-block">
                                <?php if(!empty($tour_image)) : ?>
                                    <img src="<?php echo $tour_image; ?>" alt="<?php echo $tour_name; ?>" loading="lazy">
                                <?php else : ?>
                                    <img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg" alt="no-image" loading="lazy">
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
                    </a>
                        <?php endforeach; ?>
                        
                   </div>
                </div>
            </div>
        </div>
        <?php } ?>

<!--design end-->
            

<div class="landing_specific_page slider-section" id="specificData">
  <!--   <div id="loader" :class="loading"></div> -->
  <div class="specific_page_categories" v-html="members">
  </div>
</div>


<?php } ?>
 <a href="https://www.tkqlhce.com/click-8265264-15274779" target="_top">
<img src="https://www.tqlkg.com/image-8265264-15274779" width="728" height="90" alt="" border="0" style="display: block;
    margin-left: auto;
    margin-right: auto;
    padding-top: 10px;" loading="lazy" /></a>
<?php include('blog-resources-new.php');?>
<?php include('home_footer_dev.php'); ?>
 
    

<div class="modal fade" id="exampleModalssss" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="top: 20px;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content viewAllPopup">
    </div>
  </div>
</div>
<div class="modal fade" id="PopupContact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="top: 20px;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content PopupContact">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Contact Us</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
      </div>
        <form id="ContactFrom" class="landing-page-form" method="POST" action="">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">First Name (required)</label>
                <input type="text" id="contact_first" laceholder="First Name (required)" name="fname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="message-text" class="col-form-label">Last Name (required)</label>
                <input type="text" id="contact_last" laceholder="Last Name (required)" name="lname" class="form-control" required>
            </div>  
            <div class="form-group">
                <label for="message-text" class="col-form-label">Your Email (required)</label>
                <input type="email" id="contact_email" laceholder="Your Email (required)" name="email" class="form-control" required>
            </div>  
            <div class="form-group">
                <label for="message-text" class="col-form-label">Your Message (required)</label>
                <textarea id="contact_enquiry" class="form-control" name="enquiry" placeholder="Your Message" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="SubmitContact();" name="sendContactUs">Submit</button>
            </div>
        </form>
    </div>
  </div>
</div>


<script>
    $('.ProductSlide').owlCarousel({
        // loop:true,
        // margin:20,
        nav:true,
        responsiveClass:true,
        dots:false,
        responsive:{
            0:{
                items:1,
            },
            768:{
                items:1,
            },
            1100:{
                items:4,
                loop:false
            }
        }
    })
    $('.ProductSlide1').owlCarousel({
        // loop:true,
        // margin:20,
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
</script>
<?php
  if(isset($_SESSION['city_name'])){?>
    <script defer type="text/javascript">
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
                jQuery('.escape_room').html(response);
                jQuery('html, body').animate({
                    scrollTop: jQuery(".discounts_inner").offset().top
                }, 2000);
                jQuery("#loader").removeClass("loading");
            }
        });
        </script>
  <?php }

 ?>
</body>

</html>