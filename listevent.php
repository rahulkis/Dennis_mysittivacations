<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage = " List Events";

if(!isset($_SESSION['user_id']))
{
	include('PublicProfileHeader.php');
}
else
{
	if(isset($_GET['host_id']))
	{
		include('NewHeadeHost.php');
	}
	else
	{
		include('NewHeadeHost.php');	
	}
}

if(isset($_GET['host_id']))
{
	$userID=$_GET['host_id'];
}
else
{
	$userID=$_SESSION['user_id'];
}

$userType= $_SESSION['user_type'];

// if(!isset($_SESSION['user_id'])){
// 	$Obj->Redirect("index.php");
// }

if($userType=='club'){
$userOrhost=" AND host_id ='$userID'";
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql);

if($userType=="club" && $userArray[0][type_of_club]!=11){
//$Obj->Redirect("home_club.php");
}
$type_of_user="club";
}else if($userType=='user'){
if(!isset($_GET['host_id'])){
//$Obj->Redirect("index.php");
}
$type_of_user="user";
$hostID=$_GET['host_id'];
$userOrhost=" AND host_id ='$hostID'";
$sql = "select * from `clubs` where `id` = '".$hostID."'";
$userArray = $Obj->select($sql) ;
$type_of_club =$userArray[0]['type_of_club'];
if($userType=="user" && $type_of_club!=11){
//$Obj->Redirect("host_profile.php?host_id=".$hostID);
}

}

if (strpos($_SERVER['HTTP_REFERER'],'editevent.php') !== false) {
	if(isset($_GET['county']) && isset($_GET['state']) && isset($_GET['city'])){
		
		$_SESSION['id'] = $_GET['city'];
		$_SESSION['state'] = $_GET['state'];
		$_SESSION['country'] = $_GET['county'];
	}
}


if(isset($_GET['action']) && $_GET['action'] == 'AskShare' )
{

?>
	<div class="bgpopup_overlay" style="top:20px;">
		<div id="popup2" class="enter_contest" style="z-index:200;display:block;" > 
			<!-- <span class="button b-close">X</span> -->
			<div id="mycontent" style="height: auto; width: auto;"> 
				<div class="space" id="wrapper">
                   	<div class="content1" style="margin:0px;">
						<div id="title" style="border-bottom: 1px solid #808080;color: #FECD07;font-size: 17px;height: 42px;width: 100%;">Where You want to Share your <?php echo $details['forum']; ?> Event ?</div>
						<div style=" color: #D4D4D4 !important;" class="content_txt">
							<form action="" method="POST">
								<div class="type_of_subcats">
								 
									<a style="padding:0 5px 0 0;" href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php echo $ShareFacebookURl;?>&pubid=ra-5208c23564631929&ct=1&title=<?php echo $details['forum']; ?>&pco=tbxnj-1.0" target="_blank">
										<img style="border-radius: 5px;" src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"/>
									</a>
								 
							 
									<a style="padding:0 5px 0 0;" href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo $ShareFacebookURl;?>&pubid=ra-5208c23564631929&ct=1&title=<?php echo $details['forum']; ?>&pco=tbxnj-1.0" target="_blank">
										<img style="border-radius: 5px;"src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"/>
									</a>
						 
							 
									<span class='st_email_large' displayText='Email'></span>
									 
								</div>
								<div class="submitCats">
	  								<input type="button" value="Close" onclick="hidePop();"  class="button btn">
								</div>
							</form>
						</div>	
					</div>
           				</div>
			</div>
	  	</div>
	</div>
	<div class="b-modal" id="b-modal __b-popup1__" style="display:block;"></div>
	<script type="text/javascript">
		function hidePop()
		{
			$('.b-modal, .bgpopup_overlay').hide();

		}
		
	</script>
<style type="text/css">
.bgpopup_overlay {
  
  height: 154px;
  left: 0;
  margin: auto;
  max-width: 400px;
  padding: 20px;
  position: fixed;
  right: 0;
  top: 100px !important;
  z-index: 2147483647;
}
#popup, #popup2, #popup3, .bMulti {  padding:5px 5px 20px !important; overflow: auto;}
.content_txt p {
  margin-bottom: 10px;
  text-align: left;
  line-height: normal;
}
.agreebuttons .button {
  float: left;
}
#mycontent .agreebuttons {
  padding: 20px 0;
}
 @media only screen and (max-width:540px){
 #popup2 {  padding:10px !important; max-width:260px; margin:auto; max-height:300px; overflow:auto;}
 }

