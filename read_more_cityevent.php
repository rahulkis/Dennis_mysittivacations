<?php

if(!isset($_GET['id']) || count($_GET) > 1)
{
	header('Location: searchEvents.php');
}
include("Query.Inc.php");
$Obj = new Query($DBName);

include 'fav.php';



$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";



$ForumID = (int) $_GET['id'];



$getPostQuery = mysql_query("SELECT `post_count` FROM `forum` WHERE `forum_id` = '$ForumID' ");



$fetchCount = mysql_fetch_assoc($getPostQuery);


if($fetchCount==false || !count($fetchCount))
{
	header('Location: searchEvents.php');
}


$newPostCount = $fetchCount['post_count'] + 1;



mysql_query("UPDATE `forum` SET `post_count` = '$newPostCount' WHERE `forum_id` = '$ForumID' ");



if(isset($_GET['notification'])){


	mysql_query("DELETE FROM user_notification WHERE id = '".$_GET['notification']."'");



}


//$userID=$_SESSION['user_id'];


if($_GET['type']=='private')



{



	$type=$_GET['type'];



}else



{



	$type='public';



}



?>



<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<? //include('../suggest_friend.php');?>

<script type='text/javascript' src='js/autocompletemultiple/jquery.js'></script>

<script type='text/javascript' src='js/autocompletemultiple/jquery.autocomplete.js'></script>

<script type="text/javascript" src="jwplayer/jwplayer.js"></script>

<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>

<link rel="stylesheet" type="text/css" href="js/autocompletemultiple/jquery.autocomplete.css" />

<link type="text/css" rel="stylesheet" href="../css/style_popup.css" /> 

<link rel="stylesheet" type="text/css" href="../css/new_portal/style.css" />

<style>

.popupBody {

  width: 100% !important;

  float:left !important;

}
.event-date{
	clear: both;
	color: #333;
}
.pinner {

  border: 5px solid #fff;

  box-sizing: border-box;

  float: left;

  width: 100%;

  background:#fff;

}
.location {
    color: #000 !important;
}
.videoImage {

  float: left;

  margin: 30px 0;

  width: 100%;

}

 .button, #vieweventslist a, .disableform .button, #queue, .btn_ss, #Savetonightlist, .btn_add_venu, #addevent {
    background: #1c50b3 none repeat scroll 0 0;
    border: 1px solid #1c50b3;
    color: white !important;
}

body {

  background:  url("../images/noice.png") repeat scroll 0 0;

  box-sizing: border-box;

  color: #333;

  font-family: "Open Sans",sans-serif;

  font-size: 13px;

  line-height: 1;

  margin: 0 auto;

  padding: 20px;

  transition: all 0.9s ease-out 0s;

}

.evt_title {

	color: #1c50b3;

	font-size: 20px;

	margin-bottom: 5px;

	width: 100%;

	margin-top: 15px;

	float:left;

}

.post_container img {

	float: left;

	max-width: 100%;

}

.popupContainer {

  background: transparent none repeat scroll 0 0 !important;

  border: 0 none;

  box-sizing: border-box;

  height: 100%;

  margin: 20px auto auto;

  /*max-width: 400px;*/

  position: relative !important;

  width: 100%;

}

.post_container img {

	border: 1px solid #fecd07;

	float: left;

	max-width: 100%;

}

.popupBody img {

  max-width: 100%;

  max-height: 200px;

}

.post_container a {

	text-decoration:none;

}

.post_container input {

	background: rgba(0, 0, 0, 0) none repeat scroll 0 0;

	border: 1px solid #fecd07;

	color: #fecd07;

	cursor: pointer;

	padding: 5px 30px;

	text-decoration: none;

}

.post_container input:hover {

	border-color:#fff;

	color:#fff;

}

 

.popupBody {

	padding:15px; width: 100% !important;

	box-sizing:border-box;

	-webkit-box-sizing:border-box;

 float:left;

}

.event-date {border:0px; width:100%;}

p.discription {
color: #333;

  width: 100%;

  float: left;

  text-align:justify;

  font-size: 14px;

}.popupBody img {

  max-width: 100%;

  width: auto !important;

}

.thumb_event {

  float: left;

  text-align: center;

  width: 100%;

  /*background: #fff;*/

}

.popupBody .button {

  margin: 5px !important;

}

.contRolls {

    width: 100%;

    float: left;

    margin-top:20px;

}

.discription {

  max-width: 100% !important;

  overflow: hidden;

}

.ShowTicket {

  float: left;

  width: 100%;

}

