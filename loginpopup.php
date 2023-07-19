<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";
error_reporting(0);

if(isset($_GET['action']) && $_GET['action'] == 'logout')
{

	if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'club')
	{
		//commented by kbihm on 10-02-2015
		mysql_query("update clubs set is_online='0', keepmelogin = '0', streamingLaunch = '0',`streamingLaunchFrom` = '' where id='".$_SESSION['user_id'] ."'");

	} else {
		mysql_query("update user set is_online='0',keepmelogin = '0', streamingLaunch = '0',`streamingLaunchFrom` = '' where id='".$_SESSION['user_id'] ."'");

	}
	mysql_query("UPDATE `chat_users_groups` SET `loggedin` = '0' WHERE `user_id` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]' AND `loggedin` ='1'");


	session_destroy();
	unset($_SESSION['publicViewReport1']);
	$_SESSION['google_users_auth'] = "";
	$_SESSION['token_secret'] = ""; 
	$_SESSION['token'] = ""; 

	setcookie(session_name(), '', 100);
	// empty value and expiration one hour before
	if (isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie) {
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			setcookie($name, '', time()-1000);
			setcookie($name, '', time()-1000, '/');
		}
	}
	session_unset();
	$_SESSION = array();
	$_SESSION['registertype'] = '';
	$_SESSION['id'] = '54';

}

?>

<html lang="en">
	<head>
				
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<script src="<?php echo $SiteURL; ?>js/custom.js"></script>
		<link href="<?php echo $SiteURL; ?>css/v2style.css" rel="stylesheet" type="text/css">
		<link href="<?php echo $SiteURL; ?>css/styleNew.css" rel="stylesheet" type="text/css">
				
		<link href="<?php echo $SiteURL; ?>css/responsiveNew.css" rel="stylesheet"  type="text/css"> 
		
		<link href="<?php echo $SiteURL; ?>css/v1style.css" rel="stylesheet" type="text/css"> 
					
    
<?php

