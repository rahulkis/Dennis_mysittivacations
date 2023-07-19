<?php 
	$currentDatetime = date('Y-m-d H:i:s');

	$currentDate = date('Y-m-d');

	$currentTime = date('H:i:s');

	$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

	$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";

	$ABSPATH =$_SERVER['DOCUMENT_ROOT']."/";

	$getEventsCategory = mysql_query("SELECT * FROM `eventcategory` ORDER BY `catname` ASC ");







if(empty($_SESSION['id']) && !isset($_SESSION['id']) )

{ 

	$id=54;

	$_SESSION['id']=$id;

	$_SESSION['state']='3668';

	$_SESSION['country']='223';

}









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

$ShareFacebookURl = $SiteURL.$profilename;
$ShareTitle = $profilename.' Profile Page';
if(empty($image_nm))
{
	$image_nm = 'images/man4.jpg';
}

?>
<!DOCTYPE HTML>
<html prefix="og: http://ogp.me/ns#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti.com ||<?php echo $titleofpage; ?></title>
<meta property="og:title" content="<?php echo $ShareTitle; ?>" />
<meta property="og:image" content="<?php echo  $SiteURL.str_replace("../", "", $image_nm); ?>" />
<meta property="og:description" content="<?php echo  $ShareFacebookURl; ?>" />
<meta property="og:url" content="<?php echo  $ShareFacebookURl; ?>" />
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<link rel="shortcut icon" href="<?php echo $SiteURL;?>favicon.ico" type="image/x-icon">
<!-- <link rel="icon" href="<?php echo $SiteURL;?>favicon.ico" type="image/x-icon"> -->

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
<script src="<?php echo $CloudURL; ?>lightbox/js/lightbox.js"></script>
<script src="<?php echo $CloudURL; ?>js/custom.js"></script>
<script src="<?php echo $CloudURL; ?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jwplayer-7.2.4/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>
<script src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>
<link rel="stylesheet" href="<?php echo $CloudURL; ?>css/new_portal/smk-accordion.css" />
<script type="text/javascript" src="<?php echo $CloudURL; ?>js/new_portal/smk-accordion.js"></script>
<link rel="stylesheet" href="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.pack.js"></script>
<script type="text/javascript">

$(document).ready(function(){

	$(".filter123").smk_Accordion({

		closeAble: true, //boolean

	});

	$(".fancybox").fancybox();

});

  </script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45982925-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- ======== Include Main Other Javascripts ===============  -->

<?php
// ini_set("display_errors", "1");
// error_reporting(E_ALL);

require 'instagram/instagram.class.php';

require 'instagram/instagram.config.php';

$instaURL = $instagram->getLoginUrlInsta();





if(isset($_GET['msg']) && $_GET['msg'] == 'error1'){ ?>
<script type="text/javascript">

	$(document).ready(function () {    

		$('#v2_log_in').trigger('click');

	});

</script>
<?php }



$banner_query =  mysql_query("SELECT `banner_name` FROM `host_banner` WHERE `user_id` = '".$hostID."' AND user_type = 'club' AND `status` = '1'");

		$banner_query_result = mysql_fetch_assoc($banner_query);

		$countBanner = mysql_num_rows($banner_query);

		$banner = $banner_query_result['banner_name'];

		

		if($countBanner > 0) { ?>

	 <style type="text/css">

			.v2_banner_top

			{

				background-image: url('host_banner/<?php echo $banner; ?>') !important;

			}

		</style>

	 <?php }
		else
		{
			$NoBannerForhost = '0';
		}	


?>
<script type="text/javascript">

	$(document).ready(function () {

		$('#shw_logn_frm, #v2_log_in').live('click', function(){

			

			$.post('redirect_after_login_check.php', { 'unset_store_redirect': true }, function(response){ });

			

			var $aSelected = $('.v2_log_in');

			if( $aSelected.hasClass('close') ){ // .hasClass() returns BOOLEAN true/false

			

			  $aSelected.addClass('open').removeClass('close');
			  $('.v2_login_overlay').show();

			  

			}else{

			

				$$aSelected.removeClass('open').addClass('close');
				$('.v2_login_overlay').hide();
				

			}

		});

		$('.v2_close_signup').click(function(){
			$('.v2_login_overlay, .v2_signup_overlay').hide();
		});

	});

</script>
</head>

<body itemscope itemtype="http://schema.org/Product">
<img itemprop="image" src="<?php echo  $SiteURL.str_replace("../", "", $image_nm); ?>" style="display:none;" />
<div class="slider_body">

	<ul>

		<li><img id="slider_body_img" src="" alt=""></li>

	</ul>

</div>
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

