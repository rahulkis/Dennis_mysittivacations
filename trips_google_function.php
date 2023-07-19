<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
//ob_start("ob_gzhandler");
//include("Query.Inc.php");
$Obj = new Query($DBName);
$db_connection = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 

/*if(isset($_SESSION['login_id'])){
    header('Location: trips.php');
    exit;
}
*/
require 'google-api/vendor/autoload.php';

// Creating new google client instance
$client = new Google_Client();

// Enter your Client ID
$client->setClientId('398701250205-a117l6254nng79ebfi0110g9i7is6it5.apps.googleusercontent.com');
// Enter your Client Secrect
$client->setClientSecret('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');
// Enter the Redirect URL
$client->setRedirectUri('https://www.mysittivacations.com/trips.php');



// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");


if(isset($_GET['code'])):

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if(!isset($token["error"])){

        $client->setAccessToken($token['access_token']);

        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
    
        // Storing data into database
        $id = mysqli_real_escape_string($db_connection, $google_account_info->id);
        $full_name = mysqli_real_escape_string($db_connection, trim($google_account_info->name));
        $email = mysqli_real_escape_string($db_connection, $google_account_info->email);
        $profile_pic = mysqli_real_escape_string($db_connection, $google_account_info->picture);

        // checking user already exists or not
        $get_user = mysqli_query($db_connection, "SELECT `google_id` FROM `user` WHERE `google_id`='$id'");
        if(mysqli_num_rows($get_user) > 0){

            $_SESSION['login_id'] = $id; 
            header('Location: trips.php');
             $_SESSION['username'] = $email;
            exit;

        }
        else{

            // if user not exists we will insert the user
            $insert = mysqli_query($db_connection, "INSERT INTO `user`(`google_id`,`first_name`,`email`,`image_nm`) VALUES('$id','$full_name','$email','$profile_pic')");

            if($insert){
                $_SESSION['login_id'] = $id; 
                header('Location: trips.php');
                exit;
            }
            else{
                echo "Sign up failed!(Something went wrong).";
            }

        }

    }
    else{
        header('Location: login.php');
        exit;
    }
    
else: 
    // Google Login Url = $client->createAuthUrl(); 
?>
  <a href="<?php echo $client->createAuthUrl(); ?>" class="national_pas btn btn-outline-dark d-block px-4 mt-4" ><img src="https://static.tacdn.com/img2/google/G_color_40x40.png" class="regGoogleIcon" alt=""> Continue with Google</a>

   <!--  <a class="login-btn" href="<?php echo $client->createAuthUrl(); ?>">Login</a> -->

<?php endif; ?>