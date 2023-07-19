<?php 
$currentDatetime = date('Y-m-d H:i:s');

$currentDate = date('Y-m-d');

$currentTime = date('H:i:s');

$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";

$ABSPATH =$_SERVER['DOCUMENT_ROOT']."/";

$getEventsCategory = mysql_query("SELECT * FROM `eventcategory` ORDER BY `catname` ASC ");

include('defaultimeZone.php');
if($_SESSION['user_type'] == 'club'){
	$host_query = mysql_query("SELECT * FROM clubs WHERE id = '".$_SESSION['user_id']."'");
	$loggedin_host_data = mysql_fetch_assoc($host_query);
	$userID = $_SESSION['user_id'];
	$displayImage = $loggedin_host_data['image_nm'];
}

if($_SESSION['user_type'] == 'user'){
	$user_query = mysql_query("SELECT * FROM user WHERE id = '".$_SESSION['user_id']."'");
	$loggedin_user_data = mysql_fetch_assoc($user_query);
}

if(isset($_GET['host_id'])){
	$get_host_query = mysql_query("SELECT * FROM clubs WHERE id = '".$_GET['host_id']."'");
	$get_host_data = mysql_fetch_assoc($get_host_query);
	$userID = $_GET['host_id'];
	$displayImage = $get_host_data['image_nm'];
}

if(empty($_SESSION['id']) || !isset($_SESSION['id']) || $_SESSION['id'] == "") {
	$id=54;
	$_SESSION['id']=$id;
	$_SESSION['state']='3668';
	$_SESSION['country']='223';
}


if(isset($_POST['submitCats'])) {
	$implode = implode(",", $_POST['type_of_artist']);
	$UpdateQuery = mysql_query("UPDATE `clubs` SET `type_details_of_club` = '$implode', `type_of_club` = '108' WHERE `id` = '$_SESSION[user_id]' ");
}


$sql = "select * from `clubs` where `id` = '".$userID."'";

$userArray = $Obj->select($sql) ; 

$profilename=$userArray[0]['club_name'];

$plantype = $userArray[0]['plantype'];

$typeclub = $userArray[0]['type_of_club'];

$type_details_of_club = $userArray[0]['type_details_of_club'];

$email=$userArray[0]['club_email'];

$club_address=$userArray[0]['club_address'];

$phone=$userArray[0]['club_contact_no']; 

$country=$userArray[0]['club_country'];

$state=$userArray[0]['club_state'];

$club_city=$userArray[0]['club_city'];

$web_url=$userArray[0]['web_url'];

$zipcode=$userArray[0]['zip_code'];

$google_map_url=$userArray[0]['google_map_url'];	

$image_nm  =$userArray[0]['image_nm'];

$facebookLink = $userArray[0]['facebookLink'];

$instaLink = $userArray[0]['instaLink'];

$twitterLink = $userArray[0]['twitterLink'];

$profileviewers = $userArray[0]['profile_count'];

//$_SESSION['username']=$profilename;

//$_SESSION['id']=$club_city;

//$_SESSION['state']=$state;

//$_SESSION['country']=$country;

$displayName = $profilename;

if(isset($_SESSION['subuser'])) {

	$q1 = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$userArray[0]['club_name']."'  ");

	$f1 = @mysql_fetch_array($q1);
	//$_SESSION['img'] =  $f1['user_thumb'] ;
} else {
	//$_SESSION['img'] =  $image_nm ;
}

$enablediablephone=$userArray[0]['text_status'];

$profileCounter=$userArray[0]['profile_count'];  

$streamCode = $userArray[0]['newStreamUrl'];

$pieces = explode(" ", $profilename);

$username_dash_separated = implode("-", $pieces);

$n = clean($username_dash_separated);

/* TOP SEARCH CODE */

