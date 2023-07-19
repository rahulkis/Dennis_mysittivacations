<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}

if(isset($_POST['updateEvent']))
{
	if($_POST['table_from']=='pl1')
	{		
		$sql="UPDATE `host_category` SET `category_name` = '".$_POST['category_name']."', `status` = '".$_POST['status_category']."' WHERE `host_category`.`id` =".$_POST['cat_id'];
		}
		else if($_POST['table_from']=='pl2')
		{
		$sql="UPDATE `host_category_parent` SET `category_name` = '".$_POST['category_name']."', `status` = '".$_POST['status_category']."' WHERE  `id` =".$_POST['cat_id'];	
	}else if($_POST['table_from']=='pl3')
	{
		$sql="UPDATE `host_category_parent2` SET `category_name` = '".$_POST['category_name']."', `status` = '".$_POST['status_category']."' WHERE  `id` =".$_POST['cat_id'];	
	}
	$row=mysql_query($sql);
		$message['success']="Category Successfully updated";
}

$titleofpage=" Manage Category";

if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

if(isset($_GET['id'])) 
{
	if($_GET['id'])
	{
		if($_GET['tbl']=='pl1')
		{
					$sql="select * from host_category_parent where host_id=".$_SESSION['user_id']." and parent_id=".$_GET['id'];			
		}
		else if($_GET['tbl']=='pl2')
		{
				$sql="select * from host_category_parent2 where host_id=".$_SESSION['user_id']." and parent_id=".$_GET['id'];			
		}
 
		$host_category_info=mysql_query($sql);
		$host_category_infox=mysql_query($sql);
		$countinfo = mysql_num_rows($host_category_info);
	}
	else
	{
		$sql="select * from host_category where host_id=".$_SESSION['user_id']." or host_id=0";
		$host_category_info=mysql_query($sql);
		$countinfo= mysql_num_rows($host_category_info);
	}
}
else
{
	$sql="select * from host_category where host_id=".$_SESSION['user_id']." or host_id=0";
	$host_category_info=mysql_query($sql);
	$countinfo = mysql_num_rows($host_category_info);
}
$count_cat_into_all=mysql_query("select (select count(*) as amount from host_category)+(select count(*) as amount from host_category_parent2 where host_id=".$_SESSION['user_id'].") + (select count(*) as amount from host_category_parent where host_id=".$_SESSION['user_id'].") as count_cat_all FROM dual ");
$count_cat_into_all=mysql_fetch_array($count_cat_into_all);


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
						<h3 id="title">Manage Categories</h3>
					<?php 
						if($message['success'] != "")
						{
							echo '<div id="successmessage" style="display=block;" class="message" >'.$message['success']."</div>";
						}
						if(isset($_SESSION['cat_del_succfly']))
						{
							echo '<div id="successmessage" style="display=block;" class="message" >'.$_SESSION['cat_del_succfly'].'</div>';
							unset($_SESSION['cat_del_succfly']);
						} 
					?>
						<div class="top_btns"> 
							<span> 
								<a class="button btn_add_venu" href="store.php">Store Menu</a> 
							</span>
				  	<? 
						$sql="select * from host_category where host_id=".$_SESSION['user_id']." or host_id=0";
						$host_category_infox=mysql_query($sql);
					?>
						  	<span> 
						  		<a class="button btn_add_venu" href="host_category.php">Add Category</a> 
					  		</span> 
				  		</div>
						<div class="load-more"> 
							<span class="new_mnth"> 
								<span id="date_month_venue" class="">Load By Parent Category</span>
							  	<select name="parent_category" id="parent_category" style="width:100%">
									<option value="0" <?if(!isset($_GET['id'])){echo "selected=''selected'";}?>> All </option>
					<?
									while($row= mysql_fetch_array($host_category_infox))
									{
					?>
										<option  style="font-weight:bold;" value="<? echo $row['id']."-"."host_category"; ?>" <? if($row['id']==$_GET['id'] && $_GET['tbl']=='pl1'){echo "selected=''selected'";} ?>><? echo $row['category_name']; ?></option>
					<? 
									$sql="select * from host_category_parent where parent_id=".$row['id'];
									$host_category_infox2=mysql_query($sql);
									$countinfox2=mysql_num_rows($host_category_infox2);
										if($countinfox2)
										{
											while($rows= mysql_fetch_array($host_category_infox2))
											{
							?>
											<option value="<? echo $rows['id']."-"."host_category_parent"; ?>" <? if($rows['id']==$_GET['id'] && $_GET['tbl']=='pl2'){echo "selected=''selected'";} ?>><? echo $rows['category_name']; ?></option>
							<?				}
										}
									}
						?>
							  	</select>
						  	</span> 
						</div>
				<? 
				if($countinfo)
				{
					if($count_cat_into_all['count_cat_all']>15)
					{
				?>		
						<div class=" ">
				<?	}
					else
					{
				?>		<div>
				<?
					}
				?>
							<div class="autoscroll">
							  	<table id="example" class="display loadmusic" >
									<thead>
								  		<tr bgcolor="#ACD6FE">
											<th>Category Name</th>
											<?if(!isset($_GET['id'])) {?>
											<th>Parent Category</th>
											<? } ?>
											<th>Status</th>
											<th>Products</th>
											<th>Action</th>
								  		</tr>
									</thead>
									<tbody>
									  <? while($data=mysql_fetch_array($host_category_info)){
												?>
									  <tr>
										<td title="Click on the text to edit" style="cursor: pointer;" id="cat_nm_pl1_<?php echo $data ['id']; ?>" onclick="update_cat_name('<?php echo $data ['id']; ?>', 'pl1');">

											<p id="categ_name_pl1_<?php echo $data ['id']; ?>"><? echo $data ['category_name'];?></p>
											<input onkeydown="javascript:return submit_cat_name(event,'<?php echo $data ['id'];?>', 'pl1');" style="float: left; width: 100%; display: none;" type="text" id="cat_nm_val_pl1_<?php echo $data ['id']; ?>" value="<? echo $data ['category_name'];?>">
										</td>
										<?if(!isset($_GET['id'])) {?>
										<td><? echo "ROOT";?></td>
										<? } ?>
										<td>
											<select onchange="get_cat_values(this.value , <?php echo $data ['id']; ?> , 'pl1');">
												<option <?php if($data ['status']=='1'){ echo "selected"; } ?> value="1">Active</option>
												<option <?php if($data ['status']=='0'){ echo "selected"; } ?> value="0">In-active</option>
											</select>
										<?php
										//if($data ['status']=='0')
										//echo "In-active";
										//if($data ['status']=='1')
										//echo "Active";
										?>
										</td>
										<td>
										<?php
											$sql = "SELECT count(id) as count FROM `host_product` where category_id = '".$data['id']."' AND tbname = 'host_category' AND host_id = '".$_SESSION['user_id']."'";
											$host_product_count = mysql_query($sql);
											$host_product_count = mysql_fetch_array($host_product_count);
											
												echo $host_product_count['count'];
											 ?>
										</td>
										<td>
										<?php
										//if(!isset($_GET['id'])){
										//					$ids="pl1";
										//				} else{
										//					if($_GET['tbl']=='pl1'){
										//					$ids="pl2";
										//				    }else if($_GET['tbl']=='pl2'){
										//					$ids="pl3";
										//				}else{
										//					$ids="pl1";
										//				}
										//				
										//				 } 
														 //if($data['id']!=1 && $data['id']!=2){?>
										  <!--<a href="edit_category.php?<? echo $ids; ?>=<? echo $data ['id'];?>"> <img width="25px" height="25px" title="Edit" src="images/Edit.png"> </a>-->
										  <a onClick="delrecoreds('<?php echo $data['id']; ?>','pl1');" > <img width="25px" height="25px" title="Delete" src="images/del.png"> </a>
										  <? //} ?></td>
									  </tr>
									  <?}?>
									  <? // get data from child catgeory  table
												if(!isset($_GET['id'])){
													$sql="SELECT host_category_parent.* ,host_category.category_name as parent_category_name FROM `host_category_parent` join host_category on host_category_parent.host_id=".$_SESSION['user_id']." and host_category_parent.parent_id=host_category.id ";
													$host_category_info=mysql_query($sql);
													$countinfo=		 mysql_num_rows($host_category_info);
													
													?>
									  <? while($data=mysql_fetch_array($host_category_info)){
												?>
									  <tr>
										<td title="Click on the text to edit" style="cursor: pointer;" id="cat_nm_pl2_<?php echo $data ['id']; ?>" onclick="update_cat_name('<?php echo $data ['id']; ?>', 'pl2');">

											<p id="categ_name_pl2_<?php echo $data ['id']; ?>"><? echo $data ['category_name'];?></p>
											<input onkeydown="javascript:return submit_cat_name(event,'<?php echo $data ['id'];?>', 'pl2');" style="float: left; width: 100%; display: none;" type="text" id="cat_nm_val_pl2_<?php echo $data ['id']; ?>" value="<? echo $data ['category_name'];?>">
										</td>
										
										<?if(!isset($_GET['id'])) {?>
										<td><? echo $data ['parent_category_name'];?></td>
										<? } ?>
										<td>
											<select onchange="get_cat_values(this.value , <?php echo $data ['id']; ?> , 'pl2');">
												<option <?php if($data ['status']=='1'){ echo "selected"; } ?> value="1">Active</option>
												<option <?php if($data ['status']=='0'){ echo "selected"; } ?> value="0">In-active</option>
											</select>
											
										<?php
										//if($data ['status']=='0')
										//	echo "In-active";
										//	if($data ['status']=='1')
										//	echo "Active";
										?>
										</td>
										<td><?php $sql = "SELECT count(id) as count FROM `host_product` where category_id = '".$data['id']."' AND tbname = 'host_category_parent' AND host_id = '".$_SESSION['user_id']."'";
														$host_product_count=mysql_query($sql);
														$host_product_count= mysql_fetch_array($host_product_count);
														
														
														echo $host_product_count['count'];
														 ?></td>
										<td>
											<!--<a href="edit_category.php?pl2=<? echo $data ['id'];?>"> <img width="25px" height="25px" title="Edit" src="images/Edit.png"> </a>-->
											<a onClick="delrecoreds('<?php echo $data['id']; ?>','pl2');" > <img width="25px" height="25px" title="Delete" src="images/del.png"> </a></td>
									  </tr>
									  <? }} ?>
									  <? // get data from child catgeory  table
												if(!isset($_GET['id'])){
													$sql="SELECT host_category_parent2.* ,host_category_parent.category_name as parent_category_name FROM `host_category_parent2` join host_category_parent on host_category_parent2.host_id=".$_SESSION['user_id']." and host_category_parent2.parent_id=host_category_parent.id ";
													$host_category_info=mysql_query($sql);
													$countinfo=		 mysql_num_rows($host_category_info);
													
													?>
									  <? while($data=mysql_fetch_array($host_category_info)){
												?>
									  <tr>
										<td title="Click on the text to edit" style="cursor: pointer;" id="cat_nm_pl3_<?php echo $data ['id']; ?>" onclick="update_cat_name('<?php echo $data ['id']; ?>', 'pl3');">

											<p id="categ_name_pl3_<?php echo $data ['id']; ?>"><? echo $data ['category_name'];?></p>
											<input onkeydown="javascript:return submit_cat_name(event,'<?php echo $data ['id'];?>', 'pl3');" style="float: left; width: 100%; display: none;" type="text" id="cat_nm_val_pl3_<?php echo $data ['id']; ?>" value="<? echo $data ['category_name'];?>">
										</td>
										<?if(!isset($_GET['id'])) {?>
										<td><? echo $data ['parent_category_name'];?></td>
										<? } ?>
										<td>
											<select onchange="get_cat_values(this.value , <?php echo $data ['id']; ?> , 'pl3');">
												<option <?php if($data ['status']=='1'){ echo "selected"; } ?> value="1">Active</option>
												<option <?php if($data ['status']=='0'){ echo "selected"; } ?> value="0">In-active</option>
											</select>					
										</td>
										<td><?php $sql = "SELECT count(id) as count FROM `host_product` where category_id = '".$data['id']."' AND tbname = 'host_category_parent2' AND host_id = '".$_SESSION['user_id']."'";
														$host_product_count=mysql_query($sql);
														$host_product_count= mysql_fetch_array($host_product_count);
														
														echo $host_product_count['count'];
														 ?></td>
										<td>
											<!--<a href="edit_category.php?pl3=<? echo $data ['id'];?>"> <img width="25px" height="25px" title="Edit" src="images/Edit.png"> </a>-->
											<a onClick="delrecoreds('<?php echo $data['id']; ?>','pl3');" > <img width="25px" height="25px" title="Delete" src="images/del.png"> </a></td>
									  </tr>
									  <? }} ?>
									</tbody>
							  	</table>
							</div>
						  </div>
						  <? } else{?>
						  <div class="tbl_cover" style="float:left;">
							<table id="example" class="display loadmusic" style="margin-top:10px;">
							  <thead>
								<tr bgcolor="#ACD6FE">
								  <th>Category Name</th>
								  <?if(!isset($_GET['id'])) {?>
								  <th>Parent Category</th>
								  <? } ?>
								  <th>Status</th>
								  <th>products</th>
								  <th>action</th>
								</tr>
							  </thead>
							  <tbody>
								<tr>
								  <td  colspan="5"><?if($_SESSION['user_type']=='user'){
										 echo "No info to show ";
										 }if($_SESSION['user_type']=='club'){
										 echo "No category created by you.<a href='host_category.php'>create category</a> ";
										 }?></td>
								</tr>
							  </tbody>
							</table>
						  </div>
						  <?}?>
					</div>
				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">

