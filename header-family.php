<?php  
  require_once 'Mobile_Detect.php';
  $detect = new Mobile_Detect;
	$currentDatetime = date('Y-m-d H:i:s');

	$currentDate = date('Y-m-d');

	$currentTime = date('H:i:s');

	// $SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
	$SiteURL = 'https://www.mysittivacations.com/';
	
	$CloudURL = "https://www.mysittivacations.com/";

	$ABSPATH =$_SERVER['DOCUMENT_ROOT']."/";
 $mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
	$getEventsCategory = mysql_query("SELECT * FROM `eventcategory` ORDER BY `catname` ASC ");

/* TOP SEARCH CODE */
include('defaultimeZone.php'); ?>

<!-- <link defer rel="stylesheet" href="css/bootstrap.min.css"> -->
<link rel="stylesheet" href="css/new-css/bootstrap.min.css" async>


<link rel="stylesheet" href="css/new-css/owl.carousel.min.css" type="text/css" async>
<link rel="stylesheet" href="css/new-css/owl.theme.default.css" type="text/css" async>
<!--fontawesome CSS-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<!--AOS Animation CSS-->
<link href="css/new-css/aos.css" rel="stylesheet" async>
<!--datepicker CSS-->
<link href="css/new-css/datepicker.min.css" rel="stylesheet"  media="wait" onload="if(media!='all')media='all'">

<link rel="stylesheet" href="css/new-css/mobile-style.css" type="text/css">
<link defer href="/css/customHome.css?ver=3" rel="stylesheet" />
<link rel="stylesheet" href="css/new-css/style.css" type="text/css">

<link rel="stylesheet" href="css/stylehomepopup.css" type="text/css">

<!-- <link  href="<?php echo $SiteURL; ?>css/stylesNew.css" rel="stylesheet"  type="text/css"> -->
<link defer rel="stylesheet" href="css/widgets.css">
<!-- <link  rel="stylesheet" href="css/main.css"> -->
<link defer rel="stylesheet" href="css/jslider.css" type="text/css">
<link defer rel="stylesheet" href="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />
<link defer rel="stylesheet" href="css/owl.carousel.min.css">
<!-- <link defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

<script  src="js/jquery1.9.1.js"></script>
<script  src="js/bootstrap.js"> </script> 
<script  src="js/jquery.min.js"></script>
<script  src="js/bootstrap.min.js"></script>
<script  src="<?php echo $CloudURL; ?>lightbox/js/jquery-1.7.2.min.js"></script>
<script defer src="js/jquery-migrate-1.2.1.min.js"></script>
 <!--<link href="/css/optimize/css/style.css" rel="stylesheet">-->
<script defer src="<?php echo $CloudURL; ?>js/jquery.bxslider.js"></script>
<script defer src='<?php echo $CloudURL; ?>js/jqueryvalidationforsignup.js'></script>
<script defer src="<?php echo $CloudURL;?>js/register.js" type="text/javascript"></script>
<script defer src="<?php echo $CloudURL;?>js/datetimepicker/jquery.datetimepicker.js"></script>
<script defer src="<?php echo $CloudURL;?>js/add.js" type="text/javascript"></script>
<script defer src="<?php echo $CloudURL;?>autocomplete/jquery.ajaxcomplete.js"></script>
<script defer type="text/javascript" src="<?php echo $CloudURL; ?>QapTcha-master/jquery/jquery-ui.js"></script>
<script defer src="<?php echo $CloudURL; ?>lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>
<script defer src="<?php echo $CloudURL; ?>lightbox/js/jquery.smooth-scroll.min.js"></script>
<script defer src="<?php echo $SiteURL; ?>js/custom.js"></script>
<script defer type="text/javascript" src="js/jshashtable-2.1_src.js"></script>
<script defer type="text/javascript" src="js/jquery.numberformatter-1.2.3.js"></script>
<script defer type="text/javascript" src="js/tmpl.js"></script>
<script defer type="text/javascript" src="js/jquery.dependClass-0.1.js"></script>
<script defer type="text/javascript" src="js/draggable-0.1.js"></script>
<script defer type="text/javascript" src="js/jquery.slider.js"></script>
<script defer type="text/javascript" src="js/owl.carousel.js"></script>
<script defer src="<?php echo $CloudURL; ?>js/functions.js"></script><!-- 
<script defer type="text/javascript" src="<?php echo $SiteURL;?>jwplayer-7.2.4/jwplayer.js"></script>
<script defer type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script> -->
<script defer src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>
<script defer type="text/javascript" src="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.pack.js"></script>
<script defer src="http://cdn.date-fns.org/v1.29.0/date_fns.min.js"></script>
  <link rel="stylesheet" href="css/new-css/bootstrap.min.css">
        <link rel="stylesheet" href="css/new-css/owl.carousel.min.css" type="text/css">
        <link rel="stylesheet" href="css/new-css/owl.theme.default.css" type="text/css">
        <!--<link async href="https://mysittivacations.com/css/homePage.css" rel="stylesheet" type="text/css">-->
        <!--fontawesome CSS-->
      
		<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		 <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        
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
jQuery(document).ready(function(){
	 setTimeout(function(){ 
	 	jQuery('#origin span').css('color', 'unset','important'); 
	 }, 2000); 
	 
});
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


?>

<!DOCTYPE HTML>
<html>
<head>
<meta name="google-site-verification" content="g7Wlxf6fv_3B4dAY80nr2UDbfMpWBb14xf9qkKbPLmY" />
<meta name="msvalidate.01" content="21025B23AD71A5AE65A5E9BEE98B829F" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="p:domain_verify" content="e570c841e1299de4037dc9f3f1b0a437"/>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NNL68GG');</script>
<!-- End Google Tag Manager -->
<meta name="ahrefs-site-verification" content="e50429e35aa0fa5ab3732ec89f118ae3efb55fce5d84b9311160c6c7af6b095c">

<!-- ======== Update title in Particular page file ===============  -->
<title><?php echo $titleofpage; ?></title>
<?php
////////////////////////////////////////////////////////////
// for update of meta tag please update meta_tag.php file //
////////////////////////////////////////////////////////////
require 'function.php';
echo meta_tags(basename($_SERVER['PHP_SELF']));
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo $SiteURL;?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo $SiteURL;?>favicon.ico" type="image/x-icon">

<!-- ======== Include Main Stylesheet ===============  -->
<!-- 
<link href="<?php echo $SiteURL; ?>css/v2style.css" rel="stylesheet" type="text/css"> -->
<!-- <link href="<?php echo $SiteURL; ?>css/media.css" rel="stylesheet" type="text/css"> -->
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
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&libraries=places"></script>
<script src="../getCity/geo-contrast.jquery.js" type="text/javascript"></script>
<script src="../datepick/foundation-datepicker.js" type="text/javascript"></script>
<script src="../tabby/tabby.js" type="text/javascript"></script>
<script src="js/jquery-ui.js"></script>
<style>
.pac-container {
    z-index: 9999 !important;
}
.rent-logo > ul {

	float: left;

	margin: 0;

	padding: 0;

	text-align: center;

}

.rent-logo li {

	display: inline-block;

	float: none;

	height: 70px;

	position: relative;

	width: 16%;

}

.rent-logo img {

	display: block;

	padding: 10px;

	position: relative;

	top: 50%;

	transform: translateY(-50%);

	width: 100%;

}

.rent-with {

	color: #000;

	font-size: 40px;

	font-weight: 600;

	margin: 30px auto;

}

.rent-logo {

	margin: 25px auto;

}

.road-trip {

	margin: 0px auto 50px;

}

.widget-form {

	background: white none repeat scroll 0 0 !important;

	position: static !important;

	width: 40% !important;

	box-shadow: 0 2px 4px #ddd;

	border: medium none !important;

}

.widget-form .widget_row {

	box-shadow: none;

	width: 100%;

	margin: 0;

}

.widget-form .widget_row input#geo-demo {

	border: 1px solid #ddd;

	font-size: 15px;

	box-shadow: none;

	width: 100% !important;

}

.widget-form {

	padding: 30px !important;

}

.widget-form .hit_button.check_button {

	float: left;

	margin-top: 20px;

	width: 100%;

}

.widget-form .button.hotel_button {

	border: medium none;

	float: left;

	font-size: 19px;

	font-weight: 500;

	height: 50px;

}

.rent-flifgt-deals .popular__list > li {

	padding: 0 10px;

}

.rent-flifgt-deals .weedle-widget {

	max-width: 80% !important;

	width: 100% !important;

}

.rent-flifgt-deals h2 {
    border-bottom: 2px solid #333;
    clear: both;
    color: #000;
    display: inline-block;
    float: left;
    font-size: 24px;
    font-weight: 600;
    margin: 10px auto 0px;
    text-align: left;
    width: 100%;
    padding: 0 0 10px;
}
.custom_forcast h4 {
    font-weight: 600;
    font-size: 32px !important;
}

.deal_bannerForm.form-class {
	top: 60px !important;
}
.car_rentals_form .deal_bannerForm.form-class {
    top: 20px !important;
}
img.car_rentals_images {
    height: 350px !important;
}
.car_rentals_form .widget-form {
    padding: 0px !important;
}
.car_rentals_form .all_box4 {
    padding: 2px;
}

.car-text {
	color: #000;
	float: right;
	font-size: 55px;
	margin-left: 60px;
	/* line-height: 50px; */
	font-family: 'Arial';
}

.check_in > label {
	font-size: 15px;
}

.widget_row > label {
	font-size: 15px;
}

.v2_content_inner2 .oneArticle.secondAtlcle {
	box-shadow: none !important;
	width: 100% !important;
}

.oneArticle.secondAtlcless {
	box-shadow: none;
}

.ui-timepicker-pm {
	float: left;
	font-size: 13px;
	margin: 4px auto !important;
	width: 100%;
}

.team-search.deals-button1 {
	border: 1px solid #ddd;
	box-shadow: none;
}

.car-text::after {
	background: rgba(0, 0, 0, 0) url("../images/reflect.png") no-repeat scroll 5px center;
	content: "";
	height: 30px;
	left: 0;
	opacity: 0.4;
	padding: 41px;
	position: absolute;
	right: 0;
	top: 30px;
	width: 100%;
	z-index: 987;
}
.audio_tour_modal p.dealscitssy_name {
    margin: 0;
    text-align: center;
}
ul.rating2.tour_ratingd.list-inline.yelp_ajax_rating {
    padding: 21px 0px 0px 0px;
}
.yelp_ajax_resultss a {
    float: left;
}
div#more_audio_tourss .modal-dialog {
    max-width: 700px !important;
}

