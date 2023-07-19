<?php
//error_reporting(E_ERROR | E_WARNING | E_NOTICE);
include("Query.Inc.php");
$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

$titleofpage="Host Background";

if(!isset($userID)){
	$Obj->Redirect("login.php");	
}

if($userType=='user'){
	$Obj->Redirect("home_user.php");
}

include('LoginHeader.php');

if(isset($_POST["upload_host_background"]))
{

	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	
	if($check !== false) 
	{
	  //  echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} 
	else 
	{
	  	//  echo "File is not an image.";
		$uploadOk = 0;
	}

	list($width, $height, $type, $attr) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	$imgwidth = $width;
	$imgheight = $height;

	if($imgwidth < 1024)
	{
		$uploadOk = 0;
		$error = "Image minimum width should be 1024px ";
	}

	if($imgheight < 768)
	{
		$uploadOk = 0;
		$error = "Image minimum height should be 768px ";
	}

	// Check if file already exists
	if (file_exists($target_file)) 
	{
	   	$error ="Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 4000000) {
		$error ="Sorry, your file is too large. Size should be less than 1 MB.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) 
	{
		$error =  $error;
	// if everything is ok, try to upload file
	} 
	else 
	{

		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
		$temp = explode(".", $_FILES["fileToUpload"]["name"]);
		$extension = end($temp);
		$ext_enb = date('YmdHis');
		$name = $ext_enb."_".$_FILES["fileToUpload"]["name"];
		$ext = substr($name,strrpos($name,'.'));
		$temp = explode(".", $_FILES["fileToUpload"]["name"]);
		$extension = end($temp); 
		$tmp1 = $_FILES["fileToUpload"]["tmp_name"];
		$path = "host_banner/".$name;
		$thumb_name = $name."_thumbnail".$ext;
		$thumbnail = "host_banner/thumb/".$thumb_name;
		$image_path="host_banner/".$thumb_name;
		move_uploaded_file($tmp1,$path);	
		 //indicate which file to resize (can be any type jpg/png/gif/etc...)
		$file = $path;
		
		//indicate the path and name for the new resized file
		$resizedFile = $thumbnail;
		
		//call the function (when passing path to pic)
		smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
		//call the function (when passing pic as string)
		smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );

		mysql_query("INSERT INTO host_background (`id`,`user_id`,`background_name`,`thumb`,`user_type`) VALUES ('','".$userID."','".$name."','".$thumbnail."','".$userType."')");
		
		$_SESSION['host_bk_img'] = "Host Background Uploaded Successfully.";

	}
}

if($_GET['page'] == edit)
{

}
elseif($_GET['page'] == del)
{
	$get_image_path = mysql_query("SELECT * FROM host_background WHERE id = '".$_GET['id']."'");
	$get_background_data = mysql_fetch_assoc($get_image_path);
	
	$image_base_path = $_SERVER['DOCUMENT_ROOT']."/host_banner/";
	$image_base_path_thumb = $_SERVER['DOCUMENT_ROOT']."/";
	
	$bk_thumb = $image_base_path.$get_background_data['background_name'];
	$bk_img_thumb = $image_base_path_thumb.$get_background_data['thumb'];
		
	unlink($bk_thumb);
	unlink($bk_img_thumb);
	
	mysql_query("DELETE FROM `host_background` WHERE `id` = '".$_GET['id']."'");
	
	$_SESSION['host_bk_img'] = "Host Background Deleted Successfully.";
	header('Location: host-background.php');
} 
elseif($_GET['page'] == act)
{
	mysql_query("UPDATE `host_background` SET `status` = '1' WHERE `id` = '$_GET[id]'  AND `user_id` = '$_SESSION[user_id]' ");
	mysql_query("UPDATE `host_background` SET `status` = '0' WHERE `id` != '$_GET[id]'  AND `user_id` = '$_SESSION[user_id]' ");
	mysql_query("UPDATE `host_background` SET `status` = '1' WHERE `id` = '".$_GET['id']."'");

	$_SESSION['host_bk_img'] = "Host Background Activated Successfully.";
	header('Location: host-background.php');
}

$hostquery = "select * from `clubs` where `id` = '".$userID."'";
$hostArray = $Obj->select($hostquery);	
$userArray = $Obj->select($hostquery);	

if(isset($_GET['host_id']))
{
	$hostID1 = $_GET['host_id'];
}
else
{
	$hostID1 = $_SESSION['user_id'];
}

	
?>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	 <?php  include('club-right-panel.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<?php 
  						if($error != "")
  						{

							echo '<div id="successmessage" class="message fail" >'.$error."</div>";
						}
						
						if(isset($_SESSION['host_bk_img']))
						{
							echo '<div id="successmessage" class="message success" >'.$_SESSION['host_bk_img']."</div>";
							unset($_SESSION['host_bk_img']);
						}

						?>
					 	<div id="profile_box" >
					   		<h3 id="title">Upload Host Background</h3>
							<?php
							 	$host_background = "SELECT * FROM `host_background` WHERE `user_id` = '".$userID."' order by id desc";
								$host_background_results = @mysql_query($host_background);
								$count = @mysql_num_rows($host_background_results);
								$class="";	
								if($count > 9)
								{
									$class = " class=''";
								}
								else
								{
									$class = " class=''";	
								}					
							?>
							<div <?php echo $class;?>>
						<?php
								echo "<table class='display book_list_type uploadBannerNew' id='booktype' > 
									<tr class='odd'>
										<td colspan='5'> 
											<form id='uploadBanner' action='host-background.php' method='post' enctype='multipart/form-data'>
												<div class='ppost_newdesign vtop'>
													<div class='lbl lbl upload_input'>
														<input type='file' name='fileToUpload' id='fileToUpload' onchange='return ValidateFileUploadee()' style='padding:2px'>
														<p style='float: left;' class='required_size'>Minimum Required Width:1024px & Height: 768px</p>
													</div>
													<divclass='submit_upload'>
														<input class='upload_banner' type='submit' value='Upload Image' name='upload_host_background'>
													</div>
												</div>									
											</form> 
										</td>
									</tr>
								</table>"  ; 
						?>
								<div class='display book_list_type' id='booktype'>						
									<div class="booktype_listing upload_banner_new">
					<?php	
										$i=1;
					 					while($res = mysql_fetch_array($host_background_results))
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
						 					<div  class="btype_liasting">
						  						<div class="upload_banners">
													<div class="_u_b_img">
														<img src="<?php echo $res['thumb']; ?>">
													</div>
				  									<div class="currnt"> 
														<?php 
															if($res['status'] == '0') 
															{
														?>
																<a href="?page=act&id=<?php echo $res['id'];?>" onclick="return confirm('Are you sure you want to set this as Background image?')">
															  		Set as background
															  	</a>
														<?php
															}
															else
															{
														?>
																<a href="javascript:void(0);"> Current background</a>
														<?php 	}
															echo "<a class='_u_p_del' href=?page=del&id=".$res['id']." onclick='return confirm(\"Are you sure you want to delete?\")'>
																	<img src='images/_udel.png' width='25px' title='Delete' height='25px'>
																</a>"; 
														?>
													</div>
												</div>
											</div>
									<?php 		$i++; 
										}
									?>			
									</div>
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
<style>
#booktype {
  width: 100%;
  float: left;
}
.upload_banner_new .upload_banners {
    border: 0 none;
    box-sizing: border-box;
    float: left;
    margin: 0;
    padding: 10px;
    text-align: center;
    width: 100%;
}


.upload_banner_new .upload_banners .currnt {
    float: left;
    margin: 5px 0;
    width: 100%;
}

</style>
<script type="text/javascript">

	function ValidateFileUploadee()
	{
			var check_image_ext = $('#fileToUpload').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
				alert('Host Background only allows file types of GIF, PNG, JPG and JPEG');
				$('#fileToUpload').val('');
			}
	}
</script>
<script language="javascript">	
		 $(document).ready(function(){
		$('input[type="radio"]').click(function(){
				//alert('sss');
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
<?php include('Footer.php');?>