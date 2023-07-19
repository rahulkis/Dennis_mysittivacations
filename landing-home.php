<!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <?php if($meta_description ==''){
            $meta_description = 'MysittiVacations | Travel Guide | Hotels | Flights';
        } ?>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
        <meta name="p:domain_verify" content="e570c841e1299de4037dc9f3f1b0a437"/>
        <title>MysittiVacations.com || <?php echo $titleofpage; ?></title>
        <meta name="title" content ="Flight and Hotel Packages: Find the Best Price Today " />
        <meta name="description" content="<?php echo $meta_description; ?>">
        <meta name="keywords" content=" Flight and hotel packages,Vacation Package Deals ">
        <!-- <meta name="description" content="We have array of deals on flight and hotel packages. No need to search flight and hotel offers separately; as we bring the best vacation package deals for you."/> -->
        <meta name="Book the most affordable flight and hotel packages" content="Book the most amazing vacation package deals with us. Choose from our range of best flight and hotel deals. So pack your bags and get ready to fly">
        <meta name="msvalidate.01" content="21025B23AD71A5AE65A5E9BEE98B829F" />
       <!--  <meta name="google-site-verification" content="g7Wlxf6fv_3B4dAY80nr2UDbfMpWBb14xf9qkKbPLmY" /> -->
        <meta name="google-site-verification" content="8tHP4f6J24juympQCcYSMhwZUHgHrePxIgx-H-bLRxw" />
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/new-css/bootstrap.min.css" async>

        <link rel="stylesheet" href="css/new-css/owl.carousel.min.css" type="text/css" async>
        <link rel="stylesheet" href="css/new-css/owl.theme.default.css" type="text/css" async>
        <link async href="https://mysittivacations.com/css/homePage.css" rel="stylesheet" type="text/css" async>
        <!--fontawesome CSS-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link href="css/owl.carousel.min.css" rel="stylesheet"> -->
  <link href="/mysitti-html/css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--AOS Animation CSS-->
        <link href="css/new-css/aos.css" rel="stylesheet" async>
        <!--datepicker CSS-->
        <link href="css/new-css/datepicker.min.css" rel="stylesheet"  media="wait" onload="if(media!='all')media='all'">

        <link rel="stylesheet" href="css/new-css/style.css" type="text/css">
        <link rel="stylesheet" href="css/new-css/mobile-style.css" type="text/css">
        
        <title>MysittiVacations.com || <?php echo $titleofpage; ?></title>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-157865826-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-157865826-1');
</script>
    <script type="text/javascript">
      !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t){var e=document.createElement("script");e.type="text/javascript";e.async=!0;e.src=("https:"===document.location.protocol?"https://":"http://")+"cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(e,n)};analytics.SNIPPET_VERSION="4.0.0";
      analytics.load("C2CqjCCpsi81VUIkVTmOud57gJGSSEZJ");
      analytics.page();
  }}();
</script>
<script type="text/javascript">
    (function(e,t,o,n,p,r,i){e.prismGlobalObjectAlias=n;e.pgo=e.pgo||function(){(e.pgo.q=e.pgo.q||[]).push(arguments)};e.pgo.l=(new Date).getTime();r=t.createElement("script");r.src=o;r.async=true;i=t.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)})(window,document,"https://prism.app-us1.com/prism.js","pgo");

    pgo('setAccount', '66416122');
    pgo('setTrackByDefault', true);

    pgo('process');