<div class="">
  <div class="v2_header_wrapper">
   <?php 

	if(!isset($_SESSION['user_id']))
	{
		?>
	<div class="v2_top_nav  withoutLoginHeader"><!-- v2_top_nav  starts-->
	  
	  <div class="v2_container">
		<div class="v2_login">
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
						  <input type="text" required="" placeholder="Zip Code" id="zipcode1" maxlength="8" name="zipcode">
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

$(document).ready(function(){
	$('#otherCountry').click(function() {
		if($(this).is(":checked")) {
			//alert('sss');
			$('.fromothercontry').addClass('opt2');
			$('#other1').fadeIn('slow');
		 	$('#other2').fadeIn('slow');
		  	$('#other3').fadeIn('slow');
		  	$('#zipcode').fadeOut('slow');

		}
		else
		{
			//alert('000');
			$('.fromothercontry').removeClass('opt2');
			$('#other1').fadeOut('slow');
			$('#other2').fadeOut('slow');
			$('#other3').fadeOut('slow');
			$('#zipcode').fadeIn('slow');
		}

	});

	$('.tips').hover(function(){
		$('.hoverme').css('display', 'block');
		},
		function(){
		$('.hoverme').css('display', 'none');
		}
		);
});

function showState(x)
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

		message: '<h1>Loading States And Cities</h1>'

	});

	if(x=='223')
	{
		 $.get('getcity_sign.php?con=us', function(data) {
			$('#usercity').html(data);
			$.unblockUI();
		});
	}
	else if(x=='245')
	{
		 $.get('getcity_sign.php?con=esp', function(data) {
			$('#usercity').html(data);
			$.unblockUI();
		});
	}
	else
	{
		$.get('getcity_sign.php?con=ca', function(data) {
			$('#usercity').html(data);
			$.unblockUI();
		});
	}
	ajaxFunction("getstate.php?country_id="+x, function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var s = xmlhttp.responseText;    //   s = "1,2,3,|state1,state2,state3,"
			s=s.split("|");                              //   s = ["1,2,3,", "state1,state2,state3,"]
			sid = s[0].split(",");  
			//  sid = [1,2,3,]
			sval = s[1].split(",");      
			//  sval = [state1, state2, state3,]
			st = document.getElementById('userstate');
			st.length=0; 
			for(i=0;i<sid.length-1;i++)
			{
				st[i] = new Option(sval[i],sid[i]);
			}     
			$.unblockUI();         
		}
		
	});
	
}

function getcity(x)
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

		message: '<h1>Loading Cities</h1>'

	});
	$.get('getcity_sign.php?state_id='+x, function(data) 
	{
		$('#usercity').html(data);
		$.unblockUI();
	});

}

</script>
					<style type="text/css">

	#signupd p input#hosttype {

		float: left !important;

		left: 0;

		position: relative;

		top: 0;

	}
 body {
  padding-top: 47px !important;
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


	.slider_body, .v2_header
	{
		display: none !important;
	}

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
	#Businesscheck &gt; span {
		  float: left;
		  line-height: 20px;
	}

.left_opt select
{
	margin-top: 0;
}

#user #signupd input[type="checkbox"]
{
	float: left;
	left: 0;
	position: relative;
	top: 0;
}
.tips {position:relative;}

.othercountryCheck strong {
  /*background: #0361ac none repeat scroll 0 0;*/
  border-radius: 50%;
  box-sizing: border-box;
  color: #000;
  display: inline-block;
  height: 15px;
  margin: 0 5px;
  text-align: center;
  width: 15px;
  position: relative;
}

i.hoverme {
  background: #111 none repeat scroll 0 0;
  border-radius: 0;
  box-shadow: 0 0 4px #555;
  color: #fff;
  left: 31px;
  line-height: normal;
  min-width: 200px;
  padding: 10px;
  position: absolute;
  top: -3px;
  z-index: 99;
  display:none; 
}

i.hoverme::before {
  border-bottom: 6px solid transparent;
  border-right: 6px solid #111;
  border-top: 6px solid transparent;
  content: "";
  height: 0;
  left: -6px;
  position: absolute;
  top: 6px;
  width: 0;
}

