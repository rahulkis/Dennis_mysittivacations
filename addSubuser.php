<?php

include("Query.Inc.php");

$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($userID)){
	$Obj->Redirect("index.php");
	
}
if($userType=='user'){
	$Obj->Redirect("index.php");
}
	
if(isset($_REQUEST['id']))
{
	$UserID=$_REQUEST['id'];
}
else 
{
	$UserID=$_SESSION['user_id'];	
}


$titleofpage = "Add User";

if(isset($_GET['host_id']))
{
	include('LoginHeader.php');
}
else
{
	include('HeaderHost.php');	
}



if(isset($_GET['generate_pass']) && $_GET['generate_pass'] == 1)
{
	$subHostId = $_GET['userid'];
	$club_pass=generatePassword(10);
	
	$qry1="SELECT * from hostsubusers  where id=".$subHostId;
	$res1 = mysql_query($qry1);
	$row1 = mysql_fetch_assoc($res1);

	$qry2="SELECT * from clubs where id=".$row1['host_id'];
	$res2 = mysql_query($qry2);
	$row2 = mysql_fetch_assoc($res2);
		
	$qryUpd = "UPDATE clubs set club_pass='".$club_pass."' where club_name='".$row1['username']."'";
	mysql_query($qryUpd);
	
	/* send email to main host account on update passsword for streaming
	* add by kbihm on feb 25,2015 */
	
	$str = "
		<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
			<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
			<hr>
			<h1 style='color: white;'>Broadcast Detail</h1>
			<p style='color: white;'>You have recently updated your password for broadcasting, Please find below detail to start streaming :</p>
			<p style='color: white;'>
				<b>To broadcast from external encoder like Adobe Flash Media Live Encoder</b><br />
				FMS Url : rtmp://192.163.248.47/live?usr=".$row1['useremail']."&amp;pwd=".$club_pass."<br />
				Stream : ".$row1['username']."
			</p>
				<p style='color: white;'> Thank you,<br><br>
				<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'> MYSITTI.COM </a>
				</p>
		</div>
	 ";

	$message = $str; 
	$to  = $row2['club_email'];

	$subject = "MYSITTI.com - Broadcasting Detail";
	$message = $str;
	//$from = "info@mysitti.com";

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: MySitti <mysitti@mysitti.com>' . "\r\n";
	//$headers .= "From:" . $from;

	mail($to,$subject,$message,$headers,"-finfo@mysitti.com");
	
	/* email code ended */		
	$Obj->Redirect("subuserList.php?msg=updStreamPwd");	
	
	
}




