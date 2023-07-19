<?php

include("Query.Inc.php");

$Obj = new Query($DBName);


$titleofpage="Contest Details";

$who_like_id=$_SESSION['user_id'];

$hostID=$_GET['hostID'];

$contest_id=$_GET['cont_id'];

$userType= $_SESSION['user_type'];

if(!isset($_SESSION['user_id'])){

	//$Obj->Redirect("index.php");
	include('NewHeadeHost.php');

}
else
{
	include('NewHeadeHost.php');
}








if($_GET['cont_id'])

{	

	$sql="SELECT * FROM `contest` where `status`='1' and contest_id='".$_GET['cont_id']."' AND host_id = '$hostID' ORDER BY `contest_id` ASC limit 1";

}



$contest_list = $Obj->select($sql) ;

if(!empty($contest_list)){ $result_found =  'yes';}else{ $result_found =  'no';}

$contest_img=$contest_list[0]['contest_img'];

$contest_desc=$contest_list[0]['contest_desc'];

 $contest_id=$contest_list[0]['contest_id']; 

$contest_rule=$contest_list[0]['contest_rule'];

$contest_end=$contest_list[0]['contest_end'];

$contestEndtime = $contest_list[0]['contest_end']." ".$contest_list[0]['end_time'];
$newcontestEndTime = date('Y/m/d H:i:s',strtotime($contestEndtime));

$currentdate = date('Y-m-d');

$condition2 = " LIMIT 0,1000 ";
$condition = " LIMIT 0,1000 ";



if(isset($_REQUEST['c_video_id']))

{

	if(!isset($_SESSION['user_id']))

	{

		$Obj->Redirect("login.php");

		die();	

	}

	$c_video_id = $_REQUEST['c_video_id'];

	$action=$_REQUEST['action'];

	$video_user_id=$_REQUEST['video_user_id'];		

	$who_like_id=$_SESSION['user_id'];

	if($action=="like")

	{

	if($who_like_id!='')

	{

	$ThisPageTable='contest_video_like';

	$ValueArray = array($who_like_id,$video_user_id,$contest_id,$c_video_id);

	$FieldArray = array('c_like_user_id','c_video_user_id','constest_id','c_video_id');

	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);

	}

	else

	{

	$Obj->Redirect("login.php");

	}

	}

	else

	{

	$c_video_id = $_REQUEST['c_video_id'];

	$delete = "delete from contest_video_like where c_video_id ='".$c_video_id."' && c_like_user_id='".$who_like_id."'";

	mysql_query($delete);			

	}

	$Obj->Redirect("current_contests.php");

	$count_like_qry= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$c_video_id."'");

	$count_like=@mysql_num_rows($count_like_qry);

}

	 ?>