if(isset($_POST['search'])) {

	if(isset($_POST['city_name']) || isset($_POST['city_name_jquery']))	{

		if(!empty($_POST['city_name_jquery'])) {

			$jquery_city = @mysql_query("SELECT city_id FROM capital_city WHERE state_id = '".$_POST['state']."' AND city_name = '".$_POST['city_name_jquery']."'");

			$jquery_city_rows = mysql_num_rows($jquery_city);

			if($jquery_city_rows == 1){
				$get_jquery_city_id = mysql_fetch_assoc($jquery_city);

				$city = $get_jquery_city_id['city_id'];
			} else { 
		?>

	<script type="text/javascript">

		alert("city does not exist");

		window.location.href="";
	</script>

	<?php die; 
			}
		} else {

			$city = $_POST['city_name'];

		}

		$user_type = $_SESSION['user_type'];

		$user_id = $_SESSION['user_id'];

		$d_city_status = $_POST['default_city'];

		$country = $_POST['country'];

		$state = $_POST['state'];

		if($d_city_status == 'on')	{

			$check_d_city_status = @mysql_query("SELECT * FROM default_city_selected WHERE user_id = '".$user_id."' AND user_type = '".$user_type."'");

			$check_d_city_rows = mysql_num_rows($check_d_city_status);


			if($check_d_city_rows < 1){

				$insert_d_city = @mysql_query("INSERT INTO default_city_selected (`user_id`, `user_type`, `country`, `state`, `city`, `d_city_status`) VALUES ('".$user_id."', '".$user_type."', '".$country."', '".$state."', '".$city."', '".$d_city_status."')");

			}else{

				$update_d_city = @mysql_query("UPDATE default_city_selected SET `country` = '".$country."', `state` = '".$state."', `city` = '".$city."', `d_city_status` = '".$d_city_status."' WHERE user_id = '".$user_id."' AND user_type = '".$user_type."' ");

			}

		}


		if(trim($_POST['zipcode'])!="")	{

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


			foreach($response_a->results[0]->address_components as $abc) {

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

		else {

			$num_rw=1;

			if(!empty($_POST['city_name_jquery'])) {


				$jquery_city = @mysql_query("SELECT city_id FROM capital_city WHERE state_id = '".$_POST['state']."' AND city_name = '".$_POST['city_name_jquery']."'");

				

				$jquery_city_rows = mysql_num_rows($jquery_city);

				

				if($jquery_city_rows == 1)	{

					$get_jquery_city_id = mysql_fetch_assoc($jquery_city);

					$_SESSION['id'] = $get_jquery_city_id['city_id'];

					$_SESSION['country']=$_POST['country'];

					$_SESSION['state']=$_POST['state'];

				}

				else {

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
?>
<script>

function ValidateVideoUploadnew(){

	var check_image_ext = $('#computer_file').val().split('.').pop().toLowerCase();

	

	if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {

		alert('Post Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');

		$('#computer_file').val('');

	}

}


function validate_video()

{

	

  if(document.getElementById('computer_file').value== "")

  {

		if(document.getElementById('video_file').value=="" )

		 {

			alert( "Please provide video!" );

			document.getElementById('video_file').focus() ;

			return false;   

		}

	}
}

function remove_lower_file(){

	

		jQuery("#computer_file").val("");

	

	}

	

function remove_upper_file(){

	

		jQuery("#video_file").val("");

	

	} 
</script>
<?php
if(isset($_POST['submit']))

{   

	$imageTitle = mysql_real_escape_string($_POST['video_title']);

	if($_POST['video_file']!="") 

	{
			$getmax = mysql_query("SELECT MAX(track_no) FROM uploaed_video");
			$getmaxvalue = mysql_fetch_assoc($getmax);
			$plusone = $getmaxvalue['MAX(track_no)'] + 1;

		$video_nm= $_POST['video_file'];

		$ValueArray = array($imageTitle,$userID,$_SESSION['user_type'],$video_nm,'youtube',$plusone);

		$FieldArray = array('video_title','user_id','user_type','video_nm','video_type','track_no');

		$ThisPageTable="uploaed_video"; 

		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);  

	}
	

	 

	  if($_FILES["file"]["name"]!="")

	  {

			  if ($_FILES["file"]["error"] > 0)

			 {

					  echo "Return Code: " . $_FILES["file"]["error"] . "<br>"; Exit;

			 }/*else if($_FILES["file"]["size"] > 26214400)

			 {

				$_SESSION['error_msg']="Please Upload Less than 25 MB";

				 $Obj->Redirect("upload_video.php"); exit;

			 }*/

			else

			{

				 $u_video=$_FILES["file"]["name"]; 

				$tmp = $_FILES["file"]["tmp_name"]; 

				$v_name = "user-video/".time().strtotime(date("Y-m-d")).$u_video; 

				  move_uploaded_file($tmp,$v_name);

				  
				  $getmax = mysql_query("SELECT MAX(track_no) FROM uploaed_video");
					$getmaxvalue = mysql_fetch_assoc($getmax);
					$plusone = $getmaxvalue['MAX(track_no)'] + 1;
					
				

				$ValueArray = array($imageTitle,$userID,$_SESSION['user_type'],$v_name,'computer','public',$plusone);

				$FieldArray = array('video_title','user_id','user_type','video_nm','video_type','uploaded_video_type','track_no');

				$ThisPageTable="uploaed_video"; 

				$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);  

				

			}

	 }

		if($Success)

		 {

			  if(isset($_SESSION['user_club']) && $_SESSION['user_club']=='Club')

			 {

					$Obj->Redirect("upload_video.php?msg=uploaded");

				die;

			 }else

			 {

				$Obj->Redirect("upload_video.php?msg=uploaded");

				die;

			 }

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
<title>Mysitti.com ||<?php echo $titleofpage; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="<?php echo $ShareTitle; ?>" />
<meta property="og:image" content="<?php echo  $SiteURL.str_replace("../", "", $image_nm); ?>" />
<meta property="og:description" content="<?php echo  $ShareFacebookURl; ?>" />
<meta property="og:url" content="<?php echo  $ShareFacebookURl; ?>" />
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<link rel="shortcut icon" href="<?php echo $SiteURL;?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo $SiteURL;?>favicon.ico" type="image/x-icon">

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


<link rel="stylesheet" href="<?php echo  $SiteURL;?>css/mediaelementplayer.min.css" />

<script type="text/javascript">

$(document).ready(function(){

	$(".filter123").smk_Accordion({

		closeAble: true, //boolean

	

	});

	$(".fancybox").fancybox();

});

  </script>

<!-- ======== Include Main Other Javascripts ===============  -->

<style>

.load_more_ex {

	background: transparent none repeat scroll 0 0;

	float: left;

	margin-bottom: 0;

	padding: 0;

	width: 100%;

}

.jwplayer.jw-state-idle .jw-controlbar {display: table;} 

.load_more_ex input[type="button"] {

	background: #fecd07 none repeat scroll 0 0;

	border: 1px solid #fecd07;

	color: #000;

	cursor: pointer;

	display: table;

	font-size: 15px;

	line-height: normal;

	margin: auto;

	padding: 6px 0;

	position: relative;

	text-align: center;

	text-transform: uppercase;

	width: 92%;

	z-index: 9;

}

.sxtreme_play_vid video {
	height: 98%;
	margin: 5px 0;
	width: 100%;
}

.sxtreme_play_vid .mejs-inner iframe
{
	margin: 0px !important;
}


</style>
</head>


<body>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-45982925-1', 'auto');
ga('send', 'pageview');

</script>
<?php
$MyArray = array('108','97','101','96');
	if(in_array($typeclub,$MyArray ) && (empty($type_details_of_club) || $type_details_of_club == " ") && !isset($_GET['host_id']) && $_SESSION['user_type'] == 'club')
	{
?>


	<div class="bgpopup_overlay" style="top:20px;">
	  	<div id="popup2" class="enter_contest" style="z-index:200;display:block;" > 
			<!-- <span class="button b-close">X</span> -->
			<div id="mycontent" style="height: auto; width: auto;"> 
				<div class="space" id="wrapper">
                   				<div class="content1" style="margin:0px;">
						<div id="title" style="border-bottom: 1px solid #808080;color: #FECD07;font-size: 17px;height: 42px;width: 100%;">Select Type Of Artist</div>
						<div style=" color: #D4D4D4 !important;" class="content_txt">
							<form action="" method="POST">
								<div class="type_of_subcats">
									<span>
										<input type="radio" name="type_of_artist[]" value="Band">Band
									</span>
									<span>
										<input type="radio" name="type_of_artist[]" value="Singer">Singer
									</span>
									<span>
										<input type="radio" name="type_of_artist[]" value="Performer">Performer
									</span>
								</div>
								<ul class="categoryList">
									
								</ul>
								<div class="submitCats">
	  								<input type="submit" value="Save" name="submitCats" class="button btn">
								</div>
							</form>
						</div>	
					</div>
           				</div>
			</div>
	  	</div>
	</div>
	<div class="b-modal" id="b-modal __b-popup1__" style="display:block;"></div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.type_of_subcats').find('input[type="radio"]').click(function(){
				var cat = $(this).val();
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
				$.ajax({
					type: "POST",
					url: "refreshajax.php",
					data: {
						'action' : 'fetchartistCats',
						'catname' : cat,
					},
					success: function(data){
						$.unblockUI();
						$('ul.categoryList').html(data);
						return false;
					}
				});
			});
		});
	</script>
<style>
.bgpopup_overlay {
  bottom: 0;
  left: 0;
  margin: auto;
  max-height: 650px;
  max-width: 650px;
  /*overflow: auto;*/
  padding: 5px 5px 20px !important;
  position: fixed;
  right: 0;
  z-index: 2147483647;
}
#popup, #popup2, #popup3, .bMulti {  padding:5px 5px 20px !important; overflow: auto;}
.content_txt p {
  margin-bottom: 10px;
  text-align: left;
  line-height: normal;
}
.agreebuttons .button {
  float: left;
}
#mycontent .agreebuttons {
  padding: 20px 0;
}
 @media only screen and (max-width:540px){
 #popup2 {  padding:10px !important; max-width:260px; margin:auto; max-height:300px; overflow:auto;}
 }

.type_of_subcats {
  /*border-bottom: 1px solid;*/
  float: left;
  margin-bottom: 10px;
  padding: 10px;
  width: 95%;
}

.type_of_subcats > span {
  float: left;
  width: 30%;
}
.type_of_subcats input {
	margin-right: 4px;
}
.categoryList {
	float: left;
	text-align: left;
	width: 100%;
}
.categoryList > li {
  float: left;
  padding: 10px;
  width: 45%;
}
.submitCats {
  float: left;
  margin: 20px 0;
  width: 100%;
}
#popup2 {
  box-sizing: border-box;
  height: 650px !important;
  max-height: 650px !important;
  padding: 15px !important;
}
</style>
<?php 	}	?>









<div class="slider_body">

 <ul>

  <li><img id="slider_body_img" src="" alt=""></li>

 </ul>

</div>

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

   <div class="v2_top_nav2"><!-- v2_top_nav  starts-->

	<div class="v2_header_top headerfordesk hideformobile">

	 <div class="v2_container">

	  <div style="max-width:100%" class="v2_nav v2_nav_host v2_nav2">

	   <ul> 
						<li class="small_logo"> 
								<a href="searchEvents.php"><img src="<?php echo $SiteURL;?>images/logo_without_tag.png" alt=""><i>MySitti.com</i></a>
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
								<!-- <a href="<?php //if($_SESSION['user_type'] == 'user'){ echo $SiteURL.'profile.php';}else{ echo $SiteURL.'home_club.php';} ?>">
									<span data-title="Home">Home</span>
								</a>  -->
							</li>

		      	<li <?php if($_SERVER['SCRIPT_NAME'] == '/searchEvents.php'){ echo "class='active' ";} ?>> <a href="/searchEvents.php"> <span data-title="Home">Home</span> </a> </li> 

					<li <?php if($_SERVER['SCRIPT_NAME'] == '/hotels/index.php'){ echo "class='active' ";} ?>> <a href="hotels/index.php"> <span data-title="Hotels">Hotels</span> </a> </li>

					<li <?php if($_SERVER['SCRIPT_NAME'] == '/flight/index.php'){ echo "class='active' ";} ?>> <a href="flight/index.php"> <span data-title="Flight">Flight</span> </a> </li>

					<li <?php if($_SERVER['SCRIPT_NAME'] == ''){ echo "class='active' ";} ?>> <a href="http://hotelsflights.mysitti.com/"> <span data-title="Packages">Packages</span></a></li>

					<li <?php if($_SERVER['SCRIPT_NAME'] == '/sports_event.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>sports_event.php"> <span data-title="Tickets">Tickets</span> </a> </li>

					<li <?php if($_SERVER['SCRIPT_NAME'] == '/tours.php'){ echo "class='active' ";} ?>> <a href="tours.php"><span data-title="Tours">Tours</span></a> </li>

					<li <?php if($_SERVER['SCRIPT_NAME'] == '/isangoapi.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>isangoapi.php"> <span data-title="Things To Do">Things To Do</span> </a> </li>

					<li <?php if($_SERVER['SCRIPT_NAME'] == '/city_talk.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>city_talk.php"> <span data-title="City Page">City Page</span> </a> </li>

					<li <?php if($_SERVER['SCRIPT_NAME'] == '/destination.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>destination.php"> <span data-title="Destinations">Destinations</span> </a> </li>

					<li <?php if($_SERVER['SCRIPT_NAME'] == '/homestay.php'){ echo "class='active' ";} ?>> <a href="<?php echo $SiteURL;?>homestay.php"> <span data-title="Vacation Rentals">Vacation Rentals</span> </a> </li>


				</ul>

			<div class="v2notification notify_hostside fordesknotification">
  				<?php include('notifications.php'); ?>
			</div>

	
			<div class="dropdown user_drp">
		        <button class="dropbtn_box"><img src="imagesNew/w-icon.png"></button>
		        <div class="dropdown-content">
		           <div class="searchBoxTop searchInnerBox pullRight hideform">
						<form method="POST" action="<?php echo $SiteURL."searchUsers.php";?>" id="searchUsersForm">
							<input type="text" id="searchUsers" value="" name="keyword_search" placeholder="Search By Username" class="adSearch">
							<input type="submit" id="findContestant" class="searchBoxTopBtn" name="SearchAllUsers" value="">
						</form>
					</div>
		        </div>
		    </div>
			<div class="v2_profile_user profilrForDesktop profile_usr">
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

							if($_SESSION['user_type'] == 'club'){

							$host_query = mysql_query("SELECT image_nm FROM clubs WHERE id = '".$_SESSION['user_id']."'");

							$loggedin_host_data = mysql_fetch_assoc($host_query);

							$userID = $_SESSION['user_id'];
							$displayImage = $loggedin_host_data['image_nm'];
						}

						?>
							<div class="dropbtn_profile v2_profile_user_info user_info_host2">
										<span class="v2_welcome_user">Welcome</span>
										<div class="clear"></div>
										<span class="v2_user_name"> <a href="<?php echo $SiteURL.$linkProfile; ?>">
										<?php $out = strlen($profilename) > 18 ? substr($profilename,0,18)."..." : $profilename;
										echo $out; ?>
										</a> </span> 
								</div>
								<div class="v2_thumb_user_profile user_profile_host2"> 
									<a href="<?php echo $SiteURL.$linkProfile; ?>">
									<?php if($_SESSION['user_type'] == 'club'){ ?>
										<img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$displayImage;} ?>" alt="user">
									<?php } else { ?>
										<img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$_SESSION['img'];} ?>" alt="user">
									<?php } ?>
									</a> 
								</div>
								<div class="dropdown">
							
								<div class="dropdown-content-profile">
									   <a href="<?php echo $SiteURL; ?>learn-more.php">Information</a>
					                   <a href="<?php echo $SiteURL; ?>support.php">Help</a>
					                   <a href="<?php echo $SiteURL; ?>main/logout.php">Logout</a>
					                </div>
								</div>
						</div>
   

 		<?php 

		if($_SESSION['user_type'] == 'user')

		{
			

	 	?>		<div class="pullRight"  style="margin-left:15px;">

				<div class="v2_profile_user nospace">

					<div class="v2_thumb_user_profile"> 

						<a href="<?php echo $SiteURL;?>profile.php"> 

							<img alt="user" src="<?php if(!empty($_SESSION['img']) ){ echo $_SESSION['img']; }else{ echo "images/man4.jpg"; } ?>">

						</a> 

					</div>

					<div class="v2_profile_user_info"> 

						<span class="welcome_user_logged_in">Welcome</span> <span class="user_logged_in"><a href="<?php echo $SiteURL;?>profile.php"><?php if(!empty($_SESSION['profilename'])){ echo $_SESSION['profilename'];}elseif(!empty($_SESSION['profile_name'])){ echo $_SESSION['profile_name'];}else{ echo $_SESSION['username'];} ?></a> </span> 

					</div>

				</div>

			</div>

   <?php 	}	?>

 

    	

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

	   

	   <div class="mobile_nav">

		<?php if($_SESSION['user_type'] == 'club'){ ?>

		<ul>

		<!--  <li><a href="<?php echo $SiteURL; ?>shout.php"><span data-title="Shout">Shout</span></a></li>

		 <li><a href="<?php echo $SiteURL; ?>store.php"><span data-title="Store">Store</span></a></li> -->

		 <li><a href="<?php echo $SiteURL; ?>learn-more.php"><span data-title="Calender">Information</span></a></li>

		</ul>

		<?php } ?>

		<?php if($_SESSION['user_type'] == 'user'){ ?>

		<ul class="v2_login_nav">

	<!-- 	 <li><a href="<?php echo $SiteURL; ?>user_shout.php"><span data-title="Shouts">Shouts</span></a></li>

		 <li><a href="<?php echo $SiteURL; ?>all_hosts.php"><span data-title="Favorite">Favorite</span></a></li>
 -->
		 <li><a href="<?php echo $SiteURL; ?>learn-more.php"><span data-title="Calender">Information</span></a></li>

		</ul>

		<?php } ?>

		<?php if($_SESSION['user_type'] == 'user'){ ?>

		<div class="shopcart cart2"> <a href="cart.php"> <img src="images/shopcart.png" alt="Cart">

		 <?php 

						if( count($_SESSION['cart_value']) > 0)

						{

					?>

		 <div class="shopcart_notification" style=" " id="s_cnt"> <?php echo count($_SESSION['cart_value']); ?> </div>

		 <?php 	}	?>

		 </a> </div>

		<?php } ?>

		<ul class="helpme">

		 <li> <a href="<?php echo $SiteURL; ?>support.php"><span data-title="Help"> Help</span> </a> </li>

		 <li><a href="<?php echo $SiteURL; ?>main/logout.php"><span data-title="Logout">Logout</span></a></li>

		</ul>

	   </div>

	  </div>

	 

   

	 </div>

	</div>

   </div>

   <!-- v2_top_nav  ends-->

   <?php if(isset($_SESSION['user_id'])){ ?>

   <div class="v2_nav_profile nav_profile_host HostHeaderBg"> 

	<div class="v2_container">

	 <?php

		$banner_query =  mysql_query("SELECT `banner_name` FROM `host_banner` WHERE `user_id` = '".$userID."' AND user_type = 'club' AND `status` = '1'");

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

		

		

	  if($_SESSION['user_type'] == 'user'){ ?>

	 <div class="shopcart cart2"> <a href="cart.php"> <img src="images/shopcart.png" alt="Cart">

	  <?php 

						if( count($_SESSION['cart_value']) > 0)

						{

					?>

	  <div class="shopcart_notification" style=" " id="s_cnt"> <?php echo count($_SESSION['cart_value']); ?> </div>

	  <?php 	}	?>

	  </a> </div>

	 <?php } ?>

	 <ul class="fordesk">

	  <li> <a href="<?php echo $SiteURL; ?>support.php"><span data-title="Help"> Help</span> </a> </li>

	  <li><a href="<?php echo $SiteURL; ?>main/logout.php"><span data-title="Logout">Logout</span></a></li>

	 </ul>

	 <div class="userlogo userlogo_host">

	

			  <div class="logomobi">

			<ul>

				<li class="small_logo"> <a href="<?php echo $SiteURL; ?>index.php"><img alt="" src="<?php echo $SiteURL; ?>images/logo_without_tag.png"><i>MySitti.com</i></a> </li>

			  </ul>

		  </div>

		  <div class="v2_profile_user ">

			<?php

					if($_SESSION['user_type'] == "user")

					{

						$linkProfile = "profile.php";

						$profilename = $loggedin_user_data['profilename'];

					}

					elseif($_SESSION['user_type'] == 'club' && !isset($_SESSION['subuser']))

					{

						$linkProfile = "home_club.php";

						$profilename = $loggedin_host_data['club_name'];

					}

					elseif($_SESSION['user_type'] == 'club' && isset($_SESSION['subuser']))

					{

						$linkProfile = "musicrequestList.php";

						$profilename = $loggedin_host_data['club_name'];

					}

						?>

			<div class="v2_thumb_user_profile"> <a href="<?php echo $SiteURL.$linkProfile; ?>"> <img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$_SESSION['img'];} ?>" alt="user" /> </a> </div>

			<div class="v2_profile_user_info"> <span class="v2_welcome_user">Welcome</span> <span class="v2_user_name"> <a href="<?php echo $SiteURL.$linkProfile; ?>">

			  <?php if(empty($profilename)){ echo $_SESSION['username']; }else{ echo $profilename; } ?>

			  </a> </span> </div>

		  </div>

		  </div>

		   <div class="secondarymenu">

	 

  

  

	 <?php 	//}	?>

	 <div class="hide_menu_desktop">

	  <?php if($_SESSION['user_type'] == 'club'){ ?>

	  <ul>

	  <!--  <li><a href="<?php echo $SiteURL; ?>shout.php"><span data-title="Shout">Shout</span></a></li>

	   <li><a href="<?php echo $SiteURL; ?>store.php"><span data-title="Store">Store</span></a></li> -->

	   <li><a href="<?php echo $SiteURL; ?>learn-more.php"><span data-title="Information">Information</span></a></li>

	  </ul>

	  <?php } ?>

	  <?php if($_SESSION['user_type'] == 'user'){ ?>

	  <ul class="v2_login_nav">

	  <!--  <li><a href="<?php echo $SiteURL; ?>user_shout.php"><span data-title="Shouts">Shouts</span></a></li>

	   <li><a href="<?php echo $SiteURL; ?>all_hosts.php"><span data-title="Favorite">Favorite</span></a></li> -->

	   <li><a href="<?php echo $SiteURL; ?>learn-more.php"><span data-title="Information">Information</span></a></li>

	  </ul>

	  <?php } ?>

	 </div>

	 

	 <div class="clear"></div>

	 

	 <?php

	include('image_upload_resize.php');

	include("resize-class.php");

	include("user_upgrade.php");	 

	 ?>


	</div>

   </div>

   <div class="v2_nav_profile  profile_header">

	  <input type="button" value="Menu" class="menu_toggle_sidebar">

	  

	  <div class="v2_nav_right_mobi">

	

	   <?php

		if(!isset($_SESSION['user_id']))

		{

			include('hotSpotsSidebar.php');

		}

		else

		{

			if(isset($_GET['host_id']) )

			{

				if($_SESSION['user_type'] =="club" && $_GET['host_id'] == $_SESSION['user_id'])

				{

					if(isset($_SESSION['subuser']))

					{
						include('sub-right-panel.php'); 

					}

					else

					{ 

						include('club-right-panel-responsive.php');

					} 

				}

				else

				{
					include('host_left_panel.php');

				}

				

			}

			

			else if($_SESSION['user_type'] == 'user')

			{
				include('friend-right-panel-responsive.php');

			}

			elseif($_SESSION['user_type'] =="club" && !isset($_GET['host_id']))

			{

				if(isset($_SESSION['subuser']))

				{
					include('sub-right-panel.php'); 

				}

				else

				{ 
					include('club-right-panel.php');

				} 

			}

		}



	?>

	  </div>

   

   

  

	 </div>

   <?php } ?>

   </div>

   <div class="v2_container">

   <div class="newmenu_mobile mtop51">

   <ul>

   

	  <li> 

	  <div class="next">

	   <div id="dromMenu" class="heads"><img src="images/Contest.png" alt="">

	 <label> Contests</label></div>

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

		 <li><a href="searchEvents.php">

	  <div class="next">

	   <div class="heads"><img src="images/CityEvents.png" alt="">

	 <label> City Events</label></div>

	  </div></a>

	  </li>

		</li>

	  <li><a href="city_talk.php"> 

	  <div class="next">

	   <div class="heads"><img src="images/CityTalk.png" alt="">

	 <label>City Talk</label></div>

	  </div></a>

	  </li>

	  

	  

	  <li><a href="advanced_filters.php"> 

	  <div class="next">

	   <div class="heads"><img src="images/HotSpots.png" alt="">

	 <label>Host </label></div>

	  </div></a>

	  </li>

 

	  <li>

	  <div class="v2notification notify_hostside formobinotification next">

	  <div class="heads" style="overflow:inherit;"><img src="<?php echo $SiteURL; ?>images/Notifications.jpg" alt="">

	   <?php

						include('notifications.php'); ?>

	 

	  <label><a href="<?php echo $SiteURL; ?>show-notifications.php"> Notifications</a></label> </div>

	  </div>

	  </li>

	   <li><a href="<?php echo $SiteURL; ?>user_shout.php">

	  <div class="next">

	   <div class="heads"><img src="images/Shouts.png" alt="">

	 <label>Shouts</label></div>

	  </div></a> 

	  </li>

	  

		 <li style="display:none"><a href="<?php echo $SiteURL; ?>index.php#searchArea" class=""> 

	  <div class="next">

	   <div class="heads"><img src="<?php echo $SiteURL; ?>images/searchEvent.png" alt="">

	 <label>Search</label></div>

	  </div></a> 

	  </li>

   

      <li><a href="<?php echo $SiteURL; ?>live2/battle.php" class="" style="display:none"> 

	  <div class="next">

	   <div class="heads"><img src="<?php echo $SiteURL; ?>images/batttle.png" alt="">

	 <label>Live Battle</label></div>

	  </div></a> 

	  </li>

     <li><a href="MySittiTV.php" class=""> 

	  <div class="next">

	   <div class="heads"><img src="images/mtv.png" alt="">

	 <label>Mysitti TV</label></div>

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

	 </div>   <div class="banernew v2_banner_top">
   <div class="v2_container">
<?php if(!isset($_GET['host_id']) && $_SESSION['user_type'] == "club")

		{

	  ?>

	 <div class="uload_banner_header"> <a href="<?php echo $SiteURL; ?>upload-banner.php"><img src="<?php echo $SiteURL; ?>images/uploadbanner.png" alt="Upload" title="Upload Header Banner"></a> </div>

	 <?php }  ?>

	<div  id="searchArea"  class="v2_brand brand_host_inner mtop00">

	 

	 <a href="<?php echo $SiteURL; ?>index.php"> <span class="tgLine">Making Every City Your City</span><div class="clear"></div><img src="<?php echo $SiteURL; ?>images/v2_logo_round.png" alt="" />

	 

	  </a> </div>
    </div>

	<div class="clear"></div>

	<div class="v2_search_area search_login_host" id="search_Events">

	 <div class="clear"></div>

	 <div class="clear"></div>

	</div>

   </div>

   

  

   <div class="v2_profile2_wrapper">

	<div class="v2_profile_inner v2_gutter50">

	 <div class="v2_container">

	  <div class="v2_profile2_left">

	   <h1 class="name_pro_fight">

		<?php echo $displayName; ?></h1>

	   <div class="clear"></div>
		<div class="sharenow">
    <ul>
    <li><a href=""><img src="images/sharProfile.png" alt="Share"></a>
    
     			<ul class="epkAdmin epk2admin" style="float:right;">
	    			<li style="display:inline; margin-right:10px; position:relative;">
				<?php 
						$simage = $SiteURL.str_replace("../", "", $image_nm);
					?>
					<a style="text-decoration:none;" target="_blank" onclick="return shareProfileFB('<?php echo $ShareFacebookURl; ?>', '<?php echo $simage; ?>','<?php echo $ShareTitle; ?>' )" class="fb_share_button" href="javascript:void(0);" rel="nofollow"> 
						<img alt="Share on Facebook" src="<?php echo $SiteURL;?>images/fbook.png"> 
					</a>
					<a style="text-decoration:none;" target="_blank" onclick="return shareProfileTweet('<?php echo $ShareFacebookURl; ?>' )" class="fb_share_button" href="javascript:void(0);" rel="nofollow"> 
						<img alt="Share on Facebook" src="<?php echo $SiteURL;?>images/twt.png"> 
					</a>
					<a style="text-decoration:none;" onclick="return shareProfileGoogle('<?php echo $ShareFacebookURl; ?>' )"  class="fb_share_button" href="javascript:void(0);" rel="nofollow"> 
						<img alt="Share on Facebook" src="<?php echo $SiteURL;?>images/emailShare.png"> 
					</a>
					<!-- <span class='st_email_large' displayText='Email'></span> -->

				</li>		 
			</ul>
      </li>
      </ul>
     </div>
     	<script type="text/javascript">
     		function shareProfileFB(u, t, title) 
		{
			window.open('http://www.facebook.com/dialog/feed?app_id=1027910397223837&link='+u+'&picture='+t+'&name=' + title+'&caption=' + encodeURIComponent('MySitti.com') + '&description=' + u + '&redirect_uri=https://mysitti.com/facebookshareclose.php&display=popup','toolbar=0,status=0,width=626,height=436');
			return false;
		}

		function shareProfileTweet(u) 
		{
			window.open('http://twitter.com/home?status='+u,'sharer','toolbar=0,status=0,width=626,height=436');
			return false;
		}

		function shareProfileGoogle(u) 
		{
			window.open('https://plus.google.com/share?url='+u,'sharer','toolbar=0,status=0,width=626,height=436,resizable=true,scrollbars=1');
			return false;
		}



     	</script>
	   <div class="counter"> <span class="views">Viewers: </span>

		<div class="total"><?php echo $profileviewers; ?> </div>

	   </div>
     

	  </div>

	  <div class="v2_profile2_pic_container" style="text-align:center !important;">

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

		
			<a onclick="mycropFunction()" href="javascript:void(0);">
			<img style="width:auto;" align="" src="<?php echo $imgSRC; ?>">
			</a>
			

	 </div>

	  </div>
	  <script type="text/javascript">
          function mycropFunction() {
	          	var left  = ($(window).width()/2)-(900/2),
			    top   = ($(window).height()/2)-(600/2),
			    popup = window.open ("imgpreview.php", "popup", "width=900, height=600, top="+top+", left="+left);
			}
          </script>

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
				$Anchorweb_url = "http://".$web_url;
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

    				<a target="_blank" href="<?php echo $facebookLink;?>">

    					<img alt="" src="../images/fbook.png" al="">

    				</a>

    			<?php 

    				}

    				if(!empty($twitterLink))

    				{

    			?>

				<a target="_blank" href="<?php echo $twitterLink;?>">

					<img alt="" src="../images/twt.png">

				</a>

			<?php 	}

				if(!empty($instaLink))

				{

			?>

				<a target="_blank" href="<?php echo $instaLink;?>">

					<img alt="" src="https://mysitti.com/img/icon8.png">

				</a>

			<?php }	?>

			</div>
	   	</div>

	   <div class="clear"></div>

	  </div>

	  		

  <div class="clear"></div>

	 </div>

	</div>

   </div>

   <div class="clear"></div>

  </div>

  <!-- end profilebar 2 --> 

 </div>

</div>

<!-- END v2_header_wrapper -->

</div>

<!-- v2_banner_top -->

<div class="clear"></div>

<?php 

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

			$st_qry = 'ffmpeg -i rtsp://52.37.162.200:1935/live/'.$hbhost.' 2>&1; echo $?';

	 		 

			$st_res=(string)trim(shell_exec($st_qry));

		 					

			if (strpos($st_res,'404 Not Found') === false) {

				return true;

			}



		}

		

		return false;



	}