</style>
					<div  id="user" >
					  <form action="paymentoption.php" method="post" class="tab_standerd v2_user_reg" id="signupd" name="signupd" autocomplete="off" novalidate="novalidate">
			<p>
							<input type="text" autocomplete="off" required="" placeholder="Email Address" onblur="return ChkUserId(this.value,'user','https://mysitti.com/');" name="email" tabindex="1">
			</p>
			<p>
							<input type="text" required="" placeholder="Zip Code" maxlength="8" id="zipcode" name="zipcode" tabindex="2" autocomplete="off">
			</p>
			
			<div class="clear"></div>
			<p>
							<input type="password" required="" placeholder="Password" id="password" name="password" tabindex="4" autocomplete="off">
			</p>
			<p>
							<input type="password" required="" placeholder="Confirm Password" name="cpassword" tabindex="5" autocomplete="off">
			</p>
			<div class="clear"></div>
			<div class="left_opt">
	  			<span class="fromothercontry">
					<span id="" class="othercountryCheck">
						<input type="checkbox" id="otherCountry" name="CountryOther"  style="float:left;">
						<span>From another country<span class="tips"><strong>?</strong><i class="hoverme">If you don't have Zipcode. Then select other country option and choose your location. </i></span></span>
					</span>
				</span>
   				<div id="other1" class="options"  style="display:none; ">   
					<select name="country" id="country" onChange="showState(this.value);">
							<option value="">Country</option>
		 <?php 
						$country_nm_qry = mysql_query("SELECT * FROM `country` WHERE `country_id` IN ('223','38','245')  ORDER BY `name` ASC");
						//$country_nm = mysql_fetch_array($country_nm_qry);
						while($row = mysql_fetch_array($country_nm_qry))
						{
	?>
							<option value="<?php echo $row['country_id'];?>" ><?php echo $row["name"]; ?></option>
			<?php 		}  	?>
					</select>
			 	</div>
		 		<div class="clear"></div>
		  		<div id="other2" class="options"  style="display:none; ">   
					<select required="" name="state" tabindex="6" id="userstate" style="margin-top:5px; " onChange="getcity(this.value);">
						<option value="">State / Province</option>
					</select>
			 	</div>
		  		<div id="other3" class="options"  style="display:none; ">   
					<select required="" name="city" tabindex="6" id="usercity" style="margin-top:5px; ">
						<option value="">City</option>
					</select>
			 	</div>
	  		</div>   
	  <span class="v2_accept_terms">
											<span id="Businesscheck" class="aboutYou">
					<input type="checkbox" id="hosttype" name="hostTYPE" onclick="displayFields();" style="float:left;">
					<span>Are you an Artist or Local Business?</span></span> </span>
				<div class="clear"></div>
			<div id="hostFieldsBlock" style="display: none;"> 
				<p id="profilesName">
					<input type="text" required="" placeholder="Profile or Business Name" onblur="return ChkUserProfile(this.value,'user','https://mysitti.com/');" name="profilename" tabindex="3" autocomplete="off" style=" margin-top:5px;">
				</p>
				<p id="hostsFields">
					<select required="" name="host_category" tabindex="6" id="host_category" style="margin-top:5px; ">
						<option value="">Select type of Business</option>
						<option value="108">Artist</option>
						<option value="91">Bar</option>
						<option value="92">Club</option>
						<option value="103">Fight</option>
						<option value="106">Fighter</option>
						<option value="107">Promoter</option>
						<option value="109">Promoter Artist</option>
						<option value="1">Restaurants</option>
						<option value="102">Theatre</option>
						<option value="104">Wedding</option>
					</select>
				</p>
			</div>
			<div class="clear"></div>
				<div class="clear"></div>
				
										<div class="agreementTerms aboutYou">
										<div class="span">
					<input type="checkbox" value="1" id="acknowledgement" name="acknowledgement">
					<span>I have read and agree to the</span> 
										</div>
										<a onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="float: left; padding: 0 10px 0 0;">Privacy Policy*</a>
										</div>
				<div class="clear"></div>
				<input type="hidden" name="plantype" value="free">
				
				<!-- <input type="hidden" value="" name="captchcodeuser" id="captchacodeuser"> -->
				
				<input type="hidden" name="planid" value="1">
				<input type="hidden" id="userTYPE" name="UserType" value="user">
				<input type="submit" value="Sign Up" name="submit">
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
			  <div class="v2_log_in close">
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
				  <p class="cleataccount">Don't have a MySitti account? <a href="javascript:void(0);" onclick="show_login_popop(); return false;">Sign up now</a>
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
					<a href="<?php echo $authUrl; ?>" target="blank"><img alt="Login from Google Plus" src="<?php echo $SiteURL;?>images/googleplus1.png"></a>
					<?php                       	} 	?>
				  </div>
				</div>
			  </div>
			  <div class="v2_login_overlay"></div>
			</li>
			<li>
			<li class="fordesk"><a href="<?php echo $SiteURL; ?>support.php" class="v2_help"> Help </a></li>
			</li>
		  </ul>
		  <div class="v2_filter_box publicHeader" id="topCitySearch"> 
			
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

											if(isset($_SESSION['state']) and $_SESSION['state'] != '')

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
	<div class="newmenu_mobile">
	  <ul>
		<li>
		  <div class="next">
			<div id="dromMenu" class="heads"><img src="<?php echo $SiteURL;?>images/Contest.png" alt="">
			  <label> Contests</label>
			</div>
		  </div>
		  <div class="menupopup">
			<ul>
			  
			  <!--<li><a href="<?php echo $SiteURL;?>live_host_contests.php">Live Contests</a></li>-->
			  
			  <li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">Mysitti Contests</a></li>
			  <?php if($_SESSION['user_type'] == 'user'){ ?>
			  <li><a href="<?php echo $SiteURL;?>current_host_contests.php">Host Contests</a></li>
			  <?php } ?>
			</ul>
		  </div>
		</li>
		<li><a href="<?php echo $SiteURL;?>searchEvents.php">
		  <div class="next">
			<div class="heads"><img src="<?php echo $SiteURL;?>images/CityEvents.png" alt="">
			  <label> City Events</label>
			</div>
		  </div>
		  </a> </li>
		<li><a href="<?php echo $SiteURL;?>city_talk.php">
		  <div class="next">
			<div class="heads"><img src="<?php echo $SiteURL;?>images/CityTalk.png" alt="">
			  <label>City Talk</label>
			</div>
		  </div>
		  </a> </li>
		<li><a href="<?php echo $SiteURL;?>advanced_filters.php?cat_id=1">
		  <div class="next">
			<div class="heads"><img src="<?php echo $SiteURL;?>images/HotSpots.png" alt="">
			  <label>Host </label>
			</div>
		  </div>
		  </a> </li>
		<li><a href="#searchArea" class="">
		  <div class="next">
			<div class="heads"><img src="<?php echo $SiteURL;?>images/searchEvent.png" alt="">
			  <label>Search</label>
			</div>
		  </div>
		  </a> </li>
		<li><a href="<?php echo $SiteURL;?>support.php" class="">
		  <div class="next">
			<div class="heads"><img src="<?php echo $SiteURL;?>images/Helpout.jpg" alt="">
			  <label>Help</label>
			</div>
		  </div>
		  </a> </li>
	  </ul>
	</div>
	 <?php 
		 } 
				else 
				{

				?>
	<!-- afterlogin view of the public profile page -->
	  <style type="text/css">
	  body { padding-top: 95px;}
	  </style>
	<div class="v2_header new_header_top">
			<div class="v2_container">
				<div class="hidefordeskmenu">
					<input type="button" class="menu_toggle" value="Menu">
					<div class="v2_nav v2_nav_host v2_nav2 host_fullnav">
						<ul>
							<li class="small_logo"> 
								<img src="<?php echo $SiteURL;?>images/logo_without_tag.png" alt=""><i>MySitti.com</i>
							</li> 
							<li <?php if($_SERVER['SCRIPT_NAME'] == '/artist_home.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/band_home.php'
					|| $_SERVER['SCRIPT_NAME'] == '/comedy_home.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/dj_home.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/extreme_home.php'  
					|| $_SERVER['SCRIPT_NAME'] == '/extreme_profile.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/fight_home.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/fighter_home.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/fighter_profile.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/home_club.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/host_profile.php'
					|| $_SERVER['SCRIPT_NAME'] == '/profile.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/promoter_home.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/promoter_artist_home.php' 
					|| $_SERVER['SCRIPT_NAME'] == '/theatre_home.php' ){ echo "class='active'";} ?>> 
								<a href="<?php if($_SESSION['user_type'] == 'user'){ echo $SiteURL.'profile.php';}else{ echo $SiteURL.'home_club.php';} ?>">
									<span data-title="Home">Home</span>
								</a> 
							</li>
							<li <?php if($_SERVER['SCRIPT_NAME'] == '/searchEvents.php'){ echo "class='active' ";} ?>> <a href="searchEvents.php"> <span data-title="City Events">City Events</span> </a> </li>
							<li <?php if($_SERVER['SCRIPT_NAME'] == '/city_talk.php'){ echo "class='active' ";} ?>> <a href="city_talk.php"> <span data-title="City Talk">City Talk</span> </a> </li>
							<li <?php if($_SERVER['SCRIPT_NAME'] == '/mysitti_contestsList.php' || $_SERVER['SCRIPT_NAME'] == '/current_host_contests.php' || $_SERVER['SCRIPT_NAME'] == '/LiveContest.php'  || $_SERVER['SCRIPT_NAME'] == '/mysitti_contests.php' || $_SERVER['SCRIPT_NAME'] == '/view_contestent.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL; ?>mysitti_contestsList.php"> <span data-title="Contest">Contest</span> </a>
								<ul>
									<!--<li><a href="<?php echo $SiteURL;?>live_host_contests.php">Live Contests</a></li>-->
									<li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">Mysitti Contests</a></li>
									<?php if($_SESSION['user_type'] == 'user'){ ?>
									<li><a href="<?php echo $SiteURL;?>current_host_contests.php">Host Contests</a></li>
									<?php } ?>
								</ul>
							</li>
							<li style="display:none" <?php if($_SERVER['SCRIPT_NAME'] == '/live2/battle.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>live2/battle.php"> <span data-title="Live Battle">Live Battle</span> </a> </li>
							<li <?php if($_SERVER['SCRIPT_NAME'] == '/MySittiTV.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>MySittiTV.php"> <span data-title="MySitti TV">MySitti TV</span> </a> </li>
	<?php 
							if($_SESSION['user_type'] == 'club' && !isset($_SESSION['subuser']))
							{ 
	?>
																									
								<!-- <li><a href="<?php echo $SiteURL; ?>shout.php"><span data-title="Shout">Shout</span></a></li> -->

						<?php 	}
							elseif($_SESSION['user_type'] == 'club' && isset($_SESSION['subuser']))
							{
							?>
								<li><a href="<?php echo $SiteURL; ?>music_request.php?host_id=<?php echo $_SESSION['user_id'];?>"><span data-title="Jukebox">Jukebox</span></a></li>
								<!-- <li><a href="<?php echo $SiteURL; ?>shout.php"><span data-title="Shout">Shout</span></a></li> -->
								
								<?php 
							} 
							?>
						</ul>
						<div class="v2_profile_user profilrForDesktop">
		<?php
							if($_SESSION['user_type'] == "user")
							{
								$linkProfile = "profile.php";
								$profilenameDisplay = $loggedin_user_data['profilename'];
							}
							else
							{
								$linkProfile = "home_club.php";
								$profilenameDisplay = $_SESSION['username'];
							}
								?>
								<div class="v2_thumb_user_profile user_profile_host2"> 
									<a href="<?php echo $SiteURL.$linkProfile; ?>"> 
										<img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$_SESSION['img'];} ?>" alt="user" > 
										</a> 
								</div>
								<div class="v2_profile_user_info user_info_host2"> <span class="v2_welcome_user">Welcome</span>
										<div class="clear"></div>
										<span class="v2_user_name"> <a href="<?php echo $SiteURL.$linkProfile; ?>">
										<?php if(empty($profilenameDisplay)){ echo "Mysitti"; }else{ echo $profilenameDisplay; } ?>
										</a> </span> 
								</div>
						</div>
						<div class="searchBoxTop searchInnerBox pullRight hideform">
							<form method="POST" action="<?php echo $SiteURL."searchUsers.php";?>" id="searchUsersForm">
								<input type="text" id="searchUsers" value="" name="keyword_search" placeholder="Search By Username" class="adSearch">
								<input type="submit" id="findContestant" class="searchBoxTopBtn" name="SearchAllUsers" value="">
							</form>
						</div>	
						<script type="text/javascript">
			$(document).ready(function(){	
				
				$( "#searchUsers" ).keypress(function() {
					var url = $('#siteURL').val();

					var URL = url+'refreshajax.php?action=fetchusernames';
					$('#searchUsers').autocomplete(URL);

				});


				function test()

				{

					var cityid = $('.ac_over').find('p').text();



					var club1 = $('.ac_over').html().split('<p');

					$('.ac_over').find('p').remove();

					var club = club1[0];

					var r = /<(\w+)[^>]*>.*<\/\1>/gi;

					var url = $('#siteURL').val();

					

					setTimeout(function() {

						  // Do something after 5 seconds

							

						var tt = $('#eventsearch').val();

						var tt2 = $('#clubs_autocomplete').val();







							if(tt == "" || tt == " ")

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

								message: '<h1>Loading Results</h1>'

								});

								$('#clubs_autocomplete').text(club);

								$.ajax({

								type: "POST",

								url: "refreshajax.php",

								data: {

								'fetchresult' : 'fetchresult',

								'clubname' : club,

								'city' : cityid,

								},

									success: function(data){

										$('#get_clubs_results ul').empty();

										//$('#get_clubs_results ul').html(data);

										document.location.href = data;

										return false;

									}

								   });

							}



					}, 1000);	

				}

			});
		</script> 
																</div>
												</div>
												<?php
		include('image_upload_resize.php');
		include("resize-class.php");
		//include("user_upgrade.php");
		?>
								</div>
				</div>
			<div class="v2_nav_profile nav_profile_host HosstHeader">
								<div class="v2_container">
												<div class="userlogo userlogo_host">
																<div class="logomobi">
																				<ul>
																								<li class="small_logo"> <a href="index.php"><img alt="" src="images/logo_without_tag.png"><i>MySitti.com</i></a> </li>
																				</ul>
																</div>
																<div class="v2_profile_user user_profile">
																				<?php
					if($_SESSION['user_type'] == "user")
					{
						$linkProfile = "profile.php";
						$profilenameDisplay = $loggedin_user_data['profilename'];
					}
					elseif($_SESSION['user_type'] == 'club' && !isset($_SESSION['subuser']))
					{
						$linkProfile = "home_club.php";
						$profilenameDisplay = $_SESSION['username'];
					}
					elseif($_SESSION['user_type'] == 'club' && isset($_SESSION['subuser']))
					{
						$linkProfile = "musicrequestList.php";
						$profilenameDisplay = $_SESSION['username'];
					}
						?>
																				<div class="v2_thumb_user_profile"> <a href="<?php echo $SiteURL.$linkProfile; ?>"> <img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$_SESSION['img'];} ?>" alt="user" /> </a> </div>
																				<div class="v2_profile_user_info"> <span class="v2_welcome_user">Welcome</span> <span class="v2_user_name"> <a href="<?php echo $SiteURL.$linkProfile; ?>">
																								<?php if(empty($profilenameDisplay)){ echo $_SESSION['username']; }else{ echo $profilenameDisplay; } ?>
																								</a> </span> </div>
																</div>
												</div>
								</div>
								<div class="v2_nav_profile new_nav_profile for_responsive_topfilter">
		 
											<div class="v2_container">
														<?php 	
															if($_SESSION['user_type'] == 'club')
															{
														?>
																<div class="uload_banner_header forHost" style="display:none;"> 
																	<a href="<?php echo $SiteURL; ?>upload-banner.php">
																		<img src="images/uploadbanner.png" alt="Upload" title="Upload Header Banner">
																	</a> 
																</div>
														<?php 	}	?>
																<ul class="helpme fordesk">
																				<li> <a href="<?php echo $SiteURL; ?>support.php"><span data-title="Help"> Help</span> </a> </li>
																				<li><a href="<?php echo $SiteURL; ?>main/logout.php"><span data-title="Logout">Logout</span></a></li>
																</ul>
																<div class="v2_login login_profile filter_area mobilefil">
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
										$countrysql1="select zone_id,name from zone where country_id IN(".$_SESSION['country'].") and status ='1' ORDER BY `name` ASC";
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
																<?php 		//	}	?>
																<?php if($_SESSION['user_type'] == 'club'){ ?>
																<ul class="noborder no_padd hideformobile">
																				<li><a href="<?php echo $SiteURL; ?>shout.php"><span data-title="Shout">Shout</span></a></li>
																				<li><a href="<?php echo $SiteURL; ?>store.php"><span data-title="Store">Store</span></a></li>
																				<li><a href="<?php echo $SiteURL; ?>eventscalendar.php"><span data-title="Calender">Calender</span></a></li>
																</ul>
																<?php } ?>
																<?php if($_SESSION['user_type'] == 'user'){ ?>
																<ul class="noborder no_padd hideformobile">
																				<li><a href="<?php echo $SiteURL; ?>user_shout.php"><span data-title="Shouts">Shouts</span></a></li>
																				<li><a href="<?php echo $SiteURL; ?>all_hosts.php"><span data-title="Favorite">Favorite</span></a></li>
																				<li><a href="<?php echo $SiteURL; ?>myCalendar.php"><span data-title="Calender">Calender</span></a></li>
																</ul>
																<?php } ?>
																<div class="v2notification notify_hostside hideformobile">
																				<?php
						include('notifications.php'); ?>
																</div>
												</div>
					 
								</div>
				</div>
	   
	
  <!-- End afterlogin view of the public profile page -->
	<?php 
	}
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
	<style>

