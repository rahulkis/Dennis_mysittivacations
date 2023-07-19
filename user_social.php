<?php

include("Query.Inc.php");

$Obj = new Query($DBName);



if(!isset($_SESSION['user_id']))

{

	header('Location: index.php');

}



// ini_set("display_errors", "1");

// error_reporting(E_ALL);

$titleofpage = "Social Media Sites";



include('HeaderHost.php');





/*******************************  INSTAGRAM LOGOUT CODE  ***********************************/



if(isset($_GET['action']) && $_GET['action'] == 'insta_logout'){

	unset($_SESSION['instadetails']);

	header('Location: '.$SiteURL.'user_social.php');

}



/*******************************  INSTAGRAM LOGOUT CODE  ***********************************/







/*******************************  TWITTER SHARE CODE  ***********************************/



if(isset($_GET['action']) && $_GET['action'] == 'twitter_logout'){

	unset($_SESSION['request_vars']);

	

	header('Location: '.$SiteURL.'user_social.php');

}



/*******************************  TWITTER SHARE CODE  ***********************************/



/*******************************  FACEBOOK SHARE CODE  ***********************************/



if(isset($_GET['action']) && $_GET['action'] == 'fb_logout'){

	

	unset($_SESSION['FBRLH_state']);

	unset($_SESSION['fb_token']);

	unset($_SESSION['facebook_access_token']);

	

	header('Location: '.$SiteURL.'user_social.php');

}



if(isset($_GET['code']) && isset($_GET['state']))

{

	$_SESSION['FBRLH_state'] = $_GET['state'];

}

// include required files form Facebook SDK

require_once 'FacebookV5/autoload.php';



$fb = new Facebook\Facebook([

	'app_id' => '1027910397223837',

	'app_secret' => '00175be1ff4053b4cb22bca7b51b947a',

	'default_graph_version' => 'v2.10',

]);





$permissions = ['email', 'user_posts','publish_actions']; // optional

$redirect_url = $SiteURL.'AllSocial.php';

$callback = $SiteURL.'user_social.php';





/*******************************  FACEBOOK SHARE CODE  ***********************************/







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







// echo "<pre>"; print_r($_SESSION); echo "</pre>";

// require 'instagram/instagram.class.php';

// $instagram = new Instagram(array(

//     'apiKey'      => '92f139720df84559ab02e9a5b3ddad94',

//     'apiSecret'   => '20a722870a9d4a0cabe4c85345d21a23',

//     'apiCallback' => 'https://mysittidev.com/AllSocial.php' // must point to success.php

//   ));



require_once 'InstagramSDK/src/Instagram.php';

	$instagram = new Instagram(array(

		'apiKey'      => '92f139720df84559ab02e9a5b3ddad94',

		'apiSecret'   => '20a722870a9d4a0cabe4c85345d21a23',

		'apiCallback' => 'https://mysittidev.com/AllSocial.php'

	));







?>

<div class="clear"></div>

