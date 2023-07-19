<?php
//error_reporting(E_ERROR | E_WARNING | E_NOTICE);

include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage = "Bookings";

if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($userID)){
	$Obj->Redirect("index.php");	
}

if($userType=='user'){
	$Obj->Redirect("index.php");
}

$userID=$_SESSION['user_id'];
$readstatus = "UPDATE `bookings` SET `read_status` = '1' where `host_id` = '".$userID."'";
mysql_query($readstatus);

if($_GET['page'] == edit)
      {
	//echo "edit";
	$return = "true";
	$pagename_edit = 'Edit Booking';
      }
elseif($_GET['page'] == del)
      {
	   mysql_query("DELETE FROM `bookings` WHERE `bookings`.`id` = '".$_GET['id']."'");
	   $message="Booking status deleted successfully.";
      } 
 $hostquery = "select * from `clubs` where `id` = '".$userID."'";
$hostArray = $Obj->select($hostquery);	
$userArray = $Obj->select($hostquery);	


if(isset($_GET['page']) && $_GET['page']=="edit"){
$titleofpage="Edit Bookings";
}else if(isset($_GET['page']) && $_GET['page']=="add"){
$titleofpage="Bookings";

}
 
	if(isset($_GET['host_id']))
	{
		$hostID1 = $_GET['host_id'];
	}
	else
	{
		$hostID1 = $_SESSION['user_id'];
	}
	
	if(isset($_POST['savesetting']))
	{
		// echo "<pre>"; print_r($_POST); die;
		$value = $_POST['function'];
		if($value == "Disable with message")
		{
			$m = $_POST['bookingmessage'];
		}
		else
		{
			$m = "";
		}
		
		$getq1 = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_SESSION['user_id']."'  ");
		$countrec1 = @mysql_num_rows($getq1);

		if($countrec1 > 0)
		{
			@mysql_query("UPDATE `host_functions_setting` SET `booking` = '$value', `bookingmessage` = '$m' WHERE `host_id` = '".$hostID1."'  ");
		}
		else
		{
			@mysql_query("INSERT INTO `host_functions_setting` (`host_id`,`booking`,`bookingmessage`) VALUES ('".$hostID1."','$value','$m')  ")	;
		}
		$message = 'Bookings Display Settings is Saved.';

	}
