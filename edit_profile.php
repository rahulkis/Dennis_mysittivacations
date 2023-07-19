<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}
// echo "<pre>"; print_r($_SESSION); echo "</pre>"

if(isset($_GET['msg']) && $_GET['msg'] == 'success1')
{
	$Obj->Redirect('edit_profile.php?msg=success');die;
}


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

if(isset($_POST['enableordiablephoneID']))
{
	$userID=$_SESSION['user_id'];
	$userType= $_SESSION['user_type'];
	$statustext=$_POST['enableordiablephoneID'];
	if($_SESSION['user_type']=="club"){
		echo $update_sqltext="update clubs set text_status='".$statustext."' where id='".$userID."'";
		$sqldatetext=mysql_query($update_sqltext);die;
	}else{
		echo $update_sqltext="update user set text_status='".$statustext."' where id='".$userID."'";
		$sqldatetext=mysql_query($update_sqltext);die;
	}
}



$titleofpage = "Edit Profile";
if($_SESSION['user_type'] == "club")
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');
}



/* UPDATE CODE */

if($_POST['update'])
{

	$dateofbirth =$_POST['year']."-".$_POST['month']."-".$_POST['date'];
	$_SESSION['id']=$_POST['city'];// here we are storing city id of logged user
   	$_SESSION['state']=$_POST['state']; // here we are storing state id of logged user
	$hear_abt = $_POST['hear_about'];
	if($_POST['deactivate'] == "on")
	{
		$deactivate = "1";
	}
	if(isset($_POST['sms-carrier']))
	{
		$smscarrier = $_POST['sms-carrier'];
	}
	else
	{
		$smscarrier = "";
	}

/***************************imageupload*/
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
	  		$Obj->Redirect("edit_profile.php?msg=imagefail"); die;
	  	}
	}
/***********/
	
    	if($_POST['fname'] ==""){ $first_name=""; } else { $first_name=trim($_POST['fname']); };
    	if($_POST['user_address'] ==""){ $user_address=""; } else { $user_address= trim(mysql_real_escape_string($_POST['user_address'])); };
	if($_POST['lname'] ==""){ $last_name=""; } else { $last_name=trim($_POST['lname']); };
	if($_POST['country'] ==""){ $country=""; } else { $country=trim($_POST['country']); };
	if($_POST['phone'] ==""){ $phone=""; } else { $phone=trim($_POST['phone']); };
	if($dateofbirth ==""){ $dob="0000-00-00"; } else { $dob=$dateofbirth; };
	if($_POST['state'] ==""){ $state=""; } else { $state=trim($_POST['state']); };
	if($_POST['city'] ==""){ $city=""; } else { $city=trim($_POST['city']); };
	if($_POST['zipcode'] ==""){ $zipcode=""; } else { $zipcode=trim($_POST['zipcode']); };
	if($_POST['email'] ==""){ $email=""; } else { $email=trim($_POST['email']); };
	
	if($_POST['pname'] ==""){ $pname=""; } else { $pname=trim($_POST['pname']); };
	if($_POST['hideuseraddress'] ==""){ $hideaddress=""; } else { $hideaddress=trim($_POST['hideuseraddress']); };

	if(!empty($_POST['pname']) && $_POST['pname'] != $_SESSION['profile_name'])
	{
		$checkpname = @mysql_query("SELECT * FROM `user` WHERE `profilename` = '".$pname."' ");
		$countres = @mysql_num_rows($checkpname);
		if($countres > 0)
		{
			$Obj->Redirect("edit_profile.php?msg=Error: Profile name Already exits"); die;
		}
	}


			$_SESSION['id']=$city;// here we are storing city id of logged user
		   	$_SESSION['state']=$_POST['state']; // here we are storing state id of logged user

		    	$pname = mysql_real_escape_string($pname);

			if($_POST['change_password']!="")
			{
			   $update_sql2=mysql_query("update user set password='".$_POST['change_password']."' where id='".$userID."'");	
			}
			
			if($_FILES["profile_image"]["name"]!="")
		  	{
			 	$update_sql="update user set sms_carrier = '$smscarrier',profilename='".$pname."',first_name='".$first_name."',user_address='".$user_address."',last_name='".$last_name."',country='".$country."',email='".$email."',city='".$city."',state='".$_POST['state']."',DOB='".$dob."',zipcode='".$zipcode."',image_nm='".$forum_img."',phone='".$phone."',logged_date='".date('Y-m-d H:i:s')."',hear_about = '".$hear_abt."', `hideaddress` = '$hideaddress' where id='".$userID."'";
			 	session_start(); $_SESSION['img'] = $forum_img; session_write_close();
			}
			else
			{
			  	$update_sql="update user set sms_carrier = '$smscarrier',profilename='".$pname."',first_name='".$first_name."',last_name='".$last_name."',user_address='".$user_address."',country='".$country."',email='".$email."',city='".$city."',state='".$_POST['state']."',DOB='".$dob."',zipcode='".$zipcode."',phone='".$phone."', logged_date='".date('Y-m-d H:i:s')."',hear_about = '".$hear_abt."', `hideaddress` = '$hideaddress' where id='".$userID."'"; 
			}			
			$_SESSION['usercity'] = $city ;
			$_SESSION['username'] = $pname;
			$_SESSION['profile_name'] = $pname;

			if(isset($_POST['user_new_pass']) && !empty($_POST['user_new_pass']))
			{
				$newPassword = $_POST['user_new_pass'];
				mysql_query("UPDATE `user` SET `password` = '$newPassword' WHERE `id` = '$_SESSION[user_id]' ");
			}


			$update= mysql_query($update_sql);
			
			//echo "<pre>"; print_r($_SESSION); exit;
			$Obj->Redirect("edit_profile.php?msg=success1"); die;
}
  
if($_POST['update_club'])
{

	
	if($_POST['club_deactivate'] == "on")
	{
 		$deactivate = "1";
 	}
 	if(isset($_POST['sms-carrier']))
	{
		$smscarrier = $_POST['sms-carrier'];
	}
	else
	{
		$smscarrier = "";
	}
 	
				// echo "<pre>"; print_r($_POST); die;		
					/***************************imageupload*/
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
							
							
							 //indicate which file to resize (can be any type jpg/png/gif/etc...)
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
				  		$Obj->Redirect("home_club.php?msg=imagefail");
				  	}
				}
