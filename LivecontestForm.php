<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
}

$titleofpage="Contests Form";

include('NewHeadeHost.php');


//echo "<pre>"; print_r($_SESSION); exit;
// date_default_timezone_set('America/Chicago');

$id_contest=$_REQUEST['id'];
$contest_sql="SELECT * FROM `contest` where `status`='0' && contest_id='".$id_contest."'";
$contest_info = mysql_query($contest_sql);

$checkcontestsql = @mysql_query("SELECT * FROM `contest` WHERE contest_id = '".$id_contest."' ");
$getcheckarray = @mysql_fetch_array($checkcontestsql);


if($_POST['contest_form'])
{
	
// echo "<pre>"; print_r($_POST); exit;
	$user_id=$_SESSION['user_id'];
	$today = date("Y-m-d H:i:s");
	$ThisPageTable='contestent';
	$user_type = $_SESSION['user_type'];
	
	$contest_id = $_GET['id'];
	$forum_img2 = $_SESSION['img'];

	if(!empty($_FILES['LiveVideo']['name']))
	{
		$contestTYPE = 'video';
		$contest_video=$_FILES["LiveVideo"]["name"];
		$tmp = $_FILES["LiveVideo"]["tmp_name"]; 	
	 	$video_name = "contest_video/".time().strtotime(date("Y-m-d")).$contest_video; 
		$video_name1 = "video/forum_".time().strtotime(date("Y-m-d")).$contest_video; 
		move_uploaded_file($tmp,$video_name1);
		copy($video_name1, $video_name);
      		//move_uploaded_file($tmp,$video_name);
     		$forum_img2=$video_name;
		$forum_video=$video_name1;
		$thumbnail = $video_name;
	}
	else
	{
		$contestTYPE = 'image';
		$thumbnail = $_SESSION['img'];
	}

	$ValueArray = array($_POST['contestantAddress'],$thumbnail,$contest_id,$user_id,$forum_img2,$today,$contestTYPE, $user_type);
	$FieldArray = array('city','video_thumb','contest_id','user_id','video_name','regi_date','contest_type','user_type');
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	$lastID = mysql_insert_id();
	//$lastindertid = mysql_query("SELECT * FROM `contestent` WHERE `video_name` = '$forum_img2' ");
	//$fetchres = mysql_fetch_array($lastindertid);
	

	if($Success)
	{
		
		mysql_query("INSERT INTO `contest_video_like` (`user_type`,`c_like_user_id`,`c_video_user_id`,`constest_id`,`c_video_id`,`vote_type`)
				VALUES ('$_SESSION[user_type]','$user_id','','$contest_id','$lastID','yes')

		  ");
		$contestName = $_POST['contestName'];
		$_SESSION['msg'] = 'Contest has been added successfully.';
		
			$str = "
				<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
				<div style='width:100%;'>
					<div class='logo' style='float: left; margin-right:20px;'>
						<img src='".$base_url."images/new_portal/images/logo.png' border='0' />
					</div>
					<div style='float:left; margin-top: 50px;'>
						<p style='color: white;'>
						Welcome to the MYSITTI family and be a part of the next social revolution. <br /> 
						Visit <a srtle='color:#fecd07;' href='".$base_url."'>mysittidev.com</a> where we are <span style='color:#fecd07'>MAKING EVERY CITY YOUR CITY!</span>
						</p>
					</div>
				</div>
				<hr style='float:left; width:100%;'>
				<p style='color: white; float: left;width:100%;'>
				You have successfully ENTERED to the following Contest: 
				<br/> <br/> 
				Contest Name: <span style='color:#fecd07;'>".$contestName."</span> <br><br/><br/>
				You can start the LIVE streaming onto mysittidev.com and have as many fans watch and vote (Shouts) for you during these dates.<br /><br />
				
				Contest Start : ".date("M j,Y G:i A T",strtotime($_POST['contestStart']))."<br>
				Contest End : ".date("M j,Y G:i A T",strtotime($_POST['contestEnd']))."<br>
				
					
			 ";
			$str .= "<br/> Thank you, <br>";
			$str .= " MySitti Team </p>
				</div>";
			$message = $str; 
			$to  = $_POST['contestantEmail'];
			//$to  = "sumit.manchanda@kindlebit.com";
			
			$subject = "Live Contest Registration";
			$message = $str;
			//$from = "info@mysittidev.com";
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: MySitti <mysitti@mysittidev.com>' . "\r\n";
			//$headers .= "From:" . $from;
			
			mail($to,$subject,$message,$headers,"-finfo@mysittidev.com");
			//echo "test Mail Sent.";
		header("Location:LiveContest.php?contid=".$contest_id); exit;

		die;
	}     
	
}


$user_id=$_SESSION['user_id'];

$contestcheck = @mysql_query("SELECT * FROM `contestent` WHERE contest_id = '".$id_contest."' AND user_id = '".$user_id."'  ");
$countrows = @mysql_num_rows($contestcheck);
$redirectval = "LiveContest.php?contid=".$id_contest; 
?>
<script>
	function changetype(val)
	{
		  if(val=="video")
		  {
			$('#vdv_c').show();
			$('#img_c').hide();
			$('#hidden_cont_from_vid').val(1);
			$('#hidden_cont_from_img').val(0);
		  }else
		  {
			 $('#vdv_c').hide();
			 $('#img_c').show();
			 $('#hidden_cont_from_vid').val(0);
			 $('#hidden_cont_from_img').val(1);
		  }
	}		
</script>
<script src="js/lk.popup.js"></script>
<style>
.bgpopup_overlay {
  bottom: 0;
  left: 0;
  margin: auto;
  max-height: 550px;
  max-width: 500px;
  overflow: auto;
  padding: 5px 5px 20px !important;
  position: fixed;
  right: 0;
  z-index: 2147483647;
}
#popup, #popup2, #popup3, .bMulti {  padding:5px 5px 20px !important; overflow: auto;}
.content_txt p {
  margin-bottom: 10px;
  text-align: left;
  line-height: normal;
}
.agreebuttons .button {
  float: left;
}
#mycontent .agreebuttons {
  padding: 20px 0;
}
 @media only screen and (max-width:540px){
 #popup2 {  padding:10px !important; max-width:260px; margin:auto; max-height:300px; overflow:auto;}
 }


