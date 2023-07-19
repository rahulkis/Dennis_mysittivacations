<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

// if(!isset($_SESSION['user_id']))
// {
// 	$Obj->Redirect('index.php');
// }

$titleofpage="City Events"; 

if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php'); // login

}

else

{

	include('Header.php');	// not login

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


if(!isset($_SESSION['user_id'])) { ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".socialfixed").css("display", "none");
	});
	</script>
<?php }
?>

<script language="javascript">

$(document).ready(function(){
	$( "#get_destination" ).keypress(function() {
		var urldes = '<?php echo $SiteURL;?>';
		var URLDES = urldes+'refreshajax.php?getaction=fetchdestinations';
		
		$('#get_destination').autocomplete(URLDES);
		// return false;
	}); 

});

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
 <script>
 $(function() 
 {   $( "#datepicker_side" ).datepicker(); });
</script>

<link rel="stylesheet" href="../css/new_portal/smk-accordion.css" />
<link rel="stylesheet" href="../css/hotel.css" />

<!-- Add fancyBox -->
<link rel="stylesheet" href="../fancybox/source/jquery.fancybox.css?v=2.1.6" type="text/css" media="screen" />
<script type="text/javascript" src="../fancybox/source/jquery.fancybox.pack.js?v=2.1.6"></script>
<link rel="stylesheet" href="../fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="../fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="../fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<link rel="stylesheet" href="../fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="../fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript">
	$(document).ready(function() {
	$(".fancybox").fancybox({
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});
</script>


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
.bx-viewport img {
    width: 100% !important;
}
.trip-detail .bx-wrapper img {
   
    width: 100%;
}

article {
    overflow: hidden;
}
.bx-wrapper {
    overflow: hidden;
}
 .trip-expert li{
        float: left;
		list-style-type: none;
		width: 25%;
        }	
            	
		.trip-expert img {
			width: 100%;
			float:left;
		}
		.trip-expert h2{
			 float: left;
    		margin: 0;
		}
		.trip-expert h2 a {
			color: #0355a9;
			font-family: "Whitney SSm A","Whitney SSm B",Arial,sans-serif;
			font-size: 20px;
			font-weight: 600;
			letter-spacing: -1px;
			}
		.trip-expert h2 {
			float: left;
			margin: -5px 0 0 0px;
		}		
	.trip-expert-data {
			float: left;
			margin-left: 20px;
			width: 65%;
		}
		.trip-expert-data p{
		color: #999;
		font-size: 14px;
		margin: 10px 0;
		min-height: 50px;
		float:left;
	}
	
.trip-expert {
    border-bottom: 1px solid #eee;
    float: left;
    padding: 15px 0;
	position:relative;
	width: 100%;
	}
		span.score {
   background-color: #009b45;
    border-radius: 100%;
    color: #fff;
    cursor: default;
    display: block;
    font-family: "Whitney SSm A","Whitney SSm B",Arial,sans-serif;
    font-size: 14px;
    font-weight: 600;
    height: 35px;
    line-height: 2.5;
    position: absolute;
    right: 15px;
    text-align: center;
    top: 10px;
    width: 35px;
	}
	.trip-expert:hover {
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.15);
}
.review-icon > li {
    margin: 4px;
    width: auto;
}
.review-icon img {
    width: 20px;
}
.trip-detail h2 {
    color: #131313;
    font-family: "Sentinel SSm A","Sentinel SSm B",Arial,sans-serif;
    font-size: 38px;
    font-weight: 600;
    letter-spacing: -3px;
    margin: 5px 0 10px;
}
.amenities_sec li {
   	background: rgba(0, 0, 0, 0) url("../images/green_tick.png") no-repeat scroll 0 3px !important;
   	background-size: 10px !important;
}
.trip-detail {
    float: left;
    width: 100%;
}	
	span.score-detail {
   background-color: #009b45;
    border-radius: 100%;
    color: #fff;
    cursor: default;
    display: block;
    font-family: "Whitney SSm A","Whitney SSm B",Arial,sans-serif;
    font-size: 14px;
    font-weight: 600;
    height: 35px;
    line-height: 2.5;
   margin-bottom: 15px;    
    text-align: center;
    float: right;
       width: 35px;
	}
	.trip-detail address h5 {
    color: #131313;
    font-family: "Whitney SSm A","Whitney SSm B",Arial,sans-serif;
    font-size: 14px;
    font-weight: 600;
    margin: 0;
}
.trip-detail address p {
    color: #434343;
    font-family: "Whitney SSm A","Whitney SSm B",Arial,sans-serif;
    font-size: 12px;
    margin: 7px 0 5px;
    font-style: normal;
    position: relative;
}
.city_nme {
	color: #777;
	clear: both;
}
.address > a {
    color: #666;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
}
article.newSectionEvents {
    width: 70% !important;
}
aside.sidebarEvents {
    width: 22% !important;
}
.trip-detail .no-bullet {
    color: blue;
    font-style: normal;
    text-decoration: none;
}
.trip-detail address em {
    color: #434343;
    font-size: 15px;
    font-style: normal;
}
.detial-trip-list li img {
    float: left;
    width: 60px;
}
.detial-trip-list li{
	  border-top: 1px solid #ccc;
    list-style-type: none;
    margin: 20px 0;
    padding: 20px 0;
}
.detial-trip-list li h3 {
    float: left;
    font-size: 18px;
    font-style: normal;
    margin: -5px 10px;
}
.detial-trip-list li p {
    color: #777;
    float: left;
    font-size: 14px;
    font-style: normal;
    margin: 0 0 0 10px;
    width: 85%;
}
.clearfix span {
    color: black;
    font-size: 15px;
    font-weight: bold;
}
.clearfix img {
    float: left;
    margin-top: 2px;
    padding-right: 8px;
}
.ItemBox .clearfix h4 {
	float: left;
    font-size: 16px;
    font-weight: 600;
}
.ItemBox .clearfix p {
	color: #777;
    float: left;
    margin-top: 4px;
}
.ItemBox .amenities_sec ul li {
	float: left;
    width: 50%;
}
.ItemBox .clearfix b {
	color: white;
    font-size: 20px;
    left: 47px;
    position: absolute;
    top: 136px;
}
@media( max-width:767px){

	article.newSectionEvents {
    width: 100% !important;
}
#newsidebar .ItemBox {
    padding: 0 5px;
    width: 100%;
}
}


