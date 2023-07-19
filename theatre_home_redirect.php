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

.noEvents
{
	border-bottom: none;
	text-align: center;
	padding: 20px;
	font-size: 20px;
}

</style>

<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   include('host_left_panel.php');?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
					
			<div class="theater_listing_box">
				<div class="event_icon_theater"> 
					<img src="images/event_comedy_icon.png" align=""> 
				</div>
				<div class="events_listing_comedy eventTheater">
				<?php 
					if(isset($hostID))
					{
						$linkEvents = "listevent.php?host_id=".$hostID;
					}
					else
					{
						$linkEvents = "listevent.php";
					}
				?>
 
					<h1 class="h1">See all list of <a href="<?php echo $linkEvents; ?>">Upcoming Events</a></h1>
					<?php 
						$date = date('Y-m-d');
						$get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND host_id = '".$userID."' ORDER BY date ASC LIMIT 0,5");
						$count_events = mysql_num_rows($get_latest_events);
						if($count_events > 0)
						{
							
						 ?>	

			<div class="event_list_container">
									<div class="NewBand"> 
								<?php 
									$date = date('Y-m-d');
									$get_latest_events = @mysql_query("SELECT * FROM events WHERE date(`date`) >= '$date' AND host_id = '".$userID."' ORDER BY date ASC ");
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

												if($count_ticket_check == "1" || $countPaidpasses > 0)
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
<div class="seprators"></div>
			<div class="special_listing_theater">
				<div class="special_comedy">
			 			<h1 class="h1"> 
			 				<img align="" src="images/special_icon_theater.png"> Specials
			 			</h1>
			 		<?php 
						$specailsQuery = mysql_query("SELECT * FROM `host_ad` WHERE host_id = '$userID'  ORDER BY `id` DESC LIMIT 1 ");
						$specailsFetch= mysql_fetch_array($specailsQuery);
						$specailsImage = $specailsFetch['ad_image'];
						$countSpecial = mysql_num_rows($specailsQuery);

					?>
						<div class="phot_theater_slider">
							<?php 
								if($countSpecial > 0)
								{
									//echo "<ul>";
									if($specailsFetch['ad_type'] == 'image')
									{
							?>

										<!--<li> -->
											<a href="<?php echo $specailsImage;  ?>" <?php echo 'rel="group" class="fancybox"'; ?> >
												<img src="<?php echo $specailsFetch['ad_thumb'] ;?>"    alt="" />
											</a>
										<!-- </li> -->
							<?php 		}
									elseif($specailsFetch['ad_type'] == 'video')
									{
							?>
										<a  id="ve_<?php echo $specailsFetch["id"];?>" href="#dialogx<?php echo $specailsFetch["id"];?>" name="modal">
										</a>

										<div id="add<?php echo $specailsFetch["id"];?>"></div>
										<script type="text/javascript">
											jwplayer("add<?php echo $specailsFetch["id"];?>").setup({
												file: "upload/hostads/<?php echo $specailsFetch["ad_video"];?>",
												height : 100 ,
												width: 100
											});
										</script>
							<?php
									}
									//echo "</ul>";
								}
								else
								{
									echo '<img src="images/availableSoon.png" align="">';
								}
							?>
						</div>
						<?php 
								if($specailsFetch['adv_link'] != "")
								{
						?>
									<h5>
										<a target="blank" href="<?php echo $specailsFetch['adv_link'];?>">
											<?php echo $specailsFetch['adv_link'];?>
										</a>
									</h5>
						<?php 		} 	?>

					</div>
					<div class="pass_theater">
						<h1 class="h1">
							<img align="" src="images/pass_icon_theater.png">Passes
						</h1>
						<div class="pass_theater_slider photo_slider">
					<?php 

						if(isset($hostID))
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

							$date = date("Y-m-d");
							$couponQuery = mysql_query("SELECT * FROM `host_coupon` WHERE host_id = '$userID' AND `expiry_date` > '$date' ORDER BY `id` DESC");
							
							$countCoupon = mysql_num_rows($couponQuery);
							
							if($countCoupon > 0)
							{
								if($countCoupon == "1")
								{
									echo "<ul class='noSlider' >";
								}
								elseif ($countCoupon > 1)
								{
									echo "<ul class='photosliderpass' >";
								}
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
										if(isset($hostID) && isset($_SESSION['user_id']))
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
								<?php               		}
												else
												{ 
									?>
													<li>
														<a href="<?php echo $imgsrc ?>" rel="group" class="fancybox"><img src="<?php echo $thumb ;?>" alt="" /></a>
														<span class="downloadedpass">DOWNLOADED</span><div class="clear"></div><h5><?php echo $rowCoupon['coupon_name'];?></h5>
													</li>                                                               
								<?php               		}
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
							}
							else
							{
								echo "<ul>";
								echo '<li><img src="images/availableSoon.png" align=""></li>';
								echo "</ul>";
							}
							
						?>

						
						</div>
					</div>
				</div>
		<?php 
			$photo_sql = "select * from `uploaded` where `user_id` = '".$userID."' and user_type='club' order by rand()  ";
			$photo_Array = mysql_query($photo_sql);  
			$countPhotos = mysql_num_rows($photo_Array);
			if($countPhotos > 0)
			{
		?>
  <div class="seprators"></div>
				<!-- photo section comedy -->
				<div class="theater_listing_box">
					<div class="event_icon_theater"> 
						<img align="" src="images/photo_icon_theater.png">
					</div>
					<div class="events_listing_theater photo_com">
						<h1 class="h1">Photos</h1>
						<div class="photo_theater_slider photo_slider">
							<ul class="photoslider2">
								<?php
									while($photo_row = mysql_fetch_array($photo_Array))
									{ 
								?>
										<li>
											<a href="<?php echo $photo_row['img_name']; ?>" rel="group" class="fancybox">
												<img src="<?php echo $photo_row['thumbnail']; ?>" />
											</a>										
											<h5><?php echo $photo_row['image_title']; ?></h5>
										</li>
								<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
				<!-- video section comedy -->
		<?php 	}	?>
		<?php 
			$video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' and user_type='club'  order by rand()";
			$video_Array = mysql_query($video_sql);
		  
			if(mysql_num_rows($video_Array)>0) 
			{
		?>
  <div class="seprators"></div>
				<!-- video section comedy -->
				<div class="theater_listing_box">
					<div class="event_icon_theater"> 
						<img align="" src="images/video_icon_theater.png">
					</div>
					<div class="events_listing_theater video_com band_video">
						<h1 class="h1">Videos</h1>
						<div class="vid_theater_slider com_vid photo_slider">
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
										?>		<iframe src="<?php echo str_replace('../', '', $video_row['video_nm']);?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
										<?php
											}
										?>
											<h5><?php echo $video_row["video_title"];?></h5>
										</li>
								<?      	}   ?>
							</ul>
						</div>
					</div>
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
				</div>
	<?php      	}   	?>
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
					if(!isset($hostID))
					{
					?>
						<div class="tab_scroll">
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
						?>   
										<tr>
											<td>
												<audio style="display:none;" controls id="player<?php echo $a ;?>">
												<source src="<?php echo $res['musicpath'];?>" type="audio/mpeg">
												<source src="<?php echo $res['musicpath'];?>" type="audio/ogg">
												<embed height="50" width="100" src="<?php echo $res['musicpath'];?>"></embed>
												</audio>
												<a href='javascript:play1();' id="<?php echo $a;?>" class="test audio"><img height="30px" src="images/new_portal/play.png"></a>
												<a href='javascript:pause();' class='pause' id="<?php echo $a;?>"><img height="30px" src="images/new_portal/pause.png"></a>
											</td>
											<td><?php echo $res['trackname']; ?>&nbsp;</td>
											<td><?php echo $res['artist']; ?>&nbsp;</td>
											<td><?php echo $res['label']; ?>&nbsp; </td>
											<td> <?php echo $res['genre']; ?>&nbsp; </td>
											<td> <?php  $date =  $res['releasedate'];
												$sort = strtotime($date);
												echo date('M d, Y',$sort);              
												?>&nbsp;
											</td>
											<td>  <?php echo "$".$res['price']; ?>&nbsp;</td>
										</tr>           
						<?              		}
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
					<?       				}
								}	?>  
							</table> 
						</div>
				<?php       	}
						else
						{
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
												$date =  $res['releasedate'];
												$sort = strtotime($date);
												echo date('M d, Y',$sort);          
												?>
											</td>
											<td> 
												<input type="hidden" name="product_id" value="<?php echo $res['id'];?>">
												<input type="hidden" name="price_cart" value="<?php echo $res['price'];?>"> 
												<input type="hidden" name="host_id" value="<?php echo $hostID;?>"> 
												<input type="hidden" name="product_type" value="0"> 
												<input type="hidden" name="music_type" value="music"> 
												<input type="hidden" name="product_qty" value="1"> 
												<?  $data_upgrade_needed=chk_upgrade_needed_shopping($data_upgrade['plantype'],"18",$hostID);
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
												<input type="hidden" name="host_id" value="<?php echo $hostID;?>"> 
												<input type="hidden" name="product_type" value="0"> 
												<input type="hidden" name="music_type" value="video"> 
												<input type="hidden" name="product_qty" value="1"> 
												<?  $data_upgrade_needed=chk_upgrade_needed_shopping($data_upgrade['plantype'],"18",$hostID);
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
				</div><!-- END .video tonighListing-->
<?php 			}	?>
		</div>					
					
					</div>
				</div>
			</div>
		</article>
	</div>
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