<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if(isset($_POST['set_transfer_ticket']))
{
	$updt = mysql_query("UPDATE paid_pass_download SET transferred_to = '".$_POST['friend_id']."' WHERE pd_id = '".$_POST['pass_id']."'");

	$ticket_added_on = date('Y-m-d h:i:s');
	$c_identifier = "shared_ticket_".$_POST['pass_id'];
							
	mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$_POST['friend_id']."', 'shared_ticket', '".$ticket_added_on."', '1', '".$c_identifier."', '".$_SESSION['user_type']."', 'user')");
	
	if($updt == 1)
	{
		echo "done";
	}
	die;
}
$titleofpage="Puchased Tickets";
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("index.php"); die;
}

include('NewHeadeHost.php'); 
if(isset($_GET['pass_type']) && $_GET['pass_type'] == 'paid')
{

	$host_id = $_GET['host_id'];
	$user_id = $_SESSION['user_id'];
	$user_type = $_SESSION['user_type'];
	$payment_date = date('Y-m-d H:i:s');
	$today_date = date('Y-m-d');
	$passID = $_GET['passid'];
	$no_of_tickets = $_GET['no_of_tickets'];
	$getPassinfo = mysql_query("SELECT * FROM `paid_passes` WHERE `pass_id` = '$passID' ");
	$fetchPassinfo = mysql_fetch_assoc($getPassinfo);
	$lastCountTickets = $fetchPassinfo['no_of_tickets'];
	$newCountTickets = $lastCountTickets - $no_of_tickets;
	mysql_query("UPDATE `paid_passes` SET `no_of_tickets` = '$newCountTickets' WHERE `pass_id` = '$passID' ");
	for($i=1;$i<=$no_of_tickets;$i++)
	{
		$barcode = "h$".$host_id."-u$".$user_id."-p$".$passID."-".mt_rand();
		mysql_query("INSERT INTO `paid_pass_download` (`host_id`,`user_id`,`pass_id`,`barcode`) VALUES ('$host_id','$user_id','$passID','$barcode') ");
	}
	$_SESSION['puchasemessage'] = "You have successfully purchased the ticket.";
	unset($_SESSION['puchasemessage']);
	$Obj->Redirect('successPurchase.php');
	die;
}

$getpuchasedTickets = mysql_query("SELECT * FROM `paid_passes` as pp, `paid_pass_download` as ppd WHERE `pp`.`pass_id` = `ppd`.`pass_id` AND `ppd`.`user_id` = '$_SESSION[user_id]' ORDER BY `pp`.`expiry_date` ASC");
$countPasses = mysql_num_rows($getpuchasedTickets);

$gettransferredTickets = mysql_query("SELECT * FROM `paid_passes` as pp, `paid_pass_download` as ppd WHERE `pp`.`pass_id` = `ppd`.`pass_id` AND `ppd`.`transferred_to` = '$_SESSION[user_id]' ORDER BY `pp`.`expiry_date` ASC");
$countPasses = mysql_num_rows($gettransferredTickets);

$main_arr = array();
$main_arr1 = array();
$main_arr2 = array();

while($gpt = mysql_fetch_assoc($getpuchasedTickets)){
	
	$main_arr1[] = $gpt;
	
}

while($gtt = mysql_fetch_assoc($gettransferredTickets)){
	
	$main_arr2[] = $gtt;
	
}

	if(!empty($main_arr1) && empty($main_arr2)){
		
		$main_array[] = $main_arr1;
		
	}elseif(empty($main_arr1) && !empty($main_arr2)){
		
		$main_array[] = $main_arr2;
		
	}else{
		
		$main_array[] = array_merge($main_arr1, $main_arr2);
		
	}
