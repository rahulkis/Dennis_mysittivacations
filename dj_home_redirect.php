<?php
$enablediablephone=$userArray[0]['text_status'];
$banner_query =  mysql_query("SELECT `banner_name` FROM `host_banner` WHERE `user_id` = '".$userID."' AND `status` = '1'");
$banner_query_result = mysql_fetch_assoc($banner_query);
$countBanner = mysql_num_rows($banner_query);
$banner = $banner_query_result['banner_name'];

$url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

$profilename = $club_name;
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
p.discription {
	width: 100%;
}
.advmarq:nth-child(2) {
  display: none;
}
.noEvents
{
	border-bottom: none;
	text-align: center;
	padding: 20px;
	font-size: 20px;
}
.djevents {
  background: #111 none repeat scroll 0 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  -ms-box-sizing: border-box;
  -o-box-sizing: border-box;
  float: left;
  padding: 10px;
  width: 100%;
}
</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php	include('host_left_panel.php');?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
					<div class="upcoming upcoming_clubs">
					<?php 
					$getsubusersquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `host_id` = '".$userID."' ");
					
					$countsubusersquery = @mysql_num_rows($getsubusersquery);
					
					
					?>
					<h2>
						<?php echo $profilename;
						
						if($_SESSION['user_id'] == '113'){ ?> <a href="view-all-cam.php" class="button btn" style="float: right; font-size: 12px;">View All Cam</a>
						<?php } ?>
					</h2>
					<div class="clear"></div>
					
					<?php 
					if($countsubusersquery > 0)
					{
						?>
							<div class="v2_club_listing">
								<ul class="djListings">
						<?php
					while($fetcsubuserquery = @mysql_fetch_array($getsubusersquery))
					{
					$mysql_query = @mysql_query("SELECT * FROM `clubs` WHERE club_name = '".$fetcsubuserquery['username']."' ");
					$fetcharray = @mysql_fetch_array($mysql_query);
					?>
					<li>
					<span class="subuserinfo">
					<?php 
					if($fetcsubuserquery['user_thumb'] != '')
					{ 

					?>
					<a href='music_request.php?host_id=<?php echo $fetcharray['id'];?>'><img src='<?php echo $fetcsubuserquery['user_thumb']; ?>' width='100' height='100' /></a>
					<?php
					}
					else
					{ 
						echo "<img src='images/man4.jpg'  alt='' width='100' height='100' /> "; 
					} 
					?>
					</span>
					<div class="subusercam">
					<p>
					<a href='music_request.php?host_id=<?php echo $fetcharray['id'];?>'><?php echo $profilename."-".$fetcsubuserquery['username']; ?></a>
					</p>
					
					
					<br>
						
						
<?php
$pieces = explode(" ", $fetcsubuserquery['username']);
$Subusername_dash_separated = implode("-", $pieces);
$Subusername_dash_separated =clean($Subusername_dash_separated);

$mobile = detect_mobile();
if($mobile === true) { 
?>
<p>
			<a class="button" name="submit"  onclick="goto1('https://192.163.248.47:1935/live/<?php echo $Subusername_dash_separated; ?>/playlist.m3u8')">Live Streaming

					<?php //if($fetcharray['is_launch']=='1'){?>
					<?php if(detect_stream($fetcsubuserquery['username'])===true){ ?>
					<span class="stats_icon" >
					<img src="images/online_u.png?t=<?= time() ?>" alt="Online" title="Online" />
					</span>
					
					<?php } else{ ?>
					
					<span class="stats_icon">
					<img src="images/offline_u.png?t=<?= time() ?>" alt="Offline" title="Offline"/>
					</span>
					
					<?php } ?>
			</a>
 
</p>
<? } else { ?>

			<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $fetcsubuserquery['username']; ?>&host_id=<?php echo $userID; ?>')">Live Streaming
					<?php //if($fetcharray['is_launch']=='1'){?>
					<?php if(detect_stream($fetcsubuserquery['username'])===true){ ?>
					<span class="stats_icon" >
					<img src="images/online_u.png?t=<?= time() ?>" alt="Online" title="Online" />
					</span>
					
					<?php } else{ ?>
					
					<span class="stats_icon">
					<img src="images/offline_u.png?t=<?= time() ?>" alt="Offline" title="Offline"/>
					</span>
					
					<?php } ?>                      	
			
			</a>

<?php } ?>						
						
					</div>
					<?php if($fetcsubuserquery['profile_link'] != '')
					{
					?>
					<div class="visitmypage">
					<span>Visit my Page: </span> <a href="<?php echo $fetcsubuserquery['profile_link']; ?>"><?php  echo $fetcsubuserquery['profilename']; ?></a>
					</div>
					<?php   }   ?>
					</li>
					<?php 
					}
					}
					else
					{
					//echo "<li></li>";
						?>
						</ul>
					</div>
						<?php
					}
					?>
					</div><!-- END pcoming clubs -->

			<?php 
			$date = date('Y-m-d');
			$get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND host_id = '".$userID."' ORDER BY date ASC");
			$count_events = mysql_num_rows($get_latest_events);
			if($count_events > 0)
			{
				
			 ?>	
		 	
			<div class="dj_right djevents">
			<div class=" ">
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
					<h1 class="h1">See all list of <a href="<?php echo $linkEvents; ?>">Upcoming Events</a></h1>
					<div class="event_list_container">
						<div class="NewBand"> 
								<?php 
									$date = date('Y-m-d');
									$get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND host_id = '".$userID."' ORDER BY date ASC LIMIT 0,5");
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
								<?php 	} // END COUNT CONDITION 	
									else
									{
										echo "<div class='NoRecordsFound' id='NoRecordsFound'>No events Yet!</div>";
									}
								?>
									</div> <!-- END NEW BAND -->
								</div>

				</div>
				</div>
				<div class="seprators"></div>
		<?php	} //END MAIN EVENTS COUNT CONDITION ?>


					
					<?php 
					$getBookingTypes = mysql_query("SELECT * FROM `bookingstype` WHERE `host_id` = '$userID' ");
					if(mysql_num_rows($getBookingTypes) > 0)
					{
					?>
					<script type="text/javascript">
						$(document).ready(function(){
							 $('.bookingsTypeSlider').bxSlider({
								mode: 'horizontal', //mode: 'fade',            
								speed: 500,
								auto: false,
								slideWidth: 250, 
								slideMargin: 10,
								minSlides: 3,
								infiniteLoop: true,
								autoStart: false,
								hideControlOnEnd: true,
								useCSS: false,
								// position: 1,
							});

						});
					</script>
					<style type="text/css">
						.bookingsType .bookTick
						{
							height: auto !important;
						
						}
						.bookingsType .Listings ul li
						{
							margin: 10px;
						}
					</style>

					<div class="bookingsType">
			  			<h1>Bookings Type</h1>
						<div class="Listings <?php if(mysql_num_rows($getBookingTypes) > 3){ echo 'photo_dj_slider photo_slider';}?>">
							<ul <?php if(mysql_num_rows($getBookingTypes) > 3){ echo " class='bookingsTypeSlider'";} ?>>
							<?php 
							while($rs = mysql_fetch_assoc($getBookingTypes))
							{
							?>
								<li>
									<div class="innerItem">
										<div class="thumbTick"> 
											<a rel="group" href="<?php $SiteURL;?>bookingsTypeDetails.php?typeID=<?php echo $rs['id'];?>&host_id=<?php echo $userID;?>"> 
												<img alt="" src="<?php echo $SiteURL.$rs['image_type_thumb'];?>"> 
											</a>
										</div>
										<div class="titleTick"><?php echo $rs['name'];?></div>
										<div> 
											<?php 
												if(isset($_GET['host_id']) && $_GET['host_id'] != $_SESSION['user_id'])
												{
											?>		<a class="bookTick" href="<?php echo $SiteURL;?>bookme.php?host_id=<?php echo $userID;?>&typeID=<?php echo $rs['id'];?>" > Book </a> 
											<?php 	}
												else
												{
											?>		<a class="bookTick" href="<?php echo $SiteURL;?>bookingsTypeDetails.php?typeID=<?php echo $rs['id']."&host_id=".$rs['host_id'];?>" > Book </a> 
											<?php 	}	?>
										</div>
									</div>
								</li>
						<?php 	}	?>
							</ul>
						</div>
					</div>
					 <div class="seprators"></div>
			<?php 		}	?>
			<div class="clear"></div>
			<div class="dj_left">
			<?php 
				$specailsQuery = mysql_query("SELECT * FROM `host_ad` WHERE host_id = '$userID'  ORDER BY `id` DESC LIMIT 1 ");
				$specailsFetch= mysql_fetch_array($specailsQuery);
				$specailsImage = $specailsFetch['ad_image'];
				$countSpecial = mysql_num_rows($specailsQuery);
				if($countSpecial > 0)
				{
			?>
				<div class="special_dj">
					<h1>Specials</h1>
					<div class="thumb_profile">
						<?php 
							if($specailsFetch['ad_type'] == 'image')
							{
						?>

								<li>
									<a href="<?php echo $specailsImage;  ?>" <?php echo 'rel="group" class="fancybox" '; ?> >
										<img src="<?php echo $specailsFetch['ad_thumb'] ;?>"    alt="" />
									</a>
								</li>
						<?php 	}
							elseif($specailsFetch['ad_type'] == 'video')
							{
						?>
								<a onmouseover="jwplayer('add<?php echo $specailsFetch["id"];?>').play();" onmouseout="jwplayer('add<?php echo $specailsFetch["id"];?>').pause();" id="ve_<?php echo $specailsFetch["id"];?>" href="#dialogx<?php echo $specailsFetch["id"];?>" name="modal">
								</a>

								<div id="add<?php echo $specailsFetch["id"];?>"></div>
								<script type="text/javascript">
								jwplayer("add<?php echo $specailsFetch["id"];?>").setup({
								file: "upload/hostads/<?php echo $specailsFetch["ad_video"];?>",
								height : 100 ,
								width: 100
								});
								</script>
						<?php 	}	?>
					</div>
					<?php 
					if($specailsFetch['adv_link'] != "")
					{
					?>
								<h5><a href="<?php echo $specailsFetch['adv_link'];?>"><?php echo $specailsFetch['adv_link'];?></a></h5>
			<?php 		} 	?>
				</div><!-- END special_dj -->
		<?php 		}	?>

		<?php 
			$date = date("Y-m-d");
			$couponQuery = mysql_query("SELECT * FROM `host_coupon` WHERE host_id = '$userID' AND `expiry_date` > '$date' ORDER BY `id` DESC");
			$countCoupon = mysql_num_rows($couponQuery);
			if($countCoupon > 0)
			{
		?>

				<div class="hotpass_dj">
					<h1>Passes</h1>
					<div class="thumb_profile photo_slider">
						<?php 

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
							<?php
						}

							
							echo "<ul class='photoslider2' >";
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
										if(isset($_GET['host_id']) && $_SESSION['user_type'] == 'user')
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
														<a href="<?php echo $imgsrc ?>" rel="group" class="fancybox"><img src="<?php echo $thumb ;?>" alt="" /></a>
														<span class="redeemedpass">REDEEMED</span><div class="clear"></div><div class="clear"></div><h5><?php echo $rowCoupon['coupon_name'];?></h5>
													</li>
								<?php               }
												else
												{ 
									?>
													<li>
														<a href="<?php echo $imgsrc ?>" rel="group" class="fancybox"><img src="<?php echo $thumb ;?>" alt="" /></a>
														<span class="downloadedpass">DOWNLOADED</span><div class="clear"></div><h5><?php echo $rowCoupon['coupon_name'];?></h5>
													</li>                                                               
								<?php               }
											}
											else
											{
								?>
												<li>
													<a href="<?php echo $imgsrc ?>" rel="group" class="fancybox"><img src="<?php echo $thumb ;?>" alt="" /></a>
													<span class="passdownload" onclick="download_host_pas('<?php echo $hostID; ?>', '<?php echo $_SESSION['user_id']; ?>', '<?php echo $rowCoupon['id']; ?>');">DOWNLOAD PASS</span><div class="clear"></div><h5><?php echo $rowCoupon['coupon_name'];?></h5>
												</li>                                                                               
								<?php 
											}
										}
										else
										{
											?>
																		<li>
												<a href="<?php echo $imgsrc ?>" rel="group" class="fancybox"><img  src="<?php echo $thumb ;?>" alt="" /></a><div class="clear"></div><h5><?php echo $rowCoupon['coupon_name'];?></h5>
																			</li>
											<?php
										}
			//}
									}
								}
							echo "</ul>";
						?>
					</div>
				</div> <!--  END hotpass_dj-->
	<?php 		}	?>
			</div>
	<?php 
		if($countSpecial == 0 && $countCoupon == 0 )
		{

		}
		else
		{
			echo '<div class="seprators"></div>';
		}

			$photo_sql = "select * from `uploaded` where `user_id` = '".$userID."' and user_type='club' order by rand()  ";
					$photo_Array = mysql_query($photo_sql);  
					$countPhotos = mysql_num_rows($photo_Array);
					if($countPhotos > 0)
					{
				?>
						
						<div class="photo_dj ">
							<h1>Photos</h1>
							<div class="photo_dj_slider photo_slider">
								<ul class="photoslider1">
									<?php
										while($photo_row = mysql_fetch_array($photo_Array))
										{ 
									?>
											<li>
												<a href="<?php echo $photo_row['img_name']; ?>" rel="group" class="fancybox"><img src="<?php echo $photo_row['thumbnail']; ?>" /></a>										
												<h5><?php echo $photo_row['image_title']; ?></h5>
											</li>
									<?php
										}
									?>
								</ul>
							</div>
						</div>
						<div class="seprators"></div>
			<?php       }       ?>


					<?php 
						$video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' and user_type='club'  order by rand()";
						$video_Array = mysql_query($video_sql);
					  
						if(mysql_num_rows($video_Array)>0) 
						{
							?>
	  
							<div class="photo_dj video_dj_bg">
								<h1 class="video_dj_title">Videos</h1>
								<div class="photo_dj_slider photo_slider">
									<ul class="videoslider1">
									<?php
										while($video_row = mysql_fetch_array($video_Array))
										{
										?>
								
											<li id="jw_<?php echo $video_row['video_id'];?>" <?php  /*if (strpos($video_row["video_nm"],'vimeo.com') === false) { ?> onmouseover="myFunction('a<?php echo $video_row['video_id'];?>');" onmouseout="myStopFunction('a<?php echo $video_row['video_id'];?>');" <?php }*/ ?>>
												<?php  if (strpos($video_row["video_nm"],'vimeo.com') === false) { ?>
												<a  class=""  id="ve_<?php echo $video_row["video_id"];?>" href="#dialogx<?php echo $video_row["video_id"];?>" name="modal"></a>
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
													$url = str_replace('../', '', $video_row['video_nm']);
													$urlnew = explode('/',$url);
													$videoID = end($urlnew);
											?>		<iframe src="https://player.vimeo.com/video/<?php echo $videoID;?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
											<?php
												}
											?>
													<h5><?php echo $video_row["video_title"];?></h5>
											</li>
								<?      }   ?>
									</ul>
								</div>
							</div>
							 <div class="seprators"></div>
				<?php       }   ?>
