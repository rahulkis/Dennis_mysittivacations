<?php  
	$currentDatetime = date('Y-m-d H:i:s');

	$currentDate = date('Y-m-d');

	$currentTime = date('H:i:s');

	$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
	
	$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";

	$ABSPATH =$_SERVER['DOCUMENT_ROOT']."/";

	$getEventsCategory = mysql_query("SELECT * FROM `eventcategory` ORDER BY `catname` ASC ");

/* TOP SEARCH CODE */

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
<?php 					die; 

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

			//die('dddd');

			$check_d_city_status = @mysql_query("SELECT * FROM default_city_selected WHERE user_id = '".$user_id."' AND user_type = '".$user_type."'");

			$check_d_city_rows = mysql_num_rows($check_d_city_status);

		

			if($check_d_city_rows < 1){

				

				$insert_d_city = @mysql_query("INSERT INTO default_city_selected (`user_id`, `user_type`, `country`, `state`, `city`, `d_city_status`) VALUES ('".$user_id."', '".$user_type."', '".$country."', '".$state."', '".$city."', '".$d_city_status."')");

				

			}else{

				

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

			

			echo $zip_city = "SELECT * FROM `capital_city` WHERE  `city_name`= '$city'   " ; die;

			$zip_city_Array = mysql_query($zip_city);

			$num_rw=mysql_num_rows($zip_city);

			if($num_rw > 0){

				$city_get= mysql_fetch_array($zip_city_Array);

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

	// echo "SELECT * FROM `capital_city` WHERE `city_id` = '".$cityid."' ";

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



if(!isset($_GET['host_id']))

{

	$profilename=$loggedin_host_data['club_name'];

	$club_name = $profilename;

	$plantype = $loggedin_host_data['plantype'];

	$typeclub = $loggedin_host_data['type_of_club'];

	$email=$loggedin_host_data['club_email'];

	$club_address=$loggedin_host_data['club_address'];

	$phone=$loggedin_host_data['club_contact_no']; 

	$country=$loggedin_host_data['club_country'];

	$state=$loggedin_host_data['club_state'];

	$club_city=$loggedin_host_data['club_city'];

	$web_url=$loggedin_host_data['web_url'];

	$zipcode=$loggedin_host_data['zip_code'];

	$google_map_url=$loggedin_host_data['google_map_url'];	

	$image_nm  =$loggedin_host_data['image_nm'];

	$_SESSION['username']=$profilename;


	if(isset($_SESSION['subuser']))

	{

		$q1 = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$loggedin_host_data['club_name']."'  ");

		$f1 = @mysql_fetch_array($q1);

	}

	else

	{

	}

	$enablediablephone=$loggedin_host_data['text_status'];

}

elseif(isset($_GET['host_id']))

{

	$profilename=$get_host_data['club_name'];

	$club_name = $profilename;

	$plantype = $get_host_data['plantype'];

	$typeclub = $get_host_data['type_of_club'];

	$email=$get_host_data['club_email'];

	$club_address=$get_host_data['club_address'];

	$phone=$get_host_data['club_contact_no']; 

	$country=$get_host_data['club_country'];

	$state=$get_host_data['club_state'];

	$club_city=$get_host_data['club_city'];

	$web_url=$get_host_data['web_url'];

	$zipcode=$get_host_data['zip_code'];

	$google_map_url=$get_host_data['google_map_url'];	

	$image_nm  =$get_host_data['image_nm'];

	$_SESSION['username']=$profilename;

	//$_SESSION['id']=$club_city;

	//$_SESSION['state']=$state;

	//$_SESSION['country']=$country;

	if(isset($_SESSION['subuser']))

	{

		$q1 = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$get_host_data['club_name']."'  ");

		$f1 = @mysql_fetch_array($q1);



		//$_SESSION['img'] =  $f1['user_thumb'] ;

		

	}

	else

	{

		//$_SESSION['img'] =  $image_nm ;

	}

	$enablediablephone=$get_host_data['text_status'];

}





/* FACEBOOK LOGIN CODE */
include 'login/facebook.php';
$appid      = "688073574590787";
$appsecret  = "acdbc4b9054bbc4c7e318b42a05d92fd";

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
		$current_time= date('Y-m-d H:i:s'); 
		$tdate=date('Y-m-d H:i:s');
		mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
		session_write_close();
		$Obj->Redirect("profile.php");
		die; 
	}
	else
	{
		$ValueArray = array($path,'facebook',$user_fnmae,$user_lnmae,$user_email,'','','','','','','1',$today,'','','free','','');
		$FieldArray = array('image_nm','hear_about','first_name','last_name','email','password','phone','user_address','country','state','zipcode','status','regi_date','DOB','city','plantype','longitude','latitude');     
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
		$Obj->Redirect("profile.php");
		die;
	}
}

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

/* END GOOGLE LOGIN CODE */

require 'instagram/instagram.class.php';
require 'instagram/instagram.config.php';

$instaURL = $instagram->getLoginUrl();



?>

<!DOCTYPE HTML>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti.com ||<?php echo $titleofpage; ?></title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<?php 
if(($_SERVER['SCRIPT_NAME'] == "/index.php"))
{
	?>
<meta name="google-site-verification" content="o-g5OxxDOWX2F__eELEb5UVS1lDerXIIc1hVhtJ4PpE" />
<meta name="p:domain_verify" content="70c01a95a31eed9bd52d0de689eeb163"/>
<?php
}
?>

<!-- ======== Include Main Stylesheet ===============  -->

