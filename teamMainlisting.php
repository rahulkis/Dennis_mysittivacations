<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$manyTeam = trim($_POST['manyTeam']); // for click in sports image icon
$formatedcity = trim($_POST['formatedcity']);
$sitti = explode(",", $formatedcity);

	$sitt = $sitti[0];
	if($sitt == "Washington") {
	$sitthy = "washington-dc";
	$sittsp = "washington%20dc";
	} else {
		$sitthy = str_replace(' ', '-', strtolower($sitti[0]));
		$sittsp = str_replace(' ', '%20', strtolower($sitti[0]));
		$sitttn = str_replace(' ', '', $sitti[1]);
	}

$sqlTeam = "SELECT * FROM `sportsTeam` WHERE state_code = '".$sitttn."' OR state_name = '".$sitt."'";
$teamResult = mysql_query($sqlTeam);

 while($teamRow = mysql_fetch_assoc($teamResult))
 {
	$teamPart = explode(",", trim($teamRow[$manyTeam]));
	$stateName = $teamRow['state_name'];
 }

//////////////////////////////////////////////////////////


$teamwith = trim($_POST['teamValue']); // for search box in sidebar
$checkw = substr_count($teamwith, '-');
if($checkw == 1)
{

	$res = explode(" - ", $teamwith);
	$teamValue = $res[1];

} else {
	$teamValue = $teamwith;
}
//////////////////////////////////////////////////////////////


$firstd = $_POST['da1']; // for date range filter
$secd = $_POST['da2'];
$datecin=date_create($firstd);
$date1 = date_format($datecin,"Y-m-d");

$dateout=date_create($secd);
$date2 = date_format($dateout,"Y-m-d");

$data1 = $_POST['teamnm'];
$teamnmme  = trim($data1);


////////////////////////////////////////////////////////////

$teamnmme = $_POST['teamnm']; // for sidebar team list
$hyteam = trim($teamnmme);
$check = substr_count($hyteam, '-');
if($check == 1)
{

	$resx = explode(" - ", $hyteam);
	$teamnm = $resx[1];

} else {
	$teamnm = $hyteam;
}
////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

$landing_page_team = $_POST['landing_page_team']; // for sidebar team list
$hyteam = trim($landing_page_team);
$check = substr_count($hyteam, '-');
if($check == 1)
{

	$resx = explode(" - ", $hyteam);
	$landing_page_team = $resx[1];

} else {
	$landing_page_team = $hyteam;
}
// $landing_page_city = $_POST['ticketmaster_trigger_city']; // for sidebar team list
// $hyteam = trim($landing_page_city);
// $check = substr_count($hyteam, '-');
// if($check == 1)
// {

// 	$resx = explode(" - ", $hyteam);
// 	$landing_page_city = $resx[1];

// } else {
// 	$landing_page_city = $hyteam;
// }
////////////////////////////////////////////////////////

$value = $_POST['formatted2']; // Main search box from banner
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

$start=0;
$limit = 30;
	// if(isset($_GET['page']))
	// {
	// $page = $_GET['page'];
	// $start = ($page-1)*$limit;
	// }
	if(!empty($value))
	{
		$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE `startdate` > NOW() AND (city LIKE '%$cy%' OR `keywords` LIKE '%$cy%') ORDER BY startdate ASC LIMIT $start, $limit";
	} elseif(!empty($teamnm)) {
		$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE `startdate` > NOW() AND (keywords LIKE '%$teamnm%' OR description LIKE '%$teamnm%') ORDER BY startdate ASC LIMIT $start, $limit";
	}elseif(!empty($landing_page_team)) {
		$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE `startdate` > NOW() AND (keywords LIKE '%$landing_page_team%' OR description LIKE '%$landing_page_team%') ORDER BY startdate ASC LIMIT $start, $limit";
	} elseif (!empty($teamValue)) {
		$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE `startdate` > NOW() AND (keywords LIKE '%$teamValue%' OR description LIKE '%$teamValue%') ORDER BY startdate ASC LIMIT $start, $limit";
	} elseif (!empty($manyTeam)) {
		
		$sql = "SELECT * FROM `ticket_sportsevent`
				WHERE (`city` = '$sitt' OR `city` = '$stateName')
				AND startdate > NOW() AND (";
				$i = 0;
				for ($i=0; $i < count($teamPart); $i++) { 
					$sql .= " description LIKE '%".$teamPart[$i]."%'";
					if($i < count($teamPart)-1)
					{
						$sql .= " OR";
					}
				}
			$sql .= ") LIMIT 50";
			// echo $sql;

	} else {
		$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM `ticket_sportsevent` WHERE startdate BETWEEN '$date1' and '$date2' LIMIT 45";
	}
		$result = mysql_query($sql);
		$html = "";
		

	    $rows = mysql_num_rows(mysql_query("SELECT name FROM ticket_sportsevent WHERE city LIKE '%$cy%' OR `keywords` LIKE '%$cy%' AND `startdate` > NOW() LIMIT $start, $limit"));
	    $co = mysql_num_rows($result);
	    if($co != 0) {

         
            echo $html2.= "<div id='audio-guide' class='manyTeamName'><h1 style='color: blue;'>
			</h1><h2 class='display-border' style='color: rgb(3, 85, 177);'>".$manyTeam."</h2></div>
			<a id='backbutton_id'><img src='/images/back.png'></a>
			<div class='audio-summary'>";

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
						<li><a href='redirect_aff.php?logo=tn&url=".$row['buyurl']."' class='hotelLink' target='_blank'>Select Events</a></li>

					</div>
					</div> ";
			}
    	}
		else
			{
				 echo $html2.= "<div id='audio-guide' class='manyTeamName'><h1 style='color: blue;'>
			</h1><h2 style='color: rgb(3, 85, 177);'>".$manyTeam."</h2></div>
			<a id='backbutton_id'><img src='/images/back.png'></a>
			<div class='audio-summary'>";
				$html .= "<h1 class='record_not_found'>Events not found.</h1>";
			}
    	echo $html;

    	//$total=ceil($rows/$limit);
    	
    	
?>
