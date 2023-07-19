<?php
error_reporting(0);
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}
include('NewHeadeHost.php');

$userType= $_SESSION['user_type'];
$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="success")
	{
		$message="Profile Updated Successfully.";
	}
	if($para=="imagefail")
	{
		$message="Invalid Image.";
	}
}

$userID=$_SESSION['user_id'];

 if(isset($_POST['update'])){

  $_SESSION['id']=$_POST['city'];
  $_SESSION['state']=$_POST['state'];

  if($_FILES["profile_image"]["name"]!="")
    {


		$allowedExts = array("gif", "jpeg", "jpg", "png","PNG","GIF","JPG","JPEG");
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
			$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
			$temp = explode(".", $_FILES["profile_image"]["name"]);
			$extension = end($temp);
			$name = $_FILES["profile_image"]["name"];
			$ext =substr($name,strrpos($name,'.'));
			$tmp1 = $_FILES["profile_image"]["tmp_name"];
			$path = "upload/".time().strtotime(date("Y-m-d")).$name;
			$thumb = $path."_thumbnail".$ext;
			$thumbnail = $thumb;
			$image_path=$thumb;
			$forum_img = $thumb;
	
			move_uploaded_file($tmp1,$path);
			
			$file = $path;
		
			$resizedFile = $thumbnail;
		
			$resizeObj = new resize($file);

			$resizeObj -> resizeImage(300,200, 'auto');

			$resizeObj -> saveImage($resizedFile, 100);	

		}
  	}
	else
  	{
  		$Obj->Redirect("user_profile.php?msg=imagefail");
  	}
}


 if($_POST['fname'] ==""){ $first_name=""; } else { $first_name=trim($_POST['fname']); };
 if($_POST['lname'] ==""){ $last_name=""; } else { $last_name=trim($_POST['lname']); };
 if($_POST['country'] ==""){ $country=""; } else { $country=trim($_POST['country']); };
 if($_POST['state'] ==""){ $state=""; } else { $state=trim($_POST['state']); };
 if($_POST['city'] ==""){ $city=""; } else { $city=trim($_POST['city']); };
 if($_POST['zipcode'] ==""){ $zipcode=""; } else { $zipcode=trim($_POST['zipcode']); };

 if($_POST['new_pass'] ==""){ $new_pass=""; } else { $new_pass=trim($_POST['new_pass']); };
 if($_POST['club_conf_pass'] ==""){ $club_conf_pass=""; } else { $club_conf_pass=trim($_POST['club_conf_pass']); };

if($_SESSION['user_type'] == 'club'){

if($_FILES["profile_image"]["name"]!="")
{

 	$update_sql="update clubs set first_name='".$first_name."',last_name='".$last_name."',club_country='".$country."',club_city='".$city."',club_state='".$_POST['state']."',zip_code='".$zipcode."',image_nm='".$forum_img."' where id='".$userID."'";
 	session_start(); $_SESSION['img'] = $forum_img; session_write_close();
}
else
{
  	$update_sql="update clubs set first_name='".$first_name."',last_name='".$last_name."',club_country='".$country."',club_city='".$city."',club_state='".$_POST['state']."',zip_code='".$zipcode."' where id='".$userID."'";
 	session_start(); $_SESSION['img'] = $forum_img; session_write_close();
}		


 if(isset($_POST['user_new_pass']) && !empty($_POST['user_new_pass']))
{
	$newPassword = $_POST['user_new_pass'];
	mysql_query("UPDATE `clubs` SET `password` = '$newPassword' WHERE `id` = '$_SESSION[user_id]' ");
}


}else{

if($_FILES["profile_image"]["name"]!="")
{

 	$update_sql="update user set first_name='".$first_name."',last_name='".$last_name."',country='".$country."',city='".$city."',state='".$_POST['state']."',zipcode='".$zipcode."',image_nm='".$forum_img."' where id='".$userID."'";
 	session_start(); $_SESSION['img'] = $forum_img; session_write_close();
}
else
{
  	$update_sql="update user set first_name='".$first_name."',last_name='".$last_name."',country='".$country."',city='".$city."',state='".$_POST['state']."',zipcode='".$zipcode."' where id='".$userID."'";
 	session_start(); $_SESSION['img'] = $forum_img; session_write_close();
}		


 if(isset($_POST['user_new_pass']) && !empty($_POST['user_new_pass']))
{
	$newPassword = $_POST['user_new_pass'];
	mysql_query("UPDATE `user` SET `password` = '$newPassword' WHERE `id` = '$_SESSION[user_id]' ");
}

}	
 
}
 $update= mysql_query($update_sql);
 if($update){
 	
 header("Refresh:0; url=user_profile.php"); die;
 }

