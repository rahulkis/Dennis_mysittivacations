<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
}
if(isset($_POST['create_category']))
{
	$userId=$_SESSION['user_id'];		
	$catname=mysql_real_escape_string($_POST['category_name']);
	$catstatus=$_POST['status_category'];
	
	if($_POST['category_type']=='root')
	{
		$sql="INSERT INTO `host_category` (`id`, `host_id`, `category_name`, `status`, `created_date`) VALUES (NULL,'$userId', '$catname', '$catstatus', now());";
		$row=mysql_query($sql);
		$last_isert_id=mysql_insert_id();
	}
	else
	{
		if($_POST['category_type']=='child')
		{
			$parentcat=$_POST['parent_category'];
			$parentcat=explode("-",$parentcat)	;
			if($parentcat[1]=="host_category")
			{
				$sql="INSERT INTO `host_category_parent` (`id`, `host_id`, `category_name`, `status`, `parent_id`, `created_date`) VALUES (NULL,'$userId', '$catname', '$catstatus', '$parentcat[0]', now());";	
			}
			elseif($parentcat[1]=="host_category_parent")
			{
 				$sql="INSERT INTO `host_category_parent2` (`id`, `host_id`, `category_name`, `status`, `parent_id`, `created_date`) VALUES (NULL,'$userId', '$catname', '$catstatus', '$parentcat[0]', now());";	
			}
			$row=mysql_query($sql);
			$last_isert_id=mysql_insert_id();
		}
  	}
  	$message['success']="Category has been successfully created ";
}

$host_category_info_cat= mysql_query("select * from host_category where host_id=".$_SESSION['user_id']." or host_id=0");
$countinfo= mysql_num_rows($host_category_info_cat);

$titleofpage="Create Category";

if(isset($_GET['host_id']))
{
	include('LoginHeader.php');
}
else
{
	include('HeaderHost.php');	
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
  						<h3 id="title">Create Category</h3>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}?>
					<div style="margin: 0px auto; width: 100%; text-align: center;">				
						<span style="float: right; margin-top:5px; ">
					<a class="button btn_add_venu" href="manage_category.php">Manage Category</a>
					</span>
					</div><div style="margin: 0px auto; width: 100%; text-align: center;">				
						<span style="float: right; margin-top:5px; ">
					<a class="button btn_add_venu" href="store.php">Store Menu</a>
					</span>
					</div>
					<form method="POST" action="" name="frmhostcat" id="frmhostcat">
					<div class="row">
					<span class="label">Category Type<font color='red'>*</font></span>
					<span class="formw">
					   
						
						 <? if(mysql_num_rows($host_category_info_cat) > 0){?>
						  <input required type="radio" class="inp5" value="root" onclick="$('.parent_cate').hide()"  name="category_type">Parent Category
						 <input checked  required type="radio" class="inp5" value="child"  name="category_type" onclick="$('.parent_cate').show()">Sub Category
						 <? }else{?>
						  <input required type="radio" class="inp5" value="root" name="category_type">Root
						 <? } ?>
					<br />
					</span>
					
					</div>
					 <? if(mysql_num_rows($host_category_info_cat) > 0){?>
					<div class="row parent_cate">
					<span class="label">Parent Category<font color='red'>*</font></span>
					<span class="formw">
						 <select name="parent_category">
								 <option value="">
								Select Parent Category
								 </option>
								<? while($row= mysql_fetch_array($host_category_info_cat)){?>
									
									<option value="<? echo $row['id']."-"."host_category"; ?>" style="font-weight:bold;"><? echo $row['category_name']; ?></option>
										  <? 									
									$host_category_info_cat_parent=mysql_query("select * from host_category_parent where host_id=".$_SESSION['user_id']." and parent_id=".$row['id']);
									$countinfoparent=		 mysql_num_rows($host_category_info_cat_parent);
									if($countinfoparent){
									while($row= mysql_fetch_array($host_category_info_cat_parent)){?>
									
									<option value="<? echo $row['id']."-"."host_category_parent"; ?>"><? echo $row['category_name']; ?></option>
									
									<?}}?>
									<?}?>
									
						 </select>
					<br />
					</span>
					</div>
					<? } ?>
					<div class="row">
					<span class="label">Category Name<font color='red'>*</font></span>
					<span class="formw">
					   
						 <input required type="text" class="inp5" name="category_name">
						
					<br />
					</span>
					</div>
					  <div class="row">
					<span class="label">Category Status<font color='red'>*</font></span>
					<span class="formw">
					   
						 <select name="status_category">
							  <option value="">
									Select Category Status
								 </option>
								 <option value="1">
									Active
								 </option>
								 <option value="0">
									 In-active
								 </option>
						 </select>
						
					<br />
					</span>
					</div>
				
					
					<div class="btncenter">
						
					</div>
					
					<ul class="btncenter_new">
				<li><input value="Create Category" style="" type="submit" class="button" name="create_category"></li>
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


<?php include('Footer.php');?>



