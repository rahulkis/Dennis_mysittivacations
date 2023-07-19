<?php
session_start();

include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

if(!isset($_GET['invoice_id'])){
	$Obj->Redirect("index.php");
}
$titleofpage="Order Details";	
//include('headhost.php');
//include('header.php');
//include('headerhost.php');
?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<? //include('suggest_friend.php');?>
<script type='text/javascript' src='js/autocompletemultiple/jquery.js'></script>
<script type='text/javascript' src='js/autocompletemultiple/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="js/autocompletemultiple/jquery.autocomplete.css" />


<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="../css/new_portal/style.css" />

<?php


  /******************/

?> 
<style>.home_content_top::before {
display:none;
}

.order_container {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: 1px solid #fecd07;
  bottom: 0;
  box-sizing: border-box;
  display: table;
  margin: auto;
  max-width: 600px;
  padding: 0;
  width: 100%;
}
</style>

<?php 
if(isset($_POST['savetrack']))
{
	$tracking_number = $_POST['tracking_number'];
	mysql_query("UPDATE `store_order_status` SET `tracking_number` = '$tracking_number'  WHERE `invoice` = '$_GET[invoice_id]' ");
}

?>


<div class="order_wrapper">
	<div class="order_container">
		<div class="">
			<div class="home_content_top">
					
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
					} 
                     if(isset($_POST['statusupdate']))
					{
						$message = '<div  id="successmessage" class="message">Order status updated successfully.</div>';
						
					}
					?>
					<div style="float:left; width:100%" class="manage_orderbtn">				
						<span style="float: right; margin-top:0px; ">
					<!--<a class="button btn_add_venu"  style="margin-right:0px;" href="manage_order.php">Manage Order</a>-->
					</span>
                    <div class="ordertitle">
					<h2>Orders Details</h2>
					<button style="margin-top:0px; " onclick="printContent('print_div1')">Print Content</button>
                    </div>
                    </div>
					<div id="print_div1" class="tab_scroll"> 
					<? 
					  $sql="select purchases.id as orderid,purchases.invoice,purchases.posted_date,store_order_status.status,store_order_status.tracking_number,store_order_status.id as statusid, purchases.product_quantity,purchases.product_amount, purchases.tax_name, purchases.tax_rate,purchases.payer_address,purchases.payer_city,purchases.payer_state,purchases.payer_zip,purchases.payer_country,purchases.payer_email, host_product.id as product_id ,host_product.product_name ,user.id as user_id ,user.first_name,user.last_name,user.profilename from purchases join host_product on purchases.invoice='".$_GET['invoice_id']."' and purchases.product_type='product' and host_product.id=purchases.product_id join user on purchases.user_id=user.id join store_order_status on purchases.invoice=store_order_status.invoice group by host_product.id order by purchases.id DESC ";
					$data=mysql_query($sql);
					$dataship=mysql_query($sql);
					$dataprsl=mysql_query($sql);
					
					$count_num_rows=mysql_num_rows($data);
					if($count_num_rows){
					?>
					<? if($userType=='club'){?>
					<div class="row" style="color:#000; font-weight:bold;"></div>
					<? } ?>
					<?
					if($count_num_rows > 9)
					{
					$class = " class='scroll_Div1 '";
					}
					else
					{
					$class= "class='scroll_Div1no tab_scroll details_orders'";
					}?>
					 <div <?php echo $class;?>>
					<table class='display loadmusic order_details'  style='' >
					<thead>
					<tr bgcolor="#ACD6FE">

                    <th>Product Name</th>
					<th>Qty</th>
					<th>Amount($)</th>
					<th>Total Amount($)</th>
					</tr>
					</thead>
					<tbody>
					<?
					$i=0;
					$sum=0;
					while($row=mysql_fetch_array($data)){
						$status=$row['status'];
						?>
						<?if($i%2 == '0')
							{
							$class = " class='even' ";
							}
							else
							{
							$class = " class='odd' ";
							}
							$sum=$sum+$row['product_amount']*$row['product_quantity'];
							?>
						<td><? echo $row['product_name'];?></td>
						<td><? echo $row['product_quantity'];?></td>
						<td><? echo $row['product_amount'];?></td>
						<td><? echo $row['product_amount']*$row['product_quantity'];?></td>
						</tr>
					<? }
					?>
					<tr><td colspan="3">Sub Total</td><td ><? echo $sum;?></td></tr>
					</tbody>
					</table>
                                         
					</div>
                    <div class="invoices">
					<div class="row">
					<span class="label">Order Invoice:</span>
					<span class="formw">
                                            <? echo $_GET['invoice_id'];?>
					
					</span>
					</div>
					<div class="row">
					<span class="label">Order Status:</span>
					<span class="formw">
                      <? if($status=='0'){
                             echo "Pending";
                         }else if($status=='1'){
							 echo "Processing";
						 } else if($status=='2'){
							 echo "Complete";
					     }else if($status=='3'){
							 echo "Cancel";
						   }else if($status=='4'){
							 echo "Shipped";
						 }        
                             
                             
                             ?>
					
					</span>
					</div>
					<? if($userType=='club'){
						$row=mysql_fetch_array($dataprsl);?>
					<div class="row" style="color:#000; font-weight:bold;">Personal Detail</div>
					<div class="row">
					<span class="label">Ordered By:</span>
					<span class="formw">
                     <? echo $row['first_name']." ".$row['last_name'];?>
					
					</span>
					</div>
					<div class="row">
					<span class="label">Email Id:</span>
					<span class="formw">
                       <? echo $row['payer_email'];?>					
					</span>
					</div>
					
					<? $row=mysql_fetch_array($dataship);?>
					<!--<div class="row" style="color:#000; font-weight:bold;">Shipping  Detail</div>-->
					
					<div class="row">
						<span class="label">Shipping  Detail:</span>
						<span class="formw">
							<?php
							if(empty($row['tax_name']) && empty($row['tax_rate'])){
								
								echo "Shipping Type : Free</br>";
								echo "Shipping Price : 0.00</br>";								
								
							}else{
								
								echo "Shipping Type : ".$row['tax_name']."</br>";
								echo "Shipping Price : ".$row['tax_rate']."</br>";								
								
							}
							?>
						</span>
					</div>					
					
					<div class="row">
					<span class="label">Address:</span>
					<span class="formw" >
                        <? echo $row['payer_address']."</br>";
							echo $row['payer_city']."</br>";
							echo $row['payer_state']."</br>";
							echo $row['payer_country']."</br>" ;
							echo $row['payer_zip']?>
					
					</span>
					</div>
					<? }}?>
					
					<div class="row">
						<span class="label">Tracking Number:</span>
						<span class="formw" >
							<form method="POST" action="" style="margin:0;">
								<input type="text" name="tracking_number" value="<?php if(!empty($row['tracking_number'])){ echo $row['tracking_number']; }?>" />
								<input type="submit" name="savetrack" value="Update" />
							</form>
						</span>
					</div>
				<?php 	
					if(!empty($row['tracking_number']))
					{
						$tracking_number = $row['tracking_number'];
						include('fedex/TrackWebServiceClient.php');
						?>
						<div class="row">
							<span class="label">Tracking Details:</span>
							<span class="formw" >
							<!-- <h2>Tracking Status Detail: </h2> -->
								<p>
									Description : <?php echo $RESULT['StatusDetail']->Description; ?><br />
									Location: <?php echo $RESULT['StatusDetail']->Location->StreetLines." ".$RESULT['StatusDetail']->Location->City.", ".$RESULT['StatusDetail']->Location->CountryName; ?>	<br />
									Service Message : <?php echo $RESULT['ServiceCommitMessage']; ?> <br />
									For more details <br />
									<a target="blank" href="http://www.fedex.com/Tracking?action=track&tracknumbers=<?php echo $row['tracking_number'];?>">Click Here</a>
								</p>
							</span>
						</div>

 				<?php 	}	?>

				 </div>
			<a style="float: left; margin-top: 20px;" href="javascript:void(0);"><input class="button" name="cancel" onclick="javacript:self.close();" type="button" value="Close"/></a>
		 </div>
 </div>
<?
//include('club-right-panel.php') ;
?>
   
  </div>
</div>
</div>
<?
//include('footer.php');
?>
<script>

function chnageorderstatus(id){ 
  		
		var selected_val = $('#order_status-'+id).val();
	
		$.ajax({
			url: "manage_order.php",
			type: "POST",
			data: { updatestatusid : id , val: selected_val},
			success:function(data){
				
				
				
				//window.location.assign('manage_order.php');
				$('#hiddenform').submit();
			}
		});
		}

</script>

<script> function printContent(el){ 
		 var restorepage = document.body.innerHTML; 
		 var printcontent = document.getElementById(el).innerHTML; 
		 document.body.innerHTML = printcontent; window.print(); 
		 document.body.innerHTML = restorepage; 
		 } 
</script>