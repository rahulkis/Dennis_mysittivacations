<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
$titleofpage="Travel Deals Online – Flights | Hotels | MySittiVacations"; 
$meta_description = "Check out our random deals! We know that you've been waiting for these! Here are some amazing discounts for you to enjoy! Check out this exciting electric knife! At $60 off, this is an absolute steal!Or maybe you're in the market for a new camera? We have a wide range of choices that'll fit your budget and needs. You can get a nifty camera for only $40 off! We have some more great deals for you! Check this out: an awesome laptop for only $500! Or maybe you're more of a tablet person? Our iPad 4 deal is absolutely sensational! How could you pass this up? We've got lots of great deals on our website and in-store. Don't miss out on your chance to grab them before they sell out! We're constantly searching for new deals. If you see something you like, click through to find out where you can get it. We're constantly searching for new deals. If you see something you like, click through to find out where you can get it.
We love our customers and want them to have the best possible experience with us. That's why we are offering the best deals on flights, hotels, cruises, and more. Whether you want to go on a road trip, visit a new city, or take a cruise, we have deals for you!
There’s nothing like the feeling of flying solo across the country. And now, you don’t have to worry about the hassle of planning out your entire trip. Just sign up for a deal flight and we’ll take care of the rest!
The feeling you get when you're on a plane headed toward your destination is one of a kind. The feeling of freedom is tangible as you soar over land and sea, soaring past old obstacles and toward new horizons. It's refreshing to know that you're in control of your own destiny, free to make your own decisions, and free to change the course of your own life. While this freedom is liberating at first, it can be a terrifying prospect when you realize the amount of responsibility that it creates. However, with a little bit of courage, you'll soon realize that it's a liberating and exciting experience! Our random flight deals from Austin to anywhere in the United States are great for your next vacation. If you want a cheap flight, this is the best way to find one.
Our deals are random, so you'll never know what you'll get. Plus, we'll give you a discount on the flight! We’re giving you the chance to fly to some of our favorite destinations for a truly random amount of money. Just click the 'Book Now' button and your next destination will be chosen at random. Your life is full of adventure, and there are so many things you want to see. We can help you make those dreams come true! If you are planning a family getaway or a romantic trip, you have to make sure you have everything organized as far in advance as possible.
There's nothing worse than showing up at the airport and realizing that you forgot to book your flight or hotel. So, that's where My Sitti Vacations comes in. Check out our website for all the information you'll need to plan a fun getaway or your next business trip.";
session_start();
if(isset($_GET['dream_city'])){
	$_SESSION['city_name']  = $_GET['dream_city'];
	$_SESSION['formatteds'] = $_GET['dream_city'];
}
if(isset($_GET['city'])){
	$_SESSION['city_name']  = $_GET['city'];
    $_SESSION['full_city_name']  = $_GET['city'];
	$_SESSION['formatteds'] = $_GET['city'];
}
if(isset($_GET['from_name'])){
	$_SESSION['city_name']  = $_GET['from_name'];
	$_SESSION['formatteds'] = $_GET['from_name'];
}?>
<script  src="js/jquery-1.11.0.min.js"></script>
<!-- <script  src="js/bootstrap.js"> </script>  -->
<!-- <script  src="js/jquery.min.js"></script> -->
<!-- <script  src="js/bootstrap.min.js"></script> -->
<?php
//include('Header.php');	// not login
include("randomHeader-dev.php");

$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
<style>

/*02-11-2022 css*/

.feature-section.icon-sec ul {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 50px 0px 0px;
}
.feature-section.icon-sec li img {
    width: 25px;
    height: 25px;
    object-fit: contain;
    position: relative;
    top: -3px;
    margin: 0px 10px 0px 0px;
}
.feature-section.icon-sec ul li {
    display: inline-block;
    background: rgb(255, 170, 0);
    padding: 15px 20px;
    margin: 0px 5px 0px 0px;
    font-size: 21px;
    color: rgb(255, 255, 255);
    line-height: 33px;
	width: 14.666%;
}
.feature-section.icon-sec ul li span{
    display: block;
	font-size:20px;
}
.feature-section.icon-sec ul li:first-child {
    border-radius: 5px 0px 0px 5px;
}
.feature-section.icon-sec ul li:last-child {
    border-radius: 0px 5px 5px 0px;
    margin: 0px;
}

/*02-11-2022 css*/

.discounts_inner figure.card-ui {
	box-shadow: rgb(0 0 0 / 10%) 0px 4px 12px;
	border-radius: 4px;
	margin: 0;
	height: 100%;
    position: relative;
}
.discounts_inner li {
	/*height: 100%;*/
}
img.cui-image.lazy-load {
    display: none ;
}
.discounts_inner figure.card-ui .cui-udc-image-container img {
	/*height: 168px;*/
	width: 100%;
	object-fit: cover;
	border-radius: 4px;
	  position: relative !important;
}
.discounts_inner figure.card-ui .cui-udc-details {
	padding:16px;
	position: relative;
}  
.discounts_inner figure.card-ui .cui-udc-details .cui-udc-title.one-line-truncate {
    font-size: 20px;
    margin-bottom: 8px;
    text-transform: capitalize;
    font-weight: 300;
    padding-bottom: 30px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
    width: 100%;
}
.top-header .navbar ul li a.nav-link.contact-button {
    letter-spacing: .5px;
    padding: 15px 35px;
    border-radius: 100px;
    color: #fff;
    font-size: 16px;
    margin: 0 10px;
    background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa);
    border: none;
    height: 50px;
    text-transform: capitalize;
    font-weight: 400;
    font-family: poppins,sans-serif;
}
.discounts_inner figure.card-ui .rating-count {
	display: none;
} 
.discounts_inner figure.card-ui .cui-udc-subtitle.one-line-truncate {
	position: absolute;
	top: 63px;
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
}
/*
.discounts_inner figure.card-ui .cui-location .cui-location-name:before {
	content: "\f279";
	font-family: "Font Awesome 5 Free";
	position: absolute;
	left: 0;
	font-weight: 900;
	font-size: 12px;
	top: 2px;
}
*/
.discounts_inner figure.card-ui .cui-location .cui-location-name {
	position: relative;
/*	padding-left: 20px;*/
}
.discounts_inner figure.card-ui .cui-price {
	display: flex;
	margin: 10px 0;

}
.discounts_inner figure.card-ui .cui-price .cui-price-original {
	text-decoration: line-through;
}
.discounts_inner figure.card-ui .cui-price .cui-price-discount {
	color: #276ab5;
	font-weight: bold;
	margin-right: 3px;
}

