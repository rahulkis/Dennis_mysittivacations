<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Help & Support";
//include('header_start.php');

$userID=$_SESSION['user_id'];

if(!isset($userID)){
  include('Header.php');
}else{
  include('NewHeadeHost.php');
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

if($_POST['submit_comment']){
  
  $thread_comment = mysql_real_escape_string($_POST['comment']);
  
  $success = mysql_query("INSERT INTO support_thread (`from_user`, `from_user_type`, `to_user`, `to_user_type` , `support_id` , `commented_on`, `comment`) VALUES ('".$_POST['from_user']."', '".$_POST['from_user_type']."', '".$_POST['to_user']."', '".$_POST['to_user_type']."', '".$_POST['support_id']."', '".$_POST['commented_on']."', '".$thread_comment."')");
  
  $_SESSION['comment_success'] = "success";
  $_SESSION['thread_show'] = $_POST['support_id'];
  header('Location: '.$SiteURL.'support.php');
  die;
}
?>
<style>
.lbl {
	float: left;
	width: 100% !important;
}
#u_0_t {
	float: left !important;
}
#ad_support_pst {
	display: none;
}

.v2_inner_main{
	min-height: 350px;
}

</style>
<!--<script src='js/jqueryvalidationforsignup.js'></script>-->
<!--<script src="js/register.js" type="text/javascript"></script>-->
<script type="text/javascript">
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

function goto_demo_vid(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);	
}

function show_forum_threads(thread_id){
  
  var check_collapse = $('#forum_thread_'+thread_id).text();
  
  if (check_collapse === '-') {
	
	$('#forum_thread_'+thread_id).html('&#43;');
	$('#forum_threads_'+thread_id).hide();
	return false;
  
  }else{
  
	$('.forum_threads').hide();
	$('#forum_threads_'+thread_id).show();
	$('.li_forum_thread').html('&#43;');
	$('#forum_thread_'+thread_id).html('&#45;');
	window.location.hash = "#"+$('#forum_thread_'+thread_id).attr("id");
  }
    // $('html, body').animate({
    //    scrollTop: $('.support_left_inner').offset().top
    //}, 2000);   
}

function validatesupportForm(id){
  if ($('#comment_textarea_'+id).val() == '') {
	$('.errorforsignup_'+id).show();
	return false;
  }
}

function open_login_generate_req(){

	var $aSelected = $('.v2_log_in');
	if( $aSelected.hasClass('close') ){ // .hasClass() returns BOOLEAN true/false
	
	  $('.close').addClass('open').removeClass('close');
	  
	}else{
	
		$('.v2_log_in').addClass('open');
		
	}
	
}	
</script>

<script type="text/javascript">
	$(document).ready( function() {
		$('html, body').animate({
			scrollTop: $(".v2_inner_main_content").offset().top - 150
		}, 1000);
	});
</script>