<style type="text/css">
.home_content_top:before,
.home_content_top:after {
 background: none;
}
.contestinfocontainer {
 float: left;
 margin-bottom: 15px;
 width: 100%;
}
.content1:before {
 background: none;
}
.entercontestbutton_new .button:hover {
 background:#FECD07;
 color:#000;
}
<style type="text/css">
.main-example {
	margin: 0 auto;
	/*width: 355px;*/
}
.main-example .countdown-container {
	float: left;
	height: 100%;
	margin: 5px 10px 0;
}
.main-example .time {
	border-radius: 5px;
	box-shadow: 0 0 10px 0 rgba(0,0,0,0.5);
	display: inline-block;
	text-align: center;
	position: relative;
	height: 30px;
	width: 40px;

	-webkit-perspective: 500px;
	-moz-perspective: 500px;
	-ms-perspective: 500px;
	-o-perspective: 500px;
	perspective: 500px;

	-webkit-backface-visibility: hidden;
	-moz-backface-visibility: hidden;
	-ms-backface-visibility: hidden;
	-o-backface-visibility: hidden;
	backface-visibility: hidden;

	-webkit-transform: translateZ(0);
	-moz-transform: translateZ(0);
	-ms-transform: translateZ(0);
	-o-transform: translateZ(0);
	transform: translateZ(0);

	-webkit-transform: translate3d(0,0,0);
	-moz-transform: translate3d(0,0,0);
	-ms-transform: translate3d(0,0,0);
	-o-transform: translate3d(0,0,0);
	transform: translate3d(0,0,0);
}
.main-example .count {
	background: #202020;
	color: #f8f8f8;
	display: block;
	font-family: 'Oswald', sans-serif;
	font-size: 20px;
	line-height: 25px;
	overflow: hidden;
	position: absolute;
	text-align: center;
	text-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
	top: 0;
	width: 100%;

	-webkit-transform: translateZ(0);
	-moz-transform: translateZ(0);
	-ms-transform: translateZ(0);
	-o-transform: translateZ(0);
	transform: translateZ(0);

	-webkit-transform-style: flat;
	-moz-transform-style: flat;
	-ms-transform-style: flat;
	-o-transform-style: flat;
	transform-style: flat;
}
.main-example .count.top {
	border-top: 1px solid rgba(255,255,255,0.2);
	border-bottom: 1px solid rgba(255,255,255,0.1);
	border-radius: 5px 5px;
	height: 99%;

/*  -webkit-transform-origin: 50% 100%;
	-moz-transform-origin: 50% 100%;
	-ms-transform-origin: 50% 100%;
	-o-transform-origin: 50% 100%;
	transform-origin: 50% 100%;*/
}
.main-example .count.bottom {
	background-image: linear-gradient(rgba(255,255,255,0.1), transparent);
	background-image: -webkit-linear-gradient(rgba(255,255,255,0.1), transparent);
	background-image: -moz-linear-gradient(rgba(255,255,255,0.1), transparent);
	background-image: -ms-linear-gradient(rgba(255,255,255,0.1), transparent);
	background-image: -o-linear-gradient(rgba(255,255,255,0.1), transparent);
	/*border-top: 1px solid #000;*/
	/*border-bottom: 1px solid #000;*/
	/*border-radius: 0 0 5px 5px;*/
	line-height: 0;
	height: 0;
	top: 50%;

	-webkit-transform-origin: 50% 0;
	-moz-transform-origin: 50% 0;
	-ms-transform-origin: 50% 0;
	-o-transform-origin: 50% 0;
	transform-origin: 50% 0;
}
.main-example .count.next {
}
.main-example .label {
	font-size: normal;
	margin-top: 5px;
	display: block;
	position: absolute;
	top: 35px;
	width: 100%;
}
/* Animation start */
.main-example .count.curr.top {
	-webkit-transform: rotateX(0deg);
	-moz-transform: rotateX(0deg);
	-ms-transform: rotateX(0deg);
	-o-transform: rotateX(0deg);
	transform: rotateX(0deg);
	z-index: 3;
}
.main-example .count.next.bottom {
	-webkit-transform: rotateX(90deg);
	-moz-transform: rotateX(90deg);
	-ms-transform: rotateX(90deg);
	-o-transform: rotateX(90deg);
	transform: rotateX(90deg);
	z-index: 2;
}
/* Animation end */
.main-example .flip .count.curr.top {
	-webkit-transition: all 250ms ease-in-out;
	-moz-transition: all 250ms ease-in-out;
	-ms-transition: all 250ms ease-in-out;
	-o-transition: all 250ms ease-in-out;
	transition: all 250ms ease-in-out;

	-webkit-transform: rotateX(-90deg);
	-moz-transform: rotateX(-90deg);
	-ms-transform: rotateX(-90deg);
	-o-transform: rotateX(-90deg);
	transform: rotateX(-90deg);
}
.main-example .flip .count.next.bottom {
	-webkit-transition: all 250ms ease-in-out 250ms;
	-moz-transition: all 250ms ease-in-out 250ms;
	-ms-transition: all 250ms ease-in-out 250ms;
	-o-transition: all 250ms ease-in-out 250ms;
	transition: all 250ms ease-in-out 250ms;

	-webkit-transform: rotateX(0deg);
	-moz-transform: rotateX(0deg);
	-ms-transform: rotateX(0deg);
	-o-transform: rotateX(0deg);
	transform: rotateX(0deg);
}
@media screen and (max-width: 48em) {
	.main-example {
		width: 100%;
	}
	.main-example .countdown-container {
		height: 100px;
	}
	.main-example .time {
			height: 70px;
			width: 48px;
	}
	.main-example .count {
		font-size: 14px;
		line-height: 70px;
	}
	.main-example .label {
		font-size: 0.8em;
		top: 25px;
	}
}	


.v2_post_left_contest l {
	float: right;
}
@media screen and (max-width: 640px) {
	.contestDesc {
		max-height: 50px;
	}
}
 /*Show only 4 lines in smaller screens */
