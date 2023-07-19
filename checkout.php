<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Checkout";

$host_id = $_GET['host_id'];
$userID=$_SESSION['user_id'];

if(!isset($_SESSION['new_amt_mysitti']) && !isset($_SESSION['new_amt_host'])){
	
	$percentage = 18;
	$totalamt = $_SESSION['total_prodcut_price'];
	
	$new_amt_mysitti = ($percentage / 100) * $totalamt;
	
	$mysitti_fees_cal =  number_format($new_amt_mysitti,2,".",",");

	$percentage_host = 82;
	$totalamt_host = $_SESSION['total_prodcut_price'];
	
	$new_amt_host = ($percentage_host / 100) * $totalamt_host;
	$final_amount_host = $new_amt_host;
	
	$mysitti_host_fees_cal =  number_format($final_amount_host,2,".",",");
	
	$_SESSION['new_amt_mysitti'] = $new_amt_mysitti;
	$_SESSION['new_amt_host'] = $final_amount_host;	
	
}

$removeKeys_main = array();
foreach($_SESSION['cart_value'] as $key=>$single_cart_value){
	
	if($single_cart_value['host_id'] == $_GET['host_id']){

			$removeKeys_main[] = $single_cart_value;
	}
}

if(isset($_SESSION['cart_value_host'])){
$host_array=array_unique($_SESSION['cart_value_host']);

foreach($_SESSION['count_amount_per_host'] as $key => $value){
	$count_amount_per_host_sum[$key]=array_sum($value);
}
}
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="success")
	{
	$message="Profile Updated.";
	}
	if($para=="imagefail")
	{
	$message="Invalid Image.";
	}
	if($para=="update")
	{
	$message="Coupon Updated Sucessfully";
	}
}

if(isset($userID))
{
$sql_getad=@mysql_query("select * from host_ad where host_id='".$userID."'");
$rw_ad=@mysql_fetch_assoc($sql_getad);
//print_r($rw_ad);exit;
$query_string = "SELECT id FROM user where id!='1' AND is_online='1' AND logged_date < DATE_SUB(CURDATE(), INTERVAL 1 HOUR)  ORDER BY id";
$result = @mysql_query($query_string);
while($row_a = @mysql_fetch_array($result))
{
	@mysql_query("update user set is_online='0' where id='".$row_a['id']."'");
}

// for coupon
$sql_fe=@mysql_query("select * from  host_coupon where host_id='".$userID."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);
/// end here 

// query to show data in fields

$query_data=@mysql_query("select U.*,C.name as Country_Name,Z.name as State_Name,CC.city_name as City_Name from user as U,country as C,zone as Z, capital_city as CC where U.country=C.country_id and U.state=Z.zone_id and U.city=CC.city_id and U.id=$userID") or die(mysql_error());
$query_data_row_fe=@mysql_fetch_array($query_data);

include('LoginHeader.php');
?>

<script type="text/javascript">
$(document).ready(function(){
    $('object').css('width', '300px');
});

function makelike(action,video_id,who_like_id)
{
 $.get('video-like_unlike.php?action='+action+'&video_id='+video_id+'&who_like_id='+who_like_id, function(data) {
$('#vid_'+video_id).html(data);

});
}
</script>

<?php
  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}

	 $sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;	
 /**********************************/

?>



<style>

.v2_banner_top .v2_header_wrapper{
	    overflow: visible;
	    padding-top: 0 !important;
}

.loadmusic.checkout label {
    color: #333333;
    font-size: 14px !important;
    font-weight: normal !important;
}
#mask {
  position:absolute;
  left:0;
  top:0;
  z-index:500;
  background-color:#000;
  display:none;
}
  
 .window {
	position:fixed;
	left:0;
	top:0;
	display:none;
  	z-index:9000;
	height: 400px;
	width: 600px;
}

.odd {
    background-color: rgb(226, 228, 255);
    float: left;
    width: 99.3%;
}
.even {
    background-color: rgb(255, 255, 255);
    float: left;
    width: 99.3%;
}
  .cart_inner {
  box-sizing: border-box;
  padding: 0 20px;
}