//For Host User
if($_SESSION['user_type'] == 'club'){

	$first_name=$loggedin_host_data['first_name'];
	$last_name=$loggedin_host_data['last_name'];
	$email=$loggedin_host_data['club_email'];
	$country = $loggedin_host_data['club_country'];
	$state =  $loggedin_host_data['club_state'];
	$club_city = $loggedin_host_data['club_city'];
	$zipcode = $loggedin_host_data['zip_code'];
	$displayImage = $loggedin_host_data['image_nm'];
}else{
   
    //For Mysitti USer
	$first_name=$loggedin_user_data['first_name'];
	$last_name=$loggedin_user_data['last_name'];
	$email=$loggedin_user_data['email'];
	$country = $loggedin_user_data['country'];
	$state =  $loggedin_user_data['state'];
	$club_city = $loggedin_user_data['city'];
	$zipcode = $loggedin_user_data['zipcode'];
	$displayImage = $loggedin_user_data['image_nm'];

}

?>
<style type="text/css">
.overlayNewHeader{display: none;}
.NewHeaderHostBanner{display: none;}	
</style>

<article class="forum_content v2_contentbar">
	<div class="v2_rotate_neg">
		<div class="v2_rotate_pos">
			<div class="v2_inner_main_content">
 
			 
			 	<form name="update_user" id="signup_1" method="post" enctype="multipart/form-data" class="user-edit-form">

			 	  <div class="container">

                     <div class="pf-igm1">
	                     <?php if($_SESSION['user_type'] == 'club'){ ?>
							<img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$displayImage;} ?>" alt="user" width="200" height="200">
						<?php } else { ?>
							<img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$_SESSION['img'];} ?>" alt="user" width="200" height="200">
						<?php } ?>
	                     <input type="file" name="profile_image" id="selectedFile" style="color: #fff;" onchange="return ValidateFileUpload()"/>
                      </div>

                    
					  <div class="row">
					    <div class="col-sm-6">
							<ul>
								<li>First Name:</li>
								<li>
								<input name="fname" type="text" value="<?php echo ucfirst($first_name); ?>"  class="form-control" />
								</li>
							</ul>
					    </div>
					    <div class="col-sm-6">
							<ul>
								<li>Last Name:</li>
								<li>
									<input name="lname" type="text" value="<? echo ucfirst($last_name); ?>" class="form-control" />
								</li>
							</ul>
					    </div>
					  </div>

					  <div class="row">
					    <div class="col-sm-6">
					    	<ul class="lField counry-profile">
							<?php 
							$countrysql="select country_id,name from country where country_id IN ('223','38') ";
							$country_list = mysql_query($countrysql);
							?>
									<li>Country:</li>
									<li>
										<select name="country" id="country" onChange="showStatehost(this.value);" class="form-control">
											<option value="" class="form-control">- - Select - -</option>
										<?php 
										$country_nm_qry = mysql_query("SELECT `name` FROM `country` WHERE `country_id` = '".$country."' ORDER BY `name` ASC");
										$country_nm = mysql_fetch_array($country_nm_qry);
										$state_nm_qry = mysql_query("SELECT `name` FROM `zone` WHERE `zone_id` = '".$state."' ORDER BY `name` ASC");
										$state_nm = mysql_fetch_array($state_nm_qry);
										while($row = mysql_fetch_array($country_list))
										{
									?>
											<option  value="<?php echo $row["country_id"]; ?>" <?php if($row["country_id"]== $country) {?> selected='selected'<?php } ?>><?php echo $row["name"];  ?></option>
									<?php	}	?>
								</select>
							</li>
						</ul>

					    </div>
				<div class="col-sm-3">
					     <ul class="rField state-profile">
							<li>State: </li>
							<?	$statesql=mysql_query("select name,zone_id from zone where country_id ='".$country."'");?>
							<li>
							<select name="state" class="form-control" id="hoststate" onChange="getcity_host(this.value);">
								<option   value= "">- - Select - -</option>
							<?php	
								while($row_s = mysql_fetch_array($statesql))
								{
							?>
									<option value="<?php echo $row_s["zone_id"]; ?>" class="form-control" <?php if($row_s["zone_id"]==$state) { echo "Selected"; } ?>><?php echo $row_s["name"]; ?></option>
							<?php	}	?>
							</select>
						</li>
					</ul>
				</div>

			    <div class="col-sm-3">
			    	<ul class="lField city-profile">
					<li class="txt">City</li>
					<li>
						<select name="city" id="hostcity" class="form-control" >
							<option value="">- -Select- -</option>
						<?php 
						$allcity="select city_id,city_name from capital_city where state_id='".$state."' order by city_name"; 
						$city_list1 = mysql_query($allcity);
						?>
						<?php 
						while($row_city = mysql_fetch_array($city_list1))
						{
						?>
						<option value="<?php echo $row_city["city_id"]; ?>" <?php if($club_city==$row_city["city_id"]) { ?> selected="selected" <?php } ?>><?php echo $row_city["city_name"]; ?></option>
						<?php
						}

						?>
						</select>
					</li>
				</ul>

			    </div>

			</div>
			         <div class="row">
					  <div class="col-sm-6">
                       <ul>
							<li>Email:</li>
							<li>
								<input name="email" readonly="readonly" type="text" value="<? echo $email; ?>" class="form-control" />
							</li>
					</ul>
					  </div>
					  </div>

                    <div class="row">
					  <div class="col-sm-6">
                       <ul>
							<li>Zipcode:</li>
							<li>
								<input name="zipcode" type="text" value="<? echo $zipcode; ?>" class="form-control" />
							</li>
						</ul>
					    
					  </div>
					  </div>

					  <h3>Change Your Password </h3>
                   
	                  <div class="row">
	                   <div class="col-sm-6">
	                      <ul >
			
							<li>New Password</li>
							<li>
								<input name="user_new_pass" id="user_new_pass" type="password" value="" placeholder="Enter password" class="form-control" />
							</li>

							<br />
							<li>Confirm Password</li>
							<li>
								<input name="user_conf_pass" type="password" id="txtConfirmPassword" value="" placeholder="Confirm password" class="form-control" />
							</li>

					</ul>
						    
				   </div>
				   </div>
			</div>

                <div class="row">
			     <div class="col-sm-6">
			     <div id="submit_btn subtbn" style="width: auto;">
						<input name="update" id="btnSubmit" class="button btn_add_venu" type="submit" value="Save" />
					</div>

			     </div>
			     </div>

			 	</form>
         </div>
       </div>
	</div>


