<?php
if($hostID == "")
{
	if(isset($_GET['host_id']))
	{
		$hostID = $_GET['host_id']; 
	}
	else
	{
		$hostID = $_GET['id']; 
	}
}
 $sql = "select * from `clubs` where `id` = 694";
$userArray = $Obj->select($sql) ; 
print_r($userArray);
$first_name=$userArray[0]['club_name']; 
$zipcode=$userArray[0]['zip_code'];
$state=$userArray[0]['club_state'];
$country=$userArray[0]['club_country'];
$city=$userArray[0]['club_city'];
$web_url=$userArray[0]['web_url'];

$email=$userArray[0]['club_email'];
//$image_nm=$userArray[0]['image_nm'];
$phone=$userArray[0]['club_contact_no'];
$plantype = $userArray[0]['plantype'];
$hideaddress = $userArray[0]['hideaddress'];
if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];

$club_address=$userArray[0]['club_address'];
$club_city=$userArray[0]['club_city'];
$club_name=$userArray[0]['club_name'];
$type_of_club =$userArray[0]['type_of_club'];
$type_details_of_club=$userArray[0]['type_details_of_club'];
$google_map_url=$userArray[0]['google_map_url'];
$profileCounter=$userArray[0]['profile_count'];

$q_stat=mysql_query("select name,code from zone where zone_id='$state'");	
$q_res_stat = mysql_fetch_array($q_stat);
$stat_ans=$q_res_stat['code'];

$q_city=mysql_query("select city_name,city_id  from capital_city where city_id='$club_city'");	
$q_res_city = mysql_fetch_array($q_city);
$city_ans=$q_res_city['city_name'];
$memberType = $userArray[0]['non_member'];

$CheckStream = $userArray[0]['streamingLaunch'];



/* FOR COUPON */

