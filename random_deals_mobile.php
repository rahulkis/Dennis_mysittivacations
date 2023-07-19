<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Deals"; 
 
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
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
<script type="text/javascript" src="js/owl.carousel.js"></script>
<script src="<?php echo $CloudURL; ?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jwplayer-7.2.4/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>
<script src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.pack.js"></script>
<script src="http://cdn.date-fns.org/v1.29.0/date_fns.min.js"></script>

<script src="js/angular.min.js"></script>
<script type="text/javascript">
  !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t){var e=document.createElement("script");e.type="text/javascript";e.async=!0;e.src=("https:"===document.location.protocol?"https://":"http://")+"cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(e,n)};analytics.SNIPPET_VERSION="4.0.0";
  analytics.load("C2CqjCCpsi81VUIkVTmOud57gJGSSEZJ");
  analytics.page();
  }}();
</script>
<script type="text/javascript">
    (function(e,t,o,n,p,r,i){e.prismGlobalObjectAlias=n;e.pgo=e.pgo||function(){(e.pgo.q=e.pgo.q||[]).push(arguments)};e.pgo.l=(new Date).getTime();r=t.createElement("script");r.src=o;r.async=true;i=t.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)})(window,document,"https://prism.app-us1.com/prism.js","pgo");

    pgo('setAccount', '66416122');
    pgo('setTrackByDefault', true);

    pgo('process');
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

<?php
////////////////////////////////////////////////////////////
// for update of meta tag please update meta_tag.php file //
////////////////////////////////////////////////////////////
require 'function.php';
echo meta_tags(basename($_SERVER['PHP_SELF']));
?>
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
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyAdAHPQKt-pTBl0iUiRMd3leFhe8F9TsL4&libraries=places"></script>
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
 		$_SESSION['city_name'] = strtok($_GET['city'], ",");
 		$_SESSION['formatteds'] = strtok($_GET['city'], ",");
 		$_SESSION['full_city_name'] = $_GET['city'];
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

<style>.async-hide { opacity: 0 !important}
.random_change .audio_tour_in li a {
    font-size: 12px !important;
} 
.audio_tour_in .random_list {
	width: 60px;
}
.random_change .audio_tour_in li img {
    max-width: 70% !important;
}
.random_change .audio_tour_in li a span {
    padding: 0px !important;
}
</style>
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
<input type="hidden" value="<?php echo $_SESSION['full_city_name']; ?>" id="fullCityName" />

<div id="v2_wrapper" class="n-random-sec">

<div class="v2_banner_top">
<?php
session_start();
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/deals.css">

<script type="text/javascript">
$(document).ready(function() {
	$("body").on('click', '.top', function() {
		$("nav.menu").toggleClass("menu_show");
	});
	 if (window.matchMedia("(max-width: 767px)").matches)  
        { $('.incase_mobile').css('display','block');
            $('.incase_desktop').css('display','none');
        } else { 
        	$('.incase_mobile').css('display','none');
           
        } 
	    $('.menu_icon').click(function() {

	    $('html, body').animate({
	      scrollTop: $("#myCarousel").offset().top
	    }, 1000);
	})
});
</script>
<?php
function groupon_api_call($limit,$city,$key){
	if(!empty($city)):
		$prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
		$key = str_replace(' ','+',$key);
	    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
	    $output= json_decode($geocode);
	    $latitude = $output->results[0]->geometry->location->lat;
	    $longitude = $output->results[0]->geometry->location->lng;
			$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."&locale=en_US";
		// endif;
	else:
		if(!empty($key)):
			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&offset=0&limit=".$limit."&locale=en_US";
		else:

			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&limit=".$limit."&locale=en_US";
		endif;
	endif;
	$result_get = file_get_contents($urlgo);
	$get_all_data = json_decode($result_get, true);
	$get_deals = $get_all_data['deals'];
	return $get_deals;
}
?>
<div class="random">

<?php 

$_SESSION['city_name'] = $_GET['city'];

?>

<input type="hidden" name="" id="target" value=<?php if(isset($_SESSION['city_name']) && !empty($_SESSION['city_name'])){ 
$newCitty = str_replace(' ', '%20',$_SESSION['city_name']);
	echo $newCitty;} ?>>