?>
<style>
table.display td {text-align:center;}
</style>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   
		if(!isset($_GET['host_id']))
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
				<div class="v2_rotate_pos booking">
					<div class="booking-banner">
						<h3 id="title">Bookings</h3>
							<img src="images/booking-banner.png" alt="banner">
							<h3>Bookings</h3>
							<p>
	We have created a booking feature that allows you to look professional to people who are looking to book you.
							</p>

							<span>We Encourage You to Take Advantage of This Feature.  It’s Free!!!</span>
							</div>
				<button id="BReqs_page" class="active_pagebutton">Booking Requests</button>
				<button id="BType_page">Booking Types</button>
				<button id="BSett_page">Booking Settings</button>

					<div class="BType_pageClass">
						<?php include('bookingstype.php'); ?>
					</div>

					<div class="BSett_pageClass">
						<?php include('bookingSettings.php'); ?>
					</div>

					<div class="BReqs_pageClass v2_inner_main_content">

							<h3 id="title"><?php if(isset($pagename_edit)){ echo $pagename_edit;}else{ echo "Bookings";} ?></h3>

							<?php
							if($return == "true")
							{
							if(isset($_POST['update_booking_status']))
							{
							//echo "<pre>";
							//print_r($_POST);die();
							$date = $_POST['date']; //date('y-m-d',strtotime('-1 day', strtotime($date)))

							 $date = str_replace('/', '-', $date);
							 $date=date('Y-m-d', strtotime($date));
							$current = date('Y-m-d');
								
							if(strtotime(date('Y-m-d', strtotime($current .' -1 day'))) < strtotime($date)){ //echo $date;die('sagasdfgsadf');
								  $names = explode(" ", $_POST['name']);
								
								  mysql_query("UPDATE `bookings` SET  `requeted_date` = '$date',  `status` = '$_POST[status]' WHERE `bookings`.`id` = '".$_GET['id']."'");
								  $message = "Booking status updated successfully.";
								  $send = mysql_query("Select u.email from user as u INNER JOIN bookings as b ON b.user_id = u.id where b.id  = '".$_GET['id']."'");
								  $msg = '1';
								  $send_email = mysql_fetch_array($send);
									
								 //echo '<pre>';print_r($send_email);die;  
								   if($send_email['email']){
									   $date = $_POST['date'];
										
										
										  $to = $send_email['email'];
										 //$to = 'villiam.choudhary@kindlebit.com';
										   $subject = "Thanks For Booking Updation";
										   $txt   = " HI ". $send_email['email'].",</br>";
										   $txt  .= " Your Booking detail are updated by host.</br>";
										   $txt  .= " Booking Type :" .$_POST['type']."<br>";
										   $txt  .= " Booking Status is : " . $_POST['status']."</br>";
										   $txt  .= "Booking date  : " . $_POST['date']."<br>";
										   $txt  .= "Thanks<br>";
										   $headers = "From: mysittidev.com" . "\r\n" .		
											"Content-type: text/html"."\r\n";

										   mail($to,$subject,$txt,$headers);
										  
											header('location:bookings.php?msg='.$msg);
										
									}
								} else { //echo $date;die('234234');
									$message = 'Please enter future date.';	
								}
							}
							$edit_requests = "SELECT `book`.*,u.*, `book`.`status` as bookingstatus FROM `bookings`as book, `user` as u  WHERE `book`.`id` = '".$_GET['id']."' AND book.user_id = u.id order by book.id desc";

							$edit_requests_results_query = mysql_query($edit_requests);
							$edit_requests_results = mysql_fetch_array($edit_requests_results_query);

							$adressquery = @mysql_query("SELECT cc.city_name as city, z.name as state, cnt.name as country FROM capital_city as cc, zone as z, country as cnt WHERE `cc`.`city_id` = '".$edit_requests_results['city']."' AND z.zone_id = '".$edit_requests_results['state']."' AND cnt.country_id = '".$edit_requests_results['country']."' AND cnt.country_id = z.country_id AND cc.state_id = z.zone_id  ");
							$address = @mysql_fetch_array($adressquery);
							?>
							<?php if(isset($message)){?>
								<div  style="display:block;"id="errormessage" class="message" ><?php echo $message;?></div> 
								<?php } ?>

							<form class="bookings_show" action="" method="post">
								<div class="row">
									<span class="label">Date</span>
									<span class="formw" >
									
									<input type="text" name="date" id="datecheck"  class="date" value="<?php if(isset($_POST['date'])){ echo $_POST['date']; }else{ if($edit_requests_results['requeted_date'] == '0000-00-00 00:00:00'){ echo "";}else{ echo $edit_requests_results['requeted_date'];} } ?>" /><br />
									</span>
								</div>
								<div class="row">
									<span class="label">First Name</span>
									<span class="formw flds" >
									<?php echo $edit_requests_results['first_name'];?>
									
									</span>
								</div>
								<div class="row">
									<span class="label">Last Name<font color='red'></font></span>
									<span class="formw flds" >
									<?php echo $edit_requests_results['last_name'];?>
									
									</span>
								</div>
								
								<div class="row">
									<span class="label">Phone Number</font></span>
									<span class="formw flds" >
									<?php echo $edit_requests_results['phone'];?>
									<!--input type="text" name="name" class="" value="<?php echo $edit_requests_results['first_name']. " " .$edit_requests_results['last_name']?>"--><br />
									</span>
								</div>
								<div class="row">
									<span class="label">Email</font></span>
									<span class="formw flds" >
									<?php echo $edit_requests_results['email_address'];?>
									<!--input type="text" name="name" class="" value="<?php echo $edit_requests_results['first_name']. " " .$edit_requests_results['last_name']?>"--><br />
									</span>
								</div>
								<div class="row">
									<span class="label">Profile Name<font color='red'></font></span>
									<span class="formw flds" >
									<?php echo $edit_requests_results['first_name']. "-" .$edit_requests_results['last_name']?>
									<!--input type="text" name="name" class="" value="<?php echo $edit_requests_results['first_name']. " " .$edit_requests_results['last_name']?>"--><br />
									</span>
								</div>
								<div class="row">
									<span class="label">Address<font color='red'></font></span>
									<span class="formw flds" >
									<?php echo $address['city'].", ".$address['state']." ".$edit_requests_results['zipcode'].", ".$address['country'];?>
									<!--input type="text" name="name" class="" value="<?php echo $edit_requests_results['first_name']. " " .$edit_requests_results['last_name']?>"--><br />
									</span>
								</div>
									
								<div class="row">
									<span class="label">Type<font color='red'></font></span>
									<span class="formw flds" >
									<?php echo $edit_requests_results['book_type'];?>
									<!--input type="text" name="type" class="" value="<?php echo $edit_requests_results['book_type']?>"--><br />
									</span>
								</div>
								<div class="row">
									<span class="label">Price<font color='red'></font></span>
									<span class="formw flds" >
									<?php 
										if($edit_requests_results['price'] != '0')
										{
											echo '$'.$edit_requests_results['price'];
										}
										else
										{
											echo "";
										}
									?>
									<!--input type="text" name="type" class="" value="<?php echo '$'.$edit_requests_results['price']?>"--><br />
									</span>
								</div>
								<div class="row">
									<span class="label">Requested Time<font color='red'></font></span>
									<span class="formw flds" >
									<?php
										if($edit_requests_results['start_time'] != "0000-00-00 00:00:00" && $edit_requests_results['end_time'] != "00000-00-00 00:00:00" )
										{ 
											echo date('F j, H:i',strtotime($edit_requests_results['start_time']))." &nbsp;&nbsp; to  &nbsp;&nbsp; ".date('F j, H:i',strtotime($edit_requests_results['end_time']));
										}
										else
										{
											echo " Not available ";
										}
									?>									<!--input type="text" name="name" class="" value="<?php echo $edit_requests_results['first_name']. " " .$edit_requests_results['last_name']?>"--><br />
									</span>
								</div>
								<div class="row">
									<span class="label">Number Of Guests<font color='red'></font></span>
									<span class="formw flds" >
									<?php echo $edit_requests_results['number_of_guest'];?>
									<!--input type="text" name="name" class="" value="<?php echo $edit_requests_results['first_name']. " " .$edit_requests_results['last_name']?>"--><br />
									</span>
								</div>
								<div class="row">
									<span class="label">Special Request<font color='red'></font></span>
									<span class="formw flds" >
									<?php echo $edit_requests_results['special_request'];?>
									<!--input type="text" name="name" class="" value="<?php echo $edit_requests_results['first_name']. " " .$edit_requests_results['last_name']?>"--><br />
									</span>
								</div>
								<div class="row">
									<span class="label">Status<font color='red'>*</font></span>
									<span class="formw" >
									
										<select name="status" class="">
										<?php if($edit_requests_results['bookingstatus'] == 'New'){ ?>
										<option value="Accept">Accept</option>
										<option value="Pending" selected>Pending</option>
									<?php  } elseif($edit_requests_results['bookingstatus'] == 'Acknowledge'){ ?>
										<option value="Accept">Accept</option>
										<option value="Pending" selected>Pending</option>
									<?php } elseif($edit_requests_results['status'] == 'Confirm'){ ?>
										<option value="Accept" selected>Accept</option>
										<option value="Pending" >Pending</option>
									
									<?php } elseif($edit_requests_results['bookingstatus'] == 'Done'){ ?>
										<option value="Accept" selected>Accept</option>
										<option value="Pending" </option>
									
									<?php } elseif($edit_requests_results['bookingstatus'] == 'Cancel'){ ?>			
										<option value="Accept">Accept</option>
										<option value="Pending" selected>Pending</option>
									<?php } elseif($edit_requests_results['bookingstatus'] == 'Accept'){ ?>			
										<option value="Accept" selected>Accept</option>
										<option value="Pending" >Pending</option>
									<?php } else if($edit_requests_results['bookingstatus'] == 'Pending'){ ?>			
										<option value="Accept">Accept</option>
										<option value="Pending" selected>Pending</option>
									<?php } else{?>			
									   <option value="Accept">Accept</option>
										<option value="Pending" selected>Pending</option>
										
										<?}?>
									</select><br />
									</span>
								</div>
									
									<div class="row">
									<span class="label"></span>
									<span class="formw updates" style="width: 100%;">		
										<input type="submit" name="update_booking_status" class="button btn_ss" value="Update">
										<input type="button" class="button btn_ss" onclick="window.location='bookings.php';" value="Back">	
									</select><br />
									</span>
								</div>
									<!--<span class="lable">Status:</span> 	<input type="text" name="status" class="" value="<?php //echo $edit_requests_results['status']?>">-->
									
										

								</form>		
							<?php }  else {
								if(isset($_GET['msg'])){ 
							?>

							<div style="display:block;" id="successmessage" class="message" >Booking status updated successfully. </div> 
							<?php } else { if(isset($message)){?>
								<div  style="display:block;" id="successmessage" class="message" ><?php echo $message;?></div> 
								<?php } }
								
								/* update notification*/
							$readstatus = "UPDATE `bookings` SET `read_status` = '1' where `host_id` = '".$userID."'";
							mysql_query($readstatus);
							/* update notification*/

							 $booking_requests = "SELECT `id`,`requeted_date`,`first_name`,`last_name`,`book_type`,`price`,`status` FROM `bookings` WHERE `host_id` = '".$userID."' order by id desc";
							$booking_requests_results = @mysql_query($booking_requests);
							$count = @mysql_num_rows($booking_requests_results);
							$class="";	
							if($count > 9)
							{
								$class = " class='scroll_Div1 '";
							}
							else
							{
								$class = " class='scroll_Div1 '";	
							}
								
								
								?>

							<div <?php echo $class;?>>
<div class="autoscroll">
							 <table class='display' id='booktype' >
									<thead>
									<tr bgcolor='#ACD6FE'>
									
										<th>Date</th>
										<th>Name</th>
										<th>Type</th>
										<!--<th>Price</th>-->
										<th>Status</th>
										<th>Action</th>
									   
									   
									</tr>
									</thead>
									<tbody> 
            
							<?php




							if($count == 0)
							{
								echo "<tr class='odd'><td colspan='5'> No Bookings available. </td></tr>"  ; 
							}
							else {
							$i=1;
							 while($res = mysql_fetch_array($booking_requests_results))
											{// echo '<pre>';print_r($res);die;
										if($i%2 == '0')
										{
											$class = " class='even' ";
										}
										else
										{
											$class = " class='odd' ";
										}
										   // echo $res['requeted_date'];die;
											
											$date = str_replace('/', '-', $res['requeted_date']);
											$date1=date('Y-m-d', strtotime($date));
												
											 ?>
									  <tr <?php echo $class; ?>>
										<td>
											<?php 
												if($res['requeted_date'] != "1969-12-31" && $res['requeted_date'] != "0000-00-00" )
												{
													echo date('M d,Y',strtotime($date1)); 
												}
												else
												{
													echo "&nbsp;";
												}
											?>
										</td>
										<td><?php echo $res['first_name']." ".$res['last_name']; ?></td>
										<td><?php echo $res['book_type']; ?></td>
										<!--<td><?php echo '$'.$res['price']; ?></td>-->
										<td><?php 	if(($res['status'] == "New") || ($res['status'] == "Acknowledge") || ($res['status']=="Pending") || ($res['status']=="Cancel"))
													{
														echo "Pending";
													} 
													else 
													{
														echo "Accept";
													} 

											?></td>
										<td style="text-align:center;" class="deledit_btns">
										<?php echo "<a href=?page=edit&id=".$res['id'].">
										<img src='images/Edit.png' width='25px' title='Edit' height='25px'></a>
										<a href=?page=del&id=".$res['id']." onclick='return confirm(\"Are you sure you want to delete?\")'>
										<img src='images/del.png' width='25px' title='Delete' height='25px'></a>"; ?>
										</td>		
								
									  </tr>
									<?php $i++; }
							} /*end else*/?>

							  
							  </tbody>
								</table>
							 				</div>  
								</div>
								


							<?php }?>				
					
					</div>
				</div>
			</div>
		</article>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){

	$("#BReqs_page").click(function(){
	     showDiv1();
	});
	$("#BType_page").click(function(){
	     showDiv2();
	});
	$("#BSett_page").click(function(){
	     showDiv3();
	});

	if(document.URL.indexOf("page=add") !== -1 || document.URL.indexOf("page=edit") !== -1 || document.URL.indexOf("page=del") !== -1)
	{
		$(".BType_pageClass").css({"visibility":"visible","display":"block"});
	 	$(".BReqs_pageClass").css({"visibility":"hidden","display":"none"});
	 	$(".BSett_pageClass").css({"visibility":"hidden","display":"none"});
	}
	function showDiv1()
	{
	 	$(".BReqs_pageClass").css({"visibility":"visible","display":"block"});
	 	$(".BType_pageClass").css({"visibility":"hidden","display":"none"});
	 	$(".BSett_pageClass").css({"visibility":"hidden","display":"none"});
	}
	function showDiv2()
	{
	 	$(".BType_pageClass").css({"visibility":"visible","display":"block"});
	 	$(".BReqs_pageClass").css({"visibility":"hidden","display":"none"});
	 	$(".BSett_pageClass").css({"visibility":"hidden","display":"none"});
	}
	function showDiv3()
	{
		$(".BSett_pageClass").css({"visibility":"visible","display":"block"});
	 	$(".BReqs_pageClass").css({"visibility":"hidden","display":"none"});
	 	$(".BType_pageClass").css({"visibility":"hidden","display":"none"});
	}

	$('.v2_rotate_pos.booking button').on('click',function(){
	  $('button').removeClass('active_pagebutton');
	  $(this).addClass('active_pagebutton');
	});
	

});
</script>
<style>
.BType_pageClass {
	display: none;
}

.BSett_pageClass {
	display: none;
}
.active_pagebutton {
	background: #89a7e5 none repeat scroll 0 0 !important;
	color: white !important;
}
</style>

<?php include('LandingPageFooter.php'); ?>