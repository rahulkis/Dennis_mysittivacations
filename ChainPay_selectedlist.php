<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);

$host_id = $_GET['host_id'];
$userID=$_SESSION['user_id'];

if($_SESSION['user_id'] == "")
{
	$Obj->Redirect("login.php");
}

// echo "<pre>";
// print_r($_SESSION); die;
if(isset($_SESSION['cart_value_host'])){
$host_array=array_unique($_SESSION['cart_value_host']);

foreach($_SESSION['count_amount_per_host'] as $key => $value){
	$count_amount_per_host_sum[$key]=array_sum($value);
}
}

$HostID = $_SESSION['selectedlist']['host_id'];
$Amount = $_SESSION['selectedlist']['amount'];

$query = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$HostID."'  ");
$fetchquery = @mysql_fetch_assoc($query);

$checkquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$fetchquery['club_name']."' ");
$countcheck = @mysql_num_rows($checkquery);
if($countcheck > 0)
{
	$fetchcheck = @mysql_fetch_assoc($checkquery);

	if($fetchcheck['merchant_id'] == "")
	{
		$que = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$fetchcheck['host_id']."' ");
		$fetchque = @mysql_fetch_assoc($que);
		$merchantid = $fetchque['merchant_id'];	
	}
	else {
		$merchantid = $fetchcheck['merchant_id'];	
	}
}
else
{
	$merchantid = $fetchquery['merchant_id'];	
}





$Adatpay = $Amount / 10 ;

	$titleofpage="Checkout";
	include('headhost.php');
include('header.php');

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
<script>

$(document).ready(function() {	

	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			

	$(window).resize(function () {
	 
 		var box = $('#boxes .window');
 
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
      
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
               
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
	 
	});
	
});

</script>

<style>
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
	
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
<div id="main">
    <div class="container">





<style>
      
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

.innr_odd{ float: left; width: 100%; margin: 5px 0 10px 0;}
      
</style>

<div id="wrapper" class="space">
    

    <div id="profile_box" style="overflow:hidden; padding:10px !important;width: 662px;">
      <h2 id="title" style="text-align: center">Checkout</h2>
      <h2 style="border: none;">Proceed To payment</h2>
         <table class='display loadmusic' id='example' style='margin-top:10px; width: 98%;' >

 <form action="ChainedPay.php" method="post"> <?php // remove sandbox=1 for live transactions ?>
    
    	<?php	$i = 1;
	$counter=1;
	//print_r($_SESSION['cart_value']);
		

$this_script = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

    
    /* code from chained file */
require_once("paypal/paypal_class.php");
require_once('PPBootStrap.php');
require_once('Common/Constants.php');
define("DEFAULT_SELECT", "- Select -");
    $invoice=date("His").rand(1234, 9632); 
	$i=0;
	$frmdata=array();
	 

	
	
	$receiver = array();
		
		$receiver[$i] = new Receiver();
		/*$receiver[$i]->email =  trim($_receiverEmail[$i]);		
		$receiver[$i]->amount = $_receiverAmount[$i];		
		$receiver[$i]->primary = $_primaryReceiver[$i];*/
		
	$receiver[0] = new Receiver();	
	
	$receiver[0]->email = PAYPAPOWNERID;
	$receiver[0]->primary =  'true';
	$receiver[0]->amount =$Amount;
	$receiver[1] = new Receiver();	
	$receiver[1]->amount =$Adatpay;
	$receiver[1]->email = trim($merchantid);
	$receiver[1]->primary =  'false';
	
	
	$receiverList = new ReceiverList($receiver);
 $_POST['returnUrl']='https://'.$_SERVER['HTTP_HOST']."/jukeboxsend.php?action=succes";
$_POST['cancelUrl']='https://'.$_SERVER['HTTP_HOST']."/shopping_cart.php?action=cancel";
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
}?>
<link href="Common/sdk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="Common/tooltip.js">
    </script>
	<?
$ack = strtoupper($response->responseEnvelope->ack);
if($ack != "SUCCESS") {
	echo "<span style='color:white; float:left;width:65%; font-size:17px;'>Sorry, Currently we can't process your request.</span>";
	echo "<a  class='button' href='music_request.php?host_id=".$HostID."'>Go to Music Request Page.</a>";

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
    

</div>

	</div>
	</div>
	</div>

<?php
if(isset($_GET['id'])){
include('friend-profile-panel.php');	
}else{
include('friend-right-panel.php');
} ?>
</div></div>
<?php include('footer.php') ?>
<script>
	function submitpaypalform(pp){
		$(location).attr('href',pp);
		/*jQuery(".submitedpaypal").hide();
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
		
		
	});	return false;*/
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