if(isset($_POST['save']))
{

	$uname = $_POST['uname'];
	$uemail = $_POST['email'];
	$upass	 = $_POST['pass'];
	$club_pass=generatePassword(10);

	if($_POST['allowpayment'] == 'on')
	{
		$allowpayment = 1;
	}
	
	else 
	{
		$allowpayment = 0;
	}	


	if($_FILES["profile_image"]["name"]!="")
	{
		
		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
		$temp = explode(".", $_FILES["profile_image"]["name"]);
		$extension = end($temp);
		
		if ((($_FILES["profile_image"]["type"] == "image/gif")
		|| ($_FILES["profile_image"]["type"] == "image/jpeg")
		|| ($_FILES["profile_image"]["type"] == "image/jpg")
		|| ($_FILES["profile_image"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts))
		{
			
		 
				if ($_FILES["profile_image"]["error"] > 0)
				{
					echo "Error: " . $_FILES["profile_image"]["error"] . "<br>";
				}
				else
				{

					$name = $_FILES["profile_image"]["name"];
					$tmp = $_FILES["profile_image"]["tmp_name"];
					$ext =substr($name,strrpos($name,'.'));
					$path = "upload/subuser/".time().strtotime(date("Y-m-d")).$name;
					$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$name."_thumbnail".$ext;
					$thumbnail = "upload/".$thumb;
					$image_path="upload/".$thumb;
					move_uploaded_file($tmp,$path);
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
				}
		}
		else
		{
			
			$Obj->Redirect("addSubuser.php?msg=imagefail");
			exit;
		}
	}

	$getplantypequery = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$_SESSION['user_id']."' ");
	$fetchplantype = @mysql_fetch_array($getplantypequery);
	$plantype = $fetchplantype['plantype'];

	$checkunamequery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$uname."' ");
	$countcheckuname = @mysql_num_rows($checkunamequery);
	$checkemailquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `useremail` = '".$uemail."' ");
	$countcheckemail = @mysql_num_rows($checkemailquery);
	$checkemailquery1 = @mysql_query("SELECT * FROM `clubs` WHERE `club_email` = '".$uemail."' ");
		$countcheckemail1 = @mysql_num_rows($checkemailquery1);
	$error = array();
	if($countcheckemail > 0 || $countcheckemail1 > 0)
	{
		$error['email'] = "Email Already Exists !";
	}
	if($countcheckuname > 0)
	{
		$error['uname'] = "ProfileID Already Exists !";
	}
	// print_r($error); exit;
	if(empty($error))
	{
			$adduserquery = @mysql_query("INSERT INTO `hostsubusers` (`user_thumb`,`userimage`,`username`,`useremail`,`password`,`merchant_id`,`allowpayment`,`status`,`host_id`) VALUES ('".$thumbnail."','".$path."','".$uname."','".$uemail."','".$upass."','','".$allowpayment."','1','".$_SESSION['user_id']."') ");
			
			$insertQuery = "INSERT INTO `clubs` (`club_name`,`club_pass`,`club_email`,`password`,`club_country`,`club_state`,`club_city`,`image_nm`,`status`,`plantype`,`non_member`) VALUES ('$uname','$club_pass','$uemail','$upass','$_SESSION[country]','$_SESSION[state]','$_SESSION[id]','$thumbnail','1','$plantype','0') ";
			$clubaddquery = mysql_query($insertQuery);
			if($adduserquery && $clubaddquery)
			{
			/* send email to main host account 
			 * add by kbihm on feb 23,2015 */
			$str = "
				<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
					<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
					<hr>
					<p style='color: white;'>
						<br />
			Welcome to the MYSITTI family and be a part of the next social revolution.  Visit MYSITTI.com where we are 
			<br />MAKING EVERY CITY YOUR CITY!
						<br /><br />
							Username: ".$uemail."<br>
							Password: ".$upass."<br>
							<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'>https://mysitti.com</a>
						<br /><br />
					</p>	
					<p style='color: white;'>
						<b>To broadcast from external encoder like Adobe Flash Media Live Encoder</b><br />
						FMS Url : rtmp://192.163.248.47/live?usr=".$uemail."&amp;pwd=".$club_pass."<br />
						Stream : ".$uname."
					</p>
						<p style='color: white;'> Thank you,<br><br>
						<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'> MYSITTI.COM </a>
						</p>
				</div>
			 ";

			$message = $str; 
			$to  = $fetchplantype['club_email'];

			$subject = "Welcome to MYSITTI.com";
			$message = $str;
			//$from = "info@mysitti.com";

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: MySitti <mysitti@mysitti.com>' . "\r\n";
			//$headers .= "From:" . $from;

			mail($to,$subject,$message,$headers,"-finfo@mysitti.com");			
			/* email code ended */		
				$Obj->Redirect("subuserList.php?msg=added");	
			}
			else
			{
				$Obj->Redirect("subuserList.php?msg=notadded");
			}
		}
}

