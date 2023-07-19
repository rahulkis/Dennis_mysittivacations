<?php
	ob_start("ob_gzhandler");
	include("Query.Inc.php");
	$Obj = new Query($DBName);
	$titleofpage="Family"; 
	include('Header.php');	// not login
session_start();
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");

$dropCity = $_SESSION['city_name'];

if($dropCity == 'Washington D.C.'){
	$dropCity = 'Washington';
}elseif($dropCity == 'Washington DC'){
	$dropCity = 'Washington';
}
$dropdown_value = 'family attractions';

$date1 = date("Y-m-d");
$start_date = date("Y-m-d", strtotime($date1)).'T12:00:00Z';
$date2 = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y')));
$end_date = date("Y-m-d", strtotime($date2)).'T12:00:00Z';


$city_name_query = @mysql_query("SELECT dma_id, country_name FROM us_country_dma WHERE country_name ='".$dropCity."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$city_dma_id = $get_city_name['dma_id'];



	$url = "https://app.ticketmaster.com/discovery/v2/classifications?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".rawurlencode($dropdown_value)."&preferredCountry=us";

   $response_content = file_get_contents($url);
	$response = json_decode($response_content, true);

	$classifications = $response['_embedded']['classifications'];

	$data = [];

	foreach ($classifications as $key => $classification) {

	$generes = $classification['segment']['_embedded']['genres'];
	$ids = implode(',', array_map(function($genere){
	return $genere['id'];
	}, $generes));

	$data[$key] = $ids;
	}

	$ids = implode(',', $data);

    if($date1){
    	$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&startDateTime=".$start_date."&endDateTime=".$end_date."&countryCode=US&classificationId=".$ids."&dmaId=".$city_dma_id."&page=0"; 
    }else{
      $urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&countryCode=US&classificationId=".$ids."&dmaId=".$city_dma_id."&page=0";
    }
    //https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&countryCode=US&classificationId=&dmaId=381&page=0
  
	$result_get = file_get_contents($urlgo);
	$get_all_data1 = json_decode($result_get, true);

    $page_size = $get_all_data1['page']['size'];
    $totalPages = $get_all_data1['page']['totalPages'];
    $number = $get_all_data1['page']['number'];
  
    $get_ticket_data = $get_all_data1['_embedded']['events']; 


?>

<style type="text/css">
	.blissey-widget-footer {
    display: none;
}
.tp_powered_by {
    display: none !important;
}
.v2_header_wrapper.deals_wrapper {
    display: none;
}
.blissey-widget-tabs {
    display: none;
}
	.search_filtering {
    top: -60px !important;
}
.sidebar.v2_sidebar.aside-sidebar-com {
    height: 100vh;
    overflow: auto;
}
.rating2.tour_ratingd li {
    padding: 0;
    min-height: auto;
}
.tour_cate_type li {
    min-height: auto;
    width: 100%;
    padding: 0;
}
.us-city.worldtop_city.max_containerr {
    display: flex;
    width: 100%;
    align-items: center;
}
.us-city.worldtop_city.tour_listing.spefic_adrk {
    display: flex;
    align-items: center;
}
.us-city.worldtop_city.tour_listing.spefic_adrk .popular_cityy.thing_to_specific span {
    text-align: center;
    padding: 0;
    font-size: 15px !important;
}
.popular_cityy.thing_to_specific span {
    font-size: 16px !important;
    text-align: center;
    padding: 0;
}
.row.tab-two {
    border-top: 0px solid #000;
    padding: 10px 0 10px !important;
}
.homeGroupon.city-recom {
    padding: 0;
}
.home_review ul.list_f.tour_address li {
    min-height: auto;
    width: 100%;
    padding: 0;
}
.homeGroupon.city-recom span {
    font-size: 16px !important;
}
.homeGroupon.city-recom span {
    font-size: 16px !important;
}
.us-city.worldtop_city.custom_tours .owl-item.active {
    background: transparent;
}
.us-city.worldtop_city.custom_tours .owl-item.active .popular_cityy.thing_to_specific {
    padding: 0;
}
.us-city.worldtop_city.custom_tours {
    display: flex;
    width: 100%;
    align-items: center;
}
.v2_content_inner_topslider.spacer1 {
    margin: 50px 0 50px;
}
.us-city.worldtop_city.tour_listing.thing_toDoGroupon .owl-carousel.owl-theme.owl-loaded.owl-drag {
    width: 75%;
    float: left;
}
.us-city.worldtop_city.tour_listing.thing_toDoGroupon .popular_cityy {
    width: 25%;
    float: left;
}
.us-city.worldtop_city.tour_listing.thing_toDoGroupon {
    display: flex;
    align-items: center;
}
.us-city.worldtop_city.tour_listing.thing_toDoGroupon .popular_cityy span {
    font-size: 16px !important;
    text-align: center;
    padding: 0;
}
.us-city.worldtop_city.tour_listing.thing_toDoGroupon .owl-item.active {
    background: transparent;
}
.us-city.worldtop_city.tour_listing.thing_toDoGroupon .owl-item .homeGroupon.city-recom {
    width: 100% !important;
}
.container.specificRooms.specif_roomss {
    display: flex;
    width: 100%;
    align-items: center;
    flex-wrap: wrap;
}
.blissey-widget-body ul.blissey-widget-body-hotels-full-list li.blissey-widget-body-hotels-full-list-item .blissey-info {
    height: 130px;
    position: relative !important;
    bottom: -180px;
    z-index: 999;
    background: #fff !important;
    padding: 6px !important;
}
.blissey-widget--l .blissey-widget-body-hotels-full-list-item-gallery {
    min-height: 535px!important;
    position: relative !important;
    top: -130px;
}

.headingActivity-new.new_activity {padding: 40px 0px 5px;}

.blissey-widget_type--full.blissey-widget--l {
    width: 75%;
    float: left;
}

.homespecificrooms {
    width: 25%;
    float: left;
}
.blissey-widget .blissey-widget-body-hotels-full-list {
    margin: 0!important;
    width: 100%;
    overflow-x: scroll;
    display: flex;
    align-items: center;
    justify-content: space-between;
    overflow-y: hidden;
    margin-left: auto !important;
    margin-bottom: 0px !important;
}
.blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item {
    overflow: initial !important;
    height: 320px;
    width: 350px !important;
    position: relative !important;
}
.blissey-widget .blissey-info-details {
    margin-right: 0px!important;
    padding-right: 0px!important;
    margin: 0 0 10px !important;
}
.blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item .blissey-info-price {
    display: flex !important;
    float: none !important;
    width: 100%;
    align-items: center;
    justify-content: space-between;
}
.blissey-widget .blissey-info-description {
    padding-top: 10px!important;
    padding-bottom: 0px!important;
}

.blissey-info-price-wrapper-discount {
    width: 65px;
    display: inline-block;
}
.blissey-widget .blissey-info-details-specification__hotel_name {
    font-size: 15px!important;
    line-height: 30px!important;
}

@media (max-width: 767px){

	.blissey-widget {
	    display: block !important;
	}
	.text-search{
		display: none;
	}
	.family #suggestion_search{
		display: none;
	}
	.glyphicon-search{
		display: none;
	}
	.search-section {
	    margin-top: 0px;
	}
	.groupon_respoo i{
	  margin-bottom: 45px;
	}
	.groupon_respoo i{
	  margin-bottom: 45px;
	}
	.groupon_deals_common_class h2 {
	    padding: 0;
	    margin: 0;
	}
	.us-city.worldtop_city.tour_listing.spefic_adrk {
	    display: block;
	}
	
	.us-city.worldtop_city.tour_listing.spefic_adrk .owl-carousel.owl-theme.owl-loaded.owl-drag {
	    width: 100% !important;
	    margin: 10px 0 0;
	}
	.us-city.worldtop_city.max_containerr {
	    display: block;
	}
	.owl-carousel.owl-theme.owl-loaded.owl-drag {
	    width: 100% !important;

    margin: 10px 0 0;
	}
}

