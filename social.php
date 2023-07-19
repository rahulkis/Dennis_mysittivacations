<?php
include("Query.Inc.php");
$Obj = new Query($DBName);


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
include('headhost.php');
?>



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
<section id="social">
  <div class="logo"><a href="/index.php"> <img src="images/logo.png" alt="logo"></a> </div>
  <h1 class="welcome">You Can Also Login With:</h1>
  <div class="clear"></div>
  <div class="content logincontainer">
    <!--<div class="adleft"> <a href="#"><?php if($advleft1['adv_type']=='image') {  ?>
         	<a href="<?php echo $left_adv_link1;?>" target="_blank">
         		<img src="<?php echo $left_img1; ?>" alt="Left Ad Top" />
            </a>
             <?php } else { 
          echo $advleft1['affiliate-code'];
     	    } ?>
     
           <?php if($advleft2['adv_type']=='image') {  ?>
             <!-- a href="<?php echo $left_adv_link2;?>" target="_blank">         	
             	<img src="<?php echo $left_img2; ?>" alt="Left Ad Bottom"  />
             </a 
                <?php } else { 
          echo $advleft2['affiliate-code'];
     	    } ?> </div>-->
    <div class="loginbox">
      <!--<div class="loginheader"> <img src="images/user1.png" alt="">
        <h1>Login As</h1>
      </div>-->
      <div class="socialinner">
	 <?php
	   if($message!="")
	   {
	   ?>
      <!--<p style="background-color:#FFCCFF; color:#FF0000;padding-left: 10px;"><?php echo $message; ?> </p> -->
       <?php
     }
	 ?>
        
          <!--<p> <span>
            <input name="user1" checked="checked" value="0" type="radio" class="standard">
            Standard User</span><span>
            <input name="user1" value="1" type="radio" class="standard"  >
            Host</span> </p>-->
            <!--<p> <input name="uname" type="text" placeholder="Email" required="required"></p>
            <p> <input name="password" type="password" placeholder="Password" required="required"></p>
            <p> <input name="keepmelogin" type="checkbox" />&nbsp; Keep me login</p>
            <p> <input name="submit" type="submit" value="Login"><span class="forgotpass"><a href="forget_pwd.php">Forgot Password <img src="images/quest_mark.png" alt=""> </a></span></p>-->
            
            
        </form>
        <div class="social-innerarea-fb">
        	<div class="social-innerarea-fb-lft">
            <p></p>
            </div>
            <div class="social-innerarea-fb-ryt">
            <p>Login with Facebook</p>
            </div>
        </div>
        
        <div class="social-innerarea-tw">
        	<div class="social-innerarea-tw-lft">
            <p></p>
            </div>
            <div class="social-innerarea-tw-ryt">
            <p>Login with Twitter</p>
            </div>
        </div>
        
        <div class="social-innerarea-gplus">
        	<div class="social-innerarea-gplus-lft">
            <p></p>
            </div>
            <div class="social-innerarea-gplus-ryt">
            <p>Login with Google+</p>
            </div>
        </div>
        <p class="new1">OR</p>
        <div class="social-innerarea-crt-acnt">
        	<div class="social-innerarea-crt-acnt-lft">
            <p></p>
            </div>
            <div class="social-innerarea-crt-acnt-ryt">
            <p>Create New Account</p>
            </div>
        </div>
        
      </div>
    </div>
   <!-- <div class="adright"> <a href="#">
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
         </a 
          <?php }
		   else { 
          echo $advright2['affiliate-code'];
     	    } ?></a> 
  </div>-->
</section>

<!-- aCCOUNT BUTTON start -->
<!--<section class="accout">

<a href="/sign_up_option.php">Don't have account create Account</a>
</section>-->
          
       

    <?php include('footer.php') ?>

