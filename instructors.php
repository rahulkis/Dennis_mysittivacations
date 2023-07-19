<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID = $_SESSION['user_id'];

if(!isset($_SESSION['user_id']))
{
	$Obj->Redirect("login.php");
}

// ini_set("display_errors", "1");
// error_reporting(E_ALL);


$titleofpage=" Instructors";
include('LoginHeader.php');

if(isset($_POST['save_instructor']))
{
	//echo "<pre>"; print_r($_POST); exit;
	$instructorName = mysql_real_escape_string($_POST['instructor_name']);
	$instructordesc = mysql_real_escape_string($_POST['instructor_desc']);
	if($_FILES["instructor_image"]["name"]!="")
	{
		//echo "<pre>"; print_r($_FILES); exit;
		
		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
		$temp = explode(".", $_FILES["instructor_image"]["name"]);
		$extension = end($temp);
		
		if ((($_FILES["instructor_image"]["type"] == "image/gif")
		|| ($_FILES["instructor_image"]["type"] == "image/jpeg")
		|| ($_FILES["instructor_image"]["type"] == "image/jpg")
		|| ($_FILES["instructor_image"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts))
	  	{
		 
				if ($_FILES["instructor_image"]["error"] > 0)
				{
					echo "Error: " . $_FILES["instructor_image"]["error"] . "<br>";
				}
			  	else
				{
					$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
					$temp = explode(".", $_FILES["instructor_image"]["name"]);
					$extension = end($temp);
					$name = $_FILES["instructor_image"]["name"];
					$ext =substr($name,strrpos($name,'.'));
					$tmp1 = $_FILES["instructor_image"]["tmp_name"];
					$path = "upload/".time().strtotime(date("Y-m-d")).$name;
					$thumb = $path."_thumbnail".$ext;
					$thumbnail = $thumb;
					$image_path=$thumb;
					$forum_img = $thumb;
					move_uploaded_file($tmp1,$path);
						
					$file = $path;
			
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


					$forum_img=$thumbnail;	
				}
		}
		else
		{
			$Obj->Redirect("instructors.php?msg=imagefail");
		}
	}
	$insertInstructor = mysql_query("INSERT INTO `instructors` (`host_id`,`instructor_image`,`instructor_desc`,`instructor_name`,`instructor_thumb`)
	 					VALUES ('$_SESSION[user_id]','$path','$instructordesc','$instructorName','$thumbnail')");		
	if($insertInstructor)
	{
		$Obj->Redirect("instructors.php?msg=success");
		die;
	}
	else
	{
		
	}

}


if(isset($_POST['update_instructor']))
{
	//echo "<pre>"; print_r($_POST); exit;
	$instructorName = mysql_real_escape_string($_POST['instructor_name']);
	$instructordesc = mysql_real_escape_string($_POST['instructor_desc']);
	$instructorID = $_GET['instructorID'];
	if($_FILES["instructor_image"]["name"]!="")
	{
		//echo "<pre>"; print_r($_FILES); exit;
		
		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
		$temp = explode(".", $_FILES["instructor_image"]["name"]);
		$extension = end($temp);
		
		if ((($_FILES["instructor_image"]["type"] == "image/gif")
		|| ($_FILES["instructor_image"]["type"] == "image/jpeg")
		|| ($_FILES["instructor_image"]["type"] == "image/jpg")
		|| ($_FILES["instructor_image"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts))
	  	{
		 
			if ($_FILES["instructor_image"]["error"] > 0)
			{
				echo "Error: " . $_FILES["instructor_image"]["error"] . "<br>";
			}
		  	else
			{
				$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
				$temp = explode(".", $_FILES["instructor_image"]["name"]);
				$extension = end($temp);
				$name = $_FILES["instructor_image"]["name"];
				$ext =substr($name,strrpos($name,'.'));
				$tmp1 = $_FILES["instructor_image"]["tmp_name"];
				$path = "upload/".time().strtotime(date("Y-m-d")).$name;
				$thumb = $path."_thumbnail".$ext;
				$thumbnail = $thumb;
				$image_path=$thumb;
				$forum_img = $thumb;
				move_uploaded_file($tmp1,$path);
					
				$file = $path;
		
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


				$forum_img=$thumbnail;	
			}
			mysql_query("UPDATE `instructors` SET `instructor_name` = '$instructorName', `instructor_desc` = '$instructorDesc', `instructor_image` = '$path', `instructor_thumb` = '$thumbnail' WHERE `id` = '$instructorID' ");
		}
		else
		{
			$Obj->Redirect("instructors.php?msg=imagefail");
		}

	}
	else
	{
		mysql_query("UPDATE `instructors` SET `instructor_name` = '$instructorName', `instructor_desc` = '$instructordesc' WHERE `id` = '$instructorID' ");
	}
	$Obj->Redirect("instructors.php?msg=updated");
	die;
}


if(isset($_GET['instructorID']))
{
	$getinstructorInfo = mysql_query("SELECT * FROM `instructors` WHERE `id` = '$_GET[instructorID]' ");
	$fetchinstructorINFO = mysql_fetch_assoc($getinstructorInfo);
	$instructorName = $fetchinstructorINFO['instructor_name'];
	$instructorImage = $fetchinstructorINFO['instructor_thumb'];
	$instructorDesc = $fetchinstructorINFO['instructor_desc'];
}

if(isset($_GET['deleteInstructor']))
{
	$getinstructorInfo = mysql_query("DELETE FROM `instructors` WHERE `id` = '$_GET[deleteInstructor]' ");
	$Obj->Redirect("instructors.php?msg=deleted");
		die;
}	



?>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   
		if($_SESSION['user_type']=='user')
		{
			if(isset($_GET['host_id']))
			{
				include('host_left_panel.php');
			   
			}
			else
			{ 
				include('friend-right-panel.php');
						
			}	 
		}
		else
		{
			if(isset($_GET['host_id']))
			{
				include('host_left_panel.php');
			   
			}
			else
			{
				include('club-right-panel.php') ;
			}
		}	 
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<div class="upload_photo_main">
			
				<?php
							if($_GET['msg'] == "updated")
							{

								echo '<div id="successmessage" style="display: block;">Instructor Updated Successfully</div> ';
							}
							elseif ($_GET['msg'] == "imagefail") 
							{
								# code...
								echo '<div id="errormessage" style="display: block;">Image failed to upload!</div> ';
							}
							elseif ($_GET['msg'] == "deleted") 
							{
								# code...
								echo '<div id="successmessage" style="display: block;">Instructor deleted successfully</div>';
							}
							elseif ($_GET['msg'] == "success") 
							{
								# code...
								echo '<div id="successmessage" style="display: block;">Instructor added successfully</div>';
							}


						if(!isset($_GET['host_id']))
						{

			 ?>
							<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
								<script>tinymce.init({
											selector:'#instructorsForm textarea',
											toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect",
											fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
											menubar: false
										});
								</script>
							<style type="text/css">
							.home_content_top button { background: none;}
							strong {font-weight: bold;}
							</style>
		                    <div class="instructor_wrapper">	
			 				<h3 id="title">Instructors</h3>
			 				<div id="instructorsForm">
			 					<form action="" method="POST" class="instructorform" enctype="multipart/form-data">
			 						<div class="row">
			 							<span class="label">
			 								<label>Instructor Name: </label>
			 							</span>
			 							<span class="formw">
			 								<input <?php if(!empty($instructorName)){ echo " value='".$instructorName."' ";} ?> type="text" name="instructor_name" class="txt_box" />
			 							</span>
			 						</div>
			 						<div class="row">
			 							<span class="label">
			 								<label>Instructor Image: </label>
			 							</span>
			 							<span class="formw">
			 								<input type="file" name="instructor_image"  />
			 							</span>
			 						</div>
			 						<?php 
			 						if(isset($_GET['instructorID']))
									{
										?>
				 						<div class="row">
				 							<span class="label">
				 								<label>Previous Image: </label>
				 							</span>
				 							<span class="formw">
				 								<img src="<?php echo $instructorImage; ?>" alt="" />
				 							</span>
				 						</div>
		 						<?php 	}	?>
			 						<div class="row">
			 							<span class="label">
			 								<label>Instructor Description: </label>
			 							</span>
			 							<span class="formw">
			 								<textarea name="instructor_desc" class="txt_box" ><?php if(!empty($instructorDesc)){ echo $instructorDesc;} ?></textarea>
			 							</span>
			 						</div>
			 						<div class="row">
			 							<?php 
			 								if(isset($_GET['instructorID']))
											{
												echo '<input type="submit" class="button" name="update_instructor" value="Update"  />';
											}
											else
											{
												echo '<input type="submit" class="button" name="save_instructor" value="Save"  />'; 
											}
			 							?>
			 							
			 						</div>
			 					</form>
			 				</div>
		                     </div>
			 		<?php 	}	?>
		                 <div class="instructor_wrapper">	
			 				<div id="instructorsList">
			 					<h3 id="title">Instructors List</h3>
			 					<?php 
			 					if(isset($_GET['host_id']))
								{
									$UserID = $_GET['host_id'];
									$anchor = "&host_id=".$UserID;
								}
								else
								{
									$UserID = $_SESSION['user_id'];
									$anchor = "";
								}
			 						$getinstructors = mysql_query("SELECT * FROM `instructors` WHERE `host_id` = '$UserID' ");
			 						if(mysql_num_rows($getinstructors) > 0)
			 						{
			 							while($fetchinstructors = mysql_fetch_assoc($getinstructors))
			 							{
			 								?>
			 								<div class="instructors_box">
			 									
			 								
		             <div class="instructorImage">
		             										<a href="javascript:void(0);" onclick="window.open('instructorProfile.php?instructorID=<?php echo $fetchinstructors['id'].$anchor; ?>','','width=700,scrollbars=1,height=700,resizable=true,left=300,top=0');">
			 										<!-- <a href="instructorProfile.php?instructorID=<?php echo $fetchinstructors['id'].$anchor; ?>"> -->
			 											<img src="<?php echo $fetchinstructors['instructor_thumb'] ;?>" alt="" />
			 										</a>
			 									</div>
		                                        <?php 
		 											if(!isset($_GET['host_id']))
		 											{
														?>	
              <div class="instructorName">
			 										<div class="instrctr_name"><a href="instructorProfile.php?instructorID=<?php echo $fetchinstructors['id'].$anchor; ?>"><?php echo $fetchinstructors['instructor_name']; ?></a></div>
		 										
			 									</div>
			 											<div class="down_del"> 
			 												<a href="?instructorID=<?php echo $fetchinstructors['id']; ?>"><img src="images/edit_artist.png" title="Edit" width="" height=""></a>
			                               										<a href="?deleteInstructor=<?php echo $fetchinstructors['id']; ?>" title="Delete" class="del_stream_vid"> </a> 
			                               									</div>
			                               							<?php 	}	?>
			 								</div>
			 								<?php
			 							}
			 						}
			 						else
			 						{
			 							echo "<div class='NoRecordsFound'>No Instructors Yet</div>";
			 						}
			 					?>
			 					
		 						</div>
	                    					</div>

						</div>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<?php include('Footer.php') ?>