h3{
border-bottom: 1px solid #333;
color: #fecd07;
display: block;
float: none;
font-size: 22px;
margin-bottom: 10px;
padding: 10px 0;
text-align: left;	
}
.cart-btn-pack a {
  margin-right: 10px;
}
.gutter20{margin-bottom:20px;}  
</style>

<script>
function frame()
{
	document.getElementsByTagName('object').width = "200";
	document.getElementsByTagName('object').height = "200";

}
</script>

</head>
<body >

<div class="v2_container">
	<div class="v2_inner_main">
		<div class="v2_inner_main_content">
		
<style>
.loadmusic.checkout {
  width: 50%;
}
.loadmusic.checkout label {
  font-weight: bold;
  font-size: 14px !important;
}
#example tr th{ float: left; 
    padding: 6px 20px 6px 7px;
    width: 76px;}      
  .mediaplayer {
    float: left;
    width: 101px; margin: 0 0 0 5px;
}

.odd {
    float: left;
    width: 100%;
}

.loadmusiccd {
    float: left;
    width: 120px; margin: 0 0 0 5px;
}

.loadmusiccd2 {
    float: left;
    width: 72px; margin: 0 0 0 34px; word-break: break-all;
}

.loadmusiccd1 {
      float: left;
    margin: 0 0 0 6px;
    width: 88px;
}
.loadmusic tr {
  border-bottom: 0px solid #333 !important;
}

.innr_odd{ float: left; width: 100%; margin: 5px 0 10px 0;}
      
</style>

<div id="wrapper" class="space">
 	<div class="v2_recent_contests gutter20">
        <div class="cart_inner">   

    <div id="profile_box" style="">
      <h3>Checkout</h3>
         <table class='display checkout' id='' style='width:100%;' >
<tr>
<?php

     

?></tr></table>
 <form action="ChainedPay.php" method="post"> <?php // remove sandbox=1 for live transactions ?>
    
    	<?php	$i = 1;
	$counter=1;
	//print_r($removeKeys_main);
	if (is_array( $removeKeys_main)) {
		
	} else { echo 'Your cart is empty';}		

// echo "<pre>"; print_r($_POST);echo "</pre>";

$this_script = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$primaryamount=$_POST['subtotal'];
$secamount=$_POST['subtotal']-((10*$_POST['subtotal'])/100);

if(isset($_POST['alternate_shipping']) && $_POST['alternate_shipping'] == 'true'){
	
	$country_name = mysql_query("SELECT name FROM country WHERE country_id = '".$_POST['shipping_country']."'");
	$c_name = mysql_fetch_assoc($country_name);
	
	$state_name = mysql_query("SELECT name FROM zone WHERE zone_id = '".$_POST['shipping_state']."'");
	$st_name = mysql_fetch_assoc($state_name);
	
	$city_name = mysql_query("SELECT city_name FROM capital_city WHERE city_id = '".$_POST['shipping_city']."'");
	$cty_name = mysql_fetch_assoc($city_name);	
	
	$_POST["payer_fname"] = $_POST['shipping_fname'];
	$_POST["payer_lname"] = $_POST['shipping_lname'];
	$_POST["payer_address"] = $_POST['shipping_address'];
	$_POST["payer_city"] = $cty_name['city_name'];
	$_POST["payer_state"] = $st_name['name'];
	$_POST["payer_zip"] = $_POST['shipping_zip'];
	$_POST["payer_country"] = $c_name['name'];
	$_POST["payer_email"] = $query_data_row_fe['email'];

}else{

	$_POST["payer_fname"] = $query_data_row_fe['first_name'];
	$_POST["payer_lname"] = $query_data_row_fe['last_name'];
	$_POST["payer_address"] = $query_data_row_fe['user_address'];
	$_POST["payer_city"] = $query_data_row_fe['City_Name'];
	$_POST["payer_state"] = $query_data_row_fe['State_Name'];
	$_POST["payer_zip"] = $query_data_row_fe['zipcode'];
	$_POST["payer_country"] = $query_data_row_fe['Country_Name'];
	$_POST["payer_email"] = $query_data_row_fe['email'];

}