@media only screen and (max-width: 767px) {
  body {
  padding-top: 63px !important;
}
  .v2_accept_terms > span {
 margin: 10px 0 !important;
}
.v2_accept_terms input[type="checkbox"] {
  position: static;
  margin-top: 3px;
  margin-right: 5px;
}
.v2_brand { 
  margin: 0 auto; 
}
.withoutLoginHeader #topCitySearch {

  left: 0 !important;

  position: absolute !important;

  top: 0 !important;

}

.v2_filter_box {

  clear: none;

  float:left !important;

}

.v2_container .v2_login div#topCitySearch{

  float:left !important;

}

}
.v2_get_started {
  background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;
  display: table;
  margin: 0 auto auto;
  padding: 5px 0;
  text-align: center;
  width: auto;
  float:  none;
}
.v2_get_started h4 {
  color: #fff;
  display: table-cell;
  float: none;
  font-size: 22px;
  font-weight: bold;
  line-height: normal;
  padding: 10px;
  text-align: center;
  text-transform: uppercase;
  vertical-align: middle;
  width: auto;
}
.v2_get_started h3 {
  box-sizing: border-box;
  display: table-cell;
  float: none;
  margin: 0;
  padding: 0;
  width: auto;
}
.spacer50 {
  margin-top: 55px;
}
.v2_brand  span {
	margin-top: 20px;
	width: 100%;
	float: left;
	text-align: center;
	color: #fff;
	display: initial;
	font-family: arial;
	font-size: 15px;
	font-weight: bold;
	padding: 5px 0px;
	position: relative;
	text-decoration: none;
	text-transform: uppercase;
	text-shadow: 0 1px 1px #111;
}
@media only screen and (max-width: 479px) {
 .v2_get_started h3 a {padding: 12px 0;}
 .v2_get_started h4 {font-size: 13px;} 
}

