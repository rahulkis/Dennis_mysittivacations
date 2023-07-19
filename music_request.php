<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID) )
{
	$Obj->Redirect("login.php");
}

$titleofpage = ' Music Request';

if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

$para="";
$message="";
$hostID=$_GET['host_id'];
$sql = "select * from `clubs` where `id` = '".$hostID."'";
$userArray = $Obj->select($sql) ; 

$checkrequeststatus = mysql_query("SELECT * FROM `music_settings` WHERE `user_id` = '".$hostID."' ");
$fetchrequeststatus = mysql_fetch_assoc($checkrequeststatus);
$gethostowner = mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$hostID."' ");
$fetchhostowner = mysql_fetch_array($gethostowner);

$g = mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$fetchhostowner['club_name']."' ");
$f = mysql_fetch_array($g);


$getparenthostquery = mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$f['host_id']."' ");
$fetchparenthostquery = mysql_fetch_array($getparenthostquery);


/* CODE TO CHECK THE REQUEST COUNT */

$countquery = mysql_query("SELECT `id` FROM `userplaylist` WHERE `host_id` = '$hostID'  ");
$countREQ = mysql_num_rows($countquery);

$reqLimit = $fetchrequeststatus['request_limit'];

/****/

$sql = "select * from `user` where `id` = '".$UserID."'";
$userArray1 = $Obj->select($sql) ; 
$first_name=$userArray1[0]['first_name']; 
$last_name=$userArray1[0]['last_name'];
$zipcode=$userArray1[0]['zipcode'];
$state=$userArray1[0]['state'];
$country=$userArray1[0]['country'];
if($userArray1[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray1[0]['DOB'];
$city=$userArray1[0]['city'];
$email=$userArray1[0]['email'];
$image_nm=$userArray1[0]['image_nm'];
$phone=$userArray1[0]['phone'];
/**********************************/
		
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");
$rw_row_fe=mysql_fetch_assoc($sql_fe);

// get user groups 
  $get_groups=mysql_query("select g.group_name,g.id from  chat_users_groups as cgs 
   join chat_groups as g on(g.id=cgs.group_id) where g.create_by='".$UserID."' group by g.id");
// end here 

// get all friends
  $get_friends=mysql_query("select u.first_name,u.last_name,u.id from   friends as f 
   join user as u on(u.id=f.friend_id) where f.user_id 	='".$UserID."' group by f.friend_id");
// end here 
?>
<script>
$(function() {
				  <?php 
				  $i=0;
				  while($rs=mysql_fetch_assoc($get_groups)) {
					  $val[$i]['id']=$rs['id'];
									  $val[$i]['label']=$rs['group_name'];
					  $i++;
				  }
				 $js_array = json_encode($val); 
				 
				   ?>
		var availableTags = <?php echo $js_array ?>;
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#search_val" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					$('#txt2').val($('#txt2').val()+ui.item.id+',');
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					
					return false;
				}
			});
			
			   <?php 
				  $l=0;
				  while($rs2=mysql_fetch_assoc($get_friends)) {
					  $val2[$l]['id']=$rs2['id'];
					 $val2[$l]['label']=$rs2['first_name']." ".$rs2['last_name'];
					 $l++;
				  }
				 $js_array2 = json_encode($val2); 
				 
				   ?>
		var availableTags2 = <?php echo $js_array2 ?>;
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#search_val2" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags2, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					$('#txt_f').val($('#txt_f').val()+ui.item.id+',');
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					
					return false;
				}
			});
	});
	
	
		   
</script>
<?php

		$message['error']="";
