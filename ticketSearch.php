<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$getValue = $_POST['formatted']; // main banner search box

$firstd = $_POST['da1']; // for date range filter
$secd = $_POST['da2'];
$datecin=date_create($firstd);
$date1 = date_format($datecin,"Y-m-d");

$dateout=date_create($secd);
$date2 = date_format($dateout,"Y-m-d");


$teamValue = trim($_POST['teamValue']); // for search box in sidebar



$start=0;
$limit = 30;
	// if(isset($_GET['page']))
	// {
	// $page = $_GET['page'];
	// $start = ($page-1)*$limit;
	// }
		if(!empty($getValue))
		{

			$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE `startdate` > NOW() AND (city LIKE '%$getValue%' OR `keywords` LIKE '%$getValue%') ORDER BY startdate ASC LIMIT $start, $limit";
		} elseif (!empty($teamValue)) {
			$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE `startdate` > NOW() AND (keywords LIKE '%$teamnm%' OR description LIKE '%$teamnm%') ORDER BY startdate ASC LIMIT $start, $limit";
		} else {
			$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM `ticket_sportsevent` WHERE startdate BETWEEN '$date1' and '$date2' LIMIT 45";
		}
	
		$result = mysql_query($sql);
		$html = "";
		

	    $rows = mysql_num_rows(mysql_query("SELECT name FROM ticket_sp	ortsevent WHERE city LIKE '%$getValue%' OR `keywords` LIKE '%$getValue%' AND `startdate` > NOW() LIMIT $start, $limit"));
	    $co = mysql_num_rows($result);
	    if($co != 0) {

	    while($row = mysql_fetch_assoc($result)) 
	    {
	    	

	    	$html .= "<div class='sports_list'>
					<li>";
					if(!empty($row['imageurl'])) {
					$html .= "<img src='".$row['imageurl']."'>";
					} else {
					$html .= "<img src='images/image-coming-soon-8.png'>";
					 }
					$html .= "</li>
					<div class='hotel_data'>
						<h2><a href='".$row['buyurl']."' target='_blank'>".$row['name']."</a></h2>
						<h4 class='city_nme'>".$row['city']."</h4><br>
						<div class='evnt_nme'>
							<span class='event_heading'>Event Name: </span>
							<h3 class='sports_name'>".$row['sport_events_name']."</h3>
						</div>
						<div class='evnt_nme'>
							<span class='event_heading'>Date Time: </span>
							<h3 class='sports_name'>".$row['startdate']."</h3>
						</div>
						<div class='evnt_nme'>";
						if($category_val == "concerts")
						{
							$html .= "<span class='event_heading'>Concert Category: </span>";
						} else {
							$html .= "<span class='event_heading'>Sports Category: </span>";
						}
						
						$html .= "<h3 class='sports_name'>".$row['sport_category']."</h3>
						</div>
						<p>".$row['description']."</p>
					</div>
					<div class='hotel_check'>
						<li>
							<a href='".$row['buyurl']."'>".$row['programname']."</a>
							</br>
							<span>$".$row['price']."</span>
						</li>
						<li><a href='".$row['buyurl']."' class='hotelLink' target='_blank'>Select Events</a></li>

					</div>
					</div> ";
			}
    	}
		else
			{
				$html .= "<h1 class='record_not_found'>Events not found.</h1>";
			}
    	echo $html;
    	$total=ceil($rows/$limit);
    	// if($rows > 15)
    	// {
  //   	echo '<div class="pagination_new">';
		// 	if($total > 1)
		// 	{
		// 		echo "<a href='?page=1'><span title='First'>&laquo;</span></a>";
		// 		if ($page <= 1)
		// 			echo "<span>Previous</span>";
		// 		else            
		// 			echo "<a href='?page=".($page-1)."'><span>Previous</span></a>";
		// 		echo "  ";
		// 		if(!isset($_GET['page']))
		// 		{
		// 			$y = '1';
		// 		}
		// 		else
		// 		{
		// 			$y = $_GET['page'];
		// 		}

		// 		$z = '0';
		// 		$pageNumber = (int) $_GET['page'];
		// 		for ($x=$y;$x<=$total;$x++){
		// 			if($z < 9)
		// 			{
		// 				echo "  ";
		// 				if ($x == 1)
		// 				{
		// 					echo "<span class='active_range'>$x</span>";
		// 				}
		// 				else
		// 				{ ?>
							<!-- <a href='?page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a> -->
		 			<?php	//}
		// 			}
		// 			$z++;
		// 		}
		// 		if($page == $total) 
		// 			echo "<span>Next</span>";
		// 		else           
		// 			echo "<a href='?page=".($page+1)."'><span>Next</span></a>";

		// 		echo "<a href='?page=".$total."'><span title='Last'>&raquo;</span></a>";
		// 	}
		// echo "</div>";
	// }
    	
?>