.car-text {
	position: relative;
}

.car-type-filter li {
	color: #333;
	display: inline-block;
	float: left;
	margin: 6px auto;
	padding-left: 10px;
	width: 100%;
}

.hw-checkbox {
	float: left;
}

.car-type-filter span {
	float: left;
	font-size: 13px;
	margin-left: 7px;
	margin-top: 4px;
}
.specificRooms {
    position: relative !important;
}
.homespecificrooms span {
    font-size: 18px !important;
    color: #000 !important;
    font-weight: 400 !important;
}

.ctype {
	color: #000;
	float: left;
	font-size: 17px;
	font-weight: 600;
	margin: 18px auto 5px;
	padding-left: 10px;
}
.random_list.active {
   border-bottom: #000 2px solid !important;
}
.v2_content_wrapper {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}
.rent-flifgt-deals .popular__list > li {

	padding: 0 10px;

}

.rent-flifgt-deals .weedle-widget {

	max-width: 80% !important;

	width: 100% !important;

}

.rent-flifgt-deals h2 {
    border-bottom: 2px solid #333;
    clear: both;
    color: #000;
    display: inline-block;
    float: left;
    font-size: 24px;
    font-weight: 600;
    margin: 10px auto 0px;
    text-align: left;
    width: 100%;
    padding: 0 0 10px;
}
ul.popular__list.carRentelWidgrt {
    width: 100% !important;
}
ul.popular__list.carRentelWidgrt {
    width: 100% !important;
}


.popular__list > li {

	display: inline-block;

	font-size: 18px;

	margin-bottom: 46px;

	padding: 0 30px;

	width: 32.33%;

}
ul.popular__list.carRentelWidgrt {
    width: 80% !important;
    /*overflow-x: scroll !important;
    overflow-y: hidden !important;*/
    white-space: nowrap !important;
    clear: both;
    text-align: center !important;
    margin: 20px auto 0 !important;
    transform: unset !important;
}
.carRentelWidgrt {
    display: inline-block !important;
}
.rent-flifgt-deals .carRentelWidgrt .weedle-widget {
    max-width: 100% !important;
    width: 100% !important;
}
.random_list.active {
    padding-bottom: 0px;
    margin-top: 7px;
}</style>
<?php if(empty($_SESSION['city_name'])){ ?>
<style>
div#mce-error-response {
    text-align: left;
    width: 100%;
}
div#mce-success-response {
    color: #000;
}
.unsub_contain form {
width: 100%;
display: flex;
align-items: center;
justify-content: center;
flex-wrap: wrap;
border: unset !important;
}
.unsub_contain{
border: unset !important;
}
div#mce-responses {
    width: 100%;
    text-align: center;
}
.unsub_contain form input {
  width: 100%;
    height: 40px;
    padding: 9px;
    margin: 0 0px 0 0px;
    border-radius: 0;
    border: 1px solid;
}
.unsub_contain form .form-group.col-md-12 {
   padding: 0 0px 0 10px;
    max-width: 10%;
}
.unsub_contain form .form-group.col-md-12 btn {
background: #fff !important;
}
.unsub_contain form .form-group.col-md-12 .btn {
  background: #0034fb;
    border: 0;
    color: #fff;
    min-width: 100px;
}
#thingsToDo.v2_content_inner_topslider.spacer1 {
    margin-top: 0px !important;
}

.content-banner #hitAjaxCity.hitbutton {
    top: 15px;
}
.content-banner input {
    height: 45px !important;
}
.restaurantsPage .v2_content_inner_topslider.spacer1 {
    margin-top: 0px !important;
}
#v2_wrapper {
    margin: 200px 0 0px !important;
}
.mysiti-header .navbar {
    min-height: 60px !important;
}
video {
    background: unset !important;
}
.open .pop-btn-sec {
    transform: rotate( 
90deg
 );
    bottom: -35px;
}
body {
    overflow-x: hidden;
}
.slide-sec {
    position: absolute;
    right: 0;
    top: 0;
    
        height: 100%;
}

.pop-btn-sec {
   bottom: 156px;
    top: auto !important;
}
@media (max-width: 1599px){
   .pop-btn-sec {
        bottom: 122px;
    } 
}
@media (max-width: 1199px){
.pop-btn-sec {
    bottom: 122px;
}
}
.general_nav#myHeader #navbarSupportedContent ul li a.brand img {
      max-width: 80px;
    width: 100%;
    margin: 0 15px 0 0;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid;
    background: grey;
}
.general_nav#myHeader {
    z-index: 99;
    bottom:unset;
    top:0px;
   background: #00b8f4;
}
.general_nav#myHeader {
    bottom: unset;
    background: #fff;
    border-bottom: 1px solid #000;
}
.general_nav#myHeader nav.navbar ul.navbar-nav {
    display: flex;
    align-items: center;
}
.general_nav#myHeader #navbarSupportedContent ul li a {
    border: 2px solid #000;
    border-radius: 0px;
    margin: 0px 6px;
    color: #000 !important;
    transition: .3s ease-in-out;
    max-width: 100%;
    width: 125px;
    padding: 12px 10px;
    text-align: center;
    font-size: 15px;
}
.general_nav#myHeader #navbarSupportedContent ul li .brand {
    border: unset !important;
}
.general_nav#myHeader #navbarSupportedContent ul li .brand:hover {
    border: unset !important;
}
.general_nav#myHeader #navbarSupportedContent ul li a:hover {
    border: 2px solid #0355a9 !important;
    border-radius: 0px;
    background: #0355a9;
    color: #fff !important;
}
#myHeader #navbarSupportedContent .brand:hover {
    background: unset !important;
    border: unset !important;
}
.check_class {
    font-size: 14px;
}
.content-banner {
    max-width: 250px;
}
.content-banner .search-btn img {
    width: 20px;
    position: relative;
    top: 5px;
    right: -10px;
}
.loading:not(:required) {
    z-index: 9999;
}
input#target:focus {
    box-shadow: none;
}

@media (max-width: 767px){
.slide-sec {
    position: fixed !important;
}
.pac-container.pac-logo {
    z-index: 999999999 !important;
}
.nav-item .brand {
    display: none;
}
.general_nav#myHeader #navbarSupportedContent ul li a {
    margin: 0px 6px 10px;
    max-width: 100%;
    width: 100%;
    border: 1px solid #000 !important;
}
.general_nav#myHeader nav.navbar ul.navbar-nav {
    align-items: unset;
}
.pop-btn-sec {
    bottom: 100px;
}
.unsub_contain form .form-group.col-md-12 {
padding: 0;
max-width: 30%;
}
.unsub_contain form .form-group.col-md-12 .btn {
padding: 0;
margin: 0;
}
.mysiti-header.mysitti_specific_header .logo-search-sec-general .navbar-brand {
    margin-right: -30px !important;
}

</style>
<?php } ?>
<style>
.pac-item{
    line-height: 50px;
}
.pac-icon {
    margin-top: 15px;
}
a#hidden_id{
	font-weight: 500 !important;
}
#hitAjaxCitys{
	display:none;
}
#hitAjaxCitys {
    color: #000;
    position: absolute;
    width: 5%;
    margin-left: -50px;
    z-index: 99;
    font-size: 20px;
    margin-top: 6px;
    text-decoration: none;
}
#hitAjaxCity.hitbutton {
    font-size: 0px !important;
    right: 10px !important;
    width: 30px!important;
    top: 0px;
}
.pin_geocontrast {
    display: none;
}
#myHeader #navbarSupportedContent ul li a {
    color: #fff !important;
}
#myHeader ul li.active {
    padding-bottom: 0px;
}
#myHeader #navbarSupportedContent ul li.active a {
    border-bottom: unset !important;
}
.banner {
    background: unset !important;
    height: 100vh;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    position:relative
}
.banner {
    height: 80vh !important;
}
#myHeader #navbarSupportedContent ul li a {
    padding: 10px 18px;
}
.content-banner {
    position: relative;
    max-width: 300px;
    margin-left: auto;
    width: 100%;
}
#myHeader {
    z-index: 99;
    bottom:0;
   background: #00b8f4;
}
.logo-sec {
    z-index: 99;
}
.banner video {
    position: absolute;
    width: 100% !important;
    height: 80vh;
    left: 0;
    right: 0;
    top: 0;
    object-fit: fill;
}
.mysiti-header.mysitti_specific_header .logo-search-sec-general .brand img {
    margin: 0 15px 0 0px;
    max-width: 100px;
    width: 100%;
    height: 100px;
    border-radius: 50%;
    object-fit: contain;
    border: 1px solid;
    background: grey;
}
.mysiti-header.mysitti_specific_header .logo-search-sec-general .navbar-brand img {
    margin: 0 15px 0 0px;
    max-width: 80px;
    width: 100%;
    height: 80px;
    border-radius: 50%;
    object-fit: cover !important;
    border: 1px solid;
    background: grey;
}
.mysiti-header.mysitti_specific_header .logo-search-sec-general .navbar-brand {
    display: flex;
    align-items: center;
}
.mysiti-header.mysitti_specific_header .logo-search-sec-general {
    max-width: 1140px;
    margin: 10px auto 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}


