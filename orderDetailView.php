<?
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

$titleofpage="Order Details";
include('LoginHeader.php');
	
$first_name=$loggedin_user_data['first_name']; 
$last_name=$loggedin_user_data['last_name'];
$zipcode=$loggedin_user_data['zipcode'];
$state=$loggedin_user_data['state'];
$country=$loggedin_user_data['country'];
if($loggedin_user_data['DOB']==''){$dob="00/00/0000";} else $dob=$loggedin_user_data['DOB'];
$city=$loggedin_user_data['city'];
$email=$loggedin_user_data['email'];
$image_nm=$loggedin_user_data['image_nm'];
$phone=$loggedin_user_data['phone'];
/**********************************/

if(isset($_SESSION['success']))
{
	$success=$_SESSION['success'];
	unset($_SESSION['success']);
}

$check_pdt_type = mysql_query("SELECT product_type FROM purchases WHERE invoice = '".$_GET['invoice_id']."'");
$get_product_type = mysql_fetch_assoc($check_pdt_type);

if($get_product_type['product_type'] == 'product'){
	
	$sql = "select purchases.id as orderid,purchases.invoice,purchases.posted_date,store_order_status.status,store_order_status.tracking_number,store_order_status.id as statusid, purchases.product_quantity,purchases.product_amount, purchases.tax_name, purchases.tax_rate,purchases.payer_address,purchases.payer_city,purchases.payer_state,purchases.payer_zip,purchases.payer_country,purchases.payer_email, host_product.id as product_id ,host_product.product_name ,user.id as user_id ,user.first_name,user.last_name,user.profilename from purchases join host_product on purchases.invoice='".$_GET['invoice_id']."' and purchases.product_type='product' and host_product.id=purchases.product_id join user on purchases.user_id=user.id join store_order_status on purchases.invoice=store_order_status.invoice group by host_product.id order by purchases.id DESC ";
	
}

if($get_product_type['product_type'] == 'music'){
	
	$sql = "select purchases.id as orderid,purchases.invoice,purchases.posted_date,store_order_status.status,store_order_status.tracking_number,store_order_status.id as statusid, purchases.product_quantity,purchases.product_amount, purchases.tax_name, purchases.tax_rate,purchases.payer_address,purchases.payer_city,purchases.payer_state,purchases.payer_zip,purchases.payer_country,purchases.payer_email, music.id as product_id ,music.trackname ,user.id as user_id ,user.first_name,user.last_name,user.profilename from purchases join music on purchases.invoice='".$_GET['invoice_id']."' and purchases.product_type='music' and music.id = purchases.product_id join user on purchases.user_id=user.id join store_order_status on purchases.invoice=store_order_status.invoice group by music.id order by purchases.id DESC ";
	
}


$data=mysql_query($sql);

$NewArray=mysql_query($sql);

$dataship=mysql_query($sql);
$dataprsl=mysql_query($sql);
$newData = mysql_query($sql);
$fetchData = mysql_fetch_assoc($newData);
?>
<style type="text/css">
.invoices .row
{
	float: left;
	width: 100%;
}
.invoices .row .label {
	float: left;

}


.row .formw {
    	width: 65%;
}

.row > span {
	float: left;
	line-height: 19px;
	vertical-align: middle;
	width: 35%;
	text-align: left;
}
.row h2 {
	float: left;
	margin: 10px 0;
	width: 100%;
	font-size: 17px;
}
</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   include('friend-right-panel.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<div class="oreder-wrapper">
							<div class="steps">
							<?php 
								if($fetchData['status'] == "0")
								{
									echo  '<img src="images/order-step1.png"alt="Step1"> ';
								}
								elseif ($fetchData['status'] == "1")
								{
									echo  '<img src="images/order-step2.png"alt="Step2"> ';
								}
								elseif($fetchData['status'] == "4")
								{
									echo  '<img src="images/order-step3.png"alt="Step3"> ';
								}
								elseif($fetchData['status'] == "2")
								{
									echo  '<img src="images/order-step4.png"alt="Step4"> ';
								}
							?>
								
							</div>
							<div class="order_summary">
								<h1>Your Order Details</h1>
								<div class="order_detail_field">

								</div>
								<div class="order_detail_field">
									<table>
										<tr>
											<th>Item</th>
											<th>Quantity</th>
											<th>Total Amount</th>
											<!-- <th>Est. Delivery Date</th> -->
										</tr>
							<?php 
							//$sum = 0;
// $row1=mysql_fetch_assoc($NewArray);
							// echo "<pre>"; print_r($row1); exit;
									while($row=mysql_fetch_assoc($NewArray))
									{
										
										if($i%2 == '0')
										{
											$class = " class='even' ";
										}
										else
										{
											$class = " class='odd' ";
										}
										$sum=$sum+$row['product_amount'];
										?>
										<tr>
											<td><?php echo $row['product_name'];?></td>
											<td><?php echo $row['product_quantity'];?></td>
											<td> <?php echo "$".$row['product_amount']; ?></td>
											<!-- <td>12 June</td> -->
										</tr>
							<?php 		}		?>
										<tr>
											<td colspan="2">Sub Total</td>
											<td ><? echo "$".$sum;?></td>
										</tr>
									</table>
								</div>
								<div class="invoices">
									<div class="row">
										<span class="label">Order Invoice:</span>
										<span class="formw">
		                                            						<? echo $_GET['invoice_id'];?>
							
										</span>
									</div>
							<?php	$row=mysql_fetch_array($dataprsl);	?>
									<div class="row order_detail_head" style="color:#000; font-weight:bold;  background-image: none !important;">
										<h2>Personal Detail</h2>
									</div>
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
									<div class="row order_detail_head" style="color:#000; font-weight:bold;  background-image: none !important;">
										<h2 class="">Shipping  Detail</h2>
									</div>
									<div class="row">
										<span class="label">Shipping Type:</span>
										<span class="formw">
				                     						<?php if(empty($row['tax_name'])){ echo "Free"; }else{ echo $row['tax_name']; } ?>
										</span>
									</div>
									<div class="row">
										<span class="label">Shipping Price:</span>
										<span class="formw">
				                    						<?php if(empty($row['tax_rate'])){ echo "0.00"; }else{ echo $row['tax_rate']; } ?>
										</span>
									</div>					
									<div class="row">
										<span class="label">Address:</span>
										<span class="formw" >
		                        								<? 
		                        									echo $row['payer_address']."</br>";
												echo $row['payer_city']."</br>";
												echo $row['payer_state']."</br>";
												echo $row['payer_country']."</br>" ;
												echo $row['payer_zip'];
											?>
										</span>
									</div>
									<div class="row">
										<span class="label">Tracking Number:</span>
										<span class="formw" >
											<?php echo $row['tracking_number'];?>
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
							</div>
						</div>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>

<?php include('Footer.php') ?>

