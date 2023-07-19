<?php 
include('Const.Inc.php');
/*
	Send email to activation account.
*/
$rand= rand(100000,999999);
$fetchdata = mysql_fetch_array($orderdata);
$status = $fetchdata['status'];
if($status=='0')
{
	$status =  "Pending";
}
else if($status=='1')
{
	$status = "Processing";
}
else if($status=='2')
{
	$status = "Complete";
}
else if($status=='3')
{
	$status =  "Cancel";
}


$str = "
	<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
		<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
		<hr>
		<p style='color: white;'>
			<br />
				Hello ".$fetchdata['first_name']." ".$fetchdata['last_name'].", <br /><br />
				We have received your order successfully! Below are the order details:
			<br />
		 </p>
				<h3 style='color: #FECD07;'>Order Details:</h3>
			<br />
			<style type='text/css'> table td { color: #FECD07; }</style>
			<table>
				<tr>
					<td>Invoice Number:</td><td> ".$fetchdata['invoice']."</td>
				</tr>
				<tr>
					<td>Product Name:</td><td>".$fetchdata['product_name']."</td>
				</tr>
				<tr>
					<td>Product Price:</td><td>$".$fetchdata['product_price']."</td>
				</tr>
				<tr>
					<td>Product Quantity:</td><td>".$fetchdata['product_quantity']."</td>
				</tr>
			</table>
<br />
				<h3 style='color: #FECD07;'>Shipping Details:</h3>
			<br />
			<table>
				<tr>
					<td>Email Id:</td><td>".$fetchdata['payer_email']."</td>
				</tr>
				<tr>
					<td>Shipping Address:</td><td>".$fetchdata['payer_address'].", ".$fetchdata['payer_city'].", ".$fetchdata['payer_state']." ".$fetchdata['payer_zip'].", ".$fetchdata['payer_country']."</td>
				</tr>
			</table>
			<br>
			<p style='color: white;'> Thank you,<br><br>
			<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'> mysittidev.com </a>
		   
	</div>
 ";

$to  = $fetchdata['payer_email'];
 //$to  = "sumit.manchanda@kindlebit.com";

$subject = "Order Details From Mysitti";
$message = $str;
//$from = "info@mysittidev.com";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: MySitti <mysitti@mysittidev.com>' . "\r\n";
//$headers .= "From:" . $from;

mail($to,$subject,$message,$headers,"-finfo@mysittidev.com");
//echo "test Mail Sent.";
?> 