.v2_get_started{ display: none;}


</style>
	
	<!-- v2_top_nav  ends--> 
	<div class="banernew v2_banner_top top0">
	<div class="v2_container">
	  <div class="v2_brand"> <span class="tgLine">Making Every City Your City</span><div class="clear"></div><a href="index.php"> <img src="<?php echo $SiteURL;?>images/v2_logo_round.png" alt="" />
		<div class="clear"></div>
		 </a> </div>
	  <div class="clear"></div>  
	  <div class="v2_search_area" id="search_Events">
		<h1>FIND YOUR NEXT EXPERIENCE</h1>
		<div class="clear"></div>
		<div class="v2_search-area">
		  <form method="POST" action="<?php echo $SiteURL;?>searchEvents.php" style="float: left; width:100% !important;">
			<div class="v2_date v2_input_search">
			  <input type="text" name="date_s" class="onlyDate"  id="datetimepicker_search" value="" placeholder="Select Date"  />
			</div>
			<div class="v2_cat">
			  <select id="eventcatselect" name="eventcat">
				<option value="">Select Category</option>
				<?php 

									$d_category = "9";



									while($fetchEventCategory = mysql_fetch_assoc($getEventsCategory))

									{

										?>
				<option <?php if(isset($_GET['c']) && $fetchEventCategory['id'] == $_GET['c'] ){ echo "selected"; }elseif($fetchEventCategory['id'] == '9' && !isset($_GET['c'])){ echo "selected";}?> value="<?php echo $fetchEventCategory['id'];?>"><?php echo $fetchEventCategory['catname'];?></option>
				<?php 

									}

								?>
			  </select>
			</div>
			<div class="v2_input_search">
			  <input type="text" id="eventsearch" name="keyword_search"  value="" placeholder="Search"  />
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
	</div>
	</div>
	<div class="v2_get_started" <?php if(!empty($_SESSION['user_id'])){ echo 'style="display:none;"';} ?>>
	  <h4>Create your own event</h4>
	  <h3> <a href="javascript: void(0)" id="shw_logn_frm"> <span data-title="Get Started">Get Started</span> </a> </h3>
	  <div class="clear"></div>
	</div>
	<div class="v2_header" <?php if(!empty($_SESSION['user_id'])){ echo 'style="display:none;"';} ?> >
	  <div class="v2_container">
		<div class="v2_nav">
		  <ul>
			<li> <a href="<?php echo $SiteURL;?>index.php"> <span data-title="Home">Home</span> </a> </li>
			<li> <a href="<?php echo $SiteURL;?>searchEvents.php"> <span data-title="City Events">City Events</span> </a> </li>
			<li> <a href="<?php echo $SiteURL;?>city_talk.php"> <span data-title="City Talk">City Talk</span> </a> </li>
			<li> <a href="#"> <span data-title="Contest">Contest</span> </a>
			  <ul>
				
				<!-- <li><a href="<?php echo $SiteURL;?>live_host_contests.php">Live Contests</a></li>

								<li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">Mysitti Contests</a></li>

								<li><a href="<?php echo $SiteURL;?>current_host_contests.php">Host Contests</a></li> -->
				
				<li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">Mysitti Contests</a></li>
				<li><a href="<?php echo $SiteURL;?>current_host_contests.php">Host Contests</a></li>
			  </ul>
			</li>
			<li> <a href="<?php echo $SiteURL;?>battle.php"> <span data-title="Live Battle">Live Battle</span> </a> </li>
		  </ul>
		</div>
	  </div>
	</div>
	<?php

		$catArray = array('96','97','101','102','103','106','107','108');

		if(in_array($type_of_club, $catArray))

		{

	?>
	
	<!-- profilebar-2 with center aligned profile pic -->
	
	<div class="v2_profile2_wrapper">
	  <div class="v2_profile_inner">
		<div class="v2_container">
		  <div class="v2_profile2_left">
			<h1 class="name_pro_fight"><?php echo $profilename; ?></h1>
			<div class="clear"></div>
			<div class="counter"> <span class="views">Viewers: </span>
			  <div class="total"><?php echo $profileViewCount; ?> </div>
			</div>
		  </div>
		  <div class="v2_profile2_pic_container">
			<div class="v2_profile2_pic">
			  <?php 

							if(empty($image_nm))

							{

								$imgSRC = "images/man4.jpg";

							}

							else

							{

								$imgSRC = $image_nm;

							}

						?>
			  <img align="" src="<?php echo $imgSRC; ?>"> </div>
		  </div>
		  <div class="v2_profile2_right">
		   <div class="v2_addresbox_pro2">

		<?php 

		if(!empty($web_url))
		{
			if(strpos($web_url, 'http') === true )
			{
				$Anchorweb_url = $web_url;
			}
			else
			{
				$Anchorweb_url = "https://".$web_url;
			}
		?>

			<a target="_blank" href="<?php echo $Anchorweb_url; ?>"><?php echo $web_url; ?></a>

	<?php 	} 	?>

	   </div>

	   <div class="clear"></div>

		<div class="v2_alocation_pro2"> 

			<span class="clubAddress">

			<?php 

				//if(!empty($club_address) && $userArray[0]['hideaddress'] == '0' )

				//{

					if($userArray[0]['show_city_state_phone'] == '1')

					{

						$cityID =  $userArray[0]['club_city'];

						$stateID = $userArray[0]['club_state'];

						$getClubCity = mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$cityID' ");

						$fetchClubCity = mysql_fetch_assoc($getClubCity);

						$getClubState = mysql_query("SELECT * FROM `zone` WHERE `zone_id` = '$stateID' ");

						$fetchClubState = mysql_fetch_assoc($getClubState);

						echo $fetchClubCity['city_name'].", ".$fetchClubState['name']." <br /> ".$userArray[0]['club_contact_no'];

					}
					elseif(!empty($club_address) && $userArray[0]['hideaddress'] != '0')
					{
						echo "";					
					}
					elseif(!empty($club_address) && $userArray[0]['hideaddress'] == '0')
					{

						echo $club_address;

					}

				//}

			?>

			</span>

			<?php 

				if($userArray[0]['hide_google_map'] == '0')

				{

			?>		<a href="javascript:void(0);" onclick="goto('view-map.php?add=<?php echo $userID; ?>');"> 

						<img align="" src="images/geolocation.png">

					</a> 

			<?php 	}	?>
<div class="social_media">
			<?php 

				if(!empty($facebookLink))

				{

			?>
			<a href="<?php echo $facebookLink;?>"> <img alt="" src="https://mysitti.com/images/fbook.png" al=""> </a>
			<?php 

					}

					if(!empty($twitterLink))

					{

				?>
			<a href="<?php echo $twitterLink;?>"> <img alt="" src="https://mysitti.com/images/twt.png"> </a>
			<?php 	}

				if(!empty($instaLink))

				{

			?>
			<a href="<?php echo $instaLink;?>"> <img alt="" src="https://mysitti.com/img/icon8.png"> </a>
			<?php }	?>
		  </div>
		</div>

	   <div class="clear"></div>

	  </div>
		  
		  <div class="clear"></div>
		</div>
	  </div>
	</div>
	
	<!-- end profilebar 2 -->
	
	<?php 	}	?>
  </div>
  <!-- END v2_header_wrapper --> 
  
