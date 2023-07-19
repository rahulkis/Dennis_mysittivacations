<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);

if(isset($_POST['share_current_post'])){
	
	$added_on = date("Y-m-d h:i:s");
	$city = $_SESSION['id'];
	$status = 1;
	$common_identifier = date("Ymdhis");
	$ThisPageTable='forum';
	$state = $_SESSION['state'];
	$country = $_SESSION['country'];
	$user_type = $_SESSION['user_type'];
	
	if($_POST['type'] == 'blog_page'){
		
		$ValueArray = array(date('YmdHis'),$_SESSION['user_id'],'blog',$_SESSION['user_type'],$_POST['thumb'],$_POST['title'],$_POST['image'],'',$_SESSION['user_id'],$added_on,$city,'public',$status,'','');
		$FieldArray = array('common_identifier','from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		
	}	
	
	if($_POST['type'] == 'city_talk'){
		
		mysql_query("INSERT INTO forum (`common_identifier`,`forum`, `forum_img`, `image_thumb`, `forum_video`, `user_id`, `added_on`, `city_id`, `state_id`, `country_id`, `status`, `user_type`, `from_user`, `post_from`, `forum_type`) VALUES ('$common_identifier','".$_POST['title']."', '".$_POST['image']."', '".$_POST['thumb']."', '', '".$_SESSION['user_id']."', '".$added_on."', '".$city."', '".$state."', '".$country."', '".$status."', '".$user_type."', '".$_SESSION['user_id']."', 'city_talk', 'public')");
		
	}
	
	if($_POST['type'] == 'profile_post'){
		
				$ValueArray = array($_SESSION['user_id'],'profile',$_SESSION['user_type'],$_POST['thumb'],$_POST['title'],$_POST['image'],'',$_SESSION['user_id'],$added_on,$city,'public',$status,"","", $common_identifier);
				
				$FieldArray = array('from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id', 'common_identifier');
				
				$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);		
		
	}	
	die;
}

if(isset($_POST['share_current_video'])){
	
	$added_on = date("Y-m-d h:i:s");
	$city = $_SESSION['id'];
	$status = 1;
	$common_identifier = date("Ymdhis");
	$ThisPageTable='forum';
	$state = $_SESSION['state'];
	$country = $_SESSION['country'];
	$user_type = $_SESSION['user_type'];
	
	if($_POST['type'] == 'blog_page'){
		
		$ValueArray = array(date('YmdHis'),$_SESSION['user_id'],'blog',$_SESSION['user_type'],'',$_POST['title'],'',$_POST['video'],$_SESSION['user_id'],$added_on,$city,'public',$status,'','');
		$FieldArray = array('common_identifier','from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		
	}
	
	if($_POST['type'] == 'city_talk'){
		
		mysql_query("INSERT INTO forum (`forum`, `forum_img`, `image_thumb`, `forum_video`, `user_id`, `added_on`, `city_id`, `state_id`, `country_id`, `status`, `user_type`, `from_user`, `post_from`, `forum_type`) VALUES ('".$_POST['title']."', '', '', '".$_POST['video']."', '".$_SESSION['user_id']."', '".$added_on."', '".$city."', '".$state."', '".$country."', '".$status."', '".$user_type."', '".$_SESSION['user_id']."', 'city_talk', 'public')");
		
	}
	
	if($_POST['type'] == 'profile_post'){
		
				$ValueArray = array($_SESSION['user_id'],'profile',$_SESSION['user_type'],'',$_POST['title'],'',$_POST['video'],$_SESSION['user_id'],$added_on,$city,'public',$status,"","", $common_identifier);
				
				$FieldArray = array('from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id', 'common_identifier');
				
				$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);		
		
	}	
	die;
}

if(isset($_POST['delete_id'])){
	
	$music_id = $_POST['delete_id'];
	  
	$del_action = mysql_query("DELETE FROM hostplaylist WHERE id = '$music_id'");
	
	if($del_action == 1){
	
		echo "Deleted";	
		
	}	
	
}

if(isset($_POST['delete_id_array'])){
	
	$delete_music_array = $_POST['delete_id_array'];
	
	foreach($delete_music_array as $music_id){
		  
		mysql_query("DELETE FROM hostplaylist WHERE id = '$music_id'");
		
	}
	
	echo "Deleted";
}

if(isset($_POST['delete_commment_id'])){
	
	$del_query = mysql_query("DELETE FROM forum_comment WHERE id='".$_POST['delete_commment_id']."'");
	
		if($del_query == 1){ echo "deleted"; }
	
}

if(isset($_POST['refresh_city_background'])){
	
	$select_query = @mysql_query("SELECT * FROM refresh_background WHERE city_image_id='".$_POST['refresh_city_background']."'");
	$count = @mysql_num_rows($select_query);
	
	if($count < 1){
		
		$insert_id_query = @mysql_query("INSERT INTO refresh_background (`city_image_id`, `refresh_status`, `city_name`) VALUES('".$_POST['refresh_city_background']."' , '1', '".$_POST['refresh_city_name']."')	");
		
		if($insert_id_query == 1){ echo "updated"; }else{ echo "error"; }
		
		}else{
			
			$status = mysql_fetch_assoc($select_query);
			
				if($status['refresh_status'] == 1){
					
						$update_id_query = @mysql_query("UPDATE refresh_background SET refresh_status = '0' WHERE city_image_id = '".$_POST['refresh_city_background']."'");
						
						if($update_id_query == 1){ echo "updated"; }else{ echo "error"; }					
					
					}else{
					
						$update_id_query = @mysql_query("UPDATE refresh_background SET refresh_status = '1' WHERE city_image_id = '".$_POST['refresh_city_background']."'");
						
						if($update_id_query == 1){ echo "updated"; }else{ echo "error"; }					
					
				}
				
			}
		
	}

if(isset($_POST['time_interval'])){
	
	$select_query = @mysql_query("SELECT * FROM refresh_background_time");
	$count = mysql_num_rows($select_query);
	
	if($count < 1){
		
			$insert_id_query = @mysql_query("INSERT INTO refresh_background_time (`time_interval`) VALUES('".$_POST['time_interval']."')	");
			
			if($insert_id_query == 1){ echo "updated"; }else{ echo "error"; }
		
		}else{
					
			$update_id_query = @mysql_query("UPDATE refresh_background_time SET time_interval = '".$_POST['time_interval']."'");
			
			if($update_id_query == 1){ echo "updated"; }else{ echo "error"; }					

			}	
	
	}
	