if(isset($_POST['update']))
{
	$getuserinfo = @mysql_query("SELECT * FROM `hostsubusers` WHERE `id` = '".$_GET['userid']."'  ");
	$fetchuserinfo = @mysql_fetch_array($getuserinfo);
	
	$getplantypequery = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$_SESSION['user_id']."' ");
		$fetchplantype = @mysql_fetch_array($getplantypequery);

	if($_FILES["profile_image"]["name"]!="")
	{
		
		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
		$temp = explode(".", $_FILES["profile_image"]["name"]);
		$extension = end($temp);
		
		if ((($_FILES["profile_image"]["type"] == "image/gif")
		|| ($_FILES["profile_image"]["type"] == "image/jpeg")
		|| ($_FILES["profile_image"]["type"] == "image/jpg")
		|| ($_FILES["profile_image"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts))
		{
		 
				if ($_FILES["profile_image"]["error"] > 0)
				{
					echo "Error: " . $_FILES["profile_image"]["error"] . "<br>";
				}
				else
				{
					
					$name = $_FILES["profile_image"]["name"];
					$tmp = $_FILES["profile_image"]["tmp_name"];
					$ext =substr($name,strrpos($name,'.'));
					$path = "upload/subuser/".time().strtotime(date("Y-m-d")).$name;
					$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$name."_thumbnail".$ext;
					$thumbnail = "upload/subuser/".$thumb;
					move_uploaded_file($tmp,$path);
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
					
				}
				$adduserquery = @mysql_query("UPDATE `hostsubusers` SET `user_thumb`='".$thumbnail."', `userimage`= '".$path."' WHERE `id` = '".$_GET['userid']."' ");
				$adduserquery1 = @mysql_query("UPDATE `clubs` SET `image_nm` = '".$thumbnail."' WHERE `club_name` = '".$fetchuserinfo['username']."' ");

		}
		else
		{
			$url = "addSubuser.php?msg=imagefail&userid=".$_GET['userid'];
			$Obj->Redirect($url);
			exit;
		}
	}

	$uname	 = $_POST['uname'];
	$uemail	 = $_POST['email'];
	$upass	 = $_POST['pass'];
	if($_POST['allowpayment'] == 'on')
	{
		echo $allowpayment = 1;
	}
	else    
	{
		echo $allowpayment = 0;
	}
	

	$checkunamequery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$uname."' AND `id` != '".$_GET['userid']."'  ");
	$countcheckuname = @mysql_num_rows($checkunamequery);
	$checkemailquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `useremail` = '".$uemail."' AND `id` != '".$_GET['userid']."'  ");
	$countcheckemail = @mysql_num_rows($checkemailquery);
	$error = array();
	if($countcheckemail > 0)
	{
		$error['email'] = "Email Already Exists !";
	}
	if($countcheckuname > 0)
	{
		$error['uname'] = "ProfileID Already Exists !";
	}

	if(empty($error))
	{
		$adduserquery = @mysql_query("UPDATE `hostsubusers` SET  `username` = '".$uname."', `useremail` = '".$uemail."', `password` = '".$upass."', `allowpayment` ='".$allowpayment."' WHERE `id` = '".$_GET['userid']."' ");
		$adduserquery1 = @mysql_query("UPDATE `clubs` SET `image_nm` = '".$thumbnail."' , `club_name` = '".$uname."', `club_email` = '".$uemail."', `password` = '".$upass."' WHERE `club_name` = '".$fetchuserinfo['username']."' ");
		if($adduserquery)
		{
			
			$str = "
				<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
					<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
					<hr>
					<p style='color: white;'>
						<br />
			You have recently updated following info.
						<br /><br />
							Username: ".$uemail."<br>
							Password: ".$upass."<br>
							Profile Id : ".$uname."<br>
							<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'>https://mysitti.com</a>
						<br /><br />
					</p>	
						<p style='color: white;'> Thank you,<br><br>
						<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'> MYSITTI.COM </a>
						</p>
				</div>
			 ";

			$message = $str; 
			$to  = $fetchplantype['club_email'];

			$subject = "MYSITTI.com - Sub User Updated";
			$message = $str;
			//$from = "info@mysitti.com";

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: MySitti <mysitti@mysitti.com>' . "\r\n";
			//$headers .= "From:" . $from;

			mail($to,$subject,$message,$headers,"-finfo@mysitti.com");			
			/* email code ended */		
			
			$Obj->Redirect("subuserList.php?msg=updated");	
		}
		else
		{
			$Obj->Redirect("subuserList.php?msg=notupdated");
		}
		
	}

}


if(isset($_GET['userid']))
{
	$userid = $_GET['userid'];
	$titleofpage = "Edit User";

	$getuserinforquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `id` = '".$userid."'  ");
	$fetchuserinfo = @mysql_fetch_array($getuserinforquery);

	$uname = $fetchuserinfo['username'];
	$uemail = $fetchuserinfo['useremail'];
	$upass = $fetchuserinfo['password'];
	$userimage = $fetchuserinfo['userimage'];
	$userthumb = $fetchuserinfo['user_thumb'];
	$allowpayment = $fetchuserinfo['allowpayment'];

}


