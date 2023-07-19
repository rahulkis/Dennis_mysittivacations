<?
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}


$titleofpage="Manage Private Groups";
include('NewHeadeHost.php');	

$del_id = $_GET['id'];
if($del_id !="")
{
	$shoutsql ="DELETE FROM chat_groups WHERE id = $del_id";
	$shout_list = mysql_query($shoutsql);
	header('Location: manage_groups.php');
}
	
$cnd="cg.group_type='private' AND cg.create_by='".$_SESSION['user_id']."'";
$shoutsql="select cg.*,c.city_name,u.first_name,u.last_name,u.image_nm from chat_groups as cg 
	left join capital_city as c on(cg.city_id=c.city_id) 
	left join user as u on(u.id=cg.create_by) 
	where ".$cnd." ";
$group_list = mysql_query($shoutsql);
if(count($_POST['shoutschk']) > 0)
{
	$ids=implode(",",$_POST['shoutschk']); 
	$sql_del=mysql_query("delete from chat_groups where id IN(".$ids.")");
	if($sql_del)
	{	
		$_SESSION['success']="Groups deleted successfully";
		header('location: private_groups.php'); exit;
	}
}
		
if(isset($_SESSION['success']))
{
	$success=$_SESSION['success'];
	unset($_SESSION['success']);
}
if(isset($_SESSION['Groupsuccess']))
{
	$success=$_SESSION['Groupsuccess'];
	unset($_SESSION['Groupsuccess']);
}



if(isset($_POST['add_HostContest']))
	{
	  
		if($_POST['edit_id'] > 0)
		{
		  	$up=mysql_query("update chat_groups set group_name='".mysql_real_escape_string($_POST['group_name'])."',group_desc='".mysql_real_escape_string($_POST['group_desc'])."' where id=".$_POST['edit_id']."");
			$_SESSION['success']="Group updated successfully";
		}
		else
		{
			$user_id = $_SESSION['user_id'];
			$ThisPageTable='chat_groups';
			$ValueArray = array(mysql_real_escape_string($_POST['group_name']),$_SESSION['id'],$_SESSION['user_id'],mysql_real_escape_string($_POST['group_desc']),'private',$_SESSION['user_type']);	
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
		}
	}

	if($_REQUEST['id'])
	{
	  	$sql_sel=mysql_query("select * from  chat_groups where id='".$_GET['id']."'");
	  	$get_dtl=@mysql_fetch_assoc($sql_sel);
	}



?>
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
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   
		if(!isset($_REQUEST['id']))
		{
			include('friend-right-panel.php');
		}
		else 
		{
			include('friend-profile-panel.php'); 
		} 
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
						
						<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
						<script type="text/javascript" language="javascript" class="init">
						$(document).ready(function(){
						  $('#example').dataTable();
						});
						</script>
						
						<?php include('commonpage.php');?>
						<h3 id="title" class="botmbordr">Manage <?php echo $_SESSION['profile_name']; ?> Groups </h3>
					<?php 
						if(isset($success)) 
						{ 
					?> 
							<div style="" class="successmessage">
								<?php if($success == "yes"){ echo "Group Deleted Successfully"; }else{ echo $success; } ?>
							</div> 
					<?php 	} 	?>
						<!-- <div class="m_mid">    -->
							<!-- <input type="button" class="button" style="font-size: 13px;;" value="Create Group" onClick="javascript:void window.open('add_group.php?type=private','','width=520,height=500,resizable=false,left=400,top=100');return false;"> -->
							<!-- <input type="button" class="button" style="font-size: 13px; " value="Back"  onClick="window.location='profile.php'"> -->
						<!-- </div> -->
						<div class="m_mid">
							<h2>Add Group</h2>
							<form class="createGroupForm" name="add_contest" onsubmit="return checkGroup1();"  method="post"  enctype="multipart/form-data">
								<div class="groupName">
								<label>Group Name:</label>
								<textarea id="groupName" required name="group_name"  onblur="checkGroup(this.value);" ><?php echo $get_dtl['group_name'];  ?></textarea>
								<input type="hidden" value="<?php echo $_GET['id']; ?>" name="edit_id">
								</div>
								<div class="groupInfo">
								<label>About Group:</label>
								<textarea  required name="group_desc" id="" ><?php echo $get_dtl['group_desc'];  ?></textarea>
								<input type="hidden" value="<?php echo $_GET['id']; ?>" name="edit_id">
								</div>
								<div id="submit_btn" class="pop_up_btns">
									<?php if($_REQUEST['id']) { ?>
									<input name="add_HostContest" class="button"  type="submit" value="Update Group" id="submit3" />
									<?php }else{ ?>
									<input name="add_HostContest" class="button"  type="submit" value="Add Group" id="submit3" />
									<?php } ?>
									<input type="button" class="button" style="font-size: 13px; " value="Back"  onClick="window.location='profile.php'">
								</div>
							</form>
						</div>
						<form name="shout_frm" id="shout_frm" method="post" style="margin-top:0px;">
							<div class="tab_scroll user_scroll_tab">    
								<div id="profile_box" style="padding:0px;">
								<?php 
									if(mysql_num_rows($group_list) > 0)
									{
								?>
									<table  id="example" class="display" style="margin-top:10px;" >
										<thead>
											<tr style="background: rgb(254, 205, 7);">
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
										while($row1 = mysql_fetch_array( $group_list)) 
										{ 
											
											$sql_cnt_friends=mysql_query("select count(DISTINCT(user_id)) as tot_mem from chat_users_groups  where group_id='".$row1['id']."'");
											$tot_mem=@mysql_fetch_assoc($sql_cnt_friends);
									?>
											<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
												<td>
													<?php  	if($row1['image_nm']!="") {?>
														<img src="<?php echo $row1['image_nm']; ?>" width="100" height="100">
													<?php }else { ?>
														<img src="images/no_image.jpg" height="100" width="100">
													<?php } ?><br>
													<a href="profile.php" target="_blank"><?php echo $row1['first_name']." ".$row1['last_name']; ?></a>
												</td>
												<td>
													<p><?php echo $row1['group_name']; ?><p> 
												</td>
												<td>
													<p><?php echo $row1['group_desc']; ?><p> 
												</td>
												<td>
													<?php echo $row1['city_name'];?>
												</td>
												<td>
													<?php echo $tot_mem['tot_mem']; ?> 
												</td>
												<td>
													<?php if($_SESSION['user_id']==$row1['create_by']){ ?>
														<a href="javascript:void(0);" onClick="window.open('group_list.php?id=<?php echo $row1['id']; ?>','','width=520,height=500,resizable=false,left=400,top=100');return false;"> 
															<img src='images/Edit.png' width="25px"; height="25px";>
														</a>
														&nbsp;
														<a href="javascript:void(0);" onclick="delrecoreds('<?php echo $row1['id']; ?>');">
															<img src="images/del.png" width="25px"; height="25px";>
														</a>
													<?php } ?>
												</td>
											</tr>
								<?php			$i++;
										}
								?>
										</tbody>
									</table>
								<?php 	}
									else
									{
										echo "<div class='NoRecordsFound'>No Groups created.</div>";
									}
								?>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
	
<script type="text/javascript">
function delrecoreds(id)
{
	if(confirm('Are You sure You want to delete this record'))
	{
		$.get( "deletegroups.php?id="+id, function( data ) {
			window.location='private_groups.php';
		});
	}
}
</script>
<?php include('Footer.php') ?>