<link href="<?php echo $SiteURL; ?>css/v2style.css" rel="stylesheet" type="text/css">
<link href="<?php echo $SiteURL; ?>css/v1style.css" rel="stylesheet" type="text/css">
<link href="<?php echo $SiteURL; ?>css/responsive.css" rel="stylesheet" type="text/css">
<link href="<?php echo $CloudURL; ?>css/jquery.bxslider.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $CloudURL; ?>lightbox/css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $CloudURL;?>js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $CloudURL;?>css/jukebox.css" />
<link rel="stylesheet" href="<?php echo $CloudURL;?>autocomplete/jquery.ajaxcomplete.css" />

<!-- ======== Include Main Javascript Library ===============  -->

<!--script src="<?php //echo $SiteURL; ?>js/jquery.min.js"></script -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo $CloudURL; ?>js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo $CloudURL; ?>js/jquery.bxslider.js"></script>
<script src='<?php echo $CloudURL; ?>js/jqueryvalidationforsignup.js'></script>
<script src="<?php echo $CloudURL;?>js/register.js" type="text/javascript"></script>
<script src="<?php echo $CloudURL;?>js/datetimepicker/jquery.datetimepicker.js"></script>
<script src="<?php echo $CloudURL;?>js/add.js" type="text/javascript"></script>

<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->

<script src="<?php echo $CloudURL;?>autocomplete/jquery.ajaxcomplete.js"></script>
<script type="text/javascript" src="<?php echo $CloudURL; ?>QapTcha-master/jquery/jquery-ui.js"></script>
<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="<?php echo $CloudURL; ?>lightbox/js/jquery.smooth-scroll.min.js"></script>

<!--<script src="<?php echo $CloudURL; ?>lightbox/js/lightbox.js"></script>-->

<script src="<?php echo $CloudURL; ?>js/custom.js"></script>
<script src="<?php echo $CloudURL; ?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CloudURL; ?>jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
<script src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>
<link rel="stylesheet" href="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".fancybox").fancybox();
});
  </script>


<link rel="stylesheet" href="http://mediaelementjs.com/js/mejs-2.9.2/mediaelementplayer.min.css" />

<!-- ======== Include Main Other Javascripts ===============  -->

<?php
if(empty($_SESSION['id']) && !isset($_SESSION['id']) )
{ 

	$id=54;

	$_SESSION['id']=$id;

	$_SESSION['state']='3668';

	$_SESSION['country']='223';
?>
<script>
var x = document.getElementById("demo");

//function getLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition);
	} else { 
		x.innerHTML = "Geolocation is not supported by this browser.";
	}
//}

function showPosition(position) {
	
	jQuery.post('ajaxcall.php', { 'longitude':position.coords.longitude, 'latitude':position.coords.latitude, 'get_visitor_geolocation': 'get_current_user_location' }, function(response){
		
		if (response == 'success') {
			window.location.href = '';
		}
		
		});
	
	//x.innerHTML = "Latitude: " + position.coords.latitude + 
	//"<br>Longitude: " + position.coords.longitude;	
}
</script>
<?php
}
?>
<?php

if(isset($_GET['msg']) && $_GET['msg'] == 'error1'){ ?>
<script type="text/javascript">

	$(document).ready(function () {    

		$('#v2_log_in').trigger('click');

	});

</script>
<?php }

// require 'instagram/instagram.class.php';
// require 'instagram/instagram.config.php';

// $instaURL = $instagram->getLoginUrl();


