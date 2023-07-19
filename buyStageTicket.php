<?php
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;

$titleofpage="Payment Page";
$base_url = "https://" . $_SERVER['SERVER_NAME']."/";

if ($_SESSION['user_type'] == $_GET['user_type'] && $_SESSION['user_id'] == $_GET['host_id']){

	header('Location: '.$SiteURL.'host_profile.php?host_id='.$_SESSION['user_id']);
	
}

include('LoginHeader.php'); 

$getPaidpass = mysql_query("SELECT * FROM `paid_passes` WHERE `event_id` = '$_GET[event_id]' ");
$fetchRecords = mysql_fetch_assoc($getPaidpass);
$countPaidpasses = $fetchRecords['no_of_tickets'];


$getEventInfo = mysql_query("SELECT * FROM `forum` WHERE `event_id` = '$_GET[event_id]' ");
$fetchInfo = mysql_fetch_assoc($getEventInfo);


if(isset($_POST['tickets']) )
{
	$no_of_ticket = $_POST['tickets'];
	$newAmount = trim($_POST['tickets']*str_replace("$","", $fetchRecords['amount']));

	if($countPaidpasses < $_POST['tickets'] )
	{
		$error_message = "Sorry Only ".$countPaidpasses." Tickets Available.";
	}

}
else
{
	$no_of_ticket = '1';
	$newAmount = 1*str_replace("$", "", $fetchRecords['amount']);

}

