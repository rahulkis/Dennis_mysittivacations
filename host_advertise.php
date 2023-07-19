<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$_SESSION['user_id'] = "55";
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

require_once 'facebook-php-sdk-v4-4.0-dev/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;

FacebookSession::setDefaultApplication( FBAPPID,FBAPPSECRET );

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
		
$titleofpage="Add Advertisement";
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

		$userID = $_SESSION['user_id'];
	/******************/

	if(isset($_GET['page']) && $_GET['page'] == 'del')
	{
		// die('123');
		mysql_query("DELETE FROM `host_ad` WHERE `id` = '$_GET[ad_id]' ");
	}



	if(isset($_POST['submit']))
	{
		$image="";
		$video="";
		$text="";
		$myVariable="";
		if($_POST['adv_type']=='image' && !empty($_FILES["adv_img"]["name"]) )
		{
			$myVariable = $_FILES["adv_img"]["name"];
			$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
			$temp = explode(".", $_FILES["adv_img"]["name"]);
			$extension = end($temp);
			$name = $_FILES["adv_img"]["name"];
			$ext =substr($name,strrpos($name,'.'));
			$u_video=$_FILES["adv_img"]["name"];  
			$tmp = $_FILES["adv_img"]["tmp_name"]; 
			$v_name = "upload/hostads/".time().$u_video; 
			$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$u_video;
			$thumbnail = "upload/hostads/".$thumb;
			//$image_path="upload/".$thumb; 
			move_uploaded_file($tmp,$v_name);
			
			
			//indicate which file to resize (can be any type jpg/png/gif/etc...)
		   	$image = $v_name;
		   
		   //indicate the path and name for the new resized file
	  		$resizedFile = $thumbnail;
		   
		   //call the function (when passing path to pic)
	  	 	//smart_resize_image($v_name , null, 324 , 200 , false , $resizedFile , false , false ,100 );
		   //call the function (when passing pic as string)
	 	  	//smart_resize_image(null , file_get_contents($v_name), 324 , 200 , false , $resizedFile , false , false ,100 );


	  		$resizeObj = new resize($image);

			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(300,200, 'auto');

			// *** 3) Save image ('image-name', 'quality [int]')
			$resizeObj -> saveImage($resizedFile, 100);	


	 	  				
			$image = $v_name;
		}
		elseif($_POST['adv_type']=='video' && !empty($_FILES["file"]["name"]))
		{
			$myVariable = $_FILES["file"]["name"];
				   
			if($_FILES["file"]["name"]!="")
			{
				if ($_FILES["file"]["error"] > 0)
				{
					echo "Return Code: " . $_FILES["file"]["error"] . "<br>"; Exit;
				}
				else
				{
					$u_video=$_FILES["file"]["name"]; 
					$tmp = $_FILES["file"]["tmp_name"]; 
					$v_name = "upload/hostads/".time().$u_video; 
					move_uploaded_file($tmp,$v_name);
					$video=time().$u_video;

				}
			}
				  
		}  

		if(isset($_POST['addAdv']))
		{
			$ValueArray = array($_POST['adv_link'],$thumbnail,$image,$video,$text,$userID,$_POST['adv_type']);
			$FieldArray = array('adv_link','ad_thumb','ad_image','ad_video','ad_text','host_id','ad_type');
			$ThisPageTable="host_ad";	
			$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		}
		elseif(isset($_POST['editAdv']))
		{
			if($myVariable != "")
			{
				$sql_up=mysql_query("update host_ad set adv_link='".$_POST['adv_link']."',ad_thumb='".$thumbnail."',ad_image='".$image."',ad_video='".$video."',ad_text='".$text."',ad_type='".$_POST['adv_type']."' where host_id='".$_POST['editAdv']."'");
			}
			else
			{
				$sql_up=mysql_query("update host_ad set adv_link='".$_POST['adv_link']."',ad_text='".$text."',ad_type='".$_POST['adv_type']."' where id='".$_POST['editAdv']."'");	
			}
		}




		// $sql_ck=mysql_query("select id from  host_ad where host_id='".$_SESSION['user_id']."'");
		// $rw_row=@mysql_num_rows($sql_ck);
		// if($rw_row > 0)
		// {
		// 	if($myVariable != "")
		// 	{
		// 		$sql_up=mysql_query("update host_ad set adv_link='".$_POST['adv_link']."',ad_thumb='".$thumbnail."',ad_image='".$image."',ad_video='".$video."',ad_text='".$text."',ad_type='".$_POST['adv_type']."' where host_id='".$userID."'");
		// 	}
		// 	else
		// 	{
		// 		$sql_up=mysql_query("update host_ad set adv_link='".$_POST['adv_link']."',ad_text='".$text."',ad_type='".$_POST['adv_type']."' where host_id='".$userID."'");	
		// 	}
		// }
		// else
		// {
		// 	$ValueArray = array($_POST['adv_link'],$thumbnail,$image,$video,$text,$userID,$_POST['adv_type']);
		// 	$FieldArray = array('adv_link','ad_thumb','ad_image','ad_video','ad_text','host_id','ad_type');
		// 	$ThisPageTable="host_ad";	
		// 	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);		
		// }
		
				/***** FACEBOOK POST SHARE *****/
				if(isset($_SESSION['fb_token'])){
					
					if($image != ""){
						
						$share_content = $base_url.$thumbnail;
						$share_picture = $base_url.$thumbnail;
						
					}
					
					if($video != ""){
						
						$share_content = $base_url.$v_name;
						$share_picture = $base_url."images/share_video_play_btn.png";
						
					}					
					
					$session = new FacebookSession( $_SESSION['fb_token'] );
					
					// graph api request for user data
					$request = new FacebookRequest( $session, 'POST', '/me/feed', array(
					   //'name' => $_POST['shout'],
					   'caption' => 'mysittidev.com',
					   'link' => $share_content,
					   'message' => 'New Advertisement',
					   'picture' => $share_picture
					  ) );
					$response = $request->execute();
				}
				/***** FACEBOOK POST SHARE *****/
				
				
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
					//if(isset($_POST["shout"])) 
					//{
						//Post text to twitter
						$my_update = $connection->post('statuses/update', array('status' => 'New Advertisement On Mysitti'));
						//die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php
					//}
				}
				
				/**TWITTER POST SHARE**/		
		 
		$Obj->Redirect("host_advertise.php?msg=update");die;
				 
	}
		
		
	$userType= $_SESSION['user_type'];
	if($userType=="club"){
		//include('headerhost.php');
	}

	

		?>


