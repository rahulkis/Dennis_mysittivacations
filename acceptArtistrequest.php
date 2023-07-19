<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$artistprimary = $_GET['id'];
$artistQuery = mysql_query("SELECT * FROM `artist_list` WHERE `id` = '$artistprimary' ");
$fetchCount = mysql_fetch_assoc($artistQuery);

$getHostdetails = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$fetchCount[host_id]' ");
$fetchHostdetails = mysql_fetch_assoc($getHostdetails);
if(isset($_GET['notification'])){
	
  	mysql_query("DELETE FROM user_notification WHERE id = '".$_GET['notification']."'");
  }
?>
<style>

	.evt_title{

		color: rgb(254, 205, 7);

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

  background: #000 none repeat scroll 0 0 !important;

  border: 1px solid #fecd07;

  bottom: 0;

  color: #fff;

  font-size: 12px;

  left: 0;

  margin: auto;

  max-height: 600px;

  max-width: 500px;

  overflow-x: auto;

  position: absolute;

  right: 0;

  top: 0;

}

.post_container img {

  border: 1px solid #fecd07;

  float: left;

  max-width: 100%;

}

.post_container a {text-decoration:none;}

.post_container input {

  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;

  border: 1px solid #fecd07;

  color: #fecd07;

  cursor: pointer;

  padding: 5px 30px;

  text-decoration: none;

}

.post_container input:hover {border-color:#fff; color:#fff;}

.popupHeader 

{text-indent:0;}
.popupBody div {
  display: inline;
  width: 100% !important;
}
.popupBody {padding:15px; box-sizing:border-box; -webkit-box-sizing:border-box;}
</style>

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





<script type="text/javascript">



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
<div id="modal" class="popupContainer" style=" width:99%;  height: 100%;   left: 1%; position: absolute; top:3px;" >
	<header class="popupHeader">
		<span class="header_title">Artist Request</span>
	</header>
<?php 
	$getFriendinfo = mysql_query("SELECT * FROM `friends` WHERE `friend_id`= '$fetchCount[host_id]' AND `user_id` = '$_SESSION[user_id]' AND `user_type` = 'club' AND `friend_type` = 'club' ");
	if(mysql_num_rows($getFriendinfo) > 0)
	{
		$fetchResult = mysql_fetch_assoc($getFriendinfo);
	}
	else
	{

	}
?>
	<section class="popupBody">
		<h3 id="title"><?php echo $fetchHostdetails['club_name'];?> Added you as a Artist.</h3>
		<a href="javascript:void(0);">
			<input class="button" name="confirm" onclick="requestAccept('<?php echo $fetchResult['id'];?>');" type="button" value="Confirm"/>
		</a>
		<a href="javascript:void(0);">
			<input class="button" onclick="window.self.close();" type="button" value="Close"/>
		</a>
	</section>

</div>

<script type="text/javascript">
function requestAccept(id)
{
	$.get('request-accept.php?f_id='+id, function(data) {
		$('#request_'+id).html(data);
		window.self.close();
		window.opener.location.reload();
	});
}

</script>