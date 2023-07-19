<?php 

$Obj = new Query($DBName);

if(isset($_GET['page']) && $_GET['page']=="add"){
	$titleofpage="Add Booking Type";
}else if(isset($_GET['page']) && $_GET['page']=="edit"){
	$titleofpage="Edit Booking Type";
}else{
	$titleofpage="Booking Type";
}


$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($userID)){
	$Obj->Redirect("index.php");
}

if(isset($_GET['delete']) && $_GET['delete'] == "galleryimage")
{
	$imgID = $_GET['imageid'];
	$getImageInfo = mysql_query("SELECT * FROM `bookingtype_gallery` WHERE `bid` = '$imgID' ");
	$res = mysql_fetch_assoc($getImageInfo);

	unlink($res['image_path']);
	unlink($res['thumb_path']);

	mysql_query("DELETE FROM `bookingtype_gallery` WHERE `bid` = '$imgID'  ");
}


$userID=$_SESSION['user_id'];
if($_GET['page'] == 'edit'){	
	$query = "select * from bookingstype WHERE id='".$_GET['id']."' ORDER BY id DESC";
	$exist = 'false';
	$res = mysql_query($query); 
	$exist = 'true';
	$pagename_edit = 'Edit Booking Type';
} elseif($_GET['page'] == 'add'){
	$exist = 'add';
	$pagename_edit = 'Add Booking Type';
}elseif(isset($_POST['bookmeadd'])){//die('sdgfsd');
	$float = strpos($_POST['capacity'],'.')?'1':'0';
	//echo $float;die;
	//if($_POST['capacity'] != "0" && $float == '0'){ 
		//if(($_POST['price'])){

			$explode = explode("$",$_POST['price'] );
			if(count($explode) > 1 )
			{	
				$price = $explode[1];
			}
			else
			{
				$price = $explode[0];
			}
// echo "<pre>"; print_r($_POST); print_r($_FILES); exit;
			if(!empty($_FILES['image_type']['name']))
			{
				$file_name=$_FILES['image_type']['name'];
				$tmp=$_FILES['image_type']['tmp_name'];
				$ext =substr($file_name,strrpos($fname,'.'));
				$img_path = "_".strtotime(date("Y-m-d")).$file_name;
				$path="upload/".$img_path;	
				$thumb = "_".md5(strtotime(date("Y-m-d")))."_thumnail_".$file_name;
				$thumbnail = "upload/".$thumb;	
				move_uploaded_file($tmp,$path);

				
				 //indicate which file to resize (can be any type jpg/png/gif/etc...)
				$file = $path;
				
				//indicate the path and name for the new resized file
				$resizedFile = $thumbnail;
				
				//call the function (when passing path to pic)
				//smart_resize_image($file , null, 200 , 200 , false , $resizedFile , false , false ,100 );
				//call the function (when passing pic as string)
				//smart_resize_image(null , file_get_contents($file), 200 , 200 , false , $resizedFile , false , false ,100 );			
				$resizeObj = new resize($file);

				// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
				$resizeObj -> resizeImage(500, 350, 'auto');
				//$resizeObj -> resizeImage(300,200, 'auto');

				// *** 3) Save image ('image-name', 'quality [int]')
				$resizeObj -> saveImage($resizedFile, 100);	
			}
			if(!empty($_FILES['video_type']['name']))
			{
				$videoname=$_FILES['video_type']['name'];
				$tmp1=$_FILES['video_type']['tmp_name'];
				$path1="upload/_".strtotime(date("Y-m-d")).$videoname;
				move_uploaded_file($tmp1,$path1);
			}



			$query = "INSERT INTO `bookingstype`(`name`,`capacity`, `price`, `description`,`host_id`,`video_type`,`image_type`,`image_type_thumb`) VALUES ('".mysql_real_escape_string($_POST['name'])."','".$_POST['capacity']."','".$price."','".mysql_real_escape_string($_POST['description'])."','$userID','$path1','$path','$thumbnail')";
			mysql_query($query); 
			$bookingtypeID = mysql_insert_id();
			if(!empty($_FILES['galleryfiles']['name']))
			{
				$no=count($_FILES['galleryfiles']['name']);
				for ($i=0;$i<$no;$i++)
				{
					$file_name=$_FILES['galleryfiles']['name'][$i];
					$tmp=$_FILES['galleryfiles']['tmp_name'][$i];
					
					$img_path = "_".strtotime(date("Y-m-d")).$file_name;
					$path="upload/".$img_path;	
					$thumb = "_".md5(strtotime(date("Y-m-d")))."_thumbnail".$file_name;
					$thumbnail = "upload/".$thumb;	
					move_uploaded_file($tmp,$path);

					
					 //indicate which file to resize (can be any type jpg/png/gif/etc...)
					$file = $path;
					
					//indicate the path and name for the new resized file
					$resizedFile = $thumbnail;
					
					//call the function (when passing path to pic)
					//smart_resize_image($file , null, 200 , 200 , false , $resizedFile , false , false ,100 );
					//call the function (when passing pic as string)
					//smart_resize_image(null , file_get_contents($file), 200 , 200 , false , $resizedFile , false , false ,100 );			
					$resizeObj = new resize($file);

					// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
					$resizeObj -> resizeImage(300, 200, 'auto');
					//$resizeObj -> resizeImage(300,200, 'auto');

					// *** 3) Save image ('image-name', 'quality [int]')
					$resizeObj -> saveImage($resizedFile, 100);

					mysql_query("INSERT INTO `bookingtype_gallery` (`bookingtype_id`,`image_path`,`thumb_path`,`host_id`) VALUES ('$bookingtypeID','$path','$thumbnail','$userID')");

				}
			}




			$exist = 'false';
			$pagename = 'Booking Types';
			$query1 = "select * from bookingstype WHERE `host_id` = '$_SESSION[user_id]' ORDER BY id DESC";
			$res = mysql_query($query1);			
			$message="Booking Type inserted successfully.";
		// } else {
		// 	$pagename_edit = 'Add Booking Type';
		// 	$message = 'Please enter a valid price.';			
		// 	$query1 = "select * from bookingstype WHERE `host_id` = '$_SESSION[user_id]' ORDER BY id DESC";
		// 	$exist = 'add';
		// 	$res = mysql_query($query1);			
		//}
	// } else {	
	// 	$pagename_edit = 'Add Booking Type';	
	// 	$message = 'Please enter a valid capacity.';
	// 	$query1 = "select * from bookingstype WHERE `host_id` = '$_SESSION[user_id]' ORDER BY id DESC";
	// 	$exist = 'add';
	// 	$res = mysql_query($query1);		
	// }	
}elseif($_GET['page'] == 'del'){
	$exist = 'false';
		$query = "DELETE FROM bookingstype WHERE id=".$_GET['id'];
		mysql_query($query);
		//$result = mysql_fetch_array($res);
					//echo '<pre>';print_r($result);die;
		$query1 = "select * from bookingstype WHERE `host_id` = '$_SESSION[user_id]' ORDER BY id DESC";
		$pagename = 'Booking Types';
		$res = mysql_query($query1);
		$message = "Booking Type deleted successfully.";
}
elseif(isset($_POST['bookmeedit']))
{
	//$float = strpos($_POST['capacity'],'.')?'1':'0';
	// if(is_numeric($_POST['capacity']) && $float == '0') { //var_dump($_POST['capacity']);die('fgsdf');
	//	if(is_float($_POST['price']) || is_numeric($_POST['price'])){

			if(!empty($_FILES['image_type']['name']))
			{
				$file_name=$_FILES['image_type']['name'];
				$tmp=$_FILES['image_type']['tmp_name'];
				$ext =substr($file_name,strrpos($fname,'.'));
				$img_path = "_".strtotime(date("Y-m-d")).$file_name;
				$path="upload/".$img_path;	
				$thumb = "_".md5(strtotime(date("Y-m-d")))."_thumnail_".$file_name;
				$thumbnail = "upload/".$thumb;	
				move_uploaded_file($tmp,$path);

				
				 //indicate which file to resize (can be any type jpg/png/gif/etc...)
				$file = $path;
				
				//indicate the path and name for the new resized file
				$resizedFile = $thumbnail;
				
				//call the function (when passing path to pic)
				//smart_resize_image($file , null, 200 , 200 , false , $resizedFile , false , false ,100 );
				//call the function (when passing pic as string)
				//smart_resize_image(null , file_get_contents($file), 200 , 200 , false , $resizedFile , false , false ,100 );			
				$resizeObj = new resize($file);

				// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
				$resizeObj -> resizeImage(500, 350, 'auto');
				//$resizeObj -> resizeImage(300,200, 'auto');

				// *** 3) Save image ('image-name', 'quality [int]')
				$resizeObj -> saveImage($resizedFile, 100);	
			}
			else
			{
				$query1 = mysql_query("select * from bookingstype WHERE id='".$_POST['id']."' ORDER BY id DESC");
				$r = mysql_fetch_assoc($query1);
				$path = $r['image_type'];
				$thumbnail = $r['image_type_thumb'];
			}


			if(!empty($_FILES['video_type']['name']))
			{
				$videoname=$_FILES['video_type']['name'];
				$tmp1=$_FILES['video_type']['tmp_name'];
				$path1="upload/_".strtotime(date("Y-m-d")).$videoname;
				move_uploaded_file($tmp1,$path1);
			}
			else
			{
				$query2 = mysql_query("select * from bookingstype WHERE id='".$_POST['id']."' ORDER BY id DESC");
				$s = mysql_fetch_assoc($query2);
				$path1 = $s['video_type'];
			}

			$query = "UPDATE bookingstype  SET `video_type` = '$path1', `image_type` = '$path', `image_type_thumb` = '$thumbnail', name = '".mysql_real_escape_string($_POST['name'])."',capacity = '".$_POST['capacity']."',price = '".$_POST['price']."',description = '".mysql_real_escape_string($_POST['description'])."'   WHERE id=".$_POST['id'];//die;
			mysql_query($query); 


			$bookingtypeID = $_POST['id'];
		//	echo "<pre>"; print_r($_FILES); print_r($_POST); exit;
			if(!empty($_FILES['galleryfiles']['name'][0]))
			{
				$no=count($_FILES['galleryfiles']['name']);
				for ($i=0;$i<$no;$i++)
				{
					$file_name=$_FILES['galleryfiles']['name'][$i];
					$tmp=$_FILES['galleryfiles']['tmp_name'][$i];
					
					$img_path = "_".strtotime(date("Y-m-d")).$file_name;
					$path="upload/".$img_path;	
					$thumb = "_".md5(strtotime(date("Y-m-d")))."_thumbnail".$file_name;
					$thumbnail = "upload/".$thumb;	
					move_uploaded_file($tmp,$path);

					
					 //indicate which file to resize (can be any type jpg/png/gif/etc...)
					$file = $path;
					
					//indicate the path and name for the new resized file
					$resizedFile = $thumbnail;
					
					//call the function (when passing path to pic)
					//smart_resize_image($file , null, 200 , 200 , false , $resizedFile , false , false ,100 );
					//call the function (when passing pic as string)
					//smart_resize_image(null , file_get_contents($file), 200 , 200 , false , $resizedFile , false , false ,100 );			
					$resizeObj = new resize($file);

					// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
					$resizeObj -> resizeImage(300, 200, 'auto');
					//$resizeObj -> resizeImage(300,200, 'auto');

					// *** 3) Save image ('image-name', 'quality [int]')
					$resizeObj -> saveImage($resizedFile, 100);

					mysql_query("INSERT INTO `bookingtype_gallery` (`bookingtype_id`,`image_path`,`thumb_path`,`host_id`) VALUES ('$bookingtypeID','$path','$thumbnail','$userID')");

				}
			}




			$exist = 'false';
			$pagename = 'Booking Types';
			$query1 = "select * from bookingstype WHERE `host_id` = '$_SESSION[user_id]' ORDER BY id DESC";
			$res = mysql_query($query1); 
			$message = "Booking Type updated successfully.";
		// } else {
		// 	$exist = 'true';
		// 	$pagename_edit = 'Edit Booking Type';
		// 	$query = "select * from bookingstype WHERE id='".$_POST['id']."' ORDER BY id DESC";
		// 	$message = 'Please enter a valid price.';
		// 	$res = mysql_query($query); 
		// }
	// } else {
	// 	$exist = 'true';
	// 	$pagename_edit = 'Edit Booking Type';
	// 	$query = "select * from bookingstype WHERE id='".$_POST['id']."' ORDER BY id DESC";
	// 	$message = 'Please enter a valid capacity.';
	// 	$res = mysql_query($query);			
	// }
}else {	
	$query = "select * from bookingstype WHERE `host_id` = '$_SESSION[user_id]' ORDER BY id DESC";
	$exist = 'false';
	$pagename = 'Booking Types';
	$res = mysql_query($query);
}
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}
if($para!="");
{
	if($para=="success")
	{
	$message="Profile Updated.";
	}
	if($para=="imagefail")
	{
	$message="Invalid Image.";
	}
	if($para=="update")
	{
	$message="Coupon Updated Sucessfully";
	}
}
	$sql1 = "select * from `clubs` where `id` = '".$userID."'";
			$userArray1 = $Obj->select($sql1) ; 
			//echo "<pre>"; print_r($userArray1); die;
			$first_name=$userArray1[0]['first_name']; 
			$last_name=$userArray1[0]['last_name'];
			$zipcode=$userArray1[0]['zipcode'];
			$state=$userArray1[0]['state'];
			$country=$userArray1[0]['country'];
			if($userArray1[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray1[0]['DOB'];
			$city=$userArray1[0]['city'];
			$email=$userArray1[0]['email'];
			$image_nm=$userArray1[0]['image_nm'];
			$phone=$userArray1[0]['phone'];
			$type_of_club = $userArray1[0]['type_of_club'];
			$sql = "select * from `clubs` where `id` = '".$userID."'";
			$userArray = $Obj->select($sql) ;
?>

          <div class="v2_inner_main_content">
            <h3 id="title">
              <?if($exist == 'false'){ 
									echo "Booking Types";
									} elseif($exist == 'add'){ 
									echo "Add Booking Type";
									 } else{							
										echo "Edit Booking Type";
									 }?>
            </h3>
            <?php if($exist == 'false'){ ?>
            <div class="bookings_type">
              <?php if(isset($message)){ ?>
              <div id="successmessage" class="message"><?php echo $message; ?> </div>
              <?php } ?>
              <form name="bookme"  method="post" class="bookme">
                <div class="field_out field_new field_new2 addnewbtn"> <a class="button btn_ss btn_ss_new1" href="bookings.php?page=add">ADD</a></div>
                <?php 
											$class = "";
											$count = mysql_num_rows($res);
											if($count > 10)
											{
												$class = " class='scroll_Div12'";
											} else {
												$class = " ";
												
											}
											?>
                <div <?php echo $class; ?>>
                  <div class="bookmetype autoscroll">
                    <table class='display' id='example' style=''>
                      <thead>
                        <tr bgcolor='#ACD6FE'>
                          <th>Name</th>
                          <th>Capacity</th>
                          <th>Price</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $k =1;$i=1;
														if(mysql_num_rows($res) > 0){
														while($result = mysql_fetch_assoc($res)) {
															if($i%2 == '0')
															{
																$class = " class='even' ";
															}
															else
															{
																$class = " class='odd' ";
															}
													?>
                        <tr <?php echo $class; ?>>
                          <td style="text-align:center;"><?php echo $result['name']; ?></td>
                          <td style="text-align:center;"><?php echo $result['capacity']; ?></td>
                          <td style="text-align:center;"><?php if(!empty($result['price'])){ echo "$".$result['price'];} ?></td>
                          <td style="text-align:center;" class="note"><?php if(!empty($result['description'])){ $typeDescription = strip_tags($result['description']); if(strlen($typeDescription) > 30){ echo substr($typeDescription,0,30)."....";}else{ echo $typeDescription;} }else{ echo "&nbsp;";} ?></td>
                          <td style="text-align:center;" class="note actionsImages"><?php echo "<a href=?page=edit&id=".$result['id']."><img title='Edit' src='images/Edit.png' width='25px' height='25px'></a> <a href='bookingsTypeDetails.php?typeID=".$result['id']."&host_id=".$result['host_id']."'><img title='Preview' src='images/previewicon.png' /></a> <a href=?page=del&id=".$result['id']." onclick='return confirm(\"Are you sure you want to delete?\")'><img src='images/del.png' width='25px' title='Delete' height='25px'></a>"; ?></td>
                        </tr>
                        <?php 
														 $k++;$i++;} } else { 
													?>
                        <tr>
                          <td colspan="5">No Record Found</td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </form>
            </div>
            <?php } elseif($exist == 'add'){ ?>
            <div class="bookings_type">
              <?php if(isset($message)){ ?>
              <div id="errormessage" class="message"><?php echo $message; ?> </div>
              <?php } ?>
              <form name="bookmeadd" action="bookings.php"  id="bookmeadd" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id"  value="<?php echo $result['id']; ?>" />
                <div class="row"> <span class="label">
                  <?php if($type_of_club == "103"){ echo "Instructor"; }else{ echo "Type"; } ?>
                  <b><font color='red'><em>*</em></font></b></span> <span class="formw">
                  <input type="text" name="name" size="25" value="<?php if(isset($_POST['name']))echo $_POST['name']; ?>" required/>
                  </span> </div>
                <div class="row"> <span class="label">
                  <?php if($type_of_club == "103"){ echo "Students"; }else{ echo "Capacity"; } ?>
                  </span> <span class="formw">
                  <input id="BookingCapacity" type="text" name="capacity" size="25" value="<?php if(isset($_POST['capacity']))echo $_POST['capacity']; ?>" />
                  <p class="exmple">(Example: 100)</p>
                  </span> </div>
                <div class="row"> <span class="label">Price($)</span> <span class="formw">
                  <input  id="BookingPrice" <?php if(empty($merchantID)){ ?> onclick='addmerchantID("Booking")'; <?php } ?> type="text" name="price" size="25" value="<?php if(isset($_POST['price']))echo $_POST['price']; ?>" />
                  <p class="exmple">(Example: $100)</p>
                  </span> </div>
                <div class="row"> <span class="label">Description<b><font color='red'><em>*</em></font></b></span> <span class="formw">
                  <textarea class="bookingtypedescription" name="description" rows="4" cols="37"><?php if(isset($_POST['description']))echo $_POST['description']; ?>
</textarea>
                  </span> </div>
                <div class="row"> <span class="label">Booking Type Image<b><font color='red'><em>*</em></font></b></span> <span class="formw">
                  <input  type="file" name="image_type" />
                  </span> </div>
                <div class="row"> <span class="label">Booking Type Video</span> <span class="formw">
                  <input  type="file" name="video_type" />
                  </span> </div>
                <div class="row">
                  <span class="label"> Add More Images </span> 
                    
                    <span class="formw">
                    
                        <input type="file" name="galleryfiles[]" multiple  />
                        <!-- <i onclick="AddMoreImages();">Add More</i> --> 
                      
                    </span>
                  </div>
             
                <div class="row"> <span class="label">&nbsp;</span> <span class="controlSet">
                  <input class="button btn_ss button_newss" type="submit" size="25" name="bookmeadd" value="Save"/>
                  <a href="bookings.php" class="button backme" >Cancel</a></span> </div>
              </form>
            </div>
            <?php } else { ?>
            <div class="bookings_type" >
              <?php if(isset($message)){ ?>
              <div id="errormessage" class="message"><?php echo $message; ?> </div>
              <?php } ?>
              <form name="bookmeedit" action="bookings.php"  method="post" enctype="multipart/form-data">
                <?php 	while($result = mysql_fetch_assoc($res)){ ?>
                <div class="row">
                  <input type="hidden" name="id" class="btn_ss" value="<?php echo $result['id']; ?>" />
                </div>
                <div class="row"> <span class="label">Name<b><font color='red'><em>*</em></font></b></span> <span class="formw">
                  <input type="text"  name="name" size="25" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];}else {echo $result['name'];} ?>" required />
                  </span> </div>
                <div class="row"> <span class="label">Capacity</span> <span class="formw">
                  <input type="text" name="capacity" size="25" value="<?php if(isset($_POST['capacity'])){ echo $_POST['capacity'];}else { echo $result['capacity']; }?>" />
                  <p class="exmple">(Example: 100)</p>
                  </span> </div>
                <div class="row"> <span class="label">Price <b>$</b></span> <span class="formw">
                  <input type="text" name="price" size="25" value="<?php if(isset($_POST['price'])){ echo $_POST['price'];} else { if(empty($result['price'])){ echo '0';}else{ echo $result['price'];}} ?>" />
                  <p class="exmple">(Example: $100)</p>
                  </span> </div>
                <div class="row"> <span class="label">Description<b><font color='red'><em>*</em></font></b></span> <span class="formw">
                  <textarea class="bookingtypedescription" name="description" rows="4" cols="37"  ><?php  if(isset($_POST['price'])){ echo $_POST['price'];} else { echo $result['description']; }?>
</textarea>
                  </span> </div>
                <div class="row"> <span class="label">Booking Type Image</span> <span class="formw">
                  <input  type="file" name="image_type" />
                  </span> </div>
                <div class="row"> <span class="label">Current Booking Type Image</span> <span class="formw"> <img src="<?php echo $SiteURL.$result['image_type_thumb'];?>"> </span> </div>
                <div class="row"> <span class="label">Booking Type Video</span> <span class="formw">
                  <input  type="file" name="video_type" />
                  </span> </div>
                <?php 
			if(!empty($result['video_type']))
			{
			?>
                <div class="row"> <span class="label">Current Booking Type Video</span> <span class="formw video_current_booking"> <a class="jwplayerVideo" id="jw_<?php echo $result['id'];?>" href="#dialogx<?php echo $result['id'];?>" name="modal" style="">
                  <div  id="a<?php echo $result['id'];?>" ></div>
                  <script type="text/javascript">
						   	jwplayer("a<?php echo $result['id'];?>").setup({
								file: "<?php echo $result['video_type'];?>",
							  	height : 200 ,
							  	width: 300
						  	});
						</script> 
                  </a> </span> </div>
                <?php		}	
			$getImages = mysql_query("SELECT * FROM `bookingtype_gallery` WHERE `bookingtype_id` = '$_GET[id]' ");
			if(mysql_num_rows($getImages) > 0)
			{
		?>
                <div class="row">
                  <div class="addmoreimages">
                    <h2>Images Uploaded</h2>
                    <div class="">
                      <?php
							while($s = mysql_fetch_assoc($getImages))
							{
					?>
                      <div class="UploadedImage" id="img_<?php echo $s['bid'];?>"> <img  src="<?php echo $s['thumb_path'];?>" />
                        <div onclick="deleteGalleryImage('<?php echo $s['bid'];?>');" class="removeThisThumb"> DEL </div>
                      </div>
                      <?php 		}		?>
                    </div>
                  </div>
                </div>
                <?php 		}	?>
                <div class="row"> <span class="label"> Add More Images</span>
                  <div class="formw">
                    <input type="file" name="galleryfiles[]" multiple  />
                    <!-- <i onclick="AddMoreImages();">Add More</i> -->  
                    
                  </div>
                </div>
                <?php
		}
		?>
                <span	class="controlSet">
                <input class="button"  id="bookmeadd" type="submit" size="25" name="bookmeedit" value="Update"/>
                <a  href="bookings.php" class="button backme" style="float: left">Cancel</a> </span>
              </form>
            </div>
            <?php }?>
          </div>
 
<style type="text/css">
td.actionsImages a {
	float: left;
	margin: 0 5px;
}


.addmoreimages h2 {
	float: left;
	width: 100%;
	margin: 10px 0;
	font-size: 14px;
	color: #fecd07;
}
.addmoreimages {
	float: left;
	width: 100%;
	margin: 10px 0;
}
.moreimagesfield input[type="file"] {
	float: left;
	width: 51%;
	margin: 10px 0;
}

input[type="file"]
{
	padding: 10px;
	border: 1px solid;
}

.moreimagesfield div {
  float: left;
  width: 100%;
}
.moreimagesfield div i
{
	float: left;
	font-size: 15px;
	/* margin: 0 10px; */
	/* line-height: 35px; */
	padding: 20px;
}
.imagesGallery div {
	float: left;
	/* padding: 5px; */
	border: 1px solid;
	width: 29%;
	margin: 0 5px;
}
.imagesGallery div img {
	float: left;
	width: 96%;
	padding: 5px;
}
.bookmetype table td {
  text-align: left !important;
}
</style>
<script type="text/javascript">
	function AddMoreImages()
	{
		var getcount = $('.moreimagesfield div').length;
		var newcount = getcount+1;
		$('.moreimagesfield').append("<div id='row_"+newcount+"'><input type='file' name='galleryfiles[]' /><i onclick='removeField("+newcount+")'>Remove</i></div>");
	}
	function removeField(num)
	{
		$('#row_'+num).remove();
	}

	function deleteGalleryImage(id)
	{
		var bid = "<?php echo $_GET['id'];?>";
		var r = confirm("Are you sure want to delete!");
		if (r == true) 
		{
			$.ajax({
				type: "POST",
				url: "refreshajax.php",
				data: {
					'action': "deleteBookinggallery", 
					'imageid' : id,
				},
				success: function( msg ) 
				{
					if(msg == 'OK')
					{
						$('#img_'+id).remove();
					}
				}
			});
		}
		else
		{
			return false;
		}
	}

</script>