.type_of_subcats {
  display: table;
  float: none;
  margin: auto;
  padding: 10px;
  width: 130px;
}

.type_of_subcats > span {
  display: inline;
  float: left;
  width: 0;
}

.categoryList {
	float: left;
	text-align: left;
	width: 100%;
}
.categoryList > li {
  float: left;
  padding: 10px;
  width: 45%;
}
.submitCats {
  float: left;
  margin: 20px 0;
  width: 100%;
}
#popup2 {
  box-sizing: border-box;
  height: auto !important;
  max-height: auto !important;
  padding: 15px !important;
}
.type_of_subcats a {
  border: 0 none;
  float: left;
  margin: 0 10px 0 0;
  padding: 0;
  width: auto;
}
.content1 div#title {
  height: auto !important;
  margin-bottom: 10px;
  padding-bottom: 10px;
  text-transform: uppercase;
  font-size: 16px !important;
}
</style>
<?php



}











//include('headhost.php');
//include('header.php');

//if($userType=='club'){
//	include('headerhost.php');
//}

if(isset($_SESSION['eventadded'])){
	$message['success'] = "Event added successfully. ";
	unset($_SESSION['eventadded']);
	
}
if(isset($_SESSION['eventedited'])){
	$message['success'] = "Event updated successfully. ";
	unset($_SESSION['eventedited']);
	
}
if(isset($_SESSION['eventdeleted'])){
	$message['success'] = "Event deleted successfully. ";
	unset($_SESSION['eventdeleted']);
	
}

// include 'googleplus-config.php';
if(isset($_REQUEST['id']))
{
	$UserID=$_REQUEST['id'];
}
else 
{
	$UserID=$_SESSION['user_id'];	
}
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
.spacer50 {
  margin-top: 0;
  padding-top: 20px;
}
</style>
<?php

  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
