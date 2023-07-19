<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

// $price = $_POST['range'];
// $newP = explode(';', $price);
// $arr1 = $newP[0];
// $arr2 = $newP[1];
// if(isset($_POST['data']))
// {
//     parse_str($_POST['data'], $searcharray);
//    echo "<pre>";
//    print_r($searcharray);
//    echo "</pre>";
   
// }
?>

<?php

$value = $_POST['starValue'];
$destination = $_POST['desti'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$room = $_POST['rom'];
$guest = $_POST['gust'];

// echo $today = date("Y-m-d");
// echo $next = date('Y-m-d', strtotime(' +1 day'));

$start=0;
$limit = 30;
	if(isset($_GET['page']))
	{
	$page = $_GET['page'];
	$start = ($page-1)*$limit;
	}

		// $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$destination."&key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM";

		// $details=file_get_contents($url);
		// $result = json_decode($details,true);

		// $lat=$result['results'][0]['geometry']['location']['lat'];
		// $lng=$result['results'][0]['geometry']['location']['lng'];

		$url2 = "https://apim.expedia.com/wsapi/rest/hotel/v2/search?&locationkeyword=".$destination."&dates=".$checkin.",".$checkout."&stars=".$value."&sort=price&radius=100&maxhotels=70&format=json&key=2f87cd1c-9af8-474b-ab7d-e193a13982cb";
		$result = file_get_contents($url2);
		
		$get_all_data = json_decode($result, true); 

		// $urls = "https://api.tripexpert.com/v1/venues?order_by=distance&venue_type_id=1&latitude=".$lat."&longitude=".$lng."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
		// $result_tripn = file_get_contents($urls);
  //       $get_all_data2 = json_decode($result_tripn, true);
  //       $resto_venues = $get_all_data2['response']['venues'];

  //       $array1 = array_column($get_all_data['HotelInfoList']['HotelInfo'], 'Name');
		// $array2 = array_column($resto_venues, 'name');

		// $comp = array_intersect($array2, $array1);

		?>


		<input type="hidden" id="desti" value="<?php echo $destination; ?>">
		<input type="hidden" id="checkinin" value="<?php echo $checkin; ?>">
		<input type="hidden" id="checkoutt" value="<?php echo $checkout; ?>">
		<input type="hidden" id="room" value="<?php echo $room; ?>">
		<input type="hidden" id="guest" value="<?php echo $guest; ?>">
		<?php
	    foreach($get_all_data['HotelInfoList']['HotelInfo'] as $deal) {
		    		// foreach (array_unique($comp) as $key => $valuename) {
		    			
		    		// 	if($valuename == $deal['Name']) {
	    	$html .= "<div class='hotel_list'>
						<li><img src='".substr_replace($deal['ThumbnailUrl'],'b.jpg',-5)."'></li>
						<div class='hotel_data'>
							<h2><a href='".$deal['DetailsUrl']."' target='_blank'>".$deal['Name']."</a></h2>
							<h4 class='city_nme'>".$deal['Location']['City']."</h4>
							<div class='evnt_nme'>
								<span class='event_heading'>Star Rating: </span>
								<h3 class='star_number' style='padding-right:7px;'>".$deal['StarRating']."</h3>
							</div>
							<div class='evnt_nme'>
								<span class='event_heading'>Address: </span>
								<h3 class='sports_name'>".$deal['Location']['StreetAddress'].", ".$deal['Location']['City'].", ".$deal['Location']['Province'].",".$deal['Location']['Country']."</h3>
							</div>
							<p>".$deal['Description']."</p>
						</div>
						<div class='hotel_check'>
							<li>
								<a href='".$deal['DetailsUrl']."' target='_blank'>www.hotels.com</a>
								</br>
								<span>$".$deal['Price']['TotalRate']['Value']."</span>
							</li><br>
							<li><a href='".$deal['DetailsUrl']."' class='hotelLink' target='_blank'>Select Hotel</a></li>
						</div>
					</div>";
    	//}
	    //}
		}
    	echo $html;
    	$total=ceil($rows/$limit);
    	if($rows > 30)
    	{
    	echo '<div class="pagination_new">';
			if($total > 1)
			{
				echo "<a href='?page=1'><span title='First'>&laquo;</span></a>";
				if ($page <= 1)
					echo "<span>Previous</span>";
				else            
					echo "<a href='?page=".($page-1)."'><span>Previous</span></a>";
				echo "  ";
				if(!isset($_GET['page']))
				{
					$y = '1';
				}
				else
				{
					$y = $_GET['page'];
				}

				$z = '0';
				$pageNumber = (int) $_GET['page'];
				for ($x=$y;$x<=$total;$x++){
					if($z < 9)
					{
						echo "  ";
						if ($x == 1)
						{
							echo "<span class='active_range'>$x</span>";
						}
						else
						{ ?>
							<a href='?page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
					<?php	}
					}
					$z++;
				}
				if($page == $total) 
					echo "<span>Next</span>";
				else           
					echo "<a href='?page=".($page+1)."'><span>Next</span></a>";

				echo "<a href='?page=".$total."'><span title='Last'>&raquo;</span></a>";
			}
		echo "</div>";
	}
    	
?>