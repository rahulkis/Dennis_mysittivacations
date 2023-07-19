<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$dropCity = $_POST['formatted'];
if($dropCity == 'Washington D.C.'){
	$dropCity = 'Washington';
}elseif($dropCity == 'Washington DC'){
	$dropCity = 'Washington';
}
$page = $_POST['page'];
$dropdown_value = $_POST['dropValue'];


$date1 = $_POST['srartdate'];
$start_date = date("Y-m-d", strtotime($date1)).'T12:00:00Z';
$date2 = $_POST['enddate'];
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

	$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&startDateTime=".$start_date."&endDateTime=".$end_date."&countryCode=US&classificationId=".$ids."&dmaId=".$city_dma_id."&page=".$page."";

}else{

	$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&countryCode=US&classificationId=".$ids."&dmaId=".$city_dma_id."&page=".$page."";

}


$result_get = file_get_contents($urlgo);
$get_all_data = json_decode($result_get, true);

$page_size = $get_all_data['page']['size'];
$totalPages = $get_all_data['page']['totalPages'];
$number = $get_all_data['page']['number'];


$get_deals = $get_all_data['_embedded']['events']; 



?>


<?php 
if(!empty($get_deals)){
	foreach ($get_deals as $homeData)
	{


		$eventsName = $homeData['name'];
		$eventUrl = $homeData['url'];
		$start_date = $homeData['dates']['start']['localDate'];

		$timestamp = strtotime($start_date);
		$date_foemate = date('m/d/Y', $timestamp);

		$nameOfDay = date('D', strtotime($start_date));
		$time = $homeData['dates']['start']['localTime'];
		$strtime = date('h:i A', strtotime($time));
		$city = $homeData['_embedded']['venues'][0]['city']['name'];
		$state = $homeData['_embedded']['venues'][0]['state']['name'];
		$country = $homeData['_embedded']['venues'][0]['country']['countryCode'];
		$venue_name =$address1 = $homeData['_embedded']['venues'][0]['name'];
		$address1 = $homeData['_embedded']['venues'][0]['address']['line1'];
		$address2 = $homeData['_embedded']['venues'][0]['address']['line2'];
		$image_url = $homeData['images'][1]['url'];

		$image = "https://mysitti.com/images/noimage-found.jpeg"; 
		if(!empty($image_url)){
			$image =  $image_url ;
		}


		$html .= "<div class='col-md-6'>
		<div class='music_shows'>
		<a href=".$eventUrl." target='_blank'>
		<div class='image_htfix'>
		<img src= ".$image." class='img-fluid'>
		</div>
		</a>
		<div class='showname_location'>
		<h5> ".$eventsName."</h5>
		<p class='contacts'><i class='fas fa-map-marker-alt'></i> ".$venue_name."</p>
		</div>
		<p class='contacts p-3 ''><i class='fas fa-map-marker-alt'></i>".$address1."  ".$address2.", ".$city.", ".$country."</p>
		<div class='date_coupon'>
		<p class='contacts'><i class='fas fa-calendar'></i> ". $nameOfDay .','.$date_foemate." </p>
		<p class='contacts'><i class='fas fa-clock'></i>".$strtime."</p>
		</div>
		<div class='detail_btn mx-0'>
		<a href=".$eventUrl." target='_blank'><button>SEE TICKET</button></a>
		</div>

		</div>
		</div>
		";
	}


}else{
	echo '<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h2>';
}

$html .= "<div class='pagination'>
<button class='pagination_btn prev-refine' field='quantity'>Previous</button>

<input type='text' value=".rawurlencode($dropdown_value)." class='drop-value' style='display:none;'>	
<button class='pagination_btn next-refine' field='quantity'>Next</button>
</div>  ";
echo $html;
?>
