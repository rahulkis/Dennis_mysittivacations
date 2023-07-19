<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

if($_GET['type']=='private')
{
	$type=$_GET['type'];
}else
{
$type='public';
}

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<!--<link type="text/css" rel="stylesheet" href="css/style_popup.css" />-->
 <link type="text/css" rel="stylesheet" href="css/v2style.css" />  
<style type="text/css">
.successmessage {
	background: #09d518 none repeat scroll 0 0;
	border: 1px solid #09d518;
	color: #fff;
	float: left;
	font-size: 18px;
	margin-bottom: 10px;
	padding: 10px 0;
	text-align: center;
	text-indent: 10px;
	width: 100% !important;
}
</style>
<?php
 
	if(isset($_POST['add_HostContest']))
	{
	  
		if($_POST['edit_id'] > 0)
		{
		  	$up=mysql_query("update chat_groups set group_name='".$_POST['group_name']."',group_desc='".$_POST['group_desc']."' where id=".$_POST['edit_id']."");
			$_SESSION['success']="Group updated successfully";
		}
		else
		{
			$user_id = $_SESSION['user_id'];
			$ThisPageTable='chat_groups';
			$ValueArray = array($_POST['group_name'],$_SESSION['id'],$_SESSION['user_id'],$_POST['group_desc'],$type,$_SESSION['user_type']);	
			$FieldArray = array('group_name','city_id','create_by','group_desc','group_type','user_type');
			$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
			$last_group=$Success ;
			
			$ThisPageTable2='chat_users_groups';
			$ValueArray2 = array($last_group,$_SESSION['user_id'],$_SESSION['user_type']);	
			$FieldArray2 = array('group_id','user_id','user_type');
			 $Obj->Insert_Dynamic_Query($ThisPageTable2,$ValueArray2,$FieldArray2);
   		}
   
		if($Success > 0)
		{
			$_SESSION['Groupsuccess']="Group added successfully";
			?>
<script type="text/javascript">
					opener.location.reload(true);
   					self.close();
				</script>
<?php
		}
	}

	if($_REQUEST['id'])
	{
	  	$sql_sel=mysql_query("select * from  chat_groups where id='".$_GET['id']."'");
	  	$get_dtl=@mysql_fetch_assoc($sql_sel);
	}
	
?>
<div id="modal" class="popupContainer v2_addgroup_modal">
  <div class="v2_add_group_wrapper">
    <div class="popupHeader">
      <h3 id="title">Add Chat Group</h3>
    </div>
    <div class="popupBody"> 
      <!-- Social Login -->
      <?php if(isset($_SESSION['Groupsuccess'])) {  echo '<div id="successmessage" style="display:block;" class="message" >Group successfully added</div>';
unset($_SESSION['success']) ;} ?>
      <div class="user_register">
        <form name="add_contest" onsubmit="return checkGroup1();"  method="post"  enctype="multipart/form-data">
          <label>Group Name:</label>
          <textarea id="groupName" required name="group_name"  onblur="checkGroup(this.value);" ><?php echo $get_dtl['group_name'];  ?></textarea>
          <input type="hidden" value="<?php echo $_GET['id']; ?>" name="edit_id">
          <br>
          <label>About Group:</label>
          <textarea  required name="group_desc" id="" ><?php echo $get_dtl['group_desc'];  ?></textarea>
          <input type="hidden" value="<?php echo $_GET['id']; ?>" name="edit_id">
          <div id="submit_btn" class="pop_up_btns">
            <?php if($_REQUEST['id']) { ?>
            <input name="add_HostContest" class="button"  type="submit" value="Update Group" id="submit3" />
            <?php }else{ ?>
            <input name="add_HostContest" class="button"  type="submit" value="Add Group" id="submit3" />
            <?php } ?>
            <input name="cancel" type="button"  class="button" value="Cancel"  id="submit3" onclick="javascript:self.close();"/>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	function checkGroup (str) 
	{
		if(str == "")
		{
			alert('Please Enter Group Name.');
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "checkGroup.php",
				data: {
					'title' : str,
					'action' : 'checkGroup',
				},
				success: function(data){
					//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
					if(data == 'Yes')
					{
						alert('Group Name already Taken. Please choose another name.');
						$('#groupName').val('').focus();
						return false;
					}

				}
			});
		}
		
	}
	function checkGroup1 () 
	{
		var str = $('#groupName').val();
		if(str == "")
		{
			alert('Please Enter Group Name.');
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "checkGroup.php",
				data: {
					'title' : str,
					'action' : 'checkGroup',
				},
				success: function(data){
					//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
					if(data == 'Yes')
					{
						alert('Group Name already Taken. Please choose another name.');
						$('#groupName').val('').focus();
						return false;
					}

				}
			});
		}
	}
</script> 
