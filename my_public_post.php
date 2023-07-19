<?
include("Query.Inc.php");
$Obj = new Query($DBName);

	$del_id = $_GET['id'];
 if($del_id !="")
	{
    	$shoutsql ="DELETE FROM forum WHERE forum_id = $del_id";
	 	$shout_list = mysql_query($shoutsql);
		header('Location: my_public_post.php');
	}
	
	$sql = "select * from `user` where `id` = '".$_SESSION['user_id']."'";
	$userArray = $Obj->select($sql) ; 
	$first_name=$userArray[0]['first_name']; 
	$last_name=$userArray[0]['last_name'];
	$zipcode=$userArray[0]['zipcode'];
	$state=$userArray[0]['state'];
	$country=$userArray[0]['country'];
	if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];
	$city=$userArray[0]['city'];
	$email=$userArray[0]['email'];
	$image_nm=$userArray[0]['image_nm'];
	$phone=$userArray[0]['phone'];
	/**********************************/
	
	
	
$shoutsql="select forum.added_on,forum.forum_id, forum.forum,forum.forum_img,forum.forum_video,forum.status,user.first_name,user.last_name,user.image_nm from forum 
		  LEFT JOIN user ON forum.user_id= user.id 
		  where forum.status ='1' AND forum.user_id=".$_SESSION['user_id']." AND forum.post_from = 'profile' AND forum_type='public' order by forum_id DESC";
 $shout_list = mysql_query($shoutsql);
$totlnumrows=mysql_num_rows($shout_list);
 
	if(count($_POST['shoutschk']) > 0)
		{
			
			   $ids=implode(",",$_POST['shoutschk']); 
			  $sql_del=mysql_query("delete from forum where forum_id IN(".$ids.")");
			  if($sql_del)
			  {	
			  	   $_SESSION['success']="Post deleted successfully";
				  header('location: my_public_post.php'); exit;
			  }
		}
		
   if(isset($_SESSION['success']))
   {
      $success=$_SESSION['success'];
	  unset($_SESSION['success']);
    }
$titleofpage="My Public Post";
	include('header_start.php');
?>

	
<SCRIPT language="javascript">
$(function(){
 $('#selectall').click(function() {
		if ($('#selectall').is(':checked')) {
			$('.others').attr('checked', true);
		} else {
			$('.others').attr('checked', false);
		}
	});
});

function goto(url)
{
  window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
  return false;
}
</SCRIPT>



    <?php 
	include('header.php');
	 ?>
	 <div class="home_wrapper">
	<div class="main_home">
   
		<div class="home_content">
			<div class="home_content_top">
				 
			   <div id="title" class="botmbordr">Manage Profile Posts </div>	
  			<?php if($_SESSION['user_type'] == 'user'){?>
     		<a  class="button addpost" onClick="window.location.href= 'profile.php'"  style="font-size: 14px; float:right;">Add Post</a><?php } ?>
 
     		 <? if(isset($_SESSION['popup_add_post'])){?>
				  <div id="successmessage" style="margin-bottom:6px;"> Post Successfully Added</div> 
				  
			  <?  unset($_SESSION['popup_add_post']); }?>
			  
     		 <? if(isset($_SESSION['popup_update_post'])){?>
				  <div id="successmessage" style="margin-bottom:6px;"> Post Successfully Updated</div> 
				  
			  <?  unset($_SESSION['popup_update_post']); }?> 			  
 
  
       <div id="profile_box">
   <?php if(isset($success)) { echo '<div id="successmessage" class="message" >'.$success.'</div>';} ?>
               <div class="tab_scroll">
<table  class="display" id="example" style="margin-top:10px;" >
<form name="shout_frm" id="shout_frm" method="post">
	<thead>
		<tr bgcolor="#ACD6FE">
		    <th width="120"> <INPUT TYPE=CHECKBOX NAME="all" id="selectall" width="100"> 
        
            <a href="javascript:void(0);" onclick="delete_confirm_all();"> Delete All</a></th>
			<th>Posts</th>
            <th>Added Date</th>
			<th>Action</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