?>
<script type="text/javascript">

	$(document).ready(function () {

		$('#shw_logn_frm').live('click', function(){

			

			$.post('redirect_after_login_check.php', { 'unset_store_redirect': true }, function(response){ });

			

			var $aSelected = $('.v2_log_in');

			if( $aSelected.hasClass('close') ){ // .hasClass() returns BOOLEAN true/false

			

			  $('.close').addClass('open').removeClass('close');

			  

			}else{

			

				$('.v2_log_in').addClass('open');

				

			}

		});

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
		// var $aSelected = $('.v2_log_in');
		// var $signupSelected = $('.v2_sign_up');
		// if( $signupSelected.hasClass('close') )
		// { // .hasClass() returns BOOLEAN true/false
		// 	$('.close').addClass('open').removeClass('close');
		// 	$('.v2_log_in').addClass('close').removeClass('open');
		// 	$('#v2_sign_up_after').show();
		// }
		// else
		// {				
		// 	$('.v2_log_in').addClass('close').removeClass('open');
		// 	$('.v2_sign_up').addClass('open');
		// 	$('.v2_sign_up.open').css({'display': 'block !important'});
		// }
		$(".v2_signup_overlay").css('display', 'block');

		$(".v2_sign_up").addClass('open').css('display','block');

		$(".v2_sign_up").removeClass('close');
		$(".v2_log_in").removeClass('open').addClass('close');
		return false;
	}

	

	function show_login_popop_forget_password(){

		

			var $aSelected = $('.v2_sign_up');

			if( $aSelected.hasClass('close') ){

					

						$('.v2_sign_up').addClass('open').removeClass('close');

						$('.v2_sign_up').show();

			}else{

			

				$('.v2_sign_up').addClass('open').removeClass('close');

				$('.v2_sign_up').show();

			}

	}

</script>
<script>
	window.fbAsyncInit = function() {
		FB.init({
		appId      : '688073574590787', // replace your app id here
		channelUrl : 'https://mysitti.com/user_social.php', 
		status     : true, 
		cookie     : true, 
		xfbml      : true  
		});
	};
	(function(d){
		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/en_US/all.js";
		ref.parentNode.insertBefore(js, ref);
	}(document));

	function FBLogin(){

		var usertype = 'user';

		FB.login(function(response){
			if(response.authResponse){
				window.location.href = "index.php?action=fblogin&type="+usertype;
				// window.location.href = "user_social.php?action=fblogin";
			}
		}, {scope: 'email,user_likes,publish_stream'});
	}

	function FBLogout(){
		FB.logout(function(response) {
			//window.location.href = "index.php";
		});
	}

</script>
</head>

<body>
<div class="slider_body">
  <ul>
	<li><img src="images/v2_bgmain.jpg" alt=""></li>
  </ul>
</div>
<?php 
	if(!isset($_SESSION['user_id']))
	{
		function hexrgb ($hexstr)
		{
			$int = hexdec($hexstr);

			return array("red" => 0xFF & ($int >> 0x10),
					   "green" => 0xFF & ($int >> 0x8),
					   "blue" => 0xFF & $int);
		}
	}

?>
<script type="text/javascript">

	$(document).ready(function(){

		$('#hostTab').click(function(){

			$('.v2_tab_content').find('#host').css('display','block');

			$('.v2_tab_content').find('#user').css('display','none');

			$(this).addClass('v2_active_tab');

			$('#userTab').removeClass('v2_active_tab');

		});

		$('#userTab').click(function(){

			$('.v2_tab_content').find('#host').css('display','none');

			$('.v2_tab_content').find('#user').css('display','block');

			$(this).addClass('v2_active_tab');

			$('#hostTab').removeClass('v2_active_tab');

		});

	});

</script>
<input type="hidden" value="<?php echo $SiteURL; ?>" id="siteURL" />
<div id="v2_wrapper">

<!-- v2_wrapper main outer wrapper starts-->

<div class="v2_banner_top nobanner">
  <div class="v2_header_wrapper">
	<div class="v2_top_nav withoutLoginHeader bgcolor"><!-- v2_top_nav  starts-->
	  
	  <div class="v2_container">
		<div class="v2_login withoutLogin">
		  <ul>
			<li>
			  <label id="v2_signup" for="signup">Sign Up</label>
			  <input type="checkbox" id="signup">
			  <div class="v2_sign_up" id="v2_sign_up_after">
				<h1>Sign Up Here</h1>
				<a href="javascript:void(0);" class="v2_close_signup">close</a>
				<div class="clear"></div>
				<div class="v2_signup_tabcontainer">
				  <ul id="v2_tabs_signup" style="display:none;">
					<li><a class="v2_active_tab" id="hostTab" href="#host">HOST</a></li>
					<li><a href="#user" id="userTab">USER</a></li>
				  </ul>
				  
				  <!-- Tab panes -->
				  
				  <div class="v2_tab_content">
					<div  id="host" style="display: none;">
					  <form action="<?php echo $SiteURL; ?>signup_club.php" method="post" class="tab_standerd " id="signupes" name="signupes" novalidate="novalidate" >
						<div class="clear"></div>
						<p>
						  <input type="text" required="" placeholder="Email Address" onblur="ChkUserId(this.value,'club','<?php echo $SiteURL;?>');" name="club_email">
						</p>
						<p>
						  <input type="text" required="" placeholder="Zip Code" id="zipcode" maxlength="8" name="zipcode">
						</p>
						<div class="clear"></div>
						<p>
						  <input type="password" required="" placeholder="Password" id="password2" name="password">
						</p>
						<p>
						  <input type="password" required="" placeholder="Confirm Password" name="cpassword">
						</p>
						<div class="clear"></div>
						<span class="v2_accept_terms">
						<input type="checkbox" value="1" id="acknowledgement" name="acknowledgement">
						<span>I have read and agree to the</span> <a href="javascript:vois(0)" onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Privacy Policy*</a> </span>
						<div class="clear"></div>
						<input type="hidden" value="free" name="plantype">
						<input type="hidden" value="1" name="planid">
						<input type="submit" name="submit" value="Sign Up">
					  </form>
					</div>
					<script type="text/javascript">
	function displayFields()
	{
		$('p#hostsFields').toggle();
		if($('input#hosttype').is(':checked'))
		{
			$('#userTYPE').val('club');
		}
		else
		{
			$('#userTYPE').val('user');
		}
	}
</script>
					<style type="text/css">
	#signupd p input#hosttype {
		float: left !important;
		left: 0;
		position: relative;
		top: 0;
	}
	.v2_tab_content p span {
		border: 1px solid #ccc;
		box-sizing: border-box;
		float: left;
		margin-top: 15px;
		padding: 8px 5px;
		width: 94%;
		line-height: 20px;
	}
	#Businesscheck > span {
		  float: left;
		  line-height: 20px;
	}

.mejs-mediaelement, .mejs-inner {
  float: left;
  width: 100%;
  height: 100%;
}


.mejs-layers .mejs-overlay {
  left: 0;
  position: static !important;
  top: 0;
}

.TV {
  float: left;
  height: 100%;
  width: 100%;
}

