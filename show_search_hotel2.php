<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";


$start = 0;
$limit = 15;
// 	if(isset($_GET['page']))
// 	{
// 	$page = $_GET['page'];
// 	$start = ($page-1)*$limit;
// 	}

$formatted = $_POST['formatted'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$adults = $_POST['adults'];
$child = $_POST['child'];
$room = $_POST['room'];

	$completeurl = "http://api.hotwire.com/v1/search/hotel?apikey=askvpcgfkw6fc2xrrcwkg5k6&dest=memphis&rooms=1&adults=2&children=0&startdate=07/20/2017&enddate=07/23/2017";

	$xml = simplexml_load_file($completeurl);
	
	$get_d = json_decode( json_encode($xml), true);
	echo "<pre>";
	print_r($get_d);
	echo "</pre>";
	      
     	
	$html = "";
	//$rows = count($response);
	//$slice = array_intersect_key($response,array_flip(array_slice(array_keys($response),$start,$limit)));
	// if(!empty($slice)) {
	echo "<h2 class='deal_heading'>TOP DEALS OF THE DAY</h2>";
    foreach ($get_d['Result']['HotelDeal'] as $Data)
    { 
    	// echo "<pre>";
    	// print_r($Data);
    	// echo "</pre>";
    	// die;
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
    	// } else {

    	// 	$html .= "<h1 class='record_not_found'>Events not found.</h1>";
    	// 	echo $html;
    	
    	// }
    	
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
