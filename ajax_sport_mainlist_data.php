<?php

	include 'Query.Inc.php';
	$Obj = new Query($DBName);
	error_reporting(0);
	$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

	$cityName = $_POST['city_name'];

    $session = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$cityName."'");
    $getSesionId = mysql_fetch_assoc($session);
    $SessionId = $getSesionId['city_id'];

	$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$SessionId."'");
	$get_city_name = mysql_fetch_assoc($city_name_query);
	$dropdown_city = $get_city_name['city_name'];

	$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
	$get_state_name = mysql_fetch_assoc($state_name_query);
	$_SESSION['country'] = $get_state_name['country_id'];
	$state_name = $get_state_name['name'];
	$state_code = $get_state_name['code'];

	$sql10 = "SELECT * FROM `sportsTeam` WHERE state_code = '".$state_code."' OR state_name = '".$state_name."'";
	
	$result10 = mysql_query($sql10);

	$nurows10 = mysql_num_rows($result10);

    if($nurows10 > 0) {
    while($row = mysql_fetch_assoc($result10))
    {

    	$html2 .= "<ul class='for-sports-list'>";
				if(!empty($row['NBA']))
				{

					$string = $row['NBA'];
					$array = explode(',', $string);

				$html2 .= "<li>
					<a href='javascript:;' class='list-inner'>
						<div class='list-inner-top'>
							<img src='images/nba.jpg' />
						</div>
						
						<div class='list-inner-bottom'>
						    <span style='display:none;'>".$array[0]."</span>
							<p>NBA</p>
						</div>
					</a>
				</li>";
				}

				if(!empty($row['NFL']))
				{
					$string = $row['NFL'];
					$array = explode(',', $string);

				$html2 .= "<li>
					<a href='javascript:;' class='list-inner'>
						<div class='list-inner-top'>
							<img src='images/nfl.jpg' />
						</div>
						
						<div class='list-inner-bottom'>
						    <span style='display:none;'>".$array[0]."</span>
							<p>NFL</p>
						</div>
					</a>
				</li>";
				}

				if(!empty($row['NHL']))
				{
					$string = $row['NHL'];
					$array = explode(',', $string);
			

				$html2 .= "<li>
					<a href='javascript:;' class='list-inner'>
						<div class='list-inner-top'>
							<img src='images/nhl.jpg' />
						</div>
						
						<div class='list-inner-bottom'>
						    <span style='display:none;'>".$array[0]."</span>
							<p>NHL</p>
						</div>
					</a>
				</li>";
				}

				if(!empty($row['MLB']))
				{

			    $string = $row['MLB'];
			    $array = explode(',', $string);

				$html2 .= "<li>
					<a href='javascript:;' class='list-inner'>
						<div class='list-inner-top'>
							<img src='images/mlb.jpg' />
						</div>
						
						<div class='list-inner-bottom'>
						    <span style='display:none;'>".$array[0]."</span>
							<p>MLB</p>
						</div>
					</a>
				</li>";
				}

				if(!empty($row['MLS']))
				{
					$string = $row['MLS'];
			    	$array = explode(',', $string);

				$html2 .= "<li>
					<a href='javascript:;' class='list-inner'>
						<div class='list-inner-top'>
							<img src='images/soccer.jpg' />
						</div>
						
						<div class='list-inner-bottom'>
						    <span style='display:none;'>".$array[0]."</span>
							<p>MLS</p>
						</div>
					</a>
				</li>";
				}

				if(!empty($row['CFL']))
				{
				$html2 .= "<li>
					<a href='javascript:;' class='list-inner'>
						<div class='list-inner-top'>
							<img src='images/football.jpg' />
						</div>
						
						<div class='list-inner-bottom'>
							<p>CFL</p>
						</div>
					</a>
				</li>";
				}

				if(!empty($row['Colleges']))
				{

					$string = $row['Colleges'];
					$array = explode(',', $string);

				$html2 .= "<li>
					<a href='javascript:;' class='list-inner'>
						<div class='list-inner-top'>
							<img src='imagesNew/ncaa-logo.jpg' />
						</div>
						
						<div class='list-inner-bottom'>
						    <span style='display:none;'>".$array[0]."</span>

							<p>Colleges</p>
						</div>
					</a>
				</li>";
				}

				$html2 .= "</ul>";
				
	
	    }
	    echo $html2;
	    } else {

	    	$html2 .= "<h1 class='record_not_found'>Events not found.</h1>";
	    	echo $html2;
	    	
	    }
?>       