</style>
<script type="text/javascript">

	$(document).ready( function() {

		$('html, body').animate({

			scrollTop: $(".localBusiness").offset().top - 40

		}, 1000);

	});

</script>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		
	<div class="v2_content_inner2">
	<?php
		//include('hotSpotsSidebar.php');
	?>
   	
		<article class="forum_content v2_contentbar newSectionEvents" >
  			<div class="clear"></div>
  			 			
			
			<?php
			//  dynamic city code
				$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
				$get_city_name = mysql_fetch_assoc($city_name_query);
				$dropdown_city = $get_city_name['city_name'];
				$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
				$get_state_name = mysql_fetch_assoc($state_name_query);
				$dropdown_state = $get_state_name['code'];

				$LATITUDE = $get_city_name['lat'];
				$LONGITUDE = $get_city_name['lng'];
				$CITYID = $get_city_name['city_id'];
				$_SESSION['city'] = $get_city_name['city_id'];
				$_SESSION['state'] = $get_city_name['state_id'];
				$_SESSION['country'] = $get_state_name['country_id'];
				$_SESSION['state_name'] = $get_state_name['name'];

				// echo $_SESSION['city'];
				// echo $_SESSION['state_name'];

				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&sensor=false";
				$details=file_get_contents($url);
				$result = json_decode($details,true);

				$lat=$result['results'][0]['geometry']['location']['lat'];

				$lng=$result['results'][0]['geometry']['location']['lng'];


			
				  
				  if (isset($_GET['details'])) {
				    # code...
				        $unique_Id = (int) $_GET['details'];
				        $urls ="https://api.tripexpert.com/v1/venues/".$unique_Id."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
				        $result_tripn = file_get_contents($urls);
				        $get_all_data = json_decode($result_tripn, true);
				        $hotelvenues = $get_all_data['response']['venues'];
				        $nextsideuse = $get_all_data['response']['venues'];
				         
				          foreach ($hotelvenues as $hotelvenue) 
				          {
				            echo "<div class='trip-detail'>";        
				            //echo "<h1>Id : ".$hotelvenue['id']."</h1>";
				            //echo "<h1>venue_type_id : ".$hotelvenue['venue_type_id']."</h1>";
				            	echo "<a href=''><h2>".$hotelvenue['name']."</h2></a>"; 
				            	//echo "<img src='".$hotelvenue['mobile_index_photo']."'/>";
				            	?>
									<ul class="bxslider_pic">
										<?php foreach ($hotelvenue['photos'] as $pic_p) {
											echo "<li><img src='".$pic_p['url']."'/></li>";
										} ?>
									</ul>
								<?php echo "<address class='clearfix'>
										<h5>".$hotelvenue['name']."</h5>
										<p>
										<span class='score-detail' style='color: white;'>".$hotelvenue['tripexpert_score']."</span>
										<a class='no-bullet' target='blank' href='".$hotelvenue['website']."'>".$hotelvenue['website']."</a>
										</p>
										<p class='address'>
										<a href=''>".$hotelvenue['address']."</a>
										</p>
										<em>
										<img src='trip/ph.png'>
										<dt>".$hotelvenue['telephone']."</dt>
										</em>
										<p><span>Opening Hours:</span> ".$hotelvenue['opening_hours']."</p>
										
									</address>";
									
								echo "<div class='detial-trip-list'>";		
				              foreach ($hotelvenue['reviews'] as $rvalue) 
				               {
				               	$urlsp ="https://api.tripexpert.com/v1/publications?&api_key=5d4941cd0c3c1b9571453e237705dbfb";
						        $result_tripnp = file_get_contents($urlsp);
						        $get_all_datap = json_decode($result_tripnp, true);
						        $publications = $get_all_datap['response']['publications'];
						        
									echo "<li>";
											
										foreach ($publications as $P_value) {
									        if($rvalue['publication_id'] == $P_value['id'])
									        {
									        	echo "<img src='".$P_value['icon']."' />";
									        }
								    	}
										echo "<h3>".$rvalue['publication_name']."</h3>";
											if($rvalue['publication_rating_name']) { ?>
												<span class="publication_rating"><?php echo $rvalue['publication_rating_name']; ?></span>
											<?php } 
										echo "<br/>";
										echo "<p>".$rvalue['extract']."";
										if($rvalue['source_url']) { ?>
											<em><a href="<?php echo $rvalue['source_url']; ?>" target="_blank">Full Review</a></em>
										<?php } ?>
										<?php echo "</p>";
										echo "</li>";
						        }
						        }
								}
				              echo "</div>";
				            echo "</div>";
				            
				          
				    ?>
				    

	           <?php
					// Hotel search by sidebar
					if(isset($_POST['search_room'])) 
					{
						$ameni_ties = $_POST['ameni_ties'];
						$checkin = $_POST['checkin'];
						$checkout = $_POST['checkout'];
						$room = $_POST['room'];
						$guest = $_POST['guest'];

						$url1 = "https://api.tripexpert.com/v1/countries?api_key=5d4941cd0c3c1b9571453e237705dbfb";
				  		$result_tripn1 = file_get_contents($url1);
				        $get_all_data1 = json_decode($result_tripn1, true);
				        $venues1 = $get_all_data1['response']['countries'];
				        //echo $venues1['countries'];
				        foreach ($venues1 as $Vvalue) 
				        {
				        	$get_country = @mysql_query("SELECT * FROM country WHERE country_id = '".$_SESSION['country']."'");
							$get_country_name = mysql_fetch_assoc($get_country);
							
							if($Vvalue['name'] == $get_country_name['name']) 
							{
								$url2 = "https://api.tripexpert.com/v1/destinations?country_id=".$Vvalue['id']."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
						  		$result_tripn2 = file_get_contents($url2);
						        $get_all_data2 = json_decode($result_tripn2, true);
						        $destination1 = $get_all_data2['response']['venues'];

						        foreach ($destination1 as $cityvalue) 
						        {
						        	if($dropdown_city == $cityvalue['name'])
						        	{
						        		echo $cityvalue['id'];
						        		$urls = "https://api.tripexpert.com/v1/venues?destination_id=".$cityvalue['id']."&limit=10&check_in=".$checkin."&check_out=".$checkout."&rooms=".$room."&guests=".$guest."&amenity_ids=".$ameni_ties."&api_key=5d4941cd0c3c1b9571453e237705dbfb";

								        $result_tripn = file_get_contents($urls);
								        $get_all_data = json_decode($result_tripn, true);
								        $resto_venues = $get_all_data['response']['venues'];

								        echo "<div class='couman_class'>"; ?>
								        <!--<ul class="price clearfix filter-inputs">
											<li data-id="4" class="">
												<a href="?Rbudget=<?php echo $cityvalue['id']; ?>">Budget</a>
											</li>
											<li data-id="5" class="">
												<a href="?Rmidrange=<?php echo $cityvalue['id']; ?>">Midrange</a>
											</li>
											<li data-id="6" class="">
												<a href="?Rhighrange=<?php echo $cityvalue['id']; ?>">High-end</a>
											</li>
										</ul>-->
										<?php
								        foreach ($resto_venues as $resto_venue) 
								          {
								          	echo "<div class='trip-expert'>"; 
								          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
								          		echo "<div class='trip-expert-data'>"; 
								          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
								          			echo "<h2> <a href='searchEvents.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
								          			echo "<h4 class='city_nme'>".$cityvalue['name']."</h4>";
								          			echo "<p>
													If you only have time to hit up one Memphis barbecue pit, Charlie Vergos Rendezvous should be it. You will find it in the basement of a nondescript building in an alley across from the.
													<i>Frommers</i>
													</p>
														<div class='review-icon'>
															<li><img src='trip/line.png'></li>
															<li><img src='trip/6.png'></li>
															<li><img src='trip/14.png'></li>
															<li><img src='trip/21.png'></li>
															<li><img src='trip/53.png'></li>
														</div>";
								          		echo "</div>";
								          	echo "</div>";
								          }
								        echo "</div>";  
						        	} elseif($_SESSION['state_name'] == $cityvalue['name']) {
							        		// echo $_SESSION['city'];
							        		// echo $cityvalue['id'];
							        		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$cityvalue['id']."&limit=10&check_in=".$checkin."&check_out=".$checkout."&rooms=".$room."&guests=".$guest."&amenity_ids=".$ameni_ties."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
									        $result_tripn = file_get_contents($urls);
									        $get_all_data = json_decode($result_tripn, true);
									        $resto_venues = $get_all_data['response']['venues'];

									        foreach ($resto_venues as $resto_venue) 
									          {
									          	echo "<div class='trip-expert'>"; 
									          		echo "<li><img src='".$resto_venue['tripexpert_score']."'></li>";
									          		echo "<div class='trip-expert-data'>"; 
									          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
									          			echo "<h2> <a href='searchEvents.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
									          			echo "<h4 class='city_nme'>".$cityvalue['name']."</h4>";
									          			echo "<p>
														If you only have time to hit up one Memphis barbecue pit, Charlie Vergos Rendezvous should be it. You will find it in the basement of a nondescript building in an alley across from the.
														<i>Frommers</i>
														</p>
															<div class='review-icon'>
																<li><img src='trip/line.png'></li>
																<li><img src='trip/6.png'></li>
																<li><img src='trip/14.png'></li>
																<li><img src='trip/21.png'></li>
																<li><img src='trip/53.png'></li>
															</div>";
									          		echo "</div>";
									          	echo "</div>";
									          }
									      }
						        }
						    }
						}
					}

     

