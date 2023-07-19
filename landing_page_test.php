<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Get Best Deals for flight and hotel vacation packages";
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";
error_reporting(0);
if(isset($_GET['action']) && $_GET['action'] == 'logout')
{

	if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'club')
	{
		
		mysql_query("update clubs set is_online='0', keepmelogin = '0', streamingLaunch = '0',`streamingLaunchFrom` = '' where id='".$_SESSION['user_id'] ."'");

	} else {
		mysql_query("update user set is_online='0',keepmelogin = '0', streamingLaunch = '0',`streamingLaunchFrom` = '' where id='".$_SESSION['user_id'] ."'");

	}
	mysql_query("UPDATE `chat_users_groups` SET `loggedin` = '0' WHERE `user_id` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]' AND `loggedin` ='1'");

	session_destroy();
	unset($_SESSION['publicViewReport1']);
	$_SESSION['google_users_auth'] = "";
	$_SESSION['token_secret'] = ""; 
	$_SESSION['token'] = ""; 

	setcookie(session_name(), '', 100);
	
	if (isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie) {
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			setcookie($name, '', time()-1000);
			setcookie($name, '', time()-1000, '/');
		}
	}
	session_unset();
	$_SESSION = array();
	$_SESSION['registertype'] = '';
	$_SESSION['id'] = '51';
?>

<?php } ?>


<?php include("landingPage-header.php"); ?>

<?php

$get_city['city_id'] = $_SESSION['city_id'] ;
$_SESSION['id'] = $get_city['city_id'];

$get_city['city_name'] = $_SESSION['city_name'];

$postdata = $_SESSION['formatteds'];

if(isset($_SESSION['formatteds'])){


	  $dropdown_city = $postdata;

	}else if(!isset($_SESSION['city_id'])){

         $_SESSION['id'] = 51;

		 $city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
		 $get_city_name = mysql_fetch_assoc($city_name_query);
	  	 $dropdown_city = $get_city_name['city_name'];

    }

$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$dropdown_city = $get_city_name['city_name'];