if(isset($_POST['arrange_images']))
{
  
  // $ip = $_POST['remote_address'];
  
  // $getipinfo = @mysql_query("SELECT `id` FROM `ipaddress_city` WHERE `ipaddress` = '".$ip."' ");
  // $countipifo = @mysql_num_rows($getipinfo);
  // if($countipifo > 0)
  // {
  //  $fetchipin
  // }
  // else
  // {
  //  $details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
  //  $city = $details->geoplugin_city;
  //  @mysql_query("INSERT INTO `ipaddress_city` (`ipaddress`,`city_name`) VALUES ('".$ip."','".$city."') ");

  // }
  	$cityid = $_SESSION['id'];
  	$getcityname = @mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '".$cityid."' ");
  	$fetchcity = @mysql_fetch_array($getcityname);
 	$city = trim($fetchcity['city_name']);
  	if(!empty($city))
  	{
	    if($fetchcity['refresh'] == '1')
	    {

	      	$images_array = array();
	      	$images = array();
	      	$get_images = @mysql_query("SELECT * FROM refresh_background WHERE city_name LIKE '%".$city."%'");
	      		
	      	while($row = mysql_fetch_assoc($get_images))
	      	{
	        
	        	$images_array[] = $row['city_image_id'];
	        
	      	}
	      
	      	if(!empty($images_array))
	      	{
	        
		        $random_key = array_rand($images_array, 1);
		      
		        $img_id = $images_array[$random_key];
		        echo "SELECT city_image_url FROM capital_city_images WHERE city_image_id = '".$img_id."'";
		        $get_single_image = @mysql_query("SELECT city_image_url FROM capital_city_images WHERE city_image_id = '".$img_id."'");
	        
	          	$row = @mysql_fetch_assoc($get_single_image);
	            
	            $imagesrcback =  "/admin/cities/".$row['city_image_url'];
	            $intervalq = @mysql_query("SELECT * FROM `refresh_background_time`");
	            $intervalf = @mysql_fetch_array($intervalq);
	           // echo $row['city_image_url'];
	            //die;
	            ob_start();
				setcookie("backgroundcookie", $row['city_image_url'],time() + (60 * $intervalf['time_interval'] ) );
				ob_end_clean();
				

	      	}
	    }
	    else
	    {
	    	ob_start();
			setcookie("backgroundcookie", '/images/homebg.png',time() + (60 * $intervalf['time_interval'] ) );
			ob_end_clean();
	    	echo "disable";
	    }   
  	}
}

if(isset($_POST['refreshaction']))
{
	$action = $_POST['action'];
	$cityid = $_POST['cityid'];
	if($action == 'enable')
	{
		$action = '1';
	}
	else
	{
		$action = '0';
	}
	$updateaction = @mysql_query("UPDATE `capital_city` SET `refresh` = '".$action."' WHERE `city_id` = '".$cityid."' ");

	if($updateaction)
	{
		echo "Refresh Action Updated Successfully!";
	}
	else
	{
		echo "Error";
	}

}

if(isset($_POST['delete_coupon']))
{

	$coupon_id = $_POST['delete_coupon'];
	
	  @mysql_query("delete from host_coupon where id='".$coupon_id."'");
	  @mysql_query("delete from downloadpasses where pass_id='".$coupon_id."'");
	  @mysql_query("delete from user_to_content where cont_id='".$coupon_id."' AND cont_type = 'pass'");
	  echo "deleted";

}

if(isset($_POST['download_host_pass'])){
	
	$check_max_download = mysql_query("SELECT * FROM downloadpasses WHERE pass_id = '".$_POST['pass_id']."' AND host_id = '".$_POST['host_id']."'");
	$count = mysql_num_rows($check_max_download);

	$check_max_limit = mysql_query("SELECT max_download FROM host_coupon WHERE id = '".$_POST['pass_id']."' AND host_id = '".$_POST['host_id']."'");
	$check_max_limit = mysql_fetch_assoc($check_max_limit);
	
	$pass_download_limit = $check_max_limit['max_download'];
	$pass_download_count = $count;
	
	if($pass_download_count == $pass_download_limit){
		
		echo "stop";
		
		}else{
			
	$check_user_pass = mysql_query("SELECT * FROM downloadpasses WHERE pass_id = '".$_POST['pass_id']."' AND host_id = '".$_POST['host_id']."' AND user_id = '".$_POST['user_id']."'");
	
	$count_user_d = mysql_num_rows($check_user_pass);
	
	if($count_user_d < 1){
	
	$insert = @mysql_query("INSERT INTO downloadpasses (`host_id`, `user_id`, `pass_id`) VALUES('".$_POST['host_id']."', '".$_POST['user_id']."', '".$_POST['pass_id']."')");
	
	if($insert == 1){ echo "success"; }
	
			}
	}
	
}

if(isset($_POST['delete_pass'])){
	
	  @mysql_query("delete from downloadpasses where pass_id='".$_POST['pass_id']."' AND host_id = '".$_POST['host_id']."' AND user_id = '".$_POST['user_id']."'");
	  echo "deleted";
	
}