$merchant = PAYPAPOWNERID;
?>
    <table class='loadmusic checkout' id='' style="background: none !important; color: #FFF;">
      <tr>
        <td><label>Payer First Name</label></td>
        <td><input id="payer_fname" type="text" name="payer_fname" value="<?php echo $_POST["payer_fname"]; ?>" /></td>
    </tr>
    <tr>
        <td><label>Payer Last Name</label></td>
        <td><input id="payer_lname" type="text" name="payer_lname" value="<?php echo $_POST["payer_lname"];?>" /></td>
    </tr>
    <tr>
        <td><label>Payer Address</label></td>
        <td>
			<textarea placeholder="Enter your Address" id="payer_address" name="payer_address"><?php echo $_POST["payer_address"]; ?></textarea>
			
	<!--		<input id="payer_address" type="text" name="payer_address" value="<?php echo $_POST["payer_address"]; ?>"  placeholder="Enter your Address" />-->
		
		</td>
    </tr>
    <tr>
        <td><label>Payer City</label></td>
        <td><input type="text" name="payer_city" value="<?php echo $_POST["payer_city"];?>" readonly /></td>
    </tr>
    <tr>
        <td><label>Payer State</label></td>
        <td><input type="text" name="payer_state" value="<?php echo $_POST["payer_state"]; ?>" readonly /></td>
    </tr>    
    <tr>
        <td><label>Payer Zip</label></td>
        <td><input type="text" name="payer_zip" value="<?php echo $_POST["payer_zip"]; ?>" readonly /></td>
    </tr>
    <tr>
        <td><label>Payer Country</label></td>
        <td><input type="text" name="payer_country" value="<?php echo $_POST["payer_country"]; ?>" readonly /></td>
    </tr> 
    <tr>
        <td><label>Payer Email</label></td>
        <td><input type="text" name="payer_email" value="<?php echo $query_data_row_fe['email'];?>" readonly /></td>
    </tr>
    <tr>
		<? /* adaptive payment*/?>
		<input type="hidden" name="receiverEmail[]" id="receiveremail_0" value="<?php echo $merchant; ?>">
		<? $primaryamount=round($primaryamount,2);?>
		<input type="hidden" name="receiverAmount[]" id="amount_0" value="<? echo $primaryamount;?>" class="smallfield">
		<div style="display:none;">		
			<select name="primaryReceiver[]" id="primaryReceiver_0" class="smallfield">
				<option value="true"  selected="selected">true</option>
				<option value="false">false</option>
			</select>
		</div>
		
		<?php		
		$i=1;	
	$count_amount_per_host_sum= array();
	foreach($removeKeys_main as $key=>$value){

		$count_amount_per_host_sum[$value['host_id']][] = $value['price_cart']*$value['product_qty'];
	}	
		$i_rec_email=0;
		$_receiverEmail=array();
		$_receiverEmail[$i_rec_email]=PAYPAPOWNERID;
		$_receiverAmount=array();
		$_receiverAmount[$i_rec_email] = $_SESSION['new_amt_mysitti'];
		$_primaryReceiver[$i_rec_email] = "false";
		
	

		foreach($count_amount_per_host_sum as $key=>$sum){
			
			//$_SESSION['shipping_charges_add']
			
			$sum = array_sum($sum);
			$afterdisamount = $sum-(($sum*17)/100);
			$afterdisamount = round($afterdisamount,2);
			
		  $row = mysql_query("select merchant_id from clubs where id=".$key) ;		  
		  $data = mysql_fetch_array($row);	
		  $i_rec_email++;
		  $_receiverEmail[$i_rec_email] = $data['merchant_id'];
		  $_receiverAmount[$i_rec_email] = $_SESSION['new_amt_host'];
		  $_primaryReceiver[$i_rec_email] = "true";
		  ?>
		<input type="hidden" value="<? echo $data['merchant_id'];?>" id="receiveremail_<? echo $i;?>" name="receiverEmail[]">	
		<input type="hidden" class="smallfield" value="<?echo $afterdisamount;?>" id="amount_<? echo $i;?>" name="receiverAmount[]">	
		<div style="display:none;">
		<select class="smallfield" id="primaryReceiver_<? echo $i;?>" name="primaryReceiver[]">
			<option value="true">true</option>
			<option selected="selected" value="false">false</option>
		</select>
			</div>
			
			<?php $i++; }
			?>
		
		
        <!--<td colspan="2" align="center"><input style="float: none;"  class="button" type="submit" name="submit" value="Pay Now" /></td>-->
    </tr>
    </table>
    <input type="hidden" name="countercount" value="<?php echo $counter; ?>" />
    
    
    
    <?
    
    /* code from chained file */
