<?php

include("Query.Inc.php");

$Obj = new Query($DBName);



if(!isset($_SESSION['user_id'])){

	$Obj->Redirect("login.php");

}



$base_url = "https://" . $_SERVER['SERVER_NAME']."/";



/*******************************  FACEBOOK SHARE CODE  ***********************************/



require_once 'facebook-php-sdk-v4-4.0-dev/autoload.php';



use Facebook\FacebookSession;

use Facebook\FacebookRequest;



FacebookSession::setDefaultApplication( FBAPPID,FBAPPSECRET );



/*******************************  FACEBOOK SHARE CODE  ***********************************/



$titleofpage="Paid Passes";



if(isset($_GET['host_id']))

{

	include('NewHeadeHost.php');

}

else

{

	include('NewHeadeHost.php');	

}



$userType= $_SESSION['user_type'];

$userID = $_SESSION['user_id'];



if(isset($_GET['host_id']))

{

	$HostID = $_GET['host_id'];

}

else

{

	$HostID = $userID;

}

$sql_fe=mysql_query("SELECT  * FROM `paid_passes` WHERE `host_id`='$HostID' ");

$rw_row_fe=@mysql_fetch_assoc($sql_fe);



/******************/

if(isset($_POST['update']))

{

	

	$pass_id = $_POST['pass_id'];

	$pass_name = $_POST['cname'];

	$pass_expiry_date = $_POST['c_exp_date'];

	$host_id = $_SESSION['user_id'];

	

	if($_FILES['update_adv_img']['error'] == 4)

	{

		$pass_thumb = $_POST['pass_thumb'];

		$pass_image = $_POST['pass_image'];

	

	}

	else

	{

		//        // get total count of downloaded coupon

		//	$tot_cu_cnt=@mysql_query("select id from  coupon_download where coupon_id='".$rw_row_fe['id']."' ");

		//	$cu_num=@mysql_num_rows($tot_cu_cnt);

		// 	end here 

		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");

		$temp = explode(".", $_FILES["update_adv_img"]["name"]);

		$extension = end($temp);

		$name = $_FILES["update_adv_img"]["name"];

		$ext =substr($name,strrpos($name,'.'));

		$u_video = strtotime(date("Y-m-d"))."_".$_FILES["update_adv_img"]["name"];



		$tmp = $_FILES["update_adv_img"]["tmp_name"]; 

		$v_name = "upload/coupon/".$u_video;

		$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$u_video."_thumbnail".$ext;

		$thumbnail = "upload/coupon/".$thumb;

		//$image_path="upload/".$thumb; 

		move_uploaded_file($tmp,$v_name);



		$file = $v_name;

		

		//indicate the path and name for the new resized file

		$resizedFile = $thumbnail;

		

		//call the function (when passing path to pic)

		//	smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );

		//call the function (when passing pic as string)

		//	smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );



		$resizeObj = new resize($file);



		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)

		$resizeObj -> resizeImage(300,200, 'auto');



		// *** 3) Save image ('image-name', 'quality [int]')

		$resizeObj -> saveImage($resizedFile, 100);	

		$image=$u_video;

		

		$pass_thumb = $thumbnail;

		$pass_image = $image;

	}

	

	$updt_pass = @mysql_query("UPDATE `paid_passes` SET `amount` = '$_POST[amount]' ,`no_of_tickets` = '$_POST[max_download]', `coupon_name` = '$pass_name', `pass_image` = '$pass_image', `pass_thumb` = '$pass_thumb',`expiry_date` = '$pass_expiry_date' WHERE `pass_id` = '$pass_id' ");

	

	/*******************************  FACEBOOK SHARE CODE  ***********************************/

			

	if(isset($_SESSION['fb_token']))

	{

		if(!empty($pass_thumb))

		{

			$shout_img = $base_url.$pass_thumb;

		}

		else

		{

			$shout_img = $base_url."images/logo.jpg";

		}

		$session = new FacebookSession( $_SESSION['fb_token'] );

				

		// graph api request for user data

		$request = new FacebookRequest( $session, 'POST', '/me/feed', array(

				'name' => $_POST['cname'],

				'caption' => 'mysittidev.com',

				'link' => 'https://mysittidev.com',

				'message' => 'New Pass',

				'picture' => $shout_img

			 ) );

		$response = $request->execute();

	}

			

	/*******************************  FACEBOOK SHARE CODE  ***********************************/

			

	/** TWITTER POST SHARE **/

			

	if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 

	{

		include_once("twitter/config.php");

		include_once("twitter/inc/twitteroauth.php");

		

		//Success, redirected back from process.php with varified status.

		//retrive variables

		$screenname 		= $_SESSION['request_vars']['screen_name'];

		$twitterid 			= $_SESSION['request_vars']['user_id'];

		$oauth_token 		= $_SESSION['request_vars']['oauth_token'];

		$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];

	

		//Show welcome message

		echo '<div class="welcome_txt">Welcome <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php?reset=1">Logout</a>!</div>';

		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);

		

		//see if user wants to tweet using form.

		if(isset($_POST["cname"])) 

		{

			//Post text to twitter

			$my_update = $connection->post('statuses/update', array('status' => $_POST["cname"]));

			//die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php

		}

	}

			

	/**TWITTER POST SHARE**/				

	

	if($updt_pass == 1)

	{

		header('Location: paidPasses.php?msg=updated');

		exit;			

	}

}



