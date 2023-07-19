 <?php
include("Query.Inc.php");
$Obj      = new Query($DBName);
$userID   = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

// echo "<pre>"; print_r($_SESSION); exit;

if (!isset($_SESSION['user_id'])) {
    $Obj->Redirect("index.php?error=yes");
    die;
}


if (isset($_SESSION['subuser'])) {
    $Obj->Redirect('musicrequestList.php');
    die;
}


$fetmetaquery     = @mysql_query("SELECT * FROM `facebookshare` ORDER BY `id` DESC limit 1 ");
$fetchmetacontent = @mysql_fetch_array($fetmetaquery);
$countinfo        = @mysql_num_rows($fetmetaquery);

if ($countinfo > 0) {
    $image       = $fetchmetacontent['image'];
    $description = $fetchmetacontent['description'];
} else {
    $image       = "images/mySittiLogo.jpg";
    $description = "Making Every City Your City";
}

$titleofpage = " Club Home";

include('HostProfilesInnerHeader.php');


$type_details_of_club = $loggedin_host_data['type_details_of_club'];



if ($loggedin_host_data['type_of_club'] == "97") {
    $uu = 'dj_home.php';
    $Obj->Redirect($uu);
    die();
} elseif ($loggedin_host_data['type_of_club'] == '101') {
    $Obj->Redirect("band_home.php");
    die();
} elseif ($loggedin_host_data['type_of_club'] == '102') {
    $Obj->Redirect("theatre_home.php");
    die();
} elseif ($loggedin_host_data['type_of_club'] == '103') {
    $Obj->Redirect("fight_home.php");
    die();
} elseif ($loggedin_host_data['type_of_club'] == '105') {
    $Obj->Redirect("extreme_club.php");
    die();
} elseif ($loggedin_host_data['type_of_club'] == '106') {
    $Obj->Redirect("fighter_home.php");
    die();
} elseif ($loggedin_host_data['type_of_club'] == '96') {
    $Obj->Redirect("comedy_home.php");
    die();
} elseif ($loggedin_host_data['type_of_club'] == '107') {
    $Obj->Redirect("promoter_home.php");
    die();
} elseif ($loggedin_host_data['type_of_club'] == '108') {
    $breakDetailsofClub = explode(',', $type_details_of_club);
    if (in_array('DJs', $breakDetailsofClub)) {
        $uu = 'dj_home.php';
        $Obj->Redirect($uu);
        die();
    } elseif (in_array('Comedy Club', $breakDetailsofClub)) {
        $Obj->Redirect("comedy_home.php");
        die();
    } elseif (in_array('Band', $breakDetailsofClub)) {
        $Obj->Redirect("band_home.php");
        die();
    }
    // elseif(in_array('Comedy Club', $breakDetailsofClub))
    // {
    // 	$Obj->Redirect("comedy_home.php");
    // 	die();
    // }
    
    $Obj->Redirect("artist_home.php");
    die();
} elseif ($loggedin_host_data['type_of_club'] == '109') {
    //die('dfsfsdfsdf');
    $Obj->Redirect("promoter_artist_home.php");
    die();
}


$profilename             = $club_name;
$pieces                  = explode(" ", $profilename);
$username_dash_separated = implode("-", $pieces);
$n                       = clean($username_dash_separated);

// include("live2/flash_detect.php") ;



$AutoLoadStreaming = '';

if (isset($_GET['host_id'])) {
    $userID_stream = $_GET['host_id'];
    $userID_type   = 'club';
    if ($userID_stream == $_SESSION['user_id'] && $_SESSION['user_type'] == 'club') {
        $checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `club` WHERE `id` = '$userID_stream'  ");
        $fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
        if ($fetchResultStreaming['streamingLaunch'] == '1' && $fetchResultStreaming['streamingLaunchFrom'] == 'encoder') {
            $AutoLoadStreaming = 'YES';
        } else {
            $AutoLoadStreaming = 'YES';
        }
    } else {
        $AutoLoadStreaming = 'YES';
    }
} else {
    $userID_stream = $_SESSION['user_id'];
    $userID_type   = $_SESSION['user_type'];
    
    
    $checkStreamingLaunch = mysql_query("SELECT `streamingLaunch` FROM `clubs` WHERE `id` = '$userID_stream'  ");
    $fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
    if ($fetchResultStreaming['streamingLaunch'] == '1') {
        $checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `club` WHERE `id` = '$userID_stream'  ");
        $fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
        if ($fetchResultStreaming['streamingLaunch'] == '1' && $fetchResultStreaming['streamingLaunchFrom'] == 'encoder') {
            $AutoLoadStreaming = 'YES';
        } else {
            $AutoLoadStreaming = 'YES';
        }
    } else {
        $AutoLoadStreaming = 'YES';
    }
}
// echo $AutoLoadStreaming; die;

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;




