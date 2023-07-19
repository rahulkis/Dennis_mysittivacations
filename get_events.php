<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$region = $_POST['region'];
$cid = $_POST['cid'];
$id = $_POST['id'];

$start = 0;
$limit = 15;
// 	if(isset($_GET['page']))
// 	{
// 	$page = $_GET['page'];
// 	$start = ($page-1)*$limit;
// 	}

	$completeurl = "https://www.ticketcity.com/ws/xmlticketapiv3/xmlticketapiv3.asmx/".$region."?APIKey=e040f13b-094b-4b35-8aa0-2b10c1adc8e7&".$cid."=".$id."";
	$xml = simplexml_load_file($completeurl);
	
	$get_d = json_decode( json_encode($xml), true);			
	$get_data = $get_d['Event'];
    $response = [];       
    foreach ($get_data as $i => $data) {
        $response[$i]['event'] = $data['@attributes'];
        $response[$i]['performer'] = $data['Performer']['@attributes'];
        $response[$i]['venue'] = $data['Venue']['@attributes'];
        $response[$i]['venue']['city'] = @$data['Venue']['City']['@attributes'];
        $response[$i]['venue']['country'] = @$data['Venue']['Country']['@attributes'];
    }  	
	$html = "";
	$rows = count($response);
	$slice = array_intersect_key($response,array_flip(array_slice(array_keys($response),$start,$limit)));
	if(!empty($slice)) {
    foreach ($slice as $Data)
    { 
    	
	    	$html .= "<div class='home_list'>
						<div class='Event_Div'>";
							 	$timestamp = $Data['event']['EventDateTime']; 
								$splits =  explode(" ",$timestamp);
								
								$get_date = $splits[0];
								$orderdate = explode('/', $get_date);
								$month = $orderdate[0];
								$day   = $orderdate[1];
								$year  = $orderdate[2];
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
					        	<span class='listingEventName'>".$Data['event']['Name']."</span>
					        </div>

					        <div class='divVenue'>".$Data['venue']['Name']." - ".$Data['venue']['city']['Name'].", ".$Data['venue']['country']['Name']."</div>
					        <span class='event_datetime'>".$get_time."</span>
						</div>

						<div class='divViewTix'>
							<a href=".$Data['event']['Page']." target='_blank'>
								<span class='ic'>></span>
								<span class='bText'>Select</span>
							</a>
						</div>
				</div>";
    	}
    	echo $html;
    	} else {

    		$html .= "<h1 class='record_not_found'>Events not found.</h1>";
    		echo $html;
    	
    	}
    	
 //    	$total=ceil($rows/$limit);
 //    	if($rows < 0)
 //    	{
 //    	echo '<div class="pagination_new">';
	// 		if($total > 1)
	// 		{
	// 			echo "<a href='?page=1'><span title='First'>&laquo;</span></a>";
	// 			if ($page <= 1)
	// 				echo "<span>Previous</span>";
	// 			else            
	// 				echo "<a href='?page=".($page-1)."'><span>Previous</span></a>";
	// 			echo "  ";
	// 			if(!isset($_GET['page']))
	// 			{
	// 				$y = '1';
	// 			}
	// 			else
	// 			{
	// 				$y = $_GET['page'];
	// 			}

	// 			$z = '0';
	// 			$pageNumber = (int) $_GET['page'];
	// 			for ($x=$y;$x<=$total;$x++){
	// 				if($z < 9)
	// 				{
	// 					echo " ";
	// 					if ($x == 1)
	// 					{
	// 						echo "<span class='active_range'>$x</span>";
	// 					}
	// 					else
	// 					{ ?>
	 						<!-- <a href='?page=<?php// echo $x; ?>'><span class='<?php //echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php //echo $x; ?></span></a> -->
	 				<?php	//}
	// 				}
	// 				$z++;
	// 			}
	// 			if($page == $total) 
	// 				echo "<span>Next</span>";
	// 			else           
	// 				echo "<a href='?page=".($page+1)."'><span>Next</span></a>";

	// 			echo "<a href='?page=".$total."'><span title='Last'>&raquo;</span></a>";
	// 		}
	// 	echo "</div>";
	// }
    	
?>