<?php
include("Query.Inc.php");
$Obj = new Query($DBName);


if(isset($_REQUEST["actions"])){	
    $trasaction_id  = $_POST["txn_id"];
    $invoice = $_POST["memo"];
    $payment_status=$_POST['payment_status'];
    echo "<pre>";
    $log_array		= print_r($_POST, TRUE);    
   mysql_query("INSERT INTO `paypal_log` (`id`, `txn_id`, `log`, `posted_date`, `invoice`) VALUES (NULL, ' $trasaction_id', '$log_array', 'now()','$invoice' )");
    if($payment_status==Completed){
	
	$row=@mysql_query("select * from `temp_purchase` where invoice=".$invoice);
	$i=1;
	while($row1 = mysql_fetch_array( $row)){
	 @mysql_query("INSERT INTO `purchases` 
	 	(`invoice`, `product_id`,`trasaction_id`,`log_id`, `product_name`, `product_quantity`, `product_amount`, `payer_fname`, `payer_lname`, `payer_address`, `payer_city`, `payer_state`, `payer_zip`, `payer_country`, `payer_email`, `payment_status`, `posted_date`,`product_type`,`user_id`,`host_id`,`product_size`,`product_color`) 
	 	VALUES('".$row1["invoice"]."', '".$row1["product_id"]."', '".$trasaction_id."', '".$log_array."', '".$row1["product_name"]."', '".$row1["product_quantity"]."', '".$row1["product_amount"]."', '".$row1["payer_fname"]."', '".$row1["payer_lname"]."', '".$row1["payer_address"]."', '".$row1["payer_city"]."', '".$row1["payer_state"]."', '".$row1["payer_zip"]."', '".$row1["payer_country"]."', '".$row1["payer_email"]."', 'complete', NOW(),'".$row1["product_type"]."','".$row1["user_id"]."','".$row1["host_id"]."','".$row1["product_size"]."','".$row1["product_color"]."')");
 if($row1["product_type"]=='product'){
	 @mysql_query("INSERT INTO `store_order_status` 
	 	(`invoice`, `status`,`date`) 
	 	VALUES('".$row1["invoice"]."', '0', 'now()')");

	 $stID = mysql_insert_id();
	 	@mysql_query("UPDATE product_sizes SET `stock`=(`stock`-".$row1["product_quantity"].") WHERE `product_id`=".$row1["product_id"]." and size=".$row1["product_size"]." and color=".$row1["product_color"]);

/* NOTIFICATION CODE */

	 	$order_added_on = date('Y-m-d h:i:s');
		$c_identifier = "store_order_status_".$stID;
		
		mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$row1["user_id"]."', '".$row1["host_id"]."', 'order', '".$order_added_on."', '1', '".$c_identifier."', 'user', 'club')");

/* END */		
	}
	
   $invoice=$row1["invoice"];
   $userid=$row1["user_id"];
	 $i++;
	}
   }
    @mysql_query("delete  FROM `temp_purchase` WHERE invoice !='".$invoice."' AND user_id='".$userid."'");
}

if(isset($_POST['arrayquery'])){
	$arrayOfquerys=json_decode($_POST['arrayquery']);
	$user_id=$_POST['user_id'];	
// echo "PA=".$_REQUEST['payAddress'];	 die;
	$i=1;	
	foreach($arrayOfquerys as $arrayOfquery){		
		if($i==1){		
		@mysql_query("delete  FROM `temp_purchase` WHERE invoice !='".$arrayOfquery->invoice."' AND user_id='".$user_id."'");
		}
		$item_id="product_id";
		$item_name="";
		$quantity="qty";
		$amount= "price_cart"; 
		$size= "size"; 
		$color= "color";  
		$product_type= "product_type";
                $host_id= "host_id";
		$qty=$arrayOfquery->$quantity;
		 $amnt=$arrayOfquery->$amount;
		 $totalamount=$qty*$amnt;

// echo $arrayOfquery->payeadd; die;

		@mysql_query("INSERT INTO `temp_purchase` (`invoice`, `product_id`, `product_name`, `product_quantity`, `product_amount`, `payer_fname`, `payer_lname`, `payer_address`, `payer_city`, `payer_state`, `payer_zip`, `payer_country`, `payer_email`, `payment_status`, `posted_date`,`user_id`,`product_type`,`host_id`,`product_size`,`product_color`) VALUES('".$arrayOfquery->invoice."', '".$arrayOfquery->$item_id."', '".$item_name."', '".$qty."', '".$totalamount."', '".$arrayOfquery->payer_fname."', '".$arrayOfquery->payer_lname."', '".$_REQUEST['payAddress']."', '".$arrayOfquery->payer_city."', '".$arrayOfquery->payer_state."', '".$arrayOfquery->payer_zip."', '".$arrayOfquery->payer_country."', '".$arrayOfquery->payer_email."', 'pending', NOW(),'".$user_id."','".$arrayOfquery->$product_type."','".$arrayOfquery->$host_id."','".$arrayOfquery->$size."','".$arrayOfquery->$color."')");
		$i++;
	}
}

