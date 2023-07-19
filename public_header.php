<?php 

$Obj = new Query($DBName);
$titleofpage="Home";
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";
error_reporting(0);
// echo "<pre>"; print_r($_SESSION); exit;

if(isset($_GET['action']) && $_GET['action'] == 'logout')
{

	if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'club')
	{
		//commented by kbihm on 10-02-2015
		mysql_query("update clubs set is_online='0', keepmelogin = '0', streamingLaunch = '0',`streamingLaunchFrom` = '' where id='".$_SESSION['user_id'] ."'");

	}else{
		mysql_query("update user set is_online='0',keepmelogin = '0', streamingLaunch = '0',`streamingLaunchFrom` = '' where id='".$_SESSION['user_id'] ."'");

	}
	mysql_query("UPDATE `chat_users_groups` SET `loggedin` = '0' WHERE `user_id` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]' AND `loggedin` ='1' ");


//die('dfsdfsdfs');

session_destroy();
unset($_SESSION['publicViewReport1']);
$_SESSION['google_users_auth'] = "";
	$_SESSION['token_secret'] = ""; 
	$_SESSION['token'] = ""; 

	setcookie(session_name(), '', 100);
	// empty value and expiration one hour before
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
	$_SESSION['id'] = '54';
?>
<script>

	
	// This is called with the results from from FB.getLoginStatus().
	function statusChangeCallback(response) {
		console.log(response);
		// The response object is returned with a status field that lets the
		// app know the current login status of the person.
		// Full docs on the response object can be found in the documentation
		// for FB.getLoginStatus().
		if (response.status === 'connected') {
			// Logged into your app and Facebook.
			//testAPI(response.authResponse.accessToken);
			FB.logout();
			// setTimeout(function(){
			// 	window.location.href = 'http://mysitti.com';
			// },1000);
		} else if (response.status === 'not_authorized') {
			// The person is logged into Facebook, but not your app.
			//window.location.href = 'http://mysitti.com';
			
		} else {
			// The person is not logged into Facebook, so we're not sure if
			// they are logged into this app or not.
			//window.location.href = 'http://mysitti.com';
		}
	}

	// This function is called when someone finishes with the Login
	// Button.  See the onlogin handler attached to it in the sample
	// code below.
	function checkLoginState() {
			FB.getLoginStatus(function(response) {
			statusChangeCallback(response);
		});
	}

	window.fbAsyncInit = function() {
		FB.init({
			appId      : '1027910397223837',
			xfbml      : true,
			version    : 'v2.6'
		});

		// Now that we've initialized the JavaScript SDK, we call 
		// FB.getLoginStatus().  This function gets the state of the
		// person visiting this page and can return one of three states to
		// the callback you provide.  They can be:
		//
		// 1. Logged into your app ('connected')
		// 2. Logged into Facebook, but not your app ('not_authorized')
		// 3. Not logged into Facebook and can't tell if they are logged into
		//    your app or not.
		//
		// These three cases are handled in the callback function.

		FB.getLoginStatus(function(response) {
			statusChangeCallback(response);
		});

	};

	// Load the SDK asynchronously
	(function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

	// Here we run a very simple test of the Graph API after login is
	// successful.  See statusChangeCallback() for when this call is made.

</script>
<?php
}

session_start();

if(!isset($_SESSION['id']))

