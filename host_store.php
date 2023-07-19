<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

// if($userType == 'club'){
// 	header('Location: index.php');die;
// }

if(!isset($userID)){
	$Obj->Redirect("index.php"); die;
	
}

$titleofpage=" Store";
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

  /******************/

		$id=$_GET['catid'];
		$tbl=$_GET['tbl'];

		if($tbl=='pl1'){
		$tbl="host_category";
		}else if($tbl=='pl2'){
		$tbl="host_category_parent";	
		}else if($tbl=='pl3'){
		$tbl="host_category_parent2";		

		}

if($_SESSION['user_type'] == 'user')
{
	$hostId = $_GET['host_id'];
}
else
{
	if(isset($_GET['host_id']))
	{
		$hostId = $_GET['host_id'];
	}
	else
	{
		$hostId = $_SESSION['user_id'];
	}
	
}
//echo "SELECT * FROM `host_functions_setting` WHERE `host_id` = '$hostId' "; die;
$checkpagestatus = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '$hostId' ");
$countRecords = mysql_num_rows($checkpagestatus);
if($countRecords < 1)
{
	$SETTINGS = "Enable";
}
$respagestatus = @mysql_fetch_array($checkpagestatus);
?>
<a href="javascript:TB_show('Send invitation to friend/faimly for pledge', 'user_pledge_invite.php?user=testuserTB_iframe=true&amp;height=400&amp;width=450', '', './images/trans.gif');"></a>	
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?
		if($respagestatus['store'] == "Disable with message" && $_SESSION['user_type'] == "user" && !isset($_GET['host_id']))
		{
			include('host_left_panel.php');
		}
		elseif($respagestatus['store'] != "Disable with message" )
		{
			include('store_right_bar.php');
		}
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<?php 

					if($respagestatus['store'] == 'Enable' || $_SESSION['user_type'] == "club" || $SETTINGS == "Enable")
					{
						$sql="select category_name as cname from ".$tbl." where id=".$id;
						$catname=mysql_query($sql);
						$catname=mysql_fetch_array($catname);
						if(isset($_GET['catid'])){				
							$catname=$catname['cname'];
						}
						else{
							$catname="Host Store";
						}
				?>
					<h3 id="title">
						<? if($_SESSION['user_type']=='club'){?>
						<? echo $catname;?>
						<?}else{ ?>					
						<?  
						$sql="select club_name as cbname from clubs where id=".$hostId;
								$cbname=mysql_query($sql);
								$cbname=mysql_fetch_array($cbname);
							if(isset($_GET['catid'])){
							
								echo $catname."'s By ".$cbname['cbname'];
							}else{
									echo "Shop  By ".$cbname['cbname'];
							}
								?>
						
				<? } ?></h3>
						<? if($_SESSION['user_type']=='user'){?>
					<div class="exit_store_dev_btn">				
						<span class="exit_store_btn">
					<a class="button btn_add_venu" href="host_profile.php?host_id=<? echo $_GET['host_id']?>">Exit Shop</a>
					</span>
					</div>
					<? } ?>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}if($message['error']!=""){
						echo '<div id="error" class="messagemessage" >'.$message['error']."</div>";
						}?>
						
						<? if($_SESSION['user_type']=='club'){?>
						<div class="btngroup">
						<div class="bttngroup1 m_prdct" style="margin: 0px auto; width: 100%; text-align: center;">				
							<span style="float: right; margin-top:5px; ">
								<a class="button btn_add_venu m_prdct" href="manage_product.php">Manage Product</a>
							</span>
						</div>
								<div class="store_m" style="margin: 0px auto; width: 100%; text-align: center;">				
										<span  class="store_m1" style="float: right; margin-top:5px; ">
										<a class="button btn_add_venu " href="store.php">Store Menu</a>
										</span>
								</div>
					</div>
					<? } ?>
					
					
					<div style="clear:both;"></div>
					<div class="main-store-div" >
	<?
			$catIdString = "";	
			$catIdString2 ="";				
								if(isset($_GET['catid']))
								{			
				$sql="select * from host_product where category_id=".$id." and tbname='".$tbl."' and host_id=".$hostId. " order by id DESC limit 0,9 ";
			}
			else
			{
				$getParentcat = mysql_query("SELECT id FROM `host_category` WHERE `host_id` = '$hostId' ");
				while($fetchParentcat = mysql_fetch_array($getParentcat) )
				{
					$catIdString .= $fetchParentcat['id'].",";
				}

				$NewCatString = rtrim($catIdString,',');


				$getParentcat2 = mysql_query("SELECT id FROM `host_category_parent` WHERE `host_id` = '$hostId' AND  `parent_id` IN (".$NewCatString.")  ");
				while($fetchParentcat2 = mysql_fetch_array($getParentcat2) )
				{
					$catIdString .= $fetchParentcat2['id'].",";
					$catIdString2 .= $fetchParentcat2['id'].",";
				}

				$NewCatString2 = rtrim($catIdString2,',');


				$getParentcat3 = mysql_query("SELECT id FROM `host_category_parent2` WHERE `host_id` = '$hostId' AND  `parent_id` IN (".$NewCatString2.")  ");
				while($fetchParentcat3 = mysql_fetch_array($getParentcat3 ) )
				{
					$catIdString .= $fetchParentcat3['id'].",";
				}

				$NewCatStringfinal = rtrim($catIdString,',');


				$sql="SELECT *  FROM `host_product` WHERE `category_id` IN(".$NewCatStringfinal.") AND `host_id` = '$hostId' ORDER BY id DESC limit 0,9 "	;
			}
								$data=mysql_query($sql);
								if(mysql_num_rows($data)){
									while($row=mysql_fetch_array($data)){
												echo ' <form method="POST" action="cart.php" class="product_cat_form">';?>
												  <input type="hidden" name="product_id" value="<?php echo $row['id'];?>">
												  <input type="hidden" name="host_id" value="<?php echo $hostId;?>">      
												  <input type="hidden" name="price_cart" value="<?php echo $row['product_price'];?>"> 
												  <input type="hidden" name="product_type" value="2"> 
												   <input type="hidden" name="product_qty" value="1"> 
								
												<div class='product_box'>
												
													<div class='product_box-img'>
														<?php 
														$sqlGetImages="select * from product_images where product_id=".$row['id'];
														$getImages = mysql_query($sqlGetImages);
														$fetchImages = mysql_fetch_array($getImages);
														$countImages = mysql_num_rows($getImages);
														if($countImages > 0)
														{
															$imagePath = $fetchImages['path'];
														}
														else
														{
															$imagePath = $row['image_name'];
														}
														?>
														<a href='product.php?id=<? echo $row['id']; if($_SESSION['user_type']=='user'){ echo "&host_id=".$hostId;}?>'>
															<img src='<? echo $imagePath;?>' style='height:200px;width:200px'/>
														</a>

													</div>
													<div class="bottom_prodct">
													<div class='product_box-nameprice'>
														<span class="product_box_label prdct_name"><? echo $row['product_name'];?></span>
														<span class="product_box_label prdct_price">
															<?php
																if(preg_match('/./',$row['product_price'])) {
																  echo "$".$row['product_price'];
																}
																else{
																  echo "$".$row['product_price'].".00";
																}														
															?>
															</span>
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
														<!--<span class='product_box_butn'><input type="submit" value="Add To Cart" id="submit"></span>-->
													<? }else{
															echo "<span class='product_box_butn'>Out Of Stock</span>";
															}	?>
														<!--<a href='product.php?id=<? echo $row['id'];if($_SESSION['user_type']=='user'){ echo "&host_id=".$host_id;}?>' class='button'>View Detail</a></br>-->
														
														</div>
												</div>
												</div>
												
											
												
												</form>									
								<?	}
									
									
								}else{
									echo "No Data to show !";
								}
									?>
									
					
					</div>
			<?
			$item_per_page=9;
			if(isset($_GET['catid'])){
			 $sql="select count(id) as count from host_product where category_id=".$id." and tbname='".$tbl."' and host_id=".$hostId." order by id DESC limit 0,9";
			}else{
				   $sql="select count(id) as count from host_product where category_id in(select id from host_category where host_id=".$hostId. " and status=1 union select id from host_category_parent where host_id=".$hostId. " and status=1 union select id from host_category_parent2 where host_id=".$hostId. " and status=1) ";
			}
			$results = mysql_query($sql);
			$get_total_rows = mysql_fetch_array($results); //total records
			$get_total_rows=$get_total_rows['count'];
			$pages = ceil($get_total_rows/$item_per_page); 
			?>
			<? 


			//create pagination
			$pagination = '';
			if($pages > 1)
			{
			$pagination .= '<ul class="paginate">';
			for($i = 1; $i<=$pages; $i++)
			{
			if($i==1){
			$pagination .= '<li><a  class="paginate_click active" id="'.$i.'-page">'.$i.'</a></li>';
			}else{
			$pagination .= '<li><a  class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
			}
			}
			$pagination .= '</ul>';
			}
			echo $pagination; ?>
			<div id="results"></div>
