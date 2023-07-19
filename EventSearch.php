<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Search Events";

if(isset($_GET['cityId'])){
	$_SESSION['id'] = $_GET['cityId'];
}
else{
	$_SESSION['id'] = $_SESSION['id'];
}


if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('Header.php');	
}


	

if(isset($_SESSION['user_id']))

{

	$sql_city_id = mysql_query("select * from  clubs where id='".$_SESSION['user_id']."'");

	$city_id2 = mysql_fetch_assoc($sql_city_id);

}

else

{

	$city_id2 = array();

	$city_id2['zipcode']='38125';

}

if(isset($_SESSION['clubs_filter']))

{

	$club_filter=$_SESSION['clubs_filter'];

	unset($_SESSION['clubs_filter']);

	$cnd=" parrent_id='0' AND  id IN(".$club_filter.")";

}else

{

	$cnd=" parrent_id='0'";

}

if($_SESSION['miles'])

{

	$miles_filter=$_SESSION['miles'];

	unset($_SESSION['miles']);

}



$sql_main_club=mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC");


// ini_set("display_errors", "1");
// error_reporting(E_ALL);

// echo "<pre>"; print_r($_SESSION); exit;

if(isset($_GET['code']) && isset($_GET['state']))
{
	$_SESSION['FBRLH_state'] = $_GET['state'];
}

require_once("admin/paging.php");

// include required files form Facebook SDK
require_once 'FacebookV5/autoload.php';
$fb = new Facebook\Facebook([
	'app_id' => '1027910397223837',
	'app_secret' => '00175be1ff4053b4cb22bca7b51b947a',
	'default_graph_version' => 'v2.6',
]);


$permissions = ['email', 'user_posts','publish_actions']; // optional
$redirect_url = $SiteURL.'searchEvents.php';
$callback = $SiteURL.'searchEvents.php';
$helperNew = $fb->getRedirectLoginHelper();
if(!isset($_SESSION['facebook_access_token']))
{
	
	$accessToken = $helperNew->getAccessToken();
}
elseif(isset($_SESSION['facebook_access_token']) && empty($_SESSION['facebook_access_token']))
{

	$accessToken = $helperNew->getAccessToken();
}
else
{
	$accessToken = $_SESSION['facebook_access_token'];
}
if (isset($accessToken) && !empty($accessToken)) 
{
	// User authenticated your app!
	// Save the access token to a session and redirect
	$_SESSION['facebook_access_token'] = (string) $accessToken;
    $_SESSION['fb_token'] = $accessToken;
	// Log them into your web framework here . . .
	// Redirect here . . .
	$response = $fb->get('/me', $accessToken);
	$graphNode = $response->getGraphNode();

	// Get the response typed as a GraphUser
	$user = $response->getGraphUser();

	// Get the response typed as a GraphPage
	$page = $response->getGraphPage();

	$helperLogout = $fb->getRedirectLoginHelper();
	$logoutUrl = $helperLogout->getLogoutUrl();
// echo "</pre>"; print_r($user); exit;
}


?>
<script language="javascript">



function goto(url)

{

	window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=200,top=200');

	return false;

}

function goto1(url)

{

	window.open(url,'1396358792239','width=900,height=600,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=200,top=0');

	return false;

}

function changecity()

{

	var val=$('#city_name').val();

	$.get('set-session.php?city_id='+val, function(data) {

		window.location='searchEvents.php';

	});

}



</script>
<link rel="stylesheet" href="../css/new_portal/smk-accordion.css" />
<script type="text/javascript" src="js/new_portal/smk-accordion.js"></script>
<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');



  ga('create', 'UA-45982925-1', 'mysitti.com');

  ga('send', 'pageview');



</script>
<style type="text/css">
.custom_slide .live_stream_new {
 bottom: 24px;
}
.custom_slide .live_stream_new a {
 background-color: #000;
}
.custom_slide .live_stream_new a:hover {
 background-color: #fecd07;
 color: #000;
}
.custom_slide .live_stream_new a span.stats_icon {
 margin: 0;
}
.common_box
{
	padding-top: 0px;
}
</style>
<script type="text/javascript">

	$(document).ready( function() {

		$('html, body').animate({

			scrollTop: $(".localBusiness").offset().top - 40

		}, 1000);

	});

</script>
<div class="localBusiness">
	<div class="v2_content_wrapper">
		<h1>Local</h1>
		<div class="hotLinks">
  <div class="hotLinksInner">
		<?php 
			// GET ALL PARENT CATEGORIES
			$getAllparentcats = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '0' LIMIT 0,10  ");
			while($resultcats = mysql_fetch_assoc($getAllparentcats))
			{
		?>		<a class="" href="<?php echo $SiteURL;?>advanced_filters.php?cat_id=<?php echo $resultcats['id'];?>"><?php echo $resultcats['name'];?></a>
		<?php 	}	?>
		</div>
  </div>

 <a class="fullListView line-height" href="<?php echo $SiteURL;?>advanced_filters.php?cat_id=1">Full List <img src="images/arrows.png" alt="" /></a>
 	</div>
</div>
<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="topSilder"  style="display:none;">
  			<div class="fullblack">
				<div class="img_slider_btm">
	  				<div class=" ">			
	  				</div>
				</div>
  			</div>
		</div><!-- END topSilder -->
