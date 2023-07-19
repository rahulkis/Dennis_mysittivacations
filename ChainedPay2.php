<?php

include("Query.Inc.php");
$Obj = new Query($DBName);
require_once("paypal/paypal_class.php");
require_once('PPBootStrap.php');
require_once('Common/Constants.php');
define("DEFAULT_SELECT", "- Select -");
include('headhost.php');
include('header.php');
if(isset($_POST['receiverEmail'])) {
$frmdata=array();
	for($i=1;$i<=count($_POST['countercount']); $i++){
		
		$frmdata[$i]= "INSERT INTO `purchases` (`invoice`, `product_id`, `product_name`, `product_quantity`, `product_amount`, `payer_fname`, `payer_lname`, `payer_address`, `payer_city`, `payer_state`, `payer_zip`, `payer_country`, `payer_email`, `payment_status`, `posted_date`) VALUES('".$_POST["invoice"]."', '".$_POST["item_id_".$i]."', '".$_POST["item_name_".$i]."', '".$_POST["quantity_".$i]."', '".$_POST["amount_".$i]."', '".$_POST["payer_fname"]."', '".$_POST["payer_lname"]."', '".$_POST["payer_address"]."', '".$_POST["payer_city"]."', '".$_POST["payer_state"]."', '".$_POST["payer_zip"]."', '".$_POST["payer_country"]."', '".$_POST["payer_email"]."', 'complete', NOW())";
		//$frmdata[$i]= array($_POST["invoice"],$_POST["item_id_".$i],$_POST["item_name_".$i],$_POST["quantity_".$i],$_POST["amount_".$i],$_POST["payer_fname"],$_POST["payer_lname"],$_POST["payer_address"],$_POST["payer_city"],$_POST["payer_state"],$_POST["payer_zip"],$_POST["payer_country"],$_POST["payer_email"]);
	}
	
	$_SESSION['IPNCartData']=$frmdata;
	$_SESSION['IPNinvoice']=$_POST['invoice'];
	$receiver = array();
	$_POST['invoice']=123;
		for($i=0; $i<count($_POST['receiverEmail']); $i++) {
		$receiver[$i] = new Receiver();
		$receiver[$i]->email = $_POST['receiverEmail'][$i];		
		$receiver[$i]->amount = $_POST['receiverAmount'][$i];		
		$receiver[$i]->primary = $_POST['primaryReceiver'][$i];				
		$receiver[$i]->item_name = "asd";
		$receiver[$i]->qwert = "asd";
	}		
	$receiverList = new ReceiverList($receiver);	
	
}
$asd="http://mysittidev.com/shopping_cart.php?action='success'&invoice='678'";
$_POST['cancelUrl']="http://mysittidev.com/shopping_cart.php?action=cancel&invoice=6v78";
$payRequest = new PayRequest(new RequestEnvelope("en_US"), $_POST['actionType'], $_POST['cancelUrl'], $_POST['currencyCode'], $receiverList, $asd);
if($_POST["memo"] != "") {
	//$payRequest->memo = $_POST["memo"];
	
}
$payRequest->memo='12312312231';
$payRequest->invoiceId ="123";
$payRequest->custom ="123";
$payRequest->cmd = "_notify-validat";
/*echo "<pre>";
$data = array('email'=>'test@test.com',
                        array("php","mysql"),
                        'age'=>28);
                        print_r($frmdata);
                        print_r($data);die;*/
//$payRequest->ipnNotificationUrl="http://mysittidev.com/ipn.php?invoice=".http_build_query($frmdata) ."&actions=".$_POST["invoice"];
$payRequest->ipnNotificationUrl="http://mysittidev.com/ipn.php?invoice=".$_POST['invoice'];
$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
try {
	/* wrap API method calls on the service object with a try catch */
	$response = $service->Pay($payRequest);
	
} catch(Exception $ex) {
	require_once 'Common/Error.php';
	exit;
}
/* Make the call to PayPal to get the Pay token
 If the API call succeded, then redirect the buyer to PayPal
to begin to authorize payment.  If an error occured, show the
resulting errors */


?>

<link href="Common/sdk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="Common/tooltip.js">
    </script>
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
	
		
		<div id="response_form">
					
<?php
$ack = strtoupper($response->responseEnvelope->ack);
if($ack != "SUCCESS") {
	
	echo "<b>Error </b>";
	echo "<pre>";
	echo "</pre>";
} else {
		/*$log_query		= "SELECT * FROM `purchases` WHERE `invoice` = '".$_POST["invoice"]."'";
			$log_check 		= mysql_query($log_query);
			if(mysql_num_rows($log_check) <= 0){
			for($i=1;$i<=count($_POST['countercount']); $i++){
			mysql_query("INSERT INTO `purchases` (`invoice`, `product_id`, `product_name`, `product_quantity`, `product_amount`, `payer_fname`, `payer_lname`, `payer_address`, `payer_city`, `payer_state`, `payer_zip`, `payer_country`, `payer_email`, `payment_status`, `posted_date`) VALUES
			('".$_POST["invoice"]."', '".$_POST["item_id_".$i]."', '".$_POST["item_name_".$i]."', '".$_POST["quantity_".$i]."', '".$_POST["amount_".$i]."', '".$_POST["payer_fname"]."', '".$_POST["payer_lname"]."', '".$_POST["payer_address"]."', '".$_POST["payer_city"]."', '".$_POST["payer_state"]."', '".$_POST["payer_zip"]."', '".$_POST["payer_country"]."', '".$_POST["payer_email"]."', 'pending', NOW())");
			}	
		}*/
		  $query = array();
			$query['notify_url'] = 'https://mysitti.com/ipn.php';
			$query['item_name'] = 'xfgdfgd';
			$query['item_number'] = '3';
			
	$payKey = $response->payKey;
	echo $payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey.'&'.$query;
	
			echo "<a class='button' href=$payPalURL><b>Complete Payment using Paypal</b></a>";
	
}
//require_once 'Common/Response.php';
?>
		</div>
	 </div>
		 
<script language="javascript">	

</script>
 </div>
 <?
//include('club-right-panel.php');
?>
   
  </div>
</div>
<?
include('footer.php');
?>