if ($AutoLoadStreaming == 'YES') {
    
?>
		<script type="text/javascript">
			$(document).ready(function(){
				setInterval(function()
				{
					$.ajax({
						type: "POST",
						url: "checkStream.php",
						data: {
							'host_id' : '<?php echo $userID_stream; ?>',
							'usertype' : '<?php echo $userID_type; ?>',

						},
						success: function(data){
							//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"]; ?>?host_id='+id;
							var dd = data.split('++++');
							//alert(dd[1]);
							if($.trim(dd[0]) == "Streaming" )
							{
								
								if($('.sxtreme_play_vid').hasClass('changed'))
								{
								
								}
								else
								{
									$('.sxtreme_play_vid').removeClass('offline_stream').addClass('changed');
									$('.sxtreme_play_vid').html($.trim(dd[1]));
									$('#GROUPid').val(dd[2]);
									if($.trim(dd[3]) != '' && $.trim(dd[4]) != '')
									{
										$('#AjaxChatDiv').empty().append(dd[4]);
										$('body').append(dd[3]);
									}
									$.ajax({
										type: "POST",
										url: "refreshajax.php",
										data: {
											'host_id' : '<?php echo $userID_stream; ?>',
											'usertype' : '<?php echo $userID_type; ?>',
											'action' : 'updatestreamingcounter',
										},
										success: function(data){

										}
									});
								}
							}
							else
							{
								
								if($('.sxtreme_play_vid').hasClass('offline_stream'))
								{
								
								}
								else
								{
									
									$('.sxtreme_play_vid').removeClass('changed').addClass('offline_stream');
									$('.sxtreme_play_vid').html($.trim(dd[1]));
									$('#GROUPid').val('');
									$('#AjaxChatDiv').html(dd[2]);
									//alert($('#mp4Source').attr('src'));
									var src = $('#mp4Source').attr('src');
									if($('#mp4Source').attr('type') == 'video/youtube')
									{
										//var player = new MediaElementPlayer('#tv_main_channel');
										jwplayer("tv_main_channel").setup({
											file: src,
										});
									}
									else
									{
										jwplayer("tv_main_channel").setup({
											file: src,
										});
									}
								}
							}


						}
					});
				}, 10000);
			});
		</script>

	<?php
}



// $getgroupinfo = mysql_query("SELECT * FROM `chat_groups` WHERE `group_name` = '$n' ");
// $fetchGroup = mysql_fetch_array($getgroupinfo);
// if(mysql_num_rows($getgroupinfo) > 0)
// {
// 	$groupID = $fetchGroup['id'];

// 	$CountUser = mysql_query("SELECT `id` FROM `chat_users_groups` WHERE `group_id` = '$groupID' AND `user_id` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]'  ");
// 	if(mysql_num_rows($CountUser) < 1 )
// 	{
// 		mysql_query("INSERT INTO `chat_users_groups` (`group_id`,`user_id`,`user_type`) VALUES ('$groupID','$_SESSION[user_id]','$_SESSION[user_type]')  ");
// 	}
// }
// else
// {
// 	mysql_query("INSERT INTO `chat_groups` (`group_name`,`group_type`,`create_by`,`user_type`) 
// 							VALUES ('$clubName','streaming','$clubId','club') ");
// 	$ID = mysql_insert_id();
// 	mysql_query("INSERT INTO chat_users_groups (group_id,user_id,user_type) VALUES ('$ID','$clubId','club')");
// }