.mysiti-header.mysitti_specific_header .logo-search-sec-general .navbar-brand h2 {
    margin: 0;
}
@media (max-width: 767px){
	.form-control:focus {
    box-shadow: unset !important;
}
.logo-sec a img{
    max-width: 55px!important;
    width: 100%;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid;
    background: grey;
    margin: inherit!important;
}
.pac-container.pac-logo {
    z-index: 999999999 !important;
}
.logo-sec a img {
    margin-right: auto !important;
     margin-top:10px !important;
    margin-left: inherit !important;
}

.v2_banner_top  #hitAjaxCitys{
    margin-left: 90px;
    margin-top: -42px;
}
#hitAjaxCity.hitbutton {
    top: -15px !important;
}
#myHeader img {
    width: 30px !important;
    height: 40px !important;
}
.logo-sec {
    width: 80% !important;
    left: 0;
}
#myHeader #navbarSupportedContent ul {
    margin: 0 !important;
    background: #00b8f4 !important;
    padding: 0 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
}
.logo-sec a {
    padding: 0 !important;
}
#myHeader {
    border-bottom: unset !important;
    top: 0;
    position: absolute !important;
    z-index: 1 !important;
    bottom: auto !important;
    background: transparent !important;
}
#myHeader .navbar-light .navbar-toggler {
    border: 0;
    margin-left: inherit;
    padding: 0;
    position: relative;
    color: #000;
    border-color: #000;
    font-size: 32px;
}

}
@media (max-width: 1199px){
#myHeader #navbarSupportedContent {
    background: #00b8f4 !important;
}
#myHeader .navbar-light .navbar-toggler {
    margin-left: auto;
}
}
@media only screen and (max-width: 1199px){
#myHeader .navbar-light .navbar-toggler {
    color: rgba(0,0,0,.5);
    border-color: rgb(0 0 0);
    background: #fff;
}
}
.video_banner{
	position: relative;
}
</style>
<?php if(isset($_SESSION['city_name'])){ ?>
<style>
.mysiti-header {
    border-bottom: 1px solid black !important;
    padding: 0 0 10px !important;
}
.mysiti-header.mysitti_specific_header .logo-search-sec-general {
    max-width: 1200px !important;
    margin-bottom: 5px;
}
.mysiti-header .navbar-nav li a {
    margin: 0 4px !important;
    border: 1px solid #000!important;
    border-radius: 0;
    margin: 0 10px;
    color: #000!important;
    transition: .3s ease-in-out;
    max-width: 100%;
    font-weight: 600;
    width: 126px;
    padding: 8px 3px !important;
    text-align: center;
    display: block;
    font-size: 15px !important;
}
.mysiti-header .container .navbar-brand {
    background: unset;
}
.innerCurrentCity1.custom_main_heading.container {
    top: 10px;
}
.mysiti-header {
    z-index: 9999 !important;
}
.mysiti-header .navbar {
    min-height: 60px;
}
#v2_wrapper {
    margin: 150px 0 0px;
}
.mysiti-header .navbar-nav li a {
    padding: 5px 16px;
    margin: 0 5px;
}
.search-header-bar {
	display: none;
}
.slide-arrow {
    display: none;
}
button:focus {
    outline: 1px dotted;
    outline: 0px auto -webkit-focus-ring-color !important;
}
.modal-backdrop.show {
    opacity: .9 !important;
}
.modal-backdrop {
    background-color: #fff !important;
}
.modal-content {
    border: 0px solid rgba(0,0,0,.2) !important;
}
    
.business-block {
    height: 100%;
}
.business-block a {
    height: 100%;
}  
    
@media (max-width: 767px){
	.mysiti-header .navbar {
	    min-height: 5px;
	}
	.mysiti-header.mysitti_specific_header .logo-search-sec-general .navbar-brand {
    margin-right: -30px !important;
    top: 3px;
    position: relative;
}
	.popular-modal .modal-header i#hitAjaxCityn {
    font-size: 21px !important;
    position: absolute !important;
    left: 6px;
    top: 25px !important;
}
	.mysiti-header.mysitti_specific_header .logo-search-sec-general {
	    justify-content: center;
	    flex-wrap: wrap;
	}
	.mysiti-header.mysitti_specific_header .logo-search-sec-general .navbar-brand img {
	    margin: 0 10px 0 0px;
	    max-width: 50px;
	    height: 50px;
	}
	.mysiti-header.mysitti_specific_header .logo-search-sec-general .navbar-brand h2 {
	    font-size: 24px !important;
	}
	.mysiti-header .navbar-collapse {
	    box-shadow: 0 0px 3px rgb(0 0 0 / 20%);
	    padding: 10px;
	    position: absolute;
	    width: 95%;
	    top: 75px;
	    z-index: 99999999;
	    background: #fff;
	    left: 0;
	    margin: 0 auto;
	    right: 0;
	    max-width: 100%;
	    border: 0;
	    white-space: nowrap;
	    overflow: auto;
	}
	.mysiti-header .navbar-nav li a {
	    font-size: 16px;
	    padding: 5px 10px 0px 0px;
	    display: block;
	    border-bottom: 0px solid #dfdfdf;
	}
	.content-bannersss {
	    margin: 10px 0 0;
	}
	.mysiti-header .navbar-collapse .navbar-nav {
	    flex-direction: row;
	}
	#v2_wrapper {
	    margin: 100px 0 0px !important;
	}
	.content-bannersss img {
	    top: 12px;
	}
	.join-btn-sec-n {
	    display: none !important;
	}
	.content-bannersss {
	    display: none;
	}
	.search-header-bar {
	    display: block;
	    position: absolute;
	    right: 20px;
	    top: 30px;
	}
	.mysiti-header.mysitti_specific_header .search-header-bar a {
	    color: #000;
	    font-size: 24px !important;
	}
	.mysiti-header .navbar {
	    min-height: 10px !important;
	}
	.mysiti-header .navbar-toggler {
	    top: 23px;
    	left: 5px;
	}
	.modal-backdrop.show {
    opacity: .9;
}
.modal-backdrop {
    background-color: #fff;
}
.modal-content {
    padding: 0px 0px;
    border-radius: 30px;
    box-shadow: 0 4px 4px rgb(0 0 0 / 25%);
    border: 0;
}
.popular-modal .modal-header {
    position: relative;
    padding: 10px 0 0px;
    display: flex;
    align-items: center;
}
.popular-modal .modal-header input {
    width: 100%;
    border: 0 !important;
    border-bottom: 2px solid #000 !important;
    height: 50px;
    padding: 0 0 0 35px;
    margin: 0px;
    font-size: 16px;
}
.popular-modal .modal-header i#hitAjaxCity {
    font-size: 21px !important;
    position: absolute !important;
    left: 6px;
    top: 0px !important;
}
.popular-modal .modal-body {
    padding: 10px 0 0;
}
.nearby-sec a i {
    border-radius: 50%;
    border: 2px solid #ccc;
    display: flex;
    align-items: center;
    width: 50px;
    height: 50px;
    justify-content: center;
    font-size: 28px;
    margin: 0 10px 0 0px;
}
.nearby-sec a {
    display: flex;
    align-items: center;
    font-size: 18px;
    padding: 10px 10px 10px;
    border-radius: 0px;
    color: #000;
}
.nearby-sec a:hover {
    text-decoration: none;
    background: #efefefb5;
    border-radius: 0px;
}
.nearby-sec {
    margin: 0px 0 30px;
    border-bottom: 1px solid #ccc;
    padding: 0;
}
.nearby-sec.popular-sec h3 {
    font-size: 12px;
    font-weight: 600;
    margin: 0 10px 10px;
    text-align: left;
}
.nearby-sec.popular-sec a {
    border-bottom: 1px solid #ccc;
    padding: 10px 10px 10px;
}
.nearby-sec.popular-sec a .popular.img-sec img {
    border-radius: 10px;
    width: 50px;
    height: 50px;
    object-fit: cover;
}
.nearby-sec.popular-sec a .popular.img-sec {
    margin: 0 10px 0 0;
}
.nearby-sec.popular-sec a .popular.content-sec p {
    margin: 0;
    font-weight: 600;
    font-size: 16px;
    line-height: 21px;
    text-align: left;
}
.nearby-sec.popular-sec a .popular.content-sec p span {
    display: block;
    font-weight: 400;
    font-size: 14px;
}
.nearby-sec.popular-sec {
    border: 0;
    margin: 0;
    padding: 0;
}
.popular-modal .modal-dialog {
    max-width: 650px;
    top: 60px;
    width: 95%;
    margin: 0 auto;
}
.popular {
    padding: 6px 0 6px !important;
}
.popular-modal .modal-header input:focus {
    outline: none;
}
.slide-sec.general_slider .pop-btn-sec {
    bottom: 70px;
}
.nearby-sec.popular-sec li:last-child a {
    border: 0;
}
.modal {
    z-index: 999999999 !important;
}
.slide-arrow {
    position: fixed;
    right: 0px;
    background: #ffffff;
    width: 30px;
    height: 71px;
    top: 60px;
    text-align: center;
    font-size: 44px;
    color: #000;
    z-index: 99;
    display: block;
}
.mysiti-header.mysitti_specific_header .slide-arrow a {
    color: black;
    position: relative;
    top: 14px;
    font-size: 42px !important;
}
.mysiti-header .navbar-nav li a {
    padding: 8px 5px !important;
    display: block;
    margin: 0px 10px 0px 0 !important;
    max-width: 100% !important;
    border: 1px solid #000 !important;
    border-radius: 0px;
    color: #000 !important;
    transition: .3s ease-in-out;
    width: 120px !important;
    text-align: center;
}
.mysiti-header {
    border-bottom: 1px solid black !important;
}
.mysiti-header.mysitti_specific_header .logo-search-sec-general .navbar-brand img {
    object-fit: cover;
}
}

</style>
<?php } ?>



<style>