$message['success']="";
	/******************/
	if(isset($_POST['submit']))
	{		  
			$user=$_SESSION['profile_name'];	// change it with logged in user id.
			$club=$hostID; // change club id...
			 $music = mysql_real_escape_string(htmlspecialchars($_POST['music']));
			 $artist = mysql_real_escape_string(htmlspecialchars($_POST['artist']));
			 $note = mysql_real_escape_string(htmlspecialchars($_POST['note']));
			$city = $_POST['city'];
			$state = $_POST['state'];

			if ($music == '' || $artist == '' )
			{
				//$message = array("error" => "Please enter the fields value that are required!");
				$message['error'] = 'Please enter the fields value that are required!';
			}
			else
			{
				mysql_query("INSERT music_request SET user='$user',user_city='$city',user_state='$state',club='$club', music='$music', artist='$artist', note='$note',status='Pending',request_time=NOW()");
				$message['success']="Request added successfully";
			}			 
	}
	include 'googleplus-config.php';
	if(isset($_REQUEST['id']))
	{
		$UserID=$_REQUEST['id'];
	}
	else 
	{
		$UserID=$_SESSION['user_id'];	
	}

	if(isset($_GET['host_id']))
	{
		$hostID1 = $_GET['host_id'];
	}
	else
	{
		//$hostID1 = $_SESSION['']
	}
	$getq = mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$hostID1."'  ");
	$countrec = mysql_num_rows($getq);
	if($countrec > 0)
	{
		$fetchstatus = mysql_fetch_array($getq);
		$statuspage = $fetchstatus['jukebox'];
		$me = $fetchstatus['jukeboxmessage'];
	}
	else
	{
		$statuspage = "Enable";
		$me= "";
	}
	if(isset($_POST['savesetting']))
	{
		// echo "<pre>"; print_r($_POST); die;
		$value = $_POST['function'];
		if($value == "Disable with message")
		{
			$m = $_POST['jukeboxmessage'];
		}
		else
		{
			$m = "";
		}
		
		if($countrec > 0)
		{
			mysql_query("UPDATE `host_functions_setting` SET `jukebox` = '$value', `jukeboxmessage` = '$m' WHERE `host_id` = '".$hostID1."'  ");
		}
		else
		{
			mysql_query("INSERT INTO `host_functions_setting` (`host_id`,`jukebox`,`jukeboxmessage`) VALUES ('".$hostID1."','$value','$m')  ")	;
		}
		
		$message['success'] = "Jukebox Display Settings is Saved.";


	}
?>
<link rel="stylesheet" href="css/jukebox.css" />
<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
<script src="autocomplete/jquery.ajaxcomplete.js"></script>
<script>
function jukebox()
{
var m_title  = $('#m_title').val();
var m_artist = $('#m_artist').val();
var host_id = '<?php echo $_GET['host_id'] ?>';

$.ajax({
		type: "POST",
		url: "jukeboxquery.php",
		data: {
			'm_title' : m_title,
			'm_artist' : m_artist,
		'host_id' : host_id
			
			
		},
		success: function(data){
		  $('.select_music_res').html(data);
		   $('#m_title').val('');
		   $('#m_artist').val('');
		  
		  }
	   });
}
$(document).ready(function(){
	
var host_id = '<?php echo $_GET['host_id'] ?>';
$('#m_title').autocomplete("jukeboxquery.php?title=title&host_id="+host_id).change( function(){

	setTimeout(function(){
		var mu_title  = $('#m_title').val();
		var mu_artist = $('#m_artist').val();
		var host_id = $('#hid').val();
		var newsearchlist  = 'newsearch'; 
		//if(mu_title != '' || mu_artist != ''){
			$.ajax({
				type: "POST",
				url: "jukeboxquery.php",
				data: {
					'mu_title' : mu_title,
					'mu_artist' : mu_artist,
					'host_id' : host_id,
					'newsearch' : newsearchlist
				},
				success: function(data){
			  		$('.select_music_res').html(data);
				}
		  	});
		//}
	}, 1000);
});

	
$('#m_artist').autocomplete("jukeboxquery.php?artist=artist&host_id="+host_id).change( function(){

	setTimeout(function(){
		var mu_title  = $('#m_title').val();
		var mu_artist = $('#m_artist').val();
		var host_id = $('#hid').val();
		var newsearchlist  = 'newsearch'; 
		//if(mu_title != '' || mu_artist != ''){
			$.ajax({
				type: "POST",
				url: "jukeboxquery.php",
				data: {
					'mu_title' : mu_title,
					'mu_artist' : mu_artist,
					'host_id' : host_id,
					'newsearch' : newsearchlist
				},
				success: function(data){
			   		$('.select_music_res').html(data);
				}
		   	});
	   	//}	
	}, 1000);	
});	

$('#pay').click(function(){
	
	var special_note = $('#special_note').val();
	var price = $('#price').val();
	var host_id = '<?php echo $_GET['host_id'] ?>';

	var countelements = $('.selctd_music_list').html();
	countelements = $.trim(countelements);
	
	if( (countelements == '') || (countelements == ' ') )
	{
		
		alert('Please Select a Music first.');
		return false;
	}
	else
	{
		if(price == "" || price == 0){
		
				$.ajax({
					type: "POST",
					url: "jukeboxquery.php?action=free",
					data: {
					'price' : price,
					'special_note' : special_note,
					'user_id' : '<?php echo $_SESSION['user_id']?>',
					'action' : 'free',
					'host_id' : host_id
						
						
					},
						success: function(data)
						{
						  window.top.location = "jukeboxsend.php?page=juke&host_id="+host_id;
						  
						}
				   });	

	
		}else{
			$('.demo1').show();
		$('.b-modal').css('display','block','important');
		$('#popup2').css('display','block','important');
		
			$.ajax({
			type: "POST",
			url: "jukeboxquery.php",
			data: {
				'pay' : 'pay',
			'price' : price,
			'special_note' : special_note,
				'user_id' : '<?php echo $_SESSION['user_id']?>',
			'host_id' : '<?php echo $_GET['host_id'] ?>'
				
				
			},
				success: function(data)
				{
				  $('#mycontent').html(data);
				  
				}
		   });	
		
		}
	}
	

	
	
	});	
	
window.onload = jukebox();



					});