</script>
<?php
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
if(!$detect->isMobile()) {
 ?>
<script>setTimeout(function() {
    var headID = document.getElementsByTagName("head")[0];         
    var newScript = document.createElement('script');
    newScript.type = 'text/javascript';
    newScript.src = 'https://js.convertflow.co/production/websites/10476.js';
    headID.appendChild(newScript);
}, 15000);</script>
<?php } ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TNH7XQ7');</script>
<!-- End Google Tag Manager -->
<!-- <script async src=https://js.convertflow.co/production/websites/10476.js></script> -->
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TNH7XQ7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
  <header class="top-header fixed-top">
         <nav class="navbar navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand" href="#"><img src="/mysitti-html/images/logo.png"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          
          <li class="nav-item"><a class="nav-link contact-button" href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="63.985" height="20" viewBox="0 0 63.985 20">
            <g id="Group_674" data-name="Group 674" transform="translate(-1513.015 -55)">
            <text id="Trips" transform="translate(1556 72)" fill="#fff" font-size="16" ><tspan x="-20" y="0">Trips</tspan></text>
            <path id="download" d="M204.982,158.95a6.523,6.523,0,0,0-4.653,1.96,6.73,6.73,0,0,0-1.921,4.717,7.533,7.533,0,0,0,2.206,5.327l3.85,3.85a.731.731,0,0,0,1.033,0l3.85-3.85a7.533,7.533,0,0,0,2.207-5.327,6.73,6.73,0,0,0-1.921-4.717,6.522,6.522,0,0,0-4.653-1.96Zm-3.611,2.984a5.041,5.041,0,0,1,7.221,0,5.27,5.27,0,0,1,1.5,3.693,6.073,6.073,0,0,1-1.779,4.294l-3.334,3.334-3.334-3.334a6.073,6.073,0,0,1-1.779-4.294,5.269,5.269,0,0,1,1.5-3.693Zm2.15,3.589a1.461,1.461,0,1,1,1.461,1.461A1.461,1.461,0,0,1,203.522,165.523Zm1.461-2.921a2.921,2.921,0,1,0,2.921,2.921A2.922,2.922,0,0,0,204.982,162.6Z" transform="translate(1314.606 -101.789)" fill="#fff" fill-rule="evenodd"/>
            </g>
          </svg></a></li>
          <li class="nav-item"><a class="nav-link contact-button" href="#">Contact Us</a></li>
          </ul>
        </div>
        </div>
      </nav>
    </header>
    <?php
    if(empty($_SESSION['city_name'])) {
 ?>
        <div data-aos="zoom-in-right" class="banner-section" style="background-image:url(/mysitti-html/images/my-banner.png)"> 
         <div class="container">
        <div class="mobile-hero">
          <img src="/mysitti-html/images/mobile-hero.png">
        </div>
           <div class="carousel-caption-top">
           <h1>Get ready for your next vacation by checking out our website first.</h1>
          <p>Your life is busy, and there isn't enough time to organize your travel dates. That's why we're here: we have all the information you need to plan your next vacation. Check out our website; it's packed full of helpful information to help you find the best hotels, flights, tours, and more, making your planning easy.</p>
         </div>
   
       </div>
    </div>
  <?php } ?>
    <!--end of header-->
    <!-- National Parks Popup  -->
    <div class='modal my_modal' id='national_parks'  tabindex="-1" data-focus-on="input:first"  role='dialog'>
        <div class='modal-dialog modal-lg modal-dialog-scrollable'>
            <div class='modal-content guide_modal'>
              <div class="modal-header">
                <?php session_start();?>
                <h5 class="modal-title" id="exampleModalScrollableTitle" style="font-size: 28px;">See Beautiful <?php if ( $_SESSION['city_name'] ==''){ echo "America";} else { echo  $_SESSION['city_name'];} ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" style="font-size: 36px;padding: 16px;">&times;</span>
              </button>
          </div>
          <div class="audio_tour_modalss national_parsd modal-body">

          </div>
          <div class='modal-footer'>
              <button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
          </div>
      </div>
  </div>
</div> 
<div class='modal fade my_modal' id='groupon_discounts'  tabindex="-1" data-focus-on="input:first"  role='dialog'>
    <div class='modal-dialog modal-lg modal-dialog-scrollable'>
        <div class='modal-content guide_modal'>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle" style="font-size: 28px;">Discouted Tours</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" style="font-size: 36px;padding: 16px;">&times;</span>
          </button>
      </div>
      <div class="audio_tour_modalss national_parsd modal-body">
