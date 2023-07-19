<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage = "Calendar Events";
include('NewHeadeHost.php');

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("index.php");
}

include 'googleplus-config.php';
?>
<style>
span.formw {
	float: right;
	text-align: left;
	width: 480px;
}
div.row {
	clear: both;
	padding-top: 5px
}
</style>
<?php
if(isset($_GET['host_id']))
{
	$hid = $_GET['host_id'];
}
else
{
	$hid = $_SESSION['user_id'];
}

$date = $_GET['date'];
$eventsArray = array();
$bookingsArray = array();
$i=0;
$y=0;

$get_ev_date = explode("-", $date);

$year = $get_ev_date[0];
$month = $get_ev_date[1];
$day = $get_ev_date[2];

if($_GET['action'] == "event")
{
	$geteventstodisplay = @mysql_query("SELECT `events`.*, `events`.`id` as eventid  FROM `events` WHERE `host_id` = '$hid'  AND month(date) = '$month' AND year(date) = '$year' AND day(date) =  '$day'");
	while($fetchevents = @mysql_fetch_array($geteventstodisplay))
	{
		$eventsArray[$i]['eventid'] =  $fetchevents['eventid'];
		$eventsArray[$i]['eventdate'] = $fetchevents['date'];
		$eventsArray[$i]['eventname'] = $fetchevents['eventname'];
		$eventsArray[$i]['description'] = $fetchevents['description'];
		$eventsArray[$i]['city_id'] = $fetchevents['city_id'];
		$eventsArray[$i]['state_id'] = $fetchevents['state_id'];
		$eventsArray[$i]['type'] = "Event";
		$i++;
	}
	$allArray = $eventsArray; 
}
elseif($_GET['action'] == "booking")
{
	$getbookingstodisplay = @mysql_query("SELECT `bookings`.*, `bookings`.`id` as bookingid  FROM `bookings` WHERE `requeted_date` = '$date'  AND `host_id` = '$hid' AND `status` IN ('Accept', 'Confirm', 'Done') ");
	while($fetchbookings = @mysql_fetch_array($getbookingstodisplay))
	{
		$bookingsArray[$y]['eventid'] =  $fetchbookings['bookingid'];
		$bookingsArray[$y]['eventdate'] = $fetchbookings['requeted_date'];
		$bookingsArray[$y]['eventname'] = $fetchbookings['book_type'];
		$bookingsArray[$y]['description'] = $fetchbookings['special_request'];
		$bookingsArray[$y]['type'] = "Booking";
		$y++;
	}
	$allArray = $bookingsArray; 
}
else
{
	$geteventstodisplay = @mysql_query("SELECT `events`.*, `events`.`id` as eventid  FROM `events` WHERE `host_id` = '$hid' AND month(date) = '$month' AND year(date) = '$year' AND day(date) =  '$day'   ");
	while($fetchevents = @mysql_fetch_array($geteventstodisplay))
	{
		$eventsArray[$i]['eventid'] =  $fetchevents['eventid'];
		$eventsArray[$i]['eventdate'] = $fetchevents['date'];
		$eventsArray[$i]['eventname'] = $fetchevents['eventname'];
		$eventsArray[$i]['description'] = $fetchevents['description'];
		$eventsArray[$i]['city_id'] = $fetchevents['city_id'];
		$eventsArray[$i]['state_id'] = $fetchevents['state_id'];
		$eventsArray[$i]['type'] = "Event";
		$i++;
	}
	$getbookingstodisplay = @mysql_query("SELECT `bookings`.*, `bookings`.`id` as bookingid  FROM `bookings` WHERE `requeted_date` = '$date' AND `host_id` = '$hid' AND `status` IN ('Accept', 'Confirm', 'Done')  ");
	while($fetchbookings = @mysql_fetch_array($getbookingstodisplay))
	{
		$bookingsArray[$y]['eventid'] =  $fetchbookings['bookingid'];
		$bookingsArray[$y]['eventdate'] = $fetchbookings['requeted_date'];
		$bookingsArray[$y]['eventname'] = $fetchbookings['book_type'];
		$bookingsArray[$y]['description'] = $fetchbookings['special_request'];
		$bookingsArray[$y]['type'] = "Booking";
		$y++;
	}
	$allArray = array_merge($eventsArray,$bookingsArray);   
}
function cmp($a, $b)
{
	return strcmp($a["eventid"], $b["eventid"]);
}
usort($allArray, "cmp");