?>


<script>
$(document).ready(function(){
	refreshCaptcha('<?php echo $SiteURL; ?>');
 $('.events_slider_true').bxSlider({
	mode: 'horizontal', //mode: 'fade',            
	speed: 500,
	auto: true,
	slideWidth: 200, 
	slideMargin: 10,
	minSlides: 1,
	infiniteLoop: true,
	autoStart: true,
	hideControlOnEnd: true,
	useCSS: false,
	// position: 1,
});
 });
</script>
<style type="text/css">
	table#hometonightlisting th{width:98px;}
.livehost_btn a {
  font-size: 12px !important;
  margin: 10px 0 0;
  padding: 5px !important;
  text-align: left;
  text-indent: 0;
}
	.head_ev h2 {
  margin-top: 38px;
}
	.live_host_head {padding-bottom:0; float:left;}
  .gutter-top {
   padding-top:15px;
  }
</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
  
	<?php include('club-right-panel.php'); ?>
	<!-- END SIDEBAR CODE -->

	<?php $getsubusersquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `host_id` = '" . $_SESSION['user_id'] . "' ");
	$countsubusersquery = @mysql_num_rows($getsubusersquery);
	?>
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
									<div class="upcoming_evnt">
						<div class="upcoming upcoming_clubs">
					
					<h2>
						<?php echo $profilename; 
						if ($_SESSION['user_id'] == '113') { ?>
						<a href="view-all-cam.php" class="button btn" style="float: right; font-size: 12px;">View All Cam</a>
						<?php } ?>
					</h2>
					<div id="liveonHost" class="livehost_btn" style="display:none;">
					<?php
$pieces                  = explode(" ", $profilename);
$username_dash_separated = implode("-", $pieces);
$username_dash_separated = clean($username_dash_separated);

$mobile = detect_mobile();
if ($mobile === true) {
?>

								<a class="button" name="submit"  onclick="goto1('https://54.174.85.75:1935/httplive/<?php
    echo $username_dash_separated;
?>/playlist.m3u8')">Live Streaming
								<?php // comment by kbihm on 30-01-2015 if($loggedin_host_data['is_launch']=='1'){

    if (detect_stream($username_dash_separated) === true) {
?>
											   <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
										  <?php
    } else {
?>
											  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
										  <?php
    }
?>                        
								
								</a> 
					 
					 

							<?php
} else {
?>

								<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php
    echo $username_dash_separated;
?>&host_id=<?php
    echo $_SESSION['host_id'];
?>&user_type=club')">Live Streaming
								<?php // comment by kbihm on 30-01-2015 if($loggedin_host_data['is_launch']=='1'){

    if (detect_stream($username_dash_separated) === true) {
?>
											   <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
										  <?php
    } else {
?>
											  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
										  <?php
    }
?>                        
								
								</a>

						<?php
}
?>
					</div>
					<div class="clear"></div>
	<?php
