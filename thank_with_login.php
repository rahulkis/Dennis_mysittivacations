<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require_once __DIR__ . "/depends/vendor/autoload.php";

print_r(get_included_files());die;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer;

//Enable SMTP debugging. 
$mail->SMTPDebug = 3;                               
//Set PHPMailer to use SMTP.
$mail->isSMTP();            
//Set SMTP host name                          
$mail->Host = "smtp.mail.us-east-1.awsapps.com";
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;                          
//Provide username and password     
$mail->Username = "vacations@mysittivacations.com";                 
$mail->Password = "VaSuPp0RT_L0G!NN";                           
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "ssl";                           
//Set TCP port to connect to 
$mail->Port = 465;                                   

$mail->From = "vacations@mysittivacations.com";
$mail->FromName = "MySittiVacations";

$mail->addAddress('kailash.chauhan@kindlebit.com', "Mysitti");

$mail->isHTML(true);

$str= '<div class="movableContent" style="border: 0px; padding-top: 0px;">
<table align="center" bgcolor="f2f2f2" border="0" cellpadding="0" cellspacing="0" class="MainContainer" width="650px">
	<tbody>
		<tr>
			<td>
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tbody>
					<tr>
						<td class="specbundle3"> </td>
						<td align="center" class="specbundle3">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tbody>
								<tr>
									<td valign="middle">
									<div class="contentEditableContainer contentTextEditable" style="padding: 10px;">
									<div class="contentEditable"><a href="https://mysitti.com/hotels/index.php" style="text-align:right; color: #010101;" target="_blank">Hotel</a></div>
									</div>
									</td>
									<td valign="middle">
									<div class="contentEditableContainer contentTextEditable" style="padding: 10px;">
									<div class="contentEditable"><a href="https://mysitti.com/flight/index.php" style="text-align:right; color: #010101;" target="_blank">Flight</a></div>
									</div>
									</td>
									<td valign="middle">
									<div class="contentEditableContainer contentTextEditable" style="padding: 10px;">
									<div class="contentEditable"><a href="mysitti.com/car-rentals.php" style="text-align:right; color: #010101;" target="_blank">Car Rentals</a></div>
									</div>
									</td>
									<td valign="middle">
									<div class="contentEditableContainer contentTextEditable" style="padding: 10px;">
									<div class="contentEditable"><a href="https://mysitti.com/restaurant-deals.php" style="text-align:right; color: #010101;" target="_blank">Restaurants</a></div>
									</div>
									</td>
									<td valign="middle">
									<div class="contentEditableContainer contentTextEditable" style="padding: 10px;">
									<div class="contentEditable"><a href="https://mysitti.com/yelp-tour.php" style="text-align:right; color: #010101;" target="_blank">Things To Do</a></div>
									</div>
									</td>
									<td valign="middle">
									<div class="contentEditableContainer contentTextEditable" style="padding: 10px;">
									<div class="contentEditable"><a href="https://mysitti.com/city-guide.php" style="text-align:right; color: #010101;" target="_blank">Audio Tours</a></div>
									</div>
									</td>VaSuPp0RT_L0G!NN
									<td valign="middle">
									<div class="view" style="position: relative; left: 7px;">
									<div class="view_online"><a href="https://mysitti.com" style="text-align:right; color: red; font-weight: 600; font-size: 18px;">view online</a></div>
									</div>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
		</tr>
	</tbody>
</table>
</div>
<!--<div class="movableContent" style="border: 0px; padding-top: 0px;"> </div>-->

<table align="center" border="0" cellpadding="0" cellspacing="0" height="109" width="650">
	<tbody>
		<tr>
			<td align="center" bgcolor="#429bd7" style="padding:11px;">
			<div class="contentEditableContainer contentTextEditable" style="min-height: 0px;">
			<div class="contentEditable" style="width: 80%; float: right;">
			<h2 style="color:#ffffff;font-size:20px; font-weight: 600;">Plan a Vacation. Plan a Night Out.</h2>

			<h3 style="color: #ffffff; font-size: 18px;">Plan Smarter!</h3>
			</div>

			<div class="logo" style="float: left; margin-left: 24px;"><a href="https://mysitti.com/" target="_blank"><img src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/v2_logo_round.png" style="height: 70px; width: 80px; margin-left: 10px; margin-right: 10px;" /></a></div>
			</div>
			</td>
		</tr>
	</tbody>
</table>
<!--<div class="checkout" style="border: 0px; padding-top: 0px; position: relative;background: red;"> </div>-->

