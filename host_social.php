<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if(!isset($_SESSION['user_id']))
{
	header('Location: login.php');
}
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="update")
	{
	$message="Coupon Updated Sucessfully";
	}
}

	include 'login/facebook.php';
	$appid 		= "688073574590787";
	$appsecret  = "acdbc4b9054bbc4c7e318b42a05d92fd";
	$facebook   = new Facebook(array(
  		'appId' => $appid,
  		'secret' => $appsecret,
  		'cookie' => TRUE,
	));
	$fbuser = $facebook->getUser();
	if ($fbuser) {
		try {
		    $user_profile = $facebook->api('/me');
		}
		catch (Exception $e) {

		}
		$user_fbid	= $fbuser;
		$user_email = $user_profile["email"];
		$user_fnmae = $user_profile["first_name"];
		$user_image = "https://graph.facebook.com/".$user_fbid."/picture?type=large";
	}		
 
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css" />

<link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<script src="js_validation/add_user.js" type="text/javascript"></script>

<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="js_validation/update.js" type="text/javascript"></script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>

<script type="text/javascript">
window.fbAsyncInit = function() {
	FB.init({
	appId      : '688073574590787', // replace your app id here
	channelUrl : 'https://mysitti.com/host_social.php', 
	status     : true, 
	cookie     : true, 
	xfbml      : true  
	});
};
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));

function FBLogin(){
	FB.login(function(response){
		if(response.authResponse){
			window.location.href = "host_social.php?action=fblogin";
		}
	}, {scope: 'email,user_likes,publish_stream'});
}

function FBLogout(){
	FB.logout(function(response) {
		window.location.href = "index.php";
	});
}
</script>

    </head>

<body onload="frame();">
    <div id="main">
   
        <div class="container">
        <?php 
        include('header.php');
        ?>
            <div id="wrapper" class="">
             <?php
	   if($message!="")
	   {
	   ?>
      <div style="background-color:#6F9; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     } ?>
            	<div id="title">Social  Media</div>
                
               <div class="prfile-panel">
                 <?php include('club-right-panel.php') ?>
                </div>  
                  <div class="profileright">
                   <div id="profile_box" style="overflow:hidden;margin: 30px 0 0 195px;">
       <form name="add_adv" method="post"   enctype="multipart/form-data" onsubmit="return validate_adv();">
     <p> Login to your social media sites to send shout-out   </p><br>
          
		    <ul>
           <li>Facebook:</li>
           <li>
           <img src="images/facebook-connect.png" alt="Fb Connect" title="Login with facebook" onclick="FBLogin();"/>
            <?php if(isset($user_fnmae)) { ?>
        	<p>You Looged As :  <?php echo $user_fnmae; ?> <!--<img src="<?php echo $user_image; ?>" height="100"/>-->  </p>
           <?php } ?>
             </li>
         </ul>
      	    <ul>
           <li> Twitter</li>
           <li>
         		<a href="twitter/process.php"><img src="images/sign-in-with-twitter-l.png" width="151" height="24" border="0" /></a>
                <p> <?php if(isset($_SESSION['request_vars']['screen_name'])) { ?> You Looged As :  <?php echo  $_SESSION['request_vars']['screen_name']; }?>  </p>
               
             </li>
         </ul>         
         	<!--<div id="submit_btn">	<input name="post" type="submit" value="Post" /> </div>-->
        </form>
         </div>
                     </div>
                </div>    
	     </div>
     </div>
     
<?php include('footer.php') ?>
</div>


</body>

</html>
