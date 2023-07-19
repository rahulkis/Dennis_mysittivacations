<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Cart";


if(isset($_POST['set_shipping_price'])){
	
	unset($_SESSION['annual_price_with_shipping']);
	unset($_SESSION['tax_rate_name']);
	unset($_SESSION['shipping_charges_add']);
	
	$_SESSION['annual_price_with_shipping'] = $_SESSION['total_prodcut_price'] + $_POST['set_shipping_price'];
	$_SESSION['tax_rate_name'] = $_POST['tax_rate_name'];
	$_SESSION['shipping_charges_add'] = $_POST['set_shipping_price'];
	echo "set";
	die;
}

if(isset($_POST['session_update_on_quantity_change'])){
	$key=$_POST['session_update_on_quantity_change'];
	$qty=$_POST['qty'];
	
	$_SESSION['cart_value'][$key]['product_qty'] = $qty;
	$_SESSION['total_prodcut_price'] = $_POST['subtotalcartprice'];
	print_r($_SESSION['cart_value']);
	die;
}
		
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("index.php");
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
include('NewHeadeHost.php');
  $arr1 = array();
  $arr2 = array();

  foreach ($_SESSION['cart_value'] as $key=>$val) {
	
	$name = $val['host_id'];
   
	$arr1[] = array( $name => $val );
	$arr2[] = $_SESSION['cart_value'][$key]['host_id'];
  }
  
  $signle_hosts = array_unique($arr2);

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


?> 
<style type="text/css">
table.carttable th
{
	width: 133px;
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

<div class="v2_container">
	
		<div class="v2_recent_contests gutter20">
        <div class="v2_inner_main cart_inner">
					<h3 id="title">Cart
					
					</h3>
     <div class="continueshop_section">
     <div class="cart-btn-pack shoppingCont">
						<a class="button clearshoping" href="home_user.php">Continue Shopping</a>
						<a class="button clearshoping" href="cart.php?reset=a4dnv34sk"><span>Clear all Items</span></a>
					</div>
     </div>
					  <div class="cartscrolll" style="margin-top: 10px;">
					
							   <table class='display carttable'>
					
						<tr>
							<td colspan="2" style="background:#fecd07; color:#000;"><strong>Host Name</strong></td>
       		 
					</tr>
   
					  <?php
					if(isset($_REQUEST['delete_music']) && $_REQUEST['delete_music']!=''){
						  
						if(isset($_SESSION['cart_value'])){
							$asd[]=$_SESSION['cart_value'];
							unset($_SESSION['cart_value'][$_REQUEST['delete_music']]);
							$_session['cart_item_removed']="yes";
							$Obj->Redirect("cart.php");
						}
						
					}

						 if($_SESSION['cart_value'])
						 {
							   $i=0;
							  $a = 0;
							  $counter=0;
							  $subtotalcartprice=0;
							  
							if(count($signle_hosts) == 1){

								header('Location: '.$SiteURL.'host-cart.php?host_id='.$signle_hosts[0]);
							  
							}else{
								
								foreach($signle_hosts as $host_single){
									
									// echo "<pre>"; print_r($_SESSION['cart_value']); exit;
	
														if($a%2 == '0')
														{
														$class = " class='even' ";
														}
														else
														{
														$class = " class='odd' ";
														}?>
															  <tr>
																<td>
																	<?php
																	$club_nm = mysql_query("SELECT club_name FROM clubs WHERE id = '".$host_single."'");
																	$c_nm = mysql_fetch_assoc($club_nm);
																	?>
																	<?php echo $c_nm['club_name']; ?>
																</td>
																<!--<td>-->
																<!--	2-->
																<!--</td>-->
																<td style="float: right;">
																	<span style="float: left;">
																		<a href="host-cart.php?host_id=<?php echo $host_single; ?>"><img alt="Cart" src="images/shopping_cart_webshop.png"></a>
																	</span>
																	<span style="float: left; margin-top: 6px;">
																		<a class="explorcart" href="host-cart.php?host_id=<?php echo $host_single; ?>">View Cart</a>
																	</span>
																</td>
															 </tr>
							
								 <?php
								 $counter++;
								}								
								
							}

				}else{
					echo "<tr><td colspan='2'>Your cart is empty</td></tr>";
					}
				?>

					
				</table>
				</div>

				<script>
				$(document).ready(function()
						{
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

<?php include('Footer.php'); ?>