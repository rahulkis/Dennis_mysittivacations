<?
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];

?>
<?
if(isset($_POST['getcolorvalue'])){
	
  $sql="SELECT DISTINCT  product_sizes.color,product_color_attribute.name FROM `product_sizes` join product_color_attribute on product_sizes.product_id=".$_POST['pid']." and product_color_attribute.id= product_sizes.color  and product_sizes.size=".$_POST['getcolorvalue'];
$product_sizes_avbl=mysql_query($sql);
if(mysql_num_rows($product_sizes_avbl)){?>
<label class="label lbl3">Color :</label>
<select id="choose_color_sel" name="choose_color_sel">
<option value="">Select Color</option>
<?while($product_sizes_avblx=mysql_fetch_array($product_sizes_avbl)){?>
<option value="<? echo $product_sizes_avblx['color'];?>"><? echo $product_sizes_avblx['name'];?></option>

<? }?>
</select>
<? }	
die;
}
?>
<?
if(isset($_POST['getstockvalue'])){
	
 $sql="SELECT stock FROM `product_sizes` where product_id=".$_POST['pid']." and size=".$_POST['getstockvalue']." and color=".$_POST['selectedcolor'];
$product_sizes_avbl=mysql_query($sql);
if(mysql_num_rows($product_sizes_avbl)){?>
<? $qty_data=mysql_fetch_array($product_sizes_avbl); 
if($qty_data['stock']>10){
	
	$qty=10;
	}else{
		$qty=$qty_data['stock'];
		}?>
		<label class="label lbl3">Quantity :</label>
<select id="choose_qty" name="choose_color_sel">
<option value="">Select Quantity</option>
<?for($i=1;$i<=$qty;$i++){?>
<option value="<? echo $i;?>"><? echo $i;?></option>

<? }?>
</select>
<? }	
die;
}
?>
<?php

if(isset($_POST['addcolor'])){
	 $message=array();
	 $colorname=$_POST['addcolor'];	 
	 $data=mysql_query("select count(id) as count from  `product_color_attribute` where name  LIKE '".$colorname."'");
	 $data=mysql_fetch_array($data);
	 if(!$data['count']){
          $sql="INSERT INTO `product_color_attribute` (`id`, `name`, `created_date`) VALUES ( NULL, '$colorname','now()');";	
          $row=mysql_query($sql);
          $lastinsertid=mysql_insert_id();
          $value="<option  selected='selected' value='".$lastinsertid."'>".$_POST['addcolor']."</option>";        
       
     }else{
		
		$value=false;
	 }
	 
	echo $value;
die;
 }

?> 
