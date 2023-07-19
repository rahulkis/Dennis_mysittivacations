<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("index.php");
	
}
if($userType=='user'){
	$Obj->Redirect("profile.php");
}
$userID = $_SESSION['user_id'];

if(isset($_POST['submit_cd']))
{

	$tracks = count($_FILES['songs'][name]);
 	$allowed =  array('mp3','ogg','mpeg');

	for($a=0;$a<$tracks;$a++)
	{
		$filename = $_FILES['songs']['name'][$a];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
	}

	if(!in_array($ext,$allowed) ) 
	{
		$error_uploding =  "Audio tracks accepts only mp3 files";
	}						  
 	else 
 	{
	
	
		$cd = "Select cd_name from cds where host_id = $userID";
		$val = mysql_query($cd);
		$cds_array = array();
		while($val2 = mysql_fetch_assoc($val)){
			
			$cds_array[] = $val2['cd_name'];
			
		}

	   	if(in_array($_POST['cd_name'],$cds_array))
		{
			$error_uploding =  "CD Name already exists. Please choose another CD Name";
		}
		else
		{
			if(!is_dir("cd_images/". $userID ."/")) 
			{
				mkdir("cd_images/". $userID ."/");
			}
			$allowed =  array('gif','png' ,'jpg');
			$filename = mysql_real_escape_string($_FILES['file']['name']);
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(!in_array($ext,$allowed) )
			{
				$error_uploding = 'CD Image accepts only .gif, .png, .jpg files';
			} 
			else 
			{
				if(!file_exists("cd_images/$userID/" . $_FILES["file"]["name"]))
				{
					move_uploaded_file($_FILES["file"]["tmp_name"],
					"cd_images/$userID/" . $_FILES["file"]["name"]);
					//echo "Stored in: " . "cd_images/" . $_FILES["file"]["name"];     
					$cdpic = $_FILES["file"]["name"];
					$tracks = count($_FILES['songs'][name]);
					$errorcd="";
					
					$insertcd = "INSERT INTO `cds` (`id`, `host_id`, `cd_name`, `cd_pic`, `cd_release_date`, `cd_price`, `cd_description`,`cd_genre`) VALUES ('', '".$userID."', '".mysql_real_escape_string($_POST['cd_name'])."', '".$cdpic."', '".mysql_real_escape_string($_POST['releasedate'])."', '".mysql_real_escape_string($_POST['cd_price'])."', '".mysql_real_escape_string($_POST['cd_description'])."', '".mysql_real_escape_string($_POST['cd_genre'])."')";

					mysql_query($insertcd);
					
					$cd_id = mysql_insert_id();
					$cd_id; 
				   	if($cd_id != NULL)
				   	{
						if(!is_dir("cd_tracks/". $userID ."/"))
						{
							mkdir("cd_tracks/". $userID ."/");
						} 
					   	for($a=0;$a<$tracks;$a++)
					   	{
						  	if(!file_exists("cd_tracks/$userID/" . $_FILES["songs"]["name"][$a]))
							{        
								$t=$_FILES['songs']['name'][$a];
								$insertcdtracks = "INSERT INTO `cd_tracks` (`cd_id`, `host_id`,`cd_name`, `cd_path`) VALUES ('".$cd_id."', '".$userID."','".mysql_real_escape_string($_POST['cd_name'])."', '".$t."')";
								
								mysql_query($insertcdtracks);
							   	$successmessage = " CD successfully uploaded ";
								move_uploaded_file($_FILES["songs"]["tmp_name"][$a],"cd_tracks/$userID/" . $_FILES["songs"]["name"][$a]);
							}
						   	else
						   	{
								$error_uploding = "CD Track already exists :: ".$_FILES["songs"]["tmp_name"][$a];
								unlink( "cd_images/$userID/" . $_FILES["file"]["name"]);
								mysql_query("DELETE FROM `cds` WHERE `cds`.`id` = $cd_id");
						   	}
						}
					}
				} /*end insert id check */
				else
				{
					$error_uploding = "CD Image already exists :: ".$_FILES["file"]["name"] ;
				} 
			}/*end image extention check*/
					
		}/*end match database cd name*/
	}/*end match Track files*/             
				   
}/*end load cd isset*/

