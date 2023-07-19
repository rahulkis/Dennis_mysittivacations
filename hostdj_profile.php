<?php

include("Query.Inc.php");

$Obj = new Query($DBName);

$userID = $_SESSION['user_id'];


$para="";

if(isset($_REQUEST['msg']))

{

	$para=$_REQUEST['msg'];

}

$message = "";

if($para!="");

{

	if($para=="update")

	{

	$message="Shout added successfully";

	}

}
		

if(isset($_SESSION['success']))

{

	$success=$_SESSION['success'];

	unset($_SESSION['success']);

}

$titleofpage="Bio";

if(!isset($_SESSION['user_id']))

{

	include('PublicProfileHeader.php');

}

else

{

	if(isset($_GET['host_id']))

	{

		include('NewHeadeHost.php');

	}

	else

	{

		include('NewHeadeHost.php');	

	}

}

if(isset($_GET['host_id']) && ( $_GET['host_id'] != "" ))

{

	//die('sdsdsds');

	$userID = $_GET['host_id'];

}

else

{

	$userID = $_SESSION['user_id'];

}

?>
<script type="text/javascript">


	$(document).ready(function(){

		// $(".removeimgallery").hide();
	 //    /*jQuery('.show-image').hover(function() {
	 //         jQuery(this).find('.the-buttons').fadeIn(1500);
	 //    }, function() {
	 //        jQuery(this).find('.the-buttons').fadeOut(1500); 
	 //    });*/
	    
	 //    $('.gpic_host img').hover(function() {
	    	
	 //        $('.removeimgallery').fadeIn(500);
	 //    }, function() {
	 //        $('.removeimgallery').fadeOut(500); 
	 //    });
	    
	 //    $('.gpic_host').mouseout(function() {
	 //        $('.removeimgallery').fadeOut(500); 
	 //    });

	 $('.gpic_host img').hover(function(event)
		{
		   $(this).find('img').show();
		});

		$('.gpic_host img').mouseout(function(event)
		{
		   $(this).find('img').hide();
		});

		$(".removeimgallery").click(function(){
			
			if(confirm('Are you sure you want to delete this image?'))
			{
				$(this).parent('div').hide();
				var getimgsrc = $('#galleryHide').val();
					
				var splitsrc = getimgsrc.split('hostdj_pics/gallery/'+<?php echo $_SESSION['user_id']?>+'/');
				
				var splitsrc = splitsrc[1];
				$(this).remove();
				$.ajax({
					type: "POST",
					url: "hostdj_gallrey_ajax.php",
					data: {
					'splitsrc' : splitsrc            
					},
					success: function(data){
					}
				});
			}
		});
	});
</script>

<div class="clear"></div>

