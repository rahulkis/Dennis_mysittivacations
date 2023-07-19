<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$city = $_POST['formatted'];
$page = $_POST['page'];

$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=comedy&sort=date,asc&countryCode=US&city=".$city."&page=".$page."";
 
$result_get = file_get_contents($urlgo);

$get_all_data = json_decode($result_get, true);
 
$page_size = $get_all_data['page']['size'];
$totalPages = $get_all_data['page']['totalPages'];
$number = $get_all_data['page']['number'];

$get_deals = $get_all_data['_embedded']['events'];

?>
<?php 
	if(!empty($get_deals)){
	foreach ($get_deals as $homeData){


		$eventsName = $homeData['name'];
		$eventUrl = $homeData['url'];
		$start_date = $homeData['dates']['start']['localDate'];

		$timestamp = strtotime($start_date);
		$date_foemate = date('m/d/Y', $timestamp);

		$nameOfDay = date('D', strtotime($start_date));

		$time = $homeData['dates']['start']['localTime'];
		$strtime = date('h:i A', strtotime($time));

		$address1 = $homeData['_embedded']['venue'][0]['address']['line1'];
		$address2 = $homeData['_embedded']['venue'][0]['address']['line2'];
		$image_url = $homeData['images'][1]['url'];

		$image = "https://mysittivacations.com/images/noimage-found.jpeg"; 
		if(!empty($image_url)){
			$image = $image_url;
		}

	$html .= "<div class='row ticketmaster_row'>
		<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>
		<a >
		<img src= ".$image." width='150' height='63'>
		</a>

		</div>
		<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>

		<div class='well new_name_formate'> 
		".$eventsName."
		</div>

		<div class='well new_address_formate'> 
		<p>".$address1."<p><br>
		<p>".$address2."</p>
		</div>
		</div>
		<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>
		<div class='well new_date_formate'> 
		<p>". $nameOfDay .','.$date_foemate."</p>
		<p>".$strtime."</p>
		</div>
		</div>

		<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>
		<div class='well btn-mor'> 
		<a href=".$eventUrl." target='_blank'>See Tickets</a>
		</div>
		</div>
		</div>";
	}
		echo $html;
		if ($totalPages > 1) {
			if ($number == 0) {
				echo $html1 = "<div class='next-prev'><button class='next' field='quantity'>Next</button></div>";
			}
	    	if($totalPages != $number+1) {
				echo $html1 = "<div class='next-prev'><button class='prev' field='quantity'>Prev</button>
				
						<button class='next' field='quantity'>Next</button></div>";
			}elseif($number == $totalPages-1){
				echo $html1 = "<div class='next-prev'><button class='prev' field='quantity'>Prev</button></div>";
			}
	    }
	}else{

		echo '<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h2>';
	}
?>
