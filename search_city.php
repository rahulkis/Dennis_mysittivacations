<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

// if(!isset($_SESSION['user_id']))
// {
// 	$Obj->Redirect('index.php');
// }

$titleofpage="City Events"; 

if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php'); // login

}

else

{

	include('Header.php');	// not login

}
?>
<style type="text/css">
.custom_slide .live_stream_new {
 bottom: 24px;
}
.custom_slide .live_stream_new a {
 background-color: #000;
}
.custom_slide .live_stream_new a:hover {
 background-color: #fecd07;
 color: #000;
}
.custom_slide .live_stream_new a span.stats_icon {
 margin: 0;
}
.common_box
{
	padding-top: 0px;
}



 .trip-expert li{
        float: left;
		list-style-type: none;
		width: 25%;
        }	
            	
		.trip-expert img {
			width: 100%;
			float:left;
		}
		.trip-expert h2{
			 float: left;
    		margin: 0;
		}
		.trip-expert h2 a {
			color: #0355a9;
			font-family: "Whitney SSm A","Whitney SSm B",Arial,sans-serif;
			font-size: 20px;
			font-weight: 600;
			letter-spacing: -1px;
			}
		.trip-expert h2 {
			float: left;
			margin: -5px 0 0 0px;
		}		
	.trip-expert-data {
			float: left;
			margin-left: 20px;
			width: 65%;
		}
		.trip-expert-data p{
		color: #999;
		font-size: 14px;
		margin: 10px 0;
		min-height: 50px;
		float:left;
	}
	
.trip-expert {
    border-bottom: 1px solid #eee;
    float: left;
    padding: 15px 0;
	position:relative;
	width: 100%;
	}
		span.score {
   background-color: #009b45;
    border-radius: 100%;
    color: #fff;
    cursor: default;
    display: block;
    font-family: "Whitney SSm A","Whitney SSm B",Arial,sans-serif;
    font-size: 14px;
    font-weight: 600;
    height: 35px;
    line-height: 2.5;
    position: absolute;
    right: 15px;
    text-align: center;
    top: 10px;
    width: 35px;
	}
	.trip-expert:hover {
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.15);
}
.review-icon > li {
    margin: 4px;
    width: auto;
}
.review-icon img {
    width: 20px;
}
.trip-detail h2 {
    color: #131313;
    font-family: "Sentinel SSm A","Sentinel SSm B",Arial,sans-serif;
    font-size: 38px;
    font-weight: 600;
    letter-spacing: -3px;
    margin: 5px 0 10px;
}
.trip-detail {
    float: left;
    width: 100%;
}	
	span.score-detail {
   background-color: #009b45;
    border-radius: 100%;
    color: #fff;
    cursor: default;
    display: block;
    font-family: "Whitney SSm A","Whitney SSm B",Arial,sans-serif;
    font-size: 14px;
    font-weight: 600;
    height: 35px;
    line-height: 2.5;
   margin-bottom: 15px;    
    text-align: center;
    float: right;
       width: 35px;
	}
	.trip-detail address h5 {
    color: #131313;
    font-family: "Whitney SSm A","Whitney SSm B",Arial,sans-serif;
    font-size: 14px;
    font-weight: 600;
    margin: 0;
}
.trip-detail address p {
    color: #434343;
    font-family: "Whitney SSm A","Whitney SSm B",Arial,sans-serif;
    font-size: 12px;
    margin: 7px 0 5px;
    font-style: normal;
    position: relative;
}
.city_nme {
	color: #777;
	clear: both;
}
.address > a {
    color: #666;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
}