if(isset($_POST['submit']))

{

	if($_FILES["adv_img"]["name"])

	{

			// get total count of downloaded coupon

		$tot_cu_cnt=@mysql_query("SELECT `pd_id` FROM `paid_pass_download` WHERE `pass_id` = '$rw_row_fe[pass_id]' ");

		$cu_num=@mysql_num_rows($tot_cu_cnt);

		// end here 

		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");

		$temp = explode(".", $_FILES["adv_img"]["name"]);

		$extension = end($temp);

		$name = $_FILES["adv_img"]["name"];

		$ext =substr($name,strrpos($name,'.'));

		$u_video = strtotime(date("Y-m-d"))."_".$_FILES["adv_img"]["name"];

		$tmp = $_FILES["adv_img"]["tmp_name"]; 

		$v_name = "upload/coupon/".$u_video;

		$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$u_video."_thumbnail".$ext;

		$thumbnail = "upload/coupon/".$thumb;

		//$image_path="upload/".$thumb; 

		move_uploaded_file($tmp,$v_name);

		$file = $v_name;

		

		//indicate the path and name for the new resized file

		$resizedFile = $thumbnail;

		

		//call the function (when passing path to pic)

		//smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );

		//call the function (when passing pic as string)

		//smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );



		$resizeObj = new resize($file);



		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)

		$resizeObj -> resizeImage(300,200, 'auto');



		// *** 3) Save image ('image-name', 'quality [int]')

		$resizeObj -> saveImage($resizedFile, 100);	

		

		$image=$u_video;

	}

		

	$sql_ck=@mysql_query("SELECT `pass_id` FROM `paid_passes` WHERE `host_id` = '$HostID' ");

	$rw_row=@mysql_num_rows($sql_ck);

	$added_on = date('Y-m-d h:i:s');	

	$cname = mysql_real_escape_string($_POST['cname']);

	mysql_query("INSERT INTO `paid_passes` (`amount`,`pass_thumb`,`pass_image`,`coupon_name`,`host_id`,`expiry_date`,`added_date`,`no_of_tickets`)

			VALUES ('$_POST[amount]','$thumbnail','$image','$cname','$HostID','$_POST[c_exp_date]','$added_on','$_POST[max_download]') ");

	$inserted_pass_id = mysql_insert_id();

	



	/*******************************  FACEBOOK SHARE CODE  ***********************************/

			

	if(isset($_SESSION['fb_token']))

	{

		

		if(!empty($_FILES["adv_img"]["name"]))

		{

			$shout_img = $base_url.$thumbnail;

		}

		else

		{

			$shout_img = $base_url."images/logo.jpg";

		}

		

		$session = new FacebookSession( $_SESSION['fb_token'] );

		

		// graph api request for user data

		$request = new FacebookRequest( $session, 'POST', '/me/feed', array(

				'name' => $_POST['cname'],

				'caption' => 'mysittidev.com',

				'link' => 'https://mysittidev.com',

				'message' => 'New Pass',

				'picture' => $shout_img

			) );

		$response = $request->execute();

	}

			

	/*******************************  FACEBOOK SHARE CODE  ***********************************/

	

	/** TWITTER POST SHARE **/

	

	if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 

	{

		include_once("twitter/config.php");

		include_once("twitter/inc/twitteroauth.php");

		

		//Success, redirected back from process.php with varified status.

		//retrive variables

		$screenname 		= $_SESSION['request_vars']['screen_name'];

		$twitterid 			= $_SESSION['request_vars']['user_id'];

		$oauth_token 		= $_SESSION['request_vars']['oauth_token'];

		$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];

	

		//Show welcome message

		echo '<div class="welcome_txt">Welcome <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php?reset=1">Logout</a>!</div>';

		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);

		

		//see if user wants to tweet using form.

		if(isset($_POST["cname"])) 

		{

			//Post text to twitter

			$my_update = $connection->post('statuses/update', array('status' => $_POST["cname"]));

			//die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php

		}

	}

	/**TWITTER POST SHARE**/				

	$Obj->Redirect("paidPasses.php?msg=added");die;

}

