<?php
if(isset($_GET['notification'])){

	mysql_query("DELETE FROM user_notification WHERE id = '".$_GET['notification']."'");
}
?>
<link rel="stylesheet" href="css/new_portal/jquery.countdown.css"> 
<script src="js/functions.js"></script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>



<!--<script type="text/javascript" src="js-webshim/minified/polyfiller.js"></script>-->
<!--<link rel="stylesheet" href="selectize/examples/js/selectize.default.css">-->
<!--<script  type="text/javascript">	-->
<!--	webshim.polyfill('es5 mediaelement forms');-->
<!--	</script>-->

<!--[if gte IE 9]>
<script type="text/javascript" src="placeholder_n.js"></script>
<![endif]-->

<?php
include('image_upload_resize.php');

include("resize-class.php");


//echo "<pre>"; print_r($_SERVER);echo "</pre>";
if(($_SERVER['SCRIPT_NAME'] != "/profile.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/LiveContest.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/user_shout.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/settingslist.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/view_contestent.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/music_request.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/musicrequestlist.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/user_search.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/host_profile.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/product.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/contestForm.php"))
{
	?>
<script src="js/add.js"></script>
<?php 

}

if(($_SERVER['SCRIPT_NAME'] != "/clubprofile.php")
&& ($_SERVER['SCRIPT_NAME'] != "/profile.php")
&& ($_SERVER['SCRIPT_NAME'] != "/LiveContest.php")
&& ($_SERVER['SCRIPT_NAME'] != "/view_contestent.php")
//&& ($_SERVER['SCRIPT_NAME'] != "/user_search.php")
&& ($_SERVER['SCRIPT_NAME'] != "/user_shout.php")
&& ($_SERVER['SCRIPT_NAME'] != "/host_profile.php")
&& ($_SERVER['SCRIPT_NAME'] != "/product.php")
&& ($_SERVER['SCRIPT_NAME'] != "/contestForm.php")
	  ) { ?>
<script type="text/javascript" src="js/new_portal/smk-accordion.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
	$(".filter123").smk_Accordion({
				closeAble: true, //boolean
		
			});
  });
  </script>
<?php
}


if(($_SERVER['SCRIPT_NAME'] == "/home_club.php")
|| ($_SERVER['SCRIPT_NAME'] == "/dj_home.php")
|| ($_SERVER['SCRIPT_NAME'] == "/band_home.php")
|| ($_SERVER['SCRIPT_NAME'] == "/fight_home.php") 
|| ($_SERVER['SCRIPT_NAME'] == "/extreme_club.php") 
|| ($_SERVER['SCRIPT_NAME'] == "/profile.php") 
|| ($_SERVER['SCRIPT_NAME'] == "/host_profile.php") 
|| ($_SERVER['SCRIPT_NAME'] == "/fighter_profile.php") 
|| ($_SERVER['SCRIPT_NAME'] == "/fighter_home.php") 
|| ($_SERVER['SCRIPT_NAME'] == "/comedy_home.php") 
|| ($_SERVER['SCRIPT_NAME'] == "/extreme_profile.php") 
|| ($_SERVER['SCRIPT_NAME'] == "/theatre_home.php"))
{

	if(isset($_GET['host_id']))
	{
		$userID_stream = $_GET['host_id'];
		$userID_type = 'club';
	}
	elseif(isset($_GET['user_id']))
	{
		$userID_stream = $_GET['user_id'];
		$userID_type = 'user';
	}
	elseif(isset($_GET['id']))
	{
		$userID_stream = $_GET['id'];
		$userID_type = 'user';
	}
	else
	{
		$userID_stream = $_SESSION['user_id'];	
		$userID_type = $_SESSION['user_type'];
	}

// echo "<pre>"; print_r($_SESSION); echo "</pre>";
	if(!isset($_SESSION['launchBY']))
	{

	?>
		<script type="text/javascript">
			$(document).ready(function(){
				setInterval(function()
				{
					$.ajax({
						type: "POST",
						url: "checkStream.php",
						data: {
							'host_id' : '<?php echo $userID_stream; ?>',
							'usertype' : '<?php echo $userID_type; ?>',

						},
						success: function(data){
							//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
							var dd = data.split('++++');
							//alert(dd[0]);
							if($.trim(dd[0]) == "Streaming" )
							{
								
								if($('.play_vid_current').hasClass('changed'))
								{
								
								}
								else
								{
									//$('.play_vid_current').addClass('changed');
									$('.play_vid_current').removeClass('offline_stream').addClass('changed');
									$('.play_vid_current').html($.trim(dd[1]));
								}
							}
							else
							{
								
								if($('.play_vid_current').hasClass('offline_stream'))
								{
								
								}
								else
								{
									$('.play_vid_current').removeClass('changed').addClass('offline_stream');
									$('.play_vid_current').html($.trim(dd[1]));
								}
							}


						}
					});
				}, 6000);
			});
		</script>

	<?php
	}	
}




?>
<script language="javascript" type="text/javascript">
  $(window).load(function() {
	$('#loading').hide();
	
  });

	function claimClub(url)
	{
		window.open(url,'1396358792239','width=500,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
		return false;
	}

</script>
<?php
$ast_url = $_SERVER['REQUEST_URI'];

if (strpos($ast_url,'add_usershout') == false) { ?>
<script type="text/javascript">
		jQuery(document).ready(function($){

			//setTimeout(function() {
					$('.unread').each(function(){
						//alert('4');
						var txt = $(this).text();
						if( (txt =='0'  ) || (txt == '0 ') )
						{
							$(this).css('display','none');
						}

				});
			//}, 1000);
					
			$('input.date,#datetimepicker4').mousewheel(function(event) {
			  
			  
	if ($(event.target).is("input:text")) {
	  $(this).val('');
		return false;  // Target element is a text input, do not initiate drag.
	};
		});
			
			
			$('input.dtpicker').mousewheel(function(event) {
				
				if ($(event.target).is("input:text")) {
				$(this).val('');
				return false;  // Target element is a text input, do not initiate drag.
				};
			});				
			});
	</script>
<?php
}
?>

<!-- sidebar accordion js -->

<!-- sidebar accordion js -->

<?php
$url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if (strpos($url,'forget_pwd.php') || strpos($url,'activation.php') || strpos($url,'thankyou.php')) 
{
	if($_SERVER['SCRIPT_NAME'] == "/thankyou.php")
	{
		if(isset($_GET['action']))
		{
			$style123 = " style = 'display: block'";
		}elseif($_GET['ticket_id']){
			
			$style123 = " style = 'display: block'";
			
		}else
		{
			$style123 = " style = 'display: none'";
		}
	}
	else
	{
		$style123 = " style = 'display: none'";
	}
	
}
  ?>
<style type="text/css">
@media only screen and (max-width:1024px) {
 #loading {
width:100%;
height:100%;
margin:auto;
position:fixed;
left:0;
top:0;
background:rgba(0, 0, 0, 0.8);
right:0;
bottom:0;
z-index:99999999999;
}
.wait {
 bottom: 0;
 height: 80px;
 left: 0;
 margin: auto;
 position: fixed;
 right: 0;
 top: 0;
 width: 80px;
 z-index: 2147483647;
 text-align: center;
 color: #fff;
}
}
</style>
<?php 



if($_SERVER['SERVER_NAME'] == 'localhost')
{
	$site_path = '/mysitti/';
}

$sel = $_SERVER['PHP_SELF'];

session_start();
// echo "<pre>"; print_r($_SERVER); echo "</pre>";
 //echo "<pre>"; print_r($_COOKIE); echo "</pre>";
 //echo "<pre>"; print_r($_SESSION); echo "</pre>";

if((isset($_COOKIE['loggedinuserID'])) )
{
	$userID = $_COOKIE['loggedinuserID'];
	
	if($_COOKIE['loggedinuserType'] == 'user')
	{
		
		$myquery = @mysql_query("SELECT * FROM `user` WHERE `id` = '".$userID."'  ");
		$DataArray1 = @mysql_fetch_array($myquery);
	  

		if($DataArray1['keepmelogin'] == '1')
		{
			
					$plantype = $DataArray1['plantype'];
			$profilename=$DataArray1['profilename'];
			$first_name=$DataArray1['first_name']; 
				$user_address=$DataArray1['user_address']; 
			$last_name=$DataArray1['last_name'];
			$fullname = $first_name." ".$last_name;
			$zipcode=$DataArray1['zipcode'];
			$state=$DataArray1['state'];
			$country=$DataArray1['country'];
			if($DataArray1['DOB']==''){$dob="00/00/0000";} else $dob=$DataArray1['DOB'];
			$city=$DataArray1['city'];
			$email=$DataArray1['email'];
			$image_nm=$DataArray1['image_nm'];
			$phone=$DataArray1['phone'];
			$enablediablephone=$DataArray1['text_status'];
			$_SESSION['img']=$image_nm;
			$_SESSION['user_id'] = $_COOKIE['loggedinuserID'] ; 
			$_SESSION['usercity'] = $city ;
			$_SESSION['username'] = $DataArray1['first_name']."-".$DataArray1['last_name'];
			$_SESSION['profile_name'] = $DataArray1['first_name']." ".$DataArray1['last_name'];

			$_SESSION['user_type'] = 'user';

			//$_SESSION['id']=$DataArray1['city'];// here we are storing city id of logged user
			//$_SESSION['state']=$DataArray1['state']; // here we are storing state id of logged user
			//$_SESSION['country']=$DataArray1['country'];



			//date_default_timezone_set('America/Los_Angeles');
			$current_time= date('Y-m-d H:i:s'); 
			$tdate=date('Y-m-d H:i:s');
		}
		else
		{
			

		}
	
	}
	else
	{
		$myquery = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$_COOKIE['loggedinuserID']."'  ");
		$DataArray1 = @mysql_fetch_array($myquery);
		$user_club = $DataArray1['user_club'];
	
		if($DataArray1['keepmelogin'] == '1')
		{
			$UserLoginId = $DataArray['id'] ;
			$pieces = explode(" ", $DataArray1['club_name']);
			$username_dash_separated1 = implode("-", $pieces);
			$username_dash_separated1 =clean($username_dash_separated1);
			$User = "Club";
			$_SESSION['user_id'] = $_COOKIE['loggedinuserID'] ;
			$_SESSION['user_club'] = $User ;
			$_SESSION['user_type'] = 'club';
			$_SESSION['username'] = $username_dash_separated1 ;
			if(isset($_SESSION['subuser']))
			{
				$q1 = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$DataArray1['club_name']."'  ");
				$f1 = @mysql_fetch_array($q1);

				$_SESSION['img'] =  $f1['user_thumb'] ;
				
			}
			else
			{
				$_SESSION['img'] =  $DataArray1['image_nm'] ;
			}
			
			
			//$_SESSION['id']=$DataArray1['club_city'];// here we are storing city id of logged user
			//$_SESSION['state']=$DataArray1['club_state']; // here we are storing state id of logged user
			//$_SESSION['country']=$DataArray1['club_country'];
			
			$profilename=$DataArray1['club_name'];
			$plantype = $DataArray1['plantype'];
			$typeclub = $DataArray1['type_of_club'];
			$email=$DataArray1['club_email'];
			$club_address=$DataArray1['club_address'];
			$phone=$DataArray1['club_contact_no']; 
			$country=$DataArray1['club_country'];
			$state=$DataArray1['club_state'];
			$club_city=$DataArray1['club_city'];
			$web_url=$DataArray1['web_url'];
			$zipcode=$DataArray1['zip_code'];
			$google_map_url=$DataArray1['google_map_url'];	
			$image_nm  =$DataArray1['image_nm'];
			$_SESSION['username']=$profilename;
			$_SESSION['img']=$image_nm;
			$enablediablephone=$DataArray1['text_status'];



			//date_default_timezone_set('America/Los_Angeles');
			$current_time= date('Y-m-d H:i:s'); 
			$tdate=date('Y-m-d H:i:s');
		}
		else
		{
			
		}
	}
}

function detect_mobile()
{
	/*
	 * commented by kbihm on 19-01-2015
	 if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
	return true;
	 
	else*/
	return false;
}

function detect_mobile_new()
{

	 if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
	return true;
	 
	else
	return false;
}


/* detect_stream added by kbimn on 30-01-2015 */
function detect_stream($hbhost){
	$st_qry = 'ffmpeg -i rtsp://192.163.248.47:1935/live/'.$hbhost.' 2>&1; echo $?';
	//echo $st_qry;
	$st_res=(string)trim(shell_exec($st_qry));
	//echo $st_res;
	//die;
	if (strpos($st_res,'404 Not Found') === false) {
		return true;
	}
	
	return false;

}


function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}





	//die('dfdfdf');
	$userID=$_SESSION['user_id'];
	$user_club=$_SESSION['user_club'];
	if($_SESSION['user_club'] != '')
	{

		$userID = $_SESSION['user_id'];
		$sql = "select * from `clubs` where `id` = '".$userID."'";
		$userArray = $Obj->select($sql) ; 
		$profilename=$userArray[0]['club_name'];
				$plantype = $userArray[0]['plantype'];
		$typeclub = $userArray[0]['type_of_club'];
		$email=$userArray[0]['club_email'];
		$club_address=$userArray[0]['club_address'];
		$phone=$userArray[0]['club_contact_no']; 
		$country=$userArray[0]['club_country'];
		$state=$userArray[0]['club_state'];
		$club_city=$userArray[0]['club_city'];
		$web_url=$userArray[0]['web_url'];
		$zipcode=$userArray[0]['zip_code'];
		$google_map_url=$userArray[0]['google_map_url'];	
		$image_nm  =$userArray[0]['image_nm'];
		$_SESSION['username']=$profilename;
		//$_SESSION['id']=$club_city;
		//$_SESSION['state']=$state;
		//$_SESSION['country']=$country;
		if(isset($_SESSION['subuser']))
		{
			$q1 = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$userArray[0]['club_name']."'  ");
			$f1 = @mysql_fetch_array($q1);

			$_SESSION['img'] =  $f1['user_thumb'] ;
			
		}
		else
		{
			$_SESSION['img'] =  $image_nm ;
		}
		$enablediablephone=$userArray[0]['text_status'];
	}
	else
	{
		$sql = "select * from `user` where `id` = '".$userID."'";
		$userArray = $Obj->select($sql) ; 
		 $plantype = $userArray[0]['plantype'];
		$profilename=$userArray[0]['profilename'];
		$user_address=$userArray[0]['user_address']; 
		$first_name=$userArray[0]['first_name']; 
		$last_name=$userArray[0]['last_name'];
		$fullname = $first_name." ".$last_name;
		$zipcode=$userArray[0]['zipcode'];
		$state=$userArray[0]['state'];
		$country=$userArray[0]['country'];
		if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];
		$city=$userArray[0]['city'];
		$email=$userArray[0]['email'];
		$image_nm=$userArray[0]['image_nm'];
		$phone=$userArray[0]['phone'];
		$enablediablephone=$userArray[0]['text_status'];
		$_SESSION['img']=$image_nm;
		//$_SESSION['id']=$city;
		//$_SESSION['state']=$state;
		//$_SESSION['country']=$country;
	}