/***********/

						if($_POST['clubname'] ==""){ $clubname=""; } else { $clubname=trim($_POST['clubname']); };
						if($_POST['address'] ==""){ $club_address=""; } else { $club_address=trim($_POST['address']); };
						if($_POST['country'] ==""){ $country=""; } else { $country=trim($_POST['country']); };
						if($_POST['phone'] ==""){ $phone=""; } else { $phone=trim($_POST['phone']); };
						if($_POST['state'] ==""){ $state=""; } else { $state=trim($_POST['state']); };
						if($_POST['city'] ==""){ $city=""; } else { $city=trim($_POST['city']); };
						if($_POST['zipcode'] ==""){ $zipcode=""; } else { $zipcode=trim($_POST['zipcode']); };
						if($_POST['email'] ==""){ $email=""; } else { $email=trim($_POST['email']); };
						if($_POST['google_map_url'] ==""){ $google_map_url=""; } else { $google_map_url=trim($_POST['google_map_url']); };
						if($_POST['type_of_clubs'] ==""){ $type_club=""; } else { $type_club=trim($_POST['type_of_clubs']); };
						if($_POST['web_url'] ==""){ $web_url=""; } else { $web_url=trim($_POST['web_url']); };
						if($_POST['merchant_id'] ==""){ $merchant_id=""; } else { $merchant_id=trim($_POST['merchant_id']); };
						if($_POST['hideaddress'] ==""){ $hideaddress=""; } else { $hideaddress=trim($_POST['hideaddress']); };


						if($_POST['facebookLink'] =="")
						{
							$facebookLink=""; 
						} 
						else
						{
							$facebookLink=trim($_POST['facebookLink']); 
						}
						if($_POST['instaLink'] =="")
						{
							$instaLink=""; 
						} 
						else
						{
							$instaLink=trim($_POST['instaLink']); 
						}
						if($_POST['twitterLink'] =="")
						{
							$twitterLink=""; 
						} 
						else
						{
							$twitterLink=trim($_POST['twitterLink']); 
						}

						//if($_POST['auto_chat'] ==""){ $auto_chat=""; } else { $auto_chat=trim($_POST['auto_chat']); };
						if($_POST['subcat'] =="")
						{ 
							$subclubs=""; 
						}
						else
						{
							$subclubs=implode(',', $_POST['subcat']); 
						}
						$clubname = mysql_real_escape_string($clubname);
						if($_POST['hide_google_map'] == "on")
						{ 
							$hide_google_map= "1"; 
						}
						else
						{
							$hide_google_map= "0";
						}

						if($_POST['show_city_state_phone'] == "on")
						{ 
							$show_city_state_phone= "1"; 
						}
						else
						{
							$show_city_state_phone= "0";
						}



						if($_FILES["profile_image"]["name"]!="")
					  	{
							 $update_sql="update clubs SET sms_carrier = '$smscarrier',twitterLink='$twitterLink', facebookLink='$facebookLink', instaLink='$instaLink', hideaddress = '$hideaddress',type_details_of_club = '".$subclubs."' ,club_name='".$clubname."',club_country='".$country."',club_email='".$email."',club_city='".$city."',club_state='".$_POST['state']."',
							 zip_code='".$zipcode."',image_nm='".$forum_img."',merchant_id='".$merchant_id."',google_map_url='".$google_map_url."',club_contact_no='".$phone."',type_of_club ='".$type_club."',club_address='".$club_address."',web_url='".$web_url."', show_city_state_phone = '$show_city_state_phone', hide_google_map = '$hide_google_map'
							  where id='".$userID."'";
							  session_start(); $_SESSION['img'] = $forum_img; session_write_close();
						}
						else
						{
						  	$update_sql="update clubs set sms_carrier = '$smscarrier',twitterLink='$twitterLink', facebookLink='$facebookLink', instaLink='$instaLink',hideaddress = '$hideaddress',type_details_of_club = '".$subclubs."' ,club_name='".$clubname."',club_country='".$country."',club_email='".$email."',club_city='".$city."',club_state='".$_POST['state']."',zip_code='".$zipcode."',google_map_url='".$google_map_url."',club_contact_no='".$phone."',type_of_club ='".$type_club."',club_address='".$club_address."',merchant_id='".$merchant_id."',web_url='".$web_url."', show_city_state_phone = '$show_city_state_phone', hide_google_map = '$hide_google_map' where id='".$userID."'";
						}

					if(isset($_POST['new_pass']) && !empty($_POST['new_pass']))
					{
						$newPassword = $_POST['new_pass'];
						mysql_query("UPDATE `clubs` SET `password` = '$newPassword' WHERE `id` = '$_SESSION[user_id]' ");
					}
// echo $update_sql; die;

					  /*$_SESSION['usercity'] = $city ;*/
					 $update= mysql_query($update_sql);
					
					 $Obj->Redirect("edit_profile.php?msg=success1"); die;
  }
  /******************/


/* END UPDATE CODE */



// echo "<pre>"; print_r($_SESSION); echo "</pre>";
?>
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


 function ChkUserProfile(profilename,type)
{

	if(profilename!="")
	{
		
		ajaxFunction("ChkUserProfile.php?profilename="+profilename+"&type="+type, function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var s = xmlhttp.responseText;

				if(s==0)
				{
					alert("The Username is not available.Please choose another.");	
					if(type=='user')
					{
						document.update_user.pname.value="";
						document.update_user.pname.focus() ;
					}else{
						document.signupes.club_name.value="";
						document.signupes.club_name.focus() ;
					}
					return false;
				}

			}
		});
		
	}

}


function showStateuser(x)
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
			st = document.getElementById('userstate');
			st.length=0; 
			for(i=0;i<sid.length-1;i++)
			{
				st[i] = new Option(sval[i],sid[i]);
			}              
		}
	});
}

function getcity_user(x)
{
	$.get('getcity_sign.php?state_id='+x, function(data) 
	{
		$('#usercity').html(data);
	});
}


