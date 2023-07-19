<?
include("Query.Inc.php");
$Obj = new Query($DBName);
//echo $_REQUEST['page'];
 $f=9*$_REQUEST['page'];
  $id=$_REQUEST['id'];
 $tbl=$_REQUEST['tbl'];
  $host_id=$_REQUEST['host_id'];
if($tbl=='pl1'){
			$tbname="host_category";
		}else if($tbl=='pl2'){
			$tbname="host_category_parent";
		}else if($tbl=='pl3'){ 	
			$tbname="host_category_parent2";
		}

?>
        <? 
        if($id){
			
			$sql="select * from host_product where category_id=".$id." and tbname='".$tbname."' and host_id=".$host_id. " order by id DESC limit ".$f.",9 ";
		 }else{
			 $sql="select * from host_product where category_id in(select id from host_category where host_id=".$host_id. " and status=1 union select id from host_category_parent where host_id=".$host_id. " and status=1 union select id from host_category_parent2 where host_id=".$host_id. " and status=1) order by id DESC limit ".$f.",9 ";
		 }
								$data=mysql_query($sql);
								if(mysql_num_rows($data)){?>
<?				while($row=mysql_fetch_array($data)){
												echo ' <form method="POST" action="cart.php" class="product_cat_form">';?>
												  <input type="hidden" name="product_id" value="<?php echo $row['id'];?>">
												  <input type="hidden" name="host_id" value="<?php echo $host_id;?>">      
												  <input type="hidden" name="price_cart" value="<?php echo $row['product_price'];?>"> 
												  <input type="hidden" name="product_type" value="2"> 
											       <input type="hidden" name="product_qty" value="1"> 
	                         					
												<div class='product_box'>
                                               
													<div class='product_box-img'>
														<a href='product.php?id=<? echo $row['id']; if($_SESSION['user_type']=='user'){ echo "&host_id=".$host_id;}?>'><img src='<? echo $row['image_name'];?>' style='height:200px;width:200px'/></a>
													</div>
                                                        <div class="bottom_prodct">
												<div class='product_box-nameprice'>
														<span class="product_box_label prdct_name"><? echo $row['product_name'];?></span>
														<span class="product_box_label prdct_price"> <? echo "$".$row['product_price'].".00";?></span>
													</div>
												   <?
												    $sql="SELECT sum(stock)  as stk FROM `product_sizes` where product_id=".$row['id'];
														$productsize=mysql_query($sql);
														if(mysql_num_rows($productsize)){
															$productsize=mysql_fetch_array($productsize);
															 $productsize=$productsize['stk'];
														}else{
															$productsize=0;
														}
												   ?>
														<div class='product_box-desc stock'>
														<?if($productsize>0){
														echo "<span class='product_box_butn bgstock'>In Stock</span>";?>
														<span class='product_box_butn'><input type="submit" value="Add To Cart" id="submit"></span>
													<? }else{
															echo "<span class='product_box_butn outstock'>Out Of Stock</span>";
															}	?>
														<!--<a href='product.php?id=<? echo $row['id'];if($_SESSION['user_type']=='user'){ echo "&host_id=".$host_id;}?>' class='button'>View Detail</a></br>-->
														
														</div>
                                                        </div>
												
												</div>
												
											
												
												</form>									
								<?	}?>
									
<?								}
								
									?>
	
					
