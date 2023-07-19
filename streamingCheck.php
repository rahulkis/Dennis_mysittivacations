<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$d = date('H:i:s');
// mail('sumit.manchanda@kindlebit.com', 'Streaming Check', $d);

function clean($string) 
{
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

}

function detect_stream($hbhost)
{
	$st_qry = 'ffmpeg -i rtsp://54.174.85.75:1935/httplive/'.$hbhost.' 2>&1; echo $?';
	$st_res=(string)trim(shell_exec($st_qry));
	if (strpos($st_res,'404 Not Found') === false) {
		return true;
	}
	else
	{	
		$st_qry = 'ffmpeg -i rtsp://52.37.162.200:1935/live/'.$hbhost.' 2>&1; echo $?';
		$st_res=(string)trim(shell_exec($st_qry));
		if (strpos($st_res,'404 Not Found') === false) {
			return true;
		}
	}
	return false;
}

$getAllonlinestreamers = mysql_query("SELECT * FROM `clubs` WHERE `non_member` = '0' AND `streamingLaunch` = '1'  ");
$getAllonlinestreamers1 = mysql_query("SELECT * FROM `user` WHERE `streamingLaunch` = '1'  ");
$clubsArray = array();
$i = 0;
while ($result = mysql_fetch_assoc($getAllonlinestreamers)) 
{
	$clubname = str_replace(" ", "_" , $result['club_name']);
	$clubname = clean($clubname);
	$clubsArray[$i]['hostname'] = $clubname;
	$clubsArray[$i]['host_id'] = $result['id'];
	$clubsArray[$i]['StreamCode'] = $result['newStreamUrl'];
	$clubsArray[$i]['type'] = 'club';
	$i++;
}

$y = $i;

while ($result1 = mysql_fetch_assoc($getAllonlinestreamers1)) 
{
//	echo "<pre>"; print_r($result1); 
	$clubname = str_replace(" ", "_" , $result1['profilename']);
	$clubname = clean($clubname);
	$clubsArray[$y]['hostname'] = $clubname;
	$clubsArray[$y]['host_id'] = $result1['id'];
	$clubsArray[$y]['StreamCode'] = $result1['newStreamUrl'];
	$clubsArray[$y]['type'] = 'user';
	$y++;
}
 // echo "<pre>"; print_r($clubsArray); exit;
foreach($clubsArray as $v)
{
	if(detect_stream($v['StreamCode']) === false)
	{
		if($v['type'] == 'club')
		{
			mysql_query("UPDATE `clubs` SET `streamingLaunch` = '0', `streamingLaunchFrom` = '', `is_launch` = '0', `newStreamUrl` = '' WHERE `id` = '$v[host_id]' ");
		}
		else
		{
			mysql_query("UPDATE `user` SET `streamingLaunch` = '0', `streamingLaunchFrom` = '', `is_launch` = '0', `newStreamUrl` = '' WHERE `id` = '$v[host_id]' ");	
		}
	}
}

unset($clubsArray);


