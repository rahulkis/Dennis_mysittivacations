<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$formatted = $_POST['formatted'];
$checkin = $_POST['checkin'];
$chtime = $_POST['chtime'];
$cout = $_POST['cout'];
$cout2 = $_POST['cout2'];

	$completeurl = "http://api.hotwire.com/v1/search/car?apikey=askvpcgfkw6fc2xrrcwkg5k6&dest=".$formatted."&startdate=".$checkin."&enddate=".$cout."&pickuptime=".$chtime."&dropofftime=".$cout2."";
	$xml = simplexml_load_file($completeurl);
        
        $get_d = json_decode( json_encode($xml), true); 
        
        $arr1[] = $get_d['MetaData']['CarMetaData']['CarTypes']['CarType'];
        $arr2[] = $get_d['Result']['CarResult'];
        
        $array1 = $arr1[0];
        $array2 = $arr2[0];

        
        $result = array_map(function($array1,$array2){

        return array_merge(isset($array1) ? $array1 : array(), isset($array2) ? $array2 : array());

        },$array1,$array2);
	
	echo "<h2 class='deal_heading'>RENTAL CAR OF THE DAY</h2>";
	
	if(!empty($result)) 
	{
    foreach ($result as $Data)
    {
    	$html .= "<div class='home_list'>
                <div class='Event_Div2'>
                      <div class='divHeader'>
                        <span class='listingEventName'>".$Data['CarTypeName']."</span>
                      </div>
                      <div class='divVenue'>".$Data['PossibleModels']."</div><br>
                      <div class='divVenue'>".$Data['MileageDescription']." miles</div><br>
                      <label>Seat: </label><div class='divVenue'>".$Data['TypicalSeating']."</div><br>
                      <label>Possible Features: </label><div class='divVenue'>".$Data['PossibleFeatures']."</div>
                </div>
                <div class='Event_Div2'>
                  <span class='priceCls'>".(float)$Data['TotalPrice']." ".$Data['CurrencyCode']."</span><br>
                  <span class='dalyrate'>$".$Data['DailyRate']." per day</span>
                </div>
                <div class='divViewTix'>
                  <a href=".$Data['DeepLink']." target='_blank'>
                    <span class='ic'>></span>
                    <span class='bText'>Continue</span>
                  </a>
                </div>
            </div>";
    	}
    	echo $html;
    } else {
    	echo "<h1 style='clear: both; padding-top: 10px;' class='record_not_found'>Records not found.</h1>";
    }	
?>