@media (max-width: 767px){
  h2.groupon_per{
    font-size: 13px;
    margin-top: 0;
  }
  .owl-carousel .owl-item img {
	    margin: 0;
	}

	.popular_cityy.thing_to_specific span {
	    font-size: 14px !important;
	}
	.city-recom .borderIsan.hotelandingDeal {
	    height: 300px !important;
	}
	.us-city.worldtop_city.max_containerr {
	    margin: 20px 0 0 !important;
	}
	.us-city.worldtop_city.custom_tours {
	    margin: 20px 0 0 !important;
	}
  .popular_cityy {
	    display: block !important;
	    width: 100% !important;
	}
	.rating2.tour_ratingd li {
	    padding: 0 3px 0;
	    min-height: auto;
	    text-align: center !important;
	    width: auto !important;
	    margin: 0;
	    display: block;
	}
	p.reviews.yelpuser-review {
	    text-align: center;
	}
	.m_2.tour_images img {
	    margin: 0 !important;
	}
	.rating2.tour_ratingd {
	    display: flex;
	    align-items: center;
	    justify-content: center;
	}
	.rating2.tour_ratingd li img {
	    margin: 0;
	}
	.city-recom span {
	    font-size: 12px;
	    height: auto;
	}
	.tour_cate_type {
	    margin-top: 0;
	    text-align: center;
	}
	.container.recommed-city a img {
	    width: 100%;
	    margin: 0;
	    height: 200px !important;
	}
	.homeGroupon.city-recom span {
	    font-size: 14px !important;
	    padding: 10px 10px;
	    text-align: center;
	        height: 65px;
	}
	.owl-carousel.owl-drag .owl-item {
	    padding: 0 5px;
	}
	.us-city.worldtop_city.custom_tours {
	    display: block;
	}
	.specificRooms .headingActivity-new.new_activity {
	    top: 0;
	}
	.container.specificRooms.specif_roomss {
	    display: block;
	    width: 100%;
	    margin: 20px 0 0;
	}
	.homespecificrooms {
	    width: 100%;
	    text-align: center;
	}
	.homespecificrooms h2 {
	    color: #000;
	    font-size: 24px;
	}
	.blissey-widget_type--full.blissey-widget--l {
	    width: 100%;
	    float: left;
	}
	.blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item {
	    height: 350px;
	    margin: -40px 0 0 !important;
	}
	.blissey-widget-body ul.blissey-widget-body-hotels-full-list li.blissey-widget-body-hotels-full-list-item .blissey-info {
	    height: 50px;
	    bottom: -225px;
	}
	.blissey-widget--s .blissey-info-price-wrapper__total {
	    font-size: 15px!important;
	}
}

