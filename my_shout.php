<?
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

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
	
	
 //$shoutsql="select * from shouts where user_id='".$_SESSION['user_id']."'";



	if(count($_POST['shoutschk']) > 0)
		{
			
			   $ids=implode(",",$_POST['shoutschk']); 
			  $sql_del=mysql_query("delete from shouts where id IN(".$ids.")");
			  if($sql_del)
			  {	
		  	   	$_SESSION['success']="Shouts deleted successfully";
			  	header('location:my_shout.php?msg=deleted'); exit;
			  }
		}
		
   if(isset($_SESSION['success']))
   {
      $success=$_SESSION['success'];
	  unset($_SESSION['success']);
    }
    include('header_start.php');
?>

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
<script type="text/javascript">
function confirmdelete()
{
	if ($("#shout_frm input:checkbox:checked").length > 0)
	{
	    // any one is checked
	    	var test = confirm('Are you sure you want delete selected records?');
		if(test == true)
		{
			$('#shout_frm').submit();
		}
	}
	else
	{
	   // none is checked
	   	alert('Please select atleast one record!');
	   	return false;
	}
	
}

</script>
	<?php include('header.php') ;?>
<div class="home_wrapper">
  <div class="main_home">
   <div class="home_content">
 <div class="home_content_bottom">
       <div id="title" class="botmbordr">Shouts page </div>
	 

<div id="middle" style="width:700px;" >
   <?php if(isset($success)) { ?> <div class="successmessage" style="color:#060;margin-bottom:0px;"><?php echo $success ?></div> <?php } ?>
   <form name="shout_frm" id="shout_frm" method="post">
<table  class="display" id="example" style="margin-top:10px;" >

	<thead>
		<tr style="background-color:rgb(254, 205, 7);">
		    <th width="120"><INPUT TYPE=CHECKBOX NAME="all" id="selectall" width="100"> 
         
            <a href="javascript:void(0);" onclick="confirmdelete();"> Delte All</a></th>
			<th width="45%">Shouts</th>
            <th>Added Date</th>
			<th>Action</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
 	$shout_list = @mysql_query("SELECT * FROM shouts WHERE `user_id` = '".$userID."' ");
	while($row1 = @mysql_fetch_array($shout_list))
	{
		//echo "<pre>"; print_r($row1); die;
	?>
		<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
		<td><input type="checkbox" name="shoutschk[]" id="shoutschk" value="<?php echo $row1['id']; ?>" class="others"> </td>
			<td>
			<p>
            <?php echo substr($row1['shout'],0,200); ?> <?php if(strlen($row1['shout']) > 50) { ?>....<?php } ?> <br>
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
	
</table>
</form>
</div>	
</div>
  </div>
  <!-- Grid Code  -->
           
					<?php   
                    if(!isset($_REQUEST['id'])){?>  
                            <?php include('friend-right-panel.php'); ?>

                     <? }else {  ?>
          <?php include('friend-profile-panel.php'); ?>

                       <?php } ?>

   </div>
    <?php include('footer.php') ?>
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
