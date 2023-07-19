<?php  
	$currentDatetime = date('Y-m-d H:i:s');

	$currentDate = date('Y-m-d');

	$currentTime = date('H:i:s');

	$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
	// $SiteUrl = 'https://mysitti.com/';
	
	$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";

	$ABSPATH =$_SERVER['DOCUMENT_ROOT']."/";

	$getEventsCategory = mysql_query("SELECT * FROM `eventcategory` ORDER BY `catname` ASC ");

/* TOP SEARCH CODE */
include('defaultimeZone.php'); ?>

<link rel="stylesheet" href="css/bootstrap.min.css">
<link href="/css/jquery.bxslider.css" rel="stylesheet" />
<link href="<?php echo $SiteURL; ?>css/stylesNew.css" rel="stylesheet"  type="text/css">
<link rel="stylesheet" href="css/widgets.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/jslider.css" type="text/css">
<link rel="stylesheet" href="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>

<script src="<?php echo $CloudURL; ?>js/jquery.bxslider.js"></script>
<script src='<?php echo $CloudURL; ?>js/jqueryvalidationforsignup.js'></script>
<script src="<?php echo $CloudURL;?>js/register.js" type="text/javascript"></script>
<script src="<?php echo $CloudURL;?>js/datetimepicker/jquery.datetimepicker.js"></script>
<script src="<?php echo $CloudURL;?>js/add.js" type="text/javascript"></script>
<script src="<?php echo $CloudURL;?>autocomplete/jquery.ajaxcomplete.js"></script>
<script type="text/javascript" src="<?php echo $CloudURL; ?>QapTcha-master/jquery/jquery-ui.js"></script>
<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="<?php echo $CloudURL; ?>lightbox/js/jquery.smooth-scroll.min.js"></script>
<script src="<?php echo $SiteURL; ?>js/custom.js"></script>
<script type="text/javascript" src="js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="js/tmpl.js"></script>
<script type="text/javascript" src="js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="js/draggable-0.1.js"></script>
<script type="text/javascript" src="js/jquery.slider.js"></script>
<script src="<?php echo $CloudURL; ?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jwplayer-7.2.4/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>
<script src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.pack.js"></script>
<script src="js/angular.min.js"></script>
<script type="text/javascript">
  !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t){var e=document.createElement("script");e.type="text/javascript";e.async=!0;e.src=("https:"===document.location.protocol?"https://":"http://")+"cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(e,n)};analytics.SNIPPET_VERSION="4.0.0";
  analytics.load("C2CqjCCpsi81VUIkVTmOud57gJGSSEZJ");
  analytics.page();
  }}();
</script>

<script>
	$(document).ready(function(){
		$('.bxslider_menu').bxSlider({
	  maxSlides: 3,
	  moveSlides: 1,
	  infiniteLoop: false,
	  slideWidth: 100,
	  slideMargin: 10
	});

		$('.bxslider_pic').bxSlider({
	  mode: 'fade',
	  auto: true,
	  autoControls: true,
		  captions: false
	});

	$('input[name="eventcat2"]').val(9);
		$("ul.bxslider_menu li a").click(function() {
			var elId = this.id;
			$('input[name="eventcat2"]').val(elId);
			$('ul.bxslider_menu li a').removeClass("active");
		    $(this).addClass("active");
		});

		});

	$(".before_login li label").click(function(){  $(".newCurrentCity").css("z-index", "1");  $(".v2_close_signup").click(function(){     $(".newCurrentCity").css("z-index", "9999");  });});

</script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".fancybox").fancybox();
	});
</script>


<script type="text/javascript">
	$(document).ready(function(){
		$(".sub-menuAm .more_li").click(function(){
			$(this).hide();
		    $(".sub-menuAm .li_show").css("display", "block");
		});
		$("#less_restrent").click(function(){
			$(".sub-menuAm .li_show").css("display", "none");
		    $(".sub-menuAm .more_li").css("display", "block");
		});
	});

	$(document).ready(function(){
		$('.sub-menuAm li').click(function(){
		   $.ajax("Header.php",{method:"post", data:{val:$(this).attr("data-value")}}); 
		});
	});

</script>


<?php session_start(); 
if (isset($_POST["val"])){
       $_SESSION["val"] = $_POST["val"];
}
?>

<!-- ======== Include Main Other Java scripts ======== -->

