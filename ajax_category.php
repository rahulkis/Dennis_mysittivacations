<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$category_val = $_POST['category_val'];

$city = $_POST['formatted'];


$start=0;
$limit = 30;
	// if(isset($_GET['page']))
	// {
	// $page = $_GET['page'];
	// $start = ($page-1)*$limit;
	// }
	if($category_val == "concerts")
	{
		$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE advertisercategory LIKE '%$category_val%' AND `startdate` > NOW() ORDER BY startdate ASC LIMIT $start, $limit";
	} else {

	$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE sport_category LIKE '%$category_val%' AND `startdate` > NOW() AND city LIKE '%$city%' ORDER BY startdate ASC LIMIT $start, $limit";
	}
	
		$result = mysql_query($sql);
		// $html = "";
		// 		$html .= "<div class='filter_ticketCategory'>
		// 		<label class='labelfilter'>Sports Category: <em>".$category_val."</em></label>
		// 	  	<select id='SportCategory' name='status' onchange='getCategory(this.value)'>
		// 	      <option value=''>Select Category</option>
		// 	      <option value='tennis'>Tennis</option>
		// 	      <option value='baseball'>Baseball</option>
		// 	      <option value='football'>Football</option>
		// 	      <option value='concerts'>Concerts</option>
		// 	      <option value='basketball'>Basketball</option>
		// 	      <option value='volleyball'>Volleyball</option>
		// 	      <option value='golf'>Golf</option>
		// 	      <option value='hockey'>Hockey</option>
		// 	      <option value='racing'>Racing</option>
		// 	      <option value='wrestling'>Wrestling</option>
		// 	      <option value='boxing'>Boxing</option>
		// 	      <option value='skating'>Skating</option>
		// 	      <option value='rodeo'>Rodeo</option>
		// 	      <option value='soccer'>Soccer</option>
		// 	      <option value='rugby'>Rugby</option>
		// 	      <option value='lacrosse'>Lacrosse</option>
		// 	      <option value='gymnastics'>Gymnastics</option>
		// 	      <option value='softball'>Softball</option>
		// 	    </select>
		// 	</div>";
	    $rows = mysql_num_rows(mysql_query("SELECT name FROM ticket_sportsevent WHERE sport_category LIKE '%$category_val%' AND `startdate` > NOW() AND city LIKE '%$city%'"));
	    if($rows > 0) {
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
    	} else {
    		echo "<h1 class='record_not_found' style='margin-top: 23px;'>No record found.</h1>";
    	}
    	echo $html;
    	$total=ceil($rows/$limit);
    	 if($rows > 15)
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