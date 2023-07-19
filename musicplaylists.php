<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$_SESSION['user_id'] = "24";
$_SESSION['user_type'] = "host";
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}


if(isset($_POST['saverequest']))
{
	
	$stat = trim($_POST['status']);
	if($stat == "")
	{
		$stat = "0";
	}
	$query = mysql_query("UPDATE clubs SET musicrequeststatus = '$stat' WHERE id= '$userID' ");

	if($stat == '1')
	{
		$message = '<div  id="successmessage" class="message"> Music Requests are now disabled.</div>';
	}
	else
	{
		$message = '<div  id="successmessage" class="message"> Music Requests are now enabled.</div>';
		//$message = "Music Request List is Disabled for users.";
	}
	
}

if(isset($_POST['statusupdate']))
{
	$message = '<div  id="successmessage" class="message">Request status updated successfully.</div>';
}

$titleofpage=" Music PlayLists";

?>
<div class="clear"></div>

	
		
			
					<div class="v2_inner_main_content">
  						<div class="parent-message-div">
					<?php
							if(isset($_GET['msg']))
							{
								if($_GET['msg'] == "updated" )
								{
									echo "<div id='successmessage' class='message' >Music Updated Successfully !</div>";	
								}
								if($_GET['msg'] == "notupdated" )
								{
									echo "<div class='NoRecordsFound' id='successmessage' class='message' >Music not Updated. Please try again.</div>";	
								}
								if($_GET['msg'] == "deleted" )
								{
									echo "<div id='successmessage' class='message' >Music Deleted Successfully !</div>";	
								}
								if($_GET['msg'] == "not_deleted" )
								{
									echo "<div class='NoRecordsFound' id='successmessage' class='message' >Music not Deleted. Please try again.</div>";	
								}
								if($_GET['msg'] == "single_updated" )
								{
									echo "<div id='successmessage' class='message' >Music Added Sucessfully.</div>";	
								}
								if($_GET['msg'] == "single_not_updated" )
								{
									echo "<div class='NoRecordsFound' id='successmessage' class='message' >Music not Added. Please try again.</div>";	
								}	
								if($_GET['msg'] == "imported" )
								{
									echo "<div id='successmessage' class='message' >Music List Imported Successfully!.</div>";	
								}
							}
							$get_music_query = mysql_query("SELECT * FROM hostplaylist WHERE host_id = '$userID' ORDER BY `music_title` ASC");
							$count_rows = mysql_num_rows($get_music_query);			
							if($count_rows > 15)
							{ 
								$add_class = "tab_scroll"; 
							}
					?>
						</div>
					<?php
						if(isset($_POST['single_track_add']))
						{							
							$track = mysql_real_escape_string($_POST['music_title']);
							$artist = mysql_real_escape_string($_POST['music_artist']);
							$host_id = $_POST['host_id'];
							$query = mysql_query("INSERT INTO hostplaylist (`music_title`, `artist_name`, `host_id`) VALUES ('$track', '$artist', '$host_id')");
							if($query == 1)
							{								
								$Obj->Redirect("music_request.php?msg=single_updated");
							}
							else
							{							
								$Obj->Redirect("music_request.php?msg=single_not_updated");
							}
						}
						
						if(isset($_POST['add_single_list']))
						{ 
					?>
							<h3 id="title">Add Music</h3>
							
							<form enctype='multipart/form-data' action='' method='post'>
								<div class="edit_profile_f">
									<div id="profile_box">
								  
										<ul><li>Music Title:<span style="color:#F00">*</span></li><li><input type="text" name="music_title" required /></li></ul>
										<ul><li>Artist:<span style="color:#F00">*</span> </li><li><input required type="text" name="music_artist" /></li></ul>
										<div id="submit_btn" class="controlSet">
											<input type="hidden" value="<?php echo $userID; ?>" name="host_id">
											<input type='submit' name='single_track_add' value='Add' class='button'>
											<input type='button' name='' value='Cancel' class='button' onclick="window.location='music_request.php'" >
										</div>
									</div>
								</div>
							</form>
					<?php 	}
						else
						{ 
					?>		
							<h3 id="title">Music List</h3>
							<div class="deletealltrack">
								<button onclick="delete_all();" class="button">Delete All</button>
							</div>
							<div class="musicplaylistbuttons">
								<div>
		            				<form id="addsingletrack" action="" method="POST">
										<input type="hidden" name="main_host_id" value="<?php echo $userID; ?>">
										<input type="hidden" name="active_tab" value="add_music_tab">
										<input type="submit" name="add_single_list" value="Add" class="button">
									</form>
	                			</div>
	                						
						        <div>
									<form id="importlistform" action="import.php" method="POST">
										<input type="hidden" name="main_host_id" value="<?php echo $userID; ?>">
										<input type="submit" name="load_lists" value="Upload Playlist" class="button">
									</form>
						        </div>
							    <div>
									<a href="upload/musicplaylist/musicplaylisttemplate.csv" class="button">Download Template</a>
							    </div>
						    </div>
							<div class="autoscroll <?php //echo $add_class; ?>">
								<table id="example" class="display" style="margin-top:10px;">
									<thead>
										<tr style="background-color:rgb(254, 205, 7);">
											<th><input type="checkbox" onclick="checkall();" name="delete_all" id="delete_all"></th>
											<th>Music Title</th>
											<th>Artist</th>
											<th>Action</th>
										</tr>	
									</thead>
									<tbody>
							
						<?php
								if($count_rows > 0)
								{
									while($row = mysql_fetch_assoc($get_music_query))
									{ 
								?>		<tr>
											<td class="first"><input class="delids" type="checkbox" name="music_ids[]" value="<?php echo $row['id']; ?>"></td>
											<td class="second"><?php echo $row['music_title']; ?></td>
											<td class="third"><?php echo $row['artist_name']; ?></td>
											<td class="fourth">
												<a href="edit_music.php?music_id=<?php echo $row['id']; ?>"><img width="25px" height="25px" src="images/Edit.png" title="Edit"></a> &nbsp;&nbsp;
												<a onclick="confirm_delete('<?php echo $row['id']; ?>');" href="javascript:void(0);"><img width="25px" height="25px" src="images/del.png" title="Delete"></a>
											</td>
										</tr>						
						<?php 			} 
								}
								else
								{ 
									echo "<tr><td colspan='4'>No Record Found</td></tr>"; 
								} 
						?>
									</tbody>
								</table>
							</div>
					<?php 	}	?>
  					</div>
  				
			<div class="equalizer"></div>
		
	
		
