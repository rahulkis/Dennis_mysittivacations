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
	// echo "<pre>";
	// print_r($_POST);
	// die;
	$invoice=date("His").rand(1234, 9632); 
	$i=0;
	$frmdata=array();
	foreach($_SESSION['cart_value'] as $key=>$value){
		
		if($value['product_type']==0){
			$type="music";
			 $sql="SELECT price as prodctprice FROM music where id ='".$value['product_id']."'";
		}else{
			$type="cd";
			$sql="SELECT cd_price  as prodctprice FROM cds where id ='".$value['product_id']."'";
		}
		$cartquery = mysql_query($sql);
		$cartquery=mysql_fetch_array($cartquery);
		$frmdata[$i]= array('invoice'=>$invoice,'product_id'=>$value["product_id"],'qty'=>$value["product_qty"],'price_cart'=>$cartquery['prodctprice'],'payer_fname'=>$_POST["payer_fname"],'payer_lname'=>$_POST["payer_lname"],'payer_address'=>$_POST["payer_address"],'payer_city'=>$_POST["payer_city"],'payer_state'=>$_POST["payer_state"],'payer_zip'=>$_POST["payer_zip"],'payer_country'=>$_POST["payer_country"],'payer_email'=>$_POST["payer_email"],'product_type'=>$type);
	$i++;
	}
	
	
	$receiver = array();
		for($i=0; $i<count($_POST['receiverEmail']); $i++) {
		$receiver[$i] = new Receiver();
		$receiver[$i]->email = $_POST['receiverEmail'][$i];		
		$receiver[$i]->amount = $_POST['receiverAmount'][$i];		
		$receiver[$i]->primary = $_POST['primaryReceiver'][$i];
		
	}	
	
	$receiverList = new ReceiverList($receiver);	
	
}
$_POST['returnUrl']="https://mysitti.com/shopping_cart.php?action=succes";
$_POST['cancelUrl']="https://mysitti.com/shopping_cart.php?action=cancel";
$_POST['actionType']="PAY";
$_POST['currencyCode']="USD";

$payRequest = new PayRequest(new RequestEnvelope("en_US"), $_POST['actionType'], $_POST['cancelUrl'], $_POST['currencyCode'], $receiverList,$_POST['returnUrl']);

$payRequest->memo = $invoice;
$payRequest->cmd = "_notify-validat";


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
	echo "<span style='color:white; float:left;width:65%; font-size:17px;'>Sorry, Currently we can't process your request.</span>";
	///echo "<a  class='button' href='music_request.php?host_id=".$HostID."'>Go to Music Request Page.</a>";
	echo "<a  class='button' href='cart.php'>Go to cart page</a>";

} else {
		/*$log_query		= "SELECT * FROM `purchases` WHERE `invoice` = '".$_POST["invoice"]."'";
			$log_check 		= mysql_query($log_query);
			if(mysql_num_rows($log_check) <= 0){
			for($i=1;$i<=count($_POST['countercount']); $i++){
			mysql_query("INSERT INTO `purchases` (`invoice`, `product_id`, `product_name`, `product_quantity`, `product_amount`, `payer_fname`, `payer_lname`, `payer_address`, `payer_city`, `payer_state`, `payer_zip`, `payer_country`, `payer_email`, `payment_status`, `posted_date`) VALUES
			('".$_POST["invoice"]."', '".$_POST["item_id_".$i]."', '".$_POST["item_name_".$i]."', '".$_POST["quantity_".$i]."', '".$_POST["amount_".$i]."', '".$_POST["payer_fname"]."', '".$_POST["payer_lname"]."', '".$_POST["payer_address"]."', '".$_POST["payer_city"]."', '".$_POST["payer_state"]."', '".$_POST["payer_zip"]."', '".$_POST["payer_country"]."', '".$_POST["payer_email"]."', 'pending', NOW())");
			}	
		}*/
	$payKey = $response->payKey;
	$payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey;
	
			//echo "<a class='button' href=$payPalURL><b>Complete Payment using Paypal</b></a>";
			?>
			<div class="submitedpaypalwait" style="display:none; pointer-events: none;">
			<a class='button' ><b>Complete Payment using Paypal</b></a>
			</div>
			<div class="submitedpaypal">
			<a class='button' onclick='submitpaypalform("<? echo $payPalURL?>")' ><b>Complete Payment using Paypal</b></a>
			</div>
			<?
	
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
<script>
	function submitpaypalform(pp){
		
		jQuery(".submitedpaypal").hide();
		jQuery(".submitedpaypal").show();
		 arrayquery = new Array();
		var arrayquery='<?php echo json_encode($frmdata); ?>';
		//url='https://www.sandbox.paypal.com/webscr&cmd=_ap-payment&paykey='+payPalURL;
		user_id="<? echo $_SESSION['user_id']?>";
		$.ajax({
			type: "POST",
			url: "ipn.php",
			data: "arrayquery="+arrayquery+"&user_id="+user_id,
			success: function(result){
			$(location).attr('href',pp);
			}
		
		
	});	return false;
}

</script>