<div class="v2_container">

	<div class="v2_inner_main">

	<!-- SIDEBAR CODE  -->

	<?php   

		if(!isset($_GET['host_id']))

		{

			include('club-right-panel.php');	

		}

		else

		{ 

			include('host_left_panel.php');

		} 

	?>

	<!-- END SIDEBAR CODE -->

		<article class="forum_content v2_contentbar">

			<div class="v2_rotate_neg">
			<div class="v2_rotate_pos">
			<div class="v2_inner_main_content">

				<div id="middle">

				<?php

					if(isset($_POST['savesetting']))

					{

						//echo "<pre>"; print_r($_POST); die;

						$value = $_POST['function'];

						if($value == "Disable with message")

						{

							$m = $_POST['biomessage'];

						}

						else

						{

							$m = "";

						}

						

						$getq1 = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$userID."'  ");

						$countrec1 = @mysql_num_rows($getq1);



						if($countrec1 > 0)

						{

							//die("UPDATE `host_functions_setting` SET `bio` = '$value', `biomessage` = '$m' WHERE `host_id` = '".$userID."'  ");

							mysql_query("UPDATE `host_functions_setting` SET `bio` = '$value', `biomessage` = '$m' WHERE `host_id` = '".$userID."'  ");

						}

						else

						{

							//die('else');

							@mysql_query("INSERT INTO `host_functions_setting` (`host_id`,`bio`,`biomessage`) VALUES ('".$userID."','$value','$m')  ")	;

						}

						

						$message = '<div  id="successmessage" class="message">Bio Display Settings is Saved.</div>';





					}





				$getq = mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$userID."'  ");

				$countrec = @mysql_num_rows($getq);

				if($countrec > 0)

				{

					$fetchstatus = @mysql_fetch_array($getq);

					$statuspage = $fetchstatus['bio'];

					$me = $fetchstatus['biomessage'];

					//die;

				}

				else

				{

					$statuspage = "Enable";

					$me= "";

				}

					





				?>





				<style type="text/css">

			.vidoesgallery > div > a img {

height: 115px;

width: 80%;

}

				.vidoesgallery.hostdj_pro

				{

					float: left;

				}

				.vidoesgallery > div {

				float: left;

				padding-bottom: 2%;

				margin: 1%;

				width: 18%;

				height: 125px;

				min-height: 125px;

				}







				.hostdjinfo p span em strong {font-weight: bold;}

				.hostdjinfo p span em

				{

					font-style: italic;

				}

				</style>



				<?php  	

					if($_SESSION['user_type'] == "user" && $statuspage == "Disable with message")

					{

						echo "<h3 id='title' >About</h3>";

						

						$pagestatus = "0";	

						echo "<div class='nostoreview' >";

						if($fetchstatus['bio'] == "Disable with message")

						{

							echo "<h1 id='title' style='text-align: center;'>".$me."</h1>";

						}

						

						if($fetchstatus['bio'] == "Disable without message")

						{

							

						}



						echo "</div>";

					}

					elseif($_SESSION['user_type'] == "club" && isset($_GET['host_id']) && $statuspage == "Disable with message")

					{

						echo "<h3 id='title' >About</h3>";

						

						$pagestatus = "0";	

						echo "<div class='nostoreview' >";

						if($fetchstatus['bio'] == "Disable with message")

						{

							echo "<h1 id='title' style='text-align: center;'>".$me."</h1>";

						}

						

						if($fetchstatus['bio'] == "Disable without message")

						{

							

						}



						echo "</div>";

					}

					else

					{



						if($message != "")

						{

							echo $message;

						}



						$gethostdjprofile  = "select * from host_dj_profile where host_id = ".$userID ;

						$resulquerythostdjprofile = @mysql_query($gethostdjprofile);

						$resulthostdjprofile = @mysql_fetch_assoc($resulquerythostdjprofile);



						if($_SESSION['user_type'] == 'club' && !isset($_GET['host_id']))

						{	

							if($resulthostdjprofile['host_id'] == $userID )

							{

								echo '<div id="title"><span class="disableall" style="float: right;"><a class="button" href="add_hostdj_profile.php?edithostdj=edithostdj">Edit Bio</a></span></div>';	

							}

							else 

							{

							?>

						 		<!-- <div id="title"><span class="disableall" style="float: right;"><a class="button" href="add_hostdj_profile.php">Add Host Bio</a></span></div> -->

						<?php 
							}

				 		}

					?>

					

					<?php if(isset($_SESSION['bio_edit_succ'])) { ?> <div class="successmessage" ><?php echo "Bio updated successfully."; ?></div> <?php unset($_SESSION['bio_edit_succ']); } ?>

					

				           <div style="clear:both"></div>

							<div id="middle">

								<div class="profile_djhost">

								 	<h3 id="title" class="aboutme">Bio</h3>

                                   <div class="hostdjinfo">

									

										<h4><?php echo $resulthostdjprofile['hostdj_name'];?></h4>

										<p><?php echo $resulthostdjprofile['hostdj_description']; ?></p>

									    	

									</div>

									<?php 

										if(!empty($resulthostdjprofile['hostdj_profile_pic']))

										{

									?>		<div class="hostdjthumb">

												<a id="bioProfile" href="javascript:;">

												<img src="<?php echo $resulthostdjprofile['hostdj_profile_pic']?>" alt="" title=""/>

												</a>

											</div>

							  		<?php 	}

							  			elseif(!empty($_SESSION['img']))

							  			{	

							  		?>		<div class="hostdjthumb">

												<a id="bioProfile" href="javascript:;">

												<img src="<?php echo $_SESSION['img'];?>" alt="" title=""/>

												</a>

											</div>

						  		<?php	}

						  				else

						  				{

						  				?>	<div class="hostdjthumb">

												<a id="bioProfile" href="javascript:;">

												<img src="images/man4.jpg" alt="" title=""/>

												</a>

											</div>



						  		<?php	}	?>

								</div>

				                

				                <div style="clear:both"></div>

				                
								<input type="button" class="button" id="click_for_add" name="" value="Add Photo">
				                
				                <div class="vidoesgallery hostdj_pro">

				                	

									<?php if($resulthostdjprofile['default_bio'] == 'video'){ ?>

									

										<video width="400" controls onmouseout="this.pause()" onmouseover="this.play()">

										  <source src="<?php echo $resulthostdjprofile['hostdj_video']; ?>" type="video/mp4">

										</video>													

									

									<?php }else{ ?>

									

										<?php $explodegallery =  explode("," , $resulthostdjprofile['hostdj_gallery_pic']);

										$gallercount = count($explodegallery);



											for($a=0;$a<$gallercount;$a++)

											{

												if(!empty($explodegallery[$a]))

												{

													echo '<div class="gpic_host"><a href="#"><img src="hostdj_pics/gallery/'.$userID."/".$explodegallery[$a].'" alt="" title=""/></a>';
													?>
													
													
													<a class='removeimgallery'>Delete</a>
				                					<input type="hidden" id="galleryHide" name="" value="hostdj_pics/gallery/<?php echo $_SESSION['user_id']."/".$explodegallery[$a]; ?>"></div>
				                				<?php	
												}

											}

										?>													

									

									<?php } ?>

									

				                </div>

				                

							</div>

							<?php if($_SESSION['user_type'] != "user" && !isset($_GET['host_id'])){?>

							<div class="storefunctionsetting">

							<h1 id="title">Settings</h1>

							<?php 

							//echo "SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$userID."'  "; exit;

							$getq = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$userID."'  ");

							$countrec = @mysql_num_rows($getq);

							if($countrec > 0)

							{

								$fetchstatus = @mysql_fetch_array($getq);

								$statuspage = $fetchstatus['bio'];

								$me = $fetchstatus['biomessage'];

								//die;

							}

							else

							{

								$statuspage = "Enable";

								$me= "";

							}



							?><!-- 

							<script src='js/jqueryvalidationforsignup.js'></script>

							<script src="js/register.js" type="text/javascript"></script>  -->

							<form method="POST" action="" name="storesettings" id="storesettingsform" >

								<div><input <?php if($statuspage == "Enable"){ echo "checked"; } ?> type="radio" name="function" value="Enable" />Enable your Bio for public viewing.</div>

								<div><input <?php if($statuspage == "Disable with message"){ echo "checked"; } ?> type="radio" name="function" value="Disable with message" id="disbleshow" />Bio not done yet? Leave a short message to inform the public.</div>

								

								<?php if($statuspage == "Disable with message"){ ?>

								

									<div id="disablemessage"><input  type="text" name="biomessage" value="<?php echo $me;?>" /></div>

								

								<?php }else{ ?>

								

									<div id="disablemessage" style="display: none;"><input  type="text" name="biomessage" value="<?php echo $me;?>" /></div>

								

								<?php } ?>

								<!-- <div><input <?php if($statuspage == "Disable without message"){ echo "checked"; } ?> type="radio" name="function" value="Disable without message" />Disable And Hide</div> -->

								<div class="settingformsubmit"><input type="submit" class="button" name="savesetting" value="Save" /></div>

							</form>

							</div>

							<?php } 



						} ?>

			</div>
		</div>
		</div>
		</div>

			<div class="equalizer"></div>

		</article>

	</div>

	<div class="clear"></div>