</style>
					<div  id="user" >
					  <form autocomplete="off" name="signupd" id="signupd" class="tab_standerd v2_user_reg" method="post" action="paymentoption.php" >
						<p>
						  <input tabindex="1" type="text" name="email" onblur="return ChkUserId(this.value,'user','<?php echo $SiteURL;?>');" placeholder="Email Address" required autocomplete="off"  >
						</p>
						<p>
						  <input autocomplete="off" tabindex="4" type="password" name="password" id="password" placeholder="Password" required >
						</p>
						<div class="clear"></div>
						<p>
						  <input autocomplete="off" tabindex="2" type="text" name="zipcode" id="zipcode" maxlength="8"   placeholder="Zip Code" required >
						</p>
						<p>
						  <input autocomplete="off" tabindex="5" type="password" name="cpassword" placeholder="Confirm Password" required >
						</p>
						<div class="clear"></div>
						<p>
						  <input autocomplete="off" tabindex="3" type="text" name="profilename" onblur="return ChkUserProfile(this.value,'user','<?php echo $SiteURL;?>');"  placeholder="Profile Name" required="">
						</p>
						<p style="display:none;" id="hostsFields">
						  <select id="host_category" tabindex="6" name="host_category" required>
							<option value="">Select type of Business</option>
							<?php

									$cat_query = mysql_query("SELECT * FROM club_category WHERE parrent_id = 0 AND id IN ('91', '92', '101', '96', '97', '1', '102','103','104','106', '107', '108', '109') ORDER BY name ASC");

									while($get_cats = mysql_fetch_assoc($cat_query)){ ?>
							<option   value = "<?php echo $get_cats['id'] ?>"><?php echo $get_cats['name'] ?></option>
							<?php } ?>
						  </select>
						</p>
						<div class="clear"></div>
						<span class="v2_accept_terms">
						<input name="acknowledgement" id="acknowledgement" type="checkbox" value="1" />
						<span>I have read and agree to the</span> <a style="float: left; padding: 0 10px 0 0;" href="javascript:vois(0)" onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Privacy Policy*</a> <span style="float:right; margin:0 !important;" id="Businesscheck">
						<input style="float:left;" onclick="displayFields();" type="checkbox" name="hostTYPE" id="hosttype"  />
						<span>Are you a business?</span></span> </span>
						<div class="clear"></div>
						<input type="hidden" value="free" name="plantype">
						
						<!-- <input type="hidden" value="<?php echo $code;?>" name="captchcodeuser" id="captchacodeuser"> -->
						
						<input type="hidden" value="1" name="planid">
						<input type="hidden" value="user" name="UserType" id="userTYPE" />
						<input type="submit" name="submit" value="Sign Up">
					  </form>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="v2_signup_overlay"></div>
			</li>
			<li>
			  <label id="v2_log_in" for="login">Login</label>
			  <input type="checkbox" id="login">
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
				  <div class="v2_login_brand"> <a href="<?php echo $SiteURL;?>index.php" id="loginLogo"> <img src="images/v2_logo_round_1.png" alt=""> </a> </div>
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
					  <p>
					  <div class="clear"></div>
					  <input type="submit" name="submit" value="Login">
					  </p>
					</form>
					<div class="clear"> </div>
				  </div>
				  <p><a href="<?php echo $SiteURL; ?>forget_pwd.php">Forgot Password</a></p>
				  <p class="cleataccount">Don't have a MySitti account? <a href="#" onclick="show_login_popop(); return false;">Sign up now</a>
				  <div class="socialmedia"> <a onclick="FBLogin();" href="javascript:void(0);" target="blank"> <img alt="Login from Facebook" src="images/facebook1.png"></a> <a href="<?php echo $instaURL; ?>" target="_blank"> <img src="instagram.png"> </a>
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
			{
		?>
					<a href="<?php echo $authUrl; ?>" target="blank"><img alt="Login from Google Plus" src="images/googleplus1.png"></a>
					<?php                       	} 	?>
				  </div>
				</div>
			  </div>
			  <div class="v2_login_overlay"></div>
			</li>
			<li>
			<li class="helpfordesk"><a href="<?php echo $SiteURL; ?>support.php" class="v2_help"> Help </a></li>
			</li>
		  </ul>
		  <div class="v2_filter_box" id="topCitySearch"> 
			
			<!-- <a class="v2_filter_menu" id="toggle-menu" href="#">Atlanta, GA<img alt="Menu" src="images/filter_icon.png"></a> -->
			
			<div id="Search_box_filter" >
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
				  Set as default city </p>
				<p> 
				  
				  <!-- <input type="button" id="submit" name="search"  value="Switch City" class="button"> -->
				  
				  <input type="button" class="button" value="Switch City" onclick="validate_city_Form();" name="search" id="submit">
				</p>
			  </form>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- v2_top_nav  ends-->
	
	<div class="clear"></div>
	<?php 

		if($_SERVER['SCRIPT_NAME'] != '/forget_pwd.php')

		{



	  ?>
	<div class="v2_container">
	  <div class="logoleft">
		<div class="v2_brand"> <a href="index.php"> <img src="images/v2_logo_round.png" alt="" />
		  <div class="clear"></div>
		  <span  id="searchArea">Making Every City Your City</span> </a> </div>
	  </div>
	  <?php 
	  date_default_timezone_set('America/Chicago');

$day = date('l');



$getVideos1 = mysql_query("SELECT * FROM mysittiTV WHERE `weekDay` = '$day' ORDER BY `trackno` ASC ");
$getDefault = mysql_fetch_assoc($getVideos1);
if($getDefault['user_type'] == 'club')
{
	$getClubInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$getDefault[host_id]'  ");
	$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
	if(!empty($fetchClubInfo['club_name']))
	{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
		$HostNAME = $fetchClubInfo['club_name'];
		$HostImage = str_replace('../', '', $fetchClubInfo['image_nm']);
	}
	else
	{
		$HostNAME = 'MySitti';
		$HostImage = 'images/man4.jpg';
	}
	if(!isset($_SESSION['user_id']))
	{
		$profileURL = $SiteURL.$fetchClubInfo['club_name'];
	}
	else
	{
		$profileURL = $SiteURL.'host_profile.php?host_id='.$fetchClubInfo['id'];	
	}
	
}
else
{
	$getClubInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '$getDefault[host_id]'  ");
	$fetchClubInfo = mysql_fetch_assoc($getClubInfo);	
	if(!empty($fetchClubInfo['profilename']))
	{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
		$HostNAME = $fetchClubInfo['profilename'];
		$HostImage = str_replace('../', '', $fetchClubInfo['image_nm']);
	}
	else
	{
		$HostNAME = 'MySitti';
		$HostImage = 'images/man4.jpg';
	}
	$profileURL = $SiteURL.'profile.php?id='.$fetchClubInfo['id'];
}


$getVideos = mysql_query("SELECT * FROM mysittiTV WHERE `weekDay` = '$day' /*AND `id` != '$getDefault[id]'*/ ORDER BY `trackno` ASC ");


			?>
	  <div class="v2_search_area MysittiTvBlock">
	   <!-- <h1>MySitti TV</h1>-->
		<div class="clear"></div>
		<div class="play_vid_current battleTv newMysittiBlock">
		  <div class="hoster">
			<div class="Hthumb" id='hostThumb'> <img src="<?php  echo $SiteURL.$HostImage;?>" alt=""/> </div>
			<div class="Hname" id='hostName'> <a style="cursor: pointer; color:#FFF;text-decoration: none;" href="<?php echo $profileURL;?>">
			  <?php  echo $HostNAME;?>
			  </a> </div>
		  </div>
		  <?php 
		  	if(strrpos($getDefault['video_path'], 'youtube.com') == true || strrpos($getDefault['video_path'], 'youtu.be') == true)
		  	{
		  		$type = "video/youtube";
		  	}
		  	else
		  	{
		  		$type = "video/mp4";
		  	}


		  ?>
		 
<div class="TV">
			<video id="tv_main_channel" width="400" preload="none" >
				<source id="mp4Source" src="<?php echo str_replace('../', '', $getDefault['video_path']); ?>" type="<?php echo $type;?>">
		  	</video>
		  	
		  	<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script> -->
<script src="http://mediaelementjs.com/js/mejs-2.9.2/mediaelement-and-player.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	 	setTimeout(function(){
			var player1;
			if($('#tv_main_channel').length > 0)
			{
				if($.browser.msie) {
					$('#tv_main_channel').attr('autoplay', 'true');
				}
				player1 = new MediaElementPlayer('#tv_main_channel', {
					features: ['playpause','progress','current','duration','tracks','volume','fullscreen'],
					startVolume: 0.0
				});
				if(!$.browser.msie) {
					player1.play();
				}
			}
	 	}, 2000);
		

	});
