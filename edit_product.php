<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");	
}
if($userType=='user'){
	$Obj->Redirect("profile.php");
}
if(isset($_POST['updateprodcutsize']))
{
	$pid=$_POST['cat_id'];
	for($i=1;$i<=$_POST['qty_count_div'];$i++)
	{
		$c="avblcolorsel".$i;
		$s="avblsizesel".$i;
		$q="stock_qty".$i;
		$size=$_POST[ $s];
		$color=$_POST[$c];
		$qtys=$_POST[$q];
		if($qtys)
		{
			$sqlcount=mysql_query("SELECT count(id) as countpsize FROM `product_sizes` where product_id=".$pid." and color=".$color." and size=".$size);
			$sqlcount=mysql_fetch_array($sqlcount);
			if(!$sqlcount['countpsize'])
			{		
				$sql="INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `color`, `created_date`, `stock`) VALUES ( NULL, '$pid', '$size','$color','now()','$qtys');";	
				$row=mysql_query($sql);
			}
			else
			{
				$sql="UPDATE `product_sizes` SET `stock` = '".$qtys."' WHERE  product_id=".$pid." and color=".$color." and size=".$size;	
				mysql_query($sql); 
			}
			$_GET['msg']='updated';
		}
	}
	  
	
}

if(isset($_GET['id'])) 
{
	$sql_product_get = "SELECT * FROM `host_product` where id=".$_GET['id'];
	$host_category_info_set_get = mysql_query($sql_product_get);
	$countinfo = mysql_num_rows($host_category_info_set_get);
	$host_category_info_set = mysql_fetch_assoc($host_category_info_set_get);
	
	if(!$countinfo)
	{
		$Obj->Redirect("manage_product.php");
	}
	$sql="SELECT product_size_attribute.name as sizename, product_sizes.stock, product_color_attribute.name as colorname FROM `product_sizes` join product_size_attribute on product_size_attribute.id=product_sizes.size and product_sizes.product_id=".$_GET['id']." join product_color_attribute on product_color_attribute.id=product_sizes.color join host_product on host_product.id =  product_sizes.product_id and host_product.host_id = '".$_SESSION['user_id']."'";
	$host_size_info = mysql_query($sql);
	$countsize = mysql_num_rows($host_size_info);
}
$titleofpage="Edit Product";

include('LoginHeader.php');

  /******************/

?> 