<?php
 // echo "<pre>"; print_r($_POST); echo "</pre>";exit;
				$d_category = "9";

				$fetchEventCategoryName['catname'] = 'Nightlife';

				$Heading = '';

				$condition = " AND event_category = '9' ";

				$eventname = "";

				$eventimage = "9.jpg";

				$default = "";

				$searchSQL = '';

				if(isset($_POST['ssss']))

				{

 // echo "<pre>"; print_r($_POST);echo "</pre>";

					if(!empty($_POST['keyword_search']) && empty($_POST['eventcat']))
					{

						//$eventSearchSql = mysql_query('SELECT * FROM `forum` WHERE `forum` LIKE "%'.$_POST['keyword_search'].'%"  GROUP BY `forum`, `event_date`  ORDER BY `forum` DESC,`event_date` ');
						$myCondition = " `forum` LIKE '%$_POST[keyword_search]%' ";
						$Heading = 'Search Results';

					}
					elseif(!empty($_POST['keyword_search']) && !empty($_POST['eventcat']))
					{
						$event_category = $_POST['eventcat'];
						//$eventSearchSql = mysql_query('SELECT * FROM `forum` WHERE `forum` LIKE "%'.$_POST['keyword_search'].'%" AND `event_category` = '.$event_category.' GROUP BY `forum`, `event_date`  ORDER BY `forum` DESC,`event_date` ');
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

							// $event_date = date('Y-m-d H:i:s',$event_date);	
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

							// $event_date = date('Y-m-d H:i:s',$event_date);	
							$myCondition = " event_date LIKE '%$event_date%' ";
							$condition .= " AND event_date LIKE '%$event_date%' ";

						}
					}
					//echo 'SELECT * FROM `forum` WHERE '.$myCondition.' AND `city_id` = "'.$_SESSION['id'].'" GROUP BY `forum`, `event_date`  ORDER BY `forum` DESC,`event_date` '; die; 
					$eventSearchSql = mysql_query('SELECT * FROM `forum` WHERE '.$myCondition.' GROUP BY `forum`, `event_date`  ORDER BY `forum` DESC,`event_date` ');
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
				elseif(isset($_POST['fromdate']) || isset($_POST['todate']) || isset($_POST['querystring'])){
					//echo "<pre>"; print_r($_POST); die;
					$con = '';
					if(!empty($_POST['fromdate']) && empty($_POST['todate'])){
						$fromDate = str_replace("/", "-", $_POST['fromdate']);
						$con .= " `event_date` > '".$fromDate."'  ";
					}
					if(!empty($_POST['todate']) && empty($_POST['fromdate'])){
						$toDate = str_replace("/", "-", $_POST['todate']);
						$con .= " `event_date` < '".$toDate."'  ";
					}
					if(!empty($_POST['todate']) && !empty($_POST['fromdate'])){
						$fromDate = str_replace("/", "-", $_POST['fromdate']);
						$toDate = str_replace("/", "-", $_POST['todate']);
						$con .= " `event_date` BETWEEN '$fromDate' AND '$toDate'  ";
					}
					if(!empty($_POST['querystring'])){
						$querystring = $_POST['querystring'];
						if(empty($con)){
							$con .= " `forum` LIKE '%$querystring%' ";
						}
						else{
							$con .= " AND `forum` LIKE '%$querystring%' ";	
						}
						
					}
					
					if(empty($con)){
						$con .= "  event_date >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY) ";
					}
					
					$eventSearchSql = mysql_query("SELECT * FROM `forum` WHERE ".$con." AND `city_id` = '$_SESSION[id]' GROUP BY `forum`.`user_id`, `event_date`  ORDER BY `forum` DESC,`event_date` ");
					$EventCatSQL = "SELECT * FROM `forum` WHERE ".$con." AND `city_id` = '$_SESSION[id]' GROUP BY `forum`, `event_date`  ORDER BY `forum`.`user_id` DESC,`event_date` ";
					$eventimage = $event_category.".jpg";
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
	<div class="v2_content_inner2">
   		<aside class="sidebar v2_sidebar sidebarEvents" style="position:relative;"> 
   		<?php 
			if($countContest > 0)
			{
		?>
      		<div class="register_fortalent_sidebar">
      			<a href="<?php echo $SiteURL;?>mysitti_contestsList.php">
      				<img src="images/register_for_talent.gif" alt="">
  				</a>
  			</div>
  	<?php 	}	?>
   			<div id="NewSidebar">
        
   				<h1><?php echo $dropdown_city; ?>'s Talents</h1>
       				<img src="images/corner2-sidebar.png" alt="" />
   				<div class="clear"></div>
   				<div class="ItemBox itemTitle">
          					<a style="margin-right:0px;" class="fullListView All-atlanta" href="<?php echo $SiteURL;?>artistDetailsBrowsePage.php">View All Talents </a>
          				</div>
   				<div class="ItemBox">
   					<h2>Faces of <?php echo $dropdown_city.", ".$dropdown_state; ?></h2>
   						<a href="<?php echo $SiteURL;?>artistDetailsPage.php?type=usersList">
   							<img src="images/populars_img.png" alt="" />
						</a>
   					</div>
 					<div class="ItemBox">
   						<h2>Bands</h2>
   						<a href="<?php echo $SiteURL;?>artistDetailsPage.php?type=hosts&category=Band">
   							<img src="images/bands_img.png" alt="" />
						</a>
   					</div>
   					<div class="ItemBox">
   						<h2>Singers</h2>
						<a href="<?php echo $SiteURL;?>artistDetailsPage.php?type=hosts&category=Singer">
							<img src="images/singers.png" alt="" />
						</a>
   					</div>
   					<div class="ItemBox">
   						<h2>Night Club</h2>
   						<a href="<?php echo $SiteURL;?>artistDetailsPage.php?type=hosts&category=Clubs">
   							<img src="images/nightclub_img.png" alt="" />
   						</a>
   					</div> 
					<div class="ItemBox">
   						<h2>Comedy Club</h2>
						<a href="<?php echo $SiteURL;?>artistDetailsPage.php?type=hosts&category=Comedy Club">
							<img src="images/comedyclub_img.png" alt="" />
						</a>
   					</div>
        					<div class="ItemBox">
   						<h2>DJ'S</h2>
						<a href="<?php echo $SiteURL;?>artistDetailsPage.php?type=hosts&category=Djs">
							<img src="images/djs.png" alt="" />
						</a>
   					</div>
        					
			</div>
   		</aside>
		<article class="forum_content v2_contentbar newSectionEvents">
  			<div class="NewSerachFilter">
  				<h2>Upcoming Events</h2>
  				<div class="clear"></div>
  				<div class="v2_search-area">
					<form style="float: left; width:100% !important;" action="searchEvents.php" method="POST">
						<div class="v2_date v2_input_search">
							<input type="text" value="<?php if(isset($_POST['date_s'])){ echo $_POST['date_s'];}else{ echo ""; } ?>" placeholder="Select Date" value="" id="datetimepicker_search" class="onlyDate" name="date_s">
			  			</div>
						<div class="v2_cat">
							<select name="eventcat" id="eventcatselect">
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
							<input type="text" placeholder="Search" value="<?php if(isset($_POST['keyword_search']) && !empty($_POST['keyword_search'])){ echo $_POST['keyword_search'];}else{ echo '';} ?>" name="keyword_search" id="eventsearch">
			  			</div>
						<div class="v2_btn-search">
							<input type="submit" name="ssss" value="Search">
			  			</div>
						<div class="clear"></div>
			  		</form>
					<div class="clear"></div>
		  		</div>
  			</div> <!-- END NewSerachFilter-->
			<h3 id="title">
	  			<?php if(!empty($Heading)){ echo $Heading; }else{ echo "Local ".$fetchEventCategoryName['catname']." Events";} ?>
			</h3>
			<script type="text/javascript">

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

			</script>
	<?php
// echo mysql_num_rows($eventSearchSql); die;
if(mysql_num_rows($eventSearchSql) > 0)

{
	?>
	<!-- <div class="v2_blog_post"> -->
	  <?php 

				if(mysql_num_rows($eventSearchSql) > 0)
				{
					
					$EventCatSQLExec = mysql_query($EventCatSQL);

					while($row = mysql_fetch_assoc($EventCatSQLExec) )	

					{

						$displayName = $row['forum'];

						$displayPic = $row['image_thumb'];

						

						$eventimage = $row['event_category'].".jpg";

						if($row['user_type'] == "club")
						{

							

							$selecthostquery = mysql_query('SELECT * FROM `clubs` WHERE id = "'.$row['user_id'].'" ');

							$reshostquery = mysql_fetch_array($selecthostquery);

							$postername = $reshostquery['club_name'];

							$imagesrc = $reshostquery['image_nm'];

							$club_id = $reshostquery['id'];

							$islaunch = $reshostquery['is_launch'];
							$streamingLaunch = $reshostquery['streamingLaunch'];

							if($_SESSION['user_type'] == "user"){



								$host_details=mysql_query("select status from  friends where friend_id='".$club_id."' AND user_id='".$_SESSION['user_id']."' AND friend_type='club'");

								$club_dtl=mysql_fetch_assoc($host_details); 				

								

							}	

							if($imagesrc =="")

							{

								$imagesrc = "images/man1.jpg";

							}

							else

							{ 

								$imagesrc = $imagesrc ;

							

							}

						  

						}
						else
						{
	
							$postername = $row['first_name']." ".$row['last_name'];
							$streamingLaunch = $row['streamingLaunch'];

							if($row['image_nm']=="")

							{

								$imagesrc = $SiteURL."images/man1.jpg";

							}

							else

							{ 

								$imagesrc = $SiteURL.$row['image_nm'];

							

							}   

						}

						if($row['from_user'] != '0')

						{

							//echo "SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ";

							$getusersql = mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ");

							$fetchusersql = mysql_fetch_array($getusersql);

							//echo "<pre>"; print_r($fetchusersql); die;
							$streamingLaunch = $fetchusersql['streamingLaunch'];

							$imagesrc = $SiteURL.$fetchusersql['image_nm'];

							$postername = $fetchusersql['first_name']." ".$fetchusersql['last_name'];

						}



					   ?>
	  <div class="v2_blog_post">
		<?php

							   if(!preg_match("/(bad|naughty|Dick|dick|Penis|penis|Vagina|vagina|Anal|anal)/i", $row['forum'])){

							   ?>
		<div class="v2_blogpost_user">
		  <div class="pic"> <a href="<?php echo $SiteURL; ?><?php if(isset($_SESSION['user_id'])){ ?>host_profile.php?host_id=<?php echo $club_id;  }else{ echo $postername; }?>">
			<?php        

											 if($row['user_id'] == '0')

											 {

													$style = " ";

											 }

											 else

											 {

													echo '<img src="'.$imagesrc.'" />';

													echo $postername;

													$style= "";

											 }





											?>
			</a>
			<div class="followdbtn">
			  <?php if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == "user" && $row['user_id'] != 0) { ?>
			  <a style="display: none;" id="block" href="javascript:void(0)" class="button follow_hostc block">Followed</a>
			  <?php if($club_dtl['status']=='active') { ?>
			  <a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a>
			  <?php }else if($club_dtl['status']=='block') { ?>
			  <a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a>
			  <?php }else {  ?>
			  <input type="submit" id="request" class="button follow_hostc" value="Follow Host" name="submit" onclick="savehost('<?php echo $club_id;?>','request')">
			  <?php } }?>
			</div>
			<div class="followdbtn align-left">
			  <?php 

				$pieces = explode(" ", $postername);

				$username_dash_separated = implode("-", $pieces);

				$username_dash_separated = clean($username_dash_separated);

				if(isset($_SESSION['user_id']) && $row['user_id'] != 0 && $streamingLaunch == '1'){ ?>
			  	<a class="" name="submit"  href="<?php echo $SiteURL; ?>host_profile.php?host_id=<?php echo $club_id;?>">
			  		<span class="stats_icon" style="width:100%; text-align: center;" >
			  			<img src="<?php if($streamingLaunch == '1'){ echo 'images/view-web-cam-green.png';}else{ echo 'images/view-web-cam-black.png';} ?>" title="<?php if($streamingLaunch == '1'){ echo "Online";}else{ echo "Offline";}?>" style="max-width:35px;"  />
			  		</span>			  
			  	</a>
			  <?php  } ?>
			</div>
		  </div>
		</div>
		<div class="v2_post_container">
		  <div  id="forumcontent">
			<?php $share_img=''; 

					if($row["forum_img"]!="" || $row["forum_img"] =="") 

					{

			

						



						if($row['user_id'] == "0")

						{

							$fullImage = $row['forum_img'];

							$thumbImage = $row['image_thumb'];
							$eid = $row['forum_id'];

						}

						else

						{

							$fullImage = $SiteURL.str_replace("../", "", $row["forum_img"]);

							$thumbImage = $SiteURL.str_replace("../", "", $row["image_thumb"]);

							$eid = $row['event_id']."&action=event";

						}

			

									

								   

								if(empty($fullImage))

								{

													

									$fullImage = $SiteURL."events_icons/".$eventimage;

													?>
			<a href="javascript:void(0);" rel="group" class="" onClick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $eid; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"> 
				<img  <?php echo $style; ?> src="<?php echo $SiteURL; ?>events_icons/<?php echo $eventimage;?>" alt=""  /> 
			</a>
			<?php 



												}

												else

												{





												?>
			<!-- <a href="<?php echo $fullImage; ?>" rel="group" class="fancybox">  -->
			<a href="javascript:void(0);" rel="group" class="" onClick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $eid; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"> 
			
				<img  <?php echo $style; ?> src="<?php echo $thumbImage; ?>" alt=""  /> 
			</a>
			<?php }   $share_img=$fullImage; } ?>
			
			<!--<br /><br />-->
			
			<?php if($row["forum_video"]!="") { ?>
			<a href="#dialogx" name="modal">
			<?php //echo substr($row["forum_video"],3);?>
			<div id="a<?php echo $row["forum_id"];?>" onmouseover="jwplayer().play();" onmouseout="jwplayer().pause();"></div>
			<script type="text/javascript">

													 jwplayer("a<?php echo $row["forum_id"];?>").setup({

														file: "<?php echo $SiteURL.substr($row["forum_video"],3);?>",

														//file: "Video.MOV",

														height : 140 ,

														width: 200

														});

													</script> 
			</a>
			<?php $share_img=$SiteURL.$row["forum_video"]; } ?>
		  </div>
		  <div class="comment_box commentdisplay">
			<div class="box2 socialbox">
			  <div class="v2_share_on">
				<?php  if($row["user_id"]=='0'){ $shareurl=$share_img;}else{ $shareurl=$fullImage;} ?>
				<ul class="shareit">
					<li>
				  	<?php
				  		if(isset($_SESSION['facebook_access_token']) && !empty($_SESSION['facebook_access_token']) )
						{
						?>
		  
							<a rel="nofollow" href="javascript:void(0);" class="fb_share_button"  onclick="shareFBpost('<?php echo $row["forum_id"];?>');" style="text-decoration:none;"> 
								<img src="<?php echo $SiteURL; ?>images/fbook.png" alt="Share on Facebook"/> 
							</a>
						
						<?php
						  
						} 
						else
						{
							
							$helperLogin = $fb->getRedirectLoginHelper();
							$loginUrl = $helperLogin->getLoginUrl($callback, $permissions);

						 ?>
						 	<a rel="nofollow" href="<?php echo $loginUrl; ?>" class="fb_share_button" target="_blank" style="text-decoration:none;"> 
						 		<img src="<?php echo $SiteURL; ?>images/fbook.png" alt="Share on Facebook"/> 
						 	</a>
						<?php } 
		?>   		</li>
				  	<li> <a href="#" onclick="return fbs_click123('<?php echo $shareurl;?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter"> <img src="<?php echo $SiteURL; ?>images/twt.png" alt="Share on Twitter"/> </a> </li>
				  	<li> <a href="https://plus.google.com/share?url=<?php echo $shareurl;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"> <img src="<?php echo $SiteURL; ?>images/g+.png" alt="Share on Google+"/> </a> </li>
					<?php 
					if(isset($_SESSION['user_id']))
					{
					?>
					<li> 
						<a href='javascript:void(0);'> 
							<img src="<?php echo $SiteURL; ?>images/share_pst.png" alt="Share Post"/> 
						</a>
						<ul>
							<li> <a href="javascript:void(0);" onclick="sharepostPublic('<?php echo $row['forum_id'];?>');">Public</a> </li>
							<li> <a href="javascript:void(0);" onclick="sharepostPrivate('<?php echo $row['forum_id'];?>');">Friends List</a> </li>
						</ul>
					</li>
				  <?php }	?>
				</ul>
				</li>
				</ul>
			  </div>
			</div>
		  </div>
		</div>
		<div class="v2_post_info">
		  <h1> 
			
			<!--Added on 15.12.2014-->
			
			<?php 

										

												if($row['forum'] == "")

												{

													

						$getforumtitlequery = mysql_query('SELECT * FROM contest WHERE contest_id = "'.$row['contest_id'].'" ');

													$getarray = mysql_fetch_array($getforumtitlequery);

													if($getarray['host_id'] == "0")

													{

														

														echo "<p> mySitti's ".$getarray['contest_title']." contest</p>";

													}

													else

													{

														

						$gethostnamequery = mysql_query('SELECT * FROM clubs WHERE id = "'.$getarray['host_id'].'" ');

														$gethostarray = mysql_fetch_array($gethostnamequery);

									 echo "<p>".$gethostarray['club_name']." ".$getarray['contest_title']." contest</p>";

													}

													

												}

												else

												{

													echo "<p>".$row['forum']."</p>";

												}



										?>
			
			<!--//Added on 15.12.2014--> 
			
		  </h1>
		  <div class="event-date">
			<?php 

														



											   echo date('F j, Y l g:i A',strtotime($row['event_date'])); ?>
		  </div>
		  <div class="location"> <span class="post_address"> <?php echo $row['event_address']; ?> </span> <span class="post_map"> <a target="_blank" title="" class="map"  onclick="goto('<?php echo $SiteURL; ?>eventmap.php?add=<?php echo $row['forum_id'];?>');">Map</a> </span>
			<div style="clear:both"></div>
		  </div>
		  <p class="discription">
			<?php 

									$des = strip_tags($row['description']);







								$des = str_replace('www.', ' www.', $des);

												echo substr($des,0,200); ?>
			<?php

									if($row['user_id'] == '0')

									{

										$eid = $row['forum_id'];

									}

									else

									{

										$eid = $row['event_id']."&action=event";

									}

									if(strlen($des) >= 200)

									{

									?>
			<a onClick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $eid; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"  >Read More...</a> </p>
		  <?php

									}

									if($_SESSION['user_type'] == 'user')

									{   

										$checkuserevent = mysql_query("SELECT `id` FROM `user_events` WHERE `uid` = $_SESSION[user_id] AND `forum_id` = '$row[forum_id]' ");

										$countevent = mysql_num_rows($checkuserevent);

										if($countevent < 1)

										{

										?>
		  <div class="box2 addtoMyCalendar" id="add_to_calendar_<?php echo $row['forum_id']; ?>"> <a href="javascript:void(0);"  id="event_to_calendar" onclick="addToCalendar('<?php echo $row['forum_id']; ?>');"><img src="images/addtoCalendar.png" title="Add to your Calendar" alt="Add to your Calendar"></a> </div>
		  <?php }

										else

										{

											?>
		  <div class="box2 addtoMyCalendar" id="add_to_calendar_<?php echo $row['forum_id']; ?>"> <span style='color:rgb(254, 205, 7);'>Event Already Added to your Calendar!</span> </div>
		  <?php 

										}

									

									}

									?>
		</div>
		<?php } ?>
		<div class="clear"></div>
		<?php 

				//if(isset($_SESSION['user_id']))

				//{

			?>
		<div class="ShowTicket Eventicket">
		  <?php 

					$check_ticket = mysql_Query("SELECT * FROM streaming_tickets WHERE event_id = '".$row['event_id']."'");

					$count_ticket_check = mysql_num_rows($check_ticket);

					/* PAID PASSES QUERY */

					$getPaidpass = mysql_query("SELECT * FROM `paid_passes` WHERE `event_id` = '$row[event_id]' ");

					$fetchRecords = mysql_fetch_assoc($getPaidpass);

					$countPaidpasses = $fetchRecords['no_of_tickets'];

					$currDate = strtotime(date('Y-m-d H:i:s'));

					$expiryPass = strtotime($fetchRecords['expiry_date']);

					if($count_ticket_check == "1" || $countPaidpasses > 0)

					{

				?>
		  <div class="clear"></div>
		  <?php

						if($countPaidpasses > 0 && $fetchRecords['pass_status'] == "active" && ( $expiryPass > $currDate) )

						{

							$HostID = $row['user_id'];

							$get_str_host_email = mysql_query("SELECT `merchant_id` FROM `clubs` WHERE `id` = '$HostID' ");

							$count_email = mysql_num_rows($get_str_host_email);

							

							if($count_email < 1){

								

								$host_email = "";

								

							}else{

								

								$set_host_email = mysql_fetch_assoc($get_str_host_email);

								$host_email = $set_host_email['merchant_id'];
								
							}

							

							$hide_btn = "style='display: none;'";

							$payment_amount =  trim(str_replace("$",'',$fetchRecords['amount']));

							$host_email_set = $host_email;

							$item_name = "Buy Ticket";
							
										
									if(isset($_SESSION['user_id'])){ ?>
		  <a  class="buyshowtickets"  href="<?php echo $SiteURL; ?>buyStageTicket.php?host_id=<?php echo $row['user_id'].'&str_amt='.$payment_amount.'&user_type='.$_SESSION['user_type'].'&passid='.$fetchRecords['pass_id'].'&event_id='.$row['event_id']; ?>">
		  <?php }else{
										
										if(!empty($_SERVER['QUERY_STRING'])){
											
											$Search_events_redirect = $SiteURL."searchEvents.php?".$_SERVER['QUERY_STRING'];		
											
										}else{
											
											$Search_events_redirect = $SiteURL."searchEvents.php";		
											
										}
										?>
		  <a class="buyshowtickets" href="<?php echo $Search_events_redirect; ?>" onclick="openLoginpop($(this).prop('href')); return false;">
		  <?php } ?>
		  Show Ticket </a>
		  <?php



						}



						/**** check streaming ticket exists ****/



						if($count_ticket_check == 1)

						{

							

							$get_ticket_id = mysql_fetch_assoc($check_ticket);

							$ticket_id = $get_ticket_id['ticket_id'];

							$check_user_purchased_ticket = mysql_query("SELECT * FROM streaming_tickets_purchased WHERE ticket_id = '".$ticket_id."' AND buyer_user_id = '".$_SESSION['user_id']."' AND buyer_user_type = '".$_SESSION['user_type']."' AND event_id = '".$row['event_id']."'");

							$count_downloaded_ticket = mysql_num_rows($check_user_purchased_ticket);

							

							if($count_downloaded_ticket < 1)

							{

								if(isset($_SESSION['user_id'])){ ?>
		  <a class="buysttickets" href="OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php echo $row['user_id']; ?>&user_type=club&ticket_id=<?php echo $ticket_id; ?>&event_id=<?php echo $row['event_id']; ?>">
		  <?php }else{
									
									if(!empty($_SERVER['QUERY_STRING'])){
										
										$Search_events_redirect = $SiteURL."searchEvents.php?".$_SERVER['QUERY_STRING'];		
										
									}else{
										
										$Search_events_redirect = $SiteURL."searchEvents.php";		
										
									}
									?>
		  <a class="buysttickets" href="<?php echo $Search_events_redirect; ?>" onclick="openLoginpop($(this).prop('href')); return false;">
		  <?php } ?>
		  Streaming Ticket </a>
		  <?php

							}

							else

							{ ?>
		  <span class="avail">Already Purchased Ticket</span>
		  <?php }

						}

						/**** check ticket exists ****/

					}

						?>
		</div>
		<?php 	//}	?>
	  </div>
	  <?php 


					}

					

				}

			?>
	<!-- </div> -->
	<?php

	
}
elseif(mysql_num_rows($eventSearchSql) == 0 && isset($_POST['ssss']))
{
	?>
		<div class="v2_blog_post">
			<h2 class="NoEvents"> No Events Found</h2>
		</div>
	<?php
}
else

