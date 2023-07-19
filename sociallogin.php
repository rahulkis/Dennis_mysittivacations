<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Social Login";

if(isset($_GET['type']))
{
    $usertype= $_GET['type'];

    $_SESSION['registertype'] = $usertype; 


}
else
{
    $_SESSION['registertype'] = 'user';
}

if(isset($_SESSION['user_id']))
{
    $Obj->Redirect("index.php");
}

include 'login/facebook.php';
    $appid      = "688073574590787";
    $appsecret  = "acdbc4b9054bbc4c7e318b42a05d92fd";

    $facebook   = new Facebook(array(
        'appId' => $appid,
        'secret' => $appsecret,
        'cookie' => TRUE,
    ));
    $fbuser = $facebook->getUser();
    if ($fbuser) 
    {
        try 
        {
            $user_profile = $facebook->api('/me');
        }
        catch (Exception $e) 
        {
            $facebook->destroySession();
            error_log($e);
            $fbuser = null;
        }



        $user_fbid  = $fbuser;
       
        $user_email = $user_profile["email"];
        $user_fnmae = $user_profile["first_name"];
        $user_lnmae = $user_profile["last_name"];
        $user_image = "https://graph.facebook.com/".$user_fbid."/picture?type=large";
        $profileimagename = $user_fnmae."_test.jpg";
        
        if($user_email == '')
        {
            $Obj->Redirect('main/logout.php');
            die;
        }


        $path = "upload/".$profileimagename;
        if(!file_exists($path))
        {
            copy($user_image,$path);
        }
        if($_SESSION['registertype'] == 'user')
        {
            $sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
            $getemailquery = @mysql_query($sql);
            $countemail = @mysql_num_rows($getemailquery);
            $today = date("Y-m-d h:i:s");
            if($countemail > 0 )
            {
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
            
                // date_default_timezone_set('America/Los_Angeles');
                $current_time= date('Y-m-d H:i:s'); 
                $tdate=date('Y-m-d H:i:s');
                //echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
                mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
                //exit;
                //ob_start();
                
                session_write_close();
                $Obj->Redirect("home_user.php");
                die;
               
            }
            else
            {
                $ValueArray = array($path,'facebook',$user_fnmae,$user_lnmae,$user_email,'','','','','','','1',$today,'','','free','','');
                $FieldArray = array('image_nm','hear_about','first_name','last_name','email','password','phone','user_address','country','state','zipcode','status','regi_date','DOB','city','plantype','longitude','latitude');     
                $Success = $Obj->Insert_Dynamic_Query('user',$ValueArray,$FieldArray);
                $sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
                $DataArray = $Obj->select($sql) ;
                
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
            
                // date_default_timezone_set('America/Los_Angeles');
                $current_time= date('Y-m-d H:i:s'); 
                $tdate=date('Y-m-d H:i:s');
                //echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
                mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
                //exit;
                //ob_start();
                
                session_write_close();

                $Obj->Redirect("home_user.php");
                die;

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
                
                // date_default_timezone_set('America/Los_Angeles');
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
                
                // date_default_timezone_set('America/Los_Angeles');
                $current_time= date('Y-m-d H:i:s'); 
                $tdate=date('Y-m-d H:i:s');
                mysql_query("update clubs set is_online='1', keepmelogin = '".$keepmelogin."' ,logged_date='".$tdate."' where id='".$UserLoginId ."'");
                
                session_write_close();
                $Obj->Redirect("home_club.php");
                
            }


        }   
    }   
   
include 'googletest.php';


require 'instagram/instagram.class.php';
require 'instagram/instagram.config.php';
// Login URL
$loginUrl = $instagram->getLoginUrl();