<?php
					}
					else
					{
						$pagestatus = "0";	
						echo "<div class='nostoreview' >";
						if($respagestatus['store'] == "Disable with message")
						{
							echo "<h1 id='title' style='text-align: center;'>".$respagestatus['message']."</h1>";
						}
						if($respagestatus['store'] == "Disable without message")
						{
							
						}

						echo "</div>";
					}

				?>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript">

$(document).ready(function() {
	$(".paginate_click").on('click',function() {
		id='<? echo $_GET['catid'];?>';
		tbl='<? echo $_GET['tbl'];?>';
		host_id='<? echo $hostId;?>';
		var clicked_id = $(this).attr("id").split("-"); //ID of clicked element, split() to get page number.
		var page_num = parseInt(clicked_id[0]);
		 //clicked_id[0] holds the page number we need 
		$('.paginate_click').removeClass('active'); //remove any active class   
		pg=page_num-1;   
	 $.ajax({
	type: "POST",
	url: "get_product_data.php",
	data:"id="+id+"&tbl="+tbl+"&page="+pg+"&host_id="+host_id,
	success:  function(data){
	  
		jQuery('.main-store-div').html(data);
		  
	 
   
	} });        
		  $(this).addClass('active');  
		return false;
	});
	});
</script>

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
body {
  padding-top: 115px;
}
</style>
<?php include('Footer.php');?>
