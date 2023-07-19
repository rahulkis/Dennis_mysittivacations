<?php

$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
}

$titleofpage="Music Settings";

if(isset($_POST['submit_music_request']))
{
	//echo "<pre>";print_r($_POST);die;
	$u_id = $_POST['host_id'];
	$disable_music_request = $_POST['disable_music_request'];
	$free_music_request = $_POST['free_music_request'];
	$music_request_price = $_POST['music_request_price'];
	$request_limit = $_POST['request_limit'];

	if($_FILES["profile_image"]["name"]!="")
	{
		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
		$temp = explode(".", $_FILES["profile_image"]["name"]);
		$extension = end($temp);
		$name = $_FILES["profile_image"]["name"];
		$ext =substr($name,strrpos($name,'.'));
		$temp = explode(".", $_FILES["profile_image"]["name"]);
		$extension = end($temp); 
		$tmp1 = $_FILES["profile_image"]["tmp_name"];
		$path = "upload/subuser/".time().strtotime(date("Y-m-d")).$name;
		$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$name."_thumbnail".$ext;
		$thumbnail = "upload/subuser/".$thumb;
		$image_path="upload/".$thumb;
		move_uploaded_file($tmp1,$path);	

		$file = $path;
			
		//indicate the path and name for the new resized file
		$resizedFile = $thumbnail;
		
		//call the function (when passing path to pic)
		smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
		//call the function (when passing pic as string)
		smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );

		mysql_query("update hostsubusers set `user_thumb` = '".$thumbnail."', `userimage` = '".$path."' where username ='".$_SESSION['username']."' ");
		$_SESSION['img'] = $thumbnail;
	}

	if($disable_music_request == 1){
		
		$free_music_request = 0;
		$music_request_price = 0;
	}
	
	if($free_music_request == 1){
		
		$disable_music_request = 0;
		$music_request_price = 0;
	}
	
	if(!empty($music_request_price)){
		$free_music_request = 0;
		$disable_music_request = 0;
		
	}

	mysql_query("update hostsubusers set `profilename`= '".$_POST['user_profile']."', `profile_link` = '".$_POST['user_link']."' where username ='".$_SESSION['username']."' ");
	if(isset($_POST['merchant_id']))
	{
		mysql_query("update hostsubusers set `merchant_id`='".$_POST['merchant_id']."' where username ='".$_SESSION['username']."' ");
		
	}
		
	$query = mysql_query("SELECT * FROM music_settings WHERE user_id = '$userID'");
		
	$count_rows = mysql_num_rows($query);
	
	if($count_rows == 0)
	{
		mysql_query("INSERT INTO music_settings (request_limit,user_id, disable_music_req, free_music_req, request_price)VALUES('$request_limit','$userID', '$disable_music_request', '$free_music_request', '$music_request_price')");
		
		$message =  "<div class='success_message'> Data Updated Successfully</div>";
		
	}
	else
	{
		mysql_query("UPDATE music_settings SET request_limit='$request_limit',disable_music_req = '$disable_music_request', free_music_req = '$free_music_request' , request_price = '$music_request_price' WHERE user_id= '$userID' ");
		
		$message =  "<div class='success_message'> Data Updated Successfully</div>";
		
	}
					
}



if(isset($_POST['saverequest']))
{
	
	$stat = trim($_POST['status']);
	if($stat == "")
	{
		$stat = "0";
	}
	$query = mysql_query("UPDATE clubs SET musicrequeststatus = '$stat' WHERE id= '$userID' ");

	if($stat == '1')
	{
		
		$message = '<div  id="successmessage" class="message"> Music Requests are now disabled.</div>';
	}
	else
	{
		$message = '<div  id="successmessage" class="message"> Music Requests are now enabled.</div>';
		
	}
	
}

if(isset($_POST['statusupdate']))
{
	$message = '<div  id="successmessage" class="message">Request status updated successfully.</div>';
	
}