.contestDesc {
	max-height: 216px; /* (4 * 1.5 = 6) */
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('.contestDesc').readmore({
		lessLink: '<a href="#">Read less</a>',
		moreLink: '<a href="#">Read more</a>',
		speed: 75,
		blockCSS: 'display: block; width: 100%;',
		embedCSS: true,
	});
});
</script>
<script type="text/javascript" src="<?php echo $SiteURL;?>js/jquery.countdown.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>js/lodash.min.js"></script>
<script src="Readmore.js"></script>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main mtop20"> 
		
		<!-- SIDEBAR CODE  --> 
		
		<!-- END SIDEBAR CODE -->
		
		<div class="v2_container">
			<?php if($message['success'] != ""){ 



					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";

					}

					if($message['error'] != ""){ 



					echo '<div id="errormessage" class="message NoRecordsFound" >'.$message['error']."</div>";

					} 



					?>
			<?php 

	$imgpath= strstr($contest_img,"contest_img"); 

	if($result_found == 'yes')
	{
?>
		<div id="NewLiveContest">
			<div class="col-md-5">
				<h4 class="head4"> Contest Details</h4>
				<div class="video_contestant_new">
					<?php $exp_img = explode('contest_img/' , $imgpath); ?>
					<a rel="lightbox" href="<?php echo $imgpath; ?>"> <img src="contest_img/thumb_<?php echo $exp_img[1]; ?>" /> </a> </div>
				</div>
				<div class="col-md-6">
					<div id="NewLandingSidebar">
						<div id="CountDownTimer">
							<div class="v2_timer_contest_right">
								<?php 
									$checkDate = $fetchregistrationsql['contest_end']." ".$fetchregistrationsql['end_time'];
									$nowDateTime = date('Y-m-d H:i:s');
									if($nowDateTime >= $newcontestEndTime )
									{
										echo '<h2>Contest Ended</h2>';
										$class= " style='display:none;'";
									}
									else
									{
										$class= " style='display:block; width:100% !important;height:75px; color:#000;'";
										?>
										<h2>Contest Will End In</h2>
										
										<?php
									}
								?>
							</div> 
							<div class="v2_timer_contest_container main-example" <?php echo $class1; ?>> 
								<script type="text/javascript">
									$(document).ready(function(){
										var  contestID = '<?php echo $contest_id; ?>';
										var  endtime = '<?php echo $newcontestEndTime; ?>';

										$(window).on('load', function() {
											var labels = ['Weeks', 'Days', 'Hours', 'Minutes', 'Seconds'],
											nextYear = endtime,
											template = _.template($('#main-example-template_'+contestID).html()),
											currDate = '00:00:00:00:00',
											nextDate = '00:00:00:00:00',
											parser = /([0-9]{2})/gi,
											$example = $('#main-example_'+contestID);
											// Parse countdown string to an object
											function strfobj(str) 
											{
												var parsed = str.match(parser),
												obj = {};
												labels.forEach(function(label, i) {
												obj[label] = parsed[i]
												});
												return obj;
											}
											// Return the time components that diffs
											function diff(obj1, obj2) 
											{
												var diff = [];
												labels.forEach(function(key) {
													if (obj1[key] !== obj2[key]) {
														diff.push(key);
													}
												});
												return diff;
											}
											// Build the layout
											var initData = strfobj(currDate);
											labels.forEach(function(label, i) 
											{
												$example.append(template({
													curr: initData[label],
													next: initData[label],
													label: label
												}));
											});
											// Starts the countdown
											$example.countdown(nextYear, function(event) 
											{
												var newDate = event.strftime('%w:%d:%H:%M:%S'),
												data;
												if (newDate !== nextDate) 
												{
													currDate = nextDate;
													nextDate = newDate;
													// Setup the data
													data = {
													'curr': strfobj(currDate),
													'next': strfobj(nextDate)
													};
													// Apply the new values to each node that changed
													diff(data.curr, data.next).forEach(function(label) 
													{
														var selector = '.%s'.replace(/%s/, label),
														$node = $example.find(selector);
														// Update the node
														$node.removeClass('flip');
														$node.find('.curr').text(data.curr[label]);
														$node.find('.next').text(data.next[label]);
														// Wait for a repaint to then flip
														_.delay(function($node) {
															$node.addClass('flip');
														}, 50, $node);
													});
												}
											});
										});
									});
								</script> 
								<script type="text/template" id="main-example-template_<?php echo $contest_id; ?>">
									<div class="time <%= label %>">
										<span class="count curr top"><%= curr %></span>
										<span class="count next top"><%= next %></span>
										<span class="count next bottom"><%= next %></span>
										<span class="count curr bottom"><%= curr %></span>
										<span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
									</div>
								</script>
								<div style="width:95%;" class="countdown-container" id="main-example_<?php echo $contest_id; ?>">
								</div>
							</div>
						</div>
						<div class="NewLandingSidebarInner">
							<h2>Contest Description  </h2>
							<div class="clear"></div>
					    		<div class="v2_post_left_contest contestDesc">
					    			<?php echo $contest_desc; ?>
							</div>
						<h2>Rules </h2>  
						<div class="clear"></div>
						<div class="v2_post_left_contest full_post_contest listing_city_contest contestDesc">
							<div class="rulessection">
								<?php 
									//$rules_store = $fetchregistrationsql['contest_rule'];
									//$Rules = $fetchregistrationsql['contest_rule'];
									echo $contest_rule; 
								?>			
							</div>
						</div>
						<div class="v2_registion_container">
							<?php 
								if($_SESSION['user_id'] != $_GET['hostID'] && isset($_SESSION['user_id'])) 
								{ 
									if($contest_end > $currentdate)
									{ 
							?>			<a href="contestForm.php?id=<?php echo $contest_id; ?>&hostID=<?php echo $_GET[hostID]; ?>&host_id=<?php echo $_GET[hostID]; ?>" >
										<img src="images/enterNow.png" alt="" />
										</a> 
						<?php 			} 
								}
							?>						
						</div>
					</div>
				</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div class="AllContestants">
		<div class="v2_contest_post_container newruls">

				<h2>Contestants</h2>

				<div class="clear"></div>				

				<div class="v2_contest_content_post">

					<div class="v2_post_left_contest full_post_contest listing_city_contest">

						<div class="contest_search">

						<div class="clear"></div>

							<form class="contest_search_form">

								<input type="text" id="searchContestant" value="" placeholder="Type in here..." />

								<input type="hidden" name="usercontestant" id="txt2">

								<input type="button" id="findContestant" class="contest_search_btn" value="" />

							</form>

				 			<div class="contest_search_listing" >

				 				<ul id="ajaxList">

								<?php

								$getleadersql = mysql_query("SELECT A.user_type,A.user_id,A.c_video_id,COUNT(B.c_video_id) as total FROM contestent as A,contest_video_like as B WHERE A.contest_id = ".$contest_id." AND A.c_video_id = B.c_video_id GROUP BY B.c_video_id ORDER BY total DESC,c_video_id ASC  ".$condition2." ");	

							 	$contestantsArray = array();

							 	// $kk = 0;

								while($fetchleadersql = mysql_fetch_array($getleadersql))

								{

									$c_video_id=$fetchleadersql['c_video_id'];

									$i_count++;

									$get_video =mysql_query("Select * from `contestent` where c_video_id = '$c_video_id'");

									$fetchuservideo = mysql_fetch_array($get_video);

									$uid = $fetchleadersql['user_id'];

									$getusersql = mysql_query("SELECT * FROM clubs WHERE id = '$uid' ");

									$fetchusersql = mysql_fetch_array($getusersql);

														

									$getcitysql = mysql_query("SELECT * FROM capital_city WHERE city_id = ". $fetchusersql['club_city']);

									$fetchcitysql = mysql_fetch_array($getcitysql);

									

									$getstatesql = mysql_query("SELECT * FROM zone WHERE zone_id = ". $fetchusersql['club_state']);

									$fetchstatesql = mysql_fetch_array($getstatesql);

														
// echo "<pre>"; print_r($fetchleadersql); exit;


									if($fetchleadersql['user_type'] == "user")

									{

									

										if($fetchusersql['profilename'] =='')

										{

											$uname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];

										}

										else

										{

											$uname = $fetchusersql['profilename'];

										}

									

									}

									else

									{

										

										$select_club_dt = mysql_query("SELECT * FROM clubs WHERE id = '".$fetchleadersql['user_id']."'");

										$get_club_arr = mysql_fetch_assoc($select_club_dt);

										

/* 										if($get_club_arr['club_name'] =='')

										{

											$uname = $get_club_arr['first_name']." ".$get_club_arr['last_name'];

										}

										else

										{ */

											$uname = $get_club_arr['club_name'];

										//}								

										

									}

									// $val2[$kk]['label']=$uname;

									// $val2[$kk]['id'] = $uid;	

									$val2[] = $uname;



									//$kk++;

									

								$check_usr_exists = trim($uname);

								if(!empty($check_usr_exists))
								{

							?>

					  				<li>

										<div class="contestent">

											<div class="city_contst">

												<?php echo $fetchcitysql['city_name']." , ". $fetchstatesql['code'];?>

											</div>

						  					<div class="usname">

												<?php if(isset($_SESSION['user_id'])){ ?>

						  						<a href="host_profile.php?host_id=<?php echo $fetchleadersql['user_id']; ?>" target="_blank"><?php echo $uname; ?></a>

												<?php }else{ ?>

												

												<a href="<?php echo $uname; ?>" target="_blank"><?php echo $uname; ?></a>

												

												<?php } ?>

						  					</div>

						  					<div class="s_close">

												<div class='trophy'>

													<img src='images/rank<?php echo $i_count; ?>.png' alt='' />

												</div>

						  						<div class="simg_wrp">

						  							<?php 

						  								if($fetchuservideo['contest_type'] == 'image')

						  								{

						  							?>		<a href="<?php echo $fetchuservideo['video_name'];?>" class="fancybox" rel="group">

														  		<img src="<?php if($fetchuservideo['video_thumb'] != "") { echo $fetchuservideo['video_thumb']; }else{ echo 'images/man4.jpg';} ?>" />

														  	</a>

													<?php 	}

						  								else

						  								{

						  							?>		<a  onmouseover="jwplayer('a<?php echo $c_video_id;?>').play();" onmouseout="jwplayer('a<?php echo $c_video_id;?>').pause();" href="#dialogx<?php echo $video_row['video_id'];?>" name="modal" style="">

														  		<div  id="a<?php echo $c_video_id;?>" ></div>

														  		<script type="text/javascript">

														  			 jwplayer("a<?php echo $c_video_id;?>").setup({

																  		file: "<?php echo $SiteURL.$contest_list[0]['contest_video'];?>",

																  		height : 200 ,

																  		width: 200

															  		});

															  	</script>

															</a>

						  							<?php 	}	?>

												  	

												  		

											  	</div>

						  						<div class="s_hover_des">

													<div class="s_likecity">

													<?php 

														if( ($fetchleadersql['user_id'] == $_SESSION['user_id']) && ($_SESSION['user_type'] == $fetchleadersql['user_type'])/*($currentDate >= $LiveRegDateStart && $currentDate <= $LiveRegDateEnd) */ )

														{

													?>

									                    					<a href="javascript:void(0);" onclick="deleteContestant(<?php echo $fetchuservideo['c_video_id']; ?>);" title="Delete" class="del_contst">

													                    		<img src="images/del_contst.png" alt="Delete" />

													                    	</a>

							  		<?php 					}

														$sql_like1 = "SELECT `c_like_user_id` , vote_type   FROM `contest_video_like` WHERE `c_like_user_id` = '".$_SESSION['user_id']."' AND c_video_id='".$fetchuservideo["c_video_id"]."' ";

														$sql_like= mysql_query($sql_like1) or die(mysql_error());

														$is_like= mysql_fetch_assoc($sql_like);

									?>

		                                     										<div class="sh_new_overlay">

						  									<div class="s_shout_<?php echo $fetchuservideo['c_video_id']; ?>">

							<?php 									if($is_like['vote_type']!='yes') 

																{ 

																	if($_SESSION['user_id'] != "")

																	{

																		if( ($currentDate >= $contestStartDate) && ( $currentDate <=  $contestEndDate ) )

																		{

											?>

																			<a  href="javascript:void(0);" style="text-decoration:none; color: #000;" onclick="count_vote('<?php echo $c_video_id; ?>','yes','<? echo $contest_id; ?>');">

																				Shouts <?php echo $fetchleadersql['total']; ?>

																				<span><img src="/images/s_like.png" alt="" /></span>

																			</a>

										  	<?php 							}

															  			else

															  			{

						  					?>

						  													Shouts <?php echo $fetchleadersql['total']; ?><span><img src="/images/s_like.png" alt="" /></span>

						 <?php 												}

															  		}

																	else

																	{

																		echo "Shouts <span id='yesnolikes_".$fetchuservideo['c_video_id']."'>".$fetchleadersql['total']."</span><span><img src='images/s_like.png' alt='' /></span>"; 

																	}

																}

																else

																{ 

																	echo "Shouts  <span id='yesnolikes_".$fetchuservideo['c_video_id']."'>".$fetchleadersql['total']."</span><span><img src='images/s_like.png' alt='' /></span>"; 

																}

				?>											</div>

														</div>

														<div class="dateTime">

														  	<div id="c_slot_time">

							<?php 									

																$time_slot_query = mysql_query("SELECT * FROM contestent_time_slots INNER JOIN contestent ON contestent.c_video_id = contestent_time_slots.contestent_id WHERE contestent.c_video_id = '".$fetchleadersql['c_video_id']."'");

																$count_tslot = mysql_num_rows($time_slot_query);

																$row_tslot = mysql_fetch_assoc($time_slot_query);	

																$cluB_ID = $row_tslot['user_id'];

																$user_Type = $row_tslot['user_type'];

																if($user_Type == "club")

																{

																	$getClubInfo = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$cluB_ID' ");

																	$fetchClubInfo = mysql_fetch_array($getClubInfo);

																	

																	

																}

																$start_slot = $row_tslot['slot_start_date']." ".$row_tslot['slot_start_time'];

																$s_slot = date('jS F, Y h:i:s A' , strtotime($start_slot));

																$end_slot = $row_tslot['slot_end_date']." ".$row_tslot['slot_end_time'];

																$e_slot = date('jS F, Y h:i:s A' , strtotime($end_slot));

								?>

						 									 </div>

						  									<div class="clear"></div>

						   

															<div class="live_strem_new">

						<?php

																$mobile = detect_mobile();

																if($mobile === true) 

																{ 

						?>

																	<a class="button_live" name="submit"  onclick="goto1('https://192.163.248.47:1935/live/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming

																	

													<?php 

																	if(detect_stream($username_dash_separated)===true)

																	{ 

															?>

																		<span class="stats_icon" >

																			<img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" />

																		</span>

													<?php 

																	} 

																	else

																	{ 

														?>

																		<span class="stats_icon" >

																			<img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" />

																		</span>

													<?php 				} 		?>

																	</a>

													<?php 			}

																else 

																{ 

													?>

																	<a class="button_live" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&contestantid=<?php echo $c_video_id;?>&contestID=<?php echo $_GET['contid'];?>')">Live Streaming

													<?php 

																	if(detect_stream($username_dash_separated)===true)

																	{ 

														?>

																		<span class="stats_icon" >

																			<img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" />

																		</span>

													<?php 				} 

																	else

																	{ 

														?>

																		<span class="stats_icon" >

																			<img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" />

																		</span>

													<?php 				} 		?>

																	</a>

														<?php 		} 	?>

						  										<div class="clear"></div>

															</div>

														</div>

													</div>

												</div>

											</div>

						  				</div>	

					  				</li>

					  			<?php 	}} // ENDWHILE 	
