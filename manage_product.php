<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
}

$message = "";
if(isset($_POST['submit']) && $_POST['submit'] == "Save")
{
	if(isset($_POST['featured']))
	{
		foreach($_POST['featured'] as $featured)
		{
			mysql_query("UPDATE `host_product` SET `featured` = '1' WHERE `id` = '$featured' ");
		}
	}
	 $message['success']="Product has been successfully added to featured List! ";
}



if(isset($_POST['updateEvent']))
{
	$no=count($_FILES['file']['name']);
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
	$sql="UPDATE `host_product` SET `product_weight` = '".$_POST['product_weight']."', `product_price` = '".$_POST['product_price']."', `product_stock` = '".$_POST['product_stock']."', `image_name` = '".$path."', `thumbnail` = '".$thumb."', `product_desc` = '".$_POST['product_desc']."', `product_status` = '".$_POST['status_category']."', `product_name` = '".$_POST['product_name']."' WHERE `host_product`.`id` = ".$_POST['cat_id'];
	$row=mysql_query($sql);
 	$last_isert_id=$_POST['cat_id'];
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
	if($last_isert_id)
	{
		if($_FILES['file']['name'][0])
		{
			$basecount=mysql_query("SELECT count(id) as countbase FROM `product_images` where product_id=".$last_isert_id." and base=1 ");
			$basecount=mysql_num_rows($basecount);
			for ($i=0;$i<count($imgarr);$i++)
			{
				if($basecount>0 && $i==0 )
				{
					$base=1;
				}
				else
				{
					$base=0; 
				}
				$sql="INSERT INTO `product_images` (`id`, `product_id`, `path`,`thumb`, `base`, `status`, `created_date`) VALUES ( NULL, '$last_isert_id', '$imgarr[$i]','$thumbarr[$i]', '$base','1','now()');";	
				$row=mysql_query($sql);
			}
		}
		/*  manage Images at edit product*/
		$sql="UPDATE `product_images` SET `base` = '0' WHERE `product_id`=".$_POST['cat_id'];
		mysql_query($sql);
		$sql="UPDATE `product_images` SET `base` = '1' WHERE `id` =".$_POST['baseimage'];
		mysql_query($sql);
		/* active inactive*/
		$sql="UPDATE `product_images` SET `status` = '0' WHERE `product_id`=".$_POST['cat_id'];
		mysql_query($sql);
		if($_POST['act-in_photo'])
		{
			foreach($_POST['act-in_photo'] as $data)
			{
				$sql="UPDATE `product_images` SET `status` = '1' WHERE `id` =".$data;	
				mysql_query($sql);
			}
		}
		/* delete image*/
		if($_POST['delete_photo'])
		{
			foreach($_POST['delete_photo'] as $data)
			{
				$sql="delete from  `product_images` WHERE `id` =".$data;	
				mysql_query($sql);
			}
		}
  		$message['success']="Product has been successfully updated ";
	}
	else
	{
		$message['error']="Can not add Product product Please try again later";
	}
}

$titleofpage="Manage Products";
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}
require_once("admin/paging.php");
$item_per_page=7;
if(isset($_GET['id'])) 
{
	if($_GET['id'])
	{
		if($_GET['tbl']=='pl1')
		{
			$tbname="host_category";
		}
		elseif($_GET['tbl']=='pl2')
		{
			$tbname="host_category_parent";
		}
		elseif($_GET['tbl']=='pl3')
		{
			$tbname="host_category_parent2";
		}
		$sql="select * from host_product where host_id=".$_SESSION['user_id']." and category_id=".$_GET['id']." and tbname='".$tbname."' ORDER BY `id` DESC ";
		$host_product_info=mysql_query($sql);
		$countinfo=@mysql_num_rows($host_product_info);

	}
	else
	{
		$sql="select * from host_product where host_id=".$_SESSION['user_id']." ORDER BY `id` DESC ";
		$host_product_info=mysql_query($sql);
		$countinfo=@mysql_num_rows($host_product_info);
	}
}
else
{

	$sql="select * from host_product where host_id=".$_SESSION['user_id']." ORDER BY `id` DESC";
	$host_product_info=mysql_query($sql);
	$countinfo=@mysql_num_rows($host_product_info);
}



