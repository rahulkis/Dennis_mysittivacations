<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="admin_app")
	{
		$message="Your Forum Posted Sucessfully";
	}
}
$titleofpage="Notifications";

/* HEADER CONDITION CODE */


if(isset($_POST['deleteAll']))
{
	foreach ($_POST['ids'] as $id) 
	{
		mysql_query("DELETE FROM `user_notification` WHERE `id` = '$id' ");	
	}
	
	$deleteallmessage = "Notifications Deleted.";
}



if(isset($_SESSION['user_id']))
{
	// include('LoginHeader.php');
	include('NewHeadeHost.php');
}
else
{
	include('Header.php');	
}

/* END HEADER CODE */

?>
<style type="text/css">
	
.v2_banner_top .v2_header_wrapper{
	    overflow: visible;
	    padding-top: 0 !important;
}
.v2_banner_top .v2_header_host {
    margin-top: 47px;
}
</style>
<div class="clear"></div>

<div class="v2_container">
	<div class="v2_inner_main">
	<!--  SIDEBAR CODE -->
		<?php 
			if(!isset($_SESSION['user_id']))
			{
				include('hotSpotsSidebar.php');
			}
			else
			{
				if($_SESSION['user_type'] == 'user')
				{
					include('friend-right-panel.php');
				}
				elseif($_SESSION['user_type'] =="club")
				{
					include('club-right-panel.php');
				}
			}
			$to_user_notifications = mysql_query("SELECT * FROM user_notification WHERE to_user_type = '".$_SESSION['user_type']."' AND to_user = '".$_SESSION['user_id']."' AND type != 'friend_request_accept' ORDER BY id DESC");
	
			$from_user_notifications = mysql_query("SELECT * FROM user_notification WHERE from_user_type = '".$_SESSION['user_type']."' AND from_user = '".$_SESSION['user_id']."' AND type = 'friend_request_accept' ORDER BY id DESC");
			
			$to_user_count = mysql_num_rows($to_user_notifications);
			$from_user_count = mysql_num_rows($from_user_notifications);
			
			$notifications_count = $to_user_count + $from_user_count;
		?>
	<!--  SIDEBAR CODE END -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
					<form method="POST" action="">
						<h3 id="title"> Notifications
      				<?php
					if($notifications_count > 0)
					{
				?>
					<div class="deleteallbutton">
						
							<input type="submit" name="deleteAll" value="Delete All" class="button btn" />
						
					</div>
				<?php 	}	?></h3>
						<?php 
							if(isset($deleteallmessage) && !empty($deleteallmessage))
							{
								echo 	'<div style="display:block;" id="successmessage" class="message" >'.$deleteallmessage.'</div>';
							}
							elseif($notifications_count < 1)
							{
								echo 	'<div style="display:block;" class="NoRecordsFound" class="message" >No Notifications.</div>';
							}
						?>
	
<script type="text/javascript">
$(document).ready(function(){
	$('#selectAll').click(function(){

		if($(this).is(':checked'))
		{
			//alert('ddfdd');
			$('.showAllNotification li').each(function(){
				$(this).find('input').attr('checked', true);
			});
		}
		else
		{
			$('.showAllNotification li').each(function(){
				$(this).find('input').attr('checked', false);
			});
		}
		
	});
});
	
</script>

