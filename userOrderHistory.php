<?
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}
$titleofpage="Orders History";
include('NewHeadeHost.php');
	
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

?>
<style>
.tab_scroll.scroll_Div1 {
  overflow: inherit !important;
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
  						<h3 id="title" class="botmbordr">Order History</h3> 
						<div id="middle" style="" >
						<?php 
							$gettrackquery = @mysql_query("SELECT * FROM purchases WHERE user_id = '".$_SESSION['user_id']."' AND payment_status = 'complete' ");
							$counttracklist = @mysql_num_rows($gettrackquery);
							$SQL = mysql_query("SELECT `id`,`posted_date`, `invoice` FROM purchases where user_id='".$_SESSION['user_id']."' GROUP BY `invoice` order by id desc ");
							if($counttracklist > 9)
							{
								$class = " class='  '";
							} 
						?>
						 	<div <?php echo $class;?>>
						  		<div class="autoscroll">
									<table  class="display" id="example" style="margin-top:10px; background:#fff;" >
										<thead>
											<tr style="background-color:rgb(254, 205, 7); line-height:34px">
												<th width=" ">Invoice</th>
												<th width=" ">Items</th>
												<th width=" ">Amount</th>
												<th>Date</th>
												<th  width=" ">Action</th>
											</tr>
										</thead>
										<tbody>
									<?php 
										$i=0;								
										if($counttracklist > 0) 
										{
											while($row1 = mysql_fetch_array( $SQL))
											{
												if($row1['id'])
												{
									 ?>
													<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
														<td>
															<?php echo $row1['invoice'];?>
												   		</td>
														<td>
													<? 
														$getProducts = mysql_query("SELECT * FROM `purchases` WHERE `invoice` = '$row1[invoice]' ");
														while($fetchProducts = mysql_fetch_assoc($getProducts))
														{
															//echo $row['product_quantity'];
															$Count[] = $fetchProducts['product_quantity'];
															$Count1[] = $fetchProducts['product_amount'];
														}
															echo array_sum($Count);
													?>
												   		</td>
														<td>
															<?php echo "$".array_sum($Count1);	?>
												   		</td>
														<td>
															<?php echo $row1['posted_date'];?>	                	
														</td>
														<td>
															<a target="_blank" href="orderDetailView.php?orderId=<?php echo $row1['id']; ?>&invoice_id=<?php echo $row1['invoice']; ?>" >View Order Detail</a>
														</td>
											   		</tr>
									<?php
												}
												$i++;
											} 
										}
										else 
										{ 
									?>
											<tr><td colspan=5>No Record Found!</td></tr>
									<?php 	} 	?>
										</tbody>
									</table>
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