<script type="text/javascript">
	function Validate_host_video_adv_VideoUpload(){
			var check_image_ext = $('#file').val().split('.').pop().toLowerCase();
				if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
					alert('Post Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
						$('#file').val('');
			}
	}
	
function Validate_host_adv_FileUpload(){
		var check_image_ext = $('#host_adv_img').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Post Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#host_adv_img').val('');
		}
}

function changetype(val)
{
	// alert(val);
	if(val=='plain')
	{
		document.getElementById('adv-img').style.display='none';
		document.getElementById('img-link').style.display='none';	
		// document.getElementById('adv-afl').style.display='block';	
		document.getElementById('video_d').style.display='none';	
	}
	else if(val=='video')
	{
		document.getElementById('adv-img').style.display='none';
		document.getElementById('img-link').style.display='block';	
		// document.getElementById('adv-img1').style.display='none';
		// document.getElementById('adv-img12').style.display='block';	
		document.getElementById('video_d').style.display='block';	
	}
	else
 	{
		 
		document.getElementById('adv-img').style.display='block';
		document.getElementById('img-link').style.display='block';	
		// document.getElementById('adv-img1').style.display='block';
		// document.getElementById('adv-img12').style.display='none';
		document.getElementById('video_d').style.display='none';
 	}
}
</script>
<style type="text/css">
	
	#adv-img1 .formw > img {
		float: left;
		width: 100%;
	}