<div class="v2_content_wrapper ">

	<div class="row random_change">
			<ul class="audio_tour_in" style="display: none">
				<li class="random_list <?php if(empty($_SESSION['city_name']) && empty($_SERVER['QUERY_STRING']) && $_SERVER['SCRIPT_NAME'] == '/random_deals_mobile.php'){ echo 'active'; }
				elseif(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'All-Inclusive'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'All-Inclusive'){ echo 'active'; }				?>"> <a  class="random_vacation general_page_link" data="All-Inclusive" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}"><span><img src="/images/random/all_inclusive.png" class="img-responsive"></span>All</br> Inclusive</a></li>
				<li class="random_list <?php 
        if(empty($_SESSION['city_name']) && isset($_GET['keyword']) && $_GET['keyword'] == 'Hotels'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Hotels'){ echo 'active'; }       ?>"><a class="random_flight general_page_link" data="Hotels" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}" ><span><img src="/images/random/hotels.png" class="img-responsive"></span>Hotels</a></li>
				<li class="random_list <?php 
        if(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Flights'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Flights'){ echo 'active'; }       ?>"><a class="random_flight general_page_link" data="Flights" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}" ><span><img src="/images/random/flights.png" class="img-responsive"></span>Flights</a></li>
			<!-- 	<li class="random_list"><a href=random_deals.php?keyword=Car-Rentals class="general_page_link" ><span><img src="/images/random/car_rental.png" class="img-responsive"></span>Car</br> Rentals</a></li> -->
				<li class="random_list <?php 
        if(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Vacations'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Vacations'){ echo 'active'; }       ?>"><a class="random_vacation general_page_link"  data="Vacations" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}"  ><span><img src="/images/random/vacations.png" class="img-responsive"></span>Vacations</a></li>
				<li class="random_list  <?php if(!empty($_SESSION['city_name']) && empty($_SERVER['QUERY_STRING']) && $_SERVER['SCRIPT_NAME'] == '/random_deals_mobile.php'){ echo 'active';}
				elseif(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Tours'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Tours'){ echo 'active'; }elseif(empty($_SESSION['city_name']) && isset($_GET['keyword']) && $_GET['keyword'] == 'Tours'){ echo 'active';}?>"><a class="random_tours general_page_link" data="Tours" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}"><span><img src="/images/random/tours.png" class="img-responsive"></span>Tours</a></li>
				<li class="random_list <?php 
        if(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Cruises'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Cruises'){ echo 'active'; }       ?>"><a class="random_vacation general_page_link" data="Cruises" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}"><span><img src="/images/random/crusies.png" class="img-responsive"></span>Cruises</a></li>
		<!-- 		<li class="random_list"><a href=random_deals.php?keyword=Travel class="general_page_link" ><span><img src="/images/random/travels.png" class="img-responsive"></span>Travel</a></li> -->
				<!-- <li class="random_list" style="padding: 9px 0px !important"> <span class="glyphicon glyphicon-search" id="search_box_icon" style="font-size: 19px;"></span></li> -->
			</ul>
		<?php
		//all-inclusive screen
		if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'All-Inclusive'){
			if(!empty($_SESSION['city_name'])){
				$city = $_SESSION['city_name'];
			}else{
				$city = 'Chicago';
			}
			$data = groupon_api_call('40',$city,'all%20inclusive%20resort');
			if(count($data) > 0)
			{	 ?>
				<section id="pinBoot">
					<?php
					$i= 0;
					foreach($data as $homeData)
					{
						$price = $homeData['options'][0]['price']['formattedAmount'];
						$value = $homeData['options'][0]['value']['formattedAmount'];
						$discountPercent = $homeData['options'][0]['discountPercent'];
						$endAt = 	$homeData['options'][0]['endAt'];
						$endDate = date('m/d/Y', strtotime($endAt));
						$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
						$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
						$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
						$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
						$tourname = $homeData['title']; 
						$out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
							if($discountPercent != 0){
							$i++;
							?>
							<article class="white-panel">
								<a href="<?php echo  $homeData['dealUrl']; ?>"  target="_blank"><img src="<?php echo $homeData['grid4ImageUrl']; ?>" alt=""></a>
								<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
									<h2 class="discountPercent"><?php echo $discountPercent; ?>% Off</h2>
									<h1 class="nameIsan hotelandingnameIsan" style= "text-align: center; font-size: 14px"><?php echo $out ; ?></h1>
								</a>
								<h1 class="pricelanding"><?php echo $price ;?></h1>
								<h2 class="valuelanding"><?php echo $value ; ?></h2>
								<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
							</article>
							<?php
						}
					}
					?>
				</section>
				<?php
			} 
		}		//all-inclusive screen
		if(isset($_GET['flag']) && !empty($_GET['flag']) && empty($_GET['city']) &&  $_GET['flag'] == 'Flights'){
?>
<script src="//c111.travelpayouts.com/content?promo_id=3411&shmarker=130544&from_name=dallas%2Chouston%2Cchicago%2Clos%20angeles&locale=en&currency=USD&powered_by=true" charset="utf-8"></script>
<?php
		}
		//vacation deals screen
		if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'Vacations'){
			?>
			<div class="container">
				<div class="">
					<div class="">
						<div class="well">
							<div id="carousel" class="owl-carousel">
								<?php 
								if(!empty($_SESSION['city_name'])){
									$city = $_SESSION['city_name'];
								}else{
									$city = 'Chicago';
								}
								$get_deals_mobile = groupon_api_call('80',$city,'all%20inclusive%20resort');
								// print_r($get_deals_mobile);
								if(count($get_deals_mobile) > 0)
								{	
									$i= 0;
									foreach($get_deals_mobile as $homeData)
									{
										$price = $homeData['options'][0]['price']['formattedAmount'];
										$value = $homeData['options'][0]['value']['formattedAmount'];
										$discountPercent = $homeData['options'][0]['discountPercent'];
										$endAt = 	$homeData['options'][0]['endAt'];
										$endDate = date('m/d/Y', strtotime($endAt));
										$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
										$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
										$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
										$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
										$tourname = $homeData['title']; 
										$out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
										if($discountPercent != 0){
											$i++;
											?>

											<div class="item">
												<div class='borderIsan hotelandingDeal'>
													<?php $href = str_ireplace('http:','https:',$homeData['grid4ImageUrl']); ?>
													<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
													<img src="<?php echo $href; ?>">
													</a>
													<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
														<h2 class="discountPercent"><?php echo $discountPercent; ?>% Off</h2>
														<h1 class="nameIsan hotelandingnameIsan" style= "text-align: center;"><?php echo $out ; ?></h1>
													</a>
													<h1 class="pricelanding"><?php echo $price ;?></h1>
													<h2 class="valuelanding"><?php echo $value ; ?></h2>
													<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
												</div>
											</div>
											<?php
										}
									}
								} 
								?>

							</div>
						<!--/myCarousel-->
						</div>
					</div>
				</div>
			</div>
			<section id="pinBoot">
				<?php
				$rec_limit = 40;
				if( isset($_GET{'page'} ) ) {
					$page = $_GET{'page'} + 1;
					$offset = $rec_limit * $page ;
				}else {
					$page = 0;
					$offset = 0;
				}
				$randon_deals = "SELECT * FROM  vacation_deals_new ORDER BY  order_by LIMIT $offset, $rec_limit";
				$result = $mysqli->query($randon_deals);
				$count = $result->num_rows;
				if($count > 0){
					foreach ($result as $key => $value) {?>
						<article class="white-panel <?php echo $value['id']; ?>">
							<?php
                  $vacations = str_replace("_top","_blank",$value['content']);
               echo str_ireplace('http:','https:',$vacations); ?>
						</article>
						<?php	
					}
				}
				?>
			</section>
			<div class="paggination_bottom">
				<?php
				if(!empty($_SESSION['city_name'])){
					$city = '&city='.str_replace(' ','%20',$_SESSION['city_name']);
				}
				else{
					$city = '';
				}
				if($count > 39){
				if( $page > 0 ) {
					$last = $page - 2;
					echo "<a href =random_deals_mobile.php?flag=Vacations$city&page=$last>Last 40 Records</a> |";
					echo "<a href = random_deals_mobile.php?flag=Vacations$city&page=$page>Next 40 Records</a>";
				}else if( $page == 0 ) {
					echo "<a href =random_deals_mobile.php?flag=Vacations$city&page=$page>Next 40 Records</a>";
				}else if( $left_rec < $rec_limit ) {
					$last = $page - 2;
					echo "<a href =random_deals_mobile.php?flag=Vacations$city&page=last>Last 40 Records</a>";
				}
			}
				?>
			</div>
			<?php 
		}

		//cruises deals screen
		if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'Cruises'){
			?>
			<section id="pinBoot">
				<?php
				$rec_limit = 40;
				if( isset($_GET{'page'} ) ) {
					$page = $_GET{'page'} + 1;
					$offset = $rec_limit * $page ;
				}else {
					$page = 0;
					$offset = 0;
				}
				$randon_deals = "SELECT * FROM  new_cruises_deal_page ORDER BY  order_by LIMIT $offset, $rec_limit";
				$result = $mysqli->query($randon_deals);
				$count = $result->num_rows;

					foreach ($result as $key => $value) {
					?>	
					<article class="white-panel cruisess_text">
						<a href="<?php echo $value['link']; ?>" class="text-dec"  target="_blank"><img src="<?php echo 'cruises_images/'.$value['image']; ?>" alt="">
							<p class="text-color"><?php echo $value['tittle']; ?></p>	
						</a>
					</article>

					<?php		
				}  
				?>
			</section>
			<div class="paggination_bottom">
				<?php
				if($count > 39){
				if(!empty($_SESSION['city_name'])){
					$city = '&city='.str_replace(' ','%20',$_SESSION['city_name']);
				}
				else{
					$city = '';
				}
				if( $page > 0 ) {
					$last = $page - 2;
					echo "<a href =random_deals_mobile.php?flag=Cruises$city&page=$last>Last 40 Records</a> |";
					echo "<a href = random_deals_mobile.php?flag=Cruises$city&page=$page>Next 40 Records</a>";
				}else if( $page == 0 ) {
					echo "<a href =random_deals_mobile.php?flag=Cruises$city&page=$page>Next 40 Records</a>";
				}else if( $left_rec < $rec_limit ) {
					$last = $page - 2;
					echo "<a href =random_deals_mobile.php?flag=Cruises$city&page=last>Last 40 Records</a>";
				}
				}
				?>
			</div>
			<?php 
		}
		//data with specific cities
		if(isset($_SESSION['city_name']) && !empty($_SESSION['city_name'])){
			if($_GET['flag'] == 'Flights'){
				$randon_deals = "SELECT * FROM  random_deal_widgets WHERE city LIKE '%".$_GET['city']."%'";	
			}elseif($_GET['flag'] == 'Hotels'){
				$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%".$_GET['city']."%'";
			}elseif(isset($_SESSION['city_name']) && $_SERVER['SCRIPT_NAME'] == '/random_deals_mobile.php') {
				$rec_limit = 20;
			if( isset($_GET{'page'} ) ) {
	            $page = $_GET{'page'} + 1;
	            $offset = $rec_limit * $page ;
	         }else {
	            $page = 0;
	            $offset = 0;
	         }
           if($_SESSION['city_name'] == 'Washington D.C.'){
      $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun'  LIMIT $offset, $rec_limit";
       $randon_dealspeek = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Peek.com' LIMIT $offset, $rec_limit";
           }else{
				$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun'  LIMIT $offset, $rec_limit";
			 $randon_dealspeek = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Peek.com' LIMIT $offset, $rec_limit";        
           }
			}
			$result = $mysqli->query($randon_deals);
			$resultpeek = $mysqli->query($randon_dealspeek);
		 $count = $result->num_rows;
		 $count2 = $resultpeek->num_rows;
		 $counts = ($count + $count2);
			if($counts > 0){
			if ($_SERVER['SCRIPT_NAME'] == '/random_deals_mobile.php' && $_GET['flag'] == 'Tours') {
					?>
			<section id="pinBoot">
				<?php foreach ($result as $key => $value) {
					foreach ($resultpeek as $keys => $values) {
					if(!empty($values['tag'])){
						if($keys == $key){
						?>
				<article class="white-panel"><a href="<?php echo $values['link']; ?>"  target="_blank"><img src="<?php echo $values['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-title"><?php echo $values['tag']; ?></div>
						<div class="PictureCard-wrapper">
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ <?php echo $values['price']; ?></span>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class=""><?php echo $values['title']; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></a>
				</article>
			<?php			
					}
					}
					}
				?>
				<article class="white-panel"><a href="<?php echo $value['link']; ?>"  target="_blank"><img src="<?php echo $value['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-title"><?php echo $value['tag']; ?></div>
						<div class="PictureCard-wrapper">
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ <?php echo $value['price']; ?></span>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class=""><?php echo $value['title']; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></a>
				</article>
			<?php	
		 } ?>
			</section>
			<?php if($counts > 39){ ?>
				<div class="paggination_bottom">
					<?php
					$citysp =	$_SESSION['city_name'];
				    $city = str_replace(' ', '%20', $citysp);
					if( $page > 0 ) {
						$last = $page - 2;
						echo "<a href =random_deals_mobile.php?city=$city&flag=Tours&page=$last>Last 40 Records</a> |";
						echo "<a href = random_deals_mobile.php?city=$city&flag=Tours&page=$page>Next 40 Records</a>";
					}else if( $page == 0 ) {
						echo "<a href =random_deals_mobile.php?city=$city&flag=Tours&page=$page>Next 40 Records</a>";
					}else if( $left_rec < $rec_limit ) {
						$last = $page - 2;
						echo "<a href =random_deals_mobile.php?city=$city&flag=Tours&page=last>Last 40 Records</a>";
					}
					?>
				</div>
					<?php 
				}	 }elseif(!empty($_SESSION['city_name']) && !empty($_SERVER['QUERY_STRING']) && $_GET['flag'] == 'Tours'){
					
						$rec_limit = 20;
			if( isset($_GET{'page'} ) ) {
	            $page = $_GET{'page'} + 1;
	            $offset = $rec_limit * $page ;
	         }else {
	            $page = 0;
	            $offset = 0;
	         }
                      if($_SESSION['city_name'] == 'Washington D.C.'){
      $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun'  LIMIT $offset, $rec_limit";
       $randon_dealspeek = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Peek.com' LIMIT $offset, $rec_limit";
           }else{
				$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun'  LIMIT $offset, $rec_limit";
			 $randon_dealspeek = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Peek.com' LIMIT $offset, $rec_limit";
		}
    	$result = $mysqli->query($randon_deals);
			$resultpeek = $mysqli->query($randon_dealspeek);
		 $count = $result->num_rows;
		 $count2 = $resultpeek->num_rows;
		 $countss = ($count + $count2);
			if($countss > 0){
					?>
			<section id="pinBoot">
				<?php foreach ($result as $key => $value) {
					foreach ($resultpeek as $keys => $values) {
					if(!empty($values['tag'])){
						if($keys == $key){
						?>
				<article class="white-panel"><a href="<?php echo $values['link']; ?>"  target="_blank"><img src="<?php echo $values['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-title"><?php echo $values['tag']; ?></div>
						<div class="PictureCard-wrapper">
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ <?php echo $values['price']; ?></span>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class=""><?php echo $values['title']; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></a>
				</article>
			<?php			
					}
					}
					}
				?>
				<article class="white-panel"><a href="<?php echo $value['link']; ?>"  target="_blank"><img src="<?php echo $value['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-title"><?php echo $value['tag']; ?></div>
						<div class="PictureCard-wrapper">
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ <?php echo $value['price']; ?></span>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class=""><?php echo $value['title']; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></a>
				</article>
			<?php	
		 } ?>
			</section>
			<?php
				 if($countss > 39){ ?>
				<div class="paggination_bottom">
					<?php
					$citysp =	$_SESSION['city_name'];
				    $city = str_replace(' ', '%20', $citysp);
					if( $page > 0 ) {
						$last = $page - 2;
						echo "<a href =random_deals_mobile.php?city=$city&flag=Tours&page=$last>Last 40 Records</a> |";
						echo "<a href = random_deals_mobile.php?city=$city&flag=Tours&page=$page>Next 40 Records</a>";
					}else if( $page == 0 ) {
						echo "<a href =random_deals_mobile.php?city=$city&flag=Tours&page=$page>Next 40 Records</a>";
					}else if( $left_rec < $rec_limit ) {
						$last = $page - 2;
						echo "<a href =random_deals_mobile.php?city=$city&flag=Tours&page=last>Last 40 Records</a>";
					}
					?>
				</div>  
					<?php 
				}
				}
				}
				if($_GET['flag'] == 'Hotels'){
					if(isset($_GET['categories']) && !empty($_GET['categories'])){
						$categories = explode(",", $_GET['categories']);
						// print_r($categories);
					}
					?>
					<div class="side-bar-new_n">

					<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
					<div class="top incase_mobile">
						<a href="#" class="menu_icon"><i class="fa fa-bars" aria-hidden="true"></i></a><span class="mobile_filter">List hotels with filters</span>
					</div>

					<nav class="menu incase_mobile">
						<ul class="incase_mobile">
					<!-- <li class="filter-btn_">List hotels with filters:
					</li> -->
					<li><input type="checkbox" name="" class="filters" value="3stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('3stars', $categories)){ echo "checked"; } } ?>> 3 Stars</li>
					
					<li><input type="checkbox" name="" class="filters" value="4stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('4stars', $categories)){ echo "checked"; } } ?> > 4 Stars</li>
					
					<li><input type="checkbox" name="" class="filters" value="5stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('5stars', $categories)){ echo "checked"; } } ?> > 5 Stars</li>
					
					<li><input type="checkbox" name="" class="filters" value="cheap"  <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('cheap', $categories)){ echo "checked"; } } ?> > Cheap</li>
					
					<li><input type="checkbox" name="" class="filters" value="center" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('center', $categories)){ echo "checked"; } } ?> > Close to city center</li>
					
					<li><input type="checkbox" name="" class="filters" value="tophotels"<?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('tophotels', $categories)){ echo "checked"; } } ?> > Top hotels</li>
					
					<li><input type="checkbox" name="" class="filters" value="distance" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('distance', $categories)){ echo "checked"; } } ?> > Distance</li>
					
					<li><input type="checkbox" name="" class="filters" value="highprice" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('highprice', $categories)){ echo "checked"; } } ?> > Expensive</li>
					
					<li><input type="checkbox" name="" class="filters" value="lake_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('lake_view', $categories)){ echo "checked"; } } ?> > Lake view</li>
					
					<li><input type="checkbox" name="" class="filters" value="luxury" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('luxury', $categories)){ echo "checked"; } } ?> > Luxury</li>
					
					<li><input type="checkbox" name="" class="filters" value="panoramic_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('panoramic_view', $categories)){ echo "checked"; } } ?> > Panoramic view</li>
					
					<li><input type="checkbox" name="" class="filters" value="pets" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pets', $categories)){ echo "checked"; } } ?> > Pet friendly</li>
					
					<li><input type="checkbox" name="" class="filters" value="pool" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pool', $categories)){ echo "checked"; } } ?> > Pool</li>
					
					<li><input type="checkbox" name="" class="filters" value="popularity" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('popularity', $categories)){ echo "checked"; } } ?> > Popularity</li>
					
					<li><input type="checkbox" name="" class="filters" value="rating" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('rating', $categories)){ echo "checked"; } } ?> > Rating</li>
					
					<li><input type="checkbox" name="" class="filters" value="restaurant" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('restaurant', $categories)){ echo "checked"; } } ?> > Restaurant</li>
					
					<li><input type="checkbox" name="" class="filters" value="smoke" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('smoke', $categories)){ echo "checked"; } } ?> > Smoking friendly</li>
					
					<li><input type="checkbox" name="" class="filters" value="river_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('river_view', $categories)){ echo "checked"; } } ?> > River view</li>
					
					<li><input type="checkbox" name="" class="filters" value="sea_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('sea_view', $categories)){ echo "checked"; } } ?> > Sea view</li>
					<li class="filter-btn_"><input type="button" name="filter" class="main_filters filters" value="Search"></li>
					</ul>
					</nav>

					<ul class="incase_desktop">
					<li class="filter-btn_">List hotels with filters:
					</li>
					<li><input type="checkbox" name="" class="filters" value="3stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('3stars', $categories)){ echo "checked"; } } ?>> 3 Stars</li>
					
					<li><input type="checkbox" name="" class="filters" value="4stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('4stars', $categories)){ echo "checked"; } } ?> > 4 Stars</li>
					
					<li><input type="checkbox" name="" class="filters" value="5stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('5stars', $categories)){ echo "checked"; } } ?> > 5 Stars</li>
					
					<li><input type="checkbox" name="" class="filters" value="cheap"  <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('cheap', $categories)){ echo "checked"; } } ?> > Cheap</li>
					
					<li><input type="checkbox" name="" class="filters" value="center" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('center', $categories)){ echo "checked"; } } ?> > Close to city center</li>
					
					<li><input type="checkbox" name="" class="filters" value="tophotels"<?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('tophotels', $categories)){ echo "checked"; } } ?> > Top hotels</li>
					
					<li><input type="checkbox" name="" class="filters" value="distance" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('distance', $categories)){ echo "checked"; } } ?> > Distance</li>
					
					<li><input type="checkbox" name="" class="filters" value="highprice" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('highprice', $categories)){ echo "checked"; } } ?> > Expensive</li>
					
					<li><input type="checkbox" name="" class="filters" value="lake_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('lake_view', $categories)){ echo "checked"; } } ?> > Lake view</li>
					
					<li><input type="checkbox" name="" class="filters" value="luxury" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('luxury', $categories)){ echo "checked"; } } ?> > Luxury</li>
					
					<li><input type="checkbox" name="" class="filters" value="panoramic_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('panoramic_view', $categories)){ echo "checked"; } } ?> > Panoramic view</li>
					
					<li><input type="checkbox" name="" class="filters" value="pets" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pets', $categories)){ echo "checked"; } } ?> > Pet friendly</li>
					
					<li><input type="checkbox" name="" class="filters" value="pool" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pool', $categories)){ echo "checked"; } } ?> > Pool</li>
					
					<li><input type="checkbox" name="" class="filters" value="popularity" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('popularity', $categories)){ echo "checked"; } } ?> > Popularity</li>
					
					<li><input type="checkbox" name="" class="filters" value="rating" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('rating', $categories)){ echo "checked"; } } ?> > Rating</li>
					
					<li><input type="checkbox" name="" class="filters" value="restaurant" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('restaurant', $categories)){ echo "checked"; } } ?> > Restaurant</li>
					
					<li><input type="checkbox" name="" class="filters" value="smoke" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('smoke', $categories)){ echo "checked"; } } ?> > Smoking friendly</li>
					
					<li><input type="checkbox" name="" class="filters" value="river_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('river_view', $categories)){ echo "checked"; } } ?> > River view</li>
					
					<li><input type="checkbox" name="" class="filters" value="sea_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('sea_view', $categories)){ echo "checked"; } } ?> > Sea view</li>
					<li class="filter-btn_"><input type="button" name="filter" class="main_filters filters" value="Search"></li>
					</ul>
					</div>
					<?php
				}
				foreach ($result as $key => $value) {
				if($_GET['flag'] == 'Hotels' && empty($_GET['categories'])){
					echo $value['content'];
				}
				elseif($_GET['flag'] == 'Flights'){
					echo $value['content'];
				}elseif($_GET['flag'] == 'Hotels' && empty($_GET['categories'])){
				echo $value['content'];
				}elseif($_GET['flag'] == 'Hotels' && !empty($_GET['categories'])){
				 $position =  strpos($value['content'],"popularity");
				 echo $new_string = substr_replace($value['content'],$_GET['categories'].',', $position, 0);
				}
			}	

			}else{
			if($_GET['flag'] == 'Vacations'){

			}else{

?>

<!--left-->
		<div class="left col-xs-12 col-sm-12 col-md-9 col-lg-9">
		<!--first-section-->
			<div class="">
				<div class="">
					<div class="well">
						<div id="carousel" class="owl-carousel">
							<?php 
								$today = date('y-m-d');
								$randon_deals = "SELECT * FROM  random_deals WHERE status =1 and is_feature =1";
								$result = $mysqli->query($randon_deals);

								if(count($result) > 0)
								{
									$count = $result->num_rows;
									$no = 1; 
									foreach($result as $value)
									{
										preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $value['content'], $hrefResult);

										preg_match_all('/<img[^>]+src=([\'"])(?<src>.+?)\1[^>]*>/i', $value['content'], $srcResult);

										$img_href = $hrefResult['href'][0];
										$href = str_ireplace('http:','https:',$img_href);
										$img_src = $srcResult['src'][0];

										$src = str_ireplace('http:','https:',$img_src);

										$html .= '<div class="item">

										<a href="'.$href.'"class=""><img src="'.$src.'" alt="Image"></a>
										</div>';

									}
								} 
								else
								{

									$html = '<!-- Carousel items -->

									<div class="item active">
									<div class="row">
									<div class="col-sm-3">
									<div class="img-section">
									<a href="#x" class="thumbnail"><img src="http://placehold.it/500x500" alt="Image" class="img-responsive"></a>
									<div class="overlay-area"></div>
									</div>
									</div>
									<div class="col-sm-3">
									<div class="img-section">
									<a href="#x" class="thumbnail"><img src="http://placehold.it/500x500" alt="Image" class="img-responsive"></a>
									<div class="overlay-area"></div>
									</div>
									</div>
									<div class="col-sm-3">
									<div class="img-section">
									<a href="#x" class="thumbnail"><img src="http://placehold.it/500x500" alt="Image" class="img-responsive"></a>
									<div class="overlay-area"></div>
									</div>
									</div>
									<div class="col-sm-3">
									<div class="img-section">
									<a href="#x" class="thumbnail"><img src="http://placehold.it/500x500" alt="Image" class="img-responsive"></a>
									<div class="overlay-area"></div>
									</div>
									</div>
									</div>
									<!--/row-->
									</div>
									<!--/item-->';

								}
								echo $html;
							?>

						</div>
					<!--/myCarousel-->
					</div>
				</div>
			</div>




			<!--banner-end-->

			<?php
			$rec_limit = 50;
			if( isset($_GET{'page'} ) ) {
	            $page = $_GET{'page'} + 1;
	            $offset = $rec_limit * $page ;
	         }else {
	            $page = 0;
	            $offset = 0;
	         }
			if(isset($_GET['keyword'])){
				$today = date('y-m-d');
				$keyword = str_replace('-',' ', $_GET['keyword']); 

				$chekKeyword = "SELECT * FROM random_deals WHERE (INSTR(`category`, '".$keyword."') > 0 OR INSTR(`content`, '".$keyword."') > 0) AND status = 1 ORDER BY orderby LIMIT $offset, $rec_limit";
				$result = $mysqli->query($chekKeyword);
				$count = $result->num_rows;
				$left_rec = $count - ($page * $rec_limit);
				$rows[] = $result->fetch_assoc();
				if($count > 0){
					foreach($result as $value){
						?>
						<div class="random_content">
							<?php
							echo str_ireplace('http:','https:',$value['content']);
							?>
						</div>
						<?php
					} 
				}else{
					?>
					<div class="row left-section" style="text-align: center">
					No record found
					</div>
					<?php 
				}
			}else{
					$today = date('y-m-d');
					$randon_deals = "SELECT * FROM  random_deals WHERE status = 1 ORDER BY rand(".date("Ymd").")  LIMIT $offset, $rec_limit ";
					$result = $mysqli->query($randon_deals);
					$count = $result->num_rows;
					$left_rec = $count - ($page * $rec_limit);
					$rows[] = $result->fetch_assoc();
					if($count > 0){
						foreach($result as $value){
							?>
							<div class="random_content">
							<?php 
							//	$uid = $value['id'];
							//$string = preg_replace('~<a ([^>]*)href="[^"]+"([^>]*)>~', '<a \\1href="random_deal.php?id='.$uid.'"\\2>', $value['content']);
							echo str_ireplace('http:','https:',$value['content']);
							?>
							</div>
							<?php
						} 
					}else{
						?>
						<div class="row left-section" style="text-align: center">
							No record found
						</div>
						<?php 
					}
				}
			?>
				<div class="paggination_bottom">
					<?php
					if( $page > 0 ) {
						$last = $page - 2;
						echo "<a href =random_deals_mobile.php?page=$last>Last 50 Records</a> |";
						echo "<a href = random_deals_mobile.php?page=$page>Next 50 Records</a>";
					}else if( $page == 0 ) {
						echo "<a href =random_deals_mobile.php?page=$page>Next 50 Records</a>";
					}else if( $left_rec < $rec_limit ) {
						$last = $page - 2;
						echo "<a href =random_deals_mobile.php?page=last>Last 50 Records</a>";
					}
					?>
				</div>
		</div>
		<!--right-->
		<div class="right col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 20px">
			<?php 
			$randon_deals = "SELECT * FROM  add_advertisement where status = 1 ORDER BY orderby";
			$result = $mysqli->query($randon_deals);
			$rows[] = $result->fetch_assoc();
			foreach($result as $value){
				?>
				<div class="row right_ads_Deal_r">
					<?php 
					$newWidth = $value['height'];
					$newHeight = $value['width'];
					$content = preg_replace(array('/width="\d+"/i', '/height="\d+"/i'),array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),$value['affiliated']);
					//echo $content;
					$getrplace = str_replace("_top","_blank",$content);
					echo str_ireplace('http:','https:',$getrplace);
					?>
				</div>
				<?php
			}
			?>

		</div>