{

	$_SESSION['id'] = '54';

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

/* TOP SEARCH CODE */
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Mysitti.com ||<?php echo $titleofpage; ?></title>
		<link href="<?php echo $SiteURL; ?>css/bootstrap.min.css" rel="stylesheet"  type="text/css">
		<link href="<?php echo $SiteURL; ?>css/media.css" rel="stylesheet" type="text/css">
		<link href="<?php echo $SiteURL; ?>css/styleNew.css" rel="stylesheet"  type="text/css"> 
		<link href="<?php echo $SiteURL; ?>css/stylesNew.css" rel="stylesheet"  type="text/css"> 
		<link href="<?php echo $SiteURL; ?>css/responsiveNew.css" rel="stylesheet"  type="text/css"> 
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"> 
		<link href="<?php echo $SiteURL; ?>css/v2style.css" rel="stylesheet" type="text/css"> 
		<link href="<?php echo $SiteURL; ?>css/v1style.css" rel="stylesheet" type="text/css"> 
		<!-- <link href="css/landingPagestyle.css" rel="stylesheet" type="text/css"> -->
		<!-- <link href="css/landingPageresponsive.css" rel="stylesheet" type="text/css"> -->
		<link rel="stylesheet" href="<?php echo $CloudURL; ?>js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />
  		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

		<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $SiteURL; ?>js/waltzer.js"></script>
		<script type="text/javascript">
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-45982925-1', 'auto');
ga('send', 'pageview');
		</script>

		<style type="text/css">
		.NewSerachFilter{
			display: none;
		}

		</style>
	</head>
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

//echo "<pre>"; print_r($_POST); exit;



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
			$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			//echo "<pre>"; print_r($response_a); die('dddd');
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

<script type="text/javascript">

			$(document).ready(function(){

				var imgsrc = '<?php echo $imagesrcback; ?>';

				$('.slider_body ul').find('img').attr('src',imgsrc);

			});

		</script>

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
	// die('ddd');
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
			//$Obj->Redirect("profile.php");
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
			// $Obj->Redirect("profile.php");
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
		//$Obj->Redirect("profile.php");
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

require 'instagram/instagram.class.php';
require 'instagram/instagram.config.php';


$instaURL = $instagram->getLoginUrlInsta();
?>

	<body>
		<input type="hidden" value="<?php echo $SiteURL; ?>" id="siteURL" />
		<div class="main-body">
		 <header>
			<div class="container-fluid main-header">
				<div class="container">
					<div class="">
						<div class="col-sm-2 col-xs-6 logo">
							<img src="images/v2_logo_round.png" alt="My sitti"/>
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

										$countrysql1="select zone_id,name from zone where country_id IN(".$_SESSION['country'].") and status = 1 ORDER BY `name` ASC";

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

		  <script type="text/javascript">

											$(document).ready(function () {

												//alert('ddd');

												var source = JSON.parse('<?php echo $encoded_state_list; ?>');

								

												// Create a jqxComboBox

												$("#jstate_name").jqxComboBox({selectedIndex: '<?php echo $s_key; ?>', source: source, width: '100%', height: '30px', autoComplete: true,searchMode: 'containsignorecase'});

												

												

												$('#jstate_name').on('change', function (event) 

												{

													

													var gcountry_id = $('#country').val();

													

													var args = event.args;

													

													if (args) {

																			

														var index = args.index;

														var item = args.item;

													

														var label = item.label;

														var value = item.value;

													

														$.post('ajaxcall.php',{'country_id' : gcountry_id, 'state_name' : value, 'get_state_id' : 'get_state_id' }, function(resp) {

															$('#state').val(resp);

															getcity(resp);

														});												

													}

												});

												

											});

										</script>

		  <input id="state" type="hidden" name="state" value="<?php echo $set_state_id; ?>">

		 <div id='jstate_name'></div>

		 </p>

		 <p>

		  <?php

											if(isset($_SESSION['state']) and $_SESSION['state'] != '')

											{

												$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) where c.state_id ='".$_SESSION['state']."' order by c.city_name ASC"; 

											}

											else

											{

												$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) order by c.city_name ASC";

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

		  <script type="text/javascript">

											$(document).ready(function () {

												

												var source = JSON.parse('<?php echo $encoded_list; ?>');

								

												// Create a jqxComboBox

												$("#jcity_name").jqxComboBox({selectedIndex: '<?php echo $c_key; ?>', source: source, width: '100%', height: '30px', autoComplete: true,searchMode: 'containsignorecase'});



											});

										</script>

		 <div id='jcity_name'></div>

		 </p>

		 <p>

		  <input class="option-2" id="zipcode" name="zipcode" placeholder="Zip Code" type="text" value="<?php echo $_POST['zipcode']; ?>" >

		 </p>

		 <p>

		  <input type="checkbox" value="" name="default_city" id="default_city">

		  <span class="setdefault">Set as default city</span> </p>

		 <p> 

		  <!-- <input type="button" id="submit" name="search"  value="Switch City" class="button"> -->

		  <input type="button" class="button" value="Switch City" onclick="validate_city_Form();" name="search" id="submit">

		 </p>

		</form> 
								</div>
						</div>
						<div class="col-sm-5 col-xs-6 tranparent">
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
                                    <li class="active"><a href="<?php echo $SiteURL;?>searchEvents.php">City Events <span class="sr-only">(current)</span></a></li>
                                    <li><a href="<?php echo $SiteURL;?>city_talk.php">City Talk</a></li>
                                    <li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">Contest</a></li>
                                    <li><a href="<?php echo $SiteURL;?>MySittiTV.php">Mysitti TV</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    	 <div class="col-sm-3 col-xs-6">
                        <div class="log-in-new">
                            <!--<a href="" id="v2_log_in" for="login">Log In</a>-->
                            <label for="login" id="v2_log_in">Log In</label>
                            <input type="checkbox" id="login">
                            <!--<a href="" class="join-now-new signup" onclick="show_login_popop();">Join For Free</a>-->
                            <input type="button" onclick="show_login_popop();" value="Join For Free" class="join-now-new signup">
                        </div>
                    </div>
					</div>
				</div>
			</div>	
			</header>  

			<script src="<?php echo $CloudURL; ?>js/jquery-migrate-1.0.0.js"></script>

