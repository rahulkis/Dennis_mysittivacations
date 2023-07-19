<?php
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
  $Obj->Redirect("login.php");
}
$titleofpage = " Import List";
?>
<script type="text/javascript">
function isLogin() {
  if (confirm("To view profile Please login. ")) {
   document.location = "login.php";
  }
}
 function requestBlock(id)
 {
   $.get('request-block.php?f_id='+id, function(data) {
$('#request_'+id).html(data);
});
 }

function chatsetting(action,id,f_id)
{
	
	//Use jQuery's ajax function to send it
	$.ajax({
		type: "POST",
		url: "chatsetting.php",
		data: {
			'action' : action,
			'id' : id,
			'f_id' : f_id
		},
		success: function(data){
		  if((action == 'disableall') || (action == 'enableall') )
		  {
			  //('span.disableall').html(data);
			  location.reload(true);
		  }
		  else
		  {
			  $('#enablechat_'+f_id).html(data);    
		  }
		

		}
	});
	
	//We return false so when the button is clicked, it doesn't follow the action
	return false;
}


</script>

<style>
.login table{
border-collapse:collapse;
text-align:left;
border:1px solid blue;
}
.login table tr td{
border:1px solid blue;
}

#title > span.disableall {
	float: right;
	font-size: 13px;
	width: auto;
}
</style>
<?php 

if($_SESSION['user_id']!="" )
{

 //  $sql4="select distinct(f.friend_id),u.first_name,u.last_name,cc.city_name,z.name as state ,z.code,c.name as country,f.id as f_id,f.chat  from  friends as f 
 //  left join user as u on(f.friend_id=u.id)
 // left join capital_city as cc on(cc.city_id=u.city)
 // left join  zone as z on(cc.state_id=z.zone_id)
 // left join country as c on(c.country_id=z.country_id)
 // where f.status='active' AND  f.friend_type='user'  AND f.user_id='".$_SESSION['user_id']."'";
$sql4="select distinct(fs.friend_id),u.first_name,u.image_nm,u.last_name,u.country,u.state,u.city,fs.friend_id,fs.chat,fs.id as f_id from friends as fs,
		user as u
		where u.id=fs.friend_id AND fs.user_id='".$_SESSION['user_id']."' AND fs.friend_type='user' AND fs.status='active'";


}
 $sql6=@mysql_query($sql4);
 // $sql111 = mysql_fetch_array($sql6);
 // echo "<pre>"; print_r($sql111); exit;
 $num=@mysql_num_rows($sql6);


$chatcheckquery = @mysql_query("SELECT * FROM `friends` WHERE chat= '0' AND `user_id` = '".$_SESSION['user_id']."'  ");
$countdisable = @mysql_num_rows($chatcheckquery);

$titleofpage="All Connections";
include('NewHeadeHost.php');
?>