$message = "";
if(isset($_GET['msg']))
{
	if($_GET['msg'] == 'Success')
	{
		$message = "Record Deleted Successfully.";
	}
	else
	{
		$message = "Record Not able to delete! Please try again.";
	}
}
?> 
<script type="text/javascript">
function deleterecords(type,id)
{
	var dd = '<?php echo $_GET["date"];?>';
	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'type' : type, 
			'id' : id,
			'action' : 'calendarevents' ,
		},
		success: function( msg ) 
		{
			window.location = 'viewDateEvents.php?date='+dd+'&msg='+msg;
		}
	});
}
</script>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   
		if(isset($_GET['host_id']) && $_SESSION['user_type'] == "club")
		{
			include('club-right-panel.php');	
		}
		else
		{ 
			include('host_left_panel.php');
		} 
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title">Upcoming Events</h3>
						<?php 
						if($message!= "")
						{ 
							echo '<div style="display:block;" id="successmessage" class="message" >'.$message."</div>";
						}
					?>
						<div id="demosss">
							<div class="upcomin_venue_div">
								<div style="margin: 0px auto; width: 100%; text-align: center;">
							<? 
								if($userType=="club")
								{
							?>		<span style="float: right; margin-top:5px; margin-left:10px; ">
										<a href="addevent.php?date=<?php echo $_GET['date']; ?>" class="button btn_add_venu">Add Event</a>
									</span>
									<span style="float: right; margin-top:5px; ">
										<a href="bookings.php?date=<?php echo $_GET['date']; ?>" class="button btn_add_venu">My Bookings</a>
									</span>
							<?	}
								else
								{
									$checkpagestatus = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_GET['host_id']."' ");
									$respagestatus = @mysql_fetch_array($checkpagestatus);
									if($respagestatus['booking'] == 'Enable')
									{
							?>			<span style="float: right; margin-top:5px; ">
											<a href="bookme.php?host_id=<?php echo $_GET['host_id']; ?>&date=<?php echo $_GET['date']; ?>" class="button btn_add_venu">Make Booking</a>
										</span>
						<?php 			}
								}
						?>
								</div>
				<?php 				$numResults = count($allArray);	?>
								<div id="listvenue_tab">
						<?php
								if($numResults > 9)
								{
									$class = " class='scroll_Div1 tab_scroll'";
								}
								else
								{
									$class= "class='scroll_Div1no tab_scroll'";
								}
					   ?>
									<div <?php echo $class;?>>

										<table class='display loadmusic'  style='' >
											<thead>
												<tr>
													<th>Date</th>
													<th>Description</th>
													<th>City, State</th>
													<th>Type</th>
													<?php if($_SESSION['user_type'] == "club"){?>
													<th>Action</th>
													<?php } ?>
												</tr>
											</thead>
											<tbody>
										<?php 
										if($numResults > 0)
										{
											foreach ($allArray as $k)
											{
								?>
												<tr>
													<td><?php echo $k['eventdate'];?></td>
													<td><?php echo substr($k['description'],0,200);?></td>
													<?php
													if($k['type'] == 'Event')
													{
															$getCityinfo = mysql_query("SELECT `city_name` FROM `capital_city` WHERE `city_id` = '$k[city_id]' ");
															$fetchCityinfo = mysql_fetch_array($getCityinfo);

															$getStateinfo = mysql_query("SELECT `name`,`code` FROM `zone` WHERE `zone_id` = '$k[state_id]' ");
															$fetchStateinfo = mysql_fetch_array($getStateinfo);

															$location = $fetchCityinfo['city_name'].", ".$fetchStateinfo['name'];
														   }
														   else
														   {
															$location = "NA";
														   }
														   ?>
														   <td>
															<?php echo $location; ?>
														   </td>
													<td><?php echo $k['type'];?></td>
													<?php if($_SESSION['user_type'] == "club"){?>
													<td>
														<?php 
														if($k['type'] == 'Event')
														{
															$anchor = "editevent.php?edit=".$k['eventid'];
															$delete =  'event';
														}
														else
														{
															$anchor = "bookings.php?page=edit&id=".$k['eventid'];
															$delete =  'booking';
														}
										?>

														<a href="<?php echo $anchor;?>"> <img width="25px" height="25px" src="images/Edit.png"></a>
																&nbsp;<a onclick="deleterecords('<?php echo $delete; ?>','<?php echo $k[eventid]; ?>');" href="javascript:void(0);"><img width="25px" height="25px" src="images/del.png"></a>
													</td>
													<?php } ?>
												</tr>
								<?php 			}
										}
										else
										{
											echo "<tr><td colspan='5'>No Records Found!</td></tr>";
										}
								?>
											</tbody>
										</table>
									</div>
								</div>	<!-- END #listvenue_tab -->
							</div>
						</div> <!-- END #demoss -->
				<?php 
						if($_SESSION['user_type'] == 'club')
						{
							echo '<div style="float:right;">
							<a href="home_club.php" class="button backmargn">Back </a>
							</div>';	
						}
						else
						{
							echo '<div style="float:right;">
							<a href="host_profile.php?host_id='.$_GET[host_id].'" class="button backmargn">Back </a>
							</div>';
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

<?php include('Footer.php'); ?>