<script src="<?php echo $CloudURL; ?>js/jquery.bxslider.js"></script>

<script src='<?php echo $CloudURL; ?>js/jqueryvalidationforsignup.js'></script>

<script src="<?php echo $CloudURL;?>js/register.js" type="text/javascript"></script>

<script src="<?php echo $CloudURL;?>js/datetimepicker/jquery.datetimepicker.js"></script>

<script src="<?php echo $SiteURL;?>js/add.js" type="text/javascript"></script>

<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->

<script src="<?php echo $CloudURL;?>autocomplete/jquery.ajaxcomplete.js"></script>

<script type="text/javascript" src="<?php echo $CloudURL; ?>QapTcha-master/jquery/jquery-ui.js"></script>

<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="<?php echo $CloudURL; ?>lightbox/js/jquery.smooth-scroll.min.js"></script>

<!--<script src="<?php echo $CloudURL; ?>lightbox/js/lightbox.js"></script>-->

<script src="<?php echo $SiteURL; ?>js/custom.js"></script>

<script src="<?php echo $SiteURL; ?>js/functions.js"></script>

<script type="text/javascript" src="<?php echo $SiteURL;?>jwplayer-7.2.4/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>

<script type="text/javascript" src="<?php echo $CloudURL; ?>js/chat.js"></script>

<script src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>

<link rel="stylesheet" href="<?php echo $CloudURL; ?>css/smk-accordion.css" />

<script type="text/javascript" src="<?php echo $CloudURL; ?>js/new_portal/smk-accordion.js"></script>

<link rel="stylesheet" href="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />

<script type="text/javascript" src="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.pack.js"></script>



<link rel="stylesheet" href="<?php echo $SiteURL;?>jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/scripts/demos.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxpanel.js"></script>
<script src="js/nicescroll/jquery.easing.1.3.js"></script>
<script src="js/nicescroll/jquery.nicescroll.min.js"></script>
<script src="js/nicescroll/jquery.nicescroll.plus.js"></script>
<script src="<?php echo $SiteURL; ?>js/jquery.nicescroll.min.js"></script>
<script src="<?php echo $SiteURL; ?>js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>js/SocialShare.js"></script>


