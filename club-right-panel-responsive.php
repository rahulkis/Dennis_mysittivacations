<?php 

$first_name=$loggedin_host_data['club_name']; 
$zipcode=$loggedin_host_data['zip_code'];
$state=$loggedin_host_data['club_state'];
$country=$loggedin_host_data['club_country'];
$city=$loggedin_host_data['club_city'];

$email=$loggedin_host_data['club_email'];
$merchant_Date = $loggedin_host_data['merchant_date'];
$image_nm=$loggedin_host_data['image_nm'];
$phone=$loggedin_host_data['club_contact_no'];
if($loggedin_host_data['DOB']==''){$dob="00/00/0000";} else $dob=$loggedin_host_data['DOB'];

$club_address=$loggedin_host_data['club_address'];
$web_url=$loggedin_host_data['web_url'];
$club_city=$loggedin_host_data['club_city'];
$club_name=$loggedin_host_data['club_name'];
$type_of_club =$loggedin_host_data['type_of_club'];
$type_details_of_club=$loggedin_host_data['type_details_of_club'];
$google_map_url=$loggedin_host_data['google_map_url'];
$profileCounter=$loggedin_host_data['profile_count'];
$q_stat=mysql_query("select name,code from zone where zone_id='$state'");	
$q_res_stat = mysql_fetch_array($q_stat);
$stat_ans=$q_res_stat['code'];

$q_city=mysql_query("select city_name,city_id  from capital_city where city_id='$club_city'");	
$q_res_city = mysql_fetch_array($q_city);
$city_ans=$q_res_city['city_name'];
$pieces = explode(" ", $loggedin_host_data['club_name']);
$username_dash_separated = implode("-", $pieces);
$username_dash_separated = clean($username_dash_separated);

$CheckStream = $loggedin_host_data['streamingLaunch'];


 /* POPUP SCRIPT GOES HERE */

$get_agrr = mysql_query("SELECT * FROM pages WHERE page_id = 9");
$agrr_row = mysql_fetch_assoc($get_agrr);

?>
<!--<script src="js/lk.popup.js"></script>-->


<style type="text/css">
#popup3responsive {
  background: #000 none repeat scroll 0 0;
  border: 4px solid #ff0;
  bottom: 0;
  height: auto;
  left: 0;
  margin: auto;
  max-height: 300px;
  max-width: 300px;
  overflow: auto;
  position: fixed;
  right: 0;
  top: 0;
  width: 92%;
  z-index: 2;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-ms-box-sizing: border-box;
}
#popup3responsive span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
#popup, #popup2responsive, #popup3responsive, .bMulti {
	background-color: #000;
	border-radius: 10px;
	box-shadow: 0 0 25px 5px #006099;
	color: #111;
	padding: 25px;
	display: none;
}
#popup3responsive span.b-close { border: none; float: right;color: #fecd07; cursor: pointer;}
	.b-modal{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:99; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}

#popup2responsive #mycontent > p {
    color: white;
    font-size: 15px;
    font-weight: bold;
}

#popup2responsive #mycontent > span {
    color: white;
}
#popup3responsive
{
	z-index: 200;
	color: #FFF;
}
#popup3responsive #mycontent > p {
  border-bottom: 1px solid #fff;
  font-size: 20px;
  margin-bottom: 10px;
  padding-bottom: 10px;
}


.v2_webcambutton {
  float: left;
  width: 40% !important;
}
.flatRoundedCheckbox {
  float: right;
  height: 25px;
  margin: 5px 0 0 ;
  position: relative;
  width: 50px;
}
.talent input[type="checkbox"] {
  visibility: hidden;
}
.flatRoundedCheckbox label {
  background: #fff none repeat scroll 0 0;
  border-radius: 50px;
  cursor: pointer;
  display: block;
  height: 25px;
  left: 0;
  position: absolute;
  top: 0px;
  transition: all 0.5s ease 0s;
  -webkit-transition: all 0.5s ease 0s;
  -ms-transition: all 0.5s ease 0s;
  -transition: all 0.5s ease 0s;
  width: 25px;
  z-index: 1;
}
.flatRoundedCheckbox input[type="checkbox"]:checked ~ div {
  background: #4fbe79 none repeat scroll 0 0;
}

