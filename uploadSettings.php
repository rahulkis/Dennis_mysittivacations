<?php
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

// ini_set("display_errors", "1");
// error_reporting(E_ALL);

if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}
if($userType=='user'){
	$Obj->Redirect("profile.php"); die;
}

$titleofpage = "Uploads Settings";



$message = "";
$qry="select count(*) as total_row from hostsubusers where username='".mysql_real_escape_string($loggedin_host_data['club_name'])."'";
$res=mysql_query($qry) or die("check sub host");
$sub_row = mysql_fetch_assoc($res);


function updateClubPassword()
{
	$clbpass = generatePassword(10);
	$qry="update clubs set club_pass='".$clbpass."' where id=".$_SESSION['user_id'];
	mysql_query($qry) or die("SQL club pass upd error");
	return $clbpass;
}




if(isset($_POST['savesetting']))
{
	$hostID1 = $_SESSION['user_id'];
	$value = $_POST['function'];
	if($value == "Disable with message")
	{
		$m = $_POST['uploadsmessage'];
	}
	else
	{
		$m = "";
	}
	
	$getq1 = mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_SESSION['user_id']."'  ");
	$countrec1 = @mysql_num_rows($getq1);

	if($countrec1 > 0)
	{
		//echo "UPDATE `host_functions_setting` SET `uploads` = '$value', `uploadsmessage` = '$m' WHERE `host_id` = '".$hostID1."'  "; exit;
		mysql_query("UPDATE `host_functions_setting` SET `uploads` = '$value', `uploadsmessage` = '$m' WHERE `host_id` = '".$hostID1."'  ");
	}
	else
	{
		//echo "INSERT INTO `host_functions_setting` (`host_id`,`uploads`,`uploadsmessage`) VALUES ('".$hostID1."','$value','$m')  "; exit;
		mysql_query("INSERT INTO `host_functions_setting` (`host_id`,`uploads`,`uploadsmessage`) VALUES ('".$hostID1."','$value','$m')  ")	;
	}


	$message = 'Uploads Section Display Settings is Saved.';

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


$(document).ready(function(){
	$('input[type="radio"]').click(function(){
		if($(this).val() == "Disable with message")
		{
			$('#disablemessage').css('display','block');
		}
		else
		{
			$('#disablemessage').css('display','none');
		}
	});
});


</script>

<?php 
$getq = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$hostID1."'  ");
$countrec = @mysql_num_rows($getq);
if($countrec > 0)
{
	$fetchstatus = @mysql_fetch_array($getq);
	$statuspage = $fetchstatus['uploads'];
	$me = $fetchstatus['uploadsmessage'];
}
else
{
	$statuspage = "Enable";
	$me= "";
}

?>


<div class="clear"></div>

	
			
					<div class="v2_inner_main_content">
  						<h3 id="title">Uploads Page Settings</h3>
  						<?php 
  							if(!empty($message))
  							{
  								echo '<div id="successmessage">'.$message.'</div>';
  							}
  						?>
						<form method="POST" action="" enctype="multipart/form-data" class="addsubuser">
							<div class="edit_profile_f">
								<div id="profile_box" class="StreamingSettingsPage">
									<?php 
										$getClubINfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$_SESSION[user_id]' ");
										$fetchClubInfo = mysql_fetch_assoc($getClubINfo);
										
									?>
         								<div class="BookSettings">
								         	<ul style="width:100% !important; margin:0;">
                  									<li><h3>Page Settings</h3></li>
									           	<li>
									           		<input <?php if($statuspage == "Enable"){ echo "checked"; } ?> type="radio" name="function" value="Enable" />Enable
									           	</li>
									           	<li>
									           		<input <?php if($statuspage == "Disable with message"){ echo "checked"; } ?> type="radio" name="function" value="Disable with message" id="disbleshow" />Disable with message
									           	</li>
									           	<li id="disablemessage" style="display: none;">
									         		<input   type="text" name="uploadsmessage" value="<?php echo $me;?>" />
									         	</li>
									           	<li>
		                                    						<input <?php if($statuspage == "Disable without message"){ echo "checked"; } ?> type="radio" name="function" value="Disable without message" />Disable And Hide
									           	</li>
								         	</ul>
                          <div class="clear"></div>
								         	<div class="bookingSettingsSubmit" style="float:left !important; margin-top:10px;">
										<input type="submit" name="savesetting" value="Save Settings" class="button btn" />
								         	</div>
                  </div>
								</div>
							</div>
						</form>
  					</div>
  				
			<div class="equalizer"></div>
		
	
<script type="text/javascript">
	$(document).ready(function(){
		$( "#subadmin" ).keypress(function() {
			var url = $('#siteURL').val();
			var URL = url+'refreshajax.php?action=subadmin&user_type=club';
			//alert(URL);
			$('#subadmin').autocomplete(URL);
		});
	});
</script>