<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php
	 	if(isset($_SESSION['subuser']))
	 	{
	 		include('sub-right-panel.php');
	 	}
	 	elseif(!isset($_GET['host_id']))
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
		  <h3 id="title"> Import List  	<span class="disableall">
			<a class="button" href="csv_template/Users-List-Template.csv" >Download Template</a>
		</span></h3>

	
				
			  
			
			 

					 <div class="">
   
   <?php
   
   if (isset($_POST['submit'])) {

//echo "<pre>"; print_r($_FILES); exit;


	if(array_key_exists("main_host_id", $_POST)){
	  
					  $host_id = $_POST['main_host_id'];
	  $allowedExts = array("csv");
	  $temp = explode(".", $_FILES["filename"]["name"]);
	  $extension = end($temp);
	  if($extension == 'csv')
	  {
				  if (is_uploaded_file($_FILES['filename']['tmp_name'])) {




					  echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1> <br />";
					  //echo "<h2>Displaying contents:</h2>";
					  //readfile($_FILES['filename']['tmp_name']);
				  }
			  
				  //Import uploaded file to Database
				  $handle = fopen($_FILES['filename']['tmp_name'], "r");
				  $flag = true;
				  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				  if($flag){$flag = false; continue;}
					
					  mysql_query("INSERT INTO hostplaylist (`host_id`, `artist_name`, `music_title`) VALUES ('$host_id', '$data[1]', '$data[0]')");

				  }
				  
				  echo '<a href="musicplaylists.php" class="button">Click Here to Add More</a>';
			  
				  fclose($handle);
				   $Obj->Redirect("musicplaylists.php?msg=imported");
						exit;
		}
		else
		{
			$Obj->Redirect("import.php?msg=fail");
			exit;
		}
			  
				  //print "Import done";
	  
	}else{
	  $allowedExts = array("csv");
	  $temp = explode(".", $_FILES["filename"]["name"]);
	  $extension = end($temp);
	  if($extension == 'csv')
	  {
	  
						if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
							echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
							echo "<h2>Displaying contents:</h2>";
							readfile($_FILES['filename']['tmp_name']);
						}
					
						//Import uploaded file to Database
						$handle = fopen($_FILES['filename']['tmp_name'], "r");
					$flag = true;
						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					if($flag){$flag = false; continue;}
					$import_msg = '';
						if(count($data) >= 8){
						  
									$fname   = $data[0];
									$lname   = $data[1];
									$email   = $data[2];
									$street  = $data[3];
									$states   = $data[4];
									$get_states = mysql_query("Select zone_id , country_id from zone where name = '$states'");
									while($get_states_res = mysql_fetch_assoc($get_states))
									{
										  $state = $get_states_res['zone_id'];
										  $country = $get_states_res['country_id'];
									}
									$citys    = $data[5];
									
									$get_city = mysql_query("Select city_id from capital_city WHERE city_name = '$citys'");
								   
									
									while($get_city_res = mysql_fetch_assoc($get_city))
										  {
												 $city = $get_city_res['city_id'] ;
										  }
									$zip     = $data[6];
									$phone   = $data[7];                
													
								  $import = "INSERT INTO `user`(`id`, `first_name`, `last_name`, `email`, `profilename`, `password`, `DOB`, `user_address`, `country`,`street`, `state`, `city`, `zipcode`, `gender`, `image_nm`, `regi_date`, `status`, `phone`, `is_online`, `about_yourself`, `logged_date`, `IsAdmin`, `text_status`, `plantype`, `longitude`, `latitude`, `keepmelogin`, `hear_about`) VALUES ('','$fname','$lname','$email','','','','','$country','$street','$state','$city','$zip','','','','0','$phone','','','','0','0','','','','0','')";
									
							mysql_query($import) or die(mysql_error());
									
									$friend_id = mysql_insert_id();
									
									$import2 = "INSERT INTO `friends`(`id`, `user_id`, `friend_id`, `friend_type`, `status`, `close_friend`, `chat`) VALUES ('',$userID,$friend_id,'user','active','0','0')";
									mysql_query($import2) or die(mysql_error());
						  }else{
							$import_msg = "failed";
						  }
						}
						fclose($handle);
					
						print "Import done";
						
						if($import_msg != ''){
						  
						  $succ_mg = $import_msg;
						  
						}else{
						  
						  $succ_mg = 'imported';
						}
						
						$Obj->Redirect("all_connections.php?msg=".$succ_mg);
						exit;
			}
			else
			{
				$Obj->Redirect("import.php?msg=fail");
				exit;
			}
	  
	}
// $Obj->Redirect("import.php?msg=success");
//                 exit;
	//view upload form
}else { ?>

<div class="parent-message-div">
  <?php 
	  if(isset($_GET['msg']))
	  {
		if($_GET['msg'] == 'fail')
		{
		  echo "<div id='successmessage' style='display: block;' class='message' >Import Fail. Please choose CSV format File.</div>"; 

		}
		else
		{
		  echo "<div id='successmessage' style='display: block;' class='message' >Music Playlist Uploaded successfully.</div>"; 

		}
	  }


  ?>
</div>

	<form enctype='multipart/form-data' action='' method='post'>
  
	  <div class="edit_profile_f">
		  <div id="profile_box">
		<div class="clear"></div>
		<!-- <ul><li>Upload new csv by browsing to file and clicking on Upload</li></ul> -->
		<ul style="overflow:visible">
		<li>Select File to import: <br><br> <input required style="color: #FFF;" size='50' type='file' name='filename'>
	   </li></ul>
       <div class="clear"></div>
		<div class="errorforsignup">Upload new csv by browsing to file and clicking on Upload</div>

		<div id="submit_btn" class="import_control">
		
		  <?php if(!empty($_POST['main_host_id'])){ ?>
			
			<input type="hidden" name="main_host_id" value="<?php echo $_POST['main_host_id']; ?>">
		  <?php } ?>

		  
		  <input type='submit' name='submit' value='Upload' class='button'>&nbsp; &nbsp; 
		  <?php if(!empty($_POST['main_host_id'])){ ?>
		  <input type='button' onclick="window.location='musicplaylists.php'" name='cancel' value='Cancel' class='button'>
		  <?php }else{ ?>
		  <input type='button' onclick="window.location='all_connections.php'" name='cancel' value='Cancel' class='button'>
		  <?php } ?>
		</div>
		
		  </div>
	</div>
	  
	</form>  
	
<?php
}
   
   
   ?>
									
				 </div>
				 

				 <div style="float: left; width: 100%;border-bottom:1px solid #ffffff; padding:5px;">
					

				 </div>
					  </div>
				</div>
			</div>
		</article>
	</div>
</div>
   
<?php include('Footer.php') ?>