.flatRoundedCheckbox div {
  background: #d3d3d3 none repeat scroll 0 0;
  border-radius: 50px;
  height: 100%;
  position: absolute;
  top: 0px;
  width: 100%;
}

.flatRoundedCheckbox input[type="checkbox"]:checked ~ label {
  left:24px;
}

.talent {
  float: right;
  width: 58%;
}

.talent .h {
  float: left;
  line-height: 34px;
}
 

@media only screen and (max-width:1180px){
  .v2_webcambutton {
  float: left;
  width: 100%;
}
a#Golivebutton {
  box-sizing: border-box; 
  float: none;
  font-weight: bold;
  height: auto; 
  margin: auto !important; 
}
.talent {
  background: #111 none repeat scroll 0 0;
  border-bottom: 1px solid #444;
  box-sizing: border-box;
  float: left;
  margin-top: 10px;
  padding: 10px 5px;
  text-align: center;
  width: 100%;
}
  .v2_webcambutton {
  float: left;
  width: 100%;
}
 .flatRoundedCheckbox label {
  background: #fff none repeat scroll 0 0;
  border-radius: 50px;
  cursor: pointer;
  display: block;
  height: 25px;
  left: 0;
  position: absolute;
  top: 0px;
  transition: all 0.5s ease 0s;
  width: 25px;
  z-index: 1;
}
.flatRoundedCheckbox div {
  background: #d3d3d3 none repeat scroll 0 0;
  border-radius: 50px;
  height: 100%;
  position: absolute;
  top: 0px;
  width: 100%;
}
.flatRoundedCheckbox {
  display: inline-block;
  float: none;
  height: 25px;
  margin: 5px 0 0 10px; 
  position: relative;
  width: 50px;
}
.h {
  display: inline-block;
  float: none;
  font-size: 12px;
  line-height: 16px;
  padding-top: 5px;
  text-align: left;
  width: auto;
}
.talent .h {
  float: left;
  line-height: 16px;
}

 }
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$(".b-close").click(function()
		{
			$('#popup3responsive, .b-modal').css('display','none');
		});
		$('#inner_popup_adv_responsive').click(function(){
			$('#popup3responsive').show();
			$('.b-modal').css('display','block','important');
			});
		
		$('#agree_merchant').click(function(){
			
			//if($('#agree_merchant').is(":checked")){
				
				var host_id = '<?php echo $_SESSION['user_id']; ?>';
				
				jQuery.post('ajaxcall.php?action=agree_merchant', {'host_id':host_id}, function(response){
					if (response == "updated") {
						window.location.href = "";
					}
					
					});
				
			//}
			
		});
		$('#disagree_merchant').click(function(){
		  
		  $('#popup3, .b-modal1').css('display','none');

			var r = confirm("All merchant pages and functions will be disabled for you !");
			
			if(r == true)
			{
				$('#disagree_merchant_desktop').attr('checked', false);
			}
			else
			{
				$('#inner_popup_adv').trigger('click');
			}
		  
		});
		
		});
</script>


<?php /* POPUP SCRIPT GOES HERE */ ?>