<!--<link rel="stylesheet" type="text/css" href="https://mysittidev.com/css/new_portal/style.css" />-->
<div class="v2_container">
  <div class="v2_inner_main">

	
		 
				<div class="v2_inner_main_content">
					<div class="support_inner">
					  <div class="support_left">
						<h1 class="ttl_support">Generate  a Request
						<?php if(isset($_SESSION['user_id']) && isset($_SESSION['user_type'])){ ?>
						  <div class="generate_req"> <a onclick = toggle_form(); href="javascript:void(0)">Generate a Request</a> </div>
						  <?php }else{ ?>
						  
						  <div onclick="open_login_generate_req();" class="generate_req"> <a href="javascript:void(0)">Please login to generate request</a> </div>
						  
						  <?php } ?>
						</h1>
						<? if($_SESSION['support_sucsess']){?>
						<div id="successmessage" style="margin-bottom:6px;"> <?php echo $_SESSION['support_sucsess']; ?> </div>
						<?  unset($_SESSION['support_sucsess']); }?>
						
						<div id="ad_support_pst">
						  <form enctype="multipart/form-data" method="POST" action="" id = "support_form" name="support_form" class="popupform">
							<div class="ppost_newdesign">
							  <div class="lbl">
								<div class="leftFormfields">
								  <label>Subject : </label>
								</div>
								<div class="rightFormfields">
								  <input type="text" class="txt_box clear_flds" name="support_subject" id="support_add_subject_text" required>
								</div>
							  </div>
							  <div class="lbl">
								<div class="leftFormfields">
								  <label>Question : </label>
								</div>
								<div class="rightFormfields">
								  <textarea rows="10" id="support_add_question"  name="support_question" class="txt_box clear_flds" required/>
								  </textarea>
								</div>
							  </div>
							  <div class="lbl">
								<div class="leftFormfields">
								  <label>Attachment: </label>
								</div>
								<div class="rightFormfields">
								  <div class="_6a _m" id="u_0_s"> <a class="_9lb" aria-pressed="false" role="button" rel="ignore" id="u_0_t"> <span class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf"> <img src="images/upload_camera.png"> </i>Add Photo/Video  (optional) <i class="_2wr"></i> </span>
									<div class="_3jk">
									  <input type="file" onchange="return ValidateFileUpload()" id="js_0" class="_n _5f0v" title="Choose a file to upload" name="forum_img" aria-label="Upload Photos/Video">
									  <span id="file_upload_successs" style="display: none;"><img src="images/tick_green_small.png"></span> </div>
									</a> </div>
								</div>
							  </div>
							  <div class="lbl">
								<div class="leftFormfields">
								  <label>&nbsp;</label>
								</div>
								<div class="rightFormfields">
								  <div class="pst_buttons" id="">
									<input type="submit" style="" class="button add_pub_p_post" value="Submit" name="submit" id="submit3">
								  </div>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  
						<?php if(isset($_SESSION['comment_success']) && isset($_SESSION['thread_show'])){
						
						  echo "<div style='margin-bottom:6px;' id='successmessage'> Comment Posted Successfully</div>";
						  //die("here");
						 ?>
						  <script type="text/javascript">
							  $(document).ready(function(){
								  var divid = "<?php echo $_SESSION['thread_show']; ?>";
								  $('#forum_threads_'+divid).show();
								  $('#forum_thread_'+divid).html('&#45;');
								  
								//  $('html, body').animate({
								//	 scrollTop: $('#show_thread_after_'+divid).offset().top
								// }, 2000);
								  
							  });
						  </script>
						 <?php 
						  
						  unset($_SESSION['comment_success']);
						  unset($_SESSION['thread_show']);
						} ?>
						
						<div class="support_left_inner">
						  <?php
					$get_support_Data = mysql_query("SELECT * FROM help_and_support WHERE approve = 1");
					
					//$get_support_Data = mysql_query("SELECT * FROM help_and_support WHERE user_id = '".$_SESSION['user_id']."' AND user_type = '".$_SESSION['user_type']."' AND approve = 1");
					$count_thread = mysql_num_rows($get_support_Data);
					?>
						  <h1>Most frequent questions from users like you</h1>
						  <ul class="accordion">
							<?php if($count_thread < 1){ ?>
							<li> <h3 style="color: black;">No Thread Right Now.</h3> </li>
							<?php }else{
					  
					  while($support_row = mysql_fetch_assoc($get_support_Data)){
					?>
							<li>
							  <div onclick="show_forum_threads('<?php echo $support_row['id']; ?>'); return false;" id="forum_thread_<?php echo $support_row['id']; ?>" class="li_forum_thread">&#43;</div>
							  <!--<a onclick="show_forum_threads('<?php echo $support_row['id']; ?>'); return false;" href="support-forum.php?token=<?php echo $support_row['id']; ?>"><?php echo $support_row['support_subject']; ?></a>-->
							  
							  
							  <a onclick="show_forum_threads('<?php echo $support_row['id']; ?>'); return false;" href="javascript: void(0);"><?php echo $support_row['support_subject']; ?></a>
							  
								<div id="forum_threads_<?php echo $support_row['id']; ?>" class="support_left_inner forum_threads" style="display: none;">
									<?php
									$get_support_Data_s = mysql_query("SELECT * FROM help_and_support WHERE id = '".$support_row['id']."' AND approve = 1 ORDER BY added_on DESC limit 0,20");
									$count_thread_s = mysql_num_rows($get_support_Data_s);
									$support_details_s = mysql_fetch_assoc($get_support_Data_s);
									?>
									  
									<ul class="accordion">
	  <?php if($count_thread_s < 1){ ?>
	  
		<li>
		 <h3 style="color: black;">No Thread Right Now.</h3>
		</li>
	  
	  <?php }else{
		
		$get_comments_data_s = mysql_query("SELECT * FROM support_thread WHERE support_id = '".$support_row['id']."'");
		$count_s_thread_s = mysql_num_rows($get_comments_data_s);
		
		if($count_s_thread_s > 0){
		  while($thread_data_row_s = mysql_fetch_assoc($get_comments_data_s)){
		?>
	  
		<div class="support_comments reply">
		  <div class="comment_s_desc">
		
		  
		  <div class="comment_s_uname">
			<?php
			if($thread_data_row_s['from_user_type'] == "user"){
			  
			  $get_user_detls_s = mysql_query("SELECT first_name, last_name, profilename FROM user WHERE id = '".$thread_data_row_s['from_user']."'");
			  $get_user_details_s = mysql_fetch_assoc($get_user_detls_s);
			  
			  if(!empty($get_user_details_s['profilename'])){
				
				  $commented_user_s = $get_user_details_s['profilename'];
				
				}else{
				  
				  $commented_user_s = $get_user_details_s['first_name']." ".$get_user_details_s['last_name'];
				  
				}
			  
			}
			
			if($thread_data_row_s['from_user_type'] == "club"){
			  
			  $get_club_detls_s = mysql_query("SELECT first_name, last_name, club_name FROM clubs WHERE id = '".$thread_data_row_s['from_user']."'");
			  $get_club_details_s = mysql_fetch_assoc($get_club_detls_s);
			  
			  if(!empty($get_club_details_s['club_name'])){
				
				  $commented_user_s = $get_club_details_s['club_name'];
				
				}else{
				  
				  $commented_user_s = $get_club_details_s['first_name']." ".$get_club_details_s['last_name'];
				  
				}			  
			  
			}
			
			$cdate_s = date("F j, Y, g:i a", strtotime($thread_data_row_s['commented_on'])); ?>
			
			<i style="font-style: italic; font-weight: bold;"><?php echo $commented_user_s; ?></i> commented on <i style="font-style: italic;"><?php echo $cdate_s; ?></i><br />
		  </div><div class="descinner">	<?php echo $thread_data_row_s['comment']; ?></div>
          </div>
		  <div class="comment_s_udate"></div>
		</div>
		
		<?php }}
		$comment_date_s = date("Y-m-d H:i:s"); ?>
		<div id="show_thread_after_<?php echo $support_row['id']; ?>"></div>
					  
		<?php if(isset($_SESSION['user_id']) && isset($_SESSION['user_type'])){ ?>			  
					  
		<div class="box3 1">
		  
		  <form class="forum_thread_form" action="" method="POST" onsubmit="return validatesupportForm('<?php echo $support_row['id']; ?>')">
			<div class="comment_txt v2_add_comment">
			  <textarea id="comment_textarea_<?php echo $support_row['id']; ?>" name="comment" rows="10" cols="92" placeholder="Write a comment.."></textarea>
			  <div class="errorforsignup_<?php echo $support_row['id']; ?>" for="comment" style="display: none; color: red;">Please Enter Comment.</div>
			</div>
			
			<div align="center" class="submit_support">
			  <input type="hidden" name = "from_user" value="<?php echo $_SESSION['user_id']; ?>">
			  <input type="hidden" name = "from_user_type" value="<?php echo $_SESSION['user_type']; ?>">
			  <input type="hidden" name = "to_user" value="<?php echo $support_details_s['user_id']; ?>">
			  <input type="hidden" name = "to_user_type" value="<?php echo $support_details_s['user_type']; ?>">
			  <input type="hidden" name = "commented_on" value="<?php echo $comment_date_s; ?>">
			  <input type="hidden" name = "support_id" value="<?php echo $support_details_s['id']; ?>">
			  <input type="submit" value="Add Comment" class="button" name="submit_comment">
			</div>
		  </form>
		  
		</div>

	  <?php }} ?>									  
									</ul>	
								</div>
							</li>
							
							<!--<div class="description">Lorem Ipsum text Lorem Ipsum is simply a dummy ytext of the printing industry. Lorem Ipsum is simply a dummy ytext of the printing industry.</div>-->
							
							<?php }} ?>
						  </ul>
						</div>
					  </div>
					  <div class="support_right">
						<h1> Support Videos</h1>
						<?php
				  $get_support_videos = mysql_query("SELECT * FROM help_and_support_videos ORDER BY added_on DESC");
				  
				  $count_vids = mysql_num_rows($get_support_videos);
				  ?>
						<div class="support_video_box">
						  <ul>
							<?php
					  if($count_vids < 1){ ?>
							<li>
							  <h1>No Videos Found</h1>
							</li>
							<?php }else{
						
						while($rowss = mysql_fetch_assoc($get_support_videos)){ ?>
							<li onclick="goto_demo_vid('playHelpVideo.php?video=<?php echo $rowss['support_video'];?>', 'Demo Video', '900', '500');" style="cursor:pointer;"> <a href="javascript:void(0);">
							  <h1><?php echo $rowss['support_video_title']; ?></h1>
							  </a> 
							  <!--<img src="images/img-video.jpg" alt="">--> 
							  
							  <!--                            <a href="#dialogx" name="modal">
										  <div id="a<?php echo $rowss["id"];?>"></div>
											  <script type="text/javascript">
											   jwplayer("a<?php echo $rowss["id"];?>").setup({
												  file: "<?php echo $rowss['support_video'];?>",
												  height : 200,
												  width: 200
												  });
											  </script>
										  </a>--> 
							</li>
							<?php
						}
					  }	?>
						  </ul>
						</div>
					  </div>
					  
					  <!--<h1 class="soon">Coming Soon</h1>--> 
					</div>				  
		 
		</div>
 
	
	</div>
</div>
<?php 
if(!isset($_SESSION['user_id'])){
	include('LandingPageFooter.php');
}
else{
	include('Footer.php');
}
 ?>
