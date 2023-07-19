<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
//include("CheckLogIn_con.Inc.php");
$who_like_id=$_SESSION['user_id'];
$titleofpage=" MySitti Contests List";
if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); 
}
else
{
	include('Header.php');
	//include('NewHeadeHost.php'); 
	//$Obj->Redirect('index.php');
}

if(!isset($_SESSION['user_id'])) { 
?>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".socialfixed").css("display", "none");
	});
	</script>
<?php } ?>

<!-- Auto Scroll -->
<script src="js/megalist.js"></script>
<link href="js/megalist.css" rel="stylesheet" type="text/css" >
<link href="js/prettify.css" rel="stylesheet">
<script src="js/prettify.js"></script>
<script src="js/raf.js"></script>
<script>

	$(document).ready( function() {
		
		$('#myList').megalist();
		$('#myList').on('change', function(event){ 
			var message = "selected index: "+event.selectedIndex+"\n"+ 
						  "selected item: "+event.srcElement.get()[0].outerHTML;
			alert( message ); 
		})
	});
	function likefun(val1, val2, vcount)
	{
		$.get('current_contests.php?c_video_id='+val1+'&action=like&video_user_id='+val2, function(data) {
			//window.location='current_contests.php';
		});
		$('#like_'+val1).html('Shout');
	 	vcount++;
		$('#like_count_'+val1).html(vcount);
	}
</script>

<script type="text/javascript" src="<?php echo $SiteURL;?>js/jquery.countdown.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>js/lodash.min.js"></script>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
		<div class="v2_inner_main_content">

		
		
 
		
<?php
	$sql="SELECT * FROM `contest` WHERE `contest_status`= 'enable' AND `contest_type` IN ('large','small')  ORDER BY `contest_id` AND host_id = 0 AND user_id = 0 DESC ";
	$contestlistquery = @mysql_query($sql);
	$countcontests = @mysql_num_rows($contestlistquery);
	