<div id="hide_sidebar">
 <aside class="sidebar v2_sidebar">
 	<?php 
		if( ($_SERVER['SCRIPT_NAME'] != "/dj_home.php") && ($_SERVER['SCRIPT_NAME'] != "/band_home.php") && ($_SERVER['SCRIPT_NAME'] != "/comedy_home.php") && ($_SERVER['SCRIPT_NAME'] != "/theatre_home.php") && ($_SERVER['SCRIPT_NAME'] != "/fight.php") )
 		{
 	?>
			<div class="user-profle" style="display: none;">
				<div style="font-size: 18px; color: white; float: left; width: 100%; margin-top: 10%;">  
					<?php echo $club_name; ?>
				</div>
				<div class="hostsideimage">
					<a style="text-transform: lowercase !important;" href="<?php echo $web_url; ?>" target="_blank"></a>
						<? if($image_nm!="")
						 { ?>
						  <a href="<?php echo $SiteURL; ?>home_club.php"><img src="<?php echo $SiteURL.$image_nm; ?>" height="157" width="135" /></a><br />
						 <?php } else { ?>
						   <a href="<?php echo $SiteURL; ?>home_club.php"><img src="<?php echo $SiteURL; ?>images/man4.jpg"></a>
						<?php } ?>	
					
				</div>
				<div class="hostaddress">
					<div class="addressinfo" style="float:left; width:90%;">
						<?php echo $club_address;?><br/>
						<?php echo $phone;?><br/>
				 <?php 
				if($web_url != " ")
						{
				?>
							Web Site: &nbsp; <a style="text-transform: lowercase !important;" href="<?php echo $web_url; ?>" target="_blank"> <?php echo $web_url; ?> </a>
				 <?php 	} ?>
					</div>
					<div class="hostmap" style="padding: 0px;">
						<a href="javascript:void(0);" onclick="goto('<?php echo $SiteURL; ?>view-map.php?add=<?php echo $userID;?>');"><img  src="<?php echo $SiteURL; ?>images/map-marker.png"></a>
					</div>
					<div class="profileCounter">
						Viewers: <span><?php echo $profileCounter;?></span>
					</div>
				</div>
			</div>
	<?php 	}	?>
		<div class="side_profile v2_gutter">    
		<ul class="nav_mobile_login">
            <li><a href="searchEvents.php">City Events</a></li>
            <li><a href="city_talk.php">City Talk</a></li>
            <li><a href="mysitti_contestsList.php">Contest</a></li>
            <li><a href="MySittiTV.php">Mysitti TV</a></li>
        </ul> 
			<h1><?php echo $club_name; ?> Profile</h1>
			<div class="v2_live_control">
		  		<div class="v2_webcambutton mycam">
		  			<?php 
		  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"9");
		  				/*if($data_upgrade_needed)
		  				{
		  					?>
		  					<a href="javascript:void(0);" class="button" onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')">Go Live</a>
		  					<?php
		  				}
		  				else
		  				{ */?>
				
		                  			<script language="JavaScript">
							function clean($string) {
								$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
			
								return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
							}
		                			</script>
			                        	<a href="javascript:void(0);" class="button" onclick="gotoLive('<?php echo $SiteURL; ?>live2/live_broadcast.php?username=<?php echo $username_dash_separated; ?>&clubID=<?php echo $_SESSION['user_id']; ?>');">Go Live</a>

							<!--echo '<a href="live2" target="blank" class="button">Go Live</a>';-->
		  				<?php //}

		  			?>
							<a style="display:none;" id="Viewlivebutton" class="button" name="submit"  onclick="goto1('<?php echo $SiteURL; ?>live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $userID; ?>&user_type=club')">Live Streaming
						<span class="stats_icon" ><img src="<?php echo $SiteURL; ?>images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
					</a> 
			
		  		</div>
			  	<script type="text/javascript">
					function gotoLive(url)
					{
						window.open(url,'1396358792239','width=1200,height=650,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
						document.getElementById('Golivebutton').style.display = 'none';
						document.getElementById('Viewlivebutton').style.display = 'block';
						return false;
					}
					function goto1(url)
					{
						window.open(url,'1396358792239','width=1200,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
						return false;
					}
				</script>
	  		<div class="v2_live_stresm_go livestream">
			<?php 
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"9");
  				if($data_upgrade_needed)
  				{
  					?>
  					<a  style="display:none;"  href="javascript:void(0);" class="button mylivestreaming" onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')">Live Streaming</a>
  					<?php
  				}
  				else
  				{
			
					$mobile = detect_mobile();
					if($mobile === true) 
					{ 
						if($CheckStream== '1')
						{
					?>

								<a class="button mylivestreaming" name="submit"  onclick="goto1('https://54.174.85.75:1935/httplive/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming
								<?php // comment by kbihm on 30-01-2015 if($loggedin_host_data['is_launch']=='1'){?>
								<?php if($CheckStream == '1'){ ?>
											   <span class="stats_icon" ><img src="<?php echo $SiteURL; ?>images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
										  <?php } else{ ?>
											  <span class="stats_icon" ><img src="<?php echo $SiteURL; ?>images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
										  <?php } ?>                     	
								
								</a> 
			<? 			}
					}
					else
					{
						if($CheckStream == '1')
						{
		?>

								<a class="button mylivestreaming" name="submit"  onclick="goto1('<?php echo $SiteURL; ?>live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $userID; ?>&user_type=club')">Live Streaming
								<?php // comment by kbihm on 30-01-2015 if($loggedin_host_data['is_launch']=='1'){?>
								<?php if($CheckStream == '1'){ ?>
											   <span class="stats_icon" ><img src="<?php echo $SiteURL; ?>images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
										  <?php } else{ ?>
											  <span class="stats_icon" ><img src="<?php echo $SiteURL; ?>images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
										  <?php } ?>                     	
								
								</a>
		<?php 				}
					}
				}  

				$getFunctionSettings = mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '$_SESSION[user_id]' ");
				$fetchAllfunction = mysql_fetch_assoc($getFunctionSettings);
				$getInfo = mysql_query("SELECT `profileType` FROM `clubs` WHERE `id` = '$_SESSION[user_id]' ");
$fetchInfo = mysql_fetch_assoc($getInfo);
			?>			
		  </div>
		<!-- <span class="talent">
			<div class="h">Show on Talent page?</div> 
			<div class="flatRoundedCheckbox">
				<input type="checkbox" name="" id="flatOneRoundedCheckbox" <?php if($fetchInfo['profileType'] == 'Public'){ echo 'checked';}?> >
				<label for="flatOneRoundedCheckbox"></label>
				<div>
					
				</div>
			</div>
		</span> -->
		<script type="text/javascript">
			$(document).ready(function(){
				/*$('#flatOneRoundedCheckbox').change(function(){
					
					$.blockUI({ css: {
							border: 'none',
							padding: '15px',
							backgroundColor: '#fecd07',
									'-webkit-border-radius': '10px',
									'-moz-border-radius': '10px',
							opacity: .8,
							color: '#000'
						},
						message: '<h1>Saving Profile Security.</h1>'
					});

					if($('#flatOneRoundedCheckbox').is(':checked'))
					{
						//alert('yes');
						$.ajax({
							type: "POST",
							url: "refreshajax.php",
							data: {
								'action' : 'profileSecurity',
								'value' : 'public',
							},
							success: function(data){
								
								$.unblockUI();
							}
						});
					
					}
					else
					{
						//alert('false');
						$.ajax({
							type: "POST",
							url: "refreshajax.php",
							data: {
								'action' : 'profileSecurity',
								'value' : 'private',
							},
							success: function(data){
								
								$.unblockUI();
							}
						});
					}


					
				});*/
			});
		</script>
		</div>
		<div class="searchBoxMobile">
			<div class="searchMobile">
				<form method="POST" action="<?php echo $SiteURL."searchUsers.php";?>" id="searchUsersForm">
				<input type="text" id="searchUsers" value="" name="keyword_search" placeholder="Search By Username" class="adSearchmob">
				<input type="submit" id="findContestant" class="searchBoxTopBtn" name="SearchAllUsers" value="">
			</form>
			</div>
		</div>
			<ul class="v2_nav_right">
     <li class="menuForMobile"> <a href="<?php echo $SiteURL; ?>home_club.php" class="black_text"> <span data-title="Home">Home</span> </a> </li>
				<li><a href="<?php echo $SiteURL; ?>user_search.php" class="black_text"> <span>Invite Friends</span> </a> </li>
				<li>  <a href="<?php echo $SiteURL; ?>edit_profile.php"> <span>Edit</span> </a> </li>
				<!-- <li><a href="streamingSettings.php" class="black_text"><span>Streaming Settings</span></a></li> -->
			<?php
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"24");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>About</span><?php if($fetchAllfunction['bio'] != 'Enable'){ echo '<i></i>'; }?></a></li>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Fan Page</span></a></li>
  					<?php
  				}
  				else
  				{

			?>
					<li>  <a href="<?php echo $SiteURL; ?>hostdj_profile.php"> <span>About</span><?php if($fetchAllfunction['bio'] != 'Enable'){ echo '<i></i>'; }?></a> </li>
					<li>  <a href="<?php echo $SiteURL; ?>clubprofile.php"> <span>Fan Page</span> </a> </li>
		<?php 		}	?>
				<li> <a href="<?php echo $SiteURL; ?>upload_photo.php"> <span>Photos</span> </a> </li>
				<li>  <a href="<?php echo $SiteURL; ?>upload_video.php"> <span>Videos</span> </a> </li>
		<?php
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"8");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Connections</span></a></li>
  					<?php
  				}
  				else
  				{
  		?>
					<li>  <a href="<?php echo $SiteURL; ?>all_connections.php" class="black_text"> <span>Fans</span> </a> </li>
		<?php 		}	?>

		<?php 
				$type_of_club_array = array('91','92','97');
				if(in_array($type_of_club, $type_of_club_array))
				{
					?>
				<li>  <a href="<?php echo $SiteURL; ?>subuserList.php" class="black_text"> <span>Manage Users</span> </a> </li>
		<?php 	}	?>
		<?php 
				if($type_of_club == "103")
				{
					?>
					<li><a href="<?php echo $SiteURL; ?>instructors.php" class="black_text"><span>Instructors</span></a></li>
					<li><a href="<?php echo $SiteURL; ?>fightersList.php" class="black_text"><span>Fighters</span></a></li>

					<?php 
				}
				if($type_of_club == "107" || $type_of_club == "109")
				{
					?>
					<li><a href="<?php echo $SiteURL; ?>artistList.php" class="black_text"><span>Artists</span></a></li>
					<?php 
				}
			?>