{ 
	// die('21');

	$sql = "select forum.event_category,forum.forum, forum.event_id ,forum.event_date,forum.description,forum.event_address,forum.image_thumb,forum.from_user,forum.contest_id,forum.user_type,forum.user_id,forum.forum_id, forum.forum_img,forum.forum_video,forum.status from forum as forum

	where forum.status ='1'  AND `forum`.`city_id`='".$_SESSION['id']."'  AND `forum`.`post_from` = 'city_forum' ".$condition." GROUP BY forum.forum, forum.event_date  ORDER BY `forum`.`user_id` DESC,`forum`.`event_date` ";

	$sql1 = mysql_query($sql);

	$count = mysql_num_rows($sql1);





	if($count < 1)

	{

		/*CALCULATE DISTANCE TO GET NEAR BY CITIES  */

		$cityID = $_SESSION['id'];

		$ccid = mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$cityID' ");

		$ccidfetch = mysql_fetch_array($ccid);

		$cclong = $ccidfetch['lng'];

		$cclat = $ccidfetch['lat'];



		$stateId = $_SESSION['state'];

		$distancesArray = array();
// echo "SELECT * FROM `capital_city` WHERE `state_id` = '$stateId' AND `city_id` != '$cityID' "; die;
		$rescities = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$stateId' AND `city_id` != '$cityID' ");

		while($fetchrescities = mysql_fetch_array($rescities))

		{

			if(strlen($fetchrescities['city_name']) > 2 )

			{

				if($fetchrescities['lng'] != 0.000000 && !empty($fetchrescities['lng']))

				{

					$restlong = $fetchrescities['lng'];

					$restlat = $fetchrescities['lat'];



					$distancemiles = distance($cclat, $cclong, $restlat, $restlong, "M");

					$distancesArray[$fetchrescities['city_id']] = $distancemiles;

					// $distancemiles <= round($miles_filter,2)

				}

			}

		}

		//echo "<pre>"; print_r($distancesArray); exit;

		$citys = "";

		asort($distancesArray);

		$a=0;

		foreach($distancesArray as $key=>$dis)

		{

			if($dis < 15)

			{

				$citys .= $key.",";

			}



		}

		$citystring = rtrim($citys,",");

		if(empty($citystring))

		{

			foreach($distancesArray as $key=>$dis)

			{

				if($dis < 30)

				{

					$citys .= $key.",";

				}



			}

			$citystring = rtrim($citys,",");

		}

		

		if(empty($citystring))

		{

			foreach($distancesArray as $key=>$dis)

			{

				if($dis < 50)

				{

					$citys .= $key.",";

				}



			}

			$citystring = rtrim($citys,",");

		}

		





	

	$sql = "select forum.event_category,forum.forum, forum.event_id ,forum.event_date,forum.description,forum.event_address,forum.image_thumb,forum.from_user,forum.contest_id,forum.user_type,forum.user_id,forum.forum_id, forum.forum_img,forum.forum_video,forum.status from forum as forum

	where forum.status ='1'  AND `forum`.`city_id` IN (".$citystring.")  AND `forum`.`post_from` = 'city_forum' ".$condition." GROUP BY forum.forum, forum.event_date  ORDER BY `forum`.`user_id` DESC,`forum`.`event_date` ";

		$sql1 = mysql_query($sql);

		$count = mysql_num_rows($sql1);



		if($count < 1)

		{

			

		}

	/* CALCULATE CODE ENDS */

	}









	$rowCount = 0;

	$total = 0;

	$total = $count;

	if(isset($_GET['page']))

	{

		$page = $_GET['page'];

	}

	else

	{

		$page = '1';

	}

	$limit = '10';  //limit

	$i=$limit*($page-1);

	

	$pager = Pager::getPagerData($total, $limit, $page);

	$offset = $pager->offset;

	$limit  = $pager->limit;

	$page   = $pager->page;

	$sql = $sql . " limit $offset, $limit";



	if($count > 0)

	{

		$sql = mysql_query($sql);

		$iiii = 1;

		while($row = mysql_fetch_array($sql))

		{

		   //echo "<pre>"; print_r($row); die;

			$eventimage = $row['event_category'].".jpg";

			if($row['user_type'] == "club")

			{

				

				$selecthostquery = mysql_query('SELECT * FROM `clubs` WHERE id = "'.$row['user_id'].'" ');

				$reshostquery = mysql_fetch_array($selecthostquery);

				$postername = $reshostquery['club_name'];

				$imagesrc = $reshostquery['image_nm'];

				$club_id = $reshostquery['id'];

				$islaunch = $reshostquery['is_launch'];
				$streamingLaunch = $reshostquery['streamingLaunch'];

				if($_SESSION['user_type'] == "user"){



					$host_details=mysql_query("select status from  friends where friend_id='".$club_id."' AND user_id='".$_SESSION['user_id']."' AND friend_type='club'");

					$club_dtl=mysql_fetch_assoc($host_details); 				

					

				}	

				if($imagesrc =="")

				{

					$imagesrc = "images/man1.jpg";

				}

				else

				{ 

					$imagesrc = $imagesrc ;

				

				}

			  

			}

			else

			{

				

				

				

				$postername = $row['first_name']." ".$row['last_name'];

				if($row['image_nm']=="")

				{

					$imagesrc = $SiteURL."images/man1.jpg";

				}

				else

				{ 

					$imagesrc = $SiteURL.$row['image_nm'];

				

				}   

				$streamingLaunch = $row['streamingLaunch'];

			}

			if($row['from_user'] != '0')

			{

				//echo "SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ";

				$getusersql = mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ");

				$fetchusersql = mysql_fetch_array($getusersql);

				//echo "<pre>"; print_r($fetchusersql); die;
				$streamingLaunch = $fetchusersql['streamingLaunch'];

				$imagesrc = $SiteURL.$fetchusersql['image_nm'];

				$postername = $fetchusersql['first_name']." ".$fetchusersql['last_name'];

			}



		   ?>
	<div class="v2_blog_post">
	  <?php

		   if(!preg_match("/(bad|naughty|Dick|dick|Penis|penis|Vagina|vagina|Anal|anal)/i", $row['forum'])){

		   ?>
	  <div class="v2_blogpost_user">
		<div class="pic"> <a href="<?php echo $SiteURL; ?><?php if(isset($_SESSION['user_id'])){ ?>host_profile.php?host_id=<?php echo $club_id;  }else{ echo $postername; }?>">
		  <?php        

						 if($row['user_id'] == '0')

						 {

								$style = " ";

						 }

						 else

						 {

								echo '<img src="'.$imagesrc.'" />';

								echo $postername;

								$style= "";

						 }





						?>
		  </a>
		  <div class="followdbtn">
			<?php if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == "user" && $row['user_id'] != 0) { ?>
			<a style="display: none;" id="block" href="javascript:void(0)" class="button follow_hostc block">Followed</a>
			<?php if($club_dtl['status']=='active') { ?>
			<a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a>
			<?php }else if($club_dtl['status']=='block') { ?>
			<a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a>
			<?php }else {  ?>
			<input type="submit" id="request" class="button follow_hostc" value="Follow Host" name="submit" onclick="savehost('<?php echo $club_id;?>','request')">
			<?php } }?>
		  </div>
		  <div class="followdbtn align-left">
			<?php 

				$pieces = explode(" ", $postername);

				$username_dash_separated = implode("-", $pieces);

				$username_dash_separated = clean($username_dash_separated);

			 if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == "user" && $row['user_id'] != 0 && $streamingLaunch == '1'){ ?>
				<a class="" name="submit"  href="<?php echo $SiteURL; ?>host_profile.php?host_id=<?php echo $club_id;?>">
			  		<span class="stats_icon" style="width:100%; text-align: center;" >
			  			<img src="<?php if($streamingLaunch == '1'){ echo 'images/view-web-cam-green.png';}else{ echo 'images/view-web-cam-black.png';} ?>" title="<?php if($streamingLaunch == '1'){ echo "Online";}else{ echo "Offline";}?>" style="max-width:35px;"  />
			  		</span>			  
			  	</a>
			<?php  } ?>
		  </div>
		</div>
	  </div>
	  <div class="v2_post_container">
		<div  id="forumcontent">
		  <?php $share_img=''; 

				if($row["forum_img"]!="" || $row["forum_img"] =="") 

				{

		

					



					if($row['user_id'] == "0")

					{

						$fullImage = $row['forum_img'];

						$thumbImage = $row['image_thumb'];
						$eid = $row['forum_id'];

					}

					else

					{

						$fullImage = $SiteURL.str_replace("../", "", $row["forum_img"]);

						$thumbImage = $SiteURL.str_replace("../", "", $row["image_thumb"]);

						$eid = $row['event_id']."&action=event";

					}

		

								

							   

							if(empty($fullImage))

							{

								

								$fullImage = $SiteURL."events_icons/".$eventimage;

								?>
	  	<a href="javascript:void(0);" rel="group" class="" onClick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $eid; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"> 
			<img  <?php echo $style; ?> src="<?php echo $SiteURL; ?>events_icons/<?php echo $eventimage;?>" alt=""  /> 
		</a>
		  <?php 



							}

							else

							{





							?>
	  	<a href="javascript:void(0);" rel="group" class="" onClick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $eid; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"> 
		  	<img  <?php echo $style; ?> src="<?php echo $thumbImage; ?>" alt=""  /> 
		</a>
		  <?php }   $share_img=$fullImage; } ?>
		  
		  <!--<br /><br />-->
		  
		  <?php if($row["forum_video"]!="") { ?>
		  <a href="#dialogx" name="modal">
		  <?php //echo substr($row["forum_video"],3);?>
		  <div id="a<?php echo $row["forum_id"];?>" onmouseover="jwplayer().play();" onmouseout="jwplayer().pause();"></div>
		  <script type="text/javascript">

								 jwplayer("a<?php echo $row["forum_id"];?>").setup({

									file: "<?php echo $SiteURL.substr($row["forum_video"],3);?>",

									//file: "Video.MOV",

									height : 140 ,

									width: 200

									});

								</script> 
		  </a>
		  <?php $share_img = $SiteURL.$row["forum_video"]; } ?>
		</div>
		<div class="comment_box commentdisplay">
		  <div class="box2 socialbox">
			<div class="v2_share_on">
			  <?php



				if($row["user_id"]=='0'){ $shareurl = $share_img; }else{ $shareurl = $fullImage; } ?>
			  <ul class="shareit">
					<li>
				  	<?php
						if(isset($_SESSION['facebook_access_token']) && !empty($_SESSION['facebook_access_token']))
						{


						?>
		  
							<a rel="nofollow" href="javascript:void(0);" class="fb_share_button"  onclick="shareFBpost('<?php echo $row["forum_id"];?>');" style="text-decoration:none;"> 
								<img src="<?php echo $SiteURL; ?>images/fbook.png" alt="Share on Facebook"/> 
							</a>
						
						<?php
						  
						} 
						else
						{
							
							$helperLogin = $fb->getRedirectLoginHelper();
							$loginUrl = $helperLogin->getLoginUrl($callback, $permissions);

						 ?>
						 	<a rel="nofollow" href="<?php echo $loginUrl; ?>" class="fb_share_button" target="_blank" style="text-decoration:none;"> 
						 		<img src="<?php echo $SiteURL; ?>images/fbook.png" alt="Share on Facebook"/> 
						 	</a>
						<?php } ?>   		
				</li>
				<li> <a href="#" onclick="return fbs_click123('<?php echo $shareurl;?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter"> <img src="<?php echo $SiteURL; ?>images/twt.png" alt="Share on Twitter"/> </a> </li>
				<li> <a href="https://plus.google.com/share?url=<?php echo $shareurl;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"> <img src="<?php echo $SiteURL; ?>images/g+.png" alt="Share on Google+"/> </a> </li>
				<li> <a href="https://plus.google.com/share?url=<?php echo $shareurl;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"> <img src="<?php echo $SiteURL; ?>images/share_pst.png" alt="Share Post"/> </a>
					<ul>
						<li> <a href="javascript:void(0);" onclick="sharepostPublic('<?php echo $row['forum_id'];?>');">Public</a> </li>
						<li> <a href="javascript:void(0);" onclick="sharepostPrivate('<?php echo $row['forum_id'];?>');">Friends List</a> </li>
					</ul>
				</li>
			  </ul>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="v2_post_info">
		<h1> 
		  
		  <!--Added on 15.12.2014-->
		  
		  <?php 

					

							if($row['forum'] == "")

							{

								

	$getforumtitlequery = mysql_query('SELECT * FROM contest WHERE contest_id = "'.$row['contest_id'].'" ');

								$getarray = mysql_fetch_array($getforumtitlequery);

								if($getarray['host_id'] == "0")

								{

									

									echo "<p> mySitti's ".$getarray['contest_title']." contest</p>";

								}

								else

								{

									

	$gethostnamequery = mysql_query('SELECT * FROM clubs WHERE id = "'.$getarray['host_id'].'" ');

									$gethostarray = mysql_fetch_array($gethostnamequery);

				 echo "<p>".$gethostarray['club_name']." ".$getarray['contest_title']." contest</p>";

								}

								

							}

							else

							{

								echo "<p>".$row['forum']."</p>";

							}



					?>
		  
		  <!--//Added on 15.12.2014--> 
		  
		</h1>
		<div class="event-date">
		  <?php 

									



						   echo date('F j, Y l g:i A',strtotime($row['event_date'])); ?>
		</div>
		<div class="location"> <span class="post_address"> <?php echo $row['event_address']; ?> </span> <span class="post_map"> <a target="_blank" title="" class="map"  onclick="goto('<?php echo $SiteURL; ?>eventmap.php?add=<?php echo $row['forum_id'];?>');">Map</a> </span>
		  <div style="clear:both"></div>
		</div>
		<p class="discription">
		  <?php 

				$des = strip_tags($row['description']);







			$des = str_replace('www.', ' www.', $des);

							echo substr($des,0,200); ?>
		  <?php

				if($row['user_id'] == '0')

				{

					$eid = $row['forum_id'];

				}

				else

				{

					$eid = $row['event_id']."&action=event";

				}



					if(strlen($des) >= 200)

					{

			?>
		  <a onClick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $eid; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"  >Read More...</a> </p>
		<?php

				}

				

				if($_SESSION['user_type'] == 'user')

				{   

					$checkuserevent = mysql_query("SELECT `id` FROM `user_events` WHERE `uid` = $_SESSION[user_id] AND `forum_id` = '$row[forum_id]' ");

					$countevent = mysql_num_rows($checkuserevent);

					if($countevent < 1)

					{

					?>
		<div class="box2 addtoMyCalendar" id="add_to_calendar_<?php echo $row['forum_id']; ?>"> <a href="javascript:void(0);"  id="event_to_calendar" onclick="addToCalendar('<?php echo $row['forum_id']; ?>');"><img src="images/addtoCalendar.png" title="Add to your Calendar" alt="Add to your Calendar"></a> </div>
		<?php }

					else

					{

						?>
		<div class="box2 addtoMyCalendar" id="add_to_calendar_<?php echo $row['forum_id']; ?>"> <span style='color:rgb(254, 205, 7);'>Event Already Added to your Calendar!</span> </div>
		<?php 

					}

				

				}

				?>
		<div class="clear"></div>
		<?php 

					//if(isset($_SESSION['user_id']))

					//{

					?>
		<div class="ShowTicket Eventicket">
		  <?php 
					$upcomingEvents['event_id'] = $eid; 
					$check_ticket = mysql_Query("SELECT * FROM streaming_tickets WHERE event_id = '".$upcomingEvents['event_id']."'");

					$count_ticket_check = mysql_num_rows($check_ticket);



					/* PAID PASSES QUERY */

					$getPaidpass = mysql_query("SELECT * FROM `paid_passes` WHERE `event_id` = '$upcomingEvents[event_id]' ");

					$fetchRecords = mysql_fetch_assoc($getPaidpass);

					$countPaidpasses = $fetchRecords['no_of_tickets'];

					$currDate = strtotime(date('Y-m-d H:i:s'));

					$expiryPass = strtotime($fetchRecords['expiry_date']);

				?>
		  <?php 

				if($count_ticket_check == "1" || $countPaidpasses > 0)

				{

			?>
		  <div class="clear"></div>
		  <?php

					if($countPaidpasses > 0 && $fetchRecords['pass_status'] == "active" && ( $expiryPass > $currDate) )

					{

						$HostID = $upcomingEvents['user_id'];

						$get_str_host_email = mysql_query("SELECT `merchant_id` FROM `clubs` WHERE `id` = '$HostID' ");

						$count_email = mysql_num_rows($get_str_host_email);

						

						if($count_email < 1){

							

							$host_email = "";

							

						}else{

							

							$set_host_email = mysql_fetch_assoc($get_str_host_email);

							$host_email = $set_host_email['merchant_id'];

							

						}

						

						$hide_btn = "style='display: none;'";

						

						$payment_amount =  trim(str_replace("$",'',$fetchRecords['amount']));

						$host_email_set = $host_email;

						$item_name = "Buy Ticket";
						
						if(isset($_SESSION['user_id'])){
							?>
		  <a  class="buyshowtickets"  href="<?php echo $SiteURL; ?>buyStageTicket.php?host_id=<?php echo $row['user_id'].'&str_amt='.$payment_amount.'&user_type='.$_SESSION['user_type'].'&passid='.$fetchRecords['pass_id'].'&event_id='.$row['event_id']; ?>">
		  <?php }else{
							
							if(!empty($_SERVER['QUERY_STRING'])){
								
								$Search_events_redirect = $SiteURL."searchEvents.php?".$_SERVER['QUERY_STRING'];		
								
							}else{
								
								$Search_events_redirect = $SiteURL."searchEvents.php";		
								
							}
							?>
		  <a class="buyshowtickets" href="<?php echo $Search_events_redirect; ?>" onclick="openLoginpop($(this).prop('href')); return false;">
		  <?php } ?>
		  Show Ticket </a>
		  <?php



					}



					/**** check streaming ticket exists ****/



					if($count_ticket_check == 1)

					{
						$get_ticket_id = mysql_fetch_assoc($check_ticket);

						$ticket_id = $get_ticket_id['ticket_id'];

						$check_user_purchased_ticket = mysql_query("SELECT * FROM streaming_tickets_purchased WHERE ticket_id = '".$ticket_id."' AND buyer_user_id = '".$_SESSION['user_id']."' AND buyer_user_type = '".$_SESSION['user_type']."' AND event_id = '".$row['event_id']."'");

						$count_downloaded_ticket = mysql_num_rows($check_user_purchased_ticket);
						

						if($count_downloaded_ticket < 1)

						{
						
						if(isset($_SESSION['user_id'])){ ?>
		  <a class="buysttickets" href="OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php echo $row['user_id']; ?>&user_type=club&ticket_id=<?php echo $ticket_id; ?>&event_id=<?php echo $row['event_id']; ?>">
		  <?php }else{
							
							if(!empty($_SERVER['QUERY_STRING'])){
								
								$Search_events_redirect = $SiteURL."searchEvents.php?".$_SERVER['QUERY_STRING'];		
								
							}else{
								
								$Search_events_redirect = $SiteURL."searchEvents.php";		
								
							}
							?>
		  <a class="buysttickets" href="<?php echo $Search_events_redirect; ?>" onclick="openLoginpop($(this).prop('href')); return false;">
		  <?php } ?>
		  Streaming Ticket </a>
		  <?php

						}

						else

						{ ?>
		  <span class="avail">Already Purchased Ticket</span>
		  <?php }

					}

					/**** check ticket exists ****/

				}

					?>
		</div>
		<?php 	//}	?>
	  </div>
	  <?php } ?>
	</div>
	<?php 

		$iiii++; }

	}

	else

	{

		?>
			<div class="v2_blog_post">
				<h2 id="errormessage" class="NoEvents"> 
					No Events Found
				</h2>
			</div>
		<?php

	} 



	if(isset($_GET['c'])){

		

		$e_cat = "&c=".$_GET['c'];

	}



	echo '<div class="pagination">';

		if($pager->numPages > 1)

		{

			echo '<a href="'.$_SERVER['PHP_SELF'].'?page=1'.$e_cat.'"><span title="First">&laquo;</span></a>';

			if ($page <= 1)

				echo "<span>Previous</span>";

			else            

				//echo "<a href='".$_SERVER['PHP_SELF']."'?page=".($page-1).$e_cat."'><span>Previous</span></a>";

				echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page-1).$e_cat."'><span>Previous</span></a>";

			echo "  ";

			if(!isset($_GET['page']))

			{

				$y = '1';

			}

			else

			{

				$y = $_GET['page'];

			}

			$z = '0';

			for ($x=$y;$x<=$pager->numPages;$x++){

				

				if($z < 9)

				{

					echo "  ";

					if ($x == $pager->page)

					{

						echo "<span class='active'>$x</span>";

					}

					else

					{

						echo "<a href='".$_SERVER['PHP_SELF']."?page=".$x.$e_cat."'><span>".$x."</span></a>";

					}

				}

				$z++;

			}

			if($page == $pager->numPages) 

				echo "<span>Next</span>";

			else           

				echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page+1).$e_cat."'><span>Next</span></a>";

									

			echo "<a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages.$e_cat."'><span title='Last'>&raquo;</span></a>";

		}

	echo "</div>";







}











		if(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter'])){

		

			$club_filter=$_SESSION['main_clubs_filter'];

			$cnd=" parrent_id='0' AND  id IN(".$club_filter.")";

		

			$sql_main_club=mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC"); //case 2 :

		

		}else{

		

			$sql_main_club=mysql_query("select * from club_category where parrent_id='0' ORDER BY name ASC"); //case 1 :

		

		}

		

		$single_sql_main_club=mysql_query("select * from club_category where parrent_id='0' ORDER BY id ASC"); //case 1 :

		$get_single_club = mysql_fetch_assoc($single_sql_main_club);

		/* FRIENDS QUERY */
		$getFriends = mysql_query("select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs where fs.user_id='".$_SESSION['user_id']."' AND `user_type` = '$_SESSION[user_type]' AND fs.friend_id != 1 AND fs.friend_id != '$_SESSION[user_id]' AND fs.status IN ('active')
		GROUP BY friend_id ORDER BY id ASC");


?>
		<div style="display: none;" id="popup3_album_515">
			<span class="b-close-album-515">X</span>
			<div style="height: auto; width: auto;" id="mycontent-album-515">
				<h2 class="shareselect">Select Friends to share Post</h2>
				<div class="sel_all">
						<input type="checkbox" id="SelectALL" onclick="checkAllfriends();" name="selectAll"  /> Select All Friends
				</div>
				<ul class="SharingFriendslist">
				<?php 
				$i=0;
				while($fetchFriends=mysql_fetch_assoc($getFriends))
				{
					$i++;
					if($fetchFriends['friend_type'] == "user")
					{
						$friendQuery  = mysql_query("SELECT `profilename`,`id`,`is_online`,`first_name`,`image_nm`,`last_name`,`country`,`state`,`city`,`status`,`zipcode`
											FROM `user` 
											WHERE `id` = '$fetchFriends[friend_id]'
										");
						$friendResult = mysql_fetch_assoc($friendQuery);
						if($friendResult['profilename'] != "")
						{
							$friendName = $friendResult['profilename'];
						}
						else
						{
							$friendName = $friendResult['first_name']." ".$friendResult['last_name'];
						}

						$friendCityid = $friendResult['city'];
						$friendStateid = $friendResult['state'];
						$friendCountryid = $friendResult['country'];
						$friendID = $friendResult['id'];
						$friendZip = $friendResult['zipcode'];
						$friendSattus = $friendResult['status'];
						$imageSrc = $friendResult['image_nm'];
						$anchorPath =	"profile.php?id=".$friendID;
						$onlineStatus = $friendResult['is_online']; 

					}
					else
					{
						$friendQuery  = mysql_query("SELECT `id`,`is_online`,`club_name`,`image_nm`,`club_country`,`club_state`,`club_city`,`status`,`zip_code`
											FROM `clubs` 
											WHERE `id` = '$fetchFriends[friend_id]'
											AND `non_member` = 0
										");
						$friendResult = mysql_fetch_assoc($friendQuery);
						$friendName = $friendResult['club_name'];
						$friendCityid = $friendResult['club_city'];
						$friendStateid = $friendResult['club_state'];
						$friendCountryid = $friendResult['club_country'];
						$friendID = $friendResult['id'];
						$friendZip = $friendResult['zip_code'];
						$friendSattus = $friendResult['status'];
						$imageSrc = $friendResult['image_nm'];
						$anchorPath =	"host_profile.php?host_id=".$friendID;
						$onlineStatus = $friendResult['is_online'];
					}
					$friendName = trim($friendName);
					if(!empty($friendName))
					{
				?>
					<li>
						<input type="checkbox" name="ShareFriends[]" value="<?php echo $friendID."-----".$fetchFriends['friend_type']; ?>" />&nbsp; <?php echo $friendName;?>
					</li>
			<?php 		}
				}
			?>
				</ul>
				<input type="button" id="sharePostfriends" onclick="sharePostFriends();" value="Share" />
				<input type="hidden" id="forumidtoshare" value="" />
			</div>
		</div>
	</article>
</div>
<div id="fullOverlay"></div>
<style type="text/css">
#popup3_album_515 #sharePostfriends {
  float: left;
  margin: 20px 40%;
  text-align: center;
}
	#popup_adv {
										float: left;
										position: relative;
										width: 100%;
									}
									#inner_popup_adv {
										float: left;
										height: 100%;
										position: absolute;
										width: 100%;
										z-index: 99;
									}	
									#popup3_album_515 {
								  background: #000 none repeat scroll 0 0;
  border: 4px solid #ff0;
  bottom: 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  height: auto;
  left: 0;
  margin: auto;
  max-height: 500px!important;
  max-width: 500px!important;
  overflow: auto;
  padding: 10px !important;
  position: fixed;
  right: 0;
  top: 0;
  width: 100% !important;
  z-index: 2;
									}
		 
		#popup3_album_515 h1 {
  padding: 10px 0;
  text-transform: uppercase;
  margin-bottom: 10px;
}
									#popup3_album_515 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
									#popup, #popup2, #popup3_album_515, .bMulti {
										background-color: #000;
										border-radius: 10px;
										box-shadow: 0 0 25px 5px #006099;
										color: #111;
										padding: 25px;
										display: none;
									}
									#popup3_album_515 span.b-close-album-515 { border: none; float: right;color: #fecd07; cursor: pointer;}
										.b-modal1-album-515{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:99; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}
									
									#popup2 #mycontent-album-515 > p {
										color: white;
										font-size: 15px;
										font-weight: bold;
									}
									
									#popup2 #mycontent-album-515 > span {
										color: white;
									}
									#popup3_album_515									{
										z-index: 99999;
										color: #FFF;
									}
									#popup3_album_515 #mycontent-album-515 > p {
									  border-bottom: 1px solid #fff;
									  font-size: 20px;
									  margin-bottom: 10px;
									  padding-bottom: 10px;
									}
									

									#mycontent-album-515 li {
			background: #000 none repeat scroll 0 0;
