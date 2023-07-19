<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

function getLnt($zip)
{
	//$url = "http://maps.googleapis.com/maps/api/geocode/json?address=
	//".urlencode($zip)."&sensor=false";
	$result_string = @file_get_contents($url);
	$result = json_decode($result_string, true);
	$result1[]=$result['results'][0];
	$result2[]=$result1[0]['geometry'];
	$result3[]=$result2[0]['location'];
	return $result3[0];
}

error_reporting(0);

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
 

  $theta = $lon1 - $lon2;

  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));

  $dist = acos($dist);

  $dist = rad2deg($dist);

  $miles = $dist * 60 * 1.1515;

  $unit = strtoupper($unit);

 

  if ($unit == "K") {
		
		$d_cal = $miles * 1.609344;
		$val = round($d_cal , 2);

    return $val;

  } else if ($unit == "N") {
		
		$d_cal = $miles * 0.8684;
		$val = round($d_cal , 2);

      return $val;

    } else {
		
		$val = round($miles , 2);

        return $val;

      }

}

function getDistance($zip1, $zip2, $unit)
{
	
	$first_lat = getLnt($zip1);
	$next_lat = getLnt($zip2);
	$lat1 = $first_lat['lat'];
	$lon1 = $first_lat['lng'];
	$lat2 = $next_lat['lat'];
	$lon2 = $next_lat['lng']; 
	
	$theta=$lon1-$lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
	cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
	cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	
	if ($unit == "K"){
	return ($miles * 1.609344)." ".$unit;
	}
	else if ($unit =="N"){
	return ($miles * 0.8684)." ".$unit;
	}
	else{
	return $miles." ".$unit;
	}
}
define(FB_APP_ID, '688073574590787');

if (isset($_SESSION['fb_' . FB_APP_ID . '_code'])) {
    unset ($_SESSION['fb_' . FB_APP_ID . '_code']);
}
if (isset($_SESSION['fb_' . FB_APP_ID . '_access_token'])) {
    unset ($_SESSION['fb_' . FB_APP_ID . '_access_token']);
}
if (isset($_SESSION['fb_' . FB_APP_ID . '_user_id'])) {
    unset ($_SESSION['fb_' . FB_APP_ID . '_user_id']);
}
if(isset($_SESSION['user_id']))
	{
		$sql_city_id=mysql_query("select * from  user where id='".$_SESSION['user_id']."'");
		$city_id2=@mysql_fetch_assoc($sql_city_id);
	}else
	{
		$city_id2 = array();
		$city_id2['zipcode']='38125';
	}
	if(isset($_SESSION['clubs_filter']))
	{
		$club_filter=$_SESSION['clubs_filter'];
		unset($_SESSION['clubs_filter']);
		$cnd=" parrent_id='0' AND  id IN(".$club_filter.")";
	}else
	{
		$cnd=" parrent_id='0'";
	}
if($_SESSION['miles'])
{
  $miles_filter=$_SESSION['miles'];
  unset($_SESSION['miles']);
}
// echo "select * from club_category where ".$cnd." ORDER BY name ASC";exit;
$sql_main_club=@mysql_query("select * from club_category where ".$cnd." AND non_member = '0' ORDER BY name ASC");


if($_POST['catid'] != "")
{
	$catid = $_POST['catid'];

	if(isset($_SESSION['miles']) && isset($_SESSION['longitude']) && isset($_SESSION['latitude']) && !isset($_SESSION['main_clubs_filter']) && !isset($_SESSION['inner_clubs_filter']))
	{

		$sql_clubs=@mysql_query("select * from  clubs where club_city='".$_SESSION['id']."' AND type_of_club='".$catid."' AND non_member = '0' ORDER BY club_name "); 

	/* if distance, from address, clubs selected */ 
	}
	elseif(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter']) && isset($_SESSION['miles']) && isset($_SESSION['longitude']) && isset($_SESSION['latitude']))
	{
		
		$inner_club_filter=$_SESSION['inner_clubs_filter'];
		$inner_cnd=" type_details_of_club IN(".$inner_club_filter.")";                          
		
		$sql_clubs=@mysql_query("select * from  clubs where ".$inner_cnd." AND non_member = '0' ORDER BY club_name ");

	/* if only clubs selected */ 
	}
	elseif(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter']) && !isset($_SESSION['miles']))
	{
			
		$inner_club_filter=$_SESSION['inner_clubs_filter'];
		$inner_cnd=" type_details_of_club IN(".$inner_club_filter.")";                          
		
		$sql_clubs=@mysql_query("select * from  clubs where ".$inner_cnd." AND non_member = '0' ORDER BY club_name");
		
	/* if normal user */ 
	}
	else
	{

		$sql_clubs=@mysql_query("select * from  clubs where club_city='".$_SESSION['id']."' AND type_of_club='".$catid."' AND non_member = '0' ORDER BY club_name "); 

	}
	while($rw_clubs=@mysql_fetch_assoc($sql_clubs)) 
	{

		$long1 = $city_id2['longitude'];
		$lat1 = $city_id2['latitude'];
		
		$long2 = $rw_clubs['longitude'];
		$lat2 = $rw_clubs['latitude'];
		
		$distancemiles = distance($lat1, $long1, $lat2, $long2, "M");
	   
		if(isset($miles_filter)) 
		{
			if($distancemiles <= round($miles_filter,2)) 
			{
			  
			  if($rw_clubs['non_member'] == 1){ ?>
			  
				<li>
				  <a onClick="javascript:void window.open('non_member_host.php?host_id=<?php echo $rw_clubs['id']; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"><?php echo ucfirst($rw_clubs["club_name"]);?></a>
				  
					<!-- <span class="miles">
						<?php //echo  $distancemiles." Miles"; ?>
					</span> -->
				</li>				
			  
			  <?php }else{ ?>
			  
				<li>   
					<a href="host_profile.php?host_id=<?php echo $rw_clubs["id"];?>"><?php echo ucfirst($rw_clubs["club_name"]);?></a>
					<!-- <span class="miles">
						<?php //echo  $distancemiles." Miles"; ?>
					</span> -->
				</li>			  
			  
			  <?php } ?>

<?php 
			} 
		} 
		else 
		{
		  
		  
			  if($rw_clubs['non_member'] == 1){ ?>
			  
				<li>
				  <a onClick="javascript:void window.open('non_member_host.php?host_id=<?php echo $rw_clubs['id']; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"><?php echo ucfirst($rw_clubs["club_name"]);?></a>
				  
					<!-- <span class="miles">
						<?php //echo  $distancemiles." Miles"; ?>
					</span> -->
				</li>				
			  
			  <?php }else{ ?>
			  
				<li>   
					<a href="host_profile.php?host_id=<?php echo $rw_clubs["id"];?>"><?php echo ucfirst($rw_clubs["club_name"]);?></a>
					<!-- <span class="miles">
						<?php //echo  $distancemiles." Miles"; ?>
					</span> -->
				</li>			  
			  
			  <?php } ?>		  
		  
<?php             }   
          } //ENDWHILE 
}