<table align="center" border="0" cellpadding="0" cellspacing="0" width="650">
	<tbody>
		<tr>
			<td align="center" bgcolor="#ff0000" style="padding:11px;">
			<div class="checkout_all" style="min-height: 0px;">
			<div class="check">
			<h1 style="color:#ffffff;font-size:24px; font-weight: 700;">Welcome to Mysitti.com</h1>
			</div>
			</div>
			</td>
		</tr>
	</tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="650">
<tbody>
<tr>
	<td align="center" style="padding:11px;">
	<p style="color: #333333 !important; font-size: 17px; font-family: Arial, Helvetica, sans-serif; margin: 10px auto; padding: 0; text-shadow: 1px 1px 1px #fff; font-weight: normal;">Thank you for signing up with MySitti.com. From now on, you will get regular
updates on latest deal on flights, hotels, car rentals, concerts, sporting events, and
more.</p></br>


	<p style="color: #333333 !important; font-size: 17px; font-family: Arial, Helvetica, sans-serif; margin: 10px auto; padding: 0; text-shadow: 1px 1px 1px #fff; font-weight: normal;">Username:</br></p>
	<p style="color: #333333 !important; font-size: 17px; font-family: Arial, Helvetica, sans-serif; margin: 10px auto; padding: 0; text-shadow: 1px 1px 1px #fff; font-weight: normal;">Password:</p>
</td>
</tr>
<tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="650">
	<tbody>
		<tr>
			<td align="center" bgcolor="#f2f2f2">
			<div class="have_look" style="min-height: 0px; padding:10px;">
			<div class="have_a_look" style="background-color: #4472c4; width: 249px; border-radius: 5px;padding: 15px; cursor: pointer; "><a href="https://mysitti.com/index.php?login" style="text-align:center; color: #ffffff; font-size: 34px; font-weight: 700;" target="_blank"> Login</a></div>
			</div>
			</td>
		</tr>
	</tbody>
</table>
<!--<div class="look" style="border: 0px; padding-top: 0px; position: relative;"> </div>-->


<!--<div class="more_links" style="border: 0px; padding-top: 0px; position: relative;"> </div>-->

<table align="center" border="0" cellpadding="0" cellspacing="0" width="650">
	<tbody>
		<tr>
			<td valign="middle">
			<div class="tamplate_link" style="padding: 10px;">
			<div class="about_links"><a href="[CLIENTS.WEBSITE]/contact" style=" color: #010101; font-size: 16px; text-decoration: none;" target="_blank">More Hotels choices |</a></div>
			</div>
			</td>
			<td valign="middle">
			<div class="tamplate_link" style="padding: 10px;">
			<div class="about_links"><a href="[CLIENTS.WEBSITE]/contact" style=" color: #010101; font-size: 16px; text-decoration: none;" target="_blank">More Flights choices |</a></div>
			</div>
			</td>
			<td valign="middle">
			<div class="tamplate_link " style="padding: 10px;">
			<div class="about_links"><a href="[CLIENTS.WEBSITE]/contact" style=" color: #010101; font-size: 16px; text-decoration: none;" target="_blank">More Events tickets |</a></div>
			</div>
			</td>
			<td valign="middle">
			<div class="tamplate_link" style="padding: 10px;">
			<div class="about_links"><a href="[CLIENTS.WEBSITE]/contact" style=" color: #010101; font-size: 16px; text-decoration: none;" target="_blank">More Cars </a></div>
			</div>
			</td>
		</tr>
	</tbody>
</table>

<table align="center" border="0" cellpadding="0" cellspacing="0" style="text-align: center;" width="650">
	<tbody>
		<tr style=" display: inline-block; float: none; margin: 0 auto; text-align: center;  width: 50%;">
			<td height="" style="overflow: hidden; width: 1%;" width="50"><a href=""><img alt="img1" src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/apple.png" style="margin: 0px; padding: 10px; display: block; width: 40px; border-width: 0px; border-style: solid; height: 40px;" /></a></td>
			<td height="" style="overflow: hidden; width: 1%;" width="50"><a href=""><img alt="img1" src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/android.png" style="margin: 0px; padding: 10px; display: block; width: 40px; border-width: 0px; border-style: solid; height: 40px;" /></a></td>
			<td height="" style="overflow: hidden; width: 1%;" width="50"><a href=""><img alt="img1" src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/facebook_circle_black-512.png" style="margin: 0px; padding: 10px; display: block; width: 40px; border-width: 0px; border-style: solid; height: 40px;" /></a></td>
			<td height="" style="overflow: hidden; width: 1%;" width="50"><a href=""><img alt="img1" src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/t.png" style="margin: 0px; padding: 10px; display: block; width: 40px; border-width: 0px; border-style: solid; height: 40px;" /></a></td>
			<td height="" style="overflow: hidden; width: 1%;" width="50"><a href=""><img alt="img1" src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/y.png" style="margin: 0px; padding: 10px; display: block; width: 40px; border-width: 0px; border-style: solid; height: 40px;" /></a></td>
		</tr>
	</tbody>