<script type="text/javascript">
function ValidateFileUpload(){
	var check_image_ext = $('#selectedFile').val().split('.').pop().toLowerCase();
	if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
		alert('Profile Image only allows file types of GIF, PNG, JPG and JPEG');
		$('#selectedFile').val('');
	}
}	
</script>

<script>
function showStatehost(x)
{

	if(x=='223')
	{
		 $.get('getcity_sign.php?con=us', function(data) {
		//$('#cities_host').html(data);
		});
	}else
	{
		 $.get('getcity_sign.php?con=ca', function(data) {
		//$('#cities_host').html(data);
		});
	}
	ajaxFunction("getstate.php?country_id="+x, function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var s = xmlhttp.responseText;    //   s = "1,2,3,|state1,state2,state3,"
			s=s.split("|");                              //   s = ["1,2,3,", "state1,state2,state3,"]
			sid = s[0].split(",");  
			//  sid = [1,2,3,]
			sval = s[1].split(",");      
			//  sval = [state1, state2, state3,]
			st = document.getElementById('hoststate');
			st.length=0; 
			for(i=0;i<sid.length-1;i++)
			{
				st[i] = new Option(sval[i],sid[i]);
			}              
		}
	});
}

function getcity_host(x)
{
	$.get('getcity_sign.php?state_id='+x, function(data) 
	{
		$('#hostcity').html(data);
	});
}

 $(function () {
        $("#btnSubmit").click(function () {
            var password = $("#user_new_pass").val();
            var confirmPassword = $("#txtConfirmPassword").val();
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        });
    });

function ValidateFileUpload(){
		var check_image_ext = $('#selectedFile').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Profile Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#selectedFile').val('');
		}
}
</script>		





