<?php

include("Query.Inc.php");

$Obj = new Query($DBName);



if(!isset($_SESSION['user_id'])){

	$Obj->Redirect("login.php");

}



if(isset($_POST['create_security_code'])){

	

	echo rand(100,999);

	die;

}



/*******************************  FACEBOOK SHARE CODE  ***********************************/



require_once 'facebook-php-sdk-v4-4.0-dev/autoload.php';



use Facebook\FacebookSession;

use Facebook\FacebookRequest;



FacebookSession::setDefaultApplication( FBAPPID,FBAPPSECRET );



/*******************************  FACEBOOK SHARE CODE  ***********************************/



if($_SESSION['user_type'] == "user"){

	$Obj->Redirect("profile.php");

}



if(isset($_REQUEST['id']))

{

	$userID=$_REQUEST['id'];

}

else 

{

	$userID=$_SESSION['user_id'];	

}

$sql = "select * from `clubs` where `id` = '".$userID."'";

$userArray = $Obj->select($sql) ;

$para="";

if(isset($_REQUEST['msg']))

{

	$para=$_REQUEST['msg'];

}



if($para!="");

{

	if($para=="update")

	{

		$message="Pass Updated Sucessfully";

	}

	if($para=="delete")

	{

		$message="Pass Deleted Sucessfully";

	}

}

		

$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");

$rw_row_fe=@mysql_fetch_assoc($sql_fe);



$titleofpage="Pass Uploads";



if(isset($_GET['host_id']))

{

	include('NewHeadeHost.php');

}

else

{

	include('NewHeadeHost.php');	

}



$userType= $_SESSION['user_type'];