/* if host is free type then not access to storepages*/

if(($_SESSION['user_type']=='club' && ($plantype=='host_free' || !$plantype ))){
	if($sel=='/add_product_color.php' || $sel=='/host_product.php' || $sel=='/store.php'  || $sel=='/host_category.php' /*|| $sel=='/host_store.php'*/ || $sel=='/manage_category.php' || $sel=='/manage_product.php' || $sel=='/order_history.php' || $sel=='/report.php' || $sel=='/order_history.php'){
		if($_SESSION['user_type']=='club'){
			 $Obj->Redirect("home_club.php");
		exit;
		   
		
	}
  }
}else if(($_SESSION['user_type']=='user' && ($plantype=='free' || !$plantype))){
	
 if($sel=='/add_product_color.php' || $sel=='/host_product.php' || $sel=='/store.php'  || $sel=='/host_category.php'  || $sel=='/manage_category.php' || $sel=='/manage_product.php' || $sel=='/order_history.php' || $sel=='/report.php' || $sel=='/order_history.php'){
	 $Obj->Redirect("home_user.php");
	 exit;
} }
if(!$_SESSION['user_id']){
	if($sel=='/add_product_color.php' || $sel=='/host_product.php' || $sel=='/store.php'  || $sel=='/host_category.php' || $sel=='/host_store.php' || $sel=='/manage_category.php' || $sel=='/manage_product.php' || $sel=='/order_history.php' || $sel=='/report.php' || $sel=='/order_history.php'){
	 $Obj->Redirect("index.php");
	 exit;
}}

// facebook settings
  $fc_sql = "select * from social_settings where `id` = '1'";
 $fcArray = $Obj->select($fc_sql) ; 
 $fcaccount_name=$fcArray[0]['account_name'];
$fcstatus=$fcArray[0]['status']; 
$fcurl=$fcArray[0]['url']; 
 // end here 
 // twitter settings
  $t_sql = "select * from social_settings where `id` = '2'";
 $tArray = $Obj->select($t_sql) ; 
 $taccount_name=$tArray[0]['account_name'];
$tstatus=$tArray[0]['status']; 
$turl=$tArray[0]['url']; 
 // end here 
 // you tube  settings
  $u_sql = "select * from social_settings where `id` = '3'";
 $uArray = $Obj->select($u_sql) ; 
 $uaccount_name=$uArray[0]['account_name'];
$ustatus=$uArray[0]['status']; 
$uurl=$uArray[0]['url']; 
 // end here 
 $num_rw=1;



 // if(!isset($_SESSION['id']))
 // {
 // 	if($_SESSION['user_type'] == 'user')
 // 	{
 // 		$_SESSION['id']= $_SESSION['usercity'];
 // 	}
 // 	else
 // 	{
 // 		$_SESSION['id']= $_SESSION['city'];
 // 	}
	
 // }


 if(isset($_POST['search']))
{
//echo "<pre>"; print_r($_POST); exit;

	if(isset($_POST['city_name']) || isset($_POST['city_name_jquery']))
	{
		
		if(!empty($_POST['city_name_jquery']))
		{
			
				$jquery_city = @mysql_query("SELECT city_id FROM capital_city WHERE state_id = '".$_POST['state']."' AND city_name = '".$_POST['city_name_jquery']."'");
				
				$jquery_city_rows = mysql_num_rows($jquery_city);
				
				if($jquery_city_rows == 1){
					
					
					$get_jquery_city_id = mysql_fetch_assoc($jquery_city);
					$city = $get_jquery_city_id['city_id'];
					
				}
				else
				{ 
			?>
					<script type="text/javascript">
						alert("city does not exist");
						window.location.href="";
					</script>
<?php 					die; 
				}
				
		}
		else
		{
				

			$city = $_POST['city_name'];
		}
		
		$user_type = $_SESSION['user_type'];
		$user_id = $_SESSION['user_id'];
		$d_city_status = $_POST['default_city'];
		$country = $_POST['country'];
		$state = $_POST['state'];
		if($d_city_status == 'on')
		{
			//die('dddd');
			$check_d_city_status = @mysql_query("SELECT * FROM default_city_selected WHERE user_id = '".$user_id."' AND user_type = '".$user_type."'");
			$check_d_city_rows = mysql_num_rows($check_d_city_status);
		
			if($check_d_city_rows < 1){
				
				$insert_d_city = @mysql_query("INSERT INTO default_city_selected (`user_id`, `user_type`, `country`, `state`, `city`, `d_city_status`) VALUES ('".$user_id."', '".$user_type."', '".$country."', '".$state."', '".$city."', '".$d_city_status."')");
				
			}else{
				
				$update_d_city = @mysql_query("UPDATE default_city_selected SET `country` = '".$country."', `state` = '".$state."', `city` = '".$city."', `d_city_status` = '".$d_city_status."' WHERE user_id = '".$user_id."' AND user_type = '".$user_type."' ");
				
			}
		}

		if(trim($_POST['zipcode'])!="")
		{

			$zipcode = $_POST['zipcode'];
			$address = str_replace(" ", "", $zipcode);
			$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			//echo "<pre>"; print_r($response_a); die('dddd');
			$lat = $response_a->results[0]->geometry->location->lat;
			$long = $response_a->results[0]->geometry->location->lng;	

			$i = 0;

			foreach($response_a->results[0]->address_components as $abc)
			{
				if($abc->types[0] == "country")
				{
					$country = $response_a->results[0]->address_components[$i]->long_name;
				}
				
				if($abc->types[0] == "administrative_area_level_1")
				{
					$state = $response_a->results[0]->address_components[$i]->long_name;
				}

				if($abc->types[0] == "locality")
				{
					$city = $response_a->results[0]->address_components[$i]->long_name;
				}


				$i++;


			}
			
			$zip_city = "SELECT `city_id`,`city_name` FROM `capital_city` WHERE  `city_name`= '$city'   " ;
			$zip_city_Array = @mysql_query($zip_city);
			$num_rw=@mysql_num_rows($zip_city);
			if($num_rw > 0){
				$city_get=@mysql_fetch_array($zip_city_Array);
				$_SESSION['id']=$city_get['city_id'];
				$_SESSION['state']=$_POST['state']; 
				$_SESSION['country']=$_POST['country']; 
			 
			}
		}
		else
		{
			$num_rw=1;
			
			if(!empty($_POST['city_name_jquery']))
			{
						
				$jquery_city = @mysql_query("SELECT city_id FROM capital_city WHERE state_id = '".$_POST['state']."' AND city_name = '".$_POST['city_name_jquery']."'");
				
				$jquery_city_rows = mysql_num_rows($jquery_city);
				
				if($jquery_city_rows == 1)
				{
					
					
					$get_jquery_city_id = mysql_fetch_assoc($jquery_city);
					$_SESSION['id'] = $get_jquery_city_id['city_id'];
					$_SESSION['country']=$_POST['country'];
					$_SESSION['state']=$_POST['state'];
				}
				else
				{
		?>
					<script type="text/javascript">
						alert("city does not exist");
						window.location.href="";
					</script>
	<?php 				die; 
				}
							
			}
		}
	}



	unset($_COOKIE["backgroundcookie"]);
	setcookie('backgroundcookie', null, -1, '/');

	$cityid = $_SESSION['id'];
	// echo "SELECT * FROM `capital_city` WHERE `city_id` = '".$cityid."' ";
	$getcityname = @mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '".$cityid."' ");
	$fetchcity = @mysql_fetch_array($getcityname);
	$city = trim($fetchcity['city_name']);

	$city_sel = @mysql_query("SELECT city_image_id FROM refresh_background WHERE city_name = '".$city."' AND refresh_status = '1' ORDER BY RAND() LIMIT 0,1");

	$count_img = mysql_num_rows($city_sel);

	if($count_img > 0)
	{

		$rowwww = mysql_fetch_assoc($city_sel);

		$set_image = @mysql_query("SELECT city_image_url FROM capital_city_images WHERE city_image_id = '".$rowwww['city_image_id']."'");

		$get_data = mysql_fetch_assoc($set_image);

		$imagesrcback =  "/admin/cities/".$get_data['city_image_url'];

		?>
<style type="text/css">
.home_wrapper {
	background-image: url('<?php echo $imagesrcback; ?>');
}
</style>
<?php
		$intervalq = @mysql_query("SELECT * FROM `refresh_background_time`");
		$intervalf = @mysql_fetch_array($intervalq);

		ob_start();
		setcookie("backgroundcookie", $imagesrcback,time() + (60 * $intervalf['time_interval'] ) );
		ob_end_clean();

	}

}



			// get default state and city from  sessions 
			 $countrysql1="select zone_id,name,code from zone where   zone_id ='".$_SESSION['state']."'";
			 $country_list1 = mysql_query($countrysql1);
			 $row_state = @mysql_fetch_array($country_list1);
			 
	  $city_n=mysql_query("select city_id,city_name,city_id from capital_city where state_id='".$_SESSION['state']."' and city_id ='".$_SESSION['id']."'");
			
			 $row_city_name = mysql_fetch_array($city_n);
			
			/* CLUBS SHOUTS COUNT */
			if(isset($_SESSION['subuser']))
			{
				$fetchhostquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$_SESSION['username']."' ");
				$fetres = @mysql_fetch_array($fetchhostquery);
				$user_id1 = $fetres['host_id'];
			}
			else
			{
				$user_id1 =  $_SESSION['user_id'];	
			}


			$shoutsql="select * from shouts where user_id='".$user_id1."' AND `user_type` = 'club' ";
			$shout_list = mysql_query($shoutsql);
			$countclubsshout = @mysql_num_rows($shout_list);
			/* END HERE*/

			/* CLUBS BOOKINGS COUNT */
			$bookingsql="select * from bookings where host_id='".$_SESSION['user_id']."' ";
			$booking_list = mysql_query($bookingsql);
			$countclubsbookings = @mysql_num_rows($booking_list);
			/* END HERE*/

			 
			 // end here 
		// counnt looged user shout
		   $shout_cont=mysql_query("select s.id from friends as f 
			left join shouts as s on(f.friend_id=s.user_id)
			left join user as u on(u.id=s.user_id)  
			 where f.user_id='".$_SESSION['user_id']."' AND s.user_type='user' AND  f.status='active' AND s.is_read='0' order by s.id DESC ");
			  $tot_shout=@mysql_num_rows($shout_cont); 
			 
		// end here  
		
$userType= $_SESSION['user_type'];

		//  unread contest
			   $sql_cnt="select id from user_to_content where user_id='".$_SESSION['user_id']."' AND user_type = '".$userType."'  AND cont_type='content' AND is_read='0' AND owner_id!='".$_SESSION['user_id']."' group by  cont_id";	
			   $cont_cnt = mysql_query($sql_cnt);
				$tot_con=@mysql_num_rows($cont_cnt);  
		// end here 
		// total contest 
		   //$sql_total="select id from user_to_content where user_id='".$_SESSION['user_id']."' AND user_type = '".$userType."'  AND cont_type='content'  group by  cont_id";
		   
		   $sql_total = "select c.*,uc.is_read,uc.owner_id from user_to_content as uc 
	 left join  contest as c on(c.contest_id=uc.cont_id) 
	 where uc.user_id='".$_SESSION['user_id']."' AND cont_type='content' AND c.contest_id != 'NULL' group by uc.cont_id ORDER BY c.addedOn DESC";
	 
		   $cont_total = mysql_query($sql_total);
			$total_con=@mysql_num_rows($cont_total);  
		// end here 
		
		//  unread contest
			   $sql_cnt_s="select id from user_to_content where user_id='".$_SESSION['user_id']."' AND  owner_id != '".$_SESSION['user_id']."'  AND cont_type='shout' AND is_read='0' group by  cont_id";	
			   $cont_cnt_s = mysql_query($sql_cnt_s);
				$ur_con_s=@mysql_num_rows($cont_cnt_s);  
		// end here 
		// total contest 
		   $sql_total_s="select id from user_to_content where user_id='".$_SESSION['user_id']."' AND  cont_type='shout'  group by  cont_id";	
		   $cont_total_s = mysql_query($sql_total_s);
			$total_con_s=@mysql_num_rows($cont_total_s);  
		// end here 
	
	include("user_upgrade.php");
?>
<script type="text/javascript">
function reportabuse(fid)
{
	$.get( "report-abouse.php?forum_id="+fid, function( data ) {
		if(data=='false')
		{
			$('#report_error_'+fid).html('You already sent abuse report for this forum.');
			$('#report_error_'+fid).fadeOut(5000);

		}
		else
		{
			$('#report_send_'+fid).html('Abuse report sent to admin');
			$('#report_send_'+fid).fadeOut(5000);
		}

	});
}


<!--//---------------------------------+
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use
// --------------------------------->
$(document).ready(function()
{

	/**** remove notification icon if notification is 0*/ 
	var notification = $('#nav .unread').text();
	var con = parseInt(notification);
	var notification2 = $('#pic2 .unread').text();
	var con2 = parseInt(notification2);
	
	var val = "0";
	if(con == val && con2 == val)
	{
	   $('#nav .unread').remove();
	   $('#pic2 .unread').remove();
	}	
	/**** remove notification icon if notification is 0*/
	
	/***add activ class *****/
	//$('ul.listing li').click(function()
	//			    {
	//				     alert('11111121');
	//				    //$(this).addClass('selected').siblings();
	//				$('ul.listing li').removeClass('active');
	//				$(this).addClass('active');
	//				return false;
	//			    });
	/***add activ class *****/
	
	var getlocation = $(location).attr('href');
	
	var explodeurl = getlocation.split('.com/');
	$('#home-left-nav li').each(function(){
		var anchorli = $(this).find('a').attr('href');
		if (anchorli == explodeurl[1]) {
			//code
			$(this).addClass('current');
		}
	});
	
	$('#section-1 nav ul li').each(function(){
		
		var anchorli = $(this).find('a').attr('href');
		if (anchorli == explodeurl[1]) {
			$(this).addClass('active');
			if ($(this).parent().parent('li')) {
				$(this).parent().parent('li').addClass('active');
			 }
		}
		else
		{
			if($(this).hasClass('active'))
			{
				$(this).removeClass('active');
			}
		}
	});
//	
//	setTimeout(function() {
//      // Do something after 5 seconds
//	  $('.message').fadeOut('slow');
//	  
//	}, 5000);

	
	
	
	

	//slides the element with class "menu_body" when paragraph with class "menu_head" is clicked 
	$("#firstpane p.menu_head").click(function()
	{
		$(this).css({backgroundImage:"url(down.png)"}).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
		$(this).siblings().css({backgroundImage:"url(left.png)"});
	});
	//slides the element with class "menu_body" when mouse is over the paragraph
	$("#secondpane p.menu_head").mouseover(function()
	{
		 $(this).css({backgroundImage:"url(down.png)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
		 $(this).siblings().css({backgroundImage:"url(left.png)"});
	});

	

	$(document).click(function (e) {
		if ($(e.target).closest('#Search_box').length > 0 || $(e.target).closest('#toggle-menu').length > 0) return;
		//$('#Search_box').slideUp(200);
	});


 //    $('.test').click(function(){
	//     var id=$(this).attr('id');
	// 	var audio = document.getElementById('player'+id);
	// 	play1(audio);

	// });

	$('.audio').click(function(){
		$(this).addClass('pause');
		var id=$(this).attr('id');
		var audio = document.getElementById('player'+id);
		play1(audio);

	});

	$('.pause').click(function(){
	  
		$('.test').removeClass('pause');
		var id=$(this).attr('id');

		var audio = document.getElementById('player'+id);
		pause(audio);

	});




});
function getempty()
{
	$('#zipcode').val("");
}

function play1(audio){

	audio.currentTime = 0;
	audio.play();
	int = setInterval(function() {       
		if (audio.currentTime > 20) {
			audio.pause();

			clearInterval(int);
		}
	}, 30);
}    
	
	
function pause(audio){
	audio.pause();
}

 function sendsession(id)
{ 
 $.get('send-invite.php?user_id='+id, function(data) {
  window.location='camstart.php?'+data;
});

}
function goto(url)
{
	window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
	return false;
}
</script>
<script>
$(document).ready(function(){
	
  $("input.menu1").click(function(){
  	//alert('ssss');
	$("nav").toggle( "slide" );
  });
	$(".menu2").click(function(){
	
		if($('.sidebar_menuM').hasClass('yourClass'))
		{
		   // $(".sidebar_menuM").slideDown();
			$(".sidebar_menuM").removeClass( "yourClass" );
		}
		else
		{
		//$(".sidebar_menuM").slideUp();
			$(".sidebar_menuM").addClass( "yourClass" );
		}

  });
});

function show_all_comments(id){
  
  if ($('#num_comments_'+id).val() == 0) {
	
	alert("No comment found");
	return false;
  }else{
		
	$('.hide_replies_'+id).show();
	$('.hide_'+id).show();
	
	$('#show_cm_'+id).hide();
	$('#hide_cm_'+id).show();
	$('#set_show_val_'+id).val('1');
  }
}

function hide_all_comments(id){
  
		//var id = $(this).attr('id');
		//var test = id.split('show_count_comments_');
		
		//$('.hide_replies_'+test[1]).toggle();
		
		$('.hide_replies_'+id).hide();
		$('.hide_'+id).hide();
		//var cnt = $('#num_comments_'+test[1]).val();
		//
		//if ($('#'+id).hasClass('hidden_all_comments')) {
		//  
		//	$('#'+id).html('<div class="box3">Show comments: '+cnt+'</div>').removeClass('hidden_all_comments');
		//}else{
		//	$('#'+id).html('<div class="box3">Hide comments: '+cnt+'</div>').addClass('hidden_all_comments');
		//	
		//}
	
	$('#show_cm_'+id).show();
	$('#hide_cm_'+id).hide();
	$('#set_show_val_'+id).val('0');
}
</script>
<style>
.yourClass {
	display:block !important;
}
</style>
<?php 
function getLnt($zip)
{
	//$url = "http://maps.googleapis.com/maps/api/geocode/json?address=
	//".urlencode($zip)."&sensor=false";
	$result_string = @file_get_contents($url);
	$result = json_decode($result_string, true);
	$result1[]=$result['results'][0];
	$result2[]=$result1[0]['geometry'];
	$result3[]=$result2[0]['location'];
	return $result3[0];
}

error_reporting(0);

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
 

  $theta = $lon1 - $lon2;

  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));

  $dist = acos($dist);

  $dist = rad2deg($dist);

  $miles = $dist * 60 * 1.1515;

  $unit = strtoupper($unit);

 

  if ($unit == "K") {
		
		$d_cal = $miles * 1.609344;
		$val = round($d_cal , 2);

	return $val;

  } else if ($unit == "N") {
		
		$d_cal = $miles * 0.8684;
		$val = round($d_cal , 2);

	  return $val;

	} else {
		
		$val = round($miles , 2);

		return $val;

	  }

}

