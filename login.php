<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if($_SESSION['user_id'] == '')
{
  $Obj->Redirect('index.php');
  die;
}
else
{
 $Obj->Redirect('index.php'); 
 die;
}


$para="";
if(isset($_REQUEST))
{
$para=$_REQUEST['msg'];
}
if($para=="error1")
{
$message="Please enter correct username or password to login in your account.";
}
if($para=="error2")
{
$message="Before you can login, you must active your account with the link sent to your email address.";
}
if($para=="login")
{
$message="To View Full Profile Please login";
}
/*include("CheckLogIn_con.Inc.php");
$userID=$_SESSION['user_id'];*/
$titleofpage="Login";
include('header_start.php');


include 'login/facebook.php';
$appid      = "688073574590787";
$appsecret  = "acdbc4b9054bbc4c7e318b42a05d92fd";

$facebook   = new Facebook(array(
    'appId' => $appid,
    'secret' => $appsecret,
    'cookie' => TRUE,
));


include 'directlogin.php';


if(!isset($authUrl))
{
  $user_email = $user['email'];
  $user_fnmae = $user['given_name'];
  $user_lnmae = $user['family_name'];
  $profileimagename = $user['given_name'].$user['family_name']."_test.jpg";
  //die('dfdfdfdfdf');
  $path = "upload/".$profileimagename;
 // echo $_SESSION['socialtype'];

  if(!file_exists($path))
  {
      copy($profile_image_url,$path);
  }
  if(($_SESSION['socialtype'] == 'user')  )
  {
      if($user_email != "")
      {
          //die('success');
          $sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
          $getemailquery = @mysql_query($sql);
          $countemail = @mysql_num_rows($getemailquery);
          $today = date("Y-m-d h:i:s");
          if($countemail > 0 ) 
          {
              //die('if');
              //$dataArray = @mysql_fetch_array($getemailquery);
              $sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
              $DataArray = $Obj->select($sql) ;
              $username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
              $UserLoginId = $DataArray[0]['id'];
              $_SESSION['user_id'] = $UserLoginId ; 
              $_SESSION['username'] = $username ;
              $_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];
              $_SESSION['keepmelogin'] = '0';
              $_SESSION['user_type'] = 'user';
              $_SESSION['img'] =  $DataArray[0]['image_nm'] ;
              
              $_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
              $_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
              $_SESSION['country']=$DataArray[0]['country'];
              unset($_SESSION['token']);
              date_default_timezone_set('America/Los_Angeles');
              $current_time= date('Y-m-d H:i:s'); 
              $tdate=date('Y-m-d H:i:s');
              //echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
              mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
              //exit;
              //ob_start();
              
              session_write_close();
              $Obj->Redirect("index.php");
             
          }

          else
          {
              //die('else');
              $sql = "INSERT INTO `user` (`image_nm`,`hear_about`,`first_name`,`last_name`,`email`,`street`,`password`,`phone`,`user_address`,`country`,`state`,`zipcode`,`status`,`regi_date`,`DOB`,`city`,`plantype`,`longitude`,`latitude`) VALUES ('".$path."','facebook','".$user_fnmae."','".$user_lnmae."','".$user_email."','','','','','','','','1','".$today."','','','free','','') ";
              @mysql_query($sql);

              $sql1 = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
              $DataArray = $Obj->select($sql1) ;
              
              $UserLoginId = $DataArray[0]['id'];
              $username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
              $_SESSION['user_id'] = $UserLoginId ; 
              $_SESSION['username'] = $username ;
              $_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];
              $_SESSION['keepmelogin'] = '0';
              $_SESSION['user_type'] = 'user';
              $_SESSION['img'] =  $DataArray[0]['image_nm'] ;
              
              $_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
              $_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
              $_SESSION['country']=$DataArray[0]['country'];
              unset($_SESSION['token']);
              date_default_timezone_set('America/Los_Angeles');
              $current_time= date('Y-m-d H:i:s'); 
              $tdate=date('Y-m-d H:i:s');
              //echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
              mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
              //exit;
              //ob_start();
              
              session_write_close();

              $Obj->Redirect("index.php");

          }
      }  
  }
  else
  {
      $sql = "SELECT * FROM `clubs` WHERE club_email = '".$user_email."' ";
      $getemailquery = @mysql_query($sql);
      $countemail = @mysql_num_rows($getemailquery);
      $today = date("Y-m-d h:i:s");
      if($countemail > 0 )
      {
          $sql = "SELECT * FROM `clubs` WHERE club_email = '".$user_email."' ";
          $DataArray = $Obj->select($sql) ;
          $pieces = explode(" ", $DataArray[0]['club_name']);
          $username_dash_separated = implode("-", $pieces);
          
          $UserLoginId = $DataArray[0]['id'] ;
          $User = "Club";
          $_SESSION['user_id'] = $UserLoginId ;
          $_SESSION['user_club'] = $User ;
          $_SESSION['user_type'] = 'club';
          $_SESSION['username'] = $username_dash_separated ;
          $_SESSION['img'] =  $DataArray[0]['image_nm'] ;
          $_SESSION['keepmelogin'] = 0;
          $_SESSION['id']=$DataArray[0]['club_city'];// here we are storing city id of logged user
          $_SESSION['state']=$DataArray[0]['club_state']; // here we are storing state id of logged user
          $_SESSION['country']=$DataArray[0]['club_country'];
          
          date_default_timezone_set('America/Los_Angeles');
          $current_time= date('Y-m-d H:i:s'); 
          $tdate=date('Y-m-d H:i:s');
          mysql_query("update clubs set is_online='1', keepmelogin = '".$keepmelogin."' ,logged_date='".$tdate."' where id='".$UserLoginId ."'");
          
          session_write_close();
          $Obj->Redirect("home_club.php");
          
      }
      else
      {

          $ValueArray = array($path,'facebook',$user_fnmae,$user_lnmae,'','','',$user_email,'','','','','','','','','1','host_free','','');
          $FieldArray = array('image_nm','hear_about','first_name','last_name','club_name','type_of_club','type_details_of_club','club_email','password','club_address','club_contact_no','club_country','club_state','club_city','zip_code','google_map_url','status','plantype','longitude','latitude');
          $Success = $Obj->Insert_Dynamic_Query('clubs',$ValueArray,$FieldArray);
          $sql = "SELECT * FROM `clubs` WHERE club_email = '".$user_email."' ";
          $DataArray = $Obj->select($sql) ;
          $pieces = explode(" ", $DataArray[0]['club_name']);
          $username_dash_separated = implode("-", $pieces);
          
          $UserLoginId = $DataArray[0]['id'] ;
          $User = "Club";
          $_SESSION['user_id'] = $UserLoginId ;
          $_SESSION['user_club'] = $User ;
          $_SESSION['user_type'] = 'club';
          $_SESSION['username'] = $username_dash_separated ;
          $_SESSION['img'] =  $DataArray[0]['image_nm'] ;
          $_SESSION['keepmelogin'] = 0;
          $_SESSION['id']=$DataArray[0]['club_city'];// here we are storing city id of logged user
          $_SESSION['state']=$DataArray[0]['club_state']; // here we are storing state id of logged user
          $_SESSION['country']=$DataArray[0]['club_country'];
          
          date_default_timezone_set('America/Los_Angeles');
          $current_time= date('Y-m-d H:i:s'); 
          $tdate=date('Y-m-d H:i:s');
          mysql_query("update clubs set is_online='1', keepmelogin = '".$keepmelogin."' ,logged_date='".$tdate."' where id='".$UserLoginId ."'");
          
          session_write_close();
          $Obj->Redirect("home_club.php");
          
      }
  }
}