$userID = $_SESSION['user_id'];

	/******************/

	if(isset($_POST['update']))

	{

		

		$pass_id = $_POST['pass_id'];

		$pass_name = $_POST['cname'];

		$pass_expiry_date = $_POST['c_exp_date'];

		$host_id = $_SESSION['user_id'];

		$security_code = $_POST['security_code'];

		

		if($_FILES['update_adv_img']['error'] == 4)

		{

			$pass_thumb = $_POST['pass_thumb'];

			$pass_image = $_POST['pass_image'];

		}

		else

		{

			$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");

			$temp = explode(".", $_FILES["update_adv_img"]["name"]);

			$extension = end($temp);

			$name = $_FILES["update_adv_img"]["name"];

			$ext =substr($name,strrpos($name,'.'));

			$u_video = strtotime(date("Y-m-d"))."_".$_FILES["update_adv_img"]["name"];

	

			$tmp = $_FILES["update_adv_img"]["tmp_name"]; 

			$v_name = "upload/coupon/".$u_video;

			$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$u_video."_thumbnail".$ext;

			$thumbnail = "upload/coupon/".$thumb;

			//$image_path="upload/".$thumb; 

			move_uploaded_file($tmp,$v_name);



			$file = $v_name;

			

			//indicate the path and name for the new resized file

			$resizedFile = $thumbnail;

			

			//call the function (when passing path to pic)

		//	smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );

			//call the function (when passing pic as string)

		//	smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );



			$resizeObj = new resize($file);



		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)

			$resizeObj -> resizeImage(300,200, 'auto');



			// *** 3) Save image ('image-name', 'quality [int]')

			$resizeObj -> saveImage($resizedFile, 100);	

			$image=$u_video;

			

			$pass_thumb = $thumbnail;

			$pass_image = $image;

		}

		

		$updt_pass = @mysql_query("UPDATE host_coupon SET max_download = '".$_POST['max_download']."', coupon_name = '".$pass_name."', coupon_image = '".$pass_image."', coupon_thumb = '".$pass_thumb."', expiry_date = '".$pass_expiry_date."', security_code = '".$security_code."' WHERE id = '".$pass_id."'");

		

		/*******************************  FACEBOOK SHARE CODE  ***********************************/

		

		if(isset($_SESSION['fb_token']))

		{

			

			if(!empty($pass_thumb)){

				

				$shout_img = $base_url.$pass_thumb;

			}

			else

			{

				$shout_img = $base_url."images/logo.jpg";

			}

			

			$session = new FacebookSession( $_SESSION['fb_token'] );

			

			// graph api request for user data

			$request = 	new FacebookRequest( $session, 'POST', '/me/feed', array(

						'name' => $_POST['cname'],

						'caption' => 'mysittidev.com',

						'link' => 'https://mysittidev.com',

						'message' => 'New Pass',

						'picture' => $shout_img

					) );

			$response = $request->execute();

		}

				

		/*******************************  FACEBOOK SHARE CODE  ***********************************/

		

		/** TWITTER POST SHARE **/

		

		if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 

		{

			include_once("twitter/config.php");

			include_once("twitter/inc/twitteroauth.php");

			

			//Success, redirected back from process.php with varified status.

			//retrive variables

			$screenname 		= $_SESSION['request_vars']['screen_name'];

			$twitterid 			= $_SESSION['request_vars']['user_id'];

			$oauth_token 		= $_SESSION['request_vars']['oauth_token'];

			$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];

		

			//Show welcome message

			echo '<div class="welcome_txt">Welcome <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php?reset=1">Logout</a>!</div>';

			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);

			

			//see if user wants to tweet using form.

			if(isset($_POST["cname"])) 

			{

				//Post text to twitter

				$my_update = $connection->post('statuses/update', array('status' => $_POST["cname"]));

				//die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php

			}

		}

				

		/**TWITTER POST SHARE**/				

		

		if($updt_pass == 1)

		{			

			header('Location: host_coupon.php?msg=updated');

			exit;			

		}

	}

	

	if(isset($_POST['submit']))

	{

		if($_FILES["adv_img"]["name"])

		{

					// get total count of downloaded coupon

			$tot_cu_cnt=@mysql_query("select id from  coupon_download where coupon_id='".$rw_row_fe['id']."' ");

			$cu_num=@mysql_num_rows($tot_cu_cnt);

			// end here 

			$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");

			$temp = explode(".", $_FILES["adv_img"]["name"]);

			$extension = end($temp);

			$name = $_FILES["adv_img"]["name"];

			$ext =substr($name,strrpos($name,'.'));

			$u_video = strtotime(date("Y-m-d"))."_".$_FILES["adv_img"]["name"];

			$tmp = $_FILES["adv_img"]["tmp_name"]; 

			$v_name = "upload/coupon/".$u_video;

			$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$u_video."_thumbnail".$ext;

			$thumbnail = "upload/coupon/".$thumb;

			//$image_path="upload/".$thumb; 

			move_uploaded_file($tmp,$v_name);

			$file = $v_name;

			

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

			



			$image=$u_video;

		}

			

		$sql_ck=@mysql_query("select id from  host_coupon where host_id='".$_SESSION['user_id']."'");

		$rw_row=@mysql_num_rows($sql_ck);

		$added_on = date('Y-m-d h:i:s');	

		$cname = mysql_real_escape_string($_POST['cname']);

		mysql_query("INSERT INTO `host_coupon` (`coupon_thumb`,`coupon_image`,`coupon_name`,`host_id`,`expiry_date`,`added_date`,`max_download`,`security_code`)

				VALUES ('$thumbnail','$image','$cname','$_SESSION[user_id]','$_POST[c_exp_date]','$added_on','$_POST[max_download]','$_POST[security_code]')");

		$inserted_pass_id = mysql_insert_id();

		$get_friends = @mysql_query("SELECT DISTINCT(friend_id) FROM friends WHERE user_id = '".$_SESSION['user_id']."' AND user_type='".$_SESSION['user_type']."' AND status = 'active' AND friend_type = 'user'");

		while($row_friends = mysql_fetch_assoc($get_friends))

		{

			mysql_query("INSERT INTO user_to_content (`user_id`, `owner_id`, `cont_id`, `cont_type`, `user_type`) VALUES('".$row_friends['friend_id']."', '".$_SESSION['user_id']."', '".$inserted_pass_id."', 'pass', 'club')");

			$pass_added_on = date('Y-m-d h:i:s');

			$c_identifier = "host_coupon_".$inserted_pass_id;

			mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$row_friends['friend_id']."', 'pass', '".$pass_added_on."', '1', '".$c_identifier."', 'club', 'user')");

		}



		/*******************************  FACEBOOK SHARE CODE  ***********************************/

		

		if(isset($_SESSION['fb_token']))

		{

			

			if(!empty($_FILES["adv_img"]["name"])){

				

				$shout_img = $base_url.$thumbnail;

				

			}else{

				

				$shout_img = $base_url."images/logo.jpg";

			}

			

			$session = new FacebookSession( $_SESSION['fb_token'] );

			

			// graph api request for user data

			$request = new FacebookRequest( $session, 'POST', '/me/feed', array(

			   'name' => $_POST['cname'],

			   'caption' => 'mysittidev.com',

			   'link' => 'https://mysittidev.com',

			   'message' => 'New Pass',

			   'picture' => $shout_img

			  ) );

			$response = $request->execute();

		}

		

		/*******************************  FACEBOOK SHARE CODE  ***********************************/

		

		/** TWITTER POST SHARE **/

		

		if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 

		{

			include_once("twitter/config.php");

			include_once("twitter/inc/twitteroauth.php");

			

			//Success, redirected back from process.php with varified status.

			//retrive variables

			$screenname 		= $_SESSION['request_vars']['screen_name'];

			$twitterid 			= $_SESSION['request_vars']['user_id'];

			$oauth_token 		= $_SESSION['request_vars']['oauth_token'];

			$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];

		

			//Show welcome message

			echo '<div class="welcome_txt">Welcome <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php?reset=1">Logout</a>!</div>';

			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);

			

			//see if user wants to tweet using form.

			if(isset($_POST["cname"])) 

			{

				//Post text to twitter

				$my_update = $connection->post('statuses/update', array('status' => $_POST["cname"]));

				//die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php

			}

		}

		

		/**TWITTER POST SHARE**/				

		

		$Obj->Redirect("host_coupon.php?msg=added");die;

	}



