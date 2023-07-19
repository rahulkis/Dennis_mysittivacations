<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

// if( isset($_POST['formatted']) )
// {
	$value = $_POST['formatted'];
	$exp = explode(",", $value);
	$cy = $exp[0];
	$cyhy = str_replace(' ', '-', strtolower($exp[0]));
	$cysp = str_replace(' ', '%20', strtolower($exp[0]));
	$tn = str_replace(' ', '', $exp[1]);
	

	$valueoutdoor = $_POST['formattedoutdoor'];
	$exp2 = explode(",", $valueoutdoor);
	$cy2 = $exp2[0];
	$cyhy2 = str_replace(' ', '-', strtolower($exp2[0]));
	$cysp2 = str_replace(' ', '%20', strtolower($exp2[0]));
	$tn2 = str_replace(' ', '', $exp2[1]);


// } 
// elseif( isset($_POST['changeValue']) )
// {
// 	$value = $_POST['changeValue'];
// }
$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$dropdown_city = $get_city_name['city_name'];
$state_name_query = @mysql_query("select code,country_id,zone_id FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
$get_state_name = mysql_fetch_assoc($state_name_query);
$dropdown_state = $get_state_name['code'];

$start=0;
$limit = 30;
	if(isset($_GET['page']))
	{
	$page = $_GET['page'];
	$start = ($page-1)*$limit;
	}
	?>
		<input type="hidden" id="gondesti" value="<?php echo $value; ?>">
	<?php

		if(!empty($value)) {
			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".$cyhy."&query=family+activities&division=".$cysp."&locale=en_US";
		} else {
			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".$cyhy2."&query=sports+outdoors&division=".$cysp2."&locale=en_US";
		}

		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
		$get_deals = $get_all_data['deals'];
		$html = "";
		
		if(count($get_deals) > 0) {
	    foreach ($get_deals as $homeData)
	    {
	    	 $price = $homeData['options'][0]['price']['formattedAmount'];
		    $value = $homeData['options'][0]['value']['formattedAmount'];
		    $discountPercent = $homeData['options'][0]['discountPercent'];
		    $discount = $homeData['options'][0]['discount']['formattedAmount'];
		    $endAt = 	$homeData['options'][0]['endAt'];
	        $endDate = date('m/d/Y', strtotime($endAt));
	        $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
	        $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
	        $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
	        $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
            
           
	    	$html .= "<div class='home_list newhotels-deals'>
					<div class='home_image newhotels-deals'>
					  <a href='".$homeData['dealUrl']."' target='_blank' class='homeLink1'>
					   	<img src='".$homeData['grid4ImageUrl']."' width='250' height='200'>
					   	</a>

					 <h2 class='deals-name-new'><a href='".$homeData['dealUrl']."' target='_blank'>".$homeData['merchant']['name']."</a></h2>

					<h1 class='addres1 p8'>".$streetAddress1."</h1>
					<h1 class='addres2 p9'>".$streetAddress2."</h1>
					<h1 class='cityNamelanding p10'>".$cityName.', '.$postalCode."</h1>

			        </div>

					<div class='home_data newHotelsdeals'>
						<h2 class='discountPercent p1'>".$discountPercent. '% Off'."</h2><span class='announcementTitledeasl p2' style='color: black;'>".$homeData['announcementTitle']."</span><br>
                       <div class='alldealset p3'>
						<h1 class='pricelanding-hotel p4'>".$price." <span class='valuelanding-hotel p5'>".$value."</span></h1>
						<h1 class='saleend-hotel p6'>".'Sales Ends: ' .$endDate."</h1>
                       </div>

						<div class='home_city'>
						<span class='discountNight p7'>".'Save '.$discount."</span>
							
							".$homeData['highlightsHtml']."
							<a href='".$homeData['dealUrl']."' target='_blank' class='read_more'>
					   	      Read More
					   		</a>
							</p>
							
						</div>
					</div>
				</div>";
    	}
    	} else {
    		echo "<h1 class='record_not_found'>Record not found.</h1>";
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