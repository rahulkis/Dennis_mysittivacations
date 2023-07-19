<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";


$drop_city = $_POST['formatted'];

$start = 0;
$limit = 15;

$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM `ticket_sportsevent` WHERE `startdate` > NOW() AND (`city` LIKE '%$drop_city%' OR `keywords` LIKE '%$drop_city%') AND `advertisercategory` = 'THEATRE' ORDER BY startdate ASC";
			$result = mysql_query($sql);
			$nurows = mysql_num_rows($result);


	
    $html .= "<h2 class='near_events_first'>".$drop_city." Concerts</h2>";
	if($nurows > 0) {
    while($row = mysql_fetch_assoc($result))
    {
    	
	    	$html .= "<div class='home_list'>
						<div class='Event_Div'>";
							 	$timestamp = $row['startdate']; 
								$splits =  explode(" ",$timestamp);
								
								$get_date = $splits[0];
								$orderdate = explode('-', $get_date);
								$month = $orderdate[1];
								$day   = $orderdate[2];
								$year  = $orderdate[0];
								$get_time = $splits[1];
								$months = $month;
												switch ($months) {
												    case "01":
												        $cal = "JAN";
												        break;
												    case "02":
												        $cal = "FEB";
												        break;
												    case "03":
												        $cal = "MAR";
												        break;
												  case "04":
												        $cal = "APR";
												        break;
												  case "05":
												        $cal = "MAY";
												        break;
												  case "06":
												        $cal = "JUN";
												        break;
												  case "07":
												        $cal = "JUL";
												        break;
												  case "08":
												        $cal = "AUG";
												        break;
												  case "09":
												        $cal = "SEP";
												        break;
												  case "10":
												        $cal = "OCT";
												        break;
												  case "11":
												        $cal = "NOV";
												        break;
												  default:
												        $cal = "DEC";
												}
							
					$html .= "<div class='divEventDate'>
								<div class='date_wrapper'>
									<span class='month'>".$cal."</span>
									<span class='date'>".$day."</span>
									<span class='weekday'>".$year."</span>
								</div>
							</div>
									        
					        <div class='divHeader'>
					        	<a href='".$row['buyurl']."' target='_blank'><span class='listingEventName'>".$row['name']."</span></a>
					        </div>

					        <div class='divVenue'>".$row['keywords']." </br> ".$row['sport_category']."</div>
					        <span class='event_datetime'>".$get_time."</span>
					        <span class='event_datetime'>".$row['price']."</span>
						</div>
						</div>";
    	}
    	echo $html;
    	} else {

    		$html .= "<h1 class='record_not_found'>Events not found.</h1>";
    		echo $html;
    	
    	}
   
    	
?>