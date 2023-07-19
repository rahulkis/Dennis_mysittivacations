<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Help & Support";
//include('header_start.php');

$userID=$_SESSION['user_id'];

if(!isset($userID)){
  include('Header.php');
}else{
  include('LoginHeader.php');
}

if($_POST['submit_comment']){
  
  $thread_comment = mysql_real_escape_string($_POST['comment']);
  
  $success = mysql_query("INSERT INTO support_thread (`from_user`, `from_user_type`, `to_user`, `to_user_type` , `support_id` , `commented_on`, `comment`) VALUES ('".$_POST['from_user']."', '".$_POST['from_user_type']."', '".$_POST['to_user']."', '".$_POST['to_user_type']."', '".$_POST['support_id']."', '".$_POST['commented_on']."', '".$thread_comment."')");
  
  $_SESSION['comment_success'] = "success";
}

if(isset($_POST['submit'])){
  
  $user_email = $_SESSION['user_id'];
  $user_type = $_SESSION['user_type'];
  $support_subject = $_POST['support_subject'];
  $support_question = $_POST['support_question'];
  
  if($_FILES['forum_img']['error'] == 0){
	
				$file_type = $_FILES['forum_img']['type'];
				$exp_file_type = explode('/', $file_type);
				$check_file_type = $exp_file_type[0];
				
				if($check_file_type == "video" || $check_file_type == "application"){
					
					$forum_video=$_FILES['forum_img']['name']; 
					$tmp = $_FILES["forum_img"]["tmp_name"]; 
					$support_attachment = "video/support_".time().strtotime(date("Y-m-d")).$forum_video; 
					move_uploaded_file($tmp,$support_attachment);
					
				}elseif($check_file_type == "image"){
					
					$name = $_FILES["forum_img"]["name"];
					$tmp1 = $_FILES["forum_img"]["tmp_name"];
					$support_attachment = "upload/support_".time().strtotime(date("Y-m-d")).$name;
					move_uploaded_file($tmp1,$support_attachment);
					
				}
	
	}else{
	  
					$support_attachment = "";  	  
	  
	}
	
	$added_on = date('Y-m-d H:i:s');
  
	mysql_query("INSERT INTO help_and_support (`user_id`, `user_type`, `support_subject`, `support_question`, `support_attachment`, `added_on`) VALUES ('".$user_email."', '".$user_type."', '".$support_subject."', '".$support_question."', '".$support_attachment."', '".$added_on."')");

  $_SESSION['support_sucsess'] = "Request Sent Successfully";
}

?>

<style>
.lbl{
  float: left;
  width: 100% !important;
}

#u_0_t{
  float: left !important;
}
 
#ad_support_pst{
  display: none;
}
</style>

<!--<script src='js/jqueryvalidationforsignup.js'></script>-->
<!--<script src="js/register.js" type="text/javascript"></script>-->
<script type="text/javascript">
$(document).ready(function($){
(function($) {  
  var allPanels = $('.accordion > .description').hide('slow');
    
  $('.accordion > li > a').click(function() {
    allPanels.slideUp('slow');
    $(this).parent().next().slideDown('slow');
    return false;
  });

})($);
});

function ValidateFileUpload(){
		var check_image_ext = $('#js_0').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg', 'mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {
			alert('Support Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');
			$('#js_0').val('');
		}else{
			$('#file_upload_successs').show();
		}
}

function toggle_form(){
  $("#ad_support_pst").toggle();
  $('#successmessage').hide();
  return false;
}
</script> 	
	