<?php
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


		<?php		die; 

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

			$zip_city = "SELECT * FROM `capital_city` WHERE  `city_name`= '$city'   " ;
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

	if(isset($_SESSION['subuser']))

	{

		$q1 = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$get_host_data['club_name']."'  ");

		$f1 = @mysql_fetch_array($q1);
	}

	else

	{

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

$instaURL = $instagram->getLoginUrlInsta();

?>

<!DOCTYPE HTML>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>mysitti.com || <?php echo $titleofpage; ?></title>

<meta name="viewport" content="width=device-width">
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<meta name="p:domain_verify" content="b812800cc41cd2b103f606bbda379e5b"/>

<link rel="shortcut icon" href="<?php echo $SiteURL;?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo $SiteURL;?>favicon.ico" type="image/x-icon">


<?php 
if(($_SERVER['SCRIPT_NAME'] == "/index.php"))
{
	?>
<meta name="google-site-verification" content="o-g5OxxDOWX2F__eELEb5UVS1lDerXIIc1hVhtJ4PpE" />
<meta name='B-verify' content='fc452fae810405f1fa3a7dba61393529df536296' />
<meta name="p:domain_verify" content="70c01a95a31eed9bd52d0de689eeb163"/>

<?php
}
?>

<!-- ======== Include Main Stylesheet ===============  -->

<link href="<?php echo $SiteURL; ?>css/v2style.css" rel="stylesheet" type="text/css">
<link href="<?php echo $SiteURL; ?>css/media.css" rel="stylesheet" type="text/css">
<link href="<?php echo $SiteURL; ?>css/v1style.css" rel="stylesheet" type="text/css">
<link href="<?php echo $SiteURL; ?>css/responsive.css" rel="stylesheet" type="text/css">
<link href="<?php echo $CloudURL; ?>css/jquery.bxslider.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $CloudURL; ?>lightbox/css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $CloudURL;?>js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $CloudURL;?>css/jukebox.css" />
<link href="<?php echo $CloudURL; ?>datepick/foundation-datepicker.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $CloudURL;?>autocomplete/jquery.ajaxcomplete.css" />
<link href="<?php echo $CloudURL; ?>tabby/tabby.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $SiteURL; ?>css/jquery-ui.css">
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM&libraries=places"></script>
<script src="../getCity/geo-contrast.jquery.js" type="text/javascript"></script>
<script src="../datepick/foundation-datepicker.js" type="text/javascript"></script>
<script src="../tabby/tabby.js" type="text/javascript"></script>
<script src="js/jquery-ui.js"></script>



<script>
var x = document.getElementById("demo");

// function getLocation() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
    
// }

function showPosition(position) {

	jQuery.post('ajaxcall.php', {
				'longitude':position.coords.longitude,
				'latitude':position.coords.latitude, 
				'get_visitor_geolocation': 'get_current_user_location' 
				},
				function(response){
		
				if (response == 'success') {
					// console.log(response);
					// window.location.href = '';

				}

				});	
}

</script>
<?php
	if(empty($_SESSION['id']) && !isset($_SESSION['id']) )
	{ 
		$id=54;
		$_SESSION['id']=$id;
		$_SESSION['state']='3668';
		$_SESSION['country']='223';
	} 
    elseif(isset($_GET['city'])) {
 		$dropdown_city = $_GET['city'];
 		$_SESSION['city_name'] = $_GET['city'];
 		$_SESSION['formatteds'] = $_GET['city'];
 		$dropdown_city = $_SESSION['city_name'];
 	}
 	elseif(empty($_SESSION['city_name'])){
 		$_SESSION['formatteds'] = 'Chicago, IL, USA';
 		$dropdown_city = $_SESSION['formatteds'];
 	}
 	elseif(isset($_SESSION['city_name'])){
 		$_SESSION['formatteds'] = $_SESSION['city_name'];
 		$dropdown_city = $_SESSION['formatteds'];
 	}
 	elseif(isset($_SESSION['city_id'])){
		$get_city['city_id'] = $_SESSION['city_id'] ;
		$_SESSION['id'] = $get_city['city_id'];
		$get_city['city_name'] = $_SESSION['city_name'];
		$postdata = $_SESSION['formatteds'];
		if(isset($_SESSION['formatteds'])){
			$dropdown_city = $postdata;
		}
	}
	elseif(!isset($_SESSION['city_id'])){
		$_SESSION['id'] = 51;
		$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
		$get_city_name = mysql_fetch_assoc($city_name_query);
		$dropdown_city = $get_city_name['city_name'];
		$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
		$get_state_name = mysql_fetch_assoc($state_name_query);
		$dropdown_state = $get_state_name['code'];
	}

if(isset($_GET['msg']) && $_GET['msg'] == 'error1'){ ?>

<script type="text/javascript">

	$(document).ready(function () {    

		$('#v2_log_in').trigger('click');

	});

</script>


<?php }

?>

<script type="text/javascript">

	$(document).ready(function () {

		$('#shw_logn_frm').live('click', function(){

			$.post('redirect_after_login_check.php', { 'unset_store_redirect': true }, function(response){ });

			var $aSelected = $('.v2_log_in');

			if( $aSelected.hasClass('close') ){ 
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
	function FBLogin(){

		var usertype = 'user';

		FB.login(function(response){
			if(response.authResponse){
				window.location.href = "index.php?action=fblogin&type="+usertype;
				
			}
		}, {scope: 'email,user_likes,publish_stream'});
	}

	function FBLogout(){
		FB.logout(function(response) {
			
		});
	}

</script>

<style>.async-hide { opacity: 0 !important} </style>
<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
})(window,document.documentElement,'async-hide','dataLayer',4000,
{'GTM-NWRKLW6':true});</script>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-45982925-1', 'auto');
ga('send', 'pageview');

</script>

</head>
<body>

<div class="slider_body">
	<ul>
	<li><img src="images/v2_bgmain.jpg" alt=""></li>
	</ul>
</div>

<?php if(!isset($_SESSION['user_id'])) {
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
		$('.b-close-album-515').click(function(){
			$('#popup3_album_515').hide();
		});

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

<div class="v2_banner_top">

<?php if($_SERVER['SCRIPT_NAME'] == '/searchEvents.php'){ ?>
	<div class="newCurrentCity cityevent_page">
		<div class="innerCurrentCity1">
			<h4>Going Out? Find what is going on in</h4>
			<div class="clear"></div>
			<div class="search_filtering">
			   <input id="geo-demo" type="text" class="geo" placeholder="Enter a destination" value="" data-find-address="<?php echo $dropdown_city; ?>" required>
				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>
			<h1><?php echo $dropdown_city.", ".$dropdown_state; ?></h1>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/city_talk.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Going Out? Find what is going on in</h4>
			<div class="clear"></div>
			<div class="search_filtering">
			   <input id="geo-demo" type="text" class="geo" placeholder="Enter a destination" value="" data-find-address="<?php echo $dropdown_city; ?>" required>
				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/city-guide.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Going Out? Find what is going on in</h4>
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/city-guide-events-deals.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Going Out? Find what is going on in</h4>
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/audio-tour-summary.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Going Out? Find what is going on in</h4>
			<div class="clear"></div>
			<div class="search_filtering">
			   <input id="geo-demo" type="text" class="geo" placeholder="Enter a destination" value="" data-find-address="<?php echo $dropdown_city; ?>" required>
				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/mysitti_contestsList.php') { ?>
			<div class="newCurrentCity citytalk_page">
				<div class="innerCurrentCity1">
					<h4>Got Skills? Bring it!!</h4>
					<div class="clear"></div>
				</div>
			</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/MySittiTV.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<h4>Spotlighting great local talent</h4>
			<div class="clear"></div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/isangoapi.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Go where you have never gone before!!</h4>
			<div class="clear"></div>
			<div class="search_filtering">
			   <input id="geo-demo" type="text" class="geo" placeholder="Enter a destination" value="" data-find-address="<?php echo $dropdown_city; ?>" required>
				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/flightframe.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<h4>Need a Vacation? Book your getaway!!</h4>
			<div class="clear"></div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/packageframe.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<h4>Save money with amazing package deals</h4>
			<div class="clear"></div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/rentalsframe.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<h4>Need a Ride!</h4>
			<div class="clear"></div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/vacationframe.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<h4>Do you want more than a hotel? Book your vacation home!!</h4>
			<div class="clear"></div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/bedandbreakfast.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<h4>B&B for the social traveler</h4>
			<div class="clear"></div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/destination.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<div class="clear"></div>
		</div>
		</div>

<?php } elseif ($_GET['activity'] == 'family') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<h4>Family Fun!</h4>
			<div class="clear"></div>
			<div class="search_filtering sportSearch">
			   <input id="geo-demo" type="text" class="geo" placeholder="Enter a destination" value="" data-find-address="<?php echo $dropdown_city; ?>" required>
			   <div class="filter_ticketCategory">
				</div>
				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>
		</div>
		</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/family.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<h4>Family Fun!</h4>
			<div class="clear"></div>
			<div class="search_filtering sportSearch">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			   <div class="filter_ticketCategory">
				</div>
				
			</div>
		</div>
		</div>			
		
<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/sports_event.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Find your sporting events or concerts!</h4>
			<div class="clear"></div>
			<div class="search_filtering sportSearch">
			   <input id="geo-demo" type="text" class="geo" placeholder="Enter a destination" value="" data-find-address="<?php echo $dropdown_city; ?>" required>
			   <div class="filter_ticketCategory">
				</div>
				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>
		</div>
	</div>

<?php } elseif ($_GET['activity'] == 'things-to-do') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<div class="search_filtering">
				<input type="text" data-find-address="<?php echo $dropdown_city; ?>" value="" placeholder="Enter a location" class="geo geocontrast" id="geo-demo" style="padding-right: 20px;" title="" autocomplete="on">
				<input type="submit" value="Search" class="filtering_button" id="for-faimly">
			</div>
		</div>
	</div>

<?php } elseif ($_GET['activity'] == 'sports-and-outdoors') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<div class="search_filtering">
				<input type="text" data-find-address="<?php echo $dropdown_city; ?>" value="" placeholder="Enter a location" class="geo geocontrast" id="geo-demo" style="padding-right: 20px;" title="" autocomplete="on">
				<input type="submit" value="Search" id="hitAjaxCity" class="filtering_button" id="for-outdoor">
			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allFoods.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<h4>Family Fun!</h4>
			<div class="search_filtering">

				<input type="hidden" data-find-address="<?php echo $dropdown_city; ?>" value="" placeholder="Enter a location" class="geo geocontrast" id="geo-demo" style="padding-right: 20px;" title="" autocomplete="off">

 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
				
			</div>
		
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allgroupon-tours.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<h4>Save On Your Tours</h4>
			<div class="search_filtering">

				<input type="hidden" data-find-address="<?php echo $dropdown_city; ?>" value="" placeholder="Enter a location" class="geo geocontrast" id="geo-demo" style="padding-right: 20px;" title="" autocomplete="off">

 					<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

 					<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			</div>
		
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/tours.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/yelp-tour.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Save On Your Tours</h4>
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			</div>
		</div>
	</div>


<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre-rock.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<div class="clear"></div>
			<div class="search_filtering">
              
			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

			   <input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

			   <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre-blues.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

			   <input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

			   <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				<!-- <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton"> -->

			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre-country.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

			   <input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

			   <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				<!-- <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton"> -->

			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre-jazz.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

			   <input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

			   <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				<!-- <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton"> -->

			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre-concerts-deals.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

			   <input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

			   <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				<!-- <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton"> -->

			</div>
		</div>
	</div>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allSports.php') { ?>
		<div class="newCurrentCity citytalk_page">
			<div class="innerCurrentCity1">
			<h4>Sports Zone</h4>
				<div class="clear"></div>
				<div class="search_filtering">

				   <input id="geo-demo" type="text" class="geo" placeholder="Enter a destination" value="<?php echo $_SESSION['city_name']; ?>" data-find-address="<?php echo $_SESSION['city_name']; ?>" required>

					<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
				</div>
			</div>
		</div>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/performing-arts.php') { ?>
		<div class="newCurrentCity citytalk_page">
			<div class="innerCurrentCity1">
			<h4>Creativity, Expression, and Inspiration</h4>
				<div class="clear"></div>
				<div class="search_filtering">

				   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

	 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

	 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				</div>
			</div>
		</div>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allperformingArts.php') { ?>
		<div class="newCurrentCity citytalk_page">
			<div class="innerCurrentCity1">
			<h4>Creativity, Expression, and Inspiration</h4>
				<div class="clear"></div>
				<div class="search_filtering">

				   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

	 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

	 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				</div>
			</div>
		</div>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/brewery.php') { ?>
		<div class="newCurrentCity citytalk_page">
			<div class="innerCurrentCity1">
			 	<h4>Cork and Barrel</h4>
				<div class="clear"></div>
				<div class="search_filtering">

				   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

	 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

	 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				</div>
			</div>
		</div>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allbrewery.php') { ?>
		<div class="newCurrentCity citytalk_page">
			<div class="innerCurrentCity1">
			 	<h4>Cork and Barrel</h4>
				<div class="clear"></div>
				<div class="search_filtering">

				   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

	 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

	 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				</div>
			</div>
		</div>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/comedy.php') { ?>
		<div class="newCurrentCity citytalk_page">
			<div class="innerCurrentCity1">
			<h4>Laugh With US!</h4>
				<div class="clear"></div>
				<div class="search_filtering">

				   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

	 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $dropdown_city ;?>"  required>

	 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				</div>
			</div>
		</div>

  	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allhoteldeals.php') { ?>
		<div class="newCurrentCity citytalk_page">
			<div class="innerCurrentCity1">
			<h4>  Plan a Vacation. Plan a Night Out. </br> Plan Smarter!</h4>
				<div class="clear"></div>
				<div class="search_filtering">

				   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

	 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

	 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
	                
				</div>
			</div>
		</div>	


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/seeallcomedy.php') { ?>
		<div class="newCurrentCity citytalk_page">
			<div class="innerCurrentCity1">
			<h4>Laugh With US!</h4>
				<div class="clear"></div>
				<div class="search_filtering">

				   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

	 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

	 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

				</div>
			</div>
		</div>	


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/concert.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Get Your tickets</h4>
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

			   <input id="target" type="text" class="geo geocontrast" placeholder="What are you looking for?" value="<?php echo $_SESSION['city_name']; ?>"  required>

			   <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			   <div class="concert-option">
			   	<h4>Categories</h4>
			   	<ul>
			   		<li><a href="#" data-category="Music">Music</a></li>
			   		<li><a href="#" data-category="Alternative Rock">Alternative Rock</a></li>
			   		<li><a href="#" data-category="Cabaret">Cabaret</a></li>
			   		<li><a href="#" data-category="Classical">Classical</a></li>
			   		<li><a href="#" data-category="Comedy">Comedy</a></li>
			   		<li><a href="#" data-category="Country and Folk">Country and Folk</a></li>
			   		<li><a href="#" data-category="Dance/Electronic">Dance/Electronic</a></li>
			   		<li><a href="#" data-category="Festivals">Festivals</a></li>
			   		<li><a href="#" data-category="Hard Rock and Metal">Hard Rock and Metal</a></li>
			   		<li><a href="#" data-category="Jazz and Blues">Jazz and Blues</a></li>
			   		<li><a href="#" data-category="Latin">Latin</a></li>
			   		<li><a href="#" data-category="Miscellaneous">Miscellaneous</a></li>
			   		<li><a href="#" data-category="New age and Spiritual">New age and Spiritual</a></li>
			   		<li><a href="#" data-category="R&B Urban Soul">R&B Urban Soul</a></li>
			   		<li><a href="#" data-category="Rap and Hip HOp">Rap and Hip HOp</a></li>
			   		<li><a href="#" data-category="Rock and Pop">Rock and Pop</a></li>
			   		<li><a href="#" data-category="World Music">World Music</a></li>
			   		<li><a href="#" data-category="More Concerts">More Concerts</a></li>

     	   	</ul>
			   </div>


			</div>
		</div>
	</div>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allconcerts.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Get Your tickets</h4>
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

			   <input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

			   <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/restaurant.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Local Flavors</h4>
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

			   <input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

			   <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/restaurant-deals.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Local Flavors</h4>
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>
		</div>
	</div>	

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/handpicked-restaurant.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Local Flavors</h4>
			<div class="clear"></div>
			<div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

 				<input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>

 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">

			</div>
		</div>
	</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/category-data.php') { ?>
	<div class="newCurrentCity citytalk_page">
		<div class="innerCurrentCity1">
		<h4>Go where you have never gone before!!</h4>
			<div class="clear"></div>
			<div class="search_filtering">
			   <input id="geo-demo" type="text" class="geo" placeholder="Enter a destination" value="" data-find-address="<?php echo $dropdown_city; ?>" required>
				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>
		</div>
	</div>	

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/hotelsdeals.php') { ?>

<div class="deal_bannerForm">
	<form id="hotel_api_filter" method="post">
		<div class="widget_row">
			<label>Destination:</label>
			<input id="geo-demo" type="text" class="geo" placeholder="Enter a location" value="" data-find-address="<?php echo $dropdown_city; ?>">

		</div>
		<div class="hit_button">
			<input type="button" id="hitAjax" class="button hotel_button" value="Search">
		</div>
		<div class="all_box4">
			<div class="checkin_class">
				<label>Check in:</label>
				<input type="text" id="dpd1" name="checkin" value="" class="check_class" placeholder="mm/dd/yyyy">
			</div>
			<div class="checkin_class new_classs">
				<label>Check out:</label>
				<input type="text" id="dpd2" name="checkout" value="" class="check_class" placeholder="mm/dd/yyyy">
			</div>
			<div class="room_class">
			<label>Rooms:</label>
			<select id="roomid" name="room" class="room_class">
			  <option value="1">1 Room</option>
			  <option value="2">2 Rooms</option>
			  <option value="3">3 Rooms</option>
			</select>
			</div>
			<div class="room_class new_classs">
				<label>Guest:</label>
				<select id="guestid" name="guest" class="guest_class">
					<option value="1">1 Guest</option>
				    <option value="2">2 Guests</option>
				    <option value="3">3 Guests</option>
				    <option value="4">4 Guests</option>
				    <option value="5">5 Guests</option>
				    <option value="6">6 Guests</option>
				</select>
			</div>
		</div>
	</form>
</div>
		
<style type="text/css">
	.v2_banner_top .innerCurrentCity1 {
		margin-top: 42px;
	}

</style>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/homeaway.php') { ?>
		
		<div class="deal_bannerForm">
			<form id="hotel_api_filter" method="post">
				<div class="all_box4">
					<div class="widget_row">
						<label>Destination:</label>
						<input id="geo-demo" type="text" class="geo" placeholder="Enter a location" value="" data-find-address="<?php echo $dropdown_city; ?>">

					</div>
					<div class="checkin_class">
						<label>Check in:</label>
						<input type="text" id="dpd1" name="checkin" value="" class="check_class" placeholder="mm/dd/yyyy">
					</div>
					<div class="checkin_class new_classs">
						<label>Check out:</label>
						<input type="text" id="dpd2" name="checkout" value="" class="check_class" placeholder="mm/dd/yyyy">
					</div>
					<div class="room_class new_classs">
						<label>Guest:</label>
						<select id="guestid" name="guest" class="guest_class">
							<option value="1">1 Guest</option>
						    <option value="2">2 Guests</option>
						    <option value="3">3 Guests</option>
						    <option value="4">4 Guests</option>
						    <option value="5">5 Guests</option>
						    <option value="6">6 Guests</option>
						</select>
					</div>
					<div class="hit_button">
						<input type="button" id="hitAjax_homestay" class="button hotel_button" value="Search">
					</div>
				</div>
			</form>
		</div>

<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/homestay.php') { ?>
		
		<div class="deal_bannerForm">
			<form id="hotel_api_filter" method="post">
				<div class="all_box4">
					<div class="widget_row">
						<label>Destination:</label>
						<input id="geo-demo" type="text" class="geo" placeholder="Enter a location" value="" data-find-address="<?php echo $dropdown_city; ?>">

					</div>
					<div class="checkin_class">
						<label>Check in:</label>
						<input type="text" id="dpd1" name="checkin" value="" class="check_class" placeholder="mm/dd/yyyy">
					</div>
					<div class="checkin_class new_classs">
						<label>Check out:</label>
						<input type="text" id="dpd2" name="checkout" value="" class="check_class" placeholder="mm/dd/yyyy">
					</div>
					<div class="room_class new_classs">
						<label>Guest:</label>
						<select id="guestid" name="guest" class="guest_class">
							<option value="1">1 Guest</option>
						    <option value="2">2 Guests</option>
						    <option value="3">3 Guests</option>
						    <option value="4">4 Guests</option>
						    <option value="5">5 Guests</option>
						    <option value="6">6 Guests</option>
						</select>
					</div>
					<div class="hit_button">
						<input type="button" id="hitAjax_homestay" class="button hotel_button" value="Search">
					</div>
				</div>
			</form>
		</div>
		
		<style type="text/css">
			.v2_banner_top .innerCurrentCity1 {
				margin-top: 42px;
			}	
		</style>	
<?php }elseif ($_SERVER['SCRIPT_NAME'] == '/car-rentals.php') { ?>
	<div class="container">
	 <div class="deal_bannerForm form-class">
			<form id="hotel_api_filter" method="post" class="widget-form">
				<div class="all_box4">
					<div class="widget_row">
						<label>Pick-up location:</label>
						<input id="geo-demo" type="text" class="geo" placeholder="Enter a location" value="" data-find-address="<?php echo $_SESSION['city_name']; ?>">

					</div>
					<div class="checkin_class check_in">
						<label>Pick-up date:</label>
						<input type="text" id="dpd1" name="checkin" value="" class="check_class" placeholder="mm/dd/yyyy">
						<input type="text" id="basicExample" name="picktime" value="9:00am" class="check_class" placeholder="hh:mm">

					</div>
					<div class="checkin_class new_classs check_out">
						<label>Drop-off date:</label>
						<input type="text" id="dpd2" name="checkout" value="" class="check_class" placeholder="mm/dd/yyyy">

						<input type="text" id="basicExample2" name="picktime" value="9:00pm" class="check_class" placeholder="hh:mm">
					</div>

					<div class="hit_button check_button">
						<input type="button" id="hitAjax_carentals" class="button hotel_button" value="Find a car">
					</div>
				</div>
			</form>
			<div class="car-text">Road Trip</div>
		</div>
	</div>	
	<?php } ?>

<script type="text/javascript">
    tabby.init();    
</script>

<div class="v2_header_wrapper">

	<?php
	if($_SERVER['SCRIPT_NAME'] == '/learn-more.php' || $_SERVER['SCRIPT_NAME'] == '/Epk_kit.php' || $_SERVER['SCRIPT_NAME'] == '/For-Artist-more.php' || $_SERVER['SCRIPT_NAME'] == '/sell-ticket.php' || $_SERVER['SCRIPT_NAME'] == '/advertisement.php') { ?>

	<div class="clear"></div>
	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/tours.php') { ?>
		
		<ul class="bxslider_banner">
		<?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'tours' ORDER BY id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
		</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/yelp-tour.php') { ?>
		
		<ul class="bxslider_banner">
		<?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'things_to_do' ORDER BY id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
		</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/performing-arts.php') { ?>
		
		<ul class="bxslider_banner">
		  <?php 

		  $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'performing_arts'");
		
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
		</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allperformingArts.php') { ?>
		
		<ul class="bxslider_banner">
		  <?php 

		  $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'performing_arts'");
		
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
		</ul>	


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/brewery.php') { ?>
		<ul class="bxslider_banner">
		  <?php 

		  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'winery_brewery'");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
		</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allbrewery.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'winery_brewery'");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/comedy.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'comedy'");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allhoteldeals.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM banner_images ORDER BY id DESC");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/seeallcomedy.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'comedy'");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/concert.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'concert'");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allconcerts.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'concert'");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/restaurant.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'restaurant'");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/restaurant-deals.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'restaurant'");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/car-rentals.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'car-rent'");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/category-data.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'restaurant'");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/handpicked-restaurant.php') { ?>
	<ul class="bxslider_banner">
	  <?php 

	  	$getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'restaurant'");
		while ($res = mysql_fetch_assoc($getBanner))
		{ ?>
	  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	  <?php } ?>
	</ul>		


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/sports_event.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'ticket' ORDER BY  id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/isangoapi.php') { ?>
			<ul class="bxslider_banner">
			<?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'things_to_do' ORDER BY id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/city_talk.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'city_talk'  ORDER BY id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/city-guide.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'city_talk'  ORDER BY id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/city-guide-events-deals.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'city_talk'  ORDER BY id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/audio-tour-summary.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'city_talk'  ORDER BY id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/destination.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'destination' ORDER BY id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		 	<li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/homestay.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'vacation' ORDER BY id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/homeaway.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'vacation' ORDER BY id DESC");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/bedandbreakfast.php') { ?>
			<ul class="single_banner">
			  <li><img src="../imagesNew/bed-&-bf.png" /></li>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getI = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'genre'");
			while ($res = mysql_fetch_assoc($getI))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	 <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre-rock.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getI = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'concert'");
			while ($res = mysql_fetch_assoc($getI))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	 <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre-blues.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getI = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'concert'");
			while ($res = mysql_fetch_assoc($getI))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	 <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre-country.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getI = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'concert'");
			while ($res = mysql_fetch_assoc($getI))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	 <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre-jazz.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getI = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'concert'");
			while ($res = mysql_fetch_assoc($getI))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	 <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/genre-concerts-deals.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getI = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'concert'");
			while ($res = mysql_fetch_assoc($getI))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	 <?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/artistPage.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'artist_page'");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
	<?php } ?>
	</ul>

	<?php } elseif ($_GET['activity'] == 'family') { ?>
			<ul class="bxslider_banner">
			  <?php 
			  $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'family'");
			
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
				 <li><img src="<?php echo $res['image_path']; ?>" /></li> 
	<?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/family.php') { ?>
			<ul class="bxslider_banner">
			  <?php 
			  $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'family'");
			
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
				 <li><img src="<?php echo $res['image_path']; ?>" /></li> 
	<?php } ?>
	</ul>


	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/activities.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'outdoor'");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		 <li><img src="<?php echo $res['image_path']; ?>" /></li>
	<?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allgroupon-tours.php') { ?>
			<ul class="bxslider_banner">
			  <?php $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'tours'");
			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		 <li><img src="<?php echo $res['image_path']; ?>" /></li>
	<?php } ?>
	</ul>

	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/viewAllArtist.php') { ?>
			<ul class="single_banner">
			  <li><img src="../imagesNew/artist.png" /></li>
			</ul>
	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allSports.php') { ?>
			<ul class="bxslider_banner">
			  <?php 
			 $getBanner = mysql_query("SELECT * FROM `static_page_banner_images` WHERE page_name = 'sports' ORDER BY id DESC");

			while ($res = mysql_fetch_assoc($getBanner))
			{ ?>
		  <li><img src="<?php echo $res['image_path']; ?>" /></li>
		  <?php } ?>
			</ul>
	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/allFoods.php') { ?>
			<ul class="single_banner">
			  <li><img src="../imagesNew/food-deal.jpg" /></li>
			</ul>		
	<?php } elseif ($_SERVER['SCRIPT_NAME'] == '/viewSports.php') { ?>
			<ul class="single_banner">
			  <li><img src="../imagesNew/soccer-game.jpg" /></li>
			</ul>
	<?php } else { ?>
		<ul class="bxslider_banner">
		  <li><img src="../imagesNew/p4.jpg" /></li>
		  <li><img src="../imagesNew/p5.jpg" /></li>
		  <li><img src="../imagesNew/p6.jpg" /></li>
		  <li><img src="../imagesNew/p11.jpg" /></li>
		  <li><img src="../imagesNew/p22.jpg" /></li>
		  <li><img src="../imagesNew/new1.jpg" /></li>
		  <li><img src="../imagesNew/new2.jpg" /></li>
		  <li><img src="../imagesNew/new3.jpg" /></li>
		  <li><img src="../imagesNew/new4.jpg" /></li>
		  <li><img src="../imagesNew/new5.jpg" /></li>
		  <li><img src="../imagesNew/new6.jpg" /></li>
		  <li><img src="../imagesNew/new7.jpg" /></li>
		  <li><img src="../imagesNew/new8.jpg" /></li>
		  <li><img src="../imagesNew/new9.jpg" /></li>
		  <li><img src="../imagesNew/new10.jpg" /></li>
		  <li><img src="../imagesNew/new11.jpg" /></li>
		  <li><img src="../imagesNew/new12.jpg" /></li>
		  <li><img src="../imagesNew/new13.jpg" /></li>
		  <li><img src="../imagesNew/new14.jpg" /></li>
		  <li><img src="../imagesNew/new16.jpg" /></li>
		</ul>
	<?php
	}

	if($_SERVER['SCRIPT_NAME'] == '/Epk-kit2.php' || $_SERVER['SCRIPT_NAME'] == '/Epk-kit.php') { ?>
		<div class="clear"></div>
	<?php } else { ?>
		<div class="before_can">
		<div class="container">
			<div class="search-menu">

			<?php if($_SERVER['SCRIPT_NAME'] != '/searchEvents.php') { ?>
				
			<?php } else { ?>
				<ul class="bxslider_menu ul_Menus_head">
					<?php 

						$d_category = "9";
						
						$getEventsCategory = mysql_query("SELECT * FROM `eventcategory` ORDER BY `id` ASC ");

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
							else{
								$EVENTCAT = '9';
							}
							?>
								<li><a href="searchEvents.php?eventcat=<?php echo $fetchEventCategory['id']?>&search_site_events=1" id="<?php echo $fetchEventCategory['id'];?>" class="<?php echo ($_GET['eventcat'] == $fetchEventCategory['id']) ? 'active_range' : ''?>"><?php echo $fetchEventCategory['catname'];?></a></li>
							<?php 
						}
					?>
				</ul>
				<?php } ?>
			</div>
		</div>
		</div>
		<?php } ?>
		

	<style type="text/css">
		
		.bx-wrapper {
			max-width: 1030px !important;
		}

	</style>
           	
