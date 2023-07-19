<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$price = $_POST['range'];
$newP = explode(';', $price);
$arr1 = $newP[0];
$arr2 = $newP[1];

$start=0;
$limit = 30;
	if(isset($_GET['page']))
	{
	$page = $_GET['page'];
	$start = ($page-1)*$limit;
	}

	$sql = "SELECT programname, name, keywords, price, city, buyurl, imageurl FROM hotel_data WHERE price BETWEEN ".$arr1." and ".$arr2." LIMIT $start, $limit";
		$result = mysql_query($sql);
		$html = "";
		// $html .= "<div class='search_filtering'>
		// 	<form action='hotel_all.php' method='request'>
		// 		<input name='hotel_filter' class='hotel_fil' value='' placeholder='Enter your destination' required='' type='text'>
		// 		<input name='enter_buton' class='filtering_button' type='submit'>
		// 	</form>
		// 	</div>";

	    while($row = mysql_fetch_assoc($result)) 
	    {
	    	$rows = mysql_num_rows(mysql_query("SELECT COUNT(*) FROM hotel_data WHERE price BETWEEN ".$arr1." and ".$arr2.""));
	    	$html .= "<div class='hotel_list'>
						<li><img src='".$row['imageurl']."'></li>
						<div class='hotel_data'>
							<h2><a href='".$row['buyurl']."' target='_blank'>".$row['name']."</a></h2>
							<h4 class='city_nme'>".$row['city']."</h4>
							<p>".$row['keywords']."</p>
						</div>
						<div class='hotel_price'>
							<li><a href='".$row['buyurl']."'>".$row['programname']."</a><br><span>$".$row['price']."</span></li>
						</div>
						<div class='hotel_check'>
							<li>
								<a href='#'>".$row['programname']."</a>
								<br>
								<span>$".$row['price']."</span>
							</li>
							<li><a href='".$row['buyurl']."' class='hotelLink' target='_blank'>Select Hotel</a></li>

						</div>
					</div>";
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