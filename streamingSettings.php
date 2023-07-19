<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

// ini_set("display_errors", "1");
// error_reporting(E_ALL);

if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}
if($userType=='user'){
	$Obj->Redirect("profile.php");
}

$titleofpage = "Streaming Settings";

if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}


$qry="select count(*) as total_row from hostsubusers where username='".mysql_real_escape_string($loggedin_host_data['club_name'])."'";
$res=mysql_query($qry) or die("check sub host");
$sub_row = mysql_fetch_assoc($res);

if(isset($_GET['generate_pass']) && $_GET['generate_pass']==1 && $sub_row['total_row']==0 )
{
	
	$loggedin_host_data['club_pass'] = updateClubPassword();
	
	$str = "
		<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
			<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
			<hr>
			<h1 style='color: white;'>Broadcast Detail</h1>
			<p style='color: white;'>You have recently updated your password for broadcasting, Please find below detail to start streaming :</p>
			<p style='color: white;'>
				<b>To broadcast from external encoder like Adobe Flash Media Live Encoder</b><br />
				FMS Url : rtmp://54.174.85.75:1935/httplive?usr=".$loggedin_host_data['club_email']."&amp;pwd=".$loggedin_host_data['club_pass']."<br />
				Stream : ".$loggedin_host_data['club_name']."
			</p>
				<p style='color: white;'> Thank you,<br><br>
				<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'> MYSITTI.COM </a>
				</p>
		</div>
	 ";

	$message = $str; 
	$to  = $loggedin_host_data['club_email'];
	//$to  = "pankaj.saini@kindlebit.com";

	$subject = "MYSITTI.com - Broadcasting Detail";
	$message = $str;
	//$from = "info@mysitti.com";

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: MySitti <mysitti@mysitti.com>' . "\r\n";
	//$headers .= "From:" . $from;

	mail($to,$subject,$message,$headers,"-finfo@mysitti.com");
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/streamingSettings.php');
	$_SESSION['brodcasting_passowrd_update'] = "Live Brodcasting Password Updated Successfully";
	exit;
}	

function updateClubPassword()
{
	$clbpass = generatePassword(10);
	$qry="update clubs set club_pass='".$clbpass."' where id=".$_SESSION['user_id'];
	mysql_query($qry) or die("SQL club pass upd error");
	return $clbpass;
}


if(isset($_POST['submit']))
{
	//echo "<pre>"; print_r($_POST); exit;
	$paid_hosts_cats = array('96', '102', '103');
	$userID = $_SESSION['user_id'];

	if(isset($_POST['enable_streaming_fees']) && $_POST['enable_streaming_fees'] == 'on'){
	//echo $loggedin_host_data['type_of_club']."<br />"; 
		//echo "UPDATE clubs SET streaming_paid = '1' WHERE id = '".$userID."'"; die;

		if (in_array($loggedin_host_data['type_of_club'], $paid_hosts_cats)){
			
			mysql_query("UPDATE clubs SET streaming_paid = '1' WHERE id = '".$userID."'");
			
		}
	
	}else{
		
		mysql_query("UPDATE clubs SET streaming_paid = '0' WHERE id = '".$userID."'");
		
	}
	
	if(!in_array($loggedin_host_data['type_of_club'], $paid_hosts_cats)){

		mysql_query("UPDATE clubs SET streaming_paid = '0', streaming_paid_fess = '' WHERE id = '".$userID."'");
		
	}
	
	if($_POST['savestreaming'] =="on"){ $savestreaming = "1"; } else { $savestreaming = '0'; }
	if($_POST['auto_chat'] ==""){ $auto_chat=""; } else { $auto_chat=trim($_POST['auto_chat']); }
// echo "<pre>"; print_r($_POST); exit;
	if(!empty($_POST['subadmin']))
	{
		$Name = trim(mysql_real_escape_string($_POST['subadmin']));
		$sql1 = mysql_query("SELECT `id` FROM `user` WHERE `profilename` = '$Name'  ");
		if(mysql_num_rows($sql1) > 0)
		{
			$fetchInfo = mysql_fetch_assoc($sql1);
			$SubadminID = $fetchInfo['id'];
			$SubadminType = 'user';
		}
		else
		{
			$sql2 = mysql_query("SELECT `id` FROM `clubs` WHERE `club_name` = '$Name'  ");
			$fetchInfo = mysql_fetch_assoc($sql2);
			$SubadminID = $fetchInfo['id'];
			$SubadminType = 'club';
		}
		mysql_query("UPDATE `clubs` SET `chat_subadmin` = '$SubadminID', `chat_subadmin_type` = '$SubadminType' WHERE `id` = '$_SESSION[user_id]' ");
	//	mysql_query("UPDATE `clubs` SET `chat_subadmin` = '$SubadminID', `chat_subadmin_type` = '$SubadminType' WHERE `id` = '$_SESSION[user_id]' ");


	}


	$update_sql="update clubs set saved_streaming = '$savestreaming', streaming_paid_fess = '$_POST[streaming_fess]',auto_chat = '$auto_chat' where id='$_SESSION[user_id]' ";
	mysql_query($update_sql) or die("SQL club pass upd error");
}