</div>

<div id="gallerypop">
        <?php
		if(isset($_POST['hostdj_profile_edit']))
		{
			$count = count($_FILES['forum_hodtdj_profile_images']['name']);
			for($a=0;$a<$count;$a++)
			{
				$getname = $_FILES['forum_hodtdj_profile_images']['name'][$a];
				$getall .= $getname.",";
				$temp = $_FILES["forum_hodtdj_profile_images"]["tmp_name"][$a];
				$temp1 = explode(".", $_FILES["forum_hodtdj_profile_images"]["name"][$a]);
				$extension = end($temp1);
				$pathg = "hostdj_pics/gallery/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_images"]["name"][$a];

				$thumb = $getname;
				
				$thumbnailg = "hostdj_pics/gallery/".$_SESSION['user_id']."/".$thumb;


				move_uploaded_file($_FILES["forum_hodtdj_profile_images"]["tmp_name"][$a],"hostdj_pics/gallery/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_images"]["name"][$a]);
				$fileg = $pathg;
					
				//indicate the path and name for the new resized file
				$resizedFileg = $thumbnailg;
				

				$resizeObj = new resize($file);

				// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
				$resizeObj -> resizeImage(300,200, 'auto');

				// *** 3) Save image ('image-name', 'quality [int]')
				$resizeObj -> saveImage($resizedFile, 100);	
						
				$explodegallery =  explode("," , $resulthostdjprofile['hostdj_gallery_pic']);

				$gallercount = count($explodegallery);
				
				for($b=0;$b<$gallercount;$b++)
				{
					$getall1 .= $explodegallery[$b].",";
				}	
						
				$updatedimgagal .= $getall;
				$updatedimgagal .= $getall1;
				$updatedimgagal;
					 
				$file_type = $_FILES['add_post_video_distinct']['type'];
				$exp_file_type = explode('/', $file_type);
				$check_file_type = $exp_file_type[0];
				$video_name = "";
				
				if($check_file_type == "video" || $check_file_type == "application"){
					
					$forum_video=$_FILES['add_post_video_distinct']['name']; 
					$tmp = $_FILES["add_post_video_distinct"]["tmp_name"]; 
					$video_name = "video/bio_".time().strtotime(date("Y-m-d")).$forum_video; 
					move_uploaded_file($tmp,$video_name);
					
				}

				 $des = mysql_real_escape_string($_POST['hodtdj_profile_description']);
				 $nme = mysql_real_escape_string($_POST['hodtdj_profile_name']);

				if($video_name == ""){
					
					@mysql_query("UPDATE `host_dj_profile` SET `hostdj_gallery_pic` = '$updatedimgagal', `enable` = '1' WHERE `host_id` =".$_SESSION['user_id']);
					
				}else{
						
					@mysql_query("UPDATE `host_dj_profile` SET `hostdj_gallery_pic` = '$updatedimgagal', `enable` = '1', `hostdj_video` = '".$video_name."' WHERE `host_id` =".$_SESSION['user_id']);
						
				}
				$_SESSION['bio_edit_succ'] = "success";
				header("Location:hostdj_profile.php");
			}
		}