function getDistance($zip1, $zip2, $unit)
{
	
	$first_lat = getLnt($zip1);
	$next_lat = getLnt($zip2);
	$lat1 = $first_lat['lat'];
	$lon1 = $first_lat['lng'];
	$lat2 = $next_lat['lat'];
	$lon2 = $next_lat['lng']; 
	
	$theta=$lon1-$lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
	cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
	cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	
	if ($unit == "K"){
	return ($miles * 1.609344)." ".$unit;
	}
	else if ($unit =="N"){
	return ($miles * 0.8684)." ".$unit;
	}
	else{
	return $miles." ".$unit;
	}
}
define(FB_APP_ID, '688073574590787');

if (isset($_SESSION['fb_' . FB_APP_ID . '_code'])) {
	unset ($_SESSION['fb_' . FB_APP_ID . '_code']);
}
if (isset($_SESSION['fb_' . FB_APP_ID . '_access_token'])) {
	unset ($_SESSION['fb_' . FB_APP_ID . '_access_token']);
}
if (isset($_SESSION['fb_' . FB_APP_ID . '_user_id'])) {
	unset ($_SESSION['fb_' . FB_APP_ID . '_user_id']);
}


?>
<div class="side_social">
  <ul>
	<li><a target="blank" href="https://www.facebook.com/mysitti">Facebook <img src="images/fb_side.png"></a></li>
	<li><a target="blank" href="https://twitter.com/MysittiCom">Twitter <img src="images/tw_side.png"></a></li>
	<li><a target="blank" href="https://plus.google.com/u/0/111065459897703066867/about">Google+ <img src="images/google_side.png"></a></li>
	<li><a target="blank" href="https://play.google.com/store/apps/details?id=com.pack.anmysitti&hl=en">Android <img src="images/android-icon.png"></a></li>
	<li><a href="https://itunes.apple.com/us/app/mysitti/id976124654?ls=1&mt=8">IOS <img src="images/apple-icon.png"></a></li>
	<li><a target="blank" href="support.php"> Support <img src="images/info-icon.png"></a></li>
  </ul>
</div>
<header id="section-1">

<!-- <input type="button" class="menu" value="Menu" /> -->
<input type="button" class="menu1" value="Menu" />
<a href="index.php" class="homebtn"><img src="images/go-home.png" /></a>
<nav <?php echo $style123; ?>>
  <?php

if(isset($user_club))
{
?>
  <a class="toplogo" href="home_club.php" style=""><img src="images/toplogo.png"> </a>
  <ul>
	<?php if(isset($_SESSION['subuser'])) { ?>
	<!--<li class="active"><a href="musicrequestList.php">Music Request</a></li>-->
	<li><a target="_blank" href="live2/">Go Live</a></li>
	<li><a href="shout.php" class="fl" style="padding-right:0px">(<?php echo $countclubsshout; ?>)  Shouts </a></li>
	<li> <a href="musicrequestList.php"> Jukebox
	  <?php  	
					$jukeboxreqquery = @mysql_query("SELECT * FROM `userplaylist` WHERE host_id='".$_SESSION['user_id']."' AND `status` = '1' ");
					$jukeboxreqfetch = @mysql_fetch_array($jukeboxreqquery);
					$countjukeboxreq = @mysql_num_rows($jukeboxreqquery);
					if($countjukeboxreq > 0 ) 
					{ ?>
	  <div class="unread fl" style=""> <?php echo $countjukeboxreq;?> </div>
	  <?php 	} ?>
	  </a></li>
	<?php }else{?>
	<!-- <li class="active"><a href="home_club.php">Home</a></li> -->
	<li><a  href="forum.php">City Events</a></li>
	<li><a  href="city_talk.php">City Talk</a></li>
	<!-- <li><a target="_blank" href="live2/">Go Live</a></li> -->

	<li id="navcontests" <?php if ((preg_match("/\bmysitti_contestsList.php\b/i", $sel)) || (preg_match("/\bcurrent_host_contests.php\b/i", $sel) ) ) {?> class="selected none"<?php }?>><a href="/mysitti_contestsList.php">Contests</a>
		<? 
		if($_SESSION['user_id'])
		{
			$sbmnu="sub_menu";
		}
		else
		{
			$sbmnu="sub_menunotlogin";
		}?>
		<ul class="<? echo $sbmnu;?>">
			<li><a href="live_host_contests.php">Live Contests</a></li>
			<li><a href="mysitti_contestsList.php">mySitti Contests</a></li>
			
		</ul>
	</li>
	<li><a  href="live2/battle.php">Live Battle</a></li>
	<?if($_SESSION['user_type']=='club' /*&& $plantype!='host_free'*/ ){?>
	<li id="navcontests"> <a href="/store.php">Store</a>
	  <ul class="sub_menunotlogin">
		<li> <a href="manage_order.php" style="text-transform:uppercase" class="button">Orders</a> </li>
		<li> <a href="order_history.php" style="text-transform:uppercase" class="button">Orders History</a> </li>
		<li> <a href="manage_product.php" style="text-transform:uppercase" class="button">Products</a> </li>
		<li> <a href="manage_category.php" style="text-transform:uppercase" class="button">Categories</a> </li>
		<li> <a href="host_store.php" style="text-transform:uppercase" class="button">User View Store</a> </li>
	  </ul>
	</li>
	<? }?>
	<?php } ?>
  </ul>
  <?php

}
else
{ ?>
  <a class="toplogo" href="home_user.php" style=""><img src="images/toplogo.png"> </a>
  <ul>
	<li <?php if (preg_match("/\bhome_user.php\b/i", $sel)){?> class="selected none"<?php }?>><a href="home_user.php">City Events</a></li>
	<li><a  href="city_talk.php">City Talk</a></li>
	<li id="navcontests" <?php if ((preg_match("/\bmysitti_contestsList.php\b/i", $sel)) || (preg_match("/\bcurrent_host_contests.php\b/i", $sel) ) ) {?> class="selected none"<?php }?>><a href="/mysitti_contestsList.php">Contest</a>
	  <? if($_SESSION['user_id']){
		  $sbmnu="sub_menu";
		  }else{
			  $sbmnu="sub_menunotlogin";
			  }?>
	  <ul class="<? echo $sbmnu;?>">
	  	<li><a href="live_host_contests.php">Live Contests</a></li>
		<li><a href="mysitti_contestsList.php">mySitti Contests</a></li>
		<!-- <li><a href="current_contests.php">Host Contests</a></li> -->
		<li><a href="current_host_contests.php">Host Contests</a></li>
		
		<!-- <li><a href="upcoming_contests.php">Upcoming City Contest</a></li> -->
	  </ul>
	</li>
	<li><a  href="live2/battle.php">Live Battle</a></li>
	<!-- <li <?php if (preg_match("/\ball_live_cam.php\b/i", $sel)){?> class="selected none"<?php }?>> <a href="all_live_cam.php">Live Streaming</a> </li> -->
	
  </ul>
  <?php }
  include('notifications.php');
   ?>
  
  
  
