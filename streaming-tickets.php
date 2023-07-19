<?php

$Obj = new Query($DBName);

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

if($_SESSION['user_type'] == "user"){
	$Obj->Redirect("profile.php");
}

if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}


if(isset($_GET['action']) && $_GET['action'] == "delete")
{
	mysql_query("DELETE FROM `streaming_tickets` WHERE `id` = '$_GET[ticket_id]' ");
	$message = "Ticket Deleted Successfully.";
}


$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="update")
	{
		$message="Ticket Updated Sucessfully";
	}
	if($para=="delete")
	{
		$message="Ticket Deleted Sucessfully";
	}
}
		
$sql_fe = mysql_query("select * from  streaming_tickets where user_id = '".$_SESSION['user_id']."' AND user_type = '".$_SESSION['user_type']."'");
$rw_row_fe = @mysql_fetch_assoc($sql_fe);

$titleofpage = "Streaming Tickets";

$userType= $_SESSION['user_type'];

$userID = $_SESSION['user_id'];
	
	/******************/
if(isset($_POST['update']))
{
	
	$ticket_id = $_POST['ticket_id'];
	$event_start_datetime = $_POST['event_start_datetime'];
	$event_end_datetime = $_POST['event_end_datetime'];
	$user_id = $_SESSION['user_id'];
	$user_type = $_SESSION['user_type'];
	$max_downloads = $_POST['max_download'];
	$event_name = $_POST['event_name'];
	$event_description = $_POST['event_description'];
	$ticket_price = $_POST['ticket_price'];
	
	$updt_ticket = mysql_query("UPDATE streaming_tickets SET ticket_price = '".$ticket_price."', event_name = '".$event_name."', event_description = '".$event_description."' , max_download = '".$max_downloads."', event_start_datetime = '".$event_start_datetime."', event_end_datetime = '".$event_end_datetime."' WHERE ticket_id = '".$ticket_id."'");
	
	if($updt_ticket == 1)
	{
		$_SESSION['update_msg'] = 'tk_updated';
		header('Location: streaming-tickets.php');
		exit;			
	}
}
	
if(isset($_POST['submit']))
{
	$ticket_id = date('YmdHis');
	$event_start_datetime = $_POST['event_start_datetime'];
	$event_end_datetime = $_POST['event_end_datetime'];
	$user_id = $_SESSION['user_id'];
	$user_type = $_SESSION['user_type'];
	$max_downloads = $_POST['max_download'];
	$event_name = mysql_real_escape_string($_POST['event_name']);
	$event_description = mysql_real_escape_string($_POST['event_description']);
	$ticket_price = $_POST['ticket_price'];

	mysql_query("INSERT INTO `streaming_tickets` (`ticket_price`, `event_name`, `event_description`, `max_download`,`event_start_datetime`,`event_end_datetime`,`user_id`,`user_type`,`ticket_id`)
	VALUES ('$ticket_price', '$event_name', '$event_description', '$max_downloads','$event_start_datetime','$event_end_datetime','$_SESSION[user_id]','$_SESSION[user_type]','$ticket_id')");
			
	$_SESSION['add_msg'] = 'added';
	$Obj->Redirect("streaming-tickets.php");
	die;
}
?>

<style>
	#couponupload_toggle{
		display: none;
	}