function getcity_host(x)
{
	$.get('getcity_sign.php?state_id='+x, function(data) 
	{
		$('#hostcity').html(data);
	});
}
jQuery(document).ready(function(){
	jQuery("#enableordiablephone").click(function(){
		if(jQuery("#enableordiablephone").is(':checked'))
		{
			$.ajax({
				type: "POST",
				url: "edit_profile.php",
				data: "enableordiablephoneID="+1,
				success: function(result){
				    	alert("Enabled Successfully");
				    	$('ul#sms-carriers').show();
				}
			});
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "edit_profile.php",
				data: "enableordiablephoneID="+0,
				success: function(result){
					alert("Disabled Successfully");
			    		$('ul#sms-carriers').hide();
				}
			});
		}	
	});
	jQuery("#enableordiablephone_club").click(function(){
		if(jQuery("#enableordiablephone_club").is(':checked'))
		{
			$.ajax({
				type: "POST",
				url: "edit_profile.php",
				data: "enableordiablephoneID="+1,
				success: function(result){
				    	alert("Enabled Successfully");
				    	$('ul#sms-carriers-clubs').show();
				}
			});
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "edit_profile.php",
				data: "enableordiablephoneID="+0,
				success: function(result){
					alert("Disabled Successfully");
			    		$('ul#sms-carriers-clubs').hide();
				}
			});
		}	
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

<!--/*******************************-->
<?PHP 

    FUNCTION DateSelector($useDate=0) 
    { 
			$months = array ('select','January', 'February', 'March', 'April', 'May', 'June','July', 'August', 'September', 'October', 'November', 
			
			'December');
			$days = range (1, 31);
			$years = range (1951, DATE("Y"));
			$userID=$_SESSION['user_id'];
			$sqldate=mysql_query("select DOB from user where id='".$userID."'") or die(mysql_error());
			$userArraydate = mysql_fetch_array($sqldate);
	 		$dob1= $userArraydate['DOB'];
			$date_array=explode("-",$dob1);

			$dobday =INTVAL($date_array[2]);
			$dobYear=INTVAL($date_array[0]);
			$dobMonth=INTVAL($date_array[1]);
			
			echo "<div class='styled-select'><select name='date'>";
			foreach ($days as $value) {

				if($value==$dobday){
					 $default = 'selected="selected"'; 
					echo '<option '.$default.' value="'.$value.'">'.$value.'</option>\n';
				}
				else{
					echo '<option value="'.$value.'">'.$value.'</option>\n';
				}
			}
			 echo '</select></div> &nbsp; ';
			
				echo "<div class='styled-select'><select name='month'>";
	            for ($month = 0; $month <= 12; $month++) 
				{
					if($month==$dobMonth){ $default = 'selected="selected"';
	               echo ' <option '.$default.' value="' . $month . '">' . $months[$month] . '</option>'."\n";
           			 }
					 else{
					echo '<option value="'.$month.'">'.$months[$month].'</option>\n';
					}
				}
			echo '</select> </div>&nbsp; ';
			
			
			echo "<div class='styled-select'><select name='year'>";
			foreach ($years as $value) {
				if($value == $dobYear){ $default = 'selected="selected"';
				echo '<option '.$default.' value="'.$value.'">'.$value.'</option>\n';
			}
			else{
					echo '<option value="'.$value.'">'.$value.'</option>\n';
				}
			}  
			echo '</select></div> &nbsp; ';
    
    } 


	
		$userType= $_SESSION['user_type'];
		$qry="select * from clubs where id=".$_SESSION['user_id'];
		$res=mysql_query($qry) or die("SQL club pass error");
		$club_row = mysql_fetch_assoc($res);
		$qry="select count(*) as total_row from hostsubusers where username='".mysql_real_escape_string($club_row['club_name'])."'";
		$res=mysql_query($qry) or die("check sub host");
		$sub_row = mysql_fetch_assoc($res);

	
 	?>

<?php 
	if(isset($_GET['action']) && $_GET['action'] == 'AddMerchantID')
	{
		?>
			<style type="text/css">
				@-webkit-keyframes blinkingBorder {
					0% {
						border-color: #ff0000;
					}

					50% {
						border-color: #ff0000;
					}

					100% {
						border-color: #ff0000;
					}
				}
				@keyframes blinkingBorder {
					0% {
						border-color: #ff0000;
					}

					50% {
						border-color: #ff0000;
					}

					100% {
						border-color: #ff0000;
					}
				}
				@keyframes blink { 50% { border-color: #ff0000; }  }
				.merchantID
				{
					animation: blink .6s step-end infinite alternate;
					/*border: 8px dashed #fecd07 ;*/
/*					-webkit-animation-direction: normal;
					-webkit-animation-duration: 0.5s;
					-webkit-animation-iteration-count: infinite;
					-webkit-animation-name: blinkingBorder;
					-webkit-animation-timing-function: ease;
					animation-direction: normal;
					animation-duration: 5s;
					animation-iteration-count: infinite;
					animation-name: blinkingBorder;*/
					animation-timing-function: ease
				}
			</style>

		<?php
	}
?>


