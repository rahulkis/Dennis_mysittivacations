<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Host Cart";

$fedex_update = md5('true');

if(!isset($_GET['fedex-update']) && $_GET['fedex-update'] != $fedex_update){

	unset($_SESSION['annual_price_with_shipping']);
	unset($_SESSION['tax_rate_name']);
	unset($_SESSION['shipping_charges_add']);
	unset($_SESSION['new_amt_mysitti']);
	unset($_SESSION['new_amt_host']);	
	//unset($_SESSION['total_prodcut_price']);
	
}

if(isset($_POST['set_shipping_price'])){

	unset($_SESSION['annual_price_with_shipping']);
	unset($_SESSION['tax_rate_name']);
	unset($_SESSION['shipping_charges_add']);
	unset($_SESSION['new_amt_mysitti']);
	unset($_SESSION['new_amt_host']);
	
	$_SESSION['annual_price_with_shipping'] = $_SESSION['total_prodcut_price'] + $_POST['set_shipping_price'];
	$_SESSION['tax_rate_name'] = $_POST['tax_rate_name'];
	$_SESSION['shipping_charges_add'] = $_POST['set_shipping_price'];
	
	$percentage = 18;
	$totalamt = $_SESSION['total_prodcut_price'];
	
	$new_amt_mysitti = ($percentage / 100) * $totalamt;
	
	$mysitti_fees_cal =  number_format($new_amt_mysitti,2,".","");

	$percentage_host = 82;
	$totalamt_host = $_SESSION['total_prodcut_price'];
	
	$new_amt_host = ($percentage_host / 100) * $totalamt_host;
	$final_amount_host = $new_amt_host + $_POST['set_shipping_price'];
	
	$mysitti_host_fees_cal =  number_format($final_amount_host,2,".","");
	
	$_SESSION['new_amt_mysitti'] = $mysitti_fees_cal;
	$_SESSION['new_amt_host'] = $mysitti_host_fees_cal;

	echo "set";
	die;
}

if(isset($_POST['session_update_on_quantity_change'])){
	$key=$_POST['session_update_on_quantity_change'];
	$qty=$_POST['qty'];
	
	$_SESSION['cart_value'][$key]['product_qty']=$qty;
	$_SESSION['total_prodcut_price']=$_POST['subtotalcartprice'];
	print_r($_SESSION['cart_value']);
	die;
}
		
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	//$Obj->Redirect("login.php");
}
if($userType=='user'){
	//$Obj->Redirect("index.php");
}

$host_id = $_GET['host_id'];
$userID=$_SESSION['user_id'];

$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}
if(isset($_REQUEST['reset']) && $_REQUEST['reset']=='a4dnv34sk'){
unset($_SESSION['cart_value']);
unset($_SESSION['cartcd_value']);
header('Location: cart.php');
exit();
}

if(isset($_POST['host_id'])){
	
	
	$i=0;
	$chk=0;
	if($_SESSION['cart_value']){
		//echo "<pre>";print_r($_POST);print_r($_SESSION['cart_value']);die;
	foreach($_SESSION['cart_value'] as $cart_value){
		if($_POST['product_type']=='2'  && $cart_value['product_type']==$_POST['product_type'] && $cart_value['choose_sizex']==$_POST['choose_sizex']&& $cart_value['choose_colorx']==$_POST['choose_colorx']){
			$_SESSION['cart_value'][$i]['product_qty']=$_SESSION['cart_value'][$i]['product_qty']+$_POST['product_qty'];
			$chk++;
		}else if($_POST['product_type']=='2'  && $cart_value['product_type']==$_POST['product_type']){
			$_SESSION['cart_value'][] = $_POST;
             $_SESSION['total_prodcut_price']=$_SESSION['total_prodcut_price']+$_POST['price_cart'];$chk++;
		}else
		if($cart_value['product_id']==$_POST['product_id'] && $cart_value['product_type']==$_POST['product_type'] && $cart_value['host_id']==$_POST['host_id']){
			$_SESSION['cart_value'][$i]['product_qty']=$_SESSION['cart_value'][$i]['product_qty']+$_POST['product_qty'];
			$chk++;
		}
		$i++;
		
	}
}
if($chk==0){
	
$_SESSION['cart_value'][] = $_POST;
$_SESSION['total_prodcut_price']=$_SESSION['total_prodcut_price']+$_POST['price_cart'];

}

}

  $arr1 = array();
  $arr2 = array();

  foreach ($_SESSION['cart_value'] as $key => $val) {
   
	$name = $val['host_id'];
   
	//$arr1[] = array( $name => $val );
	$arr1[] = array( $name => $val );
	$arr2[] = $key['host_id'];
  }
	
	if(isset($_GET['cart-empty']) && $_GET['cart-empty'] == 'clear'){
		
		$removeKeys = array();
		foreach($arr1 as $key=>$single_cart_value){
		
			foreach($single_cart_value as $cart_value){
				
					$arr_key = array_keys($single_cart_value);
					$array_key = $arr_key[0];
					
					if($array_key == $_GET['host_id']){
						
							unset($_SESSION['cart_value'][$key]);
							array_values($_SESSION['cart_value']);
							header('Location: cart.php');

					}
			}
		}
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
  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}

