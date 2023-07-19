<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

$titleofpage=" Manage Orders";	
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
?> 
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php include('store_right_bar.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<? 
  							if($userType=='club')
							{
						?>
							<h3 id="title">Manage Orders</h3>
						<? 
							} 
							if($userType=='user')
							{
						?>
								<h3 id="title">Ordered Item</h3>
						<? 	} 
							if($userType=='club')
							{
						?>
												<div class="manage_orderbtn">				
												<span style="float: right; margin-top:5px; ">
												<a class="button btn_add_venu" href="store.php">Store Menu</a>
												</span>
												</div><div style="clear:both;"></div>
		                                       <? 		}	 ?>
											<?php if($message['success'] != ""){ 

											echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
											}
											if($message['error'] != ""){ 

											echo '<div id="errormessage" class="message NoRecordsFound" >'.$message['error']."</div>";
											} 
						                     if(isset($_POST['statusupdate']))
						{
							                echo  $message = '<div  id="successmessage" class="message">Order status updated successfully.</div>';
							
						}

											?>
										
											
											<? 
											if($userType=='user'){
											 $sql="SELECT `posted_date`, `invoice`,COUNT(*) AS count, SUM(`product_amount`) AS amount FROM purchases where user_id='".$_SESSION['user_id']."' GROUP BY `invoice` order by id desc ";
											}  else if($userType=='club'){
											    $sql="SELECT store_order_status.status, purchases.posted_date,purchases.invoice,COUNT(*) AS count, SUM(product_amount) AS amount FROM purchases join store_order_status on  purchases.host_id=".$_SESSION['user_id']." and store_order_status.invoice=purchases.invoice and store_order_status.status in(0,1) GROUP BY purchases.invoice order by purchases.id desc ";	
											}
											//echo $sql;
											$data=mysql_query($sql);
											$count_num_rows=mysql_num_rows($data);
											if($count_num_rows > 9)
											{
											$class = " class='scroll_Div1 v2_manage_order'";
											}
											else
											{
											$class= "class='autoscroll '";
											}?>
											 <div <?php echo $class;?>>
											<table class='display loadmusic manage_orders whitespace'  style='' >
											<thead>
											<tr bgcolor="#ACD6FE">

						                      <th>Invoice</th>
											<th>Items</th>
											<th>Amount</th>
											<th>Date</th>
											<?if($userType=='club'){?>
											<th>Status</th>
											<? } ?>
											<th>Action </th>
						                   <!-- <th>Shipping Address</th>
											<th>subtotal($)</th>
											<th>Status</th>
											<th>Date </th>
											<th>Action </th>-->
											</tr>
											</thead>
											<tbody>
											<?if($count_num_rows){?>
												<?$i=0;
												  while($row=mysql_fetch_array($data)){?>
													<?if($i%2 == '0')
													{
													$class = " class='even' ";
													}
													else
													{
													$class = " class='odd' ";
													}
													?>
													<tr >
													<td><? echo $row['invoice'];?></td>
													<td>
														<? 
															$getProducts = mysql_query("SELECT * FROM `purchases` WHERE `invoice` = '$row[invoice]' ");
															while($fetchProducts = mysql_fetch_assoc($getProducts))
															{
																//echo $row['product_quantity'];
																$Count[] = $fetchProducts['product_quantity'];
																$Count1[] =$fetchProducts['product_quantity']*$fetchProducts['product_amount'];
															}
															echo array_sum($Count);
														?>
													</td>
													<td><? echo "$".array_sum($Count1);?></td>
												   <td><? echo date('M d, Y', strtotime($row['posted_date']));?></td>
												   
												   <td>
														<?php if($userType=='club'){

															$sql = "SELECT status,id from store_order_status where invoice = ".$row['invoice'];					  
															$datax = mysql_query($sql);
															$rowx = mysql_fetch_array($datax);
														?>
													
															<select onchange = "chnageorderstatus('<?php echo $rowx['id']; ?>','<?php echo $row['invoice'];?>')" id="order_status-<?php echo $rowx['id'];?>" name="order_status" class="order_status_sel">
																<option value="0" <?php if($rowx['status']=='0'){ echo " selected"; } ?>>Pending</option>
																<option value="1" <?php if($rowx['status']=='1'){ echo " selected"; } ?>>Processing</option>
																<option value="4" <?php if($rowx['status']=='4'){ echo " selected"; } ?>>Shipped</option>
																<option value="2" <?php if($rowx['status']=='2'){ echo " selected"; } ?>>Complete</option>
																<option value="3" <?php if($rowx['status']=='3'){ echo " selected"; } ?>>Cancel</option>
															</select>
															
														<?php } ?>
												   </td>
												   
													<td>
														<a href="order_detail.php?invoice_id=<? echo $row['invoice'] ?>" onclick="goclicky(this); return false;" target="_blank">View</a>
														<!--<a href="order_detail.php?id=<? echo $row['invoice'] ?>">view</a>-->
													</td>
													</tr>
												<?}?>
												
											<?}else{?>
												<tr><td colspan="6"><? echo "Sorry! No Item Purchased Yet. ";?></td></tr>
												<?}?>
											</tbody>
											</table>
											</div>
							<form style="display: none;" method="POST" class="hiddenform" action="" id="hiddenform">
							<input type="hidden" name="statusupdate" value="123" />
							<input type="submit" name="statusupdate" value="submit" class="" />
						   </form>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<script>
	jQuery(document).ready(function(){
	$("#successmessage").delay(5000).fadeOut();	
		
	});
	
function chnageorderstatus(id,invoice){
  		
		var selected_val = $('#order_status-'+id).val();
	
		$.ajax({
			url: "ajaxcall.php",
			type: "POST",
			data: { 'updatestatusid' :id , 'val' :selected_val,'invoice' :invoice, 'update_store_ordr' :true },
			success:function(response){
				
				alert(response);
				//window.location.assign('manage_order.php');
				//$('#hiddenform').submit();
				//$("#successmessage").show();
			
				
			}
		});
}

function goclicky(meh)
{
    var x = screen.width/2 - 700/2;
    var y = screen.height/2 - 450/2;
    window.open(meh.href, 'sharegplus','toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=yes,height=485,width=700,left='+x+',top='+y);
}
</script>


<?php include('Footer.php');?>