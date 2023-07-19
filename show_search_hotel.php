<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$formatted = $_POST['formatted'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$room = $_POST['room'];
$adults = $_POST['adult'];
$child = $_POST['child'];

	$completeurl = "http://api.hotwire.com/v1/deal/hotel?apikey=askvpcgfkw6fc2xrrcwkg5k6&limit=15&dest=".$formatted."&rooms=".$room."&adults=".$adults."&children=".$child."&startdate=".$checkin."&enddate=".$checkout."";
	$xml = simplexml_load_file($completeurl);
	
	$get_d = json_decode( json_encode($xml), true);
	   	
	$html = "";
	echo "<h2 class='deal_heading'>TOP DEALS OF THE DAY</h2>";
	if(!empty($get_d['Result']['HotelDeal'])) 
	{
    foreach ($get_d['Result']['HotelDeal'] as $Data)
    {
    	
    	$html .= "<div class='home_list'>
					<div class='Event_Div2'>
				        <div class='divHeader'>
				        	<span class='listingEventName'>".$Data['Headline']."</span>
				        </div>

				        <div class='divVenue'>".$Data['City'].", ".$Data['CountryCode']."</div>
				        <span class='event_datetime'>".(float)$Data['StarRating']." - Star</span>
					</div>
					<div class='Event_Div2'>
						<span class='priceCls'>".(float)$Data['Price']." ".$Data['CurrencyCode']."</span><br>
						<span class='discountCls'>".$Data['SavingsPercentage']."% off</span>
					</div>
					<div class='divViewTix'>
						<a href=".$Data['Url']." target='_blank'>
							<span class='ic'>></span>
							<span class='bText'>Select</span>
						</a>
					</div>
			</div>";
    	}
    	echo $html;
    	} else {
	    	echo "<h1 style='clear: both; padding-top: 10px;' class='record_not_found'>Records not found.</h1>";
	    }	
?>