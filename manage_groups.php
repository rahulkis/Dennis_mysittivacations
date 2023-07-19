<?
include("Query.Inc.php");
$Obj = new Query($DBName);

	$del_id = $_GET['id'];
 if($del_id !="")
	{
    echo $shoutsql ="DELETE FROM chat_groups WHERE id = $del_id";
	// $shout_list = mysql_query($shoutsql);
	 //header('Location: manage_groups.php');
	}
	
	 $cnd="cg.city_id='".$_SESSION['usercity']."' AND cg.group_type='public' AND cug.user_id='".$_SESSION['user_id']."'";
 $shoutsql="SELECT capital_city.city_name, user.first_name,user.last_name,user.image_nm ,chat_groups.id,chat_groups.create_by, chat_groups.group_name ,chat_groups.group_desc FROM `chat_groups` join user on chat_groups.group_type='public' and chat_groups.create_by=user.id join capital_city on chat_groups.city_id=capital_city.city_id ";
 $group_list = mysql_query($shoutsql);
// $row1 = mysql_fetch_array( $group_list);
 //echo "<pre>"; print_r($row1); exit;
	if(count($_POST['shoutschk']) > 0)
		{
			  $ids=implode(",",$_POST['shoutschk']);
			  
			  $sql="delete from chat_groups where id IN (".$ids.") and create_by=".$_SESSION['user_id'];
			  mysql_query($sql);			  

			  $sql_del=mysql_query("delete from  chat_users_groups where user_id='".$_SESSION['user_id']."' AND  group_id IN(".$ids.")");

			  if($sql_del)
			  {	
			  	   $_SESSION['success']="Groups Removed successfully";
				  header('location:manage_groups.php'); exit;
			  }
		}
		
   if(isset($_SESSION['success']))
   {
     $success=$_SESSION['success'];
	  
    }
	
?>


<style type="text/css" title="currentStyle">
			@import "css/demo_page.css";
			@import "css/demo_table.css";
			
.managegrouppage table th {
padding: 0 5px 3px 0 !important;
font-size: 13px !important;
}

			
		</style>
	

    <?php
 $titleofpage="Public Chat Groups";
    	include('header_start.php');
     include('header.php') ;
	?>
	 <div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
       <div id="title" class="botmbordr">Public Chat Groups </div>
	 
    <!-- Grid Code  -->

  <!--  <input type="button" data-toggle="modal" data-target="#myModal" id="shout_ac" name="shout_ac" value="ADD- SHOUT" />
     <input type="button" data-toggle="modal" data-target="#edit_myModal" id="shout_ac_edit" name="shout_ac_edit" value="ADD- SHOUT" style="display:none;" />-->

 
<div id="demosss" class="managegrouppage">
   <?php if(isset($_SESSION['success'])) {  echo '<div id="successmessage" style="display:block;" class="message" >Group successfully deleted</div>';
unset($_SESSION['success']) ;} ?>
<div class="autoscroll">
	   <span>  <a class="button" style="float:right !important" href="javascript:void(0);" onclick="remove_group()">Remove Groups</a></span>
	   <form name="shout_frm" id="shout_frm" method="post">	   
 
	   <table  class="display" id="example" style="margin-top:10px;" >

	<thead>
		<tr bgcolor="#CCCCCC">
        <th class="w20"><INPUT TYPE=CHECKBOX NAME="all" id="selectall" width="100"> </th>
            <th>Created By</th>
			<th>Group Name</th>
            <th>About Group</th>
            <th>City</th>
            <th>Members </th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	while($row1 = mysql_fetch_array( $group_list)) { 
	 $sql_cnt_friends=mysql_query("select count(user_id) as tot_mem from chat_users_groups  where 	group_id='".$row1['id']."'");
	 $tot_mem=@mysql_fetch_assoc($sql_cnt_friends);
	?>
        
		<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
        <td>
			<?if($_SESSION['user_id']==$row1['create_by']){ ?>
		<input type="checkbox" name="shoutschk[]"  value="<?php echo $row1['id']; ?>" class="others">
		<? } ?>
        </td>
        <td>
         <?php  if($row1['image_nm']!="") {?>
          <img src="<?php echo $row1['image_nm']; ?>" width="100" height="100">
          <?php }else { ?>
           <img src="images/no_image.jpg" height="100" width="100">
           <?php } ?><br>
           <a href="profile.php?id=<?php echo $row1['create_by'] ?>" target="_blank"><?php echo $row1['first_name']." ".$row1['last_name']; ?></a>
         </td>
			<td><p><?php echo $row1['group_name']; ?><p> </td>
            <td><p><?php echo $row1['group_desc']; ?><p> </td>
           <td><?php echo $row1['city_name'];?></td>
           <td><?php echo $tot_mem['tot_mem']; ?> </td>
			<td  style="width=100px;">
            <?php if($_SESSION['user_id']==$row1['create_by']){ ?>
            <a href="javascript:void(0);" onClick="javascript:void window.open('add_group.php?id=<?php echo $row1['id']; ?>','','width=500,height=500,resizable=false,left=0,top=0');return false;" > <img src="images/Edit.png" width="25px"; height="25px";></a>
            &nbsp;<a href="javascript:void(0);" onclick="delrecoreds('<?php echo $row1['id']; ?>');">
            <img src="images/del.png" width="25px"; height="25px";></a>
            <?php } ?>
             &nbsp; <a href="javascript:void(0);" onClick="javascript:void window.open('group-chat/index.php?gr_id=<?php echo $row1['id']; ?>','','width=700,height=500,resizable=false,left=0,top=0');return false;" style="float:left;margin-left:15%;"> View Group </a>
            
            </td>
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
  <!-- Grid Code  -->
    </div>
    </div>	
	
	<?php 
		if($_SESSION['user_type'] == 'user')
		{
			include('friend-right-panel.php'); 
		}
		else
		{
			include('club-right-panel.php'); 	
		}
	?>
	
    </div>	
    </div>	
    <?php include('footer.php'); ?>
<script>
$(document).ready(function() {
$('#selectall').click(function(event) {  //on click
    if(this.checked) { // check select status
        $('.others').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"              
        });
    }else{
        $('.others').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"                      
        });        
    }
});});

function remove_group(){
	if($("#shout_frm input:checkbox:checked").length > 0){
		if(confirm("Are you sure you want to delete this group")){
					$("#shout_frm").submit();
		}	
     }else{
		 alert("Please select atleast one record to delete");
	 }
}
function
 addshout()
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
	 $.get( "deletegroups.php?id="+id, function( data ) {
			window.location='manage_groups.php';
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

