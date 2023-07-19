<?php 

error_reporting(0);

	$currentDatetime = date('Y-m-d H:i:s');
	$currentDate = date('Y-m-d');
	$currentTime = date('H:i:s');
	$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
	$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";
	$ABSPATH =$_SERVER['DOCUMENT_ROOT']."/";
	$getEventsCategory = mysql_query("SELECT * FROM `eventcategory` ORDER BY `catname` ASC ");

if($_SESSION['user_type'] == 'club'){

	$host_query = mysql_query("SELECT * FROM clubs WHERE id = '".$_SESSION['user_id']."'");
	$loggedin_host_data = mysql_fetch_assoc($host_query);
	$userID = $_SESSION['user_id'];
	$UserTYPE = 'club';
}

if($_SESSION['user_type'] == 'user'){

	$user_query = mysql_query("SELECT * FROM user WHERE id = '".$_SESSION['user_id']."'");
	$loggedin_user_data = mysql_fetch_assoc($user_query);
}

if(isset($_GET['host_id'])){

	$get_host_query = mysql_query("SELECT * FROM clubs WHERE id = '".$_GET['host_id']."'");
	$get_host_data = mysql_fetch_assoc($get_host_query);
	$userID = $_GET['host_id'];
	$UserTYPE = 'club';
}

if(empty($_SESSION['id']) || !isset($_SESSION['id']) || $_SESSION['id'] == "")
{
	$id=54;
	$_SESSION['id']=$id;
	$_SESSION['state']='3668';
	$_SESSION['country']='223';
}
/* TOP SEARCH CODE */
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
if(!isset($_GET['host_id']) && $_SESSION['user_type'] == "user")
{
	$plantype = $loggedin_user_data['plantype'];
	$profilename=$loggedin_user_data['profilename'];
	$user_address=$loggedin_user_data['user_address']; 
	$first_name=$loggedin_user_data['first_name']; 
	$last_name=$loggedin_user_data['last_name'];
	$fullname = $first_name." ".$last_name;
	$zipcode=$loggedin_user_data['zipcode'];
	$state=$loggedin_user_data['state'];
	$country=$loggedin_user_data['country'];
	if($loggedin_user_data['DOB']==''){$dob="00/00/0000";} else $dob=$loggedin_user_data['DOB'];
	$city=$loggedin_user_data['city'];
	$email=$loggedin_user_data['email'];
	$image_nm=$loggedin_user_data['image_nm'];
	$phone=$loggedin_user_data['phone'];
	$enablediablephone=$loggedin_user_data['text_status'];
}
if(!isset($_GET['host_id']) && $_SESSION['user_type'] == "club")
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
	//$_SESSION['username']=$profilename;
	//$_SESSION['id']=$club_city;
	//$_SESSION['state']=$state;
	//$_SESSION['country']=$country;
	if(isset($_SESSION['subuser']))
	{
		$q1 = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$loggedin_host_data['club_name']."'  ");
		$f1 = @mysql_fetch_array($q1);

	//	$_SESSION['img'] =  $f1['user_thumb'] ;
		
	}
	else
	{
		//$_SESSION['img'] =  $image_nm ;
	}
	$enablediablephone=$loggedin_host_data['text_status'];
	$profileCounter=$loggedin_host_data['profile_count'];  
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
	//$_SESSION['username']=$profilename;
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
	$profileCounter=$get_host_data['profile_count'];  
}


?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti.com ||<?php echo $titleofpage; ?></title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">

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

<script src="<?php echo $CloudURL; ?>js/custom.js"></script>
<script src="<?php echo $CloudURL; ?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CloudURL; ?>jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
<script type="text/javascript" src="<?php echo $CloudURL; ?>js/chat.js"></script>
<script src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>
<link rel="stylesheet" href="<?php echo $CloudURL;?>css/new_portal/smk-accordion.css" />
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