</div>
<!-- v2_banner_top -->

<div class="clear"></div>
<?php 

//include('image_upload_resize.php');



//include("resize-class.php");

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











//echo "<pre>"; print_r($_SESSION);echo "</pre>";

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

		$('#Search_box_filter').hide().before('<a href="#" id="toggle-menu" class="v2_filter_menu"><?php echo $dropdown_city; ?>, <?php echo $dropdown_state; ?><img src="images/new_portal/menu.png" alt="Menu" /></a>');

		$('a#toggle-menu').click(function (e) {

			e.preventDefault();

			$('#Search_box_filter').slideToggle(200);

		});

		$('#dropdownlistContentjstate_name').find('input[type="textarea"]').val('<?php echo $set_state_name;?>');

		$('#dropdownlistContentjcity_name').find('input[type="textarea"]').val('<?php echo $set_city_name; ?>');

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



function openLoginpop(url)



	{



			$.post('redirect_after_login_check.php', { 'set_store_redirect': true, 'successurl':url }, function(response){ });



		 



			var $aSelected = $('.v2_log_in');



			if( $aSelected.hasClass('close') ){ // .hasClass() returns BOOLEAN true/false



			



			  $('.close').addClass('open').removeClass('close');



			  



			}else{



			



				$('.v2_log_in').addClass('open');







			}



	}



	



	function show_login_popop(){

// alert('sdsdsds');

			var $aSelected = $('.v2_log_in');



			var $signupSelected = $('.v2_sign_up');



			if( $aSelected.hasClass('open') ) // .hasClass() returns BOOLEAN true/false
			{
				if( $signupSelected.hasClass('close') ){ // .hasClass() returns BOOLEAN true/false

					$('.close').addClass('open').removeClass('close');
					$('.v2_log_in').addClass('close').removeClass('open');
					$('#v2_sign_up_after').show();
				}else{
					$('.v2_log_in').addClass('close').removeClass('open');
					$('.v2_sign_up').addClass('open');
					$('.v2_sign_up.open').css({'display': 'block !important'});
				}
			}
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

<!-- END TOP SEARCH SCRIPT --> 

<!-- BACKGROUND SLIDER CODE -->

<?php

/* host custom background code goes here */



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

				$('#slider_body_img').attr('src', imgsrc);

			});

		</script>
		<style type="text/css">
			.common_box
			{
				position: static;
				background-image: none;
			}
		</style>