// }





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











if(!isset($_SESSION['user_id']))

{

	$_SESSION['id'] = '54';

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

		$('#Search_box_filter').hide().before('<a href="#" id="toggle-menu" class="v2_filter_menu host_filter"><?php echo $dropdown_city; ?>, <?php echo $dropdown_state; ?><img src="images/menu.png" alt="Menu" /></a>');

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

 

</script>

<div id="fullOverlay"></div>

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

	
//echo $NoBannerForhost; die;
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
			}
		</style>

<?php

	}

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

				$('#slider_body_img').attr('src', imgsrc);

			});

		</script>
		<style type="text/css">
			.common_box
			{
				position: static;
			}
		</style>

<?php

	}
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
	

}else{



/* host custom background code goes here */

/*----------------------------------------------------------------------*/



$get_time = @mysql_query("SELECT * FROM refresh_background_time");
// echo  $NoBannerForhost; die;
$time = @mysql_fetch_assoc($get_time);
if($NoBannerForhost == '0')
{
	// die('dfdf');
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

		

	});

</script>

<?php 
}






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



}

/*--------------------------------------------------------------------------------*/





$AutoLoadStreaming = '';



if(isset($_GET['host_id']))

{

	$userID_stream = $_GET['host_id'];

	$userID_type = 'club';

	if($userID_stream == $_SESSION['user_id'] && $_SESSION['user_type'] == 'club' )

	{

		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `clubs` WHERE `id` = '$userID_stream'  ");

		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);

		if($fetchResultStreaming['streamingLaunch'] == '1' && ($fetchResultStreaming['streamingLaunchFrom'] == 'encoder') || ($fetchResultStreaming['streamingLaunchFrom'] == 'phone') )

		{

			$AutoLoadStreaming = 'YES';

		}

		else

		{

			$AutoLoadStreaming = 'NO';

		}

	}

	else

	{

		$AutoLoadStreaming = 'YES';

	}

}