$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$dropdown_city = $get_city_name['city_name'];
$state_name_query = @mysql_query("select code,country_id,zone_id FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
$get_state_name = mysql_fetch_assoc($state_name_query);
$dropdown_state = $get_state_name['code'];

$LATITUDE = $get_city_name['lat'];
$LONGITUDE = $get_city_name['lng'];
$CITYID = $get_city_name['city_id'];
$_SESSION['state'] = $get_city_name['state_id'];
$_SESSION['country'] = $get_state_name['country_id'];


		?>
		
	</head>



	<body>
		<div class="">
		<header>
			<div class="container-fluid main-header">
				<div class="container">
					<div class="">
						<div class="col-sm-2 col-xs-6">
	                        <div class="log-in-new">
	                            <!--<a href="" id="v2_log_in" for="login">Log In</a>-->
	                            <label for="login" id="v2_log_in">Log In</label>
	                            <input type="checkbox" id="login">
	                            <!--<a href="" class="join-now-new signup" onclick="show_login_popop();">Join For Free</a>-->
	                            <input type="button" id="hidden_id" onclick="show_login_popop('first');" value="Join For Free" class="join-now-new signup">
	                        </div>
                    	</div>
					</div>
				</div>
			</div>
		</header>  

		
			<div id="v2_sign_up_after" class="v2_sign_up open" style="display: none;">
				<h1>Sign Up Here</h1>
				<a class="v2_close_signup" href="javascript:void(0);">close</a>
				<div class="clear"></div>
				<div class="v2_signup_tabcontainer"> 
					<!-- Tab panes -->
					<div class="v2_tab_content">
					<script type="text/javascript">
						function displayFields()
						{
							
							if($('input#hosttype').is(':checked'))
							{
								$('#userTYPE').val('club');
								$('#hostFieldsBlock').toggle();
							}
							else
							{
								$('#userTYPE').val('user');
								$('#hostFieldsBlock').toggle();
							}
							
						}

						$('.v2_close_signup').click(function(){
							
							$(".v2_sign_up").fadeOut('slow');
							$(".v2_signup_overlay").fadeOut('slow');
						});

						$(document).ready(function(){
							$('#otherCountry').click(function() {
								if($(this).is(":checked")) {
									$('.fromothercontry').addClass('opt2');
									$('#other1').fadeIn('slow');
								 	$('#other2').fadeIn('slow');
								  	$('#other3').fadeIn('slow');
								  	$('#zipcodeSignup').fadeOut('slow');

								}
								else
								{
									$('.fromothercontry').removeClass('opt2');
									$('#other1').fadeOut('slow');
									$('#other2').fadeOut('slow');
									$('#other3').fadeOut('slow');
									$('#zipcodeSignup').fadeIn('slow');
								}

							});
						});

						
					</script>
					<script type="text/javascript">
							alert(phid);
						</script>
					<div id="user">
					<form action="paymentoption.php" method="post" class="tab_standerd v2_user_reg" id="signupd" name="signupd" autocomplete="off" novalidate>
						
							<span class="v2_accept_terms">
								<span id="Businesscheck" class="aboutYou">
								<input type="checkbox" id="hosttype" name="hostTYPE" onclick="displayFields();" style="float:left;">
								<span>Are you an Artist or Local Business?</span>
								</span> 
							</span>
							<div class="clear"></div>
							<div id="hostFieldsBlock" style="display: none;"> 
								<p id="profilesName">
									<input type="text" required placeholder="Profile or Business Name" onblur="return ChkUserProfile(this.value,'user','https://mysitti.com/');" name="profilename" autocomplete="off" style="margin-top:5px;">
								</p>
								<p id="hostsFields">
									<select required="" name="host_category" id="host_category" style="margin-top:5px; ">
										<option value="">Select type of Business</option>
										<option value="108">Artist</option>
										<option value="91">Bar</option>
										<option value="92">Club</option>
										<option value="103">Fight</option>
										<option value="106">Fighter</option>
										<option value="107">Promoter</option>
										<option value="109">Promoter Artist</option>
										<option value="1">Restaurants</option>
										<option value="191">Rock</option>
										<option value="102">Theatre</option>
										<option value="104">Wedding</option>
									</select>
								</p>
							</div>
						<p>
							<input type="text" autocomplete="off" required placeholder="Email Address" onblur="return ChkUserId(this.value,'user','https://mysitti.com/');" name="email">
						</p>
						<!-- <p>
							<input type="text" required placeholder="Zip Code" maxlength="8" id="zipcodeSignup" name="zipcode" autocomplete="off">
						</p> -->
						
						<div class="clear"></div>
						<p>
							<input type="password" required placeholder="Password" id="password" name="password" autocomplete="off">
						</p>
						<p>
							<input type="password" required placeholder="Confirm Password" name="cpassword" autocomplete="off">
						</p>
						
						<div class="clear"></div>
						
							<div class="agreementTerms aboutYou">
							<div class="span">
								<input type="checkbox" value="1" id="acknowledgement" name="acknowledgement">
								<p class="term_policy">By clicking Sign Up, you agree to our <a onclick="javascript:window.open('terms_conditions.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Terms & Conditions</a> and <a onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Privacy Policy</a>. You may receive email notification from MySitti.com, but you can choose to opt out at any time.</p> 
							</div>
							</div>
						<div class="clear"></div>
						<input type="hidden" name="plantype" value="free">
						
						<!-- <input type="hidden" value="" name="captchcodeuser" id="captchacodeuser"> -->
						
						<input type="hidden" id="planid" name="planid" value="1">
						<input type="hidden" id="userTYPE" name="UserType" value="">
						<input type="submit" value="Sign Up" name="submit">
					</form>
					
				</div>
			</div>
			</div>
	</div>

<script src="<?php echo $CloudURL; ?>js/jquery.bxslider.js"></script>

<script src='<?php echo $CloudURL; ?>js/jqueryvalidationforsignup.js'></script>

<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="<?php echo $CloudURL; ?>lightbox/js/jquery.smooth-scroll.min.js"></script>


<div class="v2_signup_overlay" style="display: none;"></div>
<div class="v2_log_in">
	<h1>Login</h1>

	<a href="javascript:void(0);" class="v2_close_signup">close</a>

	<div class="ve_login_container">
		<style type="text/css">
		a#loginLogo:hover
		{
		box-shadow: none !important;
		}
		</style>
		<div class="v2_login_brand">
			<a href="<?php echo $SiteURL;?>index.php" id="loginLogo">
				<img src="images/v2_logo_round_1.png" alt="">
			</a>
		</div>

		<div class="clear"></div>

			<div class="v2_login_key">

			<?php if(isset($_GET['msg']) && $_GET['msg'] == 'error1'){ ?>

			<div class="V2_login_error">Please enter correct email and password to login</div>

			<?php } ?>

			<form id="mainlogin" name="login" action="<?php echo $SiteURL;?>main/login.php" method="POST">
				<p>
					<input type="text" name="uname"  placeholder="Email Address" required>
				</p>

				<div class="clear"></div>

				<p>

					<input type="password" name="password" id="password2" placeholder="Password" required>

				</p>

				<p>

				<div class="clear"></div>

				<input type="submit" name="submit" value="Login">

				</p>

			</form>


			<div class="clear"></div>

		</div> <p><a href="<?php echo $SiteURL; ?>forget_pwd.php">Forgot Password</a></p>

		<p class="cleataccount">Don't have a MySitti account?  <a href="#" onclick="show_login_popop(); return false;">Sign up now</a>

	</div>

</div>




<div class="v2_login_overlay"></div>


<script type="text/javascript">

function sendsession(id)
{ 
	$.get('send-invite.php?user_id='+id, function(data) {
		window.location='camstart.php?'+data;
	});
}


function popuploginSign()
{
	
	$('#host_category option[value=108]').prop('selected', true);
	$('#hostsFields').show();
	$('#hosttype').prop('checked', true);
	$('#userTYPE').val('Artist');
		
	var $aSelected = $('.v2_log_in');
	if( $aSelected.hasClass('close') )
	{ // .hasClass() returns BOOLEAN true/false
		$('.close').addClass('open').removeClass('close');
	}
	else
	{
		$('.v2_log_in').addClass('open');
	}
}

function popuploginSign_notlogin(val)
{
	if (val != '') {
		$('#host_category option[value="' + val + '"]').prop('selected', true);
		$('#hostsFields').show();
		$('#hosttype').prop('checked', true);
		$('#userTYPE').val('club');
	}
	
	var $aSelectedc = $('.v2_log_in');

	if( $aSelectedc.hasClass('close') ){ // .hasClass() returns BOOLEAN true/false

	  $('.close').addClass('open').removeClass('close');
	  $('.v2_sign_up').addClass('close').removeClass('open');
	  
	}else{

		$('.v2_log_in').addClass('open');
	}
}

function open_redirect_loginpopup_event(url)
{
	
	$.post('redirect_after_login_check.php', { 'set_store_redirect': true, 'successurl':url }, function(response){ });

	var $aSelected = $('.v2_log_in');
	$(".v2_signup_overlay").css('display', 'block');
	$(".v2_log_in").addClass('open');
	$(".v2_log_in").removeClass('close');
	$(".v2_sign_up").removeClass('open').addClass('close');
}

function openLoginpop(url)

{

	$.post('redirect_after_login_check.php', { 'set_store_redirect': true, 'successurl':url }, function(response){ });

	var $aSelected = $('.v2_log_in');
	$(".v2_signup_overlay").css('display', 'block');
	$(".v2_log_in").addClass('open');
	$(".v2_log_in").removeClass('close');
	$(".v2_sign_up").removeClass('open').addClass('close');
}

function show_login_popop(str)
{

	if(str == 'third')
	{
		$("#Businesscheck").hide();
		$("#hostFieldsBlock").hide();
		$('#userTYPE').val("user");
	} else {
		$("#Businesscheck").show();
		$('#userTYPE').val("user");
	}
	if(str == 'second')
	{
		$("#Businesscheck").hide();
		$("#hostFieldsBlock").show();
		$('#userTYPE').val("host");
		
		$("#host_category").val("108");

	}
	$(".v2_signup_overlay").fadeIn('slow');
	$('#v2_sign_up_after').fadeIn('slow');
	$(".v2_signup_overlay").css('display', 'block');

	$(".v2_sign_up").addClass('open').css('display','block');

	$(".v2_sign_up").removeClass('close');
	$(".v2_log_in").removeClass('open').addClass('close');
	
	return false;
}
</script>

	</body>

</html>