<script type="text/javascript">

function fbs_click(u, t) 
{
				window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
			 return false;
}
function fbs_click123(u) 
{
				window.open('http://twitter.com/home?status='+encodeURIComponent(u),'sharer','toolbar=0,status=0,width=626,height=436');
			 return false;
}
			 
function fbs_click1234(u) 
{
				window.open('https://plus.google.com/share?url='+encodeURIComponent(u),'sharer','toolbar=0,status=0,width=626,height=436');
			 return false;
}


var audio;
var playlist;
var tracks;
var current;


function init()
{
	current = 0;
	audio = $('#tv_main_channel');
	playlist = $('#playlist');
	tracks = playlist.find('li');
	var tt = $('#playlist li').length;
	len = tracks.length;
	var link = playlist.find('a')[0];
	audio[0].volume = .2;
	//if(len > 1)
	//{
		
		audio[0].play();
		playlist.find('a').click(function(e){
		
		});
		audio[0].addEventListener('ended',function(e){
			audio[0].pause();
			//$('#mp4Source').attr('src', '');
			current++;
			if(current >= len ){
				current = 0;
				link = playlist.find('a')[0];
				//run($(link),audio[0],current, len);
			}else{
				link = playlist.find('a')[current];    
				
			}
			run($(link),audio[0],current, len);
			

		});
		//run($(link),audio[0],current, len);
	//}
}

function run(link, player,current, tracks){
	//alert(tracks)
	//player.src = link.attr('href');
	var newID = link.attr('id');
	$('#mp4Source').attr('src',link.attr('href'));

	par = link.parent();
	par.addClass('active').siblings().removeClass('active');
	
	player.load();
	player.volume = .2;
	//var cc = current - 1;
	//alert(current);
	if(current == 0 && tracks == 1)
	{
		player.pause();
	}
	else if(current == 1 && tracks > 1)
	{
		player.pause();
	}
	else if(current == 0 && tracks > 1)
	{

	}
	else
	{
		// alert(link.attr('href'));
		// $('#mp4Source').attr('src', '');
		player.play();
	}
}

function FBLogin(){
	var type = 'user';
	FB.login(function(response){
		if(response.authResponse){
			window.location.href = "index.php?action=fblogin&type="+type;
		// window.location.href = "user_social.php?action=fblogin";
		}
	}, {scope: 'email,user_likes,user_posts'});
}

function FBLogout(){
	FB.logout(function(response) {

	});
}


