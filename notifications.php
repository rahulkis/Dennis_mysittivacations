<?php
  if(isset($_GET['notification'])){
	
  	mysql_query("DELETE FROM user_notification WHERE id = '".$_GET['notification']."'");
  }



/*function hexrgb ($hexstr)
{
  	$int = hexdec($hexstr);

  	return array("red" => 0xFF & ($int >> 0x10),
			   "green" => 0xFF & ($int >> 0x8),
			   "blue" => 0xFF & $int);
}*/
  
?>
<div class="notify">
  <div class="notificationz">

    <?php
	$to_user_notifications = mysql_query("SELECT * FROM user_notification WHERE to_user_type = '".$_SESSION['user_type']."' AND to_user = '".$_SESSION['user_id']."' AND type != 'friend_request_accept' ORDER BY id DESC");
	
	$from_user_notifications = mysql_query("SELECT * FROM user_notification WHERE from_user_type = '".$_SESSION['user_type']."' AND from_user = '".$_SESSION['user_id']."' AND type = 'friend_request_accept' ORDER BY id DESC");
	
	$to_user_count = mysql_num_rows($to_user_notifications);
	$from_user_count = mysql_num_rows($from_user_notifications);
	
	$notifications_count = $to_user_count + $from_user_count;
	
	if($notifications_count < 1){ ?>
    <div class="notifi-menu">
      <h1><img src="<?php echo $SiteURL;?>images/notifications.png" alt="notification" />
        <!-- <div id="s_cnt" style="margin-right: 5px; margin-top: 0px; cursor : pointer;" class="unread fl">0</div> -->
      </h1>
    </div>
    <?php }else{

		?>
    <div class="notifi-menu">
      <h1><a href='<?php echo $SiteURL;?>show-notifications.php'><img src="<?php echo $SiteURL;?>images/notifications.png" alt="notification" />
        <div id="s_cnt" style=" " class="unread fl circle_notification"><?php echo $notifications_count; ?></div>
        </a>
      </h1>
    </div>
    <?php 

	echo "<div class='v2side_profile' id='notifications_side_profile' >";
		echo "<ul class='v2reset_listing'>";
		
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
					<a onclick="javascript:void window.open('<?php echo $SiteURL; ?>acceptArtistrequest.php?id=<?php echo $fetchdetail['id'];?>&amp;action=view&amp;notification=<?php echo $s_row['id'];?>','','width=400,height=500,resizable=true,left=300,top=0,scrollbar=no');return false;">
						<i>
							<strong style=''>Friend Request</strong><br>
							<?php echo $clubName; ?> added you as Artist.Confirm your request.
						</i>
					</a>
					<div class='del_notifications' onclick='delete_notification("<?php echo $s_row['id']; ?>");'></div>
			<?php
				}
				
				echo "</li>";
		
			}

			if($s_row['type'] == "become_friends"){
		
				echo "<li id='".$s_row['id']."'>";
				
				if( ($_SESSION['user_type'] == $s_row['to_user_type'] )  && ( $_SESSION['user_id'] == $s_row['to_user'] ) )
				{
					echo "<a href='javascript:void(0);'><i><strong>Friends</strong><br />".$s_row['common_identifier']."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";  
				}
				
				echo "</li>";
		
			}


			if($s_row['type'] == "shout"){
		
				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "user"){
				  
					if($s_row['from_user_type'] == "user"){
					
							echo "<a href='".$SiteURL."user_shout.php?notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." shouted on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
						  
						  }else{
							
							echo "<a href='".$SiteURL."user_shout.php?notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$get_clubname['club_name']." shouted on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
							
						  }
					
					}else{
					
						echo "<a href='".$SiteURL."shout.php?notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." shouted on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
				}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "pass"){
			 
				$cmidnt = $s_row['common_identifier'];
				$explode = explode("_", $cmidnt);
				$couponid = $explode[2];
				$getcpooninfo = mysql_query("SELECT `coupon_name` FROM `host_coupon` WHERE `id` = '$couponid' ");
				$fetchinfo = mysql_fetch_array($getcpooninfo);

				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "user"){
					
						echo "<a href='".$SiteURL."host_profile.php?host_id=".$s_row['from_user']."&notification=".$s_row['id']."'><i><strong style=''> Host ".$s_row['type']."</strong><br>".$get_clubname['club_name']." uploaded a '".$fetchinfo['coupon_name']."' on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
					}else{
						
						$explode_common_identifier = explode('host_coupon_' , $s_row['common_identifier']);
					
						echo "<a href='".$SiteURL."pass_detail.php?p_id=".$explode_common_identifier[1]."&notification=".$s_row['id']."'><i><strong style=''> Host ".$s_row['type']."</strong><br>".$get_clubname['club_name']." uploaded a '".$fetchinfo['coupon_name']."' on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
				}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "challenge"){
				
				echo "<li id='".$s_row['id']."'>";	
				
				if($_SESSION['user_type'] == "user"){
					
						echo "<a href='".$SiteURL."user_challenge.php?notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." created a challenge on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
					}
				
				echo "</li>";
		
			}

			if($s_row['type'] == "booking"){
				if($s_row['from_user_type'] == 'user')
				{
					$getUserInfo = mysql_query("SELECT `profilename` as `profilename` FROM `user` WHERE `id` = '$s_row[from_user]' ");
				}
				elseif($s_row['from_user_type'] == 'club')
				{
					$getUserInfo = mysql_query("SELECT `club_name` as `profilename` FROM `clubs` WHERE `id` = '$s_row[from_user]' ");
				}
				$fetchUsername = mysql_fetch_assoc($getUserInfo);

				echo "<li id='".$s_row['id']."'>";
				
					if($_SESSION['user_type'] == "club")
					{
						$explode_common_identifier = explode('boooking_' , $s_row['common_identifier']);
						echo "<a href='".$SiteURL."bookings.php?notification=".$s_row['id']."&page=edit&id=".$explode_common_identifier[1]."'><i><strong style=''>Booking Request</strong><br>There is a new Booking Request from ".$fetchUsername['profilename'].".</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					}
				
				echo "</li>";
		
			}

			if($s_row['type'] == "contest")
			{
				$cmidnt = $s_row['common_identifier'];
				$explode = explode("_", $cmidnt);
				$couponid = $explode[1];
				$getcpooninfo = mysql_query("SELECT * FROM `contest` WHERE `contest_id` = '$couponid' ");
				$fetchinfo = mysql_fetch_array($getcpooninfo);

				$getCityInfo = mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$fetchinfo[contest_city]' ");
				$fetchCityInfo = mysql_fetch_assoc($getCityInfo);
				$cityName = $fetchCityInfo['city_name'];
				$getCluInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$fetchinfo[host_id]' ");
				$fetchCLUB = mysql_fetch_assoc($getCluInfo);
				$CLUBID = $fetchCLUB['id'];

				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "user")
				{
					
					echo "<a href='".$SiteURL."view_contestent.php?cont_id=".$couponid."&hostID=".$CLUBID."&notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$fetchCLUB['club_name']." created a contest on ".$added_on_date." in ".$cityName."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
				}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "friend_request_sent"){
		
				echo "<li id='".$s_row['id']."'>";
				
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

					echo "<a href='".$SiteURL."friend_request.php?notification=".$s_row['id']."'><i> <strong style=''>New Friend Request</strong><br>".$senderDeatils." sent you a friend request</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
				}
				else
				{
					echo "<a href='".$SiteURL."all_connections.php?notification=".$s_row['id']."'><i> <strong style=''>New Friend Request</strong><br>".$senderDeatils." sent you a friend request</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
				}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "order"){
		
				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "club"){
						
						$get_order_id = explode('store_order_status_' , $s_row['common_identifier']);
						
						$get_invoice_number = mysql_query("SELECT invoice FROM store_order_status WHERE id = '".$get_order_id[1]."'");
						$invoice_number = mysql_fetch_assoc($get_invoice_number);
						
						
						echo "<a href='".$SiteURL."order_detail.php?id=".$invoice_number['invoice']."&notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." placed an order on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
					}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "event"){
		
				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "user"){
				  
					  $evnt_id = explode('events_forum_' , $s_row['common_identifier']);
				  
						$get_eventname = mysql_query("SELECT eventname FROM events WHERE id = '".$evnt_id[1]."'");
						$ename = mysql_fetch_assoc($get_eventname);
					
						echo "<a href='".$SiteURL."listevent.php?host_id=".$s_row['from_user']."&notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$get_clubname['club_name']." created an event '".$ename['eventname']."' on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
					}
				
				echo "</li>";
		
			}
			if($s_row['type'] == "event_invite")
			{
				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "club")
				{
				  
					$evnt_id = explode('dj_invitation_' , $s_row['common_identifier']);

					$getCLUB = mysql_query("SELECT club_name FROM clubs WHERE id = '".$s_row['from_user']."'");
					$fetchCLUB = mysql_fetch_array($getCLUB);
					$clubName = $fetchCLUB['club_name'];
					$get_eventname = mysql_query("SELECT * FROM events WHERE id = '".$evnt_id[1]."'");
					$ename = mysql_fetch_assoc($get_eventname);

					?>
					<a onclick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $evnt_id['1'];?>&action=event&notification=<?php echo $s_row['id'];?>','','width=500,height=700,resizable=true,left=0,top=0');return false;">
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
				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "club")
				{
				  
					$evnt_id = explode('dj_invitation_confirm_' , $s_row['common_identifier']);

					$getCLUB = mysql_query("SELECT club_name FROM clubs WHERE id = '".$s_row['from_user']."'");
					$fetchCLUB = mysql_fetch_array($getCLUB);
					$clubName = $fetchCLUB['club_name'];
					$get_eventname = mysql_query("SELECT * FROM events WHERE id = '".$evnt_id[1]."'");
					$ename = mysql_fetch_assoc($get_eventname);

					?>
					<a onclick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $evnt_id['1'];?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">
						<i>
							<strong style=''>Event Invitation Confirmation </strong><br>
							<?php echo $clubName; ?> confirmed your invitation for event on <?php echo $ename['date']; ?>
						</i>
					</a>
					<div class='del_notifications' onclick='delete_notification("<?php echo $s_row['id']; ?>");'></div>
					<?php
					//echo "<a onclick='javascript:void window.open('read_more_cityevent.php?id=".$evnt_id."&action=event&type=invite&notification=".$s_row['id'],'','width=500,height=700,resizable=true,left=0,top=0');return false;' ><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." posted '".$ename['forum']."' on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
				}
				
				echo "</li>";
			}

			if($s_row['type'] == "invite_reject")
			{
				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "club")
				{
				  
					$evnt_id = explode('dj_invitation_reject_' , $s_row['common_identifier']);

					$getCLUB = mysql_query("SELECT club_name FROM clubs WHERE id = '".$s_row['from_user']."'");
					$fetchCLUB = mysql_fetch_array($getCLUB);
					$clubName = $fetchCLUB['club_name'];
					$get_eventname = mysql_query("SELECT * FROM events WHERE id = '".$evnt_id[1]."'");
					$ename = mysql_fetch_assoc($get_eventname);

					?>
					<a onclick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $evnt_id['1'];?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">
						<i>
							<strong style=''>Event Invitation Rejected </strong><br>
							<?php echo $clubName; ?> rejected your invitation for event on <?php echo $ename['date']; ?>
						</i>
					</a>
					<div class='del_notifications' onclick='delete_notification("<?php echo $s_row['id']; ?>");'></div>
					<?php
					//echo "<a onclick='javascript:void window.open('read_more_cityevent.php?id=".$evnt_id."&action=event&type=invite&notification=".$s_row['id'],'','width=500,height=700,resizable=true,left=0,top=0');return false;' ><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." posted '".$ename['forum']."' on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
				}
				
				echo "</li>";
			}


			if($s_row['type'] == "post"){
		
				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "user"){
				  
					  $evnt_id = explode('forum_' , $s_row['common_identifier']);
				  
					  $get_eventname = mysql_query("SELECT forum FROM forum WHERE forum_id = '".$evnt_id[1]."'");
					  $ename = mysql_fetch_assoc($get_eventname);
					
						echo "<a href='".$SiteURL."profile.php?id=".$s_row['from_user']."&notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." posted '".$ename['forum']."' on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
					}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "clique"){
		
				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "user"){
				  
					  $evnt_id = explode('forum_' , $s_row['common_identifier']);
				  
					  $get_eventname = mysql_query("SELECT forum FROM forum WHERE forum_id = '".$evnt_id[1]."'");
					  $ename = mysql_fetch_assoc($get_eventname);
					
						echo "<a href='".$SiteURL."private_zone.php?id=".$s_row['from_user']."&notification=".$s_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." posted clique '".$ename['forum']."' on ".$added_on_date."</i></a><div class='del_notifications' onclick='delete_notification(".$s_row['id'].");'></div>";
					
					}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "event_calendar_share"){
		
				echo "<li id='".$s_row['id']."'>";
				
				//if($_SESSION['user_type'] == "user"){
				  
					  $evnt_id = explode('event_calendar_share_' , $s_row['common_identifier']);
					  $added_on_date = date("j M, Y g:i a" , strtotime($s_row['added_on']));
				  
					  $get_eventname = mysql_query("SELECT forum FROM forum WHERE forum_id = '".$evnt_id[1]."'");
					  $ename = mysql_fetch_assoc($get_eventname);
					  
					  $enm = str_replace('_', ' ', $s_row['type']);
					?>
						<a onClick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $evnt_id[1]; ?>&notification=<?php echo $s_row['id']; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"><i><strong style=""><?php echo $enm; ?></strong><br><?php echo $sender_details." shared event '".$ename['forum']."' on ".$added_on_date ?></i></a><div class="del_notifications" onclick="delete_notification('<?php echo $s_row['id']; ?>');"></div>
						
					<?php
					//}
				
				echo "</li>";
		
			}
			
			if($s_row['type'] == "shared_ticket"){
		
				echo "<li id='".$s_row['id']."'>";
				
				//if($_SESSION['user_type'] == "user"){
				  
					  $evnt_id = explode('shared_ticket_' , $s_row['common_identifier']);
					  $added_on_date = date("j M, Y g:i a" , strtotime($s_row['added_on']));
				  
					  $get_eventname = mysql_query("SELECT * FROM paid_passes INNER JOIN paid_pass_download ON paid_passes.pass_id = paid_pass_download.pass_id WHERE paid_pass_download.pd_id = '".$evnt_id[1]."'");
					  $ename = mysql_fetch_assoc($get_eventname);
					  
					  $eventname_query = mysql_query("SELECT eventname FROM events WHERE id = '".$ename['event_id']."'");
					  $eventname = mysql_fetch_assoc($eventname_query);
					  
					  $enm = str_replace('_', ' ', $s_row['type']);
					?>
						<a href="<?php echo $SiteURL; ?>successPurchase.php?notification=<?php echo $s_row['id']; ?>"><i><strong style=""><?php echo $enm; ?></strong><br><?php echo $sender_details." shared '".$eventname['eventname']."' event ticket on ".$added_on_date ?></i></a><div class="del_notifications" onclick="delete_notification('<?php echo $s_row['id']; ?>');"></div>

					<?php
					//}
				
				echo "</li>";
		
			}				
						
		}
		
		while($t_row = mysql_fetch_assoc($from_user_notifications)){
			
			if($t_row['type'] == "friend_request_accept"){
		
				echo "<li id='".$s_row['id']."'>";
				
				if($_SESSION['user_type'] == "user"){
					
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
						
						echo "<a href='".$SiteURL."all_friends.php?notification=".$t_row['id']."'><i><strong style=''>".$s_row['type']."</strong><br>".$sender_details." accepted your friend request</i></a><div class='del_notifications' onclick='delete_notification(".$t_row['id'].");'></div>";
					
					}
				
				echo "</li>";
		
			}			
			
		}
		
		echo "</ul>";
		echo "<a class='all_notification' href='".$SiteURL."show-notifications.php'>Show All</a>";
	echo "</div>";
	}?>
 
  </div>
</div>

<script type="text/javascript">
  function delete_notification(val){
	var count_val_notification = $('#s_cnt').html();
	var decrease_count_notification = count_val_notification - 1;
	//alert(decrease_count_notification);
	var Siteurl = $('#siteURL').val();
	$('#s_cnt').html(decrease_count_notification);
	$('.notificationz ul li#'+val).hide();
	
	$.post(Siteurl+'ajaxcall.php', {'notification_id':val}, function(response){ });
  }
</script>