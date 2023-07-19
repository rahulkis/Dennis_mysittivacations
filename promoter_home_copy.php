<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}
if($userType=='club'){
$userOrhost=" AND host_id ='$userID'";
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;   
	
}

$fetmetaquery = @mysql_query("SELECT * FROM `facebookshare` ORDER BY `id` DESC limit 1 ");
$fetchmetacontent = @mysql_fetch_array($fetmetaquery);
$countinfo = @mysql_num_rows($fetmetaquery);

if($countinfo > 0)
{
  $image = $fetchmetacontent['image'];
  $description = $fetchmetacontent['description'];
}
else
{
  $image = "images/mySittiLogo.jpg";
  $description = "Making Every City Your City";
}


$titleofpage="Promoter Home";
include('HostProfilesInnerHeader.php');


if(isset($_GET['host_id']))
{
	$userID= $_GET['host_id'];
}
elseif( $hostID != "" )
{
	$userID= $hostID;
	
}
else
{
	$userID=$_SESSION['user_id'];
}

$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ; 
$profilename=$userArray[0]['club_name'];
$plantype = $userArray[0]['plantype'];
$typeclub = $userArray[0]['type_of_club'];

if($typeclub != "107")
{
	$Obj->Redirect('index.php');
	die;
}


$email=$userArray[0]['club_email'];
$club_address=$userArray[0]['club_address'];
$phone=$userArray[0]['club_contact_no']; 
$country=$userArray[0]['club_country'];
$state=$userArray[0]['club_state'];
$club_city=$userArray[0]['club_city'];
$web_url=$userArray[0]['web_url'];
$zipcode=$userArray[0]['zip_code'];
$google_map_url=$userArray[0]['google_map_url'];    
$profileCounter=$userArray[0]['profile_count'];  
$image_nm  =$userArray[0]['image_nm'];
$clubContact  =$userArray[0]['club_contact_no'];
$hideaddress = $userArray[0]['hideaddress'];
$memberType = $userArray[0]['non_member'];
// $_SESSION['username']=$profilename;
//$_SESSION['id']=$club_city;
//$_SESSION['state']=$state;
//$_SESSION['country']=$country;
if(isset($_SESSION['subuser']))
{
	$q1 = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$userArray[0]['club_name']."'  ");
	$f1 = @mysql_fetch_array($q1);

	//$_SESSION['img'] =  $f1['user_thumb'] ;
	
}
else
{
	//$_SESSION['img'] =  $image_nm ;
}
$enablediablephone=$userArray[0]['text_status'];



$banner_query =  mysql_query("SELECT `banner_name` FROM `host_banner` WHERE `user_id` = '".$userID."' AND `status` = '1'");
$banner_query_result = mysql_fetch_assoc($banner_query);
$countBanner = mysql_num_rows($banner_query);
$banner = $banner_query_result['banner_name'];

$url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

$pieces = explode(" ", $profilename);
$username_dash_separated = implode("-", $pieces);
$n = clean($username_dash_separated);

// include("live2/flash_detect.php") ;