.discounts_inner figure.card-ui .cui-price-original.c-txt-gray-dk {
	margin-right: 3px;
}
.discounts_inner figure.card-ui .cui-combined-section {
	position: relative;
	display: flex;
	padding-bottom: 5px;
	align-items: center;
	padding-left: 0;
	padding-right: 46px;
}
.discounts_inner figure.card-ui .cui-verbose-urgency-text {
	position: absolute;
	bottom: 0;
	left: 0;
	padding-left: 30px;
}
.discounts_inner figure.card-ui .cui-verbose-urgency-price {
	font-weight: 700;
	color: #276ab5;
	margin-left: 10px;
}
.discounts_inner figure.card-ui .cui-price-original.c-txt-gray-dk:before {
	content:none;
} 
.discounts_inner figure.card-ui .cui-verbose-urgency-text:before {
	position: absolute;
	content: "\f017";
	left: 0;
	font-weight: 900;
	font-family: "Font Awesome 5 Free";
	font-size: 14px;
	top: 2px;
}
.discounts_inner figure.card-ui .cui-view-deal {
	position: absolute;
	right: 20px;
	bottom: 30px;
	width: 40px;
	height: 40px;
	background: #276ab5;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 50%;
	display: none;
}
.discounts_inner figure.card-ui .cui-view-deal .btn:before {
	position: absolute;
	content: "\f054";
	left: 0;
	font-weight: 900;
	font-family: "Font Awesome 5 Free";
	font-size: 16px;
	top: 50%;
	color: #fff;
	left: 50%;
	transform: translate(-50%, -50%);
}
.discounts_inner figure.card-ui .cui-view-deal .btn {;
	font-size: 0;
	opacity: 1;
} 
.discounts  .heading .btn {
	position: relative;
	z-index: 1;
}
.discounts_inner figure.card-ui .cui-price-discount.cui-verbose-urgency-pricing {
    text-decoration: line-through;
    font-weight: normal;
    color: #212529;
}
.discounts_inner figure.card-ui .cui-combined-section .cui-detail-badge.cui-discount-badge {
    display: flex;
    white-space: nowrap;
}
.discounts_inner figure.card-ui .cui-location.cui-truncate.cui-has-distance{
   padding-left: 0;
}
.discounts_inner figure.card-ui .cui-location.cui-truncate.cui-has-distance:before,.discounts_inner figure.card-ui .cui-udc-details.cui-udc-left-aligned-details:before,.discounts_inner figure.card-ui .cui-combined-section:before{
  content: none;
}
.discounts_inner figure.card-ui::before {
    position: absolute;
    content: "\f054";
    font-weight: 900;
    font-family: "Font Awesome 5 Free";
    font-size: 16px;
    color: #fff;
    right: 15px;
    bottom: 22px;
    width: 40px;
    height: 40px;
    background: #276ab5;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}
    
.deals_gateways_sec .card-ui.cui-c-udc {
    padding: 5px;
    box-shadow: 5px 5px 48px #0000002b;
    border-radius: 18px;
    background: #fff;
}
.deals_gateways_sec .cui-image-lazy-container img {
    height: 240px;
    object-fit: cover !important;
    border-radius: 15px !important;
}
.deals_gateways_sec .cui-udc-title.one-line-truncate {
    font-weight: 500;
    margin: 0 0 10px;
    font-size: 24px;
    font-family: ubuntu,sans-serif;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 34px;
}
.deals_gateways_sec .cui-udc-details {
    position: relative;
}
.deals_gateways_sec .cui-udc-details {
    position: relative;
    background: #08a0e636;
    border-radius: 15px;
    padding: 15px;
    text-align: left;
    align-items: center;
    justify-content: space-between;
    margin-top: 100px;
    padding-right: 80px;
    min-height: 105px;
}

.deals_gateways_sec .cui-udc-details .cui-single-section:nth-child(1) {
    background: #fff;
    text-align: left;
    position: absolute;
    top: -83px;
    left: 10px;
    width: 98%;
}
.deals_gateways_sec .cui-bottom-body .cui-single-section:nth-child(2) {
    position: absolute;
    top: -43px;
    left: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 24px;
}
 .free-trail-form .search-content {
    margin: 20px auto !important;
    max-width: 850px;
}   
.search-content.hotels ul li .form-group {
    margin: 10px;
    }
.deals_gateways_sec  .cui-review-rating,.groupon_discount_sec .cui-bottom-body .cui-single-section:nth-child(3){
    display: none;
}
.deals_gateways_sec .cui-udc-details .cui-single-section:nth-child(3) {
    font-weight: 500;
    font-family: 'Poppins';
}
.deals_gateways_sec  .cui-price {
    display: flex;
}
.deals_gateways_sec .cui-price-discount.c-txt-price {
    white-space: nowrap;
    display: flex;
    margin-left: 5px;
    font-weight: 500;
    font-family: 'Poppins';
}
.deals_gateways_sec .cui-price-descriptor,.groupon_discount_sec .cui-view-deal{
    display: none;
}
.deals_gateways_sec .cui-promotions {
    display: inline-block;
    float: left;
    margin-left: 5px;
}
.deals_gateways_sec .cui-price {
    display: flex;
    width: auto;
    float: left;
}
.deals_gateways_sec .cui-combined-section:after {
    content: "";
    clear: both;
    display: block;
}   
.deals_gateways_sec .cui-price-original:first-letter {
    color: #000;
    font-weight: 500;
    font-family: 'Poppins';
}
.deals_gateways_sec .cui-price-original,.groupon_discount_sec .cui-discount-badge{
    color: #575757;
}
.deals_gateways_sec .all-inclusive:nth-child(4) .cui-udc-details:after {
    background-image: url(./images/right-saff.png);   
}
.deals_gateways_sec .all-inclusive:nth-child(4) .cui-udc-details{
    background: #fe6e003d;    
}
.deals_gateways_sec .all-inclusive:nth-child(6) .cui-udc-details{
   background: #00ae5d36;      
}   
.deals_gateways_sec .all-inclusive:nth-child(6) .cui-udc-details:after {
    background-image:url(./images/right-green.png);   
}
.deals_gateways_sec .cui-location{ 
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 24px;
}
.deals_gateways_sec .discounts_inner .cui-verbose-urgency-text,.deals_gateways_sec .discounts_inner .cui-quantity-bought{
    display: none;
}
.deals_gateways_sec .view-tag .groupon_discount {
    width: 170px;
}    
.search-content ul li #hitAjaxwithCity {
    background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa);
    letter-spacing: .5px;
    padding: 10px 25px;
    border-radius: 100px;
    color: #fff;
    font-size: 21px !important;
    text-decoration: none;
    height: 75px;
    display: block;
    text-align: center;
    line-height: 60px;
    position: absolute;
    right: 0;
    top: 0;
    width: 200px !important;
}
.search-content input#target_location {
    margin: 0;
}  
.blissey-widget .blissey-widget-body-hotels-compact-list {
    margin: 0!important;
    display: flex;
    align-items: start;
    justify-content: space-between;
    flex-wrap: wrap;
}
.blissey-widget .blissey-widget-body-hotels-compact-list__item {
   min-height: initial!important;
    width: 47%;
    padding: 5px !important;
    box-shadow: 5px 5px 48px #0000002b !important;
    border-radius: 20px !important;
    background: #fff !important;
    margin: 0 10px 20px !important;
}
.blissey-widget .blissey-widget-body-hotels-compact-list-item-info {
    position: initial !important;
    margin: 10px 0 10px 0px!important;
} 
.blissey-widget .blissey-widget-body-hotels-compact-list-item-gallery {
    float: initial !important;
    margin-right: 0px!important;
    width: 100% !important;
    height: 300px;
    min-height: initial !important;
        border-radius: 15px !important;
    overflow: hidden;
}
.blissey-widget .blissey-info {
    padding: 0 !important;
}
.blissey-widget .blissey-widget-body-hotels-compact-list-item-info .blissey-info-price {
    position: initial !important;
    width: 100%!important;
    text-align: left !important;
    display: flex !important;
    float: right!important;
    align-items: center;
    background: #08a0e640 !important;
    padding: 20px !important;
    border-radius: 15px;
}
.blissey-widget .blissey-info-price-wrapper-button a {
    display: inline-block!important;
    padding: 0px 25px!important;
    height: 40px!important;
    text-decoration: none!important;
    text-transform: uppercase!important;
    white-space: nowrap!important;
    font-size: 14px!important;
    font-weight: 600!important;
    line-height: 40px!important;
    background: #ff8e01!important;
    background-color: #fe6e00 !important;
    border-radius: 30px !important;
    color: #fff !important;
}
.blissey-widget .blissey-widget-body-hotels-compact-list-item-info .blissey-info-price-wrapper__total {
    margin-top: -3!important;
    font-size: 21px!important;
    margin-left: 15px !important;
}
.blissey-widget .blissey-info-details-rating__decimal {
    margin-right: 0px!important;
    background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa) !important;
}
.blissey-widget .blissey-widget-body-hotels-compact-list-item-info .blissey-info-details-specification__hotel_name {
    width: 100%!important;
    color: #000 !important;
}
.blissey-widget .blissey-widget-body-hotels-compact-list-item-info .blissey-info-details-specification>div {
    overflow: visible;
}
.blissey-widget .blissey-widget-body-hotels-compact-list-item-info .blissey-info-details-specification__distance {
    position: relative !important;
    top: 0 !important;
    left: 0!important;
}
.blissey-widget .blissey-info-price-wrapper {
    width: 100%!important;
}
.blissey-widget .blissey-info-details-specification {
    width: 100%!important;
    margin: 10px 0 10px !important;
}
.blissey-widget .blissey-widget-body-hotels-compact-list-item-info .blissey-info-price-wrapper-button {
    position: relative !important;
}
.blissey-widget .blissey-widget-body-hotels-compact-list-item-info .blissey-info-details-rating {
    position: initial !important;
}
.blissey-info-price-wrapper-box {
    display: flex;
    align-items: start;
    flex-wrap: wrap;
}
.blissey-info-price-wrapper-box .blissey-info-price-wrapper__text {
    width: 100%;
    text-align: left !important;
}
.item.groupon_item.df .item_content,.item.groupon_item.pl .item_content,.item.groupon_item.er .item.groupon_item.pl .item_content{
    height: calc(100% - 185px);
    padding: 15px 15px;
}

.item.groupon_item.df,.item.groupon_item.pl,.item.groupon_item.er {
    padding: 5px;
    box-shadow: 5px 5px 48px #0000002b;
    border-radius: 18px;
    background: #fff;
}
.item.groupon_item.er .gateways .item_content {
    padding: 15px 15px;
    height: calc(100% - 180px);
}
.gateways .item .item_content span i {
    font-weight: 600;
    font-size: 14px;
}
.item.groupon_item.df .image_htfix_mid,.item.groupon_item.pl .image_htfix_mid,.item.groupon_item.er .image_htfix_mid{
    border-radius: 15px;
}
.item.groupon_item.er .item_content {
    padding: 15px 15px;
    height: calc(100% - 180px);
}
.item.groupon_item.er .item_content span i {
    font-weight: 600;
    font-size: 14px;
}
.gateways_inner.deals_gateways.slider_nav.deals_gateways_sec {
    padding-bottom: 100px;
}
.item.groupon_item.df .item_content p.address,.item.groupon_item.pl .item_content p.address,.item.groupon_item.er .item_content p.address {
    font-size: 20px;
    margin-bottom: 0;
    text-transform: capitalize;
    font-weight: 700;
    color: #000;
}
.gateways_inner.deals_gateways.slider_nav.deals_gateways_sec .heading, {
    margin: 40px 0;
}
.vacation_deals .item_content {
    height: auto !important;
    background: #fff;
    position: absolute;
    bottom: 15px;
    text-align: center;
    margin: 0 auto;
    width: 85%;
    color: #000;
    left: 0;
    right: 0;
    padding: 15px 0;
    border-radius: 40px;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}
.vacation_deals {
    position: relative;
    margin-bottom: 0px;
}
.vacation_deals .image_htfix_mid {height: 200px;}
.vacation_deals .image_htfix_mid img {
    height: 100% !important;
}
.discount-block img {
    border-radius: 15px;
}
@media screen and (max-width: 991px){
	.discounts_inner figure.card-ui {
		margin-right: 0;
	}  
	.discounts_inner .all-inclusive {
		margin: 20px 5px;
	}
}
@media screen and (max-width: 767px){
    .feature-section.icon-sec ul {
        flex-wrap: wrap;
    }
    .heading h4 {
    font-size: 22px;
}
    .feature-section.icon-sec ul li {
        margin: 0px 5px 10px 0px;
        width: 48%;
    }
    .gateways .deals_gateways .item img {
        width: 100%;
    }
    .new-for .heading-content {
        flex-wrap: initial;
    }
    .blissey-widget .blissey-widget-body-hotels-compact-list__item {
        width: 100%;
        margin: 0 0px 20px !important;
    }
    .blissey-widget {
         border: 0px solid #eee!important;
        }
    .blissey-widget--s .blissey-widget-body-hotels-compact-list-item-info .blissey-info-price {
        margin: 0px 0 0px 0px!important;
    }
    .blissey-widget--s .blissey-widget-body-hotels-compact-list-item-info .blissey-info-price-wrapper-box {
    width: auto !important;
}
    .banner-section.hotel-hero .mobile-hero img {height: 200px;object-position: left;}
    button.navbar-toggler {
        background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 30px;
    }
    .view-all-sec {
        top: 0;
    }
}

</style>
<input type="hidden" id="target" value="<?php if(isset($_SESSION['city_name']) && !empty($_SESSION['city_name'])){ 
	$newCitty = str_replace(' ', '%20',$_SESSION['city_name']);
	echo $newCitty;} ?>">
<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> -->
	<!-- <link rel="stylesheet" type="text/css" href="css/randDeal.css"> -->

	<script type="text/javascript">

		$(document).ready(function() {
			$("body").on('click', '.top', function() {
				$("nav.menu").toggleClass("menu_show");
			});
			if (window.matchMedia("(max-width: 767px)").matches)  
				{ $('.incase_mobile').css('display','block');
			$('.incase_desktop').css('display','none');
		} else { 
			$('.incase_mobile').css('display','none');

		} 
		$('.menu_icon').click(function() {

			$('html, body').animate({
				scrollTop: $("#myCarousel").offset().top
			}, 1000);
		})
	});