$(document).ready(function() {   

		$('.upcoming-event ul').niceScroll({styler:"fb",cursorcolor:"#1c50b3"});

		$(".contact-landing").click(function(){
			$('#ConfirmMessage').html('').hide();
			$(".contact-overlay").show();
			$(".contact-overlay").fadeIn();
			return false;
		});
		$(".close-landing-page-form").click(function(){
			$('#ConfirmMessage').html('').hide();
			$(".contact-overlay, .EventPop-overlay-host, .EventPop-overlay-user").fadeOut();
			$(".contact-overlay, .EventPop-overlay-host, .EventPop-overlay-user").hide();		
			return false;
		});

		



		$('#topsearchform input.jqx-combobox-input').click(function(){
			//$(this).text('');
			$(this).val('');
		});
		
		
		$("#ContactNumber").mask("999-999-9999");

		refreshCaptcha('<?php echo $SiteURL; ?>');
		$('.tips').hover(
			function(){
				$('.hoverme').css('display', 'block');
			},
			function(){
				$('.hoverme').css('display', 'none');
			}
		);

		window.fbAsyncInit = function() {
			FB.init({
				appId      : '1027910397223837', // replace your app id here
				channelUrl : 'https://mysitti.com/index.php', 
				status     : true, 
				cookie     : true, 
				xfbml      : true,
				version    : 'v2.6'  
			});
						};
						(function(d){
			var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement('script'); js.id = id; js.async = true;
			js.src = "//connect.facebook.net/en_US/all.js";
			ref.parentNode.insertBefore(js, ref);
		}(document));

						




		init();
	// $('.user').click(function()
	// {

	// 	$(this).addClass('selected-landing-tab');
	// 	$('.artist').removeClass('selected-landing-tab'); 
	// 	$('.host').removeClass('selected-landing-tab'); 
	// 	$('#userLanding').show();
	// 	$('#artist').hide(); 
	// 	var SRC = $('#userTabVideo').val();
	// 	$('#tv_main_channel').find('source').attr('src',SRC);
	// 	var HTML = $('.userTablist').html();
	// 	$('#playlist').html(HTML);
	// 	current = 0;
	// 	audio = $('#tv_main_channel');
	// 	playlist = $('#playlist');
	// 	tracks = playlist.find('li');
	// 	len = tracks.length;
	// 	link = playlist.find('a')[0];
	// 	audio[0].volume = .2;
	// 	audio[0].load();
	// 	audio[0].play();

	// });
	
	// $('.host').click(function()
	// {

	// 	$(this).addClass('selected-landing-tab');
	// 	$('.user').removeClass('selected-landing-tab'); 
	// 	$('#artist').show();
	// 	$('#userLanding').hide(); 
	// 	var SRC = $('#artistTabVideo').val();
	// 	$('#tv_main_channel').find('source').attr('src',SRC);
	// 	var HTML = $('.artistTablist').html();
	// 	$('#playlist').html(HTML);
	// 	current = 0;
	// 	audio = $('#tv_main_channel');
	// 	playlist = $('#playlist');
	// 	tracks = playlist.find('li');
	// 	len = tracks.length;
	// 	link = playlist.find('a')[0];
	// 	audio[0].volume = .2;
	// 	audio[0].load();
	// 	audio[0].play();
		
	// 	run($(link),audio[0],current, len);
	// });

});
	
function reportabuse(fid)
{
	$.get( "report-abouse.php?forum_id="+fid, function( data ) {
		if(data=='false')
		{
			$('#report_error_'+fid).show();
			$('#report_error_'+fid).html('You already sent abuse report for this forum.');
			$('#report_error_'+fid).fadeOut(5000);

		}
		else
		{
			$('#report_send_'+fid).show();
			$('#report_send_'+fid).html('Abuse report sent to admin');
			$('#report_send_'+fid).fadeOut(5000);
		}

	});
}	

function sendsession(id)
{ 
	$.get('send-invite.php?user_id='+id, function(data) {
		window.location='camstart.php?'+data;
	});
}


function popuploginSign()
{
	
	$('#host_category option[value=108]').prop('selected', true);
	$('#hostsFields').show();
	$('#hosttype').prop('checked', true);
	$('#userTYPE').val('Artist');
		
	var $aSelected = $('.v2_log_in');
	if( $aSelected.hasClass('close') )
	{ // .hasClass() returns BOOLEAN true/false
		$('.close').addClass('open').removeClass('close');
	}
	else
	{
		$('.v2_log_in').addClass('open');
	}
}

function popuploginSign_notlogin(val)
{
	if (val != '') {
		$('#host_category option[value="' + val + '"]').prop('selected', true);
		$('#hostsFields').show();
		$('#hosttype').prop('checked', true);
		$('#userTYPE').val('club');
	}
	
	var $aSelectedc = $('.v2_log_in');

	if( $aSelectedc.hasClass('close') ){ // .hasClass() returns BOOLEAN true/false

	  $('.close').addClass('open').removeClass('close');
	  $('.v2_sign_up').addClass('close').removeClass('open');
	  
	}else{

		$('.v2_log_in').addClass('open');
	}
}

