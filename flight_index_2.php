<?php
include("../Query.Inc.php");
$Obj = new Query($DBName);

?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>

   <script>
    var set_marker = '130544';
    var set_handle = "179763ebae3305f58117dc48c020d458";
	var set_cookies = true; 
  </script>

  <style type="text/css">
    .dropdown-content-main a:hover {
        background-color: #337ab7 !important;
    }
    </style>

  <meta charset="utf-8">
  <title>Mysitti.com || Cheap flights and airline tickets</title>
  <meta name="keywords" content="">
  <meta name="description" content="We searche travel and airline sites to help you find cheap flights at best prices.">

 
  <meta name="viewport" content="width=device-width, target-densitydpi=device-dpi, user-scalable=yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="format-detection" content="telephone=no">
  <meta name="p:domain_verify" content="b812800cc41cd2b103f606bbda379e5b"/>


  <!-- FAVICON -->
  <link rel="icon" type="image/png" href="../images/v2_logo_round.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
  
  <link href="css/widgets.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="css/style.css">
 
  <link href="css/main.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://d1xxp9ijr6bk3z.cloudfront.net/js/jquery.bxslider.js"></script>
    <script src="https://d1xxp9ijr6bk3z.cloudfront.net/autocomplete/jquery.ajaxcomplete.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){

        var state = history.state || {};
          var reloadCount = state.reloadCount || 0;
          if (performance.navigation.type === 1) { // Reload
              state.reloadCount = ++reloadCount;
              history.replaceState(state, null, document.URL);
          } else if (reloadCount) {
              delete state.reloadCount;
              reloadCount = 0;
              history.replaceState(state, null, document.URL);
          }
          if (reloadCount >= 2) {
              
          }
        
      });

    </script>
  <?php $SiteURL = "https://".$_SERVER['HTTP_HOST']."/";?>
  <link href="<?php echo $SiteURL; ?>css/v2style.css" rel="stylesheet" type="text/css">
  <style>
    .container {max-width: 960px;}
    .planTap {    color: black;    position: static;}
  </style>
</head>