function delrecoreds(id,tabl)
{
  if(confirm('If you delete this all child category and  all product  in this category and child category will be deleted.Are You sure You want to delete this record'))
  {
	  
	 $.get( "deletecategory.php?id="+id+"&tbl="+tabl, function( data ) {
		window.location='manage_category.php';
		});
  }
   else
   {
	
	}

}

function update_cat_name(id, table_type){

	$('#categ_name_'+table_type+'_'+id).hide();
	$('#cat_nm_val_'+table_type+'_'+id).show();
	
}

function submit_cat_name(event,id, table)
{
  if(event.keyCode == 13){
		//$("#cat_nm_val_"+id).attr('disabled','disabled');  
		  update_categoryname(id, table);
  }
}

function update_categoryname(id, table){
	
	if (table == "pl1") {
		var table_name = "host_category";
		
	}else if (table == "pl2") {
		var table_name = "host_category_parent";
		
	}else{
		var table_name = "host_category_parent2";
		
	}
	
	var cat_new_value = $('#cat_nm_val_'+table+'_'+id).val();
	
	$('#cat_nm_val_'+table+'_'+id).hide();
	$('#categ_name_'+table+'_'+id).html(cat_new_value);
	$('#categ_name_'+table+'_'+id).show();
	
		$.post('ajaxcall.php', {'store_category_id' :id, 'store_category_name' :cat_new_value, 'category_tb_name' :table_name }, function(response){
			
			alert("Category Name Updated Successfully");
			
		});
	
}

function get_cat_values(val, id, table){

	if (table == "pl1") {
		var table_name = "host_category";
		
	}else if (table == "pl2") {
		var table_name = "host_category_parent";
		
	}else{
		var table_name = "host_category_parent2";
		
	}
	
	var cat_status_value = val;
	
		$.post('ajaxcall.php', {'store_category_id' :id, 'store_status_value' :cat_status_value, 'category_tb_name' :table_name }, function(response){
			
			alert("Category Status Updated Successfully");
			
		});
	
}

$(document).ready(function(){
	
	$('#parent_category').on('change',function(){
	 var asd=$(this).val().split('-');	
		if(asd[0]>0){
			url=asd[0];
			if(asd[1]=="host_category"){
				window.location='manage_category.php?id='+url+'&tbl=pl1';				
			}else{
				window.location='manage_category.php?id='+url+'&tbl=pl2';				
			}
		
	}else{
		window.location='manage_category.php';	}
		
		});	
});
</script> 
<?php include('Footer.php');?>