h2.groupon_per{
    font-size: 14px;
}
#popularcitiesModal .city-recom {
    max-width: 50% !important;
}
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
</style>

<div class="v2_content_wrapper family_mobile">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">  	
		  	<?php
				if (isset($_SESSION['city_name']) || isset($_SESSION['formatteds'])) {
					$session_city_name = empty($_SESSION['city_name']) ? $_SESSION['formatteds'] : $_SESSION['city_name'];
					$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$session_city_name."'");
					$get_city_name = mysql_fetch_assoc($city_name_query);
					$dropdown_city = $get_city_name['city_name'];
					$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
					$get_state_name = mysql_fetch_assoc($state_name_query);
					$_SESSION['country'] = $get_state_name['country_id'];
					$state_name = $get_state_name['name'];
					$state_code = $get_state_name['code'];
					
					$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
					$get_co_name = mysql_fetch_assoc($co_name_query);
					$conry_nm = $get_co_name['name'];
				}elseif(!empty($_GET['city'])){
					$dropdown_city = $_GET['city'];
					$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$_GET['city']."'");
					$get_city_name = mysql_fetch_assoc($city_name_query);
					$dropdown_city = $get_city_name['city_name'];
					$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
					$get_state_name = mysql_fetch_assoc($state_name_query);
					$_SESSION['country'] = $get_state_name['country_id'];
					$state_name = $get_state_name['name'];
					$state_code = $get_state_name['code'];
					
					$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
					$get_co_name = mysql_fetch_assoc($co_name_query);
					$conry_nm = $get_co_name['name'];
				}else{
					$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
					$get_city_name = mysql_fetch_assoc($city_name_query);
					$dropdown_city = $get_city_name['city_name'];
					$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
					$get_state_name = mysql_fetch_assoc($state_name_query);
					$_SESSION['country'] = $get_state_name['country_id'];
					$state_name = $get_state_name['name'];
					$state_code = $get_state_name['code'];
					
					$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
					$get_co_name = mysql_fetch_assoc($co_name_query);
					$conry_nm = $get_co_name['name'];

				}
