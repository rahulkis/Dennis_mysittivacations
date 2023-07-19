<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$titleofpage="BookMe";
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("index.php");
}
if(isset($_GET['host_id']))
{
	include('LoginHeader.php');
}
else
{
	include('HeaderHost.php');	
}
$del_id = $_GET['id'];
$host_id = $_GET['host_id'];
if($del_id !="")
{
	$shoutsql ="DELETE FROM shouts WHERE shout_id = $del_id";
	@mysql_query($shoutsql);
	header('Location: my_shout.php');die;
}	
if($_GET['msg']==1){
	$message = 'Thank you for booking with us. We will contact you within 24 hours.';
}
	$sql = "select * from `user` where `id` = '".$_SESSION['user_id']."'";
	$userArray1 = $Obj->select($sql) ; 
	
	$first_name=$userArray1[0]['first_name']; 
	$last_name=$userArray1[0]['last_name'];	
	$zipcode=$userArray1[0]['zipcode'];
	$state=$userArray1[0]['state'];
	$country=$userArray1[0]['country'];
	if($userArray1[0]['DOB']==''){$dob="00/00/0000";} else {$dob=$userArray1[0]['DOB'];}
	$city=$userArray1[0]['city'];
	$email=$userArray1[0]['email'];
	$image_nm=$userArray1[0]['image_nm'];
	$phone=$userArray1[0]['phone'];
	/**********************************/
	$sql="select s.*,uc.is_read,uc.owner_id,uc.user_type,u.first_name,u.last_name,u.image_nm 
	  from user_to_content as uc 
	 left join  shouts as s on(s.id=uc.cont_id) 
	 left join user as u on(u.id=s.user_id)
	 where uc.user_id='".$_SESSION['user_id']."' AND  u.id!='1' AND uc.owner_id!='".$_SESSION['user_id']."' AND cont_type='shout' group by uc.cont_id ORDER BY s.id DESC";
	$shout_list = mysql_query($sql);
	$tot_shout_num=@mysql_num_rows($shout_list);
 
	if(count($_POST['shoutschk']) > 0)
	{
		$ids=implode(",",$_POST['shoutschk']); 
		$sql_del=mysql_query("delete from shouts where id IN(".$ids.")");
		if($sql_del)
		{	
			$_SESSION['success']="Shouts deleted successfully";
			header('location:shout.php'); exit;
		}
	}
	if(isset($_SESSION['success']))
	{
		$success=$_SESSION['success'];
		unset($_SESSION['success']);
	}
	
	if(isset($_POST['bookme'])) 
	{

		$start = $_POST['start_time'];		
		$end = $_POST['end_time'];//echo strtotime($end);die;	

		$date1=$start;
		$date2=$end;

		$date = date('Y-m-d', strtotime($start));

		$number_of_guest = $_POST['number_of_guest'];
		$book_type = $_POST['book_type'];
        
        		if(!empty($book_type))
        		{
        			extract($_POST);
			$userID = $_SESSION['user_id'];
			$status = "New";
			$read_status = "0";
			$finalstart = date('Y-m-d H:i:s',strtotime($start));
			$finalend= date('Y-m-d H:i:s',strtotime($end));
		    	$query = "INSERT INTO bookings ( `user_id`,`host_id`,`first_name`, `last_name`, `phone_number`, `email_address`, `profile_name`, `book_type`, `requeted_date`, `start_time`, `end_time`, `price`,`number_of_guest`, `special_request`,`status`,`read_status`)
			VALUES ('".$userID."','".$host_id."','".$first_name."', '".$last_name."','".$phone_number."','".$email_address."','".$profile_name."','".$book_type."','".$date."','".$date1."','".$date2."','".$price."','".$number_of_guest."','".mysql_real_escape_string($special_request)."','".$status."','".$read_status."')";
			$res = mysql_query($query);
			$inserted_event_id = mysql_insert_id();
			$message = 'Thank you for booking with us. We will contact you within 24 hours.';
			$send = mysql_query("Select u.email,u.first_name from user as u where u.id  = '".$userID."'");
			$send_email = mysql_fetch_array($send);
		   
			$sql1 = "select * from `clubs` where `id` = '".$host_id."'";
			$userArray11 = $Obj->select($sql1) ; 
			$club_name=$userArray11[0]['club_name']; 
		
			if($club_name)
			{
				$to = $email_address;
				$subject = "Thanks For Booking";
				$txt   = " HI ".$first_name.",</br></br>";
				$txt  .= " Thank you for booking with us.We will get back with you within 24 hours.<br>";
				$txt  .= "Your booking detail are given below.<br>";
				$txt  .= " Host Name &nbsp;&nbsp; : ".$club_name."</br>";
				$txt  .= " BookMe Type &nbsp;&nbsp; : ".$book_type."</br>";
				$txt   .= " Requested Date &nbsp;&nbsp; : ".$requeted_date."</br>";
				$txt  .= " Start Time &nbsp;&nbsp; : ".$start_time."</br>";
				$txt   .= " End Time &nbsp;&nbsp; : ".$end_time."</br>";
				$txt   .= " Number of guest &nbsp;&nbsp; : ".$number_of_guest."</br>";
				$txt   .= " Special Request &nbsp;&nbsp; : ".$special_request."</br>";
				$txt  .= " Thanks"."<br>";
				$txt  .= "mysitti.com";
				$headers = "From: mysitti.com" . "\r\n" .		
				"Content-type: text/html"."\r\n";

				mail($to,$subject,$txt,$headers);
				$message = 'Thank you for booking with us. We will contact you within 24 hours.';
				//header('Location: bookme.php?host_id='.$_GET['host_id'].'&msg=1');
			}
			if($userArray11['sms_carrier'] != 0 && $userArray11['text_status'] == '1')
			{
				$getSMS = mysql_query("SELECT * FROM `sms_carriers` WHERE `id` = '$userArray11[sms_carrier]' ");
				$fetchSMS = mysql_fetch_array($getSMS);

				$contactSMS = $userArray11['notificationNumber'].$fetchSMS['carrier_mail'];
				// $contactSMS = str_replace("-", "", $smsCode['phone']).$fetchSMS['carrier_mail'];
				// $contactSMS = 'hvongphit@gmail.com';					
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: MYSITTI.com <mysitti@mysitti.com>' . "\r\n";
				$subject = "New Booking for ".$book_type;
				$message =  "There is a New Booking for you. Please login to MySitti.com And Confirm the Booking.";
			  	// $message .= " <a href='http://mysitti.com/live2/channel.php?n=".$username."&host_id=".$UserID."&user_type=".$UserType."'>http://mysitti.com/live2/channel.php?n=".$username."&host_id=".$UserID."&user_type=".$UserType."</a>";
				mail($contactSMS,$subject,$message,$headers,"-finfo@mysitti.com");
			}
		} 
		else 
		{
			if(isset($_POST['btype']) && $_POST['btype']=='btype')
			{				
				$current = date('y-m-d');
				$date = str_replace('/', '-', $date);
			 	$date=date('Y-m-d', strtotime($date));
				//$current = date('Y-m-d');
				//echo date('Y-m-d', strtotime($current .' -1 day'));die;		
				if(strtotime(date('Y-m-d', strtotime($current .' -1 day'))) < strtotime($date))
				{
					if(strtotime($start) < strtotime($end))
					{// die('sdgdsfg');
						if(is_numeric($number_of_guest) || empty($number_of_guest))
						{
							extract($_POST);
							$userID = $_SESSION['user_id'];
							$status = "New";
							$read_status = "0";
						
							 $query = "INSERT INTO bookings ( `user_id`,`host_id`,`first_name`, `last_name`, `phone_number`, `email_address`, `profile_name`, `book_type`, `requeted_date`, `start_time`, `end_time`, `price`,`number_of_guest`, `special_request`,`status`,`read_status`)
							VALUES ('".$userID."','".$host_id."','".$first_name."', '".$last_name."','".$phone_number."','".$email_address."','".$profile_name."','".$book_type."','".$date."','".$start_time."','".$end_time."','".$price."','".$number_of_guest."','".mysql_real_escape_string($special_request)."','".$status."','".$read_status."')";

							$res = mysql_query($query);
							$inserted_event_id = mysql_insert_id();
							$message = 'Thank you for booking with us. We will contact you within 24 hours.';
							$send = mysql_query("Select u.email,u.first_name from user as u where u.id  = '".$userID."'");
							$send_email = mysql_fetch_array($send);
						   
							$sql1 = "select * from `clubs` where `id` = '".$host_id."'";
							$userArray11 = $Obj->select($sql1) ; 
							$club_name=$userArray11[0]['club_name']; 
						
							if($club_name){
								$to = $email_address;
								$subject = "Thanks For Booking";
								$txt   = " HI ".$first_name.",</br></br>";
								$txt  .= " Thank you for booking with us.We will get back with you within 24 hours.<br>";
								$txt  .= "Your booking detail are given below.<br>";
								$txt  .= " Host Name &nbsp;&nbsp; : ".$club_name."</br>";
								$txt  .= " BookMe Type &nbsp;&nbsp; : ".$book_type."</br>";
								$txt   .= " Requested Date &nbsp;&nbsp; : ".$requeted_date."</br>";
								$txt  .= " Start Time &nbsp;&nbsp; : ".$start_time."</br>";
								$txt   .= " End Time &nbsp;&nbsp; : ".$end_time."</br>";
								$txt   .= " Number of guest &nbsp;&nbsp; : ".$number_of_guest."</br>";
								$txt   .= " Special Request &nbsp;&nbsp; : ".$special_request."</br>";
								$txt  .= " Thanks"."<br>";
								$txt  .= "mysitti.com";
								$headers = "From: mysitti.com" . "\r\n" .		
								"Content-type: text/html"."\r\n";

								mail($to,$subject,$txt,$headers);
								$message = 'Thank you for booking with us. We will contact you within 24 hours.';
								//header('Location: bookme.php?host_id='.$_GET['host_id'].'&msg=1');
							}

							if($userArray11['sms_carrier'] != 0 && $userArray11['text_status'] == '1')
							{
								$getSMS = mysql_query("SELECT * FROM `sms_carriers` WHERE `id` = '$userArray11[sms_carrier]' ");
								$fetchSMS = mysql_fetch_array($getSMS);

								$contactSMS = $userArray11['notificationNumber'].$fetchSMS['carrier_mail'];
								// $contactSMS = str_replace("-", "", $smsCode['phone']).$fetchSMS['carrier_mail'];
								// $contactSMS = 'hvongphit@gmail.com';					
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
								$headers .= 'From: MYSITTI.com <mysitti@mysitti.com>' . "\r\n";
								$subject = "New Booking for ".$book_type;
								$message =  "There is a New Booking for you. Please login to MySitti.com And Confirm the Booking.";
							  	// $message .= " <a href='http://mysitti.com/live2/channel.php?n=".$username."&host_id=".$UserID."&user_type=".$UserType."'>http://mysitti.com/live2/channel.php?n=".$username."&host_id=".$UserID."&user_type=".$UserType."</a>";
								mail($contactSMS,$subject,$message,$headers,"-finfo@mysitti.com");
							}
						} 
						else 
						{
							$erromessage = 'Number of guests should be numeric.';
						}
					} 
					else 
					{
						$erromessage = 'End time should be greater than start time.';
					}
				} 
				else 
				{
					$erromessage = 'Please enter the future date.';
				}
			} 
			else 
			{
				$erromessage = 'Please select booking type.';
			}
		}
		$event_added_on = date('Y-m-d h:i:s');
		
		$c_identifier = "boooking_".$inserted_event_id;
		mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)
									VALUES('".$_SESSION['user_id']."', '$host_id', 'booking', '".$event_added_on."', '1', '".$c_identifier."', '$_SESSION[user_type]', 'club')");
	}	
	
	$hostquery = "select * from `clubs` where `id` = '".$host_id."'";
	$hostArray = $Obj->select($hostquery);	
	$userArray = $Obj->select($hostquery);	
	$userID=$_SESSION['user_id'];
	$userType= $_SESSION['user_type'];