$titleofpage="Load CD";
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
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
				<div class="v2_rotate_pos music-button">

							<div class="music-banner">
								<img src="images/music-banner.png" alt="banner">
								<h3>Music uploads sell direct</h3>
								<p>MySitti wants to give you every opportunity to advance your career. You can sell your music to your fans directly from our site, and your fans can upload it electronically.</p>
							</div>

				<button id="single_page" class="active_pagebutton">Single</button>
				<button id="cds_page">CD</button>
				<button id="video_page">Video</button>
				<button id="setting_page">Settings</button>

					<div class="single_pageClass">
						<?php include('music.php'); ?>
					</div>

					<div class="video_pageClass">
						<?php include('video_clips.php'); ?>
					</div>

					<div class="setting_pageClass">
						<?php include('uploadSettings.php'); ?>
					</div>

					<div class="cds_pageClass v2_inner_main_content">
  						<div class="parent-message-divcd">
					<?php if($message['success'] != ""){ 

					echo '<div style="display: block;" id="successmessage" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div style="display: block;" id="errormessage" class="NoRecordsFound" >'.$message['error']."</div>";
					} 

					?>
					<?php if($error_uploding){ ?><div style="display: block;" id="errormessage" class="NoRecordsFound"><?php echo $error_uploding;?></div> <?php } ?>
					<?php if($successmessage) {?><div style="display: block;" id="successmessage"><?php echo $successmessage;?></div> <?php }?>
					</div>
					<h3 id="title" class="title_txt">Load CD</h3>

					<form class="v2_cds_form" action="<?php echo $_SERVER['PHP_SELF'];?>?cd=uploaded" method="post" enctype="multipart/form-data">


					 
						<div class="row">
							<span class="label"><label>CD Name <b><font color='red'><em>*</em></font></b></label></span>
							<span class="formw"><input id="CDname" type="text" name="cd_name" required value="<?php if($error_uploding != ""){echo $_POST['cd_name'];} ?>" /></span>
						
						</div>
						
						
							<div class="row"><span class="label"><label>Price $<b><font color='red'><em>*</em></font></b></label></span>
						<span class="formw"><input id="CDprice" <?php if(empty($merchantID)){ ?> onclick='addmerchantID("CD")'; <?php } ?> type="number" min="1" name="cd_price" required value="<?php if($error_uploding != ""){echo $_POST['cd_price'];} ?>"/></span></div>
						
						
							<div class="row"><span class="label"><label>CD Description</label></span>
						<span class="formw"><input type="text" name="cd_description"  value="<?php if($error_uploding != ""){echo $_POST['cd_description'];} ?>"/></span></div>
						
						<div class="row"><span class="label"><label style="float: left;">CD Release Date </label></span>
						<span class="formw"><input type="text" name="releasedate"  class="date" value="<?php if($error_uploding != ""){echo $_POST['releasedate'];} ?>"/></span></div>
						
						<div class="row"><span class="label"><label>CD Genre </label></span>
						<span class="formw"><input type="text" name="cd_genre"  value="<?php if($error_uploding != ""){echo $_POST['cd_genre'];} ?>"/></span></div>
						
							<div class="row"><span class="label"><label>CD Image <b><font color='red'><em>*</em></font></b></label></span>
						<span class="formw"><input type="file" id="cd_image" name="file" accept="image/*" required class="brwse_btn" onchange="return Validate_cd_FileUpload()"/> (Allowed exts's gif, png, jpg & jpeg)</span></div>
						
							<div class="row"><span class="label"><label>Select Tracks:<b><font color='red'><em>*</em></font></b></label></span>
						 <span class="formw"><input id="cd_audio" type="file" name="songs[]" accept="mp3/*,audio/*" required class="brwse_btn" multiple="multiple" onchange="return Validate_cd_audio_Upload()"/> (Allowed exts mp3)</br><blockquote class="instruction">(You can add more than one track by pressing ctrl + mouse click. "Max Upload size = 7MB")</blockquote></span></div>


					  <div class="field_out"><input type="submit" name="submit_cd" class="button btn_ss" value="Load" id='submitcd' /></div>

					</form>

				<div class="seprators"></div>
					<?php $results = "Select * From cd_tracks INNER JOIN cds ON cds.cd_name = cd_tracks.cd_name WHERE cd_tracks.host_id = '". $userID."' GROUP BY cds.cd_name ORDER BY cd_tracks.id DESC ";

					$cdtracksdata = mysql_query($results);
					if(@mysql_num_rows($cdtracksdata)>0) {
					?>
					<div class="cdform">
					<?php

						$a = 0;
						while($cdarray = mysql_fetch_array($cdtracksdata))
						{
							
							if(!empty($cdarray['cd_release_date'])){
								
								$date = date('M d, Y',strtotime($cdarray['cd_release_date']));	
							}
							
							if(empty($cdarray['cd_genre'])){
								
								$get_genre = "Not defined";	
								
							}else{
								
								$get_genre = $cdarray['cd_genre'];
								
							}
							
							
							echo "<div class='cdsed' style=''> <div class='cds'>"."<span class='gray'><dd class='cdname'>".$cdarray['cd_name']."</dd>";
							echo "<dd class='cddata'>BY : ".$_SESSION['username']." ".$date."<br>Genre : ".$get_genre."</dd></span><br>";
							echo "<span class='cddesc'>".$cdarray['cd_description']."</span>";
							echo "<span class='player'><dd class='play'><audio style='display:none;' controls id='player$a'><source src='cd_tracks/".$userID."/".$cdarray['cd_path']."' type='audio/mpeg'><source src='cd_tracks/".$userID."/".$cdarray['cd_path']."' type='audio/ogg'><embed height='50' width='100' src='cd_tracks/".$userID."/".$cdarray['cd_path']."'></audio>
							<a href='javascript:play1();' id='$a' class='test audio'><img src='images/new_portal/play.png' /></a><a href='javascript:pause();' class='pause' id='$a'><img src='images/new_portal/pause.png' /></a></dd>";
							echo "<dd class='price'>Price : $".$cdarray['cd_price']."</dd></span>";
							echo "<dd class='viewtracks'><a href='cdtracks.php?cd_id=".$cdarray['id']."&cd_name=".$cdarray['cd_name']."'>View Tracks</a> <a href='#focuslink' class='deletecdrecord' id='".$cdarray['id']."'>Delete CD</a></dd></div></div>";
							$a++;
						}
						echo "</div>";
					}
					else
					{
						echo "<div class='NoRecordsFound'>No CD's available Yet.</div>" ;
					}
					?>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){

  $('.deletecdrecord').on('click',function(){

	var r=confirm("Are you sure you want delete this record?");
	if (r==true)
	{
	  var id = $(this).attr('id');
	  $.ajax({

		type: 'POST',
		url: 'deletemusicajax.php',
		data: {
		  'id': id,
		  'action': 'deletecd',
		},
		success: function(data) {
		  $('.parent-message-divcd').html(data);
		  setTimeout(function() {
				// Do something after 5 seconds
				location.reload(true);
		  }, 5000);

		  
		}

	  });
	} 

	
  });

    $('.v2_rotate_pos.music-button button').on('click',function(){
	  $('button').removeClass('active_pagebutton');
	  $(this).addClass('active_pagebutton');
	});

	$("#single_page").click(function(){
	     showDiv();
	});
	$("#cds_page").click(function(){
	     showDivcd();
	});
	$("#video_page").click(function(){
	     showDivvideo();
	});
	$("#setting_page").click(function(){
	     showDivsetting();
	});

 });