include('header_start.php') ;
include('header.php') ?>
<section id="social">
    <div class="logo">
        <a href="/index.php">
            <img src="images/logo.png" alt="logo">
        </a> 
    </div>
    <h1 class="welcome">You Can Also Login With:</h1>
    <div class="clear"></div>
        <div class="content logincontainer">
            <div class="loginbox">
                <div class="socialinner">
                    <script>
                        window.fbAsyncInit = function() {
                            FB.init({
                            appId      : '1027910397223837', // replace your app id here
                            channelUrl : 'https://mysitti.com/user_social.php', 
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
                            var type = '<?php echo $usertype; ?>';
                            FB.login(function(response){
                                if(response.authResponse){
                                    window.location.href = "sociallogin.php?action=fblogin&type="+type;
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
                    <div class="social-innerarea-fb">
                        <div class="social-innerarea-fb-lft">
                            <p></p>
                        </div>
                        <div class="social-innerarea-fb-ryt" onclick="FBLogin();">
                            <p>Login with Facebook</p>
                        </div>
                    </div>
        <!--         
                    <div class="social-innerarea-tw">
                        <div class="social-innerarea-tw-lft">
                            <p></p>
                        </div>
                        <div class="social-innerarea-tw-ryt">
                            <p>Login with Twitter</p>
                        </div>
                    </div> -->
                   <!--  <div class="social-innerarea-tw">
                        <div class="social-innerarea-tw-lft">
                            <p></p>
                        </div>
                        <div class="social-innerarea-tw-ryt">
                            <p><?php //echo "<a style='text-decoration: none; color: #FFF;' href='".$loginUrl."'>Login with Instagram </a>"; ?></p>
                        </div>
                    </div>
 -->


                    <?php   
                        if(isset($authUrl)) //user is not logged in, show login button
                        {

                    ?>
                    <div class="social-innerarea-gplus">
                        <div class="social-innerarea-gplus-lft">
                            <p></p>
                        </div>
                        <div class="social-innerarea-gplus-ryt">
                            <p><?php echo '<a style="text-decoration: none; color: #FFF;" class="" href="'.$authUrl.'">Login with Google+</a></p>';?>
                        </div>
                    </div>
                    <?php 
                        }
                        else
                        {
                            $user_email = $user['email'];
                            $user_fnmae = $user['given_name'];
                            $user_lnmae = $user['family_name'];
                            $profileimagename = $user['given_name'].$user['family_name']."_test.jpg";
                            //die('dfdfdfdfdf');
                            $path = "upload/".$profileimagename;
                            if(!file_exists($path))
                            {
                                copy($profile_image_url,$path);
                            }
                            if(($_SESSION['registertype'] == 'user')  )
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
                                        // date_default_timezone_set('America/Los_Angeles');
                                        $current_time= date('Y-m-d H:i:s'); 
                                        $tdate=date('Y-m-d H:i:s');
                                        //echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
                                        mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
                                        //exit;
                                        //ob_start();
                                        
                                        session_write_close();
                                        $Obj->Redirect("home_user.php");
                                       
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
                                        // date_default_timezone_set('America/Los_Angeles');
                                        $current_time= date('Y-m-d H:i:s'); 
                                        $tdate=date('Y-m-d H:i:s');
                                        //echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
                                        mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
                                        //exit;
                                        //ob_start();
                                        
                                        session_write_close();

                                        $Obj->Redirect("home_user.php");

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
                                    
                                    // date_default_timezone_set('America/Los_Angeles');
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
                                    
                                    // date_default_timezone_set('America/Los_Angeles');
                                    $current_time= date('Y-m-d H:i:s'); 
                                    $tdate=date('Y-m-d H:i:s');
                                    mysql_query("update clubs set is_online='1', keepmelogin = '".$keepmelogin."' ,logged_date='".$tdate."' where id='".$UserLoginId ."'");
                                    
                                    session_write_close();
                                    $Obj->Redirect("home_club.php");
                                    
                                }
                            }
                        } 



                    ?>
                    
                    <p class="new1">OR</p>
                    <div class="social-innerarea-crt-acnt">
                        <div class="social-innerarea-crt-acnt-lft">
                            <p></p>
                        </div>
                        <div class="social-innerarea-crt-acnt-ryt">
                            <?php
                            
                                if($usertype == 'user')
                                {
                                    echo '<p><a style="text-decoration: none; color: #FFF;" href="/sign_up.php?plan=free#tabs1-html">Create New Account</a></p>';
                                }
                                
                                
                                if($usertype == 'host')
                                {
                                    echo '<p><a style="text-decoration: none; color: #FFF;" href="/sign_up.php?plan=host_free#tabs1-js">Create New Account</a></p>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

                    

<?php include('footer.php') ?>

