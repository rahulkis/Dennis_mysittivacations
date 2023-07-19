<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

$titleofpage="My Calendar";
    
include('NewHeadeHost.php');

?>
<script type="text/javascript">
function fullForum(fid)
{
	window.open('read_more_cityevent.php?id='+fid,'','width=500,height=700,resizable=true,left=400,top=0');return false;
}

function removeEvent(fid)
{
	if(confirm("Are you sure want to delete this event ?"))
	{
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: 	{
					'action' : 'removeEvent', 
					'forumID' : fid, 
					// 'user_id' : user_id
				},
			success: function(data){
				alert(data);
				location.reload(true);
			}
		});
	}
	else
	{
		return false;
	}
}


</script>

<?php 
$message = "";
if(isset($_POST['submit']))
{
	
	$no_of_hours = $_POST['no_of_hours'];
	$success = mysql_query("UPDATE `user` SET `reminderhours` = '$no_of_hours' WHERE `id` = '$_SESSION[user_id]' ");
	if($success)
	{
		$message = '<div  id="successmessage" class="message">Reminder Time Updated successfully.</div>';
	}
}	

?>


<style type="text/css">
.tooltip span { font-weight: normal;}
.tooltip span b{ font-weight: bold;}

span.backtoToday {
    float: right;
    font-size: 12px;
    width: 20%;
}


</style>