require_once("paypal/paypal_class.php");
require_once('PPBootStrap.php');
require_once('Common/Constants.php');
define("DEFAULT_SELECT", "- Select -");
    $invoice=date("His").rand(1234, 9632); 
	$i=0;
	$frmdata=array();
	 

	foreach($removeKeys_main as $key=>$value){		
		if($value['product_type']==0){
			$type="music";$product_size=0;$product_color=0;
			 $sql="SELECT price as prodctprice FROM music where id ='".$value['product_id']."'";
			 $cartquery1 = mysql_query($sql);
		     $cartquery=mysql_fetch_array($cartquery1);
		     //$host_id='0';
		}else if($value['product_type']==1){
			$type="cd";$product_size=0;$product_color=0;
			$sql="SELECT cd_price  as prodctprice FROM cds where id ='".$value['product_id']."'";
			$cartquery2 = mysql_query($sql);
		    $cartquery=mysql_fetch_array($cartquery2);
		    //$host_id='0';
		}else{
			 $type="product";$product_size=$value['choose_sizex'];$product_color=$value['choose_colorx'];
			 $sql="SELECT product_price as prodctprice ,host_id FROM host_product where id ='".$value['product_id']."'";
			$cartquery3 = mysql_query($sql);
		    $cartquery=mysql_fetch_array($cartquery3);
		    // $host_id=$cartquery['host_id'];
		}
		
		$frmdata[$i]= array('color'=>$product_color,'size'=>$product_size,'invoice'=>$invoice,'product_id'=>$value["product_id"],'qty'=>$value["product_qty"],'price_cart'=>$cartquery['prodctprice'],'payer_fname'=>$_POST["payer_fname"],'payer_lname'=>$_POST["payer_lname"],'payer_address'=>$_POST["payer_address"],'payer_city'=>$_POST["payer_city"],'payer_state'=>$_POST["payer_state"],'payer_zip'=>$_POST["payer_zip"],'payer_country'=>$_POST["payer_country"],'payer_email'=>$_POST["payer_email"],'product_type'=>$type,'host_id'=>$host_id);
	$i++;
	}
	
	array_filter($_receiverEmail);
	
	$receiver = array();
		for($i=0; $i<count($_receiverEmail); $i++) {
		$receiver[$i] = new Receiver();
		$receiver[$i]->email =  trim($_receiverEmail[$i]);		
		$receiver[$i]->amount = $_receiverAmount[$i];		
		$receiver[$i]->primary = $_primaryReceiver[$i];
		
	}
	
	
	//echo "<pre>";
	//print_r($_SESSION);
	//echo "</pre>";
	//die;

	$h_email = $receiver[1]->email;
	$receiver = array();
	$receiver[0] = new Receiver();
	
	// A receiver's email address
	$receiver[0]->email = $h_email;
	
	// Amount to be credited to the receiver's account
	$receiver[0]->amount = round($_SESSION['new_amt_host'] , 2);
	
	$receiver[1] = new Receiver();
	// A receiver's email address
	$receiver[1]->email = PAYPAPOWNERID;
	
	// Amount to be credited to the receiver's account
	$receiver[1]->amount = round($_SESSION['new_amt_mysitti'] , 2);

	//$receiver[0]->amount =$sum;
	$receiverList = new ReceiverList($receiver);

