<?php
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;

$titleofpage="Upgrade Plan";
include('LoginHeader.php');

$base_url = "https://" . $_SERVER['SERVER_NAME']."/";


// echo "<pre>";print_r($_GET); exit;

$packagequery = @mysql_query('SELECT * FROM `packages` WHERE `value` = "'.$_GET['plan'].'"');
$fetchpackagearray = @mysql_fetch_array($packagequery);
$plan = $_GET['plan'];
$_SESSION['userUpgrade']['hostID'] = $_GET['host_id']; 
$_SESSION['userUpgrade']['plan'] = $_GET['plan']; 
	if($plan=='host_silver')
	{
		
		$query = array();
		$query['notify_url'] = $base_url.'ipn.php';
		$query['cmd'] = '_xclick-subscriptions';
		$query['no_shipping'] ="1";	
		$query['business'] = PAYPAPOWNERID;
		$query['lc'] = 'US';
		//$query['item_name'] = "Pro Host Membership plan for mysitti";
		$query['item_name'] = "Host Silver plan for mysitti";
		$query['no_note'] = '1';
		$query['src'] = '1';
		$query['a1'] = '0.01';
		$query['p1'] = '1';
		$query['t1'] = 'M';
		$query['a3'] = $fetchpackagearray['amount'];
		//$query['a3'] = '0.01';
		$query['p3'] = '1';
		//$query['p3'] = '5';
		$query['t3'] = 'M';
		$query['rm'] = '2';
		$query['address_override'] = '1';
		$query['currency_code'] = 'USD';
		$query['return'] = $base_url.'host-plan-upgrade.php';
		$query['cancel'] = $base_url.'host-plan-upgrade.php';
		$query_string = http_build_query($query);
		//header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
		$paypalurl = 'https://www.paypal.com/cgi-bin/webscr?' . $query_string;
		//$paypalurl = 'https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string;
	
	}
	else if($plan=='host_gold')
	{
		
		$query = array();
		$query['notify_url'] = $base_url.'ipn.php';
		$query['cmd'] = '_xclick-subscriptions';
		$query['no_shipping'] ="1";	
		$query['business'] = PAYPAPOWNERID;
		$query['lc'] = 'US';
		//$query['item_name'] = "Basic Host Membership plan for mysitti get 1 month free";
		$query['item_name'] = "Host Gold plan for mysitti";
		$query['no_note'] = '1';
		$query['src'] = '1';
		$query['a1'] = '0.01';
		$query['p1'] = '1';
		$query['t1'] = 'M';
		$query['a3'] = $fetchpackagearray['amount'];
		//$query['a3'] = '0.01';
		$query['p3'] = '1';
		//$query['p3'] = '5';
		$query['t3'] = 'M';
		$query['rm'] = '2';
		$query['address_override'] = '1';
		$query['currency_code'] = 'USD';
		$query['return'] = $base_url.'host-plan-upgrade.php';
		$query['cancel'] = $base_url.'host-plan-upgrade.php';
		$query_string = http_build_query($query);
		//header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);	
		$paypalurl = 'https://www.paypal.com/cgi-bin/webscr?' . $query_string;
		//$paypalurl = 'https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string;
	
	}
	elseif($plan=='host_platinum')
	{
		
		$query = array();
		$query['notify_url'] = $base_url.'ipn.php';
		$query['cmd'] = '_xclick-subscriptions';
		$query['no_shipping'] ="1";	
		$query['business'] = PAYPAPOWNERID;
		$query['lc'] = 'US';
		//$query['item_name'] ="Basic Host Membership plan for mysitti get 2 month free";
		$query['item_name'] ="Host Platinum plan for mysitti";
		$query['no_note'] = '1';
		$query['src'] = '1';
		$query['a1'] = '0.01';
		$query['p1'] = '1';
		$query['t1'] = 'M';
		$query['a3'] = $fetchpackagearray['amount'];
		//$query['a3'] = '0.01';
		$query['p3'] = '1';
		//$query['p3'] = '5';
		$query['t3'] = 'M';
		$query['rm'] = '2';
		$query['address_override'] = '1';
		$query['currency_code'] = 'USD';
		$query['return'] = $base_url.'host-plan-upgrade.php';
		$query['cancel'] = $base_url.'host-plan-upgrade.php';
		$query_string = http_build_query($query);
		// header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
		$paypalurl = 'https://www.paypal.com/cgi-bin/webscr?' . $query_string;
		//$paypalurl = 'https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string;
	
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
	<div class="v2_recent_contests gutter20 upgrade_plan_container"  style="margin-bottom: 10px;">
		<div class="v2_inner_main cart_inner">
			<div class="home_content_top" id="cartid">
				<div id="title_pay" class="botmbordr">Choose Payment Method to make purchase of <?php echo $query['a3']; ?></div>
				<div class="paymentmodes">
				<!-- <h2 id="title_paypal">Pay with paypal</h2> -->
				<br>
				<div id="payPalButton">
					<a href="<?php echo $paypalurl;?>" ><img src="images/paypal-btn.png" alt="Pay with Paypal" /></a> 
				</div>
				<div class="upgradeOr">
					<div class="oor">OR</div>
					</div>
				<div class="AuthorizeNetSeal" id="authorizeNetButton"> 
					<script type="text/javascript" language="javascript">var ANS_customer_id="3516696b-0575-4981-ba9a-84a96fa71d98";</script>
					<script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script>
					 	<!-- <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Credit Card Merchant Services</a> -->
					</div>


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
					<input type="text" readonly="readonly" name="amount" value='<?php echo $query['a3']; ?>' />
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
					<input type="hidden" name="trialOccurrences" value='1'>
					<input type="hidden" name="trialAmount" value='0.01'>
					<input type="hidden" name="name" value='<?php echo $fetchpackagearray['package_name'];?> Membership'>
					<input type="hidden" name="length" value='1'>
					<input type="hidden" name="unit" value='months'>
					<input type="hidden" name="upgradeorfresh" type="<? echo $upgradeorfresh;?> " />
					<input type="hidden" name="cardtype" value="" id="selectedcard" />
					<input type="hidden" name="totalOccurrences" value='999'>
					<input type="hidden" name="refId" value='<?php echo $reference; ?>'>
					<!-- <input type="submit" name="submit" value="Submit"> -->
					<input type="hidden" name="hostID" value='<?php echo $_GET['host_id'];?>'>
					<input type="hidden" name="planType" value='<?php echo $_GET['plan'];?>'>
					<input name="submit" class="button_pay" type="submit" style="border:1px outset gray; width:100px;" value="Pay Now" />
				  </div>
				  <div class="clear"></div>
				</form>
				</div>
  			</div>
		</div>
	</div>
</div>
<style type="text/css">

.leftbox, .rightbox {
float: left;
width: 50%;
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
body {
  padding-top: 115px !important;
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

</script>
<?
include('Footer.php');
?>
