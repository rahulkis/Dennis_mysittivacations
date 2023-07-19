<?php
ob_start("ob_gzhandler");
session_start();

$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$titleofpage="MySittiVacations: Best Deals For Flight & Hotel Vacation Packages";
$meta_description = "Get the best deals on flights, hotels, cruises, adventure tours, car rentals with Mysittivacations. We ensure you to get the best travel plans in USA. Visit now!";
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

   include("header-new.php");
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
                              <section class="inner_page_hero sec_pad city_bg">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="hero_section_content">
                                                <h2>Explore <?php echo $_SESSION['city_name']; ?></h2>
                                                <p><?php
                                                foreach ($result as $key => $value) {
                                                  echo substr($value['text'],0,150)."...";

                                              }?>
                                          </p>
                                      </div>
                                  </div>
                                  <div class="col-lg-12">
                                      <!--   <input id="target" type="hidden" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['full_city_name'];?>"  required> -->
                                      <!-- <h3 class="book_text">Book a room at a great price!</h3> -->
                                      <!-- <script charset="utf-8" src="//www.travelpayouts.com/widgets/c98aeb1f90b513aff212c115d707c6ac.js?v=1841" async> </script> -->
                                      <div class="content-bannersss">
                                          <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

                                          <input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['full_city_name'];?>" required="">

                                          <a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><img src="/css/optimize/images/search.png" alt=""></a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </section>
                      <?php 
               //}
                  } else{
                    ?>
                    <section class="hero_section">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-7" data-aos="fade-right" data-aos-duration="1000">
                                    <div class="hero_section_content home_page">
                                        <h5>Get ready for your next vacation by checking out our website first.</h5>
                                        <!--  <h2>The world is not in your books and maps, it’s out there...</h2> -->
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
                    </section>
                <?php } ?>
                <!--end of hero section-->

                <?php if( empty($_SESSION['city_name'])) { ?>
                    <section class="filter 4" id="home_filter">
                        <input id="target" type="hidden" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php //echo $_SESSION['full_city_name'];?>"  required>
                        <!-- <h3 class="book_text">Book a room at a great price!</h3> -->
                        <script charset="utf-8" src="//www.travelpayouts.com/widgets/c98aeb1f90b513aff212c115d707c6ac.js?v=2251" async></script>

                    </section>
                <?php } ?>
                <!--end of Filter -->
                <?php include('category-navigation.php'); ?>
                <!--end of category -->
                <?php if( empty($_SESSION['city_name'])) { ?>
                    <section id="cool_flight" data-aos="fade-up" data-aos-duration="1000">
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
                </section>

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
            <?php } else { ?>
                <section class="about_us">
                    <div class="container">
                        <div class="about_images">
                           <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <?php foreach ($result as $key => $value) { 
                                       $images[] = $value['images'];
                                       $video_url = $value['video'];
                                   } 
                                   $image_url = explode(",",$images[0] );?>
                                   <?php if($video_url!=''){ ?>
                                    <video width="" height="" class="videocontrol" playsinline autoplay muted loop>
                                        <source src="https://www.mysittivacations.com/video/<?php echo $video_url; ?>" type="video/mp4">
                                            <source src="movie.ogg" type="video/ogg">
                                <!-- <div class="col-lg-7 image_left">
                                    <img src="img/img29.png" class="img-fluid w-100" loading="lazy" >
                                </div>
                                <div class="col-lg-5 image_right">
                                    <img src="img/img30.png" class="img-fluid  w-100 mb-4" loading="lazy" >
                                    <img src="img/img31.png" class="img-fluid  w-100" loading="lazy" >
                                </div> -->
                                   <!-- <div class="col-lg-12 ">
                                    <video width="" height="" class="videocontrol" playsinline autoplay muted loop>
                                        <source src="https://staging.mysittivacations.com/video/<?php //echo $video_url; ?>" type="video/mp4">
                                            <source src="movie.ogg" type="video/ogg">
                                            </video>
                                        </div> -->
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
                            </div>
                        </div>

                        <div class="col-lg-6">
                           <div class="about_content">
                            <div class="hero_section_content">
                                <h2>About <?php echo $_SESSION['city_name']; ?></h2>
                                <?php foreach ($result as $key => $value) { 
                                    if($value['text'] != ''){ ?>
                                    <p class="pe-0">
                                        <?php  echo substr($value['text'],0,1000); ?><span class="content"><?php  echo "- ".substr($value['text'],1000,10000); ?></span>
                                        <!--  <button class="show_hide" title="Read More">Read More</button> -->
                                        <a href="javascript:void();" class="show_hide" data-content="toggle-text" style="color:green;">Read More</a>

                                    </p>
                                <?php } } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <br><br>
    <section class="travels sec_pad bg_grey what_do pb-0 hotel_style">
      <div class="container">
        <div class="heading">
            <div class="row">
             <div class="col-lg-9">
               <h4>Where to stay</h4>
               <p>Low hotel rates for luxury, comfort, pet-friendly rooms</p>
           </div>
           <div class="col-lg-3 text-lg-end">
               <a href="/hotels/index.php" class="btn btn-outline-dark px-4">View all</a>
           </div>
       </div>
   </div>
   <div class="travels_inner  mb-0">
    <div class="what_do_slider22" id="city_deals_home">
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
     echo "<div class='grid'>".str_replace('limit=50', 'limit=3', $fiveStar)."</div>";
 }
 ?>
</div>
</div>
</div> 
</section>

<div class="landing_specific_page" id="specificData">
  <!--   <div id="loader" :class="loading"></div> -->
  <div class="specific_page_categories" v-html="members">
  </div>
</div>
<section class="adds sec_pad" style="padding-top:0px !important;">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8" >
               <a href="https://www.dpbolvw.net/click-8265264-13217276" target="_top">
                <img src="images/home-ad-specific.jfif" width="728" height="90" alt="Up to 35% off at Moon Palace The Grand-Cancun almost over. Book now!" border="0"/></a>

                 <div class="container recommed-city pcdesktop new_adds" style="text-align: center;  margin: 40px 0px 0px;">
  <a href="https://track.flexlinkspro.com/g.ashx?foid=156074.4221.271012&trid=1215297.159075&foc=16&fot=9999&fos=5" rel="nofollow" target="_blank" alt="Best Hotel Prices 728x90" title="Best Hotel Prices 728x90" ><img border="0" src="http://a.impactradius-go.com/display-ad/4221-271012" style="max-width: 100%;margin-top: 20px;" /></a><img src="https://track.flexlinkspro.com/i.ashx?foid=156074.4221.271012&trid=1215297.159075&foc=16&fot=9999&fos=5" border="0" width="0" height="0" style="opacity: 0;"/></div>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
    </div>
</section>

<?php } ?>
<?php include('blog-resources.php');?>
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

<!-- JS -->

<?php include('landingFooterHome.php'); ?>


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
</script>
</body>

</html>
<style>
@media(max-width:767px){  
img.cui-image {
    max-width: 0 !important;
}
  }
</style>