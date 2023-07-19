<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Home";


// echo "<pre>"; print_r($_SESSION);

// echo "<pre>"; print_r($_GET);echo "</pre>"; exit;

$PublicUser = trim($_GET['user']);
$PublicUser =  str_replace("/", "", $PublicUser);

$club_name = mysql_real_escape_string($PublicUser);
$sql = "select * from `clubs` where `club_name` = '".$club_name."' AND `club_email` != '' ";
$userArray = $Obj->select($sql) ; 


if(count($userArray) < 1)
{
	$Obj->Redirect('index.php');
	die;
}

$hostID=$userArray[0]['id'];
$userID=$userArray[0]['id'];

//echo "<pre>"; print_r($explode);echo "</pre>"; exit;

if(isset($_GET['page']) && $_GET['page'] == 'EPK')
{
	$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
	$getDefaultEPk = mysql_query("SELECT * FROM `epk_host_info` WHERE `host_id` = '$hostID' AND `status` = '1' ");
	$fetchEPKid = mysql_fetch_assoc($getDefaultEPk);
	$template = $fetchEPKid['template'];
	if($template == '0')
	{
		echo $EPKhtml = file_get_contents($SiteURL.'viewEPK.php?Uid='.$fetchEPKid['epkId'].'&host_id='.$hostID);
		die;
	}
	elseif($template == '1' )
	{
		echo $EPKhtml = file_get_contents($SiteURL.'viewEPK1.php?Uid='.$fetchEPKid['epkId'].'&host_id='.$hostID);
		die;
	}
	elseif($template == '2')
	{
		echo $EPKhtml = file_get_contents($SiteURL.'viewEPK2.php?Uid='.$fetchEPKid['epkId'].'&host_id='.$hostID);
		die;
	}


	
}



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
$facebookLink = $userArray[0]['facebookLink'];
$instaLink = $userArray[0]['instaLink'];
$twitterLink = $userArray[0]['twitterLink'];


$profilename = $club_name;
$n = $profilename;
if(!isset($_SESSION['Counter'][$hostID]) /*&& ($_SESSION['user_id'] != $hostID)*/ )
{
	$_SESSION['Counter'][$hostID] = $profileViewCount + 1;
	$newCounter = $_SESSION['Counter'][$hostID];
	mysql_query("UPDATE `clubs` SET `profile_count` = '$newCounter' WHERE `id` = '$hostID' ");
}

$checksubuserquery = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$hostID."' ");
$fetchsubuserquery = @mysql_fetch_array($checksubuserquery);
$getsubuserquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$fetchsubuserquery['club_name']."' ");
$fetchsubuser1 = @mysql_fetch_array($getsubuserquery);
$fetchsubusercount = @mysql_num_rows($getsubuserquery);

if($fetchsubusercount > 0 )
{
	header('Location: music_request.php?host_id='.$hostID);
	die;
}