$rowCount = 0;
$total = 0;
$total = $countinfo;
if(isset($_GET['page']))
{
        	$page = $_GET['page'];
}
else
{
   	$page = '1';
}
$limit = '7';  //limit
$i=$limit*($page-1);

$pager = Pager::getPagerData($total, $limit, $page);
$offset = $pager->offset;
$limit  = $pager->limit;
$page   = $pager->page;
$sql1 = $sql . " limit $offset, $limit";



$host_product_info1=mysql_query($sql1);
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
  						<h3 id="title">Manage Products</h3>
							<?php
							if($message['success'] != ""){

								echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
							}
							
							if($_GET['action'] == "del"){

								echo '<div id="successmessage" class="message" >Product deleted successfully</div>';
							}
							?>
						<div class="top_btns">				
								<span class="btn_1">
							<a class="button btn_add_venu" href="store.php">Store Menu</a>
							</span>
		                  <span class="btn_1">
							<a class="button btn_add_venu" href="host_product.php">Add Product</a>
							</span>
							</div>
							 <div class="loadmore manage_prodct">
		<span class="new_mnth">
			
						<span id="date_month_venue" class="">Load By Parent Category</span>
								<? 
								$sql="select * from host_category where host_id=".$_SESSION['user_id']." or host_id=0";
								$host_category_info=mysql_query($sql);
								
								
		                    ?>
		                      <select name="parent_category" id="parent_category">
										 <option value="0" <?if(!isset($_GET['id'])){echo "selected=''selected'";}?>>
										All
										 </option>
										<? while($row= mysql_fetch_array($host_category_info)){?>
											
											<option style="font-weight:bold;" value="<? echo $row['id']."-"."host_category"; ?>" <? if($row['id']==$_GET['id'] && $_GET['tbl']=='pl1'){echo "selected='selected'";} ?>><? echo $row['category_name']; ?></option>
											   <? 
										    $sql="select * from host_category_parent where parent_id=".$row['id'];
								            $host_category_infox2=mysql_query($sql);
								            $countinfox2=mysql_num_rows($host_category_infox2);
								            
								            if($countinfox2){
											while($row2= mysql_fetch_array($host_category_infox2)){?>
											
											<option value="<? echo $row2['id']."-"."host_category_parent"; ?>" <? if($row2['id']==$_GET['id'] && $_GET['tbl']=='pl2'){echo "selected='selected'";} ?>><? echo $row2['category_name']; ?></option>
											    <? 
										    $sql="select * from host_category_parent2 where parent_id=".$row2['id'];
								            $host_category_infox3=mysql_query($sql);
								            $countinfox3=mysql_num_rows($host_category_infox3);
								            
								            if($countinfox3){
											while($row3= mysql_fetch_array($host_category_infox3)){?>
											
											<option value="<? echo $row3['id']."-"."host_category_parent2"; ?>" <? if($row3['id']==$_GET['id'] && $_GET['tbl']=='pl3'){echo "selected='selected'";} ?>><? echo $row3['category_name']; ?></option>
											
											<?}}?>
											<?}}?>
											<?}?>
											
											
											
								 </select>
						</span>
							
							</div>
						<form action="" method="POST">
      <div class="autoscroll">
						<table id="example" class="display loadmusic table_100" style="margin-top:10px;">
							<thead>
								<tr bgcolor="#ACD6FE">
									<th>Product Name</th>
									<th>Product Thumbnail</th>
									<th>Price($)</th>
									<?php 
									if($type_of_club == "105" || $type_of_club == "103")
									{
										echo "<th>Featured</th>";
									}

									?>
									<th>Action</th>
								
								</tr>
							</thead>
							<tbody>
							<? if($countinfo){
								while($data=mysql_fetch_array($host_product_info1)){
									?>
								<tr>
									<td>
									<? echo $data['product_name']; ?>
									</td>
									<td>

									<?php
									$get_p_img = mysql_query("SELECT thumb, path FROM product_images WHERE product_id = '".$data['id']."' AND base = '1'");
									$p_img = mysql_fetch_assoc($get_p_img);
									if (strpos($p_img,'uploadq/small') !== false){
									?>
									<a rel="lightbox" href="<? echo $p_imgy['path'];?>">
									<img style="float: left; width: 50%;" src="<?php echo $p_img['thumb']; ?>">
									</a>
									<?php }else{ echo "Image Not Available"; } ?>
									</td>							
									<td>
									<? echo $data ['product_price'];?>
									</td>
									<?php
									if($type_of_club == "105" || $type_of_club == "103")
									{
										?>

										<td>
											<input <?php if($data['featured'] == '1'){ echo "checked"; }?>  type="checkbox" name="featured[]" value="<?php echo $data['id']; ?>" />
										</td>

							<?php 		}	?>
									<td>
										<a href="edit_product.php?id=<? echo $data ['id'];?>">
											<img width="25px" height="25px" title="Edit" src="images/Edit.png">
		                                 </a>
										<a onClick="delrecoreds('<?php echo $data['id']; ?>');" >
										<img width="25px" height="25px" title="Delete" src="images/del.png">
										</a>
									</td>
								</tr>
							<? }}else{?>
								<tr>
									<td colspan="4">
										No product in this category.
								   </td>
								   </tr>
								<?}?>
							</tbody>
							</table>
       </div>
							<div class="formSubmit">
								<input type="submit" class="button" name="submit" value="Save" />
							</div>
						</form>
							<div style="clear:both:padding-top:20px;"></div>
							<?php
		echo '<div class="pagination">';
				echo '<a href="'.$_SERVER['PHP_SELF'].'?page=1'.$p_id.'"><span title="First">&laquo;</span></a>';
				if ($page <= 1)
					echo "<span>Previous</span>";
				else            
					//echo "<a href='".$_SERVER['PHP_SELF']."'?page=".($page-1)."'><span>Previous</span></a>";
					echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page-1).$p_id."'><span>Previous</span></a>";
				echo "  ";
				for ($x=1;$x<=$pager->numPages;$x++){
					echo "  ";
					if ($x == $pager->page)
						echo "<span class='active'>$x</span>";
					else
						echo "<a href='".$_SERVER['PHP_SELF']."?page=".$x.$p_id."'><span>".$x."</span></a>";
				}
				if($page == $pager->numPages) 
					echo "<span>Next</span>";
				else           
					echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page+1).$p_id."'><span>Next</span></a>";
										
				echo "<a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages.$p_id."'><span title='Last'>&raquo;</span></a>";
		echo "</div>";	


							?>
		                   <div id="results"></div>
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
	 
  if(confirm('If you deleAre You sure You want to delete this record'))
  {
	  
	 $.get( "deleteproduct.php?id="+id, function( data ) {
		window.location='manage_product.php?action=del';
		});
  }
   else
   {
	
	}

}
$(document).ready(function(){
	
	$('#parent_category').on('change',function(){		
		var asd=$(this).val().split('-');	
		if(asd[0]>0){
			url=asd[0];
		if(asd[1]=="host_category"){
				window.location='manage_product.php?id='+url+'&tbl=pl1';				
			}else if(asd[1]=="host_category_parent"){
				window.location='manage_product.php?id='+url+'&tbl=pl2';				
			}else if(asd[1]=="host_category_parent2"){
				window.location='manage_product.php?id='+url+'&tbl=pl3';
			}
	}else{
		window.location='manage_product.php';	}
		
		});	
	});
	
	$(document).ready(function() {
    $(".paginate_click").click(function (e) {
        var clicked_id = $(this).attr("id").split("-"); //ID of clicked element, split() to get page number.
        var page_num = parseInt(clicked_id[0]); //clicked_id[0] holds the page number we need       
        $('.paginate_click').removeClass('active'); //remove any active class       
        $("#example tbody").load("fetch_pages.php", {'page': (page_num-1)}, function(){
        });
        $(this).addClass('active');       
        return false; 
    });
});
</script>

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
.formSubmit {
    float: left;
    margin-top: 20px;
    width: 100%;
}

</style>
<?php include('Footer.php');?>