</script>
<div class="clear"></div>
<div class="v2_container">
  <div class="v2_inner_main"> 
	<!-- SIDEBAR CODE  -->
	<?php 
		if(isset($_SESSION['user_id']))
		{
			if(!isset($_SESSION['subuser']) && ($_SESSION['user_type'] != 'club'))
			{
				$checksubuserquery = mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$_SESSION['user_id']."' ");
				$fetchsubuserquery = mysql_fetch_array($checksubuserquery);
				$getsubuserquery = mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$fetchsubuserquery['club_name']."' ");
				$fetchsubuser1 = mysql_fetch_array($getsubuserquery);
				$fetchsubusercount = mysql_num_rows($getsubuserquery);
				if($fetchsubusercount > 0 )
				{
					include('sub-right-panel.php');
				}
				else
				{
					include('host_left_panel.php');
				}
			}
			else
			{
				$checksubuserquery = mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$hostID."' ");
				$fetchsubuserquery = mysql_fetch_array($checksubuserquery);
				$getsubuserquery = mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$fetchsubuserquery['club_name']."' ");
				$fetchsubuser1 = mysql_fetch_array($getsubuserquery);
				$fetchsubusercount = mysql_num_rows($getsubuserquery);

				if($fetchsubusercount > 0 )
				{
					include('sub-right-panel.php');
				}
				else
				{
					if($_SESSION['user_id'] == $_SESSION['user_id'])
					{
						include('club-right-panel.php');
					}
					else
					{
						include('host_left_panel.php');	
					}
				}
			}
		}
	?>
	<!-- END SIDEBAR CODE -->
	<article class="forum_content v2_contentbar">
	
	  <div class="v2_rotate_neg">
		<div class="v2_rotate_pos jukebox-button">

						<div class="jukebox-banner">
							<img src="images/jukebox-banner.png" alt="banner">
							<h3>Jukebox</h3>
							<p>
							Jukebox is a feature that we provide DJs allowing them to earn money from the venue. You can set up whatever price you want per request, or make requests free. Again, its all customizable, and you are the one that controls everything about your profile and settings.
							</p>
						</div>

		  <button id="VJuke_page" class="<?php echo (!isset($_POST['active_tab'])) ? 'active_pagebutton' : ''?>">View Jukebox</button>
		  <button id="MRList_page">Music Request</button>

		  <button id="MPList_page" class="<?php echo (isset($_POST['active_tab']) && $_POST['active_tab'] == 'add_music_tab') ? 'active_pagebutton' : ''?>">Play List</button>
		  <button id="setList_page">Settings</button>

				<div class="MRList_pageClass">
					<?php include('musicrequestList.php'); ?>
				</div>

				<div class="MPList_pageClass">
					<?php include('musicplaylists.php'); ?>
				</div>

				<div class="setList_pageClass">
					<?php include('settingslist.php'); ?>
				</div>

				<div class="VJuke_pageClass v2_inner_main_content">

					<?php 
						if($_SESSION['user_type'] == "user" && $statuspage == "Disable with message")
						{
							$pagestatus = "0";	
							echo "<div class='nostoreview' >";
							if($fetchstatus['jukebox'] == "Disable with message")
							{
								echo "<h1 id='title' style='text-align: center;'>".$me."</h1>";
							}
							if($fetchstatus['jukebox'] == "Disable without message")
							{
								
							}

							echo "</div>";
						}
						else
						{
			?>
			 <h3  id="title">Music Request</h3>
			<div class="parent-message-div">
			<?php if($message['success'] != "")
			{ 
				echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
			}
			if($message['error'] != "")
			{ 
				echo '<div class="NoRecordsFound" id="errormessage" class="message" >'.$message['error']."</div>";
			}
			?>
			</div>
			<div class="forum_content jukbox" style="background: url('images/jukbox.png') no-repeat scroll center 60px / cover  #000 !important;">
			  <form class="jukebox_form" action="">
				<input type="hidden" id="uid" value="<?php echo $_SESSION['user_id'];?>" name="user_id" />
				<input type="hidden" id="hid" value="<?php echo $_GET['host_id'];?>" name="host_id" />
				<div style="" class="greyc">
			   
					<?php
						//echo "select * from music_settings where host_id =$_GET[host_id]";
						$qry = mysql_query("select * from music_settings where user_id =$_GET[host_id]");
						$r_res = mysql_fetch_assoc($qry);
					?>
					<h3  id="title">
					  <?php if($r_res['request_price'] == 0){echo "FREE REQUEST";} else { echo "$".$r_res['request_price'];?>
					  per music
					  <?php } ?>
					</h3>
					<input type="hidden" id="price" value="<?php echo $r_res['request_price'];?>" name="price" />
					<div class="form_div_container">
					  <div class="label">
						<label>Title/Artist</label>
					  </div>
					  <div class="controls">
						<input type="text" name="title" value="" id="m_title" />
					  </div>
					</div>
					<!--<span style="text-align: center; width: 74%; float: right; font-weight: bolder; font-size: 15px; margin:0px 0px 7px  0px;">OR</span>
					<div class="form_div_container">
					  <div class="label">
						<label>Artist</label>
					  </div>
					  <div class="controls">
						<input type="text" name="artist" value="" id="m_artist"  />
					  </div>
					</div>-->
					<div class="form_div_container">
					  <div class="label">
						<label>Special Note</label>
					  </div>
					  <div class="controls">
						<textarea name="special_note" id="special_note"></textarea>
					  </div>
					</div>
					<div class="send_list"></div>
				  
				  <div class="slctd_music">
					<h3  id="title">selected Music</h3>
					<div class="slctd_m_cotainer">
					  <div class="selctd_music_head">
						<div>Music Title</div>
						<div>Artist</div>
						<div>Action</div>
					  </div>
					  <div class="selctd_music_list">
						<?php 
							$traks = mysql_query("select music_title,artist,id from jukebox where user_id =$_SESSION[user_id] AND host_id = $_GET[host_id] ");       
							while($traks_res = mysql_fetch_assoc($traks))
							{
								echo '<div class="selctd_music"><div>'.$traks_res['music_title'].'</div>';
								echo '<div>'.$traks_res['artist'].'</div>';
								echo '<div><a class="remove remove_music_item" id="'.$traks_res[id].'"><img scr="images/deleteEpk.png" alt=""> Remove</a></div></div>';
							}
						?>
						<br/>
						</div>
						<!--<input type="button" value="Send" id="jukebox_send" class="button" />-->
					  
					</div>
					<div class="send_list">
					<?php 
							if($_SESSION['user_type'] == "user" )
							{
								if($countREQ <= $reqLimit )
								{
								?>
									<input type="button" value="Send" name="save" id="pay" />
					  			<?php
								} else {
								?>
					  			<input type="button" value="Send" name="save" onclick="alert('Sorry not able to process your request. Request limit is over. Please try again Later.'); return false;" />
					  			<?php	
								}										
							}	?>
				   </div>
				  </div>
				</div>
				<div class="slctd_m_cotainer2">
				  <div class="selctd_music_head">
					<div>Music Title</div>
					<div>Artist</div>
					<div>Select</div>
				  </div>
				  <div class="select_music_res"> </div>
				</div><div class="clear"></div>
			  </form>
			  <div class="clear"></div>
			</div>
			<?php 
								if(isset($_GET['host_id']) && $_SESSION['user_type'] == 'user')
								{
									$checksubuserquery = mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$_GET['host_id']."' ");
									$fetchsubuserquery = mysql_fetch_array($checksubuserquery);
									$getsubuserquery = mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$fetchsubuserquery['club_name']."' ");
									$fetchsubuser1 = mysql_fetch_array($getsubuserquery);
									$fetchsubusercount = mysql_num_rows($getsubuserquery);
									if($fetchsubusercount > 0 )
									{
							?>
			<div class="btncenter"> <a href="host_profile.php?host_id=<?php echo $fetchsubuser1['host_id']; ?>" class="button backmargn">Back </a> </div>
			<?php 
									}
									else
									{
								?>
			<div class="btncenter"> <a href="host_profile.php?host_id=<?php echo $_GET['host_id']; ?>" class="button backmargn">Back </a> </div>
			<?php 
									}
								}
					}// END PAGE STATUS CHECK 
						?>
		  </div>
		</div>
	  </div>
	  <div class="equalizer"></div>
	</article>
  </div>
  <div class="clear"></div>