$sql_fe=mysql_query("select * from  host_coupon where host_id='".$hostID."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);
/// end here 

// get user info about download current pass or not 
 $download_info=@mysql_query("select id  from   coupon_download where coupon_id='".$rw_row_fe['id']."' AND user_id='".$_SESSION['user_id']."' ");
  $download_num=@mysql_num_rows($download_info);
 // end here 
   // get total count of downloaded coupon
  $tot_cu_cnt=@mysql_query("select id from  coupon_download where coupon_id='".$rw_row_fe['id']."' ");
  $cu_num=@mysql_num_rows($tot_cu_cnt);

/*****/




// check for host 
  $host_details=@mysql_query("select status from  friends where friend_id='".$hostID."' AND user_id='".$_SESSION['user_id']."' AND friend_type='club'");
  $club_dtl=@mysql_fetch_assoc($host_details);
 if(!empty($_POST['search']))
{ $state = $_POST['state'];
  $city = $_POST['city'];
  $_SESSION['state'] = $_POST['state'];
  $_SESSION['id'] = $_POST['city_name'];
  $sql="SELECT * FROM `contest` where `status`='1' and contest_city='".$city."' ORDER BY `contest_id` AND user_id = 0 AND host_id = '$userID' DESC limit 1";
}
else{
  $cityid = $_SESSION['id'];
  $date = date('Y-m-d');
  $sql="SELECT * FROM `contest` where `status`='1' AND `contest_end` > '$date'  AND contest_city='".$cityid."'  ORDER BY `contest_id` AND host_id = '$userID' AND user_id = 0 DESC limit 1";
}

  $contest_list = $Obj->select($sql);

  $contest_id=$contest_list[0]['contest_id'];
  $contest_title=$contest_list[0]['contest_title']; 
// 
//echo "select * from host_functions_setting where host_id='$hostID'   ";
	$getstatuslink=mysql_query("select * from host_functions_setting where host_id='$hostID'   ");
	$fetchstatuslink = @mysql_fetch_array($getstatuslink);


?>

<div id="hide_sidebar">
<aside class="sidebar v2_sidebar"> 
	<?php 

//echo $_SERVER['SCRIPT_NAME'];

		//if($_SERVER['SCRIPT_NAME'] != "/promoter_home.php" && $_SERVER['SCRIPT_NAME'] != "/artist_home.php" && $_SERVER['SCRIPT_NAME'] != "/dj_home.php" && $_SERVER['SCRIPT_NAME'] != "/band_home.php" &&  (!preg_match("/\buser=\b/i", $_SERVER['argv'][0])) && ($_SERVER['SCRIPT_NAME'] != "/comedy_home.php") && ($_SERVER['SCRIPT_NAME'] != "/fight_home.php") && ($_SERVER['SCRIPT_NAME'] != "/theatre_home.php") )
		//{
	?>
	<!--<div class="user-profle" >
	<div class="no_skew">
		<h3 id="title">
			<?php echo $club_name; ?>
		</h3>
		<div class="hostsideimage">
			<a href="<?php echo $web_url; ?>" target="_blank">
				<? if(!empty($userArray[0]['image_nm']))
				 { ?>
				  <a href="host_profile.php?host_id=<? echo $hostID;?>"> <img src="<?php echo$userArray[0]['image_nm']; ?>" height="157" width="135" /></a><br />
				 <?php } else { ?>
				  <a href="host_profile.php?host_id=<? echo $hostID;?>"><img src="images/man4.jpg"></a>
				<?php } ?>  
			</a>
		</div>
		
		<div class="hostaddress">
			<div class="addressinfo">
				<div>
				<?php 
				if($hideaddress != 1)
				{
					if($userArray[0]['show_city_state_phone'] == '1')
					{
						$cityID =  $userArray[0]['club_city'];
						$stateID = $userArray[0]['club_state'];
						$getClubCity = mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$cityID' ");
						$fetchClubCity = mysql_fetch_assoc($getClubCity);
						$getClubState = mysql_query("SELECT * FROM `zone` WHERE `zone_id` = '$stateID' ");
						$fetchClubState = mysql_fetch_assoc($getClubState);
						echo $fetchClubCity['city_name'].", ".$fetchClubState['name']."<br />";
						echo $phone."<br />";
					}
					else
					{
						echo $club_address;
						echo "<br/>";
						echo $phone;
						echo "<br/>";
					}
				}
				if(!empty($web_url))
				{
			?>
					Web Site: &nbsp; <a style="text-transform: lowercase !important;" href="<?php echo $web_url; ?>" target="_blank"> <?php echo $web_url; ?> </a>
		 <?php 	} ?>
				 </div>
			</div>
		<?php 
				if($hideaddress != 1)
				{
					if($userArray[0]['hide_google_map'] == '0')
					{
		?>
					<div class="hostmap">
						<a href="javascript:void(0);" onclick="goto('view-map.php?add=<?php echo $hostID;?>');"><img  src="images/map-marker.png"></a>
					</div>
	<?php 				} 
				}
			?>
			<div class="profileCounter">
				Viewers: <span><?php echo $profileCounter;?></span>
			</div>
			<div class="clear"></div>
						<br />
						 <?php if($memberType == "1" && isset($_SESSION['user_id'])){?>
						<div class="dj_claim band_claim"> <a class="button" name="submit" onclick="claimClub('claimClub.php?host_id=<?php echo $hostID; ?>')" href="javascript:void(0);">Claim </a> </div>
						<?php } ?>
		</div>
 </div>
	</div>-->
<?php 	//}	?>
<script type="text/javascript">
	function goto1(url)
	{
		window.open(url,'1396358792239','width=1200,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
		return false;
	}
</script>
<script>
function goto(url)
{
  window.open(url,'1396358792239','width=1000,height=670,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
  return false;
}

function savehost(id,ac)
{
	// alert('ss');
	// return false;
	$.ajax({
		type: "POST",
		url: "savehost.php",
		data: {
			'host_id' : id,
			'action' : ac,
		},
		success: function(data){
			window.location.href = "host_profile.php?host_id="+id;

		}
	});
return false;

}

function goto12(url)
{
	//alert("Please Login to see the streaming.");
	//return false;
	window.open(url,'1396358792239','width=300,height=300,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=0,left=0,top=0');
	return false;
}

</script>
	<div class="side_profile v2_gutter">
		<h1><?php echo $club_name;?> Profile</h1>
		<div class="v2_live_control">
			<div class="v2_webcambutton liveScam">
				<?php 
					$pieces = explode(" ", $club_name);
					$username_dash_separated = implode("-", $pieces);	
					$username_dash_separated = clean($username_dash_separated);  								
					$mobile = detect_mobile();
					if($mobile === true) 
					{ 
					?>

						<a class="button mylivestreaming" name="submit"  onclick="goto1('https://54.174.85.75:1935/httplive/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming
						<?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
						<?php if($CheckStream== '1'){ ?>
									   <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
								  <?php } else{ ?>
									  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
								  <?php } ?>                     	
						
						</a> 
			<? 		}
					else
					{
						if(empty($_SESSION['user_id']) )
						{
?>
							<a class="button mylivestreaming" name="submit"  onclick="goto12('live2/loginpop.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $hostID; ?>&user_type=club')">Live Streaming
<?php
						}
						else
						{
							
						?>		<a class="button mylivestreaming" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $hostID; ?>&user_type=club')">Live Streaming
						<?php	
						}
		?>

						
						<?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
						<?php if($CheckStream== '1'){ ?>
									   <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
								  <?php } else{ ?>
									  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
								  <?php } ?>                     	
						
						</a>
		<?php 			}	  			?>
			</div>
			<div class="v2_live_stresm_go">
			<?php 
				if(isset($_SESSION['user_id']) )
				{
					if($club_dtl['status']=='active') 
					{
			?>
						<a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a>
			<?php 		}
					else if($club_dtl['status']=='block') 
					{
			?>
						<a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a>
			<?php 		}
					else
					{
			?>
						<a onclick="savehost('<?php echo $hostID;?>','request')" href="" class="button follow_hostc" id="request">Follow Host</a>
						<!-- <input type="submit" id="request" class="button follow_hostc" value="Follow Host" name="submit" > -->
		<?php 			} 
				}
			?>
			</div>
		</div><!-- END .unblockalgn -->

		<div class="searchBoxMobile">
	<div class="searchMobile">
		<form method="POST" action="<?php echo $SiteURL."searchUsers.php";?>" id="searchUsersForm">
		<input type="text" id="searchUsers" value="" name="keyword_search" placeholder="Search By Username" class="adSearchmob">
		<input type="submit" id="findContestant" class="searchBoxTopBtn" name="SearchAllUsers" value="">
	</form>
	</div>
</div>

		<ul class="v2_nav_right" id="home-left-nav" style="margin: 0px;">
<li class="menuForMobile"> <a href="home_club.php"> <span data-title="Home">Home</span> </a> </li>
		<?php 
			$mq = @mysql_query("SELECT * FROM `host_dj_profile` WHERE `host_id` = '$hostID' ");
			$fq = @mysql_fetch_array($mq);
			$data_upgrade_needed=chk_upgrade_needed($plantype,"24");
			if(!$data_upgrade_needed)
			{
				
				if($fetchstatuslink['bio']!= "Disable without message")
				{
	?>
					<li>
						<a href="hostdj_profile.php?host_id=<?php echo $hostID; ?>">
							<span>About</span>
						</a>
					</li>
	<?php 			}	?>
					
					<li><a href="clubprofile.php?host_id=<?php echo $hostID; ?>"> <span>Fan Page</span></a></li>

	<?php		} // END CHECK FOR PACKAGE	?>
				
				<li><a href="upload_photo.php?host_id=<?php echo $hostID; ?>"> <span>Photos</span></a></li>
				<li><a href="upload_video.php?host_id=<?php echo $hostID; ?>"> <span>Videos</span></a></li>
	<?php
			$data_upgrade_needed=chk_upgrade_needed($plantype,"8");
			if(!$data_upgrade_needed)
			{
				?>
				<li><a href="eventscalendar.php<?php if(isset($hostID)){ echo "?host_id=".$hostID;}?>">  <span>Calendar</span> </a></li>
	<?php 		}	
			
			$data_upgrade_needed=chk_upgrade_needed($plantype,"13");
			if(!$data_upgrade_needed)
			{
	?>
				<li><a href="listevent.php<? if(isset($hostID)){ echo "?host_id=".$hostID;}?>"> <span>Upcoming Events</span></a></li>
	<?php		}	?>
	<?php 	if($type_of_club == '103')
		{
			?>
			<li><a href="instructors.php?host_id=<?php echo $hostID;?>" class="black_text"><span>Instructors</span></a></li>
			<li><a href="fightersList.php?host_id=<?php echo $hostID;?>" class="black_text"><span>Fighters</span></a></li>
	<?php 	}	
		if($type_of_club == "107" || $type_of_club == "109")
		{
			?>
			<li><a href="artistList.php?host_id=<?php echo $hostID;?>" class="black_text"><span>Artists</span></a></li>
			<?php 
		}
	?>
			<li>
				<a href="sponsor.php?host_id=<?php echo $hostID;?>" class="black_text">
					  <?php if($type_of_club == "109"){ ?>
						<span>Networking Cornor</span>
					  <?php }else{ ?>
						<span>Sponsors</span>
					  <?php } ?>
				</a>
			</li>
			<!-- <li><a href="paidPasses.php?host_id=<?php echo $hostID;?>" class="black_text"><span>Buy Tickets</span></a></li> -->
			
			<!--<li><a href="purchase-streaming-tickets.php?host_id=<?php echo $hostID;?>" class="black_text"><span>Streaming Tickets</span></a></li>-->
			<li style="float: left;" id="back_none" class="firstheading prvtzone">
				<div class="prvtzonedv">
						<h4 class="prvtzoneh4"> Promotions <?php //echo $fetchstatuslink['contest'];?></h4>
				</div>
			</li>
	<?php 
		$getDefaulktEPK = mysql_query("SELECT * FROM `epk_host_info` WHERE `host_id` = '$hostID' AND `status` = '1' ");
		if(mysql_num_rows($getDefaulktEPK) > 0)
		{
			$getResultEPK = mysql_fetch_assoc($getDefaulktEPK);
			?>
				<li>
					<a href="<?php echo $SiteURL;?>viewEPK.php?Uid=<?php echo $getResultEPK['epkId'];?>&amp;host_id=<?php echo $hostID; ?>">
						<span>Electronic Press Kit </span>
					</a>
				</li>

			<?php 
		}
	?>





	<?php	

			$data_upgrade_needed=chk_upgrade_needed($plantype,"11");
			if(!$data_upgrade_needed)
			{
			
				if($fetchstatuslink['contest'] != "Disable without message")
				{
						?>
					
					<li>
						<a href="all_contests.php?host_id=<?php echo $hostID; ?>">
							<span>Contest </span>
						</a>
					</li>
	<?php 			}	
			}			?>
					<li style="float: left;" id="back_none" class="firstheading prvtzone">
						<div class="prvtzonedv">
							<h4 class="prvtzoneh4"> Merchandise</h4>
						</div>
					</li>
	<?php

			$data_upgrade_needed=chk_upgrade_needed($plantype,"21");
			if(!$data_upgrade_needed)
			{
				if($fetchstatuslink['store']!= "Disable without message")
				{
					if($_SESSION['user_type'] == 'user')
					{
		?>
						<li>
							<a href="host_store.php?host_id=<?php echo $hostID; ?>"> <span>Shop</span></a>
						</li>
		<?php  			}
					elseif(!isset($_SESSION['user_id']))
					{
						?>
							<li><a href="host_store.php?host_id=<?php echo $hostID; ?>" onclick="openLoginpop($(this).prop('href')); return false;" ><span>Shop</span></a></li>
		<?php			}
				}
			}

			$data_upgrade_needed=chk_upgrade_needed($plantype,"17");
			if(!$data_upgrade_needed)
			{
				if($fetchstatuslink['booking']!= "Disable without message")
				{
					if(!isset($_SESSION['user_id']))
					{
						?>
						<li>
							<!-- <a href="bookme.php?host_id=<?php echo $hostID; ?>" onclick="openLoginpop($(this).prop('href')); return false;" > -->
							<a href="<?php echo $SiteURL;?>bookingTypesList.php?host_id=<?php echo $hostID; ?>" onclick="openLoginpop($(this).prop('href')); return false;" >
								<span>Bookings</span>
							</a>
						</li>
		<?php			}
					else
					{
		?>
						<li>		
							<a href="<?php echo $SiteURL;?>bookingTypesList.php?host_id=<?php echo $hostID; ?>"> 
								<span>Bookings</span>
							</a>
						</li>
	<?php 				}
				}
			}
				  
			$data_upgrade_needed=chk_upgrade_needed($plantype,"20");
			if(!$data_upgrade_needed)
			{
				if($fetchstatuslink['uploads']!= "Disable without message")
				{
					if(!isset($_SESSION['user_id']))
					{
						?>
						<li><a href="musiccds.php?host_id=<?php echo $hostID;?>" onclick="openLoginpop($(this).prop('href')); return false;" ><span>Music & CDs</span></a></li>
		<?php			}
					else
					{
			?>
						<li>
							<a href="musiccds.php?host_id=<?php echo $hostID; ?>"> <span>Music & CDs</span></a>
						</li>
		<?php 			}
				}
			}
		$array_cats = array('96','102','103','105');
		if(!in_array($type_of_club, $array_cats))
		{


			$query = mysql_query("SELECT musicrequeststatus FROM clubs WHERE id = '$hostID'");
			$res= mysql_fetch_array($query);
			if($res['musicrequeststatus'] == '1')
			{

			}
			else
			{
				$check_req_query = mysql_query("SELECT disable_music_req FROM music_settings WHERE user_id = '$hostID'");
				$get_check_res = mysql_fetch_assoc($check_req_query);
				$disable_music_req = $get_check_res['disable_music_req'];
				$data_upgrade_needed=chk_upgrade_needed($plantype,"16");
				if(!$data_upgrade_needed)
				{
					if($disable_music_req == 1)
					{
			?>
						<li><a onclick="alert('Request is disabled from the host');" href="javascript:void(0);"><span>Music Request</span></a></li>
						
		<?php     		}
					else
					{
						if(!isset($_SESSION['user_id']))
						{
							?>
							<li><a href="music_request.php?host_id=<?php echo $hostID; ?>" onclick="openLoginpop($(this).prop('href')); return false;" ><span>Music Request </span></a></li>
		<?php				}
						elseif($fetchstatuslink['jukebox']!= "Disable without message")
						{
							echo '<li><a href="music_request.php?host_id='.$hostID.'"><span>Music Request </span></a></li>';
						}
					}
				  }
			}
		}
	?>
		  <li class="menuForMobile"><a href="<?php echo $SiteURL; ?>main/logout.php"><span data-title="Logout">Logout</span></a></li>   
		</ul>
	</div>
</aside>
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
