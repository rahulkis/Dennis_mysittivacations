<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "http://".$_SERVER['HTTP_HOST']."/";

?>

<?php

$destination = $_POST['formatted'];
$checkinnn = $_POST['checkin'];
$checkouttt = $_POST['checkout'];
$guest = $_POST['guest'];

$datecin=date_create($checkinnn);
$checkin = date_format($datecin,"Y-m-d");

$dateout=date_create($checkouttt);
$checkout = date_format($dateout,"Y-m-d");

$arr6 = end(split(',',$destination));
$arr2 = trim($arr6," ");

if($arr2 == 'USA')
{
	$con = 'United States';
} elseif ($arr2 == 'UK') {
	$con = 'United Kingdom';
} else {
	$con = $arr2;
}
$start=0;
$limit = 30;
	if(isset($_GET['page']))
	{
	$page = $_GET['page'];
	$start = ($page-1)*$limit;
	}


		
	$city_name_query = @mysql_query("SELECT * FROM country WHERE name = '$con'");
	$get_city_name = mysql_fetch_assoc($city_name_query);
	$iso = $get_city_name['iso_code_2'];

		// $url1 = "https://6df56f55f10e567550a2b39d6489d743@secure.homestaymanager.com/api/v1/partner/homestays?country_code=".$iso."&guests=".$guest."&arrival_date=".$checkin."&departure_date=".$checkout."";


		    $prepAddr = str_replace(' ','+',$destination);
			$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
			$output= json_decode($geocode);
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;		

	
		 $url1 = "https://6df56f55f10e567550a2b39d6489d743@secure.homestaymanager.com/api/v1/partner/homestays?latitude=".$latitude."&longitude=".$longitude."&location=".rawurlencode($destination)."&check_in=".$checkin."&check_out=".$checkout."&guests=".$guest."&order=best_match&country_code=US&radius=50000";


	  		$result_get = file_get_contents($url1);
	        $get_all_data = json_decode($result_get, true);
	        
	        $get_allhome = $get_all_data['data'];
 
		?>

	
			<?php
				
	    	foreach($get_allhome as $homeData) {

		    	$html .= "<div class='home_list'>
					<div class='home_image'>";
					
					foreach ($homeData['pictures'] as $picture) {
			        $html .= "<img src='".$picture['small_url']."'>";

			        break;
			        }
				    $html .= "<div class='profhome_pic'>
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
    			?>
    	


<?php
    	echo $html;
    	$total=ceil($rows/$limit);
    	if($rows > 10)
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