if ($countsubusersquery > 0) {
?>
					<div class="v2_club_listing">
					<ul>
					<?php
    if ($countsubusersquery > 0) {
        while ($fetcsubuserquery = @mysql_fetch_array($getsubusersquery)) {
            $mysql_query = @mysql_query("SELECT * FROM `clubs` WHERE club_name = '" . $fetcsubuserquery['username'] . "' ");
            $fetcharray  = @mysql_fetch_array($mysql_query);
?>
					<li>
					<span class="subuserinfo">
					<?php
            if ($fetcsubuserquery['user_thumb'] != '') {
                
?>
					<a href='music_request.php?host_id=<?php
                echo $fetcharray['id'];
?>'><img src='<?php
                echo $fetcsubuserquery[user_thumb];
?>' width='100' height='100' /></a>
					<?php
            } else {
                echo "<img src='images/man4.jpg'  alt='' width='100' height='100' /> ";
            }
?>
					</span>
					<div class="subusercam">
						<p>
						<a href='music_request.php?host_id=<?php
            echo $fetcharray['id'];
?>'><?php
            echo $profilename . "-" . $fetcsubuserquery['username'];
?></a>
						</p>
						
						
						<br>
					
				
						<?php
            $pieces                     = explode(" ", $fetcsubuserquery['username']);
            $Subusername_dash_separated = implode("-", $pieces);
            $Subusername_dash_separated = clean($Subusername_dash_separated);
            
            $mobile = detect_mobile();
            if ($mobile === true) {
?>
						<p>
						<a class="button" name="submit"  onclick="goto1('https://54.174.85.75:1935/httplive/<?php
                echo $Subusername_dash_separated;
?>/playlist.m3u8')">Live Streaming

								<?php //if($fetcharray['is_launch']=='1'){
?>
								<?php
                if (detect_stream($fetcsubuserquery['username']) === true) {
?>
								<span class="stats_icon" >
								<img src="images/online_u.png?t=<?= time() ?>" alt="Online" title="Online" />
								</span>
								
								<?php
                } else {
?>
								
								<span class="stats_icon">
								<img src="images/offline_u.png?t=<?= time() ?>" alt="Offline" title="Offline"/>
								</span>
								
								<?php
                }
?>
						</a>
			 
						</p>
						<?
            } else {
?>

						<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php
                echo $fetcsubuserquery['username'];
?>&host_id=<?php
                echo $fetcharray['id'];
?>&user_type=club')">Live Streaming
								<?php //if($fetcharray['is_launch']=='1'){
?>
								<?php
                if (detect_stream($fetcsubuserquery['username']) === true) {
?>
								<span class="stats_icon" >
								<img src="images/online_u.png?t=<?= time() ?>" alt="Online" title="Online" />
								</span>
								
								<?php
                } else {
?>
								
								<span class="stats_icon">
								<img src="images/offline_u.png?t=<?= time() ?>" alt="Offline" title="Offline"/>
								</span>
								
								<?php
                }
?>                      	
						
						</a>

						<?php
            }
?>						
									
				</div>
					<?php
            if ($fetcsubuserquery['profile_link'] != '') {
?>
					<div class="visitmypage">
					<span>Visit my Page: </span> <a href="<?php
                echo $fetcsubuserquery['profile_link'];
?>"><?php
                echo $fetcsubuserquery['profilename'];
?></a>
					</div>
					<?php
            }
?>
					</li>
					<?php
        }
    } else {
        echo "<li></li>";
    }
?>
					</ul>
					</div>
			<?php
} // END COUNT SUB USERS	
?>
					</div>
					
					 
					<?php