$get_groups = mysql_query("SELECT `club_name`,`id` FROM `clubs` ORDER BY `club_name` ASC ");


	if(isset($_GET['host_id']))
	{
		$hostID1 = $_GET['host_id'];
	}
	else
	{
		$hostID1 = $_SESSION['user_id'];
	}
	
	if(isset($_POST['savesetting']))
	{
		// echo "<pre>"; print_r($_POST); die;
		$value = $_POST['function'];
		if($value == "Disable with message")
		{
			$m = $_POST['jukeboxmessage'];
		}
		else
		{
			$m = "";
		}
		
		$getq1 = mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_SESSION['user_id']."'  ");
		$countrec1 = mysql_num_rows($getq1);

		if($countrec1 > 0)
		{
			mysql_query("UPDATE `host_functions_setting` SET `jukebox` = '$value', `jukeboxmessage` = '$m' WHERE `host_id` = '".$hostID1."'  ");
		}
		else
		{
			mysql_query("INSERT INTO `host_functions_setting` (`host_id`,`jukebox`,`jukeboxmessage`) VALUES ('".$hostID1."','$value','$m')  ")	;
		}
		$message = '<div  id="successmessage" class="message">Jukebox Display Settings is Saved.</div>';

	}


?>
<div class="clear"></div>

					<div class="v2_inner_main_content">
  						<?php 	echo $message;?>
						<h3 id="title">Music Settings</h3>
						<?php
							$get_res_query = mysql_query("SELECT * FROM music_settings WHERE user_id = '$userID'"); 
							$row =	mysql_fetch_row($get_res_query);
						?>
						<div class="musiclisting">
							<form action="" method="POST" enctype="multipart/form-data">
								<table class="music_set_lst_tb width50" >
							                      <!--   <tr>
										<td>Set Request Price: $  </td>
									</tr> -->
									<tr>
							                      		<td>
							                              		<table class="width100">
										                        	<tr>
										                            	<td class="wtd2">
														Free Music Request
														<input type="radio" value="1" name="free_music_request" id="free_music_request" <?php if($row['3'] == 1){ echo "checked"; } ?>>
													</td>
									                            	</tr>
					                            				</table>
                            								</td>
									</tr>
					<?php 
								$allowpay =  mysql_query("select * from hostsubusers where username ='".$_SESSION['username']."' ");
								$allowpayfetch = mysql_fetch_assoc($allowpay);
								if($allowpayfetch['allowpayment'] == '1')
								{
						?>
									<tr>	
										<td>
											Merchant ID:
										</td>
									</tr>
									<tr>
										<td>
											<input type="text" name="merchant_id" value="<?php echo $allowpayfetch['merchant_id']; ?>"  />
										</td>
									</tr>	
					<?php 			} 			?>						
									<tr>	
										<td>
											Music Request Limit:
											<input type="text" name="request_limit" id="request_limit" value="<?php echo $row['5']; ?>"/>
										</td>
									</tr>
									<tr>	
										<td>
											Profile Image: 
										</td>
									</tr>
									<tr>
										<td>
											<input type="file" name="profile_image" id="pimage" />
										</td>
										
									</tr>	
														
									
									
									<tr>	
										<td>
											Current Image:
										</td>
									</tr>
									<tr>
										<td>
											<a href="<?php echo $allowpayfetch['userimage']; ?>" rel="lightbox"><img src="<?php echo $allowpayfetch['user_thumb']; ?>" /></a>
										</td>
                        								</tr>
                        							</table>
								<table class="music_set_lst_tb" style="width:50%;">
                        								<tbody>						
										<tr>	
											<td>
												Profile name: 
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" name="profile_name" id="pname" value="<?php echo $allowpayfetch['profilename']; ?>" placeholder="Enter profile name" />
											</td>
											<!-- <td>
												<input type="button" name="profile_name" id="pname" value="" placeholder="Enter profile name" />
											</td> -->
											
										</tr>
										<tr>	
											<td>
												User Profile: 
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" name="user_profile" id="userprofile" value="<?php echo $allowpayfetch['profilename']; ?>" placeholder="User profile" />
											</td>
											
										</tr>
										<tr>	
											<td>
												User Url: 
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" name="user_link" id="ulink" value="<?php echo $allowpayfetch['profile_link']; ?>" placeholder="User Profile Link" />
											</td>
											
										</tr>
										

										<tr>	
											<td>
												<input type="hidden" value="160" name="host_id">
												<span><input class="button" type="submit" name="submit_music_request" value="Save"></span>
											</td>
										</tr>
									</tbody>
								</table>
							</form>
						</div>
				<?php 	if($_SESSION['user_type'] != "user")
    					{
    				?>
						<div class="storefunctionsetting">
							<h1 id="title">Jukebox Page Display Settings: </h1>
							<?php 
							$getq = mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$hostID1."'  ");
							$countrec = mysql_num_rows($getq);
							if($countrec > 0)
							{
								$fetchstatus = mysql_fetch_array($getq);
								$statuspage = $fetchstatus['jukebox'];
								$me = $fetchstatus['jukeboxmessage'];
							}
							else
							{
								$statuspage = "Enable";
								$me= "";
							}


							?>
							
							<form method="POST" action="" name="storesettings" id="storesettingsform" >
								<div><input <?php if($statuspage == "Enable"){ echo "checked"; } ?> type="radio" name="function" value="Enable" />Enable</div>
								<div><input <?php if($statuspage == "Disable with message"){ echo "checked"; } ?> type="radio" name="function" value="Disable with message" id="disbleshow" />Disable with message</div>
								<div id="disablemessage" style="display: none;"><input   type="text" name="jukeboxmessage" value="<?php echo $me;?>" /></div>
								<div><input <?php if($statuspage == "Disable without message"){ echo "checked"; } ?> type="radio" name="function" value="Disable without message" />Disable And Hide</div>
								<div class="settingformsubmit"><input type="submit" class="button" name="savesetting" value="Save" /></div>
							</form>
						</div>
			<?php 		}  ?>
  					</div>
  			
			<div class="equalizer"></div>
	