$state_name_query = @mysql_query("select code,country_id,zone_id FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
$get_state_name = mysql_fetch_assoc($state_name_query);
$dropdown_state = $get_state_name['code'];

$LATITUDE = $get_city_name['lat'];
$LONGITUDE = $get_city_name['lng'];
$CITYID = $get_city_name['city_id'];
$_SESSION['state'] = $get_city_name['state_id'];
$_SESSION['country'] = $get_state_name['country_id'];

?>


<?php

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

if(isset($_POST['search']))

{

	if(isset($_POST['city_name']) || isset($_POST['city_name_jquery']))
	{
		if(!empty($_POST['city_name_jquery']))
		{
			$jquery_city = @mysql_query("SELECT city_id FROM capital_city WHERE state_id = '".$_POST['state']."' AND city_name = '".$_POST['city_name_jquery']."'");
			$jquery_city_rows = mysql_num_rows($jquery_city);
			if($jquery_city_rows == 1){
				$get_jquery_city_id = mysql_fetch_assoc($jquery_city);
				$city = $get_jquery_city_id['city_id'];
			}
			else
			{ 

	?>
				<script type="text/javascript">
						alert("city does not exist");
						window.location.href="";
				</script>
<?php 			die; 
			}
		}
		else
		{
			$city = $_POST['city_name'];
		}
		$user_type = $_SESSION['user_type'];
		$user_id = $_SESSION['user_id'];
		$d_city_status = $_POST['default_city'];
		$country = $_POST['country'];
		$state = $_POST['state'];
		if($d_city_status == 'on')
		{
			$check_d_city_status = @mysql_query("SELECT * FROM default_city_selected WHERE user_id = '".$user_id."' AND user_type = '".$user_type."'");
			$check_d_city_rows = mysql_num_rows($check_d_city_status);
			if($check_d_city_rows < 1){
				$insert_d_city = @mysql_query("INSERT INTO default_city_selected (`user_id`, `user_type`, `country`, `state`, `city`, `d_city_status`) VALUES ('".$user_id."', '".$user_type."', '".$country."', '".$state."', '".$city."', '".$d_city_status."')");
			}
			else{
				$update_d_city = @mysql_query("UPDATE default_city_selected SET `country` = '".$country."', `state` = '".$state."', `city` = '".$city."', `d_city_status` = '".$d_city_status."' WHERE user_id = '".$user_id."' AND user_type = '".$user_type."' ");
			}
		}

		if(trim($_POST['zipcode'])!="")
		{
			$zipcode = $_POST['zipcode'];
			$address = str_replace(" ", "", $zipcode);
			$url = "https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			$lat = $response_a->results[0]->geometry->location->lat;
			$long = $response_a->results[0]->geometry->location->lng;	
			$i = 0;

			foreach($response_a->results[0]->address_components as $abc)
			{
				if($abc->types[0] == "country")
				{
					$country = $response_a->results[0]->address_components[$i]->long_name;
				}
				if($abc->types[0] == "administrative_area_level_1")
				{

					$state = $response_a->results[0]->address_components[$i]->long_name;

				}
				if($abc->types[0] == "locality")
				{

					$city = $response_a->results[0]->address_components[$i]->long_name;

				}
				$i++;
			}

			$zip_city = "SELECT `city_id`,`city_name` FROM `capital_city` WHERE  `city_name`= '$city'   " ;
			$zip_city_Array = @mysql_query($zip_city);
			$num_rw=@mysql_num_rows($zip_city);
			if($num_rw > 0){

				$city_get=@mysql_fetch_array($zip_city_Array);

				$_SESSION['id']=$city_get['city_id'];

				$_SESSION['state']=$_POST['state']; 

				$_SESSION['country']=$_POST['country']; 

			}
		}
		else
		{

			$num_rw=1;

			if(!empty($_POST['city_name_jquery']))

			{
	

				$jquery_city = @mysql_query("SELECT city_id FROM capital_city WHERE state_id = '".$_POST['state']."' AND city_name = '".$_POST['city_name_jquery']."'");

				$jquery_city_rows = mysql_num_rows($jquery_city);

				if($jquery_city_rows == 1)

				{

					$get_jquery_city_id = mysql_fetch_assoc($jquery_city);

					$_SESSION['id'] = $get_jquery_city_id['city_id'];

					$_SESSION['country']=$_POST['country'];

					$_SESSION['state']=$_POST['state'];

				}

				else

				{

		?>

<script type="text/javascript">

						alert("city does not exist");

						window.location.href="";

					</script>

<?php 				die; 

				}

							

			}

		}

	}

	unset($_COOKIE["backgroundcookie"]);

	setcookie('backgroundcookie', null, -1, '/');

	$cityid = $_SESSION['id'];

	$getcityname = @mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '".$cityid."' ");

	$fetchcity = @mysql_fetch_array($getcityname);

	$city = trim($fetchcity['city_name']);

	$city_sel = @mysql_query("SELECT city_image_id FROM refresh_background WHERE city_name = '".$city."' AND refresh_status = '1' ORDER BY RAND() LIMIT 0,1");

	$count_img = mysql_num_rows($city_sel);

	if($count_img > 0)

	{

		$rowwww = mysql_fetch_assoc($city_sel);

		$set_image = @mysql_query("SELECT city_image_url FROM capital_city_images WHERE city_image_id = '".$rowwww['city_image_id']."'");

		$get_data = mysql_fetch_assoc($set_image);

		$imagesrcback =  "/admin/cities/".$get_data['city_image_url'];

		?>

<?php

		$intervalq = @mysql_query("SELECT * FROM `refresh_background_time`");

		$intervalf = @mysql_fetch_array($intervalq);
		ob_start();

		setcookie("backgroundcookie", $imagesrcback,time() + (60 * $intervalf['time_interval'] ) );

		ob_end_clean();

	}

}

/* END TOP SEARCH CODE */

/* FACEBOOK LOGIN CODE */
include 'login/facebook.php';
$appid      = "1027910397223837";
$appsecret  = "00175be1ff4053b4cb22bca7b51b947a";

$facebook   = new Facebook(array(
	'appId' => $appid,
	'secret' => $appsecret,
	'cookie' => TRUE,
));
$fbuser = $facebook->getUser();
if ($fbuser) 
{
	try 
	{
		$user_profile = $facebook->api('/me');
	}
	catch (Exception $e)
	{
		$facebook->destroySession();
		error_log($e);
		$fbuser = null;
	}

	$user_fbid  = $fbuser;
	$user_email = $user_profile["email"];
	$user_fnmae = $user_profile["first_name"];
	$user_lnmae = $user_profile["last_name"];
	$user_image = "https://graph.facebook.com/".$user_fbid."/picture?type=large";
	$profileimagename = $user_fnmae."_test.jpg";
	$profilename = $user_fnmae.$user_lnmae;
	
	if($user_email == '')
	{
		$Obj->Redirect('main/logout.php');
		die;
	}

	$path = "upload/".$profileimagename;
	if(!file_exists($path))
	{
		copy($user_image,$path);
	}

	$sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
	$sql1 = "SELECT * FROM `clubs` WHERE club_email = '".$user_email."' ";
	$getemailquery = @mysql_query($sql);
	$getemailquery1 = @mysql_query($sql1);
	$countemail = @mysql_num_rows($getemailquery);
	$countemail1 = @mysql_num_rows($getemailquery1);
	$today = date("Y-m-d h:i:s");
	if($countemail > 0 || $countemail1 > 0 )
	{
		if($countemail > 0)
		{
			$sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
			$DataArray = $Obj->select($sql) ;
			$username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
			$UserLoginId = $DataArray[0]['id'];
			$_SESSION['user_id'] = $UserLoginId ; 
			$_SESSION['username'] = $profilename ;
			$_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];
			$_SESSION['keepmelogin'] = '0';
			$_SESSION['user_type'] = 'user';
			$_SESSION['img'] =  $DataArray[0]['image_nm'] ;
			
			$_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
			$_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
			$_SESSION['country']=$DataArray[0]['country'];
			$current_time= date('Y-m-d H:i:s'); 
			$tdate=date('Y-m-d H:i:s');
			mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
			session_write_close();

			if(isset($_SESSION['redirect_to']) && $_SESSION['redirect_to'] != '')
			{
				$Obj->Redirect($_SESSION['redirect_to']);
				unset($_SESSION['redirect_to']);
				exit;
			}
			else
			{
				$Obj->Redirect("searchEvents.php");
				exit;
			}
		}
		elseif($countemail1 > 0)
		{
			$sql = "SELECT * FROM `clubs` WHERE club_email = '".$user_email."' ";
			$DataArray = $Obj->select($sql) ;
			$username = $DataArray[0]['club_name'];
			$UserLoginId = $DataArray[0]['id'];
			$_SESSION['user_id'] = $UserLoginId ; 
			$_SESSION['username'] = $profilename ;
			$_SESSION['profile_name'] = $DataArray[0]['club_name'];
			$_SESSION['keepmelogin'] = '0';
			$_SESSION['user_type'] = 'club';
			$_SESSION['img'] =  $DataArray[0]['image_nm'] ;
			
			$_SESSION['id']=$DataArray[0]['club_city'];// here we are storing city id of logged user
			$_SESSION['state']=$DataArray[0]['club_state']; // here we are storing state id of logged user
			$_SESSION['country']=$DataArray[0]['country'];
			$current_time= date('Y-m-d H:i:s'); 
			$tdate=date('Y-m-d H:i:s');
			mysql_query("update clubs set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
			session_write_close();
			if(isset($_SESSION['redirect_to']) && $_SESSION['redirect_to'] != '')
			{
				$Obj->Redirect($_SESSION['redirect_to']);
				unset($_SESSION['redirect_to']);
				exit;
			}
			else
			{
				$Obj->Redirect("searchEvents.php");
				exit;
			}
		}
	}
	else
	{
		$ValueArray = array($profilename,$path,'facebook',$user_fnmae,$user_lnmae,$user_email,'','','','','','','1',$today,'','','free','','');
		$FieldArray = array('profilename','image_nm','hear_about','first_name','last_name','email','password','phone','user_address','country','state','zipcode','status','regi_date','DOB','city','plantype','longitude','latitude');     
		$Success = $Obj->Insert_Dynamic_Query('user',$ValueArray,$FieldArray);
		$sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
		$DataArray = $Obj->select($sql) ;
		
		$UserLoginId = $DataArray[0]['id'];
		$username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
		$_SESSION['user_id'] = $UserLoginId ; 
		$_SESSION['username'] = $username ;
		$_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];
		$_SESSION['keepmelogin'] = '0';
		$_SESSION['user_type'] = 'user';
		$_SESSION['img'] =  $DataArray[0]['image_nm'] ;
		
		$_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
		$_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
		$_SESSION['country']=$DataArray[0]['country'];
		$current_time= date('Y-m-d H:i:s'); 
		$tdate=date('Y-m-d H:i:s');
		mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
		session_write_close();
	
		if(isset($_SESSION['redirect_to']) && $_SESSION['redirect_to'] != '')
		{
			$Obj->Redirect($_SESSION['redirect_to']);
			unset($_SESSION['redirect_to']);
			exit;
		}
		else
		{
			$Obj->Redirect("searchEvents.php");
			exit;
		}
	}
}

