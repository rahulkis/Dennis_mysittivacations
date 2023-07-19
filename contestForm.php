<?php

include("Query.Inc.php");

$Obj = new Query($DBName);



$userID=$_SESSION['user_id'];

$userID=$_SESSION['user_id'];

$userType= $_SESSION['user_type'];

if(!isset($userID)){

	$Obj->Redirect("login.php");

}



$titleofpage=" Contests Form";

include('NewHeadeHost.php');

$id_contest=$_REQUEST['id'];

$contest_sql="SELECT * FROM `contest` where `status`='0' && contest_id='".$id_contest."'";

$contest_info = mysql_query($contest_sql);



$checkcontestsql = @mysql_query("SELECT * FROM `contest` WHERE contest_id = '".$id_contest."' ");

$getcheckarray = @mysql_fetch_array($checkcontestsql);


if($_POST['contest_form'])

  {



/* CODE FOR FORUM POST */

	$allowedExts = array("wmv","avi","mpeg","mpg");

	$extension = end(explode(".", $_FILES["file"]["name"]));

	$video_name1 = '';

	$thumbnail = '';

	if($_POST['ctype']=="video")

	{

		$contest_video=$_FILES["uploadvideo"]["name"];

		$tmp = $_FILES["uploadvideo"]["tmp_name"]; 	

		

		$video_name = "contest_video/".time().strtotime(date("Y-m-d")).$contest_video; 



		$video_name1 = "video/forum_".time().strtotime(date("Y-m-d")).$contest_video; 



		

		

			move_uploaded_file($tmp,$video_name1);



			copy($video_name1, $video_name);





			//move_uploaded_file($tmp,$video_name);

			$forum_img2=$video_name;

			$forum_video=$video_name1;



	}

	else

	{

		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");

		$temp = explode(".", $_FILES["uploadimage"]["name"]);

		$extension = end($temp);

		$contest_video=$_FILES["uploadimage"]["name"];

		$tmp = $_FILES["uploadimage"]["tmp_name"]; 

		$video_name = "contest_img/".time().strtotime(date("Y-m-d")).$contest_video; 

		$ext =substr($contest_video,strrpos($contest_video,'.'));

		$path1 = "upload/forum_".time().strtotime(date("Y-m-d")).$contest_video;

		$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$contest_video."_thumbnail".$ext;

		$thumbnail = "contest_img/".$thumb;

		move_uploaded_file($tmp,$path1);

		//indicate which file to resize (can be any type jpg/png/gif/etc...)move_uploaded_file($tmp,$video_name);



		$file = $path1;

			

		//indicate the path and name for the new resized file

		$resizedFile = $thumbnail;

		

		//call the function (when passing path to pic)

		//smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );

		//call the function (when passing pic as string)

		//smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );

		$resizeObj = new resize($file);



		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)

		$resizeObj -> resizeImage(300,200, 'auto');



		// *** 3) Save image ('image-name', 'quality [int]')

		$resizeObj -> saveImage($resizedFile, 100);	





		copy($thumbnail,$video_name);



		$forum_img2=$video_name;

				

		

		

	}

	$contest_id=$_REQUEST['id'];

	$forum='';

	

	$user_id=$_SESSION['user_id'];
	$user_type=$_SESSION['user_type'];
	if($user_type == 'user')
	{
		$getEmail = mysql_query("SELECT `email` as `Email` FROM `user` WHERE `id` = '$user_id' ");

	}
	else
	{
		$getEmail = mysql_query("SELECT `club_email` as `Email` FROM `clubs` WHERE `id` = '$user_id' ");
	}

	$fetchRes = mysql_fetch_assoc($getEmail);

	$added_on=date("Y-m-d h:i:s");

	$status=1;

	//$forum_city=

	$ThisPageTable1='forum';

	$ValueArray1 = array($_SESSION['user_type'],$thumbnail,'contest',$forum,$forum_img2,$forum_video,$user_id,$added_on,$_SESSION['id'],'public',$status,$contest_id,'','');

	$FieldArray1 = array('user_type','image_thumb','post_from','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','contest_id','friends_id','group_id');



	//$Success1 = $Obj->Insert_Dynamic_Query($ThisPageTable1,$ValueArray1,$FieldArray1);



	$user_id=$_SESSION['user_id'];

	$today = date("Y-m-d h:i:s");

	$ThisPageTable='contestent';

	$user_type = $_SESSION['user_type'];

	$ValueArray = array($thumbnail,$contest_id,$user_id,$forum_img2,$today,$_POST['ctype'], $user_type);

	$FieldArray = array('video_thumb','contest_id','user_id','video_name','regi_date','contest_type','user_type');

	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);

	$lastindertid = mysql_query("SELECT * FROM `contestent` WHERE `video_name` = '$forum_img2' ");

	$fetchres = mysql_fetch_array($lastindertid);

	



	if($Success)

	{

		mysql_query("INSERT INTO `contest_video_like` (`user_type`,`c_like_user_id`,`c_video_user_id`,`constest_id`,`c_video_id`,`vote_type`)

				VALUES ('$_SESSION[user_type]','$user_id','','$fetchres[contest_id]','$fetchres[c_video_id]','yes')



		  ");

		

		$_SESSION['msg'] = 'Contest has been added successfully.';
		$getmessage = mysql_query("SELECT * FROM `pages` WHERE `page_name` = 'Contest Email Message' ");
		$res = mysql_fetch_assoc($getmessage);
		$str = "
				<div style=''>
				<style>p(float:left; width:100%; text-align:center;)</style>
				<div style='margin:10px auto; display:inline-block; width: 700px; background:url(https://mysittidev.com/images/emailbg.jpg) #000 center top no-repeat; background-size:100%;  padding: 170px 20px 20px 20px;'>
				<div style='width:100%; word-wrap:break-word; word-break: break-all; color:#fff;'>
				<div style='float:left;width:100%;text-align:center;'>
					<div class='logo' style='float: left; margin-right:20px; text-align:center; width:100%;'>
						<img width='150px' src='".$base_url."images/maillogo.png' border='0' />
					</div>
					
				</div>
			 
				<div style='color: white; float:left; text-align:center; width:100%;'>".$res['page_data']."  ".$getcheckarray['contest_title']." </p>
 				
			 ";
			$str .= "<br/> Thank you, <br>";
			$str .= " MySitti Team </div></div>
				</div></div>";
			$message = $str; 
	    		$to  = $fetchRes['Email'];
			//$to  = "alyssarichie3@gmail.com";
			// $to  = "mancsumit@gmail.com";
			
			$subject = "Talent Contest Registration";
			$message = $str;
			//$from = "info@mysittidev.com";
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: MySitti <mysitti@mysittidev.com>' . "\r\n";
			//$headers .= "From:" . $from;
			
			mail($to,$subject,$message,$headers,"-finfo@mysittidev.com");



		if(isset($_GET['host']) && $_GET['host'] =='hostUser')

		{

			header("Location:my_contests.php?msg=success");

		}

		else

		{

			if(isset($_GET['hostID']))

			{

				header("Location: view_contestent.php?cont_id=".$_GET['id']."&hostID=".$_GET['hostID']); exit;

			}else

			{

				header("Location:mysitti_contests.php?contid=".$contest_id); exit;

				

			}

		}

		die;

	}     

	

}









