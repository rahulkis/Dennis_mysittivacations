<?
include("Query.Inc.php");
$Obj = new Query($DBName);

	$del_id = $_GET['id'];
 if($del_id !="")
	{
    $shoutsql ="DELETE FROM shouts WHERE shout_id = $del_id";
	 $shout_list = mysql_query($shoutsql);
	 header('Location: my_shout.php');
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
	
	
	
 $shoutsql="select forum.forum_id, forum.forum,forum.forum_img,forum.forum_video,forum.status,user.first_name,user.last_name,user.image_nm from forum 
		  LEFT JOIN user ON forum.user_id= user.id 
		  where forum.status ='1' AND forum.user_id=".$UserID."  AND forum_type!='regular' order by forum_id DESC";
 $shout_list = mysql_query($shoutsql);
 
	if(count($_POST['shoutschk']) > 0)
		{
			
			   $ids=implode(",",$_POST['shoutschk']); 
			  $sql_del=mysql_query("delete from shouts where id IN(".$ids.")");
			  if($sql_del)
			  {	
			  	   $_SESSION['success']="Shouts deleted successfully";
				  header('location:shout.php'); exit;
			  }
		}
		
   if(isset($_SESSION['success']))
   {
      $success=$_SESSION['success'];
	  unset($_SESSION['success']);
    }
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css" title="currentStyle">
			@import "css/demo_page.css";
			@import "css/demo_table.css";
			
		</style>
	

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Shout </title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
	
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



</head>

<body>
<div id="main">
    <div class="container">
    <?php include('header.php') ;
	?>
    <div id="wrapper" class="space">
       <div id="title">Shouts page </div>
	 
  <div class="profileleft">
					<?php   
                    if(!isset($_REQUEST['id'])){?>
                              <div class="prfile-panel">
                            <?php include('friend-right-panel.php'); ?>
                       		</div>
                     <? }else {  ?>
                      <div class="prfile-panel">
                            <?php include('friend-profile-panel.php'); ?>
                       		</div>
                       <?php } ?>
                </div>
<div id="middle" style="width:700px;" >
   <?php if(isset($success)) { ?> <div style="color:#060"><?php echo $success ?></div> <?php } ?>
<table  class="display" id="example" style="margin-top:10px;" >
<form name="shout_frm" id="shout_frm" method="post">
	<thead>
		<tr bgcolor="#CCCCCC">
		    <th width="120"><INPUT TYPE=CHECKBOX NAME="all" id="selectall" width="100"> 
         
            <a href="javascript:void(0);" onclick="javascript:$('#shout_frm').submit();"> Delte All</a></th>
			<th>Shouts</th>
            <th>Added Date</th>
			<th>Action</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	while($row1 = mysql_fetch_array( $shout_list))
	{
	?>
		<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
		<td><input type="checkbox" name="shoutschk[]" id="shoutschk" value="<?php echo $row1['id']; ?>" class="others"> </td>
			<td>
			<p>
            <?php echo substr($row1['forum'],0,200); ?> <?php if(strlen($row1['forum']) > 50) { ?>....<?php } ?> <br>
            <?php if(strlen($row1['shout']) > 50) { ?>
            <a   href="javascript:void(0);"  onclick="goto('readshout.php?id=<?php echo $row1['id']; ?>')" style="color:red;">read more...</a>
            <?php } ?>
            <p>
           </td>
           <td>
           
			<?php echo  date('F jS  Y',strtotime($row1['added_date'])); ?>
			
            
           </td>
			<td  style="width=100px;">
            <a href="edit_user_shout.php?id=<?php echo $row1['id']; ?>" > <img src="images/Edit.png" width="25px"; height="25px";></a>
            
            &nbsp;<a href="javascript:void(0);" onclick="delrecoreds('<?php echo $row1['id']; ?>');"><img src="images/del.png" width="25px"; height="25px";></a></td>
		</tr>
		<?php
		$i++;
		}
		?>
	</tbody>
	</form>
</table>
</div>	
  
  <!-- Grid Code  -->
  
    
    </div>
    <?php include('footer.php') ?>
</div>

</body>

</html>
<script>
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
	 $.get( "deleteshout.php?id="+id, function( data ) {
			window.location='shout.php';
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