if($totlnumrows){
$shoutsql12 ="select forum.added_on,forum.forum_id, forum.forum,forum.forum_img,forum.forum_video,forum.status,user.first_name,user.last_name,user.image_nm from forum 
		  LEFT JOIN user ON forum.user_id= user.id 
		  where forum.status ='1' AND forum.user_id=".$_SESSION['user_id']." AND post_from = 'profile' AND forum_type='public' order by forum_id DESC";
 $shout_list12 = mysql_query($shoutsql12);
	while($row1 = mysql_fetch_array( $shout_list12))
	{ //echo "<pre> ";print_r($row1);
	?>
		<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
		<td><input type="checkbox" name="shoutschk[]" id="shoutschk" value="<?php echo $row1['forum_id']; ?>" class="others"> </td>
			<td>
			<p>
            <?php echo substr($row1['forum'],0,200); ?> <?php if(strlen($row1['forum']) > 50) { ?>....<?php } ?> <br>
            
            <p>
           </td>
           <td>
           
			<?php echo date('F jS,  Y',strtotime($row1['added_on'])); ?>
			
            
           </td>
			<td  style="width=100px;">
            <a href="javascript:void(0);" onclick="goto('edit_private_post.php?id=<?php echo $row1['forum_id']; ?>')" > <img src="images/Edit.png" width="25px"; height="25px";></a>
            
            &nbsp;<a href="javascript:void(0);" onclick="delrecoreds('<?php echo $row1['forum_id']; ?>');"><img src="images/del.png" width="25px"; height="25px";></a></td>
		</tr>
		<?php
		$i++;
		}}else{?>
<tr>
		<td colspan="4">No posts added yet </td>
			</tr>
<?}
		?>
	</tbody>
	</form>
</table>

<input onclick="location.href = 'profile.php';" type="button" value="Back" class="button button" style="float: right;  margin-top: 10px;">

</div>
</div>

  
  <!-- Grid Code  -->
			</div>
           </div>
					<?php   
                    if(!isset($_GET['id'])){?>
                            <?php include('friend-right-panel.php'); ?>

                     <? }else {  ?>

                            <?php include('friend-profile-panel.php'); ?>

                       <?php } ?>
    </div>
 
    <?php include('footer.php') ?>

<script>
function delete_confirm_all(){
	
	var checked_boxes = $('input.others:checked').length;
	
	if (checked_boxes < 1) {
		alert("Please select atleast one post");
	}else{

	   var r = confirm("Are You Sure Want To Delete !");
	   if (r == true) {
		   $('#shout_frm').submit();
	   }
	}   
}

function addshout()
{
  if($('#shout').val()=="")
  {
	  $('#error_shout').html('Please enter your shout');
	   $('#error_shout').fadeOut(5000);
	  return false;
  }	else
  {
	  
   $('#shout_frm').submit();
 }
}
function Edit_shout()
{
  if($('#shout_edit').val()=="")
  {
	  $('#error_shout').html('Please enter your shout');
	   $('#error_shout').fadeOut(5000);
	  return false;
  }	else
  {
	  
   $('#shout_frm_edit').submit();
 }
}
function editshout(id)
{
 	$.get("getshotdetails.php?id="+id, function( data ) {
		$('#shout_edit').val(data);
		//	window.location='shout.php';
		$("#shout_ac_edit" ).click();
		$("#edit_id" ).val(id);
		});	
}

function delrecoreds(id)
{
  if(confirm('Are You sure You want to delete this record'))
  {
	 $.get( "deletepost.php?id="+id, function( data ) {
			window.location='my_public_post.php';
		});
  }
   else
   {
	
	}

}
</script>
<script type="text/javascript">
	$(document).ready(function() {
			 $('.fancybox').fancybox();
			 
			 });
</script>