<!-- 				
				<li><a href="reset_password.php" class="black_text"><span>Reset Password</span></a></li>
				<li><a href="upload_streamingVideo.php" class="black_text"><span>Streaming Videos</span></a></li>
				<li><a href="streaming-tickets.php" class="black_text"><span>Streaming Tickets</span></a></li> -->
				<li>
					<div class="prvtzonedv"> 
					  <h4 class="prvtzoneh4"> Promotions </h4>
					</div>
				</li>
		<?php
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"5");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Pass Give Away</span></a></li>
  					<?php
  				}
  				else
  				{
  		?>
  					<li><a href="<?php echo $SiteURL; ?>host_coupon.php"> <span>Pass Give away</span> </a></li>
  		<?php 		}	?>


  					<li><a href="<?php echo $SiteURL;?>EPKlist.php"> <span>Electronic Press Kit </span> </a></li>



					<li><a href="<?php echo $SiteURL; ?>paid-tickets.php"> <span>Paid Tickets</span> </a></li>
					<li><a href="<?php echo $SiteURL; ?>host_advertise.php"> <span>Advertisements</span></a> </li>
  		<?php
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"14");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Calendar</span></a></li>
  					<?php
  				}
  				else
  				{
  		?>
  					<li><a href="<?php echo $SiteURL; ?>eventscalendar.php"> <span>Calendar</span></a></li> 
  					<li><a href="<?php echo $SiteURL; ?>listevent.php"> <span>Events</span></a></li> 
  		<?php 		}	?>

  		<?php
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"7");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Social Media Sites</span></a></li>
  					<?php
  				}
  				else
  				{
  		?>
  					<li>  <a href="<?php echo $SiteURL; ?>user_social.php?user=host" class="users"><span>Social Media Sites</span></a></li> 
  		<?php 		}	?>
  		<?php
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"11");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Contest</span></a></li>
  					<?php
  				}
  				else
  				{
  		?>
  					<li><a href="<?php echo $SiteURL; ?>contests_list.php"> <span>Contest</span></a> </li>
  		<?php 		}	?>
  		<?php
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"3");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Shout Out</span></a></li>
  					<?php
  				}
  				else
  				{
  		?>
  					<li><a href="<?php echo $SiteURL; ?>shout.php"> <span>Shout Out</span></a></li>
  		<?php 		}	?>

						
				<li><a href="<?php echo $SiteURL; ?>sponsor.php" class="black_text"><span>Sponsors</span></a></li>
				<li>
					<div class="prvtzonedv"> 
						<h4 class="prvtzoneh4"> Merchandise </h4>
					</div>
				</li>
		</ul>
		<ul class="v2_nav_right popup_adv_responsive" id="popup_adv_responsive">
			<?php if($merchant_Date == "0000-00-00 00:00:00"){ ?>
			<div id="inner_popup_adv_responsive"></div>
			<?php } ?>
		<?php
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"21");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Store</span><?php if($fetchAllfunction['store'] != 'Enable'){ echo '<i></i>'; }?></a></li>
  					<?php
  				}
  				else
  				{
  		?>
  					<li>  <a href="<?php echo $SiteURL; ?>store.php" class="users"><span>Store</span><?php if($fetchAllfunction['store'] != 'Enable'){ echo '<i></i>'; }?></a></li>
  		<?php 		}	?>

						<style type="text/css">
						.slidedown {
							/*background: url("../../images/profile_arrow.png") no-repeat scroll 10px center rgba(0, 0, 0, 0);*/
							border-bottom: 1px solid #282829;
							float: left;
							width: 100%;
						}
						.slidedown ul
						{
							background: none !important;
							border: none !important;
						}
						.slidedown .acc_content li
						{
							border: none !important;
						}
						.slidedown .acc_content li a
						{
							border: none !important;
						}
						</style>

		<?php
		$array_cats = array('96','102','103','105','106');
			if(!in_array($type_of_club, $array_cats))
			{
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"16");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Jukebox</span><?php if($fetchAllfunction['jukebox'] != 'Enable'){ echo '<i></i>'; }?></a></li>
					<?php
				}
				else
				{
		?>
					<li class="slidedown">
							<ul class="filter123" style="margin-top: 0px !important;">
								<li>
									<div><?php if($fetchAllfunction['bio'] != 'Enable'){ echo '<i>Jukebox</i>'; }else{ echo 'Jukebox';}?></div>
									<ul>
       
										<li><a href="<?php echo $SiteURL; ?>music_request.php?host_id=<?php echo $_SESSION['user_id']; ?>"> <span>View Jukebox</span></a></li>
										<li>
											<a href="<?php echo $SiteURL; ?>musicrequestList.php"> <span>Music Request</span>
												<?php  	
													$jukeboxreqquery = @mysql_query("SELECT * FROM `userplaylist` WHERE host_id='".$_SESSION['user_id']."' AND `status` = '1' ");
													$jukeboxreqfetch = @mysql_fetch_array($jukeboxreqquery);
													$countjukeboxreq = @mysql_num_rows($jukeboxreqquery);
													if($countjukeboxreq > 0 ) 
													{ ?>
														<div class="unread fl" style=""> 
															<?php echo $countjukeboxreq;?> 
														</div>
												<?php 	} ?>
											</a>
										</li>
										<li><a href="<?php echo $SiteURL; ?>musicplaylists.php"> <span>Play List</span></a></li>
										<li><a href="<?php echo $SiteURL; ?>settingslist.php"> <span>Settings</span></a></li>
									</ul>
								</li>
							</ul>
						</li>
		<?php 		
				}	
			} // END CHECK FOR CATS	

			if(in_array($type_of_club, array('96','101','97','108')))
			{
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"20");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Upload</span><?php if($fetchAllfunction['uploads'] != 'Enable'){ echo '<i></i>'; }?></a></li>
  					<?php
  				}
  				else
  				{
  		?>
  					<li class="slidedown">
						<ul class="filter123" style="margin-top: 0px !important;">
							<li>
								<div><?php if($fetchAllfunction['uploads'] != 'Enable'){ echo '<i>Upload</i>'; }else{ echo 'Upload';}?></div>
								<ul>
									<li><a href="<?php echo $SiteURL; ?>music.php"><span> Single</span></a></li>
									<li><a href="<?php echo $SiteURL; ?>cds.php"><span> CD </span></a></li>
									<li><a href="<?php echo $SiteURL; ?>video_clips.php"><span> Video </span></a></li>
									<li><a href="<?php echo $SiteURL; ?>uploadSettings.php"> <span>Uploads Settings</span></a></li>
								</ul>
							</li>
						</ul>
					</li>
  		<?php 		}
  			}
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"17");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Bookings</span><?php if($fetchAllfunction['booking'] != 'Enable'){ echo '<i></i>'; }?></a></li>
  					<?php
  				}
  				else
  				{
  		?>
  					<li class="slidedown">
						<ul class="filter123" style="margin-top: 0px !important;">
							<li>
								<div><?php if($fetchAllfunction['booking'] != 'Enable'){ echo '<i>Booking</i>'; }else{ echo 'Booking';}?></div>
								<ul>
									<li><a href="<?php echo $SiteURL; ?>bookings.php"> <span>Bookings</span> <?php /*if($_SESSION['notification']>0){ ?><div class="unread fl" style=""> <?php /*echo $ur_con_s;  echo $_SESSION['notification']; ?>  </div><?php } */?></a> <?php //} ?></li>
									<li><a href="<?php echo $SiteURL; ?>bookingstype.php"> <span>Booking Types</span></a></li>
									<li><a href="<?php echo $SiteURL; ?>bookingSettings.php"> <span>Booking Settings</span></a></li>
								</ul>
							</li>
						</ul>
					</li>
  		<?php 		}	?>

  				<li class="slidedown">
					<ul class="filter123" style="margin-top: 0px !important;">
						<li>
							<div>Streaming</div>
							<ul>
								<li><a href="<?php echo $SiteURL; ?>streamingSettings.php"><span>Settings</span></a></li>
								<li><a href="<?php echo $SiteURL; ?>upload_streamingVideo.php"><span>Videos</span></a></li>
								<li><a href="<?php echo $SiteURL; ?>streaming-tickets.php"><span>Ticket Tracking</span></a></li>
							</ul>
						</li>
					</ul>
				</li>
					<li class="menuForMobile logout"><a href="<?php echo $SiteURL; ?>main/logout.php"><span data-title="Logout">Logout</span></a></li>  	
			</ul>
		</div>
	</aside>
</div>
<?php
if($merchant_Date == "0000-00-00 00:00:00"){ ?>
<style>
#popup_adv_responsive {
    float: left;
    position: relative;
    width: 100%;
}

.b-modal {
  background: transparent none repeat scroll 0 0;
 display:none !important;
}
#inner_popup_adv_responsive {
    float: left;
    height: 100%;
    position: absolute;
    width: 100%;
    z-index: 99;
}	
</style>
<!--<div class="b-modal" id="b-modal __b-popup1__" style=""></div>-->
<div id="popup3responsive" style="">
	<span class="b-close">X</span>
	<div id="mycontent" style="height: auto; width: auto;">
		<?php echo $agrr_row['page_data']; ?>
		<!-- <input type="checkbox" id="agree_merchant"> <span>Agree & don't show this message again.</span> -->
		<div class="controlArea">
    			<a href="javascript:void(0);" id="agree_merchant">YES<br />Agree</a> 
    			<a href="javascript:void(0);" id="disagree_merchant">NO<br />Disagree</a>
    		</div>
	</div>
</div>


<?php } ?>
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