else

{

	$userID_stream = $_SESSION['user_id'];	

	$userID_type = $_SESSION['user_type'];





	$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `clubs` WHERE `id` = '$userID_stream'  ");

	$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
    
    $StreamingLaunch = $fetchResultStreaming['streamingLaunch'];
    
    $StreamingLaunchFrom = $fetchResultStreaming['streamingLaunchFrom'];

	if($fetchResultStreaming['streamingLaunch'] == '1')

	{

		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `clubs` WHERE `id` = '$userID_stream'  ");

		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);

		if($fetchResultStreaming['streamingLaunch'] == '1' && ($fetchResultStreaming['streamingLaunchFrom'] == 'encoder') || ($fetchResultStreaming['streamingLaunchFrom'] == 'phone') )

		{

			$AutoLoadStreaming = 'YES';

		}

		else

		{

			$AutoLoadStreaming = 'NO';

		}

	}

	else

	{

		$AutoLoadStreaming = 'YES';

	}

}



// echo $AutoLoadStreaming; die;



?>
<style type="text/css">
		@media only screen and (max-width: 480px) {
			.battleTv .TV .mejs-container
			{
				height: 320px !important;
			}
		}

.TV {
  float: left;
  height: 100%;
  width: 100%;
}

#tv_main_channel
{
	width: 100% !important;
	height: 100% !important;
}
#tv_main_channel > iframe {
	height: 100% !important;
	width: 100% !important;
}

	</style>