// echo "<pre>"; print_r($val2); exit;
					  			$js_array = json_encode($val2);

					  			?>

								</ul>

							</div>

						</div>

					</div>

					<div class="v2_post_left_contest full_post_contest listing_city_contest">

						<ul class="searchlistings">

						<?php

							$total_contests = array();

							$total_contestents = array();

						 	$contest_query = "SELECT * FROM contestent WHERE contestent.contest_id = '$contest_id'  ";

							$contest_list = mysql_query($contest_query);

							$i_count = 0;
//echo "SELECT A.user_type,A.user_id,A.contest_type,A.c_video_id,COUNT(B.c_video_id) as total FROM contestent as A,contest_video_like as B WHERE A.contest_id = ".$contest_id." AND A.c_video_id = B.c_video_id GROUP BY B.c_video_id ORDER BY total DESC,c_video_id ASC  ".$condition."   "; exit;
							$getleadersql = mysql_query("SELECT A.user_type,A.user_id,A.contest_type,A.c_video_id,COUNT(B.c_video_id) as total FROM contestent as A,contest_video_like as B WHERE A.contest_id = ".$contest_id." AND A.c_video_id = B.c_video_id GROUP BY B.c_video_id ORDER BY total DESC,c_video_id ASC  ".$condition."   ");

							

							while($fetchleadersql = mysql_fetch_array($getleadersql))

							{

								$c_video_id=$fetchleadersql['c_video_id'];

								$i_count++;

								$get_video =mysql_query("Select * from `contestent` where c_video_id = '$c_video_id'");

								$fetchuservideo = mysql_fetch_array($get_video);

								$uid = $fetchleadersql['user_id'];

								if($fetchleadersql['user_type'] == 'user')
								{
									$getusersql = mysql_query("SELECT * FROM user WHERE id = '$uid' ");

									$fetchusersql = mysql_fetch_array($getusersql);

														

									$getcitysql = mysql_query("SELECT * FROM capital_city WHERE city_id = ". $fetchusersql['city'])	;

									$fetchcitysql = mysql_fetch_array($getcitysql);

									

									$getstatesql = mysql_query("SELECT * FROM zone WHERE zone_id = ". $fetchusersql['state'])	;

									$fetchstatesql = mysql_fetch_array($getstatesql);
								}
								else
								{
									$getusersql = mysql_query("SELECT * FROM clubs WHERE id = '$uid' ");

									$fetchusersql = mysql_fetch_array($getusersql);

														

									$getcitysql = mysql_query("SELECT * FROM capital_city WHERE city_id = ". $fetchusersql['club_city'])	;

									$fetchcitysql = mysql_fetch_array($getcitysql);

									

									$getstatesql = mysql_query("SELECT * FROM zone WHERE zone_id = ". $fetchusersql['club_state'])	;

									$fetchstatesql = mysql_fetch_array($getstatesql);
								}


								



								if($fetchleadersql['user_type'] == "user")

								{

									if($fetchusersql['profilename'] =='')

									{

										$uname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];

									}

									else

									{

										$uname = $fetchusersql['profilename'];

									}

							

								}

								else

								{

									$select_club_dt = mysql_query("SELECT * FROM clubs WHERE id = '".$fetchleadersql['user_id']."'");

									$get_club_arr = mysql_fetch_assoc($select_club_dt);

									

									if($get_club_arr['club_name'] =='')

									{

										$uname = $get_club_arr['first_name']." ".$get_club_arr['last_name'];

									}

									else

									{

										$uname = $get_club_arr['club_name'];

									}



									$clubNAme= explode(" ", $uname);

									$username_dash_separated = implode("-", $clubNAme);

									$username_dash_separated = clean($username_dash_separated);								

								}

								

								$check_usr_exists = trim($uname);

								if(!empty($check_usr_exists)){

							?>

			  				<li style="list-style:none !important;">

								<div class="contestent">

									<div class="city_contst">

										<?php echo $fetchcitysql['city_name']." , ". $fetchstatesql['code'];?>

									</div>

						  					<div class="usname">

												<?php if(isset($_SESSION['user_id'])){ ?>

						  						<a href="host_profile.php?host_id=<?php echo $fetchleadersql['user_id']; ?>" target="_blank"><?php echo $uname; ?></a>

												<?php }else{ ?>

												

												<a href="<?php echo $uname; ?>" target="_blank"><?php echo $uname; ?></a>

												

												<?php } ?>

						  					</div>

				  					<div class="s_close">

										<div class='trophy'>

											<img src='images/rank<?php echo $i_count; ?>.png' alt='' />

										</div>

				  						<div class="simg_wrp">

				  						<?php 

				  							$SRCthumb = $fetchusersql['image_nm'];

			  								$SRCimage = $fetchusersql['image_nm'];

			  								if($fetchuservideo['contest_type'] == 'image')

			  								{

			  							?>		

			  									<!-- <img src="<?php if($SRCthumb != "") { echo $SRCthumb; }else{ echo 'images/man4.jpg';} ?>" /> -->

			  									<a href="<?php echo $fetchuservideo['video_name'];?>" class="fancybox" rel="group">

											  		<img src="<?php if($fetchuservideo['video_thumb'] != "") { echo $fetchuservideo['video_thumb']; }else{ echo 'images/man4.jpg';} ?>" />

											  	</a>

										<?php 	}

			  								else

			  								{

			  							?>		<img src="<?php if($SRCimage != "") { echo $SRCimage; }else{ echo 'images/man4.jpg';} ?>" />

			  									<div class="video_overlay">

													<img src="images/playthisvid.png" alt="Play" onclick="javascript:void window.open('<?php echo $SiteURL; ?>play_advertise_video.php?action=contestent&amp;id=<?php echo $fetchuservideo['c_video_id']; ?>','','width=500,height=500,resizable=true,left=0,top=0');return false;"/>

												</div>

			  							<?php 	}	?>

									  	</div>

				  						<div class="s_hover_des">

											<div class="s_likecity">

											<?php 

												if( ($fetchleadersql['user_id'] == $_SESSION['user_id']) && ($_SESSION['user_type'] == $fetchleadersql['user_type'])/*($currentDate >= $LiveRegDateStart && $currentDate <= $LiveRegDateEnd) */ )

												{

											?>

							                    					<a href="javascript:void(0);" onclick="deleteContestant(<?php echo $fetchuservideo['c_video_id']; ?>);" title="Delete" class="del_contst">

											                    		<img src="images/del_contst.png" alt="Delete" />

											                    	</a>

					  		<?php 					}

												$sql_like1 = "SELECT `c_like_user_id` , vote_type   FROM `contest_video_like` WHERE `c_like_user_id` = '".$_SESSION['user_id']."' AND c_video_id='".$fetchuservideo["c_video_id"]."' ";

												$sql_like= mysql_query($sql_like1) or die(mysql_error());

												$is_like= mysql_fetch_assoc($sql_like);

							?>

                                     										<div class="sh_new_overlay">

				  									<div class="s_shout_<?php echo $fetchuservideo['c_video_id']; ?>">

					<?php 									if($is_like['vote_type']!='yes') 

														{ 

															if($_SESSION['user_id'] != "")

															{

																if( ($currentDate >= $contestStartDate) && ( $currentDate <=  $contestEndDate ) )

																{

									?>

																	<a  href="javascript:void(0);" style="text-decoration:none; color: #000;" onclick="count_vote('<?php echo $c_video_id; ?>','yes','<? echo $contest_id; ?>');">

																		Shouts <?php echo $fetchleadersql['total']; ?>

																		<span><img src="/images/s_like.png" alt="" /></span>

																	</a>

								  	<?php 							}

													  			else

													  			{

				  					?>

				  													Shouts <?php echo $fetchleadersql['total']; ?><span><img src="/images/s_like.png" alt="" /></span>

				 <?php 												}

													  		}

															else

															{

																echo "Shouts <span id='yesnolikes_".$fetchuservideo['c_video_id']."'>".$fetchleadersql['total']."</span><span><img src='images/s_like.png' alt='' /></span>"; 

															}

														}

														else

														{ 

															echo "Shouts  <span id='yesnolikes_".$fetchuservideo['c_video_id']."'>".$fetchleadersql['total']."</span><span><img src='images/s_like.png' alt='' /></span>"; 

														}

		?>											</div>

												</div>

												<div class="dateTime">

												  	<div id="c_slot_time">

					<?php 									

														$time_slot_query = mysql_query("SELECT * FROM contestent_time_slots INNER JOIN contestent ON contestent.c_video_id = contestent_time_slots.contestent_id WHERE contestent.c_video_id = '".$fetchleadersql['c_video_id']."'");

														$count_tslot = mysql_num_rows($time_slot_query);

														$row_tslot = mysql_fetch_assoc($time_slot_query);	

														$cluB_ID = $row_tslot['user_id'];

														$user_Type = $row_tslot['user_type'];

														if($user_Type == "club")

														{

															$getClubInfo = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$cluB_ID' ");

															$fetchClubInfo = mysql_fetch_array($getClubInfo);

															

															

														}

														$start_slot = $row_tslot['slot_start_date']." ".$row_tslot['slot_start_time'];

														$s_slot = date('jS F, Y h:i:s A' , strtotime($start_slot));

														$end_slot = $row_tslot['slot_end_date']." ".$row_tslot['slot_end_time'];

														$e_slot = date('jS F, Y h:i:s A' , strtotime($end_slot));

						?>

				 									 </div>

				  									<div class="clear"></div>

				   								<?php 

				   									if(isset($_SESSION['user_id']))

				   									{

				   								?>

													<div class="live_strem_new" style="display:none;">

				<?php

														$mobile = detect_mobile();

														if($mobile === true) 

														{ 

				?>

															<a class="button_live" name="submit"  onclick="goto1('https://192.163.248.47:1935/live/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming

															

											<?php 

															if(detect_stream($username_dash_separated)===true)

															{ 

													?>

																<span class="stats_icon" >

																	<img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" />

																</span>

											<?php 

															} 

															else

															{ 

												?>

																<span class="stats_icon" >

																	<img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" />

																</span>

											<?php 				} 		?>

															</a>

											<?php 			}

														else 

														{ 

											?>

															<a class="button_live" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&contestantid=<?php echo $c_video_id;?>&contestID=<?php echo $_GET['contid'];?>')">Live Streaming

											<?php 

															if(detect_stream($username_dash_separated)===true)

															{ 

												?>

																<span class="stats_icon" >

																	<img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" />

																</span>

											<?php 				} 

															else

															{ 

												?>

																<span class="stats_icon" >

																	<img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" />

																</span>

											<?php 				} 		?>

															</a>

												<?php 		} 	?>

				  										<div class="clear"></div>

													</div>

												<?php 	}	?>

												</div>

											</div>

										</div>

									</div>

				  				</div>	

			  				</li>

			  			<?php 	}} // ENDWHILE 	?>

						</ul>

					</div>

				</div>

			</div>
   	</div>
