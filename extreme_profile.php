<?php
	include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];

$userType= $_SESSION['user_type'];


$titleofpage="Home";

include('HostProfilesInnerHeader.php');



if(isset($_GET['openWindowforum']))
{
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			var openURL = $('#siteURL').val();
			window.open(openURL+'read_more_cityevent.php?id=<?php echo $_GET["openWindowforum"];?>&action=event','','width=500,height=700,resizable=true,left=500,top=200');return false;
		});
	</script>
	<?php 
}


$AutoLoadStreaming = '';

if(isset($_GET['host_id']))
{
	$userID_stream = $_GET['host_id'];
	$userID_type = 'club';
	if($userID_stream == $_SESSION['user_id'] && $_SESSION['user_type'] == 'club' )
	{
		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `club` WHERE `id` = '$userID_stream'  ");
		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
		if($fetchResultStreaming['streamingLaunch'] == '1' && ($fetchResultStreaming['streamingLaunchFrom'] == 'encoder') || ($fetchResultStreaming['streamingLaunchFrom'] == 'phone') )
		{
			$AutoLoadStreaming = 'YES';
		}
		else
		{
			$AutoLoadStreaming = 'YES';
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


	$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch` FROM `clubs` WHERE `id` = '$userID_stream'  ");
	$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
	if($fetchResultStreaming['streamingLaunch'] == '1')
	{
		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `club` WHERE `id` = '$userID_stream'  ");
		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
		if($fetchResultStreaming['streamingLaunch'] == '1' && ($fetchResultStreaming['streamingLaunchFrom'] == 'encoder') || ($fetchResultStreaming['streamingLaunchFrom'] == 'phone') )
		{
			$AutoLoadStreaming = 'YES';
		}
		else
		{
			$AutoLoadStreaming = 'YES';
		}
	}
	else
	{
		$AutoLoadStreaming = 'YES';
	}
}

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;



	if( $AutoLoadStreaming == 'YES' )
	{

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
							//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
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




$hostID=$_GET['host_id'];
$sql = "select * from `clubs` where `id` = '".$hostID."'";
$userArray = $Obj->select($sql) ;
// echo $userArray[0]['club_name'];
$userArray = $Obj->select($sql) ; 
$first_name=$userArray[0]['club_name']; 
$zipcode=$userArray[0]['zip_code'];
$state=$userArray[0]['club_state'];
$country=$userArray[0]['club_country'];
$city=$userArray[0]['club_city'];
$web_url=$userArray[0]['web_url'];

$email=$userArray[0]['club_email'];
$image_nm=$userArray[0]['image_nm'];
$phone=$userArray[0]['club_contact_no'];
$plantype = $userArray[0]['plantype'];
if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];

$club_address=$userArray[0]['club_address'];
$club_city=$userArray[0]['club_city'];
$club_name=$userArray[0]['club_name'];
$type_of_club =$userArray[0]['type_of_club'];
$type_details_of_club=$userArray[0]['type_details_of_club'];
$google_map_url=$userArray[0]['google_map_url'];
$userType= $_SESSION['user_type'];

$profileViewCount = $userArray[0]['profile_count'];

if(!isset($_SESSION['Counter'][$hostID]) /*&& ($_SESSION['user_id'] != $hostID)*/ )
{
	$_SESSION['Counter'][$hostID] = $profileViewCount + 1;
	$newCounter = $_SESSION['Counter'][$hostID];
	mysql_query("UPDATE `clubs` SET `profile_count` = '$newCounter' WHERE `id` = '$hostID' ");
}



$pieces = explode(" ", $profilename);
$username_dash_separated = implode("-", $pieces);
$n = clean($username_dash_separated);
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


$paymentmessage = "";
$class="";
if(isset($_REQUEST['payment'])){
	if($_REQUEST['payment']=='success'){

		$paymentmessage =  "Your order has been successfully ordered";
		$payclass = "successmessage";
		$sql="select purchases.id as orderid,purchases.invoice,purchases.posted_date,store_order_status.status,store_order_status.id as statusid, purchases.product_quantity,purchases.product_amount,purchases.payer_address,purchases.payer_city,purchases.payer_state,purchases.payer_zip,purchases.payer_country,purchases.payer_email,host_product.product_price,host_product.id as product_id ,host_product.product_name ,user.id as user_id ,user.first_name,user.last_name,user.profilename from purchases join host_product on purchases.invoice='".$_GET['invoiceid']."' and purchases.product_type='product' and host_product.id=purchases.product_id join user on purchases.user_id=user.id join store_order_status on purchases.invoice=store_order_status.invoice order by purchases.id DESC ";
		$orderdata=mysql_query($sql);

		include_once("complete_order_mail.php");

		unset($_SESSION['cart_value']);

	}else{

		$paymentmessage = "There is problem, Please try again after some time.";
		$payclass = "errorclass";


	}
}


?>
<script>
$(document).ready(function(){
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
table#hometonightlisting th {
	width:98px;
}
.livehost_btn a {
	font-size: 12px !important;
	margin:10px 0 0;
	max-width: 80px;
	padding: 5px !important;
	text-indent: 0px;
	text-align:left;
	width: 90% !important;
}
.head_ev h2 {
	margin-top: 17px;
}
.live_host_head {
	padding-bottom:0;
	float:left;
}
</style>


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
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php include('host_left_panel.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
						<?php 

					if($paymentmessage != "")
					{
						echo "<div class='".$payclass."' style=''>".$paymentmessage."</div>";
					}

					?>
<div id="phonehostview" style="display: none;">
  <div class="user-profle">
	<div class="clubname_header"> <?php echo $club_name; ?> </div>
	<div class="hostsideimage"> <a href="<?php echo $web_url; ?>" target="_blank">
	  <? if($image_nm!="")
							{ ?>
	  <a href="<?php echo $_SERVER['SCRIPT_NAME'];?>?host_id=<? echo $_GET['host_id'];?>"> <img src="<?php echo $image_nm; ?>" height="157" width="135" /></a><br />
	  <?php } else { ?>
	  <a href="<?php echo $_SERVER['SCRIPT_NAME'];?>?host_id=<? echo $_GET['host_id'];?>"><img src="images/man4.jpg"></a>
	  <?php } ?>
	  </a> </div>
	<div class="hostaddress">
	  <div class="addressinfo">
		<div> <?php echo $club_address;?><br/>
		  <?php echo $phone;?><br/>
		  <?php 
										if($web_url != " " && $web_url != "")
										{
										?>
		  Web Site: &nbsp; <a href="<?php echo $web_url; ?>" target="_blank"> <?php echo $web_url; ?> </a>
		  <?php } ?>
		</div>
	  </div>
	  <div class="hostmap"> <a href="javascript:void(0);" onclick="goto('view-map.php?add=<?php echo $hostID;?>');"><img  src="images/map-marker.png"></a> </div>
	  <?php 
								$getCounter = mysql_query("SELECT `profile_count` FROM `clubs` WHERE `id` = '$hostID' ");
								$ftechCounter = mysql_fetch_array($getCounter);

								?>
	  <div class="profileCounter"> Total Views: <span><?php echo $ftechCounter['profile_count'];?></span> </div>
	</div>
  </div>
</div>

<div class="upcoming upcoming_clubs" sty>
  <?php 
						$getsubusersquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `host_id` = '".$_GET['host_id']."' ");
						
						$countsubusersquery = @mysql_num_rows($getsubusersquery);
					?>
  <h2 class="live_host_head">
	<?php 
							$gethostquery = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$_GET['host_id']."'  ");
							$fetchhostquery = @mysql_fetch_array($gethostquery);
							echo $fetchhostquery['club_name'];
						?> Reign Nightclub 
	
  </h2>
  <div id="liveonHost" class="livehost_btn" style="display:none;">
	  <?php 
							$pieces = explode(" ", $fetchhostquery['club_name']);
							$username_dash_separated = implode("-", $pieces);
							$username_dash_separated = clean($username_dash_separated);

							$mobile = detect_mobile();
							if($mobile === true) { 
						?>
	  <a class="button" name="submit"  onclick="goto1('https://54.174.85.75:1935/httplive/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming
	  <?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
	  <?php if(detect_stream($username_dash_separated)===true){ ?>
	  <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
	  <?php } else{ ?>
	  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
	  <?php } ?>
	  </a>
	  <? } else { ?>
	  <a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $hostID; ?>&user_type=club')">Live Streaming
	  <?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
	  <?php if(detect_stream($username_dash_separated)===true){ ?>
	  <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
	  <?php } else{ ?>
	  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
	  <?php } ?>
	  </a>
	  <?php } ?>
	</div>
  <!--<ul class="five_clubs">-->
  <div class="v2_club_listing">
  <ul>
	<?php 
											if($countsubusersquery > 0)
											{
												while($fetcsubuserquery = @mysql_fetch_array($getsubusersquery))
												{
													$mysql_query = @mysql_query("SELECT * FROM `clubs` WHERE club_name = '".$fetcsubuserquery['username']."' ");
													$fetcharray = @mysql_fetch_array($mysql_query);
													//echo "<li><a href='musicrequestlist.php?uid=".$fetcharray['id']."'>".$fetcsubuserquery['username']."</a></li>";
													?>
	<li> <span class="subuserinfo">
	  <?php 
																	if($fetcsubuserquery['userimage'] != '')
																	{ 
																		if($userArray[0]['plantype'] != 'host_free')
																		{
																?>
	  <a href='music_request.php?host_id=<?php echo $fetcharray['id'];?>'><img src='<?php echo $fetcsubuserquery[user_thumb]; ?>' width='100' height='100' /></a>
	  <?php  			}
																		else
																		{ ?>
	  <a href='#'><img src='<?php echo $fetcsubuserquery[user_thumb]; ?>' width='100' height='100' /></a>
	  <?php       					}

																	}
																	else
																	{ 
																		 echo "<img src='images/man4.jpg'  alt='' width='100' height='100' /> "; 
																	} ?>
	  </span>
	  <div class="subusercam">
		<?php 
																if($userArray[0]['plantype'] != 'host_free')
																{
																	?>
		<a href='music_request.php?host_id=<?php echo $fetcharray['id'];?>'><?php echo $userArray[0]['club_name']."-".$fetcsubuserquery['username']; ?></a>
		<?php 

																}
																else
																{
																	?>
		<a href='#'><?php echo $userArray[0]['club_name']."-".$fetcsubuserquery['username']; ?></a>
		<?php 
																}

														?>
		<br>
		<?php			

							$pieces = explode(" ", $fetcsubuserquery['username']);
							$Subusername_dash_separated = implode("-", $pieces);
							$Subusername_dash_separated = clean($Subusername_dash_separated);

							$mobile = detect_mobile();
							if($mobile === true) { 
							?>
		<a class="button" name="submit"  onclick="goto1('https://54.174.85.75:1935/httplive/<?php echo $Subusername_dash_separated; ?>/playlist.m3u8')">Live Streaming
		<?php // comment by kbihm on 30-01-2015 if($fetcharray['is_launch']=='1'){?>
		<?php if(detect_stream($fetcsubuserquery['username'])===true){ ?>
		<span class="stats_icon" > <img src="images/online_u.png?t=<?= time() ?>" alt="Online" title="Online" /> </span>
		<?php } else{ ?>
		<span class="stats_icon"> <img src="images/offline_u.png?t=<?= time() ?>" alt="Offline" title="Offline"/> </span>
		<?php } ?>
		</a>
		<? } else { ?>
		<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $fetcsubuserquery['username']; ?>&host_id=<?php echo $fetcharray['id'];?>&user_type=club')">Live Streaming
		<?php //comment by kbihm on 30-01-2015 if($fetcharray['is_launch']=='1'){?>
		<?php if(detect_stream($fetcsubuserquery['username'])===true){ ?>
		<span class="stats_icon" > <img src="images/online_u.png?t=<?= time() ?>" alt="Online" title="Online" /> </span>
		<?php } else{ ?>
		<span class="stats_icon"> <img src="images/offline_u.png?t=<?= time() ?>" alt="Offline" title="Offline"/> </span>
		<?php } ?>
		</a>
		<?php } ?>
	  </div>
	</li>
	<?php 
												}
											}
											?>
										  </ul>
            	</div>
										</div>
					<?php
							$date = date('Y-m-d');
		// echo "SELECT * FROM events WHERE `date` >= '$date' AND host_id = '".$_GET['host_id']."'  ORDER BY `date` ASC LIMIT 0,5"; exit;
							$get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND  `host_id` = '$_GET[host_id]' ORDER BY  `date` ASC");
							$count_events = mysql_num_rows($get_latest_events);
							if($count_events > 0)
							{
					?>
             							<div class="seprators"></div>
								<div class='upcoming upcoming_events1' style="border-bottom: none;">
								<h1 class="h1">See all list of <a href='listevent.php?host_id=<?php echo $_GET['host_id'];?>'>Upcoming Events</a></h1>
								<div class="event_list_container">
									<div class="NewBand"> 
								<?php 
										if($count_events > 3)
										{
											$newClass = ' events_slider_true';
										}
										else
										{
											$newClass = '';
										}
										echo '<ul class="event_slider2'.$newClass.'">';
										while($row = mysql_fetch_assoc($get_latest_events))
										{ 
								?>			
											<li> 
												<div class="v2_thumb_event">
													<div class=" "> 
													<?php 
														if(!empty($row['event_image']))
														{
													?>
															<a rel="group" class="fancybox" href="<?php echo str_replace('../', '', $row['event_image']); ?>"> 
																<img alt="" src="<?php echo str_replace('../', '', $row['event_image_thumb']); ?>"> 
															</a>
												<?php   	}
														else
														{
												?>
															<a rel="group" class="fancybox" href="<?php echo $SiteURL.'events_icons/'.$row['event_category'].'.jpg'; ?>"> 
																<img alt="" src="<?php echo $SiteURL.'events_icons/'.$row['event_category'].'.jpg'; ?>"> 
															</a>
												<?php
														}
											 	?>
													</div>
													<div class="clear"></div>
												</div>
												<div class="postDateNew">
													<div class="DateCont">
														<div class="date1"><?php echo date('M',strtotime($row['date'])); ?></div>
														<div class="date2"><?php echo date('d',strtotime($row['date'])); ?></div>
													</div>
													<div class="TimeCont">
														<div class="date3"><?php echo date('D',strtotime($row['date'])); ?></div>
														<div class="date4"><?php echo date('h:i',strtotime($row['date'])); ?></div>
														<div class="date5"><?php echo date('a',strtotime($row['date'])); ?></div>
													</div>
												</div>
												<div class="BuyMore rmore">
													<a onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row['id'] ?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">
														<img src="images/rmore.png" alt="More" />
													</a>
           </div>
           	<div class="BuyMore BuyMoreTickets">
            
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
									
													<div class="clear"></div>
								

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
														 Show Ticket
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
													 Streaming Ticket
															</a> 
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
													<!-- <a href="#">More</a>
													<div class="clear"></div>
													<a href="#">Buy</a> -->
												</div>
             						<div class='clear'></div>
            
											</li>
								<?php 		} // END WHILE	?>		 
				 						</ul>
				 					</div> <!-- END NEW BAND -->
								</div>
							</div>
							<div class="seprators" style="padding-top:0; margin-top:0;"></div>
					<?php 	}	?>
							<div class="home_content_bottom2">
								
									<div class="video">
  <?php 
						$query1 = mysql_query("SELECT * FROM `host_ad` WHERE host_id = '$hostID' AND ad_type = 'image' ORDER BY `id` DESC LIMIT 1 ");
						$res = mysql_fetch_array($query1);
						$imgsrc = $res['ad_image'];
						$count1 = mysql_num_rows($query1);
						if($count1 > 0)
						{

						?>
						  <div class="hostadd">
							<h2>Specials</h2>
							<ul>
							  <li> <a href="<?php if($res['adv_link'] == ''){ echo $imgsrc;}else{ echo $res['adv_link']; } ?>" rel="group" class="fancybox"> <img src="<?php echo $res['ad_thumb'] ;?>" alt="" /> </a> </li>
							</ul>
						  </div>
						  <?php 
						} 	
						//$query = @mysql_query("SELECT * FROM `host_coupon` WHERE host_id = '".$hostID."' ORDER BY `id` DESC");
						$query = mysql_query("SELECT * FROM `host_coupon` WHERE host_id = '$hostID' AND `expiry_date` > '$date' ORDER BY `id` DESC");
						$count = mysql_num_rows($query);
						if($count > 0)
						{
									?>
						  <div class="hostadd extremePass photo_slider">
							<h2>Passes</h2>
							<script type="text/javascript">
															function popupwindow(url, title, w, h) {
																var left = (screen.width/2)-(w/2);
																var top = (screen.height/2)-(h/2);
																return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
															}
														</script>
							<ul class="photoslider2">
	  <?php 
								while($row = mysql_fetch_assoc($query))
								{
									//echo "<pre>"; print_r($row);exit;
									$date1 = date("Y-m-d h:i:s");
									$ts1 = strtotime($date1);
									$ts2 = strtotime($row['expiry_date']);
									
									$get_difference = $ts2 - $ts1;
									
									$imgsrc = "upload/coupon/".$row['coupon_image'];
									$thumb = $row['coupon_thumb'];
									
									if($get_difference >= 0)
									{
										if(isset($_GET['host_id']) && $_SESSION['user_type'] == 'user')
										{
											$check_usr_pas = mysql_query("SELECT * FROM user_to_content WHERE cont_id = '".$row['id']."' AND owner_id = '".$hostID."' AND user_id = '".$_SESSION['user_id']."' AND cont_type = 'pass'");
											$count_check_u_pass = mysql_num_rows($check_usr_pas);							
									
											if($count_check_u_pass == 1)
											{

												$check_non_friend_pass = @mysql_query("SELECT * FROM downloadpasses WHERE user_id = '".$_SESSION['user_id']."' AND host_id = '".$hostID."' AND pass_id = '".$row['id']."'");
												$count_p = mysql_num_rows($check_non_friend_pass);
											
												if($count_p == 1)
												{
													
													$check_redm = @mysql_query("SELECT status FROM downloadpasses WHERE user_id = '".$_SESSION['user_id']."' AND host_id = '".$hostID."' AND pass_id = '".$row['id']."'");
													$c_status = mysql_fetch_assoc($check_redm);
												
													if($c_status['status'] == 1)
													{
																		?>
														  <li> <a href="<?php echo $imgsrc ?>" rel="group" class="fancybox"><img style="width: 50px;" src="<?php echo $thumb ;?>" alt="" /></a> <span class="redeemedpass">REDEEMED</span> </li>
			  <?php 									}
													else
													{ 
				?>
														  <li> <a href="<?php echo $imgsrc ?>" rel="group" class="fancybox"><img style="width: 50px;" src="<?php echo $thumb ;?>" alt="" /></a> <span class="downloadedpass">DOWNLOADED</span> </li>
	  <?php 											}
												}
												else
												{
		?>
														  <li> <a class="passdownload" href="<?php echo $imgsrc ?>" rel="group" class="fancybox"><img style="width: 50px;" src="<?php echo $thumb ;?>" alt="" /></a> <span onclick="download_host_pas('<?php echo $hostID; ?>', '<?php echo $_SESSION['user_id']; ?>', '<?php echo $row['id']; ?>');">DOWNLOAD PASS</span> </li>
  <?php 
												}
											}
										}
									}
								} // ENDWHILE ?>
										</ul>
							  </div>
	  <?php 					} 				?>
													</div>
													<?php 

																	if(isset($_REQUEST['id']))
																	{
																		$userID=$_REQUEST['id'];
																	}
																	else
																	{
																		$userID=$hostID;	
																	}
																	$photo_sql = "select * from `uploaded` where `user_id` = '".$userID."' and user_type='club' order by img_id DESC ";
																	$photo_Array = mysql_query($photo_sql);  
																	$count = mysql_num_rows($photo_Array);
																	if($count > 0 )
																	{
															?>
               <div class="seprators"></div>
													<div class="photo_slider PhotoLists">
													  <h2>Photos</h2>
													  <ul class="photoslider1">
														<?php  
																					while($photo_row = mysql_fetch_array($photo_Array))
																					{ 
														?>
														<li> <a href="<?php echo $photo_row['img_name']; ?>" rel="group" class="fancybox"><img src="<?php echo $photo_row['thumbnail']; ?>" height="157" width="135" style="padding:7px;" /></a> </li>
														<?php 						}		?>
													  </ul>
													</div>
													<?php 			}
																	else
																	{
																		//echo "<div class='nophotos'><h2>No Photos Yet!</h2></div>";
																	}
																	
																$video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' and user_type='club' order by video_id";
																$video_Array = mysql_query($video_sql);

																if(@mysql_num_rows($video_Array)>0) 
																{
																	?>
                 <div class="seprators"></div>
		<div class="video photo_slider PhotoLists">
			<h2>Videos</h2>
				<ul class="videoslider1">
				<?php
				while($video_row = mysql_fetch_array($video_Array))
				{
	?>
								
					<li id="jw_<?php echo $video_row['video_id'];?>" <?php  /*if (strpos($video_row["video_nm"],'vimeo.com') === false) { ?> onmouseover="myFunction('a<?php echo $video_row['video_id'];?>');" onmouseout="myStopFunction('a<?php echo $video_row['video_id'];?>');" <?php }*/ ?>>
						<?php  if (strpos($video_row["video_nm"],'vimeo.com') === false) { ?>
						<!-- <a  class=""  id="ve_<?php echo $video_row["video_id"];?>" href="#dialogx<?php echo $video_row["video_id"];?>" name="modal"></a> -->
						<div class="videoList" id="a<?php echo $video_row["video_id"];?>"></div>
						<script type="text/javascript">
							jwplayer("a<?php echo $video_row["video_id"];?>").setup({
								file: "<?php echo $video_row["video_nm"];?>",
								height : 250 ,
								'events': {
									onPause :function(){
										//var Vid = "<?php echo $video_row['video_id'];?>";
										//$('li#jw_'+Vid).removeClass('play').addClass('pause');
									},
									onComplete: function(){
										var Vid = "<?php echo $video_row['video_id'];?>";
										jwplayer('a'+Vid).stop();
										$('li#jw_'+Vid).removeClass('pause');
										$('li#jw_'+Vid).removeClass('play');
									}, 
									onPlay :function(){
										//var Vid = "<?php echo $video_row['video_id'];?>";
										//$('li#jw_'+Vid).removeClass('pause').addClass('play');
									},
									//  onBuffer: function(){
									// 	var Vid = "<?php echo $video_row['video_id'];?>";
									// 	$('li#jw_'+Vid).removeClass('play').addClass('pause');
									// }, 
								}
							});
						</script>
					<?php 	}
						else
						{
					?>		<iframe src="<?php echo str_replace('../', '', $video_row['video_nm']);?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					<?php
						}
					?>
							<h5><?php echo $video_row["video_title"];?></h5>
					</li>
		<?      			}   
											echo "</ul></div>";
				}

									?>
<script type="text/javascript">
	$('.videoslider1 li').each(function(){
		var i = $(this).attr('id');
		i = i.split('_');
		var id = i[1];


		// $(this).hover{
		// 	function () {
		// 		var state = jwplayer('a'+id).getState();
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
		<?php 
				$myquery = @mysql_query("SELECT  * FROM  host_product WHERE  host_id= '$userID' AND `featured` = '1' ORDER BY `id` DESC ");
				//$myquery2 = @mysql_query("SELECT * FROM dj_video where host_id = '$userID' AND tonightlist = '1' ORDER BY trackname ASC");

				if(mysql_num_rows($myquery) > 0)  
				{
				?><div class="seprators"></div>
							<div class="video PhotoLists">
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
												<a href="product.php?id=<?php echo $featuredProduct['id'];?>&host_id=<?php echo $userID; ?>">
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
					</div>
				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>


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
</script>
<?
include('Footer.php');
?>