?>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
		<div class="v2_inner_main_content">
			<div class="support_inner v2_mysitti_contest_lissts">
				<?php 
				if(isset($error_message) && !empty($error_message))
				{
					echo "<div class='successmessage' style=''>".$error_message."</div>";
				}
			?>
				<div id="title_pay" class="botmbordr">Please confirm your Tickets and Amount Below:</div>
				<div class="paymentmodes">
					<div class="eventpaymentinfo">
						<table>
							<tbody>
								<tr>
									<td>Event Name</td>
									<td><?php echo $fetchInfo['forum'];?></td>
								</tr>
								<tr>
									<td>Event Date</td>
									<td><?php echo date('F j, Y l h:i:s A', strtotime($fetchInfo['event_date'])); ?></td>
								</tr>
								<tr>
									<td>Event Place</td>
									<td><?php echo $fetchInfo['event_address'];?></td>
								</tr>
								<tr>
									<td>Ticket Price</td>
									<td>
										<?php echo "$".str_replace("$", "", $fetchRecords['amount']);?>
									</td>
								</tr>
								<tr>
									<td># of Tickets</td>
									<td>
										<form action="" method="POST" id="postForm">
											<select name="tickets" class="countTickets" onchange="calculateTotal(this.value);">
												<?php 
													if($countPaidpasses > 5 )
													{
														for($i=1;$i<=5;$i++)
														{
															?>
																<option <?php if($i == $no_of_ticket || $i == "1"){ echo "selected";} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
															<?php 
														}
													}
													else
													{
														for($i=1;$i<=$countPaidpasses;$i++)
														{
															?>
																<option <?php if($i == $no_of_ticket || $i == "1"){ echo "selected";} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
															<?php 
														}
													}
												?>
											</select>
										</form>
									</td>
								</tr>
								<tr>
									<td>
										Total Amount To be Paid
									</td>
									<td id="totalAmount">
										<?php echo $finalamount =  "$".str_replace("$", "", $newAmount);?>
									</td>
								</tr>
				  			</tbody>
				  		</table>
				  		<?php 
				  		if(!isset($error_message))
				  		{
							$HostID = $_GET['host_id'];
							$get_str_host_email = mysql_query("SELECT `merchant_id` FROM `clubs` WHERE `id` = '$HostID' ");
							$count_email = mysql_num_rows($get_str_host_email);
							
							if($count_email < 1){
								
								$host_email = "";
								
							}else{
								
								$set_host_email = mysql_fetch_assoc($get_str_host_email);
								$host_email = $set_host_email['merchant_id'];
								
							}
							
							$hide_btn = "style='display: none;'";
							
							$payment_amount =  trim(str_replace("$",'',$finalamount));
							$host_email_set = $host_email;
							$item_name = "Buy Ticket";
							$return_url = $base_url.'successPurchase.php?host_id='.str_replace(" ","",$HostID).'&str_amt='.$payment_amount.'&user_type='.$_SESSION['user_type'].'&passid='.$fetchRecords['pass_id'].'&pass_type=paid&no_of_tickets='.$no_of_ticket;
							$cancel_url = $base_url.'host_profile.php?host_id='.$HostID;
							 ?>
						
							<script type="text/javascript">
								function submitpaypalform(pp)
								{
									$(location).attr('href',pp);
								}	
							</script>
						
						<?php
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
							$receiver[0]->email = $host_email_set;

							//$receiver[1]->primary = true;
							
							// Amount to be credited to the receiver's account
						//	echo "NEW AMT HOST = ".$new_amt_host;
							$x11 = number_format($new_amt_host,2,".","");
							$receiver[0]->amount = $x11;

							$receiver[1] = new Receiver();
							
							// A receiver's email address
							$receiver[1]->email = PAYPAPOWNERID;
							
							// Amount to be credited to the receiver's account
						//	echo "NEW AMT = ".$new_amt;
							$x22 = number_format($new_amt,2,".","");
							$receiver[1]->amount =  $x22;
							
							
						
							//$receiver[0]->amount =$sum;
							$receiverList = new ReceiverList($receiver);
							//echo "<pre>"; print_r($receiverList);
							$actionType = "PAY";
							$currencyCode = "USD";
							
							$payRequest = new PayRequest(new RequestEnvelope("en_US"),$actionType,$cancel_url,$currencyCode,$receiverList,$return_url);
							
							$payRequest->memo = $invoice;
							$payRequest->cmd = "_notify-validat";
							
							//	echo "<pre>"; print_r($payRequest);
							
							$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
						//	echo "<pre>"; print_r($service); 
							try {
								/* wrap API method calls on the service object with a try catch */
								$response = $service->Pay($payRequest);
							//	echo "<pre>"; print_r($response); 

								
							} catch(Exception $ex) {
								require_once 'Common/Error.php';
								exit;
							}?>
							<link href="Common/sdk.css" rel="stylesheet" type="text/css" />
							<script type="text/javascript" src="Common/tooltip.js"></script>
					<?php
					echo "</pre>";
							$ack = strtoupper($response->responseEnvelope->ack);

							if($ack != "SUCCESS") 
							{
								
								if($host_email == ""){
									echo '<div id="NoRecordsFound" class="NoRecordsFound">	Sorry We are unable to process your request. Please try again after some time.</div>';
									
								}else{
									//echo "<div class='errorclass' style=''>Error in payment, Please try again</div>";
									echo '<div id="NoRecordsFound" class="NoRecordsFound">	Sorry We are unable to process your request. Please try again after some time.</div>';
									
								};
							
							} 
							else 
							{
								
								$payKey = $response->payKey;
								$payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey;
								?>
								<!--<a class='button' onclick='submitpaypalform("<? echo $payPalURL?>")' ><b>Pay Now</b></a>-->
								
								<!--onclick='submitpaypalform("<? //echo $payPalURL?>")' <img style="cursor: pointer;" src="images/paypal-btn.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online."> -->
								<a style="margin:20px 0;" class="buyshowtickets"  href="javascript:void(0);" onclick='submitpaypalform("<? echo $payPalURL?>")'>
									<img style="border: none !important;" src="images/paypal-btn.png" alt="Buy Now" />
								</a>
						<?php 	
							}
						}	?>
						<!-- <img border="0" alt="PayPal - The safer, easier way to pay online." name="submit" src="images/paypal-btn.png" onclick="submitpaypalform(&quot;https://www.sandbox.paypal.com/webscr&amp;cmd=_ap-payment&amp;paykey=AP-7T332063N1121812T&quot;)" style="cursor: pointer; margin-top: 10px;"> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function calculateTotal(totaltickets)
	{
		//alert(totaltickets);
		//var totaltickets = $(this).val();
		//var cURl = '<?php echo $currentUrl; ?>';
//		alert( cURl+'&no_of_tickets='+totaltickets);
		//window.top.location = cURl+'&no_of_tickets='+totaltickets;
		$('#postForm').submit();
		return false;
	}
</script>

<?php include('Footer.php'); ?>