$getgroupinfo = mysql_query("SELECT * FROM `chat_groups` WHERE `group_name` = '$n' ");
$fetchGroup = mysql_fetch_array($getgroupinfo);
if(mysql_num_rows($getgroupinfo) > 0)
{
	$groupID = $fetchGroup['id'];

	$CountUser = mysql_query("SELECT `id` FROM `chat_users_groups` WHERE `group_id` = '$groupID' AND `user_id` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]'  ");
	if(mysql_num_rows($CountUser) < 1 )
	{
		mysql_query("INSERT INTO `chat_users_groups` (`group_id`,`user_id`,`user_type`) VALUES ('$groupID','$_SESSION[user_id]','$_SESSION[user_type]')  ");
	}
}
else
{
	mysql_query("INSERT INTO `chat_groups` (`group_name`,`group_type`,`create_by`,`user_type`) 
							VALUES ('$clubName','streaming','$clubId','club') ");
	$ID = mysql_insert_id();
	mysql_query("INSERT INTO chat_users_groups (group_id,user_id,user_type) VALUES ('$ID','$clubId','club')");
}



?>
<style type="text/css">
p.discription {
	width: 100%;
}
.noEvents {
	border-bottom: none;
	text-align: center;
	padding: 20px;
	font-size: 20px;
}
/*------------------- new css ********************/


.postUser {
  max-width: 65px;
  height: 65px;
  border-radius: 50%;
  overflow: hidden;
  margin: auto;
}
.postDate {
  background: #313131 none repeat scroll 0 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  float: left;
  margin-right: 2%;
  border-radius: 4px;
 -webkit-border-radius: 4px;
  padding: 5px;
  text-align: center;
  text-transform: uppercase;
  width: 10%;
}
.postDate .date1 {
  color: #fecd07;
  font-size: 18px;
  font-weight: bold;

}

.postDate .date2 {
  font-size: 30px;
  font-weight: bold;
  line-height: 27px;
  margin-bottom: 4px;
}

.postDate hr {
  background: #000 none repeat scroll 0 0;
  border: 0 none;
  height: 1px;
}
.postDate .date3 {
  color: #fecd07;
  font-size: 18px;
  font-weight: bold;
  margin: -3px 0 0;
  padding: 0;
}
.postDate .date4 {
  color: #fff;
  font-size: 17px;
  font-weight: bold;
  margin: 0 0 3px;
  padding: 0;
}

.postDate .date5 {
  color: #fff;
  font-size: 14px;
  font-weight: bold;
  margin: 0;
  padding: 0;
}
.post_container {
  background: #000 none repeat scroll 0 0;
  border: 1px solid #fecd07 !important;
  border-radius: 9px;
  -webkit-border-radius: 9px;
  box-sizing: border-box;
  margin: 10px 0;
  padding: 10px !important;
  width: 100%;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
}
.fight_post.fight-right-post.v2_post_info {
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  float: left;
  padding-left: 0;
  padding-right: 50px;
  position: relative;
  width: 65%;
}
.buynow {
  float: left;
  width: auto;
  margin-left: 0px;
}
.buynow a {text-decoration:none;}
.v2_post_container {
  background: #fff none repeat scroll 0 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  float: left;
   border-radius: 4px;
  -webkit-border-radius: 4px;
  margin-right: 2%;
  padding: 5px;
  text-align: center;
  width: 21%;
}
.event_list_container {
  color: #fff;
  float: left;
  max-height: 850px;
  overflow: auto;
  width: 100%;
}

.moreRead {
  background: #fecd07 none repeat scroll 0 0;
  border-radius: 4px;
  color: #000;
  cursor: pointer;
  float: left;
  font-size: 12px;
  margin-top: 0;
  padding: 5px 6px;
}
.buyshowtickets, .buysttickets {
  background: #fecd07 none repeat scroll 0 0;
  border-radius: 4px;
  color: #000;
  cursor: pointer;
  float: left;
  font-size: 11px;
  margin-left: 5px;
  margin-top: 0;
  padding: 5px 10px;
}
 .buyshowtickets:hover, .buysttickets:hover, .moreRead:hover { background:#fff;}
</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 
		if(isset($_GET['host_id']))
		{
			include('host_left_panel.php');
		}
		elseif($hostID != "")
		{
			include('host_left_panel.php');
		}
		else
		{
			include('club-right-panel.php');    
		}
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<div class="fight_listing_box">
				<div class="event_icon_fight"> <img src="images/icon_band_event.png" align=""> </div>
				<div class="events_listing_fight">
					<div class="band_event_list new_band_event_list">
					<?php 
						if(isset($_GET['host_id']))
						{
							$linkEvents = "listevent.php?host_id=".$_GET['host_id'];
						}
						else
						{
							$linkEvents = "listevent.php";
						}

					?>
						<h1>See all list of <a href="<?php echo $linkEvents; ?>">Upcoming Events</a></h1>
						<div class="event_list_container">
					<?php 
							$date = date('Y-m-d');
							$get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND host_id = '".$userID."' ORDER BY date ASC LIMIT 0,5");
							$count_events = mysql_num_rows($get_latest_events);
							if($count_events > 0)
							{
								while($row = mysql_fetch_assoc($get_latest_events))
								{ 
					?>
									<div class="dj_event_list post_container home_club_posts fight-post">
         <div class="postDate">
 
		<div class="date1"><?php echo date('M',strtotime($row['date'])); ?></div>
		<div class="date2"><?php echo date('d',strtotime($row['date'])); ?></div>
		<hr>
		<div class="date3"><?php echo date('D',strtotime($row['date'])); ?></div>
		<div class="date4"><?php echo date('h:i',strtotime($row['date'])); ?></div>
		<div class="date5"><?php echo date('a',strtotime($row['date'])); ?></div>
	 
     </div>
										<div class="fight_post fight-left-post v2_post_container">
											<div id="forumcontent" class="content width_100">
					<?php 
												if($row['event_image']!='')
												{
						?>
													<a rel="group" class="fancybox" href="<?php echo $row['event_image']; ?>"> <img alt="" src="<?php echo $row['event_image_thumb']; ?>"> </a>
										<?php   	} 
												else 
												{ 
						?>
													<img alt="" src="images/man4.jpg">
						<?php   					} 
					?>
											</div>
										</div>
										<div  class="fight_post fight-right-post v2_post_info">
											<h1>
												<p><?php echo $row['eventname']; ?></p>
											</h1>
											 
											<div class="location">
												<p> 
													<span class="address_event"><?php echo $row['event_address']; ?></span><br>
												</p>
												<p> 
													<a class="map" onclick="goto('event_map.php?add=<?php echo $row['id'];?>&action=event');" title="" target="_blank">Map</a> 
												</p>
												<div style="clear:both"></div>
					<?php 
											/* CODE TO CHECK DJ ASSIGNED TO THIS EVENT */   

											$getQueryDJ = mysql_query("SELECT * FROM `dj_confirmation` WHERE `event_id` = '$row[id]' AND `status` = 'Confirm' ");
											$countQueryDJ = mysql_num_rows($getQueryDJ);
											if($countQueryDJ > 0)
											{
										?>
												<div class="eventDJ">
										<?php
												while($fetchQueryDJ = mysql_fetch_array($getQueryDJ))
												{
														$getDjinfo = mysql_query("SELECT `cl`.`image_nm`,`cl`.`id`,`cl`.`club_name`,`cc`.`name` FROM `clubs` as cl, `club_category` as cc 
														WHERE `cl`.`id` = '$fetchQueryDJ[dj_id]'
														AND     `cl`.`type_of_club` = `cc`.`id`");
														$fetchDjinfo = mysql_fetch_array($getDjinfo);
											?>
													<div class="assignedDJS">
														<div class="eventTitle"> 
															Event <?php echo $fetchDjinfo['name'];?> 
														</div>
														<div class="thumbeventDJ"> 
															<a href="host_profile.php?host_id=<?php echo $fetchQueryDJ['dj_id']; ?>"> 
																<img src="<?php echo $fetchDjinfo['image_nm'];?>" width='100' height='100' /> 
															</a> 
														</div>
														<div class="gjright">
															<div class="usernameDJ"> 
																<?php echo $fetchDjinfo['club_name'];?> 
															</div>
															<div class="djbtn">
													<?php
																$mobile = detect_mobile();
																$userNAME = str_replace(" ", "-", $fetchDjinfo['club_name']); 
																$userNAME = clean($userNAME);  								
																if($mobile === true) 
																{
														?>
																	<a class="button" name="submit"  onclick="goto1('https://192.163.248.47:1935/live/<?php echo $userNAME; ?>/playlist.m3u8')">Live Streaming
														<?php               		if(detect_stream($userNAME)===true)
																		{
													?>
																			<span class="stats_icon_dj" > <img src="images/online_u.png?t=<?= time() ?>" alt="Online" title="Online" /> </span>
													<?php               			}
																		else
																		{
													?>
																			<span class="stats_icon_dj"> <img src="images/offline_u.png?t=<?= time() ?>" alt="Offline" title="Offline"/> </span>
													<?php               			}   	?>
																	</a>
													<?      			}
																else
																{
														?>
																	<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $userNAME; ?>&host_id=<?php echo $fetchQueryDJ['dj_id']; ?>')">Live Streaming
													<?php              			if(detect_stream($userNAME)===true)
																		{
														?>
																			<span class="stats_icon" > <img src="images/online_u.png?t=<?= time() ?>" alt="Online" title="Online" /> </span>
														<?php           			}
																		else
																		{
															?>
																			<span class="stats_icon"> <img src="images/offline_u.png?t=<?= time() ?>" alt="Offline" title="Offline"/> </span>
														<?php               		}   		?>
																	</a>
													<?php           		}   	?>
															</div>
														</div>
													</div>
													<div style="clear:both"></div>
					<?php      						} // ENDWHILE   ?>
												</div><!-- END eventDJ-->
					<?php               				}       ?>
												<p class="discription"> <?php echo substr(strip_tags($row['description']),0,100); ?> 
              <div class="clear"></div>
    <hr  />		<?php 
    				if(strlen($row['description']) >= 100)
    				{
    			?>
			  	<a class="moreRead" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row['id'] ?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">Read More...</a>
			  <?php }	?>
												<div class="buynow">
												<?php 
													$check_ticket = mysql_Query("SELECT * FROM streaming_tickets WHERE event_id = '".$row['id']."'");
													$count_ticket_check = mysql_num_rows($check_ticket);

													/* PAID PASSES QUERY */
													$getPaidpass = mysql_query("SELECT * FROM `paid_passes` WHERE `event_id` = '$row[id]' ");
													$fetchRecords = mysql_fetch_assoc($getPaidpass);
													$countPaidpasses = $fetchRecords['no_of_tickets'];
													$currDate = strtotime(date('Y-m-d H:i:s'));
													$expiryPass = strtotime($fetchRecords['expiry_date']);
												?>
								 
											<?php 
												if( ($count_ticket_check == "1" || $countPaidpasses > 0) && $_SESSION['user_type'] == 'user')
												{
											?>
													<!--<span class="avail">Tickets Available</span>-->
									

											<?php
													if($countPaidpasses > 0 && $fetchRecords['pass_status'] == "active" && ( $expiryPass > $currDate) )
													{
														$HostID = $_GET['host_id'];
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
														?>
														<a  class="buyshowtickets"  href="buyStageTicket.php?host_id=<?php echo $HostID.'&str_amt='.$payment_amount.'&user_type='.$_SESSION['user_type'].'&passid='.$fetchRecords['pass_id'].'&event_id='.$row['id']; ?>">
																Buy Show Tickwt
														</a>
													<?php

													}

													/**** check streaming ticket exists ****/

													if($count_ticket_check == 1 && $_SESSION['user_type'] == 'user')
													{
														
														$get_ticket_id = mysql_fetch_assoc($check_ticket);
														$ticket_id = $get_ticket_id['ticket_id'];
														
														$check_user_purchased_ticket = mysql_query("SELECT * FROM streaming_tickets_purchased WHERE ticket_id = '".$ticket_id."' AND buyer_user_id = '".$_SESSION['user_id']."' AND buyer_user_type = '".$_SESSION['user_type']."' AND event_id = '".$row['id']."'");
														$count_downloaded_ticket = mysql_num_rows($check_user_purchased_ticket);
														
														if($count_downloaded_ticket < 1)
														{ 
													?>
												                                                 	<a class="buysttickets" href="OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php echo $_GET['host_id']; ?>&user_type=club&ticket_id=<?php echo $ticket_id; ?>&event_id=<?php echo $row['id']; ?>">
												                                                 	Buy Streaming Ticket
												                                         	</a> 
												                                        
													<?php
														}else{ ?>
														
					                                										<!-- div class="buynow" -->
														<br/>
														<span class="avail">Already Purchased Ticket</span>
													
														<?php }
													}
													/**** check ticket exists ****/
													//echo "</div>";
												}
													?>
												</div>
										 	</p>
											</div><!-- END location-->
										</div>
									</div><!-- END dj_event_list post_container home_club_posts -->
					<?php           		}	?>
					
					<div class="html">
					<div class="dj_event_list post_container home_club_posts fight-post">
         <div class="postDate">
 
				<div class="date1">Sep</div>
				<div class="date2">22</div>
				<hr>
				<div class="date3">Tue</div>
				<div class="date4">8:00</div>
				<div class="date5">pm</div>
	 
     </div>
										<div class="fight_post fight-left-post v2_post_container">
											<div class="content width_100" id="forumcontent">
																		<a href="../upload/forum_14394459121439442000Tomorrowland-2015-Wallpaper.jpg" class="fancybox" rel="group"> <img src="../upload/_143944591264872f11cbef68c448320fba76676d22Tomorrowland-2015-Wallpaper.jpg_thumbnail.jpg" alt=""> </a>
																					</div>
										</div>
										<div class="fight_post fight-right-post v2_post_info">
											<h1>
												<p>Tomorrow Land</p>
											</h1>
											 
											<div class="location">
												<p> 
													<span class="address_event">Chattahoochee Hills, atlanta GA</span><br>
												</p>
												<p> 
													<a target="_blank" title="" onclick="goto('event_map.php?add=1&amp;action=event');" class="map">Map</a> 
												</p>
												<div style="clear:both"></div>
																	<p class="discription"> TomorrowWorld has a strict 21+ age requirement. Anyone born on or after September 25, 1994 will not  
              </p><div class="clear"></div>
    <hr>
			 <?php 
    				if(strlen($row['description']) >= 100)
    				{
    			?>
			  	<a class="moreRead" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row['id'] ?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">Read More...</a>
			  <?php }	?>
												<div class="buynow">
																				 
																							</div>
										 	<p></p>
											</div><!-- END location-->
										</div>
									</div>
         <div class="dj_event_list post_container home_club_posts fight-post">
         <div class="postDate">
 
				<div class="date1">Sep</div>
				<div class="date2">22</div>
				<hr>
				<div class="date3">Tue</div>
				<div class="date4">8:00</div>
				<div class="date5">pm</div>
	 
     </div>
										<div class="fight_post fight-left-post v2_post_container">
											<div class="content width_100" id="forumcontent">
																		<a href="../upload/forum_14394459121439442000Tomorrowland-2015-Wallpaper.jpg" class="fancybox" rel="group"> <img src="../upload/_143944591264872f11cbef68c448320fba76676d22Tomorrowland-2015-Wallpaper.jpg_thumbnail.jpg" alt=""> </a>
																					</div>
										</div>
										<div class="fight_post fight-right-post v2_post_info">
											<h1>
												<p>Tomorrow Land</p>
											</h1>
											 
											<div class="location">
												<p> 
													<span class="address_event">Chattahoochee Hills, atlanta GA</span><br>
												</p>
												<p> 
													<a target="_blank" title="" onclick="goto('event_map.php?add=1&amp;action=event');" class="map">Map</a> 
												</p>
												<div style="clear:both"></div>
																	<p class="discription"> TomorrowWorld has a strict 21+ age requirement. Anyone born on or after September 25, 1994 will not  
              </p><div class="clear"></div>
    <hr>
			  <?php 
    				if(strlen($row['description']) >= 100)
    				{
    			?>
			  	<a class="moreRead" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row['id'] ?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">Read More...</a>
			  <?php }	?>
												<div class="buynow">
																				 
																							</div>
										 	<p></p>
											</div><!-- END location-->
										</div>
									</div>
         <div class="dj_event_list post_container home_club_posts fight-post">
         <div class="postDate">
 
				<div class="date1">Sep</div>
				<div class="date2">22</div>
				<hr>
				<div class="date3">Tue</div>
				<div class="date4">8:00</div>
				<div class="date5">pm</div>
	 
     </div>
										<div class="fight_post fight-left-post v2_post_container">
											<div class="content width_100" id="forumcontent">
																		<a href="../upload/forum_14394459121439442000Tomorrowland-2015-Wallpaper.jpg" class="fancybox" rel="group"> <img src="../upload/_143944591264872f11cbef68c448320fba76676d22Tomorrowland-2015-Wallpaper.jpg_thumbnail.jpg" alt=""> </a>
																					</div>
										</div>
										<div class="fight_post fight-right-post v2_post_info">
											<h1>
												<p>Tomorrow Land</p>
											</h1>
											 
											<div class="location">
												<p> 
													<span class="address_event">Chattahoochee Hills, atlanta GA</span><br>
												</p>
												<p> 
													<a target="_blank" title="" onclick="goto('event_map.php?add=1&amp;action=event');" class="map">Map</a> 
												</p>
												<div style="clear:both"></div>
																	<p class="discription"> TomorrowWorld has a strict 21+ age requirement. Anyone born on or after September 25, 1994 will not  
              </p><div class="clear"></div>
    <hr>
			  <?php 
    				if(strlen($row['description']) >= 100)
    				{
    			?>
			  	<a class="moreRead" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row['id'] ?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">Read More...</a>
			  <?php }	?>
												<div class="buynow">
																				 
																							</div>
										 	<p></p>
											</div><!-- END location-->
										</div>
									</div>
         <div class="dj_event_list post_container home_club_posts fight-post">
         <div class="postDate">
 
				<div class="date1">Sep</div>
				<div class="date2">22</div>
				<hr>
				<div class="date3">Tue</div>
				<div class="date4">8:00</div>
				<div class="date5">pm</div>
	 
     </div>
										<div class="fight_post fight-left-post v2_post_container">
											<div class="content width_100" id="forumcontent">
																		<a href="../upload/forum_14394459121439442000Tomorrowland-2015-Wallpaper.jpg" class="fancybox" rel="group"> <img src="../upload/_143944591264872f11cbef68c448320fba76676d22Tomorrowland-2015-Wallpaper.jpg_thumbnail.jpg" alt=""> </a>
																					</div>
										</div>
										<div class="fight_post fight-right-post v2_post_info">
											<h1>
												<p>Tomorrow Land</p>
											</h1>
											 
											<div class="location">
												<p> 
													<span class="address_event">Chattahoochee Hills, atlanta GA</span><br>
												</p>
												<p> 
													<a target="_blank" title="" onclick="goto('event_map.php?add=1&amp;action=event');" class="map">Map</a> 
												</p>
												<div style="clear:both"></div>
																	<p class="discription"> TomorrowWorld has a strict 21+ age requirement. Anyone born on or after September 25, 1994 will not  
              </p><div class="clear"></div>
    <hr>
			  <?php 
    				if(strlen($row['description']) >= 100)
    				{
    			?>
			  	<a class="moreRead" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row['id'] ?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">Read More...</a>
			  <?php }	?>
												<div class="buynow">
																				 
																							</div>
										 	<p></p>
											</div><!-- END location-->
										</div>
									</div>
         <div class="dj_event_list post_container home_club_posts fight-post">
         <div class="postDate">
 
				<div class="date1">Sep</div>
				<div class="date2">22</div>
				<hr>
				<div class="date3">Tue</div>
				<div class="date4">8:00</div>
				<div class="date5">pm</div>
	 
     </div>
										<div class="fight_post fight-left-post v2_post_container">
											<div class="content width_100" id="forumcontent">
																		<a href="../upload/forum_14394459121439442000Tomorrowland-2015-Wallpaper.jpg" class="fancybox" rel="group"> <img src="../upload/_143944591264872f11cbef68c448320fba76676d22Tomorrowland-2015-Wallpaper.jpg_thumbnail.jpg" alt=""> </a>
																					</div>
										</div>
										<div class="fight_post fight-right-post v2_post_info">
											<h1>
												<p>Tomorrow Land</p>
											</h1>
											 
											<div class="location">
												<p> 
													<span class="address_event">Chattahoochee Hills, atlanta GA</span><br>
												</p>
												<p> 
													<a target="_blank" title="" onclick="goto('event_map.php?add=1&amp;action=event');" class="map">Map</a> 
												</p>
												<div style="clear:both"></div>
																	<p class="discription"> TomorrowWorld has a strict 21+ age requirement. Anyone born on or after September 25, 1994 will not  
              </p><div class="clear"></div>
    <hr>
			  <?php 
    				if(strlen($row['description']) >= 100)
    				{
    			?>
			  	<a class="moreRead" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row['id'] ?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">Read More...</a>
			  <?php }	?>
												<div class="buynow">
																				 
																							</div>
										 	<p></p>
											</div><!-- END location-->
										</div>
									</div>
					</div>
					
					
					
					<?php
					
					
					 // END WHILE $row
							} // END $count_events
							else
							{
								echo '<div class="noEvents" style="border-bottom: none;"><h2 style="border-bottom: none;">No Events Found for this Host!</h2></div>';
							}
							if($count_events > 5)
							{
					?>
								<h1>See all list of <a href="<?php echo $linkEvents; ?>">Upcoming Events</a></h1>
					<?php		}	?>
						</div>
					<!-- END EVENT CONTAINER --> 
					</div>
				</div>
			</div><!-- END fight_listing_box -->

<div class="seprators"></div>
			<!-- speacial_comedy -->
			<div class="speacial_fight_box">         
				<div class="pass_fight promotorHome">
					<h1 class="h1">
						<img src="images/icon_hotpass_band.png" align="">PASS
					</h1>
					<?php 
						$date = date("Y-m-d");
						$couponQuery = mysql_query("SELECT * FROM `host_coupon` WHERE host_id = '$userID' AND `expiry_date` > '$date' ORDER BY `id` DESC");
						$countCoupon = mysql_num_rows($couponQuery);
						if(isset($_GET['host_id']))
						{
					?>
		  					<script type="text/javascript">
								function popupwindow(url, title, w, h) {
									var left = (screen.width/2)-(w/2);
									var top = (screen.height/2)-(h/2);
									return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
								}
							</script>
		  <?php			}	?>
	
					<div class="photo_fight_slider photo_slider">
						<?php 
							echo "<ul class='photoslider2'>";
							if($countCoupon > 0)
							{
								
								while($rowCoupon = mysql_fetch_assoc($couponQuery))
								{
									
									$imgsrc = "upload/coupon/".$rowCoupon['coupon_image'];
									$thumb = $rowCoupon['coupon_thumb'];

									$date1 = date("Y-m-d");
									$ts1 = strtotime($date1);
									$ts2 = strtotime($rowCoupon['expiry_date']);
									
									$get_difference = $ts2 - $ts1;                                  
									
									if($get_difference >= 0)
									{
										if(isset($_GET['host_id']))
										{

											$check_non_friend_pass = @mysql_query("SELECT * FROM downloadpasses WHERE user_id = '".$_SESSION['user_id']."' AND host_id = '".$userID."' AND pass_id = '".$rowCoupon['id']."'");
											$count_p = mysql_num_rows($check_non_friend_pass);
											if($count_p == 1)
											{
														
												$check_redm = @mysql_query("SELECT status FROM downloadpasses WHERE user_id = '".$_SESSION['user_id']."' AND host_id = '".$userID."' AND pass_id = '".$rowCoupon['id']."'");
												$c_status = mysql_fetch_assoc($check_redm);
												if($c_status['status'] == 1)
												{ 
									?>
													  <li> 
													  	<a href="<?php echo $imgsrc ?>" rel="group" class="fancybox">
													  		<img src="<?php echo $thumb ;?>" alt="" />
													  	</a> 
													  	<span>REDEEMED</span>
														<div class="clear"></div>
														<h5><?php echo $rowCoupon['coupon_name'];?></h5>
													  </li>
			  <?php               							}
												else
												{ 
									?>
													<li> 
														<a href="<?php echo $imgsrc ?>" rel="group" class="fancybox">
															<img src="<?php echo $thumb ;?>" alt="" />
														</a> 
														<span>DOWNLOADED</span>
														<div class="clear"></div>
														<h5><?php echo $rowCoupon['coupon_name'];?></h5>
													</li>
			  <?php               							}
											}
											else
											{
								?>
												<li> 
													<a href="<?php echo $imgsrc ?>" rel="group" class="fancybox">
														<img src="<?php echo $thumb ;?>" alt="" />
													</a> 
													<span onclick="download_host_pas('<?php echo $hostID; ?>', '<?php echo $_SESSION['user_id']; ?>', '<?php echo $rowCoupon['id']; ?>');">DOWNLOAD PASS</span>
													<div class="clear"></div> 
													<h5><?php echo $rowCoupon['coupon_name'];?></h5>
												</li>
			  <?php 
											}
										}
										else
										{
											?>
											<li> 
												<a href="<?php echo $imgsrc ?>" rel="group" class="fancybox">
													<img  src="<?php echo $thumb ;?>" alt="" />
												</a>
												<div class="clear"></div> 
												<h5><?php echo $rowCoupon['coupon_name'];?></h5>
											</li>
			  <?php
										}
									}
								}
							}
							else
							{
								echo '<li><img src="images/availableSoon.png" align=""><div class="clear"></div> </li>';
							}
							echo "</ul>";
						?>
					</div>
				</div>

				<div class="special_fight">
					<h1 class="h1">
						<img src="images/icon_special_band.png" align="">Specials
					</h1>
					<ul>
			<?php 
						$specailsQuery = mysql_query("SELECT * FROM `host_ad` WHERE host_id = '$userID'  ORDER BY `id` DESC LIMIT 1 ");
						$specailsFetch= mysql_fetch_array($specailsQuery);
						$specailsImage = $specailsFetch['ad_image'];
						$countSpecial = mysql_num_rows($specailsQuery);
						if($countSpecial > 0)
						{
							if($specailsFetch['ad_type'] == 'image')
							{
						?>
			  					<li>
			  						<a href="<?php echo $specailsImage;  ?>" <?php echo 'rel="group" class="fancybox"'; ?> >
			  							<img src="<?php echo $specailsFetch['ad_thumb'] ;?>"    alt="" />
			  						</a>
			  					</li>
			  <?php 			}
							elseif($specailsFetch['ad_type'] == 'video')
							{
			?>
								<li>
				  					<a onmouseover="jwplayer('add<?php echo $specailsFetch["id"];?>').play();" onmouseout="jwplayer('add<?php echo $specailsFetch["id"];?>').pause();" id="ve_<?php echo $specailsFetch["id"];?>" href="#dialogx<?php echo $specailsFetch["id"];?>" name="modal"> </a>
				  					<div id="add<?php echo $specailsFetch["id"];?>"></div>
				  					<script type="text/javascript">
										jwplayer("add<?php echo $specailsFetch["id"];?>").setup({
											file: "upload/hostads/<?php echo $specailsFetch["ad_video"];?>",
											height : 100 ,
											width: 100
										});
									</script>
								</li>
	  	<?php
							}
						}
						else
						{
							echo '<li><img src="images/availableSoon.png" align=""></li>';
						}
		?>
					</ul>
	<?php 
					if($specailsFetch['adv_link'] != "")
					{
		?>
						<h5><a href="<?php echo $specailsFetch['adv_link'];?>"><?php echo $specailsFetch['adv_link'];?></a></h5>
	<?php 				} 	?>
				</div>
			</div><!-- END speacial_fight_box -->

<div class="seprators"></div>
			<!-- ARTIST LISTING SLIDER -->
			
			<?php	
			$sql4="SELECT * FROM `artist_list` WHERE `host_id` = '$userID' ";
		 	$sql6 = mysql_query($sql4);
			$num = mysql_num_rows($sql6);
			if($num > 0)
			{	
		?>
				<div class="speacial_fight_box artisrListbox">
					<h1 class="h1">Artists List</h1>
					<div class="comedy_slider_photo com_vid photo_slider artistslider">
						<ul class="artistslider1">
						<?php 
							while($row = mysql_fetch_assoc($sql6))
							{
								$getArtistINFO = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$row[artist_id]' ");
								$fetchinstructors = mysql_fetch_assoc($getArtistINFO);
								//if($fetchinstructors['type_of_club'] == '108')
								//{
								?>
								<li> 
									<a href="host_profile.php?host_id=<?php echo $fetchinstructors['id']; ?>">
										<img src="<?php echo $fetchinstructors['image_nm'] ;?>" alt="" />
									</a>
									<h5><?php echo $fetchinstructors['club_name'];?></h5>
								</li>
							<?php 
								//}
							}
						?>
					</div>
				</div>
			<?php 	}	?>

<div class="seprators"></div>
			
			<!-- ARTIST SLIDER END -->

			<!-- photo section comedy -->
			<div class="comedy_listing_box">
	<?php 
				$photo_sql = "select * from `uploaded` where `user_id` = '".$userID."' and user_type='club' order by rand()  ";
				$photo_Array = mysql_query($photo_sql);  
				$countPhotos = mysql_num_rows($photo_Array);
				if($countPhotos > 0)
				{
			?>
					<div class="event_icon_fight"> 
						<img src="images/icon_photo_band.png" align=""> 
					</div>
					<div class="events_listing_fight photo_fight">
						<h1 class="h1">Photos</h1>
				<?php /*		<style type="text/css">
							.box_skitter_large #slider .fluxslider
							{
								float: left !important;
								width: 100% !important;
							}
						</style>
						<script src="js/Flux-Slider/js/flux.min.js" type="text/javascript" charset="utf-8"></script>
						<script type="text/javascript" charset="utf-8">
							$(function(){
								if(!flux.browser.supportsTransitions)
									alert("Flux Slider requires a browser that supports CSS3 transitions");
									
								window.f = new flux.slider('#slider', {
									// width: 500,
									// height: 300,
									autoplay: true,
									pagination: false,
									transitions: ['blocks']
								});
							});
						</script>
						*/ ?>
<link rel="stylesheet" href="js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
<!-- <link rel="stylesheet" href="js/nivo-slider/demo/style.css" type="text/css" media="screen" /> -->
<style type="text/css">
#slider
{
	height: 350px !important;
	max-height: 350px !important;
}


</style>

<script type="text/javascript" src="js/nivo-slider/jquery.nivo.slider.js"></script> 
<script type="text/javascript">
	$(window).load(function() {
		$('#slider').nivoSlider({
    effect: 'random',                 // Specify sets like: 'fold,fade,sliceDown'
    slices: 15,// For slice animations
    boxCols: 8,                     // For box animations
    boxRows: 4,                     // For box animations
    animSpeed: 1000,                 // Slide transition speed
    pauseTime: 3000,                 // How long each slide will show
    startSlide: 0,                     // Set starting Slide (0 index)
    directionNav: true,             // Next & Prev navigation
    controlNav: false,                 // 1,2,3... navigation
    controlNavThumbs: false,         // Use thumbnails for Control Nav
    pauseOnHover: true,             // Stop animation while hovering
    manualAdvance: false,             // Force manual transitions
    prevText: '<',                 // Prev directionNav text
    nextText: '>',                 // Next directionNav text
    randomStart: false,             // Start on a random slide
    beforeChange: function(){},     // Triggers before a slide transition
    afterChange: function(){},         // Triggers after a slide transition
    slideshowEnd: function(){},     // Triggers after all slides have been shown
    lastSlide: function(){},         // Triggers when last slide is shown
    afterLoad: function(){}         // Triggers when slider has loaded
});

//$('#slider').nivoSlider();
	});
</script> 
						<div class="comedy_slider_photo photo_slider box_skitter_large">
							<ul id="slider" class="photoslider12 fight_photo_slider">
			<?php
								while($photo_row = mysql_fetch_array($photo_Array))
								{ 
			?>
								 	<!-- <li> -->
										<!-- <a href="<?php //echo $photo_row['img_name']; ?>" rel="group" class="fancybox"> -->
											<img src="<?php echo $photo_row['thumbnail']; ?>" alt="<?php echo $photo_row['image_title']; ?>" />
										<!-- </a> -->
									<!-- </li>  -->
			<?php					}	?>
		  					</ul>		
						</div>
					</div>
	<?php 			}		?>
			</div>

<div class="seprators"></div>
	<?php 
/*
		$video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' and user_type='club'  order by rand()";
		$video_Array = mysql_query($video_sql);
	  
		if(mysql_num_rows($video_Array)>0) 
		{
	?>
			<div class="comedy_listing_box">
				<div class="event_icon_fight"> 
					<img src="images/video_icon_fight.png" align="">
				</div>
				<div class="events_listing_fight video_fights">
					<h1 class="h1">Videos</h1>
					<div class="comedy_slider_photo com_vid photo_slider">
						<ul class="videoslider1">
			<?php
							while($video_row = mysql_fetch_array($video_Array))
							{
			?>
								<li> 
									<a class=""  id="ve_<?php echo $video_row["video_id"];?>" href="#dialogx<?php echo $video_row["video_id"];?>" name="modal"></a>
									<div class="videoList" id="a<?php echo $video_row["video_id"];?>"></div>
									<script type="text/javascript">
										jwplayer("a<?php echo $video_row["video_id"];?>").setup({
											file: "<?php echo $video_row["video_nm"];?>",
											height : 250 ,
											// width: 100%,
										});
									</script>
									<h5><?php echo $video_row["video_title"];?></h5>
								</li>
			<?      				}   			?>
		  				</ul>
					</div>
				</div>
			</div>
<?php 		}		*/?>
			<?php 
			$myquery = @mysql_query("SELECT * FROM music where host_id = '$userID' AND tonightlist = '1' ORDER BY trackname ASC");
			$myquery2 = @mysql_query("SELECT * FROM dj_video where host_id = '$userID' AND tonightlist = '1' ORDER BY trackname ASC");
			if(mysql_num_rows($myquery) > 0 || mysql_num_rows($myquery2) > 0) 
			{
			?>

		  	<div class="video tonighListing ">
				<h2>Tonight Music List</h2>
				<?
					$i=1;
					if(!isset($_GET['host_id']))
					{						?>
						<div class="autoscroll">
						  	<table class="tonightmusictab responsivetable" id="hometonightlisting" style="background:none;">
								<tr>
									<th>&nbsp;</th>
									<th>Track Name</th>
									<th>Artist</th>
									<th>Label</th>
									<th>Genre</th>
									<th>Release Date</th>
									<th>Price</th>
								</tr>
							<?    	if(mysql_num_rows($myquery)>0) 
								{
									while($res = mysql_fetch_array($myquery))
									{
							?>
										<tr>
											<td>
												<audio style="display:none;" controls id="player<?php echo $a ;?>">
													<source src="<?php echo $res['musicpath'];?>" type="audio/mpeg">
													<source src="<?php echo $res['musicpath'];?>" type="audio/ogg">
													<embed height="50" width="100" src="<?php echo $res['musicpath'];?>"></embed>
												</audio>
												<a href='javascript:play1();' id="<?php echo $a;?>" class="test audio"><img height="30px" src="images/new_portal/play.png"></a> <a href='javascript:pause();' class='pause' id="<?php echo $a;?>"><img height="30px" src="images/new_portal/pause.png"></a>
											</td>
											<td><?php echo $res['trackname']; ?>&nbsp;</td>
											<td><?php echo $res['artist']; ?>&nbsp;</td>
											<td><?php echo $res['label']; ?>&nbsp; </td>
											<td><?php echo $res['genre']; ?>&nbsp; </td>
											<td>
												<?php  $date =  $res['releasedate'];
												$sort = strtotime($date);
												echo date('M d, Y',$sort);              
												?>
												&nbsp; 
											</td>
											<td><?php echo "$".$res['price']; ?>&nbsp;</td>
										</tr>
							<?              	}
								}
								if(mysql_num_rows($myquery2)>0) 
								{
									while($res = mysql_fetch_array($myquery2))
									{				?>
										<tr>
											<td>
												<a onClick="javascript:void window.open('play_video_clip.php?clip_id=<?php echo $res['id']; ?>','','width=500,height=500,resizable=true,left=0,top=0');return false;"><img src="images/new_portal/play.png" height="25px" width="25px;"></a>
											</td>
											<td><?php echo $res['trackname']; ?></td>
											<td><?php echo $res['artist']; ?></td>
											<td><?php echo $res['label']; ?></td>
											<td><?php echo $res['genre']; ?></td>
											<td>
												<?php  $date =  $res['releasedate'];
													$sort = strtotime($date);
													if($res['releasedate'] != ""){ echo date('M d, Y',$sort); }             
												?>
											</td>
											<td><?php echo "$".$res['price']; ?></td>
										</tr>
							<?              	}
								}		?>
						  	</table>
						</div>
				<?php       
					}
					else
					{
					?>
						<div class="autoscroll">
							<table id="hometonightlisting" class="tonightmusictab responsivetable">
								<tr>
									<th>&nbsp;</th>
									<th>Track Name</th>
									<th>Artist</th>
									<th>Label</th>
									<th>Genre</th>
									<th>Release Date</th>
									<th>Price</th>
								</tr>
					<?     
						$a= 0;
						while($res = mysql_fetch_array($myquery))
						{
								?>
							<form method="POST" action="cart.php">
				  				<tr>
									<td>
										<audio style="display:none;" controls id="player<?php echo $a ;?>">
											<source src="<?php echo $res['musicpath'];?>" type="audio/mpeg">
											<source src="<?php echo $res['musicpath'];?>" type="audio/ogg">
											<embed height="50" width="100" src="<?php echo $res['musicpath'];?>"></embed>
									  	</audio>
						  				<a href='javascript:play1();' id="<?php echo $a;?>" class="test audio"><img src="images/new_portal/play.png"  /></a> <a href='javascript:pause();' class='pause' id="<?php echo $a;?>"><img src="images/new_portal/pause.png"  /></a>
						  			</td>
									<td><?php echo $res['trackname']; ?></td>
									<td><?php echo $res['artist']; ?></td>
									<td><?php echo $res['label']; ?></td>
									<td><?php echo $res['genre']; ?></td>
									<td>
										<?php 
											$date =  $res['releasedate'];
											$sort = strtotime($date);
											echo date('M d, Y',$sort);          
										?>
									</td>
									<td>
										<input type="hidden" name="product_id" value="<?php echo $res['id'];?>">
										<input type="hidden" name="price_cart" value="<?php echo $res['price'];?>">
										<input type="hidden" name="host_id" value="<?php echo $_GET['host_id'];?>">
										<input type="hidden" name="product_type" value="0">
										<input type="hidden" name="music_type" value="music">
										<input type="hidden" name="product_qty" value="1">
						  				<?  
						  					$data_upgrade_needed=chk_upgrade_needed_shopping($data_upgrade['plantype'],"18",$_GET['host_id']);
											if(!$data_upgrade_needed && $_SESSION['user_type'] == "user"){?>
						  						<input type='submit' class="button" value="<?php echo "$".$res['price']; ?>" />
				  <?							}
					  						else
				  							{		
				  							 	echo "$".$res['price']; 
			  							 	} 
			 	?>					</td>
							  	</tr>
							</form>
					<? 		$a++;
						}
						while($res = mysql_fetch_array($myquery2))
						{
							?>
							<form method="POST" action="cart.php">
					  			<tr>
									<td><a onClick="javascript:void window.open('play_video_clip.php?clip_id=<?php echo $res['id']; ?>','','width=500,height=500,resizable=true,left=0,top=0');return false;"><img src="images/new_portal/play.png" height="25px" width="25px;"></a></td>
									<td><?php echo $res['trackname']; ?></td>
									<td><?php echo $res['artist']; ?></td>
									<td><?php echo $res['label']; ?></td>
									<td><?php echo $res['genre']; ?></td>
									<td>
										<?php  
											$date =  $res['releasedate'];
											$sort = strtotime($date);
											if($res['releasedate'] != ""){ echo date('M d, Y',$sort); }         
													?>
									</td>
									<td>
										<input type="hidden" name="product_id" value="<?php echo $res['id'];?>">
										<input type="hidden" name="price_cart" value="<?php echo $res['price'];?>">
										<input type="hidden" name="host_id" value="<?php echo $_GET['host_id'];?>">
										<input type="hidden" name="product_type" value="0">
										<input type="hidden" name="music_type" value="video">
										<input type="hidden" name="product_qty" value="1">
									  <?  
								  		$data_upgrade_needed=chk_upgrade_needed_shopping($data_upgrade['plantype'],"18",$_GET['host_id']);
										if(!$data_upgrade_needed && $_SESSION['user_type'] == "user"){?>
									  		<input type='submit' class="button" value="<?php echo "$".$res['price']; ?>" />
									  <?	}
									  	else
							  			{								  
									  		echo "$".$res['price'];
									  	}
		  	 ?>						</td>
					  			</tr>
							</form>
					<?      }   ?>
				  			</table>
						</div>
				<?php       }   ?>
			</div> <!--  END video tonighListing-->
	  <?php 	} 		?>
	<?php 

				$myquery = @mysql_query("SELECT  * FROM  host_product WHERE  host_id= '$userID' AND `featured` = '1' ORDER BY `id` DESC ");
				//$myquery2 = @mysql_query("SELECT * FROM dj_video where host_id = '$userID' AND tonightlist = '1' ORDER BY trackname ASC");

				if(mysql_num_rows($myquery) > 0)  
				{
				?><div class="seprators"></div>
							<div class="video tonighListing">
								<h2>Featured Product List</h2>
								<? $i=1; ?>
								<div class="featuredProductListing">
									<?php 
									while($featuredProduct = mysql_fetch_assoc($myquery))
									{
									?>
									<form class="product_cat_form" action="cart.php" method="POST">												  
										<input type="hidden" value="<?php echo $featuredProduct['id'];?>" name="product_id">
										<input type="hidden" value="<?php echo $featuredProduct['host_id'];?>" name="host_id">      
										<input type="hidden" value="<?php echo $featuredProduct['product_price'];?>" name="price_cart"> 
										<input type="hidden" value="2" name="product_type"> 
										<input type="hidden" value="1" name="product_qty"> 

										<div class="product_box">
											<div class="product_box-img">
												<?php 
													$sqlGetImages="select * from product_images where product_id=".$featuredProduct['id'];
													$getImages = mysql_query($sqlGetImages);
													$fetchImages = mysql_fetch_array($getImages);
													$countImages = mysql_num_rows($getImages);
													if($countImages > 0)
													{
														$imagePath = $fetchImages['path'];
													}
													else
													{
														$imagePath = $row['image_name'];
													}
												?>
												<a href="product.php?id=<?php echo $featuredProduct['id'];?>&host_id=<?php echo $userID;?>">
													<img style="height:200px;width:200px" src="<?php echo $imagePath;?>">
												</a>
											</div>
											<div class="bottom_prodct">
												<div class="product_box-nameprice">
													<span class="product_box_label prdct_name"><?php echo $featuredProduct['product_desc'];?></span>
													<span class="product_box_label prdct_price"> $<?php echo $featuredProduct['product_price'];?></span>
												</div>
												<div class="product_box-desc stock">
													<span class="product_box_butn bgstock">
													<?
												    		$sql="SELECT sum(stock)  as stk FROM `product_sizes` where product_id=".$featuredProduct['id'];
														$productsize=mysql_query($sql);
														if(mysql_num_rows($productsize))
														{
															$productsize=mysql_fetch_array($productsize);
															$productsize=$productsize['stk'];
															echo "In Stock";
														}
														else
														{
															$productsize=0;
															echo "Out Of Stock";
														}
												   	?>
													</span>
												</div>
											</div>
										</div>
									</form>
								<?php 	}	?>
								</div>
							</div>
			<? 	} 	?>
<style type="text/css">


</style>
<?php 

				$myquery = @mysql_query("SELECT  * FROM  `sponsors` WHERE  `user_id`= '$userID' ORDER BY `id` DESC ");
				//$myquery2 = @mysql_query("SELECT * FROM dj_video where host_id = '$userID' AND tonightlist = '1' ORDER BY trackname ASC");

				if(mysql_num_rows($myquery) > 0)  
				{
				?>
    <div class="seprators"></div>
							<div class="video tonighListing">
								<h2>Sponsors List</h2><br />
								<? $i=1; ?>
								<div class="SponsorsListing">
									<?php 
									while($featuredProduct = mysql_fetch_assoc($myquery))
									{
									?>
										<div class="Sponsors_box">
											<div class="product_box-img product_sponsors">
												<img   src="<?php echo $featuredProduct['image_thumb'];?>"><br/>
											</div>
											<div class="sponsor_title">
												<a href="<?php echo $featuredProduct['link']; ?>"><?php echo $featuredProduct['title']; ?></a>
											</div>										
										</div>
								<?php 	}	?>
								</div>
							</div>
			<? 	} 	?>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>






















	<?php
		if($_SESSION['user_type'] == "club")
		{
	?>
	 		<div class="upload_banner_bg">
	 			<a href="host-background.php">
	 				<img height="25px" width="30px" src="images/camera3.png" alt="" title="Change Background">
	 			</a>
	 		</div>
 	<?php 	} 		?>
<script type="text/javascript">
	function download_host_pas(host_id, user_id, pass_id){
		
		$.blockUI({ css: {
			border: 'none',
			padding: '15px',
			backgroundColor: '#fecd07',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .5,
			color: '#000'
		},
		message: '<h1>DOWNLOADING PASS</h1>'
		}); 
 
		jQuery.post('ajaxcall.php',
					{
						'host_id': host_id,
						'user_id': user_id,
						'pass_id': pass_id,
						'download_host_pass': 'download_host_pass'
					},
						function(response){
							
							setTimeout(function() { 
								$.unblockUI({
									onUnblock: function(){
										
										if (response == "stop") {
											alert('Pass Download Limit Reached');
										}else{
										
											alert('Pass Downloaded');
											window.location.href= "";
										}
									}
								}); 
							}, 2000);
						});

	}
	function goto1(url)
	{
		window.open(url,'1396358792239','width=900,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
		return false;
	}
function change_src(args,id)
{
	var player = document.getElementById('tv_main_channel');

	var mp4Vid = document.getElementById('mp4Source');

	player.pause();

	// Now simply set the 'src' attribute of the mp4Vid variable!!!!
	// (...using the jQuery library in this case)

	$(mp4Vid).attr('src', args);

	player.load();
	player.play();


	$('.list_play').each(function(){
		if($(this).attr('id') == "list_"+id)
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



}
</script>
<?php include('Footer.php');?>