if(isset($_POST['check_city_status'])){
	
	// echo "SELECT * FROM capital_city WHERE state_id = '".$_POST['state']."' AND city_name = '".$_POST['city']."'";
	// die;

	$check = $_POST['checkbox'];

	$jquery_city = @mysql_query("SELECT * FROM capital_city WHERE state_id = '".$_POST['state']."' AND city_name = '".$_POST['city']."'");
	
	$jquery_city_rows = mysql_num_rows($jquery_city);
	$fetchres = @mysql_fetch_array($jquery_city);
	if($jquery_city_rows == 1){

		if($check == "on")
		{
			$user_id = $_SESSION['user_id'];
			$user_type = $_SESSION['user_type'];
			$state = $_POST['state'];
			$country = $_POST['country'];
			$check_d_city_status = @mysql_query("SELECT * FROM default_city_selected WHERE user_id = '".$_SESSION['user_id']."' AND user_type = '".$_SESSION['user_type']."'");
			$check_d_city_rows = mysql_num_rows($check_d_city_status);
		
			if($check_d_city_rows < 1){
				
				$insert_d_city = @mysql_query("INSERT INTO default_city_selected (`user_id`, `user_type`, `country`, `state`, `city`, `d_city_status`) VALUES ('".$user_id."', '".$user_type."', '".$country."', '".$state."', '".$fetchres['city_id']."', '".$check."')");
				
			}else{
				
				$update_d_city = @mysql_query("UPDATE default_city_selected SET `country` = '".$country."', `state` = '".$state."', `city` = '".$fetchres['city_id']."', `d_city_status` = '".$check."' WHERE user_id = '".$user_id."' AND user_type = '".$user_type."' ");
				
			}
		}
		
		session_start();
		
		$_SESSION['id'] = $fetchres['city_id'];
		$_SESSION['state'] = $_POST['state'];
		$_SESSION['country'] = $_POST['country'];
		session_write_close();
		echo "exists";
		
		}
	
}

if(isset($_POST['video_id']))
{
	
	$GetContest = mysql_query("SELECT * FROM `contestent` WHERE `c_video_id` = '$_POST[video_id]' ");
	$fetchContest = mysql_fetch_assoc($GetContest);
	$contestID = $fetchContest['contest_id'];
	$contestentType = $fetchContest['user_type'];

	if($contestentType == "user")
	{
		$getUserInfo = mysql_query("SELECT `email` FROM `user` WHERE `id` = '$fetchContest[user_id]'  ");
		$fetchUserInfo = mysql_fetch_assoc($getUserInfo);
		$EMAIL = $fetchUserInfo['email'];
	}
	else
	{
		$getUserInfo = mysql_query("SELECT `club_email` FROM `clubs` WHERE `id` = '$fetchContest[user_id]'  ");
		$fetchUserInfo = mysql_fetch_assoc($getUserInfo);
		$EMAIL = $fetchUserInfo['club_email'];
	}

	$GetContestinfo = mysql_query("SELECT * FROM `contest` WHERE `id` = '$contestID' ");
	$fetchContestinfo = mysql_fetch_assoc($GetContestinfo);

	$contestName = $fetchContestinfo['contest_title'];
	$contestPrize = $fetchContestinfo['contest_prize'];
	$contestStart = $fetchContestinfo['contest_start']." ".$fetchContestinfo['start_time'];
	$contestEnd = $fetchContestinfo['contest_end']." ".$fetchContestinfo['end_time'];

	mysql_query("DELETE FROM contestent WHERE c_video_id = '".$_POST['video_id']."'");
	mysql_query("DELETE FROM contest_video_like WHERE c_video_id = '".$_POST['video_id']."'");
	mysql_query("DELETE FROM `contestent` WHERE `c_video_id` = '$_POST[video_id]' AND `contest_id` = '$contestID'");
	mysql_query("DELETE FROM contest_video_like WHERE c_video_id = '$_POST[video_id]'");

		$str = "
				<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
					<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
					<hr>
					<p style='color: white;'>
						<br />
			Welcome to the MYSITTI family and be a part of the next social revolution.  Visit mysittidev.com where we are 
			<br />MAKING EVERY CITY YOUR CITY!
						<br /><br />
				You have Deleted your Entry From the following Contest: 
				<br/> <br/> 
				Contest Name: ".$contestName." <br>
				Contest Start Date: ".$contestStart."<br>
				Contest End Date: ".$contestEnd."<br>
				Contest Prize: ".$contestPrize." <br><br>
					
			 ";
			$str .= " Thanks <br>";
			$str .= " MySitti Team </p>
				</div>";
			$message = $str; 
			$to  = $EMAIL;
			//$to  = "sumit.manchanda@kindlebit.com";
			
			$subject = "Live Contest Entry Delete Notification";
			$message = $str;
			//$from = "info@mysittidev.com";
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: MySitti <mysitti@mysittidev.com>' . "\r\n";
			//$headers .= "From:" . $from;
			
			if(mail($to,$subject,$message,$headers,"-finfo@mysittidev.com"))
			{
				echo "test Mail Sent.";
			}







	
}

if(isset($_POST['set_default_category'])){
	
	if($_POST['user_type'] == "club"){
		
		mysql_query("UPDATE clubs SET default_category = '".$_POST['set_default_category']."' WHERE id = '".$_POST['user_id']."'");
		
		echo "Selected Category Updated";
		
		}else{
		
		mysql_query("UPDATE user SET default_category = '".$_POST['set_default_category']."' WHERE id = '".$_POST['user_id']."'");
		
		echo "Selected Category Updated";
		
	}
}

if(isset($_POST['notification_id'])){
	
	mysql_query("DELETE FROM user_notification WHERE id = '".$_POST['notification_id']."'");
	
}

if(isset($_POST['get_state_id'])){
	
	$get_state_id = mysql_query("SELECT zone_id FROM zone WHERE name = '".$_POST['state_name']."' AND country_id = '".$_POST['country_id']."'");
	$st_id = mysql_fetch_assoc($get_state_id);
	echo $st_id['zone_id'];
	
}

if(isset($_POST['approval_id'])){

	$approval_id = $_POST['approval_id'];
	
	$success = mysql_query("UPDATE help_and_support SET approve = 1 WHERE id = '".$approval_id."'");
	
	if($success == 1){
		
		echo "updated";
		
	}
}

if(isset($_POST['support_id'])){

	$support_id = $_POST['support_id'];
	
	$success = mysql_query("DELETE FROM support_thread WHERE id = '".$support_id."'");
	
	if($success == 1){
		
		echo "deleted";
		$_SESSION['admin_thr_del'] = "success";
		
	}
}

if(isset($_POST['upass_id'])){

	$pass = $_POST['upass_id'];
	$user_id = $_POST['user_id'];
	$host_id = $_POST['host_id'];
	
	$success = mysql_query("DELETE FROM user_to_content WHERE user_id = '".$user_id."' AND cont_id = '".$pass."' AND owner_id = '".$host_id."'");
	
	if($success == 1){
		
		echo "deleted";
		$_SESSION['user_p_ass_del'] = "success";
		
	}
}

