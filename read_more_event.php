<?  session_start(); ?>
 <?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

if($_GET['type']=='private')
{
	$type=$_GET['type'];
}else
{
$type='public';
}

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<? include('suggest_friend.php');?>
<script type='text/javascript' src='js/autocompletemultiple/jquery.js'></script>
<script type='text/javascript' src='js/autocompletemultiple/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="js/autocompletemultiple/jquery.autocomplete.css" />


<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/new_portal/style.css" />

<!--echo "<script>opener.location.reload(true);self.close();</script>";-->


 <div id="modal" class="popupContainer" style=" width:99%;  height: 100%;   left: 1%; position: absolute; top:3px;" >
		<header class="popupHeader">
			<span class="header_title">Event Description</span>
 
		</header>
		<section class="popupBody">

			<?php
			 $get_description = @mysql_query("SELECT description FROM events WHERE id = '".$_GET['id']."'");
			 $read_desc = mysql_fetch_assoc($get_description);
			 echo $read_desc['description'];
			 ?>

		</section>
	</div>