<a href="javascript:TB_show('Send invitation to friend/faimly for pledge', 'user_pledge_invite.php?user=testuserTB_iframe=true&amp;height=400&amp;width=450', '', './images/trans.gif');"></a>	
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php  include('store_right_bar.php');?> 
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title">Edit Product</h3>
                        
					<?php
					if(isset($_SESSION['add_product_succ'])){ ?>
					
					<div class="addproduct_succeed">
						<?php
						
						echo $_SESSION['add_product_succ'];
						unset($_SESSION['add_product_succ']);
						?>
					</div>
					<?php
					}
					
					if($message['success'] != ""){ 

					echo '<div style="display:block;" id="successmessage" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div  style="display:block;" id="errormessage" class="message NoRecordsFound" >'.$message['error']."</div>";
					} 
					 if($_GET['msg']=='updated'){
						echo '<div  style="display:block;" id="successmessage" class="message" >Updated successfully</div>'; 
					 }
					?>
                     <div style="" class="topbtns_bar">	
									
						<span style="float: right; margin-top:5px; ">
					<a class="button btn_add_venu" href="manage_product.php">Manage Products	</a>
					</span>
					
						<span style="float: right; margin-top:5px; ">
					<a class="button btn_add_venu" href="store.php">Store</a>
					</span>
					
						
					</div>
					<form method="POST" name="frmhostcat" id="frmhostcat" action="manage_product.php" enctype="multipart/form-data" class="musicadd" onsubmit="return updateprodcutphoto('<?php echo $_GET['id'];?>')">

					 <div class="row">
					<span class="label">Product Category </span>
					<span class="formw">
						<?php
						
						  $sql="SELECT category_name FROM ".$host_category_info_set['tbname']." where id=".$host_category_info_set['category_id'];
						 $host_category_name_info=mysql_query($sql);
						 $host_category_name_info=mysql_fetch_array($host_category_name_info);
						 //print_r( $host_category_name_info);
						?>
					  <?  echo $host_category_name_info['category_name']; ?>
					  
					<!--<input type="text" name="Parent_name" id="parent_name" required value="<?  echo $host_category_info_set['parent_category_name']; ?>" /><br />-->
					</span>
					</div>
					<div class="row">
					<span class="label">Product Name<font color='red'>*</font></span>
					<span class="formw">

					<input type="text" name="product_name" id="product_name" required value="<? echo $host_category_info_set['product_name'] ;?>" /><br />
					</span>
					</div>
					 <div class="row">
					<span class="label">Add Product Image<font color='red'>*</font></span>
					<span class="formw">                       
						<input type="file" multiple="" name="file[]" id="image_file">                      
					<br />
					</span>
					</div>
			 <div class="row">
					<span class="label">Product Description<font color='red'>*</font></span>
					<span class="formw">

					<input type="text" name="product_desc" id="product_desc" required value="<? echo $host_category_info_set['product_desc'] ;?>" /><br />
					</span>
					</div>
					<div class="row">
					<span class="label">Product Price<font color='red'>*</font></span>
					<span class="formw">

					<input type="text" name="product_price" id="product_price" required value="<? echo $host_category_info_set['product_price'] ;?>" /><br />
					</span>
					</div>
					<div class="row">
						<span class="label">Product Weight<font color='red'>*</font></span>
						<span class="formw">
	
						<input type="text" name="product_weight" id="product_weight" required value="<? echo $host_category_info_set['product_weight'] ;?>" /><br />
						</span>
					</div>						
					<div class="row">
					<span class="label">Status</span>
					<span class="formw">
						<select name="status_category">
								  <option value="">
										Select Category Status
									 </option>
									 <option value="1" <? if($host_category_info_set['product_status']){echo 'selected="selected"';}?>>
										Active
									 </option>
									 <option value="0" <? if(!$host_category_info_set['product_status']){echo 'selected="selected"';}?>>
										 In-active
									 </option>
							 </select>
					</span>
					</div>
					<div class="row">
					<span class="label">Available Size<font color='red'>*</font></span>
					
					<span class="sizlavbllbl">
					<? if($countsize){
						while($product_size_info=mysql_fetch_array($host_size_info)){?>

						<div class="availsize">	
							<span class="avblsizelabelspanedit"></span>
							<label><? echo $product_size_info['colorname']."--".$product_size_info['sizename']." :";?></label>
							<label><? echo $product_size_info['stock'];?></label>
						</div>
					 <? }} ?>  
					 </span>
					</span>
					</div>
					<input style="margin-right:10px;" type ="button" id="show_hide_sizeandcolor"  class="button" value="Add & Edit Size" onclick="show_hide_div_for_size()">
					<input id="" class="button" style="margin-left:0px;" type="button" onclick="add_more_color_div()" value="Add More Color">
								<div id="add_more_color_div_toggle" style="display:none;"> 
								  <?php include('add_product_color.php');?>					
								
								</div>
					
					<? /* add and edit size */?>
					<div class="row" id="edit_qty_for_product_show_hide" style="display:none;">
						  
							<span class="sizlavbl">
							
							<div id="qty_for_product">								   
									<br>
									<input id="" class="button" style="margin-left:0px;" type="button" onclick="add_more_qty_div()" value="Add size & color">
									<div style="clear:both;"></div>
											 <? $i=1;?>
											<div id="qty_for_product_span<? echo  $i;?>">
											<div class="qty_for_product_header">
												<span class="button_style">Color</span>
												<span class="button_style">Size</span>
												<span class="button_style"> 
													<span >Quantity</span>
													<!--<span >Action</span>-->
												</span>
											</div>
											<div style="clear:both;"></div>
											
												<div class="size_color_etc">
													<? 
													$sizedata=mysql_query('select * from product_color_attribute');?>
													<select id="avblcolorsel<? echo $i;?>" name="avblcolorsel<? echo $i;?>" required>
														<option value=""><? echo "Select Color";?> </option>
													<? while($sizerow=mysql_fetch_array($sizedata)){?>
														<option value="<? echo $sizerow['id'];?>"><? echo $sizerow['name'];?> </option>
													<? }?>
													
													</select>
												</div>
											
												<div class="size_color_etc">
													 <? 
													$sizedata=mysql_query('select * from product_size_attribute');?>
													<select id="avblsizesel<? echo $i;?>" name="avblsizesel<? echo $i;?>" required>
														<option value=""><? echo "Select Size";?> </option>
													<? while($sizerow=mysql_fetch_array($sizedata)){?>
														<option value="<? echo $sizerow['id'];?>"><? echo $sizerow['name'];?> </option>
													<? }?>
													</select>                   
												 </div>
											
												<div class="size_color_etc">
												  <input required min="1"  type="number" id="stock_qty<? echo $i;?>" name="stock_qty<? echo $i;?>" placeholder="Quantity">
												</div>
												<div style="clear:both;"></div>
										</div>	
							</div>
							</span>			
					
							 <input type="hidden" value="1" id="qty_count_div" name="qty_count_div">
					</div>
				   
					<? /* image*/?>
					<input type="hidden" name="cat_id" value="<?php echo $_GET['id'];?>" />
						<div class="titl_prdct">
						<span class="label">Manage Product Images</span>
						<span class="formw">
						</span>
						</div>
						<div class="uploadphotos">							
							<div class="photos_row">								
						<?  $sql="select * from product_images where product_id=".$host_category_info_set['id'];						
						$host_product_images=mysql_query($sql);
						if(mysql_num_rows($host_product_images)){
							while($img_data=mysql_fetch_array($host_product_images)){?>
								<div class="photodata" style="margin-left:0;">
								<div class="thumb_photodata">
								<a rel="lightbox" href="<? echo $img_data['path'];?>" style="margin-bottom:5px;">
								<img width="135" height="157" src="<? echo $img_data['path'];?>">
								</a>
								</div>
								<div class="photo_buttons">
									   <span class="button imageupdatexyz btnupdata" id="imageupdatez<? echo $img_data['id'];?>">
											<span class="basetxt" style="color:white;">Base Image</span>
											<span> 
											<input type="radio" id="radiobase<? echo $img_data['id'];?>"class="imagebasedeleteact" value="<? echo $img_data['id'];?>"  name="baseimage" <? if($img_data['base']){ echo "checked='checked'"; } ?> >
											</span>
										</span> 
										 <div class="clear"></div>
										<span class="button btnupdata">
											<span class="basetxt" style="color:white;">Delete</span>
											<span> 
											<input type="checkbox" class="imagebasedeleteact" id="chkdel<? echo $img_data['id'];?>"value="<? echo $img_data['id'];?>" name="delete_photo[]" >
											</span>
										</span> 
										 <div class="clear"></div>
										<span class="button btnupdata">
											<span class="basetxt" style="color:white;">Active/In-active</span>
											<span> 
											<input type="checkbox" class="imagebasedeleteact" id="chkinact<? echo $img_data['id'];?>"value="<? echo $img_data['id'];?>" name="act-in_photo[]" <? if($img_data['status']){ echo "checked='checked'"; } ?> >
											</span>
										</span> 
								</div>
								</div>
								
							<?}
						}?>
							</div>
						</div>			

						<input type="hidden" name="cat_id" value="<?php echo $_GET['id'];?>" />
					<? /* image part ends */?>
					<div class="" id="submit_btn" >
					<input type="hidden" name="row_id" id="row_id" value="<? if($_GET['edit']) echo $_GET['edit']; ?>">
					<input type="submit" class="button" style="width: auto !important;padding: 5px 10px ;"  name="updateEvent" id="updateEvent" value="Update Product">					<input style="float:right" type="button" class="button" name="cancel" id="cancel" value="Cancel" onClick="cancelEdit()">
					</div>
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