.trip-detail .no-bullet {
    color: blue;
    font-style: normal;
    text-decoration: none;
}
.trip-detail address em {
    color: #434343;
    font-size: 15px;
    font-style: normal;
}
.detial-trip-list li img {
    float: left;
    width: 60px;
}
.detial-trip-list li{
	  border-top: 1px solid #ccc;
    list-style-type: none;
    margin: 20px 0;
    padding: 20px 0;
}
.detial-trip-list li h3 {
    float: left;
    font-size: 18px;
    font-style: normal;
    margin: -5px 10px;
}
.detial-trip-list li p {
    color: #777;
    float: left;
    font-size: 14px;
    font-style: normal;
    margin: 0 0 0 10px;
    width: 85%;
}
.clearfix span {
    color: black;
    font-size: 15px;
    font-weight: bold;
}
.clearfix img {
    float: left;
    margin-top: 2px;
    padding-right: 8px;
}
.check_class {
    margin: 10px auto;
    padding: 5px;
    width: 50%;
    float: left;
}
.hotel_button {
	margin: 0 auto !important;
	display: block !important;
}
.pagination span.active {
	background: #1c50b3 none repeat scroll 0 0;
	color: #fff !important;
}
</style>
<div class="v2_content_wrapper">
<div class="v2_content_inner_topslider spacer1">
		<div style="display:none;" class="topSilder">
  			<div class="fullblack">
				<div class="img_slider_btm">
	  				<div class=" ">			
	  				</div>
				</div>
  			</div>
		</div><!-- END topSilder -->
	<div class="v2_content_inner2">
	<?php
		include('sidebarSearch.php');
	?>

		<article class="forum_content v2_contentbar newSectionEvents">
		<div class="search_filtering">
			<form method="post" action="search_city.php">
				<input type="text" required="" placeholder="Enter your destination" value="" id="get_destination" name="search_filter">
				<input type="submit" class="filtering_button" name="search_submit">
			</form>	
		</div>
		<div class="NewSerachFilter">
   			<?php
  				if(isset($_GET['restaurant']) || isset($_GET['amenitess']) || isset($_GET['amenites']) || isset($_GET['S-restaurant']) || isset($_GET['details']) || isset($_GET['Rbudget']) || isset($_GET['Rmidrange']) || isset($_GET['Rhighrange'])) {
  					$get_Id = (int) $_GET['amenites'];
  					if($get_Id >= 33) {
  						echo "<h2>Attractions</h2>";
  					} else {
  						echo "<h2>Restaurants</h2>";
  					}
  				} elseif (isset($_GET['attraction']) || isset($_GET['S-attraction'])) {
  					echo "<h2>Attractions</h2>";
  				} elseif (isset($_GET['amenites'])) {
  					echo "<h2>Attractions</h2>";
  				} elseif (isset($_GET['cityhotel']) || isset($_POST['search_room']) || isset($_POST['search_submit']) || isset($_GET['S-hotel']) || isset($_POST['search_room2']) || isset($_GET['Hbudget']) || isset($_GET['Hmidrange']) || isset($_GET['Hluxury'])) {
  					echo "<h2>Hotels</h2>";
  				} else { ?>
  					<h2><?php if($fetchEventCategory['catname']){ echo $fetchEventCategory['catname']; } else { echo "Nightlife"; } ?> Events</h2>
  				<?php	} ?>
  		</div>
  			
  			<div class="clear"></div>
  			
  			
			<style type="text/css">
				
				#an-nyw_1-location {
					width: 105px !important;
				}
				.an-nyw-go {
					width: 50px !important;
				}
				#title {
					display: block;
				}
			</style>
			<div class="clear"></div>

	<?php
			//  dynamic city code

		$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
		$get_city_name = mysql_fetch_assoc($city_name_query);
		$dropdown_city = $get_city_name['city_name'];
		$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
		$get_state_name = mysql_fetch_assoc($state_name_query);
		$dropdown_state = $get_state_name['code'];

		$LATITUDE = $get_city_name['lat'];
		$LONGITUDE = $get_city_name['lng'];
		$CITYID = $get_city_name['city_id'];
		$_SESSION['city'] = $get_city_name['city_id'];
		$_SESSION['state'] = $get_city_name['state_id'];
		$_SESSION['country'] = $get_state_name['country_id'];
		$_SESSION['state_name'] = $get_state_name['name'];

		// echo $_SESSION['city'];
		// echo $_SESSION['state_name'];


			//Searching data
	
	if(isset($_POST['search_submit']))
	{
		$text = $_POST['search_filter'];
		
		$encoded = urlencode($text);

		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$encoded."&key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM";

		// $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&sensor=false";
		$details=file_get_contents($url);
		$result = json_decode($details,true);

		$lat=$result['results'][0]['geometry']['location']['lat'];
		$lng=$result['results'][0]['geometry']['location']['lng'];

		$urls2 ="https://api.tripexpert.com/v1/destinations?order_by=distance&latitude=".$lat."&longitude=".$lng."&limit=10&api_key=5d4941cd0c3c1b9571453e237705dbfb";
		$result_tripn2 = file_get_contents($urls2);
		
		$get_all_data2 = json_decode($result_tripn2, true);
		$destinations2 = $get_all_data2['response']['venues'];
		$main_id = $destinations2[0]['id'];
		// echo "<pre>";
		// print_r($destinations);
		//  echo "</pre>";
		$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');	
	 	if($page!='1'){
			$offset_page = ($page-1)*15;
	 	}else{
	 		$offset_page =0;
	 	}
		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$main_id."&venue_type_id=1&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
		$result_tripn = file_get_contents($urls);
		
		$get_all_data = json_decode($result_tripn, true);
		$destinations = $get_all_data['response']['venues'];
		$rows = $get_all_data['response']['total_records'];
		 
		echo "<div class='couman_class'>"; ?>
        <ul class="price clearfix filter-inputs">
			<li data-id="4" class="">
				<a href="search_city.php?S-hotel=<?php echo $encoded; ?>">Hotels</a>
			</li>
			<li data-id="5" class="">
				<a href="search_city.php?S-restaurant=<?php echo $encoded; ?>">Restaurants</a>
			</li>
			<li data-id="6" class="">
				<a href="search_city.php?S-attraction=<?php echo $encoded; ?>">Attractions</a>
			</li>
		</ul>
		<?php
        foreach ($destinations as $resto_venue) 
          {
          	echo "<div class='trip-expert'>"; 
          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
          		echo "<div class='trip-expert-data'>"; 
          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
          			echo "<h2> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
          			echo "<h4 class='city_nme'>".$text."</h4>";
          			$urlR ="https://api.tripexpert.com/v1/venues/".$resto_venue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
			        $result_tripnR = file_get_contents($urlR);
			        $get_all_dataR = json_decode($result_tripnR, true);
			        $firstReview = $get_all_dataR['response']['venue'];
			        foreach ($firstReview as $rvalue) {
			        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
			        }
          			echo "<div class='review-icon'>
							<li><img src='trip/line.png'></li>
							<li><img src='trip/6.png'></li>
							<li><img src='trip/14.png'></li>
							<li><img src='trip/21.png'></li>
							<li><img src='trip/53.png'></li>
						</div>";
          		echo "</div>";
          	echo "</div>";
          }
          /*$limit = 15;
			$total=ceil($rows/$limit);
			if($rows > 15) {
				echo "<div class='center_pagination'>";
				echo "<ul class='page'>";
				echo "<li>";
				if($page>1)
				{
					echo "<a href='?page=".($page-1)."' class='previous_b'><img src='../images/prev_pegi.png'/></a>";
				}
				echo "</li>";
				echo "<li class='next_li'>";
				if($page!=$total)
				{
					echo "<a href='?page=".($page+1)."' class='next_b'><img src='../images/next_pegi.png'/></a>";
				}
				echo "</li>";
				for($i=1;$i<=$total;$i++)
				{
					echo "<li><a href='?page=".$i."'>".$i."</a></li>"; 
				}
				echo "</ul>";
				echo "</div>";
			}*/
        echo "</div>";
	} 
	
	if(isset($_GET['S-hotel']))
	{
		$text = trim($_GET['S-hotel']);
		$encoded = urlencode($text);

		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$encoded."&key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM";

		// $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&sensor=false";
		$details=file_get_contents($url);
		$result = json_decode($details,true);

		$lat=$result['results'][0]['geometry']['location']['lat'];
		$lng=$result['results'][0]['geometry']['location']['lng'];

		$urls2 ="https://api.tripexpert.com/v1/destinations?order_by=distance&latitude=".$lat."&longitude=".$lng."&limit=10&api_key=5d4941cd0c3c1b9571453e237705dbfb";
		$result_tripn2 = file_get_contents($urls2);
		
		$get_all_data2 = json_decode($result_tripn2, true);
		$destinations2 = $get_all_data2['response']['venues'];
		$main_id = $destinations2[0]['id'];
		$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');	
	 	if($page!='1'){
			$offset_page = ($page-1)*15;
	 	}else{
	 		$offset_page =0;
	 	}

		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$main_id."&venue_type_id=1&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
		$result_tripn = file_get_contents($urls);
		
		$get_all_data = json_decode($result_tripn, true);
		$destinations = $get_all_data['response']['venues'];
		$rows = $get_all_data['response']['total_records'];
		 
		echo "<div class='couman_class'>"; ?>
        <ul class="price clearfix filter-inputs">
			<li data-id="4" class="">
				<a href="searchEvents.php?S-hotel=<?php echo $text; ?>" class="<?php echo ($_GET['S-hotel'] == $text || $_POST['search_submit']) ? 'active_range' : ''?>">Hotels</a>
			</li>
			<li data-id="5" class="">
				<a href="search_city.php?S-restaurant=<?php echo $text; ?>">Restaurants</a>
			</li>
			<li data-id="6" class="">
				<a href="search_city.php?S-attraction=<?php echo $text; ?>">Attractions</a>
			</li>
		</ul>
		<?php
        foreach ($destinations as $resto_venue) 
          {
          	echo "<div class='trip-expert'>"; 
          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
          		echo "<div class='trip-expert-data'>"; 
          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
          			echo "<h2> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
          			echo "<h4 class='city_nme'>".$text."</h4>";
          			$urlR ="https://api.tripexpert.com/v1/venues/".$resto_venue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
			        $result_tripnR = file_get_contents($urlR);
			        $get_all_dataR = json_decode($result_tripnR, true);
			        $firstReview = $get_all_dataR['response']['venue'];
			        foreach ($firstReview as $rvalue) {
			        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
			        }
          			echo "<div class='review-icon'>
							<li><img src='trip/line.png'></li>
							<li><img src='trip/6.png'></li>
							<li><img src='trip/14.png'></li>
							<li><img src='trip/21.png'></li>
							<li><img src='trip/53.png'></li>
						</div>";
          		echo "</div>";
          	echo "</div>";
          }
          $limit = 15;
			$total=ceil($rows/$limit);
			if($rows > 15) {
				echo '<div class="pagination_new">';
					if($total > 1)
					{
						echo "<a href='?S-hotel=".$encoded."&page=1'><span title='First'>&laquo;</span></a>";
						if ($page <= 1)
							echo "<span>Previous</span>";
						else            
							echo "<a href='?S-hotel=".$encoded."&page=".($page-1)."'><span>Previous</span></a>";
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
									<a href='?S-hotel=<?php echo $encoded; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
							<?php	}
							}
							$z++;
						}
						if($page == $total) 
							echo "<span>Next</span>";
						else           
							echo "<a href='?S-hotel=".$encoded."&page=".($page+1)."'><span>Next</span></a>";

						echo "<a href='?S-hotel=".$encoded."&page=".$total."'><span title='Last'>&raquo;</span></a>";
					}
				echo "</div>";
			}
        echo "</div>";
	}

	if(isset($_GET['S-restaurant']))
	{
		$text = trim($_GET['S-restaurant']);
		$encoded = urlencode($text);

		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$encoded."&key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM";

		// $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&sensor=false";
		$details=file_get_contents($url);
		$result = json_decode($details,true);

		$lat=$result['results'][0]['geometry']['location']['lat'];
		$lng=$result['results'][0]['geometry']['location']['lng'];

		$urls2 ="https://api.tripexpert.com/v1/destinations?order_by=distance&latitude=".$lat."&longitude=".$lng."&limit=10&api_key=5d4941cd0c3c1b9571453e237705dbfb";
		$result_tripn2 = file_get_contents($urls2);
		
		$get_all_data2 = json_decode($result_tripn2, true);
		$destinations2 = $get_all_data2['response']['venues'];
		$main_id = $destinations2[0]['id'];
		$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');	
	 	if($page!='1'){
			$offset_page = ($page-1)*15;
	 	}else{
	 		$offset_page =0;
	 	}

		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$main_id."&venue_type_id=2&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
		$result_tripn = file_get_contents($urls);
		
		$get_all_data = json_decode($result_tripn, true);
		$destinations = $get_all_data['response']['venues'];
		$rows = $get_all_data['response']['total_records'];
		 
		echo "<div class='couman_class'>"; ?>
        <ul class="price clearfix filter-inputs">
			<li data-id="4" class="">
				<a href="search_city.php?S-hotel=<?php echo $text; ?>">Hotels</a>
			</li>
			<li data-id="5" class="">
				<a href="search_city.php?S-restaurant=<?php echo $text; ?>" class="<?php echo ($_GET['S-restaurant'] == $text) ? 'active_range' : ''?>">Restaurants</a>
			</li>
			<li data-id="6" class="">
				<a href="search_city.php?S-attraction=<?php echo $text; ?>">Attractions</a>
			</li>
		</ul>
		<?php
        foreach ($destinations as $resto_venue) 
          {
          	echo "<div class='trip-expert'>"; 
          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
          		echo "<div class='trip-expert-data'>"; 
          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
          			echo "<h2> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
          			echo "<h4 class='city_nme'>".$text."</h4>";
          			$urlR ="https://api.tripexpert.com/v1/venues/".$resto_venue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
			        $result_tripnR = file_get_contents($urlR);
			        $get_all_dataR = json_decode($result_tripnR, true);
			        $firstReview = $get_all_dataR['response']['venue'];
			        foreach ($firstReview as $rvalue) {
			        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
			        }
          			echo "<div class='review-icon'>
							<li><img src='trip/line.png'></li>
							<li><img src='trip/6.png'></li>
							<li><img src='trip/14.png'></li>
							<li><img src='trip/21.png'></li>
							<li><img src='trip/53.png'></li>
						</div>";
          		echo "</div>";
          	echo "</div>";
          }
          $limit = 15;
			$total=ceil($rows/$limit);
			if($rows > 15) {
				echo '<div class="pagination_new">';
					if($total > 1)
					{
						echo "<a href='?S-restaurant=".$encoded."&page=1'><span title='First'>&laquo;</span></a>";
						if ($page <= 1)
							echo "<span>Previous</span>";
						else            
							echo "<a href='?S-restaurant=".$encoded."&page=".($page-1)."'><span>Previous</span></a>";
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
									<a href='?S-restaurant=<?php echo $encoded; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
							<?php	}
							}
							$z++;
						}
						if($page == $total) 
							echo "<span>Next</span>";
						else           
							echo "<a href='?S-restaurant=".$encoded."&page=".($page+1)."'><span>Next</span></a>";

						echo "<a href='?S-restaurant=".$encoded."&page=".$total."'><span title='Last'>&raquo;</span></a>";
					}
				echo "</div>";
			}
        echo "</div>";
	}

	if(isset($_GET['S-attraction']))
	{
		$text = trim($_GET['S-attraction']);
		$encoded = urlencode($text);

		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$encoded."&key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM";

		// $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&sensor=false";
		$details=file_get_contents($url);
		$result = json_decode($details,true);

		$lat=$result['results'][0]['geometry']['location']['lat'];
		$lng=$result['results'][0]['geometry']['location']['lng'];

		$urls2 ="https://api.tripexpert.com/v1/destinations?order_by=distance&latitude=".$lat."&longitude=".$lng."&limit=10&api_key=5d4941cd0c3c1b9571453e237705dbfb";
		$result_tripn2 = file_get_contents($urls2);
		
		$get_all_data2 = json_decode($result_tripn2, true);
		$destinations2 = $get_all_data2['response']['venues'];
		$main_id = $destinations2[0]['id'];
		$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');	
	 	if($page!='1'){
			$offset_page = ($page-1)*15;
	 	}else{
	 		$offset_page =0;
	 	}

		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$main_id."&venue_type_id=3&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
		$result_tripn = file_get_contents($urls);
		
		$get_all_data = json_decode($result_tripn, true);
		$destinations = $get_all_data['response']['venues'];
		$rows = $get_all_data['response']['total_records'];
		 
		echo "<div class='couman_class'>"; ?>
        <ul class="price clearfix filter-inputs">
			<li data-id="4" class="">
				<a href="search_city.php?S-hotel=<?php echo $text; ?>">Hotels</a>
			</li>
			<li data-id="5" class="">
				<a href="search_city.php?S-restaurant=<?php echo $text; ?>">Restaurants</a>
			</li>
			<li data-id="6" class="">
				<a href="search_city.php?S-attraction=<?php echo $text; ?>" class="<?php echo ($_GET['S-attraction'] == $text) ? 'active_range' : ''?>">Attractions</a>
			</li>
		</ul>
		<?php
        foreach ($destinations as $resto_venue) 
          {
          	echo "<div class='trip-expert'>"; 
          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
          		echo "<div class='trip-expert-data'>"; 
          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
          			echo "<h2> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
          			echo "<h4 class='city_nme'>".$text."</h4>";
          			$urlR ="https://api.tripexpert.com/v1/venues/".$resto_venue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
			        $result_tripnR = file_get_contents($urlR);
			        $get_all_dataR = json_decode($result_tripnR, true);
			        $firstReview = $get_all_dataR['response']['venue'];
			        foreach ($firstReview as $rvalue) {
			        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
			        }
          			echo "<div class='review-icon'>
							<li><img src='trip/line.png'></li>
							<li><img src='trip/6.png'></li>
							<li><img src='trip/14.png'></li>
							<li><img src='trip/21.png'></li>
							<li><img src='trip/53.png'></li>
						</div>";
          		echo "</div>";
          	echo "</div>";
          }
          $limit = 15;
			$total=ceil($rows/$limit);
			if($rows > 15) {
				echo '<div class="pagination_new">';
					if($total > 1)
					{
						echo "<a href='?S-attraction=".$encoded."&page=1'><span title='First'>&laquo;</span></a>";
						if ($page <= 1)
							echo "<span>Previous</span>";
						else            
							echo "<a href='?S-attraction=".$encoded."&page=".($page-1)."'><span>Previous</span></a>";
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
									<a href='?S-attraction=<?php echo $encoded; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
							<?php	}
							}
							$z++;
						}
						if($page == $total) 
							echo "<span>Next</span>";
						else           
							echo "<a href='?S-attraction=".$encoded."&page=".($page+1)."'><span>Next</span></a>";

						echo "<a href='?S-attraction=".$encoded."&page=".$total."'><span title='Last'>&raquo;</span></a>";
					}
				echo "</div>";
				}
        echo "</div>";
	}