</script>
<style>
</style>
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
      $key = str_replace(' ','+',$key);
      $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
      $output= json_decode($geocode);
      $latitude = $output->results[0]->geometry->location->lat;
      $longitude = $output->results[0]->geometry->location->lng;

      $urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)%20AND%20context=web_getaways&showBestOption=true&divisionLoc=41.184,-96.15&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
    // endif;
    else:

      if(!empty($key)):
        if($key == 'restaurants'){
          $urlgo = "https://www.groupon.com/occasion/deals-json?filterQuery=(subcategory:".$key.")&context=web_holiday&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=".$limit;
        } else {
          $urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)&context=web_getaways&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=".$limit;
        }
      else:
        $urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)%20AND%20context=web_getaways&showBestOption=true&divisionLoc=41.184,-96.15&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=".$limit;
      endif;
    endif;
    $result_get = file_get_contents($urlgo);
    $get_all_data = json_decode($result_get, true);
    $get_deals = $get_all_data['deals'];
    return $get_deals;
  }
?>
<!--<section class="inner_page_hero sec_pad deals_hero">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="hero_section_content">
					<h2>Check out our deals!</h2>
					<p>Find the best deals online for booking your trip.</p>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="content-bannersss">
					<input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

					<input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php //echo $_SESSION['full_city_name'];?>" required="">

					<a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><img src="/css/optimize/images/search.png" alt=""></a>
				</div>
			</div>
		</div>
	</div>
</section>-->
<div data-aos="zoom-in-right" class="banner-section hotel-hero city-hero" style="background-image:url(images/Deals.jpg)"> 
			<div class="container">
				<div class="mobile-hero">
					<img src="images/Deals.jpg">
				</div>
				<div class="carousel-caption-top">
				   <h1>Check Out Our Deals!</h1>
				   <p>Find the best deals online for booking your trip.</p>
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
<!--end of hero section-->
<?php include('category-newfile.php'); ?>


<div class="feature-section icon-sec">
		    <div class="container">
				<div class="row <?php  
					if(isset($_SESSION['city_name'])){ echo "justify-content-center"; } ?>">
					<?php  
					if(isset($_SESSION['city_name'])){
						$random_list_specific = "random_list_specific";
					}else{
						$random_list_specific = "";
					}
					?>
					<div class="col-md-12 col-12">
						<ul>
                            <?php if(empty($_SESSION['city_name'])) { ?>
							<li class="<?php echo $random_list_specific; ?> <?php if(empty($_SESSION['city_name']) && empty($_SERVER['QUERY_STRING']) && $_SERVER['SCRIPT_NAME'] == '/random_deals.php'){ echo 'active'; }
				elseif(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'All-Inclusive'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'All-Inclusive'){ echo 'active'; } ?>"> <a  class="random_vacation general_page_link" data="All-Inclusive" ><img src="https://www.mysittivacations.com/images/ic.png"><span> All Inclusive</span></a></li>
            <?php } ?>
							<li class="<?php echo $random_list_specific; ?> <?php 
						if(empty($_SESSION['city_name']) && isset($_GET['keyword']) && $_GET['keyword'] == 'Hotels'){
						echo 'active'; 
						}elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Hotels'){ 
						echo 'active'; 
						} ?>"><a class="random_flight general_page_link" data="Hotels" ><img src="https://www.mysittivacations.com/images/ic1.png"><span> Hotels</span></a></li>
							<li class="<?php echo $random_list_specific; ?> <?php 
				if(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Flights'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Flights'){ echo 'active'; }       ?>"><a class="random_flight general_page_link" data="Flights"><img src="https://www.mysittivacations.com/images/ic3.png"><span> Flights</span></a></li>
							<li class="<?php echo $random_list_specific; ?> <?php 
				if(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Vacations'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Vacations'){ echo 'active'; }       ?>"><a class="random_vacation general_page_link"  data="Vacations"><img src="https://www.mysittivacations.com/images/ic4.png"><span> Vacations</span></a></li>
							<li class="<?php echo $random_list_specific; ?>  <?php if(!empty($_SESSION['city_name']) && empty($_SERVER['QUERY_STRING']) && $_SERVER['SCRIPT_NAME'] == '/random_deals.php'){ echo 'active';}
				elseif(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Tours'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Tours'){ echo 'active'; }elseif(empty($_SESSION['city_name']) && isset($_GET['keyword']) && $_GET['keyword'] == 'Tours'){ echo 'active';}?>"><a class="random_tours general_page_link" data="Tours"><img src="https://www.mysittivacations.com/images/ic5.png"><span>Tours</span></a></li>
							<li class="<?php 
					if(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Cruises'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Cruises'){ echo 'active'; }       ?>"><a class="random_vacation general_page_link" data="Cruises"><img src="https://www.mysittivacations.com/images/ic6.png"><span>Cruises</span></a></li>
                    <li class="<?php 
                    if(isset($_GET['flag']) && $_GET['flag'] == 'adventure'){ echo 'active'; } ?>"><a class="random_vacation general_page_link" data="adventure"><img src="https://www.mysittivacations.com/images/ic6.png"><span>Adventures</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>





<section class="gateways sec_pad">
	<div class="container">
		 <a href="https://www.kqzyfj.com/click-8265264-15317769" target="_top">
<img src="https://www.tqlkg.com/image-8265264-15317769" width="628" height="100" alt="" border="0" style="display: block;
  margin-left: auto;
  margin-right: auto;padding-bottom: 10px;" /></a>
		<div class="gateways_inner deals_gateways slider_nav deals_gateways_sec">
			<div class="row">
				<div class="discounts_inner">
					<div class="row">
                        <?php  if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'adventure'){
                          ?>
                          <div class="col-lg-3 col-md-6">
            <div class="item groupon_item df">
                <a href="https://www.dpbolvw.net/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fgalapagos-central-south-east-aboard-yolita%2FSEV10YB%2F&cjsku=SEV10YB">
                    <div class="image_htfix_mid "> 
                        <img src="images/my1.jpg" alt="" class="img-fluid w-100">
                    </div>
                    <div class="item_content final_advt" style="padding-bottom:30px !important">
                        <p class="address">South America</p>
                    </div>
                </a>
            </div>
        </div>      <div class="col-lg-3 col-md-6">
            <div class="item groupon_item df">
                <a href="https://www.kqzyfj.com/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fa-month-in-central-america-beyond-tulum-and-tikal%2FCMMG%2F&cjsku=CMMG">
                    <div class="image_htfix_mid "> 
                        <img src="images/my2.jpg" alt="" class="img-fluid w-100">
                    </div>
                    <div class="item_content final_advt">
                        <p class="address">Central America</p>
                    </div>
                </a>
            </div>
        </div>      <div class="col-lg-3 col-md-6">
            <div class="item groupon_item df">
                <a href="https://www.anrdoezrs.net/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fhimalayan-adventure-india-nepal-bhutan%2FAHDB%2F&cjsku=AHDB">
                    <div class="image_htfix_mid "> 
                        <img src="images/my3.jpg" alt="" class="img-fluid w-100">
                    </div>
                    <div class="item_content final_advt">
                        <p class="address">Asia</p>
                    </div>
                </a>
            </div>
        </div>     
         <div class="col-lg-3 col-md-6">
            <div class="item groupon_item df">
                <a href="https://www.jdoqocy.com/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fsouthern-africa-tour%2FDAVV%2F&cjsku=DAVV">
                    <div class="image_htfix_mid "> 
                        <img src="images/my1.jpg" alt="" class="img-fluid w-100">
                    </div>
                    <div class="item_content final_advt" style="padding-bottom:30px !important">
                        <p class="address">Africa</p>
                    </div>
                </a>
            </div>
        </div>  
        <div class="col-lg-3 col-md-6">
            <div class="item groupon_item df">
                <a href="https://www.tkqlhce.com/click-8265264-13486737">
                    <div class="image_htfix_mid "> 
                        <img src="https://www.yceml.net/0657/13486737-1614271633911" alt="" class="img-fluid w-100">
                    </div>
                    <div class="item_content final_advt" style="padding-bottom:30px !important">
                        <p class="address">Wellness</p>
                    </div>
                </a>
            </div>
        </div>  <div class="col-lg-3 col-md-6">
            <div class="item groupon_item df">
                <a href="https://www.jdoqocy.com/click-8265264-13486755">
                    <div class="image_htfix_mid "> 
                        <img src="https://www.yceml.net/0675/13486755-1614271633806" alt="" class="img-fluid w-100">
                    </div>
                    <div class="item_content final_advt" style="padding-bottom:30px !important">
                        <p class="address">Find Your Balance</p>
                    </div>
                </a>
            </div>
        </div>
                      <?php  }?>
    <?php  if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'All-Inclusive'){
        $endpoint = "https://ads.api.cj.com/query";
$authToken = "45agzktndc3f016pmtwwfdev51";
$qry = '{ travelExperienceProducts(companyId: "4882762", partnerIds:"5840172",keywords: "Caribbean resorts", limit: 80 ) {totalCount,limit,resultList { advertiserId,advertiserName,categoryName, catalogId, id, title, description,sourceFeedType,imageLink,link,locationName, salePrice {amount,currency} price {amount, currency} linkCode(pid: "8265264") {clickUrl } }  } }';

$headers = array();
// $headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer '.$authToken;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $qry);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$dataGroupon = json_decode($result,true);
        ?>
        <div class="discounts_inner">
        <div class="row">
          
          <?php 
            foreach ($dataGroupon['data']['travelExperienceProducts']['resultList'] as $key => $value) {
                $percent = (($value['price']['amount'] - $value['salePrice']['amount'])*100) /$value['price']['amount'] ;
                ?>
             
          <div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4 aos-init aos-animate">
            <div class="discount-block">
              <img src="<?php echo $value['imageLink'] ?>">
              <div class="discount-content">
              <h3><?php echo substr($value['title'],0,20).'...'; ?></h3>
              <p><?php echo substr($value['description'],0,40).'..'; ?></p>
              </div>
              <div class="discount-action purple-bg">
              <div class="action-content">
              <p><b><?php echo $value['locationName']; ?></b> <span><b>$</b> <?php echo $value['price']['amount']; ?> <b>$<?php echo $value['salePrice']['amount']; ?></b> <?php echo number_format($percent); ?>% OFF</span></p>
              </div>
              <a href="<?php echo $value['linkCode']['clickUrl'] ?>" target="_top"><img src="/mysitti-html/images/right-blue.png"></a>
              </div>
            </div>
         
          </div>
        <?php
            }
        ?>
           <div class="view-all-sec">
              <div class="view-tag aos-init aos-animate" data-aos="zoom-in-down">
              <a href="#">View All</a>
              </div>
            </div>
        </div>
      </div>


    <?php } ?>