?> 
<script type="text/javascript">
function updatepassword(){
	<?php if($sub_row['total_row']==0){ ?>
		msg="Newly generated password will be sent to registered email address please check your span folder as well to make sure email get delivered.\nAre you sure to continue ?";
	
	if(confirm(msg)){
		window.location = "streamingSettings.php?generate_pass=1";
	}
	<?php }else{ ?>
	msg="Sub host account are not allowed to generate streaming password.Please contact your main host account to get streaming credentials.";
	
	alert(msg);
	
	<?php } ?>
}	
</script>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	 <?php	include('club-right-panel.php');?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos steam-banner">

				<div class="Steam-banner">
					<h3 id="title">Streaming Settings</h3>
							<img src="images/live-stream.png" alt="banner">
							<h3>Live Streaming</h3>
							<p>We know that a common trend is to stream live, so we have designed your profile to be your own reality show. MySitti offers you the ability to stream your shows anytime, but the major benefit is that viewers are able to purchase your music while they watch. As an added incentive to stream your shows, we have created a feature that will allow you to make viewing your show free or charge a small fee. This is an amazing feature allowing you to make money at the venue and online. Bam!!!
							</p>

							<span>We Encourage You to Take Advantage of This Feature.  It’s Free!!!</span>
							</div>

							
				<button id="SVideo_page">Videos</button>
				<button id="TicTrack_page">Ticket Tracking</button>
				<button id="Seting_page" class="active_pagebutton">Settings</button>

					<div class="SVideo_pageClass">
						<?php include('upload_streamingVideo.php'); ?>
					</div>

					<div class="TicTrack_pageClass">
						<?php include('streaming-tickets.php'); ?>
					</div>

					<div class="Seting_pageClass v2_inner_main_content">
  						
					
						<form method="POST" action="" enctype="multipart/form-data" class="addsubuser">
							<div class="edit_profile_f">
								<div id="profile_box" class="StreamingSettingsPage">
									<?php 
										$getClubINfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$_SESSION[user_id]' ");
										$fetchClubInfo = mysql_fetch_assoc($getClubINfo);
										$paid_hosts_cats = array('96', '102', '103');

										if($fetchClubInfo['chat_subadmin'] != 0)
										{
											if($fetchClubInfo['chat_subadmin_type'] == "user")
											{
												$getSubadminSQL = "SELECT `profilename` as profilename FROM `user` WHERE `id` = '$fetchClubInfo[chat_subadmin]' ";
											}
											else
											{
												$getSubadminSQL = "SELECT `club_name` as profilename FROM `clubs` WHERE `id` = '$fetchClubInfo[chat_subadmin]' ";	
											}
											$getSubadmin = mysql_query($getSubadminSQL);
											$getSubAdminINFO = mysql_fetch_assoc($getSubadmin);
										}
									?>
								         	<ul>
										<?php if (in_array($fetchClubInfo['type_of_club'], $paid_hosts_cats)){ ?>
							                                    	<li>
							                                    		<span class="stitle">Pay pre-view</span><div class="clear"></div>
								         			<span>Enter Fees For Streaming</span>
								           			<div class="feestreaming">
								           				<input id="streaming_fess" value="<?php echo $fetchClubInfo['streaming_paid_fess']; ?>" onkeypress="return isNumberKey(event)" placeholder="Enter Amount" type="text" name="streaming_fess"><br />
										
												<?php 
													if($fetchClubInfo['merchant_id'] == "" || $fetchClubInfo['merchant_id'] == " ")
													{
												?>
												
													<script type="text/javascript">
														function check_merchantid() {
															alert("Please fill paypal merchant id to accept payment");
															$('.streaming_fees_checkbox').attr('checked', false);
															$('#streaming_fess').val("");
														}
													</script>
												
													<span><input class="streaming_fees_checkbox" onclick="check_merchantid();" <?php if($fetchClubInfo['streaming_paid'] == '1'){ echo "checked"; } ?> type="checkbox" name="enable_streaming_fees" /> Click here to enable fees</span>
												
											<?php 
													}
													else
													{ 
												?>
														<span><input class="streaming_fees_checkbox" <?php if($fetchClubInfo['streaming_paid'] == '1'){ echo "checked"; } ?> type="checkbox" name="enable_streaming_fees" /> Click here to enable fees</span>
													
											<?php 		} 	?>
		                        								</div>
									           	</li>
												<?php } ?>
									           	<li>
									           		<span class="stitle">Enable Chat with Fans</span><div class="clear"></div>
									           		<input id="auto_chat" type="checkbox" name="auto_chat" value="enable" <?php if($fetchClubInfo['auto_chat'] == "enable"){ echo "checked"; }?> />&nbsp; Enable Auto Chat on Streaming
									           	</li>
									           	<li>
									           		<span class="stitle">Assign Sub-Admin for the chat from your friends:</span><div class="clear"></div>
									           		<input id="subadmin" type="text" name="subadmin" value="<?php echo $getSubAdminINFO['profilename']; ?>" />
									           	</li>
									           	<li>
			                                    						<span class="stitle">Save Streaming Videos</span><div class="clear"></div>
									           		<input id="saveStreamingVideos" type="checkbox" name="savestreaming" <?php if($fetchClubInfo['saved_streaming'] == "1"){ echo "checked"; }?> />&nbsp; Save Streaming
									           	</li>
									         		
								         		<li class="generatePass"><span class="stitle">Third Party Streaming</span><div class="clear"></div><br />
											<p><span style="color:#E74C3C;font-weight:bold;">To broadcast from external encoder like Adobe Flash Media Live Encoder</span></p>		
											<p>
												
												<span style="font-weight:bold;">FMS Url :</span> rtmp://54.174.85.75:1935/httplive?usr=<?php echo "xxxxxxxxxxxx@xxxx.xxx"; //$club_row['club_email'] ?>&amp;pwd=<?php echo "xxxxxxxxxx"; //$club_row['club_pass'] ?><br />
												<span style="font-weight:bold;">Stream :</span> <?php echo $username_dash_separated ?>
											</p>
											<br /><br />		
											<a class="button" href="javascript:void(0);" onclick="updatepassword();" style="">Generate/Change Password for Broadcasting</a>
											<br style="clear:both" />
											<br /> 
											<p style="font-size:12px;color:#fff;">Newly generated password will be sent to registered email address please check your span folder as well to make sure email get delivered.</p>		
										</li>
										<li>
											<input type="submit" name="submit" value="Save Settings" class="button btn" />
										</li>
								         	</ul>
								</div>
							</div>
						</form>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$( "#subadmin" ).keypress(function() {
			var url = $('#siteURL').val();
			var URL = url+'refreshajax.php?action=subadmin&user_type=club';
			//alert(URL);
			$('#subadmin').autocomplete(URL);
		});

		$("#Seting_page").click(function(){
	    	 showDiv1();
		});
		$("#SVideo_page").click(function(){
		     showDiv2();
		});
		$("#TicTrack_page").click(function(){
		     showDiv3();
		});

		function showDiv1()
		{
		 	$(".Seting_pageClass").css({"visibility":"visible","display":"block"});
		 	$(".SVideo_pageClass").css({"visibility":"hidden","display":"none"});
		 	$(".TicTrack_pageClass").css({"visibility":"hidden","display":"none"});
		}
		function showDiv2()
		{
		 	$(".SVideo_pageClass").css({"visibility":"visible","display":"block"});
		 	$(".Seting_pageClass").css({"visibility":"hidden","display":"none"});
		 	$(".TicTrack_pageClass").css({"visibility":"hidden","display":"none"});
		}
		function showDiv3()
		{
			$(".TicTrack_pageClass").css({"visibility":"visible","display":"block"});
		 	$(".Seting_pageClass").css({"visibility":"hidden","display":"none"});
		 	$(".SVideo_pageClass").css({"visibility":"hidden","display":"none"});
		}
		$('.v2_rotate_pos.steam-banner button').on('click',function(){
		  $('button').removeClass('active_pagebutton');
		  $(this).addClass('active_pagebutton');
		});

	});
</script>
<style>
.SVideo_pageClass {
	display: none;
}

.TicTrack_pageClass {
	display: none;
}
.active_pagebutton {
	background: #89a7e5 none repeat scroll 0 0 !important;
	color: white !important;
}
</style>
<?php include('Footer.php'); ?>