<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->
<script src="autocomplete/jquery.ajaxcomplete.js"></script>
<script type="text/javascript">
	function isNumberKey(evt)
	{
	$('#disable_music_request').attr('checked', false);
	$('#free_music_request').attr('checked', false);		
		
		
	   var charCode = (evt.which) ? evt.which : evt.keyCode;
	   if (charCode != 46 && charCode > 31 
		 && (charCode < 48 || charCode > 57))
		  return false;
	
	   return true;
	}
	
	$(document).ready(function(){
	
		$('#disable_music_request').click(function(){
			
			$('#free_music_request').attr('checked', false);
			$('#music_request_price').val('');
		});
		
		$('#free_music_request').click(function(){
			
			$('#disable_music_request').attr('checked', false);
			$('#music_request_price').val('');
		});	

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

$(document).ready(function(){
	var str = $('#pname').val();
	$('#pname').autocomplete("jukeboxquery.php?title=allclubs").change( function(){
		setTimeout(function(){
			var mu_title  = $('#pname').val();
			var newsearchlist  = 'fetchdatacluball'; 
			$.ajax({
				type: "POST",
				url: "refreshajax.php",
				data: {
			   		'clubname' : mu_title,
					'action' : 'fetchdatacluball'
				},
				success: function(data){
					$('#userprofile').val(mu_title).attr('readonly',true);
					$('#ulink').val(data).attr('readonly',true);
			  	}
			});	
		}, 1000);
	});
});
</script>	
<style>
.success_message {
  background: green none repeat scroll 0 0;
  color: #fff;
  float: left;
  margin-bottom: 10px;
  padding: 10px 0;
  text-align: center;
  text-transform: uppercase;
  width: 100%;
}
</style>