<script type="text/javascript">
	$('.videoslider1 li').each(function(){
		var i = $(this).attr('id');
		i = i.split('_');
		var id = i[1];


		// $(this).hover(
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
					$myquery = @mysql_query("SELECT * FROM music where host_id = '$userID' AND tonightlist = '1' ORDER BY trackname ASC");
					$myquery2 = @mysql_query("SELECT * FROM dj_video where host_id = '$userID' AND tonightlist = '1' ORDER BY trackname ASC");
					$i=1;
					if(mysql_num_rows($myquery) > 0 || mysql_num_rows($myquery2) > 0 ) 
					{	
				?>
<div class="seprators"></div>
				<div class="video tonighListing">
					<h2>Tonight Music List</h2>
					<?
						

						if(!isset($_GET['host_id']))
						{

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
									if(mysql_num_rows($myquery)>0) 
									{
										while($res = mysql_fetch_array($myquery))
										{
											$a = $res['id'];
						?>   

											<tr>
												<td>
													<audio style="display:none;" controls id="player<?php echo $a ;?>">
													<source src="<?php echo $res['musicpath'];?>" type="audio/mpeg">
													<source src="<?php echo $res['musicpath'];?>" type="audio/ogg">
													<embed height="50" width="100" src="<?php echo $res['musicpath'];?>"></embed>
													</audio>
													<a href='javascript:play1();' id="<?php echo $a;?>" class="test audio mynewclass_play_<?php echo $a; ?>"><img height="30px" src="images/new_portal/play.png"></a>
													<a href='javascript:pause();' style="display: none;" class='pause mynewclass_pause_<?php echo $a; ?>' id="<?php echo $a;?>"><img height="30px" src="images/new_portal/pause.png"></a>
												</td>
												<td><?php echo $res['trackname']; ?>&nbsp;</td>
												<td><?php echo $res['artist']; ?>&nbsp;</td>
												<td><?php echo $res['label']; ?>&nbsp; </td>
												<td> <?php echo $res['genre']; ?>&nbsp; </td>
												<td> <?php
													if(!empty($res['releasedate']))
													{
														$date =  $res['releasedate'];
														$sort = strtotime($date);
														echo date('M d, Y',$sort);
													}
													
													?>&nbsp;
												</td>
												<td>  <?php echo "$".$res['price']; ?>&nbsp;</td>
											</tr>           
						<?              }
									}
									if(mysql_num_rows($myquery2)>0) 
									{
										while($res = mysql_fetch_array($myquery2))
										{
						?>   

											<tr>
												<td>
													<a onClick="javascript:void window.open('play_video_clip.php?clip_id=<?php echo $res['id']; ?>','','width=500,height=500,resizable=true,left=0,top=0');return false;"><img src="images/new_portal/play.png" height="25px" width="25px;"></a>
												</td>
												<td><?php echo $res['trackname']; ?></td>
												<td><?php echo $res['artist']; ?></td>
												<td><?php echo $res['label']; ?> </td>
												<td> <?php echo $res['genre']; ?> </td>
												<td> <?php  $date =  $res['releasedate'];
													$sort = strtotime($date);
													if($res['releasedate'] != ""){ echo date('M d, Y',$sort); }             
													?>
												</td>
												<td>  <?php echo "$".$res['price']; ?></td>
											</tr>           
								<?              }
									}
								?>  
								</table> 
							</div>
				<?php       	}
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
												<a href='javascript:play1();' id="<?php echo $a;?>" class="test audio"><img src="images/new_portal/play.png"  /></a>
												<a href='javascript:pause();' class='pause' id="<?php echo $a;?>"><img src="images/new_portal/pause.png"  /></a>
											</td>
											<td><?php echo $res['trackname']; ?></td>
											<td><?php echo $res['artist']; ?></td>
											<td><?php echo $res['label']; ?> </td>
											<td><?php echo $res['genre']; ?> </td>
											<td><?php 
												if(!empty($res['releasedate']))
													{
														$date =  $res['releasedate'];
														$sort = strtotime($date);
														echo date('M d, Y',$sort);
													}        
												?>
											</td>
											<td> 
												<input type="hidden" name="product_id" value="<?php echo $res['id'];?>">
												<input type="hidden" name="price_cart" value="<?php echo $res['price'];?>"> 
												<input type="hidden" name="host_id" value="<?php echo $_GET['host_id'];?>"> 
												<input type="hidden" name="product_type" value="0"> 
												<input type="hidden" name="music_type" value="music"> 
												<input type="hidden" name="product_qty" value="1"> 
												<?  $data_upgrade_needed=chk_upgrade_needed_shopping($data_upgrade['plantype'],"18",$_GET['host_id']);
												if(!$data_upgrade_needed && $_SESSION['user_type'] == "user"){?>
												<input type='submit' class="button" value="<?php echo "$".$res['price']; ?>" />
												<?}else{?>
												<!--<input type='button' onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')" class="button" value="<?php echo "$".$res['price']; ?>" />-->
												<?php echo "$".$res['price']; ?>
												<? } ?>
											</td>
										</tr>
									</form>
						<? 
									$a++;
								}
								while($res = mysql_fetch_array($myquery2))
								{
						?>  
									<form method="POST" action="cart.php">
										<tr>
											<td>
												<a onClick="javascript:void window.open('play_video_clip.php?clip_id=<?php echo $res['id']; ?>','','width=500,height=500,resizable=true,left=0,top=0');return false;"><img src="images/new_portal/play.png" height="25px" width="25px;"></a>
											</td>
											<td><?php echo $res['trackname']; ?></td>
											<td><?php echo $res['artist']; ?></td>
											<td><?php echo $res['label']; ?> </td>
											<td> <?php echo $res['genre']; ?> </td>
											<td> <?php  $date =  $res['releasedate'];
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
												<?  $data_upgrade_needed=chk_upgrade_needed_shopping($data_upgrade['plantype'],"18",$_GET['host_id']);
												if(!$data_upgrade_needed && $_SESSION['user_type'] == "user"){?>
												<input type='submit' class="button" value="<?php echo "$".$res['price']; ?>" />
												<?}else{?>
												<!--<input type='button' onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')" class="button" value="<?php echo "$".$res['price']; ?>" />-->
												<?php echo "$".$res['price']; ?>
												<? } ?>
											</td>
										</tr>
									</form>           
							<?      }   ?>
								</table>
							</div>
				<?php       	}   ?>
				</div>
		<?php 			}	?>
					</div>
				</div>
			</div>
