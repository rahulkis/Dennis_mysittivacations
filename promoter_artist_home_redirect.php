<?php

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
.noEvents {
	border-bottom: none;
	text-align: center;
	padding: 20px;
	font-size: 20px;
}
</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 	include('host_left_panel.php');	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<div class="fight_listing_box">
				<div class="event_icon_fight"> <img src="images/event_icon_fight.png" align=""> </div>
				<div class="events_listing_fight">
					<div class="band_event_list new_band_event_list">
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
						<h1>See all list of <a href="<?php echo $linkEvents; ?>">Upcoming Events</a></h1>
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
												if( ($count_ticket_check == "1" || $countPaidpasses > 0))
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
				 					</div> 
					<!-- END EVENT CONTAINER --> 
					</div>
				</div>
			</div><!-- END fight_listing_box -->
<div class="seprators"></div>

			<!-- speacial_comedy -->
			<div class="speacial_fight_box">         
				<div class="pass_fight">
					<h1 class="h1">
						<img src="images/hotpass_icon_fight.png" align="">Passes
					</h1>
					<?php 
						$date = date("Y-m-d");
						$couponQuery = mysql_query("SELECT * FROM `host_coupon` WHERE host_id = '$userID' AND `expiry_date` > '$date' ORDER BY `id` DESC");
						$countCoupon = mysql_num_rows($couponQuery);
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
										if(isset($hostID))
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
						<img src="images/special_icon_fight.png" align="">Specials
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
				  					<a  id="ve_<?php echo $specailsFetch["id"];?>" href="#dialogx<?php echo $specailsFetch["id"];?>" name="modal"> </a>
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
						<h5><a target="blank" href="<?php echo $specailsFetch['adv_link'];?>"><?php echo $specailsFetch['adv_link'];?></a></h5>
	<?php 				} 	?>
				</div>
			</div><!-- END speacial_fight_box -->

			<!-- ARTIST LISTING SLIDER -->
			
			<?php	
			$sql4="SELECT * FROM `artist_list` WHERE `host_id` = '$userID' ";
		 	$sql6 = mysql_query($sql4);
			$num = mysql_num_rows($sql6);
			if($num > 0)
			{	
		?>
  <div class="seprators"></div>
				<div class="speacial_fight_box artisrListbox">
					<h1 class="h1">Artists List</h1>
					<div class="comedy_slider_photo com_vid photo_slider">
						<ul class="videoslider1">
						<?php 
							while($row = mysql_fetch_assoc($sql6))
							{
								$getArtistINFO = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$row[user_id]' ");
								$fetchinstructors = mysql_fetch_assoc($getArtistINFO);
							//	if($fetchinstructors['type_of_club'] == '108')
								//{
								?>
								<li> 
									<a style="height:250px !important;" href="<?php echo $SiteURL.$fetchinstructors['club_name'];?>">
										<img src="<?php echo $fetchinstructors['image_nm'] ;?>" alt="" />
									</a>
								</li>
							<?php 
								//}
							}
						?>
					</div>
				</div>
			<?php 	}	?>


			
			<!-- ARTIST SLIDER END -->


			<!-- photo section comedy -->
   <div class="seprators"></div>
			<div class="comedy_listing_box">
	<?php 
				$photo_sql = "select * from `uploaded` where `user_id` = '".$userID."' and user_type='club' order by rand()  ";
				$photo_Array = mysql_query($photo_sql);  
				$countPhotos = mysql_num_rows($photo_Array);
				if($countPhotos > 0)
				{
			?>
					<div class="event_icon_fight"> 
						<img src="images/photo_icon_fight.png" align=""> 
					</div>
					<div class="events_listing_fight photo_fight">
						<h1 class="h1">Photos</h1>
<link rel="stylesheet" href="js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
<!-- <link rel="stylesheet" href="js/nivo-slider/demo/style.css" type="text/css" media="screen" /> -->
<style type="text/css">
#slider
{
	height: 350px !important;
	max-height: 350px !important;
}

#slider img {
	bottom: 0;
	left: 0;
	margin: auto !important;
	max-width: 100% !important;
	right: 0;
	top: 0;
	width: auto !important;
}

.nivo-box img
{
/*	bottom: 0;
	left: 0;
	margin: auto !important;
	max-width: 100% !important;
	right: 0;
	top: 0;
	width: auto !important;*/
	display: none !important; 
}

.box_skitter_large #slider .nivo-slice img
{
	display: none !important; 
}
.box_skitter_large #slider .nivo-slice
{
	display: none !important; 
}

</style> 

<script type="text/javascript" src="js/nivo-slider/jquery.nivo.slider.js"></script> 
<script type="text/javascript">
	$(window).load(function() {
		$('#slider').nivoSlider({
    effect: 'fade',                 // Specify sets like: 'fold,fade,sliceDown'
    slices: 15,// For slice animations
    boxCols: 8,                     // For box animations
    boxRows: 4,                     // For box animations
    animSpeed: 500,                 // Slide transition speed
    pauseTime: 3000,                 // How long each slide will show
    startSlide: 0,                     // Set starting Slide (0 index)
    directionNav: true,             // Next & Prev navigation
    controlNav: false,                 // 1,2,3... navigation
    controlNavThumbs: false,         // Use thumbnails for Control Nav
    pauseOnHover: true,             // Stop animation while hovering
    manualAdvance: true,             // Force manual transitions
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


	<?php 

		$video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' and user_type='club'  order by rand()";
		$video_Array = mysql_query($video_sql);
	  
		if(mysql_num_rows($video_Array)>0) 
		{
	?><div class="seprators"></div>
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
<?php 		}		
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
				?><div class="seprators"></div>
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