if($_GET['action'] == "agree_merchant"){

	$host_id = $_POST['host_id'];
	$date = date('Y-m-d H:i:s');
	
	$success = $success = mysql_query("UPDATE clubs SET merchant_date = '".$date."' WHERE id = '".$host_id."'");
	
	if($success == 1){
		
		echo "updated";
		
	}
}

if(isset($_POST['store_category_name'])){

	$store_cat_id = $_POST['store_category_id'];
	$store_cat_name = mysql_real_escape_string($_POST['store_category_name']);
	$ctable_name = $_POST['category_tb_name'];

	$success = $success = mysql_query("UPDATE `".$ctable_name."` SET category_name = '".$store_cat_name."' WHERE id = '".$store_cat_id."'");
	
	if($success == 1){
		
		echo "updated";
		
	}
}

if(isset($_POST['store_status_value'])){

	$store_cat_id = $_POST['store_category_id'];
	$store_status_value = $_POST['store_status_value'];
	$ctable_name = $_POST['category_tb_name'];

	$success = $success = mysql_query("UPDATE `".$ctable_name."` SET status = '".$store_status_value."' WHERE id = '".$store_cat_id."'");
	
	if($success == 1){
		
		echo "updated";
		
	}
}

if(isset($_POST['update_store_ordr'])){

		$sql = "UPDATE `store_order_status` SET `status` = '".$_POST['val']."' WHERE `id` = ".$_POST['updatestatusid'];
		mysql_query($sql);
		
			$invoice = $_POST['invoice'];
			$sql = "select payer_email from purchases where invoice=".$invoice;
			$data = mysql_query($sql);
			
			if(mysql_num_rows($data)){
				$row = mysql_fetch_array($data);
				$email = $data['payer_email'];
				
				if($_POST['val']==1){
					$msgx = " your order  has statred processing will be dispatch soon you will get a mail when it dispatch";
				}
				if($_POST['val']==2){
					$msgx = " your order is  complete wil be diliver to you soon ";
				}
				if($_POST['val']==3){
					$msgx = " your order has been cancled due to some reason, sorry for inconvenience";
				}
				
				include('order_statuschnage_email.php');
				
				echo "Order Status Updated Successfully";
			}
}

if(isset($_POST['h_name'])){
	
	$get_clubname = mysql_real_escape_string($_POST['h_name']);
	
	$check_host_exists = mysql_query("SELECT `id` FROM clubs WHERE club_name = '".$get_clubname."'");
	$check_host_exists1 = mysql_query("SELECT `id` FROM `user` WHERE `profilename` = '".$get_clubname."'");

	$count_host_num = mysql_num_rows($check_host_exists);
	$count_host_num1 = mysql_num_rows($check_host_exists1);
	
	if($count_host_num > 0 || $count_host_num1 > 0 ){
		
		echo "false";
		
		}else{
		
		echo "true";
		
	}
}

if(isset($_POST['streaming_start_time'])){
	
	$streaming_start_time = $_POST['streaming_start_time'];
	$streaming_end_time = $_POST['streaming_end_time'];
	$host_id = $_POST['host_id'];
	$contest_id = $_POST['contest_id'];
	
	$check_host_stream = mysql_query("SELECT * FROM battle_settings WHERE contest_id = '".$contest_id."' AND user_id = '".$host_id."'");
	$count_host_stream = mysql_num_rows($check_host_stream);
	
	if($count_host_stream < 1){
		
		$success = mysql_query("INSERT INTO battle_settings (`user_id`, `user_type`, `slot_start_time`, `slot_end_time`, `contest_id`) VALUES('".$host_id."' , 'club', '".$streaming_start_time."', '".$streaming_end_time."', '".$contest_id."')");
		
		if($success == 1){
			echo "Host Streaming Time Inserted Successfully";
		}
		
	}else{
		
		$success = mysql_query("UPDATE battle_settings SET slot_start_time = '".$streaming_start_time."', slot_end_time = '".$streaming_end_time."' WHERE user_id = '".$host_id."'");
		
		if($success == 1){
			
			echo "Host Streaming Time Updated Successfully";
			
		}		
		
	}
	
}