<!--			<div class="equalizer"></div>-->
		</article>
	</div>
	<div class="clear"></div>
</div>
<?php
	if($_SESSION['user_type'] == "club")
	{
?>
		<div class="upload_banner_bg"><a href="host-background.php"><img height="25px" width="30px" src="images/camera3.png" alt="" title="Change Background"></a></div>
<?php 	} ?>

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

</script>
<style type="text/css">
.lv_brdcast {
	float: left;
	margin-bottom: 20px;
	width: 100%;
}

.inner_lv_brdcast {
	float: left;
	width: 100%;
}
/* CHAT CSS*/

.refresh {
	border: 1px solid #acd6fe;
	border-left: 4px solid #acd6fe;
	color: green;
	font-family: tahoma;
	font-size: 12px;
	height: 225px;
	overflow-y:auto;
	overflow-x:auto;
	/*width: 365px;*/
	padding:10px;/*background-color:#FFFFFF;*/
}

.grpone {
  float: left;
  padding: 10px;
  width: 100% !important;
  background: #fff;
  box-sizing: border-box;
}
.ulist {
  -moz-border-bottom-colors: none !important;
  -moz-border-left-colors: none !important;
  -moz-border-right-colors: none !important;
  -moz-border-top-colors: none !important;
  background: #fff none repeat scroll 0 0;
  border-color: -moz-use-text-color -moz-use-text-color #ccc !important;
  border-image: none !important;
  border-style: none none solid !important;
  border-width: 0 0 1px !important;
  box-sizing: border-box;
  color: green;
  float: left;
  font-family: tahoma;
  font-size: 12px;
  height: 225px;
  overflow: auto;
  padding: 10px;
  width: 100% !important;
}
.ulist > div {
  float: left;
  width: 100%;
  border-top: 0 !important;
}
.ulist p {
  border-top: 0px solid #333 !important;
}
#post_button, .onlineUsers {
	border: 1px solid #308ce4;
	background-color:#308ce4;
	width: 100px;
	color:#FFFFFF;
	font-weight: bold;
	margin-top: 0px !important;
	margin-bottom: 5px !important;
	padding:5px;
	cursor:pointer;
	border-radius:4px;
}
#textb {
	border: 1px solid #ccc;
	/*width: 283px;*/
	margin:0px 0 10px;
	width: 100%;
	box-sizing:border-box;
	-webkit-box-sizing:border-box;
	border-radius:6px;
	-webkit-border-radius:6px;
	height:35px;
	width:100% !important;
	box-shadow: 0 0 4px #ccc inset;
}
#texta {
	border: 1px solid #000 !important;
	margin-bottom: 10px;
	padding:7px 5px;
}