<?php }
	else
	{
?>
		<div class="content1">
			<div class="content_txt NoRecordsFound">
				<h1>No Record Found</h1>
			</div>
		</div>
<?php 	}	?>
		<script>

		function changecity(val)

		{

		$.get('current_contests.php?city_id='+val, function(data) {

		window.location='current_contests.php';

		});

		}

		function changecity2()

		{

		val=$('#city_name').val();

		$.get('set-session.php?city_id='+val, function(data) {

		window.location='current_contests.php';

		});

		}

		 $(document).ready( function() {

			//$('#myList').megalist();

			$('#myList').on('change', function(event){ 

				var message = "selected index: "+event.selectedIndex+"\n"+ 

								"selected item: "+event.srcElement.get()[0].outerHTML;

				alert( message ); 

			})

		});

		function likefun(val1, val2, vcount,host_id)

		{

		$.get('current_contests.php?c_video_id='+val1+'&action=like&video_user_id='+val2, function(data) {

		window.location='host_contests.php?cont_id='+val2+'&host_id='+host_id;

		});

		$('#like_'+val1).html('Like');

		 vcount++;

		$('#like_count_'+val1).html(vcount);

		}

</script> 
		<script language="javascript">

	function count_vote(id,type,contid)

	{

		$.get('vote.php?c_id='+id+'&type='+type+'&contid='+contid, function(data) {

			

			$('#yesnolikes_'+id).html(data);

			

		 

		

		});

	}

	</script> 

	<?php if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){
			echo '<script type="text/javascript">alert("Your entry has been added successfully in current contest.");</script>';
			unset($_SESSION['msg']);
		}?>

	</div>
	<div class="clear"></div>
</div>
<div class="home_wrapper">
<div class="main_home">
	<div class=""> <!--home_content class removed-->
		
		<div class=""> </div>
	</div>
</div>
<?

include('Footer.php');

?>
