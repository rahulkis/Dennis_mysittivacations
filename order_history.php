<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

$titleofpage=" Order History";	
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

if(isset($_POST['updatestatusid']))
{
	$sql="UPDATE `store_order_status` SET `status` = '".$_POST['val']."' WHERE `id` = ".$_POST['updatestatusid'];
   	mysql_query($sql);
	$invoice=$_POST['invoice'];
	$sql="select payer_email from purchases where invoice=".$invoice;
	$data=mysql_query($sql);	
	if(mysql_num_rows($data))
	{
		$row=mysql_fetch_array($data);
		$email=$data['payer_email'];
		if($_POST['val']==1)
		{
			$msgx=" your order  has statred processing will be dispatch soon you will get a mail when it dispatch";
		}
		if($_POST['val']==2)
		{
			$msgx=" your order is  complete wil be diliver to you soon ";
		}
		if($_POST['val']==3)
		{
			$msgx=" your order has been cancled due to some reason, sorry for inconvenience";
		}
		include('order_statuschnage_email.php');
 	}
	die;
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
						<? if($userType=='club'){?>
					<h3 id="title">Order History</h3>
					<? } ?>
					<? if($userType=='user'){?>
					<h3 id="title">Ordered Item</h3>
					<? } ?>
                                        <? if($userType=='club'){?>
                                        
                                       <? } ?>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
					} 
					                  if(isset($_POST['statusupdate']))
					{
						  echo  $message = '<div  id="successmessage" class="message">Order status updated successfully.</div>';
						
					}
					?>
                    
				                <div class="order_item_status" >	
				                
				                <div class="sort_order_his new_mnth">
						  <select class="sort_order_sel" id="sort_order_sel">
						   <option value="" <? if(!$_GET['sort']){ echo "selected='selected'";}?> >All</option>
					     <option value="3" <? if($_GET['sort']=='cancel'){ echo "selected='selected'";}?>>Cancel</option>
					     <option value="2" <? if($_GET['sort']=='complete'){ echo "selected='selected'";}?>>Complete</option>
					  </select>
					</div>
                    			
						<span  class="singlebtn">
							<a class="button btn_add_venu" href="store.php">Store Menu</a>
						</span>
						</div>
	                        

						
						<? 
						if(isset($_GET['sort'])){
							if($_GET['sort']=='complete'){
							  $sql="SELECT store_order_status.status, purchases.posted_date,purchases.invoice,COUNT(*) AS count, SUM(product_amount) AS amount FROM purchases join store_order_status on  purchases.host_id=".$_SESSION['user_id']." and store_order_status.invoice=purchases.invoice and store_order_status.status in(2) GROUP BY purchases.invoice order by purchases.id desc ";	
						  }else{
							   $sql="SELECT store_order_status.status, purchases.posted_date,purchases.invoice,COUNT(*) AS count, SUM(product_amount) AS amount FROM purchases join store_order_status on  purchases.host_id=".$_SESSION['user_id']." and store_order_status.invoice=purchases.invoice and store_order_status.status in(3) GROUP BY purchases.invoice order by purchases.id desc ";	
						  }
						}else{
						   $sql="SELECT store_order_status.status, purchases.posted_date,purchases.invoice,COUNT(*) AS count, SUM(product_amount) AS amount FROM purchases join store_order_status on  purchases.host_id=".$_SESSION['user_id']." and store_order_status.invoice=purchases.invoice and store_order_status.status in(2,3) GROUP BY purchases.invoice order by purchases.id desc ";	
						}
						$data=mysql_query($sql);
						$count_num_rows=mysql_num_rows($data);
						if($count_num_rows > 9)
						{
						$class = " class='scroll_Div1 '";
						}
						else
						{
						$class= "class='scroll_Div1 '";
						}?>
						 <div <?php echo $class;?>>
						<table class='display loadmusic v2_order_history whitespace'  style='' >
						<thead>
						<tr bgcolor="#ACD6FE">

	                      <th>Invoice</th>
						<th>Items</th>
						<th>Amount</th>
						<th>Date</th>					
						<th width="150px">Status</th>					
						<th>Action </th>
	                   
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
								<td><? echo $row['count'];?></td>
								<td><? echo $row['amount'];?></td>
							   <td><? echo date('M d, Y', strtotime($row['posted_date']));?></td>
							  
									<td>
								<? 
								 $sql="SELECT status,id from store_order_status where invoice=".$row['invoice'];					  
						          $datax=mysql_query($sql);
						          $rowx=mysql_fetch_array($datax)
								?>
								<? if($rowx['status']=='2'){?>
								   <? echo "Complete";?>
								<? }else{ ?>
								<select style="width:70%;" id="order_status-<?echo $rowx['id'];?>" name="order_status" class="order_status_sel">								
									<option value="1" <? if($rowx['status']=='1'){echo " selected";}?> >Processing</option>
									<option value="2" <? if($rowx['status']=='2'){echo " selected";}?> >Complete</option>
									<option value="3" <? if($rowx['status']=='3'){echo " selected";}?> >Cancel</option>
								</select>
                                <br />
								<a onclick="chnageorderstatus('<? echo $rowx['id']; ?>','<? echo $row['invoice'];?>')">update order status</a>
								<? } ?>							
								
								</td>
							
								<td>
									<!-- <a href="order_detail.php?id=<? echo $row['invoice'] ?>">view</a> -->
									<a href="order_detail.php?invoice_id=<? echo $row['invoice'] ?>" onclick="goclicky(this); return false;" target="_blank">View</a>
								</td>
								
								</tr>
							<?}?>
							
						<?}else{?>
							<tr><td colspan="6"><? echo "Sorry! No data  Yet. ";?></td></tr>
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
			url: "manage_order.php",
			type: "POST",
			data: { updatestatusid : id , val: selected_val,invoice:invoice},
			success:function(data){				
				//window.location.assign('manage_order.php');
				$('#hiddenform').submit();
			}
		});
		}
$(document).ready(function(){
	$("#sort_order_sel").on('change',function(){
		val=$(this).val();
		if(val){
		if(val==3){
			var url='order_history.php?sort=cancel';
		}else{
			var url='order_history.php?sort=complete';
		}
	}else{
		var url='order_history.php';
	}
		
		window.location.assign(url);
		
    });
	
	});
function goclicky(meh)
{
    var x = screen.width/2 - 700/2;
    var y = screen.height/2 - 450/2;
    window.open(meh.href, 'sharegplus','toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=yes,height=485,width=700,left='+x+',top='+y);
}
</script>
<?php include('Footer.php');?>