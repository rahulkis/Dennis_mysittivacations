<?php
session_start();
include("Query.Inc.php");

$Obj = new Query($DBName);
// include('headhost.php');
// include('header.php');
// if($userType=="club")
// {
// 	include('headerhost.php');
// }





if(($_GET['action'] == 'succes') || ($_GET['page'] == 'juke') )
{
	//echo "<pre>"; print_r($_SESSION); print_r($_POST); print_r($_REQUEST); print_r($_GET);exit;
    $today = date('Y-m-d h:i:s');

    $a = 0;


    $host_id = $_SESSION['selectedlist']['host_id'];

	$trakspay = @mysql_query("select * from jukebox where user_id =$_SESSION[user_id] AND host_id =$host_id ");       
	$c = @mysql_num_rows($trakspay);

	while($traks_respay = @mysql_fetch_assoc($trakspay))
	{
		
		$playlistquery = @mysql_query("INSERT INTO `jukeboxplaylist` (`added`,`music_id`, `host_id`, `user_id`, `music_title`, `artist`) VALUES ('".$today."','".$traks_respay['music_id']."','".$traks_respay['host_id']."','".$traks_respay['user_id']."','".$traks_respay['music_title']."','".$traks_respay['artist']."')   ");

	}

	$trakspay1 = @mysql_query("select * from jukeboxplaylist where user_id =$_SESSION[user_id] AND host_id =$host_id AND added = '".$today."' ");       

	while ($ff = @mysql_fetch_array($trakspay1))
	{
		$selected_track_id[$a] = $ff['id'];
	    $a++;
	}


	$selectedlist = array();
	$_SESSION['selectedlist']['host_id'] = $_SESSION['selectedlist']['host_id'];
	$_SESSION['selectedlist']['track_count'] = $a;
	$_SESSION['selectedlist']['special_note'] = $_SESSION['selectedlist']['special_note'];
	//$_SESSION['selectedlist']['amount'] = $a*$_REQUEST[price];
	$_SESSION['selectedlist']['selectedlist_track_id'] = $selected_track_id;

	@mysql_query("delete from jukebox where user_id =$_SESSION[user_id] AND host_id =$host_id");   
	




//echo "<pre>"; print_r($_SESSION); exit;

    $playlistquery = @mysql_query("INSERT INTO `userplaylist` (`status`,`added`,`special_note`,`user_id`,`host_id`,`total_tracks`) VALUES ('1','".$today."','".$_SESSION['selectedlist']['special_note']."','".$_SESSION['user_id']."','".$_SESSION['selectedlist']['host_id']."','".$_SESSION['selectedlist']['track_count']."')   ");
    //$playlistid = @mysql_insert_id();
    $q = @mysql_query("SELECT `id` FROM `userplaylist` WHERE `added` = '".$today."' ");
    $f = @mysql_fetch_array($q);

    foreach ($_SESSION['selectedlist']['selectedlist_track_id'] as $id) {
    	# code...
    	@mysql_query("UPDATE `jukeboxplaylist` SET `playlist_id` = '".$f['id']."' WHERE `id` = '".$id."'  ");
    }


    $myquerycheck = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$_SESSION['selectedlist']['host_id']."' ");
    $fetchmyquery = @mysql_fetch_array($myquerycheck);

    $getsubusercheck = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$fetchmyquery['club_name']."'  ");
    $countcheck = @mysql_num_rows($getsubusercheck);

    $redirecturl = "music_request.php?host_id=".$_SESSION['selectedlist']['host_id'];
    $Obj->Redirect($redirecturl);
    exit;
}
?>
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
				<h2>Thank you for Requesting the playlist. We will be playing your songs shortly.</h2>
			</div>
		</div>
		<?php 
			
				include('friend-right-panel.php');
			
		?>
	</div>
</div>
<? include('footer.php'); ?>


?>