$paymentmessage = "";
$class="";
if(isset($_REQUEST['payment'])){
	if($_REQUEST['payment']=='success'){
		
	$invoice = $_GET['invoiceid'];	
	$row=@mysql_query("select * from `temp_purchase` where invoice=".$invoice);
	$i=1;
	while($row1 = mysql_fetch_array( $row)){
	 @mysql_query("INSERT INTO `purchases` 
	 	(`tax_name`, `tax_rate`, `invoice`, `product_id`,`trasaction_id`,`log_id`, `product_name`, `product_quantity`, `product_amount`, `payer_fname`, `payer_lname`, `payer_address`, `payer_city`, `payer_state`, `payer_zip`, `payer_country`, `payer_email`, `payment_status`, `posted_date`,`product_type`,`user_id`,`host_id`,`product_size`,`product_color`) 
	 	VALUES('".$_SESSION['tax_rate_name']."', '".$_SESSION['shipping_charges_add']."', '".$row1["invoice"]."', '".$row1["product_id"]."', '".$trasaction_id."', '".$log_array."', '".$row1["product_name"]."', '".$row1["product_quantity"]."', '".$row1["product_amount"]."', '".$row1["payer_fname"]."', '".$row1["payer_lname"]."', '".$row1["payer_address"]."', '".$row1["payer_city"]."', '".$row1["payer_state"]."', '".$row1["payer_zip"]."', '".$row1["payer_country"]."', '".$row1["payer_email"]."', 'complete', NOW(),'".$row1["product_type"]."','".$row1["user_id"]."','".$row1["host_id"]."','".$row1["product_size"]."','".$row1["product_color"]."')");
 if($row1["product_type"]=='product'){
	 @mysql_query("INSERT INTO `store_order_status` 
	 	(`invoice`, `status`,`date`) 
	 	VALUES('".$row1["invoice"]."', '0', 'now()')");

	 $stID = mysql_insert_id();
	 	@mysql_query("UPDATE product_sizes SET `stock`=(`stock`-".$row1["product_quantity"].") WHERE `product_id`=".$row1["product_id"]." and size=".$row1["product_size"]." and color=".$row1["product_color"]);

/* NOTIFICATION CODE */

	 	$order_added_on = date('Y-m-d h:i:s');
		$c_identifier = "store_order_status_".$stID;
		
		mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$row1["user_id"]."', '".$row1["host_id"]."', 'order', '".$order_added_on."', '1', '".$c_identifier."', 'user', 'club')");

/* END */		
	}
	
   $invoice=$row1["invoice"];
   $userid=$row1["user_id"];
	 $i++;
	}		
	mysql_query("delete  FROM `temp_purchase` WHERE invoice !='".$invoice."' AND user_id='".$userid."'");
	
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
// include('HostHeaderLogin.php');
include('PublicProfileHeader.php');



// echo $type_of_club; die;

if($type_of_club == "97")
{

	include('dj_home_redirect.php');
	
} // END FOR IF CASE FOR CLUB TYPE= DJ
elseif($type_of_club == '101')
{
	include('band_home_redirect.php');
}
elseif($type_of_club == '102')
{
	include('theatre_home_redirect.php');
}
elseif($type_of_club == '103')
{
	include('fight_home_redirect.php');
}
elseif($type_of_club == '96')
{
	include('comedy_home_redirect.php');
}
elseif($type_of_club == '105')
{
	//die('dfdfddfd');
	include('extreme_profile_redirect.php');
	die();
}
elseif($type_of_club == '106')
{
	include('fighter_home_redirect.php');
	die();
}
elseif($type_of_club == '107')
{
	//die('dfdfddfd');
	include('promoter_home_redirect.php');
	die();
}
elseif($type_of_club == '108')
{
	$breakDetailsofClub = explode(',', $type_details_of_club);
	if(in_array('DJs', $breakDetailsofClub))
	{
		include('dj_home_redirect.php');
		die;

	}
	elseif(in_array('Comedy Club', $breakDetailsofClub))
	{
		include('dj_home_redirect.php');
		die();
	}
	else
	{
		include('artist_home_redirect.php');
		die;
	}

}
elseif($type_of_club == '109')
{
	//die('dfdfddfd');
	include('promoter_artist_home_redirect.php');
	die();
}
else
{
	
$profilename = $club_name;
$pieces = explode(" ", $profilename);
$username_dash_separated = implode("-", $pieces);
$n = clean($username_dash_separated);


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

<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   include('host_left_panel.php');	?>
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
									  <a href="/host_profile.php?host_id=<? echo $hostID;?>"> <img src="<?php echo $image_nm; ?>" height="157" width="135" /></a><br />
									  <?php } else { ?>
									  <a href="/host_profile.php?host_id=<? echo $hostID;?>"><img src="images/man4.jpg"></a>
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
								<div class="upcoming upcoming_clubs">
								  <?php 
														$getsubusersquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `host_id` = '".$hostID."' ");
														
														$countsubusersquery = @mysql_num_rows($getsubusersquery);
													?>
								  <h2 class="live_host_head">
									<?php 
															$gethostquery = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$hostID."'  ");
															$fetchhostquery = @mysql_fetch_array($gethostquery);
															echo $fetchhostquery['club_name'];
														?>
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
									<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $hostID; ?>')">Live Streaming
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
										<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $fetcsubuserquery['username']; ?>')">Live Streaming
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
																			else
																			{
																				echo "<li></li>";
																			}
																			?>
								  </ul>
                                  </div>
								</div>
             <div class="seprators"></div>
						<div class="upcoming upcoming_events1"> 
								<h2>See all list of <a href='listevent.php?host_id=<?php echo $hostID;?>'>Upcoming Events</a></h2>
								 <?php 
						$date = date('Y-m-d');
						$get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND host_id = '".$userID."' ORDER BY date ASC");
						$count_events = mysql_num_rows($get_latest_events);
						if($count_events > 0)
						{
							
						 ?>	

		<div class="event_list_container">
									<div class="NewBand"> 
								<?php 
									$date = date('Y-m-d');
									$get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND host_id = '".$userID."' ORDER BY date ASC");
									$count_events = mysql_num_rows($get_latest_events);
									if($count_events > 0)
									{
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
													<a onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row['id'] ?>&action=event&host_id=<?php echo $row['host_id']; ?>&page=host_profile','','width=500,height=700,resizable=true,left=0,top=0');return false;">
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
												if( ($count_ticket_check == "1" || $countPaidpasses > 0) )
												{
											?>
									
													<div class="clear"></div>
								

											<?php
													if($countPaidpasses > 0 && $fetchRecords['pass_status'] == "active" && ( $expiryPass > $currDate) )
													{
														$HostID = $row['host_id'];
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
														
														<a class="buysttickets" href="OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php echo $row['host_id']; ?>&user_type=club&ticket_id=<?php echo $ticket_id; ?>&event_id=<?php echo $row['id']; ?>">
														
														<?php }else{ ?>
														
															<a onclick="open_redirect_loginpopup_event($(this).prop('href')); return false;" class="buysttickets" href="<?php echo $SiteURL."host_profile.php?host_id=".$row['host_id'];?>">
														
														<?php } ?>
														Show Ticket
														</a>
													<?php

													}

													/**** check streaming ticket exists ****/

													if($count_ticket_check == 1)
													{
														
														$get_ticket_id = mysql_fetch_assoc($check_ticket);
														$ticket_id = $get_ticket_id['ticket_id'];
														
														$check_user_purchased_ticket = mysql_query("SELECT * FROM streaming_tickets_purchased WHERE ticket_id = '".$ticket_id."' AND buyer_user_id = '".$_SESSION['user_id']."' AND buyer_user_type = '".$_SESSION['user_type']."' AND event_id = '".$row['id']."'");
														$count_downloaded_ticket = mysql_num_rows($check_user_purchased_ticket);
														
														if($count_downloaded_ticket < 1)
														{ 
													
															if(isset($_SESSION['user_id'])){ ?>
															
																<a class="buysttickets" href="OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php echo $row['host_id']; ?>&user_type=club&ticket_id=<?php echo $ticket_id; ?>&event_id=<?php echo $row['id']; ?>">
															
															<?php }else{ ?>
															
																<a onclick="open_redirect_loginpopup_event($(this).prop('href')); return false;" class="buysttickets" href="<?php echo $SiteURL."host_profile.php?host_id=".$row['host_id'];?>">
															
															<?php } ?>
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
				 				<?php 	} // END COUNT CONDITION 	
				 					else
				 					{
				 						echo "<div class='NoRecordsFound' id='NoRecordsFound'>No events Yet!</div>";
				 					}
				 				?>
				 					</div> <!-- END NEW BAND -->
								</div>


<?php
										
						}
						else
						{
							echo '<div class="noEvents" style="border-bottom: none;"><h2 style="border-bottom: none;">No Events Found for this Host!</h2></div>';
						}
					?>
     </div>
					</div>		 
        <div class="home_content_bottom2"><div class="seprators" style="padding-top:0; margin-top:0;"></div>
								<div class="video vidLidts">
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
								  <?php 						} 	
														$Passquery = mysql_query("SELECT * FROM `host_coupon` WHERE host_id = '".$hostID."' ORDER BY `id` DESC");
														$count = mysql_num_rows($Passquery);
														if($count > 0)
														{
											?>
								  <div class="hostadd  extremePass photo_slider">
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
							
						$date = date('Y-m-d');
							$query = mysql_query("SELECT * FROM `host_coupon` WHERE host_id = '$hostID' AND `expiry_date` > '$date' ORDER BY `id` DESC");
							
							$count = mysql_num_rows($query);
							if($count > 0)
							{
								while($row = mysql_fetch_assoc($query))
								{
									
									$imgsrc = "upload/coupon/".$row['coupon_image'];
									$thumb = $row['coupon_thumb'];

									$date1 = date("Y-m-d");
									$ts1 = strtotime($date1);
									$ts2 = strtotime($row['expiry_date']);
									
									$get_difference = $ts2 - $ts1;									
									
									if($get_difference >= 0)
									{


									?>
									
										<li>
											<a href="<?php echo $imgsrc ?>" rel="group" class="fancybox">
												<img  src="<?php echo $thumb ;?>" alt="" />
                                       								</a>
                                       								<h5><?php echo $row['coupon_name'];?></h5>
                                       							</li>
										
									<?php
									}
								}
							}
						?>
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
													echo "<div class='nophotos'><h2></h2></div>";
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
								<li> <a  id="ve_<?php echo $video_row["video_id"];?>" href="#dialogx<?php echo $video_row["video_id"];?>" name="modal"></a>
								  <div id="a<?php echo $video_row["video_id"];?>"></div>
								  <script type="text/javascript">
																jwplayer("a<?php echo $video_row["video_id"];?>").setup({
																file: "<?php echo $video_row["video_nm"];?>",
																height : 250 ,
																width: 275
																});
																</script> 
								</li>
								<?			}
												echo "</ul></div>";
											}
											else
											{
												echo "<div class='nophotos'><h2></h2></div>";
											}
										?>
								<?php 
												$myquery = mysql_query("SELECT * FROM music where host_id = '$hostID' AND tonightlist = '1' ORDER BY trackname ASC");
												$myquery2 = @mysql_query("SELECT * FROM dj_video where host_id = '$hostID' AND tonightlist = '1' ORDER BY trackname ASC");
												if(mysql_num_rows($myquery)>0 || mysql_num_rows($myquery2)>0) 
												{
												?>
            		 <div class="seprators"></div>
								<div class="video">
								<h2>Tonight's Music</h2>
								<?
														$i=1;
											 ?>
								<div class="tab_scroll">
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
										//if(mysql_num_rows($myquery)>0) 
									 // {
															$a= 0;
											while($res = mysql_fetch_array($myquery))
											 {?>
								<form method="POST" action="cart.php">
								  <tr>
									<td><audio style="display:none;" controls id="player<?php echo $a ;?>">
										<source src="<?php echo $res['musicpath'];?>" type="audio/mpeg">
										<source src="<?php echo $res['musicpath'];?>" type="audio/ogg">
										<embed height="50" width="100" src="<?php echo $res['musicpath'];?>"></embed>
									  </audio>
									  <a href='javascript:play1();' id="<?php echo $a;?>" class="test audio"><img src="images/new_portal/play.png"  /></a> <a href='javascript:pause();' class='pause' id="<?php echo $a;?>"><img src="images/new_portal/pause.png"  /></a></td>
									<td><?php echo $res['trackname']; ?></td>
									<td><?php echo $res['artist']; ?></td>
									<td><?php echo $res['label']; ?></td>
									<td><?php echo $res['genre']; ?></td>
									<td><?php 
																						$date =  $res['releasedate'];
																	$sort = strtotime($date);
																		echo date('M d, Y',$sort);          
																				?></td>
									<td><input type="hidden" name="product_id" value="<?php echo $res['id'];?>">
									  <input type="hidden" name="price_cart" value="<?php echo $res['price'];?>">
									  <input type="hidden" name="host_id" value="<?php echo $hostID;?>">
									  <input type="hidden" name="product_type" value="0">
									  <input type="hidden" name="music_type" value="music">
									  <input type="hidden" name="product_qty" value="1">
									  <?  $data_upgrade_needed=chk_upgrade_needed_shopping($data_upgrade['plantype'],"18",$hostID);
																																			if(!$data_upgrade_needed){?>
									  <input type='submit' class="button" value="<?php echo "$".$res['price']; ?>" />
									  <?}else{?>
									  
									  <!--<input type='button' onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')" class="button" value="<?php echo "$".$res['price']; ?>" />--> 
									  <?php echo "$".$res['price']; ?>
									  <? } ?></td>
								  </tr>
								</form>
								<?php 
															$a++;
													}
												
											 // if(mysql_num_rows($myquery2)>0) 
															//{
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
									<td><?php  $date =  $res['releasedate'];
																						$sort = strtotime($date);
																if($res['releasedate'] != ""){ echo date('M d, Y',$sort); }         
																				?></td>
									<td><input type="hidden" name="product_id" value="<?php echo $res['id'];?>">
									  <input type="hidden" name="price_cart" value="<?php echo $res['price'];?>">
									  <input type="hidden" name="host_id" value="<?php echo $hostID;?>">
									  <input type="hidden" name="product_type" value="0">
									  <input type="hidden" name="music_type" value="video">
									  <input type="hidden" name="product_qty" value="1">
									  <?  $data_upgrade_needed=chk_upgrade_needed_shopping($data_upgrade['plantype'],"18",$hostID);
																																					if(!$data_upgrade_needed){?>
									  <input type='submit' class="button" value="<?php echo "$".$res['price']; ?>" />
									  <?}else{?>
									  
									  <!--<input type='button' onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')" class="button" value="<?php echo "$".$res['price']; ?>" />--> 
									  <?php echo "$".$res['price']; ?>
									  <? } ?></td>
								  </tr>
								</form>
								<?     }
															
												echo "</table>  
														 </div></div>   ";
													 
													 ?>
								<?php } // END COUNT CONDITION?>

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
					</div>
					</div>
				</div>
			</div>
		</article>
	</div>
</div>
<?php 
}  // END FOR DIFFRENT CLUB TYPES CHECK 

include('Footer.php'); 

?>