?>		
		
			<div class="support_inner v2_mysitti_contest_lissts">
				<h3 id="title" class="h3">MySitti Contests</h3>
				<div class="v2_recent_contests">
                <table>
                   <tr>
          
				<?php 
					if($countcontests > 0)
					{
						$i=0;
						while($row = @mysql_fetch_array($contestlistquery))
						{
							if($i%2 == 0)
							{
								$class = "left_even";
							}
							else
							{
								$class = "left_even";
							}
							$i++;
							$Date = $row['contest_end'];
							$DateArray = explode('-',$Date);
							$Year = $DateArray[0];
							$Month = $DateArray[1];
							$Day = $DateArray[2];
							$checkDate = $row['contest_end']." ".$row['end_time'];
							$nowDateTime = date('Y-m-d H:i:s');

							/* COUNTDOWN VARIABLES */
							$contestStarttime = $row['contest_start']." ".$row['start_time'];
							$contestEndtime = $row['contest_end']." ".$row['end_time'];
							$battleStartdatetime = $row['battle_date_start'];
							$battleEnddatetime = $row['battle_date_end'];
							$contestID = $row['contest_id'];
							$registrationDate = $row['contest_regi'];
							$contestVideo = $row['contest_video'];
							if($row['contest_type'] == "live")
							{
								$newcontestEndTime = date('Y/m/d H:i:s',strtotime($battleEnddatetime));
							}
							else
							{
								$newcontestEndTime = date('Y/m/d H:i:s',strtotime($contestEndtime));	
							}
							/* END*/
							if($nowDateTime >= $contestEndtime )
							{
								
								$class1 = " style='display:none;'";
								$text = "Contest Ended";
							}
							else
							{
								$class1= " style='display:block; color:#000;'";
								$text = "Contest will end in ";
								
							}
				?> 
             <td>
							<div class="s_listboxwrap <?php echo $class; ?>">
								<div class="s_border_bottom">
									<div class="s_cont_h"> 
										<?php echo $row['contest_title']."- Prize: ".$row['contest_prize']; ?>
									</div>
								</div>
								<div class="timer">
									<p><?php echo $text; ?></p>
									<div class="v2_timer_contest_container main-example" <?php echo $class1; ?>> 
										<script type="text/javascript">
											$(document).ready(function(){
												var  contestID = '<?php echo $contestID; ?>';
												var  endtime = '<?php echo $newcontestEndTime; ?>';
												// $('#countdowntimer_'+contestID).countdown(endtime, function(event) {
												// 	$(this).html(event.strftime('%w weeks %d days %H:%M:%S'));
												// });

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
										<script type="text/template" id="main-example-template_<?php echo $contestID; ?>">
											<div class="time <%= label %>">
											  <span class="count curr top"><%= curr %></span>
											  <span class="count next top"><%= next %></span>
											  <span class="count next bottom"><%= next %></span>
											  <span class="count curr bottom"><%= curr %></span>
											  <span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
											</div>
										</script>
										<div style="width:95%;" class="countdown-container" id="main-example_<?php echo $contestID; ?>">
										</div>
									</div>
								</div>
								<div class="s_box">
								
									<div class="s_img">
										<?php 
									  		if(!empty($contestVideo))
									  		{ 
									  	?>		<img onclick="javascript:void window.open('<?php echo $SiteURL; ?>play_advertise_video.php?type=contest&id=<?php echo $contestID; ?>','','width=500,height=500,resizable=true,left=0,top=0');return false;" src="<?php echo $row['contest_img'];?>" alt="">
									  	<?php  	}
									  		else
									  		{
									  	?>
									  			<a class="fancybox" href="<?php echo $row['contest_img'];?>" rel="group">
									  				<img src="<?php echo $row['contest_img'];?>" alt />
									  			</a>
									  	<?php
									  		}	
									  	?>
										
									</div>	
									<div class="s_des">
										<?php
											$contest_description=$row['contest_desc'];
											//echo $contest_desc1;
											echo substr($contest_description, 0, 130); 
										?> ... 
									</div>
								</div>
								<div class="enterContest">
									<a data-icon="&#8250;" href="mysitti_contests.php?contid=<?php echo $row['contest_id']; ?>" class=" ">
										Enter Here 
										
									</a>
					  			</div>
			  				</div> 
                       </td>
				<?php 		} // ENDWHILE
					}
					else
					{
						echo "<span id='title' class='nocontests'>No Contests Found!</span>";
					}
				?>
                  
                            </tr>
                               </table>
				</div>
			</div>
			
			
			
	<?php
	$sql="SELECT * FROM `contest` WHERE contest_type ='live' AND `status`='1' AND host_id = 0 AND `user_id` = 0 AND `contest_status` = 'enable' ORDER BY `contest_id` DESC";

	$contestlistquery = @mysql_query($sql);
	$countcontests = @mysql_num_rows($contestlistquery);
	
?>			
			
			<div class="support_inner v2_mysitti_contest_lissts">
				<h3 id="title" class="h3">Live Contests</h3>
				<div class="v2_recent_contests">
                <table>
                <tr>
				<?php 
					if($countcontests > 0)
					{
						$i=0;
						while($row = @mysql_fetch_array($contestlistquery))
						{
							if($i%2 == 0)
							{
								$class = "left_even";
							}
							else
							{
								$class = "left_even";
							}
							$i++;
							$Date = $row['contest_end'];
							$DateArray = explode('-',$Date);
							$Year = $DateArray[0];
							$Month = $DateArray[1];
							$Day = $DateArray[2];
							$checkDate = $row['contest_end']." ".$row['end_time'];
							$nowDateTime = date('Y-m-d H:i:s');

							/* COUNTDOWN VARIABLES */
							$contestStarttime = $row['contest_start']." ".$row['start_time'];
							$contestEndtime = $row['contest_end']." ".$row['end_time'];
							$battleStartdatetime = $row['battle_date_start'];
							$battleEnddatetime = $row['battle_date_end'];
							$contestID = $row['contest_id'];
							$contestVideo = $row['contest_video'];
							$registrationDate = $row['contest_regi'];
							if($row['contest_type'] == "live")
							{
								$newcontestEndTime = date('Y/m/d H:i:s',strtotime($battleEnddatetime));
							}
							else
							{
								$newcontestEndTime = date('Y/m/d H:i:s',strtotime($contestEndtime));	
							}
							/* END*/
							if($nowDateTime >= $battleEnddatetime )
							{
								
								$class1 = " style='display:none !important;'";
								$text = "Contest Ended";
							}
							else
							{
								$class1= " style='display:block; color:#000;'";
								$text = "Contest will end in ";
								
							}
				?> <td>
							<div class="s_listboxwrap <?php echo $class; ?>">
								<div class="s_border_bottom">
									<div class="s_cont_h"> 
										<?php echo $row['contest_title']."- Prize: ".$row['contest_prize']; ?>
									</div>
								</div>
								<div class="timer">
									<p><?php echo $text; ?></p>
									<div class="v2_timer_contest_container main-example" <?php echo $class1; ?>> 
										<script type="text/javascript">
											$(document).ready(function(){
												var  contestID = '<?php echo $contestID; ?>';
												var  endtime = '<?php echo $newcontestEndTime; ?>';
												// $('#countdowntimer_'+contestID).countdown(endtime, function(event) {
												// 	$(this).html(event.strftime('%w weeks %d days %H:%M:%S'));
												// });

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
										<script type="text/template" id="main-example-template_<?php echo $contestID; ?>">
											<div class="time <%= label %>">
											  <span class="count curr top"><%= curr %></span>
											  <span class="count next top"><%= next %></span>
											  <span class="count next bottom"><%= next %></span>
											  <span class="count curr bottom"><%= curr %></span>
											  <span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
											</div>
										</script>
										<div style="width:95%;" class="countdown-container" id="main-example_<?php echo $contestID; ?>">
										</div>
									</div>
									<div class="battle_contest_date">
									          	<?php 
									           		if($row['battle_date_start'] != "0000-00-00 00:00:00" && $nowDateTime <= $battleEnddatetime) 
											{
												?>
											
											           <h5>Battle Starts On</h5>
											           <br  />
											           <?php 
											            	echo date("F j, Y, g:i a", strtotime($row['battle_date_start']));
											} ?>
								          </div>
								</div>
								<div class="s_box">
								
									<div class="s_img">
										<!--<img src="<?php echo $row['contest_img'];?>" alt />-->
										
											<?php 
												if(!empty($contestVideo))
												{
											?>		<img style="cursor: pointer;" onclick="javascript:void window.open('<?php echo $SiteURL; ?>play_advertise_video.php?type=contest&id=<?php echo $contestID; ?>','','width=500,height=500,resizable=true,left=0,top=0');return false;" src="<?php echo $row['contest_img'];?>" alt="">
											<?php  	}
												else
												{
											?>
													<a class="fancybox" href="<?php echo $row['contest_img'];?>" rel="group">
														<img src="<?php echo $row['contest_img'];?>" alt="">
													</a>
											<?php
												}
											?>
										
										
										
										
										
									</div>	<div class="s_des">
										<?php
											$contest_description=$row['contest_desc'];
											//echo $contest_desc1;
											echo substr($contest_description, 0, 150); 
										?> ... 
									</div>
								</div>
								<div class="live_strem_new btn-live"> 
									<?php 
										if($nowDateTime >= $battleStartdatetime)
										{
									?>               	<a target="_blank" href='live2/battle.php?contest_id=<?php  echo $row['contest_id']; ?>' name="submit" class="button_live fourth">View Battle</a>
							                	<?php 	}
							                		else
							                		{
							                			?>
							                			<a href='javascript:void(0);' name="submit" class="button_live fourth">Battle Date: <?php echo date('M j, g:i a',strtotime($battleStartdatetime)); ?></a>
							                			<?php
							                		}
							                ?>
							                  	<div class="clear"></div>
						                	</div>
								<div class="s_btn">
									<a data-icon="&#8250;" href="LiveContest.php?contid=<?php echo $row['contest_id']; ?>" class="a-btn enter_here">
										Enter Here
										
									</a>
					  			</div>
			  				</div> 
                            </td>
						  	<script type="text/javascript">
								$(function () {
									//var austDay = new Date();
									var austDay = new Date(<?php echo $Year; ?>, <?php echo $Month; ?> - 1, <?php echo $Day; ?>);
									$('#defaultCountdown<?php echo $i;?>').countdown({until: austDay});
									$('#year').text(austDay.getFullYear());
								});
							</script>
				<?php 		} // ENDWHILE
					}
					else
					{
						echo "<span id='title' class='nocontests'>No Contests Found!</span>";
					}
				?></tr>
                </table>
				</div>
			</div>					
				
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			

			
			
			
			
		</div>
	</div>
	<div class="clear"></div>
</div>

<script language="javascript">
	function count_vote(id,type,contid)
	{
	  	$.get('vote.php?c_id='+id+'&type='+type+'&contid='+contid, function(data) {
		  	$('#yesnolikes_'+id).html(data);
		});
	}
</script>
<style type="text/css">
.main-example {
  margin: 0 auto;
  width: 355px;
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
</style>
<?php include('Footer.php'); ?>