<?php

			
}}

		}else{
			if(isset($_GET['flag']) && $_GET['flag'] == 'Vacations' || $_GET['flag'] == 'Cruises' || $_GET['flag'] == 'Flights' || $_GET['flag'] == 'All-Inclusive'){
			}else{
			$data = groupon_api_call('80','Chicago','all%20inclusive%20resort');
			if(count($data) > 0)
			{	 ?>
				<section id="pinBoot">
					<?php
					$i= 0;
					foreach($data as $homeData)
					{
						$price = $homeData['options'][0]['price']['formattedAmount'];
						$value = $homeData['options'][0]['value']['formattedAmount'];
						$discountPercent = $homeData['options'][0]['discountPercent'];
						$endAt = 	$homeData['options'][0]['endAt'];
						$endDate = date('m/d/Y', strtotime($endAt));
						$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
						$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
						$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
						$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
						$tourname = $homeData['title']; 
						$out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
							if($discountPercent != 0){
							$i++;
							?>
							<article class="white-panel">
								<a href="<?php echo  $homeData['dealUrl']; ?>"  target="_blank"><img src="<?php echo $homeData['grid4ImageUrl']; ?>" alt=""></a>
								<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
									<h2 class="discountPercent"><?php echo $discountPercent; ?>% Off</h2>
									<h1 class="nameIsan hotelandingnameIsan" style= "text-align: center; font-size: 14px"><?php echo $out ; ?></h1>
								</a>
								<h1 class="pricelanding"><?php echo $price ;?></h1>
								<h2 class="valuelanding"><?php echo $value ; ?></h2>
								<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
							</article>
							<?php
						}
					}
					?>
				</section>
				<?php
			} 
 } } ?>
	</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
                      .exec(window.location.search);

    return (results !== null) ? results[1] || 0 : false;
}
// if($.urlParam('flag') == 'Vacations'){
// 	$('.right').css('display','none');
// 	$('.left').css('display','none');
// }
	$('#search-yelp-horizontal').hide();
	$('#search_result_dropdown').hide();
	$('#search_box_icon').click(function(){
		$('#search-yelp-horizontal').toggle(100);
	});
	$('.searchrandoms').click(function(){
		var keyword = $('.randomSearchs').val();
		if(keyword != ''){
			 window.location = "random_deals_mobile.php?keyword="+keyword;
		}else{
			 window.location = "random_deals_mobile.php";
		}
	})
	$('#searchrandoms').click(function(){
		var keyword = $('#searchbox-yelp').val();
		if(keyword != ''){
			 window.location = "random_deals_mobile.php?keyword="+keyword;
		}else{
			 window.location = "random_deals_mobile.php";
		}
	})
		$('.main_filters').click(function(){
		var queryArr = [];
			var city = $('#target').val();
			jQuery(".filters:checked").each(function(el) {
				var val = jQuery(this).val();
				queryArr.push(val);	
			});	
		var finalVal = queryArr.join("%2C");
		   window.location.href="http://mysitti.com/random_deals_mobile.php?city="+city+'&flag=Hotels&categories='+'%2C'+finalVal;
	})

	$('.random_flight').on('click', function(){
		var flag = $(this).attr('data');
		var city = $('#target').val();
		if(flag == 'Tours'){
			if(city == 'Washington D.C.'){
				city = 'Washington';
			}
		}
		if(city != ''){
			 window.location.href="http://mysitti.com/random_deals_mobile.php?city="+city+'&flag='+flag;
		}else if(flag == 'Flights'){
			window.location.href="http://mysitti.com/random_deals_mobile.php?flag="+flag;
		}else{
			window.location.href="http://mysitti.com/random_deals_mobile.php?keyword="+flag;
		} 
	});
		$('.random_tours').on('click', function(){
		var flag = $(this).attr('data');
		var city = $('#target').val();
		if(flag == 'Tours'){
			if(city == 'Washington D.C.'){
				city = 'Washington';
			}
		}
		if(city != ''){
			 window.location.href="http://mysitti.com/random_deals_mobile.php?city="+city+'&flag='+flag;
		}else{
			window.location.href="http://mysitti.com/random_deals_mobile.php?keyword="+flag;
		} 
	});
	$('.random_vacation').on('click', function(){
		var flag = $(this).attr('data');
		var city = $('#target').val();
		if(city != ''){

			 window.location.href="http://mysitti.com/random_deals_mobile.php?flag="+flag+'&city='+city;
			}else{
				window.location.href="http://mysitti.com/random_deals_mobile.php?flag="+flag;
			}
	});
	$('.listing_view').on('click', function(){
		var city = $('#target').val();
		var queryArr = [];
		jQuery(".filters:checked").each(function(el) {
				var val = jQuery(this).val();
				queryArr.push(val);	
			});	
		var finalVal = queryArr.join("%2C");
		if(city != ''){
			 window.location.href="http://mysitti.com/random_deals_mobile.php?city="+city+'&flag=Hotels'+'&categories='+'%2C'+finalVal;
		}else{
			window.location.href="http://mysitti.com/random_deals_mobile.php?keyword="+flag;
		} 
	});
});


 $('.slider-single').slick({
 	slidesToShow: 1,
 	slidesToScroll: 1,
 	arrows: true,
 	fade: false,
 	adaptiveHeight: true,
 	infinite: false,
	useTransform: true,
 	speed: 400,
 	cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
 });

 $('.slider-nav')
 	.on('init', function(event, slick) {
 		$('.slider-nav .slick-slide.slick-current').addClass('is-active');
 	})
 	.slick({
 		slidesToShow: 7,
 		slidesToScroll: 7,
 		dots: false,
 		focusOnSelect: false,
 		infinite: false,
 		responsive: [{
 			breakpoint: 1024,
 			settings: {
 				slidesToShow: 5,
 				slidesToScroll: 5,
 			}
 		}, {
 			breakpoint: 640,
 			settings: {
 				slidesToShow: 4,
 				slidesToScroll: 4,
			}
 		}, {
 			breakpoint: 420,
 			settings: {
 				slidesToShow: 3,
 				slidesToScroll: 3,
		}
 		}]
 	});

 $('.slider-single').on('afterChange', function(event, slick, currentSlide) {
 	$('.slider-nav').slick('slickGoTo', currentSlide);
 	var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
 	$('.slider-nav .slick-slide.is-active').removeClass('is-active');
 	$(currrentNavSlideElem).addClass('is-active');
 });

 $('.slider-nav').on('click', '.slick-slide', function(event) {
 	event.preventDefault();
 	var goToSingleSlide = $(this).data('slick-index');

 	$('.slider-single').slick('slickGoTo', goToSingleSlide);
 });</script>