float: left;
margin: 10px 1%;
max-height: 150px;
/*min-height: 150px;*/
overflow: hidden;
position: relative;
width: 31.3%;
									}
									
					#mycontent-album-515 li img{
	  max-width:100%; position:absolute; left:0; right:0; top:0; bottom:0; margin:auto;
	 }
									#mycontent-album-515 > ul {
										float: left;
										width: 100%;
									}
         
         .v2_banner_top1.h_auto {
  background: rgba(0, 0, 0, 0) url("../images/noice.png") repeat scroll left top !important;
}
		 @media only screen and (min-width:540px) {
							#mycontent-album-515 li { 
width: 48%;
									}
		 }

h2#errormessage{
    background: crimson;
    padding: 10px;
    text-align: center;
}



</style>
<script type="text/javascript">
function checkAllfriends()
{
	if($('#SelectALL').is(':checked'))
	{
		$('.SharingFriendslist li input').each(function(){
			$(this).prop('checked', true);
		});	
	}
	else
	{
		$('.SharingFriendslist li input').each(function(){
			$(this).prop('checked', false);
		});	
	}

	
}


$(document).ready(function(){
	$('.b-close-album-515').click(function(){
		$('#popup3_album_515').hide();
	});
});

function sharepostPublic(forumid)
{
	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'forumid' : forumid,
			'action' : 'sharePostPublic',
		},
		success: function(data){
			//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
			alert('Post shared Publically!');
			return false;
		}
	});
}

