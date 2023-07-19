<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}




if(isset($_GET['page']))
{
	if($_GET['page'] == 'delete')
	{
		$id = $_GET['userid'];
		$getuserinfoquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `id` = '".$id."' ");
		$fetchuserinfo = @mysql_fetch_array($getuserinfoquery);
		$deletefromhost = @mysql_query("DELETE FROM `clubs` WHERE `club_name` = '".$fetchuserinfo['username']."'   ");
		$deleteuser = @mysql_query("DELETE FROM `hostsubusers` WHERE `id` = '".$id."' ");
		if($deleteuser)
		{
			$Obj->Redirect("subuserList.php?msg=delete");
		}
	}	
}



$titleofpage="Manage Users";
if(isset($_GET['host_id']))
{
	include('LoginHeader.php');
}
else
{
	include('HeaderHost.php');	
}
$getsubuserslist = @mysql_query("SELECT * FROM `hostsubusers` WHERE `host_id` = '".$_SESSION['user_id']."'  ");
$countrecords = @mysql_num_rows($getsubuserslist);

?>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 	include('club-right-panel.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<div class="parent-message-div">
					<?php 
						if(isset($_GET['msg']))
						{
							if($_GET['msg'] == "added" )
							{
								echo "<div style='display: block;' id='successmessage' class='message' >User Added Successfully !</div>";	
							}
							if($_GET['msg'] == "notadded" )
							{
								echo "<div style='display: block;' id='errormessage' class='message' >User not Added. There is something wrong with user details. Please try again.</div>";	
							}
							if($_GET['msg'] == "updated" )
							{
								echo "<div style='display: block;' id='successmessage' class='message' >User Updated Successfully.</div>";	
							}
							/* add by kbihm on feb 25,2015 */
							if($_GET['msg'] == "updStreamPwd" )
							{
								echo "<div style='display: block;' id='successmessage' class='message' >Streaming Password Updated Successfully.</div>";	
							}
							/* end */
							if($_GET['msg'] == "notupdated" )
							{
								echo "<div style='display: block;' id='errormessage' class='message' >User not Updated. There is something wrong with user details. Please try again.</div>";	
							}
							if($_GET['msg'] == "delete" )
							{
								echo "<div style='display: block;' id='successmessage' class='message' >User Deleted Successfully.</div>";	
							}
							
						}

					?>
						</div>
   						<div id="title" class="title  botmbordr"> <h3 id="title">Users </h3>
            							<span class="disableall">
     								<a style="float: right;" class="button" href="addSubuser.php" >Add User</a>
     							</span>
           					 	</div>
                                <div class="clear"></div>
	            					<div class="autoscroll v2_subuser_list" id="profile_box">
							<table  class="display" id="example1" style="margin-top:;" >
								<thead>
									<tr style="background-color:rgb(254, 205, 7);">
										<th>Profile ID</th>
									 	<th>User Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
							<?php 
								if($countrecords > 0)
								{
									while($res = mysql_fetch_array($getsubuserslist))
									{
									
							?>
										<tr>
											<td><?php echo $res['username']; ?></td>
											<td><?php echo $res['useremail']; ?></td>
											<td>
												<a href="addSubuser.php?userid=<?php echo $res['id'];?>">
													<img width="25px" height="25px" title="Edit" src="images/Edit.png">
												</a>
												<a onclick="return confirm('Are you sure you want to delete?');" href="?page=delete&userid=<?php echo $res['id'];?>">
													<img width="25px" height="25px" title="Delete" src="images/del.png">
												</a>
											</td>
										</tr>


						<?php

									}
								}
								else
								{
									?>
										<tr>
											<td colspan='3'>No User's Yet !</td>
										</tr>

					<?php 
								}

							?>
							
								</tbody>
							</table>
						</div>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>

<style>
.notinplanhome_club{
	color: white; font-size: 17px; text-align: center;
}
.notinplanhome_club a {
    color: #fecd07;
}
</style>

<?php include('Footer.php');?>