</div>
</div>
<?php if(isset($_GET['keyword']) || $_GET['keyword'] == 'Hotels'){?>
	<div class="heading">
		<h4 class="deal_h2_flight">Hotel Deals</h4>
	</div>
	<?php
	$general_flight = "SELECT * FROM  hotelDeal_landingPage limit 40";
	$general_result = $mysqli->query($general_flight);
	foreach ($general_result as $key => $value) {?>
		<div class="col-lg-3 col-md-6">
			<div class="item groupon_item df">
				<a href="redirect_aff.php?logo=tphotel&url=<?php echo $value['buyurl'] ; ?>">
					<div class="image_htfix_mid "> 
						<img src="<?php echo $value['imageurl']; ?>" alt="" class="img-fluid w-100">
					</div>
					<div class="item_content">
						<p class="address"><?php echo $value['city']; ?></p>
					</div>
				</a>
			</div>
		</div>
	<?php } 
} 
if(isset($_GET['flag']) && !empty($_GET['flag']) && empty($_GET['city']) && empty($_GET['from_name']) &&  $_GET['flag'] == 'Flights'){?>
	<div class="heading">
		<h4 class="deal_h2_flight">Today's Flight Deals From</h4></div>
		<!-- <div class="timer">(Time Remaining <span class="countdown"> </span>)</div> -->

		<?php $sql = "SELECT name,image_url FROM popular_cities limit 40";
		$result = $mysqli->query($sql);
		foreach ($result as $key => $value) {?>
			<br>
			<div class="col-lg-3 col-md-6">
				<div class="item groupon_item pl">
					<a href="random_deals.php?flag=Flights&from_name=<?php echo $value['name']; ?>&from_to=United state">
						<div class="image_htfix_mid"> 
							<img src="<?php echo str_ireplace( 'http:', 'https:', $value['image_url'] ); ?>"  class="img-fluid w-100"/>
						</div>
						<div class="item_content">
							<p class="address"><?php echo $value['name']; ?></p>
						</div>
					</a>
				</div>
			</div>
		<?php }
	} if(isset($_GET['flag']) && !empty($_GET['flag']) && isset($_GET['from_name']) &&  $_GET['flag'] == 'Flights'){
		if($_SESSION['city_name'] == 'Clearwater'){
			$flightCity = 'Tampa';
		}elseif($_SESSION['city_name'] == 'Siesta Key'){
			$flightCity = 'Sarasota';
		}elseif($_SESSION['city_name'] == 'Lahaina'){
			$flightCity = 'Maui';
		}elseif($_SESSION['city_name'] == 'St. Pete Beach'){
			$flightCity =  'Tampa';
		}elseif($_SESSION['city_name'] == 'Wailea'){
			$flightCity = 'Maui';
		}elseif($_SESSION['city_name'] == 'Puako'){
			$flightCity = 'Kailua-Kona';
		}elseif($_SESSION['city_name'] == 'Manhattan Beach'){
			$flightCity = 'Los Angeles';
		}elseif($_SESSION['city_name'] == 'Jekyll Island'){
			$flightCity ='Jacksonville';
		}elseif($_SESSION['city_name'] == 'La Jolla'){
			$flightCity ='San Diego';
		}elseif($_SESSION['city_name'] == 'Virginia Beach'){
			$flightCity ='Norfolk';
		}else{
			$flightCity = $_SESSION['city_name'];
		}
		$popular = "SELECT * FROM continantal WHERE   city_name = '".$flightCity."'";
		$result = $mysqli->query($popular);
		$count = $result->num_rows;
		if($count > 0){
			foreach ($result as $key => $value) {
				$iata = $value['iata'];
			}
		}else{
			$iata ='CHI';
		}
		if($_SESSION['city_name'] == 'Washington D.C.'){
			$iata = 'DCA';
		}elseif($_SESSION['city_name'] == 'Washington'){
			$iata = 'IAD';
		}elseif($_SESSION['city_name'] == 'Chicago'){
			$iata = 'ORD';
		}elseif($_SESSION['city_name'] == 'Nashville'){
			$iata = 'BNA';
		}
		if(isset($_GET['flight_page'])){
			$flight_limit = '80';
		}else{
			$flight_limit = '40';
		}
		?>
		<script src="//c111.travelpayouts.com/content?promo_id=3411&shmarker=130544&from_name=<?php echo $iata; ?>&to_name=&limit=<?php echo $flight_limit; ?>&locale=en&currency=USD&powered_by=true" charset="utf-8"></script>
		<div class="load_more_yelps flight_loads view-tag" style="text-align: center;color: black;" data-id="10"><a href="/random_deals.php?flag=Flights&from_name=<?php echo $_GET['from_name']; ?>&from_to=United%20state&flight_page=true">Load more</a><div>
		<?php }