<script>

 $(document).ready(function() {
	$('#myCarousel').carousel({
	interval: 10000
	})
    
    $('#myCarousel').on('slid.bs.carousel', function() {
    	//alert("slid");
	});
    
    
});

</script>

<script>
$("#carousel").owlCarousel({
  autoplay: true,
  lazyLoad: true,
  loop: true,
  
   /*
  animateOut: 'fadeOut',
  animateIn: 'fadeIn',
  */
  responsiveClass: true,
  autoHeight: true,
  autoplayTimeout: 7000,
  smartSpeed: 800,
  nav: true,
  responsive: {
    0: {
      items: 1
    },

    600: {
      items: 3
    },

    1024: {
      items: 4
    },

    1366: {
      items: 4
    }
  }
});
</script>


 <script>
 $(document).ready(function() {
$('#pinBoot').pinterest_grid({
no_columns: 3,
padding_x: 5,
padding_y: 5,
margin_bottom: 100,
single_column_breakpoint: 700
});
});

;(function ($, window, document, undefined) {
    var pluginName = 'pinterest_grid',
        defaults = {
            padding_x: 5,
            padding_y: 5,
            no_columns: 3,
            margin_bottom: 100,
            single_column_breakpoint: 700
        },
        columns,
        $article,
        article_width;

    function Plugin(element, options) {
        this.element = element;
        this.options = $.extend({}, defaults, options) ;
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype.init = function () {
        var self = this,
            resize_finish;

        $(window).resize(function() {
            clearTimeout(resize_finish);
            resize_finish = setTimeout( function () {
                self.make_layout_change(self);
            }, 11);
        });

        self.make_layout_change(self);

        setTimeout(function() {
            $(window).resize();
        }, 500);
    };

    Plugin.prototype.calculate = function (single_column_mode) {
        var self = this,
            tallest = 0,
            row = 0,
            $container = $(this.element),
            container_width = $container.width();
            $article = $(this.element).children();

        if(single_column_mode === true) {
            article_width = $container.width() - self.options.padding_x;
        } else {
            article_width = ($container.width() - self.options.padding_x * self.options.no_columns) / self.options.no_columns;
        }

        $article.each(function() {
            $(this).css('width', article_width);
        });

        columns = self.options.no_columns;

        $article.each(function(index) {
            var current_column,
                left_out = 0,
                top = 0,
                $this = $(this),
                prevAll = $this.prevAll(),
                tallest = 0;

            if(single_column_mode === false) {
                current_column = (index % columns);
            } else {
                current_column = 0;
            }

            for(var t = 0; t < columns; t++) {
                $this.removeClass('c'+t);
            }

            if(index % columns === 0) {
                row++;
            }

            $this.addClass('c' + current_column);
            $this.addClass('r' + row);

            prevAll.each(function(index) {
                if($(this).hasClass('c' + current_column)) {
                    top += $(this).outerHeight() + self.options.padding_y;
                }
            });

            if(single_column_mode === true) {
                left_out = 0;
            } else {
                left_out = (index % columns) * (article_width + self.options.padding_x);
            }

            $this.css({
                'left': left_out,
                'top' : top
            });
        });

        this.tallest($container);
        $(window).resize();
    };

    Plugin.prototype.tallest = function (_container) {
        var column_heights = [],
            largest = 0;

        for(var z = 0; z < columns; z++) {
            var temp_height = 0;
            _container.find('.c'+z).each(function() {
                temp_height += $(this).outerHeight();
            });
            column_heights[z] = temp_height;
        }

        largest = Math.max.apply(Math, column_heights);
        _container.css('height', largest + (this.options.padding_y + this.options.margin_bottom));
    };

    Plugin.prototype.make_layout_change = function (_self) {
        if($(window).width() < _self.options.single_column_breakpoint) {
            _self.calculate(true);
        } else {
            _self.calculate(false);
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName,
                new Plugin(this, options));
            }
        });
    }

})(jQuery, window, document);
 </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.js"></script>
<style type="text/css" href="//cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.min.css"></style>	
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.min.js"></script><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="js/nicescroll/jquery.easing.1.3.js"></script>
<script src="js/nicescroll/jquery.nicescroll.min.js"></script>
<script src="js/nicescroll/jquery.nicescroll.plus.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="<?php echo $SiteURL;?>jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/scripts/demos.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxpanel.js"></script>
</body>
</html>