/* END FACEBOOK LOGIN CODE  */
/* GOOGLE LOGIN CODE */

include 'directlogin.php';

if(!isset($authUrl))
{
	$user_email = $user['email'];
	$user_fnmae = $user['given_name'];
	$user_lnmae = $user['family_name'];
	$profileimagename = $user['given_name'].$user['family_name']."_test.jpg";
	$path = strtotime(date('Y-m-d H:i:s'))."upload/".$profileimagename;
	$_SESSION['socialtype'] = "user";
	if(!file_exists($path))
	{
	  	copy($profile_image_url,$path);
	}
	if(!empty($user_email))
  	{
		$sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
		$getemailquery = @mysql_query($sql);
		$countemail = @mysql_num_rows($getemailquery);
		$today = date("Y-m-d h:i:s");
		if($countemail > 0 ) 
		{
			$sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
			$DataArray = $Obj->select($sql) ;
			$username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
			$UserLoginId = $DataArray[0]['id'];
			$_SESSION['user_id'] = $UserLoginId ; 
			$_SESSION['username'] = $username ;
			$_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];
			$_SESSION['keepmelogin'] = '0';
			$_SESSION['user_type'] = 'user';
			$_SESSION['img'] =  $DataArray[0]['image_nm'] ;

			$_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
			$_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
			$_SESSION['country']=$DataArray[0]['country'];
			unset($_SESSION['token']);
			$current_time= date('Y-m-d H:i:s'); 
			$tdate=date('Y-m-d H:i:s');
			mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
			session_write_close();
			$Obj->Redirect("profile.php");
			exit;
		}
		else
		{
			$sql = "INSERT INTO `user` (`image_nm`,`hear_about`,`first_name`,`last_name`,`email`,`street`,`password`,`phone`,`user_address`,`country`,`state`,`zipcode`,`status`,`regi_date`,`DOB`,`city`,`plantype`,`longitude`,`latitude`) 
			VALUES ('".$path."','facebook','".$user_fnmae."','".$user_lnmae."','".$user_email."','','','','','','','','1','".$today."','','','free','','') ";
			@mysql_query($sql);

			$sql1 = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
			$DataArray = $Obj->select($sql1) ;

			$UserLoginId = $DataArray[0]['id'];
			$username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
			$_SESSION['user_id'] = $UserLoginId ; 
			$_SESSION['username'] = $username ;
			$_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];
			$_SESSION['keepmelogin'] = '0';
			$_SESSION['user_type'] = 'user';
			$_SESSION['img'] =  $DataArray[0]['image_nm'] ;

			$_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
			$_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
			$_SESSION['country']=$DataArray[0]['country'];
			unset($_SESSION['token']);
			$current_time= date('Y-m-d H:i:s'); 
			$tdate=date('Y-m-d H:i:s');
			mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
			session_write_close();
			$Obj->Redirect("profile.php");
			exit;
		}
	}
}

require 'instagram/instagram.class.php';
require 'instagram/instagram.config.php';

$instaURL = $instagram->getLoginUrlInsta();
?>

<?php

				$d_category = "9";

				$fetchEventCategoryName['catname'] = 'Nightlife';

				$Heading = '';

				$condition = " AND event_category = '9' ";

				$eventname = "";

				$eventimage = "9.jpg";

				$default = "";

				if(isset($_POST['ssss']))

				{


					if(!empty($_POST['keyword_search']) && empty($_POST['eventcat']))
					{

						$myCondition = " `forum` LIKE '%$_POST[keyword_search]%' ";
						$Heading = 'Search Results';

					}
					elseif(!empty($_POST['keyword_search']) && !empty($_POST['eventcat']))
					{
						$event_category = $_POST['eventcat'];
						
						$myCondition .= " AND `event_category` = ".$event_category;
						$Heading = 'Search Results';
					}
					elseif(empty($_POST['keyword_search']) && !empty($_POST['eventcat']))
					{
						$eventname = "";

						$event_category = $_POST['eventcat'];

						$myCondition = " `event_category` = ".$event_category;

						$condition = " AND event_category = '$event_category' ";

						$getEventsCategoryName = mysql_query("SELECT * FROM `eventcategory` WHERE `id` = '$event_category' ");

						$fetchEventCategoryName = mysql_fetch_assoc($getEventsCategoryName);

						if($_POST['date_s'] != "")

						{

							$DATE = explode("-",$_POST['date_s']);

							$event_date = $DATE['2']."-".$DATE['0']."-".$DATE['1'];
							$myCondition .= " AND event_date LIKE '%$event_date%' ";
							$condition .= " AND event_date LIKE '%$event_date%' ";

						}
					}
					elseif(empty($_POST['keyword_search']) && empty($_POST['eventcat']))
					{
						$eventname = "";

						$condition = " AND event_category = '$event_category' ";

						$getEventsCategoryName = mysql_query("SELECT * FROM `eventcategory` WHERE `id` = '$event_category' ");

						$fetchEventCategoryName = mysql_fetch_assoc($getEventsCategoryName);

						if($_POST['date_s'] != "")

						{

							$DATE = explode("-",$_POST['date_s']);

							$event_date = $DATE['2']."-".$DATE['0']."-".$DATE['1'];
							$myCondition = " event_date LIKE '%$event_date%' ";
							$condition .= " AND event_date LIKE '%$event_date%' ";

						}
					}
					
					$eventSearchSql = 'SELECT * FROM `forum` WHERE '.$myCondition.' GROUP BY `forum`, `event_date`  ORDER BY `forum` DESC,`event_date` ';
					$countsearcSQl = mysql_num_rows(mysql_query($eventSearchSql));
					$EventCatSQL = 'SELECT * FROM `forum` WHERE '.$myCondition.' GROUP BY `forum`, `event_date`  ORDER BY `forum` DESC,`event_date` ';
					$eventimage = $event_category.".jpg";

				}

				elseif(isset($_GET['c']))

				{

					$event_category = $_GET['c'];

					$condition = " AND event_category = '$event_category' ";

					$eventimage = $event_category.".jpg";		

					$getEventsCategoryName = mysql_query("SELECT * FROM `eventcategory` WHERE `id` = '$event_category' ");

					$fetchEventCategoryName = mysql_fetch_assoc($getEventsCategoryName);

				}

				else
				{

					$event_category = '9';

					$eventimage = $event_category.".jpg";		

					$getEventsCategoryName = mysql_query("SELECT * FROM `eventcategory` WHERE `id` = '$event_category' ");

					$fetchEventCategoryName = mysql_fetch_assoc($getEventsCategoryName);

				}

				if($event_date == "")

				{

					$event_date = date('Y-m-d H:i:s');  

					$condition .= " AND `forum`.`event_date` > '$event_date'";

				}

				$DATE = date('Y-m-d');
				$checkcontest = mysql_query("SELECT * FROM `contest` WHERE `contest_status` = 'enable' AND `contest_end` > '$DATE' ");
				$countContest = mysql_num_rows($checkcontest);
			?>

