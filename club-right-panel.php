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

$getInfo = mysql_query("SELECT `profileType` FROM `clubs` WHERE `id` = '$_SESSION[user_id]' ");
$fetchInfo = mysql_fetch_assoc($getInfo);

 /* POPUP SCRIPT GOES HERE */

$get_agrr = mysql_query("SELECT * FROM pages WHERE page_id = 9");
$agrr_row = mysql_fetch_assoc($get_agrr);

?>
<!--<script src="js/lk.popup.js"></script>-->


<style type="text/css">
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
#popup3 {
  background: #000 none repeat scroll 0 0;
  border: 4px solid #ff0;
  bottom: 0;
  height: auto;
  left: 0;
  margin: auto;
  max-height: 800px;
  max-width: 600px;
  overflow: auto;
  position: fixed;
  right: 0;
  top: 0;
   box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-ms-box-sizing: border-box;
  width: 100% !important;
  z-index: 2;
}
#popup3 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
#popup, #popup2, #popup3, .bMulti {
	background-color: #000;
	border-radius: 10px;
	box-shadow: 0 0 25px 5px #006099;
	color: #111;
	padding: 25px;
	display: none;
}
#popup3 span.b-close { border: none; float: right;color: #fecd07; cursor: pointer;}
	.b-modal1{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:99; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}

#popup2 #mycontent > p {
    color: white;
    font-size: 15px;
    font-weight: bold;
}

#popup2 #mycontent > span {
    color: white;
}
#popup3
{
	z-index: 200;
	color: #FFF;
}
#popup3 #mycontent > p {
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
  width: 40%;
}

