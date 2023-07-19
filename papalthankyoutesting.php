<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PayPal Adaptive Payments - Pay</title>
<link rel="stylesheet" type="text/css" href="Common/sdk.css" />
<script type="text/javascript" src="Common/sdk_functions.js"></script>
<script type="text/javascript" src="Common/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="Common/jquery.qtip-1.0.0-rc3.min.js"></script>
</head>
<?php	
	$serverName = $_SERVER['SERVER_NAME'];
	$serverPort = $_SERVER['SERVER_PORT'];
	$url = dirname('https://' . $serverName . ':' . $serverPort . $_SERVER['REQUEST_URI']);
	$returnUrl = "http://mysittidev.com/WebflowReturnPage.php";
	//$returnUrl = "http://web1.kindlebit.com/clientdemo/PayPalAdaptive/samples/WebflowReturnPage.php";
	$cancelUrl =  "http://mysittidev.com/papalthankuoutesting.php";
	//$cancelUrl =  "http://web1.kindlebit.com/clientdemo/PayPalAdaptive/samples/SimpleSamples/ChainedPay.html.php";
?>

<body>
	<div id="wrapper">
		<img src="https://devtools-paypal.com/image/bdg_payments_by_pp_2line.png"/>
		<div id="header">
			<h3>Chained Pay</h3>
			
		<div id="request_form">
			<form action="ChainedPay2.php" method="post">
				
				
				<input name="invoice" id="invoice" value="PAY" readonly="123423"/>
				<input name="item_id_1" id="item_id_1" value="PAY" readonly="23"/>
				<input name="item_name_" id="item_name_" value="PAY" readonly="readonly"/>
				<input name="quantity_1" id="quantity_1" value="PAY" readonly="4"/>
				<input name="amount_1" id="amount_1" value="PAY" readonly="readonly"/>
				
				
				<div class="params">
					<div class="param_name">Action type *</div>
					<div class="param_value">
						<input name="actionType" id="actionType" value="PAY" readonly="readonly"/>
					</div>
				</div>
				<div class="params">
					<div class="param_name">Return Url</div>
					<div class="param_value">
						<input name="returnUrl" id="returnUrl" value="<?php echo $returnUrl;?>" />
					</div>
				</div>
				<div class="params">
					<div class="param_name">Cancel Url *</div>
					<div class="param_value">
						<input name="cancelUrl" id="cancelUrl" value="<?php echo $cancelUrl;?>" />
					</div>
				</div>
				<div class="params">
					<div class="param_name">Currency code *</div>
					<div class="param_value">
						<input name="currencyCode" value="USD" />
					</div>
				</div>
		
				<div class="params">
					<div class="param_name">Memo</div>
					<div class="param_value">
						<input name="memo" value="" />
					</div>
				</div>

				<div class="section_header">Receiver info</div>
				<table class="params" id="receiverTable">
					<tr>
						<th></th>
						<th>Email *</th>
						<th>Amount *</th>
						<th>Primary Receiver</th>
						</tr>
					<tr id="receiverTable_0">
						<td align="left"><input type="checkbox" name="receiver[]" id="receiver_0"  /></td>
						<td>
							<input type="text" name="receiverEmail[]" id="receiveremail_0" value="merchant1315@gmail.com">
						</td>
						<td>
							<input type="text" name="receiverAmount[]" id="amount_0" value="1.0" class="smallfield">
						</td>
										
						<td>
							<select name="primaryReceiver[]" id="primaryReceiver_0" class="smallfield">
								<option value="true"  selected="selected">true</option>
								<option value="false">false</option>
							</select>
						</td>				
					</tr>
					<tr id="receiverTable_1">
						<td align="left"><input type="checkbox" name="receiver[]" id="receiver_1"  /></td>
						<td>
							<input type="text" value="amit.kumar@kindlebit.com" id="receiveremail_1" name="receiverEmail[]">
						</td>
						<td>
							<input type="text" class="smallfield" value="1.0" id="amount_1" name="receiverAmount[]">
						</td>
										
						<td>
							<select class="smallfield" id="primaryReceiver_1" name="primaryReceiver[]">
								<option value="true">true</option>
								<option selected="selected" value="false">false</option>
							</select>
						</td>				
					</tr>
					
				</table>
				<a rel="receiverControls"></a>
				<table align="center">
					<tr>
						<td><a href="#receiverControls" onclick="cloneRow('receiverTable', 8)" id="Submit"><span> Add
									Receiver  </span> </a></td>
						<td><a href="#receiverControls" onclick="deleteRow('receiverTable')" id="Submit"><span>  Delete
									Receiver</span> </a></td>
					</tr>
				</table>
				
							
				<div class="submit">
					<input type="submit" value="Submit" />
				</div>
			</form>
		</div>
		
	</div>
</body>
</html>