//vacation deals screen
		if(isset($_GET['flag']) && empty($_SESSION['city_name']) && !empty($_GET['flag']) && $_GET['flag'] == 'Vacations' && empty($_GET['dream']) && empty($_GET['dream_origin'])){?>
			<div class="heading"><h4 class="flght_specific_h2">Flight From</h4> </div>

			<div class="client owl-carousel owl-theme flight_from ">   

				<div class="item ">
					<a target="_blank" href="random_deals.php?flag=Flights&from_name=Chicago&from_to=United state">
						<img class="lazyload" src="images/city_images/chicago-1.jpg" style="height: 200px;object-fit: unset"/>
						<div class="item_content">Chicago</div>

					</a>
				</div>
				<div class="item">
					<a target="_blank" href="random_deals.php?flag=Flights&from_name=Los Angeles&from_to=United state">
						<img class="lazyload" src="images/city_images/los-angeles-1.jpg" style="height: 200px;object-fit: unset" />
						<div class="item_content">LA</div>

					</a>
				</div>
				<div class="item ">
					<a target="_blank" href="random_deals.php?flag=Flights&from_name=Atlanta&from_to=United state">
						<img class="lazyload" src="images/city_images/atlanta-1.jpg" style="height: 200px;object-fit: unset"/>
						<div class="item_content">Atlanta </div>

					</a>
				</div>
				<div class="item ">
					<a target="_blank" href="random_deals.php?flag=Flights&from_name=Dallas&from_to=United state">
						<img class="lazyload" src="images/city_images/Dallas-concert.jpg" style="height: 200px; object-fit: unset"/>
						<div class="item_content">Dallas </div>

					</a>
				</div>
				<div class="item">
					<a target="_blank" href="random_deals.php?flag=Flights&from_name=Memphis&from_to=United state">
						<img class="lazyload" src="images/city_images/memphis-1.jpg" style="height: 200px; object-fit: unset"/>
						<div class="item_content">Memphis</div>

					</a>
				</div>
				<div class="item ">
					<a target="_blank" href="random_deals.php?flag=Flights&from_name=Nashville&from_to=United state">
						<img class="lazyload" src="images/city_images/nashville-14.jpg" style="height: 200px; object-fit: unset"/>
						<div class="item_content">Nashville </div>

					</a>
				</div>
				<div class="item ">
					<a target="_blank" href="random_deals.php?flag=Flights&from_name=New York&from_to=United state">
						<img class="lazyload" src="images/city_images/new-york-city.jpg" style="height: 200px; object-fit: unset"/>
						<div class="item_content">New York</div>

					</a>
				</div>
				<div class="item ">
					<a target="_blank" href="random_deals.php?flag=Flights&from_name=Philadelphia&from_to=United state">
						<img class="lazyload" src="images/city_images/Philadelphia-1.jpg" style="height: 200px; object-fit: unset"/>
						<div class="item_content">Philadelphia </div>

					</a>
				</div>
				<div class="item ">
					<a target="_blank" href="random_deals.php?flag=Flights&from_name=Houston&from_to=United state">
						<img class="lazyload" src="images/city_images/Houston-1.jpg" style="height: 200px; object-fit: unset"/>
						<div class="item_content">Houston </div>

					</a>
				</div>
				<div class="item ">
					<a target="_blank" href="random_deals.php?flag=Flights&from_name=Phoenix&from_to=United state">
						<img class="lazyload" src="images/city_images/phoenix-1.jpg" style="height: 200px; object-fit: unset"/>
						<div class="item_content">Phoenix </div>

					</a>
				</div>
			</div>


			<?php
			$randon_deals = "SELECT * FROM  us_vacation_package";
			$result = $mysqli->query($randon_deals);
			?>
			<div class="heading">
				<h4 class="flght_specific_h2Fflight">Most Visited US Cities</h4>
			</h4>
		</div>
		<?php
		foreach ($result as $keys => $values) {
			?>
			<br>
			<div class="col-lg-3 col-md-6">
				<div class="item groupon_item gg vacation_deals">
					<a href="random_deals.php?flag=Vacations&city=<?php echo $values['city_name'] ; ?>">
						<div class="image_htfix_mid"> 
							<img src="images/city_images/<?php echo $values['image']; ?>" class="img-fluid w-100"/>

						</div>
						<div class="item_content">
							<p class="address"><?php echo $values['city_name'] ; ?></p>
						</div>
					</a>
				</div>
			</div>
		<?php }
	}
	if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'Vacations' && isset($_SESSION['city_name']) && !empty($_SESSION['city_name']) && empty($_GET['dream_city'])){
		?>
		<?php
		if($_SESSION['city_name'] == 'Clearwater'){
			$flightCity = 'Tampa';
		}elseif($_SESSION['city_name'] == 'Siesta Key'){
			$flightCity = 'Sarasota';
		}elseif($_SESSION['city_name'] == 'Lahaina'){
			$flightCity = 'Maui';
		}elseif($_SESSION['city_name'] == 'St. Pete Beach'){
			$flightCity =  'Tampa';
		}elseif($_SESSION['city_name'] == 'Wailea'){
			$flightCity = 'Maui';
		}elseif($_SESSION['city_name'] == 'Puako'){
			$flightCity = 'Kailua-Kona';
		}elseif($_SESSION['city_name'] == 'Manhattan Beach'){
			$flightCity = 'Los Angeles';
		}elseif($_SESSION['city_name'] == 'Jekyll Island'){
			$flightCity ='Jacksonville';
		}elseif($_SESSION['city_name'] == 'La Jolla'){
			$flightCity ='San Diego';
		}elseif($_SESSION['city_name'] == 'Virginia Beach'){
			$flightCity ='Norfolk';
		}else{
			$flightCity = $_SESSION['city_name'];
		}
		$popular = "SELECT * FROM continantal WHERE   city_name = '".$flightCity."'";
		$result = $mysqli->query($popular);
		$count = $result->num_rows;
		if($count > 0){
			foreach ($result as $key => $value) {
				$iata = $value['iata'];
			}
		}else{
			$iata ='CHI';
		}
		if($_SESSION['city_name'] == 'Washington D.C.'){
			$iata = 'DCA';
		}elseif($_SESSION['city_name'] == 'Washington'){
			$iata = 'IAD';
		}

		?>
		<div class="heading">
			<h4 class="flght_specific_h2">Flight to <?php echo $_SESSION['city_name'];?></h4>
		</div>

		<div class="owl-carousel owl-theme client">
			<?php 

			$current_city_sql = "SELECT * FROM deal_flight WHERE   city_name != '".$flightCity."'";
			$current_city = $mysqli->query($current_city_sql);

			foreach ($current_city as $key => $value) {
				$url ="https://mysittivacations.com/flight/deal.php?origin_name=".$value['city_name']."&origin_iata=".$value['iata_code']."&destination_name=".$_SESSION['city_name']."&destination_iata=".$iata."&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";

				?>
				<div class="item ">
					<a target="_blank" href="<?php echo $url; ?>">
						<img class="lazyload" src="<?php echo  $value['image']; ?>" style="height: 200px; object-fit: unset"/>
						<div class="item_content"><span class=""><?php echo  $value['city_name']; ?> <i class="fa fa-plane" aria-hidden="true"> </i> <?php echo $_SESSION['city_name'];?></span> </div>

					</a>
				</div>
			<?php } ?>
		</div>
		<?php
		if($_GET['page']){
			$limit = '80';
		}else{
			$limit = '40';
		}
		if($_SESSION['city_name'] == 'Washington D.C.'){
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' limit $limit";
		}elseif($_SESSION['city_name'] == 'Lahaina'){
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Maui%' AND tag = 'Tours4Fun' limit $limit";
		}elseif($_SESSION['city_name'] == 'Clearwater'){
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Tampa%' AND tag = 'Tours4Fun' limit $limit";
		}elseif($_SESSION['city_name'] == 'Siesta Key'){
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Sarasota%' AND tag = 'Tours4Fun' limit $limit";
		}elseif($_SESSION['city_name'] == 'St. Pete Beach'){
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Tampa%' AND tag = 'Tours4Fun' limit $limit";
		}elseif($_SESSION['city_name'] == 'Manhattan Beach'){
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Los Angeles%' AND tag = 'Tours4Fun' limit $limit";
		}elseif($_SESSION['city_name'] == 'La Jolla'){
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%San Diego%' AND tag = 'Tours4Fun' limit $limit";
		}elseif($_SESSION['city_name'] == 'Virginia Beach'){
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Norfolk%' AND tag = 'Tours4Fun' limit $limit";
		}elseif($_SESSION['city_name'] == 'Jekyll Island'){
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Jacksonville%' AND tag = 'Tours4Fun' limit $limit";
		}else{
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun' limit $limit";
		}
		$result = $mysqli->query($randon_deals);?>
		<section class="sec_pad pb-0">
			<div class="heading">
				<h4 class="tours_specific_city_h2"><?php echo $_SESSION['city_name']; ?></h4>
			</div>
		</section>
		<?php
		foreach ($result as $keys => $values) {
			$new = substr($values['link'], strrpos($values['link'], '=' )+1);
			$buy_urls = str_replace('%3A%2F%2F', '://', $new);
			$buy_urlss = str_replace('%2F', '/', $buy_urls);
			$buy_urlsss = str_replace('%3F', '/', $buy_urlss);
			$buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
			$buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
			$buy_url = $buy_urlsssss; 
			?>
			<div class="col-lg-3 col-md-6">
				<div class="item groupon_item jj">
					<a href="<?php echo $buy_url; ?>"  target="_blank">
						<div class="image_htfix_mid"> 
							<img src="<?php echo $values['image_link']; ?>" class="img-fluid w-100"/>
						</div>
						<div class="item_content">

							<p class="address"><?php echo $values['title'] ; ?><br>
								$ <?php echo $values['price']; ?>
							</p>

						</div>
					</a>
				</div>
			</div>
		<?php } ?>

		<?php
		$guide_city = "SELECT * FROM  get_guide_tours WHERE city_name LIKE '%".$_SESSION['city_name']."%' LIMIT 1";
		if($_GET['page']){
			$lim = 'limit=50';
		}else{  
			$lim = 'limit=25';
		}
		$guide_city_result = $mysqli->query($guide_city);
		$guide_city_count = $guide_city_result->num_rows;
		if($guide_city_count > 0){
			foreach ($guide_city_result as $key => $value) {
				echo str_replace('limit=25', $lim, $value['content']);
			}
			?>

			<?php if(!isset($_GET['page'])){ ?>
				<div class="load_more_yelps view-tag" style="text-align: center;color: black;font-size: 15px;"><a href="random_deals.php?flag=Vacations&page=1">Load more<div>
					<?php
				}
			}else{
				$string =  substr($_SESSION['city_name'], 0, 3);
				$string =  strtoupper(  $string ); 
				if( $_SESSION['city_name'] == "San Sebastián"){
					$string = "EAS";
				}
				if( $_SESSION['city_name'] == "İstanbul"){
					$string = "IST";
				}
				echo  $fiveStar = '<script src="//c108.travelpayouts.com/content?promo_id=4039&shmarker=iddqd&place=&items=25&locale=en-US&powered_by=true&iata='.$string.'" charset="utf-8"></script>';
			}
		}if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'Tours' || $_GET['dream'] == 'all' && empty($_SESSION['city_name'])){?>
			<div class="heading">
				<h4 class="flght_specific_h2world">World's Most Visited Cities</h4>
			</div>
			<?php
			$rec_limit = 40;
			if( isset($_GET{'page'} ) ) {
				$page = $_GET{'page'} + 1;
				$offset = $rec_limit * $page ;
			}else {
				$page = 0;
				$offset = 0;
			}
			$randon_deals = "SELECT * FROM  continantal LIMIT $offset, $rec_limit";
			$randon_deals_count = "SELECT id FROM  continantal";
			$resultCount = $mysqli->query($randon_deals_count);
			$countCount = $resultCount->num_rows;
			$left_rec = $countCount - ($page * $rec_limit);
			$result = $mysqli->query($randon_deals);
			foreach ($result as $keys => $values) {
				?>
				<div class="col-lg-3 col-md-6">
					<div class="item groupon_item uu vacation_deals">
						<a href="random_deals.php?flag=Vacations&city=<?php echo $values['city_name'] ; ?>">
							<div class="image_htfix_mid">
								<img class="lazyload" src="images/<?php echo $values['image']; ?>" />
							</div>
							<div class="item_content">
								<?php echo $values['city_name'] ; ?>
							</div>

						</a>
					</div>
				</div>
				<?php			
			}

			?>
			<div class="container">
				<div class="paggination_bottom">
					<?php

					if( $left_rec > $rec_limit && $page != '0') {
						$last = $page - 2;
						echo "<a href =random_deals.php?flag=Tours&dream=all&page=$last>Last 40 Records</a> | ";
						echo "<a href = random_deals.php?flag=Tours&dream=all&page=$page>Next 40 Records</a>";
					}else if( $page == 0 ) {
						echo "<a href =random_deals.php?flag=Tours&dream=all&page=$page class='dealNext' >Next 40 Records</a>";
					}else if( $left_rec < $rec_limit ) {
						$last = $page - 2;
						echo "<a href =random_deals.php?flag=Tours&dream=all&page=$last class='dealLast' >Last 40 Records</a>";
					}

					?>
				</div>
			</div>

		<?php } if(!empty($_GET['flag']) && $_GET['flag'] == 'Vacations' && isset($_GET['dream_origin'])){?>
			<div class="headingActivity-new new_activity container specific_flightd_h2"> 
				<div class="heading">      
					<h4 class="flght_specific_h2">Flight to <?php echo $_GET['dream_origin'];?></h4>
				</div>
			</div> 
			<?php
			if($_GET['dream_origin'] == 'Latin America'){
				$origin = 'Mexixo';
			}else{
				$origin = $_GET['dream_origin'];
			}
			$flight_query = "SELECT * FROM  deal_flight";
			$deal_flight = $mysqli->query($flight_query);
			?>
			<div class="owl-carousel owl-theme specific_continent">   
				<?php foreach ($deal_flight as $key => $value) {
					if($value['city_name'] == 'Virginia Beach'){
						$city = 'Norfolk';	
					}elseif ($value['city_name'] == 'Arlington') {
						$city = 'Baltimore';
					}elseif ($value['city_name'] == 'Fort Worth') {
						$city = 'Dallas';
					}elseif ($value['city_name'] == 'Mesa') {
						$city = 'Phoenix';
					}
					?>
					<div class="item  popular_cityy">
						<a target="_blank" href="random_deals.php?flag=Flights&from_name=<?php echo $city; ?>&from_to=<?php echo $origin;?>">
							<img  class="lazyload" src="<?php echo $value['image']; ?>" style="height: 200px; object-fit: unset">
							<span class="dealscity_name cityes_cityes_name"><?php echo $value['city_name']; ?> <i class="fa fa-plane" aria-hidden="true"> </i> <?php echo $_GET['dream_origin'];?></span>
						</a>
					</div>

				<?php } ?>
			</div>
			<div class="heading">
				<h4 class="origin_heading">
					<?php if($_GET['dream_origin'] == 'North America'){
						echo "USA";
					}else{ 
						echo $_GET['dream_origin'];
					}?>
				</h4>
			</div>
			<?php
			$randon_deals = "SELECT * FROM  continantal where name LIKE '%".$_GET['dream_origin']."%'";
			$result = $mysqli->query($randon_deals);
			foreach ($result as $keys => $values) {
				?>
				<div class="col-lg-3 col-md-6">
					<div class="item groupon_item hh">
						<a href="random_deals.php?flag=Vacations&city=<?php echo $values['city_name'] ; ?>">
							<img src="images/<?php echo $values['image']; ?>" alt="" style="height: 200px; object-fit: unset" >

							<div class="item_content">
								<?php echo $values['city_name'] ; ?> 
							</div>

						</a>
					</div>
				</div>
			<?php } ?>
			<?php 
			if($_GET['dream_origin'] == 'North America'){?>
				<div class="heading">
					<h4 class="cananda_tours">CANADA</h4></div>
					<?php
					$randon_deals = "SELECT * FROM  continantal where name LIKE '%canada%'";
					$result = $mysqli->query($randon_deals);
					foreach ($result as $keys => $values) {
						?>
						<div class="col-lg-3 col-md-6">
							<div class="item groupon_item gs">
								<a href="random_deals.php?flag=Vacations&city=<?php echo $values['city_name'] ; ?>">
									<img src="images/<?php echo $values['image']; ?>" alt="" style="height: 200px; object-fit: unset" >

									<div class="item_content">
										<?php echo $values['city_name'] ; ?> 
									</div>

								</a>
							</div>
						</div>
					<?php	}
				}
									} //cruises deals screen
									if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'Cruises'){
										$rec_limit = 40;
										if( isset($_GET['page'] ) ) {
											$page = $_GET['page'] + 1;
											$offset = $rec_limit * $page ;
										}else {
											$page = 0;
											$offset = 0;
										}
										$randon_deals = "SELECT * FROM  new_cruises_deal_page ORDER BY  order_by LIMIT $offset, $rec_limit";
										$randon_deals_count = "SELECT id FROM  new_cruises_deal_page";
										$resultCount = $mysqli->query($randon_deals_count);
										$countCount = $resultCount->num_rows;
										$left_rec = $countCount - ($page * $rec_limit);
										$result = $mysqli->query($randon_deals);
										$count = $result->num_rows;

										foreach ($result as $key => $value) {
											?>	
											<div class="col-lg-3 col-md-6">
												<div class="item groupon_item re">
													<a href="<?php echo $value['link']; ?>" class="text-dec"  target="_blank">
														<img src="<?php echo 'cruises_images/'.$value['image']; ?>"  alt="<?php echo $value['tittle']; ?>" style="height: 200px; object-fit: unset" >

														<div class="item_content">
															<?php echo $value['tittle']; ?>
														</div>

													</a>
												</div>
											</div>
											<?php		
										}  
										?> 
									</section>
									
									<?php 
								}if(isset($_SESSION['city_name']) && !empty($_SESSION['city_name'])){
									if($_GET['flag'] == 'Hotels'){
										if($_SESSION['city_name'] == 'Clearwater'){
											$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%Tampa%' limit 1";
										}elseif($_SESSION['city_name'] == 'Siesta Key'){
											$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%Sarasota%' limit 1";
										}elseif($_SESSION['city_name'] == 'Lahaina'){
											$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%Maui%' limit 1";	
										}elseif($_SESSION['city_name'] == 'St. Pete Beach'){
											$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%Tampa%' limit 1";	
										}elseif($_SESSION['city_name'] == 'Wailea'){
											$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%Maui%' limit 1";	
										}elseif($_SESSION['city_name'] == 'Puako'){
											$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%Kailua-Kona% limit' 1";	
										}elseif($_SESSION['city_name'] == 'Manhattan Beach'){
											$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%Los Angeles%' limit 1";	
										}elseif($_SESSION['city_name'] == 'La Jolla'){
											$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%San Diego%' limit 1";	}elseif($_SESSION['city_name'] == 'Virginia Beach'){
												$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%Norfolk%' limit 1";	
											}elseif($_SESSION['city_name'] == 'Jekyll Island'){
												$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%Jacksonville%' limit 1";	
											}else{	
												$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%".$_GET['city']."%' limit 1";
											}
										}elseif(isset($_SESSION['city_name']) && $_SERVER['SCRIPT_NAME'] == '/random_deals.php') {
											$limit = '15';

											if($_SESSION['city_name'] == 'Washington D.C.'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' AND tag = 'Tours4Fun'  LIMIT $limit";
											}elseif($_SESSION['city_name'] == 'Clearwater'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Tampa%' AND tag = 'Tours4Fun' LIMIT $limit";
											}elseif($_SESSION['city_name'] == 'Siesta Key'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Sarasota%' AND tag = 'Tours4Fun' LIMIT $limit";
											}elseif($_SESSION['city_name'] == 'Lahaina'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Maui%' AND tag = 'Tours4Fun' LIMIT $limit";
											}elseif($_SESSION['city_name'] == 'St. Pete Beach'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Tampa%' AND tag = 'Tours4Fun' LIMIT $limit";
											}
											elseif($_SESSION['city_name'] == 'Wailea'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Maui%' AND tag = 'Tours4Fun' LIMIT $limit";
											}elseif($_SESSION['city_name'] == 'Puako'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Kailua-Kona%' AND tag = 'Tours4Fun' LIMIT $limit";
											}elseif($_SESSION['city_name'] == 'Manhattan Beach'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Los Angeles%' AND tag = 'Tours4Fun' LIMIT $limit";
											}elseif($_SESSION['city_name'] == 'La Jolla'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%San Diego%' AND tag = 'Tours4Fun' LIMIT $limit";
											}elseif($_SESSION['city_name'] == 'Virginia Beach'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Norfolk%' AND tag = 'Tours4Fun' LIMIT $limit";
											}elseif($_SESSION['city_name'] == 'Jekyll Island'){
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Jacksonville%' AND tag = 'Tours4Fun' LIMIT $limit";
											}else{
												$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun'  LIMIT $limit";      
											}
										}
										$result = $mysqli->query($randon_deals);
										$count = $result->num_rows;
										$counts = $count;
										if ($_SERVER['SCRIPT_NAME'] == '/random_deals.php' && empty($_SERVER['QUERY_STRING'])) {
											?>
											<div class="owl-carousel owl-theme client mb-5">
												<?php

												foreach ($result as $key => $value) {
													$new = substr($value['link'], strrpos($value['link'], '=' )+1);
													$buy_urls = str_replace('%3A%2F%2F', '://', $new);
													$buy_urlss = str_replace('%2F', '/', $buy_urls);
													$buy_urlsss = str_replace('%3F', '/', $buy_urlss);
													$buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
													$buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
													$buy_url = $buy_urlsssss; 
													?>
													<div class="item">
														<a target="_blank" href="<?php echo $buy_url; ?>">
															<?php  $url = str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>
															<img src="<?php echo $value['image_link']; ?>" style="height: 200px;object-fit: unset">
															<div class="item_content"><?php echo substr($value['title'],0,30); ?>... </div>
														</a>
													</div>
													<?php 
												} ?>
											</div>
											<?php 
											$guide_city = "SELECT * FROM  get_guide_tours WHERE city_name LIKE '%".$_SESSION['city_name']."%' LIMIT 1";
											$guide_city_result = $mysqli->query($guide_city);
											$guide_city_count = $guide_city_result->num_rows;
											if($guide_city_count > 0){
												foreach ($guide_city_result as $key => $value) {
													echo $value['content'];
												}

												if(!isset($_GET['page'])){ ?>
													<div class="load_more_yelps view-tag" style="text-align: center;color: black;font-size: 15px;margin-bottom: 10px;">
														<a href="random_deals.php?flag=Tours">Load more</a>
														<div>
														<?php 	}
													}else{
														$string =  substr($_SESSION['city_name'], 0, 3);
														$string =  strtoupper(  $string ); 
														if( $_SESSION['city_name'] == "San Sebastián"){
															$string = "EAS";
														}
														if( $_SESSION['city_name'] == "İstanbul"){
															$string = "IST";
														}
														echo  $fiveStar = '<script src="//c108.travelpayouts.com/content?promo_id=4039&shmarker=iddqd&place=&items=25&locale=en-US&powered_by=true&iata='.$string.'" charset="utf-8"></script>';
													}
												}elseif(!empty($_SESSION['city_name']) && !empty($_SERVER['QUERY_STRING']) && $_GET['flag'] == 'Tours'){
													$limits = '80';

													if($_SESSION['city_name'] == 'Washington D.C.'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun'  LIMIT $limits";
													}elseif($_SESSION['city_name'] == 'Clearwater'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Tampa%' AND tag = 'Tours4Fun'  LIMIT $limits";
													}elseif($_SESSION['city_name'] == 'Siesta Key'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Sarasota%' AND tag = 'Tours4Fun'  LIMIT $limits";
													}elseif($_SESSION['city_name'] == 'Lahaina'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Maui%' AND tag = 'Tours4Fun'  LIMIT $limits";
													}elseif($_SESSION['city_name'] == 'St. Pete Beach'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Tampa%' AND tag = 'Tours4Fun'  LIMIT $limits";
													}
													elseif($_SESSION['city_name'] == 'Wailea'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Maui%' AND tag = 'Tours4Fun'  LIMIT $limits";
													}elseif($_SESSION['city_name'] == 'Puako'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Kailua-Kona%' LIMIT AND tag = 'Tours4Fun'  $limits";
													}elseif($_SESSION['city_name'] == 'Manhattan Beach'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Los Angeles%' AND tag = 'Tours4Fun'  LIMIT $limits";
													}elseif($_SESSION['city_name'] == 'La Jolla'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%San Diego%' AND tag = 'Tours4Fun'  LIMIT $limits";
													}elseif($_SESSION['city_name'] == 'Virginia Beach'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Norfolk%' AND tag = 'Tours4Fun'  LIMIT $limits";
													}elseif($_SESSION['city_name'] == 'Jekyll Island'){
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Jacksonville%' AND tag = 'Tours4Fun'  LIMIT $limits";
													}else{
														$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun'  LIMIT $limits";      
													}
													$resultss = $mysqli->query($randon_deals);

													?>

													<?php 
													foreach ($resultss as $key => $value) {
														$new = substr($value['link'], strrpos($value['link'], '=' )+1);
														$buy_urls = str_replace('%3A%2F%2F', '://', $new);
														$buy_urlss = str_replace('%2F', '/', $buy_urls);
														$buy_urlsss = str_replace('%3F', '/', $buy_urlss);
														$buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
														$buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
														$buy_url = $buy_urlsssss; 
														?>
														<div class="col-lg-3 col-md-6">
															<div class="item groupon_item as">
																<a href="<?php echo $buy_url; ?>"  target="_blank">
																	<div class="image_htfix_mid"> 
																		<img src="<?php echo $value['image_link']; ?>" alt="">

																	</div>
																	<div class="item_content">
																		<div class="PictureCard-title"><?php echo $value['tag']; ?></div>
																		<span class="PictureCard-price length-5">$ <?php echo $value['price']; ?></span>
																		<p class="address"><?php echo $value['title']; ?></p>
																	</div>
																</a>
															</div>
														</div>
													<?php } ?>

													<?php
													$guide_city = "SELECT * FROM  get_guide_tours WHERE city_name LIKE '%".$_SESSION['city_name']."%' LIMIT 1";
													$guide_city_result = $mysqli->query($guide_city);
													$guide_city_count = $guide_city_result->num_rows;
													if($guide_city_count > 0){
														foreach ($guide_city_result as $key => $value) {
															echo str_replace('limit=25', 'limit=50', $value['content']);
														}
													}else{
														$string =  substr($_SESSION['city_name'], 0, 3);
														$string =  strtoupper(  $string ); 
														if( $_SESSION['city_name'] == "San Sebastián"){
															$string = "EAS";
														}
														if( $_SESSION['city_name'] == "İstanbul"){
															$string = "IST";
														}
														echo  $fiveStar = '<script src="//c108.travelpayouts.com/content?promo_id=4039&shmarker=iddqd&place=&items=25&locale=en-US&powered_by=true&iata='.$string.'" charset="utf-8"></script>';
													}
												}
												if($_GET['flag'] == 'Hotels'){
													if(isset($_GET['categories']) && !empty($_GET['categories'])){
														$categories = explode(",", $_GET['categories']);

													}
													if($count > 0){ 
														?>
														<div class="col-lg-3">

															<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
															<div class="top incase_mobile">
																<a href="#" class="menu_icon"><i class="fa fa-bars" aria-hidden="true"></i></a><span class="mobile_filter">List hotels with filters</span>
															</div>


															<ul class="incase_desktop">
																<li class="filter-btn_">List hotels with filters:
																</li>
																<li><input type="checkbox" name="categories" class="filters" value="3stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('3stars', $categories)){ echo "checked"; } } ?>> 3 Stars </li>

																<li><input type="checkbox" name="categories" class="filters" value="4stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('4stars', $categories)){ echo "checked"; } } ?> > 4 Stars</li>

																<li><input type="checkbox" name="categories" class="filters" value="5stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('5stars', $categories)){ echo "checked"; } } ?> > 5 Stars</li>

																<li><input type="checkbox" name="categories" class="filters" value="cheap"  <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('cheap', $categories)){ echo "checked"; } } ?> > Cheap</li>

																<li><input type="checkbox" name="categories" class="filters" value="center" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('center', $categories)){ echo "checked"; } } ?> > Close to city center</li>

																<li><input type="checkbox" name="categories" class="filters" value="tophotels"<?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('tophotels', $categories)){ echo "checked"; } } ?> > Top hotels</li>

																<li><input type="checkbox" name="categories" class="filters" value="distance" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('distance', $categories)){ echo "checked"; } } ?> > Distance</li>

																<li><input type="checkbox" name="categories" class="filters" value="highprice" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('highprice', $categories)){ echo "checked"; } } ?> > Expensive</li>

																<li><input type="checkbox" name="categories" class="filters" value="lake_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('lake_view', $categories)){ echo "checked"; } } ?> > Lake view</li>

																<li><input type="checkbox" name="categories" class="filters" value="luxury" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('luxury', $categories)){ echo "checked"; } } ?> > Luxury</li>

																<li><input type="checkbox" name="categories" class="filters" value="panoramic_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('panoramic_view', $categories)){ echo "checked"; } } ?> > Panoramic view</li>

																<li><input type="checkbox" name="categories" class="filters" value="pets" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pets', $categories)){ echo "checked"; } } ?> > Pet friendly</li>

																<li><input type="checkbox" name="categories" class="filters" value="pool" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pool', $categories)){ echo "checked"; } } ?> > Pool</li>

																<li><input type="checkbox" name="categories" class="filters" value="popularity" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('popularity', $categories)){ echo "checked"; } } ?> > Popularity</li>

																<li><input type="checkbox" name="categories" class="filters" value="rating" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('rating', $categories)){ echo "checked"; } } ?> > Rating</li>

																<li><input type="checkbox" name="categories" class="filters" value="restaurant" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('restaurant', $categories)){ echo "checked"; } } ?> > Restaurant</li>

																<li><input type="checkbox" name="categories" class="filters" value="smoke" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('smoke', $categories)){ echo "checked"; } } ?> > Smoking friendly</li>

																<li><input type="checkbox" name="categories" class="filters" value="river_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('river_view', $categories)){ echo "checked"; } } ?> > River view</li>

																<li><input type="checkbox" name="categories" class="filters" value="sea_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('sea_view', $categories)){ echo "checked"; } } ?> > Sea view</li>
																<li class="filter-btn_"><input type="button" name="filter" class="main_filters filters" value="Search"></li>
															</ul>
														</div>
														<?php
													}else{


														echo "<h4 style='width:100%;text-align:center;padding-top:20px'>No recrd found</h4>";
													}
												}?>
												<div class="col-lg-9">
													<?php foreach ($result as $key => $value) {
														if($_GET['flag'] == 'Hotels' && empty($_GET['categories'])){
															echo $value['content'];
														}elseif($_GET['flag'] == 'Hotels' && empty($_GET['categories'])){
															echo $value['content'];
														}elseif($_GET['flag'] == 'Hotels' && !empty($_GET['categories'])){
															$position =  strpos($value['content'],"popularity");
															//echo $new_string = substr_replace($value['content'],$_GET['categories'].',', $position, 0);
															$categories =  explode(',',$_GET['categories']);
															foreach ($categories as $cat) {?>
																<span class="search_tag"><?php echo $cat; ?></span>
															<?php } ?>
															<div class="hotel_list">
																<?php echo  $value['content']; ?>
															</div>
														<?php }
													} ?>
												</div>
												<?php if($_GET['flag'] == 'Flights' && !isset($_GET['from_name']) ){
													if($_SESSION['city_name'] == 'Clearwater'){
														$flightCity = 'Tampa';
													}elseif($_SESSION['city_name'] == 'Siesta Key'){
														$flightCity = 'Sarasota';
													}elseif($_SESSION['city_name'] == 'Lahaina'){
														$flightCity = 'Maui';
													}elseif($_SESSION['city_name'] == 'St. Pete Beach'){
														$flightCity =  'Tampa';
													}elseif($_SESSION['city_name'] == 'Wailea'){
														$flightCity = 'Maui';
													}elseif($_SESSION['city_name'] == 'Puako'){
														$flightCity = 'Kailua-Kona';
													}elseif($_SESSION['city_name'] == 'Manhattan Beach'){
														$flightCity = 'Los Angeles';
													}elseif($_SESSION['city_name'] == 'Jekyll Island'){
														$flightCity ='Jacksonville';
													}elseif($_SESSION['city_name'] == 'La Jolla'){
														$flightCity ='San Diego';
													}elseif($_SESSION['city_name'] == 'Virginia Beach'){
														$flightCity ='Norfolk';
													}else{
														$flightCity = $_SESSION['city_name'];
													}
													$popular = "SELECT * FROM continantal WHERE   city_name = '".$flightCity."'";
													$result = $mysqli->query($popular);
													$count = $result->num_rows;
													if($count > 0){
														foreach ($result as $key => $value) {
															$iata = $value['iata'];
														}
													}else{
														$iata ='CHI';
													}
													if($_SESSION['city_name'] == 'Washington D.C.'){
														$iata = 'DCA';
													}elseif($_SESSION['city_name'] == 'Washington'){
														$iata = 'IAD';
													}

													$current_city_sql = "SELECT * FROM deal_flight WHERE   city_name != '".$flightCity."'";
													$current_city = $mysqli->query($current_city_sql);
													?>
													<script src="//tp.media/content?promo_id=3414&shmarker=130544&campaign_id=111&locale=en&show_hotels=false&powered_by=false&border_radius=0&plain=false&color_button=%2300A991&color_button_text=%23ffffff&default_destination=<?php echo $iata; ?>&default_origin=" charset="utf-8"></script>
													<?php
													foreach ($current_city as $key => $value) {
														$url ="https://mysittivacations.com/flight/deal.php?origin_name=".$value['city_name']."&origin_iata=".$value['iata_code']."&destination_name=".$_SESSION['city_name']."&destination_iata=".$iata."&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";?>
														<div class="col-lg-3 col-md-6" style="margin-top:30px; margin-bottom:0px!important;">
															<div class="item groupon_item er">
																<a href="<?php echo $url;?>">
																	<div class="image_htfix_mid"> 
																		<img src="<?php echo $value['image']; ?>" />
																	</div>
																	<div class="item_content">
																		<span><?php echo $value['city_name']; ?> <i class="fa fa-plane flight_deal_icon" aria-hidden="true"> <?php echo $_SESSION['city_name']; ?></i></span>
																	</div>
																</a>
															</div>
														</div>

													<?php	}?>
													
												<?php }




											}else{
												if(isset($_GET['flag']) && $_GET['flag'] == 'Vacations' || $_GET['flag'] == 'Cruises' || $_GET['flag'] == 'Flights' || $_GET['flag'] == 'All-Inclusive'|| $_GET['flag'] == 'Tours' || $_GET['keyword'] == 'Hotels'|| $_GET['flag'] == 'adventure'){
												}else{ ?>
												<div class="slider-section restuarent deals-sec"> 
												<div class="container">
													<div class="row">
													<div class="col-12 col-sm-12 col-md-12 col-lg-12">
														<div data-aos="zoom-in-left" class="myheader-sec">
														   <h2>Find Great Deals</h2>
														   <p>Find Great Deals in <?php echo $_SESSION['city_name']; ?></p>
														</div>
													</div>
													<div class="discounts_inner">
														<div class="row">
															<?php $data = groupon_api_call('80','','');
															if(count($data) > 0)
																{	 ?>
																	<?php
																	$i= 0;
																	foreach($data as $homeData)
																	{
																		$price = $homeData['options'][0]['price']['formattedAmount'];
																		$value = $homeData['options'][0]['value']['formattedAmount'];
																		$discountPercent = $homeData['options'][0]['discountPercent'];
																		$endAt = 	$homeData['options'][0]['endAt'];
																		$endDate = date('m/d/Y', strtotime($endAt));
																		$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
																		$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
																		$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
																		$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
																		$tourname = $homeData['merchant']['name']; 
																		$out =  substr($tourname,0,20)."...";
																		?>
																		<div class="col-lg-3 col-md-6 section_<?php echo $i; ?> ">
																			<?php  $i++; 
																			echo $homeData['cardHtml']; ?>
																				</div>

																				<?php
																			}
																			?>
																			<script>
																				$(document).ready( function (){
																					setTimeout(function(){
																						for (var i = 1; i <= 80; i++) {
																							var pics_str = jQuery('.section_'+i+' .cui-image').attr('data-srcset');
																						  if(pics_str != undefined){
																							var pics_arr = pics_str.split(',');
																							console.log('.section_<?php echo $i; ?>');
																							pics_str = '';
																							$.each(pics_arr, function(index, el) {
																								imgPath = this.trim();
																								imgPath = imgPath.substring(0, imgPath.indexOf('.jpg')+4);
																						   jQuery('.section_'+i+' .cui-svg-placeholder').css({"background-image":"url("+imgPath+")"});
																					   });
																						  }
																					  }
																				  },1000);
																				});
																			</script> 
																		</div>
																	</div>
																	</div>
																	</div>
																	</div>
																</section>
																<?php
															} 
														} } ?>
													</div>
												</div>
											</div>
										<!--end of gateways -->
										<script type="text/javascript">
											$(document).ready(function(){
												$.urlParam = function (name) {
													var results = new RegExp('[\?&]' + name + '=([^&#]*)')
													.exec(window.location.search);

													return (results !== null) ? results[1] || 0 : false;
												}
// if($.urlParam('flag') == 'Vacations'){
// 	$('.right').css('display','none');
// 	$('.left').css('display','none');
// }
$('#search-yelp-horizontal').hide();
$('#search_result_dropdown').hide();
$('#search_box_icon').click(function(){
	$('#search-yelp-horizontal').toggle(100);
});
$('.searchrandoms').click(function(){
	var keyword = $('.randomSearchs').val();
	if(keyword != ''){
		window.location = "random_deals.php?keyword="+keyword;
	}else{
		window.location = "random_deals.php";
	}
})
$('#searchrandoms').click(function(){
	var keyword = $('#searchbox-yelp').val();
	if(keyword != ''){
		window.location = "random_deals.php?keyword="+keyword;
	}else{
		window.location = "random_deals.php";
	}
})
$('.main_filters').click(function(){

	var favorite = [];

	$.each($("input[name='categories']:checked"), function(){

		favorite.push($(this).val());

	});
	var finalVal = favorite.join("%2C");

	var city = $('#target_location').val();
	window.location.href="<?php echo $SiteURL; ?>random_deals.php?city="+city+'&flag=Hotels&categories='+'%2C'+finalVal;
});
$('.main_filterss').click(function(){

	var favorite = [];

	$.each($("input[name='categorie']:checked"), function(){

		favorite.push($(this).val());

	});
	var finalVal = favorite.join("%2C");
	var city = $('#target_location').val();
	window.location.href="<?php echo $SiteURL; ?>random_deals.php?city="+city+'&flag=Hotels&categories='+'%2C'+finalVal;
});

$('.random_flight').on('click', function(){
	var flag = $(this).attr('data');
	var city = $('#target_location').val();
	if(flag == 'Tours'){
		if(city == 'Washington D.C.'){
			city = 'Washington';
		}
	}
	if(city != ''){
		window.location.href="<?php echo $SiteURL; ?>random_deals.php?city="+city+'&flag='+flag;
	}else if(flag == 'Flights'){
		window.location.href="<?php echo $SiteURL; ?>random_deals.php?flag="+flag;
	}else{
		window.location.href="<?php echo $SiteURL; ?>random_deals.php?keyword="+flag;
	} 
});
$('.random_tours').on('click', function(){
	var flag = $(this).attr('data');
	var city = $('#target_location').val();
	if(flag == 'Tours'){
		if(city == 'Washington D.C.'){
			city = 'Washington';
		}
	}
	if(city != ''){
		window.location.href="<?php echo $SiteURL; ?>random_deals.php";
	}else{
		window.location.href="<?php echo $SiteURL; ?>random_deals.php?flag="+flag;
	} 
});
$('.random_vacation').on('click', function(){
	var flag = $(this).attr('data');
		// var city = $('#target').val();
		window.location.href="<?php echo $SiteURL; ?>random_deals.php?flag="+flag;
	});
$('.listing_view').on('click', function(){
	var city = $('#target_location').val();
	var queryArr = [];
	jQuery(".filters:checked").each(function(el) {
		var val = jQuery(this).val();
		queryArr.push(val);	
	});	
	var finalVal = queryArr.join("%2C");
	if(city != ''){
		window.location.href="<?php echo $SiteURL; ?>random_deals.php?city="+city+'&flag=Hotels'+'&categories='+'%2C'+finalVal;
	}else{
		window.location.href="<?php echo $SiteURL; ?>random_deals.php?keyword="+flag;
	} 
});
});
/*

    $('.slider-single').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      fade: false,
      adaptiveHeight: true,
      infinite: false,
      useTransform: true,
      speed: 400,
      cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
  });*/

   /* $('.slider-nav')
    .on('init', function(event, slick) {
     $('.slider-nav .slick-slide.slick-current').addClass('is-active');
 })*/
   /* .slick({
     slidesToShow: 7,
     slidesToScroll: 7,
     dots: false,
     focusOnSelect: false,
     infinite: false,
     responsive: [{
        breakpoint: 1024,
        settings: {
           slidesToShow: 5,
           slidesToScroll: 5,
       }
   }, {
    breakpoint: 640,
    settings: {
       slidesToShow: 4,
       slidesToScroll: 4,
   }
}, {
    breakpoint: 420,
    settings: {
       slidesToShow: 3,
       slidesToScroll: 3,
   }
}]
});

    $('.slider-single').on('afterChange', function(event, slick, currentSlide) {
      $('.slider-nav').slick('slickGoTo', currentSlide);
      var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
      $('.slider-nav .slick-slide.is-active').removeClass('is-active');
      $(currrentNavSlideElem).addClass('is-active');
  });

    $('.slider-nav').on('click', '.slick-slide', function(event) {
      event.preventDefault();
      var goToSingleSlide = $(this).data('slick-index');

      $('.slider-single').slick('slickGoTo', goToSingleSlide);
  });*/