.form_format1 ul
{
	float: left;
	width: 100%;
}

</style>
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
			<h3 id="title">Verify Your Information</h3>
			<!-- <a id="agreement" href="agreement.php" rel="lightbox" >Agreement</a> --> 
			<!-- <a class="button" href="#modal" id="modal_trigger" style="font-size: 14px; float:right;">Add Post</a> -->
			<?php 
					   while($row =@mysql_fetch_array($contest_info))
						{
							 $imgpath= strstr($row['contest_img'],"contest_img"); 
					   ?>
			<div class="content1s">
			  <?php 
					   $imgpath= strstr($row['contest_img'],"contest_img"); 
					   
						if($imgpath=="")
					   {
					   ?>
			  <div class="pic2"><img src="../images/contest.png" width="200px" height="175px" /></div>
			  <?php
					   }
						else
						{
						?>
			  <div class="pic2"><img src="<?php echo $imgpath; ?>" width="200px" height="175px" /></div>
			  <?php } ?>
			  <div class="content_txt">
				<h1>Contest Title:</h1>
				<p><?php echo $row['contest_title']; ?> </p>
				<h1>Contest Description:</h1>
				<p><?php echo $row['contest_desc']; ?> </p>
				<h1>Rules:</h1>
				<p><?php echo substr($row['contest_rule'], 0, 300); ?> </p>
			  </div>
			</div>
			<?php }  ?>
			<div id="profile_box" class="brw">
			  <?php 
								if($countrows > 0)
								{
									?>
			  <script type="text/javascript">
											$(document).ready(function(){
												var id = '<?php echo $id_contest; ?>';
												var redirect = '<?php echo $redirectval; ?>';
												$.ajax({
													type: 'POST',
													url: 'contestError.php',
													data: {
														'id' : id,
														'redirect' : redirect
													},
													success: function(data) {
														$('#popup2 #mycontent').html(data); 
													}
												});

										
											});

								</script>
			  <?php 
								}
								else
								{



							?>
			  <script type="text/javascript">
									$(document).ready(function(){
										var redirect = '<?php echo $redirectval; ?>';
										$.ajax({
											type: 'POST',
											url: 'agreement.php',
											data: {
												'contid' : '<?php echo $id_contest; ?>',
												'redirect1' : redirect
											},
											success: function(data) {
												$('#popup2 #mycontent').html(data); 
											}
										});


									});
									
									function Validate_cont_form_FileUpload(){
											var check_image_ext = $('#cont_from_img').val().split('.').pop().toLowerCase();
											if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
												alert('Contest Image only allows file types of GIF, PNG, JPG and JPEG');
												$('#cont_from_img').val('');
											}
									}
									
									function Validate_cont_form_VideoUpload(){
											var check_image_ext = $('#cont_from_vid').val().split('.').pop().toLowerCase();
												if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
													alert('Contest Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
														$('#cont_from_vid').val('');
											}
									}					

									
									function validate_contest_Form(){
										
										
										if ($('#hidden_cont_from_vid').val() == "1") {
											
											if ($('#cont_from_vid').val() == "") {
												alert("Please select contest video");
												return false;
											}else{
												return true;
											}
										}
										
										
										if ($('#hidden_cont_from_img').val() == "1") {
											
											if ($('#cont_from_img').val() == "") {
												alert("Please select contest image");
												return false;
											}else{
												return true;
											}
										}
										
									}					
								</script>
			  <?php 
				$getClubInfo = mysql_query("SELECT `club`.`club_name`,`club`.`club_email`,`club`.`club_contact_no`,`city`.`city_name`,`state`.`name`,`state`.`code`
								FROM `clubs` as club, `capital_city` as city, `zone` as state
								WHERE `club`.`id` = '$_SESSION[user_id]'
								AND `club`.`club_city` = `city`.`city_id`
								AND `club`.`club_state` = `state`.`zone_id`
				 ");

				$fetchClubInfo = mysql_fetch_assoc($getClubInfo);




				?>
			  <div class="b-modal" id="b-modal __b-popup1__" style=""></div>
			  <form name="contest_form" enctype="multipart/form-data" method="post" action="" onsubmit="return validate_contest_Form()">
				<div style="" class="contestFrm form_format1" >
				  <ul>
					<li>Contest Name</li>
					<li>
					  <input readonly="readonly" type="text" name="contestName" value="<?php echo $getcheckarray['contest_title'];?>" />
					</li>
				  </ul>
				  <ul>
					<li>Contest Start Date</li>
					<li>
					  <input readonly="readonly" type="text" name="contestStart" value="<?php echo $getcheckarray['contest_start']." ".$getcheckarray['start_time'];?>" />
					</li>
				  </ul>
				  <ul>
					<li>Contest End Date</li>
					<li>
					  <input readonly="readonly" type="text" name="contestEnd" value="<?php echo $getcheckarray['contest_end']." ".$getcheckarray['end_time'];?>" />
					</li>
				  </ul>
				  	<div class="block_Divider">
           						<h3 style="margin: 10px 0;">Contestant Information</h3>
					</div>
				  <ul>
					<li>Contest Registratioin Date</li>
					<li>
					  <input  readonly="readonly" type="text" name="contestantRegistration" value="<?php echo date('Y-m-d H:i:s');?>" />
					</li>
				  </ul>
				  <ul>
					<li>Name</li>
					<li>
					  <input type="text" name="contestantName" value="<?php echo $fetchClubInfo['club_name'];?>" />
					</li>
				  </ul>
				  <ul>
					<li>City / State</li>
					<li>
					  <input type="text" name="contestantAddress" value="<?php echo $fetchClubInfo['city_name'].", ".$fetchClubInfo['code'];?>" />
					</li>
				  </ul>
				  <ul>
					<li>Email</li>
					<li>
					  <input type="text" name="contestantEmail" value="<?php echo $fetchClubInfo['club_email'];?>" />
					</li>
				  </ul>
				  <ul>
					<li>Phone#</li>
					<li>
					  <input type="text" name="contestantContact" value="<?php echo $fetchClubInfo['club_contact_no']; ?>" />
					</li>
				  </ul>
				<ul>
					<li>Upload Video</li>
					<li>
					<input type="file" name="LiveVideo"  />
					</li>
				</ul>
				</div>
				<ul class="btncenter_new">
				  <li>
					<input class="button" name="contest_form" type="submit" value="Register"  style="margin-left:0px !important"/>
				  </li>
				  <li>
					<input onclick="location.href = '<?php echo $redirectval;?>';" type="button" value="Cancel" class="button button" style="float: right;">
				  </li>
				</ul>
			  </form>
			  <?php } ?>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="equalizer"></div>
	</article>
	<div class="bgpopup_overlay">
	  <div id="popup2" class="enter_contest" style="z-index:200;"> 
		<!-- <span class="button b-close">X</span> -->
		<div id="mycontent" style="height: auto; width: auto;"> </div>
	  </div>
	</div>
	<div class="b-modal" id="b-modal __b-popup1__" style=""></div>
  </div>
  <div class="clear"></div>
</div>
<?php include('Footer.php');?>