<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 
		if($_SESSION['user_type']=='user')
	 	{
			include('friend-right-panel.php');           		
		}
		else
		{ 
			include('club-right-panel.php');
		}
	?>
	
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
         
					 	<h3 id="title">Edit Profile</h3>
					 <?php 
					 	/*if($_SESSION['user_type'] == 'club')
					 	{
					 		$getInfo = mysql_query("SELECT `profileType` FROM `clubs` WHERE `id` = '$_SESSION[user_id]' ");
					 		$fetchInfo = mysql_fetch_assoc($getInfo);
					 ?>
            					<div class="editType">
            						<ul> 
            							<li><input type="radio" <?php if($fetchInfo['profileType'] == 'Private'){ echo 'checked';}?> class="profileSecurity" id="PrivateProfile" vlaue="private" /> Private - Only Friends/Fans can view</li>
              							<li><input type="radio" <?php if($fetchInfo['profileType'] == 'Public'){ echo 'checked';}?> class="profileSecurity" id="PublicProfile" value="public" /> Public - All users can view</li>
            						</ul>
            					</div>
            				<?php 	} */	?>
				      		<?php 
				      			if(isset($_GET['msg']))
				      			{ 
								if($_GET['msg'] == "success")
								{
									echo '<div id="successmessage" class="message" >'.$message."</div>";
								}
								else
								{
									echo '<div id="successmessage" class="message" >'.$_GET['msg']."</div>";
								}
							}
							if(isset($_SESSION['brodcasting_passowrd_update'])){
								
								echo '<div id="successmessage" class="message" >'.$_SESSION['brodcasting_passowrd_update']."</div>";
								unset($_SESSION['brodcasting_passowrd_update']);
								
							}
							if(!isset($_SESSION['user_club'])) 
							{
								$plantype = $loggedin_user_data['plantype'];
								$profilename=$loggedin_user_data['profilename'];
								$first_name=$loggedin_user_data['first_name']; 
								$user_address=$loggedin_user_data['user_address']; 
								$last_name=$loggedin_user_data['last_name'];
								$fullname = $first_name." ".$last_name;
								$zipcode=$loggedin_user_data['zipcode'];
								$state=$loggedin_user_data['state'];
								$country=$loggedin_user_data['country'];
								if($loggedin_user_data['DOB']==''){$dob="00/00/0000";} else $dob=$loggedin_user_data['DOB'];
								$city=$loggedin_user_data['city'];
								$email=$loggedin_user_data['email'];
								$image_nm=$loggedin_user_data['image_nm'];
								$phone=$loggedin_user_data['phone'];
								$enablediablephone=$loggedin_user_data['text_status'];
								$SMSCARRIER=$loggedin_user_data['sms_carrier'];
								$_SESSION['img']=$image_nm;
								$_SESSION['usercity'] = $city ;
								$_SESSION['username'] = $loggedin_user_data['first_name']."-".$loggedin_user_data['last_name'];
								$_SESSION['profile_name'] = $loggedin_user_data['profilename'];

								$_SESSION['user_type'] = 'user';  
						?>
						      		<form name="update_user" id="signup_1" method="post" enctype="multipart/form-data" class="user-edit-form">
                       <div class="block_Divider">
						        			<div class="edit_profile_f">
						         				<div id="profile_box">	<h3> Profile Image:</h3> 
						         					<ul>
											
												<li>
													<input type="file" name="profile_image" id="selectedFile" style="color: #fff;" onchange="return ValidateFileUpload()"/>
													(Allowed exts's gif, png, jpg & jpeg)
												</li>
											</ul>
              										<ul>
              											<input type="checkbox" <?php if($fetchaddress['hideaddress'] == '1'){ echo "checked"; } ?> name="hideuseraddress" value="1">Hide Address
              											
                      										</ul>
                    
                       <div class="clear"></div>
          <h3> Profile Information</h3>
          <div class="clear"></div>
											<ul>
												 
                        <li>Profile Name: </li>
												<li>
													<input name="pname" type="text" onchange="return ChkUserProfile(this.value,'user');" value="<?php echo ucfirst($profilename); ?>" />
												</li>
											</ul>
											<ul>
												<li>First Name <!--/ Company Name-->:</li>
												<li>
													<input name="fname" type="text" value="<?php echo ucfirst($first_name); ?>" />
												</li>
											</ul>
											<ul>
												<li>Last Name:</li>
												<li>
													<input name="lname" type="text" value="<? echo ucfirst($last_name); ?>" />
												</li>
											</ul>
											<ul>
												<li>Email:</li>
												<li>
													<input name="email" readonly="readonly" type="text" value="<? echo $email; ?>" />
												</li>
											</ul>	            
											<ul>
												<li>Phone:</li>
												<li>
													<input id="ContactNumber" name="phone"  type="text" value="<? echo $phone; ?>"  placeholder="###-###-####"  />
													<span style="color:white;" class="font12">
														<input type="checkbox" <?php if($enablediablephone){ echo "checked";} ?> name="enableordiablephone" id="enableordiablephone" placeholder="##-####-####">
														Want to receive text message on cell phone.
													</span> 
												</li>
											</ul>
											<ul id="sms-carriers" <?php if($enablediablephone){ ?>style="display:block;" <?php }else{ ?> style="display:none;" <?php } ?>>
						              					<li>Select Your SMS Carrier:</li>
						              					<li>
													<select name="sms-carrier">
														<option value="">Select</option>
													<?php 
														$getsmscarriers = mysql_query("SELECT * FROM `sms_carriers` ORDER BY `carrier_name` ASC ");
														while($sms = mysql_fetch_array($getsmscarriers))
														{
													?>
															<option <?php if($SMSCARRIER == $sms['id']){echo "selected" ;}?> value="<?php echo $sms[id] ?>"><?php echo $sms['carrier_name']; ?></option>
													<?php
														}
													?>
													</select>
						                						<span style="color:white; display:none;" class="font12"> Send a message from your phone to your e-mail and you will get the phonenumber@carrier.ext needed for this to work.</span> 
						                					</li>
					            						</ul>
											<ul class="date_select">
												<li>Date of Birth:</li>
												<li>
													<?PHP DateSelector(); ?>
												</li>
											</ul>
						            				<?php
											$about_query = mysql_query("SELECT hear_about FROM user WHERE id= '$userID'");
											$res = mysql_fetch_assoc($about_query);
										?>
                    <div class="clear"></div>
											<ul>
												<li>Where you hear about us ? :</li>
												<li>
													<div id="sources" class="styled-select">
														<select id="source_name" name="hear_about">
															<option <?php if($res['hear_about'] == "Facebook"){ echo "selected"; } ?>  value="Facebook">Facebook</option>
															<option <?php if($res['hear_about'] == "Sirius Radio"){ echo "selected"; } ?> value="Sirius Radio">Sirius Radio</option>
															<option <?php if($res['hear_about'] == "YouTube"){ echo "selected"; } ?> value="YouTube">YouTube</option>
															<option <?php if($res['hear_about'] == "iHeart Radio"){ echo "selected"; } ?> value="iHeart Radio">iHeart Radio</option>
															<option <?php if($res['hear_about'] == "Friends"){ echo "selected"; } ?> value="Friends">Friends</option>
															<option <?php if($res['hear_about'] == "other"){ echo "selected"; } ?> value="other">Other</option>
														</select>
													</div>
												</li>
											</ul>
						            					<ul>
										              <?php 
											 	$countrysql="select country_id,name from country where country_id IN ('223','38') ";
											 	$country_list = mysql_query($countrysql);
												 
										 	?>
						              					<li>Country:</li>
					              						<li>
						                						<div class='styled-select'>
						                  							<select name="country" id="country" onChange="showStateuser(this.value);">
						                    								<option value="">- - Select - -</option>
						                   						 <?php 
											          			$country_nm_qry = mysql_query("SELECT `name` FROM `country` WHERE `country_id` = ".$row['country']." ORDER BY `name` ASC");
													 	$country_nm = mysql_fetch_array($country_nm_qry);
													  	$state_nm_qry = mysql_query("SELECT `name` FROM `zone` WHERE `zone_id` = ".$row['state']." ORDER BY `name` ASC");
													  	$state_nm = mysql_fetch_array($state_nm_qry);
														while($row = mysql_fetch_array($country_list))
														{
										  		?>
						                    								<option value="<?php echo $row["country_id"]; ?>" <?php if($row["country_id"]==$country) { echo "Selected"; } ?>><?php echo $row["name"]; ?></option>
						                   				<?php 			}  	?>
						                  							</select>
											                	</div>
											             </li>
						            					</ul>
						            					<ul>
						              					<li>State: </li>
						              				<?	$statesql=@mysql_query("select name,zone_id from zone where country_id ='".$country."'"); ?>
						              					<li>
											                	<div class='styled-select'>
												                  	<select name="state" id="userstate" onChange="getcity_user(this.value);">
												                    		<option   value= "">- - Select - -</option>
												                    	<?php	while($row_s = @mysql_fetch_array($statesql))
															{
													 	?>
												                    			<option value="<?php echo $row_s["zone_id"]; ?>"  <?php if($row_s["zone_id"]==$state) { echo "Selected"; } ?>><?php echo $row_s["name"]; ?></option>
												                    <?php   	}  ?>
												                  	</select>
											                	</div>
						              					</li>
						            					</ul>
						            					<ul>
						              					<li class="txt">City</li>
						              					<li>
											                	<div class='styled-select'>
											                  		<select name="city" id="usercity" >
											                    			<option value="">- -Select- -</option>
											                    <?php 
														$allcity="select city_name,city_id from capital_city"; 
													 	$city_list1 = @mysql_query($allcity);
													 	while($row_city = @mysql_fetch_array($city_list1))
														{
													?>
											                    			<option value="<?php echo $row_city["city_id"]; ?>" <?php if($_SESSION['usercity']==$row_city["city_id"]) { ?> selected="selected" <?php } ?>><?php echo $row_city["city_name"]; ?></option>
											                    <?php 	}	   ?>
											                  		</select>
											                	</div>
						              					</li>
						            					</ul>
						            					<ul>
						              					<li>Street:</li>
												<li>
													<input name="user_address" type="text" value="<? echo $user_address; ?>" />
												</li>
											</ul>
											<ul>
												<li>Zipcode:</li>
												<li>
													<input name="zipcode" type="text" value="<? echo $zipcode; ?>" />
												</li>
											</ul>
											
											<h3>Reset Password </h3>
						           <ul style="height: auto !important;">
										  
												<li>New Password</li>
												<li>
													<input name="user_new_pass" id="user_new_pass" type="password" value="" placeholder="Enter password" />
												</li>
													<span class="clear"></span>
													<br />
												<li>Confirm Password</li>
												<li>
													<input name="user_conf_pass" type="password" value="" placeholder="Confirm password" />
												</li>
										          </ul>
										          <ul>
												<li>&nbsp; </li>
												<li>
													<input onclick="deactivate_confirm_user();" id="deactivateAccountuser1" name="deactivate" type="checkbox"  />
													Deactivate Your Account 
												</li>
											</ul>
										            <script type="text/javascript">
											          	function deactivate_confirm_user()
											         	{
											         		if($('#deactivateAccountuser1').is(':checked'))
											         		{
											         			if(confirm('Are you sure you want to Deactivate your Account?'))
											         			{
											         				$.ajax({
																	type: "POST",
																	url: "refreshajax.php",
																	data: {
																	'action' : 'destroySession',
																	'userid' : '<?php echo $_SESSION["user_id"]; ?>',
																	'usertype' : '<?php echo $_SESSION["user_type"]; ?>',
																},
																success: function(data){
																	alert('Your Account is Successfully Deactivated!');
																	window.location.href = 'index.php';
																}
															});
											         			}
											         			else
											         			{
											         				$('#deactivateAccountuser1').removeAttr('checked');
											         			}
											         		}
											         	}
											</script><div class="clear"></div>
						            					<div id="save">
						              					<input name="update" type="submit" value="Save" />
						            					</div>
						          				</div>
						        			</div>
                          </div>
						      		</form>
						      	<?php 	}  
						 		else  
						 		{
						 			
									$pieces = explode(" ", $loggedin_host_data['club_name']);
									$username_dash_separated1 = implode("-", $pieces);
									$username_dash_separated1 =clean($username_dash_separated1);
									$User = "Club";
									//$_SESSION['user_id'] = $_COOKIE['loggedinuserID'] ;
									$_SESSION['user_club'] = $User ;
									$_SESSION['user_type'] = 'club';
									$_SESSION['username'] = $username_dash_separated1 ;
									if(isset($_SESSION['subuser']))
									{
										$q1 = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$loggedin_host_data['club_name']."'  ");
										$f1 = @mysql_fetch_array($q1);

										$_SESSION['img'] =  $f1['user_thumb'] ;
										
									}
									else
									{
										$_SESSION['img'] =  $loggedin_host_data['image_nm'] ;
									}

									$profilename=$loggedin_host_data['club_name'];
									$plantype = $loggedin_host_data['plantype'];
									$typeclub = $loggedin_host_data['type_of_club'];
									$email=$loggedin_host_data['club_email'];
									$club_address=$loggedin_host_data['club_address'];
									$phone=$loggedin_host_data['club_contact_no']; 
									$country=$loggedin_host_data['club_country'];
									$state=$loggedin_host_data['club_state'];
									$club_city=$loggedin_host_data['club_city'];
									$web_url=$loggedin_host_data['web_url'];
									$zipcode=$loggedin_host_data['zip_code'];
									$google_map_url=$loggedin_host_data['google_map_url'];	
									$image_nm  =$loggedin_host_data['image_nm'];
									$_SESSION['username']=$profilename;
									$_SESSION['img']=$image_nm;
									$enablediablephone=$loggedin_host_data['text_status'];
 						 			$getaddress = mysql_query("SELECT `hideaddress` FROM `clubs` WHERE `id` = '".$_SESSION['user_id']."' ");
						 			$fetchaddress  = mysql_fetch_array($getaddress);
						 			$hide_google_map = $loggedin_host_data['hide_google_map'];
						 			$show_city_state_phone = $loggedin_host_data['show_city_state_phone'];
						 			$SMSCARRIER=$loggedin_host_data['sms_carrier']; 
						 			$type_details_of_club = $loggedin_host_data['type_details_of_club'];
				 			?>
						      		<form name="update_user1" method="post" id="signup_2"  enctype="multipart/form-data">
									<div class="profileright edit_profile_f">
										<div id="profile_box">
											<ul class="lField">
												<li>Hide Google Map:
													<input name="hide_google_map" type="checkbox" <?php if($hide_google_map == '1'){ echo 'checked';} ?> />
												</li>
												<li>&nbsp;</li>
											</ul>
											<ul class="rField">
												<li>Show City, State And Phone Only:
													<input name="show_city_state_phone" type="checkbox"<?php if($show_city_state_phone == '1'){ echo 'checked';}  ?> />
												</li>
												<li>&nbsp;</li>
											</ul>
           <div class="block_Divider"> 
            <div class="left-half">
           <h3>Profile Image</h3>
           <div class="rFields">
            <ul class="rField">
												<li>Profile Image:</li>
												<li>
													<a onclick="mycropFunction()" href="javascript:void(0);"><input type="button" name="profile_image" id="selectedFile" style="color: #fff;" value="Browse..." onchange="return ValidateFileUpload()"/></a>
													(Allowed exts's gif, png, jpg & jpeg)
												</li>
											</ul>
					</div>
          </div>
          <script type="text/javascript">
          function mycropFunction() {
	          	var left  = ($(window).width()/2)-(900/2),
			    top   = ($(window).height()/2)-(600/2),
			    popup = window.open ("imgpreview.php", "popup", "width=900, height=600, top="+top+", left="+left);
			}
          </script>
          
          <div class="right-half">
                      <div class="merchantID">
           <ul>
           <li>Enter Merchant Id:</li>
												<li>
													<input name="merchant_id" id="merchant_id" type="text" value="<?php echo  $club_row['merchant_id']; ?>" placeholder="Merchant Id"   />
             
												</li>
            <li style="text-align:right">
             <a href="https://www.paypal.com/webapps/mpp/merchant">How to create Paypal Merchant ID </a>
            </li>
											</ul>
           </div>
           </div>
           <!-- profile image here  -->
           <?php
           		if($_SESSION['user_type'] == 'club')
           		{

					$host_query = mysql_query("SELECT image_nm FROM clubs WHERE id = '".$_SESSION['user_id']."'");

					$loggedin_host_data = mysql_fetch_assoc($host_query);

					$userID = $_SESSION['user_id'];
					$displayImage = $loggedin_host_data['image_nm'];
				}
           ?>
           <img src="<?php echo $SiteURL.$displayImage; ?>">
           <!-- profile image  -->
           <h3>Profile Information</h3>
											<ul class="lField">
												<li>Name of HOST:</li>
												<li>
													<input readonly name="clubname" type="text" id="name_club" onchange="return RestrictSpaceSpecial(this.value);" value="<?php echo ucfirst($club_name); ?>" />
												</li>
											</ul>
											<ul class="rField">
												<li>Email:</li>
												<li>
													<input name="email" readonly="readonly" type="text" value="<? echo $email; ?>" />
												</li>
											</ul>
											<ul class="lField">
												<li>HOST Contact No:</li>
												<li>
													<input id="ContactNumber" name="phone"  type="text" value="<? echo $phone; ?>" placeholder="###-###-####" />
													<span style="color:white;" class="font12">
														<input type="checkbox" <?php if($enablediablephone){ echo "checked";} ?> name="enableordiablephone" id="enableordiablephone_club">
														Want to receive text message on cell phone.
													</span>
												</li>
											</ul>
											<ul id="sms-carriers-clubs" <?php if($enablediablephone){ ?>style="display:block;" <?php }else{ ?> style="display:none;" <?php } ?>>
						              					<li>Select Your SMS Carrier:</li>
						              					<li>
													<select name="sms-carrier">
														<option value="">Select</option>
													<?php 
														$getsmscarriers = mysql_query("SELECT * FROM `sms_carriers` ORDER BY `carrier_name` ASC ");
														while($sms = mysql_fetch_array($getsmscarriers))
														{
													?>
															<option <?php if($SMSCARRIER == $sms['id']){echo "selected" ;}?> value="<?php echo $sms[id] ?>"><?php echo $sms['carrier_name']; ?></option>
													<?php
														}
													?>
													</select>
						                						<span style="color:white;" class="font12"> Send a message from your phone to your e-mail and you will get the phonenumber@carrier.ext needed for this to work.</span> 
						                					</li>
					            						</ul>
											<ul class="rField">
												<li>HOST Address: <span style="margin-left: 40px;">Hide Address
													<input type="checkbox" <?php if($fetchaddress['hideaddress'] == '1'){ echo "checked"; } ?> name="hideaddress" value="1">
													</span> 
												</li>
												<li>
													<input name="address" type="text" value="<?php echo ucfirst($club_address); ?>" />
												</li>
											</ul>
           <div class="clear"></div>
											<ul class="lField">
										<?php 
										$countrysql="select country_id,name from country where country_id IN ('223','38') ";
										$country_list = mysql_query($countrysql);
										?>
												<li>Country:</li>
												<li>
													<select name="country" id="country" onChange="showStatehost(this.value);">
														<option value="">- - Select - -</option>
													<?php 
													$country_nm_qry = mysql_query("SELECT `name` FROM `country` WHERE `country_id` = '".$country."' ORDER BY `name` ASC");
													$country_nm = mysql_fetch_array($country_nm_qry);
													$state_nm_qry = mysql_query("SELECT `name` FROM `zone` WHERE `zone_id` = '".$state."' ORDER BY `name` ASC");
													$state_nm = mysql_fetch_array($state_nm_qry);
													while($row = mysql_fetch_array($country_list))
													{
												?>
														<option  value="<?php echo $row["country_id"]; ?>" <?php if($row["country_id"]== $country) {?> selected='selected'<?php } ?>><?php echo $row["name"]; ?></option>
												<?php	}	?>
													</select>
												</li>
											</ul>
											<ul class="rField">
												<li>State: </li>
												<?	$statesql=mysql_query("select name,zone_id from zone where country_id ='".$country."'");?>
												<li>
													<select name="state" id="hoststate" onChange="getcity_host(this.value);">
														<option   value= "">- - Select - -</option>
													<?php	
														while($row_s = mysql_fetch_array($statesql))
														{
													?>
															<option value="<?php echo $row_s["zone_id"]; ?>" <?php if($row_s["zone_id"]==$state) { echo "Selected"; } ?>><?php echo $row_s["name"]; ?></option>
													<?php	}	?>
													</select>
												</li>
											</ul>
											<ul class="lField">
												<li class="txt">City</li>
												<li>
													<select name="city" id="hostcity" >
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
											<ul class="rField">
												<li>Street:</li>
												<li>
													<input name="user_address" type="text" value="<?php echo $club_address; ?>" />
												</li>
											</ul>
           <div class="clear"></div>
											<ul class="lField">
												<li>Zipcode:</li>
												<li>
													<input id="zipcode"  name="zipcode" type="text" value="<?php echo $zipcode; ?>" />
												</li>
          
											</ul>
										  <ul class="rField">
												<li>Membership Type:</li>
												<li>
													<input type="text" name="membership_type" id="membership_type" value="<?php echo $plantype; ?>" readonly />
												</li>
											</ul>
											<ul class="rField">
												<li>Enter Clubs Google Map URL:</li>
												<li>
													<textarea  required="" name="google_map_url" >
												<?php 
												if($google_map_url == "")
												{
													echo '<iframe src="http://maps.google.com/?q='.$userArray[0]['latitude'].','.$userArray[0]['longitude'].' scrolling=yes frameborder=0"></iframe>';
												}
												else
												{
													echo $google_map_url;		
												}
												?>
													</textarea>
												</li>
											</ul>
										
       
           </div>
     <div class="block_Divider">
           <h3>Social Information</h3>
											<ul class="rField">
												<li>Host Website Url:</li>
												<li>
													<input type="text" name="web_url" id="web_url" value="<?php echo $web_url; ?>"  />
												</li>
											</ul>
											<ul class="rField">
												<li>Host Facebook Url:</li>
												<li>
													<span class="formw" style="width:100%;">
														<input  value="<?php if(!empty($loggedin_host_data['facebookLink'])){ echo $loggedin_host_data['facebookLink']; }?>"  id="your-facebook-address" type="text"  name="facebookLink" value="" placeholder="http://facebook.com/" />
													</span>
												</li>
											</ul>
											<ul class="rField">
												<li>Host Instagram Url:</li>
												<li>
													<span class="formw" style="width:100%;">
														<input  value="<?php if(!empty($loggedin_host_data['instaLink'])){ echo $loggedin_host_data['instaLink']; }?>"  id="your-instagram-address" type="text"  name="instaLink" value="" placeholder="http://instagram.com/" />
													</span>
												</li>
											</ul>
											<ul class="rField">
												<li>Host Twitter Url:</li>
												<li>
													<span class="formw" style="width:100%;">
														<input  value="<?php if(!empty($loggedin_host_data['twitterLink'])){ echo $loggedin_host_data['twitterLink']; }?>"  id="your-twitter-address" type="text"  name="twitterLink" value="" placeholder="http://twitter.com/" />
													</span>
												</li>
											</ul>
											
									</div>
        <div class="block_Divider host_block">
           <h3>Host Information</h3>  
       		  <ul class="lField">
												<li>HOST Type:</li>
												<li>
											<?php  
												$type_details_of_club = explode(',',$type_details_of_club);
												$type_details_of_club_array = explode(',',$loggedin_host_data['type_details_of_club']);
												$cnd=" parrent_id='0'";
												$sql_main_club=mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC"); 
												while($clubs=@mysql_fetch_assoc($sql_main_club)) 
												{ 
											?>
													<ul class="select_profile_edit sub1" id="mainUL_<?php echo $clubs['id'];?>">
														<li style="float:left; width:100%;">
															<input style="width: auto !important;" <?php if($type_of_club == $clubs['id']){ echo "checked = 'checked' ";} ?> type="radio" name="type_of_clubs" value="<?php echo $clubs['id'];?>"  />  <?php  echo $clubs['name'];  ?>  
											<?php 
														$cnd=" parrent_id='0'";
														$sql_sub_cat=mysql_query("select * from club_category where parrent_id='".$clubs['id']."' ORDER BY name ASC"); 
														$countro = mysql_num_rows($sql_sub_cat);
														if($countro > 0)
														{
											?>
															<ul  style="margin-left:20px;display:none;" id="club_<?php echo $clubs['id'];?>" class="details12 edit_deatis">
																<?php 
																while($clubs_sub=@mysql_fetch_assoc($sql_sub_cat)) 
																{ 
																	//echo "select * from club_category where parrent_id='".$clubs_sub['id']."' ORDER BY name ASC"."</br>";
											?>
																	<li style="float:left; width:100%;">
											<?php 
																		
																		$sql_sub_cat1=mysql_query("select * from club_category where parrent_id='".$clubs_sub['id']."' ORDER BY name ASC"); 
																		if(mysql_num_rows($sql_sub_cat1) > 0)
																		{ //die;
											?>								<input class="" <?php if(in_array($clubs_sub['name'], $type_details_of_club)){ echo "checked" ; } ?> onclick="showInnerSub('<?php echo $clubs_sub["id"];?>');" style="width: auto !important;" type="radio" name="subcat[]" value="<?php echo $clubs_sub['name']; ?>" /><?php echo $clubs_sub['name']; ?>
																			<ul style="margin-left:20px;display:none;" class="details12 innserSUBS edit_deatis" id="innersub_<?php echo $clubs_sub['id'];?>">
																			<?php 
																				while($st = mysql_fetch_assoc($sql_sub_cat1))
																				{
																					// if(in_array($st['name'], $type_details_of_club_array))
																				 // 	{
																					// 	echo $st['name']; "<br /><pre>"; print_r($type_details_of_club_array); echo "</pre>";
																					// }
																			?>
																					<li style="float:left; width:100%;">
																						<input <?php if(in_array($st['name'], $type_details_of_club_array)){ echo "checked" ; } ?> style="width: auto !important;" type="checkbox" name="subcat[]" value="<?php echo $st['name']; ?>" /><?php echo $st['name']; ?><br />
																					</li>
															<?php 					}	?>
																			</ul>
											<?php							}
																		else
																		{
											?>								<input <?php if(in_array($clubs_sub['name'], $type_details_of_club_array)){ echo "checked" ; } ?> style="width: auto !important;" type="checkbox" name="subcat[]" value="<?php echo $clubs_sub['name']; ?>" /><?php echo $clubs_sub['name']; ?>
											<?php							}
											?>
																		
																	</li>
											<?php 
																} 
											?>
															</ul>
												<?php } ?>
														</li>
													</ul>
									<?php 			} 	?>
												</li>
											</ul>
           </div>
           <script type="text/javascript">
           	$(document).on('click',function (e) {
			  footerUl = $('#profile_box li');
			  
			  if (!footerUl.is(e.target) 
			      && footerUl.has(e.target).length === 0){
			    footerUl.children('ul.edit_deatis').hide();
			  }
			});
           </script>
        <div class="block_Divider">
           
           
     <div class="block_Divider"> 
     <h3>Reset Password</h3>
											<ul class="reset_your_pass">
												<li> 
												</li>
												<li>New Password</li>
												<li>
													<input name="new_pass" id="club_new_pass" type="password" value="" placeholder="Enter password" />
												</li>
												<span class="clear"></span>
												<br />
												<li>Confirm Password</li>
												<li>
													<input name="club_conf_pass" type="password" value="" placeholder="Confirm password" />
												</li>

											</ul>
                      <div class="rFields deact">					
             <ul class="rField">
											 
												<li>
													<input onclick="deactivate_confirm();" id="deactivateAccount" type="checkbox" name="club_deactivate" />Deactivate Your Account 
												</li>
											<?php 
													$getPrimaryCat = mysql_query("SELECT `type_of_club` FROM `clubs` WHERE `id` = '$_SESSION[user_id]'  ");
													$fetchPrimaryCat  = mysql_fetch_array($getPrimaryCat);
											?>
													<SCRIPT language=Javascript>
													<!--
													function isNumberKey(evt)
													{
														var charCode = (evt.which) ? evt.which : evt.keyCode;
														if (charCode != 46 && charCode > 31 
														&& (charCode < 48 || charCode > 57))
														return false;

														return true;
													}
													//-->
													</SCRIPT>
											</ul>
           </div>
            </div>  
           
           </div>
											<script type="text/javascript">
												function deactivate_confirm()
												{
													if($('#deactivateAccount').is(':checked'))
													{
														if(confirm('Are you sure you want to Deactivate your Account?'))
														{
															$.ajax({
																type: "POST",
																url: "refreshajax.php",
																data: {
																	'action' : 'destroySession',
																	'userid' : '<?php echo $_SESSION["user_id"]; ?>',
																	'usertype' : '<?php echo $_SESSION["user_type"]; ?>',
																},
																success: function(data){
																	alert('Your Account is Successfully Deactivated!');
																	window.location.href = 'index.php';
																}
															});
														}
														else
														{
															$('#deactivateAccount').removeAttr('checked');
														}
													}
												}
											</script> 
                      
                      
                      
            <div class="clear"></div>
											<div id="submit_btn" style="width: auto;">
												<input name="update_club" class="button btn_add_venu" type="submit" value="Save" />
            
            	<input name="cancel_update" class="button btn_add_venu" type="submit" value="Cancel" />
											</div>
										</div>
									</div>
								</form>
						      <?php } ?>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">
function RestrictSpaceSpecial(val) {
	$.post('ajaxcall.php', {'h_name':val}, function(response){
		if (response == "false") {
			alert("Please choose another host name");
			$('#name_club').val("");
			$('#name_club').focus();
		}
	});
	return false;
	var k;
	document.all ? k = e.keyCode : k = e.which;
	return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}
function showInnerSub(id)
{
	$('.innserSUBS').each(function(){
		$(this).hide();
		var ID = $(this).attr('id');
		// $('#'+ID+' li').each(function(){
		// 	$(this).find('input').removeAttr('checked');
		// });
	});
	$('ul#innersub_'+id).show();
}

$("input:radio[name=type_of_clubs]").click(function() {
	
	$("#testmycat").val('');
    var value = $(this).val();
    $("#type_of_clubs_val").val(value);
	var ID = 'club_'+value;
    $('.details12').stop().slideUp('slow');
  	$('#club_'+value).stop().slideToggle('slow');
  	$(".select_profile_edit").each(function(){
  		var IDD = $(this).find('ul').attr('id');
  		ID = IDD.split('_');
  		if(ID[1] ==  value)
  		{
  			//alert('TRUE');
  		}
  		else
  		{
  			$('#club_'+ID[1]).find('input').prop('checked',false);
  		}
  		
  	});
 	// $('#club_'+value).find('input').prop('checked',false);

		  
});
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode != 46 && charCode > 31  && (charCode < 48 || charCode > 57))
	   	return false;
	return true;
}