</style>		
<div class="clear"></div>
					<div class="v2_inner_main_content">
  						<?php
							if($_SESSION['add_msg'] == "added")
							{
								echo '<div id="successmessage" style="display: block;">Ticket Added Successfully</div> ';
								unset($_SESSION['add_msg']);
							}
							elseif ($_GET['msg'] == "imagefail") 
							{
								# code...
								echo '<div class="NoRecordsFound" id="successmessage" style="display: block;">Ticket failed to upload!</div> ';
							}
							elseif ($_GET['msg'] == "delete") 
							{
								# code...
								echo '<div id="successmessage" style="display: block;">Ticket deleted successfully</div>';
							}elseif($_SESSION['update_msg'] == 'tk_updated'){
								
								echo '<div id="successmessage" style="display: block;">Ticket updated successfully</div>';
							} ?>

						<div id="profile_box">
						<?php 
							if(isset($_GET['ticket_id']))
							{
								echo '<h3 id="title" class="">Edit Ticket</h3>';
							}
							else
							{
								echo '<h3 id="title" class="">Streaming Tickets</h3>';
							}
							
							if(isset($_GET['ticket_id']))
							{
						?>		<style>
									#couponupload_toggle{
										display: block;
									}
								</style>
						<?php
								$get_ticket_data = @mysql_query("SELECT * FROM streaming_tickets WHERE id = '".$_GET['ticket_id']."'");
								$get_ticket_edit_data = mysql_fetch_assoc($get_ticket_data);
						 	}
						 ?>
							<div id="couponupload_toggle">
								<form id="ticketupload" name="add_adv" method="post">
						                                	<div class="row" id="img-link">
						                                		<span class="label" style="font-size:16px;font-weight:bold">Event Name:</span>
						                                		<span class="formw">
											<?php if(!empty($get_ticket_edit_data['event_name'])){ ?>
											
												<input name="event_name" id="event_name" type="text" value="<?php echo $get_ticket_edit_data['event_name']; ?>"/>
											
											<?php }else{ ?>
											
												<input name="event_name" id="event_name" type="text" />
												
											<?php } ?>									

										</span>
                                							</div>
									<div class="row" id="img-link">
										<span class="label" style="font-size:16px;font-weight:bold">Event Description:</span>
										<span class="formw">
										<?php if(!empty($get_ticket_edit_data['event_description'])){ ?>

										<textarea name="event_description" id="event_description"><?php echo $get_ticket_edit_data['event_description']; ?></textarea>

										<?php }else{ ?>

										<textarea name="event_description" id="event_description"></textarea>

										<?php } ?>									

										</span>
									</div>								
									<div class="row" id="img-link">
										<span class="label" style="font-size:16px;font-weight:bold">Maximum Downloads:</span>
										<span class="formw">
										<?php if(!empty($get_ticket_edit_data['max_download'])){ ?>

										<input name="max_download" id="max_download" type="text" value="<?php echo $get_ticket_edit_data['max_download']; ?>"/>

										<?php }else{ ?>

										<input name="max_download" id="max_download" type="text" />

										<?php } ?>									

										</span>
									</div>
									<div class="row" id="img-link">
										<span class="label" style="font-size:16px;font-weight:bold">Ticket Price:</span>
										<span class="formw">
										<?php if(!empty($get_ticket_edit_data['ticket_price'])){ ?>

										<input name="ticket_price" id="ticket_price" type="text" value="<?php echo $get_ticket_edit_data['ticket_price']; ?>"/>

										<?php }else{ ?>

										<input name="ticket_price" id="ticket_price" type="text" />

										<?php } ?>									

										</span>
									</div>
									<div class="row"  id="adv-img">
										<span class="label" style="font-size:16px;font-weight:bold">Start Time:</span>
										<span class="formw">
										<?php if(!empty($get_ticket_edit_data['event_start_datetime'])){ ?>

										<input type="text" id="event_start_datetime" name="event_start_datetime" readonly class="dtpicker" value="<?php echo $get_ticket_edit_data['event_start_datetime']; ?>">

										<?php }else{ ?>

										<input type="text" id="event_start_datetime" name="event_start_datetime" readonly class="dtpicker">

										<?php } ?>
										</span>
									</div>
									<div class="row"  id="adv-img">
										<span class="label" style="font-size:16px;font-weight:bold">End Time:</span>
										<span class="formw">
										<?php if(!empty($get_ticket_edit_data['event_end_datetime'])){ ?>

										<input type="text" id="event_end_datetime" name="event_end_datetime" readonly class="dtpicker" value="<?php echo $get_ticket_edit_data['event_end_datetime']; ?>">

										<?php }else{ ?>

										<input type="text" id="event_end_datetime" name="event_end_datetime" readonly class="dtpicker">

										<?php } ?>
										</span>
									</div>
									<ul class="btncenter_new">

										<?php if(!empty($get_ticket_edit_data['ticket_id'])){ ?>

										<li>
										<input type="hidden" value="<?php echo $get_ticket_edit_data['ticket_id']; ?>" name="ticket_id">
										<input class="button"  style="float:none" name="update" type="submit" value="Update" /> &nbsp;&nbsp;&nbsp;
										</li>
										<li><input class="button" onclick="location.href='streaming-tickets.php'" style="float:none" type="button" value="Cancel" /> &nbsp;&nbsp;&nbsp;</li>

										<?php }else{ ?>

										<li><input class="button"  style="float:none" name="submit" type="submit" value="Upload" /> &nbsp;&nbsp;&nbsp;</li>
										<li><input class="button" onclick="toggle_add_pass();" style="float:none" type="button" value="Cancel" /> &nbsp;&nbsp;&nbsp;</li>

										<?php } ?>
									</ul>                               
                                						</form>
							</div>
						</div>
						
						<?php
							$get_passes = mysql_query("SELECT * FROM events INNER JOIN streaming_tickets ON events.id = streaming_tickets.event_id WHERE events.host_id = '".$_SESSION['user_id']."'");
							$count_passes = mysql_num_rows($get_passes);
						?>	
 
      <div class="autoscroll">
							<table id="example" class="display loadmusic host_cp_table" style="margin-top:10px;">
								<thead>
									<tr bgcolor="#ACD6FE">
										<th>Event Name</th>
										<th>Event Start Time</th>
										<th>Event End Time</th>
										<th>Max. Downloads</th>
										<th>Action</th>
										<!--<th>View Details</th>-->
									</tr>
								</thead>
								<tbody>
									<?php if($count_passes < 1){ ?>
									
										<tr>
											<td colspan="5">
												No Tickets Found
											</td>
										</tr>
									
									<?php 	}
										else
										{
										
										$i=1;
										while($row = mysql_fetch_assoc($get_passes))
										{
											
											if($i%2 == '0')
											{
												$class = " class='even' ";
											}
											else
											{
												$class = " class='odd' ";
											}												
										
										?>
									
											<tr <?php echo $class;?>>
												<td><?php echo $row['eventname']; ?></td>
												<td><?php echo date('F j, Y l h:i:s A', strtotime($row['date'])); ?></td>
												<td><?php echo date('F j, Y l h:i:s A', strtotime($row['event_end_date'])); ?></td>
											<td><?php echo $row['max_download']; ?></td>
												<td>
													<a href="view-ticket.php?ticket_id=<?php echo $row['ticket_id']; ?>&event_id=<?php echo $row['event_id']; ?>">View Ticket</a>
													<!--<img onclick="delete_coupon('<?php echo $row['id'];  ?>');" style="cursor: pointer;" src="images/del.png" width="25px" title="Delete" height="25px">-->
												</td>
												<!--<td><a href="pass_detail.php?p_id=<?php echo $row['id'];  ?>">View Ticket Details</a></td>												-->
											</tr>										
									
						<?php 					$i++; 
										}
									} 
						?>
								</tbody>
							</table>
						</div> 
  					</div>
			<div class="equalizer"></div>

<script type="text/javascript">
function toggle_add_pass(){
	
	$('#couponupload_toggle').toggle();
}	
	
function delete_coupon(id){
	
	if (id == "") {
		alert("Please create a coupon first");
	}else{
		
			var r = confirm("Are you sure want to delete!");
			if (r == true) 
			{
				window.top.location = "streaming-tickets.php?action=delete&ticket_id="+id;
			} 
			else
			{
				return false;
			}			
	}
}
</script>