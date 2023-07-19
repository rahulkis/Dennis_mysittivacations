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
		<input type="hidden" id="gondesti" value="<?php echo $value; ?>">
	<?php

		$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".$cyhy."&query=theater&division=".$cysp."&locale=en_US";
		
		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
		$get_deals = $get_all_data['deals'];
		$html = "";
		
		if(count($get_deals) > 0) {
	    foreach ($get_deals as $homeData)
	    {
	    	
	    	$html .= "<div class='home_list'>
					<div class='home_image'>
					   	<img src='".$homeData['grid4ImageUrl']."' width='250' height='200'>
			        </div>
					<div class='home_data'>
						<h2><a href='".$homeData['dealUrl']."' target='_blank'>".$homeData['merchant']['name']."</a></h2>
						<div class='home_city'>	
							<span>".$homeData['announcementTitle']."</span><br>
							<h3>".$homeData['division']['name']."</h3><br>
							<p><label>Key Highlights: </label></br>
							".$homeData['highlightsHtml']."
							</p>
							<p>".$homeData['title']."</p>
						</div>

					</div>
					<div class='home_price'>
						<li>
							<a href='".$homeData['dealUrl']."' class='homeLink' target='_blank'>Get Deal</a>
						</li>
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

<style type="text/css">
	.innerCurrentCity1 {  margin-top: 160px;  text-align: center;  width: 75%;}
</style>