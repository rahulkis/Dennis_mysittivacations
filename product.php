<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Product Details";
include('LoginHeader.php');

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];


if(!isset($userID)){
	$Obj->Redirect("index.php");
}

if(!isset($_GET['id'])){
	$Obj->Redirect("index.php");
}

$avblsize=array();
?>
<script type='text/javascript' src='js/jquery.cookie.js'></script>
<script type='text/javascript' src='js/jquery.hoverIntent.minified.js'></script>
<script type='text/javascript' src='js/jquery.dcjqaccordion.2.7.min.js'></script>
<script src="js/imagezoom.js"></script>
 <?
$sql="SELECT sum(stock)  as stk FROM `product_sizes` where product_id=".$_GET['id'];
$productsize=mysql_query($sql);
if(mysql_num_rows($productsize)){
$productsize=mysql_fetch_array($productsize);
$productsize=$productsize['stk'];
}else{
$productsize=0;
}
if($_SESSION['user_type']=='club'){
	
	$host_id=$_SESSION['user_id'];
	}if($_SESSION['user_type']=='user'){
		$host_id=$_GET['host_id'];
		}	
?>
<a href="javascript:TB_show('Send invitation to friend/faimly for pledge', 'user_pledge_invite.php?user=testuserTB_iframe=true&amp;height=400&amp;width=450', '', './images/trans.gif');"></a>	
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
   	<?php  include('store_right_bar.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title">Product Details</h3>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}if($message['error']!=""){
						echo '<div id="error" class="messagemessage" >'.$message['error']."</div>";
						}?>
					 <?
					 $sql="select * from host_product where id=".$_GET['id'];
								$data=mysql_query($sql);
								if(mysql_num_rows($data)){
									while($row=mysql_fetch_array($data)){ 
										if($tbl='host_category'){
								$tbl="pl1";
								}else if($tbl='host_category_parent'){
								$tbl="pl2";	
								}else if($tbl='host_category_parent2'){
								$tbl="pl3";
								}
					?>
					
						<div style="margin: 0px auto; width: 100%; text-align: center;">				
								<span style="float: right; margin-top:5px; ">
								<? if($_SESSION['user_type']=='user'){?>
								
								<a class="button btn_add_venu" href="host_store.php?catid=<?echo $row['category_id'];?>&tbl=<?echo $tbl;?>&host_id=<?echo $_GET['host_id'];?>">Close</a>
								<? }else{?>								
								<a class="button btn_add_venu" href="host_store.php?catid=1&tbl=pl1">Close</a>
								<? } ?>
								</span>
						</div>
						<? if($_SESSION['user_type']=='club'){?>
						<div style="margin: 0px auto; width: 100%; text-align: center;">				
								<span style="float: right; margin-top:5px; ">

								<a class="button btn_add_venu" href="edit_product.php?id=<? echo $_GET['id'];?>">Edit Product</a>

								</span>
						</div>
						<? } ?>
						<div style="clear:both;"></div>
					

					<div class="main-store-div" >
							<!-- zoomer start -->
							<link rel="stylesheet" href="js/product_detail_popup/jquery.css">

							<script>
									jQuery(document).ready(function()
											{
												jQuery('.single-frame').click(function()
													{
														jQuery(this).addClass('selected');
														jQuery('.multi-frame').removeClass('selected');
														jQuery('#multiframe').hide();
														jQuery('#singleframe').show();
													})
												jQuery('.multi-frame').click(function()
													{
														jQuery(this).addClass('selected');
														jQuery('.single-frame').removeClass('selected');	
														jQuery('#singleframe').hide();
														jQuery('#multiframe').show();
													})
											});											
							</script>
						
						
						
						
					<div class="row">
					<!--<a target="_blank" href='<? //echo 'http://'.$_SERVER['HTTP_HOST']."/".$row['image_name'];?>'><img src="<? //echo $row['image_name'] ;?>" style="height: 50%;width: 77%;"></a>-->
					<div class="zoom-wrapper">
							<div class="zoom-left">
								<?php
								$product_images = @mysql_query("SELECT * FROM `product_images` where product_id=$_GET[id] AND status=1 AND base =1 ");
								
									while($product_images_res = @mysql_fetch_assoc($product_images))
									{
										
										echo '<div style="" class="thumb-image zoomWrapper zoomign">
												<img data-magnification="5" data-imagezoom="true" id="zoom_03" src="'.$product_images_res[path].'" width="280">
												</div>';
										
									}
								?>


														<div id="gallery_01">
														 <?php $product_images_thumb = @mysql_query("SELECT * FROM `product_images` where product_id=$_GET[id]");
															$get_image_array = array(); 
																while($product_images_thumb_res = @mysql_fetch_assoc($product_images_thumb))
																{ ?>
																	<a href="javascript: void(0)" onclick="change_pdt_img('<?php echo $product_images_thumb_res[path]; ?>')" class="elevatezoom-gallery active" data-update="" data-image="<?php echo $product_images_thumb_res[thumb]; ?>" data-zoom-image="<?php echo $product_images_thumb_res[path]; ?>">
														<img src="<?php echo $product_images_thumb_res[thumb]; ?>" width="90"></a>
																	
																<?php } ?>  
														</div>
							</div>



<div class="zoom-right">
	

							<div class="tabs">
							<div class="single-frame selected">Product Description</div>
							<div class="multi-frame">Customer Service</div>
							</div>
		
							<div id="singleframe" class="product_disc">
								 <? echo $row['product_desc'];?>
							</div>	 
												<!--<div class="product_description1">
												<ul>
												<li class="product_description1_lft">Product Name</li>
												<li class="product_description1_ryt">Lorem Ipsum is simply dummy text</li>

												<li class="product_description1_lft">Product Price</li>
												<li class="product_description1_ryt">#120</li>

												<li class="product_description1_lft">Choose Quantity</li>
												<li class="product_description1_ryt"><input type="text" id="chooseqty" name="chooseqty"></li>
												</ul>
												</div>-->
									
							
		
							<div id="multiframe" class="product_disc" style="display: none;">Customer Service Customer ServiceCustomer Service Customer ServiceCustomer Service Customer ServiceCustomer Service Customer Service
							Customer Service Customer ServiceCustomer Service Customer Service</div>

		
		
		
		   
				  <!-- PRoduct Info -->
					
					<div class="row prname">
					<span class="label prod_name_lbl">Product Name</span>
					<span class="formw prod_name">
						<? echo $row['product_name'];?>					
					</span>
					</div>
					<? if($_SESSION['user_type']=='club'){
						$sql="select category_name from ".$row['tbname']." where id=".$row['category_id'];
						$data=mysql_query($sql);
						$datacat=mysql_fetch_array($data);
											?>
						<div class="row">
							<span class="label lbl1">Parent Category</span>
							<span class="formw">
							<? echo $datacat['category_name'];?>					
							</span>
						</div>
					 <? } ?>
					
						<div class="row prise_row">
							<span class="label lbl3 label_prise_prdct">Product Price</span>
							<span class="formw">
							<?php echo "$".$row['product_price'];?>					
							</span>

							<? if($productsize){?>
							</div>
							<div class="row choose_size">
							<div class="sizechoose">
							<label class="label lbl3 choose_s lblproduct">Choose Size :</label>
							<span class="chose_xsize ">
							<?    $sql="SELECT  distinct product_sizes.size,product_size_attribute.name FROM `product_sizes` join product_size_attribute on product_sizes.product_id=".$row['id']." and product_size_attribute.id= product_sizes.size ";
							$product_sizes_avbl=mysql_query($sql);
							if(mysql_num_rows($product_sizes_avbl)){?>
							<!--<label class="label lbl3"></label>-->
							<select id="choose_size_sel" name="choose_size_sel">
							<option value="">Choose Size</option>
							<?while($product_sizes_avblx=mysql_fetch_array($product_sizes_avbl)){?>
							<option value="<? echo $product_sizes_avblx['size'];?>"><? echo $product_sizes_avblx['name'];?></option>

							<? }?>
							</select>
							<? }?>					        
							</span>
							
							<span class="sizeerror error"></span>
							</div>
							
							<span id="chose_xcolor" class="chose_xsize lblproduct"><label class="label lbl3">Color :</label>
								<select name="choose_color_sel" id="choose_color_sel">
								<option value="">Choose Color</option>
								</select>
							</span>
							<span class="coloreerror error"></span>
							
							<!--<span class="chose_xsize" id="chose_xcolor"></span>							-->
							
							<span id="chose_xqty" class="chose_xsize"><label class="label lbl3">Quantity :</label>
								<select name="choose_color_sel" id="choose_qty">
									<option value="">Choose Quantity</option>
								</select>
							</span>							

							<span class="qtyeerror error"></span>


							<? } ?>
						</div>
					<div class="row availability">					
					<span class="formw">						
							<? if($productsize){
								echo "In Stock";
							}else{
								echo "Out Of Stock";
							}
								?>					
					</span>
					</div>
					
					<div class="btncenter" <?php if($host_id == $_SESSION['user_id'] && $_SESSION['user_type'] == 'club'){ echo ' style="display:none;"';}?>>					
						<? if($productsize){?>
												<form method="POST" action="cart.php" class="product_cat_form" onsubmit="return checkvalidation()" style="margin:0 !important">
												<input type="hidden" id="product_id"  name="product_id" value="<?php echo $row['id'];?>">
												<input type="hidden" name="host_id" value="<?php echo $host_id;?>">      
												<input type="hidden" name="price_cart" value="<?php echo $row['product_price'];?>">
												<input type="hidden" name="product_weight" value="<?php echo $row['product_weight'];?>"> 
												<input type="hidden" name="product_type" value="2"> 
												<input type="hidden" id="product_qty" name="product_qty" value="1"> 
												<input type="hidden"  name="choose_colorx" id="choose_colorx" value="">
												<input type="hidden"  name="choose_sizex" id="choose_sizex" value="">
												<?if($_SESSION['user_type']){?>
												<!--<span class="addcart"><input type="image" src="images/cart2.png"><span>Add To Cart</span></span>-->
												<div class=" ">
												<input type="submit" class="button" value="Add To Cart">
												</div>
												 <? } ?>
												
												</form>
										<? }
										 else{							
										  }
										?>					
				
					</div>
					
					
					<? } 
					}?>
					
					<!-- PRoduct Info ends -->