.family-ticketMaster .pagination .pagination_btn {
  letter-spacing: .5px;
  padding: 15px 55px;
  border-radius: 100px;
  color: #fff;
  font-size: 16px;
  background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa);
  text-decoration: none;
  display: inline-block;
  margin: 10px;
}
/*div#wrapper_row span:nth-child(2) {
    color: #08a0e6! important;
}*/
div#title_price div#title_price span {
    color: #000! important;
    font-weight: 700;
    margin: 0 0 15px! important;
    font-size: 15px!important;
}
div#wrapper_row span:nth-child(1) {
    color: #8b8b8b! important;
    font-family: poppins,sans-serif! important;
}
.cascoon-root div#title #title span {
    color: #fff;
    font-weight: 500;
    font-size: 40px;
    font-family: ubuntu,sans-serif! important;
}
    
    
.top-header .navbar ul li a.nav-link.contact-button{ padding: 15px 32px;border: none;height: 50px;text-transform: capitalize;font-weight: 400;font-family: poppins,sans-serif;font-size: 14px;}
.search-content.hotels #hitAjaxwithCity{width: 200px!important;padding: 15px;border-radius: 50px;background: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa);line-height: 2.2;top: 0;}
header li.nav-item{margin-left: 0}
#hitAjaxwithCity {right: 0;}
.free-trail-form .form-group input, .free-trail-form .form-group select{ font-size: 16px;margin: 0}    
.search-content ul{padding: 0}
.free-trail-form .form-group input:focus{outline: none}
 a,a:hover{
    text-decoration: none;
    color: initial;
}
.view-tag a {
    border: none;
}
.view-tag a:hover{
   color:#fff;
}    
    
    
.top-header .navbar ul li a.nav-link.contact-button svg {
    display: inline;
    height: 20px;
    position: absolute;
}
.top-header .navbar ul li a.nav-link.contact-button span {
    margin-left: 10px;
} 
.free-trail-form .search-content {
    margin: 20px auto !important;
    max-width: 850px;
}
.topHotel input#hotels-destination-c98aeb1f90b513aff212c115d707c6ac{
    font-size: 16px !important;     
}
    
    
#ProductSlide-audio figure.card-ui {
    background: #fff;
    padding: 5px;
    box-shadow: 0 0 5px #0000002b;
    border-radius: 18px;
}
#ProductSlide-audio figure.card-ui a {
    color: initial;
}   
#ProductSlide-audio figure.card-ui .cui-image-lazy-container img {
    height: 190px;
    border-radius: 15px;
    object-fit: cover;
    margin-bottom: 10px;
    width: 100%;
}
#ProductSlide-audio figure.card-ui  .cui-udc-title {
    font-family: ubuntu,sans-serif;
    font-weight: 500;
    font-size: 24px;
    display: -webkit-box;
    margin: 0 auto;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 34px;
}    
#ProductSlide-audio .cui-urgent.cui-offer,#ProductSlide-audio .cui-price,#ProductSlide-audio .cui-combined-section{
    display: flex;
}
#ProductSlide-audio .cui-price-discount {
    color: #08a0e6;
    margin: 0 5px;
}
#ProductSlide-audio .cui-view-deal {
    display: none;
}   
#ProductSlide-audio .cui-udc-details {
    padding: 0 12px 12px 12px;
    font-size: 14px;
    display: flex;
    flex-direction: column;
    min-height: 157px;
}
#ProductSlide-audio .cui-review-rating {
    display: none;
}  
#ProductSlide-audio .cui-bottom-body {
    display: flex;
    flex-direction: column;
}
#ProductSlide-audio .cui-bottom-body {
    display: flex;
    flex-direction: column;
}
#ProductSlide-audio .cui-single-section:nth-child(1){
     order: 1;       
} 
#ProductSlide-audio .cui-single-section:nth-child(2){
     order: 4;       
} 
#ProductSlide-audio .cui-single-section:nth-child(3){
     order: 3;       
}    
#ProductSlide-audio .cui-bottom-body{
     order: 2;       
} 
#ProductSlide-audio .cui-location:before {
    content: "\f041";
    font-family: 'FontAwesome';
    color: #1ea9e8;
}
#ProductSlide-audio .cui-combined-section {
    order: 2;
    margin-bottom: 8px;
}
#ProductSlide-audio .cui-bottom-body .cui-single-section {
    order: 1;
    margin-bottom: 15px;
    margin-top: 5px;
}
#ProductSlide-audio .cui-udc-subtitle {
    margin: 0 auto;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 40px;
    display: -webkit-box;
}
#ProductSlide-audio .cui-location{
    margin: 0 auto;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 22px;
    display: -webkit-box;
}   
#ProductSlide-audio .cui-verbose-urgency-price,#ProductSlide-audio .cui-quantity-bought{
    display: none;
}
#ProductSlide-audio .owl-stage-outer{
    padding: 0;
}
#ProductSlide-audio button{
    margin: 0 !important;   
}  
#ProductSlide-audio{
   margin-bottom: 30px;
} 

#ProductSlide-audio2 .discount-content h3 {
    font-family: ubuntu,sans-serif;
    font-weight: 500;
    font-size: 24px;
    display: -webkit-box;
    margin: 0 auto;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 34px;
}    
#ProductSlide-audio2 .discount-content {
    padding: 15px 7px;
}  
#ProductSlide-audio2 .discount-content .stars p {
    margin: 0;
}
#ProductSlide-audio2 .discount-content .stars {
    margin-bottom: 0;
}
#ProductSlide-audio2 .discount-block p {
    font-size: 14px;
    line-height: 26px;
    font-family: ubuntu,sans-serif;
    display: -webkit-box;
    margin: 0 auto;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 25px;
} 
#ProductSlide-audio2 .comedy-detail ul, #ProductSlide-audio2 .comedy-detail{
    padding: 0;
}
#ProductSlide-audio2 .comedy-detail li {
    line-height: 26px;
    font-family: ubuntu,sans-serif;
    display: -webkit-box;
    margin: 0 auto;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 25px;
}    
#ProductSlide-audio2 .comedy-detail {
    min-height: 54px;
}
#ProductSlide-audio2 .comedy-detail ul li i {
    top: 0px;
} 
#ProductSlide-audio2 .owl-stage-outer{
    padding-bottom: 0;
}
.sort-display-sec p{
    margin-bottom: 0;   
}   
#accordionFlushExample .accordion-item {
    background: transparent;
}
#ProductSlide-audio2 .discount-block img {
    height: 190px;
    object-fit: cover;
    border-radius: 12px;
} 
#ProductSlide-audio2 .discount-block {
    box-shadow: 0px 0px 10px #0000002b;
    margin: 10px 5px;
}
#ProductSlide-audio2 .discount-block .stars ul {
    padding: 0;
}
#ProductSlide-audio2 .owl-nav,#ProductSlide-audio .owl-nav{
    padding: 5px;
}
.comedy-bottom-sec.oneArticle .discount-action.hotels {
    justify-content: flex-start;
}
    
.ticketMaster_sec .discount-block img {
    height: 190px;
    object-fit: cover;
    border-radius: 12px;
}
.ticketMaster_sec .discount-block .discount-content h3 {
    font-family: ubuntu,sans-serif;
    display: block;
    display: -webkit-box;
    margin: 0 auto;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 66px;
}
.ticketMaster_sec .discount-action.hotels {
    justify-content: flex-start;
}
    
.oneArticle .discount-block .discount-content h3 {
    font-family: ubuntu,sans-serif;
    display: block;
    display: -webkit-box;
    margin: 0 auto;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 66px;
}
    
.hotels_accordian .accordion-body {
    margin: 30px 0 20px;
    background: #ffe6e1;
    padding: 20px !important;
    border-radius: 15px;
    text-align: center;
}
.hotels_accordian .blissey-widget .blissey-widget-tabs ul.blissey-widget-tabs-list {
    margin-top: 0 !important;
}
.hotels_accordian .blissey-widget .blissey-widget-tabs-list__item--checked {
    background: #5955b333 !important;
    padding: 15px 20px 15px 15px !important;
    display: inline-block !important;
    border: 1px solid #5955b3 !important;
    border-radius: 6px;
    color: #000 !important;
    font-weight: 600 !important;
}
.hotels_accordian .blissey-widget .blissey-widget-tabs-list__item--checked {
    background: #276ab5 !important;
    padding: 12px 20px 12px 15px !important;
    border: 1px solid #276ab5;
    border-radius: 5px;
    color: #fff !important;
    font-weight: 600 !important;
}
.filter_head.sort-display-sec .custom-select-box select {
    min-width: 140px;
}
.hotels_accordian .blissey-widget .blissey-widget-tabs {
    background: transparent !important;
}
.hotels_accordian .blissey-widget{
     border: none !important;   
}
.hotels_accordian .blissey-widget .blissey-widget-body-hotels-compact-list__item {
    border-radius: 10px;
}
.hotels_accordian .blissey-widget .blissey-widget-body-hotels-compact-list__item {
    position: relative!important;
    padding: 10px!important;
    min-height: 130px!important;
    border-top: 1px solid #eee!important;
    background: #fff!important;
    margin-bottom: 10px!important;
}
.hotels_accordian .blissey-widget .blissey-widget-footer {
    background-color: #ffe6e1!important;
    border-top: none !important;
}
.hotels_accordian.blissey-widget .blissey-widget-footer {
    background-color: #ffe6e1!important;
    border-top: none !important;
}
.hotels_accordian .blissey-widget .blissey-info-price-wrapper-button a {
    background: #fe6e00 !important;
    color: #fff !important;
    border-radius: 50px !important;
}
.hotels_accordian .heading-content h4 {
    font-weight: 600;
}  
.ticketMaster_sec .pagination .pagination_btn {
    letter-spacing: .5px;
    padding: 15px 55px;
    border-radius: 100px;
    color: #fff;
    font-size: 16px;
    background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa);
    text-decoration: none;
    display: inline-block;
    margin: 10px;
}
.ticketMaster_sec .pagination {
    padding: 0 !important;
    background: transparent;
    justify-content: center;
}   
.blog-resource-section li.discount-block.first img {
    height: 780px;
    object-fit: cover;
} 
.testimonial-section .cities img{
    /* height: 300px;*/
    object-fit: cover;
    border-radius: 10px;
} 
.testimonial-block.product .cities a {
    background: #fff;
    position: absolute;
    bottom: 20px;
    text-align: center;
    margin: 0 auto;
    width: 85%;
    color: #000;
    left: 0;
    right: 0;
    padding: 15px 0;
    border-radius: 40px;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}
 .testimonial-block.product .cities a p {
    margin-bottom: 0;
} 
    