function delrecoreds(id)
{
	 
  if(confirm('Are You sure You want to delete this record'))
  {
	  
	 $.get( "deletecategory.php?id="+id, function( data ) {
		window.location='manage_category.php';
		});
  }
   else
   {
	
	}

}
</script>
<script language="javascript">	
function show_hide_div_for_size(){
	
	$("#edit_qty_for_product_show_hide").toggle();
	$('#show_hide_sizeandcolor').toggle('Hide Add & Edit Size','Show Add & Edit Size');
	
}
function add_more_qty_div(){
	id=parseInt($("#qty_count_div").val());
$.ajax({
	type: "POST",
	url: "host_product.php",
	data:"divid="+id,
	success:  function(data){		
		$("#qty_count_div").val(id+1);
		$('#qty_for_product').append(data);
	}
   
	}); 
		
	
}
function delete_added_qty_div(id){
	$('#qty_for_product_span'+id).remove();
	
}
 function cancelEdit(){
   window.location='manage_product.php'
 }
 function updateprodcutphoto(product_id){
	
	if($("[name=baseimage]:checked").length==0){
		 alert('Please Select Product  Base Image Type');
	return false;
}else{
	 if(confirm('You sure you want to submit data')){
	$("#photostatusupdate") .submit();
	return true;}else{
		return false;
		}
		}
	 
	 
	 
 }
 $(document).ready(function(){
	 //$("#successmessage").delay('10000').hide();
	 $('.imagebasedeleteact').click(function(){
		 val=$(this).val();
		if($(this).attr('checked')){
			if($(this).attr('name')=='delete_photo[]'){
				  //$('#chkinact'+val).attr('checked', true);  
				 $('#radiobase'+val).attr('checked', false);  
			 }
			 if($(this).attr('name')=='act-in_photo[]'){
				  $('#chkdel'+val).attr('checked', false);  
				
			 }
			  if($(this).attr('name')=='baseimage'){
				  $('#chkdel'+val).attr('checked', false);  
				  $('#chkinact'+val).attr('checked', true); 
			 }
			}else{
				  if($(this).attr('name')=='act-in_photo[]'){
				 $('#radiobase'+val).attr('checked', false);  
				
			 }
				 
			}
		 
		 
		 })
	 
	 
	 });
</script>
<script>

$(document).ready(function() {
	$('#selecctall').click(function(event) {  //on click
		if(this.checked) { // check select status
			$('.checkbox1').each(function() { //loop through each checkbox
				this.checked = true; 
				$('.checkbox2').prop('required',true); //select all checkboxes with class "checkbox1"              
			});
		}else{
			$('.checkbox1').each(function() { //loop through each checkbox
				 this.checked = false;  
				  $('.checkbox2').prop('required',false);  //deselect all checkboxes with class "checkbox1"                      
			});        
		}
	});
	$('.checkbox1').click(function(event) {  
		val=$(this).val();
		if($(this).is(':checked')){
		$('#qty'+val).prop('required',true); 
		}else{
			$('#qty'+val).prop('required',false); 
		}
	});
   
});
</script>
<?php include('Footer.php'); ?>