include('LoginHeader.php');
?> 
<style type="text/css">

.v2_banner_top .v2_header_wrapper {
    overflow: visible;
    padding-top: 0 !important;
}
table.carttable th
{
	width: 133px;
}
#example tr:nth-child(2n+1) td {
  background: #fff none repeat scroll 0 0;
}
#example tr td:nth-child(2n) {
  background: #fff none repeat scroll 0 0;
  /*padding-left: 5px;*/
}
.loadmusic tr td:nth-last-child(1) {
  text-align: left !important;
}
.cart_inner {
  box-sizing: border-box;
  padding: 0 20px;
}
.shipping_add input[type="text"], .shipping_add textarea {
  width: 98% !important;
}

.shipping_add select{
  width: 100% !important;
}
.shipping_add td label {font-weight:bold;}
.shipping_add td {padding-right:0px;}
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
.button.cartbtn1 {
  background: #00baff none repeat scroll 0 0;
  border: 1px solid #00baff;
  color: #fff !important;
}
.goto_back a {
	background: #fff none repeat scroll 0 0;
  border: 1px solid #000;
  color: #000 !important;
}
#set_alternate_shipping table td input[type="text"], .shipping_add select {
  font-size: 12px;
  font-weight: normal;
}

.shipping_add select {
  font-size: 12px;
  font-weight: normal;
  color: #000 !important;
}

 .shipping_add ::-webkit-input-placeholder {
   color: #000;
   opacity:1;
}

 .shipping_add  :-moz-placeholder {  
   color: #000; opacity:1; 
}

 .shipping_add  ::-moz-placeholder {  
   color: #000;  opacity:1;
}

 .shipping_add  :-ms-input-placeholder {  
   color: #000;  opacity:1;
} 
.v2_banner_top .v2_header_wrapper{
	    overflow: visible;
}

.loadmusic.checkout label {
    color: #333333;
    font-size: 14px !important;
    font-weight: normal !important;
}
</style>

