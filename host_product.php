<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$_SESSION['user_id'] = "51";
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}

if(isset($_POST['divid']))
{
	$divid=$_POST['divid']+1;
	echo '<div id="qty_for_product_span'.$divid.'">';
	?>
						<div class="size_color_etc">
						<? $i=1;
						$sizedata=mysql_query('select * from product_color_attribute');?>
						<select id="avblcolorsel<? echo $divid;?>" name="avblcolorsel<? echo $divid;?>" required>
							<option value=""><? echo "Select Color";?> </option>
						<?while($sizerow=mysql_fetch_array($sizedata)){?>
							<option value="<? echo $sizerow['id'];?>"><? echo $sizerow['name'];?> </option>
						<?}?>
						</select>
						</div>
						
						<div class="size_color_etc">
						
						 <? 
						$sizedata=mysql_query('select * from product_size_attribute');?>
						<select id="avblsizesel<? echo $divid;?>" name="avblsizesel<? echo $divid;?>" required>
							<option value=""><? echo "Select Size";?> </option>
						<?while($sizerow=mysql_fetch_array($sizedata)){?>
							<option value="<? echo $sizerow['id'];?>"><? echo $sizerow['name'];?> </option>
						<?}?>
						</select> 
						
						</div>                  
					
					<div class="size_color_etc">
					<input required min="1" type="number" id="stock_qty<? echo $divid;?>" name="stock_qty<? echo $divid;?>" placeholder="Quantity">
					<input type="button" onclick="delete_added_qty_div('<? echo $divid;?>')"value="Remove" id="">
					</div>
					<div style="clear:both;"></div>
					</div>
	
<?		die;
}

if(isset($_POST['create_product'])){
	//echo "<pre>";print_r($_POST);die;
	
	 $no=count($_FILES['file']['name']);
	 $imgarr=array();
	for ($i=0;$i<$no;$i++)
	{
		//header('Content-Type: image/jpeg');
		//header('Content-Type: image/jpeg');
		$file_name=$_FILES['file']['name'][$i];
		$tmp=$_FILES['file']['tmp_name'][$i];
		$ext =substr($file_name,strrpos($fname,'.'));
		//$img_path = "_".time().strtotime(date("Y-m-d")).$i.$ext;
		$suff  = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890');
		$img_path = "_".$suff.$i.$ext;
		$path="uploadq/".$img_path;	
		//$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$file_name."_thumbnail".$ext;
		$thumb = "_".$suff.$file_name."_thumbnail".$ext;
		$thumbnail = "uploadq/".$thumb;
		$img_dirlarge="uploadq/small/";

$img = explode('.', $file_name);

$image_filePath = $tmp;

//$krowAvatar='ProfilePicLarge.'.$img[1];
$krowAvatar=$thumb;
$img_thumbLarge = $img_dirlarge . $krowAvatar;

$extension = strtolower($img[1]);

if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'bmp')))
{

	list($gotwidth, $gotheight, $gottype, $gotattr)= getimagesize($image_filePath);

	//---------- To create thumbnail of image---------------
	if($extension=="jpg" || $extension=="jpeg" ){
	$src = imagecreatefromjpeg($tmp);
	}
	else if($extension=="png"){
	$src = imagecreatefrompng($tmp);
	}
	else{
	$src = imagecreatefromgif($tmp);
	}
	//Get the height and width of uploaded image
	list($width,$height)=getimagesize($tmp);

// ----------------------------------------------------

	//Set new width for image
	$newwidthLarge=280;

	//Set new height for image
	 $newheightLarge=180;

	// or Calculate and scale it proportanly
	//$newheightLarge=round(($height*$newwidthLarge)/$height);

// ----------------------------------------------------

	//Creating the thumbnail from true color
	$tmpp=imagecreatetruecolor($newwidthLarge,$newheightLarge);
	//Enable image interlace property
	imageinterlace($tmpp, 1);
	//Create a image with given dimension
	imagecopyresampled($tmpp,$src,0,0,0,0,$newwidthLarge,$newheightLarge, $width,$height);	
	//Put the image data to newly created Image
	$createImageSave=imagejpeg($tmpp,$img_thumbLarge,100);			
		$thumbarr[]=$img_thumbLarge;
}	
		
		
		move_uploaded_file($tmp,$path);
		$imgarr[]=$path;

		
				
		}
	//echo "<pre>"; print_r($_POST); die;
		
		$userId = $_SESSION['user_id'];		
		$productstatus = $_POST['status_category'];
		$parentcat = $_POST['parent_category'];
		$parentcat = explode("-",$parentcat);
		$tbname = $parentcat[1];
		$parentcat = $parentcat[0];
		$productname = $_POST['Product_name'];
		$productprice = $_POST['Product_price'];
		$productstock = $_POST['Product_stock'];
		$productdesc = $_POST['Product_desc'];
		$productweight = $_POST['Product_weight'];
	$sql="INSERT INTO `host_product` (`product_price`, `product_stock`, `product_desc`,`product_weight`, `product_status`, `created_time`, `id`, `host_id`, `category_id`, `product_name`, `image_name`, `thumbnail`,`tbname`) VALUES ('$productprice', '$productstock', '$productdesc', '$productweight', '$productstatus', 'now()', NULL, '$userId', '$parentcat', '$productname','$path','$thumbnail','$tbname');";
		
		$row=mysql_query($sql);
	   $last_isert_id=mysql_insert_id();
	//$last_isert_id=345;
  if( $last_isert_id){
	  for ($i=0;$i<count($imgarr);$i++){
		  if($i=='0'){
			  $base=1;
		  }else{
			  $base=0;
		  }		  
		   $sql="INSERT INTO `product_images` (`id`, `product_id`, `path`,`thumb`, `base`, `status`, `created_date`) VALUES ( NULL, '$last_isert_id', '$imgarr[$i]','$thumbarr[$i]', '$base','1','now()');";	
		  $row=mysql_query($sql);
	  
	  }

	//$countQty = count($_POST['qty_count_div']);



	  for($i=1;$i<=$_POST['qty_count_div'];$i++){
			  $c="avblcolorsel".$i;
			  $s="avblsizesel".$i;
			  $q="stock_qty".$i;
			  $size=$_POST[ $s];
			  $color=$_POST[$c];
			  $qtys=$_POST[$q];
			  if($qtys){
				 
			 $sqlcount=mysql_query("SELECT count(id) as countpsize FROM `product_sizes` where product_id=".$last_isert_id." and color=".$color." and size=".$size);
			 $sqlcount=mysql_fetch_array($sqlcount);
			  if(!$sqlcount['countpsize']){				 
				   $sql="INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `color`, `created_date`, `stock`) VALUES ( NULL, '$last_isert_id', '$size','$color','now()','$qtys');";	
				   $row=mysql_query($sql);
				}
			  }
			  }
	  
  $message['success']="Product has been successfully added ";
  $_SESSION['add_product_succ'] = "Product has been successfully added";
}else{
	$message['error']="Can not add Product product Please try again later";
}
$Obj->Redirect("edit_product.php?id=".$last_isert_id);
}