function change_src(args,id)
{
	var link = args;
	var isYoutube = link && link.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
	var vimeoLink = link && link.match(/(?:vimeo)(?:\.com|\.be)\/([\w\W]+)/i);
	if(isYoutube)
	{
		$.ajax({
			type: "POST",
			url: "mediaelementLoad.php",
			data: {
				'action': "changeVideoInfo", 
				'videoid' : link,
				'link': 'youtube'
			},
			success: function( data ) 
			{
				$('.TV').html(data);
				// var audio = $('#tv_main_channel');
				// audio[0].play();
				//var player = new MediaElementPlayer('#tv_main_channel');
				jwplayer("tv_main_channel").setup({
					file: link,
					autostart: true,
				});
				//$('.mejs-controls').find('.mejs-playpause-button').find('button').trigger('click');
			}
		});
	}
	else if(vimeoLink)
		{
			$.ajax({
				type: "POST",
				url: "mediaelementLoad.php",
				data: {
					'action': "changeVideoInfo", 
					'videoid' : link,
					'link': 'vimeo'
				},
				success: function( data ) 
				{
					$('.TV').html(data);
					
				}
			});
		}
	else
	{
		$.ajax({
			type: "POST",
			url: "mediaelementLoad.php",
			data: {
				'action': "changeVideoInfo", 
				'videoid' : link,
				'link': 'mp4'
			},
			success: function( data ) 
			{
				$('.TV').html(data);
				jwplayer("tv_main_channel").setup({
					file: link,
					autostart: true,
				});
			}
		});
	}


	$('.list_play').each(function(){
		if($(this).attr('id') == "list_"+id)
		{
			$(this).addClass('playing');
			$(this).addClass('active');
		}
		else
		{
			$(this).removeClass('playing');
			$(this).removeClass('active');
		}
	});



}

function open_redirect_loginpopup_event(url)
{
	
	$.post('redirect_after_login_check.php', { 'set_store_redirect': true, 'successurl':url }, function(response){ });

	var $aSelected = $('.v2_log_in');
	$(".v2_signup_overlay").css('display', 'block');
	$(".v2_log_in").addClass('open');
	$(".v2_log_in").removeClass('close');
	$(".v2_sign_up").removeClass('open').addClass('close');
}


function addmerchantID(page)
{

	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'action': "checkMerchant", 
		},
		success: function( msg ) 
		{
			if( msg == 'No')
			{
				if(page == 'addEvent')
				{
					if($('#add_streaming_ticket').is(':checked') || $('#add_pass_ticket').is(':checked') )
					{
						if(confirm('To add this feature you must add your Paypal Merchant Id.'))
						{
							window.open('edit_profile.php?action=AddMerchantID', '_blank');
						}
						else
						{
							$('#add_streaming_ticket, #add_pass_ticket').prop('checked', false);
							$('#ticket_module').hide();
							$('#max_ticket_downloads').val('');
							$('#ticket_price').val('');
							$('#pass_module').hide();
							$('#max_download').val('');
							$('#amount').val('');
						}

					}
				}
				else
				{
					if(confirm('To add this feature you must add your Paypal Merchant Id.'))
					{
						window.open('edit_profile.php?action=AddMerchantID', '_blank');
					}
					else
					{
						if(page == 'addEvent')
						{
							$('#add_streaming_ticket, #add_pass_ticket').prop('checked', false);
							$('#ticket_module').hide();
							$('#max_ticket_downloads').val('');
							$('#ticket_price').val('');
							$('#pass_module').hide();
							$('#max_download').val('');
							$('#amount').val('');
						}
						if(page == 'Music')
						{
							$('#MusicPrice').val('');
							$('#TrackName').focus();
						}
						if(page == 'CD')
						{
							$('#CDprice').val('');
							$('#CDname').focus();
						}
						if(page == 'VideoClips')
						{
							$('#VideoPrice').val('');
							$('#VideoName').focus();
						}
						if(page == 'Booking')
						{
							$('#BookingPrice').val('');
							$('#BookingCapacity').focus();
						}
						return false;
					}
				}
			}
			else if( msg == 'Yes')
			{
				if(page == 'addEvent')
				{
					$('#add_streaming_ticket, #add_pass_ticket').removeAttr('onclick');
				}
				if(page == 'Music')
				{
					$('#MusicPrice').val('').removeAttr('onclick');
				}
				if(page == 'CD')
				{
					$('#CDprice').val('').removeAttr('onclick');
				}
				if(page == 'VideoClips')
				{
					$('#VideoPrice').val('').removeAttr('onclick');
				}
				if(page == 'Booking')
				{
					$('#BookingPrice').val('').removeAttr('onclick');
				}
			}

		}
	});
}


