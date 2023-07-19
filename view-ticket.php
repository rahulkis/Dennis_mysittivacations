<?php
include("Query.Inc.php");
$Obj = new Query($DBName);


$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

$titleofpage="View Ticket";
if(isset($_GET['host_id']))
{
	include('LoginHeader.php');
}
else
{
	include('HeaderHost.php');	
}


$sql_up=@mysql_query("SELECT * FROM events INNER JOIN streaming_tickets ON events.id = streaming_tickets.event_id where streaming_tickets.ticket_id='".$_GET['ticket_id']."'");
$op_shout=@mysql_fetch_assoc($sql_up);
   
   
?>      
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php	
		if($_SESSION['user_type']=='user')
		{
			include('host_left_panel.php');
		}
		else 
		{
			include('club-right-panel.php');
		}
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content v2_view_ticket">
  						<h3 id="title">View Ticket</h3>
						<ul>
					   		<li class="eventlbl">Event Name :</li>
					   			<li class="eventdesc"> 
					  			<?php echo $op_shout['eventname']; ?>
						 	</li>
					 	</ul>
			   			<ul id="adv-img">  
							<li class="eventlbl">Event Start Time :</li>
								<li class="eventdesc">
								<?php echo date('F j, Y l g:i A',strtotime($op_shout['date'])); ?>
							</li>
						</ul>
						<ul id="adv-img">  
							<li class="eventlbl">Event End Time :</li>
						<li class="eventdesc">
								<?php echo date('F j, Y l g:i A',strtotime($op_shout['event_end_date'])); ?>
							</li>
						</ul>		 
						<ul id="adv-img">  
						<li class="eventlbl"> Event Description :</li>
						   	<li class="eventdesc">
						  		<div>  <?php echo $op_shout['description']; ?></div>
					   		</li>
					 	</ul>
						<?php
						$get_data = mysql_query("SELECT * FROM events INNER JOIN streaming_tickets ON events.id = streaming_tickets.event_id INNER JOIN streaming_tickets_purchased ON events.id = streaming_tickets_purchased.event_id WHERE events.id = '".$_GET['event_id']."'");
						$count_data = mysql_num_rows($get_data);
						?>
						
						<div class="scroll_Div1" style="overflow: hidden;" tabindex="5000">
       <div class="autoscroll">
							<table id="example" class="display loadmusic" style="margin-top:10px;">
								<thead>
									<tr bgcolor="#ACD6FE">
										<th>Name</th>
										<th>Email</th>
										<th>State</th>
										<th>City</th>
										<th>Purchase Date</th>
										<th>Ticket Status</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								if($count_data < 1)
								{	
									echo '<tr><td colspan="6">No Results Found</td></tr>';
								}
								else
								{ 
									while($row = mysql_fetch_assoc($get_data))
									{
										
										$get_userdata = mysql_query("SELECT profilename, email, state, city FROM user WHERE id = '".$row['buyer_user_id']."'");
										$userdata = mysql_fetch_assoc($get_userdata);
										
										/** get city name **/
										
										$get_city = mysql_query("SELECT city_name FROM capital_city WHERE city_id = '".$userdata['city']."'");
										$cityname = mysql_fetch_assoc($get_city);
										
										/** get city name **/
										
										/** get state name **/
										
										$get_state = mysql_query("SELECT name FROM zone WHERE zone_id = '".$userdata['state']."'");
										$statename = mysql_fetch_assoc($get_state);
										
										/** get state name **/
									?>	
										<tr>
											<td><?php echo $userdata['profilename']; ?></td>
											<td><?php echo $userdata['email']; ?></td>
											<td><?php echo $statename['name']; ?></td>
											<td><?php echo $cityname['city_name']; ?></td>
											<td><?php echo date('F j, Y l h:i:s A', strtotime($row['purchase_date'])); ?></td>
											<td><?php echo $row['status']; ?></td>
										</tr>
							<?php 		} 
								} 
							?>
									

								</tbody>
							</table>	
						</div>			</div>		
					   	<div style="float:right;">
							<a href="streaming-tickets.php" class="button backmargn">Back </a>
						</div>
					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<?php include('Footer.php');?>