<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
		<?php include('friend-right-panel.php');	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
       <div class="CalenderBox">
  						<?php 
							if($message != "")
							{
								echo $message;
							}
							$currmonth = date('m');
							$curryear = date('Y');
							?>
							<h3 class="title_h2" id="title"><span class="title_cal">Calendar </span>
								<?php if(isset($_GET['month'])){?>
										<span class="backtoToday"><a class="" href="myCalendar.php"><img title="Back to Today" src="images/cal_back.png" alt="" class="back_month" /></a></span>
								<?php } ?>
							</h3>
							<?php   
							$userID=$_SESSION['user_id'];  
							function draw_calendar($month,$year,$events = array())
							{
								//echo "<pre>"; print_r($events); die;
								/* draw table */
									$calendar = '<table cellpadding="0" cellspacing="0" class="calendar" style="width:100%;">';

								/* table headings */
									$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
									$calendar.= '<tr class="calendar-row first-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

								/* days and weeks vars now ... */
									$running_day = date('w',mktime(0,0,0,$month,1,$year));
									$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
									$days_in_this_week = 1;
									$day_counter = 0;
									$dates_array = array();

								/* row for week one */
									$calendar.= '<tr class="calendar-row">';

								/* print "blank" days until the first of the current week */
									for($x = 0; $x < $running_day; $x++):
									$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
									$days_in_this_week++;
									endfor;

									/* keep going with days.... */
									for($list_day = 1; $list_day <= $days_in_month; $list_day++):
									$calendar.= '<td class="calendar-day"><div style="position:relative;">';
									/* add in the day number */
									$calendar.= '<div class="day-number">'.$list_day.'</div>';



									if($list_day < 10 )
									{
										$list_day = "0".$list_day;
									}
									else
									{
										$list_day = $list_day;
									}

									$event_day = $year.'-'.$month.'-'.$list_day;
			// 						echo "<pre>";   
			// 						print_r($events);
			// exit;
								if(isset($events[$event_day]))
								{
									$i=0;$userType= $_SESSION['user_type'];
									foreach($events[$event_day] as $key=>$event) 
									{
										foreach($event as $event)
										{
											$stringlocation = (strlen($event['forum']) > 6) ? substr($event['forum'],0,10).'...' : $event['forum'];
											$evntdate=date('g:i A',strtotime($event['event_date'])); 

											if($userType=="user")
											{
												if($i<2)
												{
													
													$calendar.= "<a class='tooltip' href='javascript:void(0);'>".$stringlocation."
													<span class='event'><b>Event Name: </b>".$event['forum']."</br><b>Event Time: </b>".$evntdate."<br/><br/><p class='readMore' onclick='fullForum(".$event[forum_id].");'><b>Read More</b></p>&nbsp;&nbsp;<p class='removeEvent' onclick='removeEvent(".$event[forum_id].");'><b>Remove</b></p></span> </a><br /><br />";

												}
												if($i==2)
												{
													$calendar.="<a class='read_mor' href=''>View all</a>";
												}

											}
										}
										
										$i++;
									}
								}
								else 
								{
									$calendar.= str_repeat('<p>&nbsp;</p>',2);
								}
								$calendar.= '</div></td>';
								if($running_day == 6):
									$calendar.= '</tr>';
								if(($day_counter+1) != $days_in_month):
									$calendar.= '<tr class="calendar-row">';
								endif;
								$running_day = -1;
								$days_in_this_week = 0;
								endif;
								$days_in_this_week++; $running_day++; $day_counter++;
								endfor; 

								/* finish the rest of the days in the week */
								if($days_in_this_week < 8):
								for($x = 1; $x <= (8 - $days_in_this_week); $x++):
								$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
								endfor;
								endif;

								/* final row */
								$calendar.= '</tr>';


								/* end the table */
								$calendar.= '</table>';

								/** DEBUG **/
								$calendar = str_replace('</td>','</td>'."\n",$calendar);
								$calendar = str_replace('</tr>','</tr>'."\n",$calendar);

								/* all done, return result */
								return $calendar;
							}

							function random_number() 
							{
								srand(time());
								return (rand() % 7);
							}

								/* date settings */
							$month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
							$year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));

							/* select month control */
							$select_month_control = '<select name="month" id="month">';
							for($x = 1; $x <= 12; $x++) {
							if($x < 10)
							{
							$x = "0".$x;
							}
							$select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
							}
							$select_month_control.= '</select>';

							/* select year control */
							$year_range = 7;
							$select_year_control = '<select name="year" id="year">';
							for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
							$select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
							}
							$select_year_control.= '</select>';

							if(isset($_GET['month']))
							{
							$month = "0".$_GET['month'];
							}
							else
							{
							$month = date('m');

							}



								/* "next month" control */
							$userType= $_SESSION['user_type'];
							if($userType=="club"){
							$next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control calendarright"><img src="images/arrow_right_black.png" alt="" /></a>';

							/* "previous month" control */
							$previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control"><img src="images/arrow_left_black.png" alt="" /></a>';
							} else if($userType=="user"){
							$next_month_link = '<a href="?host_id='. $hostID.'&month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control"><img src="images/arrow_right_black.png" alt="" /></a>';

							/* "previous month" control */
							$previous_month_link = '<a href="?host_id='. $hostID.'&month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control"><img src="images/arrow_left_black.png" alt="" /></a>';


							}

							/* bringing the controls together */
							$controls = '<form id="calendarhead" method="get">'.$previous_month_link.'<h2 class="monthhead">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h2>'.$next_month_link.' </form>';

							/* get all events for the given month */
							$new_events = array();
							$bookings = array();

							$query = "SELECT * FROM `forum` as f, `user_events` as uv WHERE uv.forum_id = f.forum_id AND uv.uid = $_SESSION[user_id] AND month(event_date) = '$month' AND year(event_date) = '$year' ";

							$result = mysql_query($query) or die('cannot get results!');
							while($row = mysql_fetch_assoc($result)) 
							{
								$d = date('Y-m-d',strtotime($row['event_date']));
								$new_events[$d]['forum'][] = $row;
							}
			// echo "<pre>"; print_r($new_events); die;
							$events =$new_events;
							

							echo '<div id="bigcalendar" style="float:left; width: 99.75%; border-bottom: none;">'.$controls.'</div>';
							echo '<div style="clear:both;"></div>';
							echo draw_calendar($month,$year,$events);
							echo '<br /><br />';
			        			?>
					
							<?php 

							$getuserhours = mysql_query("SELECT `reminderhours` FROM `user` WHERE `id` = '$_SESSION[user_id]' ");
							$fetchuserhours = mysql_fetch_array($getuserhours);


							?>
								<!-- EVENTS CALENDAR ENDS --> 	
						   	<script src='js/jqueryvalidationforsignup.js'></script>
							<script src="js/register.js" type="text/javascript"></script> 
						           	<div class="addtion_info">
						                	<h3 id="title" style="margin-top:20px;">Reminder Settings</h3>
					                		<form method="POST" action="" id="setCalendar">	
									 <label>Number of Hours</label>
						                    		<div>
						                    			<input type="text"  name="no_of_hours" value="<?php if($fetchuserhours['reminderhours'] == 0){ echo "24";}else{ echo $fetchuserhours['reminderhours'];}?>" placeholder="# of Hours"/>
					                    			</div>
						            			<div>
						            				<input class="button" type="submit" name="submit" value="Save" />
						            			</div>
						                	</form>
						             </div>
  					</div>
       </div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>

<?php
include('Footer.php');
?>