<div class="v2_container">

	<div class="v2_inner_main">

	<!-- SIDEBAR CODE  -->

	<?php 

		if($_SESSION['user_type'] == 'club')

    		{

    			include('club-right-panel.php');

    		}

    		else

    		{

    			 include('friend-right-panel.php');

    		}

	?>

	<!-- END SIDEBAR CODE -->

		<article class="forum_content v2_contentbar">

			<div class="v2_rotate_neg">

				<div class="v2_rotate_pos">

					<div class="v2_inner_main_content">

  						<h3 id="title" class="botmbordr">Login to your social media sites to send shout-out </h3>

					             <?php

							if($message!="")

							{

					   	?>

						      		<div style="background-color:#6F9; color:#FF0000"><?php echo $message; ?> </div> 

					       <?php     	} ?>

						<div class="profileright">

					                    	<div id="profile_box" >

								<span class="mediabanner">

									<img src="images/mediabanner.png" al="">
									<h2>Stay Connected</h2>

									<h3>Social Media</h3>
									<p style="color: black;"> We know how integral social media is to our live. MySitti has created a social media page that allows you to check your Facebook, Twitter, and Instagram all on one page.</p>

								</span>

						       		<form name="add_adv" method="post" class="c_social_link"   enctype="multipart/form-data" onSubmit="return validate_adv();">

								    	<ul class="facebook">

										<li>

											<?php

											$helperNew = $fb->getRedirectLoginHelper();

											if(!isset($_SESSION['facebook_access_token']))

											{

												

												$accessToken = $helperNew->getAccessToken();

											}

											elseif(isset($_SESSION['facebook_access_token']) && empty($_SESSION['facebook_access_token']))

											{

												

												$accessToken = $helperNew->getAccessToken();

											}

											else

											{

												$accessToken = $_SESSION['facebook_access_token'];

											}

											if (isset($accessToken)) 

											{

												// User authenticated your app!

												// Save the access token to a session and redirect

												$_SESSION['facebook_access_token'] = (string) $accessToken;

											    $_SESSION['fb_token'] = $accessToken;

												// Log them into your web framework here . . .

												// Redirect here . . .

												$response = $fb->get('/me', $accessToken);

												$graphNode = $response->getGraphNode();



												// Get the response typed as a GraphUser

												$user = $response->getGraphUser();



												// Get the response typed as a GraphPage

												$page = $response->getGraphPage();



												$logoutUrl = $helperNew->getLogoutUrl();  

												//$Obj->Redirect('AllSocial.php');

											?>

							  

											<a class="fblogin" href="<?php //echo  $helper->getLoginUrl( array( 'email', 'user_friends' ) ); ?>"><span>Logged in as <b><?php echo $user->getName(); ?></b></span></a>

											

											<a class="fblogin fblogout_social" href="<?php echo $logoutUrl.'next='.$base_url; ?>user_social.php?action=fb_logout&access_token=<?php echo $_SESSION['fb_token']; ?>">Logout</a>

											

											<?php

											  

											} else {


												$loginUrl = $helperNew->getLoginUrl($callback, $permissions);



											 ?>

											  <a class="fblogin" href="<?php echo $loginUrl; ?>"><span>Login with <b>FACEBOOK</b></span></a>



											<?php  } ?>

						           				</li>

						         			</ul>

									<ul class="twitter">

						           				<li>

											<a href="twitter/process.php" class="twlogin">Connect Using TWITTER</a>

											<p style="margin:0px;"> 

											<?php if(isset($_SESSION['request_vars']['screen_name'])) { ?> You Logged in As :  <?php echo  $_SESSION['request_vars']['screen_name']; }?>  </p>

											

											<?php if(isset($_SESSION['request_vars'])){ ?>

											

												<a class="fblogin fblogout_social twlogout" href="<?php echo $base_url; ?>user_social.php?action=twitter_logout">Logout</a>

							           

											<?php } ?>

								    		</li>

						        			</ul>

						        			<div class="clear"></div>

						        			<ul class="instagram">

						        				<li>

						        				<?php 

						        					if(!isset($_SESSION['instadetails']))

						        					{

						        						$instaURL = $instagram->getLoginUrlInsta(array('basic','likes','comments','public_content'));

						        				?>		<a href="<?php echo $instaURL; ?>"> <span>Login with <b>INSTAGRAM</b></span> </a>

						        				<?php 

						        					}

						        					else

						        					{

						        						$data = $_SESSION['instadetails'];

						        						$user=$data->user->username;

						        				?>

						        					<a style="padding: 5px 0;" class="fblogin" href="javascript:void(0);"><span>Logged in as <b><?php echo $user ?></b></span></a>

											

													<a style="padding: 5px 0;background-image: none;" onclick="instaLogout();" class="fblogin fblogout_social" href="javascript:void(0);">Logout</a>

											<?php 	}	?>



						        				</li>

						        			</ul>

						        			<ul class="pinterest" style="display:none">

						        				<li>

						        					<a href="https://pinterest.com/oauth/authorize/?client_id=4836597041438147236&redirect_uri=https://mysittidev.com/AllSocial.php&scope=read" target="_blank"> <img src="instagram.png"> </a>

						        				</li>

						        			</ul>



						        						

						     		</form>

						         	</div>

					             </div>

  					</div>

  				</div>

			</div>

			<div class="equalizer"></div>

		</article>

	</div>

	<div class="clear"></div>

</div>

<script type="text/javascript">

	function instaLogout()

	{

		jQuery('body').append('<div style="display:none"><iframe src="https://instagram.com/accounts/logout/" width="0" height="0"></iframe></div>');

		setTimeout(function(){

			window.location.href = '?action=insta_logout';	

		},2000);

		

	}

</script>

<?php include('Footer.php') ?>