.groupon_discount_sec .card-ui.cui-c-udc {
    padding: 5px;
    box-shadow: 5px 5px 48px #0000002b;
    border-radius: 18px;
    background: #fff;
}
.groupon_discount_sec .cui-image-lazy-container img {
    height: 258px;
    object-fit: cover;
    border-radius: 15px;
}
.groupon_discount_sec .cui-udc-title.one-line-truncate {
    font-weight: 500;
    margin: 0 0 10px;
    font-size: 24px;
    font-family: ubuntu,sans-serif;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 34px;
}
.groupon_discount_sec .cui-udc-details {
    position: relative;
}
.groupon_discount_sec .cui-udc-details {
    position: relative;
    background: #08a0e636;
    border-radius: 15px;
    padding: 15px;
    text-align: left;
    align-items: center;
    justify-content: space-between;
    margin-top: 100px;
    padding-right: 80px;
    min-height: 78px;
}    
.groupon_discount_sec .cui-udc-details .cui-single-section:nth-child(1) {
    background: #fff;
    text-align: left;
    position: absolute;
    top: -83px;
    left: 10px;
}
.groupon_discount_sec .cui-bottom-body .cui-single-section:nth-child(2) {
    position: absolute;
    top: -43px;
    left: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 24px;
}
.groupon_discount_sec  .cui-review-rating,.groupon_discount_sec .cui-bottom-body .cui-single-section:nth-child(3){
    display: none;
}
.groupon_discount_sec .cui-udc-details .cui-single-section:nth-child(3) {
    font-weight: 500;
    font-family: 'Poppins';
}
.groupon_discount_sec  .cui-price {
    display: flex;
}
.groupon_discount_sec .cui-price-discount.c-txt-price {
    white-space: nowrap;
    display: flex;
    margin-left: 5px;
    font-weight: 500;
    font-family: 'Poppins';
}
.groupon_discount_sec .cui-price-descriptor,.groupon_discount_sec .cui-view-deal{
    display: none;
}
.groupon_discount_sec .cui-promotions {
    display: inline-block;
    float: left;
    margin-left: 5px;
}
.groupon_discount_sec .cui-price {
    display: flex;
    width: auto;
    float: left;
}
.groupon_discount_sec .cui-combined-section:after {
    content: "";
    clear: both;
    display: block;
}   
.groupon_discount_sec .cui-price-original:first-letter {
    color: #000;
    font-weight: 500;
    font-family: 'Poppins';
}
.groupon_discount_sec .cui-price-original,.groupon_discount_sec .cui-discount-badge{
    color: #575757;
}
.groupon_discount_sec .cui-udc-details:after {
    content: "";
    width: 50px;
    height: 50px;
    position: absolute;
    top: 50%;
    right: 17px;
    transform: translateY(-50%);
    background-image: url(./images/right-blue.png);
    background-size: 50px;
}
.groupon_discount_sec .all-inclusive:nth-child(4) .cui-udc-details:after {
    background-image: url(./images/right-saff.png);   
}
.groupon_discount_sec .all-inclusive:nth-child(4) .cui-udc-details{
    background: #fe6e003d;    
}
.groupon_discount_sec .all-inclusive:nth-child(6) .cui-udc-details{
   background: #00ae5d36;      
}   
.groupon_discount_sec .all-inclusive:nth-child(6) .cui-udc-details:after {
    background-image:url(./images/right-green.png);   
}
.groupon_discount_sec .cui-location{ 
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 24px;
}
.groupon_discount_sec .view-tag .groupon_discount {
    width: 170px;
}
h1, h2, h3, h4, h5, h6{
      font-family: ubuntu,sans-serif;
    font-weight: 700;
}                   
.testimonial-section .cities img {
    height: 340.92px;
}   
.testimonial-block.product .cities a p {
	margin-bottom: 0;
	font-size: 20px;
    text-transform: lowercase;
}
.testimonial-block.product .cities a p:first-letter {
    text-transform: uppercase;
} 
.view-tag a {
    min-width: 174.73px;
    border: none;
    text-transform: capitalize;
    font-family: poppins,sans-serif;
}

/* where to stay section style */
    
.where_say_sec .blissey-widget .blissey-widget-tabs,.where_say_sec .blissey-widget .blissey-widget-footer{
    display: none
}  
.where_say_sec .blissey-widget {
    border: none !important;
}
.where_say_sec .tp_powered_by {
    display: none !important;
}
.where_say_sec .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item {
    overflow: hidden!important;
    padding: 5px !important;
    box-shadow: 5px 5px 48px #0000002b !important;
    border-radius: 18px;
    background: #fff !important;
}
.where_say_sec .blissey-widget--l .blissey-widget-body-hotels-full-list-item-gallery,.where_say_sec .blissey-widget--l .blissey-gallery{
    min-height: 257px !important;
}                   
.where_say_sec .blissey-widget .blissey-gallery-images>li>span{
   border-radius: 12px !important;
}
.where_say_sec .blissey-widget .blissey-info-details-rating__decimal{
    width: 29px!important;
    height: 29px!important;
    border-radius: 4px!important;
    font-size: 13px!important;
    line-height: 29px!important;
    background-color: #3c75be!important;
}
.where_say_sec .blissey-widget .blissey-info-details-rating{
    margin-right: 0px!important;
}                   
.where_say_sec .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item .blissey-info-details {
    position: relative !important;
    padding: 20px 15px 50px 17px !important
} 
.where_say_sec .blissey-widget .blissey-info-details-specification__hotel_name,.blissey-widget .blissey-info-details-specification__hotel_name:hover{
    position: absolute !important;
    left: 15px;
    bottom: 0;
    color: #000 !important;
    font-size: 24px !important;
    font-family: ubuntu,sans-serif !important;
    font-weight: 500 !important;
}
.where_say_sec .blissey-widget .blissey-info-details-specification__hotel_name:hover {
    color: #000 !important;
}
.where_say_sec .blissey-widget .blissey-info-price-wrapper-button a:hover{
    background: #08a0e6 !important;
}    
 .where_say_sec .blissey-widget .blissey-info-details-specification {
    padding-top: 8px !important;
    font-size: 14px!important;
    font-family: poppins,sans-serif !important;
}  
.where_say_sec .blissey-widget .blissey-info-details-specification__stars {
    height: 17px!important;
    background-size: 14px 15px!important;
} 
.where_say_sec .blissey-widget .blissey-info{
    padding: 0 !important;
}
.where_say_sec .blissey-widget .blissey-info-price-wrapper {
    background: #08a0e638 !important;
    border-top-left-radius: 10px !important;
    border-bottom-left-radius: 10px !important;
    padding: 15px !important;
    font-family: poppins,sans-serif !important;
}
.where_say_sec .blissey-widget .blissey-info-price-wrapper .blissey-info-price-wrapper-box {
    display: flex !important;
    position: relative !important;
    padding-top: 20px !important;
    align-items: center;
}
.where_say_sec .blissey-widget .blissey-info-price-wrapper__text {
    position: absolute !important;
    top: 0px !important;
}                   
.where_say_sec .blissey-widget .blissey-info-price-wrapper-discount {
    display: flex;
    order: 2;
    margin-left: 10px !important;
    align-items: center;
    margin-bottom: 0 !important;
}
.where_say_sec .blissey-widget .blissey-info-price-wrapper__total {
    font-size: 18px !important;
    font-weight: 600 !important;
    color: #000 !important;
    font-family: poppins,sans-serif !important;
}                   
.where_say_sec .blissey-widget .blissey-info-price-wrapper-discount__price {
    font-size: 18px !important;
    font-weight: 600 !important;
    text-decoration: line-through;
    color: red !important;
    letter-spacing: normal !important;
    font-family: poppins,sans-serif !important;
}                    
.where_say_sec .blissey-widget .blissey-info-price-wrapper-discount__percents {
    background: #08a0e6 !important;
    padding: 4px 5px !important;
    display: inline-block;
    border-radius: 5px !important;
    font-size: 10px !important;
    font-weight: 400 !important;
    border: none !important;
    width: 34.75px !important;
    height: 23px;
    line-height: 16px !important;
    text-align: center !important;
}
.where_say_sec .blissey-widget .blissey-info-price-wrapper-button {
    width: 100% !important;
    text-align: right !important;
    background: #c9eafa !important;
    height: 86px !important;
    padding-right: 15px !important;
    border-top-right-radius: 10px !important;
    border-bottom-right-radius: 10px !important;
} 
.where_say_sec .blissey-widget .blissey-info-price-wrapper-button a {
    box-shadow: none;
    background-color: #08a0e6 !important;
    text-decoration: none !important;
    border-radius: 30px !important;
    color: #fff !important;
    display: flex !important;
    align-items: center !important;
    padding-right: 50px !important;
    width: 147.42px;
    text-transform: capitalize !important;
    font-size: 16px !important;
    padding: 0 10px;
    height: 46px !important;
    text-align: center;
    font-weight: 400 !important;
    line-height: 46px !important;
    font-family: poppins,sans-serif !important;
    float: right !important;
    position: relative !important;
}
.where_say_sec .blissey-widget .blissey-info-price-wrapper-button a:before {
    content: "";
    position: absolute !important;
    width: 30px;
    height: 30px;
    background: #fff !important;
    right: 9px;
    border-radius: 50%;
}
.where_say_sec .blissey-widget .blissey-info-price-wrapper-button a:after {
    content: "\f105" !important;
    font-family: 'FontAwesome' !important;
    right: 19px !important;
    position: absolute !important;
    color: #000;
    z-index: 2;
    font-weight: 700 !important;
    top: 14px !important;
}
.where_say_sec .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item:nth-child(2) .blissey-info-price-wrapper,.where_say_sec .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item:nth-child(2) .blissey-info-price-wrapper-button{
    background: #fe6e003d !important;
}
.where_say_sec .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item:nth-child(2) .blissey-info-price-wrapper-button a{
    background-color: #fe6e00 !important;   
} 
.where_say_sec .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item:nth-child(3) .blissey-info-price-wrapper,.where_say_sec .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item:nth-child(3) .blissey-info-price-wrapper-button{
    background: #00ae5d36 !important;
}
.where_say_sec .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item:nth-child(3) .blissey-info-price-wrapper-button a{
    background-color: #00ae5d !important;   
} 
/* end */
    
 /* about section */
.about-mysiti-sec .about-img video {
    box-shadow: 0px 3px 26px #00000029;
    border-radius: 20px;
    height: 507px;
    object-fit: unset;
}
 .about-mysiti-sec:after {
    bottom: 0;
    height: calc(100% - 150px);
}
/* about section end */

