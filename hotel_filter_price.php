<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$price = $_POST['range'];
$newP = explode(';', $price);
$arr1 = $newP[0];
$arr2 = $newP[1];

// $value = $_POST['changeValue'];
// $addvalue = $value + 1;

$start=0;
$limit = 30;
	if(isset($_GET['page']))
	{
	$page = $_GET['page'];
	$start = ($page-1)*$limit;
	}

		$file = "https://mysittidev.com/cj/result.xml";

		$xml = simplexml_load_file($file) or die("ERROR: Cannot create SimpleXML object");
		$filter = $xml->xpath('//Deal[Price >= '.$arr1.' and Price < '.$arr2.']');
		

	    foreach ($filter as $key => $deal) {
	    	// echo "<pre>";
	    	
	    	//$rows = mysql_num_rows(mysql_query("SELECT COUNT(*) FROM hotel_data WHERE price BETWEEN ".$arr1." and ".$arr2.""));
	    	if(!empty($deal->Price))
	    	{
	    		$html .= "<div class='hotel_list'>
						<li><img src='".$deal->Image."'></li>
						<div class='hotel_data'>
							<h2><a href='".$deal->Link."' target='_blank'>".$deal->Hotel_Name."</a></h2>
							<h4 class='city_nme'>".$deal->Destination_Name."</h4>
							<div class='evnt_nme'>
								<span class='event_heading'>".$deal->Star_Rating."</span>";
								if($deal['Star_Rating'] >= 4) { echo "<h3 class='top_rated'>Top Rated</h3>"; }
							$html .= "</div>
							<div class='evnt_nme'>
								<span class='event_heading'>Address: </span>
								<h3 class='sports_name'>".$deal->Destination_Name.", ".$deal->State_Name.", ". $deal->Country_Name."</h3>
							</div>
							<div class='evnt_nme'>
								<h3 class='offer_deal'>".$deal->Offer_Name."</h3>
							</div>
						</div>
						<div class='hotel_check'>
							<li>
								<a href='#'>www.hotels.com</a>
								</br>
								<span>$".$deal->Price."</span>
							</li>
							<li><a href='".$deal->Link."' class='hotelLink' target='_blank'>Select Hotel</a></li>
						</div>
					</div>";
			} else {
				echo "<h1 class='record_not_found'>Hotels not found.</h1>";
			}
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