<?php
  if(isset($_GET['notification'])){
	
	  mysql_query("DELETE FROM user_notification WHERE id = '".$_GET['notification']."'");
  }

  


	
	if($notifications_count < 1){ ?>
    <?php }else{
				
 
		echo "<ul class='v2reset_listing showAllNotification'>";
		echo '<li style="border-bottom:none;"><input class="delNotification" type="checkbox" id="selectAll" /><a href="javascript:void(0);" style="cursor:normal;"><i><strong>Select All</strong></i></a></li>';
		while($s_row = mysql_fetch_assoc($to_user_notifications)){

			$get_upload_pass_username = mysql_query("SELECT club_name FROM clubs WHERE id = '".$s_row['from_user']."'"); /* get host name by which pass is being uploaded */
			$get_clubname = mysql_fetch_assoc($get_upload_pass_username);
			
			$get_user = mysql_query("SELECT first_name, last_name, email, profilename FROM user WHERE id = '".$s_row['from_user']."'"); /* get user name by which shout is being uploaded */
			$get_sender_data = mysql_fetch_assoc($get_user);
			
			  $full_name_notification = $get_sender_data['first_name']." ".$get_sender_data['last_name'];
			  $profilename_notification = $get_sender_data['profilename'];
			  $email_notification = $get_sender_data['email'];
			  
				if(!empty($profilename_notification)){
				  
					  $sender_details = $profilename_notification;					  
				  
				}else{

					  if(!empty($full_name_notification)){
						  
						  $sender_details = $full_name_notification;
						  
					  }else{
							  
						  $sender_details = $email_notification;
							  
					  }						  
				  
				}
			
	
			
			
		
			$originalDate = $s_row['added_on'];
			
			$added_on_date = date("j M, Y g:i a" , strtotime($originalDate));
			
			?>

			<?php 
			if($s_row['type'] == "artist_request_sent"){
		
				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "club")
				{
					$getCLUB = mysql_query("SELECT club_name FROM clubs WHERE id = '".$s_row['from_user']."'");
					$fetchCLUB = mysql_fetch_array($getCLUB);
					$clubName = $fetchCLUB['club_name'];
					$getartistdetail = mysql_query("SELECT * FROM `artist_list` WHERE `artist_id` = '$_SESSION[user_id]' AND `host_id` = '$s_row[from_user]' ");
					$fetchdetail = mysql_fetch_assoc($getartistdetail);
					?>
     					<input name="ids[]" type="checkbox" value="<?php echo $s_row['id']; ?>" class="delNotification" />
					<a onclick="javascript:void window.open('<?php echo $SiteURL; ?>acceptArtistrequest.php?id=<?php echo $fetchdetail['id'];?>&amp;action=view&amp;notification=<?php echo $s_row['id'];?>','','width=400,height=500,resizable=true,left=300,top=0,scrollbar=no');return false;">
						<i>
							<strong style=''>Friend Request</strong><br>
							<?php echo $clubName; ?> added you as Artist.Confirm your request.
						</i>
					</a>
					<!-- <div class='del_notifications' onclick='delete_notification("<?php echo $s_row['id']; ?>");'></div> -->
			<?php
				}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "shout"){
		
				echo "<li id=".$s_row['id'].">";
				
				if($_SESSION['user_type'] == "user"){
				  
					if($s_row['from_user_type'] == "user"){
					
							echo " <input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."user_shout.php?notification=".$s_row['id']."'><i><strong style='text-transform: capitalize;'>".$s_row['type']."</strong><br>".$sender_details." shouted on ".$added_on_date."</i></a>";
						  
						  }else{
							
							echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."user_shout.php?notification=".$s_row['id']."'><i><strong style='text-transform: capitalize;'>".$s_row['type']."</strong><br>".$get_clubname['club_name']." shouted on ".$added_on_date."</i></a>";
							
						  }
					
					}else{
					
						echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."shout.php?notification=".$s_row['id']."'><i><strong style='text-transform: capitalize;'>".$s_row['type']."</strong><br>".$sender_details." shouted on ".$added_on_date."</i></a>";
					
				}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "pass"){
			 
				$cmidnt = $s_row['common_identifier'];
				$explode = explode("_", $cmidnt);
				$couponid = $explode[2];
				$getcpooninfo = mysql_query("SELECT `coupon_name` FROM `host_coupon` WHERE `id` = '$couponid' ");
				$fetchinfo = mysql_fetch_array($getcpooninfo);

				echo "<li id=".$s_row['id'].">";
				
				if($_SESSION['user_type'] == "user"){
					
						echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."host_profile.php?host_id=".$s_row['from_user']."&notification=".$s_row['id']."'><i><strong style='text-transform: capitalize;'> Host ".$s_row['type']."</strong><br>".$get_clubname['club_name']." uploaded a '".$fetchinfo['coupon_name']."' on ".$added_on_date."</i></a>";
					
					}else{
						
						$explode_common_identifier = explode('host_coupon_' , $row['common_identifier']);
					
						echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."pass_detail.php?p_id=".$explode_common_identifier[1]."&notification=".$s_row['id']."'><i><strong style='text-transform: capitalize;'> Host ".$s_row['type']."</strong><br>".$get_clubname['club_name']." uploaded a '".$fetchinfo['coupon_name']."' on ".$added_on_date."</i></a>";
					
				}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "challenge"){
		
				echo "<li id=".$s_row['id'].">";
				
				if($_SESSION['user_type'] == "user"){
					
						echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."user_challenge.php?notification=".$s_row['id']."'><i><strong style='text-transform: capitalize;'>".$s_row['type']."</strong><br>".$sender_details." created a challenge on ".$added_on_date."</i></a>";
					
					}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "friend_request_sent"){
		
				echo "<li id=".$s_row['id'].">";
				
				if($s_row['from_user_type'] == "user")
				{
					$senderDeatils = $sender_details;
				}
				else
				{
					$senderDeatils = $get_clubname['club_name'];
				}

				if($_SESSION['user_type'] == "user")
				{

					echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."friend_request.php?notification=".$s_row['id']."'><i> <strong style='text-transform: capitalize;'>New Friend Request</strong><br>".$senderDeatils." sent you a friend request</i></a>";
					
				}
				else
				{
					echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."all_connections.php?notification=".$s_row['id']."'><i> <strong style='text-transform: capitalize;'>New Friend Request</strong><br>".$senderDeatils." sent you a friend request</i></a>";
				}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "order"){
		
				echo "<li id=".$s_row['id'].">";
				
				if($_SESSION['user_type'] == "club"){
						
						$get_order_id = explode('store_order_status_' , $s_row['common_identifier']);
						
						$get_invoice_number = mysql_query("SELECT invoice FROM store_order_status WHERE id = '".$get_order_id[1]."'");
						$invoice_number = mysql_fetch_assoc($get_invoice_number);
						
						
						echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."order_detail.php?id=".$invoice_number['invoice']."&notification=".$s_row['id']."'><i><strong style='text-transform: capitalize;'>".$s_row['type']."</strong><br>".$sender_details." placed an order on ".$added_on_date."</i></a>";
					
					}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "event"){
		
				echo "<li id=".$s_row['id'].">";
				
				if($_SESSION['user_type'] == "user"){
				  
					  $evnt_id = explode('events_forum_' , $s_row['common_identifier']);
				  
						$get_eventname = mysql_query("SELECT eventname FROM events WHERE id = '".$evnt_id[1]."'");
						$ename = mysql_fetch_assoc($get_eventname);
					
						echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."listevent.php?host_id=".$s_row['from_user']."&notification=".$s_row['id']."'><i><strong style='text-transform: capitalize;'>".$s_row['type']."</strong><br>".$get_clubname['club_name']." created an event '".$ename['eventname']."' on ".$added_on_date."</i></a>";
					
					}
				
				echo "</li>";
		
			}
			if($s_row['type'] == "event_invite")
			{
				echo "<li id=".$s_row['id'].">";
				
				if($_SESSION['user_type'] == "club")
				{
				  
					$evnt_id = explode('dj_invitation_' , $s_row['common_identifier']);

					$getCLUB = mysql_query("SELECT club_name FROM clubs WHERE id = '".$s_row['from_user']."'");
					$fetchCLUB = mysql_fetch_array($getCLUB);
					$clubName = $fetchCLUB['club_name'];
					$get_eventname = mysql_query("SELECT * FROM events WHERE id = '".$evnt_id[1]."'");
					$ename = mysql_fetch_assoc($get_eventname);

					?>
				<input name='ids[]' type='checkbox' value="<?php echo $s_row['id'];?>" class='delNotification' />	<a onclick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $evnt_id['1'];?>&action=event&notification=<?php echo $s_row['id'];?>','','width=500,height=700,resizable=true,left=0,top=0');return false;">
						<i>
							<strong style=''>Event Invitation</strong><br>
							<?php echo $clubName; ?> invited you to an event on <?php echo $ename['date']; ?>
						</i>
					</a>

					<?php
					//echo "<a onclick='javascript:void window.open('read_more_cityevent.php?id=".$evnt_id."&action=event&type=invite&notification=".$s_row['id'],'','width=500,height=700,resizable=true,left=0,top=0');return false;' ><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." posted '".$ename['forum']."' on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
				}
				
				echo "</li>";
			}

			if($s_row['type'] == "invite_confirm")
			{
				echo "<li id=".$s_row['id'].">";
				
				if($_SESSION['user_type'] == "club")
				{
				  
					$evnt_id = explode('dj_invitation_confirm_' , $s_row['common_identifier']);

					$getCLUB = mysql_query("SELECT club_name FROM clubs WHERE id = '".$s_row['from_user']."'");
					$fetchCLUB = mysql_fetch_array($getCLUB);
					$clubName = $fetchCLUB['club_name'];
					$get_eventname = mysql_query("SELECT * FROM events WHERE id = '".$evnt_id[1]."'");
					$ename = mysql_fetch_assoc($get_eventname);

					?>
				<input name='ids[]' type='checkbox' value="<?php echo $s_row['id'];?>" class='delNotification' />	<a onclick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $evnt_id['1'];?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">
						<i>
							<strong style=''>Event Invitation Confirmation </strong><br>
							<?php echo $clubName; ?> confirmed your invitation for event on <?php echo $ename['date']; ?>
						</i>
					</a>
					<!-- <div class='del_notifications' onclick='delete_notification("<?php echo $s_row['id']; ?>");'></div> -->
					<?php
					//echo "<a onclick='javascript:void window.open('read_more_cityevent.php?id=".$evnt_id."&action=event&type=invite&notification=".$s_row['id'],'','width=500,height=700,resizable=true,left=0,top=0');return false;' ><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." posted '".$ename['forum']."' on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
				}
				
				echo "</li>";
			}

			if($s_row['type'] == "invite_reject")
			{
				echo "<li id=".$s_row['id'].">";
				
				if($_SESSION['user_type'] == "club")
				{
				  
					$evnt_id = explode('dj_invitation_reject_' , $s_row['common_identifier']);

					$getCLUB = mysql_query("SELECT club_name FROM clubs WHERE id = '".$s_row['from_user']."'");
					$fetchCLUB = mysql_fetch_array($getCLUB);
					$clubName = $fetchCLUB['club_name'];
					$get_eventname = mysql_query("SELECT * FROM events WHERE id = '".$evnt_id[1]."'");
					$ename = mysql_fetch_assoc($get_eventname);

					?>
				<input name='ids[]' type='checkbox' value="<?php echo $s_row['id'];?>" class='delNotification' />	<a onclick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $evnt_id['1'];?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">
						<i>
							<strong style=''>Event Invitation Rejected </strong><br>
							<?php echo $clubName; ?> rejected your invitation for event on <?php echo $ename['date']; ?>
						</i>
					</a>
					<!-- <div class='del_notifications' onclick='delete_notification("<?php echo $s_row['id']; ?>");'></div> -->
					<?php
					//echo "<a onclick='javascript:void window.open('read_more_cityevent.php?id=".$evnt_id."&action=event&type=invite&notification=".$s_row['id'],'','width=500,height=700,resizable=true,left=0,top=0');return false;' ><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." posted '".$ename['forum']."' on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
				}
				
				echo "</li>";
			}


			if($s_row['type'] == "post"){
		
				echo "<li id=".$s_row['id'].">";
				
				if($_SESSION['user_type'] == "user"){
				  
					  $evnt_id = explode('forum_' , $s_row['common_identifier']);
				  
					  $get_eventname = mysql_query("SELECT forum FROM forum WHERE forum_id = '".$evnt_id[1]."'");
					  $ename = mysql_fetch_assoc($get_eventname);
					
						echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."profile.php?id=".$s_row['from_user']."&notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." posted '".$ename['forum']."' on ".$added_on_date."</i></a>";
					
					}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "clique"){
		
				echo "<li id=".$s_row['id'].">";
				
				if($_SESSION['user_type'] == "user"){
				  
					  $evnt_id = explode('forum_' , $s_row['common_identifier']);
				  
					  $get_eventname = mysql_query("SELECT forum FROM forum WHERE forum_id = '".$evnt_id[1]."'");
					  $ename = mysql_fetch_assoc($get_eventname);
					
						echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."private_zone.php?id=".$s_row['from_user']."&notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." posted clique '".$ename['forum']."' on ".$added_on_date."</i></a>";
					
					}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "event_calendar_share"){
		
				echo "<li id=".$s_row['id'].">";
				
				//if($_SESSION['user_type'] == "user"){
				  
					  $evnt_id = explode('event_calendar_share_' , $s_row['common_identifier']);
					  $added_on_date = date("j M, Y g:i a" , strtotime($s_row['added_on']));
				  
					  $get_eventname = mysql_query("SELECT forum FROM forum WHERE forum_id = '".$evnt_id[1]."'");
					  $ename = mysql_fetch_assoc($get_eventname);
					  
					  $enm = str_replace('_', ' ', $s_row['type']);
					?>
						<input name='ids[]' type='checkbox' value="<?php echo $s_row['id'];?>" class='delNotification' /><a onClick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $evnt_id[1]; ?>&notification=<?php echo $s_row['id']; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"><i><strong style=""><?php echo $enm; ?></strong><br><?php echo $sender_details." shared event '".$ename['forum']."' on ".$added_on_date ?></i></a>
						
					<?php
					//}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "shared_ticket"){
		
				echo "<li id=".$s_row['id'].">";
				
				//if($_SESSION['user_type'] == "user"){
				  
					  $evnt_id = explode('shared_ticket_' , $s_row['common_identifier']);
					  $added_on_date = date("j M, Y g:i a" , strtotime($s_row['added_on']));
				  
					  $get_eventname = mysql_query("SELECT * FROM paid_passes INNER JOIN paid_pass_download ON paid_passes.pass_id = paid_pass_download.pass_id WHERE paid_pass_download.pd_id = '".$evnt_id[1]."'");
					  $ename = mysql_fetch_assoc($get_eventname);
					  
					  $eventname_query = mysql_query("SELECT eventname FROM events WHERE id = '".$ename['event_id']."'");
					  $eventname = mysql_fetch_assoc($eventname_query);
					  
					  $enm = str_replace('_', ' ', $s_row['type']);
					?>
					<input name='ids[]' type='checkbox' value="<?php echo $s_row['id'];?>" class='delNotification' />	<a href="<?php echo $SiteURL; ?>successPurchase.php?notification=<?php echo $s_row['id']; ?>"><i><strong style=""><?php echo $enm; ?></strong><br><?php echo $sender_details." shared '".$eventname['eventname']."' event ticket on ".$added_on_date ?></i></a>

					<?php
					//}
				
				echo "</li>";
		
			}				
						
		}
		
		while($t_row = mysql_fetch_assoc($from_user_notifications)){
			
			if($t_row['type'] == "friend_request_accept"){
		
				
				
				if($_SESSION['user_type'] == "user"){
					echo "<li id=".$s_row['id'].">";
						$get_user = mysql_query("SELECT first_name, last_name, email, profilename FROM user WHERE id = '".$t_row['to_user']."'");
						$get_sender_data = mysql_fetch_assoc($get_user);
						
						$full_name_notification = $get_sender_data['first_name']." ".$get_sender_data['last_name'];
						$profilename_notification = $get_sender_data['profilename'];
						$email_notification = $get_sender_data['email'];
						
						if(!empty($full_name_notification)){
							
							$sender_details = $full_name_notification;
							
						}elseif(!empty($profilename_notification)){
								
							$sender_details = $full_name_notification;
							
						}else{
								
							$sender_details = $email_notification;
								
						}
						
						echo "<input name='ids[]' type='checkbox' value=".$s_row['id']." class='delNotification' /><a href='".$SiteURL."all_friends.php?notification=".$t_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." accepted your friend request</i></a>";
					echo "</li>";
					}
				
				
		
			}			
			
		}
		echo '</form>';
		echo "</ul>";
	}?>
	
<script type="text/javascript">
  function delete_notification(val){
	var count_val_notification = $('#s_cnt').html();
	var decrease_count_notification = count_val_notification - 1;
	//alert(decrease_count_notification);
	
	$('#s_cnt').html(decrease_count_notification);
	$('.v2_inner_main_content ul li#'+val).hide();
	
	$.post('ajaxcall.php', {'notification_id':val}, function(response){ });
  }
</script>

					</div>
					
				</div>
			</div>
			<div class="equalizer">
			</div>
		</article>
	</div>
<div class="clear"></div>
</div>
<?php include('Footer.php') ?>