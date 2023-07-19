<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$hostID=$_GET['host_id'];

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

// if(!isset($_SESSION['user_id'])){
// 	$Obj->Redirect("login.php");
// }
$hostID=$_GET['host_id'];

if(isset($hostID))
{
	$sql="SELECT * FROM `contest` where `status`='1' AND host_id=".$hostID."   ORDER BY `contest_id` ";	
	$shout_list12 = @mysql_query($sql);
	$num12=@mysql_num_rows($shout_list12);

}
$titleofpage="Host Contest";
if(!isset($_SESSION['user_id']))
{
	include('PublicProfileHeader.php');
}
else
{
	include('LoginHeader.php');
}

?>
<script>
function savehost(id,ac)
{
	$.get( "savehost.php?host_id="+id+'&action='+ac, function( data ){
		window.location='host_profile.php?host_id='+id;
   	});

}
</script>
<?php 

	$getq = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$hostID."'  ");
	$countrec = @mysql_num_rows($getq);
	if($countrec > 0)
	{
		$fetchstatus = @mysql_fetch_array($getq);
		$statuspage = $fetchstatus['contest'];
		$me = $fetchstatus['contestmessage'];
	}
	else
	{
		$statuspage = "Enable";
		$me= "";
	}
?>     
<script type="text/javascript" src="<?php echo $SiteURL;?>js/jquery.countdown.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>js/lodash.min.js"></script>
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
						if($_SESSION['user_type'] == "user" && $statuspage == "Disable with message")
						{
							$pagestatus = "0";	
							echo "<div class='nostoreview' >";
							if($fetchstatus['contest'] == "Disable with message")
							{
								echo "<h1 id='title' style='text-align: center;'>".$me."</h1>";
							}
							if($fetchstatus['contest'] == "Disable without message")
							{
								
							}

							echo "</div>";
						}
						else
						{							
		?>
							<div class="support_inner v2_mysitti_contest_lissts">
							 <h2 class="headingHost">Host Contests </h2>
								<div class="v2_recent_contests">
        									<table>
           										<tbody>
           											<tr>
		<?php 	
	           										if($num12 > 0 ) 
											{
												$sumit = 0;
												while($row1 = @mysql_fetch_array($shout_list12))
												{
													$contestEndtime = $row1['contest_end']." ".$row1['end_time'];
													$newcontestEndTime = date('Y/m/d H:i:s',strtotime($contestEndtime));
			?>
               												<td>
														<div class="s_listboxwrap left_even">
															<div class="s_border_bottom">
																<div class="s_cont_h"> 
																	<?php echo $row1['contest_title'] ;?>
																</div>
															</div>
															<div class="timer">
																<p>Contest will end in </p>
																<div style="display:block; color:#000;" class="v2_timer_contest_container main-example"> 
																	<script type="text/javascript">
																		$(document).ready(function(){
																			var  contestID = "<?php echo $row1['contest_id'] ;?>";
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
																	<script type="text/template" id="main-example-template_<?php echo $row1['contest_id']; ?>">
																		<div class="time <%= label %>">
																			<span class="count curr top"><%= curr %></span>
																			<span class="count next top"><%= next %></span>
																			<span class="count next bottom"><%= next %></span>
																			<span class="count curr bottom"><%= curr %></span>
																			<span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
																		</div>
																	</script>
																	<div id="main-example_<?php echo $row1['contest_id'];?>" class="countdown-container" style="width:95%;">
																	</div>
																</div>
															</div>
															<div class="s_box">
																<div class="s_img">
																	<a rel="group" href="<?php echo $SiteURL.str_replace('../', '', $row1['contest_img'])?>" class="fancybox">
																		<img alt="" src="<?php echo $SiteURL.str_replace('../', '', $row1['contest_img'])?>">
																	</a>
																</div>	
																<div class="s_des">
																	<?php 
																	$contest_description=$row1['contest_desc'];
																	if(strlen($contest_description) > 150)
																	{
																		echo substr(strip_tags($contest_description), 0, 150)."......"; 
																	}
																	else
																	{
																		echo $contest_description;
																	}
																	?>
																</div>
															</div>
															<div class="s_btn">
																<a class="a-btn enter_here" href="<?php echo $SiteURL;?>view_contestent.php?cont_id=<?php echo $row1['contest_id']?>&hostID=<?php echo $_GET['host_id'];?>&red=hostprofile" data-icon="›">
																	Enter Here
																</a>
												  			</div>
			  											</div> 
								                            				<script type="text/javascript">
																$(function () {
																	//var austDay = new Date();
																	var austDay = new Date(2016, 04 - 1, 30);
																	$('#defaultCountdown1').countdown({until: austDay});
																	$('#year').text(austDay.getFullYear());
																});
														</script>
													</td>
								<?php 					$sumit++;
													if($sumit%2 == 0)
													{
														echo "</tr><tr>";
													}
												}

									?>
											</tr>
        										</tbody>
        									</table>
								</div>
							</div>
				<?php 			}
						}
				?>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
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
<? include('Footer.php');?>
