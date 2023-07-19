<?php 
include("Query.Inc.php");
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

	} else {
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
		<title>mysittidev.com ||<?php echo $titleofpage; ?></title>
		<link href="<?php echo $SiteURL; ?>css/bootstrap.min.css" rel="stylesheet"  type="text/css">
		<link href="<?php echo $SiteURL; ?>css/media.css" rel="stylesheet" type="text/css">
		<link href="<?php echo $SiteURL; ?>css/styleNew.css" rel="stylesheet"  type="text/css"> 
		<link href="<?php echo $SiteURL; ?>css/stylesNew.css" rel="stylesheet"  type="text/css"> 
		<link href="<?php echo $SiteURL; ?>css/responsiveNew.css" rel="stylesheet"  type="text/css"> 
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"> 
		<link href="<?php echo $SiteURL; ?>css/v2style.css" rel="stylesheet" type="text/css"> 
		<link href="<?php echo $SiteURL; ?>css/v1style.css" rel="stylesheet" type="text/css"> 
		
		<link rel="stylesheet" href="<?php echo $CloudURL; ?>js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />
  		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

		<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-1.7.2.min.js"></script>

	</head>
<?php

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
		
                    <div class="log-in-new">
                        <label for="login" id="v2_log_in">Log In</label>
                        <input type="checkbox" id="login">
                        <input type="button" onclick="show_login_popop();" value="Join For Free" class="join-now-new signup">
                    </div>
                			
<script type="text/javascript">
	function displayFields()
		{

			if($('input#hosttype').is(':checked'))
			{
				$('#userTYPE').val('club');
				$('#hostFieldsBlock').toggle();
			}
			else
			{
				$('#userTYPE').val('user');
				$('#hostFieldsBlock').toggle();
			}
			
		}

		$('.v2_close_signup').click(function(){
			
			$(".v2_sign_up").fadeOut('slow');
			$(".v2_signup_overlay").fadeOut('slow');
		});

</script>

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

			<?php } ?>

			<form id="mainlogin" name="login" action="<?php echo $SiteURL;?>main/login.php" method="POST">

			 	<p>
			 		<input type="text" name="uname"  placeholder="Email Address" required="">
				</p>

				<div class="clear"></div>

				<p>
	     			<input type="password" name="password" id="password2" placeholder="Password" required="">
				</p>
				<div class="clear"></div>

				<p>
					<input type="submit" name="submit" value="Login">
				</p>

			</form>

				<div class="clear"></div>
   

		</div> <p><a href="<?php echo $SiteURL; ?>forget_pwd.php">Forgot Password</a></p>

		  <p class="cleataccount">Don't have a MySitti account?  <a href="#" onclick="show_login_popop(); return false;">Sign up now</a>
		  <div class="socialmedia"  style="display: none;">
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
					// die('success');
					$sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
					$getemailquery = @mysql_query($sql);
					$countemail = @mysql_num_rows($getemailquery);
					$today = date("Y-m-d h:i:s");
					if($countemail > 0 ) 
					{
						//die('if');
						//$dataArray = @mysql_fetch_array($getemailquery);
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
						//  date_default_timezone_set('America/Los_Angeles');
						$current_time= date('Y-m-d H:i:s'); 
						$tdate=date('Y-m-d H:i:s');
						//echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
						mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
						//exit;
						//ob_start();

						session_write_close();
						$Obj->Redirect("profile.php");
						exit;
					}
					else
					{
						//die('else');
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
						//date_default_timezone_set('America/Los_Angeles');
						$current_time= date('Y-m-d H:i:s'); 
						$tdate=date('Y-m-d H:i:s');
						//echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
						mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
						//exit;
						//ob_start();

						session_write_close();

						$Obj->Redirect("profile.php");
						exit;
					}
				}  
			}
		}
			if(isset($authUrl)) //user is not logged in, show login button
			{  ?>
				<a href="<?php echo $authUrl; ?>" target="blank"><img alt="Login from Google Plus" src="images/googleplus1.png"></a>
 			 <?php 	} 	?>
		  </div>
		  </div> </div>

					</div>
				</div>
			<!--banner closed-->
			
			
<script src="<?php echo $CloudURL; ?>js/jquery-migrate-1.0.0.js"></script>

<script src="<?php echo $CloudURL; ?>js/jquery.bxslider.js"></script>

<script src='<?php echo $CloudURL; ?>js/jqueryvalidationforsignup.js'></script>

<script src="<?php echo $CloudURL;?>js/register.js" type="text/javascript"></script>

<script src="<?php echo $CloudURL;?>js/datetimepicker/jquery.datetimepicker.js"></script>

<script src="<?php echo $SiteURL;?>js/add.js" type="text/javascript"></script>


<script src="<?php echo $CloudURL;?>autocomplete/jquery.ajaxcomplete.js"></script>


<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="<?php echo $CloudURL; ?>lightbox/js/jquery.smooth-scroll.min.js"></script>

<script src="<?php echo $SiteURL; ?>js/custom.js"></script>

<script src="<?php echo $SiteURL; ?>js/functions.js"></script>

<script type="text/javascript" src="<?php echo $SiteURL;?>jwplayer-7.2.4/jwplayer.js"></script>

<script type="text/javascript" src="<?php echo $CloudURL; ?>js/chat.js"></script>

<script src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>



<link rel="stylesheet" href="<?php echo $SiteURL;?>jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/scripts/demos.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxscrollbar.js"></script>

<script type="text/javascript">

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

	function open_redirect_loginpopup_event(url)
	{
		$.post('redirect_after_login_check.php', { 'set_store_redirect': true, 'successurl':url }, function(response){ });
		var $aSelected = $('.v2_log_in');
		$(".v2_signup_overlay").css('display', 'block');
		$(".v2_log_in").addClass('open');
		$(".v2_log_in").removeClass('close');
		$(".v2_sign_up").removeClass('open').addClass('close');
	}

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


<script src="js/bootstrap.min.js"></script>
	</body>

</html>
