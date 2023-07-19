<?php

include("Query.Inc.php");

$Obj = new Query($DBName);

ini_set('post_max_size', '64M');

ini_set('upload_max_filesize', '64M');

$userID=$_SESSION['user_id'];





$titleofpage="Upload your entry here";

include('LoginHeader.php');



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



<style>

#profile_box{min-height:0;}

#img_c{display: none;}
.agreebuttons {
	float: left;
	padding: 15px 0;
	width: 100%;
}

</style>

<!-- 



<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>

<script type="text/javascript" src="js/jquery.leanModal.min.js"></script> -->

<!-- <link type="text/css" rel="stylesheet" href="css/style_popup.css" /> -->

 <script type="text/javascript">



		

function Validate_cont_form_FileUpload(){

		var check_image_ext = $('#cont_from_img').val().split('.').pop().toLowerCase();

		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {

			alert('Forum Image only allows file types of GIF, PNG, JPG and JPEG');

			$('#cont_from_img').val('');

		}

}



function Validate_cont_form_VideoUpload(){

		var check_image_ext = $('#cont_from_vid').val().split('.').pop().toLowerCase();

			if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {

				alert('Forum Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');

					$('#cont_from_vid').val('');

		}

}

</script>

<script src="js/lk.popup.js"></script>

<style type="text/css">

#popup2{  background: #000 none repeat scroll 0 0;

  border: 4px solid #ff0;

  bottom: 0;

  height: auto;

  left: 0;

  margin: auto;

  max-height: 400px;

  max-width: 400px;

  overflow: auto;

  position: fixed;

  right: 0;

  top: 0;

  width: 100%;

  z-index: 2;}

#popup2 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}

#popup, .bMulti {

	background-color: #000;

	border-radius: 10px;

	color: #111;

	padding: 25px;

	display: none;

	

}

#popup2 span.b-close { border: none; float: right; min-width:auto;}

	.b-modal{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:99; opacity: 0.8; filter: alpha(opacity = 50); zoom:1; width:100%;}

#popup2 {

  background-color: #000;

  border: 5px solid #fecd07;

  border-radius: 10px;

  bottom: 0;

  box-shadow: none !important;

  color: #111;

  display: none;

  height: 600px;

  left: 0 !important;

  margin: auto;

  max-width: 400px;

  overflow: auto;

  padding: 0;

  position: fixed;

  right: 0;

  top: 17px !important;

  width: 100%;

  z-index: 2147483647 !important;

}

</style>





<?php



if($_POST['contest_form'])

  {

	$allowedExts = array("wmv","avi","mpeg","mpg");

	$extension = end(explode(".", $_FILES["file"]["name"]));

	

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

	}else

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

 		move_uploaded_file($tmp,$video_name);

	 	$file = $path1;

			   

		//indicate the path and name for the new resized file

		$resizedFile = $thumbnail;



		//call the function (when passing path to pic)

		//   smart_resize_image($image , null, 324 , 200 , false , $resizedFile , false , false ,100 );

		//call the function (when passing pic as string)

		//   smart_resize_image(null , file_get_contents($image), 324 , 200 , false , $resizedFile , false , false ,100)



		$resizeObj = new resize($file);



		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)

		$resizeObj -> resizeImage(300, 200, 'auto');



		// *** 3) Save image ('image-name', 'quality [int]')

		$resizeObj -> saveImage($resizedFile, 100);

		copy($video_name,$path1);

		$forum_img2=$video_name;

	}



	  

	$contest_id=$_REQUEST['id'];

	$user_id=$_SESSION['user_id'];

	$today = date("Y-m-d h:i:s");

	$ThisPageTable='contestent';

	$ValueArray = array($thumbnail,$contest_id,$user_id,$forum_img2,$today,$_POST['ctype']);	

	$FieldArray = array('video_thumb','contest_id','user_id','video_name','regi_date','contest_type');

	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);

	if($Success > 0)

	{

		$_SESSION['msg'] = 'Contest has been added successfully.';

				header("Location:challenge.php?cont_id=".$contest_id);die;

			

		

		

	}     

    

}



$id_contest=$_REQUEST['id'];

$contest_sql="SELECT * FROM `contest` where `status`='0' && contest_id='".$id_contest."'";

$contest_info = mysql_query($contest_sql);



$user_id=$_SESSION['user_id'];



$contestcheck = @mysql_query("SELECT * FROM `contestent` WHERE contest_id = '".$id_contest."' AND user_id = '".$user_id."'  ");

$countrows = @mysql_num_rows($contestcheck);

$redirectval = "challenge.php?cont_id=".$id_contest." ";



?>

<div class="clear"></div>

<div class="v2_container">

	<div class="v2_inner_main">

	<!-- SIDEBAR CODE  -->

	<?php 

		if($_SESSION['user_type'] == "club")

		{

			include('club-right-panel.php');

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

													$('#mycontent').html(data); 

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

													$('#mycontent').html(data); 

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

							<!--	<div id="popup2" style="">

						        			<span class="button b-close"></span>

						        			<div id="mycontent" style="height: auto; width: auto;">

						        			

						        			</div>

						    		</div>

								<div class="b-modal" id="b-modal __b-popup1__" style=""></div>-->

					               		<form name="contest_form" enctype="multipart/form-data" method="post" action="" onsubmit="return validate_contest_Form()">

					                			<div style="" class="contestFrm form_format" >

									   	<ul>

									               	<li class="cont_type"><span>Content Type:</span><br><p>Change to video or image</p></li>

									               	<li id="upld">

											   	<select name="ctype" onchange="changetype(this.value);">

										                   		<option value="video">Video</option>

										                    		<option value="image">Image</option>

											   	</select>

										   	</li>

						             			</ul>

										<ul id="vdv_c">

											<li id="upld" class="up_vid"><span>Upload Video:</span><p>Upload Up To 20 MB Video</p></li>

											<li>  

												<input type="file" id="cont_from_vid" name="uploadvideo" onchange="return Validate_cont_form_VideoUpload()"/>

												<p>(Allowed exts's .mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v)</p>

											</li>

											<input type="hidden" id="hidden_cont_from_vid" name="hidden_cont_from_vid" value="1">

										</ul>

										<ul  style="display:none;" id="img_c" >

											<li id="upld">Upload Image:</li>

											<li>

												<input type="file" id="cont_from_img" name="uploadimage" onchange="return Validate_cont_form_FileUpload()"/> (Allowed exts's gif, png, jpg & jpeg)

											</li>

											<input type="hidden"  id="hidden_cont_from_img" name="hidden_cont_from_img" value="0">

										</ul>

					             			</div>

									<ul class="btncenter_new sub_contst_form">

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

						        			<span class="button b-close">  </span>

						        			<div id="mycontent" style="height: auto; width: auto;">

						        			

						        			</div>

					    			</div>

								<div class="b-modal" id="b-modal __b-popup1__" style=""></div>

<?php include('Footer.php');?>