//  Sidebar menu data
  if (isset($_GET['restaurant'])) 
   {
   	 	$textc = trim($_GET['restaurant']);
   		$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
		$get_C_id = mysql_fetch_assoc($get_C);
     	$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');	
     	if($page!='1'){
			$offset_page = ($page-1)*15;
     	}else{
     		$offset_page =0;
     	}
	    $urls ="https://api.tripexpert.com/v1/venues?destination_id=".$get_C_id['destination_id']."&venue_type_id=2&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
        $result_tripn = file_get_contents($urls);
        $get_all_data = json_decode($result_tripn, true);
        $resto_venues = $get_all_data['response']['venues'];
        $rows = $get_all_data['response']['total_records'];

        echo "<div class='couman_class'>"; ?>
        <ul class="price clearfix filter-inputs">
			<li data-id="4" class="">
				<a href="search_city.php?Rbudget=<?php echo $textc; ?>">Budget</a>
			</li>
			<li data-id="5" class="">
				<a href="search_city.php?Rmidrange=<?php echo $textc; ?>">Midrange</a>
			</li>
			<li data-id="6" class="">
				<a href="search_city.php?Rhighrange=<?php echo $textc; ?>">High-end</a>
			</li>
		</ul>
		<?php
        foreach ($resto_venues as $resto_venue) 
          {
          	echo "<div class='trip-expert'>";
          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
          		echo "<div class='trip-expert-data'>"; 
          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
          			echo "<h2> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
          			echo "<h4 class='city_nme'>".$textc."</h4>";
          			$urlR ="https://api.tripexpert.com/v1/venues/".$resto_venue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
			        $result_tripnR = file_get_contents($urlR);
			        $get_all_dataR = json_decode($result_tripnR, true);
			        $firstReview = $get_all_dataR['response']['venue'];
			        foreach ($firstReview as $rvalue) {
			        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
			        }
          			echo "<div class='review-icon'>
							<li><img src='trip/line.png'></li>
							<li><img src='trip/6.png'></li>
							<li><img src='trip/14.png'></li>
							<li><img src='trip/21.png'></li>
							<li><img src='trip/53.png'></li>
						</div>";
          		echo "</div>";
          	echo "</div>";
          }

         	$limit = 15;
			$total=ceil($rows/$limit);
			if($rows > 15) {
			echo '<div class="pagination_new">';
				if($total > 1)
				{
					
					echo '<a href="?restaurant='.$textc.'&page=1"><span title="First">&laquo;</span></a>';
					if ($page <= 1)
						echo "<span>Previous</span>";
					else            
						echo "<a href='?restaurant=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
								<a href='?restaurant=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
						<?php	}
						}
						$z++;
					}
					if($page == $total) 
						echo "<span>Next</span>";
					else           
						echo "<a href='?restaurant=".$textc."&page=".($page+1)."'><span>Next</span></a>";

					echo "<a href='?restaurant=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
				}
			echo "</div>";
		}
        echo "</div>";
    } elseif (isset($_GET['cityhotel'])) {

        $textc = trim($_GET['cityhotel']);
   		$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
		$get_C_id = mysql_fetch_assoc($get_C);
		$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');	
     	if($page!='1'){
			$offset_page = ($page-1)*15;
     	}else{
     		$offset_page =0;
     	}

	$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$get_C_id['destination_id']."&venue_type_id=1&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
    $result_tripn = file_get_contents($urls);
    $get_all_data = json_decode($result_tripn, true);
    $resto_venues = $get_all_data['response']['venues'];
    $rows = $get_all_data['response']['total_records'];

    echo "<div class='couman_class'>";
    ?>

	<ul class="price clearfix filter-inputs">
		<li data-id="4" class="">
			<a href="search_city.php?Hbudget=<?php echo $textc; ?>">Budget</a>
		</li>
		<li data-id="5" class="">
			<a href="search_city.php?Hmidrange=<?php echo $textc; ?>">Midrange</a>
		</li>
		<li data-id="6" class="">
			<a href="search_city.php?Hluxury=<?php echo $textc; ?>">Luxury</a>
		</li>
	</ul>
	<?php

    foreach ($resto_venues as $resto_venue) 
      {
      	echo "<div class='trip-expert'>"; 
      		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
      		echo "<div class='trip-expert-data'>"; 
      			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
      			echo "<h2> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
      			echo "<h4 class='city_nme'>".$textc."</h4>";
      			$urlR ="https://api.tripexpert.com/v1/venues/".$resto_venue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
		        $result_tripnR = file_get_contents($urlR);
		        $get_all_dataR = json_decode($result_tripnR, true);
		        $firstReview = $get_all_dataR['response']['venue'];
		        foreach ($firstReview as $rvalue) {
		        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
		        }
      			echo "<div class='review-icon'>
						<li><img src='trip/line.png'></li>
						<li><img src='trip/6.png'></li>
						<li><img src='trip/14.png'></li>
						<li><img src='trip/21.png'></li>
						<li><img src='trip/53.png'></li>
					</div>";
      		echo "</div>";
      	echo "</div>";
      }
      		$limit = 15;
			$total=ceil($rows/$limit);
			if($rows > 15) {
			echo '<div class="pagination_new">';
			if($total > 1)
			{
				
				echo '<a href="?cityhotel=1&page=1"><span title="First">&laquo;</span></a>';
				if ($page <= 1)
					echo "<span>Previous</span>";
				else            
					echo "<a href='?cityhotel=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
							<a href='?cityhotel=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
					<?php	}
					}
					$z++;
				}
				if($page == $total) 
					echo "<span>Next</span>";
				else           
					echo "<a href='?cityhotel=".$textc."&page=".($page+1)."'><span>Next</span></a>";

				echo "<a href='?cityhotel=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
			}
		echo "</div>";
		}	
    echo "</div>";  
    } elseif (isset($_GET['attraction'])) {
    	$textc = trim($_GET['attraction']);
   		$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
		$get_C_id = mysql_fetch_assoc($get_C);
  		$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');	
	     	if($page!='1'){
				$offset_page = ($page-1)*15;
	     	}else{
	     		$offset_page =0;
	     	}
		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$get_C_id['destination_id']."&venue_type_id=3&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
        $result_tripn = file_get_contents($urls);
        $get_all_data = json_decode($result_tripn, true);
        $resto_venues = $get_all_data['response']['venues'];
        $rows = $get_all_data['response']['total_records'];

        echo "<div class='couman_class'>"; ?>
	        <ul class="price clearfix filter-inputs">
				<li data-id="4" class="">
					<a href="search_city.php?amenites=33">Museums</a>
				</li>
				<li data-id="5" class="">
					<a href="search_city.php?amenites=34">Outdoors</a>
				</li>
				<li data-id="6" class="">
					<a href="search_city.php?amenites=35">Historical</a>
				</li>
			</ul>
			<?php

		    foreach ($resto_venues as $resto_venue) 
	          {
	          	echo "<div class='trip-expert'>"; 
	          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
	          		echo "<div class='trip-expert-data'>"; 
	          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
	          			echo "<h2> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
	          			echo "<h4 class='city_nme'>".$textc."</h4>";
	          			$urlR ="https://api.tripexpert.com/v1/venues/".$resto_venue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
				        $result_tripnR = file_get_contents($urlR);
				        $get_all_dataR = json_decode($result_tripnR, true);
				        $firstReview = $get_all_dataR['response']['venue'];
				        foreach ($firstReview as $rvalue) {
				        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
				        }
	          			echo "<div class='review-icon'>
								<li><img src='trip/line.png'></li>
								<li><img src='trip/6.png'></li>
								<li><img src='trip/14.png'></li>
								<li><img src='trip/21.png'></li>details_hotel
								<li><img src='trip/53.png'></li>
							</div>";
	          		echo "</div>";
	          	echo "</div>";
	          }
	          $limit = 15;
				$total=ceil($rows/$limit);
				if($rows > 15) {
				echo '<div class="pagination_new">';
				if($total > 1)
				{
					
					echo '<a href="?attraction='.$textc.'&page=1"><span title="First">&laquo;</span></a>';
					if ($page <= 1)
						echo "<span>Previous</span>";
					else            
						echo "<a href='?attraction=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
								<a href='?attraction=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
						<?php	}
						}
						$z++;
					}
					if($page == $total) 
						echo "<span>Next</span>";
					else           
						echo "<a href='?attraction=".$textc."&page=".($page+1)."'><span>Next</span></a>";

					echo "<a href='?attraction=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
				}
			echo "</div>";
			}
		    echo "</div>";
		}

	// code for Restaurent sub categories
    			if (isset($_GET['amenitess'])) 
				{
					$textc = trim($_GET['city']);
					$unique_amnt = trim($_GET['amenitess']);
			   		$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
					$get_C_id = mysql_fetch_assoc($get_C);
			  		$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');
					if($page!='1'){
							$offset_page = ($page-1)*15;
				     	}else{
				     		$offset_page =0;
				     	}
				$urls ="https://api.tripexpert.com/v1/venues?category_ids=".$unique_amnt."&venue_type_id=2&destination_id=".$get_C_id['destination_id']."&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
		        $result_tripn = file_get_contents($urls);
		        $get_all_data = json_decode($result_tripn, true);
		        $resto_venues = $get_all_data['response']['venues'];
		        $rows = $get_all_data['response']['total_records'];

		        echo "<div class='couman_class'>"; ?>
		        <ul class="price clearfix filter-inputs">
					<li data-id="4" class="">
						<a href="search_city.php?Rbudget=<?php echo $textc; ?>">Budget</a>
					</li>
					<li data-id="5" class="">
						<a href="search_city.php?Rmidrange=<?php echo $textc; ?>">Midrange</a>
					</li>
					<li data-id="6" class="">
						<a href="search_city.php?Rhighrange=<?php echo $textc; ?>">High-end</a>
					</li>
				</ul>
				<?php
		        foreach ($resto_venues as $resto_venue) 
		          {
		          	echo "<div class='trip-expert'>"; 
		          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
		          		echo "<div class='trip-expert-data'>"; 
		          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
		          			echo "<h2> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
		          			echo "<h4 class='city_nme'>".$textc."</h4>";
		          			$urlR ="https://api.tripexpert.com/v1/venues/".$resto_venue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
					        $result_tripnR = file_get_contents($urlR);
					        $get_all_dataR = json_decode($result_tripnR, true);
					        $firstReview = $get_all_dataR['response']['venue'];
					        foreach ($firstReview as $rvalue) {
					        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
					        }
		          			echo "<div class='review-icon'>
									<li><img src='trip/line.png'></li>
									<li><img src='trip/6.png'></li>
									<li><img src='trip/14.png'></li>
									<li><img src='trip/21.png'></li>
									<li><img src='trip/53.png'></li>
								</div>";
		          		echo "</div>";
		          	echo "</div>";
		          }
		          $limit = 15;
					$total=ceil($rows/$limit);
					if($rows > 15) {
						echo '<div class="pagination_new">';
						if($total > 1)
						{
							echo "<a href='?amenitess=".$unique_amnt."&city=".$textc."&page=1'><span title='First'>&laquo;</span></a>";
							if ($page <= 1)
								echo "<span>Previous</span>";
							else            
								echo "<a href='?amenitess=".$unique_amnt."&city=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
										<a href='?amenitess=<?php echo $unique_amnt; ?>&city=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
								<?php	}
								}
								$z++;
							}
							if($page == $total) 
								echo "<span>Next</span>";
							else           
								echo "<a href='?amenitess=".$unique_amnt."&city=".$textc."&page=".($page+1)."'><span>Next</span></a>";

							echo "<a href='?amenitess=".$unique_amnt."&city=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
						}
					echo "</div>";
					}
		        echo "</div>";  
        	}