</script>
		  	<!-- <video width="640" height="360" id="tv_main_channel" preload="none">
		    		<source type="video/youtube" src="https://youtu.be/vjIx8aUl2J8" />
			</video> -->
			</div>
		</div>







		<div class="MySittiplaylist">
		  <ul id="playlist">
			<h2>Programs</h2>
			<?php 
			$i = 0;
				while($rowVideos = mysql_fetch_assoc($getVideos))
				{
					if($rowVideos['user_type'] == 'club')
					{
						$getClubInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$rowVideos[host_id]'  ");
						$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
						if(!empty($fetchClubInfo['club_name']))
						{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
							$HostNAME1 = $fetchClubInfo['club_name'];
							$HostImage1 = str_replace('../', '', $fetchClubInfo['image_nm']);
						}
						else
						{
							$HostNAME1 = 'MySitti';
							$HostImage1 = 'images/man4.jpg';
						}
						
					}
					else
					{
						$getClubInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '$rowVideos[host_id]'  ");
						$fetchClubInfo = mysql_fetch_assoc($getClubInfo);	
						if(!empty($fetchClubInfo['profilename']))
						{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
							$HostNAME1 = $fetchClubInfo['profilename'];
							$HostImage1 = str_replace('../', '', $fetchClubInfo['image_nm']);
						}
						else
						{
							$HostNAME1 = 'MySitti';
							$HostImage1 = 'images/man4.jpg';
						}
					}
					$path = str_replace('../', '', $rowVideos['video_path']);


					?>
			<li  class='<?php if($i == '0'){ echo "active";} ?>' id='play_<?php echo $i;?>'> 
				<a href="javascript:void(0);" onclick="changesrc('<?php echo $path;?>');" id='video_<?php echo $rowVideos['id'];?>' > <?php echo $rowVideos['video_title'].' <br />By '.$HostNAME1;?><br />
			  </a> </li>
			<?php 
						$i++;
				}
			?>
		  </ul>
		</div>
	  </div>
	</div>
	<style type="text/css">
		@media only screen and (max-width: 480px) {
			.battleTv .TV .mejs-container
			{
				height: 320px !important;
			}
		}
		.posted_image_box a > div object, embed {
			max-width: 99%;
			width: 99% !important;
			height: 100% !important;
		}
		.me-plugin {
			position: absolute;
			float: left;
			width: 100% !important;
			height: 100% !important;
		}

	</style>
	<script src="http://mediaelementjs.com/js/mejs-2.9.2/mediaelement-and-player.min.js"></script>
	<script type="text/javascript">
		function changesrc(link)
		{
			var isYoutube = link && link.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
			if(isYoutube)
			{
				$.ajax({
					type: "POST",
					url: "test123.php",
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
						var player = new MediaElementPlayer('#tv_main_channel');

						$('.mejs-controls').find('.mejs-playpause-button').find('button').trigger('click');
					}
				});
			}
			else
			{
				$.ajax({
					type: "POST",
					url: "test123.php",
					data: {
						'action': "changeVideoInfo", 
						'videoid' : link,
						'link': 'mp4'
					},
					success: function( data ) 
					{
						$('.TV').html(data);
						//player.play():
						var player = new MediaElementPlayer('#tv_main_channel');
					}
				});
			}
		}
	</script>
	<div class="clear"></div>
	<div class="newmenu_mobile nav_tv">
	  <ul>
		<li>
		  <div class="next">
			<div id="dromMenu" class="heads"><img src="images/Contest.png" alt="">
			  <label> Contests</label>
			</div>
		  </div>
		  <div class="menupopup">
			<ul>
			  <!--<li><a href="<?php echo $SiteURL;?>live_host_contests.php">Live Contests</a></li>-->
			  <li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">Mysitti Contests</a></li>
			  <li><a href="<?php echo $SiteURL;?>current_host_contests.php">Host Contests</a></li>
			</ul>
		  </div>
		</li>
		<li><a href="searchEvents.php">
		  <div class="next">
			<div class="heads"><img src="images/CityEvents.png" alt="">
			  <label> City Events</label>
			</div>
		  </div>
		  </a> </li>
		<li><a href="city_talk.php">
		  <div class="next">
			<div class="heads"><img src="images/CityTalk.png" alt="">
			  <label>City Talk</label>
			</div>
		  </div>
		  </a> </li>
		<li><a href="advanced_filters.php?cat_id=1">
		  <div class="next">
			<div class="heads"><img src="images/HotSpots.png" alt="">
			  <label>Host </label>
			</div>
		  </div>
		  </a> </li>
		<li><a href="MySittiTV.php" class="">
		  <div class="next">
			<div class="heads"><img src="images/mtv.png" alt="">
			  <label>Mysitti TV</label>
			</div>
		  </div>
		  </a> </li>
		<li><a href="battle.php" class="">
		  <div class="next">
			<div class="heads"><img src="images/batttle.png" alt="">
			  <label>Live Battle</label>
			</div>
		  </div>
		  </a> </li>
		<li><a href="#searchArea" class="">
		  <div class="next">
			<div class="heads"><img src="images/searchEvent.png" alt="">
			  <label>Search</label>
			</div>
		  </div>
		  </a> </li>
		<li><a href="support.php" class="">
		  <div class="next">
			<div class="heads"><img src="images/Helpout.jpg" alt="">
			  <label>Help</label>
			</div>
		  </div>
		  </a> </li>
	  </ul>
	</div>
	<div class="clear"></div>
	<?php } ?>
	<div class="clear"></div>
	<div class="v2_header fordesk bgnone">
	  <div class="v2_container">
		<div id="search_Events" class="v2_search-area newSearch">
		  <?php 

				if(isset($_POST['ssss']))
				{	
					if(!empty($_POST['keyword_search']) )
					{
						$EVENTNAME = $_POST['keyword_search'];
						$default = "none";
					}
					else
					{
						$EVENTNAME = "";
						$EVENTCAT = $_POST['eventcat'];
						if(!empty($_POST['date_s']) )
						{
							$EVENTDATE = $_POST['date_s'];
						}
					}
				}
				?>
		  <form method="POST" action="searchEvents.php" class="newforms" style="float: left; width:100% !important;">
			<div class="v2_date v2_input_search">
			  <input type="text" name="date_s" class="onlyDate"  id="datetimepicker_search" value="<?php echo $EVENTDATE; ?>" placeholder="Select Date"  />
			</div>
			<div class="v2_cat">
			  <select id="eventcatselect" name="eventcat">
				<option value="">Select Category</option>
				<?php 

									$d_category = "9";
									


									while($fetchEventCategory = mysql_fetch_assoc($getEventsCategory))
									{
										if( isset($_GET['c']) ) 
										{
											$EVENTCAT = $_GET['c'];
										}
										elseif(isset($_POST['eventcat'])  ) 
										{ 
											$EVENTCAT = $_POST['eventcat'];
										}
										?>
				<option <?php if($EVENTCAT == $fetchEventCategory['id']){ echo "selected";} ?>  value="<?php echo $fetchEventCategory['id'];?>"><?php echo $fetchEventCategory['catname'];?></option>
				<?php 

									}

								?>
			  </select>
			</div>
			<div class="v2_input_search">
			  <input type="text" id="eventsearch" name="keyword_search"  value="<?php echo $EVENTNAME; ?>" placeholder="Search"  />
			</div>
			<div class="v2_btn-search">
			  <input type="submit" value="Search" name="ssss" />
			</div>
			<div class="clear"></div>
		  </form>
		  <div class="clear"></div>
		</div>
		<div class="v2_nav newNav  ">
		  <ul>
			<li> <a href="index.php"> <span data-title="Home">Home</span> </a> </li>
			<li> <a href="searchEvents.php"> <span data-title="City Events">City Events</span> </a> </li>
			<li> <a href="<?php echo $SiteURL;?>city_talk.php"> <span data-title="City Talk">City Talk</span> </a> </li>
			<li> <a href="#"> <span data-title="Contest">Contest</span> </a>
			  <ul>
				
				<!--<li><a href="<?php echo $SiteURL;?>live_host_contests.php">Live Contests</a></li>-->
				
				<li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">Mysitti Contests</a></li>
				<li><a href="<?php echo $SiteURL;?>current_host_contests.php">Host Contests</a></li>
			  </ul>
			</li>
			<li> <a href="<?php echo $SiteURL;?>battle.php"> <span data-title="Live Battle">Live Battle</span> </a> </li>
			<li> <a href="<?php echo $SiteURL;?>MySittiTV.php#tv"> <span data-title="MySitti TV">MySitti TV</span> </a> </li>
		  </ul>
		</div>
	  </div>
	</div>
	<div class="clear"></div>
	<div id="search_Events" class="v2_search-area formob">
	  <?php 

				if(isset($_POST['ssss']))
				{	
					if(!empty($_POST['keyword_search']) )
					{
						$EVENTNAME = $_POST['keyword_search'];
						$default = "none";
					}
					else
					{
						$EVENTNAME = "";
						$EVENTCAT = $_POST['eventcat'];
						if(!empty($_POST['date_s']) )
						{
							$EVENTDATE = $_POST['date_s'];
						}
					}
				}
				?>
	  <form method="POST" action="searchEvents.php" style="float: left; width:100% !important;">
		<div class="v2_date v2_input_search">
		  <input type="text" name="date_s" class="onlyDate"  id="datetimepicker_search" value="<?php echo $EVENTDATE; ?>" placeholder="Select Date"  />
		</div>
		<div class="v2_cat">
		  <select id="eventcatselect" name="eventcat">
			<option value="">Select Category</option>
			<?php 

									$d_category = "9";
									


									while($fetchEventCategory = mysql_fetch_assoc($getEventsCategory))
									{
										if( isset($_GET['c']) ) 
										{
											$EVENTCAT = $_GET['c'];
										}
										elseif(isset($_POST['eventcat'])  ) 
										{ 
											$EVENTCAT = $_POST['eventcat'];
										}
										?>
			<option <?php if($EVENTCAT == $fetchEventCategory['id']){ echo "selected";} ?>  value="<?php echo $fetchEventCategory['id'];?>"><?php echo $fetchEventCategory['catname'];?></option>
			<?php 

									}

								?>
		  </select>
		</div>
		<div class="v2_input_search">
		  <input type="text" id="eventsearch" name="keyword_search"  value="<?php echo $EVENTNAME; ?>" placeholder="Search"  />
		</div>
		<div class="v2_btn-search">
		  <input type="submit" value="Search" name="ssss" />
		</div>
		<div class="clear"></div>
	  </form>
	  <div class="clear"></div>
	</div>
  </div>
  <!-- END v2_header_wrapper --> 
  