.testimonial-block.product .cities .starer{
    height: 50px;
}
.see_beautiful_inner .discount-block img,.see_beautiful .discount-block img {
    height: 257.13px;
    border-radius: 15px;
    object-fit: cover;
}
.see_beautiful_inner .discount-block h3,.blog-resource-section .blog-details h3,.see_beautiful .discount-block h3{
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.free-trail-form.car-rental .search-content{
    background: #fff;      
}   
    
.groupon_discount_sec .cui-quantity-bought {
    display: none;
}
.groupon_discount_sec .cui-verbose-urgency-text,.groupon_discount_sec .cui-verbose-urgency-price{
    display: none;
}
.groupon_discount_sec .cui-location,.groupon_discount_sec .cui-price-discount.cui-verbose-urgency-pricing {
    font-weight: 500;
}

    
.blog-resource-section .blog-block ul {
    padding: 0;
}  
.blog-block ul li:last-child ul li {
    width: calc(50% - 20px);
}
.testimonial-section .owl-nav button span {
    line-height: 42px;
}

.feature-section .business-block p {
    margin-bottom: 0;
}  
    
    
.home_dev_searchform .search-content {
    max-width: 100%;
    padding: 0 !important;
}
.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-city input {
    border-radius: 50px !important;
    height: 70px !important;
    border: 1px solid #cfcfcf !important;
    box-shadow: none !important;
    padding: 15px 40px 2px 15px!important;
}
.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-dates {
    width: 38% !important;
    height: 70px;
}
.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-dates input {
    height: 70px !important;
    border: 1px solid #cfcfcf !important;
    box-shadow: none !important;
}
.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-dates .mewtwo-hotels-dates-checkin input {
    border-top-left-radius: 50px !important;
    border-bottom-left-radius: 50px !important;
    border-right: 0 !important;
}
.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-city>input[type=text]:focus,.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-dates .mewtwo-hotels-dates-checkin input[type=text]:focus{
    border: 1px solid #cfcfcf !important; 
}
.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-dates .mewtwo-hotels-dates-checkout input {
    border-top-right-radius: 50px !important;
    border-bottom-right-radius: 50px !important;
}
.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-dates .mewtwo-hotels-dates-checkout input:focus{
    border: 1px solid #cfcfcf !important;
}
.home_dev_searchform .search-content .mewtwo-hotels-guests.mewtwo-hotels-guests--new {
    width: 20% !important;
    height: 70px !important;
    border-radius: 50px !important;
    border: 1px solid #cfcfcf !important;
    box-shadow: none !important;
}
.home_dev_searchform .search-content span.mewtwo-hotels-guests__text.mewtwo-like_input {
    top: 40%;
}
.home_dev_searchform .search-content .mewtwo-hotels-container form .mewtwo-hotels-submit_button button {
    background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa) !important;
    letter-spacing: .5px !important;
    padding: 10px 25px !important;
    border-radius: 50px !important;
    font-size: 18px !important;
    text-decoration: none;
    height: 70px !important;
    display: block;
    text-align: center;
    text-transform: capitalize !important;
}
.home_dev_searchform .search-content .mewtwo-hotels-submit_button.mewtwo-hotels-submit_button--new {
    width: 19% !important;
}
.home_dev_searchform .search-content section.mewtwo-hotels.mewtwo-hotels--virgin.mewtwo-tabs-container {
    width: 100%;
}    
.home_dev_searchform .search-content .mewtwo-hotels-container form .mewtwo-hotels-submit_button button:before {
    content: none !important;
}
.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-city {
    width: 20%!important;
}

.testimonial-section .owl-carousel .owl-nav button.owl-next, .owl-carousel .owl-nav button.owl-prev {
    border-radius: 50%;
    margin: 0 10px;
}
.sort-display-sec .custom-select-box .fa-bars, .sort-display-sec .custom-select-box .fa-th-large {
    display: none;
}
h1, h2, h3, h4, h5, h6{
   letter-spacing: normal;
}    
.testimonial-section .owl-nav button {
    background: #1671bd00!important;
}
.client-sec.comedy .slide .discount-block .cities img {
    height: 260px;
    object-fit: cover;
    border-radius: 12px;
}    
.client-sec.comedy .slide .discount-block .discount-content h3 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 59px;
    line-height: 35px;
} 
.client-sec.comedy .comedy-add-details p:nth-child(1) {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}   
.client-sec.comedy .slide .discount-block .discount-content span{
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 21px;
    height: 42px;
}
.client-sec.comedy .slide .discount-block .discount-action.hotels{
    justify-content: flex-start;
}
    
.amazing_discounts_sec .discounts_inner figure.card-ui {
    padding: 5px;
    box-shadow: 5px 5px 48px #0000002b;
    border-radius: 18px;
    background: #fff;
    position: relative;
}
.amazing_discounts_sec .cui-image-lazy-container img {
    height: 257.13px;
    border-radius: 12px !important;
    object-fit: cover;
}
.amazing_discounts_sec .discounts_inner figure.card-ui .cui-udc-details {
    padding: 15px;
    text-align: left;
    height: 200px;
    z-index: 1;
}
.amazing_discounts_sec .discounts_inner figure.card-ui .cui-udc-subtitle.one-line-truncate{
    -webkit-line-clamp: 1;     
}
.amazing_discounts_sec .cui-verbose-urgency-text {
    display: none;
}
.amazing_discounts_sec .discounts_inner figure.card-ui .cui-location.cui-truncate.cui-has-distance,.amazing_discounts_sec .discounts_inner figure.card-ui .cui-combined-section{
    padding-left: 0;
}
.amazing_discounts_sec .discounts_inner figure.card-ui .cui-combined-section{
    padding-bottom: 0; 
    position: inherit;
}
.amazing_discounts_sec .discounts_inner figure.card-ui .cui-location.cui-truncate.cui-has-distance:before,.amazing_discounts_sec .discounts_inner figure.card-ui .cui-price-original.c-txt-gray-dk:before{
    content: none;
}
.amazing_discounts_sec .cui-quantity-bought {
    display: none;
}
.amazing_discounts_sec .discounts_inner figure.card-ui .cui-udc-details:after {
    content: "";
    background: #08a0e636;
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 90px;
    z-index: -1;
    left: 0;
    border-radius: 15px;
}
.amazing_discounts_sec .discounts_inner figure.card-ui .cui-combined-section:before{
    width: 50px;
    height: 50px;
    bottom: 20px;
    right: 15px;
    background: #08a0e6;
}
.amazing_discounts_sec .discounts_inner {
    margin-bottom: 50px;
}
.amazing_discounts_sec .discounts_inner .section_1 figure.card-ui .cui-combined-section:before{
    background: #fe6e00;  
}
.amazing_discounts_sec .discounts_inner .section_1 figure.card-ui .cui-udc-details:after{
     background: #fe6e003d;    
}
.amazing_discounts_sec .discounts_inner .section_2 figure.card-ui .cui-combined-section:before{
    background: #00ae5d;  
}
.amazing_discounts_sec .discounts_inner .section_2 figure.card-ui .cui-udc-details:after{
     background: #00ae5d36;    
}
.amazing_discounts_sec .discounts_inner figure.card-ui .cui-verbose-urgency-price,.amazing_discounts_sec .discounts_inner figure.card-ui .cui-price .cui-price-discount{
    color: #000;
}
    
@media screen and (max-width:1399px){
 .testimonial-section .cities img{
    height: 300px;
 } 
.blog-resource-section li.discount-block.first img {
    height: 687px;
}
}
  