?> 
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	 <?php	include('club-right-panel.php');?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
					<?php
						if(isset($_GET['userid']))
						{
							echo "<h3 id='title'>Edit User</h3>";
						}
						else
						{
							echo "<h3 id='title'>Add User</h3>";
						}

					?>
						<div class="parent-message-div">
					<?php 
						if(!empty($error))
						{
							if(isset($error['email']))
							{
								echo "<div id='successmessage' class='message' >".$error['email']."</div>";	
							}
							if(isset($error['uname']))
							{
								echo "<div id='successmessage' class='message' >".$error['uname']."</div>";	
							}
							if((isset($error['email'])) && (isset($error['uname'])) )
							{
								echo "<div id='successmessage' class='message' >Email and Username already exits!</div>";	
							}
							
						}

						if((isset($_GET['msg'])) && ($_GET['msg'] == "imagefail") )
						{
							echo "<div id='successmessage' class='message' >Image not able to upload. Please try again.</div>";
						}
						if((isset($_GET['msg'])) && ($_GET['msg'] == "emailerror") )
						{
							echo "<div id='successmessage' class='message' >Please Enter Valid Email.</div>";
						}
					?>
						</div>
					<?php
						if(isset($_GET['userid']))
						{
					?>
						<script type="text/javascript">
							function updatepassword(){
								msg="Newly generated password will be sent to main host registered email address please check your spam folder as well to make sure email get delivered.\n\nAre you sure to continue ?";
								
								if(confirm(msg)){
									window.location="addSubuser.php?generate_pass=1&userid=<?php echo $_GET['userid'] ?>";
								}
							}
						</script>
					<?php
						}
					?>
						<form name="signupd" id="signupd" method="POST" action="" enctype="multipart/form-data" class="addsubuser" >
							<div class="edit_profile_f">
								<div id="profile_box">
									<ul>
										<li>ProfileID:<span style="color:#F00">*</span></li>
										<li><input onblur="return ChkUserProfileName(this.value,'user','<?php echo $SiteURL;?>');" name="uname" type="text" value="<?php echo $uname; ?>" required /></li>
									</ul>
									<ul>
										<li>User Name:<span style="color:#F00">*</span></li>
										<li><input onblur="return ChkUserEmail(this.value,'user','<?php echo $SiteURL;?>');"  name="email" type="text" placeholder="abc@example.com" value="<?php echo $uemail; ?>" required /></li>
									</ul>
									<ul>
										<li>Password:<span style="color:#F00">*</span></li>
										<li><input name="pass" type="text" value="<?php echo $upass; ?>" required /></li>
									</ul>
									<ul>
										<li>Profile Image:</li>
										<li> <input style="color: #FFF;" type="file" name="profile_image" id="selectedFile"  /></li>
									</ul>
							 		<p>
							 			<input type="checkbox" name="allowpayment" id="allowpayment" <?php if($allowpayment == 1){echo "checked";}?>/>
							 			&nbsp;&nbsp;Allow To Recieve Payment
							 		</p>
				<?php 				if(isset($_GET['userid']))
								{
							?>
									<ul class="v2_edituser_thumb">
										<li>Current Image:</li>
										<li><?php if($userimage != ""){ ?> <img src="<?php echo $userthumb; ?>" /><?php }else{ echo "<img src='images/man4.jpg' />" ; }?></li>
									</ul>
				<?php 				}
				?>
									<ul class="btncenter_new v2_edituser_btn" style="width:100%;">
										
								<?php 
									if(isset($_GET['userid']))
									{
								?>
										<li>
											<a class="button"  href="javascript:void(0);" onclick="updatepassword();">Generate/Update Streaming Password</a>
										</li>
                                        
										<li style="float:right">
											<input name="update" class="button" type="submit" value="Update" />
										</li>
										<li  style="float:right; margin-right:10px;">
											<input name="cancel" class="button" type="button" onclick="window.location = 'subuserList.php' " value="Cancel" />
										</li>
										
								<?php 	}
									else
									{
								?>
										<li>
											<input name="save" class="button" type="submit" value="Save" />
										</li>
										<li>
											<input name="cancel" class="button" type="button" onclick="window.location = 'subuserList.php' " value="Cancel" />
										</li>
							<?php 		}	?>
										
									</ul>			
								</div>
							</div>
						</form>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript">

function ChkUserEmail(email,type,url)
{
	var url = url+'ChkUserId.php?email_id='+email+'&type='+type;
	if(email!="")
	{
		ajaxFunction(url, function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var s = xmlhttp.responseText;
				if(s==0)
				{
					alert("The email address is already taken. Please choose another one.");	
					if(type=='user')
					{
						document.signupd.email.value="";
						document.signupd.email.focus() ;
					}
					return false;
				}
			}
		});
	}
}



function ChkUserProfileName(profilename,type,url)
{
	if(profilename!="")
	{
		var url = url+'ChkUserProfile.php?profilename='+profilename+'&type='+type;
		ajaxFunction(url, function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var s = xmlhttp.responseText;
				if(s==0)
				{
					alert("The Username is not available.Please choose another.");	
					if(type=='user')
					{
						document.signupd.uname.value="";
						document.signupd.uname.focus() ;
					}
					return false;
				}
			}
		});
	}
}
</script>

<?php include('Footer.php'); ?>