</div>
<style type="text/css">
#popup2{position:fixed; width:400px; height:auto; overflow:auto; background:#000; z-index:2; top: 100px !important;}
#popup2 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
#popup, #popup2, .bMulti {
	background-color: #000;
	border-radius: 10px;
	box-shadow: 0 0 25px 5px #006099;
	color: #111;
	padding: 25px;
	display: none ;
}
#popup2 span.b-close { border: none; float: right;}
	.b-modal{display: none ;position:fixed; left:0; top:0; height:100%; background:#000; z-index:1; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}
</style>
<!--<script src="js/lk.popup.js"></script>-->

<div style="display: none;" class="demo1">
  <div class="b-modal" id="b-modal __b-popup1__" style="display: none;"></div>
  <div id="popup2" style="display: none;"> <span class="button b-close"></span>
	<div id="mycontent" style="color: #FFF; height: auto; width: auto;"> </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		var req = "<?php echo $fetchrequeststatus['disable_music_req'];  ?>";
		var hostid = "<?php echo $f['host_id']; ?>";
		var hostplan = "<?php echo $fetchparenthostquery['plantype']; ?>";
		var subhostid = "<?php echo $f['id'];?>";
		if(req == 1)
		{
			alert('Music Request is disabled for this Host!');
			window.location = 'host_profile.php?host_id='+hostid;
		}


	$("#MRList_page").click(function(){
		 showDiv1();
	});
	$("#MPList_page").click(function(){
		 showDiv2();
	});
	$("#setList_page").click(function(){
		 showDiv3();
	});
	$("#VJuke_page").click(function(){
		 showDiv4();
	});

	// $(".MPList_pageClass").show(document.URL.indexOf("msg=updated") !== -1);

	if(document.URL.indexOf("msg=updated") !== -1 || document.URL.indexOf("msg=single_updated") !== -1 || document.URL.indexOf("msg=deleted") !== -1)
	{
		$(".MPList_pageClass").css({"visibility":"visible","display":"block"});
		$(".MRList_pageClass").css({"visibility":"hidden","display":"none"});
		$(".setList_pageClass").css({"visibility":"hidden","display":"none"});
		$(".VJuke_pageClass").css({"visibility":"hidden","display":"none"});
	}

	function showDiv1()
	{
		$(".MRList_pageClass").css({"visibility":"visible","display":"block"});
		$(".MPList_pageClass").css({"visibility":"hidden","display":"none"});
		$(".setList_pageClass").css({"visibility":"hidden","display":"none"});
		$(".VJuke_pageClass").css({"visibility":"hidden","display":"none"});
	}
	function showDiv2()
	{
		$(".MPList_pageClass").css({"visibility":"visible","display":"block"});
		$(".MRList_pageClass").css({"visibility":"hidden","display":"none"});
		$(".setList_pageClass").css({"visibility":"hidden","display":"none"});
		$(".VJuke_pageClass").css({"visibility":"hidden","display":"none"});
	}
	function showDiv3()
	{
		$(".setList_pageClass").css({"visibility":"visible","display":"block"});
		$(".MPList_pageClass").css({"visibility":"hidden","display":"none"});
		$(".MRList_pageClass").css({"visibility":"hidden","display":"none"});
		$(".VJuke_pageClass").css({"visibility":"hidden","display":"none"});
	}
	function showDiv4()
	{
		$(".VJuke_pageClass").css({"visibility":"visible","display":"block"});
		$(".MRList_pageClass").css({"visibility":"hidden","display":"none"});
		$(".setList_pageClass").css({"visibility":"hidden","display":"none"});
		$(".MPList_pageClass").css({"visibility":"hidden","display":"none"});
	}

	$('.v2_rotate_pos.jukebox-button button').on('click',function(){
	  $('button').removeClass('active_pagebutton');
	  $(this).addClass('active_pagebutton');
	});

	if ($("#MPList_page").hasClass("active_pagebutton")) {
		$(".MPList_pageClass").show();
		$(".VJuke_pageClass").hide();
	}
		
	});
</script>
<style>
.MRList_pageClass {
	display: none;
}
.MPList_pageClass {
	display: none;
}
.setList_pageClass {
	display: none;
}
.active_pagebutton {
	background: #89a7e5 none repeat scroll 0 0 !important;
	color: white !important;
}
</style>
<?php include('Footer.php');	?>