// code for filter restaurent budget, midrange, highrange
   if (isset($_GET['Rbudget'])) 
				    {
				    	$textc = trim($_GET['Rbudget']);
			   			$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
						$get_C_id = mysql_fetch_assoc($get_C);
				        
				        $page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');	
					     	if($page!='1'){
								$offset_page = ($page-1)*15;
					     	}else{
					     		$offset_page =0;
					     	}
				        $urls ="https://api.tripexpert.com/v1/venues?destination_id=".$get_C_id['destination_id']."&price_category_ids=4&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
				        $result_tripn = file_get_contents($urls);
				        $get_all_data = json_decode($result_tripn, true);
				        $hotelvenues = $get_all_data['response']['venues'];
				        $rows = $get_all_data['response']['total_records'];

				        echo "<div class='couman_class'>"; ?>
					        <ul class="price clearfix filter-inputs">
								<li data-id="4" class="">
									<a href="search_city.php?Rbudget=<?php echo $textc; ?>" class="<?php echo ($_GET['Rbudget'] == $textc) ? 'active_range' : ''?>">Budget</a>
								</li>
								<li data-id="5" class="">
									<a href="search_city.php?Rmidrange=<?php echo $textc; ?>">Midrange</a>
								</li>
								<li data-id="6" class="">
									<a href="search_city.php?Rhighrange=<?php echo $textc; ?>">High-end</a>
								</li>
							</ul>
							<?php
				         
				          foreach ($hotelvenues as $hotelvenue) 
				          {
							echo "<div class='trip-expert'>"; 
				          		echo "<li><img src='".$hotelvenue['index_photo']."'></li>";
				          		echo "<div class='trip-expert-data'>"; 
				          			echo "<span class='score'>".$hotelvenue['tripexpert_score']."</span>";
				          			echo "<h2> <a href='details_hotel.php?details=".$hotelvenue['id']."'>".$hotelvenue['name']."</a> </h2>";
				          			echo "<h4 class='city_nme'>".$textc."</h4>";
				          			$urlR ="https://api.tripexpert.com/v1/venues/".$hotelvenue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
							        $result_tripnR = file_get_contents($urlR);
							        $get_all_dataR = json_decode($result_tripnR, true);
							        $firstReview = $get_all_dataR['response']['venue'];
							        foreach ($firstReview as $rvalue) {
							        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
							        }
				          			echo "<div class='review-icon'>
											<li><img src='trip/line.png'></li>
											<li><img src='trip/6.png'></li>
											<li><img src='trip/14.png'></li>
											<li><img src='trip/21.png'></li>
											<li><img src='trip/53.png'></li>
										</div>";
				          		echo "</div>";
				          	echo "</div>";				            
				          }
				          $limit = 15;
							$total=ceil($rows/$limit);
							if($rows > 15) {
							echo '<div class="pagination_new">';
							if($total > 1)
							{
								echo "<a href='?Rbudget=".$textc."&page=1'><span title='First'>&laquo;</span></a>";
								if ($page <= 1)
									echo "<span>Previous</span>";
								else            
									echo "<a href='?Rbudget=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
											<a href='?Rbudget=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
									<?php	}
									}
									$z++;
								}
								if($page == $total) 
									echo "<span>Next</span>";
								else           
									echo "<a href='?Rbudget=".$textc."&page=".($page+1)."'><span>Next</span></a>";

								echo "<a href='?Rbudget=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
							}
							echo "</div>";
						}
				        echo "</div>";  
    				} elseif(isset($_GET['Rmidrange'])) {

    					$textc = trim($_GET['Rmidrange']);
			   			$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
						$get_C_id = mysql_fetch_assoc($get_C);
    					 $page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');
	    					if($page!='1'){
									$offset_page = ($page-1)*15;
						     	}else{
						     		$offset_page =0;
						     	}
				        $urls ="https://api.tripexpert.com/v1/venues?destination_id=".$get_C_id['destination_id']."&price_category_ids=5&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
				        $result_tripn = file_get_contents($urls);
				        $get_all_data = json_decode($result_tripn, true);
				        $hotelvenues = $get_all_data['response']['venues'];
				        $rows = $get_all_data['response']['total_records'];
				         
				         echo "<div class='couman_class'>"; ?>
					        <ul class="price clearfix filter-inputs">
								<li data-id="4" class="">
									<a href="search_city.php?Rbudget=<?php echo $textc; ?>">Budget</a>
								</li>
								<li data-id="5" class="">
									<a href="search_city.php?Rmidrange=<?php echo $textc; ?>" class="<?php echo ($_GET['Rmidrange'] == $textc) ? 'active_range' : ''?>">Midrange</a>
								</li>
								<li data-id="6" class="">
									<a href="search_city.php?Rhighrange=<?php echo $textc; ?>">High-end</a>
								</li>
							</ul>
							<?php
				          foreach ($hotelvenues as $hotelvenue) 
				          {
							echo "<div class='trip-expert'>"; 
				          		echo "<li><img src='".$hotelvenue['index_photo']."'></li>";
				          		echo "<div class='trip-expert-data'>"; 
				          			echo "<span class='score'>".$hotelvenue['tripexpert_score']."</span>";
				          			echo "<h2> <a href='details_hotel.php?details=".$hotelvenue['id']."'>".$hotelvenue['name']."</a> </h2>";
				          			echo "<h4 class='city_nme'>".$textc."</h4>";
				          			$urlR ="https://api.tripexpert.com/v1/venues/".$hotelvenue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
							        $result_tripnR = file_get_contents($urlR);
							        $get_all_dataR = json_decode($result_tripnR, true);
							        $firstReview = $get_all_dataR['response']['venue'];
							        foreach ($firstReview as $rvalue) {
							        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
							        }
				          			echo "<div class='review-icon'>
											<li><img src='trip/line.png'></li>
											<li><img src='trip/6.png'></li>
											<li><img src='trip/14.png'></li>
											<li><img src='trip/21.png'></li>
											<li><img src='trip/53.png'></li>
										</div>";
				          		echo "</div>";
				          	echo "</div>";				            
				          }
				          $limit = 15;
							$total=ceil($rows/$limit);
							if($rows > 15) {
								echo '<div class="pagination_new">';
								if($total > 1)
								{
									echo "<a href='?Rmidrange=".$textc."&page=1'><span title='First'>&laquo;</span></a>";
									if ($page <= 1)
										echo "<span>Previous</span>";
									else            
										echo "<a href='?Rmidrange=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
												<a href='?Rmidrange=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
										<?php	}
										}
										$z++;
									}
									if($page == $total) 
										echo "<span>Next</span>";
									else           
										echo "<a href='?Rmidrange=".$textc."&page=".($page+1)."'><span>Next</span></a>";

									echo "<a href='?Rmidrange=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
								}
							echo "</div>";
							}
				        echo "</div>";  
    				} elseif (isset($_GET['Rhighrange'])) {
    					$textc = trim($_GET['Rhighrange']);
			   			$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
						$get_C_id = mysql_fetch_assoc($get_C);
    					$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');
	    					if($page!='1'){
									$offset_page = ($page-1)*15;
						     	}else{
						     		$offset_page =0;
						     	}
				        $urls ="https://api.tripexpert.com/v1/venues?destination_id=".$get_C_id['destination_id']."&price_category_ids=6&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
				        $result_tripn = file_get_contents($urls);
				        $get_all_data = json_decode($result_tripn, true);
				        $hotelvenues = $get_all_data['response']['venues'];
				        $rows = $get_all_data['response']['total_records'];
				         
				         echo "<div class='couman_class'>"; ?>
					        <ul class="price clearfix filter-inputs">
								<li data-id="4" class="">
									<a href="search_city.php?Rbudget=<?php echo $textc; ?>">Budget</a>
								</li>
								<li data-id="5" class="">
									<a href="search_city.php?Rmidrange=<?php echo $textc; ?>">Midrange</a>
								</li>
								<li data-id="6" class="">
									<a href="search_city.php?Rhighrange=<?php echo $textc; ?>" class="<?php echo ($_GET['Rhighrange'] == $textc) ? 'active_range' : ''?>">High-end</a>
								</li>
							</ul>
							<?php
				          foreach ($hotelvenues as $hotelvenue) 
				          {
							echo "<div class='trip-expert'>"; 
				          		echo "<li><img src='".$hotelvenue['index_photo']."'></li>";
				          		echo "<div class='trip-expert-data'>"; 
				          			echo "<span class='score'>".$hotelvenue['tripexpert_score']."</span>";
				          			echo "<h2> <a href='details_hotel.php?details=".$hotelvenue['id']."'>".$hotelvenue['name']."</a> </h2>";
				          			echo "<h4 class='city_nme'>".$textc."</h4>";
				          			$urlR ="https://api.tripexpert.com/v1/venues/".$hotelvenue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
							        $result_tripnR = file_get_contents($urlR);
							        $get_all_dataR = json_decode($result_tripnR, true);
							        $firstReview = $get_all_dataR['response']['venue'];
							        foreach ($firstReview as $rvalue) {
							        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
							        }
				          			echo "<div class='review-icon'>
											<li><img src='trip/line.png'></li>
											<li><img src='trip/6.png'></li>
											<li><img src='trip/14.png'></li>
											<li><img src='trip/21.png'></li>
											<li><img src='trip/53.png'></li>
									</div>";
				          		echo "</div>";
				          	echo "</div>";				            
				          }
				          $limit = 15;
							$total=ceil($rows/$limit);
							if($rows > 15) {
								echo '<div class="pagination_new">';
								if($total > 1)
								{
									echo "<a href='?Rhighrange=".$textc."&page=1'><span title='First'>&laquo;</span></a>";
									if ($page <= 1)
										echo "<span>Previous</span>";
									else            
										echo "<a href='?Rhighrange=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
												<a href='?Rhighrange=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
										<?php	}
										}
										$z++;
									}
									if($page == $total) 
										echo "<span>Next</span>";
									else           
										echo "<a href='?Rhighrange=".$textc."&page=".($page+1)."'><span>Next</span></a>";

									echo "<a href='?Rhighrange=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
								}
							echo "</div>";
							}
				        echo "</div>";  
    				}

    // code for filter Hotel -->budget, midrange, luxury
   if (isset($_GET['Hbudget'])) 
				    {
				    	$textc = trim($_GET['Hbudget']);
			   			$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
						$get_C_id = mysql_fetch_assoc($get_C);
				        
				        $page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');	
					     	if($page!='1'){
								$offset_page = ($page-1)*15;
					     	}else{
					     		$offset_page =0;
					     	}
				        $urls ="https://api.tripexpert.com/v1/venues?destination_id=".$get_C_id['destination_id']."&price_category_ids=1&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
				        $result_tripn = file_get_contents($urls);
				        $get_all_data = json_decode($result_tripn, true);
				        $hotelvenues = $get_all_data['response']['venues'];
				        $rows = $get_all_data['response']['total_records'];

				        echo "<div class='couman_class'>"; ?>
					        <ul class="price clearfix filter-inputs">
								<li data-id="4" class="">
									<a href="search_city.php?Hbudget=<?php echo $textc; ?>" class="<?php echo ($_GET['Hbudget'] == $textc) ? 'active_range' : ''?>">Budget</a>
								</li>
								<li data-id="5" class="">
									<a href="search_city.php?Hmidrange=<?php echo $textc; ?>">Midrange</a>
								</li>
								<li data-id="6" class="">
									<a href="search_city.php?Hluxury=<?php echo $textc; ?>">Luxury</a>
								</li>
							</ul>
							<?php
				         
				          foreach ($hotelvenues as $hotelvenue) 
				          {
							echo "<div class='trip-expert'>"; 
				          		echo "<li><img src='".$hotelvenue['index_photo']."'></li>";
				          		echo "<div class='trip-expert-data'>"; 
				          			echo "<span class='score'>".$hotelvenue['tripexpert_score']."</span>";
				          			echo "<h2> <a href='details_hotel.php?details=".$hotelvenue['id']."'>".$hotelvenue['name']."</a> </h2>";
				          			echo "<h4 class='city_nme'>".$textc."</h4>";
				          			$urlR ="https://api.tripexpert.com/v1/venues/".$hotelvenue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
							        $result_tripnR = file_get_contents($urlR);
							        $get_all_dataR = json_decode($result_tripnR, true);
							        $firstReview = $get_all_dataR['response']['venue'];
							        foreach ($firstReview as $rvalue) {
							        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
							        }
				          			echo "<div class='review-icon'>
											<li><img src='trip/line.png'></li>
											<li><img src='trip/6.png'></li>
											<li><img src='trip/14.png'></li>
											<li><img src='trip/21.png'></li>
											<li><img src='trip/53.png'></li>
										</div>";
				          		echo "</div>";
				          	echo "</div>";				            
				          }
				          $limit = 15;
							$total=ceil($rows/$limit);
							if($rows > 15) {
							echo '<div class="pagination_new">';
							if($total > 1)
							{
								echo "<a href='?Hbudget=".$textc."&page=1'><span title='First'>&laquo;</span></a>";
								if ($page <= 1)
									echo "<span>Previous</span>";
								else            
									echo "<a href='?Hbudget=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
											<a href='?Hbudget=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
									<?php	}
									}
									$z++;
								}
								if($page == $total) 
									echo "<span>Next</span>";
								else           
									echo "<a href='?Hbudget=".$textc."&page=".($page+1)."'><span>Next</span></a>";

								echo "<a href='?Hbudget=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
							}
							echo "</div>";
						}
				        echo "</div>";  
    				} elseif(isset($_GET['Hmidrange'])) {

    					$textc = trim($_GET['Hmidrange']);
			   			$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
						$get_C_id = mysql_fetch_assoc($get_C);
    					 $page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');
	    					if($page!='1'){
									$offset_page = ($page-1)*15;
						     	}else{
						     		$offset_page =0;
						     	}
				        $urls ="https://api.tripexpert.com/v1/venues?destination_id=".$get_C_id['destination_id']."&price_category_ids=2&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
				        $result_tripn = file_get_contents($urls);
				        $get_all_data = json_decode($result_tripn, true);
				        $hotelvenues = $get_all_data['response']['venues'];
				        $rows = $get_all_data['response']['total_records'];
				         
				         echo "<div class='couman_class'>"; ?>
					        <ul class="price clearfix filter-inputs">
								<li data-id="4" class="">
									<a href="search_city.php?Hbudget=<?php echo $textc; ?>">Budget</a>
								</li>
								<li data-id="5" class="">
									<a href="search_city.php?Hmidrange=<?php echo $textc; ?>" class="<?php echo ($_GET['Hmidrange'] == $textc) ? 'active_range' : ''?>">Midrange</a>
								</li>
								<li data-id="6" class="">
									<a href="search_city.php?Hluxury=<?php echo $textc; ?>">Luxury</a>
								</li>
							</ul>
							<?php
				          foreach ($hotelvenues as $hotelvenue) 
				          {
							echo "<div class='trip-expert'>"; 
				          		echo "<li><img src='".$hotelvenue['index_photo']."'></li>";
				          		echo "<div class='trip-expert-data'>"; 
				          			echo "<span class='score'>".$hotelvenue['tripexpert_score']."</span>";
				          			echo "<h2> <a href='details_hotel.php?details=".$hotelvenue['id']."'>".$hotelvenue['name']."</a> </h2>";
				          			echo "<h4 class='city_nme'>".$textc."</h4>";
				          			$urlR ="https://api.tripexpert.com/v1/venues/".$hotelvenue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
							        $result_tripnR = file_get_contents($urlR);
							        $get_all_dataR = json_decode($result_tripnR, true);
							        $firstReview = $get_all_dataR['response']['venue'];
							        foreach ($firstReview as $rvalue) {
							        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
							        }
				          			echo "<div class='review-icon'>
											<li><img src='trip/line.png'></li>
											<li><img src='trip/6.png'></li>
											<li><img src='trip/14.png'></li>
											<li><img src='trip/21.png'></li>
											<li><img src='trip/53.png'></li>
										</div>";
				          		echo "</div>";
				          	echo "</div>";				            
				          }
				          $limit = 15;
							$total=ceil($rows/$limit);
							if($rows > 15) {
								echo '<div class="pagination_new">';
								if($total > 1)
								{
									echo "<a href='?Hmidrange=".$textc."&page=1'><span title='First'>&laquo;</span></a>";
									if ($page <= 1)
										echo "<span>Previous</span>";
									else            
										echo "<a href='?Hmidrange=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
												<a href='?Hmidrange=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
										<?php	}
										}
										$z++;
									}
									if($page == $total) 
										echo "<span>Next</span>";
									else           
										echo "<a href='?Hmidrange=".$textc."&page=".($page+1)."'><span>Next</span></a>";

									echo "<a href='?Hmidrange=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
								}
							echo "</div>";
							}
				        echo "</div>";  
    				} elseif (isset($_GET['Hluxury'])) {
    					$textc = trim($_GET['Hluxury']);
			   			$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
						$get_C_id = mysql_fetch_assoc($get_C);
    					$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');
	    					if($page!='1'){
									$offset_page = ($page-1)*15;
						     	}else{
						     		$offset_page =0;
						     	}
				        $urls ="https://api.tripexpert.com/v1/venues?destination_id=".$get_C_id['destination_id']."&price_category_ids=3&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
				        $result_tripn = file_get_contents($urls);
				        $get_all_data = json_decode($result_tripn, true);
				        $hotelvenues = $get_all_data['response']['venues'];
				        $rows = $get_all_data['response']['total_records'];
				         
				         echo "<div class='couman_class'>"; ?>
					        <ul class="price clearfix filter-inputs">
								<li data-id="4" class="">
									<a href="search_city.php?Hbudget=<?php echo $textc; ?>">Budget</a>
								</li>
								<li data-id="5" class="">
									<a href="search_city.php?Hmidrange=<?php echo $textc; ?>">Midrange</a>
								</li>
								<li data-id="6" class="">
									<a href="search_city.php?Hluxury=<?php echo $textc; ?>" class="<?php echo ($_GET['Hluxury'] == $textc) ? 'active_range' : ''?>">Luxury</a>
								</li>
							</ul>
							<?php
				          foreach ($hotelvenues as $hotelvenue) 
				          {
							echo "<div class='trip-expert'>"; 
				          		echo "<li><img src='".$hotelvenue['index_photo']."'></li>";
				          		echo "<div class='trip-expert-data'>"; 
				          			echo "<span class='score'>".$hotelvenue['tripexpert_score']."</span>";
				          			echo "<h2> <a href='details_hotel.php?details=".$hotelvenue['id']."'>".$hotelvenue['name']."</a> </h2>";
				          			echo "<h4 class='city_nme'>".$textc."</h4>";
				          			$urlR ="https://api.tripexpert.com/v1/venues/".$hotelvenue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
							        $result_tripnR = file_get_contents($urlR);
							        $get_all_dataR = json_decode($result_tripnR, true);
							        $firstReview = $get_all_dataR['response']['venue'];
							        foreach ($firstReview as $rvalue) {
							        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
							        }
				          			echo "<div class='review-icon'>
											<li><img src='trip/line.png'></li>
											<li><img src='trip/6.png'></li>
											<li><img src='trip/14.png'></li>
											<li><img src='trip/21.png'></li>
											<li><img src='trip/53.png'></li>
									</div>";
				          		echo "</div>";
				          	echo "</div>";				            
				          }
				          $limit = 15;
							$total=ceil($rows/$limit);
							if($rows > 15) {
								echo '<div class="pagination_new">';
								if($total > 1)
								{
									echo "<a href='?Hluxury=".$textc."&page=1'><span title='First'>&laquo;</span></a>";
									if ($page <= 1)
										echo "<span>Previous</span>";
									else            
										echo "<a href='?Hluxury=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
												<a href='?Hluxury=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
										<?php	}
										}
										$z++;
									}
									if($page == $total) 
										echo "<span>Next</span>";
									else           
										echo "<a href='?Hluxury=".$textc."&page=".($page+1)."'><span>Next</span></a>";

									echo "<a href='?Hluxury=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
								}
							echo "</div>";
							}
				        echo "</div>";  
    				}

		
	// code for Attraction sub categories
    			if ($_GET['amenites'] == 33 || $_GET['amenites'] == 34 || $_GET['amenites'] == 35) 
				   {
				   		$textc = trim($_GET['city']);
				   		$get_C = mysql_query("SELECT destination_id FROM trip_city_list WHERE country_name = '".$textc."'");
						$get_C_id = mysql_fetch_assoc($get_C);

				   		
	        		$unique_amnt = (int) $_GET['amenites'];
	        		$page = (trim($_REQUEST['page'])!='' ? trim($_REQUEST['page']) : '1');
					if($page!='1'){
							$offset_page = ($page-1)*15;
				     	}else{
				     		$offset_page =0;
				     	}
					$urls ="https://api.tripexpert.com/v1/venues?category_ids=".$unique_amnt."&venue_type_id=3&destination_id=".$get_C_id['destination_id']."&limit=15&offset=".$offset_page."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
			        $result_tripn = file_get_contents($urls);
			        $get_all_data = json_decode($result_tripn, true);
			        $resto_venues = $get_all_data['response']['venues'];
			        $rows = $get_all_data['response']['total_records'];

			        echo "<div class='couman_class'>"; ?>
			        <ul class="price clearfix filter-inputs">
							<li data-id="4" class="">
								<a href="search_city.php?amenites=33&city=<?php echo $textc; ?>" class="<?php echo ($_GET['amenites'] == 33) ? 'active_range' : ''?>">Museums</a>
							</li>
							<li data-id="5" class="">
								<a href="search_city.php?amenites=34&city=<?php echo $textc; ?>" class="<?php echo ($_GET['amenites'] == 34) ? 'active_range' : ''?>">Outdoors</a>
							</li>
							<li data-id="6" class="">
								<a href="search_city.php?amenites=35&city=<?php echo $textc; ?>" class="<?php echo ($_GET['amenites'] == 35) ? 'active_range' : ''?>">Historical</a>
							</li>
						</ul>
					<?php
			        foreach ($resto_venues as $resto_venue) 
			          {
			          	echo "<div class='trip-expert'>"; 
			          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
			          		echo "<div class='trip-expert-data'>"; 
			          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
			          			echo "<h2> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
			          			echo "<h4 class='city_nme'>".$textc."</h4>";
			          			$urlR ="https://api.tripexpert.com/v1/venues/".$resto_venue['id']."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
						        $result_tripnR = file_get_contents($urlR);
						        $get_all_dataR = json_decode($result_tripnR, true);
						        $firstReview = $get_all_dataR['response']['venue'];
						        foreach ($firstReview as $rvalue) {
						        	echo "<p>".$rvalue['reviews'][0]['extract']."</p>";
						        }
			          			echo "<div class='review-icon'>
										<li><img src='trip/line.png'></li>
										<li><img src='trip/6.png'></li>
										<li><img src='trip/14.png'></li>
										<li><img src='trip/21.png'></li>
										<li><img src='trip/53.png'></li>
									</div>";
			          		echo "</div>";
			          	echo "</div>";
			          }
			          $limit = 15;
						$total=ceil($rows/$limit);
						if($rows > 15) {
							echo '<div class="pagination_new">';
							if($total > 1)
							{
								echo "<a href='?amenites=".$unique_amnt."&city=".$textc."&page=1'><span title='First'>&laquo;</span></a>";
								if ($page <= 1)
									echo "<span>Previous</span>";
								else            
									echo "<a href='?amenites=".$unique_amnt."&city=".$textc."&page=".($page-1)."'><span>Previous</span></a>";
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
											<a href='?amenites=<?php echo $unique_amnt; ?>&city=<?php echo $textc; ?>&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
									<?php	}
									}
									$z++;
								}
								if($page == $total) 
									echo "<span>Next</span>";
								else           
									echo "<a href='?amenites=".$unique_amnt."&city=".$textc."&page=".($page+1)."'><span>Next</span></a>";

								echo "<a href='?amenites=".$unique_amnt."&city=".$textc."&page=".$total."'><span title='Last'>&raquo;</span></a>";
							}
						echo "</div>";
						}
			        echo "</div>";  
	        	} 
						

	?>	
	
				
		
	</article>

		<aside style="position:relative;" class="sidebar v2_sidebar sidebarEvents"> 
   		   			<div id="NewSidebar">
        
   				<h1>Memphis's Talents</h1>
       				<img alt="" src="images/corner2-sidebar.png">
   				<div class="clear"></div>
   				<div class="ItemBox itemTitle">
          					<a href="https://www.mysittidev.com/artistDetailsBrowsePage.php" class="fullListView All-atlanta" style="margin-right:0px;">View All Talents </a>
          				</div>
   				<div class="ItemBox">
   					<h2>Faces of Memphis, TN</h2>
   						<a href="https://www.mysittidev.com/artistDetailsPage.php?type=usersList">
   							<img alt="" src="images/populars_img.png">
						</a>
   					</div>
 					<div class="ItemBox">
   						<h2>Bands</h2>
   						<a href="https://www.mysittidev.com/artistDetailsPage.php?type=hosts&amp;category=Band">
   							<img alt="" src="images/bands_img.png">
						</a>
   					</div>
   					<div class="ItemBox">
   						<h2>Singers</h2>
						<a href="https://www.mysittidev.com/artistDetailsPage.php?type=hosts&amp;category=Singer">
							<img alt="" src="images/singers.png">
						</a>
   					</div>
   					<div class="ItemBox">
   						<h2>Night Club</h2>
   						<a href="https://www.mysittidev.com/artistDetailsPage.php?type=hosts&amp;category=Clubs">
   							<img alt="" src="images/nightclub_img.png">
   						</a>
   					</div> 
					<div class="ItemBox">
   						<h2>Comedy Club</h2>
						<a href="https://www.mysittidev.com/artistDetailsPage.php?type=hosts&amp;category=Comedy Club">
							<img alt="" src="images/comedyclub_img.png">
						</a>
   					</div>
        					<div class="ItemBox">
   						<h2>DJ'S</h2>
						<a href="https://www.mysittidev.com/artistDetailsPage.php?type=hosts&amp;category=Djs">
							<img alt="" src="images/djs.png">
						</a>
   					</div>
        					
			</div>
   		</aside>