?>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 
		include('friend-right-panel.php');
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<?php 
							if(!empty($_SESSION['puchasemessage']))
							{
								echo '<div id="error" class="successmessage" style="">'.$_SESSION['puchasemessage'].'</div> ';
								unset($_SESSION['puchasemessage']);
							}
							
							if(isset($_SESSION['event_ticket_redeemed'])){
								echo '<div id="error" class="successmessage" style="">'.$_SESSION['event_ticket_redeemed'].'</div> ';
								unset($_SESSION['event_ticket_redeemed']);
							}
						?>
						<div class="profile_box">
							<h3 class="" id="title">Purchased Tickets</h3>
						</div>
						<div class="autoscroll2">
							<table style="margin-top:10px;" class="display loadmusic host_cp_table " id="example">
								<thead>
									<tr bgcolor="#ACD6FE" style="background-color: rgb(254, 205, 7);">
										<th>Event Name</th>
										<th>Event Time</th>
										<th>Amount</th>
										<th>Expiry Date</th>
										<th>Status</th>
										<th>Barcode</th>
										<th>Transfer Ticket</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$current_date = date('Y-m-d H:i:s');
								if(count($main_array[0]) > 0)
								{
									foreach($main_array[0] as $result)
									{
										
										if($result['expiry_date'] >= $current_date)
										{
										
										$getEventInfo = mysql_query("SELECT * FROM `forum` WHERE `event_id` = '$result[event_id]'  ");
										$fetchEventInfo = mysql_fetch_assoc($getEventInfo);
										?>
											<tr>
												<td>
													<?php echo $fetchEventInfo['forum']; ?>
												</td>
												<td>
													<?php echo date('F j, Y l h:i:s A', strtotime($fetchEventInfo['event_date'])); ?>
												</td>
												<td>
													<?php  

														echo "$".trim(str_replace('$','',$result['amount']));
														
													 ?>
												</td>
												<td>
													<?php echo date('F j, Y l h:i:s A', strtotime($result['expiry_date'])); ?>
												</td>
												<td>
													<?php 
														$date = strtotime(date('Y-m-d H:i:s'));
														$date2 = strtotime($result['expiry_date']);
														if($date < $date2)
														{
															echo "Active";
														}
														else
														{
															echo "Expired";
														}
													?>
												</td>
												<td>
													<a href="javascript:void(0);" onclick="popupbarcode('<?php echo $result['pass_id']; ?>','<?php echo $result['host_id'];?>','<?php echo $_SESSION['user_id'];?>','<?php echo $result['pd_id']; ?>');">
														<img src="images/barcode_default.png" alt="Barcode" />
													</a>
												</td>
												<td>
													<?php
													if($result['status'] == "redeemed"){
														
														echo "Already Redeemed";
														
													}else{
														
																	if($_SESSION['user_id'] == $result['transferred_to']){
																		
																		$get_user_name = mysql_query("SELECT email FROM user WHERE id = '".$result['user_id']."'");
																		$t_username = mysql_fetch_assoc($get_user_name);
																		
																		echo "Got Ticket From ".$t_username['email'];
																		
																	}else{
																		
																		if($result['user_id'] == $_SESSION['user_id'] && $result['transferred_to'] != "0"){
																			
																		$get_user_name = mysql_query("SELECT email FROM user WHERE id = '".$result['transferred_to']."'");
																		$t_username = mysql_fetch_assoc($get_user_name);
																		
																			echo "Ticket Transferred To ".$t_username['email'];
																		
																		}else{ ?>
																		
																			<select name="share_ticket" onchange="transfer_to(this.value);">
																				<option value="">-- Transfer to --</option>
																				<?php
																				$frnd_list = mysql_query("select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs where fs.user_id='".$_SESSION['user_id']."' AND fs.friend_id != 1 AND fs.friend_type = 'user' AND fs.status IN ('active','block') GROUP BY friend_id ORDER BY id ASC");
																				$get_curr_em = mysql_query("SELECT email FROM user WHERE id = '".$_SESSION['user_id']."'");
																				$uem_get = mysql_fetch_assoc($get_curr_em);
						
																				while($get_frnd_list = mysql_fetch_assoc($frnd_list)){
																					
																					$get_frnd_name = mysql_query("SELECT email, first_name, last_name, profilename FROM user WHERE id = '".$get_frnd_list['friend_id']."'");
																					$friend_name = mysql_fetch_assoc($get_frnd_name);
																						
																						$fr_name = $friend_name['email'];
																						
																						if(!empty($fr_name) && $uem_get['email'] != $fr_name){
																				?>
																				
																							<option <?php if($result['transferred_to'] == $get_frnd_list['friend_id']){ echo "selected"; } ?> value="<?php echo $result['pd_id']; ?>friend<?php echo $get_frnd_list['friend_id']; ?>"><?php echo $fr_name; ?></option>
																				
																				<?php
																						}
																				}
																				?>
																			
																			</select>
																		
																		<?php } ?>
				
																	<?php
																	}														
														
													}
													
													

													?>
												</td>
											</tr>
										<?php
										}
									}
									
								}
								else
								{
									echo "<tr><td colspan='7'>No Passes Found</td></tr>";
								}
								?>
								</tbody>
							</table>
						</div>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">
function popupbarcode(passid,hostid,userid,pdid)
{
	url = 'barcodeGet.php?host_id='+hostid+'&user_id='+userid+'&pass_id='+passid+'&pd_id='+pdid+'&ticket=147b6b98b0b5715a7b01a447a3cc5113';
	window.open(url,'1396358792239','width=500,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=500,top=200');
	return false;
}

function transfer_to(val){
	
	var frnd = val.split('friend');
	
	if (frnd[1] != "" && frnd[0] != "") {

		var r = confirm("Are you sure want to transfer ticket !");
		if (r == true) {

					$.blockUI({ css: {
						border: 'none', 
						padding: '15px', 
						backgroundColor: '#000', 
						'-webkit-border-radius': '10px', 
						'-moz-border-radius': '10px', 
						opacity: .5, 
						color: '#fff' 
					} });
					
					jQuery.post('successPurchase.php', {'set_transfer_ticket': 'set_transfer_ticket', 'friend_id': frnd[1], 'pass_id': frnd[0]}, function(response){
						
						if (response == 'done') {
							
							setTimeout(function() { 
								$.unblockUI({ 
									onUnblock: function(){
										alert("Ticket Transferred");
										window.location.href = '';
									} 
								}); 
							}, 2000);
							
						}
						
						
						
					});
			 
					
    
		}
	}
	
}
</script>
<?php include('Footer.php'); ?>