<script type="text/javascript">


	// $(document).ready(function(){
	// 	$('#stop_ref').click(function(e){
	// 	    e.preventDefault();
	// 	    // Code goes here
	// 	});
	// });

	function confirm_delete(id){

		var del = confirm("Are you want to delete this music !");
		if (del == true) {

			jQuery.post(
				'ajaxcall.php',
				{'delete_id':id},
				
				function(response){
					
					if (response == "Deleted") {
						window.top.location = "music_request.php?msg=deleted";
					}else{
						window.top.location = "music_request.php?msg=not_deleted";
					}
					
					});
		}
	}
		
	function delete_all(){
		
		var del = confirm("Are you want to delete this music !");
		if (del == true) {

		var values = $('input:checkbox:checked.delids').map(function () {
		  return this.value;
		}).get();
		
			jQuery.post(
				'ajaxcall.php',
				{'delete_id_array':values},
				
				function(response){
					
							if (response == "Deleted") {
								window.top.location = "music_request.php?msg=deleted";
							}else{
								window.top.location = "music_request.php?msg=not_deleted";
							}
					
					});
		}

	}
		
	function checkall()
	{
		if($('#delete_all').hasClass('checked'))
		{
			$(".delids").prop("checked", false);
			$('#delete_all').removeClass('checked')
		}
		else
		{
			$(".delids").prop("checked", true);
			$('#delete_all').addClass('checked');
		}
	}

</script>