$(document).ready(function(){
	
	if ($.trim($('#club_new_pass').val()).length != 0 && $.trim($('#club_new_pass').val()).length == 0) {
		//alert("Please confirm password");
		return false;
	}
	if ($.trim($('#club_new_pass').val()).length == 0 && $.trim($('#club_new_pass').val()).length != 0) {
		//alert("Please enter new password");
		return false;
	}	
});
</script>
<style type="text/css">
.rField span.formw input#your-website-address 
{
	background: #fff url("/img/icon7.png") no-repeat scroll 10px center;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	padding-left: 45px !important;
	background-size:20px;
}
.rField span.formw input#your-facebook-address
{
	background: #fff url("/img/icon6.png")  no-repeat scroll 10px center;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;background-size:20px;
	padding-left: 45px !important;
}
.rField span.formw input#your-twitter-address {
	background: #fff url("/img/icon5.png") no-repeat scroll 10px center;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;background-size:20px;
	padding-left: 45px !important;
}
.rField span.formw input#your-instagram-address {
	background: #fff url("/img/icon8.png") no-repeat scroll 10px center;
	box-sizing: border-box;background-size:20px;
	-webkit-box-sizing: border-box;
	padding-left: 45px !important;
}
.rField span.formw input#your-soundcloud-address {
	background: #fff url("/img/icon3.png") no-repeat scroll 10px center;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;background-size:20px;
	padding-left: 45px !important;
}
/*.select_profile_edit li .details12.edit_deatis {
  background: #111 none repeat scroll 0 0;
  border: 1px solid #fecd07;
  float: left;
  height: auto !important;
  margin: -12px 0 0 130px !important;
  min-height: 20px;
  min-width: 20%;
  overflow: visible !important;
  padding: 5px;
  position: absolute;
  width:  200px !important;
  max-height: 200px !important;
  overflow-y: auto !important;
}*/
</style>
<?php include('Footer.php'); ?>