</div>
<div id="fullOverlay"></div>
<style type="text/css">

	.active_range {
   		background: #1c50b3 !important;
   		color: white !important;
   	}

#popup3_album_515 #sharePostfriends {
  float: left;
  margin: 20px 40%;
  text-align: center;
}
	#popup_adv {
										float: left;
										position: relative;
										width: 100%;
									}
									#inner_popup_adv {
										float: left;
										height: 100%;
										position: absolute;
										width: 100%;
										z-index: 99;
									}	
									#popup3_album_515 {
								  background: #000 none repeat scroll 0 0;
  border: 4px solid #ff0;
  bottom: 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  height: auto;
  left: 0;
  margin: auto;
  max-height: 500px!important;
  max-width: 500px!important;
  overflow: auto;
  padding: 10px !important;
  position: fixed;
  right: 0;
  top: 0;
  width: 100% !important;
  z-index: 2;
									}
		 
		#popup3_album_515 h1 {
  padding: 10px 0;
  text-transform: uppercase;
  margin-bottom: 10px;
}
									#popup3_album_515 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
									#popup, #popup2, #popup3_album_515, .bMulti {
										background-color: #000;
										border-radius: 10px;
										box-shadow: 0 0 25px 5px #006099;
										color: #111;
										padding: 25px;
										display: none;
									}
									#popup3_album_515 span.b-close-album-515 { border: none; float: right;color: #fecd07; cursor: pointer;}
										.b-modal1-album-515{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:99; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}
									
									#popup2 #mycontent-album-515 &gt; p {
										color: white;
										font-size: 15px;
										font-weight: bold;
									}
									
									#popup2 #mycontent-album-515 &gt; span {
										color: white;
									}
									#popup3_album_515									{
										z-index: 99999;
										color: #FFF;
									}
									#popup3_album_515 #mycontent-album-515 &gt; p {
									  border-bottom: 1px solid #fff;
									  font-size: 20px;
									  margin-bottom: 10px;
									  padding-bottom: 10px;
									}
									

									#mycontent-album-515 li {
			background: #000 none repeat scroll 0 0;
