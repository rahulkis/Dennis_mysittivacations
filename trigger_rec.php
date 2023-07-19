<?php
	sleep(20);
	if($_SERVER['REQUEST_METHOD']=="POST"){
		
		$copy_stream='ffmpeg -y -i rtsp://@54.174.85.75:1935/httplive/'.$_POST['host_name'].'_360p -vcodec copy -acodec copy '.$_POST['upload_path'].$_POST['file_name'].'.mp4 </dev/null >/dev/null 2> '.$_POST['upload_path'].$_POST['file_name'].'.log &';

		shell_exec($copy_stream);

	}
?>