</style>
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
						
						<?php 
						if(isset($_GET['page']) && ($_GET['page'] == 'edit' || $_GET['page'] == 'add') )
						{
							//die('ddd');
							$getAdvertise = mysql_query("SELECT * FROM `host_ad` WHERE `host_id` = '$_SESSION[user_id]' AND `id` = '$_GET[ad_id]' " );
							$fetchAdvertise = mysql_fetch_array($getAdvertise);
						?>
						<div id="profile_box" >
						 	<h3 id="title">Add  Specials </h3>
							<form class="v2_host_advrt v2_editpass" name="add_adv" method="post"   enctype="multipart/form-data" onsubmit="return validate_adv();">
							<?php 	if($fetchAdvertise['ad_type'] == "image")
								{
									$stt1 = " style='display:block;' ";
									$stt = " style='display:none;' ";
								}
								elseif($fetchAdvertise['ad_type'] == "video")
								{
									$stt = " style='display:block;' ";
									$stt1 = " style='display:none;' ";
								}
								else
								{
									$stt1 = " style='display:block;' ";
									$stt = " style='display:none;' ";
								}	
							if(isset($_GET['page']) &&  $_GET['page'] == 'add') 
							{
								echo "<input type='hidden' name='addAdv' value='add' />";
							}
							elseif(isset($_GET['page']) &&  $_GET['page'] == 'edit') 
							{
								echo "<input type='hidden' name='editAdv' value='".$_GET['ad_id']."' />";
							} 
							?>

								<div class="row">
									<span class="label">Special Type:</span>
									<span class="formw control_editpass">							  
										<select name="adv_type" id="adv_type" onchange="changetype(this.value);">
										<option <?php if($fetchAdvertise['ad_type'] == "image"){ echo "selected"; } ?> value="image">Image/ Poster</option>
										<!-- <option <?php if($fetchAdvertise['ad_type'] == "plain"){ echo "selected"; $stt2 = " style='display: block;'";} ?> value="plain">Plain Text</option> -->
										<option <?php if($fetchAdvertise['ad_type'] == "video"){ echo "selected";} ?> value="video">Video</option>
										</select>
									</span>
								</div>

								<div class="row" id="img-link">
									<span class="label">URL:</span>
									<span class="formw control_editpass"><input value="<?php echo $fetchAdvertise['adv_link'];?>" name="adv_link" id="adv_link" type="text" /></span>
								</div>
								
								<div class="row" id="adv-img" <?php echo $stt1; ?>>
									<span class="label">Special Image:</span>
									<span class="formw control_editpass">
										<input onchange="return Validate_host_adv_FileUpload()" id="host_adv_img" name="adv_img" type="file" /> 
										(Allowed exts's gif, png, jpg & jpeg)
									</span>
								</div>
								<?php 
								if($fetchAdvertise['ad_image'] != "")
								{
								?>
									<div class="row" id="adv-img1">
										<span class="label">Current Special Image:</span>
										<span class="formw thumb_editpass">
											<img src="<?php echo $fetchAdvertise['ad_image']?>" alt="" />
										</span>
									</div>
							<?php 	}	?>
							<?php 
								if($fetchAdvertise['ad_video'] != "")
								{
								?>
									<div class="row" id="adv-img12">
										<span class="label">Current Special Video;</span>
										<span class="formw">
											<a href="#dialogx" name="modal">
												<div id="a<?php echo $fetchAdvertise["id"];?>"></div>
												<script type="text/javascript">
												 jwplayer("a<?php echo $fetchAdvertise["id"];?>").setup({
													file: "upload/hostads/<?php echo $fetchAdvertise["ad_video"];?>",
													//file: "Video.MOV",
													height : 200 ,
													width: 200
													});
												</script>
											</a>
										</span>
									</div>
							<?php 	}	?>
								<div class="row" id="video_d" <?php echo $stt;?>>
									<span class="label" style="font-size:16px;font-weight:bold">Upload From Computer :</span>
									<span class="formw"><input onchange="return Validate_host_video_adv_VideoUpload()" type="file" name="file" id="file"/>
										<p>(Allowed exts's .mov, .m2ts, .avi, .mp4, .webm, .flv and .f4v)</p>
									</span>
								</div>




								<ul class="btncenter_new v2_coupn_btn">
									<li><input class="button" name="submit" type="submit" value="Submit" /></li>
									<li><a class="button" href="host_advertise.php">Cancel</a></li>
								</ul>
							</form>
						</div><!-- END profile_bx -->
				<?php 		}	?>
						<?php 
						$getAdvertisement = mysql_query("SELECT * FROM `host_ad` WHERE `host_id` = '$_SESSION[user_id]' ");
						
						?>
						<h3 id="title">Manage Advertisements </h3>
							<div class="advertise-banner">
							<img src="imagesNew/advertise-banner.png" alt="banner">
							<h3>Advertisements</h3>
							<p>
								Right now, when you post your show it only shows up on your profile page. We are dedicated to making

sure that you are easy to find. MySitti will not only post it on your profile, we will also post it on the city

talk page and email your fans. Free!<br/>

MySitti knows how expensive it is to advertise. That’s why we have created the free features to advertise

your shows. If you want the maximum visibility upgrade your profile, we offer to our MySitti ballers.

							</p>
							
							<a href="advertisement.php" id="click_for_div">Learn More</a>
							<a style="float:right;" class="button" href="?page=add">Add Advertisement</a>
							</div>
						<div class="autoscroll">
							<table id="example" class="display loadmusic host_cp_table v2_host_coupn" style="margin-top:10px;">
								<thead>
									<tr bgcolor="#ACD6FE">
										<th>Advertisement Link</th>
										<th>Advertisement Image</th>
										<th>Advertisement Video</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
							<?php 
								if(mysql_num_rows($getAdvertisement) < 1)
								{ 
							?>		<tr>
										<td colspan="4">
											No Advertisments Found
										</td>
									</tr>
							<?php 	}
								else
								{
									$i=1;
									while($row = mysql_fetch_assoc($getAdvertisement))
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
											<td><?php echo $row['adv_link']; ?></td>
											<td>
												<?php 
												if(!empty($row['ad_image']))
												{
												?>
												<a class="fancybox" rel="group" href="<?php echo $SiteURL.$row['ad_image']; ?>">
													<img  src="<?php echo $SiteURL.$row['ad_thumb']; ?>">
												</a>
											<?php 	}
												else
												{
													echo "NA";
												}
											?>
											</td>
											<td>
												<?php 
												if(!empty($row['ad_video']))
												{
											?>
													<a  class=""  id="ve_<?php echo $row["id"];?>" href="#dialogx<?php echo $row["id"];?>" name="modal"></a>
													<div class="videoList" id="a<?php echo $row["id"];?>"></div>
													<script type="text/javascript">
														jwplayer("a<?php echo $row["id"];?>").setup({
															file: "<?php echo $row["ad_video"];?>",
															width : 200 ,
														});
													</script>
											<?php
												}
												else
												{
													echo "NA";
												}
										?>
												
											</td>												
											<td>
												<a href="?page=edit&ad_id=<?php echo $row['id'];  ?>">
													<img width="25px" height="25px" title="Edit" src="images/Edit.png">
												</a>
												<img onclick="delete_coupon('<?php echo $row['id'];  ?>');" style="cursor: pointer;" src="images/del.png" width="25px" title="Delete" height="25px">
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
		</article>
	</div>
</div>
<script type="text/javascript">
function delete_coupon(id)
{
	
	if (id == "") {
		alert("Please create a coupon first");
	}
	else
	{	
		var r = confirm("Are you sure want to delete!");
		if (r == true) {
			window.location.href = "host_advertise.php?page=del&ad_id="+id;
		} 
		else 
		{
			return false;
		}			
	}
}

function validate_adv()
{
	var imageval = $('#host_adv_img').val();
	var videoval = $('#file').val();
	if(imageval == '' && videoval == '')
	{
		alert('Please Select Media file to upload.');
		return false;
	}
	else
	{
		return true;
	}

}

</script>
<?php include('Footer.php') ?>