?>
        <form method="POST" enctype="multipart/form-data" class="musicadd12" id="" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="dragNdrop">
        	 
        	<img src="images/drag.png">
			<span class="text_allowed"> (Allowed exts's gif, png, jpg & jpeg)</span>

			<input type="file" style="color: #fff; width:100%;padding: 44px 0px 44px 4px;border: 1px dashed #cccccc;" name="forum_hodtdj_profile_images[]" class="txt_box" id="add_post_videoahd" multiple onchange="return ValidateVideoUploadahd()" required />
        	<input type="button" id="cancel_button" value="X">
        	<input type="submit" name="hostdj_profile_edit" value="Upload Image" class="button addfrmbutton"  />
        </div>
        </form>
        
</div>
<div id="gallerypop2">
<?php
if(isset($_POST['hostdj_profile_img']))
{
	$getname = $_FILES['forum_hodtdj_profile_img']['name'];

	if(!is_dir("hostdj_pics/profile_pic/". $_SESSION['user_id'] ."/"))
	{
		mkdir("hostdj_pics/profile_pic/".  $_SESSION['user_id'] ."/");
	}

	$temp = $_FILES["forum_hodtdj_profile_img"]["tmp_name"];
	$path = "hostdj_pics/profile_pic/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_img"]["name"];
	$temp = $_FILES["forum_hodtdj_profile_img"]["name"];
	$temp1 = explode(".", $_FILES["forum_hodtdj_profile_img"]["name"]);
	$extension = end($temp1);
	$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$getname."_thumbnail.".$extension;
	$thumbnail = "hostdj_pics/profile_pic/".$_SESSION['user_id']."/".$thumb;

	move_uploaded_file($_FILES["forum_hodtdj_profile_img"]["tmp_name"],"hostdj_pics/profile_pic/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_img"]["name"]);
	$file = $path;
		
	$resizedFileg = $thumbnailg;
	
	$resizeObj = new resize($file);

	$resizeObj -> resizeImage(300,200, 'auto');

	$resizeObj -> saveImage($resizedFile, 100);	
		
	@mysql_query("UPDATE `host_dj_profile` SET `hostdj_profile_pic` = '$file', `enable` = '1' WHERE `host_id` =".$_SESSION['user_id']);
		
	$_SESSION['bio_edit_succ'] = "success";
	header("Location:hostdj_profile.php");

}
?>
	<form method="POST" enctype="multipart/form-data" class="musicadd12" id="" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="dragNdrop">
        	 
        	<img src="images/drag.png">
			<span class="text_allowed"> (Allowed exts's gif, png, jpg & jpeg)</span>

			<input type="file" style="color: #fff; width:100%;padding: 44px 0px 44px 4px;border: 1px dashed #cccccc;" name="forum_hodtdj_profile_img" class="txt_box" id="add_post_videoahd" multiple onchange="return ValidateVideoUploadahd()" required />
        	<input type="button" id="cancel_button2" value="X">
        	<input type="submit" name="hostdj_profile_img" value="Upload Image" class="button addfrmbutton"  />
        </div>
        </form>
</div>

    <script>

        $(document).ready(function(){
        
 
         $("#click_for_add").click(function(){
          showpopup();
         });
         $("#cancel_button").click(function(){
          hidepopup();
         });
         
        
        $("#bioProfile").click(function(){
          showpopup2();
         });
         $("#cancel_button2").click(function(){
          hidepopup2();
         });
         
        });

        function showpopup()
        {
         $("#gallerypop").fadeToggle();
         $("#gallerypop").css({"visibility":"visible","display":"block"});
        }

        function hidepopup()
        {
         $("#gallerypop").fadeToggle();
         $("#gallerypop").css({"visibility":"hidden","display":"none"});
        }

        function ValidateVideoUploadahd(){
			var check_image_ext = $('#add_post_videoahd').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
				//alert('Host Dj Image only allows file types of GIF, PNG, JPG and JPEG');
				$('#add_post_videoahd').val('');
			}
		}

		function showpopup2()
        {
         $("#gallerypop2").fadeToggle();
         $("#gallerypop2").css({"visibility":"visible","display":"block"});
        }

        function hidepopup2()
        {
         $("#gallerypop2").fadeToggle();
         $("#gallerypop2").css({"visibility":"hidden","display":"none"});
        }
    </script>

<script type="text/javascript">

$(document).ready(function(){



	$('input[type="radio"]').click(function(){

		if($(this).val() == "Disable with message")

		{

			$('#disablemessage').css('display','block');

		}

		else

		{

			$('#disablemessage').css('display','none');

		}

	});



});

</script>

<?php include('LandingPageFooter.php') ?>