function SubmitContact()
{
	var fname = $('#contact_first').val();
	var lname = $('#contact_last').val();
	var enquiry = $('#contact_enquiry').val();
	var newenquiry = $.trim(enquiry);
	var email = $('#contact_email').val();
	var captcha = $('#contact_captcha').val();
	var confirmcaptcha = $('#captchacodeImage').val();

	if(confirm("Are you sure you want to submit the form ?"))
	{
		if(fname != '' && lname != '' && newenquiry != '' && email != '' && captcha != '' )
		{
			if(captcha == confirmcaptcha)
			{

				$.blockUI({ css: {

					border: 'none',

					padding: '15px',

					backgroundColor: '#fecd07',

					'-webkit-border-radius': '10px',

					'-moz-border-radius': '10px',

					opacity: .8,

					color: '#000'

				},

				message: '<h1>Submitting Your Query. Please Wait.</h1>'

				});

				$.ajax({
					type: "POST",
					url: "refreshajax.php",
					data:  $('#ContactFrom').serialize() + "&action=ContactSubmit" ,
					success: function( msg ) 
					{
						if( msg == 'NO')
						{
							alert('There is something wrong with Code you have entered. Please try again.');
							$('#ContactFrom')[0].reset;
							document.getElementById("ContactFrom").reset();
						}
						else
						{
							$( '#ContactFrom' ).each(function(){
								this.reset();
							});
							$('#ContactFrom')[0].reset;
							document.getElementById("ContactFrom").reset();
							alert('Your Query is submitted with us. We will contact you as soon as possible.');
						}
						
						$.unblockUI();
					}
				});
			}
			else
			{
				alert('Captcha Mismatch . .  And please enter Proper details.');
				return false;
			}
		}
		else
		{
			alert('Please fill up all the fields.');
			return false;
		}
	}
	else
	{
		return false;
	}

}