</div>
<!-- v2_banner_top -->

<div class="clear"></div>
<?php 

include('image_upload_resize.php');



include("resize-class.php");

include("user_upgrade.php");

/* COMMON FUNCTIONS */



function detect_mobile()

{

	return false;

}



function detect_mobile_new()

{



	if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))

	return true;

	 

	else

	return false;

}





/* detect_stream added by kbimn on 30-01-2015 */

function detect_stream($hbhost)
{
	$st_qry = 'ffmpeg -i rtsp://54.174.85.75:1935/httplive/'.$hbhost.' 2>&1; echo $?';
		 
	$st_res=(string)trim(shell_exec($st_qry));
					
	if (strpos($st_res,'404 Not Found') === false) {
		return true;
	}
	else
	{	
		$st_qry = 'ffmpeg -i rtsp://54.174.85.75:1935/videowhisper-x/'.$hbhost.' 2>&1; echo $?';
		 
		$st_res=(string)trim(shell_exec($st_qry));
						
		if (strpos($st_res,'404 Not Found') === false) {
			return true;
		}

	}
	
	return false;

}





function clean($string) {


	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.



	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

}



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


$city_name_query = @mysql_query("SELECT city_name FROM capital_city WHERE city_id = '".$_SESSION['id']."'");



$get_city_name = mysql_fetch_assoc($city_name_query);