<body>
	<!--[if lt IE 9]>
				<p class="browserupgrade" style="color: #fff;background: #000;padding: 20px 15px; text-align: center;">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KF5H5F"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KF5H5F');</script>
	<!-- End Google Tag Manager -->

  <!-- wrapper -->
  <div class="wrapper">
  <div style="display:none;">
    <?php include 'svg_content2.php'; ?>
    </div>
    <!-- content -->
    <div class="content" role="main">

          <div class="main-header">
          <div class="container flight_contain">
            <div class="">
              <div class="col-sm-1 col-xs-6 logo">
                <a href="https://mysitti.com/index.php" id="logo-top"><img src="../images/v2_logo_round.png" alt="My sitti"></a>
              </div>
              
              <div class="col-sm-9 col-xs-6 tranparent">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li>
                                      <div class="dropdown-main">
                                        <p class="activities">Home</p>
                                        <div class="dropdown-content-main">
                                         <?php if(isset($_SESSION['user_id'])){ ?>
                                         <a href="<?php echo $SiteURL;?>searchEvents.php">Home</a>
                                         <?php }else { ?>
                                         <a href="<?php echo $SiteURL;?>index.php">Home</a>
                                         <?php } ?>
                                         <a href="<?php echo $SiteURL;?>comedy.php">Comedy</a>
                                          <a href="<?php echo $SiteURL;?>brewery.php">Wine & Brewery</a>
                                          <a href="<?php echo $SiteURL;?>handpicked-restaurant.php">Handpicked Restaurants</a>
                                          <a href="<?php echo $SiteURL;?>concert.php">Concerts</a>
                                          <a href="<?php echo $SiteURL;?>allSports.php">Sports</a>
                                          <a href="<?php echo $SiteURL;?>family.php">Family</a>
                                          <a href="<?php echo $SiteURL;?>allhoteldeals.php">Hotels Deals</a>
                                          <a href="<?php echo $SiteURL;?>performing-arts.php">Performing Arts</a>
                                          
                                         <a href="<?php echo $SiteURL;?>genre-rock.php">Rock</a>
                                         <a href="<?php echo $SiteURL;?>genre-blues.php">Blues</a>
                                          <a href="<?php echo $SiteURL;?>genre-country.php">Country</a>
                                          <a href="<?php echo $SiteURL;?>genre-jazz.php">Jazz</a>
                                
                                         </div>
                                      </div>
                                    </li>
                                    <li><a href="../hotels/index.php">Hotels</a></li>
                                    <li><a href="index.php" class="active">Flights</a></li>
                                    
                                    <li><a href="<?php echo $SiteURL;?>car-rentals.php">Car Rentals</a></li>

                                    <li><a href="https://mysitti.com/restaurant-deals.php">Restaurants</a></li>

                                    <li><a href="https://mysitti.com/yelp-tour.php">Things To Do</a></li>

                                    <!-- <li><a href="https://mysitti.com/tours.php">Things To Do</a></li> -->

                                    <li><a href="https://mysitti.com/city-guide.php">Audio Tours</a></li>
                                    
                                    <li><a href="https://mysitti.com/destination.php">Destinations</a></li>

                                    <!-- <li><a href="../homestay.php">Vacation Rentals</a></li> -->
                                  
                                </ul>
                            </div>
                        </nav>

                    </div>
                    <?php if(!isset($_SESSION['user_id'])) { ?>
                      <div class="col-sm-2 col-xs-6 log-n" style="float: right;">
                        <div class="log-in-new">
                            <a href=""><label for="login" id="v2_log_in">Log In</label></a>
                            <input type="checkbox" id="login">
                            
                            <a href="javascript:;"><input type="button" id="hidden_id" onclick="show_login_popop('first');" value="Join For Free" class="join-now-new signup"></a>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="v2_profile_user profilrForDesktop">
                    <?php
                        if($_SESSION['user_type'] == "user")
                        {
                          $linkProfile = "profile.php";
                          $profilename = $loggedin_user_data['profilename'];
                        }
                        else
                        {
                          $linkProfile = "home_club.php";
                          $profilename = $loggedin_host_data['club_name'];
                        }

                        if($_SESSION['user_type'] == 'club')
                        {

                        $host_query = mysql_query("SELECT * FROM clubs WHERE id = '".$_SESSION['user_id']."'");

                        $loggedin_host_data = mysql_fetch_assoc($host_query);

                        $userID = $_SESSION['user_id'];
                        $displayImage = $loggedin_host_data['image_nm'];
                        
                        }

                      ?>
                          <div class="v2_thumb_user_profile user_profile_host2"> 
                            <a href="<?php echo $SiteURL.$linkProfile; ?>">
                            <?php if($_SESSION['user_type'] == 'club'){ ?>
                              <img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$displayImage;} ?>" alt="user">
                            <?php } else { ?>
                              <img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$_SESSION['img'];} ?>" alt="user">
                            <?php } ?>
                            </a> 
                          </div>
                          <div class="v2_profile_user_info user_info_host2"> <span class="v2_welcome_user">Welcome</span>
                            <div class="clear"></div>
                            <span class="v2_user_name"> <a href="<?php echo $SiteURL.$linkProfile; ?>">
                            <?php 
                            if($_SESSION['user_type'] == 'user'){
                              $pget = mysql_query("SELECT profilename FROM user WHERE id = ".$_SESSION['user_id']."");
                              $cnma = mysql_fetch_array($pget);
                              $profilename = $cnma['profilename'];
                            } else {
                              $pget = mysql_query("SELECT club_name FROM clubs WHERE id = ".$_SESSION['user_id']."");
                              $cnma = mysql_fetch_array($pget);
                              $profilename = $cnma['club_name'];
                              }
                              $out = strlen($profilename) > 18 ? substr($profilename,0,18)."..." : $profilename;
                              echo $out; ?>
                            </a> </span> 
                          </div>
                      </div>
                      <?php } ?>
            </div>
          </div>
        </div>
      <div class="present b-lazy" data-src="../imagesNew/flight-land.jpg">
        <div class="container">
         
          <h1 class="searchTravl">We search multiple travel sites to find you the <strong>Best Deals!</strong></h1>
          <div class="present__fix-height-wrap">
          <input id="target" type="hidden" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>
          <script charset="utf-8" type="text/javascript">
            if ($('#target').val().length === 0) {
              var geodemo = 'Chicago';
            }else{
              var geodemo = $('#target').val();
            }
            // var geodemo = $('#target').val();
            // var today = new Date(2016, 12, 17);
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
              window.TP_FORM_SETTINGS = window.TP_FORM_SETTINGS || {};
              window.TP_FORM_SETTINGS["42219e94a7f90ad552c689a62e1689c7"] = {
                "handle": "42219e94a7f90ad552c689a62e1689c7",
                "widget_name": "Flights Search form",
                "border_radius": "2",
                "additional_marker": null,
                "width": null,
                "show_logo": false,
                "show_hotels": true,
                "form_type": "avia",
                "locale": "en",
                "currency": "usd",
                "sizes": "default",
                "search_target": "_blank",
                "active_tab": "avia",
                "search_host": "flights.mysitti.com/flights",
                "hotels_host": "search.hotellook.com",
                "hotel": "",
                "hotel_alt": "Hotellook - hotel price comparison. Search for hotels and find the best price",
                "avia_alt": "",
                "retargeting": true,
                "trip_class": "economy",
                "depart_date": today,
                "return_date": null,
                "check_in_date": null,
                "check_out_date": null,
                "no_track": false,
                "powered_by": true,
                "id": 119182,
                "marker": 130544,
                "origin": {
                  "name": geodemo
                },
                "destination": {
                  "name": ""
                },
                "color_scheme": {
                  "name": "custom",
                  "icons": "icons_orange",
                  "background": "#feba31",
                  "color": "#000000",
                  "border_color": "#feba31",
                  "button": "#65c109",
                  "button_text_color": "#ffffff",
                  "input_border": "#feba31"
                },
                "hotels_type": "hotellook_host",
                "best_offer": {
                  "locale": "en",
                  "currency": "usd",
                  "marker": 130544,
                  "search_host": "flights.mysitti.com/flights",
                  "offers_switch": true,
                  "api_url": "//minprices-jetradar.aviasales.ru/minimal_prices/offers.json",
                  "routes": [
                    {
                      "one_way": false,
                      "origin": {
                        "name": ""
                      },
                      "destination": {
                        "name": ""
                      }
                    }
                  ]
                },
                "hotel_logo_host": null,
                "search_logo_host": "jetradar.com",
                "hotel_marker_format": null,
                "hotelscombined_marker": null,
                "responsive": true,
                "height": 424
          };
        </script>
        <script charset="utf-8" src="//www.travelpayouts.com/widgets/42219e94a7f90ad552c689a62e1689c7.js?v=1497" async></script>
            <!-- <script charset="utf-8" src="//www.travelpayouts.com/widgets/42219e94a7f90ad552c689a62e1689c7.js?v=1131" async></script> -->

            <ul class="present__list">
              <li class="present__list__title show-xs"><strong>Mysitti.com works with</strong></li>
              <li>
                <span class="present__icon">
                  <svg class="icon-plain">
                    <use xlink:href="#plain" />
                  </svg>
                </span>
                <strong>728</strong>
                <span>airlines</span>
              </li>
              <li>
                <span class="present__icon">
                  <svg class="icon-deal">
                    <use xlink:href="#deal" />
                  </svg>
                </span>
                <strong>200</strong>
                <span>agencies</span>
              </li>
              <li>
                <span class="present__icon">
                  <svg class="icon-search">
                    <use xlink:href="#search" />
                  </svg>
                </span>
                <strong>5</strong>
                <span>booking sites</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="container">
        <div class="planTap">Plan a Vacation. Plan a Night Out. <br>
          Plan Smarter!</div>
      </div>
      <!-- Ads -->
      <div class="container">
        <div class="TPWL-front-content-weedle">
          <ul class="carousel-list js-init-slider">
          <?php 

            $getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE page_name = 'flights' ORDER BY `id` DESC LIMIT 10");
              while ($res = mysql_fetch_assoc($getAds))
              {
            ?> 
            <li>
                  <?php echo $res['af_code']; ?>
            </li>
            <?php   }  ?>
            
          </ul>
        </div>
      </div>
    
      <div class="calendar">
        <div class="container">
          <h2>Low Fare Calendar</h2>
          <span class="subtitle">The best airfares for a year ahead</span>
          <ul class="calendar__list">
            <li>
              <div class="calendar__item">
                <div class="calendar__img">
                  <div class="table">
                    <div class="cell">
                      <span class="calendar__value">1</span>
                      <svg class="icon-map">
                        <use xlink:href="#map" />
                      </svg>
                    </div>
                  </div>
                </div>
                <div class="calendar__desc">Choose your destination</div>
              </div>
            </li>
            <li>
              <div class="calendar__item">
                <div class="calendar__img">
                  <div class="table">
                    <div class="cell">
                      <span class="calendar__value">2</span>
                      <svg class="icon-arrows">
                        <use xlink:href="#arrows" />
                      </svg>
                    </div>
                  </div>
                </div>
                <div class="calendar__desc">One Way or<br />or Round Trip</div>
              </div>
            </li>
            <li>
              <div class="calendar__item">
                <div class="calendar__img">
                  <span class="calendar__value">3</span>
                  <div class="table">
                    <div class="cell">
                      <svg class="icon-calendar">
                        <use xlink:href="#calendar" />
                      </svg>
                    </div>
                  </div>
                </div>
                <div class="calendar__desc">Set the duration<br />of your trip</div>
              </div>
            </li>
            <li>
              <div class="calendar__item">
                <div class="calendar__img">
                  <div class="table">
                    <div class="cell">
                      <span class="calendar__value">4</span>
                      <svg class="icon-thumbup">
                        <use xlink:href="#thumbup" />
                      </svg>
                    </div>
                  </div>
                </div>
                <div class="calendar__desc">Сalendarwill show<br />the best flight deals</div>
              </div>
            </li>
          </ul>
          <div class="calendar__tooltip">
            <div class="tooltip">To change calendar's options click here</div>
          </div>
        
          <div class="calendar__form">
          <script charset="utf-8" src="//www.travelpayouts.com/calendar_widget/iframe.js?marker=130544.&origin=ATL&destination=BKK&currency=usd&searchUrl=flights.mysitti.com%2Fflights&one_way=false&only_direct=false&locale=en&period=year&range=7%2C14&width=800" async></script>
          </div>
        </div>
      </div>
      <!-- calendar end -->

      <!-- advantages -->
    <div class="advantages b-lazy" data-src="img/advantages-bg.jpg">
        <div class="container">
          <div class="advantages__img b-lazy" data-src="img/advantages__img-bg.png"></div>
          <div class="advantages__inner">
            <h2 class="advantages__title"><strong class="reg">5 ADVANTAGES OF BOOKING WITH MySitti</strong></h2>
            <ol class="advantages__list">
              <li>We find you the cheapest flight deals.</li>
              <li>We don’t charge any commissions or extra fees to our customers.</li> 
              <li>We have partnered with several companies so that we can offer you a huge choice of destinations, promotions and discounts.</li> 
              <li>We cooperate only with proven and reliable companies.</li> 
              <li>We always keep you up-to-date with the latest offers. Choose your destination, subscribe to our newsletter and get notified about any price changes.</li>
            </ol>
          </div>
        </div>
    </div>
     
      <div class="popular">
      	<div class="container">
      	<h2>Most popular flight destinations</h2>
      	<ul class="popular__list">
      		<li>
      		<script async src="//www.travelpayouts.com/weedle/widget.js?width=260px&marker=130544&host=flights.mysitti.com&locale=us&currency=usd&destination=PAR&destination_name=Paris" charset="UTF-8"></script></li>
      		<li>
      		<script async src="//www.travelpayouts.com/weedle/widget.js?width=260px&marker=130544&host=flights.mysitti.com&locale=us&currency=usd&destination=BKK&destination_name=Bangkok" charset="UTF-8"></script></li>
      		<li><script async src="//www.travelpayouts.com/weedle/widget.js?width=260px&marker=130544&host=flights.mysitti.com&locale=us&currency=usd&destination=TLV&destination_name=Tel%20Aviv-Yafo" charset="UTF-8"></script></li>
      		<li><script async src="//www.travelpayouts.com/weedle/widget.js?width=260px&marker=130544&host=flights.mysitti.com&locale=us&currency=usd&destination=LON&destination_name=London" charset="UTF-8"></script></li>
      		<li><script async src="//www.travelpayouts.com/weedle/widget.js?width=260px&marker=130544&host=flights.mysitti.com&locale=us&currency=usd&destination=NYC&destination_name=New%20York%2C%20NY" charset="UTF-8"></script></li>
      		<li><script async src="//www.travelpayouts.com/weedle/widget.js?width=260px&marker=130544&host=flights.mysitti.com&locale=us&currency=usd&destination=LAX&destination_name=Los%20Angeles%2C%20CA" charset="UTF-8"></script></li>
      	</ul>	
      	</div>
      </div>
      <!-- popular end -->

      <!-- choose -->
      <div class="choose b-lazy" data-src="img/choose-bg.jpg">
        <div class="container">
          <h2 class="reg-choose">Choose your destination and we will help you plan an Amazing Vacation!</h2>
          
          <script charset="utf-8" src="//www.travelpayouts.com/widgets/42219e94a7f90ad552c689a62e1689c7.js?v=1054" async></script>
        </div>
      </div>
      <!-- choose end -->
    </div>
    <!-- content end -->

    <!-- footer -->
    <footer class="footer" role="contentinfo">
    <div class="footerfix">
      <div id="v2_footer">
      <div class="v2_footer_container">
        <div class="landing_footer" id="v2_col2">
          <ul>
            <li><a href="https://mysitti.com/about_us.php"> About Us</a></li>
            <li><a target="_blank" href="https://mysitti.com/packages.php">Pricing</a></li>
            <li> <a href="javascript:void(0);" onclick="javascript:window.open('../copyright.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">DMCA Policy</a></li>
            <li> <a href="javascript:void(0);" onclick="javascript:window.open('../terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Terms &amp; Conditions</a></li>    
            <li> <a href="javascript:void(0);" onclick="javascript:window.open('../policy.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Privacy Policy</a></li>
            <li><a href="javascript:void(0);" onclick="javascript:window.open('../other_terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Other Terms &amp; Conditions</a></li>
            <li><a class="contact-landing" href="javascript:void(0);">Contact Us</a></li>
            <li><a href="https://itunes.apple.com/us/app/mysitti/id976124654?mt=8"><img alt="" src="../images/ios.png"></a></li>
             <li><a href="https://play.google.com/store/apps/details?id=com.pack.anmysitti&amp;hl=en"><img alt="" src="../images/android.png"></a></li>
          </ul>
          <ul class="landingpageSocial">
            <li><a href="https://www.facebook.com/mysitti"><img alt="" src="https://mysitti.com/images/v2_fb_icon_bottom.png"> Facebook</a></li>
            <li><a href="https://plus.google.com/u/0/111065459897703066867/about"><img alt="" src="https://mysitti.com/images/v2_gplus_icon_bottom.png"> Google+</a></li>
            <li><a href="https://instagram.com/mysitti/"><img alt="" src="https://mysitti.com/images/v2_instagram_icon_bottom.png"> Instagram</a></li>
            <li><a href="https://twitter.com/MysittiCom"><img alt="" src="https://mysitti.com/images/v2_tw_icon_bottom.png"> Twitter</a></li>
            <li><a href="https://www.youtube.com/channel/UCxCROSO5kbVn9Z-Sifw-LqA"><img alt="" src="https://mysitti.com/images/v2_ytube_icon_bottom.png"> Youtube</a></li>
          </ul>
         
  
          <div style="display:none;" class="contact-overlay">
             <div class="outer-landing-form">
              <h1>Contact Us</h1>
              <div class="successmessage" id="ConfirmMessage" style="border:none !important; display:none;">
              </div>
              <form action="https://flights.mysitti.com/flights" method="POST" class="landing-page-form" id="ContactFrom" novalidate="novalidate">
        
                <input type="text" required="" value="" placeholder="First Name (required)" name="fname" id="contact_first">
                <input type="text" required="" value="" placeholder="Last Name (required)" name="lname" id="contact_last">
                <input type="text" required="" value="" placeholder="Your Email (required)" name="email" id="contact_email">
                <textarea required="" placeholder="Your Message" name="enquiry" id="contact_enquiry"></textarea>
                <div class="v2_captcha">
                <img src="https://mysitti.com/captcha/image1509955480.png" id="captchaimage">
                <input type="hidden" id="captchacodeImage" name="captchcodeuser" value="shyj99" readonly="readonly">
                <a id="refreshImage" href="javascript: refreshCaptcha('https://mysitti.com/');"><img src="https://mysitti.com/images/refersh.png"></a>
                <input type="text" required="" placeholder="Captcha code here" name="captchaCode" value="" id="contact_captcha">
                </div>
                <input type="button" name="sendContactUs" value="Submit" onclick="SubmitContact();">
              </form>
              <a class="close-landing-page-form" href="javascript:void(0);"></a>
             </div>
           </div>
        </div>
        <div class="clear"></div>
      </div>
      </div>
      <div class="v2_copyright"> &copy; <script type="text/javascript">var mdate = new Date(); document.write(mdate.getFullYear());</script> mysitti.com <div id="back-top"><a href="#v2_wrapper">&nbsp;</a></div> </div>
    </div>
    
    </footer>
    <!-- footer end -->
  </div>
  <div id="v2_sign_up_after" class="v2_sign_up open" style="display: none;">
        <h1>Sign Up Here</h1>
        <a class="v2_close_signup" href="javascript:void(0);">close</a>
        <div class="clear"></div>
        <div class="v2_signup_tabcontainer"> 
          <!-- Tab panes -->
          <div class="v2_tab_content">
          <script type="text/javascript">
            function displayFields()
            {
              
              if($('input#hosttype').is(':checked'))
              {
                $('#userTYPE').val('club');
                $('#hostFieldsBlock').toggle();
              }
              else
              {
                $('#userTYPE').val('user');
                $('#hostFieldsBlock').toggle();
              }
              
            }

            $('.v2_close_signup').click(function(){
              
              $(".v2_sign_up").fadeOut('slow');
              $(".v2_signup_overlay").fadeOut('slow');
            });

            $(document).ready(function(){
              $('#otherCountry').click(function() {
                if($(this).is(":checked")) {
                  $('.fromothercontry').addClass('opt2');
                  $('#other1').fadeIn('slow');
                  $('#other2').fadeIn('slow');
                    $('#other3').fadeIn('slow');
                    $('#zipcodeSignup').fadeOut('slow');

                }
                else
                {
                  $('.fromothercontry').removeClass('opt2');
                  $('#other1').fadeOut('slow');
                  $('#other2').fadeOut('slow');
                  $('#other3').fadeOut('slow');
                  $('#zipcodeSignup').fadeIn('slow');
                }

              });
            });
          </script>
         
          <div id="user">
          <form action="<?php echo $SiteURL;?>paymentoption.php" method="post" class="tab_standerd v2_user_reg" id="signupd" name="signupd" autocomplete="off" novalidate>
            
              <!-- <span class="v2_accept_terms">
                <span id="Businesscheck" class="aboutYou">
                <input type="checkbox" id="hosttype" name="hostTYPE" onclick="displayFields();" style="float:left;">
                <span>Are you an Artist or Local Business?</span>
                </span> 
              </span> -->
              <div class="clear"></div>
              <div id="hostFieldsBlock" style="display: none;">
                <p id="profilesName">
                  <input type="text" required placeholder="Profile or Business Name" onblur="return ChkUserProfile(this.value,'user','https://mysitti.com/');" name="profilename" autocomplete="off" style="margin-top:5px;">
                </p>
                <p id="hostsFields">
                  <select required="" name="host_category" id="host_category" style="margin-top:5px; ">
                    <option value="">Select type of Business</option>
                    <option value="108">Artist</option>
                    <option value="91">Bar</option>
                    <option value="92">Club</option>
                    <option value="103">Fight</option>
                    <option value="106">Fighter</option>
                    <option value="107">Promoter</option>
                    <option value="109">Promoter Artist</option>
                    <option value="1">Restaurants</option>
                    <option value="191">Rock</option>
                    <option value="102">Theatre</option>
                    <option value="104">Wedding</option>
                  </select>
                </p>
              </div>
            <p>
              <input type="text" autocomplete="off" required placeholder="Email Address" onblur="return ChkUserId(this.value,'user','https://mysitti.com/');" name="email">
            </p>
          
            
            <div class="clear"></div>
            <p>
              <input type="password" required placeholder="Password" id="password" name="password" autocomplete="off">
            </p>
            <p>
              <input type="password" required placeholder="Confirm Password" name="cpassword" autocomplete="off">
            </p>
            
            <div class="clear"></div>
            
              <div class="agreementTerms aboutYou">
              <div class="span">
                <input type="checkbox" value="1" id="acknowledgement" name="acknowledgement">
                <p class="term_policy">By clicking Sign Up, you agree to our <a onclick="javascript:window.open('../terms_conditions.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Terms & Conditions</a> and <a onclick="javascript:window.open('../policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Privacy Policy</a>. You may receive email notification from MySitti.com, but you can choose to opt out at any time.</p> 
              </div>
              </div>
            <div class="clear"></div>
            <input type="hidden" name="plantype" value="free">
            <input type="hidden" id="planid" name="planid" value="1">
            <input type="hidden" id="userTYPE" name="UserType" value="">
            <input type="submit" value="Sign Up" name="submit">
          </form>
          <div class="social_signup" style="display:block;">
             <span class="elseLogin">OR  </span> 
           
          <span class="socialIconLogin"><label>Sign Up With</label> <br /><a onclick="FBLogin();" href="javascript:void(0);"><img alt="Login from Facebook" src="../images/facebook1.png"></a>

        
          <a href="<?php echo $authUrl; ?>" target="blank"><img alt="Login from Google Plus" src="../images/googleplus1.png"></a>
           

          <a href="<?php echo $instaURL;?>"><img src="../instagram.png" alt=""></a></span>
          </div>
          
        </div>
      </div>
      </div>
  </div>
    <div class="v2_signup_overlay" style="display: none;"></div>
<div class="v2_log_in">
  <h1>Login</h1>

  <a href="javascript:void(0);" class="v2_close_signup">close</a>

  <div class="ve_login_container">
    <style type="text/css">
    a#loginLogo:hover
    {
    box-shadow: none !important;
    }
    
    </style>
    <div class="v2_login_brand">
      <a href="<?php echo $SiteURL;?>index.php" id="loginLogo">
        <img src="../images/v2_logo_round_1.png" alt="">
      </a>
    </div>

    <div class="clear"></div>

      <div class="v2_login_key">

      <?php if(isset($_GET['msg']) && $_GET['msg'] == 'error1'){ ?>

      <div class="V2_login_error">Please enter correct email and password to login</div>

      <?php } ?>

      <form id="mainlogin" name="login" action="<?php echo $SiteURL;?>main/login.php" method="POST">
        <p>
          <input type="text" name="uname"  placeholder="Email Address" required>
        </p>

        <div class="clear"></div>

        <p>
          <input type="password" name="password" id="password2" placeholder="Password" required>
        </p>

        <p>

        <div class="clear"></div>

        <input type="submit" name="submit" value="Login">

        </p>

      </form>


      <div class="clear"></div>

    </div> <p><a href="<?php echo $SiteURL; ?>forget_pwd.php">Forgot Password</a></p>

    <p class="cleataccount">Don't have a MySitti account?  <a href="#" onclick="show_login_popop(); return false;">Sign up now</a>

    <div class="socialmedia">
      <a onclick="FBLogin();" href="javascript:void(0);" target="blank"> <img alt="Login from Facebook" src="../images/facebook1.png"></a>
       <a href="<?php echo $instaURL; ?>" target="_blank"> <img src="../instagram.png"> </a>
    
        <a href="<?php echo $authUrl; ?>" target="blank"><img alt="Login from Google Plus" src="../images/googleplus1.png"></a>
 
      </div>

  </div>

</div>

<div class="v2_login_overlay"></div>

<script type="text/javascript">
function sendsession(id)
{ 
  $.get('send-invite.php?user_id='+id, function(data) {
    window.location='camstart.php?'+data;
  });
}

function popuploginSign()
{
  
  $('#host_category option[value=108]').prop('selected', true);
  $('#hostsFields').show();
  $('#hosttype').prop('checked', true);
  $('#userTYPE').val('Artist');
    
  var $aSelected = $('.v2_log_in');
  if( $aSelected.hasClass('close') )
  {
    $('.close').addClass('open').removeClass('close');
  }
  else
  {
    $('.v2_log_in').addClass('open');
  }
}

function popuploginSign_notlogin(val)
{
  if (val != '') {
    $('#host_category option[value="' + val + '"]').prop('selected', true);
    $('#hostsFields').show();
    $('#hosttype').prop('checked', true);
    $('#userTYPE').val('club');
  }
  
  var $aSelectedc = $('.v2_log_in');

  if( $aSelectedc.hasClass('close') ){

    $('.close').addClass('open').removeClass('close');
    $('.v2_sign_up').addClass('close').removeClass('open');
    
  }else{

    $('.v2_log_in').addClass('open');
  }
}

function open_redirect_loginpopup_event(url)
{
  
  $.post('redirect_after_login_check.php', { 'set_store_redirect': true, 'successurl':url }, function(response){ });

  var $aSelected = $('.v2_log_in');
  $(".v2_signup_overlay").css('display', 'block');
  $(".v2_log_in").addClass('open');
  $(".v2_log_in").removeClass('close');
  $(".v2_sign_up").removeClass('open').addClass('close');
}

function openLoginpop(url)

{

  $.post('redirect_after_login_check.php', { 'set_store_redirect': true, 'successurl':url }, function(response){ });

  var $aSelected = $('.v2_log_in');
  $(".v2_signup_overlay").css('display', 'block');
  $(".v2_log_in").addClass('open');
  $(".v2_log_in").removeClass('close');
  $(".v2_sign_up").removeClass('open').addClass('close');
}

function show_login_popop(str)
{
  console.log(str);
  if(str == 'third')
  {
    $("#Businesscheck").hide();
    $("#hostFieldsBlock").hide();
    $('#userTYPE').val("user");
  } else {
    $("#Businesscheck").show();
    $('#userTYPE').val("user");
  }
  if(str == 'second')
  {
    $("#Businesscheck").hide();
    $("#hostFieldsBlock").show();
    $('#userTYPE').val("host");
    
    $("#host_category").val("108");

  }
  $(".v2_signup_overlay").fadeIn('slow');
  $('#v2_sign_up_after').fadeIn('slow');
  $(".v2_signup_overlay").css('display', 'block');

  $(".v2_sign_up").addClass('open').css('display','block');

  $(".v2_sign_up").removeClass('close');
  $(".v2_log_in").removeClass('open').addClass('close');
  
  return false;
}
</script>
  
  <script src="js/widgets.js"></script>
  <script src="js/functions.js"></script>
  <script src="js/functions2C.js"></script>
  <script src="js/app.js"></script>
</body>

</html>
<!-- footer end -->