</script>
<script>

	$(document).ready(function() {
		$('#myCarousel').carousel({
			interval: 10000
		})

		$('#myCarousel').on('slid.bs.carousel', function() {
    	//alert("slid");
    });


	});
$(document).on('blur','#target_location', function(){
                setTimeout(function(){
                    var geodemo = $('#target_location').val();
                    console.log(geodemo);
                    if(geodemo != '' && geodemo != null){
                        $('#hitAjaxwithCity').click();
                    }
                    else{
                        console.log('empty');
                    }
                },100);

                return false;  
            });
            $(document).on('click','#hitAjaxwithCity',function(e){
                e.preventDefault();
                $.removeCookie('city_name');
                var geodemo = $('#target_location').val();
                if(geodemo != '' && geodemo != null){
                    console.log(geodemo);
                    $.ajax({
                        url: "city_search_ajax.php",
                        type: "POST",
                        data: {
                            formatteds: geodemo
                        },
                        success: function (response) 
                        {   
                            console.log(response);
                            window.location = window.location.href.split("?")[0];
                        }
                    });
                }else{
                    alert("Please Enter Keyword.");
                }
            });
</script>

<script>
	$("#carousel").owlCarousel({
		autoplay: true,
		lazyLoad: true,
		loop: true,

   /*
  animateOut: 'fadeOut',
  animateIn: 'fadeIn',
  */
  responsiveClass: true,
  autoHeight: true,
  autoplayTimeout: 7000,
  smartSpeed: 800,
  nav: true,
  responsive: {
  	0: {
  		items: 1
  	},

  	600: {
  		items: 3
  	},

  	1024: {
  		items: 4
  	},

  	1366: {
  		items: 4
  	}
  }
});
</script>