if(isset($_POST['from_superadmin'])){
	
	$streaming_start_time = $_POST['streaming_start_time_admin'];
	$streaming_end_time = $_POST['streaming_end_time_admin'];
	$host_id = $_POST['host_id'];
	$contest_id = $_POST['contest_id'];
	
	
	$get_contest_name = mysql_query("SELECT contest_title FROM contest WHERE contest_id = '".$contest_id."'");
	$contest_name = mysql_fetch_assoc($get_contest_name);
	
	$check_host_stream = mysql_query("SELECT * FROM battle_settings WHERE contest_id = '".$contest_id."' AND user_id = '".$host_id."'");
	$count_host_stream = mysql_num_rows($check_host_stream);
	
	if($count_host_stream < 1){
		
		$success = mysql_query("INSERT INTO battle_settings (`user_id`, `user_type`, `slot_start_time`, `slot_end_time`, `contest_id`, `status`) VALUES('".$host_id."' , 'club', '".$streaming_start_time."', '".$streaming_end_time."', '".$contest_id."', 'pending')");
		
		if($success == 1){
			echo "Host Requested For Streaming Successfully";

						$club_email_query = mysql_query("SELECT club_email FROM clubs WHERE id = '".$host_id."'");
						$club_email = mysql_fetch_assoc($club_email_query);
					
						$email = mysql_real_escape_string($club_email['club_email']);
						$base_url = "https://" . $_SERVER['SERVER_NAME']."/";
						//$activation = md5($email.time());
						$activation = md5(strtotime(date('YmdHis')));
						
						mysql_query("UPDATE battle_settings SET activation_code = '".$activation."' WHERE user_id = '".$host_id."'");
						
$str = "
				<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
				<div width:100%;'>
					<div class='logo' style='float: left; margin-right:20px;'>
						<img src='".$base_url."images/new_portal/images/logo.png' border='0' />
					</div>
					<div style='float:left; margin-top: 50px;'>
						<p style='color: white;'>
						Welcome to the MYSITTI family and be a part of the next social revolution. <br /> 
						Visit <a srtle='color:#fecd07;' href='".$base_url."'>mysittidev.com</a> where we are <span style='color:#fecd07'>MAKING EVERY CITY YOUR CITY!</span>
						</p>
					</div>
				</div>
				<hr style='float:left; width:100%;'>
				<p style='color: white; float: left;width:100%;'>
				Please confirm your Live Battle streaming time.  We need to make sure you are human.  Please verify by clicking the link below.
				<br/> <br/> 
				Live Battle: ".$contest_name['contest_title']." <br />
				Start Time: ".date("M j,Y G:i A T",strtotime($streaming_start_time))." <br />
				End Time: ".date("M j,Y G:i A T",strtotime($streaming_end_time))."<br /><br />
				
				Click to confirm:  <a href=".$base_url."streaming-activation.php?code=".$activation.">".$base_url."activation/".$activation."</a>
			 ";
			$str .= "<br/> Thank you, <br>";
			$str .= " MySitti Team </p>
				</div>";						
						
						$message = $str; 
						$to  = $email;
						
						$subject = "Mysitti Streaming verification";
						$message = $str;
						//$from = "info@mysittidev.com";
						
						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: MySitti <mysitti@mysittidev.com>' . "\r\n";
						//$headers .= "From:" . $from;
						
						mail($to,$subject,$message,$headers,"-finfo@mysittidev.com");
						//echo "test Mail Sent.";				
			
			
		}
		
	}else{
		
		$host_Data = mysql_fetch_assoc($check_host_stream);
		
		if($host_Data['pending']){
			
			echo "Requested Already";
			
		}
		
		if($host_Data['accepted']){
			
			echo "Already Accepted";
			
		}	
		
		//$success = mysql_query("UPDATE battle_settings SET slot_start_time = '".$streaming_start_time."', slot_end_time = '".$streaming_end_time."' WHERE user_id = '".$host_id."'");
		//
		//if($success == 1){
		//	
		//	echo "Host Streaming Time Updated Successfully";
		//	
		//}		
		
	}
	
}

if(isset($_POST['streaming_all_invite'])){

	$contest_id = $_POST['contest_id'];
	
	$cont_query = mysql_query("SELECT * FROM contest");
	while($c_row = mysql_fetch_assoc($cont_query)){
		
		if($c_row['contest_id'] == $contest_id){
			
			mysql_query("UPDATE contest SET battle_status = 'active' WHERE contest_id = '".$c_row['contest_id']."'");
			
		}else{
			
			mysql_query("UPDATE contest SET battle_status = 'inactive' WHERE contest_id = '".$c_row['contest_id']."'");
			
		}
		
	}	
	
	$check_host_stream = mysql_query("SELECT * FROM battle_settings WHERE contest_id = '".$contest_id."' AND status = 'accepted'");
	
	$msg_query = mysql_query("SELECT page_data FROM pages WHERE page_id = '10'");
	$msg_data = mysql_fetch_assoc($msg_query);
	$email_message = $msg_data['page_data'];
	
		while($count_host_stream = mysql_fetch_assoc($check_host_stream)){
			
						$club_email_query = mysql_query("SELECT club_email FROM clubs WHERE id = '".$count_host_stream['user_id']."'");
						$club_email = mysql_fetch_assoc($club_email_query);
					
						$email = mysql_real_escape_string($club_email['club_email']);
		
			$str = "
				<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
				<div width:100%;'>
					<div class='logo' style='float: left; margin-right:20px;'>
						<img src='".$base_url."images/new_portal/images/logo.png' border='0' />
					</div>
					<div style='float:left; margin-top: 50px;'>
						<p style='color: white;'>
						Welcome to the MYSITTI family and be a part of the next social revolution. <br /> 
						Visit <a srtle='color:#fecd07;' href='".$base_url."'>mysittidev.com</a> where we are <span style='color:#fecd07'>MAKING EVERY CITY YOUR CITY!</span>
						</p>
					</div>
				</div>
				<hr style='float:left; width:100%;'>
				<p style='color: white; float: left;width:100%;'>".$email_message."
				
			 ";
			$str .= "<br/> Thank you, <br>";
			$str .= " MySitti Team </p>
				</div>";

						$message = $str; 
						$to  = $email;
						//$to  = "anuj.gambhir@kindlebit.com";
						
						$subject = "Mysitti Battle Invitation";
						$message = $str;
						//$from = "info@mysittidev.com";
						
						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: MySitti <mysitti@mysittidev.com>' . "\r\n";
						//$headers .= "From:" . $from;
						
						mail($to,$subject,$message,$headers,"-finfo@mysittidev.com");
						//echo "test Mail Sent.";							
						
			
		}
		
		echo "Invitation sent to all hosts successfully";
	
}

if(isset($_POST['add_contestant_winner'])){
	
	$battle_total = mysql_query("SELECT * FROM winners_list WHERE contest_id = '".$_POST['c_id']."'");
	$battle_total_rows = mysql_num_rows($battle_total);
	
	if($battle_total_rows == 10){
	
			echo "Winners list already full";
		
	}else{
		
	$battle_query = mysql_query("SELECT * FROM winners_list WHERE contest_id = '".$_POST['c_id']."' AND user_id = '".$_POST['u_id']."'");
	$battle_rows = mysql_num_rows($battle_query);
	
		if($battle_rows < 1){
			
			mysql_query("INSERT INTO winners_list (`user_id`, `contest_id`) VALUES ('".$_POST['u_id']."', '".$_POST['c_id']."')");
			
			echo "Contestant added to winner list";
			
		}else{
			
			echo "Contestant already in winner list";
			
		}		
		
	}

}

if(isset($_POST['set_default_video'])){
	
	$get_videos = mysql_query("SELECT id FROM battle_playlist");
	
	while($row = mysql_fetch_assoc($get_videos)){
		
		if($row['id'] == $_POST['set_default_video']){
			
			mysql_query("UPDATE battle_playlist SET default_video = '1' WHERE id = '".$row['id']."'");
			
		}else{
			
			mysql_query("UPDATE battle_playlist SET default_video = '0' WHERE id = '".$row['id']."'");
			
		}
		
	}

	echo "Default Video Set";
	
}