$date              = date('Y-m-d');
$get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND host_id = '" . $_SESSION['user_id'] . "' ORDER BY date ASC");
$count_events      = mysql_num_rows($get_latest_events);
if ($count_events > 0) {
?>
						
					<div class='upcoming upcoming_events1' style="border-bottom: none;">
						<h2>See all list of <a href='listevent.php'>Upcoming Events</a></h2>
			 <?php
    $date              = date('Y-m-d');
    $get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND host_id = '" . $userID . "' ORDER BY date ASC ");
    $count_events      = mysql_num_rows($get_latest_events);
    if ($count_events > 0) {
        
?>	

							<div class="event_list_container">
									<div class="NewBand"> 
								<?php
        $date              = date('Y-m-d');
        $get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND host_id = '" . $userID . "' ORDER BY date ASC LIMIT 0,5");
        $count_events      = mysql_num_rows($get_latest_events);
        if ($count_events > 3) {
            $newClass = ' events_slider_true';
        } else {
            $newClass = '';
        }
        echo '<ul class="event_slider2' . $newClass . '">';
        while ($row = mysql_fetch_assoc($get_latest_events)) {
?>			
											<li> 
												<div class="v2_thumb_event">
													<div class=" "> 
													<?php
            if (!empty($row['event_image'])) {
?>
															<a rel="group" class="fancybox" href="<?php
                echo str_replace('../', '', $row['event_image']);
?>"> 
																<img alt="" src="<?php
                echo str_replace('../', '', $row['event_image_thumb']);
?>"> 
															</a>
												<?php
            } else {
?>
															<a rel="group" class="fancybox" href="<?php
                echo $SiteURL . 'events_icons/' . $row['event_category'] . '.jpg';
?>"> 
																<img alt="" src="<?php
                echo $SiteURL . 'events_icons/' . $row['event_category'] . '.jpg';
?>"> 
															</a>
												<?php
            }
?>
													</div>
													<div class="clear"></div>
												</div>
												<div class="postDateNew">
													<div class="DateCont">
														<div class="date1"><?php
            echo date('M', strtotime($row['date']));
?></div>
														<div class="date2"><?php
            echo date('d', strtotime($row['date']));
?></div>
													</div>
													<div class="TimeCont">
														<div class="date3"><?php
            echo date('D', strtotime($row['date']));
?></div>
														<div class="date4"><?php
            echo date('h:i', strtotime($row['date']));
?></div>
														<div class="date5"><?php
            echo date('a', strtotime($row['date']));
?></div>
													</div>
												</div>
												<div class="BuyMore rmore">
													<a onclick="javascript:void window.open('read_more_cityevent.php?id=<?php
            echo $row['id'];
?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">
														<img src="images/rmore.png" alt="More" />
													</a>
														</div>
														<div class="BuyMore BuyMoreTickets">
			
												  <?php
            $check_ticket       = mysql_Query("SELECT * FROM streaming_tickets WHERE event_id = '" . $row['id'] . "'");
            $count_ticket_check = mysql_num_rows($check_ticket);
            
            /* PAID PASSES QUERY */
            $getPaidpass     = mysql_query("SELECT * FROM `paid_passes` WHERE `event_id` = '$row[id]' ");
            $fetchRecords    = mysql_fetch_assoc($getPaidpass);
            $countPaidpasses = $fetchRecords['no_of_tickets'];
            $currDate        = strtotime(date('Y-m-d H:i:s'));
            $expiryPass      = strtotime($fetchRecords['expiry_date']);
?>
												<?php
            if (($count_ticket_check == "1" || $countPaidpasses > 0) && $_SESSION['user_type'] == 'user') {
?>
									
													<div class="clear"></div>
								

											<?php
                if ($countPaidpasses > 0 && $fetchRecords['pass_status'] == "active" && ($expiryPass > $currDate)) {
                    $HostID             = $_GET['host_id'];
                    $get_str_host_email = mysql_query("SELECT `merchant_id` FROM `clubs` WHERE `id` = '$HostID' ");
                    $count_email        = mysql_num_rows($get_str_host_email);
                    
                    if ($count_email < 1) {
                        
                        $host_email = "";
                        
                    } else {
                        
                        $set_host_email = mysql_fetch_assoc($get_str_host_email);
                        $host_email     = $set_host_email['merchant_id'];
                        
                    }
                    
                    $hide_btn = "style='display: none;'";
                    
                    $payment_amount = trim(str_replace("$", '', $fetchRecords['amount']));
                    $host_email_set = $host_email;
                    $item_name      = "Buy Ticket";
?>
														<a  class="buyshowtickets"  href="buyStageTicket.php?host_id=<?php
                    echo $HostID . '&str_amt=' . $payment_amount . '&user_type=' . $_SESSION['user_type'] . '&passid=' . $fetchRecords['pass_id'] . '&event_id=' . $row['id'];
?>">
														 Show Ticket
														</a>
													<?php
                    
                }
                
                /**** check streaming ticket exists ****/
                
                if ($count_ticket_check == 1 && $_SESSION['user_type'] == 'user') {
                    
                    $get_ticket_id = mysql_fetch_assoc($check_ticket);
                    $ticket_id     = $get_ticket_id['ticket_id'];
                    
                    $check_user_purchased_ticket = mysql_query("SELECT * FROM streaming_tickets_purchased WHERE ticket_id = '" . $ticket_id . "' AND buyer_user_id = '" . $_SESSION['user_id'] . "' AND buyer_user_type = '" . $_SESSION['user_type'] . "' AND event_id = '" . $row['id'] . "'");
                    $count_downloaded_ticket     = mysql_num_rows($check_user_purchased_ticket);
                    
                    if ($count_downloaded_ticket < 1) {
?>
															<a class="buysttickets" href="OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php
                        echo $_GET['host_id'];
?>&user_type=club&ticket_id=<?php
                        echo $ticket_id;
?>&event_id=<?php
                        echo $row['id'];
?>">
													 Streaming Ticket
															</a> 
													<?php
                    } else {
?>
												 
														<span class="avail">Already Purchased Ticket</span>
													
													<?php
                    }
                }
                /**** check ticket exists ****/
            }
?>
													<!-- <a href="#">More</a>
													<div class="clear"></div>
													<a href="#">Buy</a> -->
												</div>
			 <div class='clear'></div>
			
											</li>
								<?php
        } // END WHILE	
?>		 
										</ul>
								<?php
    } // END COUNT CONDITION 	
    else {
        echo "<div class='NoRecordsFound' id='NoRecordsFound'>No events Yet!</div>";
    }
?>
									</div> <!-- END NEW BAND -->
								</div>

			</div>
			<div class="seprators"></div>
<?php
} // END EVENTS COUNT		
?>
				
	<?php