<script>
	$(document).ready(function() {
		$('#pinBoot').pinterest_grid({
			no_columns: 3,
			padding_x: 5,
			padding_y: 5,
			margin_bottom: 100,
			single_column_breakpoint: 700
		});
	});

	;(function ($, window, document, undefined) {
		var pluginName = 'pinterest_grid',
		defaults = {
			padding_x: 5,
			padding_y: 5,
			no_columns: 3,
			margin_bottom: 100,
			single_column_breakpoint: 700
		},
		columns,
		$article,
		article_width;

		function Plugin(element, options) {
			this.element = element;
			this.options = $.extend({}, defaults, options) ;
			this._defaults = defaults;
			this._name = pluginName;
			this.init();
		}

		Plugin.prototype.init = function () {
			var self = this,
			resize_finish;

			$(window).resize(function() {
				clearTimeout(resize_finish);
				resize_finish = setTimeout( function () {
					self.make_layout_change(self);
				}, 11);
			});

			self.make_layout_change(self);

			setTimeout(function() {
				$(window).resize();
			}, 500);
		};

		Plugin.prototype.calculate = function (single_column_mode) {
			var self = this,
			tallest = 0,
			row = 0,
			$container = $(this.element),
			container_width = $container.width();
			$article = $(this.element).children();

			if(single_column_mode === true) {
				article_width = $container.width() - self.options.padding_x;
			} else {
				article_width = ($container.width() - self.options.padding_x * self.options.no_columns) / self.options.no_columns;
			}

			$article.each(function() {
				$(this).css('width', article_width);
			});

			columns = self.options.no_columns;

			$article.each(function(index) {
				var current_column,
				left_out = 0,
				top = 0,
				$this = $(this),
				prevAll = $this.prevAll(),
				tallest = 0;

				if(single_column_mode === false) {
					current_column = (index % columns);
				} else {
					current_column = 0;
				}

				for(var t = 0; t < columns; t++) {
					$this.removeClass('c'+t);
				}

				if(index % columns === 0) {
					row++;
				}

				$this.addClass('c' + current_column);
				$this.addClass('r' + row);

				prevAll.each(function(index) {
					if($(this).hasClass('c' + current_column)) {
						top += $(this).outerHeight() + self.options.padding_y;
					}
				});

				if(single_column_mode === true) {
					left_out = 0;
				} else {
					left_out = (index % columns) * (article_width + self.options.padding_x);
				}

				$this.css({
					'left': left_out,
					'top' : top
				});
			});

			this.tallest($container);
			$(window).resize();
		};

		Plugin.prototype.tallest = function (_container) {
			var column_heights = [],
			largest = 0;

			for(var z = 0; z < columns; z++) {
				var temp_height = 0;
				_container.find('.c'+z).each(function() {
					temp_height += $(this).outerHeight();
				});
				column_heights[z] = temp_height;
			}

			largest = Math.max.apply(Math, column_heights);
			_container.css('height', largest + (this.options.padding_y + this.options.margin_bottom));
		};

		Plugin.prototype.make_layout_change = function (_self) {
			if($(window).width() < _self.options.single_column_breakpoint) {
				_self.calculate(true);
			} else {
				_self.calculate(false);
			}
		};

		$.fn[pluginName] = function (options) {
			return this.each(function () {
				if (!$.data(this, 'plugin_' + pluginName)) {
					$.data(this, 'plugin_' + pluginName,
						new Plugin(this, options));
				}
			});
		}

	})(jQuery, window, document);

</script>
<?php
if(isset($_GET['flight_page'])){?>
	<script>
		$(function(){
			$('.flight_loads').css('display','none');
		})
	</script>
<?php }
include('footer-newfile.php'); ?>
<div class="modal fade popular-modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<i id="hitAjaxCity" class="fa fa-search" aria-hidden="true"></i>
				<input id="target"  type="name" value="" name="" class="geo geocontrast form-control" placeholder="Where to?" required="" aria-required="true">
			</div>
			<div class="modal-body">
				<div class="nearby-sec popular-sec">
					<h3>POPULAR DESTINATIONS</h3>
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

<style type="text/css">
    .sec_pad {
    padding-top: 40px;
}
.gateways .item .item_content .final_advt{
    padding-bottom: 30px !important;
}
.search-content {
    padding: 0 0px;
}
</style>
<script>
      AOS.init();
      
      AOS.init({disable: 'mobile'});
    </script>