?>
<style type="text/css">
			#hint{
				cursor:pointer;
			}
			.tooltip{
				width:200px;
				heigh:50px;
				margin:8px;
				padding:8px;
				border:1px solid #91C9FF;
				background-color:#d3d3d3;
				position: absolute;
				z-index: 2;
			}
		</style>
<style type="text/css" title="currentStyle">
			@import "css/demo_table.css";			
		</style>
<script language="javascript">
			$(document).ready(function(){ 
				$('#book_type').change(function(){ 
					var price = $('#book_type option:selected').attr('price');
					//alert(price);
					$('#price').val(price);
					var price1 = $('#price').val();
					var price1 = $('#price').val();
					//alert(price1);
				});
				
				var changeTooltipPosition = function(event) {
					
					var tooltipX = event.pageX - 8;
					var tooltipY = event.pageY + 8;
					// $('div.tooltip').css({top: tooltipY, left: tooltipX});
					//alert(tooltipX);
					//alert(tooltipY);
					$('div.tooltip').css({top: tooltipY, left: tooltipX});
				};
				var showTooltip = function(event) { //alert($('#texttype').text());
				  $('div.tooltip').remove();
				  $('<div class="tooltip"></div>')
						.appendTo('body');
						$('.tooltip').html($('#texttype').text())
				  changeTooltipPosition(event);
				};
				var hideTooltip = function() {
				   $('div.tooltip').remove();
				};			 
				$("span#hint").bind({ 
				   mousemove : changeTooltipPosition,
				   mouseenter : showTooltip,
				   mouseleave: hideTooltip
				});			
			});
			
		function validateForm(){
			
			// if ($('#datetimepicker6').val().length < 1 || $('#datetimepicker6').val() == " ") {
			// 	alert("Please enter start time");
			// 	return false;
			
			// }
			
			// if ($('#datetimepicker3').val().length < 1 || $('#datetimepicker3').val() == "") {
			// 	alert("Please enter end time");
			// 	return false;
			// }			
			
			}	

		function gettypeDetails(type)
		{
			$.ajax({
				type: "POST",
				url: "refreshajax.php",
				data: {
				'booktypeName': type, 
				'action' : 'bookMe' 
				},
				success: function( msg ) 
				{
					$('#dynamicType').html('<b>Type Description:</b> '+msg);
				}
		  	});
		}


			