$rowCount = 0;

	$total = 0;

	$total = $countsearcSQl;

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

	$eventSearchSql = $eventSearchSql . " limit $offset, $limit";


// echo mysql_num_rows($eventSearchSql); die;
if($countsearcSQl > 0)

{

	?>
	<!-- <div class="v2_blog_post"> -->
	  <?php 

				if($countsearcSQl > 0)
				{
					
					$EventCatSQLExec = mysql_query($eventSearchSql);

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
			<?php if(isset($_SESSION['user_id'])) {  ?>
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
				
			  </div>
			  <?php } ?>
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

					if(isset($_GET['c'])){

		

		$e_cat = "&c=".$_GET['c'];

	}



	echo '<div class="pagination" style="display: none !important;">';

		

	echo "</div>";

				}

			?>
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

			$sql = "select forum.event_category,forum.forum, forum.event_id ,forum.event_date,forum.description,forum.event_address,forum.image_thumb,forum.from_user,forum.contest_id,forum.user_type,forum.user_id,forum.forum_id, forum.forum_img,forum.forum_video,forum.status from forum as forum

				where forum.status ='1'  AND `forum`.`city_id`= '54' AND `forum`.`post_from` = 'city_forum' ".$condition." GROUP BY forum.forum, forum.event_date  ORDER BY `forum`.`user_id` DESC,`forum`.`event_date` ";

			$sql1 = mysql_query($sql);

			$count = mysql_num_rows($sql1);

		}

		if($count < 1)
		{
			$event_date1 = date('Y-m-d H:i:s');  
			$sql = "select forum.event_category,forum.forum, forum.event_id ,forum.event_date,forum.description,forum.event_address,forum.image_thumb,forum.from_user,forum.contest_id,forum.user_type,forum.user_id,forum.forum_id, forum.forum_img,forum.forum_video,forum.status from forum as forum

				where forum.status ='1'  AND `forum`.`city_id`= '54' AND `forum`.`post_from` = 'city_forum' AND `event_date` > '$event_date1' AND `event_category` IN ('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25')  GROUP BY forum.forum, forum.event_date  ORDER BY `forum`.`user_id` DESC,`forum`.`event_date` ";

			$sql1 = mysql_query($sql);

			$count = mysql_num_rows($sql1);
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

										} else { ?>
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

		echo "<p id='errormessage' style='display:block;'>No Events Yet.</p>";

	} 



	if(isset($_GET['c'])){

		

		$e_cat = "&c=".$_GET['c'];

	}



	echo '<div class="pagination">';


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
		
	</article>

		<aside class="sidebar v2_sidebar sidebarEvents" style="position:relative;">
		<div id="NewSidebar" style="color: black;">
		<div class="ItemBox">
			<div class="search_filtering new_clFilter">
			<form action="search_city.php" method="post">
				<input type="text" name="search_filter" id="get_destination" value="" placeholder="Enter your destination" required>
				<input type="submit" name="search_submit">
			</form>	
		</div>
		</div>
   		<?php 
   			foreach ($nextsideuse as $hotel_value) { ?>
   				<div class="ItemBox">
   					<div class="clearfix">
						<img alt="Badge@2x c76d2208bd50be15fac0f0bae01a6c5d8444e5bce67bd1aecf266eccc2637ee9" src="https://www.tripexpert.com/assets/tripexpert/badge@2x-c76d2208bd50be15fac0f0bae01a6c5d8444e5bce67bd1aecf266eccc2637ee9.png" style="width: 77px;">
						<b><?php echo $hotel_value['tripexpert_score']; ?></b>
					</div>
					<div class="data_review">
						<h4><?php
						if($hotel_value['tripexpert_score'] >= 60 && $hotel_value['tripexpert_score'] < 70) {
							echo "Recommended";
						} elseif ($hotel_value['tripexpert_score'] >= 70 && $hotel_value['tripexpert_score'] < 80) {
							echo "Very Good";
						} elseif ($hotel_value['tripexpert_score'] >= 80 && $hotel_value['tripexpert_score'] < 90) {
							echo "Excellent";
						} elseif ($hotel_value['tripexpert_score'] >= 90 && $hotel_value['tripexpert_score'] <= 100) {
							echo "Outstanding";
						}
						?></h4><p>say expert reviewers</p>
						<span> <?php 
							if($hotel_value['rank_in_destination'] == 1) {
								echo "#1 in";
							} else {
								echo "Top ".$hotel_value['rank_in_destination']."% in ";
							}
							echo $dropdown_city;
							?>
						</span>
						<a href="https://www.tripexpert.com/about#score" target="_blank">About the TripExpert Score</a>
					</div>
   				</div>
   				<div class="ItemBox">
   				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM"></script>
			    <script>
			      // In the following example, markers appear when the user clicks on the map.
			      // Each marker is labeled with a single alphabetical character.
			      var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			      var labelIndex = 0;

			      function initialize() {
			        var bangalore = { lat: <?php echo $hotel_value['latitude']; ?>, lng: <?php echo $hotel_value['longitude']; ?> };
			        var map = new google.maps.Map(document.getElementById('map'), {
			          zoom: 12,
			          center: bangalore
			        });

			        // This event listener calls addMarker() when the map is clicked.
			        google.maps.event.addListener(map, 'click', function(event) {
			          addMarker(event.latLng, map);
			        });

			        // Add a marker at the center of the map.
			        addMarker(bangalore, map);
			      }

			      // Adds a marker to the map.
			      function addMarker(location, map) {
			        // Add the marker at the clicked location, and add the next-available label
			        // from the array of alphabetical characters.
			        var marker = new google.maps.Marker({
			          position: location,
			          label: labels[labelIndex++ % labels.length],
			          map: map
			        });
			      }

			      google.maps.event.addDomListener(window, 'load', initialize);
			    </script>
					<div id='map' style='width:270px; height:250px;'></div>
   				</div>
   				<div class="ItemBox">
   					<address class="address_side">
						<h5><?php echo $hotel_value['name']; ?></h5>
						<span>Website: <a href="http://www.riverinnmemphis.com/" target="blank" class=""><?php echo $hotel_value['website']; ?></a></span>
						<br>
						<p class="address"><?php echo $hotel_value['address']; ?></p>
						<em>
						<img alt="Contact d445f63b78b656f887e08d10ef2d2d4992d799b4a92ccab83cccb07d135ca2c9" src="https://www.tripexpert.com/assets/tripexpert/contact-d445f63b78b656f887e08d10ef2d2d4992d799b4a92ccab83cccb07d135ca2c9.png">
						<?php echo $hotel_value['telephone']; ?>
						</em>
					</address>
   				</div>
   				<?php if($hotel_value['amenities']) { ?>
	   				<div class="ItemBox">
	   					<div class="amenities_sec">
	   					<h5>Amenities</h5>
	   					<ul>
	   						<?php foreach ($hotel_value['amenities'] as $A_value) { ?>
	   							<li><?php echo $A_value; ?></li>
	   						<?php } ?>
	   					</ul>
	   					</div>
	   				</div>
   				<?php } ?>
   				<div class="ItemBox">
   					<?php if($hotel_value['venue_type_id'] == 2) {
   						$url1 = "https://api.tripexpert.com/v1/countries?api_key=5d4941cd0c3c1b9571453e237705dbfb";
				  		$result_tripn1 = file_get_contents($url1);
				        $get_all_data1 = json_decode($result_tripn1, true);
				        $venues1 = $get_all_data1['response']['countries'];
				        
				        foreach ($venues1 as $Vvalue) 
				        {
				        	$get_country = mysql_query("SELECT * FROM country WHERE country_id = '".$_SESSION['country']."'");
							$get_country_name = mysql_fetch_assoc($get_country);
							
							if($Vvalue['name'] == $get_country_name['name']) 
							{
								$url2 = "https://api.tripexpert.com/v1/destinations?country_id=".$Vvalue['id']."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
						  		$result_tripn2 = file_get_contents($url2);
						        
						        $get_all_data2 = json_decode($result_tripn2, true);
						        $destination1 = $get_all_data2['response']['destinations'];

						        foreach ($destination1 as $cityvalue) 
						        {
						        	if($dropdown_city == $cityvalue['name'])
						        	{
									    $urls ="https://api.tripexpert.com/v1/venues?destination_id=".$cityvalue['id']."&venue_type_id=2&limit=5&api_key=5d4941cd0c3c1b9571453e237705dbfb";
								        $result_tripn = file_get_contents($urls);
								        $get_all_data = json_decode($result_tripn, true);
								        $resto_venues = $get_all_data['response']['venues'];
								        							        
								        echo "<div class='sidebar_top_hotel'>";
								    	echo "<h1>Top Restaurants in ".$cityvalue['name']."</h1>";
								        foreach ($resto_venues as $resto_venue) 
								          {
								          	echo "<div class='trip-expert'>"; 
								          		echo "<li><img src='".$resto_venue['index_photo']."'><em>#".$resto_venue['rank_in_destination']."</em></li>";
								          		echo "<div class='trip-expert-data'>"; 
								          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
								          			echo "<h3> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
								          			echo "<h4 class='city_nme'>".$cityvalue['name']."</h4>";
								          		echo "</div>";
								          	echo "</div>";
								          }
								        echo "</div>";
						        	} elseif($_SESSION['state_name'] == $cityvalue['name']) {
							        		// echo $_SESSION['city'];
							        		// echo $cityvalue['id'];
							        		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$cityvalue['id']."&venue_type_id=2&limit=5&api_key=5d4941cd0c3c1b9571453e237705dbfb";
									        $result_tripn = file_get_contents($urls);
									        $get_all_data = json_decode($result_tripn, true);
									        $resto_venues = $get_all_data['response']['venues'];

									        echo "<div class='sidebar_top_hotel'>";
									        echo "<h1>Top Restaurants in ".$cityvalue['name']."</h1>";
									        foreach ($resto_venues as $resto_venue) 
									          {
									          	echo "<div class='trip-expert'>"; 
									          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
									          		echo "<div class='trip-expert-data'>"; 
									          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
									          			echo "<h3> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
									          			echo "<h4 class='city_nme'>".$cityvalue['name']."</h4>";
									          		echo "</div>";
									          	echo "</div>";
									          }
									          echo "</div>";
									      }
						        }
						    }
						}
					} elseif($hotel_value['venue_type_id'] == 1) {
						$url1 = "https://api.tripexpert.com/v1/countries?api_key=5d4941cd0c3c1b9571453e237705dbfb";
				  		$result_tripn1 = file_get_contents($url1);
				        $get_all_data1 = json_decode($result_tripn1, true);
				        $venues1 = $get_all_data1['response']['countries'];
				        //echo $venues1['countries'];
				        foreach ($venues1 as $Vvalue) 
				        {
				        	// echo $Vvalue['name'];
				        	$get_country = @mysql_query("SELECT * FROM country WHERE country_id = '".$_SESSION['country']."'");
							$get_country_name = mysql_fetch_assoc($get_country);
							
							if($Vvalue['name'] == $get_country_name['name']) 
							{
								$url2 = "https://api.tripexpert.com/v1/destinations?country_id=".$Vvalue['id']."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
						  		$result_tripn2 = file_get_contents($url2);
						        $get_all_data2 = json_decode($result_tripn2, true);
						        $destination1 = $get_all_data2['response']['destinations'];

						        foreach ($destination1 as $cityvalue) 
						        {
						        	if($dropdown_city == $cityvalue['name'])
						        	{
						        		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$cityvalue['id']."&venue_type_id=1&limit=5&api_key=5d4941cd0c3c1b9571453e237705dbfb";
								        $result_tripn = file_get_contents($urls);
								        $get_all_data = json_decode($result_tripn, true);
								        $resto_venues = $get_all_data['response']['venues'];

								        echo "<div class='sidebar_top_hotel'>";
								    	echo "<h1>Top Hotel in ".$cityvalue['name']."</h1>";
								        foreach ($resto_venues as $resto_venue) 
								          {
								          	echo "<div class='trip-expert'>"; 
								          		echo "<li><img src='".$resto_venue['index_photo']."'><em>#".$resto_venue['rank_in_destination']."</em></li>";
								          		echo "<div class='trip-expert-data'>"; 
								          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
								          			echo "<h3> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
								          			echo "<h4 class='city_nme'>".$cityvalue['name']."</h4>";
								          		echo "</div>";
								          	echo "</div>";
								          }
								        echo "</div>";
						        	} elseif($_SESSION['state_name'] == $cityvalue['name']) {
							        		// echo $_SESSION['city'];
							        		// echo $cityvalue['id'];
							        		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$cityvalue['id']."&venue_type_id=1&limit=5&api_key=5d4941cd0c3c1b9571453e237705dbfb";
									        $result_tripn = file_get_contents($urls);
									        $get_all_data = json_decode($result_tripn, true);
									        $resto_venues = $get_all_data['response']['venues'];

									        echo "<div class='sidebar_top_hotel'>";
									        echo "<h1>Top Hotel in ".$cityvalue['name']."</h1>";
									        foreach ($resto_venues as $resto_venue) 
									          {
									          	echo "<div class='trip-expert'>"; 
									          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
									          		echo "<div class='trip-expert-data'>"; 
									          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
									          			echo "<h3> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
									          			echo "<h4 class='city_nme'>".$cityvalue['name']."</h4>";
									          		echo "</div>";
									          	echo "</div>";
									          }
									          echo "</div>";
									      }
						        }
						    }
						}
					} elseif($hotel_value['venue_type_id'] == 3) {
						$url1 = "https://api.tripexpert.com/v1/countries?api_key=5d4941cd0c3c1b9571453e237705dbfb";
				  		$result_tripn1 = file_get_contents($url1);
				        $get_all_data1 = json_decode($result_tripn1, true);
				        $venues1 = $get_all_data1['response']['countries'];
				        
				        foreach ($venues1 as $Vvalue) 
				        {
				        	$get_country = @mysql_query("SELECT * FROM country WHERE country_id = '".$_SESSION['country']."'");
							$get_country_name = mysql_fetch_assoc($get_country);
							
							if($Vvalue['name'] == $get_country_name['name']) 
							{
								$url2 = "https://api.tripexpert.com/v1/destinations?country_id=".$Vvalue['id']."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
						  		$result_tripn2 = file_get_contents($url2);
						        $get_all_data2 = json_decode($result_tripn2, true);
						        $destination1 = $get_all_data2['response']['destinations'];

						        foreach ($destination1 as $cityvalue) 
						        {
						        	if($dropdown_city == $cityvalue['name'])
						        	{
						        		
						        		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$cityvalue['id']."&venue_type_id=3&limit=5&api_key=5d4941cd0c3c1b9571453e237705dbfb";
								        $result_tripn = file_get_contents($urls);
								        $get_all_data = json_decode($result_tripn, true);
								        $resto_venues = $get_all_data['response']['venues'];

								         echo "<div class='sidebar_top_hotel'>";
								    	echo "<h1>Top Attraction in ".$cityvalue['name']."</h1>";
								        foreach ($resto_venues as $resto_venue) 
								          {
								          	echo "<div class='trip-expert'>"; 
								          		echo "<li><img src='".$resto_venue['index_photo']."'><em>#".$resto_venue['rank_in_destination']."</em></li>";
								          		echo "<div class='trip-expert-data'>"; 
								          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
								          			echo "<h3> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
								          			echo "<h4 class='city_nme'>".$cityvalue['name']."</h4>";
								          		echo "</div>";
								          	echo "</div>";
								          }
								        echo "</div>";
						        	} elseif($_SESSION['state_name'] == $cityvalue['name']) {
							        		// echo $_SESSION['city'];
							        		// echo $cityvalue['id'];
							        		$urls ="https://api.tripexpert.com/v1/venues?destination_id=".$cityvalue['id']."&venue_type_id=3&limit=5&api_key=5d4941cd0c3c1b9571453e237705dbfb";
									        $result_tripn = file_get_contents($urls);
									        $get_all_data = json_decode($result_tripn, true);
									        $resto_venues = $get_all_data['response']['venues'];

									        echo "<div class='sidebar_top_hotel'>";
									        echo "<h1>Top Attraction in ".$cityvalue['name']."</h1>";
									        foreach ($resto_venues as $resto_venue) 
									          {
									          	echo "<div class='trip-expert'>"; 
									          		echo "<li><img src='".$resto_venue['index_photo']."'></li>";
									          		echo "<div class='trip-expert-data'>"; 
									          			echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
									          			echo "<h3> <a href='details_hotel.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
									          			echo "<h4 class='city_nme'>".$cityvalue['name']."</h4>";
									          		echo "</div>";
									          	echo "</div>";
									          }
									          echo "</div>";
									      }
						        }
						    }
						}
					}
						?>
   				</div>




   			<?php }  ?>
   		</div>
   		</aside>

</div>
<div id="fullOverlay"></div>
<style type="text/css">
.publication_rating {
	border: 1px solid #ddd;
    border-radius: 3px;
    color: #f37933;
    font-weight: bold;
    padding: 2px;
}
.detial-trip-list li p {
	margin-top: 5px !important;
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
<?php $activity = (isset($_GET['activity']) ? $_GET['activity'] : 0);
			
if($activity == 1) { ?>
	<script type="text/javascript">
		$(".active_access").show();
		$("#title").hide();
		$(".v2_blog_post").css("display", "none", "important");
	</script>
<?php } ?>

<?php $activity = (isset($_GET['details']) || isset($_GET['amenites']) || isset($_POST['search_room']));
if($activity == 1) { ?>
	<script type="text/javascript">
		$(".v2_blog_post").css("display", "none", "important");
	</script>
<?php } ?>


<?php 
if(!isset($_SESSION['user_id'])){
	include('LandingPageFooter.php');
}
else{
	include('Footer.php');
}
 ?>