.talent .h {
  float: left;
  line-height: 34px;
  color: #FFF;
}
 .controlArea {width:100%; float:left; text-align:center;}
 
 .controlArea a {
  display: inline-block;
  margin: 10px 10px;
  padding: 5px 40px;
  border: 1px solid #fecd07;
  color: #fecd07;
  font-weight:bold;
  text-decoration: none;
}

 .controlArea a:hover {background:#fecd07;color:#000;}
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
 
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$(".b-close").click(function()
		{
			$('#popup3, .b-modal1').css('display','none');
		});
		$('#inner_popup_adv').click(function(){
			$('#popup3').show();
			$('.b-modal1').css('display','block','important');
		});
		
		$('#agree_merchant_desktop').click(function(){
			
			//if($('#agree_merchant_desktop').is(":checked")){
				
				var host_id = '<?php echo $_SESSION['user_id']; ?>';
				
				jQuery.post('ajaxcall.php?action=agree_merchant', {'host_id':host_id}, function(response){
					if (response == "updated") {
						window.location.href = "";
					}
					
					});
				
			//}
			
		});

		// $('#agree_merchant').click(function(){
			
		// 	//if($('#agree_merchant_desktop').is(":checked")){
				
		// 		var host_id = '<?php echo $_SESSION['user_id']; ?>';
				
		// 		jQuery.post('ajaxcall.php?action=agree_merchant', {'host_id':host_id}, function(response){
		// 			if (response == "updated") {
		// 				window.location.href = "";
		// 			}
					
		// 			});
				
		// 	//}
			
		// });
		
		$('#disagree_merchant_desktop').click(function(){
		  
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
			<div class="user-profle" style="display: none !important;">
				<div style="font-size: 18px; color: white; float: left; width: 100%; margin-top: 10%;">  
					<?php echo $club_name; ?>
				</div>
				<div class="hostsideimage">
					<a style="text-transform: lowercase !important;" href="<?php echo $web_url; ?>" target="_blank"></a>
						<? if($image_nm!="")
						 { ?>
						  <a href="/home_club.php"><img src="<?php echo $image_nm; ?>" height="157" width="135" /></a><br />
						 <?php } else { ?>
						   <a href="/home_club.php"><img src="images/man4.jpg"></a>
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
						<a href="javascript:void(0);" onclick="goto('view-map.php?add=<?php echo $userID;?>');"><img  src="images/map-marker.png"></a>
					</div>
					<div class="profileCounter">
						Viewers: <span><?php echo $profileCounter;?></span>
					</div>
				</div>
			</div>
	<?php 	}	?>
		<div class="side_profile v2_gutter">  
		<ul class="nav_mobile">
            <li><a href="searchEvents.php">City Events</a></li>
            <li><a href="city_talk.php">City Talk</a></li>
            <li><a href="mysitti_contestsList.php">Contest</a></li>
            <li><a href="MySittiTV.php">Mysitti TV</a></li>
        </ul>
		
			<h1><?php echo $club_name; ?> Profile</h1>
			<div class="v2_live_control">
		  		<div class="v2_webcambutton" id="golivebutton">
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
		                			<?php if($CheckStream != '1'){ ?>
			                        			<a id="Golivebutton" href="javascript:void(0);" class="button Golivebutton" onclick="gotoLive('live2/live_broadcast.php?username=<?php echo $username_dash_separated; ?>&clubID=<?php echo $_SESSION['user_id']; ?>');">Go Live</a>
		  				<?php }

		  			?>
					<a style="display:none;" id="Viewlivebutton" class="button Viewlivebutton" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $userID; ?>&user_type=club')">Live Streaming
						<span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
					</a> 
			
		  		<!-- </div> -->
			  	<script type="text/javascript">
					function gotoLive(url)
					{
					  $('.Golivebutton').hide();
					  $('.Viewlivebutton').show();
						window.open(url,'1396358792239','width=1500,height=800,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
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
	  		<!-- <div id="v2_live_stresm_go" class="v2_webcambutton" style="display:none;"> -->
			<?php 
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"9");
  				if($data_upgrade_needed)
  				{
  					?>
  					<a style="display:none;" href="javascript:void(0);" class="button" onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')">Live Streaming</a>
  					<?php
  				}
  				else
  				{
			
					$mobile = detect_mobile();
					if($mobile === true) 
					{ 
						if($CheckStream== '1')
						{ 
					?>		<a class="button" name="submit"  onclick="goto1('https://54.174.85.75:1935/live/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming
								<?php // comment by kbihm on 30-01-2015 if($loggedin_host_data['is_launch']=='1'){?>
								<?php if($CheckStream== '1'){ ?>
									<span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
								<?php } else{ ?>
									<span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
								<?php } ?>                     	
								
							</a> 
			<? 			}
					}
					else
					{
						if($CheckStream== '1')
						{
			?>				<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $userID; ?>&user_type=club')">Live Streaming
								<?php // comment by kbihm on 30-01-2015 if($loggedin_host_data['is_launch']=='1'){?>
								<?php if($CheckStream== '1'){ ?>
									<span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
								<?php } else{ ?>
									<span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
								<?php } ?>                     	
							</a>
		<?php 				}
					}
				}  

				$getFunctionSettings = mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '$_SESSION[user_id]' ");
				$fetchAllfunction = mysql_fetch_assoc($getFunctionSettings);


			?>			
		  </div>
			<span class="talent">
				<div class="h">Be Feature?</div> 
				<div class="flatRoundedCheckbox">
					<input type="checkbox" name="" id="flatOneRoundedCheckbox" <?php if($fetchInfo['profileType'] == 'Public'){ echo 'checked';}?> >
					<label for="flatOneRoundedCheckbox"></label>
					<div>
						
					</div>
				</div>
			</span>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#flatOneRoundedCheckbox').change(function(){
						
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


						
					});
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
     		<li class="menuForMobile"> <a href="home_club.php"> <span data-title="Home">Home</span> </a> </li>
				
				<li>  <a href="edit_profile2.php"> <span>Settings</span> </a> </li>
				
			<?php
  				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"24");
  				if($data_upgrade_needed)
  				{
  					?>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Bio</span><?php if($fetchAllfunction['bio'] != 'Enable'){ echo '<i></i>'; }?></a></li>
  					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Fan Page</span></a></li>
  					<?php
  				}
  				else
  				{

			?>
					<li>  <a href="hostdj_profile.php"> <span>Bio</span><?php if($fetchAllfunction['bio'] != 'Enable'){ echo '<i></i>'; }?></a> </li>
					<li>  <a href="clubprofile.php"> <span>Fan Page</span></a> </li>
			<?php 		}	?>
				<li> <a href="upload_photo.php"> <span>Photos</span> </a> </li>
				<li>  <a href="upload_video.php"> <span>Videos</span> </a> </li>
		

			<?php 
				$type_of_club_array = array('91','92','97');
				if(in_array($type_of_club, $type_of_club_array))
				{
					?>
				<li>  <a href="subuserList.php" class="black_text"> <span>Manage Users</span> </a> </li>
			<?php 	}	?>
			<?php 
				if($type_of_club == "103")
				{
					?>
					<li><a href="instructors.php" class="black_text"><span>Instructors</span></a></li>
					<li><a href="fightersList.php" class="black_text"><span>Fighters</span></a></li>

					<?php 
				}
				if($type_of_club == "107" || $type_of_club == "109")
				{
					?>
					<li><a href="artistList.php" class="black_text"><span>Artists</span></a></li>
					<?php 
				}
				?>
		</ul>

		<div class='itemProfile sideYellow'>Promotions</div>
		<div class='item-data'>
		<ul class="v2_nav_right">
			<li><a href="<?php echo $SiteURL;?>EPKlist.php"> <span>Electronic Press Kit </span> </a></li>
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
  						<li><a href="eventscalendar.php"> <span>Calendar</span></a></li>
  						
  					<?php }	?>
				<li>
					<a href="sponsor.php" class="black_text">
					  <?php if($type_of_club == "109"){ ?>
						<span>Networking Corner</span>
					  <?php }else{ ?>
						<span>Sponsors</span>
					  <?php } ?>
					</a>
				</li>
		</ul>	
		</div>
		<div class='itemProfile sideYellow'>Merchandise</div>
		<div class='item-data'>
			<ul class="v2_nav_right">
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
  					<li>  <a href="store.php" class="users"><span>Store</span><?php if($fetchAllfunction['store'] != 'Enable'){ echo '<i></i>'; }?></a></li>
  			<?php 		}	

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
  					
					<li><a class="users" href="bookings.php"><span>Booking</span></a></li>
  					<?php 		}	?>
  			</ul>		
		</div>
				
  					
					
  					

  					
  					<?php
		  				// $data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"3");
		  				// if($data_upgrade_needed)
		  				// {
		  					?>
		  					<!-- <li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Shout Out</span></a></li> -->
		  					<?php
		  				// }
		  				// else
		  				// {
  					?>
  					<!-- <li><a href="shout.php"> <span>Shout Out</span></a></li> -->
  					<?php 		//}	?>

						
				
				
		
		<ul class="v2_nav_right popup_adv" id="popup_adv">
			<?php if($merchant_Date == "0000-00-00 00:00:00"){ ?>
			<!-- <div id="inner_popup_adv"></div> -->
			<?php } ?>
		

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

			
			

  				
				<li class="menuForMobile"><a href="<?php echo $SiteURL; ?>main/logout.php"><span data-title="Logout">Logout</span></a></li>  	
			</ul>
		</div>
	</aside>
</div>
<?php
if($merchant_Date == "0000-00-00 00:00:00"){ ?>
 

<div id="popup3" style="">
	<span class="b-close">X</span>
	<div id="mycontent" style="height: auto; width: auto;">
		<?php echo $agrr_row['page_data']; ?>
		<!-- <input name="merchant_radio_btns" type="radio" > <span>Agree & don't show this message again.</span><br /> -->
		<!-- <input name="merchant_radio_btns" type="radio" id="disagree_merchant_desktop"> <span>Disagree.</span> -->
    		<div class="controlArea">
    			<a href="javascript:void(0);" id="agree_merchant_desktop">YES<br />Agree</a> 
    			<a href="javascript:void(0);" id="disagree_merchant_desktop">NO<br />Disagree</a>
    		</div>
	</div>
</div>

<div class="b-modal1" id="b-modal1 __b-popup1__" style=""></div>
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