float: left;
margin: 10px 1%;
max-height: 150px;
/*min-height: 150px;*/
overflow: hidden;
position: relative;
width: 31.3%;
									}
									
					#mycontent-album-515 li img{
	  max-width:100%; position:absolute; left:0; right:0; top:0; bottom:0; margin:auto;
	 }
									#mycontent-album-515 &gt; ul {
										float: left;
										width: 100%;
									}
         
         .v2_banner_top1.h_auto {
  background: rgba(0, 0, 0, 0) url("../images/noice.png") repeat scroll left top !important;
}
		 @media only screen and (min-width:540px) {
							#mycontent-album-515 li { 
width: 48%;
									}
		 }
		 
</style>
<script language="javascript">


$(document).ready(function(){
	$( "#get_destination" ).keypress(function() {
		var urldes = '<?php echo $SiteURL;?>';
		var URLDES = urldes+'refreshajax.php?getaction=fetchdestinations';
		
		$('#get_destination').autocomplete(URLDES);
		// return false;
	}); 

});
</script>
<script type="text/javascript">
function checkAllfriends()
{
	if($('#SelectALL').is(':checked'))
	{
		$('.SharingFriendslist li input').each(function(){
			$(this).prop('checked', true);
		});	
	}
	else
	{
		$('.SharingFriendslist li input').each(function(){
			$(this).prop('checked', false);
		});	
	}

	
}