?>



<style>

	#couponupload_toggle{

		display: none;

	}

</style>		

<div class="clear"></div>

<div class="v2_container">

	<div class="v2_inner_main">

	<!-- SIDEBAR CODE  -->

	<?php include('club-right-panel.php'); ?>

	<!-- END SIDEBAR CODE -->

		<article class="forum_content v2_contentbar">

			<div class="v2_rotate_neg">

				<div class="v2_rotate_pos">

					<div class="v2_inner_main_content">

					<?php

						if($_GET['msg'] == "added")

						{

							echo '<div id="successmessage" style="display: block;">Pass Added Successfully</div> ';

						}

						elseif ($_GET['msg'] == "imagefail") 

						{

							# code...

							echo '<div id="successmessage" style="display: block;">Video failed to upload!</div> ';

						}

						elseif ($_GET['msg'] == "delete") 

						{

							# code...

							echo '<div id="successmessage" style="display: block;">Pass deleted successfully</div>';

						}

						elseif($_GET['msg'] == 'updated')

						{

							echo '<div id="successmessage" style="display: block;">Pass updated successfully</div>';

						} 

					?>



						<div id="profile_box">

							<?php if(isset($_GET['pass_id']))

							{

								echo '<h3 id="title" class="">Edit  Pass</h3>';

							}

							else

							{ 

								echo '<h3 id="title" class="">Upload  Pass</h3>';

							} 

															

							if(isset($_GET['pass_id']))

							{ 

						?>		<style type="text/css">

									#couponupload_toggle{

										display: block;

									}

								</style>

								

						<?php

								$get_pass_data = @mysql_query("SELECT * FROM host_coupon WHERE id = '".$_GET['pass_id']."'");

								$get_pass_edit_data = mysql_fetch_assoc($get_pass_data);

							} 

						 ?>	
						 		<div class="upload-banner">
						 			<img src="imagesNew/upload-pass.png" alt="banner">
						 			<h3> Connect and Increase Your Fan Base</h3>
						 			<span>Pass Giveaways</span>
						 			<p>
						 				Everyone knows that the best way to increase your fans and attendance to your shows is to giveaway

passes. This shows your loyal fans that you appreciate their support and will strengthen their relationship

with you. MySitti will track the number of passes you want to giveaway, this is a quick and easy process