<?php

  function groupon_api_call($limit,$city,$key){
  $url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&address=".urlencode($_SESSION['city_name']);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
  $responseJson = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($responseJson);

  if ($response->status == 'OK') {
    $latitude = $response->results[0]->geometry->location->lat;
    $longitude = $response->results[0]->geometry->location->lng;
  } 
  if(!empty($city)):
    $prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
    // echo $prepAddr;
    $key = str_replace(' ','+',$key);
    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
    $output= json_decode($geocode);
    $latitude = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;
    $urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-4269)%20AND%20(category:things-to-do)&context=web_holiday&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=7";
    // endif;
  else:

    if(!empty($key)):
      $urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&offset=0&limit=".$limit."&locale=en_US";
    else:

     $urlgo = "https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-4269)%20AND%20(category:things-to-do)&context=web_holiday&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=30";
   endif;
    // endif;

 endif;
  // return $urlgo;
 $result_get = file_get_contents($urlgo);
 $get_all_data = json_decode($result_get, true);
 $get_deals = $get_all_data['deals'];
 return $get_deals;
}
$get_deals = groupon_api_call('3','','');
        $i= 0;
        foreach ($get_deals as $homeData):
           // print_r($get_deals);
          $price = $homeData['options'][0]['price']['formattedAmount'];
          $value = $homeData['options'][0]['value']['formattedAmount'];
          $discountPercent = $homeData['options'][0]['discountPercent'];
          $endAt =  $homeData['options'][0]['endAt'];
          $endDate = date('m/d/Y', strtotime($endAt));
          $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
          $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
          $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
          $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
          $tourname = $homeData['merchant']['name']; 
          $out =  substr($tourname,0,20).' ...';
           // if($discountPercent != 0){
             // $i++;
          ?>

          <div class="col-lg-4 all-inclusive section_<?php echo $i; ?>">
            <?php   $i++; 
            echo $homeData['cardHtml']; ?>
                
            </div>
          <?php // }  
            endforeach; ?>
      </div>
      <div class='modal-footer'>
          <button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
  </div>
</div>
</div>
<div class='modal fade' id='myModal-review' role='dialog'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
       <h4 class='modal-title'></h4>
      </div>
      <div class='tuorfun'>
         <ul class='modal-tour-review'>
        
      </ul>    
      </div>
      <div class='modal-footer'>
      <button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
    </div>
    
  </div>
</div>
<div class="modal fade popular-modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-4">
      <div class="modal-header">
        <i id="hitAjaxCity" class="fa fa-search" aria-hidden="true"></i>

        <input id="target"  type="name" value="" name="" class="geo geocontrast form-control" placeholder="Where to?" required="" aria-required="true" autocomplete="off">
        

    </div>
    <div class="modal-body">
        <div class="nearby-sec popular-sec">
            <h3> POPULAR DESTINATIONS</h3>
            <ul>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="New York">
                        <div class="popular img-sec">
                            <img src="images/city_images/newyork.jpg"  alt="New York" loading="lazy" >
                        </div>
                        <div class="popular content-sec">
                            <p>New York<span>New York, United States</span></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Miami Beach">
                        <div class="popular img-sec">
                            <img src="images/city_images/Miami_Beach.jpg" alt="Miami Beach" loading="lazy">
                        </div>
                        <div class="popular content-sec">
                            <p>Miami Beach <span>Florida, United States</span></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Chicago">
                        <div class="popular img-sec">
                            <img src="images/city_images/chicaaago.jpg" alt="Hotels in  chicaaago" loading="lazy">
                        </div>
                        <div class="popular content-sec">
                            <p>Chicago <span>Chicago, United States</span></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Austin">
                        <div class="popular img-sec">
                            <img src="images/city_images/Austin1.jpg" alt="Hotels in  Austin" loading="lazy">
                        </div>
                        <div class="popular content-sec">
                            <p>Austin <span>Texas, United States</span></p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
</div>
<div class='modal fade my_modal' id='subscribe'  tabindex="-1" data-focus-on="input:first"  role='dialog'>
    <div class='modal-dialog modal-md modal-dialog-scrollable'>
        <div class='modal-content guide_modal'>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle" style="font-size: 28px;">Sign Up</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" style="font-size: 36px;padding: 16px;">&times;</span>
          </button>
      </div>
      <div class="travel_inspiration_modalss travel_inspiration_parsd modal-body pb-4">
        <div class="sub_inner">
            <div class="container unsub_contain subs_form">
                <div class="row">
                    <div class="col-sm-12 col-md-12  unsub text-center">
                        <div class="heading_title mb-3"><h3>Subscribe?</h3></div>
                    </div>
                    <form action="https://mysittivacations.us20.list-manage.com/subscribe/post?u=0425720754466f04348f8e55f&amp;id=0e669ac09b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                       <div class="row">
                           <div class="col-md-12">
                            <label for="exampleInputEmail1" class="mb-2 text-center w-100">For Subscription Enter your Email Address</label>

                    </div>
                           <div class="col-md-8">
                        <div class="mc-field-group">
                            <div id="mce-responses" class="clear">
                            </div>
                            <input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL" aria-describedby="emailHelp" placeholder="Enter email" required>
                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group button_area_box"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button btn btn-primary bg-dark btn btn-primary button rounded-3">
                        </div>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.all.min.js"></script>
        <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';fnames[5]='MMERGE5';ftypes[5]='dropdown';fnames[6]='MMERGE6';ftypes[6]='radio';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
        <style>
            .joinCaptcha{
                padding: 7px;
            }
        </style>
        <script>
            $(document).ready(function(){
                $('#mc-embedded-subscribe').click(function(){
                    setTimeout(function(){ swal("Thanks for the subscribe"); window.location.replace("https://mysittivacations.com/"); }, 2000);
                })
            })
        </script>
        <script>
            $(function(){ 
                var navMain = $(".navbar-collapse");

                navMain.on("click", "a", null, function () {
                    navMain.collapse('hide');
                });
            });
        </script>
    </div>
    <!-- <div class='modal-footer'>
      <button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
   </div> -->
