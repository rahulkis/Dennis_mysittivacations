<?php
include("Query.Inc.php");

$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($userID)){
	$Obj->Redirect("login.php");
}

if($userType=='user'){
	$Obj->Redirect("profile.php");
}
	

$titleofpage = "Edit Music";
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}


$userID=$_SESSION['user_id'];

  /******************/


if(isset($_GET['music_id']))
{
	$music_id = $_GET['music_id'];
	$query = mysql_query("SELECT music_title, artist_name FROM hostplaylist WHERE id = '$music_id'");
	$count_rows = mysql_num_rows($query);
	if($count_rows > 0)
	{	
		$get_music_data = mysql_fetch_row($query);
		$trackname = $get_music_data[0];
		$artist = $get_music_data[1];		
	}
	else
	{		
		$Obj->Redirect("music_request.php");
	}
}
else
{
	$Obj->Redirect("music_request.php");
}

if(isset($_POST['update'])){
	
	$trackname = $_POST['trackname'];
	$artist = $_POST['artist'];
	$music_id = $_POST['music_id'];
	
	$update = mysql_query("UPDATE hostplaylist SET music_title = '$trackname', artist_name = '$artist' WHERE id= '$music_id' ");
	
	if($update == 1){
		$Obj->Redirect("music_request.php?msg=updated");
	}else{
		$Obj->Redirect("music_request.php?msg=notupdated");
	}
}
?>	 
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	 <?php include('club-right-panel.php');?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title" class="title  botmbordr">Edit Music</h3>
						<form method="POST" action="" enctype="multipart/form-data" class="addsubuser">
							<div class="edit_profile_f">
								<div id="profile_box">
								         	<ul>
									           	<li>Music Title:<span style="color:#F00">*</span></li>
									           	<li><input required name="trackname" type="text"  value="<?php echo $trackname; ?>" /></li>
								         	</ul>
								         	<ul>
									           	<li>Artist:<span style="color:#F00">*</span></li>
									           	<li><input required name="artist" type="text" value="<?php echo $artist; ?>" /></li>
								         	</ul>
								         	<div id="submit_btn">
										<input type="hidden" name="music_id" value="<?php echo $music_id; ?>" />
							         			<input name="update" class="button" type="submit" value="Update" />
							         			<input type='button' name='' value='Cancel' class='button' onclick="window.location='music_request.php'" />
							         		</div>
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

<?php include('Footer.php');?>