elseif(isset($_REQUEST['host_id']))
{
	$userID=$_REQUEST['host_id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
?>

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
		<div class="v2_rotate_pos">
		  <div class="v2_inner_main_content">
			<a href="eventscalendar.php"><h3 class="calList">Calendar</h3></a>
					<a href="listevent.php"><h3 class="listCaln">List</h3></a>
			<?php if($message['success'] != ""){ 
								echo '<div style="display:block;" id="successmessage" class="message" >'.$message['success']."</div>";
								}
								if($message['error'] != ""){ 
								echo '<div style="display:block;" id="errormessage" class="message" >'.$message['error']."</div>";
								} 	?>
			<div id="demosss">
			  <div class="upcomin_venue_div"> <span class="upcomin_venue_spn"></span>
				<div style="margin: 0px auto; width: 100%; text-align: center;">
				  <div class="clear"></div>
				  <div id="addEvents">
					<?php if($userType=="club") {?>
					<a href="addevent.php" class="button btn_add_venu"><i>Add Event</i><span> <img src="images/addevent.png" alt=""></span></a></div>
				  <?php }?>
				</div>
			  </div>
			  <?php
								   if(isset($success)) { ?>
			  <div style="color:#060"><?php echo $success ?></div>
			  <?php }
			$sql = 'SELECT * FROM `events` WHERE date >= CURDATE() AND host_id = '.$userID.' ORDER BY date ASC';

								/* to count  event */
								$retval = mysql_query($sql);
								$numResults = mysql_num_rows($retval);
								?>
			</div>
			<div id="listvenue_tab">
			  <?php if($numResults > 9)
							{
								$class = " class='scroll_Div1 '";
							}
							else
							{
								$class= "class='scroll_Div1no '";
							}
							if($numResults)
							{
						?>
			  				<div <?php //echo $class;?>>
								<div class="eventsListNew">
								<?php 
								while($row1 = mysql_fetch_array( $retval))
								{
									$getForumId = mysql_query("SELECT forum_id FROM `forum` WHERE `event_id` = '$row1[forum_id]'");
									$fetchForumId = mysql_fetch_assoc($getForumId);
								?>
				  					<div class="dj_event_list post_container home_club_posts fight-post">
										
										<div class="fight_post fight-left-post v2_post_container">
					  						<div class="content width_100" id="forumcontent"> 
					  							<a href="<?php echo str_replace("../", '', $row1['event_image']); ?>" class="fancybox" rel="group"> 
					  								<img src="<?php echo str_replace("../", '', $row1['event_image_thumb']); ?>" alt=""> 
					  							</a> 
					  						</div>
										</div>



										<div class="fight_post fight-right-post v2_post_info">
						  					<h1>
												<p><?php echo $row1['eventname']; ?></p>
						  					</h1>
						  					<div class="postDate">
												<!-- <div class="date1"><?php echo date('M',strtotime($row1['date'])); ?></div>
												<div class="date2"><?php echo date('d',strtotime($row1['date'])); ?></div>
												<hr>
												<div class="date3"><?php echo date('D',strtotime($row1['date'])); ?></div>
												<div class="date4"><?php echo date('h:i',strtotime($row1['date'])); ?></div>
												<div class="date5"><?php echo date('a',strtotime($row1['date'])); ?></div> -->
												<ul>
						  							<li><?php echo date('l',strtotime($row1['date'])); ?>, <?php echo date('F',strtotime($row1['date'])); ?> <?php echo date('d',strtotime($row1['date'])); ?>, <?php echo date('Y',strtotime($row1['date'])); ?></li>
						  							<li><?php echo date('h:i',strtotime($row1['date'])); ?> <?php echo date('a',strtotime($row1['date'])); ?></li>
					  							</ul>
											</div>

						  					<div class="location">
												<p> 
													<span class="address_event">
														<?php echo $row1['event_address'];?>
													</span>
													<br>
												</p>
												<p> 
													<a target="_blank" title="Map" onclick="goto('event_map.php?add=<?php echo $row1['id']?>&amp;action=forum');" class="map">
														Map
													</a> 
												</p>
												<div style="clear:both"></div>
												</br>
												<p class="discription"> 
												<?php 
													$stringdescription = (strlen($row1['description']) > 100) ? substr($row1['description'],0,100).'...' : $row1['description'];
													echo $stringdescription;
												?>
												</p>
												<div class="clear"></div>
												
												<div class="ShowTicket listtickets"> 
													<?php 
														if(strlen($row1['description']) > 100)
														{
													?>		<a class="moreRead " onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row1['id'] ?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">Read More...</a> 
													<?php 	}	
													$check_ticket = mysql_Query("SELECT * FROM streaming_tickets WHERE event_id = '".$row1['id']."'");
													$count_ticket_check = mysql_num_rows($check_ticket);

													/* PAID PASSES QUERY */
													$getPaidpass = mysql_query("SELECT * FROM `paid_passes` WHERE `event_id` = '$row1[id]' ");
													$fetchRecords = mysql_fetch_assoc($getPaidpass);
													$countPaidpasses = $fetchRecords['no_of_tickets'];
													$currDate = strtotime(date('Y-m-d H:i:s'));
													$expiryPass = strtotime($fetchRecords['expiry_date']);

													if( ($count_ticket_check == "1" || $countPaidpasses > 0) && $_SESSION['user_type'] == 'user')
													{

														if($countPaidpasses > 0 && $fetchRecords['pass_status'] == "active" && ( $expiryPass > $currDate) )
														{
															$HostID = $_GET['host_id'];
															$get_str_host_email = mysql_query("SELECT `merchant_id` FROM `clubs` WHERE `id` = '$HostID' ");
															$count_email = mysql_num_rows($get_str_host_email);
														
														if($count_email < 1)
														{
															
															$host_email = "";
															
														}
														else
														{
															
															$set_host_email = mysql_fetch_assoc($get_str_host_email);
															$host_email = $set_host_email['merchant_id'];
															
														}
														
														$hide_btn = "style='display: none;'";
														
														$payment_amount =  trim(str_replace("$",'',$fetchRecords['amount']));
														$host_email_set = $host_email;
														$item_name = "Buy Ticket";
														?>
														<a  class=" "  href="buyStageTicket.php?host_id=<?php echo $HostID.'&str_amt='.$payment_amount.'&user_type='.$_SESSION['user_type'].'&passid='.$fetchRecords['pass_id'].'&event_id='.$row1['id']; ?>">
															 Show Ticket
														</a>
													<?php

													}

													/**** check streaming ticket exists ****/

													if($count_ticket_check == 1 && $_SESSION['user_type'] == 'user')
													{
														
														$get_ticket_id = mysql_fetch_assoc($check_ticket);
														$ticket_id = $get_ticket_id['ticket_id'];
														
														$check_user_purchased_ticket = mysql_query("SELECT * FROM streaming_tickets_purchased WHERE ticket_id = '".$ticket_id."' AND buyer_user_id = '".$_SESSION['user_id']."' AND buyer_user_type = '".$_SESSION['user_type']."' AND event_id = '".$row1['id']."'");
														$count_downloaded_ticket = mysql_num_rows($check_user_purchased_ticket);
														if($count_downloaded_ticket < 1)
														{ 
													?>
															<a class="" href="OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php echo $_GET['host_id']; ?>&user_type=club&ticket_id=<?php echo $ticket_id; ?>&event_id=<?php echo $row1['id']; ?>">
															 Streaming Ticket
															</a> 
																						
													<?php
														}
														else
														{ 
													?>
															<a class="moreRead" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row1['id'] ?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">Already Purchased</a> 
													
													<?php }
													}
													/**** check ticket exists ****/
												}
													?>
												</div>
												<div class="buynow"> 
												</div>
												<p></p>
					  						</div>
					  					<!-- END location--> 
										</div>
										<?php 
											if($_SESSION['user_type'] == 'club' AND !isset($_GET['host_id']))
											{
										?>
												<div class="Settings"> 
												
													<!-- <a href="<?php echo $SiteURL;?>editevent.php?edit=<?php echo $row1['id']; ?>"> 
														<img title="Edit Event" src="images/editEvent.png">
													</a> --> 
             	<a href="javascript:void(0);" onClick="delrecoreds('<?php echo $row1['id']; ?>');">
														<img title="Delete Event" src="images/delEvent.png">
													</a> 
												</div>
										<?php 	}
											else
											{
										?>		
												<div class="Settings"> 
													<a href="<?php echo $SiteURL;?>read_event.php?host_id=<?php echo $_GET['host_id'];?>&event_id=<?php echo $row1['id']; ?>">View</a>
												</div>
										<?php
											}
										?>
				  					</div>
				  			<?php 	} // ENDWHILE	?>
				  					
								</div><!-- END eventsListNew -->
							</div><!-- END count records -->
			  		<?php 	} //END count records
		  				else
	  					{
	  				?>
							<div <?php echo $class;?>>
								<div class="eventsListNew">
									<div class="NoRecordsFound" id="NoRecordsFound">No Events Yet !</div>
								</div>
							</div>
					<?php  } ?>
					<input type="hidden" id="hostid" value="<?php if(isset($_GET['host_id'])){ echo $_GET['host_id']; }else{ echo $userID; } ?>">
					<input type="hidden" id="hostOruser" value="<? echo $userType;?>">
			  		<img src="images/ajax-loader.gif" style="display:none;" id="loader"> 
			  	</div><!-- END listvenue_tab -->
			<?php if(isset($_GET['host_id'])){	   
				   $referrer = $_SERVER['HTTP_REFERER'];	   
				   if (strpos($referrer,'host_profile')) { ?>
			<div style="float:right;"> <a href="host_profile.php?host_id=<?php echo $_GET['host_id']; ?>" class="button backmargn">Back </a> </div>
			<?php } else { ?>
			<div style="float:right;"> <a href="eventscalendar.php?host_id=<?php echo $_GET['host_id']; ?>" class="button backmargn">Back </a> </div>
			<?php }  }else{ ?>
			<div style="float:right;">
			  <input onclick="location.href='eventscalendar.php'" type="button" value="Back" style="float: right; margin-top: 10px;" class="button">
			</div>
			<?php } ?>
			<script language="javascript">	
					function  disables()
					{
						if(jQuery('#eventname').val()!='' && jQuery('#eventDate').val()!='' && jQuery('#description').val()!=''){	
						jQuery("#addevent").attr('disabled',true);
						jQuery('#addeventform').submit();
					}
					}	
					 function cancelEdit(){
					   window.location='listevent.php'
					 } 
					 

					function delrecoreds(id)
					{
						  $val= jQuery('#current_month_for_venue').val();
							$current_year= jQuery('#current_year_for_venue').val(); 
						   

					  if(confirm('Are You sure You want to delete this record'))
					  {
						  
						 $.get( "deleteevent.php?id="+id+"&month="+$val+"&year="+$current_year, function( data ) {
							window.location='listevent.php';
							});
					  }
					   else
					   {
						
						}

					}
					</script> 
		  </div>
		</div>
	  </div>
	</article>
  </div>
</div>
<?
include('Footer.php');

unset($_SESSION['year_Edit']);
unset($_SESSION['month_Edit']);