<div class="home_wrapper">
<div class="main_wrapper band_wrapper_bg">
  <div class="support_center">
    <div class="support_container">
      <h1 class="title"><img alt="" src="images/help-icon-support.png"> Mysitti Support Forum</h1>
    </div>
    </div>
  
    <div class="clear"></div>
    <div class="support_container"> 
    <div class="support_inner">
   <div class="support_full">
   <?php if(isset($_SESSION['comment_success'])){ ?>
   
	<div id="successmessage" style="margin-bottom:6px;"> Comment Posted Successfully</div>
   
   <?php } unset($_SESSION['comment_success']); ?>
	
    <div class="support_left_inner">
	  
	  <?php
	  $get_support_Data = mysql_query("SELECT * FROM help_and_support WHERE id = '".$_GET['token']."' AND approve = 1 ORDER BY added_on DESC limit 0,20");
	  $count_thread = mysql_num_rows($get_support_Data);
	  $support_details = mysql_fetch_assoc($get_support_Data);
	  ?>
	    <div class="clear"></div> 
    <h1><?php echo $support_details['support_subject']; ?> <a class="button v2_button_back" style="float: right; font-size: 12px;" href="javascript:void(0);" onclick="window.location.href='support.php' ">Go Back</a></h1>
    <div class="clear"></div>
    <ul  class="accordion">
	  
	  <?php if($count_thread < 1){ ?>
	  
		<li>
		  <a href="javascript: void(0);">No Thread Right Now.</a>
		</li>
	  
	  <?php }else{
		
		$get_comments_data = mysql_query("SELECT * FROM support_thread WHERE support_id = '".$_GET['token']."'");
		$count_s_thread = mysql_num_rows($get_comments_data);
		
		if($count_s_thread > 0){
		  while($thread_data_row = mysql_fetch_assoc($get_comments_data)){
		?>
	  
		<div class="support_comments reply">
		  <div class="comment_s_desc">
		
		  
		  <div class="comment_s_uname">
			<?php
			if($thread_data_row['from_user_type'] == "user"){
			  
			  $get_user_detls = mysql_query("SELECT first_name, last_name, profilename FROM user WHERE id = '".$thread_data_row['from_user']."'");
			  $get_user_details = mysql_fetch_assoc($get_user_detls);
			  
			  if(!empty($get_user_details['profilename'])){
				
				  $commented_user = $get_user_details['profilename'];
				
				}else{
				  
				  $commented_user = $get_user_details['first_name']." ".$get_user_details['last_name'];
				  
				}
			  
			}
			
			if($thread_data_row['from_user_type'] == "club"){
			  
			  $get_club_detls = mysql_query("SELECT first_name, last_name, club_name FROM clubs WHERE id = '".$thread_data_row['from_user']."'");
			  $get_club_details = mysql_fetch_assoc($get_club_detls);
			  
			  if(!empty($get_club_details['club_name'])){
				
				  $commented_user = $get_club_details['club_name'];
				
				}else{
				  
				  $commented_user = $get_club_details['first_name']." ".$get_club_details['last_name'];
				  
				}			  
			  
			}
			
			$cdate = date("F j, Y, g:i a", strtotime($thread_data_row['commented_on'])); ?>
			
			<i style="font-style: italic; font-weight: bold;"><?php echo $commented_user; ?></i> commented on <i style="font-style: italic;"><?php echo $cdate; ?></i><br />
		  </div><div class="descinner">	<?php echo $thread_data_row['comment']; ?></div>
          </div>
		  <div class="comment_s_udate"></div>
		</div>
		
		<?php }}
		$comment_date = date("Y-m-d H:i:s"); ?>

		<div class="box3 1">
		  <form id="forum_thread_form" action="" method="POST">
			<div class="comment_txt v2_add_comment">
			  <textarea name="comment" required rows="10" cols="92" placeholder="Write a comment.."></textarea>
			</div>
			
			<div align="center" class="submit_support">
			  <input type="hidden" name = "from_user" value="<?php echo $_SESSION['user_id']; ?>">
			  <input type="hidden" name = "from_user_type" value="<?php echo $_SESSION['user_type']; ?>">
			  <input type="hidden" name = "to_user" value="<?php echo $support_details['user_id']; ?>">
			  <input type="hidden" name = "to_user_type" value="<?php echo $support_details['user_type']; ?>">
			  <input type="hidden" name = "commented_on" value="<?php echo $comment_date; ?>">
			  <input type="hidden" name = "support_id" value="<?php echo $support_details['id']; ?>">
			  <input type="submit" value="Add Comment" class="button" name="submit_comment">
			</div>
		  </form>
		</div>

	  <?php } ?>

    </ul>
    </div>
   </div>

    <!--<h1 class="soon">Coming Soon</h1>-->
    </div>
    <div class="clear"></div></div>
  </div>
</div>
    <?php include('Footer.php') ?>