<div class="v2_container">
		<div class="v2_recent_contests gutter20"  style="margin-bottom: 10px;">
        <div class="v2_inner_main cart_inner">
		 
			
			<div class="home_content_top" id="cartid">
					<h3>Cart</h3>
					<div class="cart-btn-pack" style="margin-bottom: 10px;">
						<a class="button clearshoping" href="home_user.php">Continue Shopping</a>
						<a  class="button clearshoping" href="host-cart.php?cart-empty=clear&host_id=<?php echo $_GET['host_id']; ?>"><span>Clear all Items</span></a>
					</div>
    
						 
						<div class="catscroll">
								   <table class='display carttable' id='example' style=' ' >
							<thead>
							<tr bgcolor='#ACD6FE' style="">
							<th>&nbsp;</th>
								<th>Item Name</th>
								<!--<th>Quantity</th>-->
								<th>Item Price($)</th>
							   <th>Price($)</th>
							</tr>
							</thead>
					   
						
						  <?php
							 if($_SESSION['cart_value'])
							 {
								   $i=0;
								  $a = 0;
								  $counter=0;
								  $subtotalcartprice=0;
								foreach($arr1 as $key=>$single_cart_value){

									foreach($single_cart_value as $cart_value){

									$arr_key = array_keys($single_cart_value);
									$array_key = $arr_key[0];
									
									if($array_key == $_GET['host_id']){				

									//echo "<pre>";
									//print_r($single_cart_value);
									//echo "</pre>";	
									
									// echo "<pre>"; print_r($_SESSION['cart_value']); exit;
									 
									if( $cart_value['product_type']==0){
										if($cart_value['music_type'] == "music")
										{
											$table = "music";
										}
										else
										{
											$table = "dj_video";
										}
									$sql="SELECT trackname as prodctname , price as prodctprice FROM ".$table." where id ='".$cart_value['product_id']."'";
									}
									if( $cart_value['product_type']==1){
										 $sql="SELECT cd_name as prodctname , cd_price  as prodctprice FROM cds where id ='".$cart_value['product_id']."'";
									}
									if( $cart_value['product_type']==2){
										 
										 $sql="SELECT product_name as prodctname , product_price  as prodctprice FROM host_product where id ='".$cart_value['product_id']."'";
									}
									//echo $sql;
									  $cartquery = mysql_query($sql);
									  $num_rows=mysql_num_rows($cartquery);
									  if($num_rows){

												while($cartfetcharray = mysql_fetch_array($cartquery))
												{
														if($a%2 == '0')
														{
														$class = " class='even' ";
														}
														else
														{
														$class = " class='odd' ";
														}?>
															<tr>
																
																	<td class="" id="<?php echo $counter;?>">
																		<a href="cart.php?delete_music=<?php echo $key;?>" class="delete remove-cart">Remove</a>
																	</td>
																	<td class="" id="<?php echo $counter;?>">
																		<?php echo $cartfetcharray['prodctname']; ?>
																		<? if($cart_value['product_type']==2){?>
																			 <? $sql= "SELECT product_size_attribute.name as sizename ,product_color_attribute.name as colorname FROM `product_size_attribute` join product_color_attribute on product_size_attribute.id=".$cart_value['choose_sizex']." and product_color_attribute.id=".$cart_value['choose_colorx'];
																			 
																			  $getsizename = mysql_query($sql);
																			  $getsizename=mysql_fetch_array($getsizename);
																			  echo "</br>";
																			  echo "(".$getsizename['sizename'].")";
																			  echo "</br>";
																			   echo "(".$getsizename['colorname'].")";
																			  ?>
																		<? }?>
																	</td>
					<!--												<td class="">-->
					<!--													<input type="hidden" id="session_cart_index<?php echo $cart_value['product_id'];?>" value="<? echo $key?>">-->
					<!--													<a class="add" id="<?php echo $counter;?>" title="Track">+</a>-->
					<!--                                                    -->
					<!--													-->
					<!--<input type="text" name="quantity" id="<?php echo $cart_value['product_id'];?>" value="<?php echo $cart_value['product_qty'];?>" readonly="readonly" class="quantity"/>-->
					<!--													-->
					<!--                                                    <a class="reduce" id="<?php echo $counter;?>" title="Track">-</a>-->
					<!--												</td>-->
																	<td id="<?php echo "pricecart-".$cart_value['product_id'];?>">
																		
																			<input type="hidden" value="<? echo  $cartfetcharray['prodctprice'];?>" id="<?php echo "pricecart-item".$cart_value['product_id']; ?>">
																			<?php
																				if(preg_match('/./',$cartfetcharray['prodctprice'])) {
																				  echo "$".$cartfetcharray['prodctprice'];
																				}
																				else{
																				  echo "$".$cartfetcharray['prodctprice'].".00";
																				}
																			?>
																	</td>
																	<td>
																		<?php $totalcartprice= $cartfetcharray['prodctprice']*$cart_value['product_qty']; ?>
																		<div id="<?php echo "total-pricecart-item".$cart_value['product_id']; ?>">
																
																			<?php
																			$subtotalcartprice = $subtotalcartprice+$totalcartprice;
																			
																				if(preg_match('/./',$subtotalcartprice)) {
																				  echo "$".$subtotalcartprice;
																				}
																				else{
																				  echo "$".$subtotalcartprice.".00";
																				}																			
																			?>
																		</div>
																	</td>
																
															</tr>
							
																<?php 
												 }
											}
											$a++;$counter++;$i++;
									}
								}
							}
								
									/*************************** FEDEX RATE CALCULATE ************************************/
							?>

							<script type="text/javascript">
								function add_tax_rate(tax_value, tax_rate_name){
									
									$.blockUI({ css: {
										border: 'none', 
										padding: '15px', 
										backgroundColor: '#000', 
										'-webkit-border-radius': '10px', 
										'-moz-border-radius': '10px', 
										opacity: .5, 
										color: '#fff' 
									} });
									
									//setTimeout(function() {
									//	$.unblockUI({ 
									//		onUnblock: function(){
												
												
												$.post('host-cart.php', {'set_shipping_price': tax_value, 'tax_rate_name': tax_rate_name}, function(response){
													$.unblockUI();
													if (response == 'set') {
														window.location.href = 'host-cart.php?host_id=<?php echo $_GET['host_id']; ?>&fedex-update=b326b5062b2f0e69046810717534cb09';
													}
												});
												
												
												
									//			} 
									//	}); 
									//}, 2000);			
									

								}	
							</script>
							
							<?php
							$check_host_shipping = mysql_query("SELECT fixed_shipping_price, shipping_type FROM clubs WHERE id = '".$_GET['host_id']."'");
							$count_check_host_shipping = mysql_num_rows($check_host_shipping);
							
							if($count_check_host_shipping < 1){
								
								echo '<div class="shipping-method">';
								echo '<h1>Shipping Method</h1>';			
							
								include("fedex/fedex.php");
							
								/*************************** FEDEX RATE CALCULATE ************************************/
								
								include("UPS/SoapRateClient.php");
								
								/*************************** UPS RATE CALCULATE ************************************/
								
								echo '</div>';	echo '</div>';
								
							}else{
								
								echo '<div class="shipping-method">';
								echo '<h1>Shipping Method</h1>';
								
								$get_host_shipping = mysql_fetch_assoc($check_host_shipping);
								$host_shipping = $get_host_shipping['shipping_type'];
								$fixed_host_shipping = $get_host_shipping['fixed_shipping_price'];
								
								$shipping_explode = explode(',' , $host_shipping);
								
								array_filter($shipping_explode);
								
									if(in_array("Free", $shipping_explode)){
										
										echo "<h1>Free Shipping Available</h1>";					
										
									}
									
									if(in_array("Fixed Price", $shipping_explode)){ ?>
										
										<span><input <?php if($_SESSION['tax_rate_name'] === 'Fixed Price'){ echo "checked"; } ?> onclick="add_tax_rate('<?php echo number_format($fixed_host_shipping,2,".",","); ?>', '<?php echo 'Fixed Price'; ?>')" type="radio" class="shipping_rate" name="shipping_rate"> $ <?php echo number_format($fixed_host_shipping,2,".",","); ?> <?php echo 'Fixed Price'; ?><br /></span>				
										
									<?php }				
									
									if(in_array("Fedex", $shipping_explode)){
										
										include("fedex/fedex.php");
									
										/*************************** FEDEX RATE CALCULATE ************************************/					
										
									}
									
									if(in_array("UPS", $shipping_explode)){
										
										include("UPS/SoapRateClient.php");
										
										/*************************** UPS RATE CALCULATE ************************************/			
										
									}
									
								echo '</div">';
							}

							echo "<tr><td colspan='3' align='right' style='text-align:right;'>Sub Total: </td>";
							echo "<input type='hidden' value='".$subtotalcartprice."' id='subtotalcartprice'></input>";
							echo "<td class='subtotalcartprice'>";

								//if (is_float($subtotalcartprice)) {
								//	
								//	echo $sub_cart_p = round($subtotalcartprice,2);
								//	
								//} else {
								//	
								//	echo $sub_cart_p = round($subtotalcartprice,2).".00";
								//	
								//}
								
								$sub_cart_p = $subtotalcartprice;
								
								if(preg_match('/./',$sub_cart_p)) {
								  echo "$".$sub_cart_p;
								}
								else{
								  echo "$".$sub_cart_p.".00";
								}								
							
							echo "</td></tr>";
							
							$_SESSION['total_prodcut_price'] = $subtotalcartprice;
							
							if($_SESSION['annual_price_with_shipping'] != ''){
							
								echo "<tr><td colspan='3' align='right'>Sub Total + Shipping Charges</td>";
								echo "<td>";		
								echo  $_SESSION['annual_price_with_shipping'];
								echo "</td></tr>";
							}
							?>		
							<tr>
								<td colspan="4" align="right">
									<form id="user_order_checkout" name="user_order_checkout" onsubmit="return validateForm()" action="checkout.php?host_id=<?php echo $_GET['host_id']; ?>" method="post">
									<!---->
									<!--<form id="user_order_checkout" name="user_order_checkout" action="checkout.php?host_id=<?php echo $_GET['host_id']; ?>" method="POST">-->
					<div class="shipping_add_box">
											<span class="shiptoaddress"><input onclick="set_virtual_shipping_address();" type="checkbox" id="add_other_shipping_address"> Ship to this address</span>
										<div id="set_alternate_shipping" style="display: none;">
											
									 
												<table class="shipping_add">
													  <tbody><tr>
														<td><b><font color="red"><em>* </em></font></b><label>First Name</label></td>
														<td><input type="text" placeholder="First Name" name="shipping_fname"></td>
													</tr>
													<tr>
														<td><label style="margin-left: 9px;">Last Name</label></td>
														<td><b><font color="red"><em> </em></font></b><input type="text" placeholder="Last Name" name="shipping_lname"></td>
													</tr>
													<tr>
														<td><b><font color="red"><em>* </em></font></b><label>Address</label></td>
														<td>
															<textarea placeholder="Enter your Address" name="shipping_address" id="payer_address"></textarea>
														</td>
													</tr>
													<tr>
														<td><b><font color="red"><em>* </em></font></b><label>Country</label></td>
														<td>
															
															<?php 
															$countrysql="select country_id,name from country where country_id IN ('223','38') ";
															$country_list = mysql_query($countrysql);
															?>
															
															<select name="shipping_country" id="country" onChange="showStateuser(this.value);">
															  <option value = "">--- Country ---</option>
															  <?php
															  while($row_c = mysql_fetch_array($country_list))
															  {
															  ?>
															  <option value ="<?php echo $row_c["country_id"]; ?>"><?php echo $row_c["name"]; ?></option>
														<?php } ?>
															</select>										
															
															
														</td>
													</tr>
													<tr>
														<td><b><font color="red"><em>* </em></font></b><label>State</label></td>
														<td>
															<select name = "shipping_state" id = "userstate" onChange = "getcity_user(this.value);">
															  <option   value= "">--- State ---</option>
															</select>
														</td>
													</tr>
													<tr>
														<td><b><font color="red"><em>* </em></font></b><label>City</label></td>
														<td>
														
															<select name = "shipping_city" id = "usercity" >
															  <option value = "">--- City ---</option>
															</select>
														</td>
													</tr>
													<tr>
														<td><b><font color="red"><em>* </em></font></b><label>Zip</label></td>
														<td>
															<input type="text" placeholder="Zip" name="shipping_zip">
															<input type="hidden" value="false" name="alternate_shipping" id="alternate_shipping">
														</td>
                                                      
													</tr>	  
                                                    						
													</tbody>
												</table>
             </div>                                 
									 
										

									
										
									  <table class="controls_cart" style="float: left;">
                                                <tbody>
                                                
											      <tr>
                                                    
                                                        <td>
                                                        	<input type="hidden" value="<?php echo $subtotalcartprice; ?>" id="hidden_subtotal" name="subtotal" style="float:left"/>
										<input type="submit" class="button cartbtn1 " name="checkout" value="Checkout"/>	<div class="goto_back">
										
										</div>
                                                        </td>
                                                        <td>
                                                        <a style="float: left;" href="cart.php" class="button cartbtn backtocart">Back</a>
                                                        </td>
                                                        </tr>							
													</tbody>
												</table>
										</div>
									</form>
								</td>
							</tr>
					<?
					}

						if(!$_SESSION['cart_value']){
							echo '<div style="width:100%;float:left;color:white;">Your cart is empty</div>';
						} ?>

						 
					</table>
     </div>
					 

					<script type="text/javascript">
					function showStateuser(x)
					{
									$.blockUI({ css: {
										border: 'none',
										padding: '15px',
										backgroundColor: '#fecd07',
										'-webkit-border-radius': '10px',
										'-moz-border-radius': '10px',
										opacity: .8,
										color: '#000'
									},
									message: '<h1>Loading States</h1>'
									});
									
									if(x=='223')
									{
										 $.get('getcity_sign.php?con=us', function(data) {
										//$('#cities_host').html(data);
										});
									}else
									{
										 $.get('getcity_sign.php?con=ca', function(data) {
										//$('#cities_host').html(data);
										});
									}				
									

									ajaxFunction("getstate.php?country_id="+x, function()
									{

										if (xmlhttp.readyState==4 && xmlhttp.status==200)
										{
											
												setTimeout(function() {
													$.unblockUI({
														onUnblock: function(){												
													
													var s = xmlhttp.responseText;    //   s = "1,2,3,|state1,state2,state3,"
													s=s.split("|");                              //   s = ["1,2,3,", "state1,state2,state3,"]
													sid = s[0].split(",");  
													//  sid = [1,2,3,]
													sval = s[1].split(",");      
													//  sval = [state1, state2, state3,]
													st = document.getElementById('userstate');
													st.length=0; 
													for(i=0;i<sid.length-1;i++)
													{
													st[i] = new Option(sval[i],sid[i]);
													}
													
													
													}
												});
											}, 2000);												
										}
									});
					}

					function getcity_user(x)
					{
						
									$.blockUI({ css: {
										border: 'none',
										padding: '15px',
										backgroundColor: '#fecd07',
										'-webkit-border-radius': '10px',
										'-moz-border-radius': '10px',
										opacity: .8,
										color: '#000'
									},
									message: '<h1>Loading Cities</h1>'
									});
									
									$.get('getcity_sign.php?state_id='+x, function(data) {
										
												setTimeout(function() {
													$.unblockUI({
														onUnblock: function(){
															
															$('#usercity').html(data);
														}
													});
												}, 2000);
									});
					}

					function set_virtual_shipping_address(){
						
						if(document.getElementById('add_other_shipping_address').checked) {
							$("#set_alternate_shipping").show();
							$("#alternate_shipping").val("true");
						} else {
							$("#set_alternate_shipping").hide();
							$("#alternate_shipping").val("false");
						}	
						
					}

					function validateForm(){
						
						if ($(".shipping_rate").length > 0) {
							if (!$("input[name='shipping_rate']:checked").val()) {
							   alert('Please select a shipping method');
							   return false;
							}
						}else{
							$( "#user_order_checkout" ).submit();
						}
						
					}

					$(document).ready(function(){
						
						var getTotal = function(){
							var total = 0;
							$('.realprice').each(function(){
							cost=this.innerHTML;
							cost=cost.replace('$','');
							total += parseFloat($.trim(cost));
							});
							return total;
						}
						
						$('.subtotal').html(getTotal());
						$('#hidden_subtotal').val(getTotal());
						
						
						$('.add').click(function(){   // onclick 
						current_id=$(this).next().attr('id');
						var inc = $(this).next().val();
						inc=parseInt(inc)+1;
						session_cart_index=$('#session_cart_index'+current_id).val();
						session_cart_index=parseFloat(session_cart_index);
						
						$(this).next().val(inc);
										var pricecartitem=$("#pricecart-item"+current_id).val();	
										totalprice=pricecartitem*inc;
										totalprice=totalprice.toFixed(2);
										$("#total-pricecart-item"+current_id).html(totalprice);
										subtotalcartprice=$('#subtotalcartprice').val();	
										subtotalcartprice=parseFloat(subtotalcartprice)+parseFloat(pricecartitem);	
										$('.subtotalcartprice').html(subtotalcartprice.toFixed(2));
										$('#subtotalcartprice').val(subtotalcartprice);
										$('#hidden_subtotal').val(subtotalcartprice);
						$.ajax({
								type: "POST",
								url: "cart.php",
								data: "session_update_on_quantity_change="+session_cart_index+"&qty="+inc+"&subtotalcartprice="+subtotalcartprice,
								success: function(result){
										
								}
							});
						
						
						});
						
						$('.reduce').click(function(){   // onclick
							current_id=$(this).prev().attr('id');
							var inc = $(this).prev().val();
							inc=parseInt(inc)-1;
							if(inc>=1){
							$(this).prev().val(inc);
							var pricecartitem=$("#pricecart-item"+current_id).val();	
							totalprice=pricecartitem*inc;
							totalprice=totalprice.toFixed(2);
							$("#total-pricecart-item"+current_id).html(totalprice);	
							
							subtotalcartprice=$('#subtotalcartprice').val();
						subtotalcartprice=parseFloat(subtotalcartprice)-parseFloat(pricecartitem);
						
						$('.subtotalcartprice').html(subtotalcartprice.toFixed(2));
						$('#subtotalcartprice').val(subtotalcartprice);
						$('#hidden_subtotal').val(subtotalcartprice);
						session_cart_index=$('#session_cart_index'+current_id).val();
						session_cart_index=parseFloat(session_cart_index);
						
						$.ajax({
								type: "POST",
								url: "cart.php",
								data: "session_update_on_quantity_change="+session_cart_index+"&qty="+inc+"&subtotalcartprice="+subtotalcartprice,
								success: function(result){
										
								}
							});
							}
						});
						
					});	
						
					</script>
					 </div>
				</div>
			</div>
	</div>
</div>

<?php include('Footer.php'); ?>