$myquery  = @mysql_query("SELECT * FROM music where host_id = '$userID' AND tonightlist = '1' ORDER BY trackname ASC");
$myquery2 = @mysql_query("SELECT * FROM dj_video where host_id = '$userID' AND tonightlist = '1' ORDER BY trackname ASC");

if (mysql_num_rows($myquery) > 0 || (mysql_num_rows($myquery2) > 0)) {
?>
  		
			 <div class="video tonighListing">
			

			  <h2>Tonight Music List</h2>
			<?
    $i = 1;
?>
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
			<?
    if (mysql_num_rows($myquery) > 0) {
        while ($res = mysql_fetch_array($myquery)) {
            $a = $res['id'];
            
?>   
			
			<tr>
				<td>
					<audio style="display:none;" controls id="player<?php
            echo $a;
?>">
					<source src="<?php
            echo $res['musicpath'];
?>" type="audio/mpeg">
					<source src="<?php
            echo $res['musicpath'];
?>" type="audio/ogg">
					<embed height="50" width="100" src="<?php
            echo $res['musicpath'];
?>"></embed>
					</audio>
					<a href='javascript:play1();' id="<?php
            echo $a;
?>" class="test audio mynewclass_play_<?php
            echo $a;
?>"><img height="30px" src="images/new_portal/play.png"></a>
					<a href='javascript:pause();' style="display: none;" class='pause mynewclass_pause_<?php
            echo $a;
?>' id="<?php
            echo $a;
?>"><img height="30px" src="images/new_portal/pause.png"></a>
				</td>
				<td><?php
            echo $res['trackname'];
?>&nbsp;</td>
				<td><?php
            echo $res['artist'];
?>&nbsp;</td>
				<td><?php
            echo $res['label'];
?>&nbsp; </td>
				<td> <?php
            echo $res['genre'];
?>&nbsp; </td>
				<td> <?php
            if (!empty($res['releasedate'])) {
                $date = $res['releasedate'];
                $sort = strtotime($date);
                echo date('M d, Y', $sort);
            }
            
?>&nbsp;
				</td>
				<td>  <?php
            echo "$" . $res['price'];
?>&nbsp;</td>
			</tr>           
			
			
			<?
        }
    }
    if (mysql_num_rows($myquery2) > 0) {
        while ($res = mysql_fetch_array($myquery2)) {
            
            
?>   
					
					<tr>
					<td>
					<!-- <a onClick="javascript:void window.open('play_video_clip.php?clip_id=<?php
            //echo $res['id'];
?>','','width=500,height=500,resizable=true,left=0,top=0');return false;"><img src="images/new_portal/play.png" height="25px" width="25px;"></a> -->
					</td>
					<td><?php
            echo $res['trackname'];
?></td>
					<td><?php
            echo $res['artist'];
?></td>
					<td><?php
            echo $res['label'];
?> </td>
					<td> <?php
            echo $res['genre'];
?> </td>
					<td> <?php
            $date = $res['releasedate'];
            $sort = strtotime($date);
            if ($res['releasedate'] != "") {
                echo date('M d, Y', $sort);
            }
?>
					</td>
					<td>  <?php
            echo "$" . $res['price'];
?></td>
					</tr>           
			
			
<?
        }
    }
?>  
			</table> 
			</div>
				</div> 
				   <div class="seprators"></div>
			<?
}
?>
	   
		</div>
  		
	   