<!-- END BACKGROUND CODE -->

<div class="common_box">

<div class="v2_container">

 <div class="clear"></div>

 <div class="v2_wrapper_video v2_gutter50"> 

  <div class="v2_play_vid_current" style="height: auto !important;">

   <div class="sxtreme_play_vid <?php if($AutoLoadStreaming == 'YES' && $ST['streamingLaunch'] == '1'){ echo 'changed'; }else{ echo 'offline_stream';}?>" >

	<?php



					$swfurl= $SiteURL."live2/live_video.swf?n=".urlencode($n);

					$scale="noborder";

					// echo $profilename;

					if($StreamingLaunch == '1' && $AutoLoadStreaming == 'YES')

					{

						//die('dfdfdfdfd');

						if($userID == $_SESSION['user_id'] && $_SESSION['user_type'] == 'club')

						{



						}

						else

						{

							$getPreviousCounter = mysql_query("SELECT `streamingCounter` FROM `clubs` WHERE `id` = '$userID' ");

							$fetchCounter = mysql_fetch_assoc($getPreviousCounter);

							$NewstreamingCOUNTER =  $fetchCounter['streamingCounter'] + 1;

							mysql_query("UPDATE `clubs` SET `streamingCounter` = '$NewstreamingCOUNTER' WHERE `id` = '$userID' ");

						}

					?>

					<div class="iframe">
                        <?php
                            if($StreamingLaunchFrom == 'phone'){
                            ?>
                                <iframe style='width:660px; max-width:100%;height:420px !important;' hspace="0" vspace="0" frameborder="0" scrolling="no" src="https://52.37.162.200/live/streamPlayerUrl.php?v=<?php echo $streamCode;?>">
                                </iframe>
						<?php
                            }
                            else{
                        ?>
                                <iframe style='width:660px; max-width:100%;height:420px !important;' hspace="0" vspace="0" frameborder="0" scrolling="no" src="<?php echo $SiteURL;?>live2/channelIframe.php?n=<?php echo $n; ?>&host_id=<?php echo $userID; ?>&user_type=club">
                                </iframe>
                        <?php
                            }
                        ?>

					</div>

	<?php 

					}

					else

					{ 

	?>
<div class="TV">
	<video id="tv_main_channel" style='width:100%;height:92% !important; display:none;' controls="true">

	 <?php
		$getDefault = mysql_query("SELECT * FROM uploaed_video WHERE `featured` = '1'  AND `user_id` = '$userID'  AND `user_type` = 'club' ORDER BY `video_id` DESC LIMIT 1 ");
		$default_vid = mysql_fetch_assoc($getDefault);
		$getDefault1= mysql_query("SELECT * FROM uploaed_video WHERE `user_id` = '$userID'  AND `user_type` = 'club' AND `featured` = '1' AND `default_video` = '1'");
		$default_vid1 = mysql_fetch_assoc($getDefault1);
		if(mysql_num_rows($getDefault1) > 0 )
		{
			if(strrpos($default_vid1['video_nm'], 'youtube.') == true || strrpos($default_vid1['video_nm'], 'youtu.be') == true)
			{
				$type = 'video/youtube';
			}
			else
			{
				$type = 'video/mp4';
			}

?>
			<source id="mp4Source" src="<?php echo str_replace("../", "",$default_vid1['video_nm']); ?>" type="<?php echo $type; ?>">
<?php 			
		}
		elseif(mysql_num_rows($getDefault1) == 0 && mysql_num_rows($getDefault) > 0 )
		{
			if(strrpos($default_vid['video_nm'], 'youtube.') == true || strrpos($default_vid['video_nm'], 'youtu.be') == true)
			{
				$type = 'video/youtube';
			}
			else
			{
				$type = 'video/mp4';
			}

?>
			<source id="mp4Source" src="<?php echo str_replace("../", "",$default_vid['video_nm']); ?>" type="<?php echo $type; ?>">
<?php
		}
		elseif(mysql_num_rows($getDefault1) == 0 && mysql_num_rows($getDefault) == 0 )
		{
			$getMainDefault = mysql_query("SELECT * FROM `pages` WHERE `page_id` = '13' ");
			$fetchMainDefault = mysql_fetch_assoc($getMainDefault);
			if(strrpos($fetchMainDefault['default_video'], 'youtube.') == true || strrpos($fetchMainDefault['default_video'], 'youtu.be') == true)
			{
				$type = 'video/youtube';
			}
			else
			{
				$type = 'video/mp4';
			}
			?>
				<source id="mp4Source" src="<?php echo str_replace("../", "", $fetchMainDefault['default_video']); ?>" type="<?php echo $type;?>">
<?php
		}
	?>

	</video>
</div><!-- END TV div -->
<script type="text/javascript">
	jQuery(document).ready(function($) {
		var link = $('#mp4Source').attr('src');
		var isYoutube = link && link.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
		var vimeoLink = link && link.match(/(?:vimeo)(?:\.com|\.be)\/([\w\W]+)/i);
		var current = 0;
		var playlist = $('.extereme_playlist');
		var tracks = playlist.find('li');
		var len = tracks.length;
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
						//autostart: true,
				  	});

					///$('.mejs-controls').find('.mejs-playpause-button').find('button').trigger('click');
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
						//autostart: true,
				  	});
				}
			});
		}



		$('.list_play').each(function(){
			if($(this).hasClass('videourl_'+link))
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

		$('.jw-icon-display').click(function(){
			jwplayer("tv_main_channel").play();
		});
	});
