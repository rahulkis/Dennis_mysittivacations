<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Payment Page";
include('LoginHeader.php');

$titleofpage="Payment Page";
$base_url = "https://" . $_SERVER['SERVER_NAME']."/";

if ($_SESSION['user_type'] == $_GET['user_type'] && $_SESSION['user_id'] == $_GET['host_id']){

		header('Location: '.$SiteURL.'host_profile.php?host_id='.$_SESSION['user_id']);
	
}
?>

<style type="text/css">
.paymentmodes div.AuthorizeNetSeal {
	float: left;
	width: 45%;
}

.paymentmodes div#payPalButton {
	float: left;
	width: 45%;
}
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
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
					
		<?php
		if(isset($_GET['ticket_id'])){
			$get_ticket_feess = mysql_query("SELECT ticket_price FROM streaming_tickets WHERE ticket_id = '".$_GET['ticket_id']."'");
			$ticket_feess = mysql_fetch_assoc($get_ticket_feess);
			
			$payment_amt = $ticket_feess['ticket_price'];			
		}elseif(isset($_GET['host_id'])){
			$get_ticket_feess = mysql_query("SELECT streaming_paid_fess FROM clubs WHERE id = '".$_GET['host_id']."'");
			$ticket_feess = mysql_fetch_assoc($get_ticket_feess);
			
			$payment_amt = $ticket_feess['streaming_paid_fess'];			
		}
		?>
		
		<?php
		if(isset($_GET['ticket_id'])){ ?>
		
		  <div id="title_pay" class="botmbordr">Kindly confirm the details below</div>
		
		<?php }else{ ?>
		
		<div id="title_pay" class="botmbordr">Please make purchase of $ <?php echo $payment_amt; ?></div>
		
		<?php }
		?>
	
	  
		<div class="paymentmodes">
		<?php
		
		$getContestInfo = mysql_query("SELECT * FROM `contest` WHERE `contest_id` = '$_GET[contID]' ");
		$fetchContestInfo = mysql_fetch_assoc($getContestInfo);
		
		$stream_payment = $_GET['pay'];
		
		$str = "streaming-payment";
		$str1 = "purchase-ticket";
		
		if (md5($str) == $stream_payment)
		  {
			
			$get_str_host_email = mysql_query("SELECT streaming_paid_fess,merchant_id FROM clubs WHERE id = '".$_GET['host_id']."'");
			$count_email = mysql_num_rows($get_str_host_email);
			
			if($count_email < 1){
				
				$host_email = "";
				
			}else{
				
				$set_host_email = mysql_fetch_assoc($get_str_host_email);
				$host_email = $set_host_email['merchant_id'];
				
			}
			
			$hide_btn = "style='display: none;'";
			
			$payment_amount = $set_host_email['streaming_paid_fess'];
			$host_email_set = $host_email;
			$item_name = "Live Streaming Payment";
			$return_url = $base_url.'success-payment.php?host_id='.$_GET['host_id'].'&str_amt='.$payment_amount.'&user_type='.$_GET['user_type'];
			$cancel_url = $base_url.'success-payment.php?host_id='.$_GET['host_id'].'&str_amt='.$payment_amount.'&user_type='.$_GET['user_type'];
			 ?>
		
			<script type="text/javascript">
			function submitpaypalform(pp){
					
					$(location).attr('href',pp);
			}	
			</script>
		
		<?php
				$HOSTID = $_GET['host_id'];
				/* code from chained file */
				require_once("paypal/paypal_class.php");
				require_once('PPBootStrap.php');
				require_once('Common/Constants.php');
				define("DEFAULT_SELECT", "- Select -");
		
				$invoice = date("His").rand(1234, 9632); 
			
				$percentage = 18;
				$totalamt = $payment_amount;
				
				$new_amt = ($percentage / 100) * $totalamt;
		
				$percentage_host = 82;
				$totalamt_host = $payment_amount;
				
				$new_amt_host = ($percentage_host / 100) * $totalamt_host;
			
				$receiver = array();
				$receiver[0] = new Receiver();
				
				// A receiver's email address
				$receiver[0]->email = PAYPAPOWNERID;
				
				// Amount to be credited to the receiver's account
				$receiver[0]->amount = $new_amt;
				
				$receiver[1] = new Receiver();
				// A receiver's email address
				$receiver[1]->email = $host_email_set;
				
				// Amount to be credited to the receiver's account
				$receiver[1]->amount = $new_amt_host;
			
				//$receiver[0]->amount =$sum;
				$receiverList = new ReceiverList($receiver);
	
				$actionType = "PAY";
				$currencyCode = "USD";
				
				$payRequest = new PayRequest(new RequestEnvelope("en_US"), $actionType, $cancel_url, $currencyCode, $receiverList,$return_url);
				
				$payRequest->memo = $invoice;
				$payRequest->cmd = "_notify-validat";
				// echo "<pre>"; print_r($payRequest); exit;
				
				$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
				// echo "<pre>"; print_r($service); exit;
				try {
					/* wrap API method calls on the service object with a try catch */
					$response = $service->Pay($payRequest);
					
				} catch(Exception $ex) {
					require_once 'Common/Error.php';
					exit;
				}?>
				<link href="Common/sdk.css" rel="stylesheet" type="text/css" />
				<script type="text/javascript" src="Common/tooltip.js">
					</script>
					<?php
					$ack = strtoupper($response->responseEnvelope->ack);
					
					if($ack != "SUCCESS") {
						
						if($host_email == ""){
							echo "<div class='errorclass NoRecordsFound' style=''>Sorry We are unable to process your request. Please try again after some time.</div>";
							
						}else{
							echo "<div class='errorclass NoRecordsFound' style=''>Sorry We are unable to process your request. Please try again after some time.</div>";
							
						};
					
					} else {
						
							$payKey = $response->payKey;
							$payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey;
							?>
							<!--<a class='button' onclick='submitpaypalform("<? echo $payPalURL?>")' ><b>Pay Now</b></a>-->
							
							<img style="cursor: pointer;" onclick='submitpaypalform("<? echo $payPalURL?>")' src="images/paypal-btn.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
					<?php }
		
		  
		  }elseif (md5($str1) == $stream_payment)
		  {
			
			
			$get_str_host_email = mysql_query("SELECT merchant_id FROM clubs WHERE id = '".$_GET['host_id']."'");
			$count_email = mysql_num_rows($get_str_host_email);
			
			if($count_email < 1){
				
				$host_email = "";
				
			}else{
				
				$set_host_email = mysql_fetch_assoc($get_str_host_email);
				$host_email = $set_host_email['merchant_id'];
				
			}
			
			$hide_btn = "style='display: none;'";
			
			$get_ticket_fees = mysql_query("SELECT event_id,ticket_price FROM streaming_tickets WHERE ticket_id = '".$_GET['ticket_id']."'");
			$ticket_fees = mysql_fetch_assoc($get_ticket_fees);
			
			$payment_amount = $ticket_fees['ticket_price'];
			$host_email_set = $host_email;
			$event_id = $ticket_fees['event_id'];
			$item_name = "Streaming Event Ticket";
			$return_url = $base_url.'thankyou.php?host_id='.$_GET['host_id'].'&str_amt='.$payment_amount.'&ticket_id='.$_GET['ticket_id'].'&stps=true&event_id='.$event_id;
			$cancel_url = $base_url.'thankyou.php?host_id='.$_GET['host_id'].'&str_amt='.$payment_amount.'&ticket_id='.$_GET['ticket_id'].'&stps=true&event_id='.$event_id;
			 ?>
		
			<script type="text/javascript">
			function submitpaypalform(pp){
					
					$(location).attr('href',pp);
			}	
			</script>
		
		<?php
		
				$HOSTID = $_GET['host_id'];
				/* code from chained file */
				require_once("paypal/paypal_class.php");
				require_once('PPBootStrap.php');
				require_once('Common/Constants.php');
				define("DEFAULT_SELECT", "- Select -");
		
				$invoice = date("His").rand(1234, 9632); 
			
				$percentage = 18;
				$totalamt = $payment_amount;
				
				$new_amt = ($percentage / 100) * $totalamt;
		
				$percentage_host = 82;
				$totalamt_host = $payment_amount;
				
				$new_amt_host = ($percentage_host / 100) * $totalamt_host;
			
				$receiver = array();
				$receiver[0] = new Receiver();
				
				// A receiver's email address
				$receiver[0]->email = PAYPAPOWNERID;
				
				// Amount to be credited to the receiver's account
				$receiver[0]->amount = $new_amt;
				
				$receiver[1] = new Receiver();
				// A receiver's email address
				$receiver[1]->email = $host_email_set;
				
				// Amount to be credited to the receiver's account
				$receiver[1]->amount = $new_amt_host;
			
				//$receiver[0]->amount =$sum;
				$receiverList = new ReceiverList($receiver);
	
				$actionType = "PAY";
				$currencyCode = "USD";
				
				$payRequest = new PayRequest(new RequestEnvelope("en_US"), $actionType, $cancel_url, $currencyCode, $receiverList,$return_url);
				
				$payRequest->memo = $invoice;
				$payRequest->cmd = "_notify-validat";
				// echo "<pre>"; print_r($payRequest); exit;
				
				$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
				// echo "<pre>"; print_r($service); exit;
				try {
					/* wrap API method calls on the service object with a try catch */
					$response = $service->Pay($payRequest);
					
				} catch(Exception $ex) {
					require_once 'Common/Error.php';
					exit;
				}?>
				<link href="Common/sdk.css" rel="stylesheet" type="text/css" />
				<script type="text/javascript" src="Common/tooltip.js">
					</script>
					<?php
					$ack = strtoupper($response->responseEnvelope->ack);
					if($ack != "SUCCESS") {
						
						if($host_email == ""){
							echo "<div class='errorclass NoRecordsFound' style=''>Sorry We are unable to process your request. Please try again after some time.</div>";
							
						}else{
							echo "<div class='errorclass NoRecordsFound' style=''>Sorry We are unable to process your request. Please try again after some time.</div>";
							
						};
					
					} else {
						
							$payKey = $response->payKey;
							$payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey;
							?>
							<!--<a class='button' onclick='submitpaypalform("<? echo $payPalURL?>")' ><b>Pay Now</b></a>-->
							
							<?php
							$get_event = mysql_query("SELECT * FROM events WHERE id = '".$_GET['event_id']."'");
							$event_details = mysql_fetch_assoc($get_event);
							?>
							
								<div class="eventpaymentinfo">
									<table>
									<tr>
									<td>Event Name</td><td><?php echo $event_details['eventname']; ?></td>
									</tr>
									<tr>
									<td>Event Date</td><td><?php echo date('F j, Y l h:i:s A', strtotime($event_details['date'])); ?></td>
									</tr>
									<tr>
									<td>Event Place</td><td><?php echo $event_details['event_address']; ?></td>
									</tr>
								  
									</table>
									<img style="cursor: pointer; margin-top: 10px;" onclick='submitpaypalform("<? echo $payPalURL?>")' src="images/paypal-btn.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
								</div>							
							
							
							
					<?php }
		
		  
		  }elseif($_GET['contID']){
			
			$payment_amount = $fetchContestInfo['one_time_pay'];
			$item_name = "Upgrade Plan";
			$return_url = $base_url.'LiveContest.php?contid='.$_GET['contID'];
			$cancel_url = $base_url.'LiveContest.php?contid='.$_GET['contID'];
			 ?>
			 
				<div class="paymentmodes">
				  <!-- <h2 id="title_paypal">Pay with paypal</h2> -->
				  <br>
				  <div id="payPalButton">
					  <!-- <a href="<?php echo $paypalurl;?>" >
						  <img src="images/paypal-btn.png" alt="Pay with Paypal" />
					  </a>  -->
					  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						  <input type="hidden" name="cmd" value="_xclick">
						  <input type="hidden" name="business" value="<?php echo PAYPAPOWNERID; ?>">
						  <input type="hidden" name="item_name" value="<?php echo $item_name; ?>">
						  <input type="hidden" name="item_number" value="1">
						  <input type="hidden" name="amount" value="<?php echo $payment_amount; ?>">
						  <input type="hidden" name="no_shipping" value="0">
						  <input type="hidden" name="no_note" value="1">
						  <input type="hidden" name="currency_code" value="USD">
						  <input type="hidden" name="lc" value="US">
						  <input type="hidden" name="notify_url" value="<?php echo $base_url.'ipn.php'; ?>">
						  <input type="hidden" name="return" value="<?php echo $return_url; ?>">
						  <input type="hidden" name="cancel" value="<?php echo $cancel_url; ?>">
						  <input type="hidden" name="bn" value="PP-BuyNowBF">
						  <input type="image" src="images/paypal-btn.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
						  <!-- <img alt="" border="0" src="images/paypal-btn.png"> -->
					  </form>
				  </div>
				  <div style=" float: left;width:10%;text-align: center;">
					  <div class="oor">OR</div>
				  </div>
				  <div class="AuthorizeNetSeal" id="authorizeNetButton"> 
					  <script type="text/javascript" language="javascript">var ANS_customer_id="3516696b-0575-4981-ba9a-84a96fa71d98";</script>
					  <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script>
					  <!-- <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Credit Card Merchant Services</a> -->
				  </div>
		  
				  
			  </div>			 
			
		 <?php }else{
			header('Location: index.php');
		  }
		?>	  
	  </div>

	  <!-- (c) 2005, 2015. Authorize.Net is a registered trademark of CyberSource Corporation --> 
	   



	  <div class="cardsselect spacer_card" style="display: none;"> 
		<!--<a href="javascript:void(0);" onclick="authnetpay();"><img src="../images/payment-authorize.net.png" alt="Pay with Authorize.Net" /></a>-->
		
		<div><img src="images/visa.png" alt="Pay with Visa" /><br />
		  <input onclick="authnetpay(this.value);" type="radio" value="Visa" name="Visa" id="byvisa" />
		</div>
		<div><img src="images/mastercard.png" alt="Pay with Master Card" /><br />
		  <input onclick="authnetpay(this.value);" type="radio" value="MasterCard" name="Master" id="bymaster" />
		</div>
		<div><img src="images/americanexpress.png"  alt="Pay with American Express" /><br />
		  <input type="radio" onclick="authnetpay(this.value);" value="AmericanExpress" name="american" id="byamerican" />
		</div>
		<div><img src="images/dinerclub.png" alt="Pay with Diners Club" /><br />
		  <input type="radio" onclick="authnetpay(this.value);" value="DinersClub" name="diner" id="bydinerclub" />
		</div>
	  </div>
	  <script type="text/javascript" src="telephone.js"></script>
	  <div id="authopayform" style="display:none">
		<h4 class="ttl_small">Payment Details</h4>
		<form action="Authorize/subscription_create.php" method="POST" class="paypalform">

		  <div class="leftone"> Cardholder First Name: </div>
		  <div class="rightone">
			<input type="text" name="firstName" />
		  </div>
		  <div class="leftone"> Cardholder Last Name: </div>
		  <div class="rightone">
			<input type="text" name="lastName" />
		  </div>
		  <div class="leftone"> Card Number: </div>
		  <div class="rightone">
			<input name="cardNumber" type="text" />
		  </div>
		  <div class="leftone"> Expiration Date: <span style=" font:8pt arial;">[ MM-YYYY ]</span> </div>
		  <div class="rightone">
			<input id="cardexpiryDate" name="expirationDate" class="sel" type="text" />
		  </div>
		  <div class="leftone"> Amount: </div>
		  <div class="rightone">
			<input type="text" readonly="readonly" name="amount" value='<?php echo $fetchContestInfo['one_time_pay']; ?>' />
		  </div>
		  <div class="leftone"></div>
		  <div class="rightone">
			<input type="hidden" readonly="readonly" name="startDate" value='<?php echo date('Y-m-d'); ?>'>
		  </div>
		  <?php 
							$dd = date('Y-m-d H:i:s');
							$reference = strtotime($dd);

						?>
		 <div class="leftone"> &nbsp; </div>
		  <div class="rightone">
		  	<input type="hidden" name="name" value='Silver Plan Membership'>
			<input type="hidden" name="length" value='30'>
			<input type="hidden" name="unit" value='days'>
			<input type="hidden" name="upgradeorfresh" type="<? echo $upgradeorfresh;?> " />
			<input type="hidden" name="cardtype" value="" id="selectedcard" />
			<input type="hidden" name="totalOccurrences" value='1'>
			<input type="hidden" name="refId" value='<?php echo $reference; ?>'>
			<input type="hidden" name="onetimepay" value="1">
			<input type="hidden" name="host_ID" value="<?php echo $_SESSION['user_id'];?>">
			<input type="hidden" name="contestid" value="<?php echo $_GET['contid'];?>">
			<input name="submit" class="button_pay" type="submit" style="border:1px outset gray; width:100px;" value="Pay Now" />
		  </div>
		  <div class="clear"></div>
		</form>
	  </div>
	  <div class="clear"></div>					
					
					</div>
				</div>
			</div>
		</article>
	</div>
</div>


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

</script>
<?php include('Footer.php'); ?>