<!-- New seacrh bar php code end    -->

	<body>
		<input type="hidden" value="<?php echo $SiteURL; ?>" id="siteURL" />
		<div class="">
		
		<header>
			<div class="container-fluid main-header">
				<div class="container">
					<div class="">
						<div class="col-sm-1 col-xs-6 logo">
							<a href="https://mysitti.com/index.php"><img src="images/v2_logo_round.png" alt="My sitti"/></a>
						</div>
						<div class="col-sm-2 col-xs-6 search-box">
							<div class="select-city" id="Search_box_filter">
								<form name="user_serach" action="" method="POST" id="topsearchform" >
								<?php 
									$countrysql="select country_id,name from country where country_id IN(223,38)";
									$country_list = mysql_query($countrysql);
								?>

								<p>
									<select class="option-1" name="country" id="country" onChange="showState_new(this.value);">
										<option value="">------- Select -------</option>

										<?php

											while($row = mysql_fetch_array($country_list))

											{

												if($row["country_id"] == $_SESSION['country'])

												{

										?>

													<option selected="selected" value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>

										<?php

												}

												else

												{

										?>

													<option value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>

										<?php

												}

											}

										?>

										</select>

									</p>

									<p>

									<?php

										$countrysql1="select zone_id,name from zone where country_id IN(".$_SESSION['country'].") and status ='1'";

										$country_list1 = mysql_query($countrysql1);
										

										$state_arr = array();
										

										while($row1 = mysql_fetch_array($country_list1)){
											

											$state_arr[] = $row1["name"];

											
												if($_SESSION['state']==$row1["zone_id"]) {

												  
												  $set_state_name = $row1["name"];

												  $set_state_id = $row1["zone_id"];
												  
												  }			

										}

										$s_key = array_search($set_state_name , $state_arr);

										$encoded_state_list = json_encode($state_arr);

										?>


										

										<input id="state" type="hidden" name="state" value="<?php echo $set_state_id; ?>">

										<div id='jstate_name'></div>	

									</p>

									<p>

									<?php

											if(isset($_SESSION['state']) && $_SESSION['state'] != '')

											{

												$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) where c.state_id ='".$_SESSION['state']."' order by c.city_name"; 

											}

											else

											{

												$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) order by c.city_name";

											}

											$city_list1 = mysql_query($allcity);


											$city_arr = array();
											

											while($row_city = mysql_fetch_array($city_list1))

											{

												if(strlen($row_city["city_name"]) > 2 && $row_city["city_name"] != "" && $row_city["city_name"] != " ")

												{

													$city_arr[] = $row_city["city_name"];



													if($_SESSION['id']==$row_city["city_id"]) {

													  

													  $set_city_name = $row_city["city_name"];

													  

													  }


													if($_SESSION['id'] == $row_city["city_id"]) { ?>

														<input type="hidden" name="city_name" value="<?php echo $row_city["city_id"]; ?>">

														<input type="hidden" name="city_name123" value="<?php echo $row_city["city_name"]; ?>">

									<?php 				}

												}

											

											}

											$c_key = array_search($set_city_name , $city_arr);

											$encoded_list = json_encode($city_arr);

									?>

										<div id='jcity_name'></div>

									</p>

									<p>

										<input class="option-2" id="zipcode" name="zipcode" placeholder="Zip Code" type="text" value="<?php echo $_POST['zipcode']; ?>" >

									</p>

									<p>

										<input type="checkbox" value="" name="default_city" id="default_city">
										<span class="setdefault">Set as default city</span>

									</p>

									<p>
										<input type="button" class="button" value="Switch City" onclick="validate_city_Form();" name="search" id="submit">

									</p>

								</form>
						</div>
					</div>
					<meta name="description" content="Mysitti offers best cheap vacation destinations & cheap vacation spots for honeymoon. Book your vacation from several cheap vacation packages international available.">
					<meta name="keywords" content="cheap vacation packages international , flight and hotel vacation packages , best cheap vacation destinations, cheap vacation spots for honeymoon, cheap luxury vacation destinations ">
					   <meta name="p:domain_verify" content="b812800cc41cd2b103f606bbda379e5b"/>
						<div class="col-sm-9 col-xs-6 tranparent">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                         
                                    <!-- <li>
                                    	<div class="dropdown-main">
										  <p class="activities">Home</p>
										  <div class="dropdown-content-main">
										   <a href="<?php echo $SiteURL;?>index.php">Home</a>
										   <a href="<?php echo $SiteURL;?>comedy.php">Comedy</a>
										    <a href="<?php echo $SiteURL;?>brewery.php">Wine & Brewery</a>
										    <a href="<?php echo $SiteURL;?>handpicked-restaurant.php">Handpicked Restaurants</a>
										    <a href="<?php echo $SiteURL;?>concert.php">Concerts</a>
										    <a href="<?php echo $SiteURL;?>allSports.php">Sports</a>
										    <a href="<?php echo $SiteURL;?>family.php">Family</a>
										    <a href="<?php echo $SiteURL;?>allhoteldeals.php">Hotels Deals</a>
										    <a href="<?php echo $SiteURL;?>performing-arts.php">Performing Arts</a>
										    
											<a href="<?php echo $SiteURL;?>genre-rock.php">Rock</a>
											<a href="<?php echo $SiteURL;?>genre-blues.php">Blues</a>
										    <a href="<?php echo $SiteURL;?>genre-country.php">Country</a>
										    <a href="<?php echo $SiteURL;?>genre-jazz.php">Jazz</a>
							
										   </div>
										</div>
                                    </li> -->
                                    
                                    <li><a href="<?php echo $SiteURL; ?>index.php">Home</a></li>
                                    <li><a href="<?php echo $SiteURL; ?>hotels/index.php">Hotels</a></li>
 									<li><a href="<?php echo $SiteURL; ?>flight/index.php">Flights</a></li>
 									<li><a href="<?php echo $SiteURL;?>car-rentals.php">Car Rentals</a></li>
                                    <li><a href="<?php echo $SiteURL;?>restaurant-deals.php">Restaurants</a></li>

                                    <!-- <li><a href="<?php echo $SiteURL;?>yelp-tour.php">Tours</a></li> -->

                                    <li><a href="<?php echo $SiteURL;?>yelp-tour.php">Things To Do</a></li>
                                    
                                    <li><a href="<?php echo $SiteURL;?>city-guide.php">Audio Tours</a></li>
                                    <li><a href="<?php echo $SiteURL;?>destination.php">Destinations</a></li>
                                    <li><a href="<?php echo $SiteURL;?>/blog">Blogs</a></li>
                                    <!-- <li><a href="homestay.php">Vacation Rentals</a></li> -->
                                   
                                </ul>
                            </div>
                        </nav>

                    </div>
                         <?php if(!isset($_SESSION['user_id'])) { ?>
                    	<div class="col-sm-2 col-xs-6 log-n">
	                        <div class="log-in-new">
	                            
	                            <label for="login" id="v2_log_in">Log In</label>
	                            <input type="checkbox" id="login">
	                          
	                            <input type="button" id="hidden_id" onclick="show_login_popop('first');" value="Join For Free" class="join-now-new signup">

	                        </div>
                            <div class="tooltip-box" style="display: none;">
                              <!-- <span class="cross-icons" id="cross-ico"><img src="images/cross-icon.png"></span> -->
                            	<span class="get_deals">Get Deals</span>
                            	<span class="plan-fst">Plan Faster. Plan Smarter!</span>
                                
                                <div class="fb-login"><div class="fb-login-button" data-max-rows="1" data-size="medium" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div></div>
                            	
                            	<p class="create-account" onclick="show_login_popop('first');">Create an account</p>
                            	<div class="accoust">
                            		<p class="already-accnt">Already Have an account?</p>
                            		<label for="login" id="v2_log_in">Sign In</label>
                            	</div>

                            </div>
                        </div>
                        <?php } else { ?>
                       <div class="v2_profile_user profilrForDesktop">
                      <?php
                        if($_SESSION['user_type'] == "user")
                        {
                          $linkProfile = "profile.php";
                          $profilename = $loggedin_user_data['profilename'];
                        }
                        else
                        {
                          $linkProfile = "home_club.php";
                          $profilename = $loggedin_host_data['club_name'];
                        }

                        if($_SESSION['user_type'] == 'club')
                        {

                        $host_query = mysql_query("SELECT * FROM clubs WHERE id = '".$_SESSION['user_id']."'");

                        $loggedin_host_data = mysql_fetch_assoc($host_query);

                        $userID = $_SESSION['user_id'];
                        $displayImage = $loggedin_host_data['image_nm'];
                        
                        }

                      ?>
                          <div class="v2_thumb_user_profile user_profile_host2"> 
                            <a href="https://mysitti.com/user_profile.php">
                            <?php if($_SESSION['user_type'] == 'club'){ ?>
                              <img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$displayImage;} ?>" alt="user">
                            <?php } else { ?>
                              <img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$_SESSION['img'];} ?>" alt="user">
                            <?php } ?>
                            </a> 
                          </div>
                          <div class="dropdown">
                          <div class="dropbtn_profile v2_profile_user_info user_info_host2"> <span class="v2_welcome_user">Welcome</span>
                            <div class="clear"></div>
                            <span class="v2_user_name"> <a href="<?php //echo $SiteURL.$linkProfile; ?>https://mysitti.com/user_profile.php">
                            <?php 
                            if($_SESSION['user_type'] == 'user'){
                              $pget = mysql_query("SELECT profilename FROM user WHERE id = ".$_SESSION['user_id']."");
                              $cnma = mysql_fetch_array($pget);
                              $profilename = $cnma['profilename'];
                            } else {
                              $pget = mysql_query("SELECT club_name FROM clubs WHERE id = ".$_SESSION['user_id']."");
                              $cnma = mysql_fetch_array($pget);
                              $profilename = $cnma['club_name'];
                              }
                              $out = strlen($profilename) > 18 ? substr($profilename,0,18)."..." : $profilename;
                              echo $out; ?>
                            </a> </span> 
                          </div>
                          <div class="dropdown-content-profile">
									   <!-- <a href="<?php //echo $SiteURL; ?>learn-more.php">Information</a>
					                   <a href="<?php //echo $SiteURL; ?>support.php">Help</a> -->
					                   <a href="<?php echo $SiteURL; ?>user_profile.php">Profile</a>
					                   <a href="<?php echo $SiteURL; ?>main/logout.php">Logout</a>
					                </div>
						</div>	
                      </div>
                      <?php } ?>
					</div>
				</div>
				</div>
				
			</header>  

			<section>
              <div class="home-banner">
               <?php 
				$getUserdata2 = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'User' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC ");

				$getUserdata21 = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'Artist' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC ");
				$getpagedata = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'Artist' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC ");
				$fetchPagedata = mysql_fetch_assoc($getpagedata);
				
					?>
				<div class="battleTv newMysittiBlock">
					<div id="mainPagevideoPlayer"></div>
					<input type="hidden" id="playVideoname" value="<?php echo str_replace("../", "", $fetchPagedata['video_path']);?>">
					
				</div>
              <div class="overlayNewHeader">
              	<ul class="bxslider_banner">
              	
              	<?php 
              		$getI = mysql_query("SELECT * FROM banner_images ORDER BY id DESC");
  
              		while ($newget = mysql_fetch_array($getI))
              		 { ?>
              			<li><img src="<?php echo $newget['image_path']; ?>" alt="<?php echo $newget['image_name']; ?>" /></li>
              	<?php	}	?> 

				</ul>
              </div>

                  <div class="container home-page-con">
                    <div class="text-center">
                      
                       <p>
                      Plan a Vacation. Plan a Night Out. </br> Plan Smarter!
                       </p>
                  			
                  		 <div class="CurrentCity citytalk_page">
							<div class="innerCurrentCity1">
								<div class="search_filtering" id="panel">
								<input id="target-hide" type="hidden" class="geo geocontrast"  value="<?php echo $dropdown_city; ?>" required>

							   <input id="target" type="text" class="geo geocontrast" placeholder="Let us help you?" value="<?php //echo $_SESSION['city_name'];?>"  required>
							 
							   <div id="map-canvas"></div>
								<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton"> 
							</div>

						</div>
					</div>
	
                    </div> 
                    	
			      </div>
			     
              </div> 
              <div id="loader"></div>
           </section>
    			<div id="v2_sign_up_after" class="v2_sign_up open" style="display: none;">
				<h1>Sign Up Here</h1>
				<a class="v2_close_signup" href="javascript:void(0);">close</a>
				<div class="clear"></div>
				<div class="v2_signup_tabcontainer"> 
					<!-- Tab panes -->
					<div class="v2_tab_content">
					
					<div id="user">
					<form action="paymentoption.php" method="post" class="tab_standerd v2_user_reg" id="signupd" name="signupd" autocomplete="off" novalidate>
						
							<div class="clear"></div>
							<div id="hostFieldsBlock" style="display: none;"> 
								<p id="profilesName">
									<input type="text" required placeholder="Profile or Business Name" onblur="return ChkUserProfile(this.value,'user','https://mysitti.com/');" name="profilename" autocomplete="off" style="margin-top:5px;">
								</p>
								<p id="hostsFields">
									<select required="" name="host_category" id="host_category" style="margin-top:5px; ">
										<option value="">Select type of Business</option>
										<option value="108">Artist</option>
										<option value="91">Bar</option>
										<option value="92">Club</option>
										<option value="103">Fight</option>
										<option value="106">Fighter</option>
										<option value="107">Promoter</option>
										<option value="109">Promoter Artist</option>
										<option value="1">Restaurants</option>
										<option value="191">Rock</option>
										<option value="102">Theatre</option>
										<option value="104">Wedding</option>
									</select>
								</p>
							</div>
						<p>
							<input type="text" autocomplete="off" required placeholder="Email Address" onblur="return ChkUserId(this.value,'user','https://mysitti.com/');" name="email">
						</p>
						
						<div class="clear"></div>
						<p>
							<input type="password" required placeholder="Password" id="password" name="password" autocomplete="off">
						</p>
						<p>
							<input type="password" required placeholder="Confirm Password" name="cpassword" autocomplete="off">
						</p>
						<div class="clear"></div>
												  	
						<div class="clear"></div>
						
							<div class="agreementTerms aboutYou">
							<div class="span">
								<input type="checkbox" value="1" id="acknowledgement" name="acknowledgement">
								<p class="term_policy">By clicking Sign Up, you agree to our <a onclick="javascript:window.open('terms_conditions.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Terms & Conditions</a> and <a onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Privacy Policy</a>. You may receive email notification from MySitti.com, but you can choose to opt out at any time.</p> 
							</div>
							</div>
						<div class="clear"></div>
						<input type="hidden" name="plantype" value="free">
						<input type="hidden" id="planid" name="planid" value="1">
						<input type="hidden" id="userTYPE" name="UserType" value="">
						<input type="submit" value="Sign Up" name="submit">
					</form>
					<div class="social_signup" style="display:block;">
					   <span class="elseLogin">OR  </span> 
				   
					<span class="socialIconLogin"><label>Sign Up With</label> <br /><a onclick="FBLogin();" href="javascript:void(0);"><img alt="Login from Facebook" src="images/facebook1.png"></a>

					<?php 
					if(isset($authUrl)) 
					{
					?>
					<a href="<?php echo $authUrl; ?>" target="blank"><img alt="Login from Google Plus" src="images/googleplus1.png"></a>
				    <?php	} 	?>

					<a href="<?php echo $instaURL;?>"><img src="instagram.png" alt=""></a></span>
					</div>
				</div>
			</div>
			</div>
	</div>

