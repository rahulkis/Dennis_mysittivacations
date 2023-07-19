<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Success Payment";
include('LoginHeader.php');
$base_url = "https://" . $_SERVER['SERVER_NAME']."/"; 	
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

//https://mysitti.com/success-payment.php?host_id=42&str_amt=0.01&tx=8LD89427J8299340M&st=Completed&amt=0.01&cc=USD&cm=&item_number=1

$host_id = $_GET['host_id'];
$streaming_user_type = $_GET['user_type'];
$streaming_amount = $_GET['str_amt'];
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
$payment_date = date('Y-m-d H:i:s');
$today_date = date('Y-m-d');

if(empty($host_id) || empty($streaming_amount) || empty($user_id) || empty($user_type)){ $Obj->Redirect("login.php"); }

$check_payment = mysql_query("SELECT * FROM user_streaming_records WHERE user_id = '".$user_id."' AND user_type = '".$user_type."' AND streaming_host_id = '".$host_id."' AND payment_day_check = '".$today_date."'");
$count_user_payment = mysql_num_rows($check_payment);

if($count_user_payment < 1){
	
	if(!empty($user_id) && !empty($user_type) && !empty($payment_date) && !empty($streaming_amount) && !empty($host_id)){

		mysql_query("INSERT INTO user_streaming_records (`user_id`, `user_type`, `payment_date`, `payment_amount`, `streaming_host_id`, `streaming_user_type`, `payment_day_check`) VALUES ('".$user_id."', '".$user_type."', '".$payment_date."', '".$streaming_amount."', '".$host_id."', '".$streaming_user_type."', '".$today_date."')");
		
		$last_inserted_id = mysql_insert_id();
	}

}else{
	
	$payment_alert = "You have already done the payment for today";
	
}
?>
	
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">			
					
						  <div id="title_pay" class="botmbordr"><?php if(!empty($payment_alert)){ echo $payment_alert; }else{ ?> Payment Completed Successfully <?php } ?></div>
						  <div class="paymentmodes" style="float: left; width: 100%; border: medium none;">
							<!-- <h2 id="title_paypal">Pay with paypal</h2> -->
							<div class="botmbordr sucess_pay">
									<?php
									$get_user_rec = mysql_query("SELECT * FROM user_streaming_records WHERE id = '".$last_inserted_id."'");
									$count_u = mysql_num_rows($get_user_rec);
									if($count_u == 1 || $count_user_payment == 1){
									$getClubInfo = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$host_id' ");
									$fetchClubInfo = mysql_fetch_array($getClubInfo);
									//echo "<pre>"; print_r($fetchClubInfo); exit;
									$clubNAme= explode(" ", $fetchClubInfo['club_name']);
									$username_dash_separated = implode("-", $clubNAme);
									$username_dash_separated = clean($username_dash_separated);
									
									?>
											<a class="button_live" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $host_id;?>&user_type=<?php echo $_GET['user_type']; ?>')">Live Streaming
											<?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
											<?php if(detect_stream($username_dash_separated)===true){ ?>
											<span class="stats_icon ico_online" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
											<?php } else{ ?>
											<span class="stats_icon ico_online" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
											<?php } ?>
											</a>
											
									<?php } ?>		

								<!--<a class="btn button" style="float: left; margin-left: 30%;">Click Here</a> <p style="float: left; width: 20%; margin-top: 1%;">to view Host Streaming</p>-->
							</div>
							<br>
						</div>
						  
						  <!-- (c) 2005, 2015. Authorize.Net is a registered trademark of CyberSource Corporation --> 					
					
					
					</div>
				</div>
			</div>
		</article>
	</div>
</div>


<style type="text/css">
.leftbox, .rightbox {
float: left;
width: 50%;
}
.leftone, span
{
	color: rgb(254, 205, 7);
	margin: 10px 0;
}
.paymentmodes
{
	float: left;
	width:100%;
	text-align: center;
}

.paymentmodes > a
{
	float: left;
	width:100%;
}

.cardsselect {
float: left;
width: 100%;
margin: 5% 0;
text-align: center;
}

.cardsselect div {
float: left;
width: 25%;
}

</style>
<script type="text/javascript">
$(document).ready(function(){
	$('#authorizeNetButton').find('img').click(function(){
		$('.cardsselect').show();
	});
});

function authnetpay(valuecard)
{
	
	//var getcheckvalue = $(this).val(); 
	$('#authopayform').fadeIn('slow');
	$('input#selectedcard').val(valuecard);

	$('.cardsselect').find('input[type="radio"]').each(function(){
		if($(this).val() == valuecard)
		{
			$(this).attr('checked', true);
		}
		else
		{
			$(this).attr('checked', false);	
		}
	});

}

function goto1(url)
{
	window.open(url,'1396358792239','width=900,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
	return false;
}
</script>


<?php include('Footer.php'); ?>