<div class="v2_top_nav withoutLoginHeader">

  <div class="v2_container">

	<div class="v2_login withoutLogin new_Cl_menu">
	<a href="index.php">	<img alt="My sitti" src="../../images/v2_logo_round.png"></a>
		<div class="v2_filter_box" id="topCitySearch" style="display: none;">

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
												var source = JSON.parse('<?php echo $encoded_state_list; ?>');
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

										<span class="setdefault">Set as default city</span>

									</p>

									<p>

										<input type="button" class="button" value="Switch City" onclick="validate_city_Form();" name="search" id="submit">

									</p>

								</form>

					</div>

					</div>

		<ul class="static_menus">

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

			<li <?php if($_SERVER['SCRIPT_NAME'] == '/car-rentals.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>car-rentals.php">Car Rentals</a></li>

			<li <?php if($_SERVER['SCRIPT_NAME'] == '/restaurant-deals.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>restaurant-deals.php"> <span data-title="Restaurants">Restaurants</span> </a> </li>

			
			<li <?php if($_SERVER['SCRIPT_NAME'] == '/yelp-tour.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>yelp-tour.php"><span data-title="Things To Do">Things To Do</span></a> </li>


			<li <?php if($_SERVER['SCRIPT_NAME'] == '/city-guide.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>city-guide.php"> <span data-title="Audio Tours">Audio Tours</span> </a> </li>

			<!-- <li <?php if($_SERVER['SCRIPT_NAME'] == '/homestay.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>homestay.php"> <span data-title="Vacation Rentals">Vacation Rentals</span> </a> </li> -->

			<li <?php if($_SERVER['SCRIPT_NAME'] == '/destination.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>destination.php"> <span data-title="Destinations">Destinations</span> </a> </li>

			
			
		</ul>
		
		<nav class="navbar navbar-default nav-mobile">
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
                 <!--  <li>
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

			<li><a href="<?php echo $SiteURL; ?>hotels/index.php">Hotels</a></li>
			<li><a href="<?php echo $SiteURL; ?>flight/index.php">Flights</a></li>

			<li <?php if($_SERVER['SCRIPT_NAME'] == '/car-rentals.php'){ echo "class='active' ";} ?> > <a href="<?php echo $SiteURL;?>car-rentals.php">Car Rentals</a></li>
			
			<li <?php if($_SERVER['SCRIPT_NAME'] == '/restaurant-deals.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>restaurant-deals.php"> <span data-title="Restaurants">Restaurants</span> </a> </li>
			

			

			<li <?php if($_SERVER['SCRIPT_NAME'] == '/yelp-tour.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>yelp-tour.php"><span data-title="Things To Do">Things To Do</span></a> </li>


			<li <?php if($_SERVER['SCRIPT_NAME'] == '/city-guide.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>city-guide.php"> <span data-title="Audio Tours">Audio Tours</span> </a> </li>

			<!-- <li <?php if($_SERVER['SCRIPT_NAME'] == '/homestay.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>homestay.php"> <span data-title="Vacation Rentals">Vacation Rentals</span> </a> </li> -->

			<li <?php if($_SERVER['SCRIPT_NAME'] == '/destination.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>destination.php"> <span data-title="Destinations">Destinations</span> </a> </li>
			<!-- <li> <?php echo $dropdown_city; ?></li> -->

			

                </ul>

            	<?php if($_SERVER['SCRIPT_NAME'] == '/searchEvents.php' || $_SERVER['SCRIPT_NAME'] == '/city_talk.php') 
            	{
	                include('resHotspot_sidebar.php');
	            }  ?>
	          
            </div>
        </nav>
	
	  <ul class="before_login">

		<li>

		  <label id="v2_log_in" for="login">Log In</label>

		  <input type="checkbox" id="login">

		  <div class="v2_log_in">

			<h1>Login</h1>

			<a href="javascript:void(0);" class="v2_close_signup">close</a>

		  <div class="ve_login_container">
		 
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
					<p>
					 <div class="clear"></div>
						<input type="submit" name="submit" value="Login">
					</p>
			</form>
				<div class="clear">
			</div>   
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
			if(isset($authUrl))
			{
		?>
				<a href="<?php echo $authUrl; ?>" target="blank"><img alt="Login from Google Plus" src="images/googleplus1.png"></a>
  <?php  	} 	?>
		  </div>
		  </div> </div><div class="v2_login_overlay"></div>
		</li>
		<li>
		</li>


		<li>
		  <label id="v2_signup" for="signup" class="new-sign-u">Join For Free</label>

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

						<input type="checkbox" value="1" id="acknowledgement" name="acknowledgement"><span>I have read and agree to the</span> <a href="javascript:vois(0)" onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Privacy Policy*</a>

					</span><div class="clear"></div>

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



		<div  id="user" >

			<form action="paymentoption.php" method="post" class="tab_standerd v2_user_reg" id="signupd" name="signupd" autocomplete="off" novalidate="novalidate">
			<span class="v2_accept_terms">
									<span id="Businesscheck" class="aboutYou">
			<input type="checkbox" id="hosttype" name="hostTYPE" onclick="displayFields();" style="float:left;">
			<span>Are you an Artist or Local Business?</span></span> </span>
			<div class="clear"></div>
			<div id="hostFieldsBlock" style="display: none;"> 
				<p id="profilesName">
					<input type="text" required="" placeholder="Profile or Business Name" onblur="return ChkUserProfile(this.value,'user','https://mysitti.com/');" name="profilename" autocomplete="off" style=" margin-top:5px;">
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
			<input type="text" autocomplete="off" required="" placeholder="Email Address" onblur="return ChkUserId(this.value,'user','https://mysitti.com/');" name="email">
			</p>
						
			
			<p>
			<input type="password" required="" placeholder="Password" id="password" name="password" autocomplete="off">
			</p>
			<p>
			<input type="password" required="" placeholder="Confirm Password" name="cpassword" autocomplete="off">
			</p>
			<div class="clear"></div>
            
			<div class="clear"></div>
				<div class="clear"></div>
					<!-- <div class="agreementTerms aboutYou">
					<div class="span">
						<input type="checkbox" value="1" id="acknowledgement" name="acknowledgement">
						<p class="term_policy">By clicking Sign Up, you agree to our <a onclick="javascript:window.open('terms_conditions.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Terms & Conditions</a> and <a onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Privacy Policy</a>. You may receive email notification from mysittidev.com, but you can choose to opt out at any time.</p> 
					</div>
					</div> -->
				<div class="clear"></div>
				<input type="hidden" name="plantype" value="free">
				<input type="hidden" name="planid" value="1">
				<input type="hidden" id="userTYPE" name="UserType" value="user">
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
  		<?php  	} 	?>
				
		<a href="<?php echo $instaURL;?>"><img src="instagram.png" alt=""></a></span>
		</div>

		</div>

			  </div>

			</div>

		  </div>

		  <div class="v2_signup_overlay"></div>

		</li>

	  </ul>


	</div>

  </div>

</div>

<div class="newmenu_mobile">
   <ul>
   <li> 
      <div class="next">
       <div id="dromMenu" class="heads"><img src="images/Contest.png" alt="">
     <label> Contests</label></div>
      </div> 
      <div class="menupopup">
      <ul>
      <li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">Mysitti Contests</a></li>
      
		  <li><a href="<?php echo $SiteURL;?>current_host_contests.php">Host Contests</a></li>
	 
      </ul>
      </div>
      </li>
         <li><a href="searchEvents.php">
      <div class="next">
       <div class="heads"><img src="images/CityEvents.png" alt="">
     <label> City Events</label></div>
      </div></a>
      </li>
      
       <li><a href="city_talk.php"> 
      <div class="next">
       <div class="heads"><img src="images/CityTalk.png" alt="">
     <label>City Talk</label></div>
      </div></a>
      </li>
      <li><a href="advanced_filters.php?cat_id=1"> 
      <div class="next">
       <div class="heads"><img src="images/HotSpots.png" alt="">
     <label>Host </label></div>
      </div></a>
      </li>
      
        	<li><a href="MySittiTV.php" class=""> 
	  <div class="next">
	   <div class="heads"><img src="images/mtv.png" alt="">
	 <label>Mysitti TV</label></div>
	  </div></a> 
	  </li>
    
   <li><a href="battle.php" class=""> 
	  <div class="next">
	   <div class="heads"><img src="images/batttle.png" alt="">
	 <label>Live Battle</label></div>
	  </div></a> 
	  </li>
   
   	<li><a href="#searchArea" class=""> 
	  <div class="next">
	   <div class="heads"><img src="images/searchEvent.png" alt="">
	 <label>Search</label></div>
	  </div></a> 
	  </li>
     <li><a href="support.php" class=""> 
	  <div class="next">
	   <div class="heads"><img src="images/Helpout.jpg" alt="">
	 <label>Help</label></div>
	  </div></a> 
	  </li>
   
      </ul>
     </div>
     <div class="clear"></div>
	<?php 

	if($_SERVER['SCRIPT_NAME'] != '/forget_pwd.php')

	{

	?>
	  	<div class="for_hotel">
		<div class="v2_container">
		<?php
			if (!empty($_GET['city'])) {
				$dropdown_city = $_GET['city'];
			}
			elseif(empty($_SESSION['city_name'])){
				$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
				$get_city_name = mysql_fetch_assoc($city_name_query);
				$dropdown_city = $get_city_name['city_name'];
				$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
				$get_state_name = mysql_fetch_assoc($state_name_query);
				$dropdown_state = $get_state_name['code'];
				$LATITUDE = $get_city_name['lat'];
				$LONGITUDE = $get_city_name['lng'];
				$CITYID = $get_city_name['city_id'];
			}
		?>
			<div class="v2_brand"> 

				<a href="index.php">

					<img src="images/v2_logo_round.png" alt="" /><div class="clear"></div>

					<span  id="searchArea">Making Every City Your City</span>

				</a> 	

			</div>

			<div class="clear"></div>

			<div class="v2_search_area" id="search_Events">

				<h1>FIND YOUR NEXT EXPERIENCE</h1>

				<div class="clear"></div>

				<div class="v2_search-area">
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

				<div class="clear"></div>

			</div>
			<div class="hotel_menu">
				<ul>
					<li><a href="hotel_all.php">Hotels</a></li>
					<li><a href="">Hotels Deals</a></li>
					<li><a href="">Packages & Flights</a></li>
					<li><a href="">Car Rentals</a></li>
					<li><a href="">Vacations Rentals</a></li>
					<li><a href="">Tours</a></li>
					<li><a href="">Tickets</a></li>
					<li><a href="">Bed & Breakfast</a></li>
				</ul>
			</div>

		</div>
		</div>

		<div class="clear"></div>
	<?php } ?>

		<div class="v2_header fordesk">

			<div class="v2_container">


						<div class="v2_nav">

					<ul>
									
						<li>

							<a href="searchEvents.php">

								<span data-title="City Events">City Events</span>

							</a>

						</li>

						<li>

							<a href="<?php echo $SiteURL;?>city_talk.php">

								<span data-title="City Talk">City Talk</span>

							</a>

						</li>

						<li>

							<a href="#">

								<span data-title="Contest">Contest</span>

							</a>

							<ul>

								<li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">Mysitti Contests</a></li>

								<li><a href="<?php echo $SiteURL;?>current_host_contests.php">Host Contests</a></li>

							</ul>

						</li>

						<li>

							<a href="<?php echo $SiteURL;?>battle.php">

								<span data-title="Live Battle">Live Battle</span>

							</a>

						</li>
						<li>

							<a href="<?php echo $SiteURL;?>MySittiTV.php#tv">

								<span data-title="MySitti TV">MySitti TV</span>

							</a>

						</li>

					</ul>

				</div>

			</div>

		</div>

	</div><!-- END v2_header_wrapper -->

</div><!-- v2_banner_top -->

<div class="clear"></div>


<?php 

include('image_upload_resize.php');

include("resize-class.php");

include("user_upgrade.php");

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

function detect_stream($hbhost)
{
	$st_qry = 'ffmpeg -i rtsp://54.174.85.75:1935/httplive/'.$hbhost.' 2>&1; echo $?';
 		 
	$st_res=(string)trim(shell_exec($st_qry));
 					
	if (strpos($st_res,'404 Not Found') === false) {
		return true;
	}
	else
	{	
		$st_qry = 'ffmpeg -i rtsp://52.37.162.200:1935/live/'.$hbhost.' 2>&1; echo $?';
 		 
		$st_res=(string)trim(shell_exec($st_qry));
	 					
		if (strpos($st_res,'404 Not Found') === false) {
			return true;
		}

	}
	
	return false;

}

function clean($string) {

	$string = str_replace(' ', '-', $string); 

	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); 

}

function getLnt($zip)

{

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
<script type="text/javascript">
$(document).ready(function(){
  $('#basicExample').timepicker();
  $('#basicExample2').timepicker();
});
</script>
<script>

$(document).ready(function() {
$("#dpd1").datepicker({
    minDate: 0,
    dateFormat: "mm/dd/yy",
    onSelect: function (date) {
        var date2 = $('#dpd1').datepicker('getDate');
        date2.setDate(date2.getDate() +1);
        $('#dpd2').datepicker('setDate', date2);
        $('#dpd2').datepicker('option', 'minDate', date2);
    }
});
$('#dpd2').datepicker({
    dateFormat: "mm/dd/yy",
    onClose: function () {
        var dt1 = $('#dpd1').datepicker('getDate');
        var dt2 = $('#dpd2').datepicker('getDate');
        if (dt2 <= dt1) {
            var minDate = $('#dpd2').datepicker('option', 'minDate');
            $('#dpd2').datepicker('setDate', minDate);
        }
    }
}); 

$('.geo').geoContrast({format: "short"});


$(".before_login li label").click(function(){  $(".newCurrentCity").css("z-index", "1");  $(".v2_close_signup").click(function(){ $(".newCurrentCity").css("z-index", "9999");  });});

});

$(document).ready(function(){
  $(".geocontrast").click(function(){
    $(".concert-option").show();
	});
  });

$(document).mouseup(function(e){
    var container = $(".concert-option");
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.hide();
    }
});

$('.concert-option li a').click(function() {
      $(".concert-option").hide();
});

$('.geocontrast').keypress(function() {
$('.concert-option').hide();
});

</script>

<script type="text/javascript">
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

				if(j_city_name =="")

				{

					j_city_name = $('#topsearchform').find('input[name="city_name123"]').val();

				}

				if (j_city_name != "") 

				{

					jQuery.post('ajaxcall.php', {'check_city_status': 'check_city_status', 'state': state, 'city': j_city_name,'country': country,'checkbox': chkbox}, function(response){

						if (response == "exists") {

							location.reload(true);


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
