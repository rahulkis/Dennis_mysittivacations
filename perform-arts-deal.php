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
	if($cy == "Washington") {
		$cyhy = "washington-dc";
		$cysp = "washington%20dc";
	} else {
		$cyhy = str_replace(' ', '-', strtolower($exp[0]));
		$cysp = str_replace(' ', '%20', strtolower($exp[0]));
		$tn = str_replace(' ', '', $exp[1]);
	}
	
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
		
	<?php

	// $tokenURL = "http://widgetapi2.isango.com/token";
	// $ch = curl_init();
	// curl_setopt($ch, CURLOPT_URL, $tokenURL);
	// curl_setopt($ch, CURLOPT_POST, 1);
	// curl_setopt($ch, CURLOPT_POSTFIELDS,
	//             "grant_type=password&username=mysitti&password=Sitti@1My");
	// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


	// // receive server response ...
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// $server_output = curl_exec ($ch);

	// curl_close ($ch);
	// $curl_jason = json_decode($server_output, true);

	// $TOKEN = $curl_jason['access_token'];

	// 	$urlgo = "http://widgetapi2.isango.com/TicketFilterList/v2?language=en&currency=usd&destination=6195&order=1&exclude=1,2&partner=isa&PageNumber=1&PageSize=35&direction=0";

		
	// 	$ch = curl_init($urlgo);

	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// 	curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');

	// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	// 	    'Content-Type: application/json',
	// 	    'Authorization: Bearer ' . $TOKEN
	// 	    ));

	// 	$data = curl_exec($ch);

	// 	$info = curl_getinfo($ch);

	// 	curl_close($ch);
	// 	$get_all_data = json_decode($data, true);

		//$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_201236_212556_0&division_id=".$cyhy."&offset=0&limit=20";
		$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".$cyhy."&query=Things+to+do&division=".$cysp."&locale=en_US";

		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
		$get_deals = $get_all_data['deals'];
	
		
		
	    foreach ($get_deals as $homeData)
	    {
	    	
	    	$html .= "<li class='col-sm-3 col-md-3 col-xs-12' style='float: left; list-style: none; position: relative; width: 260px;'>
						<div class='m_1'>
							<a href='".$homeData['dealUrl']."' target='_blank'>
								<img src='".$homeData['grid4ImageUrl']."'>
							</a>
						</div>
						<h3 class='up'>	
							<a href='".$homeData['dealUrl']."' target='_blank'>";
							$tourname = $homeData['merchant']['name']; 
							$out = strlen($tourname) > 44 ? substr($tourname,0,44)."..." : $tourname;
							$html .= "".$out."</a>
						</h3>	
						<dd class='pri_ce'>".$homeData['division']['name']."</dd>
					</li>";
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