if( ($getcheckarray['user_id'] == 0 ) && ($getcheckarray['host_id'] != 0 ) )

{

	//die('if');

	$redirectval = "view_contestent.php?cont_id=".$id_contest."&hostID=".$getcheckarray['host_id']."  ";

}

else

{

	//die('else');

	$redirectval = "mysitti_contests.php?contid=".$id_contest." ";	

}



$user_id=$_SESSION['user_id'];



$contestcheck = @mysql_query("SELECT * FROM `contestent` WHERE contest_id = '".$id_contest."' AND user_id = '".$user_id."'  ");

$countrows = @mysql_num_rows($contestcheck);



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

		}

		else

		{

			$('#vdv_c').hide();

			$('#img_c').show();

			$('#hidden_cont_from_vid').val(0);

			$('#hidden_cont_from_img').val(1);

		}

	}		

</script>
<script src="js/lk.popup.js"></script>
<style type="text/css">
#popup2 {
	position:fixed;
	width:400px;
	height:auto;
	overflow:auto;
	background:#000;
	z-index:2;
	top: 100px !important;
}
#popup2 span#close {
	float:right;
	margin:10px;
	color:#fff;
	font-weight:bold;
}
#popup, .bMulti {
	background-color: #000;
	border-radius: 10px;
	color: #111;
	padding: 25px;
	display: none;
}
#popup2 span.b-close {
	border: none;
	float: right;
	min-width:auto!important
}
.b-modal {
	display: none;
	position:fixed;
	left:0;
	top:0;
	height:100%;
	background:#000;
	z-index:99;
	opacity: 0.5;
	filter: alpha(opacity = 50);
	zoom:1;
	width:100%;
}
#popup2 {
	background-color: #000;
	border: 5px solid #fecd07;
	border-radius: 10px;
	bottom: 0;
	box-shadow: none !important;
	color: #111;
	display: none;
	height: 500px;
	left: 0 !important;
	margin: auto;
	max-width: 400px;
	overflow: auto;
	padding: 0;
	position: fixed;
	right: 0;
	top: 0 !important;
	width: 100%;
	z-index: 2147483647 !important;
}