</nav>
<?php 

  // echo "12<pre>"; print_r($_SESSION); echo "</pre>";
			if($_SESSION['user_id'] != "")
			{

  ?>
<input type="button" class="menu2" value="" />
<div class="sidebar_menuM">
  <?php
	if(isset($_GET['id']) && $_SERVER['SCRIPT_NAME'] == "/profile.php")
	{
			$rq_f=@mysql_query("select id from friends where friend_id='".$_SESSION['user_id']."' AND status='pending'");
			$f_req=@mysql_num_rows($rq_f);
			// end here 

			$myquery = @mysql_query("SELECT * FROM `user` WHERE id ='".$_GET['id']."'  ");
			$getchuser = @mysql_fetch_array($myquery);
			?>
  <aside class="sidebar">
	<div class="profileleft">
	  <div class="side_profile">
		<h1>Profile</h1>
		<ul>
		  <div style="float:none;" class="UseroneBox">
			<?php if($getchuser['image_nm']!="")
													{   ?>
			<a href="/profile.php"> <img src="<?php echo $getchuser['image_nm']; ?>" width="130" height="158"  alt='img' /></a>
			<?php 
													} 
													else 
													{ ?>
			<a href="/profile.php"> <img src="images/man4.jpg" /></a>
			<?php 
													} ?>
			<div class="uname" style="font-size:18px; color:white;"> <?php echo $getchuser['first_name']." ".$getchuser['last_name']; ?> </div>
		  </div>
		  <ul class="reset listing">
			<li><a href="profile.php?id=<?php  echo $_GET['id']; ?>"> Profile </a> </li>
			<? 
													  
													 /*  $rq_f=@mysql_query("select id from friends where user_id='".$_GET['id']."' AND friend_id='".$_SESSION['user_id']."' AND status='active'  AND  close_friend='1'");
														  $f_req=@mysql_num_rows($rq_f);
														  if($f_req){
														   ?>
			<li><a href="private_zone.php?id=<?php  echo $_GET['id']; ?>"> Clique </a> </li>
			<? }else{ ?>
			<li onclick="javascript:alert('You are not allow to view my Clique page')" >Clique <span class="lockimage"><img src="images/lock.png"></span></li>
			<?php } */?>
			<li> <a href="user_challenge.php?id=<?php  echo $_GET['id']; ?>"> Challenge </a></li>
			<li><a href="<?php  if($_SESSION['user_type'] == "user"){ echo 'profile.php';}else{ echo 'home_club.php';}?>"> Back to Home Page </a> </li>
			<li class="logbutton12"> <a id="logouta"  href="main/logout.php">Log Out</a> </li>
		  </ul>
		</ul>
	  </div>
	</div>
  </aside>
  <?php 
					}
					else
					{



						if($_SESSION['user_type'] == 'user')
						{
							if(isset($_GET['host_id']))
							{
								?>
  <script>
									

									function savehost(id,ac)
									{
										
										$.ajax({
											type: "POST",
											url: "savehost.php",
											data: {
												'host_id' : id,
												'action' : ac,
											},
											success: function(data){
												window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;

											}
										});

									return false;

									}
									</script>
  <?php
									if($hostID == "")
									{
										$hostID = $_GET['host_id']; 
									}

									 $sql = "select * from `clubs` where `id` = '".$hostID."'";
									$userArray = $Obj->select($sql) ; 
									$first_name=$userArray[0]['club_name']; 
									$zipcode=$userArray[0]['zip_code'];
									$state=$userArray[0]['club_state'];
									$country=$userArray[0]['club_country'];
									$city=$userArray[0]['club_city'];
									$web_url=$userArray[0]['web_url'];

									$email=$userArray[0]['club_email'];
									$image_nm=$userArray[0]['image_nm'];
									$phone=$userArray[0]['club_contact_no'];
									$plantype = $userArray[0]['plantype'];
									if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];

									$club_address=$userArray[0]['club_address'];
									$club_city=$userArray[0]['club_city'];
									$club_name=$userArray[0]['club_name'];
									$type_of_club =$userArray[0]['type_of_club'];
									$type_details_of_club=$userArray[0]['type_details_of_club'];
									$google_map_url=$userArray[0]['google_map_url'];
									$profileCounter =$userArray[0]['profile_count'];
									$q_stat=mysql_query("select name,code from zone where zone_id='$state'");	
									$q_res_stat = mysql_fetch_array($q_stat);
									$stat_ans=$q_res_stat['code'];

									$q_city=mysql_query("select city_name,city_id  from capital_city where city_id='$club_city'");	
									$q_res_city = mysql_fetch_array($q_city);
									$city_ans=$q_res_city['city_name'];

									/* FOR COUPON */

									$sql_fe=mysql_query("select * from  host_coupon where host_id='".$hostID."'");
									$rw_row_fe=@mysql_fetch_assoc($sql_fe);
									/// end here 

									// get user info about download current pass or not 
									 $download_info=@mysql_query("select id  from   coupon_download where coupon_id='".$rw_row_fe['id']."' AND user_id='".$_SESSION['user_id']."' ");
									  $download_num=@mysql_num_rows($download_info);
									 // end here 
									   // get total count of downloaded coupon
									  $tot_cu_cnt=@mysql_query("select id from  coupon_download where coupon_id='".$rw_row_fe['id']."' ");
									  $cu_num=@mysql_num_rows($tot_cu_cnt);

									/*****/




									// check for host 
									  $host_details=@mysql_query("select status from  friends where friend_id='".$hostID."' AND user_id='".$_SESSION['user_id']."' AND friend_type='club'");
									  $club_dtl=@mysql_fetch_assoc($host_details);
									 if(!empty($_POST['state']))
									{ 
									  $sql="SELECT * FROM `contest` where `status`='1' and contest_city='".$city."' ORDER BY `contest_id` AND user_id = 0 AND host_id = '$userID' DESC limit 1";
									}
									else{
									 // $cityid = $_SESSION['id'];
									  //$date = date('Y-m-d');
									  $sql="SELECT * FROM `contest` where `status`='1' AND `contest_end` > '$date'  AND contest_city='".$cityid."'  ORDER BY `contest_id` AND host_id = '$userID' AND user_id = 0 DESC limit 1";
									}

									  $contest_list = $Obj->select($sql);

									  $contest_id=$contest_list[0]['contest_id'];
									  $contest_title=$contest_list[0]['contest_title']; 
									// 
									?>
  <aside class="sidebar">
  <div class="user-profle">
	<div style="font-size: 18px; color: white; float: left; width: 100%; margin-top: 10%;"> <?php echo $club_name; ?> </div>
	<div class="hostsideimage"> <a href="<?php echo $web_url; ?>" target="_blank">
	  <? if($image_nm!="")
													 { ?>
	  <a href="/home_club.php"> <img src="<?php echo $image_nm; ?>" height="157" width="135" /></a><br />
	  <?php } else { ?>
	  <a href="/home_club.php"><img src="images/man4.jpg"></a>
	  <?php } ?>
	  </a> </div>
	<div class="hostaddress">
	  <div class="addressinfo"> <?php echo $club_address;?><br/>
		<?php echo $phone;?><br/>
		Web Site: &nbsp; <a href="<?php echo $web_url; ?>" target="_blank"> <?php echo $web_url; ?> </a> </div>
	  <div class="hostmap"> <a href="javascript:void(0);" onclick="goto('view-map.php?add=<?php echo $hostID;?>');"><img  src="images/map-marker.png"></a> </div>
	  <div class="profileCounter">
				Profile Views: <span><?php echo $profileCounter;?></span>
	</div>
	</div>
  </div>
  <div class="side_profile">
	<h1><?php echo $club_name;?> Profile</h1>
	<div class="unblockalgn">
	  <div class="webcambutton">
		<? if($data_upgrade1['plantype'] == "")
		{
			$data_upgrade1['plantype'] = "host_free";
		}
		else
		{
		  $data_upgrade1['plantype'] = $data_upgrade1['plantype'];
		}
		$data_upgrade_needed=chk_upgrade_needed($data_upgrade1['plantype'],"9");
		$pieces = explode(" ", $club_name);
		$club_name_dash_separated = implode("-", $pieces);
		$club_name_dash_separated  = clean($club_name_dash_separated);
	/*	if($data_upgrade_needed){?>
<a onclick="alert('This Host does not have this feature in his Suscribed Plan!');" class="button"> Live Streaming</a>
		<?}else{*/?>
		<a href="javascript: void(0);" onclick="goto('live2/channel.php?n=<?php echo $club_name_dash_separated;?>')" class="button">Live Streaming</a>
		<? //} ?>
	  </div>
	  <div class="blockhostbutton">
		<?php if(isset($_SESSION['user_id'])) { ?>
		<?php if($club_dtl['status']=='active') { ?>
		<a id="block" href="javascript:void(0)" class="button" onclick="savehost('<?php echo $hostID;?>','block')">Followed</a> 
		<!-- <input type="submit" id="block" class="button" value="Block Host" name="submit" onclick="savehost('<?php //echo $hostID;?>','block')"> -->
		<?php }else if($club_dtl['status']=='block') { ?>
		<a id="unblock" href="javascript:void(0)" class="button" onclick="savehost('<?php echo $hostID;?>','unblock')">Followed</a> 
		<!-- <input type="submit" id="unblock" class="button" value="Un Block" name="submit" onclick="savehost('<?php //echo $hostID;?>','unblock')"> -->
		<?php }else {  ?>
		<input type="submit" id="request" class="button" value="Save Host" name="submit" onclick="savehost('<?php echo $hostID;?>','request')">
		<?php } }?>
	  </div>
	</div>
	<hr>
	<ul class="reset listing" id="home-left-nav" style="margin: 0px;">
		<li><a href="hostdj_profile.php?host_id=<?php echo $hostID; ?>"> Bio</a></li>
		<li><a href="clubprofile.php?host_id=<?php echo $hostID; ?>"> Blog</a></li>
		<li><a href="upload_photo.php?host_id=<?php echo $hostID; ?>"> Photos</a></li>
		<li><a href="upload_video.php?host_id=<?php echo $hostID; ?>"> Videos</a></li>
		<li><a href="eventscalendar.php<? if(isset($_GET['host_id'])){ echo "?host_id=".$_GET['host_id'];}?>"> Calendar </a></li>
		<li><a href="listevent.php<? if(isset($_GET['host_id'])){ echo "?host_id=".$_GET['host_id'];}?>"> Upcoming Events</a></li>
		<li style="float: left;" id="back_none" class="firstheading prvtzone">
			<div class="prvtzonedv">
				<h4 class="prvtzoneh4"> Promotions</h4>
			</div>
		</li>
	  	<li><a href="all_contests.php?host_id=<?php echo $hostID; ?>">Contest </a></li>
	  <?php if($rw_row_fe['coupon_image']) { ?>
	  	<li>
		<?php if($rw_row_fe['max_download']==$cu_num) { ?>
		<a id="d_pass_ex"   onclick="javascript:alert('No more pass available to download');" >Download Pass</a>
		<?php }else { ?>
		<a id="d_pass"  name="submit" <?php if($download_num <= 0){ ?>onclick="$('#d_pass_ex').show();$('#d_pass').hide();window.location='download.php?filename=upload/coupon/<?php echo $rw_row_fe["coupon_image"];  ?>&host_id=<?php echo $rw_row_fe["host_id"]; ?>&c_id=<?php echo $rw_row_fe["id"]?>' "
	  	<?php }else{ ?> onclick="javascript:alert('You Already Downloaded This Pass');" <?php } ?> style=""> Download Pass</a>
		<?php  }  ?>
		<a id="d_pass_ex" onclick="javascript:alert('You Already Downloaded This Pass');" style="display: none;">Download Pass</a> </li>
	  <?php } ?>
	  <li style="float: left;" id="back_none" class="firstheading prvtzone">
		<div class="prvtzonedv">
		  <h4 class="prvtzoneh4"> Merchandise</h4>
		</div>
	  </li>
	  <?php 
														$sql_user_plan=mysql_query("select plantype from user where id=".$_SESSION['user_id']);
														$host_user_data=mysql_fetch_array($sql_user_plan);
														//if($plantype=='host_pro')
														//{
													?>
	  <li> <a href="host_store.php?host_id=<?php echo $hostID; ?>"> Shop</a> </li>
	  <?  //} ?>
	  <? 
														$needed=get_plan_type($_GET['host_id']);
														//$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"17");
															/*  if($needed){?>
	  <?}else{*/?>
	  <li> <a href="bookme.php?host_id=<?php echo $hostID; ?>"> Bookings</a> </li>
	  <? //} ?>
	  <?php 
												  //if($plantype=="" || $plantype == "host_free")
												 // {

												 // }
												//  else
												//  {
											?>
	  <li> <a href="musiccds.php?host_id=<?php echo $hostID; ?>"> Music & CDs</a> </li>
	  <?php 
													$query = mysql_query("SELECT musicrequeststatus FROM clubs WHERE id = '$hostID'");
													$res= mysql_fetch_array($query);
													if($res['musicrequeststatus'] == '1')
													{

													}
													else
													{
													  
													  $check_req_query = mysql_query("SELECT disable_music_req FROM music_settings WHERE user_id = '$hostID'");
													  $get_check_res = mysql_fetch_assoc($check_req_query);
													
															  $disable_music_req = $get_check_res['disable_music_req'];
															 // if($plantype == 'host_pro')
													 // {


															  if($disable_music_req == 1)
														{
											  ?>
	  <li><a onclick="alert('Request is disabled from the host');" href="javascript:void(0);">Make Music Request</a></li>
	  <?php     }
														else
														{
														
																  echo '<li><a href="music_request.php?host_id='.$hostID.'">Make Music Request </a></li>';
															  }
													 // }
													}
												 // }
											 ?>
	<li><a href="<?php  if($_SESSION['user_type'] == "user"){ echo 'profile.php';}else{ echo 'home_club.php';}?>"> Back to Home Page </a> </li>
	  <li class="logbutton12"> <a id="logouta" href="main/logout.php">Log Out</a> </li>
	</ul>
  </div>
</div>
</aside>
<?php 

							}
							else
							{


								$rq_f=@mysql_query("select id from friends where friend_id='".$_SESSION['user_id']."' AND status='pending'");
								$f_req=@mysql_num_rows($rq_f);
								// end here 


								// get friends list 
									$query_string = "select DISTINCT(u.id),u.first_name,u.last_name,fs.friend_id,u.is_online,fs.chat from friends as fs left join user as u on(u.id=fs.friend_id) where fs.user_id='".$_SESSION['user_id']."' AND fs.status='active' AND u.IsAdmin='0'";
									$rq_f1=@mysql_query($query_string);
									$f_num=@mysql_num_rows($rq_f1);
								// end here 

								// get clubs
								 $query_club = "select c.id,c.club_name,c.is_online,fs.friend_id,fs.chat from friends as fs
								 left join  clubs as c on(c.id=fs.friend_id) 
								where fs.user_id='".$_SESSION['user_id']."' AND fs.status='active' AND fs.friend_type='club' group by c.id";
								$rq_club=@mysql_query($query_club);
								$f_num_club=@mysql_num_rows($rq_club);?>
<aside class="sidebar">
<div class="user-profle">
  <?php
									if(isset($_SESSION['img']) && $_SESSION['img']!='')
									{?>
  <a href="/profile.php"><img src="<?php echo $_SESSION['img']; ?>" ></a>
  <div class="uname">
	<?php 
		if(($profilename == " ") || ($profilename == "") ) 
		{ 
			echo $fullname; 
		}
		else
		{ 
			echo $profilename; 
		}
	?>
  </div>
  <?php 
									}
									else 
									{ 
								?>
  <a href="/profile.php"> <img src="images/man4.jpg" /></a>
  <?php 
									
									} 
								?>
</div>
<!-- END user-profle -->
<div class="side_profile">
<ul>
	<li><a href="hotspots.php" >Hot Spots</a></li>
  <li><a href="home_user.php" >City Events</a></li>
  <li><a  href="city_talk.php">City Talk</a></li>
  <li><a href="all_live_cam.php" >Live Streaming</a></li>
  <li class="toggle_nav" id="navcontests" <?php if ((preg_match("/\bmysitti_contestsList.php\b/i", $sel)) || (preg_match("/\bcurrent_host_contests.php\b/i", $sel) ) ) {?> class="selected none"<?php }?>>
  <a href="javascript:;">Contest</a>
  <?
	if($_SESSION['user_id'])
	{
		$sbmnu="sub_menu";
	}
	else
	{
		$sbmnu="sub_menunotlogin";
	}
	?>
  <ul class="<? echo $sbmnu;?>">
	<li><a href="mysitti_contestsList.php">mySitti Contests</a></li>
	<li><a href="current_host_contests.php">Host Contests</a></li>
  </ul>
  </li>
</ul>
<h1><a  style="color: #000;" href="edit_profile.php">
  <?php if(($profilename == " ") || ($profilename == "") ) { echo $fullname; }else{ echo $profilename; } ?>
  Profile</a></h1>
<div id="back_none" style="display: none" class="UseroneBox">
  <?php   if(isset($image_nm) && $image_nm!="")
											{   
									?>
  <img src="<?php echo $image_nm; ?>" width="130" height="158"  alt='img' /><br>
  <?php 
											} 
											else 
											{ 
									?>
  <a href="/profile.php"> <img src="images/man4.jpg" /></a>
  <?php 
											} 
									?>
  <div style="font-size:18px; color:white;"> <?php echo $first_name." ".$last_name; ?> </div>
</div>

<ul class="reset listing">

  <li><a href="edit_profile.php" class="black_text"> Edit</a></li>
  <li><a href="profile.php" class="black_text"> Profile Posts</a></li>
  <li><a href="user_shout.php" class="black_text"> (<?php echo $total_con_s; ?>)Shouts</a></li>
  <li><a href="downloadtracks.php" class="black_text"> Download Music
	<?         $data=mysql_query("SELECT count(id) as countdownload FROM `purchases` where user_id=".$_SESSION['user_id']);
												$data=mysql_fetch_array($data);
												
									  ?>
	
	</a> </li>
  <li><a href="downloadpasses.php" class="black_text"> <span>Download Pass</span>
	<?         $data=mysql_query("SELECT count(id) as countdownload FROM `downloadpasses` where user_id= '".$_SESSION['user_id']."' AND `status` = '0'");
					$data=mysql_fetch_array($data);
					
		  ?>
	
	</a></li>
	<li>  <a href="home_user.php"> <span>City Events</span> </a> </li>
	<li> <a href="myCalendar.php" class="black_text">Calendar </a> </li>
	<li> <a href="user_search.php" class="black_text"> Invite Friends </a> </li>
	<li> <a href="all_friends.php" class="black_text"> Friends List </a> </li>
  <li> <a href="all_hosts.php" class="black_text"> Host Spots (<?php echo $f_num_club; ?>) </a> </li>
  <li class="logbutton12"> <a id="logouta" href="main/logout.php">Log Out</a> </li>
</ul>
<div class="clear:both;"></div>

</div>
<!-- here is closing ul and div from profile page -->
</aside>
<?php 						
								} // END ISSET HOST ID
							} //END IF USER TYPE USER
							else
							{
								if(isset($_SESSION['subuser']))
								{
									if(isset($_SESSION['subuser']))
									{
										$hostID = $_SESSION['user_id'];
									}
									elseif(isset($_GET['uid']))
									{
										$hostID = $_GET['uid'];
									}
									else
									{
										$hostID = $_GET['host_id'];	
									}

									$sql = "select * from `clubs` where `id` = '".$hostID."'";
									$userArray = $Obj->select($sql) ; 
									$first_name=$userArray[0]['club_name']; 
									$zipcode=$userArray[0]['zip_code'];
									$state=$userArray[0]['club_state'];
									$country=$userArray[0]['club_country'];
									$city=$userArray[0]['club_city'];

									$email=$userArray[0]['club_email'];
									$image_nm=$userArray[0]['image_nm'];
									$phone=$userArray[0]['club_contact_no'];
									if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];

									$club_address=$userArray[0]['club_address'];
									$web_url=$userArray[0]['web_url'];
									$club_city=$userArray[0]['club_city'];
									$club_name=$userArray[0]['club_name'];
									$type_of_club =$userArray[0]['type_of_club'];
									$type_details_of_club=$userArray[0]['type_details_of_club'];
									$google_map_url=$userArray[0]['google_map_url'];

									$q_stat=mysql_query("select name,code from zone where zone_id='$state'");	
									$q_res_stat = mysql_fetch_array($q_stat);
									$stat_ans=$q_res_stat['code'];

									$q_city=mysql_query("select city_name,city_id  from capital_city where city_id='$club_city'");	
									$q_res_city = mysql_fetch_array($q_city);
									$city_ans=$q_res_city['city_name'];
									$pieces = explode(" ", $userArray[0]['club_name']);
									$username_dash_separated = implode("-", $pieces);
									$username_dash_separated = clean($username_dash_separated);
									if(!empty($_POST['state']))
									{	
									// 	$state = $_POST['state'];
									// 	$city = $_POST['city'];
									// 	$_SESSION['state'] = $_POST['state'];
									// 	$_SESSION['id'] = $_POST['city'];
										$sql="SELECT * FROM `contest` where `status`='1' and contest_city='".$city."' ORDER BY `contest_id` AND user_id = 0 AND host_id = '$userID' DESC limit 1";
									}
									 else{
									// 	$cityid = $_SESSION['id'];
									// 	$date = date('Y-m-d');
										$sql="SELECT * FROM `contest` where `status`='1' AND `contest_end` > '$date'  AND contest_city='".$cityid."'  ORDER BY `contest_id` AND host_id = '$userID' AND user_id = 0 DESC limit 1";
									}

									$q = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$club_name."'  ");
									$f = @mysql_fetch_array($q);


									$clubquery = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$f['host_id']."'  ");
									$fetchclubquery = @mysql_fetch_array($clubquery);
									//die('dfdfdfdfdfdf');
									session_start();
									$_SESSION['img'] = $f['user_thumb'];
									?>