@media screen and (max-width: 767px){
  
    
    .mobileView{
			display:block !important;
		}
		.desktopView{
			display:none !important;
		}
     .blog-block li.discount-block.first img {
        height: 350px;
    }
    .blog-block li.discount-block.first {
        width: 100%;
    }
    .blog-section .blog-block ul {
       padding: 0;
        display: block;
    }
    .blog-block li.discount-block.first{
        width: 100% !important;
        display: block;
    }
    .blog-block ul li:last-child{
        display: block;
        width: 100% !important;
    }
    .blog-block ul li:last-child ul li {
        width: 100%;
        margin: 26px 0 20px 0;
    }
    .blissey-widget--m .blissey-widget-body-hotels-compact-list-item-gallery, .blissey-widget--s .blissey-widget-body-hotels-compact-list-item-gallery {
    width: 100%!important;
    }
        .blissey-widget--s .blissey-widget-body-hotels-compact-list-item-info .blissey-info-price {
        margin: 15px 0 10px 0 !important;
    }
    .blissey-widget--s .blissey-widget-body-hotels-compact-list-item-info {
        margin: 0 0 0 0 !important;
    }
    .accordian_info .blissey-widget .blissey-widget-tabs-list__item--buttonchecked {
        background: #276ab5!important;
    }
     .rest-deals .accordian_info .accordion-body {
        padding: 12px;
     }
     .rest-deals .accordian_info .blissey-widget .blissey-info-price-wrapper-button a {
        margin: 0 !important;
    }
.rest-deals .accordian_info .accordion-body {
    margin: 30px 0 20px;
    background: #ffe6e1;
    padding: 20px !important;
    border-radius: 15px;
    text-align: center;
}
.rest-deals .accordian_info .blissey-widget .blissey-info-price-wrapper-button a {
    background: #fe6e00 !important;
    color: #fff !important;
    border-radius: 50px !important;
}
.rest-deals .blissey-widget .blissey-widget-tabs ul.blissey-widget-tabs-list {
    margin-top: 0 !important;
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-tabs-list__item--checked {
    background: #5955b333 !important;
    padding: 15px 20px 15px 15px !important;
    display: inline-block !important;
    border: 1px solid #5955b3 !important;
    border-radius: 6px;
    color: #000 !important;
    font-weight: 600 !important;
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-tabs-list__item--checked {
    background: #276ab5 !important;
    padding: 12px 20px 12px 15px !important;
    border: 1px solid #276ab5;
    border-radius: 5px;
    color: #fff !important;
    font-weight: 600 !important;
}   


     
  /* commom style */    
/*.mobile-hero {display: none}*/
/*.banner-section .container{padding: 15px}*/
.banner-section.hotel-hero .mobile-hero img {height: 200px;}
.banner-section.hotel-hero .carousel-caption-top h1 {margin: 0 0 0px;}
.banner-section.hotel-hero .carousel-caption-top h1{color: #000;font-size: 24px;text-align: center;}
.banner-section .view-all-sec{display: none}
.free-trail-form{display: block}
.search-content{border-radius: 0;background: transparent;padding: 0;margin: 0 !important;box-shadow: none}
.search-content.hotels ul li .form-group{margin:10px; display: block}
.free-trail-form .search-content {
    padding: 0 5px;
    }
.search-content.hotels #hitAjaxwithCity{font-size: 18px;height: 50px;line-height: 1 !important;float: left;transform: translateX(-50%);left: 50%;position: relative;margin-top: 15px;}
.free-trail-form .search-content .form-group input, .free-trail-form .search-content.form-group select{height: 50px}
.free-trail-form .search-content .form-group{margin: 0 auto}
.top-header .navbar .navbar-toggler{background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");background-repeat: no-repeat;background-position: center;background-size: 30px}
.free-trail-form .form-group input, .free-trail-form .form-group select{font-size: 16px;margin: 0}

.blog-resource-section li.discount-block.first img {
    height: 350px !important;
}
    
.about-mysiti-sec .about-img video {
    height: 350px;
}
    
.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-dates {
    width: 100% !important;
    height: 70px;
}
.home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-dates .mewtwo-hotels-dates-checkin input[type=text], .home_dev_searchform .search-content .mewtwo-widget .mewtwo-hotels-dates .mewtwo-hotels-dates-checkout input{
    border-radius: 50px !important;
}
.home_dev_searchform .search-content section.mewtwo-hotels.mewtwo-hotels--virgin.mewtwo-tabs-container {
    padding: 0 !important;
}
.home_dev_searchform .search-content {
    margin: 0 !important;
}
.home_dev_searchform .search-content .mewtwo-hotels-guests.mewtwo-hotels-guests--new {
    width: 100% !important;
}
.home_dev_searchform .search-content .mewtwo-hotels-submit_button.mewtwo-hotels-submit_button--new {
    width: 100% !important;
}
/*.banner-section .carousel-caption-top {
    top: 0;
}*/
.testimonial-section .owl-nav button span {
    color: #000;
}
.home_dev_searchform {
    padding-bottom: 30px;
}
}

    
</style>
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
?>
</head>
<body>
<div class="slider_body">
	<ul>
	<li><img src="images/v2_bgmain.jpg" alt="Affordable flight and hotel packages"></li>
	</ul>
</div>

<input type="hidden" value="<?php echo $SiteURL; ?>" id="siteURL" />
<input type="hidden" value="<?php echo $_SESSION['full_city_name']; ?>" id="fullCityName" />
<?php if(isset($_SESSION['city_name'])){
$firstTool = $_SESSION['city_name'];
$headerClass = "mysitti_specific_header";
}else{
$firstTool = "Home";
$headerClass = "";
}

?>
 <header class="top-header fixed-top">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="https://www.mysittivacations.com/">
                    <img src="img/logo.png" class="logo" alt="image">
                </a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>                
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link contact-button" href="trips.php">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 63.985 20">
								  <g id="Group_674" data-name="Group 674" transform="translate(-1513.015 -55)">
									<path id="download"d="M204.982,158.95a6.523,6.523,0,0,0-4.653,1.96,6.73,6.73,0,0,0-1.921,4.717,7.533,7.533,0,0,0,2.206,5.327l3.85,3.85a.731.731,0,0,0,1.033,0l3.85-3.85a7.533,7.533,0,0,0,2.207-5.327,6.73,6.73,0,0,0-1.921-4.717,6.522,6.522,0,0,0-4.653-1.96Zm-3.611,2.984a5.041,5.041,0,0,1,7.221,0,5.27,5.27,0,0,1,1.5,3.693,6.073,6.073,0,0,1-1.779,4.294l-3.334,3.334-3.334-3.334a6.073,6.073,0,0,1-1.779-4.294,5.269,5.269,0,0,1,1.5-3.693Zm2.15,3.589a1.461,1.461,0,1,1,1.461,1.461A1.461,1.461,0,0,1,203.522,165.523Zm1.461-2.921a2.921,2.921,0,1,0,2.921,2.921A2.922,2.922,0,0,0,204.982,162.6Z" transform="translate(1314.606 -101.789)" fill="#fff" fill-rule="evenodd"/>
								  </g>
								</svg>
                                <span>Trips</span>
							</a>
						</li>
                        <li class="nav-item"><a href="javascript:void(0);" class="nav-link contact-button btn_login contact-landing">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

<div id="v2_wrapper44" class="n-random-sec">
<?php if(empty($_SESSION['city_name'])){
	if($_SERVER['SCRIPT_NAME'] == '/yelp-tour.php'){	
	$topClass = 'top_main_header';
	}elseif($_SERVER['SCRIPT_NAME'] == '/random_deals.php'){
		$topClass = 'top_main_header_deals';
	}else{
		$topClass = '';
	}
}
if($_SERVER['SCRIPT_NAME'] == '/car-rentals.php'){
$topClass = "top_main_bannersss";
}
 ?>
<div class="v2_banner_top <?php echo $topClass; ?>">

<?php if($_SERVER['SCRIPT_NAME'] == '/searchEvents.php'){ ?>
	<div class="newCurrentCity cityevent_page">
		<div class="innerCurrentCity1">
			<h4>Find great deals </h4>
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

<?php }  elseif ($_SERVER['SCRIPT_NAME'] == '/yelp-tour.php') { 
if(isset($_SESSION['city_name'])){
?>
	<div class="newCurrentCity citytalk_page">
	<?php if(isset($_SESSION['city_name'])){
		$banner = "custom_main_heading container";
	}else{
		$banner = "container";
	} ?>
		<div class="innerCurrentCity1 <?php echo $banner; ?>">
		
		

			<div class="clear"></div>
			<!-- <div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

 				<input id="target" data-cancel="" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>
 				<span id="hitAjaxCitys" class="search-btn" href="javascript:void(0);">x</span>
 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div> -->
		</div>
	</div>


<?php } }  elseif ($_SERVER['SCRIPT_NAME'] == '/allSports.php') { ?>
		<!-- <div class="newCurrentCity citytalk_page container inner_specific_page spotrs_inner_page">
			<div class="innerCurrentCity1">
			<h4>Sports Zone</h4>
				<div class="clear"></div>
				<div class="search_filtering">

				   <input id="geo-demo" type="text" class="geo" placeholder="Enter a destination" value="<?php echo $_SESSION['city_name']; ?>" data-find-address="<?php echo $_SESSION['city_name']; ?>" required>

					<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
				</div>
			</div>
		</div> -->

	

	<?php }  elseif ($_SERVER['SCRIPT_NAME'] == '/restaurant-deals.php') { 
if(isset($_SESSION['city_name'])){
		?>
	<div class="newCurrentCity citytalk_page">
	<?php if(isset($_SESSION['city_name'])){
		$banner = "custom_main_heading container";
	}else{
		$banner = "random_genrel_pagess container";
	} ?>
		<div class="innerCurrentCity1 <?php echo $banner ?>">
				
						
					<?php

					echo '<h4> '.$_SESSION['city_name'].' Restaurants</h4>';

								?>
	
			<div class="clear"></div>
			<!-- <div class="search_filtering">

			   <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="<?php echo $dropdown_city; ?>" data-find-address="<?php echo $dropdown_city; ?>" required>

 				<input id="target" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>
<span id="hitAjaxCitys" class="search-btn" href="javascript:void(0);">x</span>
 				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>
		</div> -->
	</div>	

<?php } }elseif ($_SERVER['SCRIPT_NAME'] == '/car-rentals.php') { ?>
	<!-- <div class="container car_rentals_form">
	 <div class="deal_bannerForm form-class">
			<form id="hotel_api_filter" method="post" class="widget-form">
				<div class="all_box4">
					<div class="widget_row">
						<label>Pick-up location:</label>
						<input id="geo-demo" type="text" class="geo" placeholder="Enter a location" value="<?php echo $_SESSION['city_name'];?>" data-find-address="<?php echo $dropdown_city;?>">

					</div>
					<div class="checkin_class check_in">
						<label>Pick-up date:</label>
						<input type="text" id="dpd1" name="checkin" value="<?php echo date('m/d/Y') ?>" class="check_class" placeholder="mm/dd/yyyy">
						<input type="text" id="basicExample" name="picktime" value="9:00am" class="check_class" placeholder="hh:mm">

					</div>
					<div class="checkin_class new_classs check_out">
						<label>Drop-off date:</label>
						<input type="text" id="dpd2" name="checkout" value="<?php echo date('m/d/Y') ?>" class="check_class" placeholder="mm/dd/yyyy">

						<input type="text" id="basicExample2" name="picktime" value="9:00pm" class="check_class" placeholder="hh:mm">
					</div>

					<div class="hit_button check_button">
						<input type="button" id="hitAjax_carentals" class="button hotel_button" value="Find a car">
					</div>
				</div>
			</form>
			<div class="car-text">Road Trip</div>
		</div>
	</div> -->	
		<style type="text/css">
			.v2_header_wrapper.deals_wrapper.car_rentals_banner_images {
			display: none !important;
		}
		.road-trip {
			 margin: 0px auto 0 !important; 
			/*padding: 20px 10px 0 0;*/
		}
		</style>
		<?php 
		if(isset($_SESSION['city_name'])){
			$search = $_SESSION['city_name'];
		}else{
			$search = 'chicago';
		}
		if($search == 'Washington D.C.'){
			$search = 'washington';
		}
	 	$search_ci = str_replace(" ","-",$search);
	 $guide_city = "SELECT * FROM  discover_cars WHERE location LIKE '%".$search_ci."%' LIMIT 2";
		$guide_city_result = $mysqli->query($guide_city);
		foreach ($guide_city_result as $key => $value) {
			$search_city = $value['location'];
		}
		 $count = $guide_city_result->num_rows;
      if($count == 0){
		$search_city = 'chicago';
      }
		 ?>
<script src="https://c117.travelpayouts.com/content?promo_id=3873&shmarker=iddqd&location=<?php echo $search_city; ?>&locale=en&bg_color=transparent&font_color=333333&button_color=0355a9&button_font_color=ffffff&button_text=Search&powered_by=true" charset="utf-8" async="true"></script>

	<?php } ?>

<script type="text/javascript">
    tabby.init();    
</script>
<?php if(isset($_SESSION['city_name'])){
	if ($_SERVER['SCRIPT_NAME'] == '/yelp-tour.php' || $_SERVER['SCRIPT_NAME'] == '/restaurant-deals.php' || $_SERVER['SCRIPT_NAME'] == '/city-guide.php' || $_SERVER['SCRIPT_NAME'] == '/random_deals.php' || $_SERVER['SCRIPT_NAME'] == '/brewery.php' || $_SERVER['SCRIPT_NAME'] == '/performing-arts.php' || $_SERVER['SCRIPT_NAME'] == '/concert.php' || $_SERVER['SCRIPT_NAME'] == '/genre-country.php' || $_SERVER['SCRIPT_NAME'] == '/genre-jazz.php' || $_SERVER['SCRIPT_NAME'] == '/genre-rock.php' || $_SERVER['SCRIPT_NAME'] == '/genre-blues.php') {
	$class = "specific_custom_page";
	}else{
		$class ="";
	}
}else{
	$class = "general_custom_page";
}

if($_SERVER['SCRIPT_NAME'] == '/car-rentals.php'){
	$class = "car_rentals_banner_images";
	}
 ?>


<div class="clear"></div>
    			<div id="v2_sign_up_after" class="v2_sign_up open" style="display: none;">
				<h1>Sign Up Here</h1>
				<a class="v2_close_signup" href="javascript:void(0);">close</a>
				<div class="clear"></div>
				<div class="v2_signup_tabcontainer"> 
					<!-- Tab panes -->
					<div class="v2_tab_content">
					<div id="user">
					 <form  method="post" class="tab_standerd v2_user_reg" id="signupd" name="signupd" autocomplete="off" novalidate> 
				 <p>
					<input type="text" autocomplete="off" class="joinEmail" required placeholder="Email Address" name="email">
						 </p>
						
						<div class="clear"></div>
						<p>
							<input type="password" class="joinPwd" required placeholder="Password" id="password" name="password" autocomplete="off">
						</p>
						<p>
						<input type="password" class="joinCPwd" required placeholder="Confirm Password" name="cpassword" autocomplete="off">
						</p>
						 <?php $codee = rand(1000,9999); ?>
						 <div class="captcha_section">
            	<input type="text" id='CheckCaptcha' class="joinCaptcha" name='captcha' placeholder="Enter Captcha" required style="padding: 7px;">
           	<input type="text" value="<?php echo $codee; ?>" id="captchaa" readonly="" style="background:#0361ac;color:white;font-size: 15px;text-align: center;width: 17%; font-weight: 600; padding: 6px;">
					<input type="hidden" value="<?php echo $codee; ?>" class="captchahidd" name="">
           </div>
        
             <p class="jobforError" style="display:none; color:red">Please verify that you are not a robot</p>
						<div class="clear"></div>
												  	
						<div class="clear"></div>
						
							<div class="agreementTerms aboutYou">
							<div class="span">
								<input type="checkbox" value="1" id="acknowledgement" name="acknowledgement">
								<p class="term_policy">By clicking Sign Up, you agree to our <a onclick="javascript:window.open('terms_conditions.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Terms & Conditions</a> and <a onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Privacy Policy</a>. You may receive email notification from MySittiVacations.com, but you can choose to opt out at any time.</p> 
							</div>
							</div>
						<div class="clear"></div>
						<input type="hidden" name="plantype" value="free">
						<input type="hidden" id="planid" name="planid" value="1">
						<input type="hidden" id="userTYPE" name="UserType" value="">
						<input type="submit" value="Sign Up" class="joinButton" name="submit">
				</form> 
				</div>
			</div>
			</div>
	</div>

<?php 

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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content city-search-pop">
      <div class="modal-header">
		<div class="pop-input">
        <i id="hitAjaxCity" class="fa fa-search" aria-hidden="true"></i>
        <input id="target"  type="name" value="" name="" class="geo geocontrast form-control" placeholder="Where to?" required="" aria-required="true">
		</div>				
      </div>
	  
      <div class="modal-body">
            <h3>POPULAR DESTINATIONS</h3>
            <ul>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="New York">
                        <div class="img-sec-pop">
                            <img src="images/city_images/newyork.jpg">
                        </div>
                        <div class="content-pop">
                            <h5>New York</h5><p>New York, United States</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Miami Beach">
                        <div class="img-sec-pop">
                            <img src="images/city_images/Miami_Beach.jpg">
                        </div>
                        <div class="content-pop">
                            <h5>Miami Beach</h5><p>Florida, United States</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Chicago">
                        <div class="img-sec-pop">
                            <img src="images/city_images/chicaaago.jpg">
                        </div>
                        <div class="content-pop">
                            <h5>Chicago</h5><p>Chicago, United States</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Austin">
                        <div class="img-sec-pop">
                            <img src="images/city_images/Austin1.jpg">
                        </div>
                        <div class="content-pop">
                            <h5>Austin </h5><p>Texas, United States</p>
                        </div>
                    </a>
                </li>
            </ul>
      </div>
    </div>
  </div>
</div>


<div class="modal fade popular-modal" id="exampleModals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <i id="hitAjaxCityn" class="fa fa-search" aria-hidden="true"></i>
        <input id="targets"  type="name" value="" name="" class="geo geocontrast form-control" placeholder="Where to?" required="" aria-required="true">
      </div>
      <div class="modal-body">
        <div class="nearby-sec popular-sec">
            <h3>POPULAR DESTINATIONS</h3>
            <ul>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="New York">
                        <div class="popular img-sec">
                            <img src="images/city_images/newyork.jpg">
                        </div>
                        <div class="popular content-sec">
                            <p>New York<span>New York, United States</span></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Miami Beach">
                        <div class="popular img-sec">
                            <img src="images/city_images/Miami_Beach.jpg">
                        </div>
                        <div class="popular content-sec">
                            <p>Miami Beach <span>Florida, United States</span></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Chicago">
                        <div class="popular img-sec">
                            <img src="images/city_images/chicaaago.jpg">
                        </div>
                        <div class="popular content-sec">
                            <p>Chicago <span>Chicago, United States</span></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Austin">
                        <div class="popular img-sec">
                            <img src="images/city_images/Austin1.jpg">
                        </div>
                        <div class="popular content-sec">
                            <p>Austin <span>Texas, United States</span></p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <script type="text/javascript">
$(document).ready(function(){
  $('#basicExample').timepicker();
  $('#basicExample2').timepicker();
});
</script> -->
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
<div class='modal fade my_modal' id='national_parks'  tabindex="-1" data-focus-on="input:first"  role='dialog'>
    <div class='modal-dialog modal-lg modal-dialog-scrollable'>
        <div class='modal-content guide_modal'>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle" style="font-size: 28px;">National Parks</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" style="font-size: 36px;padding: 16px;">&times;</span>
          </button>
      </div>
      <div class="audio_tour_modalss national_parsd modal-body">

      </div>
      <div class='modal-footer'>
          <button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
  </div>
</div>
</div>
<div class='modal fade my_modal' id='groupon_discounts'  tabindex="-1" data-focus-on="input:first"  role='dialog'>
    <div class='modal-dialog modal-lg modal-dialog-scrollable'>
        <div class='modal-content guide_modal'>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle" style="font-size: 28px;">National Parks</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" style="font-size: 36px;padding: 16px;">&times;</span>
          </button>
      </div>
      <div class="audio_tour_modalss national_parsd modal-body">

      </div>
      <div class='modal-footer'>
          <button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
  </div>
</div>
</div>
<div class='modal fade my_modal' id='groupon_discount'  tabindex="-1" data-focus-on="input:first"  role='dialog'>
    <div class='modal-dialog modal-xl modal-dialog-scrollable'>
        <div class='modal-content guide_modal'>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle" style="font-size: 28px;">Groupon Discount</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" style="font-size: 36px;padding: 16px;">&times;</span>
          </button>
      </div>
      <div class="audio_tour_modalss groupon_discount_parsd modal-body">

      </div>
      <div class='modal-footer'>
          <button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
  </div>
</div>
</div>
<style>
	.travels .grid img {object-fit: cover;}
	.gateways .item img {object-fit: cover;}
	.see_beautiful .grid img {object-fit: cover;height: 228px;}
	.resturantclient .grid img, .foodtype .grid img {object-fit: cover;}
	#cool_flight .item img, .resturantclient .item img, .foodtype .item img {object-fit: cover;}
	/*.image_htfix_mid img {height: 100%;}*/
	#cool_flight .item_content, .resturantclient .item_content, .foodtype .item_content {padding: 15px 15px;}
@media screen and (max-width:767px){
	#show_hhottel .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item {
    margin: 0 !important;}
    #cool_flight .owl-dots, .resturantclient .owl-dots, .foodtype .owl-dots {margin: 10px 0 0!important;}
    .travels .grid img {border-radius: 10px;object-fit: cover;width: 100% !important;height: 200px !important;}
    .image_sq_htfix {height: 200px;}
    .slider_nav .owl-nav.disabled {display: flex;margin: 0;}
    .heading {margin-bottom: 30px!important;}
    .owl-carousel .owl-item img {object-fit: cover;}
    .image_htfix_mid {height: 200px!important;}
    section.inner_page_hero.sec_pad.city_bg p {margin-bottom: 0px;}
.hero_section_content h2 { font-size: 24px !important; margin: 0 0 0 !important;}
section.inner_page_hero.sec_pad {min-height: 15rem; display: flex;align-items: center;}
.v2_banner_top .v2_header_wrapper { height: auto;}
.content-bannersss { width: 100%;display:block;}
#hitAjaxwithCity { right: 3px;top: 13px;width: 42px!important; background: #276ab5; padding: 13px;border-radius: 4px 4px;}
.general_nav#myHeader .check_class, 
section.category li {width: 47%;margin: 0 8px 0 0;}
  section.category li a {font-size: 14px;}
  section.category h4 {margin-bottom: 30px;}
  section.category {margin: 40px 0 40px;}
  .category li:nth-child(2), .category li:nth-child(4), .category li:nth-child(6), .category li:nth-child(8) {margin: 0 0px 0 0 !important;}
  .heading p { padding-left: 0;}
  .slider_nav .owl-nav { display: none;}
  .heading h4 {font-size: 24px;}
 /* .image_htfix_mid img {height: 100%;}*/
  #cool_flight .item_content, .resturantclient .item_content, .foodtype .item_content {padding: 15px 15px;}
  .new-for .review-sec .rating {display: flex;align-items: center;margin: 10px 0 0;width: 100%;justify-content: center;}
  .new-for .review-sec ul {display: flex;margin: 0;padding: 0;}
  .new-for .review-sec {align-items: start;display: flex; justify-content: space-between;margin: 10px 0 0;flex-wrap: wrap;}
  .new-for .dis-content ul {padding: 0;}
  .new-for .dicount-offer-sec img {margin: 0 0 0px;}
  .new-for .review-sec a {width: 100%;}
  .flips-content { color: #fff;height: auto;}
  div#con-left ul {padding: 0;}
  .where_say_sec .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item {margin: 0 0 20px !important;}
  .where_say_sec .blissey-widget .blissey-info-price-wrapper-button {height: auto !important;padding-right: 5px !important;}
  .where_say_sec .blissey-widget .blissey-info-details-specification__hotel_name, .blissey-widget .blissey-info-details-specification__hotel_name:hover {left: 0px;}
  .where_say_sec .blissey-widget .blissey-widget-body-hotels-full-list .blissey-widget-body-hotels-full-list-item .blissey-info-details {padding: 20px 15px 50px 0px !important;}
  .where_say_sec .blissey-widget .blissey-info-price-wrapper-button {padding: 10px 10px 10px !important;}
  .where_say_sec .blissey-widget .blissey-info-price-wrapper {padding: 0px 10px !important;}
  .free-trail-form .search-content .form-group input, .free-trail-form .search-content.form-group select {border: 1px solid #ccc !important;}
  button.navbar-toggler {
    background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: center;
    background-size: 30px;
}

}


.free-trail-form .form-group{
	margin: 10px auto;
}
.search-content {
    padding: 0 10px;
}
.business-block.grey-bg a {
    background: #00b0f540;
}
</style>