</div>
</div>
</div>

<style>
#cool_flight .item_content, .resturantclient .item_content, .foodtype .item_content {padding: 15px 15px;}
.desktop-filter {display: block;}
/*.image_htfix_mid img {height: 100%;}*/
.mobile-filter {display: none;}
.travels .grid img {object-fit: cover !important;}
.resturantclient .grid img, .foodtype .grid img {object-fit: cover;}
#cool_flight .item img, .resturantclient .item img, .foodtype .item img {object-fit: cover;}
.outer-landing-form #ContactFrom label {color: #000;margin: 0 0 8px;}
.outer-landing-form #ContactFrom input {height: 47px;border-radius: 2px;border: 1px solid #000 !important;font-size: 14px;padding: 0 15px;}
.v2_captcha input {width: 50% !important;}
.outer-landing-form #ContactFrom .v2_captcha input#captchacodeImage {border-left: 0 !important;margin: 0 !important;border-radius: 0 2px 2px 0;}
.outer-landing-form #ContactFrom .v2_captcha input#contact_captcha {border-radius: 2px 0 0 2px;margin: 0 !important;}
form#ContactFrom {padding: 10px 20px 20px;}
.outer-landing-form h1 {font-size: 24px;font-weight: bold;}
.outer-landing-form #ContactFrom input.submitsec-btn {width: 100%;background: #000;color: #fff;font-size: 15px; text-transform: uppercase;}
.outer-landing-form #ContactFrom input::placeholder {color: #a8a8a8 !important;}
.outer-landing-form #ContactFrom textarea {border: 1px solid #000;border-radius: 2px;height: 90px;}
.outer-landing-form #ContactFrom textarea::placeholder {color: #a8a8a8 !important;}
.image_htfix img {height: 240px;object-fit: cover;}
.blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item {padding-top: 0px!important;}
section.travels .travels_inner #city_deals_home .blissey-widget--l .blissey-gallery {height: 200px!important;min-height: 200px!important;}
@media screen and (max-width:767px){
  .desktop-filter {display: none;}
  .mobile-filter {display: block;}
  #cool_flight .owl-dots, .resturantclient .owl-dots, .foodtype .owl-dots {margin: 10px 0 0!important;}
  .content-bannersss { width: 100%;}
  .travels .grid img {border-radius: 10px!important;}
  .travels .grid img {border-radius: 10px;object-fit: cover;width: 100% !important;height: 200px !important;}
  .image_sq_htfix {height: 200px;}
  section.category li {width: 47%;margin: 0 8px 0 0;}
  section.category li a {font-size: 14px;}
  section.inner_page_hero.sec_pad {min-height: 15rem;padding-top: 20px;}
  section.category h4 {margin-bottom: 30px;}
  section.category {margin: 40px 0 40px;}
  .resturant_listhead .sorf-filter a {display: none;}
  .sorf-filter span {margin: 0 10px 0 0px;}
  .add_img {display: none;}
  .slider_nav .owl-nav.disabled {display: flex;margin: 0;}
  .heading {margin-bottom: 30px!important;}
  .owl-carousel .owl-item img {object-fit: cover;}
  .heading h4 {font-size: 28px;}
  .heading p {padding-left: 0px;}
  .heading {margin-bottom: 30px;}
  #our_blogs {padding: 50px 0;}
  .hero_section_content h2 {font-size: 32px;line-height: 42px;margin: 0 0 10px !important;}
  .general_nav#myHeader .check_class, .geo.geocontrast {font-size: 16px;border-radius: 4px;}
  #hitAjaxwithCity {right: 3px;top: 13px;width: 42px!important;background: #276ab5;padding: 13px;border-radius: 4px 4px;}
  .mobile-filter ul {display: flex;align-items: center;justify-content: space-around;flex-wrap: wrap;}
  .mobile-filter ul li a {font-size: 16px;}
  .mobile-filter ul li a i {margin: 0 10px 0 0px;}
  .mobile-filter {border-top: 1px solid #ccc;padding: 0px 0 0px;border-bottom: 1px solid #ccc;margin: 0 0 20px;}
  .mobile-filter ul li {width: 50%;text-align: center;border-right: 1px solid #ccc;padding: 15px;}
  .mobile-filter ul li:last-child {border: 0;}
  .filter_box {padding-right: 0px;}
  h5.filter-heading {margin-bottom: 20px;}
  .hero_section_img {padding-left: 0px;}
  .home_page p {font-size: 14px;padding-right: 0px!important;}
  .hero_section_content p {margin-top: 10px;margin-bottom: 30px;font-size:13px}
  section.hero_section {padding-top: 2em;}
  .home_page h5 {margin-top: 0px;font-size: 24px;}
  section.filter {margin-top: -48px;}
  section#home_filter {display: none;}
  .category li:nth-child(2), .category li:nth-child(4), .category li:nth-child(6), .category li:nth-child(8) {margin: 0 0px 0 0 !important;}
  #show_hhottel .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item {
    margin: 0 !important;}
  #cool_flight .owl-nav {margin-top: 0px;display: none!important;}
  .owl-dots{
    display:block !important;
  }
  #cool_flight .owl-dots, .resturantclient .owl-dots, .foodtype .owl-dots {
    display: block !important;
}
  .client .owl-nav, #our_blogs .owl-nav {display: none !important;}
  footer.footer.sec_pad { text-align: center;}
  .gateways_inner .image_htfix_mid img {position: initial;height: 100px;transform: initial;width: 100%;}
  .gateways_inner .image_htfix_mid {height: 100px;}
  .gateways .item_content h3 {font-size: 13px;margin-bottom: 0;white-space: initial;text-overflow: inherit;height: auto;
    letter-spacing: 0;}
  .gateways .item_content {padding: 15px 15px;}
  section.adds img {margin: 0 0 10px;}
  #cool_flight .item_content, .resturantclient .item_content, .foodtype .item_content {padding: 20px 15px;}
  #cool_flight .item_content h3, .resturantclient .item_content h3, .foodtype .item_content h3 { margin-bottom: 0px;}
  #cool_flight .image_htfix_mid {height: 160px;}
  /*.image_htfix_mid img {height: 100%;}*/
  #cool_flight .item_content, .resturantclient .item_content, .foodtype .item_content {padding: 15px 15px;}
  #cool_flight .image_htfix_mid img {height: 160px;object-fit: cover;}
  #cool_flight .image_htfix_mid {height: 160px;}
  .travels.sec_pad .image_sq_htfix {height: 200px;}
  .travels.sec_pad .image_sq_htfix h3 {font-size: 14px !important;}
  .travels.sec_pad h3 {font-size: 14px;left: 10px;}
  .travels_inner {margin-bottom: 0;}
  .bicycle_content h4 {text-align: center;}
  .bicycle_content .heading h4:after {display: none;}
  .slider_nav .owl-nav {margin-top: 0px; display: none!important}
  .travels.sec_pad.what_do h2 {margin: 0 0 10px !important;}
  #our_blogs .item img {max-height: 220px!important;height: 220px;}
  .outer-landing-form {max-width: 90%;height: auto;max-height: fit-content;}
  .image_htfix img {height: 240px;object-fit: cover;}
  section.inner_page_hero.sec_pad.city_bg p {margin-bottom: 0px;}
  .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item {margin: 0 !important;}
  .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item .blissey-info-price {
    align-items: center;display: flex !important;}
  .blissey-widget .blissey-info-price-wrapper {display: block!important;width: 230px!important;}
  .blissey-widget--m .blissey-info-price-wrapper-box, .blissey-widget--s .blissey-info-price-wrapper-box {display: flex;    align-items: center;}
  .hotel_style .blissey-widget .blissey-info-price-wrapper-discount {margin: 0 10px !important;}
  .blissey-widget--s .blissey-info-price-wrapper__total {font-size: 21px!important;}
}
</style>