if(isset($_POST['set_playlist_video']))
{
	$getVideosdetail = mysql_query("SELECT * FROM `uploaed_video` WHERE `video_id` = '$_POST[set_playlist_video]' ");
	$Weekday = $_POST['day'];
	$fetchResult = mysql_fetch_assoc($getVideosdetail);

	$countCheck = mysql_query("SELECT * FROM `mysittiTV` WHERE `weekDay` = '$Weekday' ");
	$MyCount = mysql_num_rows($countCheck);

	if($_POST['check'] == 'yes' )
	{
		mysql_query("UPDATE `uploaed_video` SET `featured` = '1' WHERE `video_id` = '$fetchResult[video_id]' ");
		echo "Added Video in to playlist.";

		// $checkq = mysql_query("SELECT * FROM `mysittiTV` WHERE `bpid` = '$_POST[set_playlist_video]' ");
		// if(mysql_num_rows($checkq) < 1)
		// {
		// 	$MyCount = $MyCount+1;
		// 	mysql_query("INSERT INTO `mysittiTV` (`host_id`,`video_path`,`weekDay`,`video_title`,`user_type`,`bpid`,`trackno`) VALUES ('$fetchResult[user_id]','$fetchResult[video_path]','$Weekday','$fetchResult[video_title]','$fetchResult[user_type]','$fetchResult[id]','$MyCount') ");
		// 	echo "Video Added to playlist.";
		// }
		// else
		// {
		// 	echo "Video Already Added to a playlist";
		// }
	}
	elseif($_POST['check'] == 'no')
	{
		mysql_query("UPDATE `uploaed_video` SET `featured` = '0' WHERE `video_id` = '$_POST[set_playlist_video]' ");
		echo "Removed Video from playlist.";
	}
	

	
	
}


if(isset($_POST['set_playlist_video_play']))
{
	$getVideosdetail = mysql_query("SELECT * FROM `mysittiTV` WHERE `id` = '$_POST[set_playlist_video_play]' ");
	$Weekday = $_POST['day'];
	$fetchResult = mysql_fetch_assoc($getVideosdetail);

	$countCheck = mysql_query("SELECT * FROM `mysittiTV` WHERE `weekDay` = '$Weekday' ");
	$MyCount = mysql_num_rows($countCheck);



	if($_POST['check'] == 'yes' )
	{
		$checkq = mysql_query("SELECT * FROM `mysittiTV` WHERE `id` = '$_POST[set_playlist_video]' ");
		if(mysql_num_rows($checkq) < 1)
		{
			$MyCount = $MyCount+1;
			mysql_query("INSERT INTO `mysittiTV` (`host_id`,`video_path`,`weekDay`,`video_title`,`user_type`,`bpid`,`trackno`) VALUES ('$fetchResult[user_id]','$fetchResult[video_path]','$Weekday','$fetchResult[video_title]','$fetchResult[user_type]','$fetchResult[id]','$MyCount') ");
			echo "Video Added to playlist.";
		}
		else
		{
			mysql_query("UPDATE `mysittiTV` SET `weekDay` = '$Weekday' WHERE `id` = '$_POST[set_playlist_video_play]' ");
			echo "Video Updated to playlist.";
		}
	}
	elseif($_POST['check'] == 'no')
	{
		//echo "DELETE FROM `mysittiTV`  WHERE bpid = '$_POST[set_playlist_video_play]' ";
		mysql_query("DELETE FROM `mysittiTV`  WHERE id = '$_POST[set_playlist_video_play]' ");	
		echo "Video Removed from playlist.";
	}
	
}
// For new list
if(isset($_POST['set_playlist_video_play2']))
{
	$getVideosdetail = mysql_query("SELECT * FROM `uploaed_video` WHERE `video_id` = '$_POST[set_playlist_video_play2]' ");
	$Weekday = $_POST['day'];
	$fetchResult = mysql_fetch_assoc($getVideosdetail);

	$countCheck = mysql_query("SELECT * FROM `mysittiTV` WHERE `weekDay` = '$Weekday' ");
	$MyCount = mysql_num_rows($countCheck);



	if($_POST['check'] == 'yes' )
	{
		$checkq = mysql_query("SELECT * FROM `uploaed_video` WHERE `video_id` = '$_POST[set_playlist_video]' ");
		if(mysql_num_rows($checkq) < 1)
		{
			$MyCount = $MyCount+1;
			mysql_query("INSERT INTO `mysittiTV` (`host_id`,`video_path`,`weekDay`,`video_title`,`user_type`,`bpid`,`trackno`) VALUES ('$fetchResult[user_id]','$fetchResult[video_path]','$Weekday','$fetchResult[video_title]','$fetchResult[user_type]','$fetchResult[id]','$MyCount') ");
			echo "Video Added to playlist.";
		}
		else
		{
			mysql_query("UPDATE `mysittiTV` SET `weekDay` = '$Weekday' WHERE `id` = '$_POST[set_playlist_video_play2]' ");
			echo "Video Updated to playlist.";
		}
	}
	elseif($_POST['check'] == 'no')
	{
		//echo "DELETE FROM `mysittiTV`  WHERE bpid = '$_POST[set_playlist_video_play]' ";
		mysql_query("DELETE FROM `uploaed_video`  WHERE video_id = '$_POST[set_playlist_video_play2]' ");	
		echo "Video Removed from playlist.";
	}
	
}


if(isset($_POST['redeem_streaming_ticktet'])){
	
	$update = mysql_query("UPDATE streaming_tickets_purchased SET status = 'redeemed' WHERE buyer_code = '".$_POST['buyer_code']."'");
	
	if($update == 1){
		echo "done";
	}
}

