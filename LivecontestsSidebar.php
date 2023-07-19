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
</style>


<div id="liveContest_sidebar">
  	<div class="aside">
  		<div id="CountDownTimer">
  			<div class="v2_timer_contest_right">
			<?php 
				$checkDate = $fetchregistrationsql['contest_end']." ".$fetchregistrationsql['end_time'];
				$nowDateTime = date('Y-m-d H:i:s');
				if($nowDateTime >= $checkDate )
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
			<div class="clear"></div>
			<div class="v2_timer_contest_container main-example" <?php echo $class1; ?>> 
				<script type="text/javascript">
					$(document).ready(function(){
						var  contestID = '<?php echo $contestID; ?>';
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
				<script type="text/template" id="main-example-template_<?php echo $contestID; ?>">
					<div class="time <%= label %>">
					  <span class="count curr top"><%= curr %></span>
					  <span class="count next top"><%= next %></span>
					  <span class="count next bottom"><%= next %></span>
					  <span class="count curr bottom"><%= curr %></span>
					  <span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
					</div>
				</script>
				<div style="width:95%;" class="countdown-container" id="main-example_<?php echo $contestID; ?>"></div>
			</div>
  		</div>
		
		<div class="clear" <?php echo $class; ?>> 
			<div class="v2_registion_container">
		 	<?php 
		 		if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == "club") 
	 			{
	 		?> 
					
			<?php 	}
				//if(date('Y-m-d') < $registrationDate )
				//{
				//	echo "<p>Registration Opened Till ".date( 'd M, Y', strtotime( $registrationDate ) )."</p>";
				//}
				//else
				//{
				//	echo "<p>Registration Closed.</p>";
				//}
			?>
			<?php 
			if($_SESSION['user_id'] != "" && $_SESSION['user_type'] == 'club') 
			{
				if($currentDate >= strtotime($LiveRegDateStart) && $currentDate <= strtotime($LiveRegDateEnd) )
				{
					$myDivshow = " style='display: none;' ";
					$condition2 = " LIMIT 0,1000 ";
					$condition = "";
					if($plantype == "host_free")
					{
					  if($one_time_pay < 1){ ?>
					  
						<a href="javascript:void(0);" onclick="window.location='LivecontestForm.php?id=<?php echo $contest_id; ?>'">
							<img src="images/btn_enter_here.png" alt="" />
						</a>						
					  
					  <?php }else{ ?>
					  
						<a href="javascript:void(0);" onclick="openPopUp();">
							<img src="images/btn_enter_here.png" alt="" />
						</a>						
					  
					  <?php } ?>
						<!-- <input type="button" value=""    class="s_mybutton" name="button"> -->

						<?php
					}
					else
					{
					?>
						<!-- <input type="button" value=""    class="s_mybutton" name="button"> -->
						<a href="javascript:void(0);" onclick="window.location='LivecontestForm.php?id=<?php echo $contest_id; ?>'">
							<img src="images/btn_enter_here.png" alt="" />
						</a>
					<?php 
					}
					?>	
					<p>Registration Opened Till
					<?php $timestamp = strtotime( $LiveRegDateEnd );
					print date( 'd M, Y h:i:s A', $timestamp );?>
					</p>
					<?php 
				}
				elseif($currentDate >= strtotime($LiveRegDateEnd))
				{
					$myDivshow = " style='display: block;' ";
					$condition2 = " LIMIT 10,1000 ";
					$condition = " LIMIT 0,10 ";
					?>
					<p>Registration Period is Over.</p>
					<?php

				}
				else
				{
					?>
					<p>Registration Will Open on
					<?php $timestamp = strtotime( $LiveRegDateStart );
					print date( 'd M, Y h:i:s A', $timestamp );?>
					</p>
					<?php
				}
			}
			if($_SESSION['user_id'] != "" && $_SESSION['user_type'] == 'user') 
			{ 
				//echo strtotime($LiveRegDateStart)." ---".strtotime($LiveRegDateEnd)."----".$currentDate; die;
				if($currentDate >= strtotime($LiveRegDateStart) && $currentDate <= strtotime($LiveRegDateEnd) )
				{

					$myDivshow = " style='display: none;' ";
					$condition2 = " LIMIT 0,1000 ";
					$condition = "";
				}
				elseif($currentDate >= strtotime($LiveRegDateEnd))
				{
					$myDivshow = " style='display: block;' ";
					$condition2 = " LIMIT 10,1000 ";
					$condition = " LIMIT 0,10 ";
				}
			}
			
			if(!isset($_SESSION['user_id'])){
			  
			  $get_default_host = mysql_query("SELECT `default_host` FROM `contest` WHERE `contest_id` = '".$_GET['contid']."'");
			  $set_default_host = mysql_fetch_assoc($get_default_host);
			  
			  if(!empty($set_default_host['default_host'])){ ?>
			  
			  <a onclick="popuploginSign_notlogin('<?php echo $set_default_host['default_host']; ?>');" href="javascript:void(0);">
						<img alt="" src="images/btn_enter_here.png">
					</a>				
			  
			  <?php }else{ ?>
			  
			  <a onclick="popuploginSign();" href="javascript:void(0);">
						<img alt="" src="images/btn_enter_here.png">
					</a>			  
			  
			  <?php } ?>

			  <?php
			}
			?>
				
		  	</div>	
		</div>
		<div class="clear"></div>
		<div class="v2_contest_block_panel">
		  	<h1>Contests</h1>
		  	<div class="v2_contest_block_panel_inner">
				<ul>
					<li><a href="live_host_contests.php"><img src="images/icon_live_contest.jpg" alt="" /> Live Contest</a></li>
					<li><a href="mysitti_contestsList.php"><img src="images/icon_mysitti_contest.jpg" alt="" /> Mysitti Contest</a></li>
					<?php 
					if($_SESSION['user_type'] == "user")
					{
				?>
						<li><a href="current_host_contests.php"><img src="images/icon_host_contest.jpg" alt="" />  Host Contest</a></li>
				<?php 
					}
				?>
				</ul>
		  	</div>
		</div>
		<div class="clear"></div>
		<div class="v2_contest_block_panel v2_live_contest_block">
		  	<h1>Live Battle</h1>
	  		<div class="v2_contest_block_panel_inner">
				<ul>
					
					<?php 
						$getLiveContests = mysql_query("SELECT * FROM `contest` WHERE `contest_type` = 'live' AND `contest_status` = 'enable' ");
						if(mysql_num_rows($getLiveContests) > 0)
						{
							while($fetchLivecontest = mysql_fetch_assoc($getLiveContests))
							{
								echo "<li><a href='LiveContest.php?contid=".$fetchLivecontest['contest_id']."'>".$fetchLivecontest['contest_title']."</a></li>";
							}
						}
					?>
				</ul>
		  	</div>
		</div>
	</div>
</div>