<div class="home_content_bottom">
				
<?php

if (isset($_REQUEST['id'])) {
    $userID = $_REQUEST['id'];
} else {
    $userID = $_SESSION['user_id'];
}
$photo_sql   = "select * from `uploaded` where `user_id` = '" . $userID . "' and user_type='" . $_SESSION['user_type'] . "' order by img_id DESC ";
$photo_Array = mysql_query($photo_sql);
$count       = mysql_num_rows($photo_Array);
if ($count > 0) {
?>
				
					<div class="photo_slider v2_club_video_slider clubHomePhoto">
						<h2>Photo</h2>

			   <ul class="photoslider1">
				 <?php
    
    while ($photo_row = mysql_fetch_array($photo_Array)) {
?>
						<li>
						 <a href="<?php
        echo $photo_row['img_name'];
?>" rel="group" class="fancybox"><img src="<?php
        echo $photo_row['thumbnail'];
?>" height="157" width="135" style="padding:7px;" /></a>
						 <h5><?php
        echo $photo_row['image_title'];
?></h5>
					   </li>
						<?php
    }
?>  
			  </ul>
			  </div>
			  <div class="seprators"></div>
		<?php
    
}
?>

		 
		  
					<?
$video_sql   = "select * from `uploaed_video` where `user_id` = '" . $userID . "' and user_type='club' order by video_id DESC ";
$video_Array = mysql_query($video_sql);

if (@mysql_num_rows($video_Array) > 0) {
?>
						
							<div class="video photo_slider v2_club_video_slider forvids">
								<h2>Videos</h2>
								<ul class="videoslider1">
<?php
    
    while ($video_row = mysql_fetch_array($video_Array)) {
?>
							<li id="jw_<?php echo $video_row['video_id']; ?>"
							 <?php
        if (strpos($video_row["video_nm"], 'vimeo.com') === false) {
            echo "class='jwplayervideo'";
        }
?>>
								<?php
        if (strpos($video_row["video_nm"], 'vimeo.com') === false) {
?>
								<!-- <a  class=""  id="ve_<?php
            echo $video_row["video_id"];
?>" href="#dialogx<?php
            echo $video_row["video_id"];
?>" name="modal"></a> -->
								<div class="videoList" id="a<?php
            echo $video_row["video_id"];
?>"></div>
								<script type="text/javascript">
									jwplayer("a<?php
            echo $video_row["video_id"];
?>").setup({
										file: "<?php
            echo $video_row["video_nm"];
?>",
										height : 250 ,
										'events': {
											onPause :function(){
											//	var Vid = "<?php
            echo $video_row['video_id'];
?>";
											//	$('li#jw_'+Vid).removeClass('play').addClass('pause');
											},
											onBuffer: function(){
												
											}, 
											onPlay :function(){
											//	var Vid = "<?php
            echo $video_row['video_id'];
?>";
											//	$('li#jw_'+Vid).removeClass('pause').addClass('play');
											},
										}
									});
								</script>
							<?php
        } else {
?>		<iframe src="<?php
            echo str_replace('../', '', $video_row['video_nm']);
?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							<?php
        }
?>
									<h5><?php echo $video_row["video_title"]; ?></h5>
							</li>
		   <?
    }
?>
						</ul>
					</div>
					<div class="seprators"></div>
		<?php
}
?>
					  
					
<script type="text/javascript">
	$('.videoslider1 li.jwplayervideo').each(function(){
		var i = $(this).attr('id');
		i = i.split('_');
		var id = i[1];


		// $(this).hover(
		// 	function () {
		// 		var state = jwplayer('a'+id).getState();
		// 	//	alert(state);
		// 		if(state == 'PLAYING')
		// 		{
		// 			jwplayer('a'+id).pause();
		// 		}
		// 		else if(state == 'BUFFERING')
		// 		{
		// 			jwplayer('a'+id).pause();
		// 		}
		// 		else if(state == 'IDLE')
		// 		{
		// 			jwplayer('a'+id).pause();
		// 		}
		// 		else
		// 		{
		// 			jwplayer('a'+id).play();
		// 		}
		// 	}
		// );
	});