function Validate_cd_FileUpload(){
		var check_image_ext = $('#cd_image').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('CD Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#cd_image').val('');
		}
}

function Validate_cd_audio_Upload(){
		var check_image_ext = $('#cd_audio').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['mp3']) == -1) {
				alert('CD Audio only allows file type of MP3');
					$('#cd_audio').val('');
		}
} 

if(document.URL.indexOf("cd=uploaded") !== -1)
	{
		$(".cds_pageClass").css({"visibility":"visible","display":"block"});
	 	$(".single_pageClass").css({"visibility":"hidden","display":"none"});
	 	$(".video_pageClass").css({"visibility":"hidden","display":"none"});
	 	$(".setting_pageClass").css({"visibility":"hidden","display":"none"});
	 }

if(document.URL.indexOf("video=uploaded") !== -1)
	{
		$(".video_pageClass").css({"visibility":"visible","display":"block"});
	 	$(".cds_pageClass").css({"visibility":"hidden","display":"none"});
	 	$(".single_pageClass").css({"visibility":"hidden","display":"none"});
	 	$(".setting_pageClass").css({"visibility":"hidden","display":"none"});
	 }
function showDiv()
{
 	$(".single_pageClass").css({"visibility":"visible","display":"block"});
 	$(".cds_pageClass").css({"visibility":"hidden","display":"none"});
 	$(".video_pageClass").css({"visibility":"hidden","display":"none"});
 	$(".setting_pageClass").css({"visibility":"hidden","display":"none"});
}
function showDivcd()
{
 	$(".cds_pageClass").css({"visibility":"visible","display":"block"});
 	$(".single_pageClass").css({"visibility":"hidden","display":"none"});
 	$(".video_pageClass").css({"visibility":"hidden","display":"none"});
 	$(".setting_pageClass").css({"visibility":"hidden","display":"none"});
}
function showDivvideo()
{
	$(".video_pageClass").css({"visibility":"visible","display":"block"});
 	$(".cds_pageClass").css({"visibility":"hidden","display":"none"});
 	$(".single_pageClass").css({"visibility":"hidden","display":"none"});
 	$(".setting_pageClass").css({"visibility":"hidden","display":"none"});
}
function showDivsetting()
{
	$(".video_pageClass").css({"visibility":"hidden","display":"none"});
 	$(".cds_pageClass").css({"visibility":"hidden","display":"none"});
 	$(".single_pageClass").css({"visibility":"hidden","display":"none"});
 	$(".setting_pageClass").css({"visibility":"visible","display":"block"});
}

</script>
<style>
.cds_pageClass {
	display: none;
}
.video_pageClass {
	display: none;
}
.setting_pageClass {
	display: none;
}
.active_pagebutton {
	background: #89a7e5 none repeat scroll 0 0 !important;
	color: white !important;
}

</style>
<?php include('Footer.php');?>