</script>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 
		if(isset($_GET['host_id']))
		{
			include('host_left_panel.php');
		}
		else 
		{
			include('friend-profile-panel.php'); 
		}
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<div class="bookme_wrapper v2_bookme">
						<?php 
						$checkpagestatus = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_GET['host_id']."' ");
						$respagestatus = @mysql_fetch_array($checkpagestatus);
						if($respagestatus['booking'] != 'Disable with message')
						{

							?>
							<h3 id="title">Booking</h3>
								
								<?php if(isset($message) && !empty($message)){?> 
										<div id="successmessage" style="display:block;" class="message" ><?php echo $message; ?></div>
									<?php }else ?> 
									<?php if(isset($erromessage) && !empty($erromessage)){?> 
										<div id="errormessage" style="display:block;" class="message" ><?php echo $erromessage; ?></div>
									<?php } ?>
								<div id="texttype" style="display:none;">
											<ul> 
												<li id="dynamicType"><b>Select Booking Type to know more</b>.</li><br />
											</ul>
										</div>
			   
			   					<form id="bookme" name="bookme" onsubmit="return validateForm()" method="post">
											<input type="hidden" id="price" name="price" value="" />
											<div class="row"> 
												<span class="label"><label >First Name</label></span>
                                                <span class="control">
											   <input type="text"  name="first_name" value="<?php if(isset($userArray1[0]['first_name'])){ echo $userArray1[0]['first_name']; }?>" readonly/>
                                               </span>
											</div>
											<div class="row"> 
												<span class="label"><label >Last Name</label></span>
                                                 <span class="control">
												<input type="text" name="last_name" value="<?php if(isset($userArray1[0]['first_name'])){ echo $userArray1[0]['last_name']; }?>" readonly/>
                                                 <span class="control">
											</div>       
											<div class="row"> 
											   <span class="label"><label >Phone Number</label></span>
                                                <span class="control">
											   <input type="text" name="phone_number" value="<?php if(isset($userArray1[0]['first_name'])){ echo $userArray1[0]['phone']; }?>" readonly/>
                                               </span>
											</div> 		
											<div class="row"> 
											  <span class="label"> <label >Email Address</span>
                                               <span class="control">
											   <input type="text" name="email_address" value="<?php if(isset($userArray1[0]['first_name'])){ echo $userArray1[0]['email']; }?>" readonly />
                                               </span>
											</div>
											<div class="row"> 
												<span class="label"><label >Profile Name</label></span>
                                                 <span class="control">
												<input type="text" name="profile_name" value="<?php if(isset($userArray1[0]['first_name']) && isset($userArray1[0]['last_name'])){ echo $userArray1[0]['first_name'].'-'.$userArray1[0]['last_name']; }?>" readonly/>
                                                </span>
											</div> 
												
											<?php 
											$query1 = "SELECT  * FROM `bookingstype` WHERE `id` = '$_GET[typeID]' ";
											$res1 = mysql_query($query1);					
											if(mysql_num_rows($res1)>0) {
												$result = mysql_fetch_assoc($res1);
											$count = '7';?>
											<div class="field_ss row">               
												<span class="label">Booking Type</span>
												<span class="control"> 
													<input type="text" name="book_type" id="book_type" value="<?php echo $result['name'];?>" readonly />
												</span>
											</div> 	
											<?php } else {	?>
											<div class="row"> 
												<span class="label"><label style="margin:0px !important;" >Book Type</label>
												
												</span><span style="margin-left: 12px; color:#9a9a9a;">Booking type is not available.</span>
                                                <span class="control">
												<input type="hidden" name="btype" value='btype'>
                                                </span>
											</div> 
											<?php } ?>		
											<!--<div class="row"> -->
											<!--	<span class="label"><label >Requested Date<b><font color='red'><em>*</em></font></b></label></span>-->
											<!--	<input readonly type="text" name="requeted_date" id="requeted_date" placeholder="mm-dd-yy"  id="txtFromDate" value="<?php if(isset($_POST['requeted_date'])) echo $_POST['requeted_date']; ?>" required/>-->
											<!--</div>	  -->
											<div class="row"> 
												<span class="label"> Requested Time</span>
                                                 <span class="control">
												<div class="start_time"><span class="span_start">Start Date and Time</span><input readonly id="datetimepicker6" type="text" name="start_time" style=" width: 100%;" size="10" value="<?php //if(isset($_POST['start_time'])) echo $_POST['start_time']; ?>"   /></div>
												<div class="start_time"><span class="span_start">End Date and Time</span><input readonly type="text" id="datetimepicker3" size="10"  style=" width: 100%;"  name="end_time" value="<?php //if(isset($_POST['end_time'])) echo $_POST['end_time']; ?>"     /></div>
												</span>
												
											</div>
											<?php  if($type_of_club != "103"){ ?>
											<div class="row"> 

												<span class="label"> Number of Guests</span>
                                                 <span class="control">
												<input type="text" name="number_of_guest" id="frst" value="<?php //if(isset($_POST['number_of_guest'])) echo $_POST['number_of_guest']; ?>"/>
                                                </span>
											</div>
											<?php } ?>
											<div class="row"> 
												<span class="label"><label ><?php if($type_of_club == "103"){ echo "Note"; }else{ echo "Special Request"; }?><b><font color='red'><em> &nbsp;</em></font></b></label></span>
                                                 <span class="control">
												<textarea class="formw" cols="37" rows="8" name="special_request"><?php //if(isset($_POST['special_request'])) echo $_POST['special_request']; ?></textarea>
                                                </span>
											</div>
											<div class="row btncenter bookme_btn">
			                                    					<span class="label">&nbsp;
											<input class="button" style="float:left;" type="submit" id="bookme" name="bookme" value="Submit"/>

												<?php if(isset($_GET['host_id'])){ ?>
													<!--<a href="host_profile.php?host_id=<?php echo $_GET['host_id']; ?>" class="button">Back</a>-->
													<input type="button" onclick="location.href='bookingsTypeDetails.php?host_id=<?php echo $_GET['host_id']; ?>&typeID=<?php echo $_GET['typeID'];?>'" class="button" style="float: right;" value="Cancel">
												<?php } ?>
											</span>
			                                    					<span class="control">
											</span>

											</div>
										</form>
					<?php  }
						else
						{
							$pagestatus = "0";	
							echo "<div class='nostoreview' >";
							if($respagestatus['booking'] == "Disable with message")
							{
								echo "<h1 id='title' style='text-align: center;'>".$respagestatus['bookingmessage']."</h1>";
							}
							if($respagestatus['booking'] == "Disable without message")
							{
								
							}

							echo "</div>";
						}
						?>
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

<Script>
$("#requeted_date").on('blur',function(){
  req_val=$("#requeted_date").val();   
  req_val=req_val.toString();
  $('#datetimepicker6').val( req_val+" 00:00");  
  $('#datetimepicker3').val( req_val+" 00:00");  
  $("#datetimepicker2").focus();
})
</Script>