function toggleMenu(){
	$('#bs-example-navbar-collapse-1').slideToggle('slow');
}


			$(document).ready(function(){
				$('#carousel').waltzer({scroll:1});
				$('#Search_box_filter').hide().before('<a href="#" id="toggle-menu" class="v2_filter_menu host_filter"><?php echo $dropdown_city; ?>, <?php echo $dropdown_state; ?><img src="images/menu.png" alt="Menu" /></a>');

				$('a#toggle-menu').click(function (e) {

					e.preventDefault();

					$('#Search_box_filter').slideToggle(200);

				});

				$('#dropdownlistContentjstate_name').find('input[type="textarea"]').val('<?php echo $set_state_name;?>');

				$('#dropdownlistContentjcity_name').find('input[type="textarea"]').val('<?php echo $set_city_name; ?>');

				$('a#toggle-menu').hover(
					function(e){
						//$('a#toggle-menu').trigger('click');
						e.preventDefault();

						$('#Search_box_filter').slideToggle(200);
					},
					function(e){
						//$('a#toggle-menu').trigger('click');
						//e.preventDefault();

						//$('#Search_box_filter').slideToggle(200);
					}
				);

				$(document).click(function(e) {
					if (!$(e.target).is('a#toggle-menu, #Search_box_filter *')) {
						$("#Search_box_filter").slideUp('slow');
					}
				});



			});

			function validate_city_Form()

			{



				var country = $('#topsearchform').find("#country").val();

				var state = $('#topsearchform').find("#state").val();

				var city = $('#topsearchform').find("#city_name").val();

				var j_city_name = $('#topsearchform').find('#jcity_name').find('input[name="city_name_jquery"]').val();

				var zipcode = $('#topsearchform').find('#zipcode').val();



				if($('#topsearchform').find('#default_city').is(':checked'))

				{



					var chkbox = "on";

				}

				else

				{

			var chkbox = "off";

				}



				if(country == "" && state=="")

				{

					alert("Please Select Country And State First!");

					return false;

				}

				else if(country == "" && state != "" )

				{

					alert("Please Select Country!");

					return false;

				}

				else if(country != "" && state == "" )

				{

					alert("Please Select State!");

					return false;

				}

				else

				{

					if(zipcode != "")

					{

						$.ajax({

							type: "POST",

							url: "refreshajax.php",

							data: {

										'action': "checkzipcode", 

										'zip' : zipcode,

										'state' : state,

										'country' : country,

										'checkbox': chkbox,

							},

							success: function( msg ) 

							{

								if(msg == "1")

								{

									location.reload(true);



								}

								else if(msg == "0")

								{

									alert("No city Found for this Zip code");

									return false;

								}

							}

							});	



					}

					else

					{

						//alert(j_city_name);

						if(j_city_name =="")

						{

							j_city_name = $('#topsearchform').find('input[name="city_name123"]').val();

						}

						if (j_city_name != "") 

						{

							//alert(chkbox);

							jQuery.post('ajaxcall.php', {'check_city_status': 'check_city_status', 'state': state, 'city': j_city_name,'country': country,'checkbox': chkbox}, function(response){

								

								if (response == "exists") {

									//$('#topsearchform').submit();

									location.reload(true);//return true;



								}else{

									

									alert("City Does Not Exist for this state.");

									return false;

								}

								

							});

						}

						else

						{

							alert("Please Enter or Select City First!");

							return false;

						}

					}

				}

			}

			var usertextlen = $('.user ul li').length;
			var artisttextlen = $('.host ul li').length;
			if(usertextlen > 3)
			{
				$('<span class="moreslide collapsed" id="userreadmore"></span>').insertAfter('.user > .TablListBlock');
			}

			if(artisttextlen > 3)
			{
				$('<span class="moreslide collapsed" id="artistreadmore"></span>').insertAfter('.host > .TablListBlock');
			}


			$('#userreadmore').click(function(){
				$(".EventPop-overlay-host").fadeOut();
				$(".EventPop-overlay-host").hide();
				$('.EventPop-overlay-user').show();
				$(".EventPop-overlay-user").fadeIn();
				return false;
			});
			$('#artistreadmore').click(function(){
				$(".EventPop-overlay-user").fadeOut();
				$(".EventPop-overlay-user").hide();
				$('.EventPop-overlay-host').show();
				$(".EventPop-overlay-host").fadeIn();
				return false;
			});



	function openLoginpop(url)

	{

			$.post('redirect_after_login_check.php', { 'set_store_redirect': true, 'successurl':url }, function(response){ });

			var $aSelected = $('.v2_log_in');
			$(".v2_signup_overlay").css('display', 'block');
			$(".v2_log_in").addClass('open');
			$(".v2_log_in").removeClass('close');
			$(".v2_sign_up").removeClass('open').addClass('close');
	}

	

	function show_login_popop()
	{
		$(".v2_signup_overlay").fadeIn('slow');
		$('#v2_sign_up_after').fadeIn('slow');
		$(".v2_signup_overlay").css('display', 'block');

		$(".v2_sign_up").addClass('open').css('display','block');

		$(".v2_sign_up").removeClass('close');
		$(".v2_log_in").removeClass('open').addClass('close');
		return false;
	}

		</script>