if(isset($_POST['search_user_friend'])){
	$friendname = mysql_real_escape_string($_POST['search_user_friend']);
	
	$check_user = mysql_query("SELECT * FROM user WHERE profilename = '".$friendname."'");
	$count_user_row = mysql_num_rows($check_user);
	
	if($count_user_row == 1){
		
			$user_friend_data = mysql_fetch_assoc($check_user);
		
			$get_country = mysql_query("SELECT name FROM country WHERE country_id = '".$user_friend_data['country']."'");
			$country_name = mysql_fetch_assoc($get_country);
			
			$get_state = mysql_query("SELECT name FROM zone WHERE zone_id = '".$user_friend_data['state']."'");
			$state_name = mysql_fetch_assoc($get_state);
			
			$get_city = mysql_query("SELECT city_name FROM capital_city WHERE city_id = '".$user_friend_data['city']."'");
			$city_name = mysql_fetch_assoc($get_city);
		?>
		<div class="v2_friend_listing">
			<div class="infodiv">
				<div class="image_friends">
						<a href="profile.php?id=<?php echo $user_friend_data['id']; ?>">
							<img alt="" src="<?php echo $user_friend_data['image_nm']; ?>">
						</a>
				</div>

				<div class="address_friends"><?php echo $user_friend_data['profilename']; ?><br><?php echo $country_name['name']; ?><br><?php echo $state_name['name']; ?><br><?php echo $city_name['city_name']; ?><br></div>
				
				<div class="chatoption">
						<a onclick="chatWith('<?php echo $user_friend_data['profilename']; ?>');" class="users" href="javascript:void(0);">
							<?php if($user_friend_data['is_online'] == 1){ ?>
								<img height="20" style="border: 0px;" src="images/chat.png"><br>
							<?php }else{ ?>
								<img height="20" style="border: 0px;" src="images/chat_offline.png"><br>
							<?php } ?>
						</a>
		
						<a class="button-a" href="profile.php?id=<?php echo $user_friend_data['id']; ?>"> View Profile </a>
						<?php
						$friend_status = mysql_query("SELECT id FROM friends WHERE user_id = '".$_SESSION['user_id']."' AND user_type = '".$_SESSION['user_type']."' AND friend_id = '".$user_friend_data['id']."' AND friend_type = 'user'");
						$get_friend_id = mysql_fetch_assoc($friend_status);
						?>
						<span id="request_<?php echo $get_friend_id['id']; ?>">
							<a class="button-a" onclick="requestBlock('<?php echo $get_friend_id['id']; ?>','block','user');" href="javascript:void(0);">Remove</a>
						</span>
				</div>
			</div>
		</div>
		
	<?php }else{
		
		$check_club = mysql_query("SELECT * FROM clubs WHERE club_name = '".$friendname."'");
		$count_club_row = mysql_num_rows($check_club);
		
			if($count_club_row == 1){
		
			$user_club_data = mysql_fetch_assoc($check_club);
		
			$get_country = mysql_query("SELECT name FROM country WHERE country_id = '".$user_club_data['club_country']."'");
			$country_name = mysql_fetch_assoc($get_country);
			
			$get_state = mysql_query("SELECT name FROM zone WHERE zone_id = '".$user_club_data['club_state']."'");
			$state_name = mysql_fetch_assoc($get_state);
			
			$get_city = mysql_query("SELECT city_name FROM capital_city WHERE city_id = '".$user_club_data['club_city']."'");
			$city_name = mysql_fetch_assoc($get_city);
		?>
		<div class="v2_friend_listing">
			<div class="infodiv">
				<div class="image_friends">
						<a href="host_profile.php?host_id=<?php echo $user_club_data['id']; ?>">
							<img alt="" src="<?php echo $user_club_data['image_nm']; ?>">
						</a>
				</div>

				<div class="address_friends"><?php echo $user_club_data['club_name']; ?><br><?php echo $country_name['name']; ?><br><?php echo $state_name['name']; ?><br><?php echo $city_name['city_name']; ?><br></div>
				
				<div class="chatoption">
						<a onclick="chatWith('<?php echo $user_club_data['club_name']; ?>');" class="users" href="javascript:void(0);">
							<?php if($user_club_data['is_online'] == 1){ ?>
								<img height="20" style="border: 0px;" src="images/chat.png"><br>
							<?php }else{ ?>
								<img height="20" style="border: 0px;" src="images/chat_offline.png"><br>
							<?php } ?>
						</a>
		
						<a class="button-a" href="host_profile.php?host_id=<?php echo $user_club_data['id']; ?>"> View Profile </a>
						<?php
						$friend_status = mysql_query("SELECT id FROM friends WHERE user_id = '".$_SESSION['user_id']."' AND user_type = '".$_SESSION['user_type']."' AND friend_id = '".$user_club_data['id']."' AND friend_type = 'club'");
						$get_friend_id = mysql_fetch_assoc($friend_status);
						?>
						<span id="request_<?php echo $get_friend_id['id']; ?>">
							<a class="button-a" onclick="requestBlock('<?php echo $get_friend_id['id']; ?>','block','club');" href="javascript:void(0);">Remove</a>
						</span>
				</div>
			</div>
		</div>				
		
			<?php }else{
				
				echo "No Results Found";
				
			}
		
	}
}

if(isset($_POST['search_address'])){
	
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($_POST['search_address'])."&amp;sensor=false";
    $result_string = file_get_contents($url);
    
    $result = json_decode($result_string, true);
	
	echo $result['results'][0]['geometry']['location']['lat']."&details&".$result['results'][0]['geometry']['location']['lng'];
	
}