</div>
</div>

<!-- zoomer Ends -->
					
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

<script type="text/javascript">	
	   function checkvalidation(){
		   size_selected_value=$("#choose_size_sel").val();
		   if(size_selected_value){
			   color_selected_value=$("#choose_color_sel").val();
			   if(color_selected_value){
				   qty_selected_value=$("#choose_qty").val();
				   if(qty_selected_value){
					   $('#product_qty').val(qty_selected_value);
						$('#choose_sizex').val(size_selected_value);
						 $('#choose_colorx').val(color_selected_value);
					   return true;
				   }else{
					   $(".qtyeerror").html("Please Select Quantity");
					   return false;
				   }
			   }else{
					$(".coloreerror").html("Please Select Color");
					return false;
			   }
			   
		   }else{
			   $(".sizeerror").html("Please Select Size");
			   return false;
		   }
		   return false;
	   }

 $(document).ready(function(){
		$('#choose_size_sel').on('change',function(){
			$('.error').html('');
			pid=parseInt($("#product_id").val());
		   selectedsize=parseInt($(this).val());	
		   if(selectedsize){
			$.ajax({
			type: "POST",
			url: "ajax_data_store.php",
			data:"getcolorvalue="+selectedsize+"&pid="+pid,
			success:  function(data){		
			
				$('#chose_xcolor').html(data);
			}

			}); 
			}else{
				$('#chose_xcolor').empty();
				$('#chose_xqty').empty();
				
			}
			
		});	
	
		$('#choose_color_sel').live('change',function(){
		$('.error').html('');
			pid=parseInt($("#product_id").val());
		   selectedsize=parseInt($('#choose_size_sel').val());	
		   selectedcolor=parseInt($(this).val());	
			if(selectedcolor){
				$.ajax({
			type: "POST",
			url: "ajax_data_store.php",
			data:"getstockvalue="+selectedsize+"&selectedcolor="+selectedcolor+"&pid="+pid,
			success:  function(data){		
			
				$('#chose_xqty').html(data);
			}

			}); 
		}else{
			$('#chose_xqty').empty();
		}
			
			
		});
	});
 
 function change_pdt_img(img){
	$("#zoom_03").attr("src",img);
 }
    </script>
 }

<style>
#accordion a{
	color:white;
	font-size:20px;
}
#accordion2 a{
	color:white;
	font-size:20px;
}
#accordion2{
	
	
}
#accordion2 li{
	padding-top:20%;
}
.left-store-div{
	float: left;
	width: 40%;
}
.right-store-div{
	float: right;
	width: 60%;
}
.product_box a{
	color:white;
	
	
}
</style>
<style>
.paginate {
  bottom: 0;
  clear: both;
  height: 30px;
  margin: 0;
  padding: 20px 0 0;
  /*position: absolute;*/
  text-align: center;left: 25px;
}
.paginate li {
	background: none repeat scroll 0 0 #f3cd07;
	display: inline-block;
	line-height: 25px;
	list-style: none outside none;
	margin-right: 1px;
	padding: 0;
	text-align: center;
	width: 30px;
}
.paginate .active {
	background-color: #666666;
	display: inline-block;
	line-height: 25px;
	list-style: none outside none;
	margin-right: 1px;
	padding: 0;
	text-align: center;
	width: 30px;
}
.paginate li a {
	color: black;
	text-decoration: none;
}
</style>
<?php include('Footer.php');?>