?>
<script>
                        window.fbAsyncInit = function() {
                            FB.init({
                            appId      : '688073574590787', // replace your app id here
                            channelUrl : 'https://mysittidev.com/user_social.php', 
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
                            var type = $('.logininner').find('input[type=radio]:checked').val();
                            if(type == '0')
                            {
                                var usertype = 'user';
                            }
                            else
                            {
                                var usertype = 'host';
                            }
                            FB.login(function(response){
                                if(response.authResponse){
                                    window.location.href = "sociallogin.php?action=fblogin&type="+usertype;
                                    // window.location.href = "user_social.php?action=fblogin";
                                }
                            }, {scope: 'email,user_likes,publish_stream'});
                        }

                        function FBLogout(){
                            FB.logout(function(response) {
                                //window.location.href = "index.php";
                            });
                        }

                    </script>
                   




<?php
	$adv_sql = mysql_query("select * from `advertise` where `status` = '1'");
	$advArray =mysql_fetch_array($adv_sql) ; 
	$adv_img= substr($advArray['adv_img'],6);
?>

    <?php include('header.php') ?>
    

     

	   		<?php 	
			$adv_left1 = @mysql_query("select * from `advertise` where page_name='login-left1'");
				$advleft1 =@mysql_fetch_array($adv_left1) ; 
				$left_img1 =substr($advleft1['adv_img'],6);
				$left_afl1 =$advleft1['affiliate-code'];
				$left_adv_link1 = $advleft1['adv_link'];  
				
				$adv_left2 = @mysql_query("select * from `advertise` where page_name='login-left2'");
				$advleft2 =@mysql_fetch_array($adv_left2) ; 
				$left_img2 =substr($advleft2['adv_img'],6);
				$left_adv_link2 = $advleft2['adv_link'];  
	?>
        
      
           <form action="main/login.php" method="post" onSubmit="return loginvalidate();" name="login" style="margin:0;">
         <!-- slider start -->
<section id="login">
  <div class="logo"><a href="/index.php"> <img src="images/logo.png" alt="logo"></a> </div>
  <h1 class="welcome">Account Login</h1>
  <div class="clear"></div>
  <div class="content logincontainer">
    <div class="adleft"> <a href="#"><?php if($advleft1['adv_type']=='image') {  ?>
         	<a href="<?php echo $left_adv_link1;?>" target="_blank">
         		<img src="<?php echo $left_img1; ?>" alt="Left Ad Top" />
            </a>
             <?php } else { 
          echo $advleft1['affiliate-code'];
     	    } ?>
     
           <?php if($advleft2['adv_type']=='image') {  ?>
             <!-- a href="<?php echo $left_adv_link2;?>" target="_blank">         	
             	<img src="<?php echo $left_img2; ?>" alt="Left Ad Bottom"  />
             </a -->
                <?php } else { 
          echo $advleft2['affiliate-code'];
     	    } ?> </div>
    <div class="loginbox">
      <div class="loginheader"> <img src="images/user1.png" alt="">
        <h1>Login As</h1>
      </div>
      <div class="logininner">
	 <?php
	   if($message!="")
	   {
	   ?>
      <p style="background-color:#FFCCFF; color:#FF0000;padding-left: 10px;"><?php echo $message; ?> </p> 
       <?php
     }
	 ?>
        
          <p> <span>
            <input name="user1" checked="checked" value="0" type="radio" class="standard">
            Standard User</span><span>
            <input name="user1" value="1" type="radio" class="standard"  >
            Host</span> </p>
            <p> <input name="uname" type="text" placeholder="Email" required="required"></p>
            <p> <input name="password" type="password" placeholder="Password" required="required"></p>
            <p> <input name="keepmelogin" type="checkbox" />&nbsp; Keep me login<span class="forgotpass"><a href="forget_pwd.php">Forgot Password <img src="images/quest_mark.png" alt=""> </a></span></p>
            <p> <input name="submit" type="submit" value="Login"></p>
            
            <p style="font-size:20px; text-align:center;">OR</p>
            <div style="text-align: center;" ><label class="sm_link"><span class="temp"> Login with your other <span class="blue">Accounts</span> </span>
            <span><img onClick="FBLogin();" src="images/fb-login.png"></a>
            <!-- <a href="http://mysittidev.com/sociallogin.php" ><img src="images/tw-login.png"></a> -->
            <?php 
            // echo "<pre>"; print_r($_SESSION); echo "</pre>";
                if(isset($authUrl)) //user is not logged in, show login button
                {
            ?>    
                  <a href="<?php echo $authUrl; ?>" target="blank"><img src="images/gp-login.png"></a></span></label><label class="sm_icon"></label>
            <?php } ?>
            </div>
           
        </form>
      </div>
    </div>
    <div class="adright"> <a href="#">
      <?php 	
	   $adv_right1 = @mysql_query("select * from `advertise` where page_name='login-right1'");
	$advright1 =@mysql_fetch_array($adv_right1) ; 
	$right_img1 =substr($advright1['adv_img'],6); 
	$right_adv_link1 = $advright1['adv_link']; 
	
	$adv_right2 = @mysql_query("select * from `advertise` where page_name='login-right2'");
	$advright2 =@mysql_fetch_array($adv_right2) ; 
	$right_img2 =substr($advright2['adv_img'],6);  
	$right_adv_link2 = $advright2['adv_link']; 
	?>
    <?php if($advright1['adv_type']=='image') {  ?>
         <a href="<?php echo $right_adv_link1;?>" target="_blank">
         <img src="<?php echo $right_img1; ?>" />
         </a>
          <?php } else { 
          echo $advright1['affiliate-code'];
     	    } ?>
        
           <?php if($advright2['adv_type']=='image') {  ?>
          <!-- a href="<?php echo $right_adv_link2;?>" target="_blank">
         <img src="<?php echo $right_img2; ?>" />
         </a -->
          <?php }
		   else { 
          echo $advright2['affiliate-code'];
     	    } ?></a> 
  </div>
</section>

<!-- aCCOUNT BUTTON start -->
<section class="accout">

<a href="/sign_up_option.php">Don't have an account ? Create Account</a>
</section>
          
       

    <?php include('footer.php') ?>

 <script type="text/javascript">
    $(document).ready(function(){
        var type = $('.logininner').find('input[type=radio]:checked').val();
        //alert(type);
          if(type == '0')
          {
              var usertype = 'user';
          }
          else
          {
              var usertype = 'host';
          }
          $.ajax({
              type: 'POST',
              url: 'setsession.php',
              data: {
                'type' : usertype,
              },
              success: function(data) {
                
              }
            });

          $('.logininner').find('input[type=radio]').click(function(){
            var type = $(this).val();
            if(type == '0')
            {
                var usertype = 'user';
            }
            else
            {
                var usertype = 'host';
            }
            $.ajax({
                type: 'POST',
                url: 'setsession.php',
                data: {
                  'type' : usertype,
                },
                success: function(data) {
                  
                }
              });
          });

    });
</script>