$dropdown_city = $get_city_name['city_name'];





$state_name_query = @mysql_query("select code FROM zone where zone_id = '".$_SESSION['state']."' and status ='1'");



$get_state_name = mysql_fetch_assoc($state_name_query);

$dropdown_state = $get_state_name['code'];

?>

<!--  TOP SEARCH SCRIPT --> 
<style type="text/css">
	.mejs-container.mejs-video {
  float: left;
  width: 100% !important;
  height: 100% !important;
}
</style>

<script type="text/javascript">

	$(document).ready(function(){

		$('#Search_box_filter').hide().before('<a href="#" id="toggle-menu" class="v2_filter_menu"><?php echo $dropdown_city; ?>, <?php echo $dropdown_state; ?><img src="images/dropIcon.png" alt="Menu" /></a>');

		$('a#toggle-menu').click(function (e) {

			e.preventDefault();

			$('#Search_box_filter').slideToggle(200);

		});
		$('#dropdownlistContentjstate_name').find('input[type="textarea"]').val('<?php echo $set_state_name;?>');
		$('#dropdownlistContentjcity_name').find('input[type="textarea"]').val('<?php echo $set_city_name; ?>');

		getYoutubeLinks();
		//init();
	});


function getYoutubeLinks()
{
	//console.clear();
	// videos = document.getElementById("tv_main_channel");
	videos = document.querySelectorAll("video");
	for (var i = 0, l = videos.length; i < l; i++) 
	{
		var video = videos[i];
		var src = video.src || (function () 
		{
			var sources = video.querySelectorAll("source");
			for (var j = 0, sl = sources.length; j < sl; j++) 
			{
				var source = sources[j];
				var type = source.type;
				var isMp4 = type.indexOf("mp4") != -1;
				if (isMp4) return source.src;
			}
			return null;
		})();
		if (src) 
		{
			var isYoutube = src && src.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
			if (isYoutube) 
			{
				var id = isYoutube[1].match(/watch\?v=|[\w\W]+/gi);
				id = (id.length > 1) ? id.splice(1) : id;
				id = id.toString();
				var mp4url = "http://www.youtubeinmp4.com/redirect.php?video=";
				video.src = mp4url + id;
				$('#mp4Source').attr('src',mp4url + id);
			}
		}
	}
}
var audio;
var playlist;
var tracks;
var current;