.ShowTicket a {

border-radius: 4px;

-webkit-border-radius: 4px;

-o-border-radius: 4px;

-ms-border-radius: 4px;

color: #000;

font-size: 11px;

font-weight: bold;

margin-right: 6px;

padding: 7px 10px;

width:auto;

float:left;

margin:10px 5px;

text-decoration: none;

  /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#45ea00+0,2c9b22+100 */

background: #45ea00; /* Old browsers */

background: -moz-linear-gradient(top,  #45ea00 0%, #2c9b22 100%); /* FF3.6+ */

background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#45ea00), color-stop(100%,#2c9b22)); /* Chrome,Safari4+ */

background: -webkit-linear-gradient(top,  #45ea00 0%,#2c9b22 100%); /* Chrome10+,Safari5.1+ */

background: -o-linear-gradient(top,  #45ea00 0%,#2c9b22 100%); /* Opera 11.10+ */

background: -ms-linear-gradient(top,  #45ea00 0%,#2c9b22 100%); /* IE10+ */

background: linear-gradient(to bottom,  #45ea00 0%,#2c9b22 100%); /* W3C */

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#45ea00', endColorstr='#2c9b22',GradientType=0 ); /* IE6-9 */



}





.ShowTicket a:hover {

 /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#2c9b22+0,45ea00+100 */

background: #2c9b22; /* Old browsers */

background: -moz-linear-gradient(top,  #2c9b22 0%, #45ea00 100%); /* FF3.6+ */

background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#2c9b22), color-stop(100%,#45ea00)); /* Chrome,Safari4+ */

background: -webkit-linear-gradient(top,  #2c9b22 0%,#45ea00 100%); /* Chrome10+,Safari5.1+ */

background: -o-linear-gradient(top,  #2c9b22 0%,#45ea00 100%); /* Opera 11.10+ */

background: -ms-linear-gradient(top,  #2c9b22 0%,#45ea00 100%); /* IE10+ */

background: linear-gradient(to bottom,  #2c9b22 0%,#45ea00 100%); /* W3C */

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2c9b22', endColorstr='#45ea00',GradientType=0 ); /* IE6-9 */

color:#fff;

}

h3 {

  background: #fecd07 none repeat scroll 0 0;

  box-sizing: border-box;

  color: #000;

  float: left;

  font-size: 15px;

  font-weight: bold;

  margin-bottom: 0;

  padding: 10px;

  text-align: center;

  text-transform: uppercase;

  width: 100%; 

}

.clear{clear:both;}

</style>






<script type="text/javascript">

function open_loginpopup_event(){

	var $aSelected = $('.v2_log_in');

	var URL = $('#urltoredirect').val();

	$(".v2_signup_overlay").css('display', 'block');

	$(".v2_log_in").addClass('open');

	$(".v2_log_in").removeClass('close');

	$(".v2_sign_up").removeClass('open').addClass('close');		

	// opener.location.reload(true);

	self.close();

	window.opener.location.href = URL;

}





function confirmInvite(eid,nid,djID)



{



	$.ajax({



		type: "POST",



		url: "refreshajax.php",



		data: {



			'event_id' : eid,



			'dj_id' : djID,



			'notification_id' : nid,



			'action' : 'confirmInvite',



		},



		success: function(data){



		//	window.location.href = 'host_profile.php?host_id='+id;



			if(data == "update")



			{



				window.self.close();



			}







		}



	});



}



function openpaymentPage(URL)

{

	self.close();

	window.opener.location.href = URL;

}



function rejectInvite(eid,nid,djID)



{



	$.ajax({



		type: "POST",



		url: "refreshajax.php",



		data: {



			'event_id' : eid,



			'dj_id' : djID,



			'notification_id' : nid,



			'action' : 'rejectInvite',



		},



		success: function(data){



		//	window.location.href = 'host_profile.php?host_id='+id;



			if(data == "update")



			{



				window.self.close();



			}



		}



	});



}



</script>


<div id="modal" class="popupContainer">

<div class="pinner">

  <h3>Event Description</h3>   

 <div class="popupBody">

  <?php



		if($_GET['action'] == 'event')



		{


			echo "SELECT * FROM events WHERE id = '".$_GET['id']."'";
			$event_details = @mysql_query("SELECT * FROM events WHERE id = '".$_GET['id']."'");



			$count_record = mysql_num_rows($event_details);



			$get_data = mysql_fetch_assoc($event_details);



			



		if($count_record < 1){ echo "No record Found"; }else{ ?>

		  <div class="">

		   <div class="thumb_event">

		    <div class="popup_divimage">

		     <?php if($get_data['event_image'] != "")



				{



					?>

     				<img src="<?php echo $get_data['event_image']; ?>">

    			 <?php



				}



				else



				{

					$eventimage = $get_data['category_id'].".jpg";

					echo "<img src='".$SiteURL."events_icons/".$eventimage."' />";	



				}

?>

</div>

</div>

<div class="videoImage">

<?php 

				



				if(!empty($get_data['event_video'])){



				?>

     <?php $url = str_replace("../", '', $get_data['event_video']); ?>

     <a href="#dialogx<?php echo $get_data['id'];?>" name="modal" style="">

     <div id="a<?php echo $get_data['id'];?>"></div>

     <script type="text/javascript">



                         jwplayer("a<?php echo $get_data['id'];?>").setup({



                            	file: "<?php echo $url;?>",



                            	//file: "user-video/14170027491416985200Internet Download.flv",



                            	 height : 200 ,



                            	width: 200



                            });



                            </script> 

     </a>

     <?php } ?>

     <div style="clear:both"></div>

    </div>

    <div class="clear"></div>

    <h1 class="evt_title">

     <p><?php echo $get_data['eventname']; ?></p>

    </h1>

    <div class="clear"></div>

    <div class="event-date" style="border:0; width:100%">

     <?php     echo date('F j, Y l g:i A',strtotime($get_data['date'])); ?>

    </div>

    <div class="clear"></div>

    <div class="location">

     <p><span><?php echo $get_data['event_address']; ?></span><br>

     </p>

     

     <!--<p><a title="" target="_blank">Map</a></p>-->

     

     <div style="clear:both"></div>

    </div>

    <p class="discription"> <?php echo $get_data['description']; ?> </p>

   </div>

          <div class="clear"></div>	

    		<?php 

				//if(isset($_SESSION['user_id']))

				//{

			?>

				<div class="ShowTicket">	 

			 	<?php 

					$check_ticket = mysql_Query("SELECT * FROM streaming_tickets WHERE event_id = '".$get_data['id']."'");

					$count_ticket_check = mysql_num_rows($check_ticket);



					/* PAID PASSES QUERY */

					$getPaidpass = mysql_query("SELECT * FROM `paid_passes` WHERE `event_id` = '$get_data[id]' ");

					$fetchRecords = mysql_fetch_assoc($getPaidpass);

					$countPaidpasses = $fetchRecords['no_of_tickets'];

					$currDate = strtotime(date('Y-m-d H:i:s'));

					$expiryPass = strtotime($fetchRecords['expiry_date']);

				?>

				<?php 

				if($count_ticket_check == "1" || $countPaidpasses > 0)

				{

			?>

	

					<div class="clear"></div>





			<?php

					if($countPaidpasses > 0 && $fetchRecords['pass_status'] == "active" && ( $expiryPass > $currDate) )

					{

						$HostID = $get_data['host_id'];

						$get_str_host_email = mysql_query("SELECT `merchant_id` FROM `clubs` WHERE `id` = '$HostID' ");

						$count_email = mysql_num_rows($get_str_host_email);

						

						if($count_email < 1){

							

							$host_email = "";

							

						}else{

							

							$set_host_email = mysql_fetch_assoc($get_str_host_email);

							$host_email = $set_host_email['merchant_id'];

							

						}

						

						$hide_btn = "style='display: none;'";

						

						$payment_amount =  trim(str_replace("$",'',$fetchRecords['amount']));

						$host_email_set = $host_email;

						$item_name = "Buy Ticket";

						

							$hide_btnc = "";

							if($_SESSION['user_type'] == "club"){

								

								$hide_btnc = "style='display: none;'";

								

							}						

						

							if(isset($_SESSION['user_id'])){ ?>

							

								<a <?php echo $hide_btnc; ?> class="buyshowtickets"  href="javascript:void(0);" onclick="openpaymentPage('<?php echo $SiteURL; ?>buyStageTicket.php?host_id=<?php echo $HostID.'&str_amt='.$payment_amount.'&user_type='.$_SESSION['user_type'].'&passid='.$fetchRecords['pass_id'].'&event_id='.$get_data['id']; ?>');">

							

							<?php }else{ ?>

							

								<a onclick="open_loginpopup_event()" class="buysttickets" href="javascript: void(0)">

							

							<?php } ?>						

						

						

						 Show Ticket

						</a>

					<?php



					}



					/**** check streaming ticket exists ****/



					if($count_ticket_check == 1)

					{

						

						$get_ticket_id = mysql_fetch_assoc($check_ticket);

						$ticket_id = $get_ticket_id['ticket_id'];

						

						$check_user_purchased_ticket = mysql_query("SELECT * FROM streaming_tickets_purchased WHERE ticket_id = '".$ticket_id."' AND buyer_user_id = '".$_SESSION['user_id']."' AND buyer_user_type = '".$_SESSION['user_type']."' AND event_id = '".$get_data['id']."'");

						$count_downloaded_ticket = mysql_num_rows($check_user_purchased_ticket);

						

						if($count_downloaded_ticket < 1)

						{

							$hide_btnc = "";

							if($_SESSION['user_type'] == "club"){

								

								$hide_btnc = "style='display: none;'";

								

							}

							

							if(isset($_SESSION['user_id'])){ ?>

							

								<a <?php echo $hide_btnc; ?> class="buysttickets" href="javascript:void(0);" onclick="openpaymentPage('OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php echo $HostID; ?>&user_type=club&ticket_id=<?php echo $ticket_id; ?>&event_id=<?php echo $get_data['id']; ?>');">

								<!-- <a class="buysttickets" href="OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php echo $HostID; ?>&user_type=club&ticket_id=<?php echo $ticket_id; ?>&event_id=<?php echo $get_data['event_id']; ?>"> -->

							

							<?php }else{ ?>

							

								<a onclick="open_loginpopup_event()" class="buysttickets" href="javascript: void(0)">

							

							<?php } ?>

							

					 Streaming Ticket

							</a> 

					<?php

						}

						else

						{ ?>

				 

						<span class="avail">Already Purchased Ticket</span>

					

					<?php }

					}

					/**** check ticket exists ****/

				}

					?>

				</div>

			<?php 	//}	?>

   <div class="clear"></div>

   <div class="contRolls">

   <a href="javascript:void(0);">

   <input class="button" name="cancel" onclick="javacript:self.close();" type="button" value="Close"/>

   </a>

   <?php 

 

						if(isset($_GET['notification']))



						{



							?>

      

   <a href="javascript:void(0);" id="confirmInvite" style="margin-left:20px;float:left;">

   <input class="button" name="confirm" onclick="confirmInvite('<?php echo $_GET['id'];?>','<?php echo $_GET['notification'];?>','<?php echo $_SESSION['user_id'];?>');" type="button" value="Confirm"/>

   </a> <a href="javascript:void(0);">

   <input class="button" name="reject" onclick="rejectInvite('<?php echo $_GET['id'];?>','<?php echo $_GET['notification'];?>','<?php echo $_SESSION['user_id'];?>');" type="button" value="Reject"/>

   </a>

   </div>

   <?php



						}











					?>

  </div>

  <?php }







			



		}



		else

		{



			$event_details = @mysql_query("SELECT * FROM forum WHERE forum_id = '".$_GET['id']."'");



			$count_record = mysql_num_rows($event_details);



			$get_data = mysql_fetch_assoc($event_details);



			



			



			if($count_record < 1){ echo "No record Found"; }else{ ?>

  <div class="">

     <div class="thumb_event">

   <div>

    <?php if($get_data['forum_img'] != "")



			{



				?>

    <img src="<?php echo $get_data['forum_img']; ?>">

    <?php



			}



			else



			{



				$eventimage = $get_data['event_category'].".jpg";

					echo "<img src='".$SiteURL."events_icons/".$eventimage."' />";		



			}



			?>

   </div>

   </div>

    <h1 class="evt_title">

     <p><?php echo $get_data['forum']; ?></p>

    </h1>

    <div class="event-date"  style="border:0; width:100%"> <?php echo date('F j, Y l g:i A',strtotime($get_data['event_date'])); ?> </div>

    <div class="location">

     <p><span><?php echo $get_data['event_address']; ?></span><br>

     </p>

     

     <!--<p><a title="" target="_blank">Map</a></p>-->

     

     <div style="clear:both"></div>

    </div>

    <p class="discription"> <?php echo $get_data['description']; ?> </p>

   </div>

          <div class="clear"></div>	

<?php 

				//if(isset($_SESSION['user_id']))

				//{

			?>

				<div class="ShowTicket">	 

			 	<?php 

					$check_ticket = mysql_Query("SELECT * FROM streaming_tickets WHERE event_id = '".$get_data['event_id']."'");

					$count_ticket_check = mysql_num_rows($check_ticket);



					/* PAID PASSES QUERY */

					$getPaidpass = mysql_query("SELECT * FROM `paid_passes` WHERE `event_id` = '$get_data[event_id]' ");

					$fetchRecords = mysql_fetch_assoc($getPaidpass);

					$countPaidpasses = $fetchRecords['no_of_tickets'];

					$currDate = strtotime(date('Y-m-d H:i:s'));

					$expiryPass = strtotime($fetchRecords['expiry_date']);

				?>

				<?php 

				if($count_ticket_check == "1" || $countPaidpasses > 0)

				{

			?>

	

					<div class="clear"></div>





			<?php

					if($countPaidpasses > 0 && $fetchRecords['pass_status'] == "active" && ( $expiryPass > $currDate) )

					{

						$HostID = $get_data['user_id'];

						$get_str_host_email = mysql_query("SELECT `merchant_id` FROM `clubs` WHERE `id` = '$HostID' ");

						$count_email = mysql_num_rows($get_str_host_email);

						

						if($count_email < 1){

							

							$host_email = "";

							

						}else{

							

							$set_host_email = mysql_fetch_assoc($get_str_host_email);

							$host_email = $set_host_email['merchant_id'];

							

						}

						

						$hide_btn = "style='display: none;'";

						

						$payment_amount =  trim(str_replace("$",'',$fetchRecords['amount']));

						$host_email_set = $host_email;

						$item_name = "Buy Ticket";

						

							$hide_btnc = "";

							if($_SESSION['user_type'] == "club"){

								

								$hide_btnc = "style='display: none;'";

								

							}

							

							if(isset($_SESSION['user_id'])){ ?>

							

								<a <?php echo $hide_btnc; ?> class="buyshowtickets" href="javascript:void(0);" onclick="openpaymentPage('<?php echo $SiteURL; ?>buyStageTicket.php?host_id=<?php echo $HostID.'&str_amt='.$payment_amount.'&user_type='.$_SESSION['user_type'].'&passid='.$fetchRecords['pass_id'].'&event_id='.$get_data['event_id']; ?>');">

							

							<?php }else{ ?>

							

								<a onclick="open_loginpopup_event()" class="buysttickets" href="javascript: void(0)">

							

							<?php } ?>

							

						

						 Show Ticket

						</a>

					<?php



					}



					/**** check streaming ticket exists ****/



					if($count_ticket_check == 1)

					{

						

						$get_ticket_id = mysql_fetch_assoc($check_ticket);

						$ticket_id = $get_ticket_id['ticket_id'];

						

						$check_user_purchased_ticket = mysql_query("SELECT * FROM streaming_tickets_purchased WHERE ticket_id = '".$ticket_id."' AND buyer_user_id = '".$_SESSION['user_id']."' AND buyer_user_type = '".$_SESSION['user_type']."' AND event_id = '".$get_data['event_id']."'");

						$count_downloaded_ticket = mysql_num_rows($check_user_purchased_ticket);

						

						if($count_downloaded_ticket < 1)

						{

							

							$hide_btnc = "";

							if($_SESSION['user_type'] == "club"){

								

								$hide_btnc = "style='display: none;'";

								

							}							

							

							if(isset($_SESSION['user_id'])){ ?>

							

								<a <?php echo $hide_btnc; ?> class="buysttickets" href="javascript:void(0);" onclick="openpaymentPage('OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php echo $HostID; ?>&user_type=club&ticket_id=<?php echo $ticket_id; ?>&event_id=<?php echo $get_data['event_id']; ?>');">

							

							<?php }else{ ?>

							

								<a onclick="open_loginpopup_event()" class="buysttickets" href="javascript: void(0)">

							

							<?php } ?>

							

					

					 Streaming Ticket

							</a> 

					<?php

						}

						else

						{ ?>

				 

						<span class="avail">Already Purchased Ticket</span>

					

					<?php }

					}

					/**** check ticket exists ****/

				}

					?>

				</div>

			<?php 	//}	?>

   <div class="clear"></div>

   <div class="contRolls">

   <a href="javascript:void(0);">

   <input class="button" name="cancel" onclick="javacript:self.close();" type="button" value="Close"/>

   </a>

   <?php 


	if(isset($_GET['notification']))

	{

	?>

       

   <a href="javascript:void(0);">

   <input class="button" name="confirm" onclick="confirmInvite('<?php echo $_GET['id'];?>','<?php echo $_GET['notification'];?>','<?php echo $_SESSION['user_id'];?>');" type="button" value="Confirm"/>

   </a> <a href="javascript:void(0);">

   <input class="button" name="reject" onclick="rejectInvite('<?php echo $_GET['id'];?>','<?php echo $_GET['notification'];?>','<?php echo $_SESSION['user_id'];?>');" type="button" value="Reject"/>

   </a>

   </div> 

   <?php

	}

	?>
 

  </div>

  <?php } 
		}
		?>

  

 </div>

</div>

</div>

