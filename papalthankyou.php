<?php
ob_start();
?>
</head>

<body>
    <?php
include("Query.Inc.php");
$Obj = new Query($DBName);
include('headhost.php');
include('header.php');?>
<div id="main">
    <div class="container">
		<div style="clear:both;"></div>
<div class="paypalcls">

<?php

define('EMAIL_ADD', 'villiam.choudhary@kindlebit.com'); // define any notification email
define('PAYPAL_EMAIL_ADD', 'villiam.choudhary-facilitator@kindlebit.com'); // facilitator email which will receive payments change this email to a live paypal account id when the site goes live
require_once("paypal/paypal_class.php");
$p 				= new paypal_class(); // paypal class
$p->admin_mail 	= EMAIL_ADD; // set notification email
$action 		= $_REQUEST["action"];
error_reporting(0);
switch($action){
	case "process": // case process insert the form data in DB and process to the paypal
		mysql_query("INSERT INTO `purchases` (`invoice`, `product_id`, `product_name`, `product_quantity`, `product_amount`, `payer_fname`, `payer_lname`, `payer_address`, `payer_city`, `payer_state`, `payer_zip`, `payer_country`, `payer_email`, `payment_status`, `posted_date`) VALUES ('".$_POST["invoice"]."', '".$_POST["product_id"]."', '".$_POST["product_name"]."', '".$_POST["product_quantity"]."', '".$_POST["product_amount"]."', '".$_POST["payer_fname"]."', '".$_POST["payer_lname"]."', '".$_POST["payer_address"]."', '".$_POST["payer_city"]."', '".$_POST["payer_state"]."', '".$_POST["payer_zip"]."', '".$_POST["payer_country"]."', '".$_POST["payer_email"]."', 'pending', NOW())");
		$this_script = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$p->add_field('business', PAYPAL_EMAIL_ADD); // Call the facilitator eaccount
		$p->add_field('cmd', $_POST["cmd"]); // cmd should be _cart for cart checkout
		$p->add_field('upload', '1');
		$p->add_field('return', $this_script.'?action=success'); // return URL after the transaction got over
		$p->add_field('cancel_return', $this_script.'?action=cancel'); // cancel URL if the trasaction was cancelled during half of the transaction
		$p->add_field('notify_url', $this_script.'?action=ipn'); // Notify URL which received IPN (Instant Payment Notification)
		$p->add_field('currency_code', $_POST["currency_code"]);
		$p->add_field('invoice', $_POST["invoice"]);
		
		
    $i = 1;
    $counter=1;
	if (is_array( $_SESSION['cart_value'])) {
		$cart_item_qty=array_count_values($_SESSION['cart_value']);
		foreach(array_unique($_SESSION['cart_value']) as $val)
		{    
		 $val_id = $val;
		$count_array = array($val);
		 $countrese = count($count_array);
		 $countrese;
		if(!empty($val_id)){	
		  $cartquery = mysql_query("SELECT * FROM music where id = $val_id ");
			$cartfetcharray[] = mysql_fetch_array($cartquery);	
		}
		}
		 $a = 0;
		 if(!empty($cartfetcharray)){
		foreach($cartfetcharray as $valmusic)   { 
		
		 
		$p->add_field('item_id_'.$counter.'', $valmusic['id']);
		$p->add_field('item_name_'.$counter.'', $valmusic['trackname']);
		$p->add_field('item_number_'.$counter.'', $counter);
		$p->add_field('quantity_'.$counter.'', $cart_item_qty[$valmusic['id']]);
		$p->add_field('amount_'.$counter.'', $valmusic['price']);
		
		  $a++;$counter++;} }
	}
	
	if (!empty( $_SESSION['cartcd_value'])) {
	    $i = 1;

	    $cart_item_qty=array_count_values($_SESSION['cartcd_value']);
		foreach(array_unique($_SESSION['cartcd_value']) as $value_cds)
		{
		    $valuecds = $value_cds;
		if(!empty($valuecds))
		{
		  $cartcdquery = mysql_query("SELECT * FROM cds where id = $valuecds");
		  $cartcdfetcharray[] = mysql_fetch_array($cartcdquery); 
		}
		}
		$a = 0;
		if(!empty($cartcdfetcharray))
		{
		foreach($cartcdfetcharray as $valuecd)
		{
		$prices=str_replace('$','',$valuecd['cd_price']);
		$totalcd_price += $prices;
		$p->add_field('item_name_'.$counter.'', $valuecd['cd_name']);
		$p->add_field('item_number_'.$counter.'', $counter);
		$p->add_field('quantity_'.$counter.'', $cart_item_qty[$valuecd['id']]);
		$p->add_field('amount_'.$counter.'', $valuecd['cd_price']);
		$a++;$counter++;
		
		} }
	}
		$p->add_field('first_name', $_POST["payer_fname"]);
		$p->add_field('last_name', $_POST["payer_lname"]);
		$p->add_field('address1', $_POST["payer_address"]);
		$p->add_field('city', $_POST["payer_city"]);
		$p->add_field('state', $_POST["payer_state"]);
		$p->add_field('country', $_POST["payer_country"]);
		$p->add_field('zip', $_POST["payer_zip"]);
		$p->add_field('email', $_POST["payer_email"]);
		$p->submit_paypal_post(); // POST it to paypal
		$p->dump_fields(); // Show the posted values for a reference, comment this line before app goes live
	break;
	
		case "success":
		echo '<title>Payment Done Successfully</title>';
		echo '<style>.as_wrapper{
	font-family:Arial;
	color:#FECD07;
	font-size:14px;
	padding:20px;
	border:2px dashed #FECD07;
	width:600px;
	margin:0 auto;
}</style>';
echo '<div class="as_wrapper">';
		echo "<h1>Payment Transaction Done Successfully</h1>";
		//echo '<h4>Use this below URL in paypal sandbox IPN Handler URL to complete the transaction</h4>';
		//echo '<h3>https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?action=ipn</h3>';
		echo '</div>';
	break;
	
	case "cancel": // case cancel to show user the transaction was cancelled
		echo "<h1>Transaction Cancelled";
	break;
	
	case "ipn": // IPN case to receive payment information. this case will not displayed in browser. This is server to server communication. PayPal will send the transactions each and every details to this case in secured POST menthod by server to server. 
		$trasaction_id  = $_POST["txn_id"];
		$payment_status = strtolower($_POST["payment_status"]);
		$invoice		= $_POST["invoice"];
		$log_array		= print_r($_POST, TRUE);
		$log_query		= "SELECT * FROM `paypal_log` WHERE `txn_id` = '$trasaction_id'";
		$log_check 		= mysql_query($log_query);
		//echo "<pre>"; print_r($log_array); exit;
		if(mysql_num_rows($log_check) <= 0){
			mysql_query("INSERT INTO `paypal_log` (`txn_id`, `log`, `posted_date`) VALUES ('$trasaction_id', '$log_array', NOW())");
		}else{
			mysql_query("UPDATE `paypal_log` SET `log` = '$log_array' WHERE `txn_id` = '$trasaction_id'");
		} // Save and update the logs array
		$paypal_log_fetch 	= mysql_fetch_array(mysql_query($log_query));
		$paypal_log_id		= $paypal_log_fetch["id"];
		if ($p->validate_ipn()){ // validate the IPN, do the others stuffs here as per your app logic
			mysql_query("UPDATE `purchases` SET `product_id` = '".$_POST['item_id1']."',`product_quantity` = '".$_POST['quantity1']."',`product_name` = '".$_POST['item_name1']."',`trasaction_id` = '$trasaction_id ', `log_id` = '$paypal_log_id', `payment_status` = '$payment_status' WHERE `invoice` = '$invoice'");
			$subject = 'Instant Payment Notification - Recieved Payment';
			$p->send_report($subject); // Send the notification about the transaction
		}else{
			$subject = 'Instant Payment Notification - Payment Fail';
			$p->send_report($subject); // failed notification
		}
	break;
}
?>
   </div>
    </div>
    </div>
    <?php include('footer.php') ?>
</div>
</body>
</html>