.agreebuttons {
  float: left;
  padding: 15px 0;
  width: 100%;
}

 @media only screen and (min-width:768px) and (max-width: 1024px)   { 
 .contestFrm.form_format1 li {
  float: left;
  width: 100% !important;
}

 }
 
 @media only screen and (max-width: 767px) {
 article { 
  width: 100% !important;
}
 .contestFrm.form_format1 li {
  float: left;
  width: 100% !important;
}
#popup2 {max-width:300px; padding:5px; box-sizing:border-box; -webkit-box-sizing:border-box; -ms-box-sizing:border-box;}
.agreebuttons {
  margin-bottom: 32px;
}
 }
 
 @media only screen and (max-width: 540px) {
#popup2 {max-width:300px; padding:10px; max-height:400px; overflow:auto;}
.agreebuttons {
  margin-bottom: 32px;
} 
 }
</style>

<div class="clear"></div>
<div class="v2_container">
  <div class="v2_inner_main"> 
	
	<!-- SIDEBAR CODE  -->
	
	<?php 

		if($_SESSION['user_type'] == "club")

		{

			include('club-right-panel.php');

		}elseif($_SESSION['user_type'] == 'user'){

			include('friend-right-panel.php');

		}
		else

		{

			include('friend-right-panel.php');

		}

	?>
	
	<!-- END SIDEBAR CODE -->
	
	<article class="forum_content v2_contentbar">
	  <div class="v2_rotate_neg">
		<div class="v2_rotate_pos">
		  <div class="v2_inner_main_content">
			<h3 id="title">Contests Form</h3>
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

													$('#mycontent122').html(data); 

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

													$('#mycontent122').html(data); 

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
			  <form name="contest_form" enctype="multipart/form-data" method="post" action="" onsubmit="return validate_contest_Form()">
				<div style="" class="contestFrm form_format1" >
				  <ul>
					<li>Content Type:<br>
					  Change to video or image</li>
					<li id="upld">
					  <select name="ctype" onchange="changetype(this.value);">
						<option value="video">Video</option>
						<option value="image">Image</option>
					  </select>
					</li>
				  </ul>
				  <ul id="vdv_c">
					<li id="upld">Upload Video:
					  <p>Upload Up To 20 MB Video</p>
					</li>
					<li>
					  <input type="file" id="cont_from_vid" name="uploadvideo" onchange="return Validate_cont_form_VideoUpload()"/>
					  <p>(Allowed exts's .mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v)</p>
					</li>
					<input type="hidden" id="hidden_cont_from_vid" name="hidden_cont_from_vid" value="1">
				  </ul>
				  <ul  style="display:none;" id="img_c" >
					<li id="upld">Upload Image:</li>
					<li>
					  <input type="file" id="cont_from_img" name="uploadimage" onchange="return Validate_cont_form_FileUpload()"/>
					  (Allowed exts's gif, png, jpg & jpeg) </li>
					<input type="hidden"  id="hidden_cont_from_img" name="hidden_cont_from_img" value="0">
				  </ul>
				</div>
				<ul class="btncenter_new">
				  <li>
					<input class="button" name="contest_form" type="submit" value="Submit"  style="margin-left:0px !important"/>
				  </li>
				  <li>
					<input onclick="location.href = '<?php echo $redirectval;?>';" type="button" value="Back" class="button button" style="float: right;">
				  </li>
				</ul>
			  </form>
			  <?php 	} 	?>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="equalizer"></div>
	</article>
  </div>
  <div class="clear"></div>
</div>

  
 	<div id="popup2" style=""> 
		<div id="mycontent122" style="height: auto; width: auto;"> </div>
	</div>

	<div class="b-modal" id="b-modal __b-popup__" style=""></div>
			  
</div>

<?php include('Footer.php');

?>