<style type="text/css">
													#leaderboard
													{
														float: left;
														/*width: 100% !important;*/
														margin-top: 0 !important;
													}
													#leaderboard h1:before
													{
														background-image: url("../../images/siderbar_top.png") ;
														background-repeat: no-repeat;
														content: "";
														float: left;
														height: 30px;
														left: 0;
														position: absolute;
														top: -30px;
														width: 100%;
														font-size: 22px;
														padding: 14px 0;
													}
													#leaderboard h1
													{

														background: none repeat scroll 0 0 #FECD07;
														font-size: 22px;
														padding: 14px 5px;
														text-transform: uppercase;
													}
													#leaderboard ul li
													{
														color: #FFFFFF;
														background-position: 6% center;
														background-repeat: no-repeat;
														border-bottom: 1px solid #808080;
														float: left;
														line-height: 38px;
														padding: 10px 20%;
														width: 60%;
													}
													</style>
<aside class="sidebar">
  <div class="user-profle">
	<div style="font-size: 18px; color: white; float: left; width: 100%; margin-top: 10%;"> <?php echo $club_name; ?> </div>
	<div class="hostsideimage">
	  <? 
															if(($_SESSION['user_type'] == 'user') )
																{	
																	$anchor = "host_profile.php?host_id=".$fetchclubquery['id'];
																}
																elseif ( $_SESSION['user_type'] == 'club') {
																	$anchor = 'home_club.php';
																}
																else
																{
																	$anchor = "musicrequestList.php";
																}

															if($_SESSION['img']!="")
															{ 
															?>
	  <a href="<?php echo $anchor; ?>"><img src="<?php echo $_SESSION['img']; ?>" height="157" width="135" /></a><br />
	  <?php } else { ?>
	  <a href="<?php echo $anchor; ?>"><img src="images/man4.jpg"></a>
	  <?php } ?>
	</div>
	<div class="hostaddress">
	  <?php 
															

															if((!isset($_SESSION['subuser'])) || ($_SESSION['user_type'] == 'user') )
															{
														?>
	  <span class="subusersidebarlink" style="color: #FFF;">Return to<a style="color:rgb(254, 205, 7);" href="<?php echo $anchor; ?>"> <?php echo $fetchclubquery['club_name']; ?></a></span>
	  <?php 	} ?>
	</div>
  </div>
  <div class="side_profile">
	<h1>
	  <?php //echo $club_name; ?>
	  Sounds</h1>
	<ul>
	  <li>
		<?php 

		$getsubuserquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$club_name."' ");

		$fetchsubuser1 = @mysql_fetch_array($getsubuserquery);
		$fetchsubusercount = @mysql_num_rows($getsubuserquery);
		if(isset($_SESSION['subuser']))
		{
	?>
<!-- <a href="musicrequestlist.php"> Music Request</a> --> 
			<a href="live2/" >Go Live</a>
<?php 
		}
		else
		{
	?>
			<a href="javascript: void(0);" onclick="goto('live2/channel.php?n=<?php echo $club_name; ?>')">Live Streaming</a>
<?php 
		}
		?>
	  </li>
	  <li> <a href="music_request.php?host_id=<?php echo $hostID; ?>"> Jukebox</a> </li>
	  <?php
		if(!isset($_SESSION['subuser']))
		{
							?>
	  <li> <a href="musicrequestList.php?uid=<?php echo $hostID; ?>"> Music Requests</a> </li>
	  <?php 		} ?>
	  <li>
		<?php
		if(isset($_SESSION['subuser']))
		{
			?>
		<a href="add_shout.php"> Shout Out</a>
		<?php 

		}
		else
		{
		}

	 ?>
	  </li>
	  <?php if(isset($_SESSION['subuser'])) { ?>
	  <li><a href="musicrequestList.php"> Music Request</a></li>
	  <li><a href="settingslist.php"> Settings</a></li>
	  <li><a href="musicplaylists.php"> Play List</a></li>
	  <?php } ?>
	  <li class="logbutton12"> <a id="logouta"  href="main/logout.php">Log Out</a> </li>
	</ul>
  </div>
</aside>
<?php 
			}
			else
			{

				$sql = "select * from `clubs` where `id` = '".$userID."'";
				$userArray = $Obj->select($sql) ; 
				$first_name=$userArray[0]['club_name']; 
				$zipcode=$userArray[0]['zip_code'];
				$state=$userArray[0]['club_state'];
				$country=$userArray[0]['club_country'];
				$city=$userArray[0]['club_city'];

				$email=$userArray[0]['club_email'];
				$image_nm=$userArray[0]['image_nm'];
				$phone=$userArray[0]['club_contact_no'];
				if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];

				$club_address=$userArray[0]['club_address'];
				$web_url=$userArray[0]['web_url'];
				$club_city=$userArray[0]['club_city'];
				$club_name=$userArray[0]['club_name'];
				$type_of_club =$userArray[0]['type_of_club'];
				$type_details_of_club=$userArray[0]['type_details_of_club'];
				$google_map_url=$userArray[0]['google_map_url'];

				$q_stat=mysql_query("select name,code from zone where zone_id='$state'");	
				$q_res_stat = mysql_fetch_array($q_stat);
				$stat_ans=$q_res_stat['code'];

				$q_city=mysql_query("select city_name,city_id  from capital_city where city_id='$club_city'");	
				$q_res_city = mysql_fetch_array($q_city);
				$city_ans=$q_res_city['city_name'];
				$pieces = explode(" ", $userArray[0]['club_name']);
				$username_dash_separated = implode("-", $pieces);
				$username_dash_separated = clean($username_dash_separated);
				if(!empty($_POST['state']))
				{	
					$sql="SELECT * FROM `contest` where `status`='1' and contest_city='".$_SESSION['id']."' ORDER BY `contest_id` AND user_id = 0 AND host_id = '$userID' DESC limit 1";
				}
				else{
					//$cityid = $_SESSION['id'];
					//$date = date('Y-m-d');
					$sql="SELECT * FROM `contest` where `status`='1' AND `contest_end` > '$date'  AND contest_city='".$_SESSION['id']."'  ORDER BY `contest_id` AND host_id = '$userID' AND user_id = 0 DESC limit 1";
				}

					$contest_list = $Obj->select($sql);
					$contest_id=$contest_list[0]['contest_id'];
					$contest_title=$contest_list[0]['contest_title'];

				?>
<aside class="sidebar">
  <div class="user-profle">
	<div style="font-size: 18px; color: white; float: left; width: 100%; margin-top: 10%;"> <?php echo $club_name; ?> </div>
	<div class="hostsideimage"> <a href="<?php echo $web_url; ?>" target="_blank"></a>
	  <? if($image_nm!="")
													 { ?>
	  <a href="/home_club.php"><img src="<?php echo $image_nm; ?>" height="157" width="135" /></a><br />
	  <?php } else { ?>
	  <a href="/home_club.php"><img src="images/man4.jpg"></a>
	  <?php } ?>
	   </div>
	<div class="hostaddress">
	  <div class="addressinfo"> <?php echo $club_address;?><br/>
		<?php echo $phone;?><br/>
		Web Site: &nbsp; <a href="<?php echo $web_url; ?>" target="_blank"> <?php echo $web_url; ?> </a> </div>
	  <div class="hostmap"> <a href="javascript:void(0);" onclick="goto('view-map.php?add=<?php echo $userID;?>');"><img  src="images/map-marker.png"></a> </div>
	</div>
  </div>