?>

<style>

	#couponupload_toggle{

		display: none;

	}

</style>

<div class="clear"></div>

<div class="v2_container">

	<div class="v2_inner_main">

	<!-- SIDEBAR CODE  -->

	<?php 	

		if(isset($_GET['host_id']))

		{

			include('host_left_panel.php'); 

		}

		else

		{

			include('club-right-panel.php'); 

		}

	?>

	<!-- END SIDEBAR CODE -->

		<article class="forum_content v2_contentbar">

			<div class="v2_rotate_neg">

				<div class="v2_rotate_pos">

					<div class="v2_inner_main_content">

				<?php

					if($_GET['msg'] == "added")

					{



						echo '<div id="successmessage" style="display: block;">Pass Added Successfully</div> ';

					}

					elseif ($_GET['msg'] == "imagefail") 

					{

						# code...

						echo '<div id="successmessage" style="display: block;">Video failed to upload!</div> ';

					}

					elseif ($_GET['msg'] == "delete") 

					{

						# code...

						echo '<div id="successmessage" style="display: block;">Pass deleted successfully</div>';

					}elseif($_GET['msg'] == 'updated')

					{

						echo '<div id="successmessage" style="display: block;">Pass updated successfully</div>';

					} 

				?>

						<div id="profile_box">

				<?php 

						if(isset($_GET['pass_id']))

						{ 

							echo '<h3 id="title" class="">Edit  Pass</h3>';

						}

						else

						{

							echo '<h3 id="title" class="">Sell Tickets</h3>';

							//echo '<a style = "float: right;" class="btn button" href="scan-ticket.php">Scan Ticket</a>';

						}

				?>

						</div><!-- END DIV #profile_box -->

				<?php

					$get_passes = mysql_query("SELECT * FROM `paid_passes` WHERE `host_id` = '$HostID' ORDER BY `expiry_date` DESC");

					$count_passes = mysql_num_rows($get_passes);

				?>
							<div class="sell-ticket-banner">
							<img src="imagesNew/ticket-pass.png" img="banner">
							<h3>Connect and Increase Your Fan Base</h3>
							<span>Sell Tickets</span>
							<p>
								Selling your own tickets online allows you to keep up to 99% of the ticket price. You may be paying a ticket company anywhere $3-$5 dollars per ticket which eats into your profit if you are trying to keep your ticket price reasonable to increase your show attendance. With MySitti, we only charge the transaction fee of $1.99. You keep a large portion of what you sell, because You Are In Control.</p>
								<strong style="color: #000;">Stop Paying Those High Rates and Keep 99% of Your Ticket Price.</strong>

						<div class="autoscroll" tabindex="5000">

							<table id="example" class="display loadmusic host_cp_table" style="margin-top:10px;">

								<thead>

									<tr bgcolor="#ACD6FE">

										<th>Event Name</th>

										<!--<th>Pass</th>-->

										<th>Amount</th>

										<th>Expiry Date</th>

										<th>Ticket</th>

										<th>Security Code</th>

										<th>Status</th>

										<!--<th>Action</th>-->

										<?php 

										if(isset($_GET['host_id']))

										{

											echo '<th>Download</th>';

										}

										else

										{

											echo '<th>View Details</th>';

										}

										?>

									</tr>

								</thead>

								<tbody>

						<?php 

							if($count_passes < 1)

							{ 

						?>			<tr>

										<td colspan="7">

											No passes Found

										</td>

									</tr>

						<?php 	}

							else

							{

								$i=1;

								while($row = mysql_fetch_assoc($get_passes))

								{

									if($i%2 == '0')

									{

										$class = " class='even' ";

									}

									else

									{

										$class = " class='odd' ";

									}												

						?>			<tr <?php echo $class;?>>

								<?php

									$event_nm = mysql_query("SELECT eventname FROM events WHERE id = '".$row['event_id']."'");

									$check_event_exists = mysql_num_rows($event_nm);

									$event_name = mysql_fetch_assoc($event_nm);

									if($check_event_exists < 1)

									{

										mysql_query("DELETE FROM paid_passes WHERE event_id = '".$row['event_id']."'");

										mysql_query("DELETE FROM paid_pass_download WHERE pass_id = '".$row['pass_id']."'");

									}

						?>

										<td><?php echo $event_name['eventname']; ?></td>

										<td><?php echo $row['amount']; ?></td>

										<td><?php echo date('F j, Y l h:i:s A', strtotime($row['expiry_date'])); ?></td>

										<td>

											<a href="javascript:void(0);" onclick="popupbarcode('<?php echo $row['pass_id']; ?>','<?php echo $_SESSION['user_id'];?>','host_sample_ticket');">

												<img src="images/barcode_default.png" alt="Barcode" />

											</a>

										</td>

										<td><?php echo $row['security_code']; ?></td>

										<td>

								 <?php

										$now = time(); // or your date as well

										$your_date = strtotime($row['expiry_date']);

										$datediff =  $your_date - $now;

										$get_difference = floor($datediff/(60*60*24));

										if($get_difference < 0)

										{ 

											echo "Expired"; 

										}

										else

										{ 

											echo "Active"; 

										}

								?>					 

										</td>

										<td>

								<?php

									if(isset($_GET['host_id']))

									{

										/* PAYMENT CODE FOR PAID PASS*/

										$get_str_host_email = mysql_query("SELECT `merchant_id` FROM `clubs` WHERE `id` = '$HostID' ");

										$count_email = mysql_num_rows($get_str_host_email);

										

										if($count_email < 1){

											

											$host_email = "";

											

										}else{

											

											$set_host_email = mysql_fetch_assoc($get_str_host_email);

											$host_email = $set_host_email['merchant_id'];

											

										}

										

										$hide_btn = "style='display: none;'";

										

										$payment_amount =  trim(str_replace("$",'',$row['amount']));

										$host_email_set = $host_email;

										$item_name = "Buy Ticket";

										$return_url = $base_url.'successPurchase.php?host_id='.$HostID.'&str_amt='.$payment_amount.'&user_type='.$_SESSION['user_type'].'&passid='.$row['pass_id'].'&pass_type=paid';

										$cancel_url = $base_url.'successPurchase.php?host_id='.$_GET['host_id'].'&str_amt='.$payment_amount.'&user_type='.$_SESSION['user_type'].'&passid='.$row['pass_id'].'&pass_type=paid';

								?>

										<script type="text/javascript">

											function submitpaypalform(pp)

											{

												$(location).attr('href',pp);

											}	

										</script>

												

								<?php 		require_once("paypal/paypal_class.php");

										require_once('PPBootStrap.php');

										require_once('Common/Constants.php');

										define("DEFAULT_SELECT", "- Select -");

											

										$invoice = date("His").rand(1234, 9632); 

									

										$percentage = 18;

										$totalamt = $payment_amount;

										

										$new_amt = ($percentage / 100) * $totalamt;

								

										$percentage_host = 82;

										$totalamt_host = $payment_amount;

										

										$new_amt_host = ($percentage_host / 100) * $totalamt_host;

									

										$receiver = array();

										$receiver[0] = new Receiver();

										

										// A receiver's email address

										$receiver[0]->email = PAYPAPOWNERID;

										

										// Amount to be credited to the receiver's account

										$receiver[0]->amount = number_format($new_amt,2,".",",");

										

										$receiver[1] = new Receiver();

										// A receiver's email address

										$receiver[1]->email = $host_email_set;

										

										// Amount to be credited to the receiver's account

										$receiver[1]->amount = number_format($new_amt_host,2,".",",");

									

										//$receiver[0]->amount =$sum;

										$receiverList = new ReceiverList($receiver);

							// echo "<pre>"; print_r($receiverList);

										$actionType = "PAY";

										$currencyCode = "USD";

										

										$payRequest = new PayRequest(new RequestEnvelope("en_US"), $actionType, $cancel_url, $currencyCode, $receiverList,$return_url);

										

										$payRequest->memo = $invoice;

										$payRequest->cmd = "_notify-validat";

										

									//	echo "<pre>"; print_r($payRequest);

										

										$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());

										//echo "<pre>"; print_r($service); 

										try {

											/* wrap API method calls on the service object with a try catch */

											$response = $service->Pay($payRequest);

											//echo "<pre>"; print_r($response); exit;

											

										} catch(Exception $ex) {

											require_once 'Common/Error.php';

											exit;

										}?>

										<link href="Common/sdk.css" rel="stylesheet" type="text/css" />

										<script type="text/javascript" src="Common/tooltip.js"></script>

							<?php

										$ack = strtoupper($response->responseEnvelope->ack);

										if($ack != "SUCCESS") 

										{

											if($host_email == "")

											{

												echo "Cannot Buy this Ticket.";

											}

											else

											{

												echo "Cannot Buy this Ticket.";

											}

										} 

										else 

										{

											$payKey = $response->payKey;

											$payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey;

						?>

											<a  onclick='submitpaypalform("<? echo $payPalURL?>")' href="javascript:void(0);">Buy Ticket</a>

								<?php 		}/* END HERE */

									}

									else

									{

										?>

										<a class="ticket-details" href="paid-ticket-detail.php?p_id=<?php echo $row['pass_id'];  ?>">View Ticket Details</a>

										<?php

									}

								?>

												

										</td>												

									</tr>										

					<?php 				$i++; 

								}

							} 

					?>			</tbody>

							</table>

						</div>

  					</div>

  				</div>

			</div>

		<!--	<div class="equalizer"></div>-->

		</article>

	</div>

	<div class="clear"></div>