function sharepostPrivate (forumid) 
{
	$('#popup3_album_515,#fullOverlay').show();
	$('#forumidtoshare').val(forumid);
	$('.SharingFriendslist li input').each(function(){
		$(this).prop('checked', false);
	});
}


function sharePostFriends()
{
	var forumid = $('#forumidtoshare').val();

	var stringids = $.map($(':checkbox[name=ShareFriends\\[\\]]:checked'), function (n, i) {
					return n.value;
			}).join(',');

	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'string' : stringids,
			'forumid' : forumid,
			'action' : 'sharePostFriends',
		},
		success: function(data){
			//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
			alert('Post shared with selected Friends!');
			$('#popup3_album_515').hide();
			$('#fullOverlay').hide();
			return false;
		}
	});
}




function fetchclubs(id)

{

	var catid1 = id.split('_');

	var cityid = "<?php echo $_SESSION['id']; ?>";

	//alert($('#list_'+catid1[1]).size());

	if( $('#list_'+catid1[1]).size()  == 1 )

	{

		$('#list_'+catid1[1]).html('<li style="text-align: center; background: none;"><img width="100px" src="loading.gif" alt="" /></li>');

	}

	

	$.ajax({

		type: "POST",

		url: "fetchClubs.php",

		data: {

			'cityid' : cityid,

			'catid' : catid1[1]

		},

		success: function(data)

		{

			//alert(data);

			$('#list_'+catid1[1]).html(data);

		}

	});

}