#sc p span{
 width:100%;
 float:left;
 color:#505050;	
}
.fl {
	float:left
}
#sc{border:0px !important; border-top:1px solid #ccc !important;padding: 2px !important}  
#sc p { padding: 5px;}
#sc p:hover {background:#f2f2f2; }
#sc p:hover .deleteMessage {display:block; }
#smilies {
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	-webkit-box-shadow: #666 0px 2px 3px;
	-moz-box-shadow: #666 0px 2px 3px;
	box-shadow: #666 0px 2px 3px;
	background: #A0CFFB;
	background: -webkit-gradient(linear, 0 0, 0 bottom, from(#A0CFFB), to(#dfeffe));
	background: -webkit-linear-gradient(#A0CFFB, #dfeffe);
	background: -moz-linear-gradient(#A0CFFB, #dfeffe);
	background: -ms-linear-gradient(#A0CFFB, #dfeffe);
	background: -o-linear-gradient(#A0CFFB, #dfeffe);
	background: linear-gradient(#A0CFFB, #dfeffe);
	-pie-background: linear-gradient(#A0CFFB, #dfeffe);
}
.ulist > p {
	float: left;
	width: 100%;
}
.joinbutton {
	float: left;
	margin: 5% 0;
	width: 100%;
}
.groupchatname {
	float: left;
	margin: 10px 0;
	width: 100%;
}
.grp_ceond {
  background: #ccc none repeat scroll 0 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  float: right;
/*  max-height: 360px;*/
  overflow: hidden;
  padding: 10px;
  /*width: 32% !important;*/
}
.boject_container {width:66%; float:left; margin-right:2%;}
.main_home p {
	color: #000 !important;
}
.channel_bg {
	background: rgba(0, 0, 0, 0) url("../../images/channel-bg.jpg") no-repeat scroll left top / 100% auto;
	float: left;
	width: 100%;
}
.channer_container {
	margin: 20px auto !important;
	max-width: 1080px;
	width: 100%;
}
.channel_inner {
	box-shadow: 0 0 1px rgba(255, 255, 255, 0.3) inset;
	background: rgba(0, 0, 0, 0.3);
	margin-bottom: 30px;
	padding: 10px 10px 20px;
	width:100%;
	float:left;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
}
.webcame_live {
	padding: 10px;
}
object, embed {
 
  max-width: 100%;
}
#sc {
  width: 100%;
  float: l;
  box-sizing: border-box;
  border: 0px !important;
}
#sc p span {font-weight:bold;}
.divider {width:100%; height:1px; background:#e7e7e7; float:left; margin:5px 0;}
.closepop {float:right; margin:10px 0;}

.ulist .groupchatname {
  padding-bottom: 10px;
  border-bottom: 1px solid #000;
  color: #000;
}
.main_home {
  margin: 0 auto !important;
  max-width: 1080px;
  width: 100%;
}
#chatMembers p span img {vertical-align:middle; margin-right:10px;}
#chatMembers p a {color:#000;}



.groupchatname > span#totalViewers 
{
	float: right;
}

.deleteMessage {
	display: none;
	float: right !important;
	width: 20px !important;
	cursor: pointer;
}

.videoslider1 iframe {
	float: left;
	height: 254px;
	max-height: 100%; 
	width: 100%;
}

</style>

<?php include('Footer.php');?>
