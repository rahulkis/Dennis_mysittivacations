<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}
if($_SESSION['user_type']=='user'){
	$Obj->Redirect("profile.php");
}

$titleofpage="Store";

if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

/******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}


	
	if(isset($_POST['savesetting']))
	{
		$merchant_id = mysql_real_escape_string($_POST['paypal_merchant_id']);
		
		if(empty($merchant_id))
		{
			$merchant_id = "";
		}
		mysql_query("UPDATE `clubs` SET `merchant_id` = '".$merchant_id."' WHERE `id` = '".$_SESSION['user_id']."'  ");
		$value = $_POST['function'];
		if($value == "Disable with message")
		{
			$m = $_POST['message'];
		}
		else
		{
			$m = "";
		}
		$getq1 = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_SESSION['user_id']."'  ");
		$countrec1 = @mysql_num_rows($getq1);
		if($countrec1 > 0)
		{
			@mysql_query("UPDATE `host_functions_setting` SET `store` = '$value', `message` = '$m' WHERE `host_id` = '".$_SESSION['user_id']."'  ");
		}
		else
		{
			@mysql_query("INSERT INTO `host_functions_setting` (`host_id`,`store`,`message`) VALUES ('".$_SESSION['user_id']."','$value','$m')  ")	;
		}
		
		$message['success'] = "Store Settings is Saved.";
	}


	if(isset($_POST['saveshipping']))
	{
		$string = "";
		if( $_POST['shipping_type'] == "Free")
		{
			$shippingType = 'Free'; 
			mysql_query("UPDATE `clubs` SET `shipping_type` = 'Free', `fixed_shipping_price` = ''  WHERE `id` = '$_SESSION[user_id]'");
			
		}else if( $_POST['shipping_type'] === "Fixed Price")
		{
			//$shippingType = 'Free';
			if(empty($_POST['fixed_price'])){
				$shipping_price = '0.00';
			}else{
				$shipping_price = $_POST['fixed_price'];
			}
			
			mysql_query("UPDATE `clubs` SET `shipping_type` = 'Fixed Price', `fixed_shipping_price` = '".$shipping_price."' WHERE `id` = '".$_SESSION[user_id]."'");
		}
		else
		{
			foreach($_POST['shipping_type'] as $shipping_type)
			{
				$string .= $shipping_type.",";
			}
			$string = trim(rtrim($string,","));
			mysql_query("UPDATE `clubs` SET `shipping_type` = '$string', `fixed_shipping_price` = '' WHERE `id` = '$_SESSION[user_id]'");
		}

		$message['success'] = "Shipping Settings Saved.";
	}
?>

<style type="text/css">
	#shippingsettings > div {
		float: left;
		margin: 5px 0;
		width: 100%;
	}

</style>
<a href="javascript:TB_show('Send invitation to friend/faimly for pledge', 'user_pledge_invite.php?user=testuserTB_iframe=true&amp;height=400&amp;width=450', '', './images/trans.gif');"></a>	

<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
 	<?
		if($_SESSION['user_type'] != 'user')
    		{
    			include('club-right-panel.php');
    		}
    		else
    		{
    			 include('friend-right-panel.php');
    		}
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title">Store </h3>
						<?php if($message['success'] != ""){ 

						echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
						}
						if($message['error'] != ""){ 

						echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
						}
						
						$check_merchant_id_query = mysql_query("SELECT merchant_id FROM clubs WHERE id = '".$_SESSION['user_id']."'");
						$count_merchant_id = mysql_fetch_assoc($check_merchant_id_query);
						
						if(empty($count_merchant_id['merchant_id'])){
						?>
						
						<div style="background: none repeat scroll 0% 0% red ! important; border: 1px solid red ! important;" id="successmessage" class="message" >Please fill your paypal merchant id</div>
						
						<?php } ?>
						
						<div style="clear:both;"></div>
						<div class="store-banner">
							<img src="images/store-banner.png" alt="banner">
							<h3>Your own Store</h3>
							<p>
								This is a free tool that MySitti provides to allow you to earn money which would allow you to keep doing what you love doing, performing. Selling your merchandise with your name and logo also acts as an advertisement. This will supercharge your career while giving you money now.
							</p>
							</div>
						<div class="store_content" style="padding-top: 28px;">
							<div class="store_contentf store_menu">
								<span>
									<a href="manage_category.php" class="button">Categories</a>
								</span>
								<span>
									<a href="manage_order.php" class="button">Orders</a>
								</span>
								<span>
									<a href="order_history.php" class="button">Order History</a>
								</span>							
								<span>
									<a href="report.php" class="button">Reporting</a>
								</span>							
								<span>
									<a href="host_store.php" class="button">User View Store</a>
								</span>							
								<span>
									<a href="manage_product.php" class="button">Products</a>
								</span>
								<span>
									<a href="cds.php" class="button">Music & Video</a>
								</span>
	                        					</div>
	                    				</div>
	                    				<!--  SHIPPING SETTINGS SECTION -->

	                    				<div class="storefunctionsetting">
	                    					<h1 id="title">Shipping Settings: </h1>
	                    					<?php 

	                    					$getq = mysql_query("SELECT `fixed_shipping_price`, `shipping_type` FROM `clubs` WHERE `id` = '".$_SESSION['user_id']."'  ");
							$countrec = @mysql_num_rows($getq);
							$fetchstatus = mysql_fetch_array($getq);
							$explode = explode(",", $fetchstatus['shipping_type']);
							
								?>
							<form method="POST" action="" style="color:#FFF;" id="shippingsettings">
								<div>
									<input <?php if(in_array("Fixed Price", $explode)){ echo "checked"; } ?> type="radio" id="fixed_price_radio" name="shipping_type" value="Fixed Price" />Fixed Price <input <?php if(!empty($fetchstatus['fixed_shipping_price'])){ ?> value="<?php echo $fetchstatus['fixed_shipping_price']; ?>" <?php } ?> type="text" name="fixed_price" id="fixed_price">
								</div>							
								<div>
									<input <?php if(in_array("Fedex", $explode)){ echo "checked"; } ?> type="checkbox" name="shipping_type[]" value="Fedex" />Fedex
								</div>
								<div>
									<input <?php if(in_array("UPS", $explode)){ echo "checked"; } ?> type="checkbox" name="shipping_type[]" value="UPS" />UPS
								</div>
								<div>
									<input <?php if(in_array("Free", $explode)){ echo "checked"; } ?> type="radio" name="shipping_type" value="Free" />Free Shipping
								</div>
								<div class="settingformsubmit">
									<input type="submit" class="button" name="saveshipping" value="Save" />
								</div>
							</form>
	                    				</div>

	                    				<!--  END HERE  -->

	                    				<div class="storefunctionsetting">
	                    					<h1 id="title">Store Display Settings: </h1>
	                    					<?php 
	                    					$getq = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_SESSION['user_id']."'  ");
							$countrec = @mysql_num_rows($getq);
							if($countrec > 0)
							{
								$fetchstatus = @mysql_fetch_array($getq);
								$statuspage = $fetchstatus['store'];
								$me = $fetchstatus['message'];
							}
							else
							{
								$statuspage = "Enable";
								$me= "";
							}


	                    					?>
	                    					<script src='js/jqueryvalidationforsignup.js'></script>
							<script src="js/register.js" type="text/javascript"></script> 
	                    					<form method="POST" action="" name="storesettings" id="storesettingsform" >
	                    						<div><input <?php if($statuspage == "Enable"){ echo "checked"; } ?> type="radio" name="function" value="Enable" />Enable</div>
	                    						<div><input <?php if($statuspage == "Disable with message"){ echo "checked"; } ?> type="radio" name="function" value="Disable with message" id="disbleshow" />Disable with message</div>
	                    						<div id="disablemessage" style="display: none;"><input  type="text" name="message"  value="<?php echo $me;?>" /></div>
	                    						<div><input <?php if($statuspage == "Disable without message"){ echo "checked"; } ?> type="radio" name="function" value="Disable without message" />Disable And Hide</div>
												
												<div class="input_merchant">Paypal Merchant Id : <input <?php if(!empty($count_merchant_id['merchant_id'])){ ?> value="<?php echo $count_merchant_id['merchant_id']; ?>" <?php } ?> type="email" name="paypal_merchant_id" placeholder="Paypal Merchant Id"/></div>
												
	                    						<div class="settingformsubmit"><input type="submit" class="button" name="savesetting" value="Save" /></div>
	                    					</form>
	                    				</div>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">

$(document).ready(function(){

	$('#storesettingsform input[type="radio"]').click(function(){
		if($(this).val() == "Disable with message")
		{
			$('#disablemessage').css('display','block');
		}
		else
		{
			$('#disablemessage').css('display','none');
		}
	});

	$('#shippingsettings input[type="radio"]').click(function(){

		if (this.id != 'fixed_price_radio') {
			$('#fixed_price').val('');
		}
		
		if($(this).prop('checked') === true)
		{
			$('#shippingsettings input[type="checkbox"]').prop('checked', false);		
		}
	});
	
	$('#shippingsettings input[type="checkbox"]').click(function(){
		if($(this).prop('checked') === true)
		{
			$('#shippingsettings input[type="radio"]').prop('checked', false);
			$('#fixed_price').val('');
		}
	});
	
	$('#fixed_price').keypress(function(event) {
	  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
	  }
	});	

});


function delrecoreds(id)
{ 
  	if(confirm('Are You sure You want to delete this record'))
  	{
		$.get( "deletecategory.php?id="+id, function( data ) {
			window.location='manage_category.php';
		});
	}
}

function cancelEdit(){
	window.location='manage_category.php'
}
</script>
<?php include('LandingPageFooter.php');?>