$(document).ready(function(){
	$('.b-close-album-515').click(function(){
		$('#popup3_album_515').hide();
	});
});

function sharepostPublic(forumid)
{
	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'forumid' : forumid,
			'action' : 'sharePostPublic',
		},
		success: function(data){
			//window.location.href = '?host_id='+id;
			alert('Post shared Publically!');
			return false;
		}
	});
}

function sharepostPrivate (forumid) 
{
	$('#popup3_album_515,#fullOverlay').show();
	$('#forumidtoshare').val(forumid);
	$('.SharingFriendslist li input').each(function(){
		$(this).prop('checked', false);
	});
}


function sharePostFriends()
{
	var forumid = $('#forumidtoshare').val();

	var stringids = $.map($(':checkbox[name=ShareFriends\\[\\]]:checked'), function (n, i) {
					return n.value;
			}).join(',');

	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'string' : stringids,
			'forumid' : forumid,
			'action' : 'sharePostFriends',
		},
		success: function(data){
			//window.location.href = '?host_id='+id;
			alert('Post shared with selected Friends!');
			$('#popup3_album_515').hide();
			$('#fullOverlay').hide();
			return false;
		}
	});
}




function fetchclubs(id)

{

	var catid1 = id.split('_');

	var cityid = "54";

	//alert($('#list_'+catid1[1]).size());

	if( $('#list_'+catid1[1]).size()  == 1 )

	{

		$('#list_'+catid1[1]).html('&lt;li style="text-align: center; background: none;"&gt;&lt;img width="100px" src="loading.gif" alt="" /&gt;&lt;/li&gt;');

	}

	

	$.ajax({

		type: "POST",

		url: "fetchClubs.php",

		data: {

			'cityid' : cityid,

			'catid' : catid1[1]

		},

		success: function(data)

		{

			//alert(data);

			$('#list_'+catid1[1]).html(data);

		}

	});

}