<link rel="stylesheet" href="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php echo $SiteURL;?>jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />

<div class="v2_signup_overlay" style="display: none;"></div>
<div class="v2_log_in">

			<h1>Login</h1>

			<a href="javascript:void(0);" class="v2_close_signup">close</a>

		  <div class="ve_login_container">
		 <style type="text/css">
		 	a#loginLogo:hover
		 	{
		 		box-shadow: none !important;
		 	}
		 </style>
		  <div class="v2_login_brand">
		  	<a href="<?php echo $SiteURL;?>index.php" id="loginLogo">
		  		<img src="images/v2_logo_round_1.png" alt="">
		  	</a>
		  </div>

		  <div class="clear"></div>

		  <div class="v2_login_key">

			<?php if(isset($_GET['msg']) && $_GET['msg'] == 'error1'){ ?>

				<div class="V2_login_error">Please enter correct email and password to login</div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
				<script type="text/javascript">
				$(document).ready(function() {
					var inputID = $(this).find("label").attr("for");
					 setTimeout(function() {
					   $("#"+inputID).trigger('click');
					   },4000); 
					});
					
				</script>
			<?php } ?>

			<form id="mainlogin" name="login" action="<?php echo $SiteURL;?>main/login.php" method="POST">

		  			<p>

					  <input type="text" name="uname"  placeholder="Email Address" required>

					</p>

					<div class="clear"></div>

					<p>

					  <input type="password" name="password" id="password2" placeholder="Password" required>

					</p>

					<p>

					 <div class="clear"></div>

					

					<input type="submit" name="submit" value="Login">

					</p>

			</form>
				<div class="clear"></div>
		  </div> <p><a href="<?php echo $SiteURL; ?>forget_pwd.php">Forgot Password</a></p>

		  <p class="cleataccount">Don't have a MySitti account?  <a href="#" onclick="show_login_popop(); return false;">Sign up now</a>
		  <div class="socialmedia">
		  <a onclick="FBLogin();" href="javascript:void(0);" target="blank"> <img alt="Login from Facebook" src="images/facebook1.png"></a>
		   <a href="<?php echo $instaURL; ?>" target="_blank"> <img src="instagram.png"> </a>
		<?php 	
		include 'directlogin.php';
		if(!isset($authUrl))
		{
			$user_email = $user['email'];
			$user_fnmae = $user['given_name'];
			$user_lnmae = $user['family_name'];
			$profileimagename = $user['given_name'].$user['family_name']."_test.jpg";

			$path = strtotime(date('Y-m-d H:i:s'))."upload/".$profileimagename;
			$_SESSION['socialtype'] = "user";
			if(!file_exists($path))
			{
				copy($profile_image_url,$path);
			}
			if(($_SESSION['socialtype'] == 'user')  )
			{
				if($user_email != "")
				{
					
					$sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
					$getemailquery = @mysql_query($sql);
					$countemail = @mysql_num_rows($getemailquery);
					$today = date("Y-m-d h:i:s");
					if($countemail > 0 ) 
					{
						
				
						$sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
						$DataArray = $Obj->select($sql) ;
						$username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
						$UserLoginId = $DataArray[0]['id'];
						$_SESSION['user_id'] = $UserLoginId ; 
						$_SESSION['username'] = $username ;
						$_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];
						$_SESSION['keepmelogin'] = '0';
						$_SESSION['user_type'] = 'user';
						$_SESSION['img'] =  $DataArray[0]['image_nm'] ;

						$_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
						$_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
						$_SESSION['country']=$DataArray[0]['country'];
						unset($_SESSION['token']);
						
						$current_time= date('Y-m-d H:i:s'); 
						$tdate=date('Y-m-d H:i:s');
						
						mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
						

						session_write_close();
						$Obj->Redirect("profile.php");
						exit;
					}
					else
					{
						
						$sql = "INSERT INTO `user` (`image_nm`,`hear_about`,`first_name`,`last_name`,`email`,`street`,`password`,`phone`,`user_address`,`country`,`state`,`zipcode`,`status`,`regi_date`,`DOB`,`city`,`plantype`,`longitude`,`latitude`) 
						VALUES ('".$path."','facebook','".$user_fnmae."','".$user_lnmae."','".$user_email."','','','','','','','','1','".$today."','','','free','','') ";
						@mysql_query($sql);

						$sql1 = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
						$DataArray = $Obj->select($sql1) ;

						$UserLoginId = $DataArray[0]['id'];
						$username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
						$_SESSION['user_id'] = $UserLoginId ; 
						$_SESSION['username'] = $username ;
						$_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];
						$_SESSION['keepmelogin'] = '0';
						$_SESSION['user_type'] = 'user';
						$_SESSION['img'] =  $DataArray[0]['image_nm'] ;

						$_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
						$_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
						$_SESSION['country']=$DataArray[0]['country'];
						unset($_SESSION['token']);
				
						$current_time= date('Y-m-d H:i:s'); 
						$tdate=date('Y-m-d H:i:s');
						
						mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
				
						session_write_close();
						$Obj->Redirect("profile.php");
						exit;
					}
				}  
			}
		}
			if(isset($authUrl)) //user is not logged in, show login button
			{
		?>
				<a href="<?php echo $authUrl; ?>" target="blank"><img alt="Login from Google Plus" src="images/googleplus1.png"></a>
  <?php                       	} 	?>
		  </div>
		  </div> </div><div class="v2_login_overlay"></div>
			
			</div>
				</div>
			</div><!--banner closed-->
			
			<div class="container video-section">
				<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 video-b" style="display: none;">
					
					<?php 
				$getUserdata2 = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'User' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC ");

				$getUserdata21 = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'Artist' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC ");
				$getpagedata = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'Artist' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC ");
				$fetchPagedata = mysql_fetch_assoc($getpagedata);
				
					?>
				<div class="battleTv newMysittiBlock">
					<div id="mainPagevideoPlayer"></div>
					<input type="hidden" id="playVideoname" value="<?php echo str_replace("../", "", $fetchPagedata['video_path']);?>">
					<video width="400" controls id="tv_main_channel" >
						<source type="video/mp4" src="<?php echo str_replace("../", "", $fetchPagedata['video_path']);?>" id="mp4Source"></source>
					</video>
				</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 new-home">
					<div class="host selected-landing-tab">
					<div class="TablListBlock">
						<h2>Host</h2>