<?php

	}




/* host custom background code goes here */

/*----------------------------------------------------------------------*/



$get_time = @mysql_query("SELECT * FROM refresh_background_time");
	// echo  $NoBannerForhost; die;
	$time = @mysql_fetch_assoc($get_time);
	if($NoBannerForhost == '0')
	{
			// die('dfdf');
		$get_images = mysql_query("SELECT * FROM refresh_background WHERE city_name LIKE '%".$dropdown_city."%' AND refresh_status = '1'");
		while($row = mysql_fetch_assoc($get_images))
			{
			
					$images_array[] = $row['city_image_id'];
			
			}
			if(!empty($images_array))
			{
			
				$random_key = array_rand($images_array, 1);
			  
				$img_id = $images_array[$random_key];
				//echo "SELECT city_image_url FROM capital_city_images WHERE city_image_id = '".$img_id."'";
				$get_single_image = mysql_query("SELECT city_image_url FROM capital_city_images WHERE city_image_id = '".$img_id."'");
			
					$row = mysql_fetch_assoc($get_single_image);
					if(mysql_num_rows($get_single_image) > 0)
					{
						$imagesrcback =  "/admin/cities/".$row['city_image_url'];
						$intervalq = mysql_query("SELECT * FROM `refresh_background_time`");
						$intervalf = mysql_fetch_array($intervalq);
					
						ob_start();
				setcookie("backgroundcookie", $imagesrcback,time() + (60 * $intervalf['time_interval'] ) );
				ob_end_clean();
				
			}
			}
		?>

		<script type="text/javascript">

			$(document).ready(function(){

				

				var time = '<?php echo $time['time_interval']; ?>';
				var defimage = '<?php echo $imagesrcback; ?>';
				if( defimage === "" || defimage === " ")
				{
					defimage =  "images/v2_header_bg.jpg";
					$('.v2_banner_top').css('background-image', 'url('+defimage+')');
				}
				else
				{
					$('.v2_banner_top').css('background-image', 'url('+defimage+')');
				

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

								//alert(msg);

								if( (msg == 'disable') || (msg == '') ) 

								{

									//$('.home_wrapper').css('background-image', 'url(/images/homebg.png)');

									//$('.slider_body ul').find('img').attr('src','/images/homebg.png');

											

								}

								else

								{

									$('.v2_banner_top').css('background-image', 'url('+msg+')');	

									//$('.slider_body ul').find('img').attr('src',msg);			

								}

							}

						  });		

						  // }, 1000);	

					}, 1000 * 60 * time); // where X is your every X minutes								
				}
				

			});

		</script>

		<?php 
	}