$host_category_info_cat = mysql_query("select * from host_category where host_id=".$_SESSION['user_id']." or host_id = 0 and status=1");
// $countinfo123=@mysql_num_rows($host_category_info);
$titleofpage="Add Product";

if(isset($_GET['host_id']))
{
	include('LoginHeader.php');
}
else
{
	include('HeaderHost.php');	
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
<script>
function validate_image()
{
	
	if(document.getElementById('image_file').value== "" )
	 {
		alert( "Please provide image!" );
		document.getElementById('image_file').focus() ;
		return false;   
	}
	var ext = $('#image_file').val().split('.').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg']) == -1) {
	   alert( "Please valid image type" );return false;
	}

}
</script>
 
<a href="javascript:TB_show('Send invitation to friend/faimly for pledge', 'user_pledge_invite.php?user=testuserTB_iframe=true&amp;height=400&amp;width=450', '', './images/trans.gif');"></a>	
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
  						<h3 id="title">Add Product</h3>
						<?php if($message['success'] != ""){ 

						echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
						}if($message['error']!=""){
							echo '<div style="display:block;" id="error" class="messagemessage" >'.$message['error']."</div>";
							}?>
							
							<div style="" class="topbtns_bar">	
										
							<span style="float: right; margin-top:5px; ">
						<a class="button btn_add_venu" href="manage_product.php">Manage Products	</a>
						</span>
						
							<span style="float: right; margin-top:5px; ">
						<a class="button btn_add_venu" href="store.php">Store Menu</a>
						</span>
						
							
						</div>
						<form method="POST" onsubmit="return validate_image();" enctype="multipart/form-data" action="" name="frmhostcat" id="frmhostcat">
						
						
						 <?php if(mysql_num_rows($host_category_info_cat) > 0) { ?>
						<div class="row parent_cate">
						<span class="label lbl1">Product Category<font color='red'>*</font></span>
						<span class="formw select1">
							 <select name="parent_category">
									 <option value="">
									Select Product Category
									 </option>
									<?php while($row = mysql_fetch_assoc($host_category_info_cat)){ ?>
										
										<option  style="font-weight:bold;" value="<? echo $row['id'].'-host_category'; ?>" <? if($row['id']==$_GET['id']){echo "selected=''selected'";} ?>><? echo $row['category_name']; ?></option>
										<?php $sql="select * from host_category_parent where host_id=".$_SESSION['user_id']." and parent_id=".$row['id'];?>
										<?php
										$host_category_infox=mysql_query($sql);
										$countinfox=mysql_num_rows($host_category_infox);
										
										if($countinfox){
										while($row2= mysql_fetch_array($host_category_infox)){?>
										
										<option value="<? echo $row2['id']."-"."host_category_parent"; ?>" <? if($row2['id']==$_GET['id']){echo "selected=''selected'";} ?>><? echo $row2['category_name']; ?></option>
											 <? 
										$sql3="select * from host_category_parent2 where host_id=".$_SESSION['user_id']." and parent_id=".$row2['id'];
										$host_category_infox3=mysql_query($sql3);
										$countinfox3=mysql_num_rows($host_category_infox3);
										
										if($countinfox3){
										while($row3= mysql_fetch_array($host_category_infox3)){?>
										
										<option value="<? echo $row3['id']."-"."host_category_parent2"; ?>" <? if($row3['id']==$_GET['id']){echo "selected=''selected'";} ?>><? echo $row3['category_name']; ?></option>
										
										<?}}?>
										<?}}?>
										<?}?>
										
										
							 </select>
						<br />
						</span>
						</div>
						<? } ?>
						<div class="row">
						<span class="label lbl2">Product Name<font color='red'>*</font></span>
						<span class="formw">                       
							 <input required type="text" class="inp5" name="Product_name">                        
						<br />
						</span>
						</div>
						<div class="row">
						<span class="label lbl3">Product Image<font color='red'>*</font></span>
						<span class="formw">                       
							<input type="file" multiple="" name="file[]" id="image_file">                      
						<br />
						</span>
						</div>
						<div class="row">
						<span class="label">Product Description<font color='red'>*</font></span>
						<span class="formw">                       
							 <input required type="text" class="inp5" name="Product_desc">                        
						<br />
						</span>
						</div>
						<div class="row">
						<span class="label">Product Price $<font color='red'>*</font></span>
						<span class="formw">                       
							 <input required type="text" class="inp5" name="Product_price">                        
						<br />
						</span>
						</div>
						
						<div class="row">
							<span class="label">Product Weight $<font color='red'>*</font></span>
							<span class="formw">                       
								 <input placeholder="Weight in LB's" required type="text" class="inp5" name="Product_weight">
							<br/>
							</span>
						</div>					
						
						<div class="row">
						<span class="label">Product Status<font color='red'>*</font></span>
						<span class="formw">
						   
							 <select name="status_category">
								  <option value="">
										Select Product Status
									 </option>
									 <option value="1">
										Active
									 </option>
									 <option value="0">
										 De-active
									 </option>
							 </select>
							
						<br />
						</span>
						</div>
						<!--<div class="row">
						<span class="label">Available Size<font color='red'>*</font></span>
						<span class="sizlavbl">
							<label>All</label>
							<input type="checkbox" id="selecctall"></br>
							<? 
							$sizedata=mysql_query('select * from product_size_attribute');
							
							while($sizerow=mysql_fetch_array($sizedata)){?>
								<label><? echo $sizerow['name'];?></label>
								<input type="checkbox" class="checkbox1" name="size[]" id="size<? echo $sizerow['id'];?>" value="<? echo $sizerow['id'];?>">
								<input type="text" class="checkbox2" placeholder="Quantity for <? echo $sizerow['name'];?>" name="qty<? echo $sizerow['id'];?>" id="qty<? echo $sizerow['id'];?>" value="">
								</br>
							<?}
							?>                     
						<br />
						</span>
						</div>-->
						<div class="row">
							   <span class="label">Available Size<font color='red'>*</font></span>
								<span class="sizlavbl">
								
								   <div id="qty_for_product">								   
									<br>
									
									<ul class="btncenter_new">
					<li><input type="button" class="button addfrmbutton" name="submit" onclick="add_more_qty_div()" value="Add size & color"></li>
					<li>				
					
					<input id="" class="button" style="margin-left:0px;" type="button" onclick="add_more_color_div()" value="Add More Color">			
					</li>
					</ul>
					
					<!--<input id="" class="button" style="margin-left:0px;" type="button" onclick="add_more_qty_div()" value="Add size & color">-->
									<!--<input id="" class="button" style="margin-left:0px;" type="button" onclick="add_more_color_div()" value="Add More Color">-->
									
									
									
									<div id="add_more_color_div_toggle" style="display:none;"> 
									  <? include('add_product_color.php');?>					
									
									</div>
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
						
						<!--<div class="row">
						<span class="label">
							<input value="Create Product" style=" float: left;" type="submit" class="button" name="create_product">
							</span>                        
							
							<span class="formw">
								<input type="button" class="button" name="cancel" id="cancel" value="Cancel" onClick="cancelEdit()">
							</span>
						</div>-->
						
						<ul class="btncenter_new">
					<li><input type="submit" class="button addfrmbutton" value="Create Product" name="create_product"></li>
					<li>				
					<!--<a style="float: right;" class="button" href="listevent.php">Cancel</a>	-->	
					 <input type="button" class="button" name="cancel" id="cancel" value="Cancel" onClick="cancelEdit()">		
					</li>
					</ul>

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
 function cancelEdit(){
   window.location='manage_product.php'
 }
function delete_added_qty_div(id){
	
		$('#qty_for_product_span'+id).remove();
}
$(document).ready(function() {
	
	 $('#selecctall').trigger('click'); 
	 $('.checkbox1').each(function() { //loop through each checkbox
				this.checked = true; 
				$('.checkbox2').prop('required',true); //select all checkboxes with class "checkbox1"              
			});
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
<?php include('Footer.php');?>