<?php 
					$getUserdata1 = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'Artist' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC  LIMIT 1 ");
					$getUserdata12 = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'Artist' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC  ");
					$r1 = mysql_fetch_assoc($getUserdata1);
					echo $r1['content_text'];
				?>
					</div>
					<input type="hidden" id="artistTabVideo" value="<?php echo str_replace("../", "", $r1['video_path']);?>" >
						<ul class="artistTablist" style="display:none;">
					<?php 
							$t = 0;
							while($r31 = mysql_fetch_assoc($getUserdata12))
							{
								if(!empty($r31['video_path']))
								{
									$exp = $r31['video_path'];
									if(!empty($exp))
									{
								?>
										<li class='<?php if($t == '0'){ echo "active";} ?>' id='play_<?php echo $t;?>'> <a href="<?php echo str_replace("../", "", $exp); ?>" id='video_<?php echo $t;?>' > <?php echo $exp; ?> </a> </li>
					<?php			}
									$rs++;
								}
							}
							?>
						</ul>
					</div>
					<div class="clearfix"></div>
						
					<div class="user">
						<div class="TablListBlock">
						<h2>User</h2>
<?php 
$getUserdata = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'User' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC LIMIT 0,1");
					$r = mysql_fetch_assoc($getUserdata);
					echo $r['content_text'];