<?php 
if(isset($_GET['host_id']) && $_SESSION['user_type'] == "club")
{
	?>

<div class="side_profile">
	<h1><?php echo $club_name;?> Profile</h1>
	<div class="unblockalgn">
	  <div class="webcambutton">
		<? if($data_upgrade1['plantype'] == "")
		{
			$data_upgrade1['plantype'] = "host_free";
		}
		else
		{
		  $data_upgrade1['plantype'] = $data_upgrade1['plantype'];
		}
		$data_upgrade_needed=chk_upgrade_needed($data_upgrade1['plantype'],"9");
		$pieces = explode(" ", $club_name);
		$club_name_dash_separated = implode("-", $pieces);
		$club_name_dash_separated  = clean($club_name_dash_separated);
	/*	if($data_upgrade_needed){?>
<a onclick="alert('This Host does not have this feature in his Suscribed Plan!');" class="button"> Live Streaming</a>
		<?}else{*/?>
		<a href="javascript: void(0);" onclick="goto('live2/channel.php?n=<?php echo $club_name_dash_separated;?>')" class="button">Live Streaming</a>
		<? //} ?>
	  </div>
	  <div class="blockhostbutton">
		<?php if(isset($_SESSION['user_id'])) { ?>
		<?php if($club_dtl['status']=='active') { ?>
		<a id="block" href="javascript:void(0)" class="button" onclick="savehost('<?php echo $hostID;?>','block')">Followed</a> 
		<!-- <input type="submit" id="block" class="button" value="Block Host" name="submit" onclick="savehost('<?php //echo $hostID;?>','block')"> -->
		<?php }else if($club_dtl['status']=='block') { ?>
		<a id="unblock" href="javascript:void(0)" class="button" onclick="savehost('<?php echo $hostID;?>','unblock')">Followed</a> 
		<!-- <input type="submit" id="unblock" class="button" value="Un Block" name="submit" onclick="savehost('<?php //echo $hostID;?>','unblock')"> -->
		<?php }else {  ?>
		<input type="submit" id="request" class="button" value="Save Host" name="submit" onclick="savehost('<?php echo $hostID;?>','request')">
		<?php } }?>
	  </div>
	</div>
	<hr>
	<ul class="reset listing" id="home-left-nav" style="margin: 0px;">
		<li><a href="hostdj_profile.php?host_id=<?php echo $hostID; ?>"> Bio</a></li>
		<li><a href="clubprofile.php?host_id=<?php echo $hostID; ?>"> Blog</a></li>
		<li><a href="upload_photo.php?host_id=<?php echo $hostID; ?>"> Photos</a></li>
		<li><a href="upload_video.php?host_id=<?php echo $hostID; ?>"> Videos</a></li>
		<li><a href="eventscalendar.php<? if(isset($_GET['host_id'])){ echo "?host_id=".$_GET['host_id'];}?>"> Calendar </a></li>
		<li><a href="listevent.php<? if(isset($_GET['host_id'])){ echo "?host_id=".$_GET['host_id'];}?>"> Upcoming Events</a></li>
		<li style="float: left;" id="back_none" class="firstheading prvtzone">
			<div class="prvtzonedv">
				<h4 class="prvtzoneh4"> Promotions</h4>
			</div>
		</li>
	  	<li><a href="all_contests.php?host_id=<?php echo $hostID; ?>">Contest </a></li>
	  <?php if($rw_row_fe['coupon_image']) { ?>
	  	<li>
		<?php if($rw_row_fe['max_download']==$cu_num) { ?>
		<a id="d_pass_ex"   onclick="javascript:alert('No more pass available to download');" >Download Pass</a>
		<?php }else { ?>
		<a id="d_pass"  name="submit"<?php if($download_num <= 0){ ?>onclick="$('#d_pass_ex').show();$('#d_pass').hide();window.location='download.php?filename=upload/coupon/<?php echo $rw_row_fe['coupon_image'];  ?>&host_id=<?php echo $rw_row_fe['host_id']; ?>&c_id=<?php echo $rw_row_fe['id']?>'"
																  <?php }else{ ?> onclick="javascript:alert('You Already Downloaded This Pass');" <?php } ?> style=""> Download Pass</a>
		<?php  }  ?>
		<a id="d_pass_ex" onclick="javascript:alert('You Already Downloaded This Pass');" style="display: none;">Download Pass</a> </li>
	  <?php } ?>
	  <li style="float: left;" id="back_none" class="firstheading prvtzone">
		<div class="prvtzonedv">
		  <h4 class="prvtzoneh4"> Merchandise</h4>
		</div>
	  </li>
	  <?php 
														$sql_user_plan=mysql_query("select plantype from user where id=".$_SESSION['user_id']);
														$host_user_data=mysql_fetch_array($sql_user_plan);
														//if($plantype=='host_pro')
														//{
													?>
	  <li> <a href="host_store.php?host_id=<?php echo $hostID; ?>"> Shop</a> </li>
	  <?  //} ?>
	  <? 
														$needed=get_plan_type($_GET['host_id']);
														//$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"17");
															/*  if($needed){?>
	  <?}else{*/?>
	  <li> <a href="bookme.php?host_id=<?php echo $hostID; ?>"> Bookings</a> </li>
	  <? //} ?>
	  <?php 
												  //if($plantype=="" || $plantype == "host_free")
												 // {

												 // }
												//  else
												//  {
											?>
	  <li> <a href="musiccds.php?host_id=<?php echo $hostID; ?>"> Music & CDs</a> </li>
	  <?php 
													$query = mysql_query("SELECT musicrequeststatus FROM clubs WHERE id = '$hostID'");
													$res= mysql_fetch_array($query);
													if($res['musicrequeststatus'] == '1')
													{

													}
													else
													{
													  
													  $check_req_query = mysql_query("SELECT disable_music_req FROM music_settings WHERE user_id = '$hostID'");
													  $get_check_res = mysql_fetch_assoc($check_req_query);
													
															  $disable_music_req = $get_check_res['disable_music_req'];
															 // if($plantype == 'host_pro')
													 // {


															  if($disable_music_req == 1)
														{
											  ?>
	  <li><a onclick="alert('Request is disabled from the host');" href="javascript:void(0);">Make Music Request</a></li>
	  <?php     }
														else
														{
														
																  echo '<li><a href="music_request.php?host_id='.$hostID.'">Make Music Request </a></li>';
															  }
													 // }
													}
												 // }
											 ?>
	  <li><a href="<?php  if($_SESSION['user_type'] == "user"){ echo 'profile.php';}else{ echo 'home_club.php';}?>"> Back to Home Page </a> </li>
	  <li class="logbutton12"> <a id="logouta" href="main/logout.php">Log Out</a> </li>
	</ul>
  </div>

<?php
}
else
{

?>

<div class="side_profile">    
			<h1><?php echo $club_name; ?> Profile</h1>
			<div class="unblockalgn">
				<div class="webcambutton">
					<?php 
						$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"9");
						if($data_upgrade_needed)
						{
							?>
							<a href="javascript:void(0);" class="button" onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')">Go Live</a>
							<?php
						}
						else
						{
							echo '<a href="live2" target="blank" class="button">Go Live</a>';
						}

					?>
					
			
				</div>
				<script type="text/javascript">
					function goto1(url)
					{
						window.open(url,'1396358792239','width=900,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
						return false;
					}
				</script>
			<div class="blockhostbutton">
			<?php 
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"9");
				if($data_upgrade_needed)
				{
					?>
					<a href="javascript:void(0);" class="button" onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')">Live Streaming</a>
					<?php
				}
				else
				{
			
					$mobile = detect_mobile();
					if($mobile === true) 
					{ 
					?>

								<a class="button" name="submit"  onclick="goto1('https://192.163.248.47:1935/live/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming
								<?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
								<?php if(detect_stream($username_dash_separated)===true){ ?>
											   <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
										  <?php } else{ ?>
											  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
										  <?php } ?>                     	
								
								</a> 
			<? 		}
					else
					{
		?>

								<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>')">Live Streaming
								<?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
								<?php if(detect_stream($username_dash_separated)===true){ ?>
											   <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
										  <?php } else{ ?>
											  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
										  <?php } ?>                     	
								
								</a>
		<?php 			}
				}  
			?>			
		  </div>
		</div>
			<ul class="reset listing">
				<li>  <a href="edit_profile.php"> <span>Edit</span> </a> </li>
			<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"24");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Bio</span></a></li>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Blog</span></a></li>
					<?php
				}
				else
				{

			?>
					<li>  <a href="hostdj_profile.php"> <span>Bio</span> </a> </li>
					<li>  <a href="clubprofile.php"> <span>Blog</span> </a> </li>
		<?php 		}	?>
				<li>  <a href="forum.php"> <span>City Events</span> </a> </li>
				<li> <a href="upload_photo.php"> <span>Photos</span> </a> </li>
				<li>  <a href="upload_video.php"> <span>Video</span> </a> </li>
				<li>  <a href="subuserList.php" class="black_text"> <span>Manage Users</span> </a> </li>
		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"8");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Connections</span></a></li>
					<?php
				}
				else
				{
		?>
					<li>  <a href="all_connections.php" class="black_text"> <span>Connections</span> </a> </li>
		<?php 		}	?>
				<li><a href="reset_password.php" class="black_text"><span>Reset Password</span></a></li>
				<li style="float: left" class="firstheading prvtzone"   id="back_none">
					<div class="prvtzonedv"> 
					  <h4 class="prvtzoneh4"> Promotions </h4>
					</div>
				</li>
		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"5");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Manage Pass</span></a></li>
					<?php
				}
				else
				{
		?>
					<li><a href="host_coupon.php"> <span>Manage Pass</span> </a></li>
		<?php 		}	?>

					<li><a href="host_advertise.php"> <span>Advertisement</span></a> </li>

		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"13");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Events</span></a></li>
					<?php
				}
				else
				{
		?>
					<li><a href="listevent.php"> Manage Events</a></li> 
		<?php 		}	?>

		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"14");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Calendar</span></a></li>
					<?php
				}
				else
				{
		?>
					<li><a href="eventscalendar.php"> <span>Calendar</span></a></li> 
		<?php 		}	?>

		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"7");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Social Media Sites</span></a></li>
					<?php
				}
				else
				{
		?>
					<li>  <a href="user_social.php?user=host" class="users"><span>Social Media Sites</span></a></li> 
		<?php 		}	?>
		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"11");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Contest</span></a></li>
					<?php
				}
				else
				{
		?>
					<li><a href="contests_list.php"> <span>Contest</span></a> </li>
		<?php 		}	?>
		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"3");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Shout Out</span></a></li>
					<?php
				}
				else
				{
		?>
					<li><a href="shout.php"> <span>Shout Out</span></a></li>
		<?php 		}	?>

						

				<li style="float: left" class="firstheading prvtzone"   id="back_none">
					<div class="prvtzonedv"> 
						<h4 class="prvtzoneh4"> Merchandise </h4>
					</div>
				</li>
		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"21");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Store</span></a></li>
					<?php
				}
				else
				{
		?>
					<li>  <a href="store.php" class="users"><span>Store</span></a></li>
		<?php 		}	?>

						<style type="text/css">
						.slidedown {
							/*background: url("../../images/profile_arrow.png") no-repeat scroll 10px center rgba(0, 0, 0, 0);*/
							border-bottom: 1px solid #282829;
							float: left;
							width: 100%;
						}
						.slidedown ul
						{
							background: none !important;
							border: none !important;
						}
						.slidedown .acc_content li
						{
							border: none !important;
						}
						.slidedown .acc_content li a
						{
							border: none !important;
						}
						</style>

		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"16");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Jukebox</span></a></li>
					<?php
				}
				else
				{
		?>
					<li class="slidedown">
							<ul class="filter123" style="margin-top: 0px !important;">
								<li>
									<div>Jukebox</div>
									<ul>
										<li><a href="music_request.php?host_id=<?php echo $_SESSION['user_id']; ?>"> <span>View Jukebox</span></a></li>
										<li>
											<a href="musicrequestList.php"> <span>Music Request</span>
												<?php  	
													$jukeboxreqquery = @mysql_query("SELECT * FROM `userplaylist` WHERE host_id='".$_SESSION['user_id']."' AND `status` = '1' ");
													$jukeboxreqfetch = @mysql_fetch_array($jukeboxreqquery);
													$countjukeboxreq = @mysql_num_rows($jukeboxreqquery);
													if($countjukeboxreq > 0 ) 
													{ ?>
														<div class="unread fl" style=""> 
															<?php echo $countjukeboxreq;?> 
														</div>
												<?php 	} ?>
											</a>
										</li>
										<li><a href="musicplaylists.php"> <span>Play List</span></a></li>
										<li><a href="settingslist.php"> <span>Settings</span></a></li>
									</ul>
								</li>
							</ul>
						</li>
		<?php 		}	?>
		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"20");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Music Upload</span></a></li>
					<?php
				}
				else
				{
		?>
					<li class="slidedown">
						<ul class="filter123" style="margin-top: 0px !important;">
							<li>
								<div>Music Upload</div>
								<ul>
									<li><a href="music.php"><span> Single</span></a></li>
									<li><a href="cds.php"><span> CD </span></a></li>
									<li><a href="video_clips.php"><span> Video </span></a></li>
								</ul>
							</li>
						</ul>
					</li>
		<?php 		}	?>

		<?php
				$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"17");
				if($data_upgrade_needed)
				{
					?>
					<li><a href="javascript:void(0);"  onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')"><span>Bookings</span></a></li>
					<?php
				}
				else
				{
		?>
					<li class="slidedown">
						<ul class="filter123" style="margin-top: 0px !important;">
							<li>
								<div>Booking</div>
								<ul>
									<li><a href="bookings.php"> <span>Bookings</span> <?php /*if($_SESSION['notification']>0){ ?><div class="unread fl" style=""> <?php /*echo $ur_con_s;  echo $_SESSION['notification']; ?>  </div><?php } */?></a> <?php //} ?></li>
									<li><a href="bookingstype.php"> <span>Booking Types</span></a></li>
								</ul>
							</li>
						</ul>
					</li>
		<?php 		}	?>

				<li class="logbutton12"> <a id="logouta"  href="main/logout.php">Log Out</a> </li>	
			</ul>
		</div>
