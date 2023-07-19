<?
include("Query.Inc.php");

$Obj = new Query($DBName);
//echo $_REQUEST['page'];
$f=7*$_REQUEST['page'];


$sql="SELECT host_product.*,host_category.category_name FROM `host_product` join host_category on host_product.host_id=".$_SESSION['user_id']." and host_category.id=host_product.category_id  limit ".$f.",7";

$host_product_info=mysql_query($sql);
$countinfo=		 @mysql_num_rows($host_product_info);
?>
        
					<? while($data=mysql_fetch_array($host_product_info)){?>
						<tr>
							<td>
							<? echo $data ['product_name'];?>
							</td>
							<?if(!isset($_GET['id'])) {?>					
							<!--<td>
							<? echo $data ['category_name'];?>
							</td>
							<? } ?>-->
							<td>
							<? echo $data ['product_price'];?>
							</td>
							<!--<td>
							<? echo $data ['product_stock'];?>
							</td>-->
							<td>
								<a href="edit_product.php?id=<? echo $data ['id'];?>">
									<img width="25px" height="25px" title="Edit" src="images/Edit.png">
                                 </a>
								<a onClick="delrecoreds('<?php echo $data['id']; ?>');" >
								<img width="25px" height="25px" title="Delete" src="images/del.png">
								</a>
							</td>
						</tr>
					<? }?>
	
					