function yelp_api_data($limit,$city,$keyword){
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

function groupon_api_call($limit,$city,$key){
	if(!empty($city)):
		$prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
		// echo $prepAddr;
		$key = str_replace(' ','+',$key);
	    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
	    $output= json_decode($geocode);
	    $latitude = $output->results[0]->geometry->location->lat;
	    $longitude = $output->results[0]->geometry->location->lng;
			$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."&locale=en_US";
		// endif;
	else:
		
		if(!empty($key)):
			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&offset=0&limit=".$limit."&locale=en_US";
		else:

			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&limit=".$limit."&locale=en_US";
		endif;
		// endif;
		
	endif;
	// return $urlgo;
	$result_get = file_get_contents($urlgo);
	$get_all_data = json_decode($result_get, true);
	$get_deals = $get_all_data['deals'];
	return $get_deals;
}
$get_deals = groupon_api_call('80',$_SESSION['city_name'],'Family Attractions');
			?>			
			<div id="loader"></div>
			
		</div>
		<div class="clear"></div>	
		<div class="container recommed-city pcdesktop max_containerr">
		<div class="us-city worldtop_city tour_listing spefic_adrk">
				<div class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific" style="width:24%">
				<h2>Groupon Family Deals</h2>
				<span>Save money on things to do for the kids</span>
				</div>
			<div class="owl-carousel owl-theme" style="width:75%; float: right">
				<?php foreach ($get_deals as $key => $homeData) {
				$price = $homeData['options'][0]['price']['formattedAmount'];
				$value = $homeData['options'][0]['value']['formattedAmount'];
				$discountPercent = $homeData['options'][0]['discountPercent'];
				$endAt = 	$homeData['options'][0]['endAt'];
				$endDate = date('m/d/Y', strtotime($endAt));
				$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
				$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
				$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
				$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
				$tourname = $homeData['title']; 
				$out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
				?>

				<div class="item col-md-12 col-sm-12 col-xs-12 homeGroupon city-recom" style="width: 100% !important">
					<div class='borderIsan hotelandingDeal'>
						<a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
							<img src="<?php echo $homeData['grid4ImageUrl']; ?>">
						</a>
						<a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
							<h1 class="nameIsan hotelandingnameIsan" style= "text-align: center;"><?php echo $out ; ?></h1>
						</a>
						<h1 class="pricelanding"><?php echo $value ; ?></h2>
						<h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>
						<h2 class="valuelanding"><?php echo $price ;?></h1>
						<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
					</div>
				</div>
				<?php  } ?>

			</div>
		</div>
		</div>

		<div class="us-city worldtop_city max_containerr">
                  <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific" style="width: 24%">
                  <a id="top_links" name="escape%20%room" >
                  <h2>Family Attractions</h2>
                  <span>Museums, Landmarks, Historical buildings</span>
                  </a>
                  </div>
                  
<div class="owl-carousel owl-theme" style="width: 75%; float: right">
<?php 
    $ciountt = 0;
      $getyelpTourData = yelp_api_data('20',$_SESSION['city_name'],'family attractions');      
      if(!empty($getyelpTourData)):
      foreach ($getyelpTourData as $homeData):
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
          $tour_phone = $homeData->display_phone;
  
      ?>
        <div class="item row tab-two">
            <div class="m_2 tour_images">
              <a href="<?php echo $tour_url ; ?>" target="_blank">
                 <?php if(!empty($tour_image)) : ?>
                  <img src="<?php echo $tour_image; ?>">
                <?php else : ?>
                  <img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg">
                <?php endif; ?>
              </a>
            </div>
           
              <h2 class="hu tour_names">
                <a href="<?php echo $tour_url; ?>" target="_blank"><?php echo $tour_name; ?></a>
              </h2> 
            <ul class="rating2 tour_ratingd">
              <?php for($x=1;$x<=$tour_rating;$x++): ?>
                <li><img class="star_images"  src="imagesNew/star.png"></li>
              <?php endfor; ?>
              <?php if (strpos($tour_rating,".")) : ?>
                <li><img class="star_images" src="images/halfstarnew.png"></li>
              <?php 
                $x++;
                endif; ?>
            </ul>           
                    <p class="reviews yelpuser-review" style="color:#0355a9; cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id ; ?>" ><?php echo $tour_review_count ; ?> Reviews</p>
            <ul class="tour_cate_type" style="color:black";>
              <li>
                <?php 
                  $for_counter = 0 ;
                  $total = count((array)$homeData->categories)-1; 
                  foreach ($homeData->categories as $category):
                    echo $category->title;
                    if($for_counter != $total):
                      echo ", ";
                    endif; 
                    $for_counter++; 
                  endforeach; 
                ?>
              </li>
            </ul>
            <div class="col-md-12 home_review">
              <ul class="list_f tour_address">
                <li><?php echo $tour_location_address1 ; ?></li>
                <li><?php echo $tour_location_address2 ; ?></li>
                <li><?php echo $tour_city ; ?>  <?php echo $tour_state ; ?>  <?php echo $tour_zipCode ; ?></li>
                <li><?php echo $tour_phone ; ?></li>
              </ul>
            </div>
            
        </div>
  <?php
      endforeach;
      ?>
      </div>
      <?php
    else:
  ?>
      <div class="row tab-two text-muted">
          <div class="yelp-serach-null-result col-md-5 col-sm-5 col-xs-6">
            <p> No record Found</p>
          </div>
        </div>
<?php
    endif;?>
    </div>
    		<div class="container recommed-city pcdesktop max_containerr">
		<div class="us-city worldtop_city tour_listing spefic_adrk">
				<div class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific" style="width:24%">
				<h2>Tickets</h2>
				<span>Concerts, Events, and Theater</span>
				</div>
			<div class="owl-carousel owl-theme" style="width:75%; float: right">
				<?php foreach ($get_ticket_data as $key => $homeData) {
					$eventsName = $homeData['name'];
					$eventUrl = $homeData['url'];
					$image_url = $homeData['images'][1]['url'];

					$image = "https://mysitti.com/images/noimage-found.jpeg"; 
					if(!empty($image_url)){
					$image =  $image_url ;
					}
				?>

				<div class="item col-md-12 col-sm-12 col-xs-12 homeGroupon city-recom" style="width: 100% !important">
				<a href="<?php echo $eventUrl; ?>" target="_blank">
              <img src="<?php echo $image; ?>" alt="Family">
              <span><?php echo $eventsName; ?></span>
              </a>
				</div>
				<?php  } ?>

			</div>
		</div>
		</div> 
     <?php

      if($_SESSION['city_name'] == 'Washington D.C.'){
      $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' LIMIT 20";
      }else{
      $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' LIMIT 20";
      }
      $result = $mysqli->query($randon_deals);?>
      <div class="us-city worldtop_city custom_tours">
                  <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific" style="width: 23%">
                  <a id="top_links" name="escape%20%room" >
                  <h2><?php echo $_SESSION['city_name']; ?> Tours</h2>
                  <span>sightseeing,tour,and passes</span>
                  </a>
                  </div>
                   <div class="owl-carousel owl-theme" style="width: 75%; float: right;">
      <?php 
      foreach ($result as $keys => $values) {
          if(!empty($values['tag'])){
            ?>
        <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific">
        <a href="<?php echo $values['link']; ?>"  target="_blank">
        <img src="<?php echo $values['image_link']; ?>" alt="">
          <div class="PictureCard-overlay">
         
            <div class="PictureCard-wrapper">
              <div class="PictureCard-data">
                <span class="PictureCard-price length-5">$ <?php echo $values['price']; ?></span>
              </div>
              <div class="PictureCard-menu">
                <div> 
                  <div class="PictureCard-timebox _outbound">
                    <div class="PictureCard-timebox-col">
                      <span class=""><?php echo $values['title']; ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </a>
          </div>
        
      <?php     
          }
          }
        ?>
</div>
</div>
<?php
        $get_deals = groupon_api_call('30',$_SESSION['city_name'],'restaurants deals');
?>
          <div class="container recommed-city pcdesktop max_containerr">
              <div class="us-city worldtop_city tour_listing thing_toDoGroupon">
             
             <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
          <h2>Restraurant Deals</h2>
          <span>Save yourself or family money with meal deals</span>
    </div>
    <div class="owl-carousel owl-theme">
          <?php 
          $i= 0;
          foreach ($get_deals as $homeData):
              $price = $homeData['options'][0]['price']['formattedAmount'];
              $value = $homeData['options'][0]['value']['formattedAmount'];
              $discountPercent = $homeData['options'][0]['discountPercent'];
              $endAt =  $homeData['options'][0]['endAt'];
              $endDate = date('m/d/Y', strtotime($endAt));
              $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
              $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
              $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
              $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
              $tourname = $homeData['title']; 
            $out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
            if($discountPercent != 0){
              $i++;?>
               
            <div class="item col-md-12 col-sm-12 col-xs-12 homeGroupon city-recom">
              <div class='borderIsan hotelandingDeal'>
                <a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
                  <img src="<?php echo $homeData['grid4ImageUrl']; ?>">
                </a>
                <a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
                  <!-- <h2 class="discountPercent"><?php echo $discountPercent; ?>% Off</h2> -->
                  <h1 class="nameIsan hotelandingnameIsan" style= "text-align: center;"><?php echo $out ; ?></h1>
                </a>
                <h1 class="pricelanding"><?php echo $value ; ?></h2>
                <h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>
                

                <h2 class="valuelanding"><?php echo $price ;?></h1>
                <h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
              </div>
            </div>
        <?php  }  endforeach; ?>
      </div>
      	</div>
</div>

<?php 
$today = date("Y-m-d");
$tomorrow = date('Y-m-d', strtotime($today. ' + 1 days'));
$hotel_url = "http://hotels.mysittivacations.com/hotels?destination=".$_SESSION['city_name']."&=1&checkIn=".$today."&checkOut=".$tomorrow."&adults=2&language=en_us&currency=usd&marker=130544.Zz19b397cdcee540df9e5db24717f4bb";
?>
<div class="container specificRooms specif_roomss">
<div class="headingActivity-new new_activity">
<a href="<?php echo $hotel_url; ?>" target="_blank" class="open-CitiesDialog">See all</a></div>
                  <div class="homespecificrooms">
                  <h2>Places To Stay</h2>
                  <span>Family and Pet Friendly Hotels</span>
                   </div>
<?php
$getAds = "SELECT content FROM specific_city_sidebar WHERE city like '%".$_SESSION['city_name']."%' limit 1";
      $result = $mysqli->query($getAds);
      $count = $result->num_rows;
      if($count > 0){
        foreach ($result as $key => $value) {
          $fiveStar = str_replace('popularity', '5star', $value['content']);
          echo str_replace('limit=50', 'limit=8', $fiveStar);
        }
      }
  ?>

	</div>
        </div> 
	</div>
</div>
<!-- Us popular city -->

<div class='modal fade' id='popularcitiesModal' role='dialog'>

	<div class='modal-dialog '>
		<div class='modal-content'>
		    <div class='modal-header'>
		    	<span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>
		      	<button type='button' class='close' data-dismiss='modal'>&times;</button>
		      	<div id="modal_loader"></div>
		    </div>
		    <div class="cities_modal">
		    	
		    </div>
		    <div class='modal-footer'>
		      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		    </div>
		</div>
	</div>
</div>

<!-- Us popular city End -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/autocomplete.js"></script>
<script>
	(function($){
		var jQuery_2_1_1 = $.noConflict(true);
		jQuery_2_1_1('#suggestion_search').autocomplete({
			serviceUrl: 'family_search_data.php',
			groupBy: 'category',
			minChars:'2',
 			preventBadQueries: true,
 			type: "GET",
			onSearchStart: function(query, suggestions) {
				$("#loadingmessage").show();
			},
			formatResult: function(suggestion) {

				var html = '<a href="'+suggestion.data.url+'"><img src="'+suggestion.data.img+'">';
				html += '<div class="text-format"><h3>'+suggestion.value+'</h3><p>'+suggestion.data.class+'</p><p>'+suggestion.data.date+'</p></div></a>';
				return html;
			},
			onSearchComplete: function(query, suggestions) {
				$("#loadingmessage").hide();
				if(!suggestions.length){
            		console.log('no suggestion');
        		}
			},
			noCache: true,
			showNoSuggestionNotice: true,
  			noSuggestionNotice: "Sorry, no matching results"
		});
	})(jQuery);
</script>

<script type="text/javascript">

	var pageCounter = 0;
	if ($('#target').val().length === 0) {
		var geodemo = $('#geo-demo').val();
	}else{
		var geodemo = $('#target').val();
	}
	$(window).load(function(){

	  	var textBox_city = $('#refine-result').val();
	var date1 = $('#dpd_team').val();
	var date2 = $('#dpdtm').val();
	var drop_down_keyword = 'Family Attractions';	

	if(textBox_city == ''){
		alert('Please Enter City Name')
	}else{
	  
	  $.ajax({
	    url: "ajax_refine_ticketmaster_data.php",
	    type: "POST",
	    data: {
	      formatted: textBox_city, srartdate: date1, enddate : date2, doropdown : drop_down_keyword
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
	    	console.log(response);
		   	$('.family-ticketMaster').html(response);
		   	$("#loader").removeClass("loading");
		}
		});	
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
			   	$('.cities_modal').html(response);
			   	$("#modal_loader").removeClass("loading");
			}
	  	});    
	});
</script>
<script type="text/javascript">
	   $(document).ready(function() {
              $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                autoplay: false,
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 3,
                    nav: false
                  },
                  1000: {
                    items: 3,
                    nav: true,
                    loop: false,
                    margin: 20
                  }
                }
              })
            })
</script>
<?php

include('LandingPageFooter.php');

 ?>