$_POST['returnUrl'] = $SiteURL."host_profile.php?host_id=".$host_id."&invoiceid=".$invoice."&payment=success";
$_POST['cancelUrl'] = $SiteURL."shopping_cart.php?action=cancel";
$_POST['actionType']="PAY";
$_POST['currencyCode']="USD";

$payRequest = new PayRequest(new RequestEnvelope("en_US"), $_POST['actionType'], $_POST['cancelUrl'], $_POST['currencyCode'], $receiverList,$_POST['returnUrl']);

$payRequest->memo = $invoice;
$payRequest->cmd = "_notify-validat";
// echo "<pre>"; print_r($payRequest); exit;

$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
// echo "<pre>"; print_r($service); exit;
try {
	/* wrap API method calls on the service object with a try catch */
	$response = $service->Pay($payRequest);
	
	//echo "<pre>";
	//print_r($response);
	//echo "</pre>";	
	
} catch(Exception $ex) {
	require_once 'Common/Error.php';
	exit;
}?>
<link href="Common/sdk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="Common/tooltip.js">
    </script>
	<?
$ack = strtoupper($response->responseEnvelope->ack);
if($ack != "SUCCESS") {
	echo "<div class=' NoRecordsFound errorclass' style=''>Error in cart,Please check again your cart </div>";
	echo "<a  class='button' href='cart.php'>Go to cart page</a>";

} else {
	$payKey = $response->payKey;
	$payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey;
	
			//echo "<a class='button' href=$payPalURL><b>Complete Payment using Paypal</b></a>";
			?>
			<div class="submitedpaypalwait" style="display:none; pointer-events: none;">
			<a class='button' ><b>Pay Now</b></a>
			</div>
			<div class="submitedpaypal">
			<a class='button' onclick='submitpaypalform("<? echo $payPalURL?>")' ><b>Pay Now</b></a>
			</div>
			<?
	
}
//require_once 'Common/Response.php';

	 /* code from chained file */
	?>
	
	
	
	
	
    </form>
</table>
</div>
</div>

<script type="text/javascript">
	function submitpaypalform(pp){
		
		jQuery(".submitedpaypal").hide();
		jQuery(".submitedpaypal").show();
		 arrayquery = new Array();
		var arrayquery='<?php echo json_encode($frmdata); ?>';
		
		var payefname = $('#payer_fname').val();
		if(payefname == "" || payefname == " ")
		{
			alert("Please Enter First Name.");
			return false;
		}
		
		var payelname = $('#payer_lname').val();
		if(payelname == "" || payelname == " ")
		{
			alert("Please Enter Last Name.");
			return false;
		}
		
		var payeadd = $('#payer_address').val();
		if(payeadd == "" || payeadd == " ")
		{
			alert("Please Enter Shipping Address.");
			return false;
		}
		else
		{
		//url='https://www.sandbox.paypal.com/webscr&cmd=_ap-payment&paykey='+payPalURL;
			user_id="<? echo $_SESSION['user_id']?>";
			$.ajax({
				type: "POST",
				url: "ipn.php",
				data: "arrayquery="+arrayquery+"&user_id="+user_id+"&payAddress="+payeadd,
				success: function(result){
					// alert(result);
					//return false;
				$(location).attr('href',pp);
				}
		
		
			});
			return false;
		}
}

</script>
<script language="javascript">
function playvideo(id)
{
jwplayer('a'+id).stop();
$('#ve_'+id).click();
 
}
function  deletevideo(id)
{
var r=confirm("Are you sure you want delete this video");
if (r==true)
  {
    $.get('delete-video.php?video_id='+id, function(data) {
	 window.location='home_club.php';
	});
  }

 }
 
 function deletephoto(id)
 {
   var r=confirm("Are you sure you want delete this Photo");
if (r==true)
  {
    $.get('delete-video.php?type=img&image_id='+id, function(data)
	{
	 window.location='home_club.php';
	});
  }
 
 }
</script>		
		
		</div>
	</div>
</div>

<?php include('Footer.php');
}
else
{
$Obj->Redirect("index.php");
}
?>