function set_default_cat(){

	var atLeastOneIsChecked = $( "#s_default_cat:input:checked" ).val();

	if (atLeastOneIsChecked == "on") {

		

		var cat_value = $('#eventcatselect').val();

		var user_type = 'club';

		var user_id = '497627';

		

		$.ajax({

			type: "POST",

			url: "ajaxcall.php",

			data: {

				'set_default_category' : cat_value, 'user_type' : user_type, 'user_id' : user_id

			},

			success: function(data)

			{

				alert(data);

			}

		});

	}

}



function addToCalendar(fid)

{

	$.ajax({

		type: "POST",

		url: "refreshajax.php",

		data: 	{

				'action' : 'addtocalendar', 

				'forumID' : fid, 

				// 'user_id' : user_id

			},

		success: function(data){

			$('#add_to_calendar_'+fid).html(data);

		}

	});

}



function savehost(id,ac)

{

	

	$.ajax({

		type: "POST",

		url: "savehost.php",

		data: {

			'host_id' : id,

			'action' : ac,

		},

		success: function(data){

			$('.follow_hostc').hide();

			

			if (data == "success") {

				$('.block_new').hide();

				$('.block').show();

			}else if (data == "blocked") {

				$('.unblock_new').hide();

				$('.unblock').show();

			}else if (data == "unblocked") {

				$('.block_new').hide();

				$('.block').show();

			}

		}

	});



return false;

}

</script>



</div>
</div>




<?php
if(!isset($_SESSION['user_id'])){
	include('LandingPageFooter.php');
}
else{
	include('Footer.php');
}

?>