</script>
		  
			<div class="v2_club_video_slider photo_slider">
				   <?php
$query1 = mysql_query("SELECT * FROM `host_ad` WHERE host_id = '$userID' ORDER BY `id` DESC LIMIT 1 ");
$res    = mysql_fetch_array($query1);
// echo "<pre>"; print_r($res); exit;
$imgsrc = $res['ad_image'];
$count1 = mysql_num_rows($query1);

$date  = date('Y-m-d');
$query = mysql_query("SELECT * FROM `host_coupon` WHERE host_id = '$userID' AND `expiry_date` > '$date' ORDER BY `id` DESC");

$count = mysql_num_rows($query);



if ($count1 > 0) {
?>

						<div class="hostadd" style="display: none;">
						<h2>Specials</h2><div class="clear"></div>
						<ul>
									<li>
				<?php
    if ($res['ad_type'] == 'image') {
?>
									<a href="<?php
        echo $SiteURL . str_replace("../", "", $imgsrc);
?>" rel="group" class="fancybox" ><img src="<?php
        echo $res['ad_thumb'];
?>" alt="" /></a>
							<?php
    } elseif ($res['ad_type'] == 'video') {
?>
									<a onmouseover="jwplayer('add<?php
        echo $res["id"];
?>').play();" onmouseout="jwplayer('add<?php
        echo $res["id"];
?>').pause();" id="ve_<?php
        echo $res["id"];
?>" href="#dialogx<?php
        echo $res["id"];
?>" name="modal">
									</a>

									<div id="add<?php
        echo $res["id"];
?>"></div>
									<script type="text/javascript">
									jwplayer("add<?php
        echo $res["id"];
?>").setup({
									file: "upload/hostads/<?php
        echo $res["ad_video"];
?>",
									height : 250 ,
									width: 300
									});
									</script>

							<?php
    }
    if ($res['adv_link'] != "") {
?>
									<h5><a target="_blank" style="color:#fecd07; text-transform: none;" href="<?php
        echo $res['adv_link'];
?>"><?php
        echo $res['adv_link'];
?></a></h5>
							<?php
    }
?>
							</li>
						</ul>
					</div>
			<?php
}


if ($count > 0) {
?>
						<div class="hostadd extremePass photo_slider"> 
							<h2>Passes</h2>
							<div class="clear"></div>
							<ul class="photoslider2" id="passSlider">


						<?php
    while ($row = mysql_fetch_assoc($query)) {
        
        $imgsrc = "upload/coupon/" . $row['coupon_image'];
        $thumb  = $row['coupon_thumb'];
        
        $date1 = date("Y-m-d");
        $ts1   = strtotime($date1);
        $ts2   = strtotime($row['expiry_date']);
        
        $get_difference = $ts2 - $ts1;
        
        if ($get_difference >= 0) {
            
            
?>
									
										<li>
											<a href="<?php
            echo $imgsrc;
?>" rel="group" class="fancybox">
												<img  src="<?php
            echo $thumb;
?>" alt="" />
																	</a>
																	<h5><?php
            echo $row['coupon_name'];
?></h5>
																</li>
										
									<?php
        }
    }
?>
							</ul>
						</div>
			<?php
}
?>
		</div><!-- END v2_club_video_slider -->
					</div>
				</div>
			</div></div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>


<script type="text/javascript">
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
<?php
include('LandingPageFooter.php');
?>
<style>
ul.nav_mobile{
	display: none;
}
.notinplanhome_club{
	color: white; font-size: 17px; text-align: center;
}
.notinplanhome_club a {
	color: #fecd07;
}
.videoslider1 iframe {
  border: 3px solid #fff;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  float: left;
  height: 250px; 
  width: 100%;
}
</style>