if(isset($_POST['get_visitor_geolocation'])){

	$lat = $_POST['latitude']; //latitude
	$lng = $_POST['longitude']; //longitude
	
	//$lat = '38.029087'; //latitude
	//$lng = '-121.961627'; //longitude
	
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
	$json = @file_get_contents($url);
	$data = json_decode($json);
	
	$i = 0;
	$country = array();
	$state = array();
	$city = array();

	foreach($data->results[0]->address_components as $abc)
	{
		if($abc->types[0] == "country")
		{
			$country[] = $data->results[0]->address_components[$i]->long_name; 
		}
		
		if($abc->types[0] == "administrative_area_level_1")
		{
			$state[] = $data->results[0]->address_components[$i]->long_name; 
			
		}

		if($abc->types[0] == "locality")
		{
			$city[] = $data->results[0]->address_components[$i]->long_name; 
		}

		$i++;


	}
	
	
	/********************** Get State ****************************/
	
	$get_state_query = mysql_query("SELECT `name`, `zone_id` FROM zone WHERE name = '".$state[0]."'");
	$count_state_value = mysql_num_rows($get_state_query);
	$get_state_name = mysql_fetch_assoc($get_state_query);
	$statename = $get_state_name['name'];
	$stateid = $get_state_name['zone_id'];
	
	/********************** Get State ****************************/
	
	/********************** Get Country ****************************/
	
	$get_country_query = mysql_query("SELECT `name`, `country_id` FROM country WHERE name = '".$country[0]."'");
	$count_country_value = mysql_num_rows($get_country_query);
	$get_country_name = mysql_fetch_assoc($get_country_query);
	$countryname = $get_country_name['name'];
	$countryid = $get_country_name['country_id'];
	
	/********************** Get Country ****************************/
	
	/********************** Get City ****************************/
	
	$get_city_query = mysql_query("SELECT `city_name`, `city_id` FROM capital_city WHERE city_name = '".$city[0]."' AND state_id = '".$stateid."'");
	$count_city_value = mysql_num_rows($get_city_query);
	$get_city_name = mysql_fetch_assoc($get_city_query);
	$cityname = $get_city_name['city_name'];
	$cityid = $get_city_name['city_id'];
	
	/********************** Get City ****************************/	
	
	// if($count_city_value != 0 && $count_state_value != 0 && $count_country_value != 0){
		
		// if($countryid == '223' || $countryid == '38'){
			
			session_start();
			
			
			$check_city_exists = mysql_query("SELECT * FROM capital_city WHERE city_name = '".$cityname."' AND state_id = '".$stateid."'");
			$count_city_exists = mysql_num_rows($check_city_exists);
			
			if($count_city_exists < 1){
				
				mysql_query("INSERT INTO capital_city (`city_name`, `state_id`, `refresh`, `lat`, `lng`) VALUES ('".$cityname."', '".$stateid."', '1', '".$lat."', '".$lng."')");
				
				$current_city_id = mysql_insert_id();
				
				$_SESSION['id'] = $current_city_id;
			
				$_SESSION['state'] = $stateid;
			
				$_SESSION['country'] = $countryid;
				
				echo "success";				
				
			}else{
				
				$_SESSION['id'] = $cityid;
			
				$_SESSION['state'] = $stateid;
			
				$_SESSION['country'] = $countryid;
				
				echo "success";				
				
			}
			

			session_write_close();
		// }
		
	// }

}

if(isset($_POST['add_photo_inalbum'])){
	
	$check_image_inalbum = mysql_query("SELECT * FROM uploaded WHERE album_id = '".$_POST['album_id']."' AND img_id = '".$_POST['image_id']."'");
	$count_image_inalbum = mysql_num_rows($check_image_inalbum);
	
	if($count_image_inalbum < 1){

		$upd_query = mysql_query("UPDATE uploaded SET album_id = '".$_POST['album_id']."' WHERE img_id = '".$_POST['image_id']."'");
		
		if($upd_query == 1){
			echo "done";
		}
	}
	die;
}

if(isset($_POST['deleteFriends'])){
	
	foreach($_POST['deleteFriends'] as $delete)
	{
		$recordID = $delete;
		$getRecorddetails = mysql_query("SELECT * FROM `friends` WHERE `id` = '$recordID' ");
		$fetchRecorddetails = mysql_fetch_assoc($getRecorddetails);
	// echo "<pre>"; print_r($fetchRecorddetails); echo "</pre>"; die;
		$recordUserid = $fetchRecorddetails['user_id'];
		$recordUsertype = $fetchRecorddetails['user_type'];
		$recordFriendid = $fetchRecorddetails['friend_id'];
		$recordFriendtype = $fetchRecorddetails['friend_type'];

		/* DELETE MAIN RECORD FROM THE TABLE WHERE ID is $recordID */
		mysql_query("DELETE FROM `friends` WHERE `id` = '$recordID' ");

		/* DELETE OPPOSITE RECORD FROM THE OTHER USER Too */
		mysql_query("DELETE FROM `friends` WHERE `user_id` = '$recordFriendid' AND `user_type` = '$recordFriendtype' AND `friend_id` = '$recordUserid' AND `friend_type` = '$recordUsertype' ");
		$_SESSION['friend_records_deleted'] = "Records Deleted Successfully.";
	}
	die;
}

if($_POST['action'] == 'changeWeekday')
{
	$DAY = $_POST['DAY'];
	mysql_query("UPDATE `mysittiTV` SET  `weekDay` = '$DAY' WHERE id = '$_POST[TvvideoID]'  ");
	echo "Week day Updated";
}

if($_POST['action'] == 'changestarttime')
{
	$TIME = $_POST['startTIME'];
	mysql_query("UPDATE `battle_playlist` SET `mySittiTV` = '1', `start_time` = '$TIME' WHERE id = '$_POST[TvvideoID]'  ");
	echo "Start Time Updated";
}


if($_POST['action'] == 'changeendtime')
{
	$TIME = $_POST['endTIME'];
	mysql_query("UPDATE `battle_playlist` SET `mySittiTV` = '1', `end_time` = '$TIME' WHERE id = '$_POST[TvvideoID]'  ");
	echo "End Time Updated";
}

if(isset($_POST['addtoblog']))
{
	if($_POST['check'] == 'yes')
	{
		mysql_query("UPDATE `mysittiBlogvideos` SET `status` = '1' WHERE `id` = '$_POST[addtoblog]' ");
		echo 'Video Added to Blog Videos.';
	}
	else
	{
		mysql_query("UPDATE `mysittiBlogvideos` SET `status` = '0' WHERE `id` = '$_POST[addtoblog]' ");
		echo 'Video Removed From Blog Videos.';
	}


}


if(isset($_POST['remote_address']))
{
	$new_arr= file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=e7e031c8e57941dc09869628855245c5bc0c0fddd890876bdaf69423c1bd864e&ip='.$_POST['remote_address'].'&format=json');
	$result = json_decode($new_arr);
	echo $result->latitude."&details&".$result->longitude; 

	// echo "<pre>"; print_r(json_decode($new_arr));
	die;
}




?>