</script>	

	

	<?php }	?>

   </div>

  </div>

  	<div class="v2_vid_list" id="AjaxChatDiv">

  		<?php 

		if($StreamingLaunch == '1'  || $ST['streamingLaunch'] != '1' )

		{

  		?>

			<div class="thumb_list_battle newbattle extereme_playlist">
			<h1>Featured Videos
           <img id="addvideo" src="imagesNew/682987_add_512x512.png" width="35" height="35" style="float: right; padding: 5px;">
			</h1>
			<!-- <input type="button" class="button"  id="addvideo" value="Add" style="margin-right:15px;"> -->
			<!-- <img id="addvideo" src="imagesNew/682987_add_512x512.png" width="35" height="35" style="float: right; padding: 5px;"> -->
			<?php

			$get_battle_videos = mysql_query("SELECT * FROM `uploaed_video` WHERE `user_id` = '$userID'  AND `user_type` = 'club' AND `featured` = '1' AND `default_video` = '0' ORDER BY `video_id` DESC ");

			$count_battle_videos = mysql_num_rows($get_battle_videos);



			if($count_battle_videos < 1){

				

				//echo "No video found";

				

			}else{

				if(mysql_num_rows($getDefault1) > 0)
				{
				?>
				<a id="list_<?php echo $default_vid1['video_id']; ?>" class="list_play videourl_<?php echo str_replace("../", "", $default_vid1['video_nm']); ?>" href="javascript: void(0);" onclick="change_src('<?php echo str_replace("../", "", $default_vid1['video_nm']); ?>','<?php echo $default_vid1['video_id']; ?>')"><?php echo $default_vid1['video_title']; ?></a>
				<?php
				}
				while($b_row = mysql_fetch_assoc($get_battle_videos)){



					//$explode_vid = explode("../video/" , $b_row['video_path']); ?>

			<a id="list_<?php echo $b_row['video_id']; ?>" class="list_play videourl_<?php echo str_replace("../", "", $b_row['video_nm']); ?>" href="javascript: void(0);" onclick="change_src('<?php echo str_replace("../", "", $b_row['video_nm']); ?>','<?php echo $b_row['video_id']; ?>')"><?php echo $b_row['video_title']; ?></a>

			<?php }

			} ?>

			</div>

			<?php 

			if(!isset($_GET['host_id']) && !isset($_GET['id']))

			{

			?>

   				<div class="load_more_ex" style="display:none;">

					<input type="button" onclick="window.location.href='uploadVideos.php'" value="Load Videos">

   				</div>

   		<?php 	}	

		}

		elseif( ($typeclub == '97' || ($typeclub == '108' && strrpos($type_details_of_club, 'DJs') == true) ) && $ST['streamingLaunch'] == '1')

		{

			// $gname1=mysql_query("select * from  chat_groups where group_name='$n' ");



			// if(mysql_num_rows($gname1)  == "0")

			// {

			// 	//die('dfdfd');

			// 	mysql_query("INSERT INTO `chat_groups` (`group_name`,`group_type`,`create_by`,`user_type`) 

			// 			VALUES ('$n','streaming','$userID','club') ");

			// 	$ID = mysql_insert_id();

			// 	mysql_query("INSERT INTO chat_users_groups (group_id,user_id,user_type,loggedin) VALUES ('$ID','$userID','club','1')");



			// }



	?>		

	<div id="gallerypop">
        
         <form method="post" name="upvideo" id="upvideo" enctype="multipart/form-data" onsubmit="return validate_video();"> 

		 <?php if(isset($_SESSION['error_msg'])){ ?> 

		 <div style="color:#F00" align="center"> <?php echo $_SESSION['error_msg']; ?></div>

		 <?php  unset($_SESSION['error_msg']);

		 } ?>


			<div class="row">

				<span class="label" style="font-size:16px;font-weight:bold">Video Title:</span>

				<span class="formw"><input type="text" id="video_title" name="video_title" required />

				</span>

			</div>

		 <div class="row">
		 	<span class="label" style="font-size:16px;font-weight:bold">Enter the video YouTube share URL</span>
			<span class="formw new-border">
				<input type="text" id="video_file" name="video_file" placeholder="Paste Youtube/Vimeo URL link here" multiple onclick="remove_lower_file();">
					<span class="label" style="font-size:16px;float: left;font-weight:bold">Or</span>
					<span class="formw" style="float: left;"><input style="color:#FFF;" class="upload_vi" type="file"  name="file" id="computer_file" onchange="return ValidateVideoUploadnew();" onclick="remove_upper_file();"/>
			<p>.mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v</p>
			</span>
			</span>
		</div>

		<div class="row">
			<!--<span class="label" style="font-size:16px;font-weight:bold">YouTube, Vimeo URL Or Computer :</span>-->
		
		</div>
		<ul class="btncenter_new">

		 <li> <input name="submit" type="submit" class="button btn_add_venu" value="Upload" /></li>

		</ul>

		<input type="button" id="cancel_button" value="X">
        	
        </form>
        
</div>

	<script type="text/javascript">
		$(document).ready(function(){
        
         $("#addvideo").click(function(){
         	alert("jhdfhjdsfjk");
          showpopup();
         });
         $("#cancel_button").click(function(){
          hidepopup();
         });
         
    	});

        function showpopup()
        {
         $("#gallerypop").fadeToggle();
         $("#gallerypop").css({"visibility":"visible","display":"block"});
        }

        function hidepopup()
        {
         $("#gallerypop").fadeToggle();
         $("#gallerypop").css({"visibility":"hidden","display":"none"});
        }
	</script>

			<script type="text/javascript">

				function blockUser(uid)

				{

					var ID = $('#GROUPid').val();

					$.ajax({

						url: "group-chat/refresh.php?group_id="+ID+"&deleteuserid="+uid,

						cache: false,

						success: function(html)

						{

							$(".refresh").html(html);

							$('#sc').animate({

							    	scrollTop: $("#sc").get(0).scrollHeight

						    	}, 3000);

					  	}

					});

				}



				function deleteMessage(msgid)

				{

					var ID = $('#GROUPid').val();

					$.ajax({

						url: "group-chat/refresh.php?group_id="+ID+"&message_id="+msgid,

						cache: false,

						success: function(html)

						{

							$(".refresh").html(html);

							$('#sc').animate({

							    	scrollTop: $("#sc").get(0).scrollHeight

						    	}, 3000);

					  	}

					});



				}



				function setchat(val)

				{



					

				$('#textb').val($('#textb').val() + val);



				}

				$(document).ready(function(){





				$("div.refresh").scrollTop(700);

					$(document).ready(function()

					{

					//	alert('dddd');

						window.setInterval(function(){
							console.clear()
							var ID = $('#GROUPid').val();

							$.ajax({

								url: "group-chat/refresh.php?group_id="+ID,

								cache: false,

								success: function(html)

								{

									$(".refresh").html(html);

									$('#sc').animate({

									    	scrollTop: $("#sc").get(0).scrollHeight

								    	}, 1000);

							  	}

							});

							$.ajax({

								url: "group-chat/refresh.php?group_id="+ID+"&count=users",

								cache: false,

								success: function(html)

								{

									$("#chatMembers").html(html);

							  	}

							})

							$.ajax({

								url: "group-chat/refresh.php?group_id="+ID+"&view=Viewers",

								cache: false,

								success: function(html)

								{

									$("span#totalViewers").html(html);

							  	}

							})

						}, 3000);

						

					});

					

					

					$(document).ready(function() {





						$("input").keypress(function(event) {



							if (event.which == 13)

							{

								var ID = $('#GROUPid').val();

								event.preventDefault();

								$text = $('#textb').val();

								if($('#textb').val() != "")

								{

									$('#textb').val('');

									$.ajax({

										type: "POST",

										cache: false,

										url: "group-chat/save.php",

										data: "text="+$text+"&group_id="+ID+"&sender=<?php echo $_SESSION['user_id']; ?>",

										success: function(data) {

											//alert('data has been stored to database');

											$('#textb').val('');

										    	$('#sc').animate({

											    	scrollTop: $("#sc").get(0).scrollHeight

										    	}, 1000);

										}

									});

								}

							}

						});





						$('#post_button').click(function() {

							//alert($('#textb').val());

							$text = $('#textb').val();

							if($('#textb').val() != "")

							{

								var ID = $('#GROUPid').val();

								$('#textb').val('');

								$.ajax({

									type: "POST",

									cache: false,

									url: "group-chat/save.php",

									data: "text="+$text+"&group_id="+ID+"&sender=<?php echo $_SESSION['user_id']; ?>",

									success: function(data) {

										//alert('data has been stored to database');

										$('#textb').val('');

										$('#sc').animate({

										    	scrollTop: $("#sc").get(0).scrollHeight

									    	}, 1000);

									}

								});

							}

						});

					});

						

				});

				</script>
		

			<div class="grp_ceond">



						<?php 

							$gname=mysql_query("select * from  chat_groups where group_name='$n' ");

							$group_dtl=mysql_fetch_assoc($gname);

							$nowtime = date('Y-m-d H:i:s');

							$groupID = $group_dtl['id'];

							$chk_user=mysql_query("select  user_id from  chat_users_groups where group_id=".$groupID."");

							$cnt_row=mysql_num_rows($chk_user);

							$my_smilies = array(

								'@!' => '<img src="group-chat/smilies/barmy.gif"/>',

								'||' => '<img src="group-chat/smilies/bash.gif"/>',

								'[]' => '<img src="group-chat/smilies/bottle.gif"/>',

								'%#' => '<img src="group-chat/smilies/bike2.gif"/>',

								'!@' => '<img src="group-chat/smilies/cheer.gif"/>'

								);

							?>

							



					<div class="grpone" >

						<input type="hidden" id="GROUPid" value="<?php echo $groupID; ?>" />

							<script type="text/javascript">

							function userPop(url)

							{

								window.open(url,'1396358792239','width=300,height=330,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=0,left=0,top=0');

								return false;

							}



							</script>

							<input name="message" type="text" id="textb"/>



							<input type="button" class="onlineUsers" onclick="userPop('fetchUsers.php?gID=<?php echo $groupID; ?>');" value="View Users" />

							<input name="submit1" type="button" value="Send" id="post_button" />



							<input name="sender" type="hidden" id="texta" value="<?php echo $_SESSION['username']?>"/>

 							<div class="divider"></div>

						<div class="refresh" id="sc">



							<?php

							//where sent_time > NOW() - INTERVAL 1 HOUR 



							//echo "SELECT * FROM message where group_id=".$ID." AND group_type='streaming' AND  sent_time  > ( '$nowtime' - INTERVAL 1 HOUR )  ORDER BY id"; exit;



							$result = mysql_query("SELECT * FROM message where group_id=".$groupID." AND group_type='streaming' AND  sent_time  > ( '$nowtime' - INTERVAL 1 HOUR )  ORDER BY id");

							if(mysql_num_rows($result) > 0)

							{

								while($row = @mysql_fetch_array($result))

								{	

									if($row['sender_type'] == 'user')

									{

										$QQ = mysql_query("SELECT * FROM `user` WHERE `id` = '$row[sender]' ");

										$fetchUser = mysql_fetch_array($QQ);

										if($fetchUser['profilename'] == "" && $fetchUser['profilename'] == " ")

										{

											echo '<p>'.'<span>'.$row['first_name'].' '.$row['last_name'].':</span>'. '&nbsp;&nbsp;' . 	str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';

										}

										else

										{

											echo '<p>'.'<span>'.$row['profilename'].':</span>'. '&nbsp;&nbsp;' . str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';

										}

									}

									else

									{

										$QQ = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$row[sender]' ");

										$fetchUser = mysql_fetch_array($QQ);

										echo '<p>'.'<span>'.$row['club_name'].':</span>'. '&nbsp;&nbsp;' . str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';

									}

								 

								}

							 }

							 else

							 {

								echo "<p>Loading.....</p>";

							 }

							?>



						</div>

							

					</div>

							

				</div>

		<?php 	}	?>

  	</div>

 </div>

</div>

<?php if($_SESSION['user_type'] == 'club' && !isset($_GET['host_id'])){ ?>

<div class="uload_banner_bg"> <a href="host-background.php"><img title="Upload Background Banner" alt="Upload" src="https://mysitti.com/images/uploadbanner.png"></a> </div>

<?php } ?>