<?php 	}	?>
</aside>
<?php 
								} // END IF CLUB TYPE SUBUSER OR NOT
							}// END IF USER TYPE CLUB

						} // END PROFILE SIDEBAR

						?>
</div>
<?php 	}//END HERE FOR SESSION CHECK    //if(!isset($_SESSION['user_club']))
		//{ ?>
<? if($num_rw <= 0){ 

		$message = "No City Found For this zipcode";
		echo "<script type='text/javascript'>alert('$message');</script>";
		
	 }


?>
<script type="text/javascript">  




function validate_city_Form()
{

	var country = $('#topsearchform').find("#country").val();
	var state = $('#topsearchform').find("#state").val();
	var city = $('#topsearchform').find("#city_name").val();
	var j_city_name = $('#topsearchform').find('#jcity_name').find('input[name="city_name_jquery"]').val();
	var zipcode = $('#topsearchform').find('#zipcode').val();

	if($('#topsearchform').find('#default_city').is(':checked'))
	{

		var chkbox = "on";
	}
	else
	{
var chkbox = "off";
	}

	if(country == "" && state=="")
	{
		alert("Please Select Country And State First!");
		return false;
	}
	else if(country == "" && state != "" )
	{
		alert("Please Select Country!");
		return false;
	}
	else if(country != "" && state == "" )
	{
		alert("Please Select State!");
		return false;
	}
	else
	{
		if(zipcode != "")
		{
			$.ajax({
				type: "POST",
				url: "refreshajax.php",
				data: {
							'action': "checkzipcode", 
							'zip' : zipcode,
							'state' : state,
							'country' : country,
							'checkbox': chkbox,
				},
				success: function( msg ) 
				{
					if(msg == "1")
					{
						location.reload(true);

					}
					else if(msg == "0")
					{
						alert("No city Found for this Zip code");
						return false;
					}
				}
				});	

		}
		else
		{
			//alert(j_city_name);
			if(j_city_name =="")
			{
				j_city_name = $('#topsearchform').find('input[name="city_name123"]').val();
			}
			if (j_city_name != "") 
			{
				//alert(chkbox);
				jQuery.post('ajaxcall.php', {'check_city_status': 'check_city_status', 'state': state, 'city': j_city_name,'country': country,'checkbox': chkbox}, function(response){
					
					if (response == "exists") {
						//$('#topsearchform').submit();
						location.reload(true);//return true;

					}else{
						
						alert("City Does Not Exist for this state.");
						return false;
					}
					
				});
			}
			else
			{
				alert("Please Enter or Select City First!");
				return false;
			}
		}
	}
}
 
</script>

<div class="search">
  <div id="Search_box" style="display:none;">
	<form name="user_serach" action="" method="POST" id="topsearchform" >
	  <div class="styled-select">
		<?php 
 $countrysql="select country_id,name from country where country_id IN(223,38)";
 $country_list = mysql_query($countrysql);
		 // $row["country_id"];
	?>
		<select class="option-1" name="country" id="country" onChange="showState_new(this.value);">
		  <option value="">------- Select -------</option>
		  <?php
					while($row = mysql_fetch_array($country_list))
			{
			if($row["country_id"] == $_SESSION['country'])
			{
			?>
		  <option selected="selected" value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
		  <?php
			}
			else
			{
			?>
		  <option value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
		  <?php
			}
			}
			?>
		</select>
	  </div>
		<div class="styled-select">
		<?php
		$countrysql1="select zone_id,name from zone where country_id IN(".$_SESSION['country'].") and status ='1'";
		$country_list1 = mysql_query($countrysql1);
		
		$state_arr = array();
		
		while($row1 = mysql_fetch_array($country_list1)){
			
			$state_arr[] = $row1["name"];
			
				if($_SESSION['state']==$row1["zone_id"]) {
				  
				  $set_state_name = $row1["name"];
				  $set_state_id = $row1["zone_id"];
				  
				  }			
			
		}
		$s_key = array_search($set_state_name , $state_arr);
		
		$encoded_state_list = json_encode($state_arr);
		?>

		<script type="text/javascript">
					$(document).ready(function () {
						//alert('ddd');
						var source = JSON.parse('<?php echo $encoded_state_list; ?>');
		
						// Create a jqxComboBox
						$("#jstate_name").jqxComboBox({selectedIndex: '<?php echo $s_key; ?>', source: source, width: '100%', height: '30px', autoComplete: true,searchMode: 'containsignorecase'});
						
						
						$('#jstate_name').on('change', function (event) 
						{
							
							var gcountry_id = $('#country').val();
							
							var args = event.args;
							
							if (args) {
													
							var index = args.index;
							var item = args.item;
							
							var label = item.label;
							var value = item.value;
							
							//alert(value);
							//alert(gcountry_id);
							
							
									$.post('ajaxcall.php',{'country_id' : gcountry_id, 'state_name' : value, 'get_state_id' : 'get_state_id' }, function(resp) {
										
										$('#state').val(resp);
										getcity(resp);
									});												
							}
						});
						
					});
		</script>
		<input id="state" type="hidden" name="state" value="<?php echo $set_state_id; ?>">
		<div id='jstate_name'></div>		
	</div>


	<div class="styled-select">
		<?php 
					if(isset($_SESSION['state']) and $_SESSION['state'] != '')
					{
						$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) where c.state_id ='".$_SESSION['state']."' order by c.city_name"; 
					}
					else
					{
						$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) order by c.city_name";
					}

					$city_list1 = mysql_query($allcity);

					$city_arr = array();
					
					while($row_city = mysql_fetch_array($city_list1))
					{
						if(strlen($row_city["city_name"]) > 2 && $row_city["city_name"] != "" && $row_city["city_name"] != " ")
						{
							$city_arr[] = $row_city["city_name"];

							if($_SESSION['id']==$row_city["city_id"]) {
							  
							  $set_city_name = $row_city["city_name"];
							  
							  }
							  
							  if($_SESSION['id'] == $row_city["city_id"]) { ?>
		<input type="hidden" name="city_name" value="<?php echo $row_city["city_id"]; ?>">
		<input type="hidden" name="city_name123" value="<?php echo $row_city["city_name"]; ?>">
		<?php }
						}
					
					}
					
					$c_key = array_search($set_city_name , $city_arr);
					
					$encoded_list = json_encode($city_arr);
					?>
		<script type="text/javascript">
					$(document).ready(function () {
						
						var source = JSON.parse('<?php echo $encoded_list; ?>');
		
						// Create a jqxComboBox
						$("#jcity_name").jqxComboBox({selectedIndex: '<?php echo $c_key; ?>', source: source, width: '100%', height: '30px', autoComplete: true,searchMode: 'containsignorecase'});

					});
				</script>
		<div id='jcity_name'></div>
	  </div>
	  <input class="option-2" id="zipcode" name="zipcode" placeholder="Zip Code" type="text" value="<?php echo $_POST['zipcode']; ?>" >
	  <?php
				 ?>
	  <span class="set_dflt">
	  <input type="checkbox" value="" name="default_city" id="default_city">
	  Set as default city</span>
	  <input type="button" class="button" value="Switch City" onclick="validate_city_Form();" name="search" id="submit">
	</form>
  </div>
</div>
<?php //} ?> 
<div class="menu-right">
<ul class="login">
	<?php 
if($_SESSION['user_id'] != '')
{
	if($_SESSION['user_type'] == "user")
	{
		$linkProfile = "profile.php";
	}
	else
	{
		$linkProfile = "home_club.php";
	}

	?>
  <li class="login_toggle"> <a style="float: left !important; border: none !important;" href="<?php echo $linkProfile; ?>"><img class="logintoggle" src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo 'images/man4.jpg'; }else{echo $_SESSION['img'];} ?>" ></a>
	<div class="welcometext_profile"> <span class="welcometext">Welcome </span> <br />
	  <div class="profile_name logintoggle login_profile drop" >
		<a style="float: none !important; border: none !important;" href="<?php echo $linkProfile; ?>">
			<?php 
			if(($profilename == " ") && ($profilename == "") ) 
			{ 
				if($_SESSION['username'] == "" || $_SESSION['username'] == " " || $_SESSION['username'] == "-")
				{ 
					
					$e =  explode('@', $_SESSION['userEmail']);  
					echo $e[0]; 
				}
				else
				{
					
					if(isset($_SESSION['profile_name']) && !empty($_SESSION['profile_name']))
					{
						echo $_SESSION['profile_name'];
					} 
				}
			}
			else
			{

					if(isset($_SESSION['profile_name']) && !empty($_SESSION['profile_name']))
					{
						echo $_SESSION['profile_name'];
					} 
					else
					{	
						if(empty($profilename))
						{
							echo $first_name." ".$last_name;
						}
						else
						{
							echo $profilename; 		
						}
					} 
				
			} 
			?>
		</a>
	  </div>
	</div>
	<ul>
	  <div class="loginbox-right">
		<?php  

// echo "<pre>"; print_r($_SESSION); exit;
	if($_SESSION['user_id'] != '')
	{
	?>
		<li class="logusername">
		  <?php

			if(isset($_SESSION['img']) && $_SESSION['img']!='')
			{
				if(isset($_SESSION['subuser']))
				{
					$anc = 'musicrequestList.php';
				}
				elseif($_SESSION['user_type'] == 'club')
				{
					$anc = 'home_club.php';
				}
				else
				{
					$anc = 'profile.php';
				}
		?>
		  <div class="profile">
		  <?php 
			}
		else
		{
?>
		  
		  <div class="profile">
		  
		  <?php 	}		
		if($_SESSION['user_type']=='club') 
		{
			if(isset($_SESSION['subuser']))
			{
?>
		  <!-- <a href="musicrequestList.php"><?php if(($profilename == " ") || ($profilename == "") ) { echo $_SESSION['username']; }else{ echo $profilename; }?></a> -->
		  <?php 
			}
			else
			{
				?>
		  <!--<a href="home_club.php"><?php if(($profilename == " ") || ($profilename == "") ) { echo $_SESSION['username']; }else{ echo $profilename; }?></a>-->
		  <?php //if(($profilename == " ") || ($profilename == "") ) { echo $_SESSION['username']; }else{ echo $profilename; }?>
		  <!-- <a href="hostdj_profile.php">Edit Your Bio</a><br /> -->
		  <a href="clubprofile.php">Blog</a><br />
		  <a href="shout.php"> Shout Out </a><br />
		  <a href="bookings.php"> Bookings </a><br />
		  <a href="musicrequestList.php" class="black_text"> Music Request</a><br />
		  <a href="listevent.php" class="black_text">Events</a><br />
		  <a href="host_coupon.php"> Pass Give Away </a><br />
		  <a href="host_advertise.php" class="black_text"> Specials</a><br />
		  <a href="all_connections.php" class="black_text"> Connections</a><br />  
		  <a href="host_profile.php?host_id=<?php echo $_SESSION['user_id'];?>">User View</a><br />        
		   <a href="windowsApp/MysittiSetup.msi" class="black_text"> Windows App Download</a><br /> 
		  <a target="_blank" href="support.php" class="cart_php"> Help & Support</a><br/>
		  
		  <?php 

			}
		}

		if($_SESSION['user_type'] !='club') 
		{ 
?>
	<a href="profile.php" class="cart_php"> Profile Posts</a><br/>
	<a href="all_hosts.php" class="cart_php"> Favourites</a><br/>
	<!-- <a href="private_zone.php" class="cart_php"> Clique</a><br/> -->
	<a href="user_shout.php" class="cart_php"> Shouts</a><br/>
	<a class="black_text" href="downloadpasses.php"> <span>Pass Download</span>
	<a href="myCalendar.php" class="cart_php"> Calendar</a><br/>

	<a target="_blank" href="support.php" class="cart_php"> Help & Support</a><br/>
		  <?php 	} 	?>
		
		</div></li>
		<?php } else { ?>
		<li class="logusername">
		  <? if(isset($_SESSION['plan-payment-type'])){ ?>
		  <? if($_SESSION['plan-payment-type']=='user'){?>
		  <!--<a href="/sign_up.php#tabs1-html">Sign Up</a>--> 
		  <a href="/sign_up_option.php">Sign Up</a>
		  <? }else{ ?>
		  <a href="/sign_up_option.php">Sign Up</a> 
		  <!--<a href="/sign_up.php#tabs1-js">Sign Up</a>-->
		  <? } ?>
		  <?	}else{ ?>
		  <a href="/sign_up_option.php">Sign Up</a>
		  <? } ?>
		</li>
		<?php
	 }
		if($_SESSION['user_id'] == '')
		{
?>
		<li class="logbutton"> <a id="logina" href="login.php">Login</a> </li>
		<?php 	}
		else
		{
?>
		<li class="logbutton"> <a id="logouta"  href="main/logout.php">Log Out</a> </li>
		<?php
		}
?>
	  </div>

	
	</ul>
  </li>
  <?php }else{ ?>


	<li class="logbutton"> <a id="logina" href="index.php">Login</a> 
	<a id="logina" href="index.php">Sign up</a> </li>


  <?php } ?>