</table>

<div class="footer" style="border: 0px; padding-top: 0px; position: relative; background-color: #429bd7; height: auto; padding-top: 27px; width: 650px;
            display: block; margin: 0 auto;
               ">
<table border="0" cellpadding="0" cellspacing="0" width="650px">
	<tbody>
		<tr>
			<td valign="middle">
			<div class="footers" style="margin-left: 5px;">
			<div class="dev_footers"><a href="https://mysitti.com/about_us.php" style=" color: #ffffff; font-size: 12px; text-decoration: none;    text-transform: capitalize; clear: both;" target="_blank">about us </a></div>
			</div>
			</td>
			<td valign="middle">
			<div class="footers" style="margin-left: 5px;">
			<div class="dev_footers"><a href="https://mysitti.com/copyright.php" style=" color: #ffffff; font-size: 12px; text-decoration: none;    text-transform: capitalize;" target="_blank">dmca policy </a></div>
			</div>
			</td>
			<td valign="middle">
			<div class="footers " style="margin-left: 5px;">
			<div class="dev_footers"><a href="https://mysitti.com/terms_conditions.php" style=" color: #ffffff; font-size: 12px; text-decoration: none;    text-transform: capitalize;" target="_blank">terms and conditions</a></div>
			</div>
			</td>
			<td valign="middle">
			<div class="footers" style="margin-left: 5px;">
			<div class="dev_footers"><a href="https://mysitti.com/policy.php" style=" color: #ffffff; font-size: 12px; text-decoration: none;    text-transform: capitalize;" target="_blank">privacy policy </a></div>
			</div>
			</td>
			<td valign="middle">
			<div class="footers" style="margin-left: 5px;">
			<div class="dev_footers"><a href="https://mysitti.com/other_terms_conditions.php" style=" color: #ffffff; font-size: 12px; text-decoration: none;    text-transform: capitalize;" target="_blank">other terms & conditions </a></div>
			</div>
			</td>
			<td valign="middle">
			<div class="footers" style="margin-left: 5px; ">
			<div class="dev_footers"><a href="[CLIENTS.WEBSITE]" style=" color: #ffffff; font-size: 12px; text-decoration: none;    text-transform: capitalize;" target="_blank">contact us </a></div>
			</div>
			</td>
		</tr>
	</tbody>
</table>

<table align="center" border="0" cellpadding="0" cellspacing="0" style="text-align: center;" width="650">
	<tbody>
		<tr style=" display: inline-block; float: none; margin: 0 auto; text-align: center;  width: 50%;">
			<td height="" style="overflow: hidden; width: 1%;" width="50"><a href="https://www.facebook.com/mysitti" target="_blank"><img alt="img1" src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/05.png" style="margin: 0px; padding: 10px; display: block; width: 65px; border-width: 0px; border-style: solid;" /></a></td>
			<td height="" style="overflow: hidden; width: 1%;" width="50"><a href="https://plus.google.com/u/0/111065459897703066867/about" target="_blank"><img alt="img1" src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/04.png" style="margin: 0px; padding: 10px; display: block; width: 65px; border-width: 0px; border-style: solid;" /></a></td>
			<td height="" style="overflow: hidden; width: 1%;" width="50"><a href="https://instagram.com/mysitti/" target="_blank"><img alt="img1" src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/03.png" style="margin: 0px; padding: 10px; display: block; width: 65px; border-width: 0px; border-style: solid;" /></a></td>
			<td height="" style="overflow: hidden; width: 1%;" width="50"><a href="https://twitter.com/MysittiCom" target="_blank"><img alt="img1" src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/02.png" style="margin: 0px; padding: 10px; display: block; width: 65px; border-width: 0px; border-style: solid;" /></a></td>
			<td height="" style="overflow: hidden; width: 1%;" width="50"><a href="https://www.youtube.com/channel/UCxCROSO5kbVn9Z-Sifw-LqA" target="_blank"><img alt="img1" src="https://mysitti.com/mailer/latest/frontend/assets/files/customer/vc395l3fan39a/01.png" style="margin: 0px; padding: 10px; display: block; width: 65px; border-width: 0px; border-style: solid;" /></a></td>
		</tr>
	</tbody>
</table>

<h2 style="color: #edca93; font-size: 15px; text-align: center;">©2018Mysitti.com</h2>
</div>';
$mail->Subject = "Mysitti login details";
$mail->Body = $str;
// $mail->AltBody = "This is the plain text version of the email content";

if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 
{
    echo "Message has been sent successfully";
}