function set_default_cat(){

	var atLeastOneIsChecked = $( "#s_default_cat:input:checked" ).val();

	if (atLeastOneIsChecked == "on") {

		

		var cat_value = $('#eventcatselect').val();

		var user_type = '<?php echo $_SESSION['user_type']; ?>';

		var user_id = '<?php echo $_SESSION['user_id']; ?>';

		

		$.ajax({

			type: "POST",

			url: "ajaxcall.php",

			data: {

				'set_default_category' : cat_value, 'user_type' : user_type, 'user_id' : user_id

			},

			success: function(data)

			{

				alert(data);

			}

		});

	}

}



function addToCalendar(fid)

{

	$.ajax({

		type: "POST",

		url: "refreshajax.php",

		data: 	{

				'action' : 'addtocalendar', 

				'forumID' : fid, 

				// 'user_id' : user_id

			},

		success: function(data){

			$('#add_to_calendar_'+fid).html(data);

		}

	});

}



function savehost(id,ac)

{

	

	$.ajax({

		type: "POST",

		url: "savehost.php",

		data: {

			'host_id' : id,

			'action' : ac,

		},

		success: function(data){

			$('.follow_hostc').hide();

			

			if (data == "success") {

				$('.block_new').hide();

				$('.block').show();

			}else if (data == "blocked") {

				$('.unblock_new').hide();

				$('.unblock').show();

			}else if (data == "unblocked") {

				$('.block_new').hide();

				$('.block').show();

			}

		}

	});



return false;

}

</script>
<?php include('Footer.php') ?>