</ul>
<div id="mobileNotification">
	<?php  include('notifications.php'); ?>
  <?php 	if($_SESSION['user_type'] !='club' && $_SESSION['user_id'] != "") 
		{ 
	?>
<div class="shoppingCart"> <a style="color: #fecd07;" href="cart.php" class="cart_php"> <img src="images/mycart.png" /> Cart(<b>
  <?php 


			if(is_array($_SESSION['cart_value']))
			{
				$cv=count($_SESSION['cart_value']);
			}
			if(is_array($_SESSION['cartcd_value']))
			{
				$ccd=count($_SESSION['cartcd_value']);
			}
			if(is_array($_SESSION['cart_value']) || is_array($_SESSION['cartcd_value']))
			{
			echo $cv+$ccd;
			}
			else
			{ 
				echo '0';
			}
?>
  </b> )</a> </div>
  </div>
<?php } ?>
</div>
</header>

<?php
/* host custom background code goes here */

if(isset($_GET['host_id'])  )
{
	if(isset($_GET['host_id']))
	{
		$hostID = $_GET['host_id'];
	}
	else
	{
		$hostID = $hostID;
	}
	
	$get_host_bk_query = mysql_query("SELECT background_name FROM host_background WHERE user_id = '".$hostID."' AND status = '1' AND user_type = 'club'");
	$count_host_background = mysql_num_rows($get_host_bk_query);
	
	if($count_host_background == 1)
	{
		$host_bkground_img = mysql_fetch_assoc($get_host_bk_query);
		$host_bg_img = "/host_banner/".$host_bkground_img['background_name'];
	?>

		<style type="text/css">
			.home_wrapper
			{
				background-image: url('<?php echo $host_bg_img; ?>') !important;
			}
		</style>

<?php
	}
}
elseif($_SESSION['user_type'] == "club")
{
	
	$get_host_bk_query = mysql_query("SELECT background_name FROM host_background WHERE user_id = '".$_SESSION['user_id']."' AND status = '1' AND user_type = 'club'");
	$count_host_background = mysql_num_rows($get_host_bk_query);
	
	if($count_host_background == 1)
	{
		$host_bkground_img = mysql_fetch_assoc($get_host_bk_query);
		$host_bg_img = "/host_banner/".$host_bkground_img['background_name'];
?>

		<style type="text/css">
			.home_wrapper
			{
				background-image: url('<?php echo $host_bg_img; ?>') !important;
			}
		</style>

<?php
	}
}/*
elseif(!isset($_SESSION['user_id']) && !isset($_POST['club_email']) )
{

//die('dddd');
	$club_name_social = mysql_real_escape_string($_GET['user']);
	$sql_social = "select * from `clubs` where `club_name` = '".$club_name_social."'";


	//$userArray = $Obj->select($sql) ;
	// echo $userArray[0]['club_name'];
	$userArray_social = $Obj->select($sql_social) ; 
	//echo "<pre>"; print_r($userArray);exit;

	if(count($userArray_social) < 1)
	{
		$Obj->Redirect('index.php');
	}
	$hostID=$userArray_social[0]['id'];
	$userID=$userArray_social[0]['id'];
	$get_host_bk_query = mysql_query("SELECT background_name FROM host_background WHERE user_id = '".$hostID."' AND status = '1' AND user_type = 'club'");
	$count_host_background = mysql_num_rows($get_host_bk_query);
	
	if($count_host_background == 1)
	{
		//die('dddd');
		$host_bkground_img = mysql_fetch_assoc($get_host_bk_query);
		$host_bg_img = "/host_banner/".$host_bkground_img['background_name'];
?>

		<style type="text/css">
			.home_wrapper
			{
				background-image: url('<?php echo $host_bg_img; ?>') !important;
			}
		</style>

<?php
	}

}*/
/* host custom background code goes here */
/*----------------------------------------------------------------------*/

$get_time = @mysql_query("SELECT * FROM refresh_background_time");
$time = @mysql_fetch_assoc($get_time);
?>
<script type="text/javascript">
	$(document).ready(function(){
		





		var time = '<?php echo $time['time_interval']; ?>';
		
		setInterval(function() {
			
			var cityid = '<?php echo $_SESSION['id']; ?>';
			
			$.ajax({
				type: "POST",
				url: "refreshajax.php",
				data: {
				'arrange_images': "arrange_images", 
				'cityid' : cityid 
				},
				success: function( msg ) 
				{
				//	alert(msg);
					if( (msg == 'disable') || (msg == '') ) 
					{
						$('.home_wrapper').css('background-image', 'url(/images/homebg.png)');
								
					}
					else
					{
						$('.home_wrapper').css('background-image', 'url('+msg+')');				
					}
				}
			  });		
			  // }, 1000);	
		}, 1000 * 60 * time); // where X is your every X minutes								
		
	});
</script>
<?php 

if(isset($_COOKIE['backgroundcookie']) && ($_COOKIE['backgroundcookie'] != '/images/homebg.png' ) )
{
?>
<style type="text/css">
	.home_wrapper
	{
		background-image: url('<?php echo $_COOKIE["backgroundcookie"]; ?>');
	}
</style>
<?php }

  
	$cityid = $_SESSION['id'];
	$getcityname = @mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '".$cityid."' ");
	$fetchcity = @mysql_fetch_array($getcityname);
	$city = trim($fetchcity['city_name']);

	$city_sel = @mysql_query("SELECT city_image_id FROM refresh_background WHERE city_name = '".$city."' AND refresh_status = '1' ORDER BY RAND() LIMIT 0,1");

	$count_img = mysql_num_rows($city_sel);

	if($count_img > 0)
	{

		$rowwww = mysql_fetch_assoc($city_sel);

		$set_image = @mysql_query("SELECT city_image_url FROM capital_city_images WHERE city_image_id = '".$rowwww['city_image_id']."'");

		$get_data = mysql_fetch_assoc($set_image);

		$imagesrcback =  "/admin/cities/".$get_data['city_image_url'];

		?>
<style type="text/css">
			.home_wrapper
			{
				background-image: url('<?php echo $imagesrcback; ?>');
			}
		</style>
<?php
			$intervalq = @mysql_query("SELECT * FROM `refresh_background_time`");
			$intervalf = @mysql_fetch_array($intervalq);

			ob_start();
			setcookie("backgroundcookie", $imagesrcback,time() + (60 * $intervalf['time_interval'] ) );
			ob_end_clean();

	}  
//}


/*--------------------------------------------------------------------------------*/


if(empty($_SESSION['id']) || !isset($_SESSION['id']) || $_SESSION['id'] == "")
{
	$id=54;
	$_SESSION['id']=$id;
	$_SESSION['state']='3668';
	$_SESSION['country']='223';
}

//echo "<pre>"; print_r($_SESSION);echo "</pre>";
$city_name_query = @mysql_query("SELECT city_name FROM capital_city WHERE city_id = '".$_SESSION['id']."'");

$get_city_name = mysql_fetch_assoc($city_name_query);
$dropdown_city = $get_city_name['city_name'];


$state_name_query = @mysql_query("select code FROM zone where zone_id = '".$_SESSION['state']."' and status ='1'");

$get_state_name = mysql_fetch_assoc($state_name_query);
$dropdown_state = $get_state_name['code'];




?>

<!--for  responsive toggle menu --> 
<script type="text/javascript">



$(document).ready(function(){
	$(".menu").click(function(){
		$("nav").slideToggle();
	});
	$('#Search_box').hide().before('<a href="#" id="toggle-menu" class="menu"><?php echo $dropdown_city; ?>, <?php echo $dropdown_state; ?><img src="images/new_portal/menu.png" alt="Menu" /></a>');

	$('a#toggle-menu').click(function (e) {
		e.preventDefault();
		$('#Search_box').slideToggle(200);
	});


  $(".toggle_nav a").click(function(){
	$(".toggle_nav > ul.sub_menu").slideToggle();
  });
});
</script> 

<?php 
if(($_SERVER['SCRIPT_NAME'] == "/home_club.php") 
	|| ($_SERVER['SCRIPT_NAME'] == "/dj_home.php") 
	|| ($_SERVER['SCRIPT_NAME'] == "/band_home.php") 
	|| ($_SERVER['SCRIPT_NAME'] == "/fight_home.php") 
	|| ($_SERVER['SCRIPT_NAME'] == "/extreme_club.php") 
	|| ($_SERVER['SCRIPT_NAME'] == "/home_user.php") 
	|| ($_SERVER['SCRIPT_NAME'] == "/theatre_home.php") )
{
	if($_SESSION['user_type'] == "user")
	{
		$table="user";
		$getloginDetail = mysql_query("SELECT `first_login` FROM `user` WHERE `id` = '$_SESSION[user_id]' ");
		$fetchLogin = mysql_fetch_assoc($getloginDetail);
	}
	else
	{
		$table="clubs";
		$getloginDetail = mysql_query("SELECT `first_login` FROM `clubs` WHERE `id` = '$_SESSION[user_id]' ");
		$fetchLogin = mysql_fetch_assoc($getloginDetail);
	}

	if($fetchLogin['first_login'] == "0")
	{
	
	//die('dfdfdfdfdfd');

	?>
		<script type="text/javascript">
			$(document).ready(function(){
				//alert('ssss');
				$(".b-close").click(function(){
					$('#popup24, .b-modal').css('display','none');
				});
				$('#popup24').show();
				$('.b-modal').show();
			});
			function getStarted(url)
			{
				$('#popup24, .b-modal').css('display','none');
				window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
				return false;
			}
		</script>
		<style>
		.black_overlay {
			background:rgba(0, 0, 0, 0.7);
			height: 100%;
			left: 0;
			position: fixed;
			top: 0;
			width: 100%;
			z-index: 1;
		}
		.close {
			width:62px;
			height:62px;
			position:absolute;
			right:10px;
			top:10px;
			cursor:pointer;
			background:url(images/close.png) left top no-repeat;
		}
		.mynew_popup {
			background: #fff none repeat scroll 0 0;
			border-radius: 50%;
			bottom: 0;
			box-sizing: border-box;
			height: 550px;
			left: 0;
			margin: auto;
			max-width: 550px;
			padding: 60px 40px;
			position: absolute;
			right: 0;
			top: 0;
			width: 100%;
			z-index: 99;
			border:4px solid #face00; 
		}
		.mynew_popup h1 {
			font-size: 20px;
			font-weight: normal;
			margin: 0;
			text-align: center;
		}
		.brandlogo img {
			max-width: 70px;
		}
		.mynew_popup h1 span {
			font-weight:bold;
		}
		.brandlogo {
			width:100%;
			text-align:center;
			float:left;
			margin:10px 0;
		}
		.mynew_popup .content_left {
			width:64%;
			text-align:left;
			line-height:20px;
			float:left;
		}
		.mynew_popup .content_right {
			float: right;
			text-align: right;
			width: 35%;
			line-height:20px;
		}
		.getstarted {
			background: #fecd07 none repeat scroll 0 0;
			border: 1px solid #000;
			color: #000;
			display: table;
			float: none;
			margin: 30px auto 10px;
			padding: 8px 15px;
			text-align: center;
			text-decoration: none;
		}
		.getstarted:hover {
			background:#111;
			color:#fff;
		}
		.clear {
			clear:both;
		}
		.new_social {
			text-align:center;
			width:100%;
			float:left;
			margin:10px 0 20px
		}
		.new_social img {
  margin: 10px;
}
		#popup24 {
			position:fixed;
			/*left:0 !important;*/
			/*top:0 !important;*/
			height:100%;
			z-index:99;
			zoom:1;
			width:100%;
			z-index:2147483647;
			background:rgba(0, 0, 0, 0.7)!important;
		}

		.bgpopup_overlay {
		  background: #fff none repeat scroll 0 0;
		  border: 5px solid #ccc;
		  border-radius: 8px !important;
		  bottom: 0;
		  box-shadow: none;
		  height: 590px;
		  left: 0 !important;
		  margin: auto;
		  max-width: 450px;
		  overflow: auto;
		  padding: 0;
		  position: absolute;
		  right: 0;
		  top: 0 !important;
		  width: 100%;
		  z-index: 2;
		}
		#popup24 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
		#popup, .bMulti {
			background-color: #000;
			border-radius: 10px;
			color: #111;
			padding: 25px;
			display: none;
			
		}
#popup24 span.b-close {
  border: medium none;
  color: #fff;
  cursor: pointer;
  float: right;
  padding: 10px;
  position: absolute;
  right: 75px;
}
			.b-modal{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:99; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}





		</style>
		<div id="popup24"  class="popoverlay" style="display:none;">
			
				<div class="mynew_popup">
                <span class="b-close"> <img src="images/closepopup.png" alt="Close" /> </span>
					<h1>Welcome to <span>mysittidev.com</span></h1>
					<div class="brandlogo"> 
						<img src="images/mysittinewlogo.png" alt="" /> 
					</div>
					<div class="new_social"> 
						<a href="https://www.facebook.com/mysitti">
							<img src="images/f1.png" alt="" />
						</a> 
						<a href="https://plus.google.com/108962646742620892931">
							<img src="images/g1.png" alt="" />
						</a> 
						<a href="https://instagram.com/mysitti/"> 
							<img src="images/in1.png" alt="" />
						</a> 
					</div>
					<div class="content_left"> 
						Djs,rappers, event hosts and Users
						Take advantage of our social and streaming platform
						that will increase your entertainment
						experience. Share what you do in your city so that visitors to your 
						city can enjoy your city the way that you do. 
					</div>
					<div class="content_right"> 
						Thank you for joining<br />
						<strong>mysittidev.com</strong> <br />
						<br />
						Help <em>Make Every City Your City</em> by spreading the word to your friends. 
					</div>
					<br />
					<br />
					<div class="clear"></div>
					<?php 
						$getVideoStarted = mysql_query("SELECT * FROM `advertise` WHERE `page_name` = 'get-started' ");
						$fetchVideoStarted = mysql_fetch_assoc($getVideoStarted);
					?>
					<a href="javascript:void(0);" class="getstarted" onclick="getStarted('playHelpVideo.php?video=<?php echo $fetchVideoStarted["adv_video"];?>');">Get Started Now</a> 
				</div>
		</div>
				<div id="fade" class="black_overlay b-modal" style="display:none;">></div>
	<?php
		mysql_query("UPDATE  ".$table."  SET `first_login` = '1' WHERE `id` = '$_SESSION[user_id]'  ");
	}

}