/*
function init()
{
	current = 0;
	audio = $('#tv_main_channel');
	playlist = $('#playlist');
	tracks = playlist.find('li');
	//alert(tracks);
	var tt = $('#playlist li').length;
	//
	len = tracks.length;
	//alert(len);
	audio[0].volume = .10;
	audio[0].play();
	playlist.find('a').click(function(e){
		e.preventDefault();
		link = $(this);
		current = link.parent().index();
		//run(link, audio[0]);
		var isYoutube = link.attr('href') && link.attr('href').match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
		if(isYoutube)
		{
			$.ajax({
				type: "POST",
				url: "test123.php",
				data: {
					'action': "changeVideoInfo", 
					'videoid' : link.attr('href')
				},
				success: function( data ) 
				{
					$('.TV').html(data);
					//player.play():
				}
			});
		}
		else
		{
		//	var audio = new MediaElementPlayer('#tv_main_channel');
			$('#mp4Source').attr('type','video/mp4');
			audio[0].pause();
			$('#mp4Source').attr('src',link.attr('href'));
			$('#tv_main_channel').attr('src',link.attr('href'));
			audio[0].play();
		}
		// ... more code ...
		

		// return false;
	});
	audio[0].addEventListener('ended',function(e){
		current++;
		//current = current - 1;
		if(current >= len ){
			current = 0;
			link = playlist.find('a')[0];
		}else{
			link = playlist.find('a')[current];    
		}

		run($(link),audio[0]);

	});
}

function run(link, player){
	player.src = link.attr('href');
	var newID = link.attr('id');
	
	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'action': "changeVideoInfo", 
			'videoid' : newID
		},
		success: function( data ) 
		{
			var dd = data.split('++++');
			$('#hostThumb').find('img').attr('src',dd[1]);
			$('#hostName').find('a').text(dd[0]);
			$('#hostName').find('a').attr('href',dd[2]);
		}
	});

	$('#mp4Source').attr('src',link.attr('href'));

	par = link.parent();
	par.addClass('active').siblings().removeClass('active');
	var isYoutube = link.attr('href') && link.attr('href').match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
	// if (isYoutube) 
	// {
	// 	getYoutubeLinks();
	// }
	
	audio[0].load();
	audio[0].play();
}
*/



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

						//$('#submit').val('abc');

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

 

</script> 

<!-- END TOP SEARCH SCRIPT --> 

<!-- BACKGROUND SLIDER CODE -->

<?php

/* host custom background code goes here */



if(isset($_GET['host_id'])  )

{

	if(isset($_GET['host_id']))

	{

		$hostID = $_GET['host_id'];

	}

	else

	{

		$hostID = $hostID;

	}

	

	$get_host_bk_query = mysql_query("SELECT background_name FROM host_background WHERE user_id = '".$hostID."' AND status = '1' AND user_type = 'club'");

	$count_host_background = mysql_num_rows($get_host_bk_query);

	

	if($count_host_background == 1)

	{

		$host_bkground_img = mysql_fetch_assoc($get_host_bk_query);

		$host_bg_img = "/host_banner/".$host_bkground_img['background_name'];

	?>
<script type="text/javascript">

			$(document).ready(function(){

				var imgsrc = '<?php echo $host_bg_img; ?>';

				$('.slider_body ul').find('img').attr('src',imgsrc);

			});

		</script>
<?php

	}

}

elseif($_SESSION['user_type'] == "club")

{

	

	$get_host_bk_query = mysql_query("SELECT background_name FROM host_background WHERE user_id = '".$_SESSION['user_id']."' AND status = '1' AND user_type = 'club'");

	$count_host_background = mysql_num_rows($get_host_bk_query);

	

	if($count_host_background == 1)

	{

		$host_bkground_img = mysql_fetch_assoc($get_host_bk_query);

		$host_bg_img = "/host_banner/".$host_bkground_img['background_name'];

?>
<script type="text/javascript">

			$(document).ready(function(){

				var imgsrc = '<?php echo $host_bg_img; ?>';

				$('.slider_body ul').find('img').attr('src',imgsrc);

			});

		</script>
<?php

	}

}



/* host custom background code goes here */

/*----------------------------------------------------------------------*/



$get_time = @mysql_query("SELECT * FROM refresh_background_time");

$time = @mysql_fetch_assoc($get_time);

?>
<script type="text/javascript">

	$(document).ready(function(){

		

		var time = '<?php echo $time['time_interval']; ?>';

		

		setInterval(function() {

			

			var cityid = '<?php echo $_SESSION['id']; ?>';

			

			$.ajax({

				type: "POST",

				url: "refreshajax.php",

				data: {

				'arrange_images': "arrange_images", 

				'cityid' : cityid 

				},

				success: function( msg ) 

				{

				//	alert(msg);

					if( (msg == 'disable') || (msg == '') ) 

					{

						//$('.home_wrapper').css('background-image', 'url(/images/homebg.png)');

						$('.slider_body ul').find('img').attr('src','/images/homebg.png');

								

					}

					else

					{

						// $('.home_wrapper').css('background-image', 'url('+msg+')');	

						$('.slider_body ul').find('img').attr('src',msg);			

					}

				}

			  });		

			  // }, 1000);	

		}, 1000 * 60 * time); // where X is your every X minutes								

		

	});

</script>
<?php 



if(isset($_COOKIE['backgroundcookie']) && ($_COOKIE['backgroundcookie'] != '/images/homebg.png' ) )

{

?>
<script type="text/javascript">

		$(document).ready(function(){

			var imgsrc = '<?php echo $_COOKIE["backgroundcookie"]; ?>';

			$('.slider_body ul').find('img').attr('src',imgsrc);

		});

	</script>
<?php }



  

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

//}




 

?>

<!-- END BACKGROUND CODE --> 
<script type="text/javascript">
	$(document).ready(function(){
		refreshCaptcha('<?php echo $SiteURL; ?>');
	});
</script>