<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$value = $_POST['changeValue'];

$start=0;
$limit = 30;
	if(isset($_GET['page']))
	{
	$page = $_GET['page'];
	$start = ($page-1)*$limit;
	}

	$url1 = "https://6df56f55f10e567550a2b39d6489d743@secure.homestaymanager.com/api/v1/partner/homestays?country_code=".$value."";
	$result_get = file_get_contents($url1);
    $get_all_data = json_decode($result_get, true);
    $get_allhome = $get_all_data['data'];
		$html = "";
		
		if(!empty($get_allhome)) {
	    foreach ($get_allhome as $homeData)
	    {
	    	foreach ($homeData['pictures'] as $picture) { 
			        	$pic = $picture['small_url'];
			        break;
			        }
	    	$html .= "<div class='home_list'>
					<div class='home_image'>
					   	<img src='".$pic."'>
			        <div class='profhome_pic'>
						<img src='".$homeData['profile_picture']."'>
					</div>
					</div>
					<div class='home_data'>
						<h2><a href='".$homeData['url']."' target='_blank'>".$homeData['title']."</a></h2>
						<div class='home_city'><h4 class='home_nme'>".$homeData['city']."</h4></div>
						<p>".$homeData['description']."</p>
					</div>
					<div class='home_price'>
						<li>
							FROM <span>$".$homeData['minimum_price_per_night']."</span> PER NIGHT
						</li>
					</div>
					<li>
						<a href='".$homeData['url']."' class='homeLink' target='_blank'>Checkout</a>
					</li>
				</div>";
    	}
    	} else {
    		echo "<h1 class='record_not_found'>Homestay not found.</h1>";
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