?>
					</div>
					<input type="hidden" id="userTabVideo" value="<?php echo str_replace("../", "", $r['video_path']);?>" >
					</div>
					

				</div>
				
			
			<?php 

			$sql = "SELECT *, ((ACOS(SIN($LATITUDE * PI() / 180) * SIN(lat * PI() / 180) + COS($LATITUDE * PI() / 180) * COS(lat * PI() / 180) * COS(($LONGITUDE - lng) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance 
					FROM `capital_city`
					WHERE `city_id` NOT IN ($CITYID) 
					AND `state_id` = '$_SESSION[state]'
					GROUP BY `city_id` 
					HAVING `distance` <= '100'
					ORDER BY `distance` ASC LIMIT 25";
			$CityNearBy = mysql_query($sql);
			?>
			<div class="gallery">
				<div class="container">
	            	<div id="carousel" class='outerWrapper'>
					<?php 
					while($rc = mysql_fetch_assoc($CityNearBy)){
						$getImageCity = mysql_query("SELECT * FROM `capital_city_images` WHERE `city_id` = '$rc[city_id]' AND `city_image_url` != '' ORDER BY RAND() LIMIT 1  ");
						$fetchimage = mysql_fetch_assoc($getImageCity);

						if(empty($fetchimage['city_image_url'])){
							$contestImage = $SiteURL.'admin/cities/img-default.jpg';
						}
						else{
							$contestImage = $SiteURL.'admin/cities/'.str_replace("../", '', $fetchimage['city_image_url']);	
						}
					
						$title = $rc['city_name'];
				?>
							<div class="itemsnew">
								<?php 
									if(empty($fetchimage['city_image_url'])){
										echo '<h2><a href="'.$SiteURL.'EventSearch.php?cityId='.$rc['city_id'].'">'.$title.'</a></h2>';
									}
									else{
										echo '<div class="link">	
													<a href="'.$SiteURL.'EventSearch.php?cityId='.$rc['city_id'].'">'.$title.'</a>
											</div>';
									}
								?>
								<img src="<?php echo $contestImage;?>" alt="pic">
							</div>

				<?php
					}

					?>

					</div>
				</div>
			</div>
			<?php 
				$DATE = date('Y-m-d');
				$checkcontest = mysql_query("SELECT * FROM `contest` WHERE `contest_status` = 'enable' AND `contest_end` > '$DATE' ");
				$countContest = mysql_num_rows($checkcontest);
			?>
				<div id="landing-page-contest">
					<div class="container landing-event" >
						<div style="min-height: 120px;" class="landing-container">
							<div class="col-md-4 col-sm-4  col-lg-4 contest-img" style="display:block;">
								<a href="<?php echo $SiteURL;?>LiveContest.php?contid=112">
									<img alt="Dj Contest" src="<?php echo $SiteURL;?>images/dj-contest-landing1.png">
								</a>
							</div>
							<div class="col-md-4  col-sm-4 col-lg-4 contest-img" style="display:block;">
								<a href="<?php echo $SiteURL;?>LiveContest.php?contid=128">
									<img alt="Rap Contest" src="<?php echo $SiteURL;?>images/rap-contest-landing1.png">
								</a>
							</div>
							<div class="col-md-4 col-sm-4 col-lg-4 contest-img" style="display:block;">
								<a href="<?php echo $SiteURL;?>mysitti_contests.php?contid=231">
									<img alt="Talnt show" src="<?php echo $SiteURL;?>images/14599084301459900800My-Sitti-Jackson-3.jpg">
								</a>
							</div>
							
						</div>
					</div>
				</div>
				<?php if (isset($_SESSION['city_name']) ) : ?>
						<div class="landing_specific_page">
							<div class="specific_page_categories">
								
							</div>
							<div class="container recommed-city">
								<ul class="groupon_allinclusive_deals">
								
								</ul>
							</div>
							<div class="deals_banner">
								<ul class="banner_vacation_deals">
									
								</ul>
							</div>
						</div>
				<?php else: ?>



					<a id="popuplink" href="#inline" style="display:none;"></a>
					<div id="inline" style="display:none;text-align:center;">
						<div class="subscribe-content">
							<h1>Plan Smarter!</h1>
							<p>Sign up today for up to 40% off your hotel and to get the latest Deals on Flights,Hotels, Cars, Concerts, Sporting events, and more.</p>
							<div class="substext">
								<input type="email" class="form-control" autocomplete="off" required placeholder="Email Address" name="email" id='signup-email'>
								<input type="button" name="submit" class="signup-button remove_popup" value="Sign Up, It's Free!"  id="signup-form" onclick="jQuery.fancybox.close();">
							</div> 	
							<p class="thanks-subs" style="display: none;">Thanks for subscribing email</p>
						</div>
					<p><a href="javascript:;" class="remove_popup" onclick="jQuery.fancybox.close();" style="background-color:#333;padding:5px 10px;color:#fff;border-radius:5px;text-decoration:none;">Close</a></p>
					</div>
					
						<!--div class="subscribe-content">
							<h1>Plan Smarter!</h1>
							<p>Sign up today for up to 40% off your hotel and to get the latest Deals on Flights,Hotels, Cars, Concerts, Sporting events, and more.</p>
							<div class="substext">
								<input type="email" class="form-control" autocomplete="off" required placeholder="Email Address" name="email" id='signup-email'>
								<input type="button" name="submit" class="signup-button" value="Sign Up, It's Free!" id="signup-form">
							</div> 	
							<p class="thanks-subs" style="display: none;">Thanks for subscribing email</p>
						</div-->	
						<div class="container new_designCate">
							<div class="generalPageHeadingActivity">
								
							</div>
							<div class="container recommed-city">
								<ul class="groupon_allinclusive_deals">
								
								</ul>
							</div>
							<div class="deals_banner">
								<ul class="banner_vacation_deals">
									
								</ul>
							</div>
							<div class="clear"></div>				
						</div>
				<?php endif; ?>
		</div>

<!-- Us popular city -->

<div class='modal fade' id='popularcitiesModal' role='dialog'>

	<div class='modal-dialog '>
		<div class='modal-content'>
		    <div class='modal-header'>
		    	<span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>
		      	<button type='button' class='close' data-dismiss='modal'>&times;</button>
		      	<div id="modal_loader"></div>
		    </div>
		    <div class="cities_modal">
		    	
		    </div>
		    <div class='modal-footer'>
		      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		    </div>
		</div>
	</div>
</div>

<!-- Us popular city End -->

		<?php include('landing_page_footer_tst.php'); ?>

	</body>

</html>