</div>

<script type="text/javascript">

function toggle_add_pass(){

	

	$('#couponupload_toggle').toggle();

}	

	

function delete_coupon(id){

	

	if (id == "") {

		alert("Please create a coupon first");

	}else{

		

			var r = confirm("Are you sure want to delete!");

			if (r == true) {

				jQuery.post('ajaxcall.php', {'delete_coupon':id}, function(response){

					

					if (response == "deleted") {

						window.top.location = "host_coupon.php?msg=delete";

					}else{

						

						alert("Error deleting coupon");

					}

					

					});

			} else {

				return false;

			}			

	}

}



function validate_adv()

{

	

	if(document.add_adv.old_name.value=="")

	{

		if( document.add_adv.adv_img.value== "" )

		{

			//alert( "Please provide coupon Image!" );

			document.add_adv.adv_img.focus() ;

			return false;	

		}

	}

	if( document.add_adv.cname.value== "" )

		{

		//alert( "Please enter  coupon name!" );

		document.add_adv.cname.focus() ;

		return false;	

	}



	if( document.add_adv.max_download.value== "" )

		{

		//alert( "Please enter max download!" );

		document.add_adv.max_download.focus() ;

		return false;	

	}

	

}



function Validate_coupon_FileUpload(){

	var check_image_ext = $('#adv_img').val().split('.').pop().toLowerCase();

	if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {

		alert('Pass Image only allows file types of GIF, PNG, JPG and JPEG');

		$('#adv_img').val('');

	}

}



function popupbarcode(passid,hostid,sampledata)

{

	url = 'barcodeGet.php?host_id='+hostid+'&pass_id='+passid+'&host_sample_ticket=sampledata';

	var left = (screen.width/2)-(500/2);

	var top = (screen.height/2)-(600/2);



	window.open(url,'1396358792239','width=500,height=520,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left='+left+',top='+top);

	return false;

	

}

</script>

<?php include('Footer.php'); ?>