that will greatly grow your fan base.
						 			</p>
									<?php 
									if(!isset($_GET['pass_id']))
									{					
										echo '<input class="button" type="button" onclick="toggle_add_pass();" value="Add Pass" style="float:right">';
									}
									?>
						 		</div>				

							<div id="couponupload_toggle" class="v2_editpass">

								<form id="couponupload" name="add_adv" method="post"   enctype="multipart/form-data" onsubmit="return validate_adv();">

									<input type="hidden" name="club_name" value="<?php  echo $first_name;?>">

									<div class="row">

										<span class="label">Pass Name:</span>

										<span class="formw control_editpass">

										<?php 

											if(!empty($get_pass_edit_data['coupon_name']))

											{ 

												echo '<input type="text" name="cname" id="cname" value="'.$get_pass_edit_data['coupon_name'].'">';

											}

											else

											{

												echo '<input type="text" name="cname" id="cname">';

											} 

										?>									

											<input  type="hidden" name="c_id" id="c_id">

										</span>

									</div>

									<div class="row" id="img-link">

										<span class="label">Maximum Downloads:</span>

										<span class="formw control_editpass">

									<?php 

										if(!empty($get_pass_edit_data['max_download']))

										{

											echo '<input readonly name="max_download" id="max_download" type="text" value="'.$get_pass_edit_data['max_download'].'"/>';

										}

										else

										{

											echo '<input name="max_download" id="max_download" type="text" />';

										}

										?>									

										</span>

									</div>

									<div class="row"  id="adv-img">

										<span class="label">Expiry Date:</span>

										<span class="formw control_editpass">

										<?php 

											if(!empty($get_pass_edit_data['expiry_date']))

											{

												echo '<input type="text" id="c_exp_date" name="c_exp_date" readonly class="dtpicker" value="'.$get_pass_edit_data['expiry_date'].'">';

											}

											else

											{

												echo '<input type="text" id="c_exp_date" name="c_exp_date" readonly class="dtpicker">';

											}

										?>

										</span>

									</div>

									<div class="row"  id="adv-img">

									<?php
										if(empty($get_pass_edit_data['security_code']))
										{ ?>
											<span class="label">Security Code:</span>
										<?php 
										} ?>
										<span class="formw control_editpass">

										<?php

										

											if(!empty($get_pass_edit_data['security_code']))

											{ 

											 echo '<a style="color: rgb(254, 205, 7); text-decoration: none; margin-right: 10px; cursor: default;" href="javascript: void(0);">Click here to generate secuity code</a> <input style="width: 15%;" placeholder="xxx" minlength="3" maxlength="3" type="text" id="security_code" name="security_code"  value="'.$get_pass_edit_data['security_code'].'" disabled>';

											 }

											else

											{

												echo '<a onclick="create_securitycode();" style="color: rgb(254, 205, 7); text-decoration: none; margin-right: 10px;" href="javascript: void(0);">Click here to generate secuity code</a> <input maxlength="3"  placeholder="xxx" minlength="3" style="width: 15%;" type="text" id="security_code" name="security_code" >';

											}

										?>

										</span>

									</div>									

							<?php 

								if(!empty($get_pass_edit_data['coupon_thumb']))

								{

							?>		

                            <div class="clear"></div>  

                            <div class="row v2_upload_pass"  id="adv-img">

										<span class="label" >Upload Pass:</span>

										<span class="formw control_editpass">

											<input onchange="return Validate_coupon_FileUpload()" id="update_adv_img" style="color:#FFF;" name="update_adv_img" type="file" /> (Allowed exts's gif, png, jpg & jpeg)

										</span>

									</div>

                                    <div class="clear"></div>								

									<div class="row thumb_editpass"  id="adv-img">

										<span class="label" >Pass Thumbnail:</span>

										<span class="formw">

											<img src="<?php echo $get_pass_edit_data['coupon_thumb']; ?>">

											<input type="hidden" value="<?php echo $get_pass_edit_data['coupon_thumb']; ?>" name="pass_thumb">

										</span>

									</div>

							<?php 	}

								else

								{

							?>		 <div class="clear"></div> <div class="row v2_upload_pass"  id="adv-img">

										<span class="label">Upload Pass:</span>

										<span class="formw allowed_ext">

											<input onchange="return Validate_coupon_FileUpload()" id="adv_img" style="color:#FFF;" required name="adv_img" type="file" /> <div class="clear"></div>(Allowed exts's gif, png, jpg & jpeg)

											<input type="hidden" name="old_name" id="old_name">

										</span>

									</div>								

							<?php 	} ?>                              

									<ul class="btncenter_new v2_coupn_btn">

									<?php 

										if(!empty($get_pass_edit_data['id']) && !empty($get_pass_edit_data['coupon_image']))

										{ 

									?>		<li>

												<input type="hidden" value="<?php echo $get_pass_edit_data['id']; ?>" name="pass_id">

												<input type="hidden" value="<?php echo $get_pass_edit_data['coupon_image']; ?>" name="pass_image">

												<input class="button"  style="float:none" name="update" type="submit" value="Update" /> &nbsp;&nbsp;&nbsp;

											</li>

											<li>

												<input class="button" onclick="location.href='host_coupon.php'" style="float:none" type="button" value="Cancel" /> &nbsp;&nbsp;&nbsp;

											</li>										

								<?php 		}

										else

										{ 

								?>			<li><input class="button"  style="float:none" name="submit" type="submit" value="Upload" /> &nbsp;&nbsp;&nbsp;</li>

											<li><input class="button" onclick="toggle_add_pass();" style="float:none" type="button" value="Cancel" /> &nbsp;&nbsp;&nbsp;</li>

								<?php 		}	?>

									</ul>                               

								</form>

							</div>

						</div><!-- END #profile_box -->

					<?php

						$get_passes = @mysql_query("SELECT * FROM host_coupon WHERE host_id='".$_SESSION['user_id']."' ORDER BY expiry_date DESC");

						$count_passes = mysql_num_rows($get_passes);

					?>

		 

      <div class="autoscroll">

							<table id="example" class="display loadmusic host_cp_table v2_host_coupn" style="margin-top:10px;">

								<thead>

									<tr bgcolor="#ACD6FE">

										<th>Pass Name</th>

										<th>Pass</th>

										<th>Expiry Date</th>

										<th>Status</th>

										<th>Action</th>

										<th>Security Code</th>

										<th>View Details</th>

									</tr>

								</thead>

								<tbody>

							<?php 

								if($count_passes < 1)

								{ 

							?>		<tr>

										<td colspan="7">

											No passes Found

										</td>

									</tr>

							<?php 	}

								else

								{

									$i=1;

									while($row = mysql_fetch_assoc($get_passes))

									{										

										if($i%2 == '0')

										{

											$class = " class='even' ";

										}

										else

										{

											$class = " class='odd' ";

										}												

							?>

										<tr <?php echo $class;?>>

											<td><?php echo $row['coupon_name']; ?></td>

											<td>

												<a class="fancybox" rel="group" href="upload/coupon/<?php echo $row['coupon_image']; ?>">

													<img width="50" src="<?php echo $row['coupon_thumb']; ?>">

												</a>

											</td>

											<td>

												<?php echo date('F j, Y l h:i:s A', strtotime($row['expiry_date'])); ?>

											</td>

											<td>

											<?php

												$now = time(); // or your date as well

												$your_date = strtotime($row['expiry_date']);

												$datediff =  $your_date - $now;

												$get_difference = floor($datediff/(60*60*24));	 

											 	if($get_difference < 0)

										 		{ 

										 			echo "Expired"; 

										 		}

										 		else

									 			{ 

								 					echo "Active"; 

								 				}

											?>					 

											</td>												

											<td>

												<a href="?page=edit&amp;pass_id=<?php echo $row['id'];  ?>">

													<img width="25px" height="25px" title="Edit" src="images/Edit.png">

												</a>

												<img onclick="delete_coupon('<?php echo $row['id'];  ?>');" style="cursor: pointer;" src="images/del.png" width="25px" title="Delete" height="25px">

											</td>

											<td><?php echo $row['security_code']; ?></td>

											<td>

												<a href="pass_detail.php?p_id=<?php echo $row['id'];  ?>">View Pass Details</a>

											</td>

										</tr>										

							<?php 			$i++; 

									}

								} 

						?>		</tbody>

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



<script type="text/javascript">

function toggle_add_pass()

{

	$('#couponupload_toggle').toggle();

}	

	

function delete_coupon(id){

	

	if (id == "") {

		alert("Please create a coupon first");

	}

	else

	{	

		var r = confirm("Are you sure want to delete!");

		if (r == true) {

			jQuery.post('ajaxcall.php', {'delete_coupon':id}, function(response){

				if (response == "deleted") {

					window.top.location = "host_coupon.php?msg=delete";

				}

				else

				{

					alert("Error deleting coupon");

				}

			});

		} 

		else 

		{

			return false;

		}			

	}

}



function validate_adv()

{

	

	if(document.add_adv.old_name.value=="")

	{

		if( document.add_adv.adv_img.value== "" )

		{

			//alert( "Please provide coupon Image!" );

			document.add_adv.adv_img.focus() ;

			return false;	

		}

	}

	if( document.add_adv.cname.value== "" )

	{

		//alert( "Please enter  coupon name!" );

		document.add_adv.cname.focus() ;

		return false;	

	}



	if( document.add_adv.max_download.value== "" )

	{

		//alert( "Please enter max download!" );

		document.add_adv.max_download.focus() ;

		return false;	

	}

	

}



function Validate_coupon_FileUpload(){

	var check_image_ext = $('#adv_img').val().split('.').pop().toLowerCase();

	if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {

		alert('Pass Image only allows file types of GIF, PNG, JPG and JPEG');

		$('#adv_img').val('');

	}

}



function create_securitycode(){

	$.post('', {'create_security_code':'create_security_code'}, function(response){

	

		if (response != "") {

			$('#security_code').val(response);

		}

	

	});

}

</script>

<?php include('Footer.php'); ?>