/*--------------------------------------------------------------------------------*/

?>

<!-- END BACKGROUND CODE -->

<div class="common_box spacer50">
<div class="v2_container">
<div class="v2_wrapper_video nogutter"> 
  
  <!-- <div class="v2_brand_new">  

				<a href="index.php">

					<img src="images/v2_logo_round.png" alt="" /><div class="clear"></div>

				  

				</a> 	

			</div>-->
  
  <div class="v2_play_vid_current" style="height: auto !important;">
	<div class="sxtreme_play_vid <?php if(detect_stream($n)===true){ echo 'changed'; }else{ echo 'offline_stream';}?>" >
	  <?php

					$swfurl= $SiteURL."live2/live_video.swf?n=".urlencode($n);

					$scale="noborder";

					if(detect_stream($n)==='13' && !empty($profilename))

					{

					?>
	  
	  <!-- <iframe style='max-width:100%;height:92% !important;' hspace="0" vspace="0" frameborder="0" scrolling="no" src="https://mysitti.com/live2/dj_streaming.php?n=<?php echo $n; ?>&host_id=<?php echo $userID; ?>&user_type=user"></iframe> -->
	  <iframe style='width:660px; max-width:100%;height:420px !important;' hspace="0" vspace="0" frameborder="0" scrolling="no" src="<?php echo $SiteURL;?>live2/channelIframe.php?n=<?php echo $n; ?>&host_id=<?php echo $userID; ?>&user_type=club"></iframe>
	  <?php 

					}

					else

					{

	?>
	  <video id="tv_main_channel" style='width:100%;height:92% !important;' controls="true"  loop >
		<?php

							$getDefault = mysql_query("SELECT * FROM battle_playlist WHERE `default_video` = '1'  AND `user_id` = '$hostID'  AND `user_type` = 'club' ");

							$default_vid = mysql_fetch_assoc($getDefault);

							$getDefault1= mysql_query("SELECT * FROM battle_playlist WHERE `user_id` = '$hostID'  AND `user_type` = 'club' ORDER BY `id` DESC LIMIT 1 ");

							$default_vid1 = mysql_fetch_assoc($getDefault1);



							if(mysql_num_rows($getDefault1) > 0)

							{

								if($default_vid['default_video'] == 1)

								{

				?>
		<source id="mp4Source" src="<?php echo $default_vid['video_path']; ?>" type="video/mp4">
		<?php 				}

								else

								{

									

				?>
		<source id="mp4Source" src="<?php echo $default_vid1['video_path']; ?>" type="video/mp4">
		<?php 				}

							}

							else

							{

								$getMainDefault = mysql_query("SELECT * FROM `pages` WHERE `page_id` = '13' ");

								$fetchMainDefault = mysql_fetch_assoc($getMainDefault);

								?>
		<source id="mp4Source" src="<?php echo $fetchMainDefault['default_video']; ?>" type="video/mp4">
		<?php

							}



						?>
		
		<!--<source src="https://mysitti.com/upload/1428887022123de511f82d5bd8176c08e4f361fcb2MySitti_.ogv" type="video/ogg">--> 
		
	  </video>
	  <?php 			}	?>
	</div>
  </div>
  <div class="v2_vid_list">
	<div class="thumb_list_battle newbattle extereme_playlist">
	  <?php

	$get_battle_videos = mysql_query("SELECT * FROM battle_playlist WHERE `user_id` = '$hostID'  AND `user_type` = 'club' ");

	$count_battle_videos = mysql_num_rows($get_battle_videos);

	

	if($count_battle_videos < 1){

		

		//echo "No video found";

		

	}else{

		

		while($b_row = mysql_fetch_assoc($get_battle_videos)){

	

			//$explode_vid = explode("../video/" , $b_row['video_path']); ?>
	  <a id="list_<?php echo $b_row['id']; ?>" class="list_play" href="javascript: void(0);" onclick="change_src('<?php echo $b_row['video_path']; ?>','<?php echo $b_row['id']; ?>')"><?php echo $b_row['video_title']; ?></a>
	  <?php }

	} ?>
	</div>
  </div>
</div>
<script type="text/javascript">

	$(document).ready(function(){

		refreshCaptcha('<?php echo $SiteURL; ?>');

		console.clear();

		getYoutubeLinks();





	});

	function getYoutubeLinks()

	{

		console.clear();

		videos = document.getElementById("tv_main_channel");

		//for (var i = 0, l = videos.length; i < l; i++) 

		//{

			var video = videos;

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

		//}

	}

</script>
<div class="">