<!-- ======== Include Main Other Javascripts ===============  -->
<style>
.load_more_ex {
 background: transparent none repeat scroll 0 0;
 float: left;
 margin-bottom: 0;
 padding: 0;
 width: 100%;
}
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
</style>
</head>
<body>
<div class="slider_body">
  <ul>
	<li> <img src="images/v2_bgmain.jpg" alt=""> </li>
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
<div class="v2_banner_top h_auto spacer2">
  <div class="v2_header_wrapper v2_pos_rel">
	<div class="v2_top_nav2"><!-- v2_top_nav  starts-->
	  <div class="v2_header_top">
		<div class="v2_container">
		  <input type="button" class="menu_toggle" value="Menu" style="display:none;">
		  <div class="v2_nav v2_nav_host v2_nav2" style="max-width:100%">
			<ul>
			  <li> <a href="home_club.php"> <span data-title="Home">Home</span> </a> </li>
			  <li> <a href="searchEvents.php"> <span data-title="City Events">City Events</span> </a> </li>
			  <li> <a href="city_talk.php"> <span data-title="City Talk">City Talk</span> </a> </li>
			  <li> <a href="<?php echo $SiteURL; ?>mysitti_contestsList.php"> <span data-title="Contest">Contest</span> </a>
				<ul>
				  <!--<li><a href="<?php echo $SiteURL;?>live_host_contests.php">Live Contests</a></li>-->
				  <li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">Mysitti Contests</a></li>
				  <?php if($_SESSION['user_type'] == 'user'){ ?>
				  <li><a href="<?php echo $SiteURL;?>current_host_contests.php">Host Contests</a></li>
				  <?php } ?>
				</ul>
			  </li>
			  <li> <a href="<?php echo $SiteURL;?>live2/battle.php"> <span data-title="Live Battle">Live Battle</span> </a> </li>
			  <li>

				<a href="<?php echo $SiteURL;?>MySittiTV.php#tv">

					<span data-title="MySitti TV">MySitti TV</span>

				</a>

			</li>
			  <?php 
	if($_SESSION['user_type'] == 'club' && !isset($_SESSION['subuser']))
	{ 
?>
			  
			  <!--<li><a href="<?php echo $SiteURL; ?>shout.php"><span data-title="Shout">Shout</span></a></li>-->
			  
			  <?php 	}
	elseif($_SESSION['user_type'] == 'club' && isset($_SESSION['subuser']))
	{
?>
			  <li><a href="<?php echo $SiteURL; ?>music_request.php?host_id=<?php echo $_SESSION['user_id'];?>"><span data-title="Jukebox">Jukebox</span></a></li>
			  <!--<li><a href="<?php echo $SiteURL; ?>shout.php"><span data-title="Shout">Shout</span></a></li>-->
			  <?php 
	} 
	if($_SESSION['user_type'] == 'user'){ ?>
			  <li class="sh"><a href="<?php echo $SiteURL; ?>user_shout.php"><span data-title="Shouts">Shouts</span></a></li>
			  <li><a href="<?php echo $SiteURL; ?>all_hosts.php"><span data-title="Favorite">Favorite</span></a></li>
			  <?php } ?>
			</ul>
   	<div class="searchBoxTop" style="right:0">
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
			<div class="mobile_nav">
			  <?php if($_SESSION['user_type'] == 'club'){ ?>
			  <ul>
				<li><a href="<?php echo $SiteURL; ?>shout.php"><span data-title="Shout">Shout</span></a></li>
				<li><a href="<?php echo $SiteURL; ?>store.php"><span data-title="Store">Store</span></a></li>
				<li><a href="<?php echo $SiteURL; ?>eventscalendar.php"><span data-title="Calender">Calender</span></a></li>
			  </ul>
			  <?php } ?>
			  <?php if($_SESSION['user_type'] == 'user'){ ?>
			  <ul class="v2_login_nav">
				<li><a href="<?php echo $SiteURL; ?>user_shout.php"><span data-title="Shouts">Shouts</span></a></li>
				<li><a href="<?php echo $SiteURL; ?>all_hosts.php"><span data-title="Favorite">Favorite</span></a></li>
				<li><a href="<?php echo $SiteURL; ?>myCalendar.php"><span data-title="Calender">Calender</span></a></li>
			  </ul>
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
	<div class="v2_nav_profile nav_profile_host HosstHeader">
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
    <div class="clear"></div>
	  <div class="v2_container mobilecontainer">
	   <div class="v2_nav_profile  hidefordesktop">
		 
		  <input type="button" value="Menu" class="menu_toggle_sidebar profilehosttoggler">
	
		  <div class="v2_nav_right_mobi">
			
			
				<?php
				
include('image_upload_resize.php');
include("resize-class.php");
include("user_upgrade.php");
  	if(!isset($_SESSION['user_id']))
	{
		include('hotSpotsSidebar.php');
	}
	else
	{
	// die('kkkk');
		if(isset($_GET['host_id']) )
		{
			if($_SESSION['user_type'] == 'user')
			{
				include('host_left_panel.php');
			}
			elseif($_SESSION['user_type'] =="club" && $_GET['host_id'] == $_SESSION['user_id'])
			{
				include('club-right-panel-responsive.php');
			}
			elseif($_SESSION['user_type'] =="club" && $_GET['host_id'] != $_SESSION['user_id'])
			{
				include('host_left_panel.php');
			}
		}
		else if($_SESSION['user_type'] == 'user')
		{

			include('friend-right-panel-responsive.php');

		}
		elseif($_SESSION['user_type'] =="club" && $_GET['host_id'] == $_SESSION['user_id'])
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
		elseif($_SESSION['user_type'] =="club" && !isset($_GET['host_id']))
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
	}
	  
	  
	?>
			
			
		  </div>
	
	


		</div>
	  
		<?php
		if($_SESSION['user_type'] == 'club'){
			
		$banner_query =  mysql_query("SELECT `banner_name` FROM `host_banner` WHERE `user_id` = '".$userID."' AND user_type = 'club' AND `status` = '1'");
		$banner_query_result = mysql_fetch_assoc($banner_query);
		$countBanner = mysql_num_rows($banner_query);
		$banner = $banner_query_result['banner_name'];
		
		if($countBanner != 0) { ?>
		<style type="text/css">
			.v2_banner_top
			{
				background-image: url('host_banner/<?php echo $banner; ?>') !important;
			}
		</style>
		<?php } ?>
		<div class="uload_banner_header"> <a href="upload-banner.php"><img src="images/uploadbanner.png" alt="Upload" title="Upload Header Banner"></a> </div>
		<?php } ?>
		<ul class="fordesk">
		  <li> <a href="support.php"><span data-title="Help"> Help</span> </a> </li>
		  <li><a href="<?php echo $SiteURL; ?>main/logout.php"><span data-title="Logout">Logout</span></a></li>
		</ul>
		<div class="v2_login login_profile">
		  <div class="v2_filter_box " id="topCitySearch"> 
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
										//echo "<pre>"; print_r($encoded_list);echo "</pre>";
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
		<div class="hide_menu_desktop">
		  <?php if($_SESSION['user_type'] == 'club'){ ?>
		  <ul>
			<li><a href="<?php echo $SiteURL; ?>shout.php"><span data-title="Shout">Shout</span></a></li>
			<li><a href="<?php echo $SiteURL; ?>store.php"><span data-title="Store">Store</span></a></li>
			<li><a href="<?php echo $SiteURL; ?>eventscalendar.php"><span data-title="Calender">Calender</span></a></li>
		  </ul>
		  <?php } ?>
		  <?php if($_SESSION['user_type'] == 'user'){ ?>
		  <ul class="v2_login_nav">
			<li><a href="<?php echo $SiteURL; ?>user_shout.php"><span data-title="Shouts">Shouts</span></a></li>
			<li><a href="<?php echo $SiteURL; ?>all_hosts.php"><span data-title="Favorite">Favorite</span></a></li>
			<li><a href="<?php echo $SiteURL; ?>myCalendar.php"><span data-title="Calender">Calender</span></a></li>
		  </ul>
		  <?php } ?>
		</div>
		<div class="v2notification notify_hostside fordesknotification">
		  <?php
						include('notifications.php'); ?>
		</div>
		<div class="clear"></div>
		<?php
/*include('image_upload_resize.php');
include("resize-class.php");
include("user_upgrade.php");*/
?>
		<div class="v2_mobile_menu_sidebar">
		  <div class="v2_live_control" style="display:none;">
			<div class="v2_webcambutton"> <a onclick="gotoLive('live2/live_broadcast.php?username=MidNight&amp;clubID=7');" class="button" href="javascript:void(0);">Go Live</a> </div>
			<div class="v2_live_stresm_go"> <a onclick="goto1('live2/channel.php?n=MidNight&amp;host_id=7&amp;user_type=user')" name="submit" class="button">Live Streaming <span class="stats_icon"><img title="Offline" alt="Offline" style="width:15px; height:15px;" src="images/offline_u.png?t=1436780642"></span> </a> </div>
		  </div>
		</div>
	  </div>
	</div>
	<?php
	
if(!empty($profilename))
{
	$pieces = explode(" ", $profilename);
	$username_dash_separated = implode("-", $pieces);
	$n = clean($username_dash_separated);

}
?>
	<!-- v2_top_nav  ends-->
	<div class="v2_container">
	  <div class="v2_nav_profile  profile_header hidefordesktop">
	   
		<div class="v2_filter_box newfilter" id="topCitySearch"> 
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
										//echo "<pre>"; print_r($encoded_list);echo "</pre>";
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
	  <div class="v2_brand brand_host_inner space50"> <a href="index.php"> <img src="images/v2_logo_round.png" alt="" />
		<div class="clear"></div>
		<span  id="searchArea">Making Every City Your City</span> </a> </div>
	  <div class="clear"></div>
	  <div class="v2_search_area" id="search_Events">
		<h1>FIND YOUR NEXT EXPERIENCE</h1>
		<div class="clear"></div>
		<div class="v2_search-area">
		  <form method="POST" action="searchEvents.php" style="float: left; width:100% !important;">
			<?php 

				if(isset($_POST['ssss']))
				{	
					if(!empty($_POST['keyword_search']) )
					{
						$EVENTNAME = $_POST['keyword_search'];
						//$condition = " AND forum = '$eventname' AND event_category IN (1,2,3,4,5,6,7,8,9,14,15,16,17,18,19,20,21) ";	
						$default = "none";
					}
					else
					{
						// echo "<pre>"; print_r($_POST); exit;
						$EVENTNAME = "";
						$EVENTCAT = $_POST['eventcat'];
						//$condition = " AND event_category = '$event_category' ";
						if(!empty($_POST['date_s']) )
						{
							$EVENTDATE = $_POST['date_s'];
							// $event_date = date('Y-m-d H:i:s',$event_date);	
							//$condition .= " AND event_date LIKE '%$event_date%' ";
						}
					}
				}
							?>
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
	</div>
	<!-- profilebar-2 with center aligned profile pic -->
	<div class="v2_profile2_wrapper spacer1">
	  <div class="v2_profile_inner v2_gutter50">
		<div class="v2_container">
		  <div class="v2_profile2_left">
			<h1 class="name_pro_fight"><?php echo $club_name; ?></h1>
			<div class="clear"></div>
			<div class="counter"> <span class="views">Viewers: </span>
			  <div class="total"><?php echo $profileCounter; ?> </div>
			</div>
		  </div>
		  <div id="tv" class="v2_profile2_pic_container">
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
			  <a href="<?php if(isset($_GET['host_id']) && $_SESSION['user_type'] == 'user'){ echo $SiteURL."host_profile.php?host_id=".$_GET['host_id'];}elseif($_SESSION['user_type'] == 'club'){ echo $SiteURL."home_club.php";} ?>"> <img align="" src="<?php echo $imgSRC; ?>"> </a> </div>
		  </div>
		  <div class="v2_profile2_right">
			<div class="v2_addresbox_pro2">
			  <?php 
						if(!empty($web_url))
						{
					?>
			  <a  target="blank" href="<?php echo $web_url; ?>"><?php echo $web_url; ?></a>
			  <?php 	} 	?>
			</div>
			<div class="clear"></div>
			<div class="v2_alocation_pro2"> <span class="clubAddress">
			  <?php 
							if(!empty($club_address) && $loggedin_host_data['hideaddress'] == '0' )
							{
								echo $club_address;
							}
						?>
			  </span> <a href="javascript:void(0);" onclick="goto('view-map.php?add=<?php echo $userID; ?>');"> <img align="" src="images/fight_location_icon.png"> </a> </div>
			<div class="clear"></div>
		  </div>
		  <div class="clear"></div>
		</div>
	  </div>
	</div>
	<!-- end profilebar 2 -->
	
	<?php if(isset($_SESSION['user_id'])){ ?>
	<?php } ?>
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

// error_reporting(0);

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
/*include('image_upload_resize.php');

include("resize-class.php");
include("user_upgrade.php");*/
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
		$('#Search_box_filter').hide().before('<a href="#" id="toggle-menu" class="v2_filter_menu  host_filter"><?php echo $dropdown_city; ?>, <?php echo $dropdown_state; ?><img src="images/menu.png" alt="Menu" /></a>');
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


/*--------------------------------------------------------------------------------*/
?>
<!-- END BACKGROUND CODE -->
<?php /*if($_SESSION['user_type'] == 'club'){ ?>

<div class="uload_banner_bg">
	<a href="host-background.php"><img title="Upload Header Banner" alt="Upload" src="https://mysitti.com/images/uploadbanner.png"></a>
</div>

<?php } */?>
<script type="text/javascript">
	$(document).ready(function(){
		refreshCaptcha('<?php echo $SiteURL; ?>');
	});
</script>