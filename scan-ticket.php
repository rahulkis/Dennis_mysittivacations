<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if(isset($_POST['post_param']) && $_POST['post_param'] == 'scanned_ticket')
{
	$check_ticket_exists = mysql_query("SELECT * FROM paid_pass_download WHERE barcode = '".$_POST['post_value']."'");
	$count_check_ticket_exists = mysql_num_rows($check_ticket_exists);
	if($count_check_ticket_exists < 1)
	{
		echo "false";
	}
	else
	{
		$cur_date = date('Y-m-d H:i:s');
		$updt = mysql_query("UPDATE paid_pass_download SET `status` = 'redeemed', `redeem_date` = '".$cur_date."' WHERE barcode = '".$_POST['post_value']."'");
		if($updt == 1)
		{
			echo "success";
		}
	}
	die;
}

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
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}
		
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);

$titleofpage="Scan Ticket";
include('LoginHeader.php');
$userID = $_SESSION['user_id'];
$userType= $_SESSION['user_type'];
	
?>

<style>
	#couponupload_toggle{
		display: none;
	}
	#successmessage-ticket{
		display: none;
	}

	#ticket_message_error{
		display: none;
	}
	
	.ticket_message{
		background: #09d518 none repeat scroll 0 0 !important;
		border: 1px solid #09d518 !important;
		color: #fff !important;
		display: block;
		float: left;
		font-size: 18px;
		margin: 10px 0;
		padding: 10px 0;
		text-align: center;
		width: 100% !important;
		margin-top: -8px;
	}
	
	.ticket_message_error{
		background: red none repeat scroll 0 0 !important;
		border: 1px solid red !important;
		color: #fff !important;
		display: block;
		float: left;
		font-size: 18px;
		margin: 10px 0;
		padding: 10px 0;
		text-align: center;
		width: 100% !important;
		margin-top: -8px;
	}	
</style>		
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php include('club-right-panel.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title">Scan Ticket Code Here</h3>
						<form onsubmit="return scan_ticket()" id="scan-ticket-form" class="musicadd12" method = "POST">
							<div class="row"> 
								<span class="formw" style="width: 100%">
									<textarea name="scanned_ticket_code" id="scanned_ticket_code" placeholder="Scan Ticket Code Here"></textarea>
								</span>
							</div>
							<ul class="btncenter_new">
								<li>
									<div id="successmessage-ticket" class="ticket_message">Ticket Redeemed Successfully.</div>
								</li>
								<li>
									<div id="ticket_message_error" class="ticket_message_error">Error in code.</div>
								</li>													
								<li>
									<input type="submit" class="button addfrmbutton" value="Submit" name="hostdj_profile_edit">
								</li>
							</ul>
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
	window.onload = function() {
	  var input = document.getElementById("scanned_ticket_code").focus();
	}
});

// this is the id of the form
function scan_ticket(){

	var url = "scan-ticket.php"; // the script where you handle the form input.
	var post_value = $('#scanned_ticket_code').val();
	
	$.ajax({
		   type: "POST",
		   url: url,
		   data: {'post_value': post_value, 'post_param': 'scanned_ticket'}, // serializes the form's elements.
		   success: function(data)
		   {
			   if (data == 'success') {
				$('#successmessage-ticket').show(0).delay(5000).hide(0);
			   }else{
				$('#ticket_message_error').show(0).delay(5000).hide(0);
			   }
		   }
		 });

	return false; // avoid to execute the actual submit of the form.
}
</script>	
<?php include('Footer.php'); ?>