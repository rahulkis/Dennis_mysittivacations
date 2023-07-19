<?php
session_start();

include("Query.Inc.php");

$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}
if(!isset($_GET['pl2']) && !isset($_GET['pl1']) && !isset($_GET['pl3'])){
	$Obj->Redirect("login.php");
	$tablefrom="pl2";
}else{
	if(isset($_GET['pl3'])){
		 $sql="SELECT host_category_parent2.* ,host_category_parent.category_name as parent_category_name FROM `host_category_parent2` join host_category_parent on host_category_parent2.parent_id=host_category_parent.id  and host_category_parent2.id=".$_GET['pl3'];	
		$catIds=$_GET['pl3'];$tablefrom="pl3";
	 
	}
	if(isset($_GET['pl2'])){
		 $sql="SELECT host_category_parent.* ,host_category.category_name as parent_category_name FROM `host_category_parent` join host_category on host_category_parent.parent_id=host_category.id  and host_category_parent.id=".$_GET['pl2'];	
	 $catIds=$_GET['pl2'];$tablefrom="pl2";
	} 
	if(isset($_GET['pl1'])){
		/*if($_GET['pl1']==1 && $_GET['pl1']==2){
			$Obj->Redirect("manage_category.php");
		}*/
		$tablefrom="pl1";
	 $sql="select * from host_category where host_id=".$_SESSION['user_id']." and id=".$_GET['pl1'];	
	$catIds=$_GET['pl1'];	
	} 
	
$host_category_info=mysql_query($sql);
 $countinfo=mysql_num_rows($host_category_info);
$host_category_info=mysql_fetch_array($host_category_info);


if(!$countinfo){
	//$Obj->Redirect("manage_category.php");
	die;
}
}

$titleofpage="Edit Category";

include('header_start.php');
include('header.php');
include('headerhost.php');
?>
<?
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

<script src='js/jqueryvalidationforsignup.js'></script>
<script src="js/register.js" type="text/javascript"></script> 
<a href="javascript:TB_show('Send invitation to friend/faimly for pledge', 'user_pledge_invite.php?user=testuserTB_iframe=true&amp;height=400&amp;width=450', '', './images/trans.gif');"></a>	
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Edit Category</h2>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
					} 

					?>
					<div style="margin: 0px auto; width: 100%; text-align: center;">				
						<span style="float: right; margin-top:5px; ">
					<a class="button btn_add_venu" href="store.php">Shop</a>
					</span>
					</div>
					<form method="POST" name="frmhostcat" id="frmhostcat" action="manage_category.php" enctype="multipart/form-data" class="musicadd">

					
					<div class="row">
					<span class="label lbl">Category Name<font color='red'>*</font></span>
					<span class="formw">

					<input type="text" name="category_name" id="category_name" required value="<? echo $host_category_info['category_name'] ;?>" /><br />
					</span>
					</div>
                    <div class="row">
					<div class="label lb2">Parent Name</div>
					<div class="Parent">
						
<? if(isset($_GET['pl1'])){echo "Root";}else{  echo $host_category_info['parent_category_name']; }?>
					<!--<input type="text" name="Parent_name" id="parent_name" required value="<?  echo $host_category_info['parent_category_name']; ?>" /><br />-->
					</div>
					</div>
					
					 <div class="row">
					<span class="label">Status</span>
					<span class="formw">
						<select name="status_category">
								  <option value="">
										Select Category Status
									 </option>
									 <option value="1" <? if($host_category_info['status']){echo 'selected="selected"';}?>>
										Active
									 </option>
									 <option value="0" <? if(!$host_category_info['status']){echo 'selected="selected"';}?>>
										 In-active
									 </option>
							 </select>
					</span>
					</div>
                    
					
                    
                    <ul class="btncenter_new">
                    <li><input type="hidden" name="row_id" id="row_id" value="<? if($_GET['edit']) echo $_GET['edit']; ?>">
					<input type="submit" class="button addfrmbutton"  name="updateEvent" id="updateEvent" value="Update"></li>
                  	<li><input type="button" class="button addfrmbutton" name="cancel" id="cancel" value="Cancel" onClick="cancelEdit()"></li>
                    </ul>
                    
                    
                    
                    <input type="hidden" name="table_from" value="<?php echo $tablefrom;?>" />
					<input type="hidden" name="cat_id" value="<?php echo $catIds;?>" />



					</form>
					

		 </div>
		 

 </div>
 <?
/*
if($_SESSION['user_type'] != 'user')
    		{
    			include('club-right-panel.php');
    		}
    		else
    		{
    			 include('friend-right-panel.php');
    		}*/

?>
 <?  include('store_right_bar.php');?>  
  </div>
</div>
<?
include('footer.php');
?>

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
 function cancelEdit(){
   window.location='manage_category.php'
 }
</script>
